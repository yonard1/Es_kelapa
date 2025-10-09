<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['tanggal', 'total', 'user_id', 'bayar', 'kembalian'];

    // Relasi ke detail transaksi (1 transaksi bisa punya banyak detail)
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    // Relasi ke user (kasir/admin)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
