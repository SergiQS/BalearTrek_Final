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

        <h1 class="text-2xl font-semibold mb-6">Editar municipio</h1>

        <form method="POST" action="{{ route('backoffice.municipalities.update', $municipality) }}">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <label for="name">Nombre</label>
                <input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name', $municipality->name) }}" />
                @error('name')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="island_id">Isla</label>
                <select id="island_id" name="island_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    @foreach ($islands as $island)
                        <option value="{{ $island->id }}" {{ $municipality->island_id == $island->id ? 'selected' : '' }}>
                            {{ $island->name }}
                        </option>
                    @endforeach

                </select>
              
            </div>


            <div class="mb-4">
                <label for="zone_id">Zona</label>
                <select id="zone_id" name="zone_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                    @foreach ($zones as $zone)
                        <option value="{{ $zone->id }}" {{ $municipality->zone_id == $zone->id ? 'selected' : '' }}>
                            {{ $zone->name }}
                        </option>
                    @endforeach

                </select>
            
            </div>
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar
                    </button>
                </div>

        </form>
    </div>
    </x-app-layout>
@endsection