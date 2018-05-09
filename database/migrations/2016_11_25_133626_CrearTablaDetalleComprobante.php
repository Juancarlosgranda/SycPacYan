<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDetalleComprobante extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_detallecomprobante', function(Blueprint $table)
		{
			$table->increments('dcomp_id');
			$table->decimal('dcomp_cant',12,3);
			$table->decimal('dcomp_prec',12,2);
			$table->decimal('dcomp_desc',12,2);
			$table->integer('comp_id')->unsigned();
			$table->integer('up_id')->unsigned();
			$table->foreign('comp_id')->references('comp_id')->on('t_comprobante');
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
		Schema::drop('t_detallecomprobante');
	}

}
