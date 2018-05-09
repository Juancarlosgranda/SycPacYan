<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\TipoComprobante;

class TipoComprobanteSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoComprobante::create
		([
			'tcomp_desc' => "Boleta",
			'tcomp_cod' => "BO"
		]);
		TipoComprobante::create
		([
			'tcomp_desc' => "Factura",
			'tcomp_cod' => "FA"
		]);
		TipoComprobante::create
		([
			'tcomp_desc' => "Nota de Crédito",
			'tcomp_cod' => "NC"
		]);
		TipoComprobante::create
		([
			'tcomp_desc' => "Nota de Débito",
			'tcomp_cod' => "ND"
		]);
		TipoComprobante::create
		([
			'tcomp_desc' => "Documento de Cobranza",
			'tcomp_cod' => "DC"
		]);
		TipoComprobante::create
		([
			'tcomp_desc' => "Guía de Remisión",
			'tcomp_cod' => "GR"
		]);

	}

}
