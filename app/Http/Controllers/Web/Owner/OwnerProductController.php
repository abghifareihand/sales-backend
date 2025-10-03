<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OwnerProductController extends Controller
{
    public function index()
    {
        // Ambil semua data, nanti pagination handled oleh DataTables JS
        $products = Product::orderBy('id', 'desc')->get();
        return view('pages.owner.product.index', compact('products'));
    }


    public function create()
    {
        return view('pages.owner.product.create');
    }

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

        return redirect()->route('owner.product.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('pages.owner.product.edit', compact('product'));
    }

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

        $expired = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('expired'))->format('Y-m-d');

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'provider' => $request->provider,
            'category' => $request->category,
            'zona' => $request->zona,
            'kuota' => $request->kuota,
            'expired' => $expired,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
        ]);
        return redirect()->route('owner.product.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function show(Product $product)
    {
        return view('pages.owner.product.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('owner.product.index')->with('success', 'Produk berhasil dihapus');
    }
}
