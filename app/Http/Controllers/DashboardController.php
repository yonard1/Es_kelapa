<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;
use Carbon\Carbon;
use App\Models\Material;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        if($user->hak == 'admin'){
        // Ambil bulan & tahun dari request, fallback ke bulan & tahun sekarang
            $bulan = $request->input('bulan', $today->month);
            $tahun = $request->input('tahun', $today->year);

            $totalPenjualanHariIni = Transaksi::whereDate('tanggal', $today)->sum('total');

            $totalPembelianBulanIni = Pembelian::whereMonth('tanggal', $bulan)
                                                ->whereYear('tanggal', $tahun)
                                                ->sum('total');

            $totalTransaksiBulanIni = Transaksi::whereMonth('tanggal', $bulan)
                                            ->whereYear('tanggal', $tahun)
                                            ->sum('total');

            $stokHampirHabis = Material::where('stok', '<=', 5)->get();

            return view('dashboard.admin', compact(
                'totalPenjualanHariIni',
                'totalPembelianBulanIni',
                'totalTransaksiBulanIni',
                'bulan',
                'tahun',
                'stokHampirHabis'
            ));
        }
        else {

            // Total penjualan kasir hari ini
            $totalPenjualanKasirHariIni = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->sum('total');

            // Total transaksi kasir hari ini
            $totalTransaksiKasirHariIni = Transaksi::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->count();

            return view('dashboard.kasir', compact(
                'totalPenjualanKasirHariIni',
                'totalTransaksiKasirHariIni'
            ));
        }
    }
}
