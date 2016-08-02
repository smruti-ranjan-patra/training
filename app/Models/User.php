<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Log;

class User extends Model
{
	/**
	 * Fillable fields
	 * 
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'middle_name',
		'last_name',
		'prefix',
		'gender',
		'dob',
		'email',
		'password',
		'marital_status',
		'employment',
		'employer',
		'photo',
		'extra_note',
		'comm_id',
		'key',
		'is_active'
	];

	/**
	 * Get the address that owns the user.
	 */
	public function address()
	{
		return $this->hasMany('App\Models\Address');
	}

	/**
	 * To insert data into users tabel.
	 *
	 * @param  array $post_data
	 * @return void
	 */
	public static function store ($post_data)
	{
		try
		{
			$user = User::create(
				[
					'first_name' => $post_data['first_name'],
					'middle_name' => $post_data['middle_name'],
					'last_name' => $post_data['last_name'],
					'email' => $post_data['email'],
					'password' => Hash::make($post_data['password']),
					'twitter_name' => $post_data['twitter_name'],
					'prefix' => $post_data['prefix'],
					'gender' => $post_data['gender'],
					'dob' => $post_data['dob'],
					'marital_status' => $post_data['marital_status'],
					'employment' => $post_data['employment'],
					'employer' => $post_data['employer'],
					'extra_note' => $post_data['notes'],
					'comm_id' => $post_data['comm_val']
				]);

			User::find($user->id)->update(['key' => Hash::make( $user->id . $post_data['password'])]);
			return $user->id;
		}
		catch(\Exception $e)
		{
			Log::error($e);
			return 0;
		}

		// Address::create();
	}

	/**
	 * To upload the profile image
	 *
	 * @param  integer  $id
	 * @param  string  $image_name
	*/
	public static function imageUpload($id, $image_name)
	{
		User::find($id)->update(['photo' => $image_name]);
	}

	/**
	 * To Update all data
	 *
	 * @param  string  $key
	*/
	public static function updateUser ($post_data)
	{
		User::where('id', '=', $post_data['id'])
					->update(
						[
							'first_name' => $post_data['first_name'],
							'middle_name' => $post_data['middle_name'],
							'last_name' => $post_data['last_name'],
							'email' => $post_data['email'],
							'password' => Hash::make($post_data['password']),
							'twitter_name' => $post_data['twitter_name'],
							'prefix' => $post_data['prefix'],
							'gender' => $post_data['gender'],
							'dob' => $post_data['dob'],
							'marital_status' => $post_data['marital_status'],
							'employment' => $post_data['employment'],
							'employer' => $post_data['employer'],
							'extra_note' => $post_data['notes'],
							'comm_id' => $post_data['comm_val'],
							'photo' => $post_data['pic_name']
						]);
	}

	/**
	 * To delete data from users tabel.
	 *
	 * @param  integer $id
	 * @return void
	 */
	public static function deleteRecord ($id)
	{
		User::where('id', '=', $id)->delete();
	}

	/**
	 * To verify though mail
	 *
	 * @param  string  $key
	*/
	public static function verifyLink ($key)
	{
		try
		{
			$user = User::where('key', $key)->first();
			User::find($user->id)->update(['is_active' => 1]);
			return 1;
		}
		catch(\Exception $e)
		{
			Log::error($e);
			return 0;
		}
	}

	/**
	 * To select all data
	 *
	 * @param  string  $key
	*/
	public static function retrieveData ($id)
	{
		return User::with('address')->where('id', $id)->get();
	}
}