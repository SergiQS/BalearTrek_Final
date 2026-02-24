<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrekRequest;
use App\Models\InterestingPlace;
use App\Models\Trek;
use App\Models\User;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Http\Resources\TrekResource;
use Exception;

class TrekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $trek = Trek::all();
        $treks = Trek::with(['meetings', 'interestingPlaces'])->orderBy('created_at', 'desc')->paginate(10);
        return view('backoffice.treks.index', compact('treks'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipalities = Municipality::all();
        $interestingPlaces = InterestingPlace::all();
        return view('backoffice.treks.create', compact('municipalities', 'interestingPlaces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrekRequest $request)
    {
        // Validación básica
        $validated = $request->validated();
        // Crear el Trek
        $trek = Trek::create([
            'regNumber' => $validated['regNumber'],
            'name' => $validated['name'],
            'municipality_id' => $validated['municipality_id'],
            'status' => 'y'
        ]);

        // Asociar lugares de interés si se enviaron
        if ($request->has('interesting_places')) {
            $trek->interestingPlaces()->attach($request->interesting_places);
        }

        return redirect()->route('backoffice.treks.index')
            ->with('success', 'Trek creado correctamente');
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Trek $trek)
    {
        // 
        // $trek->load([
        //     'municipality',
        //     'meetings',
        //     'meetings.comments',
        //     'meetings.user',
        //     'interestingPlaces',
        //     'interestingPlaces.placeType',



        // ]);
        // return (new TrekResource($trek))->additional(['message' => 'Trek retrieved successfully']);
        $trek->load(['meetings.user']);

        return view('backoffice.treks.show', compact('trek'));

        // $trek = Trek::findorFail($id);
        // return response()->json($trek);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trek $trek)
    {
        try {
            // Validación básica
            $request->validate([
                'regNumber' => 'required|string',
                'name' => 'required|string',
                'municipality_id' => 'required|exists:municipalities,id',
            ]);

            // Actualizar Trek
            $trek->update([
                'regNumber' => $request->regNumber,
                'name' => $request->name,
                'municipality_id' => $request->municipality_id
            ]);

            // Sincronizar lugares interesantes
            if ($request->has('interesting_places')) {
                $trek->interestingPlaces()->sync($request->interesting_places);
            } else {
                // Si no se envía nada, desasociar todos
                $trek->interestingPlaces()->detach();
            }

            return redirect()->route('backoffice.treks.index')
                ->with('success', 'Trek actualizado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error actualizando trek: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trek $trek)
    {
        try {
            // Desasociar lugares de interés primero
            $trek->interestingPlaces()->detach();
            
            // Eliminar meetings y sus comentarios
            foreach ($trek->meetings as $meeting) {
                $meeting->comments()->delete();
            }
            $trek->meetings()->delete();
            
            // Ahora sí eliminar el trek
            $trek->delete();
            
            return redirect()->route('backoffice.treks.index')
                ->with('success', 'Trek eliminado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error eliminando trek: ' . $e->getMessage());
        }
    }

    public function filterByIsland($illa)
    {
        $treks = Trek::whereHas('municipality.island', function ($query) use ($illa) {
            $query->where('name', $illa);
        })
            ->with([
                'municipality.island',
                'meetings.comments',
                'meetings.user',
                'interestingPlaces.placeType'
            ])
            ->get();

        return TrekResource::collection($treks);
    }

    public function search($value)
    {
        //Si es numero busco por id
        if (is_numeric($value)) {
            $trek = Trek::with([
                'municipality',
                'meetings.comments',
                'meetings.user',
                'interestingPlaces.placeType'
            ])->findOrFail($value);

            // Si no es numero busco per regNumber
        } else {
            $trek = Trek::where('regNumber', $value)
                ->with([
                    'municipality',
                    'meetings.comments',
                    'meetings.user',
                    'interestingPlaces.placeType'
                ])
                ->firstOrFail();

            return new TrekResource($trek);

        }

    }

    public function edit(Trek $trek)
    {
                  
        $municipalities = Municipality::all();
        $interestingPlaces = InterestingPlace::orderBy('name','asc')->get();

        return view('backoffice.treks.edit', [
            
            'trek' => $trek,
            'municipalities' => $municipalities,
            'interestingPlaces' => $interestingPlaces,
        ]);
    }

    

}
