<div class="p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th rowspan="2" class="px-4 py-3 text-center font-semibold border border-gray-300">No</th>
                    <th rowspan="2" class="px-4 py-3 text-center font-semibold border border-gray-300">Waktu (Tanggal)</th>
                    <th colspan="4" class="px-4 py-3 text-center font-semibold border border-gray-300">Jumlah Kendaraan</th>
                    <th colspan="5" class="px-4 py-3 text-center font-semibold border border-gray-300">Pelanggaran</th>
                    <th colspan="4" class="px-4 py-3 text-center font-semibold border border-gray-300 bg-green-200">Penindakan</th>
                </tr>
                <tr class="bg-gray-100 text-gray-600">
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Diperiksa</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Melanggar</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Tidak Melanggar</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Daya Angkut</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Dimensi</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Persyaratan Teknis</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Dokumen</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Tata Cara Muat</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300">Kelas Jalan</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300 bg-green-100">Peringatan</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300 bg-green-100">Tilang</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300 bg-green-100">Kepolisian</th>
                    <th class="px-4 py-2 text-center font-medium border border-gray-300 bg-green-100">Tilang Lainnya</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ ($records->firstItem() ?? 0) + $loop->index }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200 whitespace-nowrap">
                            {{ optional($record->tanggal)->format('d-M-Y') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->jumlah_diperiksa, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->jumlah_melanggar, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->jumlah_tidak_melanggar, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_daya_angkut, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_dimensi, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_teknis, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_dokumen, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_tcm, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->pelanggaran_kelas_jalan ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->tindakan_peringatan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->tindakan_tilang, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format($record->tindakan_serah_polisi, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center border border-gray-200">
                            {{ number_format(
                                ($record->tindakan_surat_tilang ?? 0)
                                + ($record->tindakan_proses_etilang ?? 0)
                                + ($record->tindakan_transfer_muatan ?? 0),
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="px-4 py-8 text-center text-sm text-gray-500 border border-gray-300">
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

