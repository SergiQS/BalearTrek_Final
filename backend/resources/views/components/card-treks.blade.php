<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">

        <h5 class="mb-2 text-xl font-medium leading-tight">
            {{ $trek->name }}
        </h5>

        <p class="mb-4 text-sm">
            <strong>Municipality:</strong> {{ $trek->municipality->name ?? '—' }}
        </p>
        <p class="mb-4 text-sm">
            <strong>Sitios de interes</strong>
        </p>
        <div class="mb-4">
            @foreach ($trek->interestingPlaces as $place)
                <span>
                    {{ $place->name }},
                </span>
            @endforeach
        </div>

        <p class="mb-4 text-sm">
            <strong>Status:</strong> {{ $trek->status }}
        </p>

        <p class="mb-4 text-sm">
            <strong>created at:</strong> {{ $trek->created_at }}
        </p>

        <p class="mb-4 text-sm">
            <strong>updated at:</strong> {{ $trek->updated_at }}
        </p>



        <a href="{{ route('backoffice.treks.show', ['trek' => $trek->id]) }}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="{{ route('backoffice.treks.edit', ['trek' => $trek->id]) }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{ route('backoffice.treks.destroy', ['trek' => $trek->id]) }}" method="POST" class="float-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete
            </button>
        </form>

    </div>
</div>