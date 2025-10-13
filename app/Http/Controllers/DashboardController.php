<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;
use Carbon\Carbon;
use App\Models\Material;
use DB;

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

            // 🔹 Hitung total penjualan & pembelian
            $total_penjualan = $totalTransaksiBulanIni;
            $total_pembelian = $totalPembelianBulanIni;

            // 🔹 Hitung untung / rugi
            $keuntungan = $total_penjualan - $total_pembelian;

            $penjualanPerBulan = Transaksi::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('sum(total) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

            $pembelianPerBulan = Pembelian::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('sum(total) as total')
            )
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();
            
            $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            for ($i = 1; $i <= 12; $i++) {
                $totalPenjualan = Transaksi::whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $i)
                    ->sum('total');

                $totalPembelian = Pembelian::whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $i)
                    ->sum('total');

                $dataPenjualan[] = (int) $totalPenjualan;
                $dataPembelian[] = (int) $totalPembelian;
            }

            

            return view('dashboard.admin', compact(
                'totalPenjualanHariIni',
                'totalPembelianBulanIni',
                'totalTransaksiBulanIni',
                'bulan',
                'tahun',
                'stokHampirHabis',
                'keuntungan',
                'dataPenjualan',
                'dataPembelian',
                'bulanNama'
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
