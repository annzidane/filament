<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function saveGambar(array $gambarPaths)
    {
        // Log gambar yang diunggah
        Log::info('Menyimpan gambar dengan paths: ' . implode(', ', $gambarPaths));

        // Remove existing gambar
        $this->gambar()->delete();

        // Save new gambar
        foreach ($gambarPaths as $path) {
            Log::info('Menyimpan gambar dengan path: ' . $path);
            $this->gambar()->create([
                'path' => $path,
            ]);
        }
    }
}
