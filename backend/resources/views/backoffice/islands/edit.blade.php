<x-app-layout>
    @extends('layouts.backoffice')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

        <h1 class="text-2xl font-semibold mb-6">Editar isla</h1>

        <form method="POST" action="{{ route('backoffice.islands.update', $island) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-input-label for="name" value="Nombre" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ old('name', $island->name) }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
