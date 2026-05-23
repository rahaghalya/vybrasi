<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produk extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jualan_kopi.produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function ulasan()
    {
        // Gunakan DB::raw() untuk mem-bypass konversi PDO
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk')
                    ->where('is_hidden', \Illuminate\Support\Facades\DB::raw('false'))
                    ->latest();
    }
}