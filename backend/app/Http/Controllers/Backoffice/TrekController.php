<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
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
        $treks = Trek::with(['meetings', 'interestingPlaces'])->paginate(10);
        return view('backoffice.treks.index', compact('treks'));
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $trek = Trek::Create([
        //     'regNumber' => $request->regNumber,
        //     'name' => $request->name,
        //     'municipality_id' => $request->municipality_id,
        // ]);

        // trek M:N interestingPlace
        /* foreach (explode(',', $request->regNumber) as $inter)
            $trek->tags()->attach(InterestingPlace::firstOrCreate(['name' => trim($inter)])->id); */


        //return response()->json($trek);



        //Buscar municipio por nombre
        $municipality = Municipality::where('name', $request->municipality)->firstOrFail();

        //Crear el Trek
        $trek = Trek::create([
            'regNumber' => $request->regNumber,
            'name' => $request->name,
            'municipality_id' => $municipality->id,
            'status' => 'y'
        ]);

        //Crear meetings
        foreach ($request->meetings as $meetingData) {

            // Buscar usuario por DNI
            $user = User::where('dni', $meetingData['DNI'])->firstOrFail();

            // Crear meeting
            $meeting = $trek->meetings()->create([
                'day' => $meetingData['day'],
                'hour' => $meetingData['time'],
                'dateIni' => $meetingData['day'],
                'user_id' => $user->id
            ]);

            //Crear comments dentro del meeting
            if (isset($meetingData['comments'])) {
                foreach ($meetingData['comments'] as $commentData) {

                    // Buscar usuario del comentario por DNI
                    $userComment = User::where('dni', $commentData['DNI'])->firstOrFail();

                    $meeting->comments()->create([
                        'comment' => $commentData['comment'],
                        'score' => $commentData['score'],
                        'user_id' => $userComment->id
                    ]);
                }
            }
        }

        // 5. Cargar relaciones para devolver el Trek completo
        $trek->load([
            'municipality',
            'meetings.user',
            'meetings.comments',
            'interestingPlaces.placeType'
        ]);

        return new TrekResource($trek);
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
        try { //Buscar municipio por nombre
            $municipality = Municipality::where('name', $request->municipality)->firstOrFail();

            // Actualizar Trek
            $trek->update([
                'regNumber' => $request->regNumber,
                'name' => $request->name,
                'municipality_id' => $municipality->id
            ]);

            // Sincronizar lugares interesantes
            if ($request->has('interesting_places')) {
                $ids = collect($request->interesting_places)->pluck('id');
                $trek->interestingPlaces()->sync($ids);
            }


            //Borrar meetings y comments antiguos
            foreach ($trek->meetings as $meeting) {
                $meeting->comments()->delete();
            }
            $trek->meetings()->delete();

            //Crear meetings nuevos
            foreach ($request->meetings as $meetingData) {

                //Buscar usuario del meeting por DNI
                $user = User::where('dni', $meetingData['DNI'])->firstOrFail();

                $meeting = $trek->meetings()->create([
                    'day' => $meetingData['day'],
                    'hour' => $meetingData['time'],
                    'dateIni' => $meetingData['day'],
                    'dateEnd' => $meetingData['day'],
                    'user_id' => $user->id
                ]);

                //Crear comments nuevos
                if (isset($meetingData['comments'])) {
                    foreach ($meetingData['comments'] as $commentData) {

                        $userComment = User::where('dni', $commentData['DNI'])->firstOrFail();

                        $meeting->comments()->create([
                            'comment' => $commentData['comment'], // tu columna real
                            'score' => $commentData['score'],
                            'user_id' => $userComment->id
                        ]);
                    }
                }
            }

            //Cargar relaciones para devolver el Trek completo
            $trek->load([
                'municipality',
                'meetings.user',
                'meetings.comments',
                'interestingPlaces.placeType'
            ]);

            return new TrekResource($trek);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating trek: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(Trek $trek)
    public function destroy(Trek $trek)
    {
        $trek->delete();
        //
        return (new TrekResource($trek))->additional(['message' => 'Trek deleted successfully']);
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

    public function create()
    {
        $municipalities = Municipality::all();
        $interestingPlaces = InterestingPlace::orderBy('name','asc')->get();

        return view('backoffice.treks.create', [
            'municipalities' => $municipalities,
            'interestingPlaces' => $interestingPlaces,
        ]);
    }


}
