<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Concerns\AuthorizesRole;
use App\Models\LaporanOperasionalHarian;
use Livewire\Component;

class LaporanOperasionalHarianForm extends Component
{
    use AuthorizesRole;

    public $tanggal;
    public $waktu;

    public $jumlah_kendaraan_masuk = 0;
    public $jumlah_kendaraan_keluar = 0;
    public $manual_masuk = 0;
    public $jto_masuk = 0;
    public $manual_keluar = 0;
    public $jto_keluar = 0;
    public $jumlah_diperiksa = 0;
    public $jumlah_melanggar = 0;
    public $jumlah_tidak_melanggar = 0;

    public $pelanggaran_daya_angkut = 0;
    public $pelanggaran_tcm = 0;
    public $pelanggaran_dokumen = 0;
    public $pelanggaran_dimensi = 0;
    public $pelanggaran_teknis = 0;
    public $tindakan_peringatan = 0;
    public $tindakan_tilang = 0;
    public $tindakan_transfer_muatan = 0;
    public $tindakan_putar_balik = 0;
    public $tindakan_tunda_berangkat = 0;
    public $tindakan_surat_tilang = 0;
    public $tindakan_serah_polisi = 0;
    public $tindakan_proses_etilang = 0;
    public $denda = 0;
    public $kecelakaan_lalu_lintas = 0;

    public $jumlah_sdm = 0;
    public $sdm_ppns = 0;
    public $sdm_danru = 0;
    public $sdm_pkb = 0;
    public $sdm_ppkb = 0;
    public $sdm_pelaporan_jto = 0;
    public $sdm_petugas_lalin = 0;
    public $arus_lalu_lintas = '';
    public $cuaca = '';
    public $jumlah_responden_skm = 0;

    public $kendala = '';
    public $catatan = '';

    public function mount(): void
    {
        $this->authorizeRole([UserRole::KABALAI, UserRole::SATPEL]);
    }

    protected function rules(): array
    {
        $integerFields = collect($this->integerFields())->mapWithKeys(function ($field) {
            return [$field => ['nullable', 'integer', 'min:0']];
        })->toArray();

        return array_merge([
            'tanggal' => ['required', 'date'],
            'waktu' => ['nullable', 'date_format:H:i'],
            'denda' => ['nullable', 'numeric', 'min:0'],
            'arus_lalu_lintas' => ['nullable', 'string', 'max:50'],
            'cuaca' => ['nullable', 'string', 'max:50'],
            'kendala' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ], $integerFields);
    }

    protected function integerFields(): array
    {
        return [
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
            'kecelakaan_lalu_lintas',
            'jumlah_sdm',
            'sdm_ppns',
            'sdm_danru',
            'sdm_pkb',
            'sdm_ppkb',
            'sdm_pelaporan_jto',
            'sdm_petugas_lalin',
            'jumlah_responden_skm',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        foreach ($this->integerFields() as $field) {
            $validated[$field] = is_null($validated[$field] ?? null)
                ? 0
                : (int) $validated[$field];
        }

        $validated['denda'] = (float) ($validated['denda'] ?? 0);

        LaporanOperasionalHarian::create($validated);

        session()->flash('message', 'Laporan UPPKB berhasil disimpan.');

        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset([
            'tanggal',
            'waktu',
            'arus_lalu_lintas',
            'cuaca',
            'kendala',
            'catatan',
        ]);

        foreach ($this->integerFields() as $field) {
            $this->{$field} = 0;
        }

        $this->denda = 0;
    }

    public function render()
    {
        return view('livewire.laporan-operasional-harian-form');
    }
}


