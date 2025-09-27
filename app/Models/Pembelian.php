<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = ['id_user', 'tanggal', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'id_pembelian');
    }
}
