<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Comprobante;

class ComprobanteSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Comprobante::create
		([
			'comp_nro' => "0000",
			'comp_fecha' => "2001-01-01",
			'comp_est' => "x",
			'comp_subt' => "0",
			'comp_igv' => "0",
			'comp_tot' => "0",
			'comp_desc' => "0",
			'comp_saldo' => "0",
			'comp_cond' => "x",
			'comp_tipcambio' => "0",
			'comp_moneda' => "x",
			'tcomp_id' => "1",
			'ent_id' => "1",
			'comp_correlativo'=> '0'
		]);
	}

}
