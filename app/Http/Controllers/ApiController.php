<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Address;
use App\Models\CommunicationMedium;
use Validator;
use Auth;
use Log;

class ApiController extends Controller
{
	/**
	 * To error in URL
	 *
	 * @param  Request  $request
	 * @return response
	*/
	public function postIndex(Request $request)
	{
		return response()->json(['error' => 1404, 'message' => 'URL not found']);
	}

	/**
	 * To validate the fields
	 *
	 * @param  Request  $request
	 * @param  integer  $user_id
	 * @return mixed
	*/
	public static function validateRequest($request, $user_id)
	{
		$state_list = config( 'constants.state_list' );
		$state_string = implode(',', array_keys($state_list));

		$messages = [
			'first_name.required' => 'First Name is required',
			'first_name.min' => 'First Name must be between 2 to 15 characters',
			'first_name.max' => 'First Name must be between 2 to 15 characters',
			'first_name.alpha' => 'First Name must can contain only alphabets'
		];

		$val_array = [
			'first_name' => 'required|alpha|min:2|max:15',
			'middle_name' => 'alpha|max:15',
			'last_name' => 'alpha|min:2|max:15',
			'new_email' => 'required|email|unique:users,email,' . $user_id,
			'new_password' => 'required|min:8|max:12',
			'twitter' => 'max:15',
			'prefix' => 'in:mr,ms,mrs',
			'gender' => 'in:male,female,others',
			'dob' => 'date',
			'marital' => 'in:single,married',
			'employment' => 'in:employed,unemployed',
			'employer' => 'max:20',
			'r_street' => 'alpha_dash|max:20',
			'o_street' => 'alpha_dash|max:20',
			'r_city' => 'alpha|max:20',
			'o_city' => 'alpha|max:20',
			'r_state' => 'in:' . $state_string,
			'o_state' => 'in:' . $state_string,
			'r_zip' => 'numeric|digits_between:5,6',
			'o_zip' => 'numeric|digits_between:5,6',
			'r_phone' => 'numeric|digits_between:7,11',
			'o_phone' => 'numeric|digits_between:7,11',
			'r_fax' => 'numeric|digits_between:7,11',
			'o_fax' => 'numeric|digits_between:7,11'
		];

		$validator = Validator::make($request->all(), $val_array, $messages);

		if($validator->fails())
		{
			return $validator->messages()->all();
		}
		else
		{
			return true;
		}
	}

