<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Word Editor Online') }}
            </h2>
            <a href="{{ route('graph.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <iframe 
                    src="{{ $embedUrl }}" 
                    width="100%" 
                    style="height: 80vh;" 
                    frameborder="0" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>