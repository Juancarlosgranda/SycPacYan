<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_categoria';

    protected $primaryKey="cat_id";
	protected $fillable = ['cat_desc','fam_id'];
	
	public function productos(){
		return $this->hasMany('SICPA\Producto');
	}

	public function familia(){
		return $this->belongsTo('SICPA\Familia','fam_id');
	}
	
}
