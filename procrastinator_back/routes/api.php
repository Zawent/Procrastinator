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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', UserApiController::class);
Route::apiResource('informacion', InformacionApiController::class);
Route::apiResource('app', AppApiController::class);
Route::apiResource('bloqueo', BloqueoApiController::class);
Route::apiResource('comodin', ComodinApiController::class);
Route::apiResource('consejo', ConsejoApiController::class);
Route::apiResource('nivel', NivelApiController::class);
Route::apiResource('respuesta', RespuestaApiController::class);
Route::apiResource('rol', RolApiController::class);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signUp']);
  
    Route::group([  
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class,'logout']);
        Route::get('user', [AuthController::class,'user']);
    });
    Route::post('/comodin/ganar/{id_app}', 'ApiController@ganarComodin');

});












