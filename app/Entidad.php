<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_entidad';

    protected $primaryKey="ent_id";
	protected $fillable = ['ent_ruc','ent_rz','ent_dir','ent_ciu','tent_id','ent_tel','ent_cont','ent_ctel','ent_dpto','ent_correo'];

	public function tipoentidad(){
		return $this->belongsTo('SICPA\TipoEntidad','tent_id');
	}
	public function comprobantes(){
		return $this->hasMany('SICPA\Comprobante');
	}
	public function ordencvs(){
		return $this->hasMany('SICPA\OrdenCV');
	}
}
