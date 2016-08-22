<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'api_access'], function ()
{
	Route::controller('/','ApiController');
});
