<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTipoComprobanteInc extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_tipocomprobanteinc', function(Blueprint $table)
		{
			$table->increments('tcompinc_id');
			$table->string('tcompinc_desc');
			$table->string('tcompinc_cod');
			$table->integer('tcomp_id')->unsigned();
			$table->foreign('tcomp_id')->references('tcomp_id')->on('t_tipocomprobante');
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
		Schema::drop('t_tipocomprobanteinc');
	}

}
