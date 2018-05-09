<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaIEExterno extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_ieexterno', function(Blueprint $table)
		{
			$table->increments('ie_id');
			$table->string('ie_comp');
			$table->string('ie_ruc');
			$table->string('ie_rz');
			$table->string('ie_tcomp');
			$table->date('ie_fecha');
			$table->string('ie_guia');
			$table->string('ie_moneda');
			$table->decimal('ie_tipcambio',12,3);
			$table->decimal('ie_subt',12,2);
			$table->decimal('ie_tot',12,2);
			$table->decimal('ie_igv',12,2);
			$table->integer('vend_id')->unsigned();
			$table->string('ie_tipgasto');
			$table->string('ie_tipocc');	
			$table->string('ie_zona');
			$table->string('ie_obs');		
			$table->foreign('vend_id')->references('vend_id')->on('t_vendedor');
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
		Schema::drop('t_ieexterno');
	}

}
