<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_departamento';

    protected $primaryKey="dpto_id";
	protected $fillable = ['dpto_cod','dpto_desc'];
	
	public function GuiaAdicional(){
		return $this->hasMany('SICPA\GuiaAdicional');
	}
}
