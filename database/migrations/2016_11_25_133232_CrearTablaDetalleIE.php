<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDetalleIE extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_detalleie', function(Blueprint $table)
		{
			$table->increments('die_id');
			$table->string('die_desc');
			$table->decimal('die_cant',12,3);
			$table->decimal('die_prec',12,2);
			$table->integer('ie_id')->unsigned();
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
		Schema::drop('t_detalleie');
	}

}
