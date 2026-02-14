<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
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
        $municipalities = Municipality::paginate(10);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ]);
        Municipality::create([
            'name' => $request->name,
            'island_id' => $request->island_id,
            'zone_id' => $request->zone_id,
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
    public function update(Request $request, Municipality $municipality)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $municipality->update($request->all());

        return redirect()->route('backoffice.municipalities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return redirect()->route('backoffice.municipalities.index');

    }
}
