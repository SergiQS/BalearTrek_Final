<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $zones = Zone::orderBy('created_at', 'desc')->paginate(10);
        return view('backoffice.zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backoffice.zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zones,name',
        ]);

        Zone::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('backoffice.zones.index')
            ->with('success', 'Zona creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        return view('backoffice.zones.show', compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return view('backoffice.zones.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:zones,name,' . $zone->id,
        ]);

        $zone->update([
            'name' => $request->name,
        ]);

        return redirect()->route('backoffice.zones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        if ($zone->municipalities()->exists()) {
            return redirect()
                ->route('backoffice.zones.index')
                ->with('status', 'No se puede eliminar una zona con municipios asociados.');
        }

        $zone->delete();

        return redirect()
            ->route('backoffice.zones.index')
            ->with('success', 'Zona eliminada correctamente');
    }
}
