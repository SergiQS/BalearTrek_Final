<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Meeting:') }} {{ $meeting->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @each('components.card-meetings', [$meeting], 'meeting')
                    <div>
                        @if ($meeting->users->count() > 0)
                            <p class="mb-2 text-sm font-semibold">Usuarios del Meeting: {{ $meeting->users->count() }}</p>

                            <ul class="mb-4 text-sm text-gray-700">
                                @foreach ($meeting->users as $user)
                                    <li class="mb-1">• {{ $user->name }}</li>
                                @endforeach
                            </ul>

                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>  

</x-app-layout>