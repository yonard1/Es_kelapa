<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Produksi;

class ProduksiDetail extends Model
{
    use HasFactory;

    protected $table = 'produksi_details';
    protected $fillable = ['id_produksi','id_bahan','jumlah_dipakai','satuan'];

    // Relasi ke bahan/material
    public function bahan()
    {
        return $this->belongsTo(Material::class, 'id_bahan');
    }

    // Relasi ke produksi
    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'id_produksi');
    }
}

