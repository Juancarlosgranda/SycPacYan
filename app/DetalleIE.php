<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class DetalleIE extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_detalleie';

    protected $primaryKey="die_id";
	protected $fillable = ['die_desc','die_cant','die_prec','ie_id'];
	public function ieexterno(){
		return $this->belongsTo('SICPA\IEExterno','ie_id');
	}
}
