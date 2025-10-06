<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::where('sales_id', $request->user()->id)
            ->with('items.product', 'outlet', 'edits')
            ->latest() // transaksi terbaru dulu
            ->get();

        // Format rapi
        $data = $transactions->map(function ($transaction) {
            $lastEdit = $transaction->edits->sortByDesc('id')->first();
            return [
                'id' => $transaction->id,
                'status' => $lastEdit ? $lastEdit->status : 'pending',
                'original_total' => $lastEdit ? $lastEdit->old_total : null,
                'original_profit' => $lastEdit ? $lastEdit->old_profit : null,
                'outlet' => [
                    'id' => $transaction->outlet->id,
                    'name' => $transaction->outlet->name,
                    'name_outlet' => $transaction->outlet->name_outlet,
                    'address_outlet' => $transaction->outlet->address_outlet,
                ],
                'total' => $transaction->total,
                'profit' => $transaction->profit,
                'created_at' => $transaction->created_at->format('Y-m-d H:i:s'),
                'items' => $transaction->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product->id,
                        'name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'cost_price' => $item->cost_price,
                        'subtotal' => $item->price * $item->quantity,
                    ];
                })
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar transaksi berhasil didapatkan',
            'transactions' => $data
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        $sales = $request->user();
        $total = 0;
        $profit = 0;

        // Cek stok sales dulu
        foreach ($request->items as $item) {
            $stock = Stock::where('sales_id', $sales->id)
                ->where('product_id', $item['product_id'])
                ->first();

            // Ambil nama produk
            $product = Product::find($item['product_id']);

            if (!$stock || $stock->quantity < $item['quantity']) {
                return response()->json([
                    'status' => false,
                    'message' => "Stok produk {$product->name} tidak cukup"
                ], 400);
            }
        }

        // Buat transaksi
        $transaction = Transaction::create([
            'sales_id' => $sales->id,
            'outlet_id' => $request->outlet_id,
            'branch_id' => $sales->branch_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'total' => 0, // nanti update
            'profit' => 0
        ]);

        // Simpan item transaksi & update stok
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $price = $product->selling_price;
            $cost = $product->cost_price;

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $price,
                'cost_price' => $cost
            ]);

            $total += $price * $item['quantity'];
            $profit += ($price - $cost) * $item['quantity'];

            // Kurangi stok sales
            $stock = Stock::where('sales_id', $sales->id)
                ->where('product_id', $product->id)
                ->first();
            $stock->quantity -= $item['quantity'];
            $stock->save();
        }

        // Update total & profit
        $transaction->update(['total' => $total, 'profit' => $profit]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil melakukan transaksi',
            'transaction_id' => $transaction->id,
            'total' => $total
        ]);
    }

    public function summary(Request $request)
    {
        $salesId = $request->user()->id;

        $now = now();
        $today = $now->format('Y-m-d');
        $startOfWeek = $now->startOfWeek()->format('Y-m-d');
        $startOfMonth = $now->startOfMonth()->format('Y-m-d');

        $daily = Transaction::where('sales_id', $salesId)
            ->whereDate('created_at', $today)
            ->selectRaw('SUM(total) as total_sales, SUM(profit) as total_profit')
            ->first();

        $weekly = Transaction::where('sales_id', $salesId)
            ->whereDate('created_at', '>=', $startOfWeek)
            ->selectRaw('SUM(total) as total_sales, SUM(profit) as total_profit')
            ->first();

        $monthly = Transaction::where('sales_id', $salesId)
            ->whereDate('created_at', '>=', $startOfMonth)
            ->selectRaw('SUM(total) as total_sales, SUM(profit) as total_profit')
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'Ringkasan penjualan berhasil didapatkan',
            'summary' => [
                'daily' => [
                    'total' => (float) ($daily->total_sales ?? 0),
                    'profit' => (float) ($daily->total_profit ?? 0),
                ],
                'weekly' => [
                    'total' => (float) ($weekly->total_sales ?? 0),
                    'profit' => (float) ($weekly->total_profit ?? 0),
                ],
                'monthly' => [
                    'total' => (float) ($monthly->total_sales ?? 0),
                    'profit' => (float) ($monthly->total_profit ?? 0),
                ]
            ]
        ]);
    }
}
