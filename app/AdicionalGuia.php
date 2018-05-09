<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class AdicionalGuia extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_adicionalguia';

    protected $primaryKey="adig_id";
	protected $fillable = ['mtras_id','adig_transprog','adig_pbruto','uni_id','adig_nbulto','adig_mtrasl','adig_ftrasl','adig_doctrans','adig_tdoctrans','adig_rztrans','adig_nroplaca','adig_doccond','adig_tdoccond','adig_paispart','dpto_idpart','prov_idpart','dist_idpart','adig_dirpart','adig_paislleg','dpto_idlleg','prov_idlleg','dist_idlleg','adig_dirlleg','adig_ncontenedor','adig_codpuerto','comp_id'];
	public function comprobante(){
		return $this->belongsTo('SICPA\Comprobante','comp_id');
	}
	public function unidad(){
		return $this->belongsTo('SICPA\Unidad','uni_id');
	}
	public function motivotraslado(){
		return $this->belongsTo('SICPA\MotivoTraslado','mtras_id');
	}
	public function departamentopart(){
		return $this->belongsTo('SICPA\Departamento','dpto_idpart');
	}
	public function provinciapart(){
		return $this->belongsTo('SICPA\Provincia','prov_idpart');
	}
	public function distritopart(){
		return $this->belongsTo('SICPA\Distrito','dist_idpart');
	}
	public function departamentolleg(){
		return $this->belongsTo('SICPA\Departamento','dpto_idlleg');
	}
	public function provincialleg(){
		return $this->belongsTo('SICPA\Provincia','prov_idlleg');
	}
	public function distritolleg(){
		return $this->belongsTo('SICPA\Distrito','dist_idlleg');
	}

}
