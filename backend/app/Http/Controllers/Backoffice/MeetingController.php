<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreMeetingsRequest;
use App\Http\Requests\UpdateMeetingsRequest;
use App\Models\Meeting;
use App\Models\Trek;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = Meeting::with('trek', 'trek.municipality', 'user', 'users.role')->orderBy('created_at', 'desc')->paginate(10);
        // $treks = Trek::with(['meetings.user'])
        // ->orderBy('name')
        // ->get();

        return view('backoffice.meetings.index', compact('meetings'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meetings = Meeting::all();
        $treks = Trek::orderBy('name', 'asc')->get();
        $guias = User::whereHas('role', fn($q) => $q->where('name', 'guia'))->get();
        return view('backoffice.meetings.create', compact('treks', 'guias', 'meetings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeetingsRequest $request)
    {
        // Validar datos
        $validated = $request->validated();


        // Crear el meeting
        Meeting::create([
            'trek_id' => $validated['trek_id'],
            'dateIni' => $validated['dateIni'],
            'dateEnd' => $validated['dateEnd'],
            'day' => $validated['day'],
            'hour' => $validated['hour'],
            'user_id' => $validated['user_id'], // Asignar el guía responsable
        ]);

        return redirect()->route('backoffice.meetings.index')
            ->with('status', 'Meeting creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $meeting = Meeting::with('trek', 'user', 'users.role')->findOrFail($id);
        return view('backoffice.meetings.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        $treks = Trek::all();
        $guias = User::whereHas('role', fn($q) => $q->where('name', 'guia'))->get();
        return view('backoffice.meetings.edit', compact('meeting', 'treks', 'guias'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingsRequest $request, Meeting $meeting)
    {
        $validated = $request->validated();

        // Actualizar el meeting
        $meeting->update([
            'trek_id' => $validated['trek_id'],
            'dateIni' => $validated['dateIni'],
            'dateEnd' => $validated['dateEnd'],
            'user_id' => $validated['user_id'],
            'day' => $validated['day'],
            'hour' => $validated['hour'],

        ]);

        // Obtener los usuarios normales actuales (no guias) para mantenerlos
        $usuariosNormales = $meeting->getUsuariosNormales()->pluck('id')->toArray();

        // Preparar array de todas las guias (responsable + adicionales)
        $guiasIds = [$validated['user_id']];

        if ($request->has('guias_adicionales') && is_array($request->guias_adicionales)) {   // Si hay guías adicionales seleccionados, los añadimos al array de guías
            $guiasIds = array_merge($guiasIds, $validated['guias_adicionales']);
        }

        // Eliminar duplicados de guias
        $guiasIds = array_unique($guiasIds);

        // Combinar guias + usuarios normales
        $todosLosUsuarios = array_unique(array_merge($guiasIds, $usuariosNormales));

        // Sincronizar en la tabla pivot (guias + participantes) 
        // El método sync() en Laravel se utiliza para sincronizar relaciones de muchos a muchos, asegurando que solo los registros especificados en el array proporcionado permanezcan en la tabla pivote.  A diferencia de attach(), que solo añade relaciones,
        //  sync() elimina automáticamente las relaciones existentes que no están en el array proporcionado y añade solo las nuevas.
        $meeting->users()->sync($todosLosUsuarios);

        return redirect()->route('backoffice.meetings.index')
            ->with('success', 'Meeting actualizado correctamente con ' . count($guiasIds) . ' guía(s) y ' . count($usuariosNormales) . ' participante(s)');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        // Primero eliminar las imágenes de cada comentario
        foreach ($meeting->comments as $comment) {
            $comment->images()->delete();
        }

        // Luego eliminar los comentarios
        $meeting->comments()->delete();

        // Detach guías de la tabla pivot
        $meeting->users()->detach();

        // Finalmente eliminar el meeting
        $meeting->delete();

        return redirect()->route('backoffice.meetings.index')
            ->with('success', 'Meeting eliminado correctamente');

    }
}
