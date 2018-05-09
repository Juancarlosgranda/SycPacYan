<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearDetalleIERequest extends Request {

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
			'die_cant' =>'required',
			'die_prec' =>'required',
			'ie_id' =>'required',
			'die_desc' =>'required',
		];
	}

}
