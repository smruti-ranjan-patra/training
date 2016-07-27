<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('first_name', 30);
			$table->string('middle_name', 30);
			$table->string('last_name', 30);
			$table->string('email', 100)->unique();
			$table->string('password', 100);
			$table->string('twitter_name', 15);
			$table->string('prefix', 3);
			$table->string('gender', 6);
			$table->date('dob', 30);
			$table->string('marital_status', 10);
			$table->string('employment', 20);
			$table->string('employer', 100);
			$table->string('photo', 100);
			$table->text('extra_note');
			$table->string('comm_id', 15);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
	}
}
