<div class="p-8">
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg">
            <p class="font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">No ST</label>
                <input
                    type="text"
                    wire:model.lazy="noSt"
                    @if($isEditing) readonly @endif
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @if($isEditing) bg-gray-100 @endif"
                >
                @error('noSt') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
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
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Seksi</label>
                <select
                    wire:model="namaSeksi"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                    <option value="">-- Pilih Seksi --</option>
                    @foreach($seksiOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @error('namaSeksi') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label class="block text-sm font-medium">Petugas</label>
                <button
                    type="button"
                    wire:click="addPetugas"
                    class="text-blue-600 text-sm font-medium hover:underline"
                >
                    + Tambah Petugas
                </button>
            </div>
            <div class="mt-3 space-y-3">
                @foreach($petugas as $index => $nama)
                    <div class="flex items-center space-x-2">
                        <input
                            type="text"
                            wire:model.lazy="petugas.{{ $index }}"
                            placeholder="Nama petugas"
                            class="flex-1 border rounded p-2"
                        >
                        @if($index > 0)
                            <button
                                type="button"
                                wire:click="removePetugas({{ $index }})"
                                class="text-red-500 hover:text-red-700 px-2 py-1 rounded hover:bg-red-50"
                                aria-label="Hapus petugas"
                            >
                                &times;
                            </button>
                        @endif
                    </div>
                    @error("petugas.$index") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @endforeach
            </div>
            @error('petugas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Kegiatan</label>
            <textarea
                wire:model.lazy="kegiatan"
                rows="4"
                class="w-full border rounded p-2"
                placeholder="Deskripsi kegiatan"
            ></textarea>
            @error('kegiatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Dokumentasi (Link Google Drive)</label>
                <input
                    type="url"
                    wire:model.lazy="dokumentasiLink"
                    class="w-full border rounded p-2"
                    placeholder="https://drive.google.com/..."
                >
                @error('dokumentasiLink') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Hasil Kegiatan (Link Google Drive)</label>
                <input
                    type="url"
                    wire:model.lazy="hasilKegiatanLink"
                    class="w-full border rounded p-2"
                    placeholder="https://drive.google.com/..."
                >
                @error('hasilKegiatanLink') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

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


