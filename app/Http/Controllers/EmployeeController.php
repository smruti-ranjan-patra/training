<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\CommunicationMedium;
use Auth;
use Twitter;
use Log;

class EmployeeController extends Controller
{
	/**
	 * Handle Employee Edit
	 *
	 * @param  Request  $request
	 *
	 * @return view
	*/
	public function edit(Request $request)
	{
		$state_list = config( 'constants.state_list' );
		$emp_data = User::retrieveData($request->id);
		$comm_medium = CommunicationMedium::retrieveData();

		return view('registration', ['emp_data' => $emp_data, 'state_list' => $state_list, 'comm_medium' => $comm_medium]);
	}

	/**
	 * Handle Employee Delete
	 *
	 * @param  Request  $request
	 *
	 * @return redirect
	*/
	public function delete(Request $request)
	{

		if(auth()->user()->id == $request->id || Auth::user()->role_id == 1)
		{
			User::deleteRecord($request->id);
		}

		if(Auth::user()->role_id == 1)
		{
			return redirect('details');
		}
		else
		{
			$request->session()->flush();
			return redirect('login');
		}
	}

	/**
	 * To view employee details
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	public function view(Request $request)
	{
		$emp_data = User::retrieveData($request->id);

		$name = ucfirst($emp_data[0]->prefix) . ' ' . ucfirst($emp_data[0]->first_name) . ' ' . ucfirst($emp_data[0]->middle_name) . ' ' . ucfirst($emp_data[0]->last_name);

		$r_state = config( 'constants.state_list.' . $emp_data[0]->address[0]->state);
		$o_state = config( 'constants.state_list.' . $emp_data[0]->address[1]->state);

		$emp_data[0]->address[0]->state = $r_state;
		$emp_data[0]->address[1]->state = $o_state;

		$res_add = EmployeeController::displayAddress($emp_data[0], 'residence');
		$off_add = EmployeeController::displayAddress($emp_data[0], 'office');

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

	/**
	 * To display address
	 *
	 * @param  string $data
	 *
	 * @return string $display_string
	*/
	public static function displayAddress($employee, $type = 'residence')
	{
		$display_string = '';
		$flag = ($type == 'residence') ? 0 : 1;
		$fields = ['street', 'city', 'state', 'zip', 'phone', 'fax'];
		
		foreach($fields as $field)
		{
			$data = $employee->address[$flag]->$field;

			if($data === '' || $data === '0')
			{
				$display_string .= '';
			}
			else
			{
				$display_string .= $data . ', ';
			}
		}

		$display_string = rtrim($display_string, ", ");
		return $display_string;
	}

	/**
	 * Fetch Twitter data
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	public function twitter(Request $request)
	{
		try
		{
			$twitter_name = User::retrieveData($request->id)[0]->twitter_name;
			$num_tweets = $request->num_tweets;

			if($twitter_name == null)
			{
				return response()->json(['err_msg' => 'Twitter account not given', 'err_val' => 2]);
			}
			else
			{			
				$response = Twitter::getUserTimeline(['screen_name' => $twitter_name, 'count' => $num_tweets, 'format' => 'object']);
				$image = str_replace("normal","400x400",$response[0]->user->profile_image_url);
				$user_name = $response[0]->user->name;
				$result = array();

				for($i=0; $i<$num_tweets; $i++)
				{
					if($response[$i]->text != '')
					{
						$result[$i] = $response[$i]->text;
					}
				}
			}

			return response()->json(['tweet_results' => $result, 'image' => $image, 'user_name' => $user_name]);
		}
		catch(\Exception $e)
		{
			Log::error($e);
			return response()->json(['err_msg' => 'Invalid Twitter account', 'err_val' => 1]);
		}

	}
}
