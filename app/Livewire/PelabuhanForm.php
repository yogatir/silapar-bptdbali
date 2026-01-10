<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Concerns\AuthorizesRole;
use App\Models\Pelabuhan;
use Livewire\Component;

class PelabuhanForm extends Component
{
    use AuthorizesRole;

    public $tanggal;
    public $waktu;
    public $pelabuhan = '';
    public $dermaga = [];
    public $kapalOperasi;
    public $trip;
    public $penumpang;
    public $roda2;
    public $roda4Penumpang;
    public $roda4Barang;
    public $editingId = null;
    public $recordId = null;
    
    // For Sampalan special form
    public $tripKedatangan;
    public $tripKeberangkatan;
    public $totalPenumpang;

    public $pelabuhanConfig = [];
    public $currentPelabuhanConfig = null;

    protected $listeners = ['editPelabuhan' => 'loadRecord'];

    public function mount($recordId = null)
    {
        $this->authorizeRole([UserRole::ADMIN, UserRole::SATPEL]);
        $this->pelabuhanConfig = Pelabuhan::getPelabuhanConfig();
        
        if ($recordId) {
            $this->loadRecord($recordId);
        }
    }
    
    public function loadRecord($id = null)
    {
        $this->resetForm();
        
        if ($id) {
            $record = Pelabuhan::findOrFail($id);
            $this->editingId = $id;
            $this->tanggal = \Carbon\Carbon::parse($record->tanggal)->format('Y-m-d');
            $this->waktu = $record->waktu;
            $this->pelabuhan = $record->pelabuhan;
            $this->kapalOperasi = $record->kapal_operasi;
            
            if ($record->pelabuhan === 'sampalan') {
                // Load Sampalan specific fields
                $this->tripKedatangan = $record->trip_kedatangan ?? 0;
                $this->tripKeberangkatan = $record->trip_keberangkatan ?? 0;
                $this->totalPenumpang = $record->penumpang;
            } else {
                // Load standard fields
                $this->trip = $record->trip;
                $this->penumpang = $record->penumpang;
                $this->roda2 = $record->roda_2;
                $this->roda4Penumpang = $record->roda_4_penumpang;
                $this->roda4Barang = $record->roda_4_barang;
            }
            
            $this->dermaga = $record->dermaga ?? [];
            
            // Trigger the updatedPelabuhan event to load dermaga config
            $this->updatedPelabuhan($this->pelabuhan);
        }
    }

    public function updatedPelabuhan($value)
    {
        if ($value && isset($this->pelabuhanConfig[$value])) {
            $this->currentPelabuhanConfig = $this->pelabuhanConfig[$value];
            
            // Only initialize dermaga if it's empty or not set
            if (empty($this->dermaga)) {
                if ($value === 'sampalan') {
                    // For Sampalan, initialize with detailed dermaga structure
                    $this->dermaga = collect($this->currentPelabuhanConfig['dermaga'])->map(function ($dermaga) {
                        return [
                            'nama' => $dermaga['nama'],
                            'kapal' => []  // Each kapal will have: jam, nama_kapal, trip_type, penumpang
                        ];
                    })->toArray();
                } else {
                    $this->dermaga = collect($this->currentPelabuhanConfig['dermaga'])->map(function ($dermaga) {
                        return [
                            'nama' => $dermaga['nama'],
                            'kapal' => []
                        ];
                    })->toArray();
                }
            }
        } else {
            $this->currentPelabuhanConfig = null;
            $this->dermaga = [];
        }
    }

    public function addKapal($dermagaIndex)
    {
        if (isset($this->dermaga[$dermagaIndex])) {
            if ($this->pelabuhan === 'sampalan') {
                // For Sampalan, add detailed kapal structure
                $this->dermaga[$dermagaIndex]['kapal'][] = [
                    'jam_sandar' => '',
                    'jam_tolak' => '',
                    'nama_kapal' => '',
                    'penumpang_turun' => '',
                    'penumpang_naik' => '',
                    'trip_berangkat' => '',
                    'trip_datang' => '',
                    'kegiatan' => ''
                ];
            } else {
                $this->dermaga[$dermagaIndex]['kapal'][] = '';
            }
        }
    }

