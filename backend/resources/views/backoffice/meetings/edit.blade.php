<x-app-layout>
@extends('layouts.backoffice')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Meeting: {{ $meeting->trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('backoffice.meetings.update', $meeting) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="block rounded-lg bg-white shadow-secondary-1">
                            <div class="p-6 text-surface">

                                <h5 class="mb-4 text-xl font-medium leading-tight">
                                    Editar datos del Meeting
                                </h5>

                                {{-- Trek --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Trek
                                    </label>
                                    <select name="trek_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                        @foreach ($treks as $trek)
                                            <option value="{{ $trek->id }}"
                                                {{ $meeting->trek_id == $trek->id ? 'selected' : '' }}>
                                                {{ $trek->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Fecha Inicial --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha Inicial
                                    </label>
                                    <input type="date" name="dateIni"
                                           value="{{ $meeting->dateIni }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>

                                {{-- Fecha Final --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha Final
                                    </label>
                                    <input type="date" name="dateEnd"
                                           value="{{ $meeting->dateEnd }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>

                                {{-- Guía Responsable --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Guía Responsable
                                    </label>
                                    <select name="user_id"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                        @foreach ($guias as $guia)
                                            <option value="{{ $guia->id }}"
                                                {{ $meeting->user_id == $guia->id ? 'selected' : '' }}>
                                                {{ $guia->name }} {{ $guia->lastName }}
                                            </option> 
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Guías Adicionales --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Guías Adicionales (mantén Ctrl para seleccionar múltiples)
                                    </label>
                                    <select name="guias_adicionales[]" multiple
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                                            style="min-height: 120px;">
                                        @foreach ($guias as $guia)
                                            <option value="{{ $guia->id }}"
                                                {{ $meeting->users->contains($guia->id) && $meeting->user_id != $guia->id ? 'selected' : '' }}>
                                                {{ $guia->name }} {{ $guia->lastName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Día --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Día
                                    </label>
                                    <input type="text" name="day"
                                           value="{{ $meeting->day }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>

                                {{-- Hora --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Hora
                                    </label>
                                    <input type="time" name="hour"
                                           value="{{ $meeting->hour }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>

                                {{-- Botones --}}
                                <div class="flex gap-3 mt-4">

                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Actualizar
                                    </button>

                                </div>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>