
<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight"> {{ $interestingplace->name }}</h5>
         <p class="mb-4 text-sm">GPS: {{$interestingplace->gps}}</p>
        <p class="mb-4 text-sm">Tipo: {{$interestingplace->placeType->name}}</p>
       

        <a href="{{route('backoffice.interestingplaces.show', ['interestingplace' => $interestingplace->id])}}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="{{route('backoffice.interestingplaces.edit', ['interestingplace' => $interestingplace->id])}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{route('backoffice.interestingplaces.destroy', ['interestingplace' => $interestingplace->id])}}" method="POST"
            class="float-right">
            @method('DELETE')
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div>