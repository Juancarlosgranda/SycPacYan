<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_unidad';

    protected $primaryKey="uni_id";
	protected $fillable = ['uni_cod','uni_desc'];
	
	public function unidadmedidas(){
		return $this->hasMany('SICPA\UnidadMedida');
	}
}
