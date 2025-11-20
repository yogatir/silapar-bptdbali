<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Waktu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Terminal</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kedatangan Armada</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Kedatangan Penumpang</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Keberangkatan Armada</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Keberangkatan Penumpang</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-center">
                            {{ ($records->firstItem() ?? 0) + $loop->index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ optional($record->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ \Illuminate\Support\Str::of($record->waktu)->substr(0, 5) }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                            {{ $record->terminal }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->kedatangan_armada, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->kedatangan_penumpang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->keberangkatan_armada, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 border border-gray-300 text-right">
                            {{ number_format($record->keberangkatan_penumpang, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
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


