<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'dni' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]/*, [
            // Mensajes personalizados de validación
            'name.required' => 'El nombre es obligatorio',
            'name.max' => 'El nombre no debe exceder los 255 caracteres',
            'lastname.required' => 'El apellido es obligatorio',
            'lastname.max' => 'El apellido no debe exceder los 255 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe proporcionar un correo electrónico válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres',
            'dni.required' => 'El DNI es obligatorio',
            'dni.unique' => 'Este DNI ya está registrado',
            'dni.max' => 'El DNI no debe exceder los 20 caracteres',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.max' => 'El teléfono no debe exceder los 50 caracteres',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'La confirmación de contraseña no coincide',
        ]*/);

        $role = Role::where('name', 'visitant')->first();

        $user = User::create([
            'name' => $request->name,
            'lastName' => $request->lastname ?? $request->lastName,
            'dni' => $request->dni,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role?->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
