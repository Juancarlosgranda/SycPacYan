<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_conversion';

    protected $primaryKey="conv_id";
	protected $fillable = ['conv_fact','um_id1','um_id2'];
	public function unidadmedida1(){
		return $this->belongsTo('SICPA\UnidadMedida','um_id1');
	}
	public function unidadmedida2(){
		return $this->belongsTo('SICPA\UnidadMedida','um_id2');
	}
}
