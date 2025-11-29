<div class="p-8">
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Laporan</label>
                <select wire:model.live="primaryFilter" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
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
                @livewire('terminal-table', ['filterTerminal' => $secondaryFilter], key('terminal-table-' . $secondaryFilter))
                @break

            @case('pelabuhan')
                @livewire('pelabuhan-table', ['filterPelabuhan' => $secondaryFilter], key('pelabuhan-table-' . $secondaryFilter))
                @break

            @case('laporan_harian_seksi')
                @livewire('laporan-harian-seksi-table', ['filterNamaSeksi' => $secondaryFilter], key('laporan-harian-seksi-table-' . $secondaryFilter))
                @break

            @case('laporan_operasional_harian')
                @livewire('laporan-operasional-harian-table', key('laporan-operasional-harian-table'))
                @break

            @default
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">Pilih jenis laporan untuk melihat data.</p>
                </div>
        @endswitch
    </div>
</div>


