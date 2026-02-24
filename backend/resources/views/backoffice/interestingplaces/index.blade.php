<x-app-layout>
    @extends('layouts.backoffice')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Lugares Interesantes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">




                    @each('components.card-interestingplaces', $interestingplaces, 'interestingplace')

                    {{-- Paginación --}}
                    {{ $interestingplaces->links() }}
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