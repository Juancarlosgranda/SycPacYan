<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_producto';

    protected $primaryKey="prod_id";
	protected $fillable = ['prod_desc', 'prod_cod', 'prod_obs','prod_exo','cat_id','um_id'];

	public function categoria(){
		return $this->belongsTo('SICPA\Categoria','cat_id');
	}
	public function unidadmedida(){
		return $this->belongsTo('SICPA\UnidadMedida','um_id');
	}
	public function inventarios(){
		return $this->hasMany('SICPA\Inventario');
	}	
	public function conversiones1(){
		return $this->hasMany('SICPA\Conversion','um_id1','um_id');
	}
	public function unidadesproducto(){
		return $this->hasMany('SICPA\UnidadProducto');
	}
}
