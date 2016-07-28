<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table)
		{
			$table->string('key', 60);
			$table->tinyInteger('is_active')->default(0)->comment('0=Inactive, 1=Active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table)
		{
			$table->dropColumn('key');
			$table->dropColumn('is_active');
		});
	}
}
