<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarianSeksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_st',
        'nama_seksi',
        'tanggal',
        'petugas',
        'kegiatan',
        'dokumentasi_link',
        'hasil_kegiatan_link',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'petugas' => 'array',
    ];
}


