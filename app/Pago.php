<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_pago';

    protected $primaryKey="pago_id";
	protected $fillable = ['pago_fecha','pago_monto','pago_banco','pago_nope','comp_id','pago_tipcambio'];
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
}
