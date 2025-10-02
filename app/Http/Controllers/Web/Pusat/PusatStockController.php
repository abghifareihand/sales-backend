<?php

namespace App\Http\Controllers\Web\Pusat;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Distribution;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class PusatStockController extends Controller
{
    // Stok Pusat
    public function stockPusat()
    {
        // Ambil stok pusat (branch_id = null)
        $stocks = Stock::with('product')
                    ->whereNull('branch_id')
                    ->whereNull('sales_id')
                    ->get();

        return view('pages.pusat.stock.pusat.index', compact('stocks'));
    }

    public function createStockPusat()
    {
        $products = Product::all();
        return view('pages.pusat.stock.pusat.create', compact('products'));
    }

    public function storeStockPusat(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ], [
            'product_id.required' => 'Pilih produk terlebih dahulu!',
            'quantity.required' => 'Jumlah stok tidak boleh kosong!',
            'quantity.integer' => 'Jumlah stok harus berupa angka!',
            'quantity.min' => 'Jumlah stok minimal 0!',
        ]);

        // Ambil stock lama atau buat baru
        $stock = Stock::firstOrNew([
            'product_id' => $request->product_id,
            'branch_id' => null,
            'sales_id' => null,
        ]);

        // Tambahkan quantity baru ke stock lama
        $stock->quantity += $request->quantity;
        $stock->save();

        return redirect()->route('pusat.stock.pusat.index')
                        ->with('success', 'Stok pusat berhasil diperbarui');
    }

    public function editStockPusat(Stock $stock)
    {
        return view('pages.pusat.stock.pusat.edit', compact('stock'));
    }

    public function updateStockPusat(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ], [
            'quantity.required' => 'Jumlah stok tidak boleh kosong!',
            'quantity.integer' => 'Jumlah stok harus berupa angka!',
            'quantity.min' => 'Jumlah stok minimal 0!',
        ]);

        $stock->quantity = $request->quantity;
        $stock->save();

        return redirect()->route('pusat.stock.pusat.index')
                        ->with('success', 'Stok pusat berhasil diperbarui');
    }



    // Stok Cabang
    public function stockCabang()
    {
        $stocks = Stock::with('product', 'branch')
            ->whereNotNull('branch_id')
            ->whereNull('sales_id')
            ->paginate(10);

        return view('pages.pusat.stock.cabang.index', compact('stocks'));
    }

    // Stok Sales
    public function stockSales()
    {
        // Ambil semua stock yang sudah punya sales
        $stocks = Stock::with(['product', 'sales.branch']) // eager load sales beserta cabangnya
            ->whereNotNull('sales_id')
            ->get();

        return view('pages.pusat.stock.sales.index', compact('stocks'));
    }

    public function distributionForm(Stock $stock)
    {
        $branches = Branch::all();
        return view('pages.pusat.stock.pusat.distribution', compact('stock', 'branches'));
    }

    public function distributionToCabang(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'branch_id.required' => 'Pilih cabang terlebih dahulu!',
            'quantity.required' => 'Jumlah stok tidak boleh kosong!',
            'quantity.min' => 'Jumlah stok minimal 1!',
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        $branch = Branch::findOrFail($request->branch_id);

        if ($request->quantity > $stock->quantity) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['quantity' => "Jumlah stok tidak boleh lebih dari {$stock->quantity}"]);
        }

        // Kurangi stok pusat
        $stock->quantity -= $request->quantity;
        $stock->save();

        // Tambah stok ke cabang
        $branchStock = Stock::firstOrNew([
            'product_id' => $stock->product_id,
            'branch_id' => $request->branch_id,
        ]);
        $branchStock->quantity += $request->quantity;
        $branchStock->save();

        // Catat distribusi
        Distribution::create([
            'from_branch_id' => null,
            'to_branch_id' => $request->branch_id,
            'product_id' => $stock->product_id,
            'quantity' => $request->quantity,
            'type' => 'pusat_to_cabang',
        ]);

        return redirect()->route('pusat.stock.pusat.index')->with('success', 'Stok berhasil didistribusikan ke cabang ' . $branch->name);

    }
}
