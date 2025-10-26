<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProduksiDetail;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksis';
    protected $primaryKey = 'id_produksi'; 
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['id_produk','tanggal_produksi','jumlah_dibuat','catatan'];

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    // Relasi ke detail produksi
    public function detail()
    {
        return $this->hasMany(ProduksiDetail::class, 'id_produksi');
    }
}
