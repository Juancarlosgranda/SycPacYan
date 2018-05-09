<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearOrdenCVRequest extends Request {

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
			'ocv_nro' =>'required|unique:t_ordencv',
			'ocv_fecha' =>'required',
			'ocv_subt' =>'required',
			'ocv_igv' =>'required',
			'ocv_tot' =>'required',
			'ocv_saldo' =>'required',		
			'ocv_moneda' =>'required',
			'ocv_tipo' =>'required',
			'ent_id' =>'required',

		];
	}

}
