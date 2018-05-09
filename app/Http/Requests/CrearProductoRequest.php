<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearProductoRequest extends Request {

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
			'prod_desc'=>'required|unique:t_producto',
			'prod_cod'=>'required|unique:t_producto',
			'prod_obs'=>'required',
			'prod_exo'=>'required',
			'cat_id'=>'required',
			'um_id'=>'required'
		];
	}

}
