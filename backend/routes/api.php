<?php

use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Trek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// FIX CSRF: Eliminada la ruta POST /login duplicada que existía aquí.
// El frontend llama a /login (sin prefijo /api), así que usa la ruta de web.php,
// que sí tiene middleware de sesión y CSRF. Tener una copia aquí en api.php
// (que se monta como /api/login) no se usaba y creaba confusión.
Route::post('/register', [RegisteredUserController::class, 'store']);

// Endpoint /api/login para aplicaciones móviles/SPA que usan Sanctum
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'user' => $user->load('role'),
        'token' => $token
    ]);
});

// Protegida con Sanctum para el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user()->load([
        'role',
        'meetings',
        'meetings.trek',
        'comments',
        'meeting',
        'meeting.users',
        'meeting.trek'
    ]);
    return response()->json(['data' => $user]);
});

//CRUD per a administradors 
Route::middleware(['multiauth', 'CHECK-ROLEADMIN'])->group(function () {
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    // update and delete per email
    Route::put('/users/email/{email}', [UserController::class, 'updateByEmail']);
    Route::delete('/users/email/{email}', [UserController::class, 'destroyByEmail']);
    // rutes per a obtenir usuaris per email
    Route::get('/users/email/{email}', [UserController::class, 'showByEmail']);

});
Route::middleware('multiauth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/profile', function () {
        return ['message' => 'Acceso permitido'];

    });
    // index and show per a usuaris autenticats
    // Route::get('/user', [UserController::class, 'indexUser']);
    Route::get('user/show', [UserController::class, 'showUser']);
    Route::put('/user/deactivate', [UserController::class, 'deactivateAccount']);
    // Rutes per a operacions amb email

    // Route::apiResource('user', UserController::class)->except(['store', 'update', 'destroy']);



});

// Route::bind('Trek', function ($value) {
//     return is_numeric($value) ?
//         Trek::findOrFail($value) :
//         Trek::where('regNumber', $value)->firstOrFail();
//});

Route::get('/treks/search/{value}', [TrekController::class, 'search']);
Route::get('/treks/illa/{illa}', [TrekController::class, 'filterByIsland']);
Route::get('/treks/{identifier}/meeting/{id}',[TrekController::class, 'showMeeting']);
Route::apiResource('treks', TrekController::class);

// Route::bind('user', function ($value) {
//     return is_numeric($value) ?
//         User::findOrFail($value) :
//         User::where('email', $value)->firstOrFail();
// });



// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
