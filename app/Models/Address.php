<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	// The table associated with the model.
	protected $table = 'address';

	/**
	 * Fillable fields
	 * 
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'address_type',
		'street',
		'city',
		'state',
		'zip',
		'phone',
		'fax'
	];

	public static function store($post_data)
	{
		try
		{
			Address::insert(
				[

					[
						'user_id' => $post_data['id'],
						'address_type' => 'residence',
						'street' => $post_data['r_street'],
						'city' => $post_data['r_city'],
						'state' => config( 'constants.state_list.' . $post_data['r_state']),
						'zip' => $post_data['r_zip'],
						'phone' => $post_data['r_phone'],
						'fax' => $post_data['r_fax']
					],

					[
						'user_id' => $post_data['id'],
						'address_type' => 'office',
						'street' => $post_data['o_street'],
						'city' => $post_data['o_city'],
						'state' => config( 'constants.state_list.' . $post_data['o_state']),
						'zip' => $post_data['o_zip'],
						'phone' => $post_data['o_phone'],
						'fax' => $post_data['o_fax']
					]

				]);
		}
		catch(\Exception $e)
		{
			Log::error($e);
		}
	}

}
