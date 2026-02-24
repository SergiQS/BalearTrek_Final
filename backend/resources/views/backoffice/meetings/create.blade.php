<x-app-layout>
    @extends('layouts.backoffice')

    @section('content')

            <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold mb-6">Crear Encuentro</h1>

                <form method="POST" action="{{ route('backoffice.meetings.store') }}">
                    @csrf

                    {{-- EXCURSIÓN --}}
                    <div class="mb-4">
                        <label for="trek_id">Excursión</label>
                        <select id="trek_id" name="trek_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                            <option value="">Selecciona una excursión</option>

                            @foreach ($treks as $trek)
                                <option value="{{ $trek->id }}" {{ old('trek_id') == $trek->id ? 'selected' : '' }}>
                                    {{ $trek->name }}
                                </option>
                            @endforeach

                        </select>
                       
                    </div>

                    {{-- FECHA INICIAL --}}
                    <div class="mb-4">
                        <label for="dateIni">Fecha inicial</label>
                        <input id="dateIni" name="dateIni" type="date" class="mt-1 block w-full"
                            value="{{ old('dateIni') }}" />
                         @error('dateIni')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FECHA FINAL --}}
                    <div class="mb-4">
                        <label for="dateEnd">Fecha final</label>
                        <input id="dateEnd" name="dateEnd" type="date" class="mt-1 block w-full"
                            value="{{ old('dateEnd  ') }}" />
                         @error('dateEnd')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DÍA --}}
                    <div class="mb-4">
                        <label for="day">Día</label>
                        <input id="day" name="day" type="date" class="mt-1 block w-full" placeholder="Ej: 24/12/2024"
                            value="{{ old('day') }}" />
                         @error('day')
                            <div style="color: red;">{{ $message }}</div>   
                        @enderror
                    </div>

                    {{-- HORA --}}
                    <div class="mb-4">
                        <label for="time">Hora</label>
                        <input id="time" name="time" type="time" class="mt-1 block w-full" value="{{ old('time') }}" />
                            @error('time')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                    </div>

                    {{-- GUÍAS --}}
                    <div class="mb-4">
                        <label for="guides">Guías</label>

                        <select id="guides" name="guides"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                            @foreach ($guias as $guia)
                                <option value="{{ $guia->id }}" {{$guia->id == old('guides') ? 'selected' : ''}}>
                                    {{ $guia->name }} {{ $guia->lastName }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                  
                    {{-- BOTÓN --}}
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Crear
                    </button>
                </form>
            </div>


            </div>
        </x-app-layout>
    @endsection