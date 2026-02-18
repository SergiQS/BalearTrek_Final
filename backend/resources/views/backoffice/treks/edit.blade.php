 <x-app-layout>

@extends('layouts.backoffice')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

    <h1 class="text-2xl font-semibold mb-6">Editar Trek</h1>

    <form method="POST" action="{{ route('backoffice.treks.update', $trek   ) }}">
        @csrf
        @method('PUT')

        {{-- Número de Registro --}}
        <div class="mb-4">
            <x-input-label for="regNumber" value="Número de Registro" />
            <x-text-input id="regNumber" name="regNumber" type="text"
                class="mt-1 block w-full"
                value="{{ old('regNumber', $trek->regNumber) }}" />
            <x-input-error :messages="$errors->get('regNumber')" class="mt-2" />
        </div>

        {{-- Nombre --}}
        <div class="mb-4">
            <x-input-label for="name" value="Nombre" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                value="{{ old('name', $trek->name) }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Municipio --}}
        <div class="mb-4">
            <x-input-label for="municipality_id" value="Municipio" />
            <select id="municipality_id" name="municipality_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                @foreach ($municipalities as $municipality)
                    <option value="{{ $municipality->id }}"
                        {{ $trek->municipality_id == $municipality->id ? 'selected' : '' }}>
                        {{ $municipality->name }}
                    </option>
                @endforeach

            </select>
            <x-input-error :messages="$errors->get('municipality_id')" class="mt-2" />
        </div>

        {{-- Lugares de interés --}}
        <div class="mb-4">
            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach ($interestingPlaces as $place)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                            name="interesting_places[]"
                            value="{{ $place->id }}"
                            {{ $trek->interestingPlaces->contains($place->id) ? 'checked' : '' }}>
                        {{ $place->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botón --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Actualizar 
        </button>

    </form>
</div>
 </x-app-layout>
 @endsection