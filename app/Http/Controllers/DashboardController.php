<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pembelian;
use App\Models\Material;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        if ($user->hak == 'admin') {
            // Ambil bulan & tahun dari request, fallback ke bulan & tahun sekarang
            $bulan = $request->input('bulan', $today->month);
            $tahun = $request->input('tahun', $today->year);

            // ======================
            // 💳 Summary Card Data
            // ======================
            $totalPenjualanHariIni = Transaksi::whereDate('tanggal', $today)->sum('total');

            $totalTransaksiBulanIni = Transaksi::whereMonth('tanggal', $bulan)
                                               ->whereYear('tanggal', $tahun)
                                               ->sum('total');

            $totalPembelianBulanIni = Pembelian::whereMonth('tanggal', $bulan)
                                               ->whereYear('tanggal', $tahun)
                                               ->sum('total');

            $keuntungan = $totalTransaksiBulanIni - $totalPembelianBulanIni;

            // ======================
            // ⚠️ Stok Hampir Habis
            // ======================
            $stokHampirHabis = Material::where('stok', '<=', 5)->get();

            // ======================
            // 📈 Data Chart per Bulan
            // ======================
            // Penjualan per bulan (chart)
            $penjualanData = Transaksi::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

            // Pembelian per bulan (chart)
            $pembelianData = Pembelian::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(total) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

            // Pastikan array 12 bulan ada nilainya (0 jika tidak ada)
            $penjualanPerBulan = [];
            $pembelianPerBulan = [];
            for ($i = 1; $i <= 12; $i++) {
                $penjualanPerBulan[$i] = $penjualanData[$i] ?? 0;
                $pembelianPerBulan[$i] = $pembelianData[$i] ?? 0;
            }

            // ======================
            // 🔝 Top Products
            // ======================
            $topProducts = DetailTransaksi::with('produk')
                ->select('id_produk', DB::raw('SUM(qty) as total_terjual'))
                ->groupBy('id_produk')
                ->orderByDesc('total_terjual')
                ->limit(5)
                ->get();

            // ======================
            // 🧱 Material
            // ======================
            $material = Material::limit(5)->get();

            // Kirim ke view
            return view('dashboard.admin', compact(
                'totalPenjualanHariIni',
                'totalPembelianBulanIni',
                'totalTransaksiBulanIni',
                'keuntungan',
                'bulan',
                'tahun',
                'stokHampirHabis',
                'penjualanPerBulan',
                'pembelianPerBulan',
                'topProducts',
                'material'
            ));
        } else {
            // Dashboard kasir
            $totalPenjualanKasirHariIni = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->sum('total');

            $totalTransaksiKasirHariIni = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->count();

            return view('dashboard.kasir', compact(
                'totalPenjualanKasirHariIni',
                'totalTransaksiKasirHariIni'
            ));
        }
    }

    // Material AJAX
    public function getMaterialStok()
    {
        $material = Material::all();
        return response()->json(['material' => $material]);
    }

    // Top Products AJAX
    public function getTopProducts()
    {
        $topProducts = DetailTransaksi::with('produk')
            ->select('id_produk', DB::raw('SUM(qty) as total_terjual'))
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return response()->json(['topProducts' => $topProducts]);
    }
}
