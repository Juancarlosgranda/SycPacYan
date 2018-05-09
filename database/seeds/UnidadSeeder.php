<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Unidad;

class UnidadSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Unidad::create
		([
			'uni_cod' => "1",
			'uni_desc' => "Bolsa"
		]);

		Unidad::create
		([
			'uni_cod' => "2",
			'uni_desc' => "Caja"
		]);

		Unidad::create
		([
			'uni_cod' => "3",
			'uni_desc' => "Piezas"
		]);

		Unidad::create
		([
			'uni_cod' => "4",
			'uni_desc' => "Kilogramo"
		]);

		Unidad::create
		([
			'uni_cod' => "5",
			'uni_desc' => "Litro"
		]);

		Unidad::create
		([
			'uni_cod' => "6",
			'uni_desc' => "Metro Cuadrado"
		]);

		Unidad::create
		([
			'uni_cod' => "7",
			'uni_desc' => "Metro"
		]);

		Unidad::create
		([
			'uni_cod' => "8",
			'uni_desc' => "Unidad"
		]);

		Unidad::create
		([
			'uni_cod' => "9",
			'uni_desc' => "Onzas"
		]);

		Unidad::create
		([
			'uni_cod' => "10",
			'uni_desc' => "Tonelada"
		]);
		Unidad::create
		([
			'uni_cod' => "11",
			'uni_desc' => "Gramo"
		]);
		Unidad::create
		([
			'uni_cod' => "12",
			'uni_desc' => "Bidon"
		]);
	}

}
