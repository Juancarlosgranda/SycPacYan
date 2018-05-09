<?php namespace SICPA\Services;

use SICPA\Usuario;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Http\Request;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'usu_nom' => 'required|max:255',
			'email' => 'required|email|max:255|unique:t_usuario',
			'password' => 'required|confirmed|min:6',
			'usu_preg' => 'required|max:255',
			'usu_rpta' => 'required|max:255',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return Usuario::create([
			'usu_nom' => $data['usu_nom'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'usu_preg' => $data['usu_preg'],
			'usu_rpta' => $data['usu_rpta'],
		]);
	}

}
