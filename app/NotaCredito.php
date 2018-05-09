<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class NotaCredito extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_notacredito';

    protected $primaryKey="ncred_id";
	protected $fillable = ['ncred_tot','ncred_saldo','comp_id','ncred_num','ncred_obs'];
	public function comprasncredito(){
		return $this->hasMany('SICPA\CompraNCredito');
	}
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
}
