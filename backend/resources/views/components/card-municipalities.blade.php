
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight"> {{ $municipality->name }}</h5>
        <p class="mb-4 text-sm">Zone: {{$municipality->zone->name}}</p>
        <p class="mb-4 text-sm">Island: {{$municipality->island->name}}</p>

        <a href="{{route('backoffice.municipalities.show', ['municipality' => $municipality->id])}}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="{{route('backoffice.municipalities.edit', ['municipality' => $municipality->id])}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{route('backoffice.municipalities.destroy', ['municipality' => $municipality->id])}}" method="POST"
            class="float-right">
            @method('DELETE')
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div>