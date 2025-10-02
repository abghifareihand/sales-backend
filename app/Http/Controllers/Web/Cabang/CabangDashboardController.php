<?php

namespace App\Http\Controllers\Web\Cabang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CabangDashboardController extends Controller
{
public function index()
    {
        $branchId = Auth::user()->branch_id;

        // Total produk terjual di cabang ini
        $totalProductsSold = TransactionItem::whereHas('transaction', function($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->sum('quantity');

        // Total pendapatan di cabang ini
        $totalRevenue = Transaction::where('branch_id', $branchId)->sum('total');

        // Total profit di cabang ini
        $totalProfit = TransactionItem::whereHas('transaction', function($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })
        ->select(DB::raw('SUM((price - cost_price) * quantity) as profit'))
        ->value('profit');

        // Produk terlaris (top 5) di cabang ini
        $bestSellers = TransactionItem::whereHas('transaction', function($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->with('product:id,name')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get()
        ->map(function($item) {
            return (object)[
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'total_sold' => $item->total_sold
            ];
        });

        // Transaksi terkini di cabang ini (5 terakhir)
        $recentTransactions = Transaction::with(['items.product', 'sales'])
                                ->where('branch_id', $branchId)
                                ->orderByDesc('created_at')
                                ->take(5)
                                ->get();

        // Top Sales di cabang ini
        $topSales = Transaction::select(
                            'sales_id',
                            DB::raw('SUM(total) as total_revenue'),
                            DB::raw('SUM((SELECT SUM((ti.price - ti.cost_price) * ti.quantity)
                                           FROM transaction_items ti
                                           WHERE ti.transaction_id = transactions.id)) as total_profit'),
                            DB::raw('SUM((SELECT SUM(ti.quantity)
                                           FROM transaction_items ti
                                           WHERE ti.transaction_id = transactions.id)) as total_products')
                        )
                        ->where('branch_id', $branchId)
                        ->with('sales:id,name')
                        ->groupBy('sales_id')
                        ->orderByDesc('total_revenue')
                        ->take(10)
                        ->get();

        // Expired produk di cabang ini saja
        $expiredProducts = Product::whereHas('stocks', function($q) use ($branchId) {
                                $q->where('branch_id', $branchId);
                            })
                            ->orderBy('expired', 'asc')
                            ->take(10)
                            ->get();

        // Stock summary cabang
        $stockSummary = Product::with(['stocks' => function($q) use ($branchId) {
                                $q->where('branch_id', $branchId)->orWhereNull('branch_id');
                            }])->get()->map(function($product) use ($branchId) {
                                $pusat = $product->stocks->whereNull('branch_id')->sum('quantity');
                                $cabang = $product->stocks->where('branch_id', $branchId)->whereNull('sales_id')->sum('quantity');
                                $sales = $product->stocks->where('branch_id', $branchId)->whereNotNull('sales_id')->sum('quantity');
                                return [
                                    'product' => $product->name,
                                    'pusat'   => $pusat,
                                    'cabang'  => $cabang,
                                    'sales'   => $sales,
                                    'total'   => $pusat + $cabang + $sales,
                                ];
                            })
                            ->sortByDesc('total');

        return view('pages.cabang.dashboard', compact(
            'totalProductsSold',
            'totalRevenue',
            'totalProfit',
            'bestSellers',
            'recentTransactions',
            'topSales',
            'expiredProducts',
            'stockSummary'
        ));
    }
}
