<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class IEExterno extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_ieexterno';

    protected $primaryKey="ie_id";
	protected $fillable = ['ie_comp','ie_ruc','ie_rz','ie_tcomp','ie_fecha','ie_guia','ie_moneda','ie_tipcambio','ie_subt','ie_tot','ie_igv','vend_id','ie_tipgasto','ie_tipocc','ie_zona','ie_obs'];
	public function operacion(){
		return $this->hasOne('SICPA\Operacion');
	}
	public function detallesie(){
		return $this->hasMany('SICPA\DetalleIE');
	}
	public function vendedor(){
		return $this->belongsTo('SICPA\Vendedor','vend_id');
	}
}
