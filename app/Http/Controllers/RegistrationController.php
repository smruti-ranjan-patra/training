<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;

class RegistrationController extends Controller
{
	/**
		 * Show registration form
		 *
		 * @param  Request  $request
	*/
	public function register(Request $request)
	{
		$state_list = config( 'constants.state_list' );
		return view('registration', ['state_list' => $state_list ]);
	}

	/**
		 * Process registration form
		 *
		 * @param  Request  $request
	*/
	public function doRegister(Request $request)
	{
		$state_list = config( 'constants.state_list' );
		// echo "<pre>";
		// print_r($request->all());
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

// print_r($request->comm);exit();
		$state_string = implode(',', array_keys($state_list));
		$comm_array = ['1','2','3','4'];

		$this->validate($request, [
							'first_name' => 'required|alpha|min:2|max:15',
							'middle_name' => 'alpha|max:15',
							'last_name' => 'required|alpha|min:2|max:15',
							'email' => 'required|email',
							'password' => 'required|min:8|max:12',
							'twitter' => 'max:15',
							'prefix' => 'in:mr,ms,mrs',
							'gender' => 'in:male,female,others',
							'dob' => 'required',
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

					], $messages);

		// echo "<pre>";
		// print_r($request->all());exit;
		$comm = $request->get('comm');

		if ( !empty( $comm ) && empty( array_intersect( $comm, $comm_array) ) )
		{
			return redirect('register')->with( 'redirect_error', 'invalid com selection' )
																	->withInput();
		}
		// else
		// {
		// 	dd('yes');
		// }

		$data = $request->all();

		if(isset($comm))
		{
			$data['comm_val'] = implode(', ', $comm);
		}
		else
		{
			$data['comm_val'] = '';
		}

		if($request->hasFile('pic'))
		{
			$data['pic'] = $request->file('pic')->getClientOriginalName();		
		}
		else
		{
			$data['pic'] = '';
		}

		$user_insert_id = User::store($data);

		if($user_insert_id)
		{
			$data['id'] = $user_insert_id;
			Address::store($data);
		}
		else
		{
			return view('registration', ['db_insert_error', 'Please try again after sometime']);
		}
	}

}
