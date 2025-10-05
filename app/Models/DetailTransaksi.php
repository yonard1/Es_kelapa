<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\Product;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksis';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_transaksi', 'id_produk', 'qty', 'harga', 'subtotal'];

    // Relasi ke transaksi (detail ini milik 1 transaksi)
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke produk (detail ini menunjuk ke 1 produk)
    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
