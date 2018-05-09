<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class EditarNotaCreditoEmitidaRequest extends Request {

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
			'comp_nro' =>'required',
			'comp_fecha' =>'required',
			'vend_id' =>'required'
		];
	}

}
