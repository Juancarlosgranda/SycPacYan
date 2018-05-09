<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_vendedor';

    protected $primaryKey="vend_id";
	protected $fillable = ['vend_dni','vend_nom','vend_tipo','vend_tel','vend_ciu','vend_dpto','vend_obs'];

	public function comprobantes(){
		return $this->hasMany('SICPA\Comprobante');
	}

	public function ieexternos(){
		return $this->hasMany('SICPA\IEExterno');
	}

	public function ordencvs(){
		return $this->hasMany('SICPA\OrdenCV');
	}
}
