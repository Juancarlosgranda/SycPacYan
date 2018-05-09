<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_tipooperacion';

    protected $primaryKey="tope_id";
	protected $fillable = ['tope_desc','tope_crit_caja','tope_crit_prod'];
	public function operaciones(){
		return $this->hasMany('SICPA\Operacion');
	}
}
