<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
		return view('welcome');
});

Route::get('home', function () {
		return view('home');
});

Route::group(['middleware' => 'user_access'], function ()
{
	Route::get('dashboard', 
		[
			'as' => 'dashboard',
			'uses' => 'DashBoardController@dashboard'
		]);

	Route::get('details', ['uses' => 'DatatablesController@getIndex']);
	Route::get('edit', 'EmployeeController@edit');
	Route::get('delete', 'EmployeeController@delete');
	Route::get('view', 'EmployeeController@view');
	Route::get('add_user', 'AuthController@register');

});


Route::get('register', 
	[
		'as' => 'register',
		'uses' => 'AuthController@register'
	]);

Route::post('do-register', 
	[
		'as' => 'do-register',
		'uses' => 'AuthController@doRegister'
	]);

Route::get('login', 
	[
		'as' => 'login',
		'uses' => 'AuthController@login'
	]);

Route::post('do-login', 
	[
		'as' => 'do-login',
		'uses' => 'AuthController@doLogin'
	]);

Route::get('logout', 
	[
		'as' => 'logout',
		'uses' => 'DashBoardController@logout'
	]);

Route::get('login/verify', 
	['uses' => 'AuthController@emailVerification']);

/*Route::controller('datatables', 'DatatablesController', 
	[
		'anyData'  => 'datatables.data',
		'getIndex' => 'datatables'
	]);*/

// Route::get('datatables', ['uses' => 'DatatablesController@getIndex']);




Route::get('calculator/{operation}/{val1?}/{val2?}', function ($operation, $val1='', $val2='')
	{
		if($val1 == '' || $val2 == '')
		{
			return 'Parameters missing !!!';
		}
		else if($operation == 'add')
		{
			add($val1, $val2);
		}
		else if($operation == 'subtract')
		{
			subtract($val1, $val2);
		}
		else if($operation == 'multiply')
		{
			multiply($val1, $val2);
		}
		else if($operation == 'division')
		{
			division($val1, $val2);
		}
		else
		{
			return 'Invalid Operation';
		}
	})->where(array('val1' => '^-?\d+(\.\d)?$', 'val2' => '^-?\d+(\.\d)?$'));

function add($num1, $num2)
{
	$result = $num1 + $num2;
	echo 'The result is ' . $result;
}

function subtract($num1, $num2)
{
	$result = $num1 - $num2;
	echo 'The result is ' . $result;
}

function multiply($num1, $num2)
{
	$result = $num1 * $num2;
	echo 'The result is ' . $result;
}

function division($num1, $num2)
{
	try
	{
		$result = $num1 / $num2;
		echo 'The result is ' . $result;
	}
	catch(Exception $e)
	{
		echo 'Divide by zero not possible';
	}
}




// Route::get('/', function () {
// 	echo "Hi";
//     return view('welcome');
// });

// Route::get('/', ['as' => 'profile', function () {
//     return view('welcome');
// }]);

// Route::get('profile-1/{name}', function ($name) {
//     		return 'Hello ' . $name;
//        })->where('name', '[A-Za-z]+');

 Route::get('profile/{name?}', function ($name = 'Scott') {
				return 'Hello ' . $name;
			 })->where('name', '[A-Za-z]+');

// Route::group(['prefix' => 'admin'], function () {
//     Route::get('users', function ()    {
//         // Matches The "/admin/users" URL
//     });
// });