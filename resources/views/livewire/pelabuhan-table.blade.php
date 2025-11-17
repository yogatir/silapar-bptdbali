<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Pelabuhan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kapal Operasi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Trip</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Penumpang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda 2</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda 4 / Lebih (Penumpang)</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Roda 4 / Lebih (Barang)</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Total Jumlah Kendaraan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
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
                        <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($records->total() > 0)
                <tfoot class="bg-gray-100 font-semibold">
                    <tr class="bg-gray-200">
                        <td colspan="2" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Jumlah</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['kapal_operasi'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['trip'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_2'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_4_penumpang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['roda_4_barang'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['total']['total_kendaraan'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td colspan="2" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Rata-Rata</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['kapal_operasi'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['trip'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['penumpang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_2'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_4_penumpang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['roda_4_barang'], 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 border border-gray-300 text-right">{{ number_format($statistics['average']['total_kendaraan'], 2, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-200">
                        <td colspan="2" class="px-4 py-3 text-sm text-gray-900 border border-gray-300 font-bold">Maximum</td>
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
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
