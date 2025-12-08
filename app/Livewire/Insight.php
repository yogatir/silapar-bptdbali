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

    public function updated($propertyName)
    {
        // Log what property was updated
        \Log::info('Livewire property updated', [
            'property' => $propertyName,
            'value' => $this->$propertyName ?? 'null',
            'selectedReportType' => $this->selectedReportType
        ]);
        
        // Only reload data if one of the filter properties changed
        if (in_array($propertyName, ['startDate', 'endDate', 'selectedReportType', 'reportType'])) {
            $this->loadData();
            // Dispatch event to refresh charts
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
        } elseif ($this->selectedReportType === 'terminal') {
            // Handle Terminal report type
            $query = \App\Models\TerminalReport::query()
                ->whereDate('tanggal', '>=', $this->startDate)
                ->whereDate('tanggal', '<=', $this->endDate);

            // Get statistics
            $stats = $query->clone()->selectRaw('
                SUM(kedatangan_armada) as total_kedatangan_armada,
                SUM(kedatangan_penumpang) as total_kedatangan_penumpang,
                SUM(keberangkatan_armada) as total_keberangkatan_armada,
                SUM(keberangkatan_penumpang) as total_keberangkatan_penumpang
            ')->first();

            // Get data by date and terminal
            $terminalData = $query->clone()
                ->select(
                    'tanggal',
                    'terminal',
                    \DB::raw('SUM(kedatangan_armada) as total_kedatangan_armada'),
                    \DB::raw('SUM(kedatangan_penumpang) as total_kedatangan_penumpang'),
                    \DB::raw('SUM(keberangkatan_armada) as total_keberangkatan_armada'),
                    \DB::raw('SUM(keberangkatan_penumpang) as total_keberangkatan_penumpang')
                )
                ->groupBy('tanggal', 'terminal')
                ->orderBy('tanggal')
                ->get();

            // Format data for the traffic chart (LEFT CHART - Total Penumpang by Date)
            $labels = $terminalData->pluck('tanggal')->unique()->sort()->values();

            // Calculate total passengers (kedatangan + keberangkatan) by date
            $totalPassengersByDate = [];
            foreach ($labels as $date) {
                $total = $terminalData->where('tanggal', $date)
                    ->sum(function($item) {
                        return $item->total_kedatangan_penumpang + $item->total_keberangkatan_penumpang;
                    });
                $totalPassengersByDate[] = $total;
            }

            $this->trafficData = [
                'labels' => $labels->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))->toArray(),
                'datasets' => [
                    [
                        'label' => 'Total Penumpang',
                        'data' => $totalPassengersByDate,
                        'borderColor' => 'rgb(59, 130, 246)',
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'borderWidth' => 3,
                        'tension' => 0.4,
                        'fill' => true,
                        'pointRadius' => 4,
                        'pointBackgroundColor' => 'rgb(59, 130, 246)',
                        'pointBorderColor' => '#fff',
                        'pointBorderWidth' => 2
                    ]
                ]
            ];

            // Prepare data for RIGHT CHART - Total Armada by Terminal (Doughnut)
            $terminals = $terminalData->pluck('terminal')->unique()->sort()->values();
            $terminalArmadaTotals = [];
            
            foreach ($terminals as $terminal) {
                $totalArmada = $terminalData->where('terminal', $terminal)
                    ->sum(function($item) {
                        return $item->total_kedatangan_armada + $item->total_keberangkatan_armada;
                    });
                $terminalArmadaTotals[] = $totalArmada;
            }
            
            // Debug logging
            \Log::info('Terminal Chart Data', [
                'terminals' => $terminals->toArray(),
                'armada_totals' => $terminalArmadaTotals,
                'terminal_data_count' => $terminalData->count()
            ]);

            $colors = [
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(249, 115, 22, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(20, 184, 166, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(220, 38, 38, 0.8)'
            ];

            $terminalColors = array_slice($colors, 0, count($terminals));
            $terminalBorderColors = array_map(
                function($color) {
                    return str_replace('0.8', '1', $color);
                },
                $terminalColors
            );

            $this->transactionData = [
                'labels' => $terminals->toArray(),
                'data' => $terminalArmadaTotals,
                'colors' => $terminalColors,
                'borderColors' => $terminalBorderColors
            ];

            $this->stats = [
                'total_kapal' => ($stats->total_kedatangan_armada ?? 0) + ($stats->total_keberangkatan_armada ?? 0),
                'total_penumpang' => ($stats->total_kedatangan_penumpang ?? 0) + ($stats->total_keberangkatan_penumpang ?? 0),
                'total_roda_2' => 0,
                'total_roda_4' => 0,
                'total_kedatangan_armada' => $stats->total_kedatangan_armada ?? 0,
                'total_kedatangan_penumpang' => $stats->total_kedatangan_penumpang ?? 0,
                'total_keberangkatan_armada' => $stats->total_keberangkatan_armada ?? 0,
                'total_keberangkatan_penumpang' => $stats->total_keberangkatan_penumpang ?? 0,
                'visitor_change' => 0,
                'time_change' => 0,
                'transaction_change' => 0,
                'satisfaction_rate' => 0,
            ];
        } elseif ($this->selectedReportType === 'laporan_operasional_harian') {
            // Handle Laporan Operasional Harian
            $query = \App\Models\LaporanOperasionalHarian::query()
                ->whereDate('tanggal', '>=', $this->startDate)
                ->whereDate('tanggal', '<=', $this->endDate);

            // Get statistics
            $stats = $query->clone()->selectRaw('
                SUM(jumlah_diperiksa) as total_diperiksa,
                SUM(jumlah_melanggar) as total_melanggar,
                SUM(jumlah_tidak_melanggar) as total_tidak_melanggar,
                SUM(pelanggaran_daya_angkut) as total_daya_angkut
            ')->first();

            // Get data by date
            $dailyData = $query->clone()
                ->select(
                    'tanggal',
                    \DB::raw('SUM(jumlah_diperiksa) as total_diperiksa'),
                    \DB::raw('SUM(jumlah_melanggar) as total_melanggar'),
                    \DB::raw('SUM(jumlah_tidak_melanggar) as total_tidak_melanggar')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // Format data for the traffic chart
            $labels = $dailyData->pluck('tanggal')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))->toArray();
            
            $this->trafficData = [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Total Diperiksa',
                        'data' => $dailyData->pluck('total_diperiksa')->toArray(),
                        'borderColor' => 'rgb(59, 130, 246)',
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'borderWidth' => 2,
                        'tension' => 0.3
                    ],
                    [
                        'label' => 'Total Melanggar',
                        'data' => $dailyData->pluck('total_melanggar')->toArray(),
                        'borderColor' => 'rgb(239, 68, 68)',
                        'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                        'borderWidth' => 2,
                        'tension' => 0.3
                    ]
                ]
            ];

            // Prepare data for the donut chart
            $violationData = [
                $stats->total_melanggar ?? 0,
                $stats->total_tidak_melanggar ?? 0
            ];
            
            $this->transactionData = [
                'labels' => ['Melanggar', 'Tidak Melanggar'],
                'data' => $violationData,
                'colors' => [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                'borderColors' => [
                    'rgb(239, 68, 68)',
                    'rgb(16, 185, 129)'
                ]
            ];

            $this->stats = [
                'total_diperiksa' => $stats->total_diperiksa ?? 0,
                'total_melanggar' => $stats->total_melanggar ?? 0,
                'total_tidak_melanggar' => $stats->total_tidak_melanggar ?? 0,
                'total_daya_angkut' => $stats->total_daya_angkut ?? 0,
                'total_kapal' => 0,
                'total_penumpang' => 0,
                'total_roda_2' => 0,
                'total_roda_4' => 0,
                'visitor_change' => 0,
                'time_change' => 0,
                'transaction_change' => 0,
                'satisfaction_rate' => 0,
            ];
        } else {
            // Handle other report types
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
    
    public function resetFilters()
    {
        $this->selectedReportType = 'pelabuhan';
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadData();
        $this->dispatch('filters-updated');
    }
    
    public function refreshData()
    {
        $this->loadData();
        $this->dispatch('filters-updated');
    }
}