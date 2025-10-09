<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $bulan ?? Carbon::now()->month;
        $tahun = $tahun ?? Carbon::now()->year;

        $transaksiBulanan = Transaksi::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $transaksiBulanan->sum('total');

        return [
            'transaksiBulanan' => $transaksiBulanan,
            'totalPendapatan' => $totalPendapatan,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
    }
}
