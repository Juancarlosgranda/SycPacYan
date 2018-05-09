<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_unidadmedida';

    protected $primaryKey="um_id";
	protected $fillable = ['um_desc','um_abrev','uni_id'];
	
	public function productos(){
		return $this->hasMany('SICPA\Producto');
	}
	public function conversiones1(){
		return $this->hasMany('SICPA\Conversion','um_id1','um_id');
	}
	public function conversiones2(){
		return $this->hasMany('SICPA\Conversion','um_id2','um_id');
	}
	public function unidadesproducto(){
		return $this->hasMany('SICPA\UnidadProducto');
	}
	public function unidad(){
		return $this->belongsTo('SICPA\Unidad','uni_id');
	}
}
