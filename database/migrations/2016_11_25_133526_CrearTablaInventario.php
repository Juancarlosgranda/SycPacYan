<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInventario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_inventario', function(Blueprint $table)
		{
			$table->increments('inv_id');
			$table->decimal('inv_cant',12,3);
			$table->dateTime('inv_fecha');
			$table->integer('prod_id')->unsigned();
			$table->integer('alm_id')->unsigned();
			$table->foreign('prod_id')->references('prod_id')->on('t_producto');
			$table->foreign('alm_id')->references('alm_id')->on('t_almacen');
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
		Schema::drop('t_inventario');
	}

}
