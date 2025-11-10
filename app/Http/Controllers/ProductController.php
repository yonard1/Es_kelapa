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

        $data = $request->only(['nama_produk', 'harga', 'stok']);

        if($request->hasFile('foto')){
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/produk'),$filename);
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

        $data = $request->only(['nama_produk', 'harga', 'stok']);

        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($product->foto && file_exists(public_path('upload/produk/' . $product->foto))) {
                unlink(public_path('upload/produk/' . $product->foto));
            }

            // simpan foto baru
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
