<?php

namespace App\Livewire;

use App\Models\LaporanOperasionalHarian;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanOperasionalHarianTable extends Component
{
    use WithPagination;

    public string $selectedDate = '';

    protected $listeners = ['dateChanged' => 'updateSelectedDate'];

    public function mount(string $selectedDate = ''): void
    {
        $this->selectedDate = $selectedDate;
    }
    
    public function updateSelectedDate($date): void
    {
        $this->selectedDate = $date;
        $this->resetPage();
    }

    public function getRecordsProperty()
    {
        $query = LaporanOperasionalHarian::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at');
            
        if (!empty($this->selectedDate)) {
            $query->whereDate('tanggal', $this->selectedDate);
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

