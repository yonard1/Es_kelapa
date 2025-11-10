<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Pembelian;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LaporanController extends Controller
{
    // Fungsi utama buat nampilin laporan
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'harian'); // default harian
        $today = Carbon::today();

        // Ambil bulan & tahun dari request (default bulan & tahun sekarang)
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));

        // Siapkan variabel
        $transaksis = collect();
        $pembelians = collect();
        $total_penjualan = 0;
        $total_pembelian = 0;

        // Filter berdasarkan jenis laporan
        if ($filter == 'harian') {
            $transaksis = Transaksi::whereDate('tanggal', $today)->get();
            $pembelians = Pembelian::whereDate('tanggal', $today)->get();
        } elseif ($filter == 'mingguan') {
            $start = Carbon::parse("monday this week"); // Start of the current week (Monday)
            $end = Carbon::parse("sunday this week"); // End of the current week (Sunday)

            $transaksis = Transaksi::whereBetween('tanggal', [$start, $end])->get();
            $pembelians = Pembelian::whereBetween('tanggal', [$start, $end])->get();
        } elseif ($filter == 'bulanan') {
            $transaksis = Transaksi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $pembelians = Pembelian::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        }

        // Hitung total penjualan & pembelian
        $total_penjualan = $transaksis->sum('total');
        $total_pembelian = $pembelians->sum('total');

        // Hitung untung / rugi
        $keuntungan = $total_penjualan - $total_pembelian;

        // Kirim ke view
        return view('laporan.index', compact(
            'filter',
            'bulan',
            'tahun',
            'transaksis',
            'pembelians',
            'total_penjualan',
            'total_pembelian',
            'keuntungan'
        ));
    }

    // Fungsi untuk download laporan sebagai PDF
    public function downloadPdf(Request $request)
    {
        $filter = $request->get('filter', 'harian');
        $today = Carbon::today();

        // Ambil bulan & tahun dari request (default bulan & tahun sekarang)
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));

        // Siapkan variabel
        $transaksis = collect();
        $pembelians = collect();

        // Filter berdasarkan jenis laporan
        if ($filter == 'harian') {
            $transaksis = Transaksi::whereDate('tanggal', $today)->get();
            $pembelians = Pembelian::whereDate('tanggal', $today)->get();
        } elseif ($filter == 'mingguan') {
            $start = Carbon::parse("monday this week");
            $end = Carbon::parse("sunday this week");

            $transaksis = Transaksi::whereBetween('tanggal', [$start, $end])->get();
            $pembelians = Pembelian::whereBetween('tanggal', [$start, $end])->get();
        } elseif ($filter == 'bulanan') {
            $transaksis = Transaksi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $pembelians = Pembelian::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        }

        // Hitung total penjualan & pembelian
        $total_penjualan = $transaksis->sum('total');
        $total_pembelian = $pembelians->sum('total');

        // Hitung untung / rugi
        $keuntungan = $total_penjualan - $total_pembelian;

        // Render view ke PDF
        $pdf = PDF::loadView('laporan.pdf', compact(
            'filter',
            'bulan',
            'tahun',
            'transaksis',
            'pembelians',
            'total_penjualan',
            'total_pembelian',
            'keuntungan'
        ));

        // Download PDF
        return $pdf->download('laporan_'.$filter.'.pdf');
    }
}
