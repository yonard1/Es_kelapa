<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->orderBy('tanggal', 'desc')->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    // Form create transaksi
    public function create()
    {
        $products = Product::all();
        return view('transaksi.create', compact('products'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'produk_id.*' => 'required|exists:products,id_produk',
            'qty.*'   => 'required|integer|min:1'
        ]);

        // Hitung total
        $total = 0;
        foreach ($request->produk_id as $key => $id_produk) {
            $produk = Product::findOrFail($id_produk);
            $subtotal = $produk->harga * $request->jumlah[$key];
            $total += $subtotal;
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'total'   => $total
        ]);

        // Simpan detail transaksi
        foreach ($request->produk_id as $key => $id_produk) {
            $produk = Product::findOrFail($id_produk);
            $subtotal = $produk->harga * $request->jumlah[$key];

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk'    => $id_produk,
                'qty'       => $request->jumlah[$key],
                'harga' => $produk->harga,
                'subtotal'     => $subtotal
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}
