<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Usuario;
use SICPA\TipoEntidad;
use SICPA\TipoOperacion;
use SICPA\TipoComprobante;
use SICPA\Entidad;
use SICPA\Comprobante;
use SICPA\IEExterno;
use SICPA\Almacen;
use SICPA\TipoComprobanteInc;
use SICPA\Unidad;
use SICPA\MotivoTraslado;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Usuario::truncate();
		TipoEntidad::truncate();
		TipoOperacion::truncate();
		TipoComprobante::truncate();
		Entidad::truncate();
		Comprobante::truncate();
		IEExterno::truncate();
		Almacen::truncate();
		TipoComprobanteInc::truncate();
		Unidad::truncate();
		MotivoTraslado::truncate();

		$this->call('UsuarioSeeder');
		$this->call('AlmacenSeeder');
		$this->call('TipoEntidadSeeder');
		$this->call('TipoOperacionSeeder');
		$this->call('TipoComprobanteSeeder');
		$this->call('EntidadSeeder');
		$this->call('ComprobanteSeeder');
		$this->call('TipoComprobanteIncSeeder');
		$this->call('UnidadSeeder');
		$this->call('IEExternoSeeder');
		$this->call('MotivoTrasladoSeeder');
	}

}
