<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class TipoComprobanteInc extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_tipocomprobanteinc';

    protected $primaryKey="tcompinc_id";
	protected $fillable = ['tcompinc_desc','tcompinc_cod','tcomp_id'];

	public function tipocomprobante(){
		return $this->belongsTo('SICPA\TipoComprobante','tcomp_id');
	}
	
	public function comprobantes(){
		return $this->hasMany('SICPA\Comprobante');
	}
}
