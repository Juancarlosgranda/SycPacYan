<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class EditarProductoRequest extends Request {

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
			'prod_id'=>'required',
			'prod_desc'=>'required',
			'prod_cod'=>'required',
			'prod_obs'=>'required',
			'prod_exo'=>'required',
			'cat_id'=>'required',
			'um_id'=>'required'
		];
	}

}
