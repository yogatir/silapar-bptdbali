<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Insight extends Component
{
    // Filter properties
    public $startDate;
    public $endDate;
    public $reportType = 'all';
    public $reportTypes = [
        'pelabuhan' => 'Laporan Pelabuhan',
        'terminal' => 'Laporan Terminal',
        'laporan_harian_seksi' => 'Laporan Harian Seksi',
        'laporan_operasional_harian' => 'Laporan UPPKB',
    ];
    
    public $selectedReportType = 'pelabuhan';

    public $stats = [
        'total_kapal' => 0,
        'total_penumpang' => 0,
        'total_roda_2' => 0,
        'total_roda_4' => 0,
        'visitor_change' => 0,
        'time_change' => 0,
        'transaction_change' => 0,
        'satisfaction_rate' => 0,
    ];

    public $trafficData = [];

    public $transactionData = [
        'labels' => ['Tiket Online', 'Pembayaran Tunai', 'Kartu Transportasi', 'Lainnya'],
        'data' => [45, 30, 15, 10],
        'colors' => [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(249, 115, 22, 0.8)',
            'rgba(156, 163, 175, 0.8)'
        ],
        'borderColors' => [
            'rgba(59, 130, 246, 1)',
            'rgba(16, 185, 129, 1)',
            'rgba(249, 115, 22, 1)',
            'rgba(156, 163, 175, 1)'
        ]
    ];

    public $recentActivities = [
        [
            'title' => 'Pembaruan jadwal rute baru',
            'description' => 'Sistem telah memperbarui jadwal rute dengan 15 perubahan.',
            'time' => '2 jam yang lalu',
            'icon' => 'clock',
            'color' => 'blue'
        ],
        [
            'title' => 'Pembayaran berhasil diproses',
            'description' => 'Pembayaran untuk tiket #12345 telah berhasil diverifikasi.',
            'time' => '5 jam yang lalu',
            'icon' => 'check',
            'color' => 'green'
        ]
    ];

    protected $listeners = ['refreshInsight' => '$refresh'];

    public function mount()
    {
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadData();
    }

    // Add individual update methods for each filter
    public function updatedStartDate()
    {
        $this->loadData();
        $this->dispatch('filters-updated');
    }

    public function updatedEndDate()
    {
        $this->loadData();
        $this->dispatch('filters-updated');
    }

    public function updatedSelectedReportType()
    {
        $this->loadData();
        $this->dispatch('filters-updated');
    }

    public function updated($propertyName)
    {
        // Keep this as fallback for other properties
        if (in_array($propertyName, ['reportType'])) {
            $this->loadData();
            $this->dispatch('filters-updated');
        }
    }

    protected function loadData()
    {
        if ($this->selectedReportType === 'pelabuhan') {
            $query = \App\Models\Pelabuhan::query()
                ->whereDate('tanggal', '>=', $this->startDate)
                ->whereDate('tanggal', '<=', $this->endDate);

            // Get statistics
            $stats = $query->clone()->selectRaw('
                SUM(kapal_operasi) as total_kapal,
                SUM(penumpang) as total_penumpang,
                SUM(roda_2) as total_roda_2,
                (SUM(roda_4_penumpang) + SUM(roda_4_barang)) as total_roda_4
            ')->first();

            // Get passenger data by date and pelabuhan
            $passengerData = $query->clone()
                ->select(
                    'tanggal',
                    'pelabuhan',
                    \DB::raw('SUM(penumpang) as total_penumpang')
                )
                ->groupBy('tanggal', 'pelabuhan')
                ->orderBy('tanggal')
                ->get();

            // Get kapal_operasi data by pelabuhan
            $kapalOperasiData = $query->clone()
                ->select(
                    'pelabuhan',
                    \DB::raw('SUM(kapal_operasi) as total_kapal_operasi')
                )
                ->groupBy('pelabuhan')
                ->orderBy('pelabuhan')
                ->get();

            // Format data for the traffic chart
            $labels = $passengerData->pluck('tanggal')->unique()->sort()->values();
            $pelabuhans = $passengerData->pluck('pelabuhan')->unique()->sort()->values();

            $datasets = [];
            $colors = [
                'rgba(59, 130, 246, 0.8)',    // Blue
                'rgba(16, 185, 129, 0.8)',    // Green
                'rgba(249, 115, 22, 0.8)',    // Orange
                'rgba(139, 92, 246, 0.8)',    // Purple
                'rgba(236, 72, 153, 0.8)',    // Pink
                'rgba(20, 184, 166, 0.8)',    // Teal
                'rgba(245, 158, 11, 0.8)',    // Yellow
                'rgba(220, 38, 38, 0.8)'      // Red
            ];

            foreach ($pelabuhans as $index => $pelabuhan) {
                $data = [];
                foreach ($labels as $date) {
                    $data[] = $passengerData->where('tanggal', $date)
                        ->where('pelabuhan', $pelabuhan)
                        ->sum('total_penumpang');
                }
                
                $datasets[] = [
                    'label' => $pelabuhan,
                    'data' => $data,
                    'borderColor' => $colors[$index % count($colors)],
                    'backgroundColor' => str_replace('0.8', '0.1', $colors[$index % count($colors)]),
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'fill' => true
                ];
            }

            $this->trafficData = [
                'labels' => $labels->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))->toArray(),
                'datasets' => $datasets
            ];

            // Prepare data for kapal operasi chart
            $pelabuhanLabels = $kapalOperasiData->pluck('pelabuhan')->toArray();
            $kapalOperasiValues = $kapalOperasiData->pluck('total_kapal_operasi')->toArray();
            
            $this->transactionData = [
                'labels' => $pelabuhanLabels,
                'data' => $kapalOperasiValues,
                'colors' => array_slice([
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(20, 184, 166, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(220, 38, 38, 0.8)'
                ], 0, count($pelabuhanLabels)),
                'borderColors' => array_slice([
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(249, 115, 22)',
                    'rgb(139, 92, 246)',
                    'rgb(236, 72, 153)',
                    'rgb(20, 184, 166)',
                    'rgb(245, 158, 11)',
                    'rgb(220, 38, 38)'
                ], 0, count($pelabuhanLabels))
            ];

            $this->stats = [
                'total_kapal' => $stats->total_kapal ?? 0,
                'total_penumpang' => $stats->total_penumpang ?? 0,
                'total_roda_2' => $stats->total_roda_2 ?? 0,
                'total_roda_4' => $stats->total_roda_4 ?? 0,
                'visitor_change' => 0,
                'time_change' => 0,
                'transaction_change' => 0,
                'satisfaction_rate' => 0,
            ];
        } else {
            // Handle other report types
            // Add similar logic for terminal, laporan_harian_seksi, etc.
            $this->stats = [
                'total_kapal' => 0,
                'total_penumpang' => 0,
                'total_roda_2' => 0,
                'total_roda_4' => 0,
                'visitor_change' => 0,
                'time_change' => 0,
                'transaction_change' => 0,
                'satisfaction_rate' => 0,
            ];
            
            $this->trafficData = [
                'labels' => [],
                'datasets' => []
            ];
            
            $this->transactionData = [
                'labels' => [],
                'data' => [],
                'colors' => [],
                'borderColors' => []
            ];
        }
    }

    public function render()
    {
        return view('livewire.insight')
            ->layout('layouts.app');
    }
    
    public function refreshData()
    {
        $this->loadData();
        $this->dispatch('filters-updated');
        $this->emit('refreshInsight');
    }
}