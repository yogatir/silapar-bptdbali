<?php

namespace App\Livewire;

use App\Models\LaporanOperasionalHarian;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanOperasionalHarianTable extends Component
{
    use WithPagination;

    public function getRecordsProperty()
    {
        return LaporanOperasionalHarian::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->paginate(25);
    }

    public function render()
    {
        return view('livewire.laporan-operasional-harian-table', [
            'records' => $this->records,
        ]);
    }
}

