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

                <h1 class="text-2xl font-semibold mb-6">Crear Usuario</h1>

                <form method="POST" action="{{ route('backoffice.users.store') }}">
                    @csrf
                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" />
                        @error('name')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Apellidos --}}
                    <div class="mb-4">
                        <label for="lastName">Apellidos</label>
                        <input id="lastName" name="lastName" type="text" class="mt-1 block w-full"
                            value="{{ old('lastName') }}" />
                        @error('lastName')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="mt-1 block w-full"
                            value="{{ old('email') }}" />
                        @error('email')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- DNI --}}
                    <div class="mb-4">
                        <label for="dni">DNI</label>
                        <input id="dni" name="dni" type="text" class="mt-1 block w-full" value="{{ old('dni') }}" />
                        @error('dni')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Teléfono --}}
                    <div class="mb-4">
                        <label for="phone">Teléfono</label>
                        <input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            value="{{ old('phone') }}" />
                        @error('phone')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full" />
                        @error('password')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Rol --}}
                    <div class="mb-4">
                        <label for="role_id">Rol</label>
                        <select id="role_id" name="role_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Botones --}}
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Crear
                    </button>


                </form>
            </div>
        </x-app-layout>
    @endsection