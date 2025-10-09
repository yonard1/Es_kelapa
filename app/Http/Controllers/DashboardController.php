<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hari ini
        $today = Carbon::today();
        // Bulan ini
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Total pendapatan hari ini
        $pendapatanHarian = Transaksi::whereDate('tanggal', $today)->sum('total_harga');

        // Total pendapatan bulan ini
        $pendapatanBulanan = Transaksi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('total_harga');

        // Laporan harian (misal untuk chart nanti)
        $laporanHarian = Transaksi::select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('dashboard', compact('pendapatanHarian', 'pendapatanBulanan', 'laporanHarian'));
    }
}
