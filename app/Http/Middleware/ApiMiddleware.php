<?php

namespace App\Http\Middleware;

use Closure;
use Validator;
use Auth;
use App\Models\User;

/** 
 * ApiMiddleware
 * Handles authentication and authorization of users for API
 * 
 * @category Middleware
 * @author Smruti Ranjan
 */
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
			'email.required' => 'Email id is required',
			'email.email' => 'Invalid email id',
			'password.required' => 'Password is required',
			'limit.numeric' => 'Invalid limit provided, only numbers accepted',
			'limit.min' => 'Limit can not be negative',
			'offset.numeric' => 'Invalid offset provided, only numbers accepted',
			'name.alpha' => 'Name must can contain only alphabets'
		];

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required',
			'limit' => 'numeric|min:0',
			'offset' => 'numeric',
			'name' => 'alpha'
		], $messages);

		if($validator->fails())
		{
			return response()->json(['error' => 1401, 'message' => $validator->messages()->all()], 401);
		}

		if(Auth::once(['email' => $email, 'password' => $password]))
		{
			if(Auth::once(['email' => $email, 'password' => $password, 'is_active' => 1]))
			{
				return $next($request);
			}
			else
			{
				return response()->json(['error' => 1401, 'message' => 'Inactive account'], 401);
			}
		}
		else
		{
			return response()->json(['error' => 1401, 'message' => 'Invalid Login Credentials'], 401);
		}
	}
}
