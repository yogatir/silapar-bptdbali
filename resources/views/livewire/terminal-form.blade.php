<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Laporan Terminal</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tanggal</label>
                <input
                    type="date"
                    wire:model="tanggal"
                    class="w-full border rounded p-2"
                >
                @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Waktu</label>
                <input
                    type="time"
                    wire:model="waktu"
                    class="w-full border rounded p-2"
                >
                @error('waktu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

        <div class="pt-4">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
                Simpan Laporan
            </button>
        </div>
    </form>
</div>


