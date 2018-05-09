<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Almacen;

class AlmacenSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Almacen::create
		([
			'alm_desc' => "Almacen Agroimport"
		]);
	}

}
