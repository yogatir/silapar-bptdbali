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
    })->middleware('role:' . UserRole::ADMIN . ',' . UserRole::KABALAI . ',' . UserRole::SEKSI . ',' . UserRole::SATPEL)
      ->name('dashboard');

    Route::get('/pelabuhan', function () {
        return view('pelabuhan');
    })->middleware('role:' . UserRole::ADMIN . ',' . UserRole::SATPEL)
      ->name('pelabuhan.form');

    Route::get('/laporan-harian-seksi', function () {
        return view('laporan-harian-seksi');
    })->middleware('role:' . UserRole::ADMIN . ',' . UserRole::SEKSI)
      ->name('laporan-harian-seksi.form');

    Route::get('/laporan-operasional-harian', function () {
        return view('laporan-operasional-harian');
    })->middleware('role:' . UserRole::ADMIN . ',' . UserRole::SATPEL)
      ->name('laporan-operasional-harian.form');

    Route::get('/terminal', function () {
        return view('terminal');
    })->middleware('role:' . UserRole::ADMIN . ',' . UserRole::SATPEL)
      ->name('terminal.form');
      
    Route::get('/pelabuhan/{pelabuhan}/edit', function (App\Models\Pelabuhan $pelabuhan) {
        return view('pelabuhan-edit', ['pelabuhan' => $pelabuhan]);
    })->middleware('role:' . UserRole::ADMIN)
      ->name('pelabuhan.edit');
      
    Route::get('/terminal/{terminal}/edit', function (App\Models\TerminalReport $terminal) {
        return view('terminal-edit', ['terminal' => $terminal]);
    })->middleware('role:' . UserRole::ADMIN)
      ->name('terminal.edit');
      
    Route::get('/insight', \App\Livewire\Insight::class)
        ->middleware('role:' . UserRole::ADMIN . ',' . UserRole::KABALAI . ',' . UserRole::SEKSI . ',' . UserRole::SATPEL)
        ->name('insight');
      
    Route::get('/laporan-harian-seksi/{laporanHarianSeksi}/edit', function (App\Models\LaporanHarianSeksi $laporanHarianSeksi) {
        return view('laporan-harian-seksi-edit', ['laporanHarianSeksi' => $laporanHarianSeksi]);
    })->middleware('role:' . UserRole::ADMIN)
      ->name('laporan-harian-seksi.edit');
      
    Route::get('/laporan-operasional-harian/{id}/edit', function ($id) {
        return view('laporan-operasional-harian-edit', ['id' => $id]);
    })->middleware('role:' . UserRole::ADMIN)
      ->name('laporan-operasional-harian.edit');
});


