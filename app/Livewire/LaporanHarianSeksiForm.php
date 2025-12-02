<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Concerns\AuthorizesRole;
use App\Models\LaporanHarianSeksi;
use Illuminate\Validation\Rule;
use Livewire\Component;

class LaporanHarianSeksiForm extends Component
{
    use AuthorizesRole;

    public $recordId = null;
    public $editingId = null;
    public $isEditing = false;
    public $noSt = '';
    public $namaSeksi = '';
    public $tanggal;
    public $petugas = [''];
    public $kegiatan = '';
    public $dokumentasiLink = '';
    public $hasilKegiatanLink = '';
    public array $seksiOptions = [];

    public function mount($recordId = null): void
    {
        $this->authorizeRole([UserRole::ADMIN, UserRole::SEKSI]);
        $this->seksiOptions = LaporanHarianSeksi::getNamaSeksiList();
        
        $this->recordId = $recordId;
        $this->editingId = $recordId;
        $this->isEditing = !is_null($recordId);
        
        if ($this->recordId) {
            $this->loadRecord($this->recordId);
        }
    }

    public function addPetugas(): void
    {
        $this->petugas[] = '';
    }

    public function removePetugas(int $index): void
    {
        if (isset($this->petugas[$index])) {
            unset($this->petugas[$index]);
            $this->petugas = array_values($this->petugas);
        }
    }

    public function loadRecord($id): void
    {
        $record = LaporanHarianSeksi::findOrFail($id);
        
        $this->noSt = $record->no_st;
        $this->namaSeksi = $record->nama_seksi;
        $this->tanggal = $record->tanggal->format('Y-m-d');
        $this->petugas = $record->petugas ?: [''];
        $this->kegiatan = $record->kegiatan;
        $this->dokumentasiLink = $record->dokumentasi_link;
        $this->hasilKegiatanLink = $record->hasil_kegiatan_link;
    }

    public function save()
    {
        $petugas = array_values(array_filter(
            $this->petugas,
            static fn ($value) => filled(trim((string) $value))
        ));

        $this->petugas = $petugas ?: [''];

        $rules = [
            'noSt' => [
                'required',
                'string',
                'max:50',
            ],
            'namaSeksi' => ['required', Rule::in($this->seksiOptions)],
            'tanggal' => ['required', 'date'],
            'petugas' => ['array', 'min:1'],
            'petugas.*' => ['required', 'string', 'max:255'],
            'kegiatan' => ['nullable', 'string'],
            'dokumentasiLink' => ['nullable', 'url', 'max:2048'],
            'hasilKegiatanLink' => ['nullable', 'url', 'max:2048'],
        ];

        // Add unique rule for no_st only if we're creating a new record
        if ($this->isEditing) {
            $rules['noSt'][] = Rule::unique('laporan_harian_seksis', 'no_st')->ignore($this->editingId);
        } else {
            $rules['noSt'][] = Rule::unique('laporan_harian_seksis', 'no_st');
        }

        $validated = $this->validate($rules);

        $data = [
            'no_st' => $validated['noSt'],
            'nama_seksi' => $validated['namaSeksi'],
            'tanggal' => $validated['tanggal'],
            'petugas' => $validated['petugas'],
            'kegiatan' => $validated['kegiatan'] ?? null,
            'dokumentasi_link' => $validated['dokumentasiLink'] ?? null,
            'hasil_kegiatan_link' => $validated['hasilKegiatanLink'] ?? null,
        ];

        if ($this->isEditing) {
            // Update existing record
            $record = LaporanHarianSeksi::findOrFail($this->editingId);
            $record->update($data);
            
            session()->flash('message', 'Laporan Harian Seksi berhasil diperbarui.');
            return redirect()->route('laporan-harian-seksi.form');
        } else {
            // Create new record
            LaporanHarianSeksi::create($data);
            
            session()->flash('message', 'Laporan Harian Seksi berhasil ditambahkan.');
            return redirect()->route('laporan-harian-seksi.form');
        }
    }

    public function render()
    {
        return view('livewire.laporan-harian-seksi-form');
    }
}


