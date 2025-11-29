<x-app-layout>
    <x-slot name="header">
        <div class="relative bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700 text-white py-8">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/graphy.png')] opacity-10"></div>
            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <p class="text-sm uppercase tracking-[0.3em] text-blue-200">Sistem Informasi</p>
                <h2 class="mt-2 text-3xl font-bold">{{ __('Dashboard') }}</h2>
                <p class="mt-2 text-blue-100">Pantau dan kelola data operasional transportasi darat</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                @livewire('dashboard-table-switcher')
            </div>
        </div>
    </div>
</x-app-layout>
