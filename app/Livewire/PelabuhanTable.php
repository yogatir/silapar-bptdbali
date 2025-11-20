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

        $aggregates = (clone $query)
            ->reorder()
            ->selectRaw('
                COUNT(*) as total_rows,
                COALESCE(SUM(kapal_operasi), 0) as sum_kapal_operasi,
                COALESCE(SUM(trip), 0) as sum_trip,
                COALESCE(SUM(penumpang), 0) as sum_penumpang,
                COALESCE(SUM(roda_2), 0) as sum_roda_2,
                COALESCE(SUM(roda_4_penumpang), 0) as sum_roda_4_penumpang,
                COALESCE(SUM(roda_4_barang), 0) as sum_roda_4_barang,
                COALESCE(SUM(roda_2 + roda_4_penumpang + roda_4_barang), 0) as sum_total_kendaraan,
                COALESCE(AVG(kapal_operasi), 0) as avg_kapal_operasi,
                COALESCE(AVG(trip), 0) as avg_trip,
                COALESCE(AVG(penumpang), 0) as avg_penumpang,
                COALESCE(AVG(roda_2), 0) as avg_roda_2,
                COALESCE(AVG(roda_4_penumpang), 0) as avg_roda_4_penumpang,
                COALESCE(AVG(roda_4_barang), 0) as avg_roda_4_barang,
                COALESCE(AVG(roda_2 + roda_4_penumpang + roda_4_barang), 0) as avg_total_kendaraan,
                COALESCE(MAX(kapal_operasi), 0) as max_kapal_operasi,
                COALESCE(MAX(trip), 0) as max_trip,
                COALESCE(MAX(penumpang), 0) as max_penumpang,
                COALESCE(MAX(roda_2), 0) as max_roda_2,
                COALESCE(MAX(roda_4_penumpang), 0) as max_roda_4_penumpang,
                COALESCE(MAX(roda_4_barang), 0) as max_roda_4_barang,
                COALESCE(MAX(roda_2 + roda_4_penumpang + roda_4_barang), 0) as max_total_kendaraan
            ')
            ->first();

        if (! $aggregates || (int) $aggregates->total_rows === 0) {
            return [
                'total' => array_fill_keys([
                    'kapal_operasi',
                    'trip',
                    'penumpang',
                    'roda_2',
                    'roda_4_penumpang',
                    'roda_4_barang',
                    'total_kendaraan',
                ], 0),
                'average' => array_fill_keys([
                    'kapal_operasi',
                    'trip',
                    'penumpang',
                    'roda_2',
                    'roda_4_penumpang',
                    'roda_4_barang',
                    'total_kendaraan',
                ], 0),
                'maximum' => array_fill_keys([
                    'kapal_operasi',
                    'trip',
                    'penumpang',
                    'roda_2',
                    'roda_4_penumpang',
                    'roda_4_barang',
                    'total_kendaraan',
                ], 0),
            ];
        }

        return [
            'total' => [
                'kapal_operasi' => (int) $aggregates->sum_kapal_operasi,
                'trip' => (int) $aggregates->sum_trip,
                'penumpang' => (int) $aggregates->sum_penumpang,
                'roda_2' => (int) $aggregates->sum_roda_2,
                'roda_4_penumpang' => (int) $aggregates->sum_roda_4_penumpang,
                'roda_4_barang' => (int) $aggregates->sum_roda_4_barang,
                'total_kendaraan' => (int) $aggregates->sum_total_kendaraan,
            ],
            'average' => [
                'kapal_operasi' => round((float) $aggregates->avg_kapal_operasi, 2),
                'trip' => round((float) $aggregates->avg_trip, 2),
                'penumpang' => round((float) $aggregates->avg_penumpang, 2),
                'roda_2' => round((float) $aggregates->avg_roda_2, 2),
                'roda_4_penumpang' => round((float) $aggregates->avg_roda_4_penumpang, 2),
                'roda_4_barang' => round((float) $aggregates->avg_roda_4_barang, 2),
                'total_kendaraan' => round((float) $aggregates->avg_total_kendaraan, 2),
            ],
            'maximum' => [
                'kapal_operasi' => (int) $aggregates->max_kapal_operasi,
                'trip' => (int) $aggregates->max_trip,
                'penumpang' => (int) $aggregates->max_penumpang,
                'roda_2' => (int) $aggregates->max_roda_2,
                'roda_4_penumpang' => (int) $aggregates->max_roda_4_penumpang,
                'roda_4_barang' => (int) $aggregates->max_roda_4_barang,
                'total_kendaraan' => (int) $aggregates->max_total_kendaraan,
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
