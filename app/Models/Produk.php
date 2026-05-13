<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produk extends Model
{
    use HasFactory, HasUuids;

    // Arahkan tepat ke skema database milikmu
    protected $table = 'jualan_kopi.produk';
    
    // Beri tahu Laravel primary key-nya bukan 'id'
    protected $primaryKey = 'id_produk';

    // Izinkan pengisian massal
    protected $guarded = [];

    // --- TAMBAHAN RELASI KE ULASAN ---
    public function ulasan()
    {
        // Menarik semua ulasan terkait produk ini yang tidak disembunyikan
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk')
                    ->where('is_hidden', false)
                    ->latest();
    }
}