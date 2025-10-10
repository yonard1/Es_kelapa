<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Pembelian;

class LaporanController extends Controller
{
     // Fungsi utama buat nampilin laporan
    public function index(Request $request)
    {
        // Ambil filter dari user (harian, mingguan, bulanan)
        $filter = $request->get('filter', 'harian'); // default harian

        // Ambil tanggal sekarang
        $today = Carbon::today();

        // Variabel buat nyimpen total
        $total_penjualan = 0;
        $total_pembelian = 0;

        // 🔹 Filter berdasarkan jenis laporan
        if ($filter == 'harian') {
            $transaksis = Transaksi::whereDate('tanggal', $today)->get();
            $pembelians = Pembelian::whereDate('tanggal', $today)->get();
        } elseif ($filter == 'mingguan') {
            $start = $today->copy()->startOfWeek();
            $end = $today->copy()->endOfWeek();
            $transaksis = Transaksi::whereBetween('tanggal', [$start, $end])->get();
            $pembelians = Pembelian::whereBetween('tanggal', [$start, $end])->get();
        } elseif ($filter == 'bulanan') {
            $transaksis = Transaksi::whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year)->get();
            $pembelians = Pembelian::whereMonth('tanggal', $today->month)->whereYear('tanggal', $today->year)->get();
        }

        // 🔹 Hitung total penjualan & pembelian
        $total_penjualan = $transaksis->sum('total');
        $total_pembelian = $pembelians->sum('total');

        // 🔹 Hitung untung / rugi
        $keuntungan = $total_penjualan - $total_pembelian;

        // Kirim ke view
        return view('laporan.index', compact(
            'filter',
            'transaksis',
            'pembelians',
            'total_penjualan',
            'total_pembelian',
            'keuntungan'
        ));
    }
}
