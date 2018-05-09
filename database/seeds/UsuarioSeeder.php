<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use SICPA\Usuario;

class UsuarioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Usuario::create
		([
			'usu_nom' => "admin",
			'email' => "admin@agroimport.com",
			'password' => bcrypt("admin"),
			'usu_preg' => "preg1",
			'usu_rpta' => "rpta1"
		]);
	}

}
