<?php

namespace App\Livewire;

use App\Models\LaporanOperasionalHarian;
use App\Enums\UserRole;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class LaporanOperasionalHarianTable extends Component
{
    use WithPagination;

    public string $startDate = '';
    public string $endDate = '';

    protected $listeners = [
        'dateRangeChanged' => 'updateSelectedDateRange',
        'refresh' => '$refresh'
    ];
    
    public $editingId = null;

    public function mount(string $startDate = '', string $endDate = ''): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate ?: now()->format('Y-m-d');
    }
    
    public function updateSelectedDateRange($dateRange): void
    {
        $this->startDate = $dateRange['startDate'] ?? '';
        $this->endDate = $dateRange['endDate'] ?? now()->format('Y-m-d');
        $this->resetPage();
    }
    
    public function edit($id)
    {
        $this->editingId = $id;
        $this->dispatch('editLaporanOperasionalHarian', id: $id);
    }
    
    public function delete($id = null)
    {
        if (!$id) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'ID tidak valid',
            ]);
            return;
        }

        try {
            $record = \App\Models\LaporanOperasionalHarian::findOrFail($id);
            $record->delete();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
            
            // Reset editing ID and refresh the table
            $this->editingId = null;
            $this->resetPage();
            $this->dispatch('$refresh');
            
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ]);
        }
    }

    public function getRecordsProperty()
    {
        $query = LaporanOperasionalHarian::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at');
            
        if (!empty($this->startDate)) {
            $query->whereDate('tanggal', '>=', $this->startDate);
        }
        if (!empty($this->endDate)) {
            $query->whereDate('tanggal', '<=', $this->endDate);
        }

        return $query->paginate(25);
    }

    public function render()
    {
        return view('livewire.laporan-operasional-harian-table', [
            'records' => $this->records,
        ]);
    }
}

