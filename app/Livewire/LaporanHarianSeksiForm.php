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

    public $noSt = '';
    public $namaSeksi = '';
    public $tanggal;
    public $petugas = [''];
    public $kegiatan = '';
    public $dokumentasiLink = '';
    public $hasilKegiatanLink = '';
    public array $seksiOptions = [];

    public function mount(): void
    {
        $this->authorizeRole([UserRole::ADMIN, UserRole::SEKSI]);
        $this->seksiOptions = LaporanHarianSeksi::getNamaSeksiList();
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

    public function save(): void
    {
        $petugas = array_values(array_filter(
            $this->petugas,
            static fn ($value) => filled(trim((string) $value))
        ));

        $this->petugas = $petugas ?: [''];

        $validated = $this->validate([
            'noSt' => [
                'required',
                'string',
                'max:50',
                Rule::unique('laporan_harian_seksis', 'no_st'),
            ],
            'namaSeksi' => ['required', Rule::in($this->seksiOptions)],
            'tanggal' => ['required', 'date'],
            'petugas' => ['array', 'min:1'],
            'petugas.*' => ['required', 'string', 'max:255'],
            'kegiatan' => ['nullable', 'string'],
            'dokumentasiLink' => ['nullable', 'url', 'max:2048'],
            'hasilKegiatanLink' => ['nullable', 'url', 'max:2048'],
        ]);

        LaporanHarianSeksi::create([
            'no_st' => $validated['noSt'],
            'nama_seksi' => $validated['namaSeksi'],
            'tanggal' => $validated['tanggal'],
            'petugas' => $validated['petugas'],
            'kegiatan' => $validated['kegiatan'] ?? null,
            'dokumentasi_link' => $validated['dokumentasiLink'] ?? null,
            'hasil_kegiatan_link' => $validated['hasilKegiatanLink'] ?? null,
        ]);

        session()->flash('message', 'Laporan harian berhasil disimpan.');

        $this->reset([
            'noSt',
            'namaSeksi',
            'tanggal',
            'petugas',
            'kegiatan',
            'dokumentasiLink',
            'hasilKegiatanLink',
        ]);

        $this->petugas = [''];
        $this->namaSeksi = '';
    }

    public function render()
    {
        return view('livewire.laporan-harian-seksi-form');
    }
}


