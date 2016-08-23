<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleResourcePermission extends Model
{
	// The table associated with this model.
	protected $table = 'role_resource_permission';

	/**
	 * Fillable fields
	 * 
	 * @var array
	 */
	protected $fillable = [
		'fk_role',
		'fk_resource',
		'fk_permission',
	];

	/**
	 * To select all data
	 *
	 * @param  void
	 * @return object $permissions
	*/
	public static function retrieveData ()
	{
		$rrp = RoleResourcePermission::all();
		return $rrp;
	}

	/**
	 * To insert data
	 *
	 * @param  string $id
	 * @return void
	*/
	public static function insertData ($id)
	{
		$id_array = explode("-", $id);
		RoleResourcePermission::create(
				[
					'fk_role' => $id_array[0],
					'fk_resource' => $id_array[1],
					'fk_permission' => $id_array[2]
				]);
	}

	/**
	 * To delete data
	 *
	 * @param  string $id
	 * @return void
	*/
	public static function deleteData ($id)
	{
		$id_array = explode("-", $id);
		RoleResourcePermission::where('fk_role', '=', $id_array[0])
								->where('fk_resource', '=', $id_array[1])
								->where('fk_permission', '=', $id_array[2])
								->delete();		
	}

	/**
	 * To check specified permission
	 *
	 * @param  integer $p_id
	 * @return integer 
	*/
	public static function isAllowed ($p_id)
	{
		$rrp = RoleResourcePermission::where('fk_role', '=', 2)
									->where('fk_resource', '=', 1)
									->where('fk_permission', '=', $p_id)
									->count();

		if($rrp)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

}
