<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('home', 'home')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
