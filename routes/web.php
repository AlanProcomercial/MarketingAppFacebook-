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

		Route::get('/{id}', array('as' => 'contest.show','uses' => 'FrontendController@showContest'));

		Route::get('/apply/{id}', array('as' => 'contest.applie','middleware' => 'auth','uses' => 'FrontendController@applieContest'));

		Route::post('/apply/{id}', array('as' => 'apply.save','middleware' => 'auth','uses' => 'FrontendController@saveApplie'));
});

Auth::routes();

/*** Facebook Routes ****/
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');
