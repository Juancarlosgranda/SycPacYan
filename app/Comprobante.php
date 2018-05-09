<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_comprobante';

    protected $primaryKey="comp_id";
	protected $fillable = [
	'comp_nro','comp_fecha','comp_est','comp_subt',
	'comp_igv','comp_tot','comp_desc','comp_saldo','comp_cond',
	'comp_tipcambio','comp_moneda','comp_guia','tcomp_id',
	'ent_id','vend_id','tcompinc_id','comp_fven','comp_fpago','comp_banco','comp_nope','comp_doc','comp_np','comp_oc','comp_obs','comp_desc','comp_ref','comp_correlativo'];

	public function entidad(){
		return $this->belongsTo('SICPA\Entidad','ent_id');
	}
	public function tipocomprobante(){
		return $this->belongsTo('SICPA\TipoComprobante','tcomp_id');
	}
	public function tipocomprobanteinc(){
		return $this->belongsTo('SICPA\TipoComprobanteInc','tcompinc_id');
	}
	public function comprasncredito(){
		return $this->hasMany('SICPA\CompraNCredito');
	}
	public function operacion(){
		return $this->hasOne('SICPA\Operacion');
	}
	public function detallescomprobante(){
		return $this->hasMany('SICPA\DetalleComprobante');
	}
	public function notacredito(){
		return $this->hasOne('SICPA\NotaCredito');
	}
	public function pagos(){
		return $this->hasMany('SICPA\Pago','comp_id');
	}
	public function vendedor(){
		return $this->belongsTo('SICPA\Vendedor','vend_id');
	}
	public function adicionalguia(){
		return $this->hasOne('SICPA\AdicionalGuia','comp_id');
	}
}
