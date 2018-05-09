<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Entidad;

class EntidadSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Entidad::create
		([
			'ent_ruc' => "123456789",
			'ent_rz' => "Cliente 1",
			'ent_dir' => "Dirección Entidad",
			'ent_ciu' => "Arequipa",
			'tent_id' => "1"
		]);
	}

}
