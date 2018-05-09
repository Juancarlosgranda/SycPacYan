<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUnidadProducto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_unidadproducto', function(Blueprint $table)
		{
			$table->increments('up_id');
			$table->integer('um_id')->unsigned();
			$table->integer('prod_id')->unsigned();
			$table->decimal('up_psug',12,2);
			$table->foreign('um_id')->references('um_id')->on('t_unidadmedida');
			$table->foreign('prod_id')->references('prod_id')->on('t_producto');
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
		Schema::drop('t_unidadproducto');
	}

}
