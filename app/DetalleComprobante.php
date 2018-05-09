<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class DetalleComprobante extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_detallecomprobante';

    protected $primaryKey="dcomp_id";
	protected $fillable = ['dcomp_cant','dcomp_prec','dcomp_desc','comp_id','up_id'];
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
	public function unidadproducto(){
		return $this->belongsTo('SICPA\UnidadProducto','up_id');
	}
}
