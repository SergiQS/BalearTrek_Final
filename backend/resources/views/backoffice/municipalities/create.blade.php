<x-app-layout>@extends('layouts.backoffice')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

    <h1 class="text-2xl font-semibold mb-6">Crear municipio</h1>

    <form method="POST" action="{{ route('backoffice.municipalities.store') }}">
        @csrf

        {{-- Nombre --}}
        <div class="mb-4">
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                value="{{ old('name') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Isla --}}
        <div class="mb-4">
            <x-input-label for="island_id" value="Isla" />
            <select id="island_id" name="island_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                <option value="">Selecciona una isla</option>

                @foreach ($islands as $island)
                    <option value="{{ $island->id }}"
                        {{ old('island_id') == $island->id ? 'selected' : '' }}>
                        {{ $island->name }}
                    </option>
                @endforeach

            </select>
            <x-input-error :messages="$errors->get('island_id')" class="mt-2" />
        </div>

        {{-- Zona --}}
        <div class="mb-4">
            <x-input-label for="zone_id" value="Zona" />
            <select id="zone_id" name="zone_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                <option value="">Selecciona una zona</option>

                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}"
                        {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->name }}
                    </option>
                @endforeach

            </select>
            <x-input-error :messages="$errors->get('zone_id')" class="mt-2" />
        </div>

        {{-- Botones --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('backoffice.municipalities.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md 
                      font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                Cancelar
            </a>

            <x-primary-button>
                Crear municipio
            </x-primary-button>
        </div>

    </form>
</div>
</x-app-layout>
@endsection