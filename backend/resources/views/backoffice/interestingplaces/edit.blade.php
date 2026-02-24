<x-app-layout>
    @extends('layouts.backoffice')
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

                <h1 class="text-2xl font-semibold mb-6">Editar Lugar Interesante</h1>

                <form method="POST" action="{{ route('backoffice.interestingplaces.update', $interestingplace) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full"
                            value="{{ old('name', $interestingplace->name) }}" />
                        @error('name')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- GPS --}}
                    <div class="mb-4">
                        <label for="gps">GPS</label>
                        <input id="gps" name="gps" type="text" class="mt-1 block w-full"
                            value="{{ old('gps', $interestingplace->gps) }}" />
                        @error('gps')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipo de Lugar --}}
                    <div class="mb-4">
                        <label for="place_type_id">Tipo de Lugar</label>

                        <select id="place_type_id" name="place_type_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                            <option value="">Selecciona un tipo</option>

                            @foreach ($placeType as $type)
                                <option value="{{ $type->id }}" {{ old('place_type_id', $interestingplace->place_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>  
                    </div>

                    {{-- Botones --}}
                   <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar
                    </button>
            </div>

            </form>
            </div>
        </x-app-layout>
    @endsection