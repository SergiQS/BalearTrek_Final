<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
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
        $meetings = Meeting::with('trek', 'trek.municipality', 'user', 'users.role')->paginate(10);
        // $treks = Trek::with(['meetings.user'])
        // ->orderBy('name')
        // ->get();

        return view('backoffice.meetings.index', compact('meetings'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $meetings = Meeting::all();
        $treks = Trek::orderBy('name','asc')->get();
        $guias = User::whereHas('role', fn($q) => $q->where('name', 'guia'))->get();
        return view('backoffice.meetings.create', compact('treks', 'guias', 'meetings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'trek_id' => 'required|exists:treks,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'day' => 'required|string',
            'time' => 'required',
            'guides' => 'required|exists:users,id',
        ]);

        // Crear el meeting
        $meeting = Meeting::create([
            'trek_id' => $request->trek_id,
            'dateIni' => $request->start_date,
            'dateEnd' => $request->end_date,
            'day' => $request->day,
            'hour' => $request->time,
            'user_id' => $request->guides,
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
    public function update(Request $request, Meeting $meeting)
    {
        // Validar datos del formulario
        $request->validate([
            'trek_id' => 'required|exists:treks,id',
            'dateIni' => 'required|date',
            'dateEnd' => 'nullable|date|after_or_equal:dateIni',
            'user_id' => 'required|exists:users,id',
            'guias_adicionales' => 'nullable|array',
            'guias_adicionales.*' => 'exists:users,id',
            'day' => 'required|string',
            'hour' => 'required',
        ]);

        // Actualizar el meeting
        $meeting->update([
            'trek_id' => $request->trek_id,
            'dateIni' => $request->dateIni,
            'dateEnd' => $request->dateEnd,
            'user_id' => $request->user_id,
            'day' => $request->day,
            'hour' => $request->hour,
        ]);

        // Obtener los usuarios normales actuales (no guías) para mantenerlos
        $usuariosNormales = $meeting->getUsuariosNormales()->pluck('id')->toArray();
        
        // Preparar array de todas las guías (responsable + adicionales)
        $guiasIds = [$request->user_id];
        
        if ($request->has('guias_adicionales') && is_array($request->guias_adicionales)) {
            $guiasIds = array_merge($guiasIds, $request->guias_adicionales);
        }
        
        // Eliminar duplicados de guías
        $guiasIds = array_unique($guiasIds);
        
        // Combinar guías + usuarios normales
        $todosLosUsuarios = array_unique(array_merge($guiasIds, $usuariosNormales));
        
        // Sincronizar en la tabla pivot (guías + participantes)
        $meeting->users()->sync($todosLosUsuarios);

        return redirect()->route('backoffice.meetings.index')
            ->with('status', 'Meeting actualizado correctamente con ' . count($guiasIds) . ' guía(s) y ' . count($usuariosNormales) . ' participante(s)');
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
