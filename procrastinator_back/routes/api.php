<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\InformacionApiController;
use App\Http\Controllers\API\AppApiController;
use App\Http\Controllers\API\BloqueoApiController;
use App\Http\Controllers\API\ComodinApiController;
use App\Http\Controllers\API\ConsejoApiController;
use App\Http\Controllers\API\NivelApiController;
use App\Http\Controllers\API\RespuestaApiController;
use App\Http\Controllers\API\RolApiController;
use App\Http\Controllers\API\PreguntaApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


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

Route::apiResource('app', AppApiController::class)->middleware("auth:api");
Route::apiResource('bloqueo', BloqueoApiController::class)->middleware("auth:api");
Route::apiResource('comodin', ComodinApiController::class)->middleware("auth:api");
Route::apiResource('consejo', ConsejoApiController::class)->middleware("auth:api");
Route::apiResource('nivel', NivelApiController::class)->middleware("auth:api");
Route::apiResource('respuesta', RespuestaApiController::class);
Route::apiResource('rol', RolApiController::class)->middleware("auth:api");
Route::apiResource('pregunta', PreguntaApiController::class)->middleware("auth:api");
Route::get('preguntas/cantidad',[PreguntaApiController::class, 'contar']);
Route::get('comodines/cantidad/{id_user}', [ComodinApiController::class, 'cantidadComodines']);
Route::get('consejo/diario/{id}',[ConsejoApiController::class, 'consejoDiario']);
Route::get('consejos/{id}',[ConsejoApiController::class, 'consejosPorId']);
Route::post('apps/{id_user}',[AppApiController::class, 'listarPorUser']);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signUp']);
  
    Route::group([  
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class,'logout']);
        Route::get('getuser', [AuthController::class,'user']);
        Route::apiResource('user', UserApiController::class);
    });
});












