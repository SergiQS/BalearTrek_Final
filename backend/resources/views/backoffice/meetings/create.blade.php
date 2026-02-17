<x-app-layout>
@extends('layouts.backoffice')

@section('content')

    <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

        <h1 class="text-2xl font-semibold mb-6">Crear Meeting</h1>

        <form method="POST" action="{{ route('backoffice.meetings.store') }}">
            @csrf

            {{-- TREK --}}
            <div class="mb-4">
                <x-input-label for="trek_id" value="Trek" />
                <select id="trek_id" name="trek_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    <option value="">Selecciona un trek</option>

                    @foreach ($treks as $trek)
                        <option value="{{ $trek->id }}" {{ old('trek_id') == $trek->id ? 'selected' : '' }}>
                            {{ $trek->name }}
                        </option>
                    @endforeach

                </select>
                <x-input-error :messages="$errors->get('trek_id')" class="mt-2" />
            </div>

            {{-- FECHA INICIAL --}}
            <div class="mb-4">
                <x-input-label for="start_date" value="Fecha inicial" />
                <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                    value="{{ old('start_date') }}" />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>

            {{-- FECHA FINAL --}}
            <div class="mb-4">
                <x-input-label for="end_date" value="Fecha final" />
                <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                    value="{{ old('end_date') }}" />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>

            {{-- DÍA --}}
            <div class="mb-4">
                <x-input-label for="day" value="Día" />
                <x-text-input id="day" name="day" type="text" class="mt-1 block w-full" placeholder="Ej: 24/12/2024"
                    value="{{ old('day') }}" />
                <x-input-error :messages="$errors->get('day')" class="mt-2" />
            </div>

            {{-- HORA --}}
            <div class="mb-4">
                <x-input-label for="time" value="Hora" />
                <x-text-input id="time" name="time" type="time" class="mt-1 block w-full" value="{{ old('time') }}" />
                <x-input-error :messages="$errors->get('time')" class="mt-2" />
            </div>

            {{-- GUÍAS --}}
            <div class="mb-4">
                <x-input-label for="guides" value="Guías" />

                <select id="guides" name="guides" 
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    @foreach ($guias as $guia)
                        <option value="{{ $guia->id }}" {{$guia->id == old('guides') ? 'selected' : ''}}>
                            {{ $guia->name }} {{ $guia->lastName }}
                        </option>
                    @endforeach

                </select>

                <x-input-error :messages="$errors->get('guides')" class="mt-2" />
            </div>
            <x-input-error :messages="$errors->get('guides')" class="mt-2" />
            {{-- BOTÓN --}}
            <x-primary-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Meeting
            </x-primary-button>

        </form>
    </div>


    </div>
    </x-app-layout>
@endsection