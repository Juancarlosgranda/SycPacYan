<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class PrecioVenta extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_precioventa';

    protected $primaryKey="pv_id";
	protected $fillable = ['pv_prec','up_id'];
	public function unidadproducto(){
		return $this->belongsTo('SICPA\UnidadProducto','up_id');
	}
}
