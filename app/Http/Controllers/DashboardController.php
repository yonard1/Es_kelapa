<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        if($user->hak == 'admin'){
            $totalPenjualanHariIni = Transaksi::whereDate('tanggal', $today) -> sum('total');
            $totalPembelianBulanIni = Pembelian::whereMonth('tanggal', $today->month) -> sum('total');
            $totalTransaksiBulanIni = Transaksi::whereMonth('tanggal', $today->month) -> sum('total');

            return view('dashboard.admin', compact(
                'totalPenjualanHariIni',
                'totalPembelianBulanIni',
                'totalTransaksiBulanIni'
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
