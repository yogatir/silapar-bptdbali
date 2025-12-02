<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Concerns\AuthorizesRole;
use App\Models\LaporanOperasionalHarian;
use Livewire\Component;

class LaporanOperasionalHarianForm extends Component
{
    use AuthorizesRole;

    public $recordId = null;
    public $editingId = null;
    public $isEditing = false;
    
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

    public function mount($recordId = null): void
    {
        $this->authorizeRole([UserRole::ADMIN, UserRole::SATPEL]);
        
        $this->recordId = $recordId;
        $this->editingId = $recordId;
        $this->isEditing = !is_null($recordId);
        
        if ($this->isEditing) {
            $this->loadRecord();
        }
    }
    
    protected function loadRecord(): void
    {
        $record = \App\Models\LaporanOperasionalHarian::findOrFail($this->editingId);
        
        // Map all fillable attributes to component properties
        foreach ($record->toArray() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        
        // Format the date for the input field (YYYY-MM-DD)
        if ($this->tanggal) {
            $this->tanggal = \Carbon\Carbon::parse($this->tanggal)->format('Y-m-d');
        }
        
        // Format the time if it exists
        if ($this->waktu) {
            $this->waktu = \Carbon\Carbon::parse($this->waktu)->format('H:i');
        }
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

    public function save()
    {
        $this->validate();
        
        $data = $this->only([
            'tanggal', 'waktu',
            'jumlah_kendaraan_masuk', 'jumlah_kendaraan_keluar',
            'manual_masuk', 'jto_masuk', 'manual_keluar', 'jto_keluar',
            'jumlah_diperiksa', 'jumlah_melanggar', 'jumlah_tidak_melanggar',
            'pelanggaran_daya_angkut', 'pelanggaran_tcm', 'pelanggaran_dokumen',
            'pelanggaran_dimensi', 'pelanggaran_teknis',
            'tindakan_peringatan', 'tindakan_tilang', 'tindakan_transfer_muatan',
            'tindakan_putar_balik', 'tindakan_tunda_berangkat',
            'tindakan_surat_tilang', 'tindakan_serah_polisi', 'tindakan_proses_etilang',
            'denda', 'kecelakaan_lalu_lintas', 'jumlah_sdm', 'sdm_ppns',
            'sdm_danru', 'sdm_pkb', 'sdm_ppkb', 'sdm_pelaporan_jto', 'sdm_petugas_lalin',
            'arus_lalu_lintas', 'cuaca', 'jumlah_responden_skm', 'kendala', 'catatan'
        ]);
        
        if ($this->isEditing) {
            // Update existing record
            $record = LaporanOperasionalHarian::findOrFail($this->editingId);
            $record->update($data);
            
            session()->flash('message', 'Laporan UPPKB berhasil diperbarui');
        } else {
            // Create new record
            LaporanOperasionalHarian::create($data);
            
            session()->flash('message', 'Laporan UPPKB berhasil disimpan');
            $this->resetForm();
        }
        
        return redirect()->route('laporan-operasional-harian.form');
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


