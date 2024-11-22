<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Organization extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Tentukan tabel jika nama tabel berbeda dari konvensi
    protected $table = 'organizations';

    // Kolom yang dapat diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
    ];

    // Kolom yang disembunyikan saat data dikembalikan dalam respons JSON
    protected $hidden = [
        'password', // Sembunyikan password dalam respons JSON untuk keamanan
        'remember_token', // Untuk keamanan tambahan
    ];

    // Tentukan tipe data otomatis
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Mutator untuk meng-hash password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
