<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_tipocomprobante';

    protected $primaryKey="tcomp_id";
	protected $fillable = ['tcomp_desc','tcomp_cod'];
	public function comprobantes(){
		return $this->hasMany('SICPA\Comprobante');
	}
	public function tipocomprobanteincs(){
		return $this->hasMany('SICPA\TipoComprobanteInc');
	}

}
