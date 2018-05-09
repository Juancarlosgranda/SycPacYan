<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class EditarOrdenCVRequest extends Request {

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
			'ocv_id' =>'required',
			'ocv_nro' =>'required',
			'ocv_fecha' =>'required',
			'ocv_cond' =>'required',
			'ocv_moneda' =>'required',
			'ocv_tipo' =>'required',
			'ent_id' =>'required'
		];
	}

}
