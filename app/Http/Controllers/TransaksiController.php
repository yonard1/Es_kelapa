<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');

        // Ambil data transaksi dengan relasi user
        $query = Transaksi::with('user')->orderBy('tanggal', 'desc');

        // 🔍 Filter berdasarkan nama kasir
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // 📅 Filter berdasarkan tanggal
        if ($date) {
            $query->whereDate('tanggal', $date);
        }

        $user = Auth::user();

        // Kalau user adalah kasir, arahkan ke halaman tambah transaksi
        if ($user->hak === 'kasir') {
            return redirect()->route('transaksi.create');
        }

        session()->forget('back_url'); // Bersihkan session

        $transaksis = $query->paginate(10);

        return view('transaksi.index', compact('transaksis', 'search', 'date'));
    }


    // Form create transaksi
    public function create()
    {
        $products = Product::all();
        return view('transaksi.create', compact('products'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
        'tanggal' => 'required|date',
        'produk_id.*' => 'required|exists:products,id_produk',
        'qty.*'   => 'required|integer|min:1',
        'bayar'   => 'required|numeric|min:0',
    ]);

    // Hitung total harga
    $total = 0;
    foreach ($request->produk_id as $key => $id_produk) {
        $produk = Product::findOrFail($id_produk);
        $subtotal = $produk->harga * $request->jumlah[$key];
        $total += $subtotal;
    }

    // Cek apakah uang cukup
    if ($request->bayar < $total) {
        return redirect()->back()->with('error', 'Uang tidak cukup untuk melakukan transaksi!');
    }

    $kembalian = $request->bayar - $total;

    // Simpan transaksi
    $transaksi = Transaksi::create([
        'user_id' => Auth::id(),
        'tanggal' => $request->tanggal,
        'total'   => $total,
        'bayar'   => $request->bayar,
        'kembalian' => $kembalian,
    ]);

    // Simpan detail transaksi
    foreach ($request->produk_id as $key => $id_produk) {
        $produk = Product::findOrFail($id_produk);
        $subtotal = $produk->harga * $request->jumlah[$key];

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_produk'    => $id_produk,
            'qty'          => $request->jumlah[$key],
            'harga'        => $produk->harga,
            'subtotal'     => $subtotal,
        ]);
    }

    if (!session()->has('back_url')) {
        session(['back_url' => url()->previous()]);
    }

    $backUrl = session('back_url', route('transaksi.index'));

    return view('transaksi.show', compact('transaksi', 'backUrl'));

    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);

        $previousUrl = url()->previous();

        if (str_contains($previousUrl, 'transaksi/create')) {
            $backUrl = route('transaksi.create'); // kalau datang dari form transaksi baru
        } elseif (auth()->user()->hak === 'kasir') {
            $backUrl = route('kasir.riwayat'); // kalau kasir buka dari riwayat
        } else {
            $backUrl = route('transaksi.index'); // kalau admin
        }

        return view('transaksi.show', compact('transaksi', 'backUrl'));
    }

    public function riwayat()
    {
        session()->forget('back_url'); // bersihkan juga
        $riwayat = Transaksi::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('transaksi.riwayat', compact('riwayat'));
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);

    // Generate PDF from the view
    $pdf = PDF::loadView('transaksi.struk', compact('transaksi'));

    // Return the PDF to download
    return $pdf->download('struk-transaksi-'.$transaksi->id_transaksi.'.pdf');
    }
}
