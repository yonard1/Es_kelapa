<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\ProduksiDetail;
use App\Models\Product;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    public function index()
    {
        // ✅ Tambahkan paginate(10)
        $produksi = Produksi::with(['produk', 'detail.bahan'])
            ->latest()
            ->paginate(10);

        $produk = Product::all();
        $bahan = Material::all();

        return view('produksi.index', compact('produksi', 'produk', 'bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk',
            'tanggal_produksi' => 'required|date',
            'jumlah_dibuat' => 'required|numeric|min:1',
            'bahan' => 'required|array',
            'jumlah_dipakai.*' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            // ✅ Simpan data produksi
            $produksi = Produksi::create([
                'id_produk' => $request->id_produk,
                'tanggal_produksi' => $request->tanggal_produksi,
                'jumlah_dibuat' => $request->jumlah_dibuat,
                'catatan' => $request->catatan,
            ]);

            // ✅ Simpan detail bahan
            foreach ($request->bahan as $key => $id_bahan) {
                $jumlah = $request->jumlah_dipakai[$key];
                $satuan = $request->satuan[$key] ?? null;

                ProduksiDetail::create([
                    // ⚠️ PENTING: gunakan id_produksi, bukan id
                    'id_produksi' => $produksi->id_produksi,
                    'id_bahan' => $id_bahan,
                    'jumlah_dipakai' => $jumlah,
                    'satuan' => $satuan,
                ]);

                // Kurangi stok bahan
                $bahan = Material::find($id_bahan);
                if ($bahan && $bahan->stok >= $jumlah) {
                    $bahan->stok -= $jumlah;
                    $bahan->save();
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Produksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $produksi = Produksi::with('detail')->findOrFail($id);

        // Kembalikan stok bahan
        foreach ($produksi->detail as $detail) {
            $bahan = Material::find($detail->id_bahan);
            if ($bahan) {
                $bahan->stok += $detail->jumlah_dipakai;
                $bahan->save();
            }
        }

        // Hapus detail (jika FK tidak cascade)
        $produksi->detail()->delete();
        $produksi->delete();

        return redirect()->back()->with('success', 'Data produksi berhasil dihapus.');
    }
}
