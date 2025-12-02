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
            $this->tanggal = $record->tanggal->format('Y-m-d');
            $this->waktu = $record->waktu;
            $this->pelabuhan = $record->pelabuhan;
            $this->kapalOperasi = $record->kapal_operasi;
            $this->trip = $record->trip;
            $this->penumpang = $record->penumpang;
            $this->roda2 = $record->roda_2;
            $this->roda4Penumpang = $record->roda_4_penumpang;
            $this->roda4Barang = $record->roda_4_barang;
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
                $this->dermaga = collect($this->currentPelabuhanConfig['dermaga'])->map(function ($dermaga) {
                    return [
                        'nama' => $dermaga['nama'],
                        'kapal' => []
                    ];
                })->toArray();
            }
        } else {
            $this->currentPelabuhanConfig = null;
            $this->dermaga = [];
        }
    }

    public function addKapal($dermagaIndex)
    {
        if (isset($this->dermaga[$dermagaIndex])) {
            $this->dermaga[$dermagaIndex]['kapal'][] = '';
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

        $this->validate($rules);

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
