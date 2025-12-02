<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Models\LaporanHarianSeksi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanHarianSeksiTable extends Component
{
    use WithPagination;

    public string $filterNamaSeksi = '';
    public string $selectedDate = '';
    public $editingId = null;

    protected $listeners = [
        'dateChanged' => 'updateSelectedDate',
        'refresh' => '$refresh'
    ];

    public function mount(string $filterNamaSeksi = '', string $selectedDate = ''): void
    {
        $validOptions = LaporanHarianSeksi::getNamaSeksiList();
        $this->filterNamaSeksi = in_array($filterNamaSeksi, $validOptions, true) ? $filterNamaSeksi : '';
        $this->selectedDate = $selectedDate;
    }
    
    public function updateSelectedDate($date): void
    {
        $this->selectedDate = $date;
        $this->resetPage();
    }

    public function updatedFilterNamaSeksi(): void
    {
        $this->resetPage();
    }
    
    public function edit($id)
    {
        $this->editingId = $id;
        $this->dispatch('editLaporanHarianSeksi', id: $id);
    }
    
    public function delete($id = null)
    {
        try {
            $record = LaporanHarianSeksi::findOrFail($id);
            $record->delete();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
            
            // Refresh the table
            $this->resetPage();
            $this->dispatch('refresh');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ]);
        }
    }

    public function getRecordsProperty()
    {
        $query = LaporanHarianSeksi::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at');

        if ($this->filterNamaSeksi !== '') {
            $query->where('nama_seksi', $this->filterNamaSeksi);
        }
        
        if (!empty($this->selectedDate)) {
            $query->whereDate('tanggal', $this->selectedDate);
        }

        return $query->paginate(50);
    }

    public function render()
    {
        return view('livewire.laporan-harian-seksi-table', [
            'records' => $this->records,
        ]);
    }
}


