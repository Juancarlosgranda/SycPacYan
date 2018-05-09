<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class EditarComprobanteRequest extends Request {

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
			'comp_id' =>'required',
			'comp_nro' =>'required',
			'comp_fecha' =>'required',
			'comp_cond' =>'required',
			'comp_moneda' =>'required',
			'tcomp_id' =>'required',
			'ent_id' =>'required',
			'vend_id' =>'required'
		];
	}

}
