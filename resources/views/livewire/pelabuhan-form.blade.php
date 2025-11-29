<div class="p-8">
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg">
            <p class="font-medium">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Tanggal and Waktu in the same row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date" wire:model="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('tanggal') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu</label>
                <input type="time" wire:model="waktu" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('waktu') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pelabuhan</label>
            <select wire:model.live="pelabuhan" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Pilih Pelabuhan --</option>
                @foreach($this->pelabuhanList as $pel)
                    <option value="{{ $pel['value'] }}">{{ $pel['label'] }}</option>
                @endforeach
            </select>
            @error('pelabuhan') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        @if($pelabuhan && $currentPelabuhanConfig)


        {{-- Show numeric fields for all pelabuhan --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                <div>
                    <label class="block text-sm font-medium">Kapal Operasi</label>
                    <input type="text" 
                           wire:model="kapalOperasi" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('kapalOperasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Trip</label>
                    <input type="text" 
                           wire:model="trip" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('trip') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Penumpang</label>
                    <input type="text" 
                           wire:model="penumpang" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('penumpang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Roda 2</label>
                    <input type="text" 
                           wire:model="roda2" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('roda2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Roda 4 / Lebih (Penumpang)</label>
                    <input type="text" 
                           wire:model="roda4Penumpang" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('roda4Penumpang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium">Roda 4 / Lebih (Barang)</label>
                    <input type="text" 
                           wire:model="roda4Barang" 
                           class="w-full border rounded p-2 no-spinner" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           onkeydown="return (event.key >= '0' && event.key <= '9') || event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight' || event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'Tab' || event.key === 'Home' || event.key === 'End' || (event.ctrlKey && ['a', 'c', 'v', 'x'].includes(event.key.toLowerCase())) || event.metaKey"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onpaste="event.preventDefault(); const paste = (event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''); if(paste) { this.value = paste; this.dispatchEvent(new Event('input', { bubbles: true })); }">
                    @error('roda4Barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            
            {{-- Show dermaga form only if pelabuhan has dermaga configuration --}}
            @if(count($dermaga) > 0)
                <div class="mt-6 space-y-6">
                    <h2 class="text-lg font-semibold">Dermaga</h2>
                    @foreach($dermaga as $i => $dermagaItem)
                        <div class="border p-4 rounded">
                            <h3 class="font-semibold mb-2">{{ $dermagaItem['nama'] }}</h3>
                            @if(isset($dermagaItem['kapal']) && is_array($dermagaItem['kapal']))
                                @foreach($dermagaItem['kapal'] as $j => $kapal)
                                    <div class="flex items-center space-x-2 mb-2">
                                        <input type="text"
                                               wire:model="dermaga.{{ $i }}.kapal.{{ $j }}"
                                               placeholder="Nama Kapal"
                                               class="flex-1 border rounded p-2">
                                        <button type="button"
                                                wire:click="removeKapal({{ $i }}, {{ $j }})"
                                                class="text-red-500 hover:text-red-700 px-2 py-1 rounded hover:bg-red-50">&times;</button>
                                    </div>
                                @endforeach
                            @endif
                            <button type="button" 
                                    wire:click="addKapal({{ $i }})"
                                    class="text-blue-600 text-sm font-medium hover:underline mt-2">
                                + Tambah Kapal
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        @if($pelabuhan && $currentPelabuhanConfig)
            <div class="pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                    Simpan Data
                </button>
            </div>
        @endif
    </form>
</div>
