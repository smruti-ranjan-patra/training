<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleResourcePermissionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_resource_permission', function (Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fk_role')->unsigned();
			$table->foreign('fk_role')->references('id')->on('role')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('fk_resource')->unsigned();
			$table->foreign('fk_resource')->references('id')->on('resource')->onDelete('cascade')->onUpdate('cascade');
			$table->integer('fk_permission')->unsigned();
			$table->foreign('fk_permission')->references('id')->on('permission')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_resource_permission');
	}
}
