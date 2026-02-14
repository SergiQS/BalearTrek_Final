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
        $meetings = Meeting::with('trek', 'user')->paginate(10);
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
        

        $meeting = Meeting::create([
        'trek_id' => $request->trek_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'day' => $request->day,
        'time' => $request->time,
    ]);
    if ($request->has('guias')) {
        $meeting->users()->attach($request->guias);
    }



        return redirect()->route('backoffice.meetings.index')
                     ->with('status', 'Meeting creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $meeting = Meeting::with('trek', 'user')->findOrFail($id);
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
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);
        $meeting->users()->sync($request->users);
        $meeting->update($request->all());

        return redirect()->route('backoffice.meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        //Eliminar comments
        if (method_exists($meeting, 'comments')) {
            $meeting->comments()->delete();
        }
        //Eliminar images
        if (method_exists($meeting, 'images')) {
            $meeting->images()->delete();
        }
        //Eliminar el meeting
        $meeting->users()->detach();
        
        $meeting->delete();

        return redirect()->route('backoffice.meetings.index')
        ->with('success', 'Meeting eliminada correctament');

    }
}
