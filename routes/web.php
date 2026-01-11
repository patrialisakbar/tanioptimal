<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk user biasa (role = user)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:user'])->name('dashboard');

// Route untuk schedule
Route::get('/schedule', function () {
    return view('schedule.index');
})->middleware(['auth', 'verified'])->name('schedule');

require __DIR__.'/auth.php';
