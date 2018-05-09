<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConversion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_conversion', function(Blueprint $table)
		{
			$table->increments('conv_id');
			$table->decimal('conv_fact',12,2);
			$table->integer('um_id1')->unsigned();
			$table->integer('um_id2')->unsigned();
			$table->foreign('um_id1')->references('um_id')->on('t_unidadmedida');
			$table->foreign('um_id2')->references('um_id')->on('t_unidadmedida');
			
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
		Schema::drop('t_conversion');
	}

}
