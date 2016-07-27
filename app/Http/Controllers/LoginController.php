<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;


class LoginController extends Controller
{
	/**
	 * Show login form
	 *
	 * @param  Request  $request
	*/
	public function login(Request $request)
	{

		if(Auth::check())
		{
			return redirect('dashboard');
		}
		else
		{
			return view('login');
		}

	}

	/**
	 * Process login form
	 *
	 * @param  Request  $request
	*/
	public function doLogin(Request $request)
	{
		$messages = [
			'email.required' => 'Email is required!!!',
			'password.required' => 'Password is required!!!',
			'password.min' => 	'Password must be between 8 to 12!!!',
			'password.max' => 	'Password must be between 8 to 12!!!',
		];

		$this->validate($request, [
				'email' => 'required|email',
				'password' => 'required|min:8|max:12'
			], $messages);

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
		{
			return redirect('dashboard');
		}
		else
		{
			return redirect('login')->with( 'redirect_error', 'Login Failed' );
		}

	}
}
