<x-app-layout>
    @extends('layouts.backoffice')

    @section('content')
            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

                <h1 class="text-2xl font-semibold mb-6">Editar zona</h1>

                <form method="POST" action="{{ route('backoffice.zones.update', $zone) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full"
                            value="{{ old('name', $zone->name) }}" />
                        @error('name')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
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