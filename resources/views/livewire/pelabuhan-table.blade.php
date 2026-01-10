<div class="p-6">
    <div class="overflow-x-auto">
        @if($filterPelabuhan === 'sampalan')
            {{-- Sampalan Specific Table --}}
            <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Aksi</th>
                        @endif
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Sandar</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Tolak</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Nama Kapal</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Dermaga I</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">II</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">III</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">IV</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Penumpang Turun</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Penumpang Naik</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Trip Datang</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Trip Berangkat</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kegiatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                        @php
                            $dermaga = $record->dermaga ?? [];
                            $kapalItems = [];
                            
                            // Collect all kapal from all dermaga
                            foreach ($dermaga as $dermagaItem) {
                                if (isset($dermagaItem['kapal']) && is_array($dermagaItem['kapal'])) {
                                    foreach ($dermagaItem['kapal'] as $kapal) {
                                        $kapalItems[] = [
                                            'dermaga' => $dermagaItem['nama'] ?? '',
                                            'kapal' => $kapal
                                        ];
                                    }
                                }
                            }
                            
                            $rowCount = max(1, count($kapalItems));
                        @endphp
                        
                        @if(count($kapalItems) > 0)
                            @foreach($kapalItems as $index => $item)
                                <tr class="hover:bg-gray-50">
                                    @if($index === 0)
                                        @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                        <td rowspan="{{ $rowCount }}" class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center align-top">
                                            <div class="flex justify-center space-x-1">
                                                <a href="{{ route('pelabuhan.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <button 
                                                    wire:click="delete({{ $record->id }})" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                    class="text-red-600 hover:text-red-900" 
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        @endif
                                        <td rowspan="{{ $rowCount }}" class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center align-top">
                                            {{ ($records->firstItem() ?? 0) + $loop->parent->index }}
                                        </td>
                                    @endif
                                    
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['kapal']['jam_sandar'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['kapal']['jam_tolak'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                        {{ $item['kapal']['nama_kapal'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['dermaga'] === 'Dermaga 1' ? '1' : '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['dermaga'] === 'Dermaga 2' ? '1' : '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['dermaga'] === 'Dermaga 3' ? '1' : '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        {{ $item['dermaga'] === 'Dermaga 4' ? '1' : '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                                        {{ number_format($item['kapal']['penumpang_turun'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                                        {{ number_format($item['kapal']['penumpang_naik'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                                        {{ number_format($item['kapal']['trip_datang'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                                        {{ number_format($item['kapal']['trip_berangkat'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                        @if(isset($item['kapal']['kegiatan']))
                                            @if($item['kapal']['kegiatan'] === 'Bongkar')
                                                B
                                            @elseif($item['kapal']['kegiatan'] === 'Muat')
                                                M
                                            @elseif($item['kapal']['kegiatan'] === 'Bongkar Muat')
                                                BM
                                            @else
                                                {{ $item['kapal']['kegiatan'] }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="hover:bg-gray-50">
                                @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                                <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                    <div class="flex justify-center space-x-1">
                                        <a href="{{ route('pelabuhan.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <button 
                                            wire:click="delete({{ $record->id }})" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                            class="text-red-600 hover:text-red-900" 
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                @endif
                                <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                                    {{ ($records->firstItem() ?? 0) + $loop->index }}
                                </td>
                                <td colspan="12" class="px-4 py-3 text-center text-sm text-gray-500 border border-gray-300">
                                    Tidak ada data kapal
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="14" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            {{-- Standard Table for other Pelabuhan --}}
            <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Aksi</th>
                    @endif
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Pelabuhan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kapal Operasi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Trip</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Penumpang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda&nbsp;2</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda 4 / Lebih (Penumpang)</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda 4 / Lebih (Barang)</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Total Jumlah Kendaraan</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-gray-50">
                        @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                            <div class="flex justify-center space-x-1">
                                <a href="{{ route('pelabuhan.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>

                                <button 
                                    wire:click="delete({{ $record->id }})" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                    class="text-red-600 hover:text-red-900" 
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        @endif
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                            {{ ($records->firstItem() ?? 0) + $loop->index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ $record->tanggal->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ $record->pelabuhan_name }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->kapal_operasi, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->trip, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->penumpang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->roda_2, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->roda_4_penumpang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->roda_4_barang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->roda_2 + $record->roda_4_penumpang + $record->roda_4_barang, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($records->total() > 0)
                <tfoot class="bg-gray-100 font-semibold">
                    <tr class="bg-gray-200">
                        <td colspan="4" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Jumlah</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['kapal_operasi'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['trip'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_2'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_4_penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_4_barang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['total_kendaraan'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td colspan="4" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Rata-Rata</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['kapal_operasi'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['trip'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['penumpang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_2'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_4_penumpang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_4_barang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['total_kendaraan'], 2, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-200">
                        <td colspan="4" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Maximum</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['kapal_operasi'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['trip'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['roda_2'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['roda_4_penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['roda_4_barang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['maximum']['total_kendaraan'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            @endif
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
