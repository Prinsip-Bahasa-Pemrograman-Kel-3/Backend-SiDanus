<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthOrganization extends Authenticatable
{
    // Tentukan tabel jika nama tabel berbeda dari konvensi
    protected $table = 'auth_organizations';

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
    ];

    // Tentukan apakah password harus di-hash
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
