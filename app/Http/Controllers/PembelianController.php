<?php

namespace App\Http\Controllers;
use App\Models\Material;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with(['user', 'details.bahan'])->latest()->get();
        $materials = Material::all();
        return view('pembelian.index', compact('pembelians', 'materials'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('pembelian.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'bahan.*.id_bahan' => 'required|exists:materials,id_bahan',
            'bahan.*.jumlah' => 'required|numeric|min:1',
            'bahan.*.harga' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, &$pembelian, &$total) {
        $pembelian = Pembelian::create([
            'id_user' => Auth::id(),
            'tanggal' => $request->tanggal,
            'total'   => 0,
        ]);

        $total = 0;

        foreach ($request->bahan as $item) {
            $subtotal = $item['jumlah'] * $item['harga'];
            $total += $subtotal;

            PembelianDetail::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_bahan'     => $item['id_bahan'],
                'jumlah'       => $item['jumlah'],
                'harga'        => $item['harga'],
                'subtotal'     => $subtotal,
            ]);

            $bahan = Material::find($item['id_bahan']);
            $bahan->stok += $item['jumlah'];
            $bahan->save();
        }

        $pembelian->update(['total' => $total]);
    });

    return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil disimpan!');
    }
}
