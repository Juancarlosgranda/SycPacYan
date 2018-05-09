<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class CompraNCredito extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_comprancreadito';

    protected $primaryKey="compranc_id";
	protected $fillable = ['compranc_monto','ncred_id','comp_id'];
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
	public function notacredito(){
		return $this->belongsTo('SICPA\NotaCredito','ncred_id');
	}
	
}
