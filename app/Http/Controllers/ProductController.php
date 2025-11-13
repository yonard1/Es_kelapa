<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 🔍 Cek duplikat nama produk
        if (Product::where('nama_produk', $request->nama_produk)->exists()) {
            return redirect()->back()->with('error', 'Produk dengan nama tersebut sudah ada!');
        }

        $data = $request->only(['nama_produk', 'harga', 'stok']);

        if ($request->hasFile('foto')) {
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/produk'), $filename);
            $data['foto'] = $filename;
        }

        Product::create($data);
        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::findOrFail($id);

        // 🔍 Cek duplikat nama produk selain dirinya sendiri
        $cekNama = Product::where('nama_produk', $request->nama_produk)
                          ->where('id', '!=', $id)
                          ->exists();

        if ($cekNama) {
            return redirect()->back()->with('error', 'Nama produk sudah digunakan oleh produk lain!');
        }

        $data = $request->only(['nama_produk', 'harga', 'stok']);

        if ($request->hasFile('foto')) {
            if ($product->foto && file_exists(public_path('upload/produk/' . $product->foto))) {
                unlink(public_path('upload/produk/' . $product->foto));
            }

            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/produk'), $filename);
            $data['foto'] = $filename;
        }

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->foto && file_exists(public_path('upload/produk/' . $product->foto))) {
            unlink(public_path('upload/produk/' . $product->foto));
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
