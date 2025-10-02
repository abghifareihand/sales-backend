<?php

namespace App\Http\Controllers\Web\Cabang;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangStockController extends Controller
{
    public function stockCabang(Request $request)
    {
        $branchId = Auth::user()->branch_id;

        // Hanya stok cabang, tanpa ambil stok sales
        $stocks = Stock::with('product')
                    ->where('branch_id', $branchId)
                    ->whereNull('sales_id')
                    ->get();

        return view('pages.cabang.stock.cabang.index', compact('stocks'));
    }

    public function stockSales()
    {
        $branchId = Auth::user()->branch_id;

        $stocks = Stock::with('product', 'sales')
            ->whereNotNull('sales_id')
            ->where('stocks.branch_id', $branchId) // <-- tambahkan nama tabel
            ->join('users', 'stocks.sales_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('stocks.*') // penting supaya paginate tetap jalan
            ->get();

        return view('pages.cabang.stock.sales.index', compact('stocks'));
    }

    public function distributionForm(Stock $stock)
    {
        // Ambil semua user sales yang terhubung dengan cabang login
        $sales = User::where('branch_id', Auth::user()->branch_id)
                     ->where('role', 'sales')
                     ->get();

        return view('pages.cabang.stock.cabang.distribution', compact('stock', 'sales'));
    }

    public function distributionToSales(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'sales_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'sales_id.required' => 'Sales harus dipilih!',
            'quantity.required' => 'Jumlah stok tidak boleh kosong!',
            'quantity.min' => 'Jumlah stok minimal 1!',
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        $sales = User::findOrFail($request->sales_id);

        if ($request->quantity > $stock->quantity) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['quantity' => "Jumlah stok tidak boleh lebih dari {$stock->quantity}"]);
        }

        // Kurangi stok cabang
        $stock->quantity -= $request->quantity;
        $stock->save();

        // Tambah stok ke sales
        $salesStock = Stock::firstOrNew([
            'product_id' => $stock->product_id,
            'branch_id' => $stock->branch_id,
            'sales_id' => $sales->id, // tambahkan kolom sales_id di tabel stocks
        ]);
        $salesStock->quantity += $request->quantity;
        $salesStock->save();

        // Catat distribusi
        Distribution::create([
            'from_branch_id' => $stock->branch_id,
            'to_sales_id' => $sales->id,
            'product_id' => $stock->product_id,
            'quantity' => $request->quantity,
            'type' => 'cabang_to_sales',
        ]);

        return redirect()->route('cabang.stock.cabang.index')
                         ->with('success', 'Stok berhasil didistribusikan ke sales ' . $sales->name);
    }


    public function returnForm(Stock $stock)
    {
        return view('pages.cabang.stock.cabang.return', compact('stock'));
    }


    public function returnToPusat(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'quantity.required' => 'Jumlah stok tidak boleh kosong!',
            'quantity.min' => 'Jumlah stok minimal 1!',
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        if ($request->quantity > $stock->quantity) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['quantity' => "Jumlah stok tidak boleh lebih dari {$stock->quantity}"]);
        }

        // Kurangi stok cabang
        $stock->quantity -= $request->quantity;
        $stock->save();

        // Tambah stok pusat
        $stockPusat = Stock::firstOrNew([
            'product_id' => $stock->product_id,
            'branch_id' => null,
            'sales_id' => null,
        ]);
        $stockPusat->quantity += $request->quantity;
        $stockPusat->save();

        // Catat distribusi return
        Distribution::create([
            'from_branch_id' => $stock->branch_id,
            'to_branch_id' => null,
            'product_id' => $stock->product_id,
            'quantity' => $request->quantity,
            'type' => 'cabang_to_pusat',
            'notes' => $request->notes ?? 'Return from branch',
        ]);

        return redirect()->route('cabang.stock.cabang.index')
                        ->with('success', 'Stok berhasil dikembalikan ke pusat');
    }


}
