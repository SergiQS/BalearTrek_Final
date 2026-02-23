<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }


    public function store(Request $request)
    {
        // try {
        //     // Validació amb missatges personalitzats
        //     $validated = $request->validate([
        //            'email'     => 'required|string|email',
        //             'password' => 'required|string',
        //         ],[ 'email.required' => 'El correu és obligatori',
        //             'email.email'    => 'El correu no té un format vàlid',
        //             'password.required' => 'La contrasenyaa és obligatòria',
        //         ]
        //     );
        //     // Intent d'inici de sessió
        //     if (!Auth::attempt($validated->only('email', 'password'))) {
        //         return response()->json([
        //             'message' => 'Credencials d\'accés invàlides'
        //         ], 401);
        //     }

        //     // Usuari autenticat
        //     $user = Auth::guard('sanctum')->user();

        //     // Crear token d'accés
        //     $token = $user->createToken('auth_token')->plainTextToken;

        //     // Resposta JSON
        //     return response()->json([
        //         'access_token' => $token,
        //         'token_type'   => 'Bearer',
        //         'user'         => $user,
        //         'status'       => 'Login OK successful',
        //     ], 200);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => 'S\'ha produït un error al tractar les dades',
        //         'error_details' => $e->getMessage(),
        //     ], 200);
        // }
        {
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Credenciales incorrectas'], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Verificar si el usuario está autenticado con token Sanctum
            if ($request->user() && $request->user()->currentAccessToken()) {
                // Logout con token API
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'Logout exitoso (token eliminado)']);
            }
            
            // Logout con sesión web (si no hay token)
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json(['message' => 'Logout exitoso (sesión cerrada)']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión',
                'error_details' => $e->getMessage(),
            ], 500);
        }
    }
}