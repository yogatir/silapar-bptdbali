<div class="p-8">
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Date Picker -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                <div class="relative">
                    <div class="relative">
                        <input 
                            type="date" 
                            wire:model.live="selectedDate"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition pr-10"
                            max="{{ now()->format('Y-m-d') }}"
                            placeholder="Pilih tanggal (kosongkan untuk semua data)"
                        >
                        @if($selectedDate)
                            <button 
                                type="button" 
                                wire:click="clearDate"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors"
                                title="Hapus filter tanggal"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    @error('selectedDate')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Report Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Laporan</label>
                <select 
                    wire:model.live="primaryFilter" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                    @foreach($primaryOptions as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>

            @if($this->showSecondaryFilter)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        @if($primaryFilter === 'pelabuhan')
                            Pelabuhan
                        @elseif($primaryFilter === 'terminal')
                            Terminal
                        @elseif($primaryFilter === 'laporan_harian_seksi')
                            Nama Seksi
                        @endif
                    </label>
                    <select wire:model.live="secondaryFilter" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @if($primaryFilter === 'pelabuhan')
                            <option value="">Semua Pelabuhan</option>
                            @php
                                $pelabuhanConfig = \App\Models\Pelabuhan::getPelabuhanConfig();
                            @endphp
                            @foreach($pelabuhanConfig as $key => $config)
                                <option value="{{ $key }}">{{ $config['nama'] }}</option>
                            @endforeach
                        @elseif($primaryFilter === 'terminal')
                            <option value="">Semua Terminal</option>
                            @php
                                $terminalOptions = \App\Models\TerminalReport::getTerminalOptions();
                            @endphp
                            @foreach($terminalOptions as $terminal)
                                <option value="{{ $terminal['value'] }}">{{ $terminal['label'] }}</option>
                            @endforeach
                        @elseif($primaryFilter === 'laporan_harian_seksi')
                            <option value="">Semua Seksi</option>
                            @php
                                $seksiOptions = \App\Models\LaporanHarianSeksi::getNamaSeksiOptions();
                            @endphp
                            @foreach($seksiOptions as $seksi)
                                <option value="{{ $seksi['value'] }}">{{ $seksi['label'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
        @switch($primaryFilter)
            @case('terminal')
                @livewire('terminal-table', [
    'filterTerminal' => $secondaryFilter,
    'selectedDate' => $selectedDate
], key('terminal-table-' . $secondaryFilter))
                @break

            @case('pelabuhan')
                <div>
                    @livewire('pelabuhan-table', [
                        'filterPelabuhan' => $secondaryFilter,
                        'selectedDate' => $selectedDate
                    ], key('pelabuhan-table-' . $secondaryFilter . '-' . ($selectedDate ?? 'all')))
                </div>
                @break

            @case('laporan_harian_seksi')
                @livewire('laporan-harian-seksi-table', [
    'filterNamaSeksi' => $secondaryFilter,
    'selectedDate' => $selectedDate
], key('laporan-harian-seksi-table-' . $secondaryFilter))
                @break

            @case('laporan_operasional_harian')
                @livewire('laporan-operasional-harian-table', [
    'selectedDate' => $selectedDate
], key('laporan-operasional-harian-table'))
                @break

            @default
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">Pilih jenis laporan untuk melihat data.</p>
                </div>
        @endswitch
    </div>
</div>


