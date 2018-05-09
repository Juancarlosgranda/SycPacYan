<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOrdenCV extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_ordencv', function(Blueprint $table)
		{
			$table->increments('ocv_id');
			$table->string('ocv_nro');
			$table->date('ocv_fecha');
			$table->string('ocv_est');
			$table->decimal('ocv_subt',12,2);
			$table->decimal('ocv_igv',12,2);
			$table->decimal('ocv_tot',12,2);
			$table->string('ocv_cond');
			$table->decimal('ocv_tipcambio',12,3);
			$table->string('ocv_moneda');
			$table->string('ocv_tipo');
			$table->string('ocv_dirdesp');
			$table->string('ocv_localidad');
			$table->string('ocv_transporte');
			$table->string('ocv_nroopcompra');
			$table->string('ocv_nroopventa');
			$table->string('ocv_obs');
			$table->date('ocv_fechadepcli');
			$table->date('ocv_fechadeppro');
			$table->integer('ent_id')->unsigned();
			$table->foreign('ent_id')->references('ent_id')->on('t_entidad');
			$table->integer('vend_id')->unsigned();
			$table->foreign('vend_id')->references('vend_id')->on('t_vendedor');
			$table->string('ocv_doc');
			$table->string('ocv_ref');
			$table->string('ocv_nroop1');
			$table->string('ocv_nroop2');
			$table->string('ocv_nroop3');
			$table->string('ocv_banco1');
			$table->string('ocv_banco2');
			$table->string('ocv_banco3');
			$table->decimal('ocv_monto1');
			$table->decimal('ocv_monto2');
			$table->decimal('ocv_monto3');
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
		Schema::drop('t_ordencv');
	}

}
