<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\TipoEntidad;

class TipoEntidadSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoEntidad::create
		([
			'tent_desc' => "Cliente"
		]);
		TipoEntidad::create
		([
			'tent_desc' => "Proveedor"
		]);
	}

}
