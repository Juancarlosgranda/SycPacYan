<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_distrito';

    protected $primaryKey="dist_id";
	protected $fillable = ['dist_cod','dist_desc','prov_id'];
	
	public function GuiaAdicional(){
		return $this->hasMany('SICPA\GuiaAdicional');
	}
	public function Provincia(){
		return $this->belongsTo('SICPA\Provincia','prov_id');
	}
}
