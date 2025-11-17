<?php

namespace App\Livewire;

use App\Models\LaporanHarianSeksi;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanHarianSeksiTable extends Component
{
    use WithPagination;

    public function getRecordsProperty()
    {
        return LaporanHarianSeksi::query()
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.laporan-harian-seksi-table', [
            'records' => $this->records,
        ]);
    }
}


