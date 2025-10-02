<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Distribution;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerStockController extends Controller
{
    // ===== STOCK PUSAT =====
    public function stockPusat()
    {
        $stocks = Stock::with('product')
                    ->whereNull('branch_id')
                    ->whereNull('sales_id')
                    ->get();

        return view('pages.owner.stock.pusat.index', compact('stocks'));
    }

    public function createStockPusat()
    {
        $products = Product::all();
        return view('pages.owner.stock.pusat.create', compact('products'));
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

        return redirect()->route('owner.stock.pusat.index')
                        ->with('success', 'Stok pusat berhasil diperbarui');
    }

    public function editStockPusat(Stock $stock)
    {
        return view('pages.owner.stock.pusat.edit', compact('stock'));
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

        return redirect()->route('owner.stock.pusat.index')
                        ->with('success', 'Stok pusat berhasil diperbarui');
    }

    public function distributionToCabangForm(Stock $stock)
    {
        $branches = Branch::all();
        return view('pages.owner.stock.pusat.distribution', compact('stock', 'branches'));
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

            return redirect()->route('owner.stock.pusat.index')->with('success', 'Stok berhasil didistribusikan ke cabang ' . $branch->name);

    }

    // ===== STOCK CABANG =====
    public function stockCabang()
    {
        $stocks = Stock::with('product', 'branch')
            ->whereNotNull('branch_id')
            ->whereNull('sales_id')
            ->get();

        return view('pages.owner.stock.cabang.index', compact('stocks'));
    }

    public function distributionToSalesForm(Stock $stock)
    {
        // Hanya ambil cabang dari stock ini
        $branch = $stock->branch;
        $sales = $branch->users()->where('role', 'sales')->get();

        return view('pages.owner.stock.cabang.distribution', compact('stock', 'sales'));
    }

    public function distributionToSales(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'sales_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'sales_id.required' => 'Pilih sales terlebih dahulu!',
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

        // Kurangi stok cabang/pusat
        $stock->quantity -= $request->quantity;
        $stock->save();

        // Tambah stok ke sales dan simpan branch_id
        $salesStock = Stock::firstOrNew([
            'product_id' => $stock->product_id,
            'branch_id' => $stock->branch_id, // <-- penting supaya filter cabang bisa jalan
            'sales_id' => $sales->id,
        ]);
        $salesStock->quantity += $request->quantity;
        $salesStock->save();

        // Catat distribusi
        Distribution::create([
            'from_branch_id' => $stock->branch_id,
            'to_sales_id' => $sales->id,
            'product_id' => $stock->product_id,
            'quantity' => $request->quantity,
            'type' => 'cabang_to_sales', // bisa tetap sama tipe
        ]);

        return redirect()->route('owner.stock.cabang.index')
                        ->with('success', 'Stok berhasil didistribusikan ke sales ' . $sales->name);
    }


    // ===== STOCK SALES =====
    public function stockSales()
    {
        // Ambil semua stock yang sudah punya sales
        $stocks = Stock::with(['product', 'sales.branch']) // eager load sales beserta cabangnya
            ->whereNotNull('sales_id')
            ->get();

        return view('pages.owner.stock.sales.index', compact('stocks'));
    }
}
