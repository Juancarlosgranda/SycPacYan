<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\MotivoTraslado;

class MotivoTrasladoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		MotivoTraslado::create
		([
			'mtras_cod' => "01",
			'mtras_desc' => "VENTA"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "14",
			'mtras_desc' => "VENTA SUJETA A LA CONFIRMACION DEL COMPRADOR"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "02",
			'mtras_desc' => "COMPRA"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "04",
			'mtras_desc' => "TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "18",
			'mtras_desc' => "TRASLADO EMISOR ITINERANTE CP"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "08",
			'mtras_desc' => "IMPORTACION"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "09",
			'mtras_desc' => "EXPORTACION"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "19",
			'mtras_desc' => "TRASLADO A ZONA PRIMARIA"
		]);

		MotivoTraslado::create
		([
			'mtras_cod' => "13",
			'mtras_desc' => "OTROS"
		]);
	}

}
