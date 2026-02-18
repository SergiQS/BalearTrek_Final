<x-app-layout>
    @extends('layouts.backoffice')

    @section('content')
            <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold mb-6">Editar Lugar Interesante</h1>

                <form method="POST" action="{{ route('backoffice.interestingplaces.update', $interestingplace) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            value="{{ old('name', $interestingplace->name) }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- GPS --}}
                    <div class="mb-4">
                        <x-input-label for="gps" value="GPS" />
                        <x-text-input id="gps" name="gps" type="text" class="mt-1 block w-full"
                            value="{{ old('gps', $interestingplace->gps) }}" />
                        <x-input-error :messages="$errors->get('gps')" class="mt-2" />
                    </div>

                    {{-- Tipo de Lugar --}}
                    <div class="mb-4">
                        <x-input-label for="place_type_id" value="Tipo de Lugar" />

                        <select id="place_type_id" name="place_type_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                            <option value="">Selecciona un tipo</option>

                            @foreach ($placeType as $type)
                                <option value="{{ $type->id }}" {{ old('place_type_id', $interestingplace->place_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('place_type_id')" class="mt-2" />
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