<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Island;
use Illuminate\Http\Request;

class IslandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $islands = Island::orderBy('created_at', 'desc')->paginate(10);
        return view('backoffice.islands.index', compact('islands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backoffice.islands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:islands,name',
        ]);

        Island::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('backoffice.islands.index')
            ->with('success', 'Isla creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Island $island)
    {
        return view('backoffice.islands.show', compact('island'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Island $island)
    {
        return view('backoffice.islands.edit', compact('island'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Island $island)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:islands,name,' . $island->id,
        ]);

        $island->update([
            'name' => $request->name,
        ]);

        return redirect()->route('backoffice.islands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Island $island)
    {
        if ($island->municipalities()->exists()) {
            return redirect()
                ->route('backoffice.islands.index')
                ->with('status', 'No se puede eliminar una isla con municipios asociados.');
        }

        $island->delete();

        return redirect()
            ->route('backoffice.islands.index')
            ->with('success', 'Isla eliminada correctamente');
    }
}
