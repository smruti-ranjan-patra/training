<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Address;
use App\Models\CommunicationMedium;
use Auth;
use Log;

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
		$limit = isset($request->limit) ? $request->limit : User::get()->count();
		$offset = isset($request->offset) ? $request->offset : 0;
		$name = isset($request->name) ? $request->name : '';

		$comm_medium_tbl = CommunicationMedium::retrieveData();
		$json = array();

		if($request->id === 0 || $request->id === null)
		{
			$user_data = User::with('address')
								->where('first_name', 'LIKE', '%'.$name.'%')
								->orWhere('middle_name', 'LIKE', '%'.$name.'%')
								->orWhere('last_name', 'LIKE', '%'.$name.'%')
								->take($limit)
								->skip($offset)
								->get();
		}
		else
		{
			$user_data = User::retrieveData($request->id);

			if(User::find($request->id) == null)
			{
				return response()->json(['error' => 404, 'message' => 'Invalid ID'], 404);
			}		
		}

		$i = 0;

		foreach($user_data as $value)
		{
			$json[$i]['first_name'] = $value->first_name;
			$json[$i]['middle_name'] = $value->middle_name;
			$json[$i]['last_name'] = $value->last_name;
			$json[$i]['email'] = $value->email;
			$json[$i]['dob'] = date("jS M Y", strtotime($value->dob));
			$json[$i]['twitter_name'] = $value->twitter_name;
			$json[$i]['address']['residence']['street'] = $value->address[0]->street;
			$json[$i]['address']['residence']['city'] = $value->address[0]->city;
			$json[$i]['address']['residence']['state'] = config( 'constants.state_list.' . $value->address[0]->state);
			$json[$i]['address']['residence']['zip'] = ApiController::displayNumbers($value->address[0]->zip);
			$json[$i]['address']['residence']['phone'] = ApiController::displayNumbers($value->address[0]->phone);
			$json[$i]['address']['residence']['fax'] = ApiController::displayNumbers($value->address[0]->fax);
			$json[$i]['address']['office']['street'] = $value->address[1]->street;
			$json[$i]['address']['office']['city'] = $value->address[1]->city;
			$json[$i]['address']['office']['state'] = config( 'constants.state_list.' . $value->address[1]->state);
			$json[$i]['address']['office']['zip'] = ApiController::displayNumbers($value->address[1]->zip);
			$json[$i]['address']['office']['phone'] = ApiController::displayNumbers($value->address[1]->phone);
			$json[$i]['address']['office']['fax'] = ApiController::displayNumbers($value->address[1]->fax);

			if($value->photo == '')
			{
				$photo_name = '';
			}
			else
			{
				$photo_name = asset('images/profile_pic' . '/' . $value->photo);
			}

			$json[$i]['profile_pic'] = $photo_name;

			if($value->comm_id == '')
			{
				$comm_val = '';
			}
			else
			{	
				$temp_arr = array();
				$comm_arr = explode(", ", $value->comm_id);

				foreach ($comm_arr as $val)
				{
					$temp = CommunicationMedium::where('id', $val)->first()->type;
					$temp_arr[] = $temp;
				}

				$comm_val = $temp_arr;
			}

			$json[$i]['communicatio_medium'] = $comm_val;
			$i++;
		}

		if($limit == User::get()->count())
		{
			return response()->json(['total_users' => User::get()->count(), 'displaying_users' => count($json),'users' => $json]);
		}
		else
		{
			return response()->json(['total_users' => User::get()->count(), 'displaying_users' => count($json), 'users' => $json]);
		}
	}

	/**
	 * To convert zero to empty string
	 *
	 * @param  mixed $num
	 *
	 * @return mixed
	*/
	public static function displayNumbers($num)
	{
		if($num === '' || $num === '0')
		{
			return '';
		}
		else
		{
			return $num;
		}
	}
}
