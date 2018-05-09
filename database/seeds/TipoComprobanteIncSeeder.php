<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\TipoComprobanteInc;

class TipoComprobanteIncSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Anulación de la Operación",
			'tcompinc_cod' => "01",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Anulación por Error en el RUC",
			'tcompinc_cod' => "02",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Corección por Error en la Descripción",
			'tcompinc_cod' => "03",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Descuento Global",
			'tcompinc_cod' => "04",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Descuento por Item",
			'tcompinc_cod' => "05",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Devolución Total",
			'tcompinc_cod' => "06",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Devolución Parcial",
			'tcompinc_cod' => "07",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Bonificación",
			'tcompinc_cod' => "08",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Disminución en el Valor",
			'tcompinc_cod' => "09",
			'tcomp_id' => "3"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Interés por Mora",
			'tcompinc_cod' => "01",
			'tcomp_id' => "4"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Aumento en el Valor",
			'tcompinc_cod' => "02",
			'tcomp_id' => "4"
		]);
		TipoComprobanteInc::create
		([
			'tcompinc_desc' => "Ninguno",
			'tcompinc_cod' => "00",
			'tcomp_id' => "1"
		]);


	}

}
