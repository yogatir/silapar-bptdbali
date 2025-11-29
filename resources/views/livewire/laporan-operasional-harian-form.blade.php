<div class="p-8">
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg">
            <p class="font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input
                    type="date"
                    wire:model="tanggal"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                @error('tanggal') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu</label>
                <input type="time" wire:model="waktu" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('waktu') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <section class="space-y-4">
            <h2 class="text-lg font-semibold">Data Kendaraan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    'jumlah_kendaraan_masuk' => 'Jumlah Kendaraan Masuk',
                    'jumlah_kendaraan_keluar' => 'Jumlah Kendaraan Keluar',
                    'manual_masuk' => 'Manual Masuk',
                    'jto_masuk' => 'JTO Masuk',
                    'manual_keluar' => 'Manual Keluar',
                    'jto_keluar' => 'JTO Keluar',
                    'jumlah_diperiksa' => 'Jumlah Diperiksa',
                    'jumlah_melanggar' => 'Jumlah Melanggar',
                    'jumlah_tidak_melanggar' => 'Jumlah Tidak Melanggar',
                ] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium">{{ $label }}</label>
                        <input
                            type="number"
                            min="0"
                            step="1"
                            wire:model.lazy="{{ $field }}"
                            class="w-full border rounded p-2"
                        >
                        @error($field) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-lg font-semibold">Hasil Operasional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    'pelanggaran_daya_angkut' => 'Pelanggaran Daya Angkut',
                    'pelanggaran_tcm' => 'Pelanggaran TCM',
                    'pelanggaran_dokumen' => 'Pelanggaran Dokumen',
                    'pelanggaran_dimensi' => 'Pelanggaran Dimensi',
                    'pelanggaran_teknis' => 'Pelanggaran Teknis',
                    'tindakan_peringatan' => 'Tindakan Peringatan',
                    'tindakan_tilang' => 'Tindakan Tilang',
                    'tindakan_transfer_muatan' => 'Tindakan Transfer Muatan',
                    'tindakan_putar_balik' => 'Tindakan Putar Balik',
                    'tindakan_tunda_berangkat' => 'Tindakan Tunda Berangkat',
                    'tindakan_surat_tilang' => 'Tindakan Surat Tilang',
                    'tindakan_serah_polisi' => 'Tindakan Serah Polisi',
                    'tindakan_proses_etilang' => 'Tindakan Proses e-Tilang',
                    'kecelakaan_lalu_lintas' => 'Kecelakaan Lalu Lintas',
                    'denda' => 'Denda (Rp)',
                ] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium">{{ $label }}</label>
                        <input
                            type="{{ $field === 'denda' ? 'number' : 'number' }}"
                            min="0"
                            step="{{ $field === 'denda' ? '0.01' : '1' }}"
                            wire:model.lazy="{{ $field }}"
                            class="w-full border rounded p-2"
                        >
                        @if($field === 'denda')
                            <p class="text-xs text-gray-500 mt-1">Denda maksimal Pasal 307 Jo. 169 (1)</p>
                        @endif
                        @error($field) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-lg font-semibold">Kondisi Operasional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach([
                    'jumlah_sdm' => 'Jumlah SDM',
                    'sdm_ppns' => 'SDM PPNS',
                    'sdm_danru' => 'SDM Danru',
                    'sdm_pkb' => 'SDM PKB',
                    'sdm_ppkb' => 'SDM PPKB',
                    'sdm_pelaporan_jto' => 'SDM Pelaporan JTO',
                    'sdm_petugas_lalin' => 'SDM Petugas Lalin',
                    'jumlah_responden_skm' => 'Jumlah Responden SKM',
                ] as $field => $label)
                    <div>
                        <label class="block text-sm font-medium">{{ $label }}</label>
                        <input
                            type="number"
                            min="0"
                            step="1"
                            wire:model.lazy="{{ $field }}"
                            class="w-full border rounded p-2"
                        >
                        @error($field) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endforeach
                <div>
                    <label class="block text-sm font-medium">Arus Lalu Lintas</label>
                    <input
                        type="text"
                        wire:model="arus_lalu_lintas"
                        class="w-full border rounded p-2"
                        placeholder="Contoh: Ramai Lancar"
                    >
                    @error('arus_lalu_lintas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Cuaca</label>
                    <input
                        type="text"
                        wire:model="cuaca"
                        class="w-full border rounded p-2"
                        placeholder="Contoh: Cerah"
                    >
                    @error('cuaca') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>

        <section class="space-y-4">
            <h2 class="text-lg font-semibold">Kendala &amp; Catatan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Kendala</label>
                    <textarea
                        wire:model.lazy="kendala"
                        rows="4"
                        class="w-full border rounded p-2"
                        placeholder="Tuliskan kendala yang dihadapi"
                    ></textarea>
                    @error('kendala') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Catatan</label>
                    <textarea
                        wire:model.lazy="catatan"
                        rows="4"
                        class="w-full border rounded p-2"
                        placeholder="Tuliskan catatan tambahan"
                    ></textarea>
                    @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </section>

        <div class="pt-6 border-t border-gray-200">
            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all"
            >
                Simpan Laporan
            </button>
        </div>
    </form>
</div>


