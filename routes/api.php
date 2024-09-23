<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\MultiplicacionController;

Route::get('/multiplicar/{numero1?}/{numero2?}/{limiteFibonacci?}', [MultiplicacionController::class, 'tablasMultiplicar'])
-> where('numero1', '[0-9]')
-> where('numero2', '[0-9]')
-> where('limiteFibonacci', '[a-z]+');

Route::post('persona', [MultiplicacionController::class, 'stores']);

use App\Http\Controllers\PhotoController;

Route::get('/humanos', [PhotoController::class, 'index']);
Route::get('/humanos/{id}', [PhotoController::class, 'show']);
Route::post('/humanos', [PhotoController::class, 'store']);
Route::put('/humanos/{id}', [PhotoController::class, 'update']);
Route::delete('/humanos/{id}', [PhotoController::class, 'destroy']);


use App\Http\Controllers\AhorcadoController;
Route::post('/iniciar-juego', [AhorcadoController::class, 'iniciarJuego']);
Route::post('/adivinar/{letra}', [AhorcadoController::class, 'adivinar']);

