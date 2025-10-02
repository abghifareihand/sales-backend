<?php

namespace App\Http\Controllers\Web\Pusat;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PusatProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('pages.pusat.product.index', compact('products'));
    }

    // Form tambah produk baru
    public function create()
    {
        return view('pages.pusat.product.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'kuota' => 'required|string|max:255',
            'expired' => 'required|date',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'provider.required' => 'Provider wajib diisi',
            'category.required' => 'Kategori wajib diisi',
            'zona.required' => 'Zona wajib diisi',
            'kuota.required' => 'Kuota wajib diisi',
            'expired.required' => 'Tanggal kadaluarsa wajib diisi',
            'expired.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid',
            'cost_price.required' => 'Harga pokok wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
        ]);

        Product::create($request->only(
            'name',
            'description',
            'provider',
            'category',
            'zona',
            'kuota',
            'expired',
            'cost_price',
            'selling_price'
        ));

        return redirect()->route('pusat.product.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        return view('pages.pusat.product.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'kuota' => 'required|string|max:255',
            'expired' => 'required|date',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'provider.required' => 'Provider wajib diisi',
            'category.required' => 'Kategori wajib diisi',
            'zona.required' => 'Zona wajib diisi',
            'kuota.required' => 'Kuota wajib diisi',
            'expired.required' => 'Tanggal kadaluarsa wajib diisi',
            'expired.date' => 'Tanggal kadaluarsa harus berupa tanggal yang valid',
            'cost_price.required' => 'Harga pokok wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
        ]);

        $product->update($request->only('name','description','cost_price','selling_price'));

        return redirect()->route('pusat.product.index')->with('success', 'Produk berhasil diperbarui');
    }

        public function show(Product $product)
    {
        return view('pages.pusat.product.show', compact('product'));
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('pusat.product.index')->with('success', 'Produk berhasil dihapus');
    }
}
