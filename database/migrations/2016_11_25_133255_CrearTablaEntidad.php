<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEntidad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_entidad', function(Blueprint $table)
		{
			$table->increments('ent_id');
			$table->string('ent_ruc',11);
			$table->string('ent_rz');
			$table->string('ent_dir');
			$table->string('ent_ciu');
			$table->integer('tent_id')->unsigned();
			$table->string('ent_tel');
			$table->string('ent_cont');
			$table->string('ent_ctel');
			$table->string('ent_dpto');
			$table->string('ent_correo');
			$table->foreign('tent_id')->references('tent_id')->on('t_tipoentidad');
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
		Schema::drop('t_entidad');
	}

}
