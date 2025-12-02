<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr class="bg-gray-50">
                    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Aksi</th>
                    @endif
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No ST</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Nama Seksi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Petugas</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kegiatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Dokumentasi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Hasil Kegiatan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
                        @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::ADMIN)
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('laporan-harian-seksi.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                
                                <button 
                                    wire:click="delete({{ $record->id }})" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                    class="text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        @endif
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                            {{ ($records->firstItem() ?? 0) + $loop->index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ optional($record->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ $record->no_st }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ $record->nama_seksi }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300">
                            @if(is_array($record->petugas))
                                <ul class="list-disc list-inside space-y-0.5">
                                    @foreach($record->petugas as $petugas)
                                        <li>{{ $petugas }}</li>
                                    @endforeach
                                </ul>
                            @else
                                {{ $record->petugas }}
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300">
                            {{ $record->kegiatan ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-blue-600 border border-gray-300">
                            @if($record->dokumentasi_link)
                                <a href="{{ $record->dokumentasi_link }}" target="_blank" class="hover:underline">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-blue-600 border border-gray-300">
                            @if($record->hasil_kegiatan_link)
                                <a href="{{ $record->hasil_kegiatan_link }}" target="_blank" class="hover:underline">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>


