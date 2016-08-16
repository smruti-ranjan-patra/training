<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Address;
use App\Models\CommunicationMedium;
use Auth;

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
		// $limit = isset($request->limit) ? $request->limit : 5;
		// $offset = isset($request->offset) ? $request->offset : 0;

		if(Auth::once(['email' => $email, 'password' => $password, 'is_active' => 1]))
		{
			$emp_data = User::retrieveData($request->id);
			$comm_medium_tbl = CommunicationMedium::retrieveData();

			/*$json = [];
			$json['total'] = User::with('address')->get()->count();
			foreach(User::with('address')->get() as $key => $value)
			{
				$json['users'][$key] = "$value";
			}
			print_r($json);exit;*/

			$json = array();
			$user_data = User::with('address')->get();
			$i = 0;

			foreach($user_data as $value)
			{
				$json[$i]['first_name'] = $value->first_name;
				$json[$i]['middle_name'] = $value->middle_name;
				$json[$i]['last_name'] = $value->last_name;
				$json[$i]['dob'] = date("jS M Y", strtotime($value->dob));
				$json[$i]['residence_address']['street'] = $value->address[0]->street;
				$json[$i]['residence_address']['city'] = $value->address[0]->city;
				$json[$i]['residence_address']['state'] = config( 'constants.state_list.' . $value->address[0]->state);
				$json[$i]['residence_address']['zip'] = ApiController::displayNumbers($value->address[0]->zip);
				$json[$i]['residence_address']['phone'] = ApiController::displayNumbers($value->address[0]->phone);
				$json[$i]['residence_address']['fax'] = ApiController::displayNumbers($value->address[0]->fax);
				$json[$i]['office_address']['street'] = $value->address[1]->street;
				$json[$i]['office_address']['city'] = $value->address[1]->city;
				$json[$i]['office_address']['state'] = config( 'constants.state_list.' . $value->address[1]->state);
				$json[$i]['office_address']['zip'] = ApiController::displayNumbers($value->address[1]->zip);
				$json[$i]['office_address']['phone'] = ApiController::displayNumbers($value->address[1]->phone);
				$json[$i]['office_address']['fax'] = ApiController::displayNumbers($value->address[1]->fax);

				if($emp_data[0]->photo == '')
				{
					$photo_name = '';
				}
				else
				{
					$photo_name = public_path( 'images/profile_pic/' . $value->photo);
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

					$comm_val = implode(", ", $temp_arr);
				}

				$json[$i]['communicatio_medium'] = $comm_val;
				$i++;
			}

			return response()->json(['users' => $json]);

			
		else
		{
			return response()->json(['error' => 'Invalid login credentials']);
		}
	}

	/**
	 * To display address
	 *
	 * @param  string $data
	 *
	 * @return string $display_string
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
