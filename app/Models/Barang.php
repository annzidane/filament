<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
    ];

    public function gambar()
    {
        return $this->hasMany(Gambar::class);
    }
}