    public function removeKapal($dermagaIndex, $kapalIndex)
    {
        if (isset($this->dermaga[$dermagaIndex]['kapal'][$kapalIndex])) {
            unset($this->dermaga[$dermagaIndex]['kapal'][$kapalIndex]);
            $this->dermaga[$dermagaIndex]['kapal'] = array_values($this->dermaga[$dermagaIndex]['kapal']);
        }
    }

    public function save()
    {
        // Allow saving for all pelabuhan (with or without dermaga)
        if (!$this->currentPelabuhanConfig) {
            session()->flash('error', 'Silakan pilih pelabuhan terlebih dahulu.');
            return;
        }

        if ($this->pelabuhan === 'sampalan') {
            // Validation rules for Sampalan
            $rules = [
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'pelabuhan' => 'required',
                'kapalOperasi' => 'required|numeric|min:0',
                'tripKedatangan' => 'required|numeric|min:0',
                'tripKeberangkatan' => 'required|numeric|min:0',
                'totalPenumpang' => 'required|numeric|min:0',
            ];
        } else {
            // Standard validation rules
            $rules = [
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'pelabuhan' => 'required',
                'kapalOperasi' => 'required|numeric|min:0',
                'trip' => 'required|numeric|min:0',
                'penumpang' => 'required|numeric|min:0',
                'roda2' => 'required|numeric|min:0',
                'roda4Penumpang' => 'required|numeric|min:0',
                'roda4Barang' => 'required|numeric|min:0',
            ];
        }

        $this->validate($rules);

        if ($this->pelabuhan === 'sampalan') {
            // Data structure for Sampalan
            $data = [
                'tanggal' => $this->tanggal,
                'waktu' => $this->waktu,
                'pelabuhan' => $this->pelabuhan,
                'kapal_operasi' => $this->kapalOperasi ?? 0,
                'trip' => ($this->tripKedatangan ?? 0) + ($this->tripKeberangkatan ?? 0), // Combined trip
                'penumpang' => $this->totalPenumpang ?? 0,
                'roda_2' => 0,
                'roda_4_penumpang' => 0,
                'roda_4_barang' => 0,
                'dermaga' => $this->dermaga ?? [],
                'trip_kedatangan' => $this->tripKedatangan ?? 0,
                'trip_keberangkatan' => $this->tripKeberangkatan ?? 0,
            ];
        } else {
            // Standard data structure
            $data = [
                'tanggal' => $this->tanggal,
                'waktu' => $this->waktu,
                'pelabuhan' => $this->pelabuhan,
                'kapal_operasi' => $this->kapalOperasi ?? 0,
                'trip' => $this->trip ?? 0,
                'penumpang' => $this->penumpang ?? 0,
                'roda_2' => $this->roda2 ?? 0,
                'roda_4_penumpang' => $this->roda4Penumpang ?? 0,
                'roda_4_barang' => $this->roda4Barang ?? 0,
                'dermaga' => $this->dermaga ?? [],
            ];
        }

        if ($this->editingId) {
            $record = Pelabuhan::findOrFail($this->editingId);
            $record->update($data);
            $message = 'Data berhasil diperbarui!';
        } else {
            Pelabuhan::create($data);
            $message = 'Data berhasil disimpan!';
        }

        session()->flash('message', $message);
        $this->resetForm();
    }

    public function getPelabuhanListProperty()
    {
        return collect($this->pelabuhanConfig)->map(function ($config, $key) {
            return [
                'value' => $key,
                'label' => $config['nama'],
            ];
        })->values()->toArray();
    }
    
    public function resetForm()
    {
        $this->reset([
            'editingId',
            'tanggal',
            'waktu',
            'pelabuhan',
            'dermaga',
            'kapalOperasi',
            'trip',
            'penumpang',
            'roda2',
            'roda4Penumpang',
            'roda4Barang',
            'tripKedatangan',
            'tripKeberangkatan',
            'totalPenumpang',
            'currentPelabuhanConfig'
        ]);
        
        // Reset validation errors
        $this->resetValidation();
        
        // Emit event to parent component to reset editing state
        if ($this->editingId) {
            $this->dispatch('cancelEdit');
        }
    }

    public function render()
    {
        return view('livewire.pelabuhan-form');
    }
}
