<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Data Terminal') }}
            </h2>
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @livewire('terminal-form', ['recordId' => $terminal->id], key('terminal-form-edit-'.$terminal->id))
            </div>
        </div>
    </div>
</x-app-layout>
