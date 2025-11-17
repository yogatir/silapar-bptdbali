<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
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
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
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


