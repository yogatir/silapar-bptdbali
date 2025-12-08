<div>
    <x-slot name="header">
        <div class="relative bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700 text-white py-8">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/graphy.png')] opacity-10"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <p class="text-sm uppercase tracking-[0.3em] text-blue-200">Sistem Informasi</p>
                <h2 class="mt-2 text-3xl font-bold">{{ __('Insight BPTD Kelas II Bali') }}</h2>
                <p class="mt-2 text-blue-100">Analisis dan wawasan data operasional transportasi darat</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Filter Section with Debug -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <div class="relative">
                            <input type="date" 
                                id="startDate" 
                                wire:model.live="startDate" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                max="{{ $endDate }}">
                        </div>
                    </div>
                    
                    <!-- End Date -->
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <div class="relative">
                            <input type="date" 
                                id="endDate" 
                                wire:model.live="endDate" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                min="{{ $startDate }}"
                                max="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <!-- Report Type - CRITICAL: Check wire:model matches property name -->
                    <div>
                        <label for="selectedReportType" class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                        <select wire:model.live="selectedReportType"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="pelabuhan">Laporan Pelabuhan</option>
                            <option value="terminal">Laporan Terminal</option>
                            <option value="laporan_harian_seksi">Laporan Harian Seksi</option>
                            <option value="laporan_operasional_harian">Laporan UPPKB</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                        </p>
                    </div>
                    
                    <!-- Reset Button -->
                    <div class="flex items-end">
                        <button type="button" 
                                wire:click="resetFilters"
                                class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @if($selectedReportType === 'terminal')
                    <!-- Total Armada -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_kapal']) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Armada</h3>
                                <p class="text-xs text-gray-400">(Kedatangan + Keberangkatan)</p>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-blue-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v1a1 1 0 001 1h1.5l1.5 7.5h8l1.5-7.5H17a1 1 0 001-1V5a1 1 0 00-1-1h-3.5a1 1 0 01-.9-.6L11 2.2a1 1 0 00-1.8 0L8.4 3.4a1 1 0 01-.9.6H3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Penumpang -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_penumpang']) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Penumpang</h3>
                                <p class="text-xs text-gray-400">(Kedatangan + Keberangkatan)</p>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Kedatangan -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_kedatangan_penumpang'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Kedatangan</h3>
                                <p class="text-xs text-gray-400">{{ number_format($stats['total_kedatangan_armada'] ?? 0) }} armada</p>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-purple-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Keberangkatan -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_keberangkatan_penumpang'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Keberangkatan</h3>
                                <p class="text-xs text-gray-400">{{ number_format($stats['total_keberangkatan_armada'] ?? 0) }} armada</p>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-orange-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @else
                    @if($selectedReportType === 'pelabuhan')
                    <!-- Total Kapal Operasi -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_kapal']) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Kapal Operasi</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 01-1-1v-5a1 1 0 011-1h1a1 1 0 01.7.3l1.7 1.7 3.3-3.3a1 1 0 011.4 0l3.3 3.3 1.7-1.7a1 1 0 01.7-.3h1a1 1 0 011 1v5a1 1 0 01-1 1H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Penumpang -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_penumpang']) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Penumpang</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Roda 2 -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_roda_2']) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Roda 2</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Roda 4 -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_roda_4'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Roda 4</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v1a1 1 0 001 1h1.5l1.5 7.5h8l1.5-7.5H17a1 1 0 001-1V5a1 1 0 00-1-1h-3.5a1 1 0 01-.9-.6L11 2.2a1 1 0 00-1.8 0L8.4 3.4a1 1 0 01-.9.6H3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($selectedReportType === 'laporan_operasional_harian')
                    <!-- Total Diperiksa -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_diperiksa'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Diperiksa</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-blue-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Daya Angkut -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_daya_angkut'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Daya Angkut</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v1a1 1 0 001 1h1.5l1.5 7.5h8l1.5-7.5H17a1 1 0 001-1V5a1 1 0 00-1-1h-3.5a1 1 0 01-.9-.6L11 2.2a1 1 0 00-1.8 0L8.4 3.4a1 1 0 01-.9.6H3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Melanggar -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_melanggar'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Melanggar</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-red-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Tidak Melanggar -->
                    <div class="p-5 bg-white rounded-lg shadow border border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ number_format($stats['total_tidak_melanggar'] ?? 0) }}</span>
                                <h3 class="text-base font-normal text-gray-500">Total Tidak Melanggar</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Traffic Chart - Fixed Version -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100" 
                    x-data="{ 
                        chart: null,
                        initChart() {
                            const canvas = this.$refs.trafficCanvas;
                            if (!canvas) return;
                            
                            // Destroy existing chart
                            if (this.chart) {
                                this.chart.destroy();
                            }
                            
                            // Get fresh data from Livewire
                            const trafficData = @this.trafficData;
                            
                            this.chart = new Chart(canvas, {
                                type: 'line',
                                data: {
                                    labels: trafficData.labels || [],
                                    datasets: trafficData.datasets || []
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false,
                                            callbacks: {
                                                label: function(context) {
                                                    let label = context.dataset.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    if (context.parsed.y !== null) {
                                                        label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                                    }
                                                    return label;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.05)'
                                            },
                                            ticks: {
                                                callback: function(value) {
                                                    return new Intl.NumberFormat('id-ID').format(value);
                                                }
                                            }
                                        },
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            });
                            
                            console.log('Traffic chart updated');
                        }
                    }"
                    x-init="$nextTick(() => initChart())"
                    @filters-updated.window="$nextTick(() => initChart())"
                    wire:key="traffic-chart-{{ $selectedReportType }}">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Trafik Penumpang</h3>
                        <div style="position: relative; height: 400px; width: 100%;">
                            <canvas x-ref="trafficCanvas"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Transaction Chart - Fixed Version -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100"
                    x-data="{
                        chart: null,
                        initChart() {
                            const canvas = this.$refs.transactionCanvas;
                            if (!canvas) return;
                            
                            // Destroy existing chart
                            if (this.chart) {
                                this.chart.destroy();
                            }
                            
                            // Get fresh data from Livewire
                            const transactionData = @this.transactionData;
                            
                            this.chart = new Chart(canvas, {
                                type: 'doughnut',
                                data: {
                                    labels: transactionData.labels || [],
                                    datasets: [{
                                        data: transactionData.data || [],
                                        backgroundColor: transactionData.colors || [],
                                        borderColor: transactionData.borderColors || [],
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'bottom',
                                            labels: {
                                                padding: 15,
                                                font: {
                                                    size: 12
                                                }
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    let label = context.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    label += new Intl.NumberFormat('id-ID').format(context.parsed);
                                                    
                                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                                    label += ` (${percentage}%)`;
                                                    
                                                    return label;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                            
                            console.log('Transaction chart updated');
                        }
                    }"
                    x-init="$nextTick(() => initChart())"
                    @filters-updated.window="$nextTick(() => initChart())"
                    wire:key="transaction-chart-{{ $selectedReportType }}">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            @if($selectedReportType === 'terminal')
                                Total Armada
                            @else
                                Kapal Operasi
                            @endif
                        </h3>
                        
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas x-ref="transactionCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>