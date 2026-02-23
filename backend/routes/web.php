<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Rutas de autenticación Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Rutas de perfil Breeze

// Rutas del BackOffice
Route::middleware('auth')->prefix('backoffice')->name('backoffice.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('backoffice.users.index');
    })->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');//
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', \App\Http\Controllers\Backoffice\UserController::class);
    Route::resource('municipalities', \App\Http\Controllers\Backoffice\MunicipalityController::class);
    Route::resource('interestingplaces', \App\Http\Controllers\Backoffice\InterestingPlaceController::class);
    Route::resource('meetings', \App\Http\Controllers\Backoffice\MeetingController::class);
    Route::resource('treks', \App\Http\Controllers\Backoffice\TrekController::class);


});

require __DIR__ . '/auth.php';