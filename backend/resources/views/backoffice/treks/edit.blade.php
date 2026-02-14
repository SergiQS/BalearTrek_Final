<form action="{{ route('backoffice.meetings.store') }}" method="POST">
    @csrf

    {{-- TREK --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Trek</label>
        <select name="trek_id" class="w-full border rounded p-2">
            <option value="">Selecciona un trek</option>
            @foreach ($treks as $trek)
                <option value="{{ $trek->id }}">{{ $trek->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- FECHA INICIAL --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Fecha inicial</label>
        <input type="date" name="start_date" class="w-full border rounded p-2">
    </div>

    {{-- FECHA FINAL --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Fecha final</label>
        <input type="date" name="end_date" class="w-full border rounded p-2">
    </div>

    {{-- DÍA --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Día</label>
        <input type="text" name="day" class="w-full border rounded p-2" placeholder="Ej: Lunes">
    </div>

    {{-- HORA --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Hora</label>
        <input type="time" name="time" class="w-full border rounded p-2">
    </div>

    {{-- GUÍAS --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Guías</label>

        <div class="grid grid-cols-2 gap-2 mt-2">
            @foreach ($guides as $guide)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="guides[]" value="{{ $guide->id }}">
                    {{ $guide->name }}
                </label>
            @endforeach
        </div>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Crear Meeting
    </button>
</form>