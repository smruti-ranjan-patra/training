<?php

use Illuminate\Database\Seeder;

class CommunicationMediumSeeder extends Seeder
{
	/**
	 * To seed the communication_medium table.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('communication_medium')->insert(['type' => 'mail']);
		DB::table('communication_medium')->insert(['type' => 'message']);
		DB::table('communication_medium')->insert(['type' => 'phone']);
		DB::table('communication_medium')->insert(['type' => 'any']);
	}
}
