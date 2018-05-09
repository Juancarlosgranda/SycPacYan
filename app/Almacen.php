<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;
class Almacen extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_almacen';

    protected $primaryKey="alm_id";
	protected $fillable = ['alm_desc'];

	public function inventarios(){
		return $this->hasMany('SICPA\Inventario');
	}

}
