<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">

        <h5 class="mb-2 text-xl font-medium leading-tight">
            {{ $meeting->trek->name }}
        </h5>

        <p class="mb-4 text-sm">
            <strong>Municipio:</strong> {{ $meeting->trek->municipality->name ?? '—' }}
        </p>
        <p class="mb-4 text-sm">
            <strong>Fecha Inicial:</strong> {{ $meeting->dateIni }}
        </p>
        <p class="mb-4 text-sm">
            <strong>Fecha Final:</strong> {{ $meeting->dateEnd }}
        </p>

        <p class="mb-2 text-sm">
            <strong>Guía Responsable:</strong> 
            <span class="text-blue-600 font-semibold">{{ $meeting->getGuiaResponsable()->name ?? '—' }} {{ $meeting->getGuiaResponsable()->lastName ?? '—' }}</span>
        </p>

        @if($meeting->getGuiasAcompanantes()->count() > 0)
            <p class="mb-1 text-sm">
                <strong>Guías Acompañantes:</strong>
            </p>
            <ul class="mb-4 text-sm text-gray-700 ml-4">
                @foreach ($meeting->getGuiasAcompanantes() as $acompanante)
                    <li class="mb-1">• {{ $acompanante->name }} {{ $acompanante->lastName}}</li>
                @endforeach
            </ul>
        @else
            <p class="mb-4 text-sm text-gray-500 italic">Sin guías acompañantes</p>
        @endif


        <p class="mb-4 text-sm">
            <strong>Dia:</strong> {{ $meeting->day }}
        </p>

        <p class="mb-4 text-sm">
            <strong>Hora:</strong> {{ $meeting->hour }}
        </p>
        
        <div class="mb-4 p-2 bg-gray-100 rounded text-xs">
            <p class="text-gray-700">
                <strong>Guías:</strong> {{ $meeting->getAllGuias()->count() }} | 
                <strong>Participantes:</strong> {{ $meeting->getUsuariosNormales()->count() }}
            </p>
        </div>



        <a href="{{ route('backoffice.meetings.show', ['meeting' => $meeting->id]) }}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Ver</a>
        <a href="{{ route('backoffice.meetings.edit', ['meeting' => $meeting->id]) }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{ route('backoffice.meetings.destroy', ['meeting' => $meeting->id]) }}" method="POST"
            class="float-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Eliminar
            </button>
        </form>

    </div>
</div>