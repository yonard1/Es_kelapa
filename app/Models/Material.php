<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $primaryKey = 'id_bahan';
    protected $fillable = ['nama_bahan', 'satuan', 'stok', 'harga'];
    public function PembelianDetails(){
        return $this->hasMany(PembelianDetail::class, 'id_bahan');
    }
}
