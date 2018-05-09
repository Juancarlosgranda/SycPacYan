<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTipoOperacion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_tipooperacion', function(Blueprint $table)
		{
			$table->increments('tope_id');
			$table->string('tope_desc');
			$table->string('tope_crit_caja');
			$table->string('tope_crit_prod');
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
		Schema::drop('t_tipooperacion');
	}

}
