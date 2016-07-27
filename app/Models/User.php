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
		'comm_id'

	];

	/**
	 * To insert data into users tabel.
	 *
	 * @param  array $post_data
	 * @return void
	 */
	public static function store($post_data)
	{
		try
		{
			$user = User::create([
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

			$pic_name = $user->id . '_' . $post_data['pic'];

			User::find($user->id)->update(['photo'=>$pic_name]);
			return $user->id;
		}
		catch(\Exception $e)
		{
			Log::error($e);
			return 0;
		}

		Address::create();
	}
}