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

    public static function getNamaSeksiList(): array
    {
        return config('laporan_seksi.options', []);
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function getNamaSeksiOptions(): array
    {
        return collect(self::getNamaSeksiList())
            ->map(fn (string $nama) => [
                'value' => $nama,
                'label' => $nama,
            ])
            ->values()
            ->all();
    }
}


