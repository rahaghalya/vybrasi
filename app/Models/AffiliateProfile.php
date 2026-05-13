<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AffiliateProfile extends Authenticatable
{
    protected $table = 'affiliate_profiles'; // Sesuaikan nama tabel
    protected $guarded = ['id'];

    public function getAuthPassword()
    {
        return $this->password; 
    }
}