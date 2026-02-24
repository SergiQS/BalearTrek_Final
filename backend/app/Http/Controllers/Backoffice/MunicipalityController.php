<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalitiesRequest;
use App\Models\Island;
use App\Models\Municipality;
use App\Models\Zone;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $municipalities = Municipality::orderBy('created_at', 'desc')->paginate(10);
        return view('backoffice.municipalities.index', compact('municipalities'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $islands = Island::all();
        $zones = Zone::all();
        return view('backoffice.municipalities.create', compact('islands', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreMunicipalityRequest $request)
    {
        $validated = $request->validated();

        
        Municipality::create([
            'name' => $validated['name'],
            'island_id' => $validated['island_id'],
            'zone_id' => $validated['zone_id'],
        ]);


        return redirect()
            ->route('backoffice.municipalities.index')
            ->with('success', 'Municipio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $municipality = Municipality::findOrFail($id);
        return view('backoffice.municipalities.show', compact('municipality'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Municipality $municipality)
    {
        $islands = Island::all();
        $zones = Zone::all();
        return view('backoffice.municipalities.edit', compact('municipality', 'islands', 'zones'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMunicipalitiesRequest $request, Municipality $municipality)
    {
        $validated = $request->validated();
        $municipality->update([
            'name' => $validated['name'],
            'island_id' => $validated['island_id'],
            'zone_id' => $validated['zone_id'],
        ]);

        return redirect()->route('backoffice.municipalities.index')
            ->with('success', 'Municipio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return redirect()->route('backoffice.municipalities.index')
            ->with('danger', 'Municipio eliminado correctamente');
    }
}
