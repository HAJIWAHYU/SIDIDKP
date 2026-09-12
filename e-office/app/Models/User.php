<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bidang_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = strtolower($value);
    }

    public function suratMasuk()
    {
        return $this->hasMany(Surat::class, 'penerima_id');
    }

    public function suratKeluar()
    {
        return $this->hasMany(Surat::class, 'pengirim_id');
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
