<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Permission;
use App\Models\RoleResourcePermission;

class UserMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Auth::check())
		{
			$url =  url()->current();
			$pos = strrpos($url, "/");
			$page = substr($url, $pos+1);

			if($page == 'permission' || $page == 'add_user')
			{
				if(Auth::user()->role_id != 1)
				{
					return redirect('dashboard')->with( 'redirect_error', 'You dont have the specified permission' );
				}
			}

			elseif($page == 'view' || $page == 'edit' || $page == 'delete')
			{
				if(UserMiddleware::isAllowed($page))
				{
					if(Auth::user()->id == $request->id)
					{
						return $next($request);
					}
					else
					{
						return redirect('dashboard')->with( 'redirect_error', 'You dont have the specified permission' );
					}
				}
				else
				{
					return redirect('dashboard')->with( 'redirect_error', 'You dont have the specified permission' );
				}
			}
			else
			{
				return $next($request);				
			}

		}
		else
		{
			return redirect('login')->with( 'redirect_error', 'Please Login to continue' );
		}
	}

	/**
	* It is method that will check whether the user has permission
	*
	* @param string $permission
	* @return boolean
	*/
	public static function isAllowed($permission)
	{
		$p_id = Permission::where('permission_name', $permission)->first()->id;

		try
		{
			$rrp = RoleResourcePermission::where('fk_role', '=', Auth::user()->role_id)
										->where('fk_resource', '=', 1)
										->where('fk_permission', '=', $p_id)
										->count();

			if($rrp > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(\Exception $e)
		{
			Log::error($e);
			return false;
		}
	}
}
