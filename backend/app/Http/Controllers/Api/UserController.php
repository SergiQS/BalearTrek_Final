<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $users = User::with(['roles,meetings'])
            ->when(
                $request->name,
                fn($q, $name) =>
                $q->where('name', 'like', "%$name%")
            )
            ->when(
                $request->lastname,
                fn($q, $lastname) =>
                $q->where('lastname', 'like', "%$lastname%")
            )
            ->when(
                $request->email,
                fn($q, $email) =>
                $q->where('email', 'like', "%$email%")
            )
            ->when(
                $request->dni,
                fn($q, $dni) =>
                $q->where('dni', 'like', "%$dni%")
            )
            ->when(
                $request->role,
                fn($q, $role) =>
                $q->whereHas(
                    'role',
                    fn($q) =>
                    $q->where('name', 'like', "%$role%")
                )
            )
            ->get();

        return response()->json([
            'users' => $users
        ]);

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

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)//Este show es el que usa el admin
    {
        //
        // $user = User::findorFail($id);
        //return response()->json($user);
        return response()->json(
            $user->load(['meeting', 'meetings', 'comments', 'comments.images'])
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

        //Update fields
        $user->name = $request->name ?? $user->name;
        $user->lastname = $request->lastname ?? $user->lastname;
        $user->email = $request->email ?? $user->email;
        $user->dni = $request->dni ?? $user->dni;
        $user->phone = $request->phone ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ]);


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

        //Eliminar comments
        if (method_exists($user, 'comments')) {
            $user->comments()->delete();
        }

        //Eliminar meetings
        if (method_exists($user, 'meetings')) {
            $user->meetings()->delete();
        }
        //Eliminar images
        if (method_exists($user, 'images')) {
            $user->images()->delete();
        }

        //Eliminar el user
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully with full integrity'
        ]);

        //
    }

    public function indexUser()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'role' => $user->role->name,
        ]);
    }

    public function showUser()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return response()->json(
            $user->load(['meetings', 'comments'])
        );

    }




    public function showByEmail($email)
    {
        $user = User::where('email', $email)
            ->with([
                'comments',
            ])
            ->firstOrFail();

        return new UserResource($user);
    }


    public function updateByEmail(Request $request, $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $user->update($request->all());

        return (new UserResource($user))
            ->additional(['message' => 'User updated successfully']);
    }

    /**
     * Delete user by email (with cascade delete).
     */
    public function destroyByEmail($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        // Borrado en cascada

        $user->comments()->delete();
        $user->images()->delete();
        $user->roles()->detach();

        $user->delete();

        return response()->json([
            'message' => 'User and related data deleted successfully'
        ]);
    }


}
