<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class OrdenCV extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_ordencv';

    protected $primaryKey="ocv_id";
	protected $fillable = [
	'ocv_nro','ocv_fecha','ocv_est','ocv_subt',
	'ocv_igv','ocv_tot','ocv_cond',
	'ocv_tipcambio','ocv_moneda','ocv_tipo',
	'ent_id','vend_id','ocv_doc','ocv_dirdesp','ocv_localidad','ocv_transporte','ocv_nroopcompra','ocv_nroopventa','ocv_obs','ocv_fechadepcli','ocv_fechadeppro','ocv_ref','ocv_nroop1','ocv_nroop2','ocv_nroop3','ocv_banco1','ocv_banco2','ocv_banco3','ocv_monto1','ocv_monto2','ocv_monto3'];

	public function entidad(){
		return $this->belongsTo('SICPA\Entidad','ent_id');
	}

	public function vendedor(){
		return $this->belongsTo('SICPA\Vendedor','vend_id');
	}

	public function detallesordencv(){
		return $this->hasMany('SICPA\DetalleOrdenCV');
	}
}
