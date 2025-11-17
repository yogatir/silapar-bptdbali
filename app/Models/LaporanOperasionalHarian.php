<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanOperasionalHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_operasional_harian';

    protected $fillable = [
        'tanggal',
        'waktu',
        'jumlah_kendaraan_masuk',
        'jumlah_kendaraan_keluar',
        'manual_masuk',
        'jto_masuk',
        'manual_keluar',
        'jto_keluar',
        'jumlah_diperiksa',
        'jumlah_melanggar',
        'jumlah_tidak_melanggar',
        'pelanggaran_daya_angkut',
        'pelanggaran_tcm',
        'pelanggaran_dokumen',
        'pelanggaran_dimensi',
        'pelanggaran_teknis',
        'tindakan_peringatan',
        'tindakan_tilang',
        'tindakan_transfer_muatan',
        'tindakan_putar_balik',
        'tindakan_tunda_berangkat',
        'tindakan_surat_tilang',
        'tindakan_serah_polisi',
        'tindakan_proses_etilang',
        'denda',
        'kecelakaan_lalu_lintas',
        'jumlah_sdm',
        'sdm_ppns',
        'sdm_danru',
        'sdm_pkb',
        'sdm_ppkb',
        'sdm_pelaporan_jto',
        'sdm_petugas_lalin',
        'arus_lalu_lintas',
        'cuaca',
        'jumlah_responden_skm',
        'kendala',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'denda' => 'decimal:2',
    ];
}