	/**
	 * To check and call specific functions
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	public function postUsers(Request $request, $one = '', $two = '')
	{
		if(!ctype_digit($one) && $one != 'create' && $one != 'update' && $one != 'delete' && $one != null)
		{
			$json_response = response()->json(['error' => 1404, 'message' => 'URL not found'], 404);
		}
		else
		{
			switch($one)
			{
				case 'create':
						$json_response = ApiController::create($request);
						break;

				case 'update':
						$json_response = ApiController::update($request, $two);
						break;

				case 'delete':
						$json_response = ApiController::delete($two);
						break;

				default:
						$json_response = ApiController::details($request, $one);
						break;
			}
		}

		return $json_response;
	}

	/**
	 * To fetch all employee details
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	private static function details(Request $request, $id = 0)
	{
		$limit = isset($request->limit) ? $request->limit : User::get()->count();
		$offset = isset($request->offset) ? $request->offset : 0;
		$name = isset($request->name) ? $request->name : '';
		$street = isset($request->street) ? $request->street : '';
		$city = isset($request->city) ? $request->city : '';
		$phone = isset($request->phone) ? $request->phone : '';
		$json = array();

		if(isset($request->street) || isset($request->city) || isset($request->phone))
		{
			$address_data = Address::where('street', 'LIKE', '%'.$street.'%')
								->where('city', 'LIKE', '%'.$city.'%')
								->where('phone', 'LIKE', '%'.$phone.'%')
								->first();

			if($address_data == null)
			{
				return response()->json(['error' => 1404, 'message' => 'Invalid city, state or fax'], 404);
			}
			else
			{
				$user_data = User::retrieveData($address_data->user->id);
			}
		}
		elseif($id == 0)
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
			$user_data = User::retrieveData($id);

			if(User::find($id) == null)
			{
				return response()->json(['error' => 1404, 'message' => 'Invalid ID'], 404);
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

		return response()->json(['total_users' => User::get()->count(), 'users_per_page' => count($json),'users' => $json]);
	}

	/**
	 * To create new users
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	private static function create(Request $request)
	{
		$ajax_error = '';
		$error_message = '';
		$http_error = '';
		$valdation_status = ApiController::validateRequest($request, 0);

		if($valdation_status === true)
		{
			$data = $request->all();
			$data['comm_val'] = isset($request->comm_id) ? $request->comm_id : '';
			$data['email'] = $request->new_email;
			$data['password'] = $request->new_password;
			$user_insert_id = User::store($data);

			if($user_insert_id !== 0)
			{
				// Successful insertion of data in user table
				$data['id'] = $user_insert_id;
				$address_insert_status = Address::store($data);

				if($address_insert_status == 1)
				{
					// Successful insertion of data in address table
					User::find($user_insert_id)->update(['is_active' => 1]);
					$ajax_error = '';
					$error_message = 'New user successfully created';
					$http_error = 200;
				}
				else
				{
					//Unsuccessful insertion of data in address table
					User::deleteRecord($user_insert_id);
					$ajax_error = 1500;
					$error_message = 'An error occured, please try after sometime';
					$http_error = 500;
				}
			}
			else
			{
				//Unsuccessful insertion of data in user table
				$ajax_error = 1500;
				$error_message = 'An error occured, please try after sometime';
				$http_error = 500;
			}
		}
		else
		{
			$ajax_error = 1401;
			$error_message = $valdation_status;
			$http_error = 401;
		}

		return response()->json(['error' => $ajax_error, 'message' => $error_message], $http_error);
	}

	/**
	 * To update user data
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	private static function update(Request $request, $id = 0)
	{
		$ajax_error = '';
		$error_message = '';
		$http_error = '';

		if(User::find($id) == null)
		{
			$ajax_error = 1404;
			$error_message = 'Invalid ID';
			$http_error = 404;
		}
		else
		{
			$valdation_status = ApiController::validateRequest($request, $id);

			if($valdation_status === true)
			{
				$data = $request->all();
				$data['id'] = $id;
				$data['comm_val'] = isset($request->comm_id) ? $request->comm_id : '';
				$data['email'] = $request->new_email;
				$data['password'] = $request->new_password;

				try
				{
					User::updateUser($data);
					Address::updateAddress($data);
					$ajax_error = '';
					$error_message = 'User data successfully updated';
					$http_error = 200;
				}
				catch(\Exception $e)
				{
					Log::error('Update user table : '.$e);
					$ajax_error = 1500;
					$error_message = 'An error occured, please try after sometime';
					$http_error = 500;
				}
			}
			else
			{
				$ajax_error = 1401;
				$error_message = $valdation_status;
				$http_error = 401;
			}
		}

		return response()->json(['error' => $ajax_error, 'message' => $error_message], $http_error);
	}

	/**
	 * To delete user
	 *
	 * @param  Request  $request
	 *
	 * @return response
	*/
	private static function delete($id = 0)
	{
		$ajax_error = '';
		$error_message = '';
		$http_error = '';

		if(User::find($id) == null)
		{
			$ajax_error = 1404;
			$error_message = 'Invalid ID';
			$http_error = 404;
		}
		else
		{
			try
			{
				User::deleteRecord($id);
				$ajax_error = '';
				$error_message = 'User successfully deleted';
				$http_error = 200;
			}
			catch(\Exception $e)
			{
				Log::error('Delete user table : '.$e);
				$ajax_error = 1500;
				$error_message = 'An error occured, please try after sometime';
				$http_error = 500;
			}
		}

		return response()->json(['error' => $ajax_error, 'message' => $error_message], $http_error);
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
