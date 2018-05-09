<?php namespace SICPA\Http\Requests;

use SICPA\Http\Requests\Request;

class EditarEntidadRequest extends Request {

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
			'ent_id'=>'required',
			'ent_ruc' =>'required',
			'ent_rz' =>'required',
			'ent_dir' =>'required',
			'ent_ciu' =>'required'
		];
	}

}
