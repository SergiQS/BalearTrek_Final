<x-app-layout>
@extends('layouts.backoffice')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Islas') }}
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

                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('danger'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                            <span class="font-medium">{{ session('danger') }}</span>
                        </div>
                    @endif

                    @each('components.card-islands', $islands, 'island')

                    <div class="mt-6">
                        {{ $islands->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
