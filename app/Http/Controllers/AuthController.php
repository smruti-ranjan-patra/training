<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Address;
use App\Models\CommunicationMedium;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Permission;
use App\Models\RoleResourcePermission;
use Auth;
use Mail;
use Hash;
use Log;
use Socialite;

class AuthController extends Controller
{
	public $comm_array = ['1','2','3','4'];

	/**
	 * To validate the fields
	 *
	 * @param  Request  $request
	 * @param  integer  $user_id
	 * @return boolean
	*/
	public function validateRequest($request, $user_id)
	{
		$state_list = config( 'constants.state_list' );

		$messages = [
			'first_name.required' => 'First Name is required!!!',
			'first_name.min' => 'First Name must be between 2 to 15 characters!!!',
			'first_name.max' => 'First Name must be between 2 to 15 characters!!!',
			'first_name.alpha' => 'First Name must can contain only alphabets!!!',
			'r_street.required' => 'Please provide Residence street address',
			'o_street.required' => 'Please provide Office street address',
			'r_city.required' => 'Please provide Residence city address',
			'o_city.required' => 'Please provide Office city address',
			'r_state.required' => 'Please select a valid Residence state',
			'o_state.required' => 'Please select a valid Office state',
			'r_zip.required' => 'Please provide Residence Zip code',
			'o_zip.required' => 'Please provide Office Zip code',
			'r_phone.required' => 'Please provide Residence Phone no.',
			'o_phone.required' => 'Please provide Office Phone no.',
			'r_fax.required' => 'Please provide Residence Fax no.',
			'o_fax.required' => 'Please provide Office Fax no.'
		];

		$state_string = implode(',', array_keys($state_list));
		$val_array = [
			'first_name' => 'required|alpha|min:2|max:15',
			'middle_name' => 'alpha|max:15',
			'last_name' => 'alpha|min:2|max:15',
			'email' => 'required|email|unique:users,email,' . $user_id,
			'password' => 'required|min:8|max:12',
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
			'o_fax' => 'numeric|digits_between:7,11',
			'pic' => 'image|mimes:jpeg,jpg,JPG,JPEG|max:6144'
		];

		$this->validate($request, $val_array, $messages);
		return true;
	}

	/**
	 * Show registration form
	 *
	 * @param  Request  $request
	*/
	public function register(Request $request)
	{
		$state_list = config( 'constants.state_list' );
		$comm_medium = CommunicationMedium::retrieveData();
		return view('registration', ['state_list' => $state_list, 'comm_medium' => $comm_medium]);
	}

	/**
	 * Process registration form
	 *
	 * @param  Request  $request
	 * @return mixed
	*/
	public function doRegister(Request $request)
	{
		$data = $request->all();
		$comm = $request->get('comm');

		if (!empty($comm) && empty(array_intersect($comm, $this->comm_array)))
		{
			return redirect('register')->with( 'redirect_error', 'invalid communication medium selection' )
										->withInput();
		}

		if(isset($comm))
		{
			$data['comm_val'] = implode(', ', $comm);
		}
		else
		{
			$data['comm_val'] = '';
		}

		if($request->id !== 0)
		{
			// Update Data
			if($this->validateRequest($request, $request->id))
			{
				if($request->hasFile('pic'))
				{
					$pic_name = AuthController::imageUpload($request, $request->id);
				}
				else
				{
					$pic_name = User::retrieveData($request->id)[0]->photo;
				}

				$data['pic_name'] = $pic_name;
				User::updateUser($data);
				Address::updateAddress($data);
				return redirect('details');
			}
		}
		else
		{
			// Create user data
			if($this->validateRequest($request, 0))
			{
				$user_insert_id = User::store($data);

				if($request->hasFile('pic'))
				{
					$pic_name = AuthController::imageUpload($request, $user_insert_id);
				}
				else
				{
					$pic_name = '';
				}

				User::imageUpload($user_insert_id, $pic_name);

				if($user_insert_id !== 0)
				{
					$data['id'] = $user_insert_id;
					$address_insert_status = Address::store($data);

					
					if($address_insert_status == 1)
					{
						// Successful insertion of data in address table

						if(auth()->user() != null)
						{
							// Adding User by Admin
							$mail_text = 'Your new account has been created by ' . Auth::user()->first_name . ' ' . Auth::user()->last_name . ' and your password is : ' . $request->password;

							Mail::raw($mail_text, function ($message) use ($request)
							{
								$message->from('1234asdf56789@gmail.com', 'Laravel');
								$message->to($request->email, 'Hello User')->subject('New Account');
							});

							User::find($user_insert_id)->update(['is_active' => 1]);

							return redirect('dashboard');
						}						
						else
						{
							// User registering its own details
							\Session::flash('flash_message', 'A verification link has been sent to the registered mail id');

							$key = User::find($user_insert_id)->key;
							$url = url('login/verify?key=') . $key;

							Mail::send('email', ['url' => $url], function ($message) use ($request)
							{
								$message->from('1234asdf56789@gmail.com', 'Laravel');
								$message->to($request->email, 'Hello User')->subject('Email Verification');
							});

							return redirect('login');
						}
					}
					else
					{
						//Unsuccessful insertion of data in address table
						User::deleteRecord($user_insert_id);
						return view('registration', ['db_insert_error', 'Please try again after sometime']);
					}
				}
				else
				{
					return view('registration', ['db_insert_error', 'Please try again after sometime']);
				}
			}
		}
	}

