<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminProfile extends Authenticatable
{
    protected $table = 'admin_profiles'; // Sesuaikan nama tabel
    protected $guarded = ['id'];
    
    // Kalau password tidak di-hash atau beda nama kolomnya, sesuaikan di sini
    public function getAuthPassword()
    {
        return $this->password; 
    }
}