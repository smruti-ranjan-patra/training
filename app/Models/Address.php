<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	// The table associated with this model.
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

	/**
	 * Get the user that owns the address.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

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
						'state' => $post_data['r_state'],
						'zip' => $post_data['r_zip'],
						'phone' => $post_data['r_phone'],
						'fax' => $post_data['r_fax']
					],

					[
						'user_id' => $post_data['id'],
						'address_type' => 'office',
						'street' => $post_data['o_street'],
						'city' => $post_data['o_city'],
						'state' => $post_data['o_state'],
						'zip' => $post_data['o_zip'],
						'phone' => $post_data['o_phone'],
						'fax' => $post_data['o_fax']
					]

				]);
			return 1;
		}
		catch(\Exception $e)
		{
			return 0;
			Log::error($e);
		}
	}

	/**
	 * To Update all data
	 *
	 * @param  string  $key
	*/
	public static function updateAddress ($post_data)
	{
		Address::where('user_id', '=', $post_data['id'])
					->where('address_type', '=', 'residence')
						->update(
							[
								'street' => $post_data['r_street'],
								'city' => $post_data['r_city'],
								'state' => $post_data['r_state'],
								'zip' => $post_data['r_zip'],
								'phone' => $post_data['r_phone'],
								'fax' => $post_data['r_fax']
							]);

		Address::where('user_id', '=', $post_data['id'])
					->where('address_type', '=', 'office')
						->update(
							[
								'street' => $post_data['o_street'],
								'city' => $post_data['o_city'],
								'state' => $post_data['o_state'],
								'zip' => $post_data['o_zip'],
								'phone' => $post_data['o_phone'],
								'fax' => $post_data['o_fax']
							]);
	}

	/**
	 * To delete data from address tabel.
	 *
	 * @param  array $post_data
	 * @return void
	 */
	public static function delete_record ($id)
	{
		Address::destroy($id);
	}

}
