<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearDetalleOrdenCVRequest extends Request {

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
			'docv_cant' =>'required',
			'docv_prec' =>'required',
			'ocv_id' =>'required',
			'prod_id' =>'required',
			'um_id' =>'required'
		];
	}

}
