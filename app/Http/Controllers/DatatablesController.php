<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Yajra\Datatables\Datatables;
use DB;

class DatatablesController extends Controller
{
	/**
	 * Displays datatables front end view
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex(Request $request)
	{

		if ( $request->ajax() )
		{
			$query = User::select('id', 'prefix', 'first_name', 'middle_name', 'last_name', 'email', 'gender', 'dob');

			return Datatables::of($query)
											->remove_column('middle_name')
											->remove_column('last_name')
											->edit_column('id', function($query)
												{
													static $serial = 0;
													return ++$serial;
												})
											->edit_column('prefix', '{{ucfirst($prefix)}}')
											// ->edit_column('first_name', '{{ucfirst($first_name)}} {{ucfirst($middle_name)}} {{ucfirst($last_name)}}')
											->edit_column('first_name', function ($query)
											{
												return '<div class="full_name" data_userid="' . $query->id . '">' . '<a href="" onClick="return false;">' . ucfirst($query->first_name) . ' ' . ucfirst($query->middle_name) . ' ' . ucfirst($query->last_name) . '</a></div>';
											})
											->edit_column('email', '{{$email}}')
											->edit_column('gender', '{{ucfirst($gender)}}')
											->edit_column('dob', '{{ date("jS M Y", strtotime($dob))}}')
											->add_column('action', function ($query)
												{
													return '<div class="dropdown">
													<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Click
													<span class="caret"></span></button>
													<ul class="dropdown-menu">
														<li id="view_details" "data-toggle="modal" data-target="#myModal"><a class="view_details" user_id="' . $query->id . '" href="#">View</a></li>
														<li><a href="edit?id=' . $query->id .'">Edit</a></li>
														<li><a href="delete?id=' . $query->id . '">Delete</a></li>
													</ul>
												</div>';
												})
											->make(true);
		}
		else
		{
			return view('datatables.index');
		}

	}
}
