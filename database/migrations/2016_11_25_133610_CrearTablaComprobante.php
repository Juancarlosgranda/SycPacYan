<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaComprobante extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_comprobante', function(Blueprint $table)
		{
			$table->increments('comp_id');
			$table->string('comp_nro');
			$table->date('comp_fecha');
			$table->string('comp_est');
			$table->decimal('comp_subt',12,2);
			$table->decimal('comp_igv',12,2);
			$table->decimal('comp_tot',12,2);
			$table->decimal('comp_desc',12,2);
			$table->decimal('comp_saldo',12,2);
			$table->string('comp_cond');
			$table->decimal('comp_tipcambio',12,3);
			$table->string('comp_moneda');
			$table->string('comp_guia');
			$table->integer('tcomp_id')->unsigned();
			$table->integer('ent_id')->unsigned();
			$table->integer('vend_id')->unsigned();
			$table->foreign('tcomp_id')->references('tcomp_id')->on('t_tipocomprobante');
			$table->foreign('ent_id')->references('ent_id')->on('t_entidad');
			$table->foreign('vend_id')->references('vend_id')->on('t_vendedor');
			$table->integer('tcompinc_id')->unsigned();
			$table->foreign('tcompinc_id')->references('tcompinc_id')->on('t_tipocomprobanteinc');
			$table->date('comp_fven');
			$table->date('comp_fpago');
			$table->string('comp_banco');
			$table->string('comp_nope');
			$table->string('comp_doc');
			$table->string('comp_np');
			$table->string('comp_oc');
			$table->string('comp_ref');
			$table->string('comp_descrip');
			$table->string('comp_obs');
			$table->integer('comp_correlativo');
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
		Schema::drop('t_comprobante');
	}

}
