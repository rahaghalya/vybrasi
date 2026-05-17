<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ulasan extends Model
{
    use HasFactory, HasUuids;

    // Arahkan ke skema database ulasan
    protected $table = 'jualan_kopi.ulasan';
    
    // Primary key menggunakan UUID
    protected $primaryKey = 'id_ulasan';

    protected $guarded = [];

    // Cast data agar tipe datanya sesuai dengan PostgreSQL
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'gambar' => 'array', // Mengolah tipe data ARRAY dari PostgreSQL
            'is_verified_purchase' => 'boolean',
            'is_hidden' => 'boolean',
        ];
    }

    // --- TAMBAHAN RELASI KE USER ---
    public function user()
    {
        // Menyambungkan ulasan ke tabel profiles berdasarkan user_id
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}