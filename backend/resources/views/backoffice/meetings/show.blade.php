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





                    <div class="mt-2 pt-2 border-t">
                        <p class="text-xs text-gray-600">Total de guías: {{ $meeting->getAllGuias()->count() }}</p>
                    </div>
                </div>

                @if ($meeting->getUsuariosNormales()->count() > 0)
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Participantes del Meeting</h3>

                        <p class="text-sm font-semibold text-indigo-600 mb-2">Usuarios Inscritos
                            ({{ $meeting->getUsuariosNormales()->count() }}):</p>
                        <ul class="ml-4 text-sm text-gray-700">
                            @foreach ($meeting->getUsuariosNormales() as $participante)
                                <li class="mb-1">• {{ $participante->name }} {{ $participante->lastName ?? '' }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>

</x-app-layout>