<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('permission')->insert(['permission_name' => 'view']);
		DB::table('permission')->insert(['permission_name' => 'edit']);
		DB::table('permission')->insert(['permission_name' => 'delete']);
	}
}
