<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">

        <h5 class="mb-2 text-xl font-medium leading-tight">
            {{ $meeting->trek->name }}
        </h5>

        <p class="mb-4 text-sm">
            <strong>Municipality:</strong> {{ $meeting->trek->municipality->name ?? '—' }}
        </p>
        <p class="mb-4 text-sm">
            <strong>Fecha Inicial:</strong> {{ $meeting->dateIni }}
        </p>
        <p class="mb-4 text-sm">
            <strong>Fecha Final:</strong> {{ $meeting->dateEnd }}
        </p>

        <p class="mb-4 text-sm">
            <strong>Guia:</strong> {{ $meeting->user->name ?? '—' }}
        </p>

        <p class="mb-4 text-sm">
            <strong>Dia:</strong> {{ $meeting->day }}
        </p>

        <p class="mb-4 text-sm">
            <strong>Hora:</strong> {{ $meeting->hour }}
        </p>
        <p class="mb-2 text-sm font-semibold">Usuarios del Meeting: {{ $meeting->users->count() }}</p>



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