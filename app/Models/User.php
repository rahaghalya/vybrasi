<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasUuids;

    // ✅ Cukup 'profiles' saja — search_path=jualan_kopi sudah handle schema-nya
    protected $table = 'profiles';

    // ✅ Fillable pakai property biasa, bukan attribute #[Fillable]
    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'email',
        'password',
        'role',
        'can_shop',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'password'                => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'can_shop'                => 'boolean',
        ];
    }

    // ✅ Auto-generate user_id (UUID) saat user baru dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->user_id)) {
                $model->user_id = (string) Str::uuid();
            }
        });
    }
}