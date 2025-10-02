<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Total product sold
        $totalProductsSold = TransactionItem::sum('quantity');

        // Total revenue
        $totalRevenue = Transaction::sum('total');

        // Total profit
        $totalProfit = TransactionItem::select(DB::raw('SUM((price - cost_price) * quantity) as profit'))
                        ->value('profit');

        // Best seller products (top 5)
        $bestSellers = TransactionItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
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

        // Recent 5 transactions
        $recentTransactions = Transaction::with(['items.product', 'branch', 'sales'])
                                ->orderByDesc('created_at')
                                ->take(5)
                                ->get();

        // Stock summary
        $stockSummary = Product::with('stocks.branch')
            ->get()
            ->map(function($product) {
                $pusat = $product->stocks->whereNull('branch_id')->sum('quantity');
                $cabang = $product->stocks->whereNotNull('branch_id')->whereNull('sales_id')->sum('quantity');
                $sales = $product->stocks->whereNotNull('sales_id')->sum('quantity');

                return [
                    'product' => $product->name,
                    'pusat'   => $pusat,
                    'cabang'  => $cabang,
                    'sales'   => $sales,
                    'total'   => $pusat + $cabang + $sales,
                ];
            })
            ->sortByDesc('total')   // urutkan berdasarkan total terbanyak
            ->take(10)              // ambil 10 teratas
            ->values();             // reset index biar rapih


        // Produk yang expired paling dekat (top 10)
        $expiredProducts = Product::orderBy('expired', 'asc')
                            ->take(10)
                            ->get();

        // Sales dengan pendapatan terbanyak
        $topSales = Transaction::select(
                            'sales_id',
                            'branch_id',
                            DB::raw('SUM(total) as total_revenue'),
                            DB::raw('SUM((SELECT SUM((ti.price - ti.cost_price) * ti.quantity)
                                           FROM transaction_items ti
                                           WHERE ti.transaction_id = transactions.id)) as total_profit'),
                            DB::raw('SUM((SELECT SUM(ti.quantity)
                                           FROM transaction_items ti
                                           WHERE ti.transaction_id = transactions.id)) as total_products')
                        )
                        ->with(['sales:id,name', 'branch:id,name'])
                        ->groupBy('sales_id', 'branch_id')
                        ->orderByDesc('total_revenue')
                        ->take(10)
                        ->get();

        $totalAsset = Stock::with('product')
            ->get()
            ->sum(fn($stock) => $stock->quantity * $stock->product->cost_price);

        return view('pages.owner.dashboard', compact(
            'totalProductsSold',
            'totalRevenue',
            'totalProfit',
            'bestSellers',
            'recentTransactions',
            'stockSummary',
            'expiredProducts',
            'topSales',
            'totalAsset',
        ));
    }
}
