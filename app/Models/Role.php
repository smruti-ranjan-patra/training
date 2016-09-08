<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
 * Role
 * Handles role table
 * 
 * @category Model
 * @author Smruti Ranjan
 */
class Role extends Model
{
	// The table associated with this model.
	protected $table = 'role';

	/**
	 * To select all data
	 *
	 * @param  void
	 * @return object $roles
	*/
	public static function retrieveData ()
	{
		$roles = Role::all();
		return $roles;
	}
}
