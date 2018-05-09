<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVendedor extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_vendedor', function(Blueprint $table)
		{
			$table->increments('vend_id');
			$table->string('vend_dni',11);
			$table->string('vend_nom');
			$table->string('vend_tipo');
			$table->string('vend_tel');
			$table->string('vend_ciu');
			$table->string('vend_dpto');
			$table->string('vend_obs');
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
		Schema::drop('t_vendedor');
	}

}
