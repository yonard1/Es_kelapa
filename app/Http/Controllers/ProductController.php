<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Product::create($request->all());
        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $products = Product::findOrFail($id);
        $products->update($request->all());

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
