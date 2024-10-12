<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MultiplicacionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AhorcadoController;
use App\Http\Controllers\DatosController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::get('/multiplicar/{numero1?}/{numero2?}/{limiteFibonacci?}', [MultiplicacionController::class, 'tablasMultiplicar'])
-> where('numero1', '[0-9]')
-> where('numero2', '[0-9]')
-> where('limiteFibonacci', '[a-z]+');

Route::post('persona', [MultiplicacionController::class, 'stores']);

/*
Route::get('/humanos', [PhotoController::class, 'index']);
Route::get('/humanos/{id}', [PhotoController::class, 'show']);
Route::post('/humanos', [PhotoController::class, 'store']);
Route::put('/humanos/{id}', [PhotoController::class, 'update']);
Route::delete('/humanos/{id}', [PhotoController::class, 'destroy']);
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/jwt', [AuthController::class, 'login'])->name('login');
Route::middleware('auth.jwt')->get('/me', [AuthController::class, 'me']);

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});
Route::post('/register/sanctum', [AuthController::class, 'register_sanctum']);

Route::post('/login', function (Request $request) {
    // Validar las credenciales del usuario
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    // Generar un token de acceso personal para el usuario autenticado
    $token = $user->createToken($request->device_name)->plainTextToken;

    // Devolver el token en la respuesta
    return response()->json(['token' => $token]);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    
Route::get('/multiplicar/{numero1?}/{numero2?}/{limiteFibonacci?}', [MultiplicacionController::class, 'tablasMultiplicar'])
-> where('numero1', '[0-9]')
-> where('numero2', '[0-9]')
-> where('limiteFibonacci', '[a-z]+');
    Route::get('/humanos', [PhotoController::class, 'index']);
    Route::get('/humanos/{id}', [PhotoController::class, 'show']);
    Route::post('/humanos', [PhotoController::class, 'store']);
    Route::put('/humanos/{id}', [PhotoController::class, 'update']);
    Route::delete('/humanos/{id}', [PhotoController::class, 'destroy']);
    Route::get('/mascotas/{id}/detalles', [DatosController::class, 'mostrarDetallesMascota'])
-> where('id', '[0-9]+');
});


Route::post('/ahorcado/{indicePalabra}/jugar/{jugar}', [AhorcadoController::class, 'jugar'])
-> where('indicePalabra', '[1-9]');



Route::post('/dueños', [DatosController::class, 'insertarDueño']);
Route::post('/mascotas', [DatosController::class, 'insertarMascota']);
Route::post('/razas', [DatosController::class, 'insertarRaza']);
Route::post('/vacunas', [DatosController::class, 'insertarVacuna']);
Route::post('/historiales-medicos', [DatosController::class, 'insertarHistorialMedico']);
Route::post('/visitas-veterinarias', [DatosController::class, 'insertarVisitaVeterinaria']);
Route::post('/veterinarios', [DatosController::class, 'insertarVeterinario']);
Route::post('/consultas', [DatosController::class, 'insertarConsulta']);
Route::post('/clinicas-veterinarias', [DatosController::class, 'insertarClinicaVeterinaria']);
Route::post('/citas', [DatosController::class, 'insertarCita']);
Route::middleware(['auth:sanctum'])->group(function () {



});
