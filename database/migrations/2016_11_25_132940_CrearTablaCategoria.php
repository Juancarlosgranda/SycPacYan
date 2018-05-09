<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCategoria extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_categoria', function(Blueprint $table)
		{
			$table->increments('cat_id');
			$table->string('cat_desc');
			$table->integer('fam_id')->unsigned();
			$table->foreign('fam_id')->references('fam_id')->on('t_familia');
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
		Schema::drop('t_categoria');
	}

}
