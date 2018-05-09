<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_tipogasto';

    protected $primaryKey="tgasto_id";
	protected $fillable = ['tgasto_desc'];
	
	public function ieexternos(){
		return $this->hasMany('SICPA\IEExterno');
	}
}
