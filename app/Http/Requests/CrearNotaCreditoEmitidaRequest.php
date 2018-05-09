<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearNotaCreditoEmitidaRequest extends Request {

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
			'comp_nro' =>'required|unique:t_comprobante',
			'comp_fecha' =>'required',
			'comp_est' =>'required',
			'comp_subt' =>'required',
			'comp_igv' =>'required',
			'comp_tot' =>'required',
			'comp_saldo' =>'required',
			'tcomp_id' =>'required',
			'vend_id' =>'required'

		];
	}

}
