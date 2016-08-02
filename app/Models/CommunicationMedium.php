<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationMedium extends Model
{
    // The table associated with the model.
    protected $table = 'communication_medium';

	/**
	 * To select all data
	 *
	 * @param  string  $key
	*/
	public static function retrieveData ()
	{
		return CommunicationMedium::all();
	}
}
