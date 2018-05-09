<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\IEExterno;

class IEExternoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		IEExterno::create
		([
			'ie_comp' => "0000",
			'ie_ent' => "x",
			'ie_fecha' => "2001-01-01",
			'ie_subt' => "0",
			'ie_tot' => "0",
			'ie_igv' => "0"
		]);
	}

}
