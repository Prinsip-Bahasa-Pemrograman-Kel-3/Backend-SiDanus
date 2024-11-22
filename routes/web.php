<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Rute ini hanya dapat diakses oleh pengguna dengan peran 'admin'
Route::middleware(['role:admin'])->get('/dashboard', function () {
    return view('dashboard');
});

