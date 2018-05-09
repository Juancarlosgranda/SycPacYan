<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProducto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_producto', function(Blueprint $table)
		{
			$table->increments('prod_id');
			$table->string('prod_desc');
			$table->string('prod_cod');
			$table->string('prod_obs');
			$table->string('prod_exo',2);
			$table->integer('cat_id')->unsigned();
			$table->integer('um_id')->unsigned();
			$table->foreign('cat_id')->references('cat_id')->on('t_categoria');
			$table->foreign('um_id')->references('um_id')->on('t_unidadmedida');
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
		Schema::drop('t_producto');
	}

}
