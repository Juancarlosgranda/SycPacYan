<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_usuario', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('usu_nom');
			$table->string('email')->unique();
			$table->string('password',60);
			$table->string('usu_preg');
			$table->string('usu_rpta');
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
		Schema::drop('t_usuario');
	}

}
