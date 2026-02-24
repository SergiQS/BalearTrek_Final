<x-app-layout>@extends('layouts.backoffice')
      @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

    @section('content')
            <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold mb-6">Crear municipio</h1>

                <form method="POST" action="{{ route('backoffice.municipalities.store') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" />
                        @error('name')
                            <div style="color: red;">{{ $message }}</div>   
                        @enderror
                    </div>

                    {{-- Isla --}}
                    <div class="mb-4">
                        <label for="island_id">Isla</label>
                        <select id="island_id" name="island_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="">Selecciona una isla</option>

                            @foreach ($islands as $island)
                                <option value="{{ $island->id }}" {{ old('island_id') == $island->id ? 'selected' : '' }}>
                                    {{ $island->name }}
                                </option>
                            @endforeach

                        </select>
                     
                    </div>

                    {{-- Zona --}}
                    <div class="mb-4">
                        <label for="zone_id">Zona</label>
                        <select id="zone_id" name="zone_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="">Selecciona una zona</option>

                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach

                        </select>
                       
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-between mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Crear
                        </button>
                    </div>

                </form>
            </div>
        </x-app-layout>
    @endsection