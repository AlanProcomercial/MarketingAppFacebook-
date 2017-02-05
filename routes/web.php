<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontendController@index');

Route::group(['prefix' => 'contests'], function(){

		Route::get('/', 'FrontendController@contests');

		Route::get('/all', array('as' => 'all.contest',
								'middleware' => array('auth', 'role:admin'), 
								'uses' => 'ContestController@getAll'));

		Route::put('/{id}', array('as' => 'update.contest',
								'middleware' => array('auth', 'role:admin'), 
								'uses' => 'ContestController@update'));

		Route::get('/{slug}', array('as' => 'contest.show',
									'uses' => 'FrontendController@showContest'));

		Route::get('/apply/{slug}', array('as' => 'contest.applie',
										  'middleware' => 'auth',
										  'uses' => 'FrontendController@applieContest'));

		Route::post('/apply/{id}', array('as' => 'apply.save',
										 'middleware' => 'auth',
										 'uses' => 'FrontendController@saveApplie'));

});

Route::group(['prefix' => 'contestants'], function(){

		Route::get('/', array('as' => 'all.contestants',
							   'middleware' => array('auth', 'role:admin'), 
							   'uses' => 'ContestantController@getAll'));

		Route::get('/{contest_id}', 'ContestantController@getAllInContest');

		Route::put('/{id}', array('as' => 'update.vote',
								  'middleware' => array('auth', 'role:admin'), 
								  'uses' => 'ContestantController@updateVote'));

		Route::delete('/{id}', array('as' => 'delete.contestant',
									 'middleware' => array('auth', 'role:admin'), 
									 'uses' => 'ContestantController@delete'));

		Route::put('/ban/{id}', array('as' => 'ban.contestant',
									  'middleware' => array('auth', 'role:admin'), 
									  'uses' => 'ContestantController@updateBan'));

		Route::post('/results', array('as' => 'search.contestants',
									  'middleware' => array('auth', 'role:admin'), 
									  'uses' => 'ContestantController@filterResults'));

});

Route::group(['prefix' => 'votes'], function(){

		Route::post('/save', 'FrontendController@vote');
});

//Rutas para la administracion
Route::group(['prefix' => 'admin', 'middleware' => array('auth', 'role:admin')], function(){

		Route::get('/','BackendController@index');

		Route::get('/contests', 'BackendController@contests');

		Route::get('/contestants', 'BackendController@contestants');
});

Auth::routes();



/***Ruta para verificar si el host ya realizo el voto en dicho concurso ***/

Route::get('verifyIp/{id}', 'FrontendController@verifyIp');

/*** Facebook Routes ****/
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');
