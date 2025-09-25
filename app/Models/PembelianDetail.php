<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_pembelian', 'id_bahan', 'jumlah', 'harga'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function bahan()
    {
        return $this->belongsTo(Material::class, 'id_bahan');
    }
}
