<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOperacion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_operacion', function(Blueprint $table)
		{
			$table->increments('ope_id');
			$table->integer('tope_id')->unsigned();
			$table->integer('comp_id')->unsigned();
			$table->integer('ie_id')->unsigned();
			$table->foreign('tope_id')->references('tope_id')->on('t_tipooperacion');
			$table->foreign('comp_id')->references('comp_id')->on('t_comprobante');
			$table->foreign('ie_id')->references('ie_id')->on('t_ieexterno');
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
		Schema::drop('t_operacion');
	}

}
