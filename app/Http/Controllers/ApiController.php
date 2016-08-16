<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Address;
use App\Models\CommunicationMedium;

class ApiController extends Controller
{
	/**
	 * To fetch all employee details
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	public function getUsers(Request $request)
	{
		$email = isset($request->email) ? $request->email : '';
		$password = isset($request->password) ? $request->password : '';
		$limit = isset($request->limit) ? $request->limit : 5;
		$offset = isset($request->offset) ? $request->offset : 0;

		if(Auth::once(['email' => $request->email, 'password' => $request->password, 'is_active' => 1]))
		{

		}
		else
		{

		}
	}
}
