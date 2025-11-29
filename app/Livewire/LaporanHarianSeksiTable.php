<?php

namespace App\Livewire;

use App\Models\LaporanHarianSeksi;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanHarianSeksiTable extends Component
{
    use WithPagination;

    public string $filterNamaSeksi = '';
    public string $selectedDate = '';

    protected $listeners = ['dateChanged' => 'updateSelectedDate'];

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


