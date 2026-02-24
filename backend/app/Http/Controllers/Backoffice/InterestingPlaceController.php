<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaceRequest;
use App\Models\InterestingPlace;
use App\Models\PlaceType;
use Illuminate\Http\Request;

class InterestingPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $interestingplaces = InterestingPlace::with('placeType')->orderBy('created_at', 'desc')->paginate(10);


        return view('backoffice.interestingplaces.index', compact('interestingplaces'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $placeType = PlaceType::all();
        return view('backoffice.interestingplaces.create', compact('placeType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaceRequest $request)
    {
        $validated = $request->validated();

        InterestingPlace::create($validated);

        return redirect()->route('backoffice.interestingplaces.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $interestingplace = InterestingPlace::with('placeType')->findOrFail($id);
        return view('backoffice.interestingplaces.show', compact('interestingplace'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InterestingPlace $interestingplace)
    {
        $placeType = PlaceType::all();
        return view('backoffice.interestingplaces.edit', compact('interestingplace', 'placeType'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InterestingPlace $interestingplace)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gps' => 'nullable|string|max:255',
            'place_type_id' => 'nullable|exists:place_types,id',
        ]);

        $interestingplace->update($request->all());

        return redirect()
            ->route('backoffice.interestingplaces.index')
            ->with('success', 'Lugar actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InterestingPlace $interestingplace)
    {
        $interestingplace->delete();
        return redirect()->route('backoffice.interestingplaces.index');

    }
}
