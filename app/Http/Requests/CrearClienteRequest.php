<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearClienteRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'ent_ruc' =>'required|unique:t_entidad',
			'ent_rz' =>'required|unique:t_entidad',
			'ent_dir' =>'required',
			'ent_ciu' =>'required',
			'ent_correo' => 'required|email'
		];
	}

}
