<?php



Route::group(['prefix' => 'api/v1/', 'middleware' => 'api_access'], function ()
{
	Route::post('users/{id?}', 
	[	
		'middleware' => 'api',
		'uses' => 'ApiController@getUsers'
	]);
});