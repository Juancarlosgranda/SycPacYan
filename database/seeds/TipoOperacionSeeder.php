<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\TipoOperacion;

class TipoOperacionSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoOperacion::create
		([
			'tope_desc' => "Compra",
			'tope_crit_caja' => "-",
			'tope_crit_prod' => "+",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "Venta",
			'tope_crit_caja' => "+",
			'tope_crit_prod' => "-",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "IngresoE",
			'tope_crit_caja' => "-",
			'tope_crit_prod' => "x",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "EgresoE",
			'tope_crit_caja' => "-",
			'tope_crit_prod' => "x",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "NotaCreditoE",
			'tope_crit_caja' => "-",
			'tope_crit_prod' => "+",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "NotaDebito",
			'tope_crit_caja' => "+",
			'tope_crit_prod' => "*",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "GuiaRemision",
			'tope_crit_caja' => "+",
			'tope_crit_prod' => "*",
		]);
		TipoOperacion::create
		([
			'tope_desc' => "NotaCreditoR",
			'tope_crit_caja' => "+",
			'tope_crit_prod' => "*",
		]);
	}

}
