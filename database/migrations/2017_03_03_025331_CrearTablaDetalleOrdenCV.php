<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDetalleOrdenCV extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_detalleordencv', function(Blueprint $table)
		{
			$table->increments('docv_id');
			$table->decimal('docv_cant',12,3);
			$table->decimal('docv_prec',12,2);
			$table->integer('ocv_id')->unsigned();
			$table->integer('up_id')->unsigned();
			$table->foreign('ocv_id')->references('ocv_id')->on('t_ordencv');
			$table->foreign('up_id')->references('up_id')->on('t_unidadproducto');
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
		Schema::drop('t_detalleordencv');
	}

}
