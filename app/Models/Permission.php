<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	// The table associated with this model.
	protected $table = 'permission';

	/**
	 * To select all data
	 *
	 * @param  void
	 * @return object $permissions
	*/
	public static function retrieveData ()
	{
		$permissions = Permission::all();
		return $permissions;
	}
}
