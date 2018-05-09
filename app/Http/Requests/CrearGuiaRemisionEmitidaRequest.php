<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class CrearGuiaRemisionEmitidaRequest extends Request {

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
			'comp_est' =>'required',
			'tcomp_id' =>'required',
			'vend_id' =>'required',			
			'mtras_id' =>'required',
			'uni_id' =>'required',
			'dpto_idpart' =>'required',
			'prov_idpart' =>'required',
			'dist_idpart' =>'required',
			'adig_dirpart' =>'required',
			'adig_paislleg' =>'required',
			'dpto_idlleg' =>'required',
			'prov_idlleg' =>'required'

		];
	}

}
