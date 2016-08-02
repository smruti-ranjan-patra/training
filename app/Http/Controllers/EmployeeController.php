<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\CommunicationMedium;
use Auth;

class EmployeeController extends Controller
{
	/**
	 * Handle Employee Edit
	 *
	 * @param  Request  $request
	*/
	public function edit(Request $request)
	{
		// echo auth()->user()->id;exit;
		$state_list = config( 'constants.state_list' );
		$emp_data = User::retrieveData($request->id);
		$comm_medium = CommunicationMedium::retrieveData();

		return view('registration', ['emp_data' => $emp_data, 'state_list' => $state_list, 'comm_medium' => $comm_medium]);
	}

	/**
	 * Handle Employee Delete
	 *
	 * @param  Request  $request
	*/
	public function delete(Request $request)
	{

		if(auth()->user()->id != $request->id)
		{
			User::deleteRecord($request->id);
		}

		return redirect('details');
	}

	/**
	 * To view employee details
	 *
	 * @param  Request  $request
	*/
	public function view(Request $request)
	{
		$emp_data = User::retrieveData($request->id);
		$comm_medium_tbl = CommunicationMedium::retrieveData();

		$name = ucfirst($emp_data[0]->prefix) . ' ' . ucfirst($emp_data[0]->first_name) . ' ' . ucfirst($emp_data[0]->middle_name) . ' ' . ucfirst($emp_data[0]->last_name);

		$r_state = config( 'constants.state_list.' . $emp_data[0]->address[0]->state);
		$o_state = config( 'constants.state_list.' . $emp_data[0]->address[1]->state);

		$res_add = $emp_data[0]->address[0]->street . ', ' . $emp_data[0]->address[0]->city . ', ' . $r_state . ', ' . $emp_data[0]->address[0]->zip . ', ' . $emp_data[0]->address[0]->phone . ', ' . $emp_data[0]->address[0]->fax;

		$off_add = $emp_data[0]->address[1]->street . ', ' . $emp_data[0]->address[1]->city . ', ' . $o_state . ', ' . $emp_data[0]->address[1]->zip . ', ' . $emp_data[0]->address[1]->phone . ', ' . $emp_data[0]->address[1]->fax;

		if($emp_data[0]->photo == '')
		{
			$photo_name = 'default_' . $emp_data[0]->gender . '.jpg';
		}
		else
		{
			$photo_name = $emp_data[0]->photo;
		}

		$img_path = public_path( 'images/profile_pic/' . $photo_name );

		if(!file_exists($img_path))
		{
			$photo_name = 'no_image_found.jpg';
		}

		if($emp_data[0]->comm_id == '')
		{
			$comm_val = 'none';
		}
		else
		{	
			$temp_arr = array();
			$comm_arr = explode(", ", $emp_data[0]->comm_id);

			foreach ($comm_arr as $value)
			{
				$temp = CommunicationMedium::where('id', $value)->first()->type;
				$temp_arr[] = $temp;
			}

			$comm_val = implode(", ", $temp_arr);
		}


		return response()->json(['photo' => $photo_name, 'full_name' => $name, 'employment' => $emp_data[0]->employment, 'employer' => $emp_data[0]->employer, 'res_add' => $res_add, 'off_add' => $off_add, 'comm_medium' => $comm_val]);
	}
}
