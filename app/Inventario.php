<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_inventario';

    protected $primaryKey="inv_id";
	protected $fillable = ['inv_cant','inv_fecha','prod_id','alm_id'];

	public function producto(){
		return $this->belongsTo('SICPA\Producto','prod_id');
	}
	public function almacen(){
		return $this->belongsTo('SICPA\Almacen','alm_id');
	}
}
