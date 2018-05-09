<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class TipoEntidad extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_tipoentidad';

    protected $primaryKey="tent_id";
	protected $fillable = ['tent_desc'];
	
	public function entidades(){
		return $this->hasMany('SICPA\Entidades');
	}
}
