<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCompraNCredito extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_comprancreadito', function(Blueprint $table)
		{
			$table->increments('compranc_id');
			$table->decimal('compranc_monto',12,2);
			$table->integer('ncred_id')->unsigned();
			$table->integer('comp_id')->unsigned();
			$table->foreign('comp_id')->references('comp_id')->on('t_comprobante');
			$table->foreign('ncred_id')->references('ncred_id')->on('t_notacredito');
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
		Schema::drop('t_comprancreadito');
	}

}
