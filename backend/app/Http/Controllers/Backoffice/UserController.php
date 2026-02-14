<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Meeting;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $users = User::with('meetings')->paginate(10);
        $meetings = Meeting::with('users')->get();

        return view('backoffice.users.index', compact('meetings', 'users'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $role = Role::where('name', 'visitant')->first();

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role_id' => $role->id,
        ]);


        // return response()->json($user->additional(['message' => 'User created successfully']), 201);
        //return response()->json($user);

        return redirect()->route('backoffice.users.index')
            ->with('success', 'Usuari creat correctament');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)//Este show es el que usa el admin
    {
        //
        // $user = User::findorFail($id);
        //return response()->json($user);
        return view(
            'backoffice.users.show',
            compact('user')
        );


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $identifier)
    //public function update(Request $request, string $id)
    {
        if (is_numeric($identifier)) {
            $user = User::findOrFail($identifier);
        } else {
            $user = User::where('email', $identifier)->firstOrFail();
        }
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'dni' => 'nullable',
            'phone' => 'nullable',
            'role_id' => 'required|exists:roles,id',
        ]);


        //Update fields
        $user->name = $request->name ?? $user->name;
        $user->lastname = $request->lastname ?? $user->lastname;
        $user->email = $request->email ?? $user->email;
        $user->dni = $request->dni ?? $user->dni;
        $user->phone = $request->phone ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->role_id;

        $user->save();

        return redirect()->route('backoffice.users.index')
            ->with('success', 'Usuari actualitzat correctament');



        //

    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(string $id)
    public function destroy(User $user)
    {
        // Borrado en cascada
        //Eliminar tokens de Sanctum
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }
        //Eliminar meetings
        if (method_exists($user, 'meetings')) {
            $user->meetings()->detach();
        }

        //Eliminar comments
        if (method_exists($user, 'comments')) {
            Comment::where('user_id', $user->id)->update(['status' => 'n']);
        }


        // //Eliminar images
        // if (method_exists($user, 'images')) {
        //     $user->images()->detach();
        // }

        //Desactivar el user
        $user->status = 'n';
        $user->save();

        return redirect()->route('backoffice.users.index')
            ->with('status', 'Usuario desactivado correctamente');

        //
    }


    public function create(Request $request)
    {
        $roles = Role::all();
        return view('backoffice.users.create', compact('roles'));
    }

    //Para el backoffice, mostrar el formulario de edición de un usuario
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backoffice.users.edit', compact('user', 'roles'));
    }

    public function removeUser(Meeting $meeting, User $user)
    {
        // 1. Quitar al usuario del meeting (tabla pivote)
        $meeting->users()->detach($user->id);

        // 2. Marcar sus comentarios como "n"
        Comment::where('meeting_id', $meeting->id)
            ->where('user_id', $user->id)
            ->update(['status' => 'n']);

        return back()->with('status', 'Usuario eliminado del meeting');
    }

}
