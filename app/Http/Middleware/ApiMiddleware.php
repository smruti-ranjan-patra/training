<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use Auth;
use App\Models\User;

class ApiMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$email = isset($request->email) ? $request->email : '';
		$password = isset($request->password) ? $request->password : '';

		$messages = [
			'email.required' => 'Email is required',
			'email.email' => 'Invalid email id',
			'password.required' => 'Password is required',
			'limit.numeric' => 'Invalid limit provided, only numbers accepted',
			'limit.min' => 'Limit can not be negative'

		];

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required',
			'limit' => 'numeric|min:0',
			'offset' => 'numeric'
		], $messages);

		if($validator->fails())
		{
			return response()->json(['error' => 401, 'message' => $validator->messages()], 401);
		}

		if(Auth::once(['email' => $email, 'password' => $password, 'is_active' => 1]))
		{
			return $next($request);
		}
		else
		{
			return response()->json(['error' => 401, 'message' => 'Invalid Login Credentials'], 401);
		}
	}
}
