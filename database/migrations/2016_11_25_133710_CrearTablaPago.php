<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPago extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_pago', function(Blueprint $table)
		{
			$table->increments('pago_id');
			$table->date('pago_fecha');
			$table->decimal('pago_monto');
			$table->string('pago_banco');
			$table->string('pago_nope');
			$table->decimal('pago_tipcambio',12,2);
			$table->integer('comp_id')->unsigned();
			$table->foreign('comp_id')->references('comp_id')->on('t_comprobante');
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
		Schema::drop('t_pago');
	}

}
