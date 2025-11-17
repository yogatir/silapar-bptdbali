<?php

namespace App\Livewire;

use App\Models\Pelabuhan;
use Livewire\Component;
use Livewire\WithPagination;

class PelabuhanTable extends Component
{
    use WithPagination;

    public $filterPelabuhan = '';

    public function mount($filterPelabuhan = '')
    {
        $this->filterPelabuhan = $filterPelabuhan;
    }

    public function updatedFilterPelabuhan()
    {
        $this->resetPage();
    }

    public function getRecordsProperty()
    {
        $query = Pelabuhan::query()
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc');

        if ($this->filterPelabuhan) {
            $query->where('pelabuhan', $this->filterPelabuhan);
        }

        return $query->paginate(50);
    }

    public function getStatisticsProperty()
    {
        $query = Pelabuhan::query();

        if ($this->filterPelabuhan) {
            $query->where('pelabuhan', $this->filterPelabuhan);
        }

        $records = $query->get();

        if ($records->isEmpty()) {
            return [
                'total' => [
                    'kapal_operasi' => 0,
                    'trip' => 0,
                    'penumpang' => 0,
                    'roda_2' => 0,
                    'roda_4_penumpang' => 0,
                    'roda_4_barang' => 0,
                    'total_kendaraan' => 0,
                ],
                'average' => [
                    'kapal_operasi' => 0,
                    'trip' => 0,
                    'penumpang' => 0,
                    'roda_2' => 0,
                    'roda_4_penumpang' => 0,
                    'roda_4_barang' => 0,
                    'total_kendaraan' => 0,
                ],
                'maximum' => [
                    'kapal_operasi' => 0,
                    'trip' => 0,
                    'penumpang' => 0,
                    'roda_2' => 0,
                    'roda_4_penumpang' => 0,
                    'roda_4_barang' => 0,
                    'total_kendaraan' => 0,
                ],
            ];
        }

        $count = $records->count();

        return [
            'total' => [
                'kapal_operasi' => $records->sum('kapal_operasi'),
                'trip' => $records->sum('trip'),
                'penumpang' => $records->sum('penumpang'),
                'roda_2' => $records->sum('roda_2'),
                'roda_4_penumpang' => $records->sum('roda_4_penumpang'),
                'roda_4_barang' => $records->sum('roda_4_barang'),
                'total_kendaraan' => $records->sum(function ($record) {
                    return $record->roda_2 + $record->roda_4_penumpang + $record->roda_4_barang;
                }),
            ],
            'average' => [
                'kapal_operasi' => round($records->avg('kapal_operasi'), 2),
                'trip' => round($records->avg('trip'), 2),
                'penumpang' => round($records->avg('penumpang'), 2),
                'roda_2' => round($records->avg('roda_2'), 2),
                'roda_4_penumpang' => round($records->avg('roda_4_penumpang'), 2),
                'roda_4_barang' => round($records->avg('roda_4_barang'), 2),
                'total_kendaraan' => round($records->avg(function ($record) {
                    return $record->roda_2 + $record->roda_4_penumpang + $record->roda_4_barang;
                }), 2),
            ],
            'maximum' => [
                'kapal_operasi' => $records->max('kapal_operasi'),
                'trip' => $records->max('trip'),
                'penumpang' => $records->max('penumpang'),
                'roda_2' => $records->max('roda_2'),
                'roda_4_penumpang' => $records->max('roda_4_penumpang'),
                'roda_4_barang' => $records->max('roda_4_barang'),
                'total_kendaraan' => $records->max(function ($record) {
                    return $record->roda_2 + $record->roda_4_penumpang + $record->roda_4_barang;
                }),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pelabuhan-table', [
            'records' => $this->records,
            'statistics' => $this->statistics,
        ]);
    }
}
