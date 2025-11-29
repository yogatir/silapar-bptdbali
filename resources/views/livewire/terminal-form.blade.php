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
                <input
                    type="time"
                    wire:model="waktu"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                @error('waktu') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Terminal</label>
            <select wire:model="terminal" class="w-full border rounded p-2">
                <option value="">-- Pilih Terminal --</option>
                @foreach($terminalOptions as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </select>
            @error('terminal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Kedatangan Armada</label>
                <input
                    type="number"
                    min="0"
                    step="1"
                    wire:model.lazy="kedatangan_armada"
                    class="w-full border rounded p-2"
                >
                @error('kedatangan_armada') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Kedatangan Penumpang</label>
                <input
                    type="number"
                    min="0"
                    step="1"
                    wire:model.lazy="kedatangan_penumpang"
                    class="w-full border rounded p-2"
                >
                @error('kedatangan_penumpang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Keberangkatan Armada</label>
                <input
                    type="number"
                    min="0"
                    step="1"
                    wire:model.lazy="keberangkatan_armada"
                    class="w-full border rounded p-2"
                >
                @error('keberangkatan_armada') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Keberangkatan Penumpang</label>
                <input
                    type="number"
                    min="0"
                    step="1"
                    wire:model.lazy="keberangkatan_penumpang"
                    class="w-full border rounded p-2"
                >
                @error('keberangkatan_penumpang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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


