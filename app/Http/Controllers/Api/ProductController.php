<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sales = $request->user(); // Sales yang login

        // Ambil stok untuk sales ini beserta product
        $stocks = Stock::where('sales_id', $sales->id)
                    ->with('product')
                    ->get();

        // Format output supaya ada info produk + quantity
        $products = $stocks->map(function($stock) {
            return [
                'stock_id' => $stock->id,   
                'id' => $stock->product->id,
                'name' => $stock->product->name,
                'description' => $stock->product->description,
                'cost_price' => $stock->product->cost_price,
                'selling_price' => $stock->product->selling_price,
                'quantity' => $stock->quantity
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Daftar produk berhasil didapatkan',
            'products' => $products
        ]);
    }

    public function returnStock(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $sales = $request->user();
        $stock = Stock::where('id', $request->stock_id)
                    ->where('sales_id', $sales->id)
                    ->firstOrFail();

        if ($request->quantity > $stock->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Quantity yang dikembalikan melebihi stok tersedia.'
            ], 400);
        }

        // Kurangi stok di sales
        $stock->quantity -= $request->quantity;
        $stock->save();

        // Tambahkan / update stok di cabang asal
        $branchStock = Stock::firstOrCreate([
            'product_id' => $stock->product_id,
            'branch_id' => $stock->branch_id, // cabang asal
            'sales_id' => null,
        ], [
            'quantity' => 0,
        ]);

        $branchStock->quantity += $request->quantity;
        $branchStock->save();

        return response()->json([
            'status' => true,
            'message' => 'Stok berhasil dikembalikan ke cabang.',
            'returned_quantity' => $request->quantity,
            'branch_stock' => $branchStock->quantity
        ]);
    }

}
