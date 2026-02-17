<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight"> {{ $user->name }} {{ $user->lastName }}</h5>
        <p class="mb-4 text-sm">DNI:{{$user->dni}}</p>
        <p class="mb-4 text-sm">Email: {{$user->email}}</p>
        <p class="mb-4 text-sm">Phone: {{$user->phone}}</p>
        <p class="mb-4 text-sm">Status: {{$user->status}}</p>
        <p class="mb-4 text-sm">Role: {{$user->role->name}}</p>

        <a href="{{route('backoffice.users.show', ['user' => $user->id])}}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Ver</a>
        <a href="{{route('backoffice.users.edit', ['user' => $user->id])}}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</a>
        <form action="{{ route('backoffice.users.destroy', ['user' => $user->id]) }}" method="POST"
            class="inline-block float-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                Eliminar
            </button>
        </form>

    </div>
</div>