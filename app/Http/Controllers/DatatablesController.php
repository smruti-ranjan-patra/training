<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Yajra\Datatables\Datatables;
use DB;
use Session;
use Auth;
use App\Models\RoleResourcePermission;

class DatatablesController extends Controller
{
	/**
	 * Displays datatables front end view
	 *
	 * @return \Illuminate\View\View
	 */
	public function getIndex(Request $request)
	{
		$can_view = RoleResourcePermission::isAllowed(1);
		$can_edit = RoleResourcePermission::isAllowed(2);
		$can_delete = RoleResourcePermission::isAllowed(3);
		session(['can_view' => $can_view, 'can_edit' => $can_edit, 'can_delete' => $can_delete]);

		if ( $request->ajax() )
		{
			$query = User::select('id', 'prefix', 'first_name', 'middle_name', 'last_name',  'role_id', 'email', 'gender', 'dob');

			return Datatables::of($query)
							->remove_column('middle_name')
							->remove_column('last_name')
							->remove_column('role_id')
							->edit_column('id', function($query)
								{
									static $serial = 0;
									return ++$serial;
								})
							->edit_column('prefix', '{{ucfirst($prefix)}}')
							->edit_column('first_name', function ($query)
							{
								return '<div class="full_name" data_userid="' . $query->id . '">' . '<a href="" onClick="return false;">' . ucfirst($query->first_name) . ' ' . ucfirst($query->middle_name) . ' ' . ucfirst($query->last_name) . '</a></div>';
							})
							->edit_column('email', '{{$email}}')
							->edit_column('gender', '{{ucfirst($gender)}}')
							->edit_column('dob', '{{ date("jS M Y", strtotime($dob))}}')
							->add_column('action', function ($query)
								{
									$flag = 0;
									$display_string = '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Click
									<span class="caret"></span></button>
									<ul class="dropdown-menu">';

									if(Auth::user()->role_id == 1 || (Session::has('can_view') && Session::get('can_view') == 1 && $query->id == Auth::user()->id))
									{
										$display_string .= '<li id="view_details" "data-toggle="modal" data-target="#myModal"><a class="view_details" user_id="' . $query->id . '" href="#">View</a></li>';
										$flag++;
									}

									if(Auth::user()->role_id == 1 || (Session::has('can_view') && Session::get('can_edit') == 1 && $query->id == Auth::user()->id))
									{
										$display_string .= '<li><a href="edit?id=' . $query->id .'">Edit</a></li>';
										$flag++;
									}

									if(Auth::user()->role_id == 1 || (Session::has('can_delete') && Session::get('can_edit') == 1 && $query->id == Auth::user()->id))
									{
										$display_string .= '<li><a href="delete?id=' . $query->id . '">Delete</a></li>';
										$flag++;
									}

									$display_string .= '</ul></div>';

									if($flag == 0)
									{
										return '';
									}

									return $display_string;
								})
							->make(true);
		}
		else
		{
			return view('datatables.index');
		}

	}
}
