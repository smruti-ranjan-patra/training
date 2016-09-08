<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

/** 
 * DashBoardController
 * Handles Dashboard of users
 * 
 * @category Controller
 * @author Smruti Ranjan
 */
class DashBoardController extends Controller
{
	/**
	 * Show Dashboard Page
	 *
	 * @param  Request  $request
	*/
	public function dashboard(Request $request)
	{
		$user = Auth::user()->first_name;
		return view('dashboard', ['name' => $user]);
	}

	/**
	 * Log out from dashboard
	 *
	 * @param  Request  $request
	*/
	public function logout(Request $request)
	{
		Auth::logout();
		return redirect('dashboard');
	}
}
