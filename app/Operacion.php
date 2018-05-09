<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Operacion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_operacion';

    protected $primaryKey="ope_id";
	protected $fillable = ['tope_id','comp_id','ie_id'];
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
	public function tipooperacion(){
		return $this->belongsTo('SICPA\TipoOperacion','tope_id');
	}
	public function ieexterno(){
		return $this->belongsTo('SICPA\IEExterno','ie_id');
	}
}