	/**
	 * To upload the profile image
	 *
	 * @param  Request  $request
	 * @param  integer  $id
	*/
	public static function imageUpload($request, $id)
	{
		$image_name = $request->file('pic')->getClientOriginalName();
		$temp_file = public_path( 'images/profile_pic/' );
		$request->file('pic')->move( $temp_file, $id . '_' . $image_name );

		return $id . '_' . $image_name;
	}

	/**
	 * Show login form
	 *
	 * @param  Request  $request
	 * @return mixed
	*/
	public function login(Request $request)
	{
		if(Auth::check())
		{
			return redirect('dashboard');
		}
		else
		{
			return view('login');
		}
	}

	/**
	 * Process login form
	 *
	 * @param  Request  $request
	 * @return RedirectResponse
	*/
	public function doLogin(Request $request)
	{
		$messages = [
			'email.required' => 'Email is required!!!',
			'password.required' => 'Password is required!!!',
			'password.min' => 	'Password must be between 8 to 12!!!',
			'password.max' => 	'Password must be between 8 to 12!!!',
		];

		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|min:8|max:12'
		], $messages);

		if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1]))
		{
			return redirect('dashboard');
		}
		else
		{
			return redirect('login')->with( 'redirect_error', 'Invalid email id or password provided' );
		}
	}

	/**
	 * To verify though mail
	 *
	 * @param  object $request
	 * @return RedirectResponse
	*/
	public function emailVerification(Request $request)
	{
		$verification_success = User::verifyLink($request->key);

		if($verification_success)
		{
			\Session::flash('flash_message', 'Your account is active now');
			return redirect('login');
		}
		else
		{
			return redirect('login')->with( 'redirect_error', 'You have clicked on an invalid verification link' );
		}
	}

	/**
	 * To open reset password form
	 *
	 * @param  object $request
	 * @return View
	*/
	public function resetPassword(Request $request)
	{
		return view('reset_password');
	}

	/**
	 * To reset the user password
	 *
	 * @param  object $request
	 * @return RedirectResponse
	*/
	public function doResetPassword(Request $request)
	{
		try
		{
			$new_password = AuthController::randStrGen(8);

			User::where('email', '=', $request->email)
				->update(
					[
						'password' => Hash::make($new_password)
					]);
			
			$user = User::where('email', $request->email)->first();
			User::where('id', '=', $user->id)
				->update(
					[
						'key' => Hash::make( $user->id . $new_password )
					]);

			$this->validate($request, [
					'email' => 'required|email'
			]);

			$mail_text = 'The new password for your email id - ' . $request->email . ' is  ' . $new_password;

			Mail::raw($mail_text, function ($message) use ($request)
			{
				$message->from('1234asdf56789@gmail.com', 'Laravel');
				$message->to($request->email, 'Hello User')->subject('Reset Password');
			});

			\Session::flash('flash_message', 'Your new password has been sent to the registered mail id');
			return redirect('login');
		}
		catch(\Exception $e)
		{
			Log::error('Reset Password error - ' . $e);
			return redirect('reset-password')->with('db_insert_error', 'Invalid email id !');
		}
	}

	/**
	 * To generate a random string password
	 *
	 * @param  integer $len
	 * @return string $result
	*/
	public static function randStrGen($len)
	{
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyz$0123456789";
		$charArray = str_split($chars);
		
		for($i = 0; $i < $len; $i++)
		{
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}

		return $result;
	}

	/**
	 * To display the permission manager
	 *
	 * @param  void
	 * @return View
	*/
	public function displayPermissionManager()
	{
		$roles = Role::retrieveData();
		$resources = Resource::retrieveData();
		$permissions = Permission::retrieveData();
		$rrp = RoleResourcePermission::retrieveData();
		$selected_permission = [];

		foreach($rrp as $value)
		{
			$selected_permission[$value->fk_role . '-' . $value->fk_resource . '-' . $value->fk_permission] = true;
		}

		return view('permission_manager', ['roles' => $roles, 'resources' => $resources, 'permissions' => $permissions, 'selected_permission' => $selected_permission]);
	}

	/**
	 * To display the permission manager
	 *
	 * @param  Request  $request
	 * @return void
	*/
	public function changePermission(Request $request)
	{
		if($request->is_checked == 1)
		{
			RoleResourcePermission::insertData($request->id);
		}
		else
		{
			RoleResourcePermission::deleteData($request->id);
		}
	}

	/**
	 * Redirect the user to the LinkedIn authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProviderLinkedin()
	{
		return Socialite::driver('linkedin')->redirect();
	}

	/**
	 * Redirect the user to the Twitter authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProviderTwitter()
	{
		return Socialite::driver('twitter')->redirect();
	}

	/**
	 * Obtain the user information from all api.
	 *
	 * @return Response
	 */
	public function handleProviderCallback(Request $request = null)
	{		
		if(isset($request->error) && $request->error == 'user_cancelled_login')
		{
			// User cancels login through linkedIn
			return redirect('login');
		}

		if($request->type == 'twitter')
		{
			$user = Socialite::driver('twitter')->user();
		}
		elseif($request->type == 'linkedin')
		{
			$user = Socialite::driver('linkedin')->user();
		}
		else
		{
			return redirect('login');
		}

		$email = $user->getEmail();

		if($email == null)
		{
			return redirect('login')->with('redirect_error', 'You have not provided email id in your social media profile');
		}

		$name = explode(" ", $user->getName());
		$first_name = $name[0];
		$last_name = (isset($name[2])) ? $name[2] : '';
		$middle_name = (isset($name[1])) ? $name[1] : '';
		$password = env('DEFAULT_PASSWORD', '12341234');
		$id = User::getId($email);

		if($id != 0)
		{
			// Login the existing user
			Auth::loginUsingId($id);
			return redirect('dashboard');
		}
		else
		{
			// Create User data for new user
			$user_data = array(
				'first_name' => $first_name,
				'middle_name' => $middle_name,
				'last_name' => $last_name,
				'email' => $email,
				'password' => $password
				);

			$new_user_id = User::store($user_data);

			if($new_user_id != 0)
			{
				// Successful insertion of data in users table
				User::imageUpload($new_user_id, '');
				$address_data = array('id' => $new_user_id);
				$address_insert_status = Address::store($address_data);

				if($address_insert_status != 0)
				{
					// Successful insertion of data in address table
					Auth::loginUsingId($new_user_id);
					return redirect('dashboard');
				}
				else
				{
					// Unsuccessful insertion of data in address table
					User::deleteRecord($new_user_id);
					return view('login', ['db_insert_error', 'Please try again after sometime']);
				}
			}
			else
			{
				//Unsuccessful insertion of data in users table
				return view('login', ['db_insert_error', 'Please try again after sometime']);
			}
		}

	}

}
