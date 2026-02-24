<x-app-layout>
    @extends('layouts.backoffice')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Municipios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                            <span class="font-medium">{{ session('status') }}</span>
                        </div>
                    @endif

                    {{-- Renderizar cada municipio como un card --}}
                    @each('components.card-municipalities', $municipalities, 'municipality')

                    {{-- Paginación --}}
                    {{ $municipalities->links() }}
                    
                    @if(session('success'))
                        <div style="color: green;">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>