<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPrecioVenta extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_precioventa', function(Blueprint $table)
		{
			$table->increments('pv_id');
			$table->decimal('pv_prec',12,2);
			$table->integer('up_id')->unsigned();
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
		Schema::drop('t_precioventa');
	}

}
