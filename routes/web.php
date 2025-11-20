<?php

use App\Enums\UserRole;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:' . UserRole::KABALAI . ',' . UserRole::SEKSI . ',' . UserRole::SATPEL)
      ->name('dashboard');

    Route::get('/pelabuhan', function () {
        return view('pelabuhan');
    })->middleware('role:' . UserRole::KABALAI . ',' . UserRole::SATPEL)
      ->name('pelabuhan.form');

    Route::get('/laporan-harian-seksi', function () {
        return view('laporan-harian-seksi');
    })->middleware('role:' . UserRole::KABALAI . ',' . UserRole::SEKSI)
      ->name('laporan-harian-seksi.form');

    Route::get('/laporan-operasional-harian', function () {
        return view('laporan-operasional-harian');
    })->middleware('role:' . UserRole::KABALAI . ',' . UserRole::SATPEL)
      ->name('laporan-operasional-harian.form');

    Route::get('/terminal', function () {
        return view('terminal');
    })->middleware('role:' . UserRole::KABALAI . ',' . UserRole::SATPEL)
      ->name('terminal.form');
});


