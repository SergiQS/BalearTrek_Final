
<x-app-layout>@extends('layouts.backoffice')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg p-6">

        <h1 class="text-2xl font-semibold mb-6">Crear Usuario</h1>

        <form method="POST" action="{{ route('backoffice.users.store') }}">
            @csrf
            {{-- Nombre --}}
            <div class="mb-4">
                <x-input-label for="name" value="Nombre" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            {{-- Apellidos --}}
            <div class="mb-4">
                <x-input-label for="lastName" value="Apellidos" />
                <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full"
                    value="{{ old('lastName') }}" />
                <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
            </div>
            {{-- Email --}}
            <div class="mb-4">
                <x-input-label for="email" value="Correo electrónico" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            {{-- DNI --}}
            <div class="mb-4">
                <x-input-label for="dni" value="DNI" />
                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" value="{{ old('dni') }}" />
                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
            </div>
            {{-- Teléfono --}}
            <div class="mb-4">
                <x-input-label for="phone" value="Teléfono" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone') }}" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            {{-- Contraseña --}}
            <div class="mb-4">
                <x-input-label for="password" value="Contraseña" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Rol --}}
            <div class="mb-4">
                <x-input-label for="role_id" value="Rol" />
                <select id="role_id" name="role_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
            </div>


            {{-- Botones --}}
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                Crear usuario
            </x-primary-button>


        </form>
    </div>
    </x-app-layout>
@endsection