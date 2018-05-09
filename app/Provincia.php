<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_provincia';

    protected $primaryKey="prov_id";
	protected $fillable = ['prov_cod','prov_desc','dpto_id'];
	
	public function GuiaAdicional(){
		return $this->hasMany('SICPA\GuiaAdicional');
	}
	public function Departamento(){
		return $this->belongsTo('SICPA\Departamento','dpto_id');
	}
}
