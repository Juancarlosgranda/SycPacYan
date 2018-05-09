<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUnidadMedida extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_unidadmedida', function(Blueprint $table)
		{
			$table->increments('um_id');
			$table->string('um_desc');
			$table->string('um_abrev');
			$table->string('uni_id');
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
		Schema::drop('t_unidadmedida');
	}

}
