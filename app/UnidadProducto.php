<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class UnidadProducto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_unidadproducto';

    protected $primaryKey="up_id";
	protected $fillable = ['um_id','prod_id','up_psug'];
	public function producto(){
		return $this->belongsTo('SICPA\Producto','prod_id');
	}
	public function unidadmedida(){
		return $this->belongsTo('SICPA\UnidadMedida','um_id');
	}
	public function precioventa(){
		return $this->hasOne('SICPA\PrecioVenta');
	}
	public function detallescomprobante(){
		return $this->hasMany('SICPA\DetalleComprobante');
	}
}
