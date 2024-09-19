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

Route::post('persona', [MultiplicacionController::class, 'store']);

Route::post('crud', [MultiplicacionController::class, 'insert']);

use App\Http\Controllers\AhorcadoController;

Route::post('/iniciar', [AhorcadoController::class, 'iniciarJuego']);
Route::post('/adivinar', [AhorcadoController::class, 'adivinar']);

