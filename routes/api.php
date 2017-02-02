<?php

use Illuminate\Http\Request;

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


//Rutas para obtener datos de los concursantes
Route::group(['prefix' => 'contestants'], function(){

		Route::get('/{contest_id}', 'ApiController@getContestants');
});

Route::group(['prefix' => 'votes'], function(){

		Route::post('/save', 'ApiController@vote');
});

//Ruta para verificar si el host ya realizo el voto en dicho concurso

Route::get('verifyIp/{id}', 'ApiController@verifyIp');