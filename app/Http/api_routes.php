<?php

Route::group(['prefix' => 'api/v1/', 'middleware' => 'api_access'], function ()
{
	Route::post('users/details/{id?}', 
	[
		'middleware' => 'api',
		'uses' => 'ApiController@getUsers'
	]);
	Route::post('users/create', 
	[
		'middleware' => 'api',
		'uses' => 'ApiController@createUsers'
	]);
	Route::post('users/update/{id}', 
	[
		'middleware' => 'api',
		'uses' => 'ApiController@updateUsers'
	]);
	Route::post('users/delete/{id}', 
	[
		'middleware' => 'api',
		'uses' => 'ApiController@deleteUsers'
	]);
});
