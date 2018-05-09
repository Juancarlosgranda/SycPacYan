<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class MotivoTraslado extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_motivotraslado';

    protected $primaryKey="mtras_id";
	protected $fillable = ['mtras_desc','mtras_cod'];
	
	public function adicionalguias(){
		return $this->hasMany('SICPA\AdicionalGuia');
	}
}
