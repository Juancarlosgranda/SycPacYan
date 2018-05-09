<?php namespace SICPA;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 't_familia';

    protected $primaryKey="fam_id";
	protected $fillable = ['fam_desc'];
	
	public function categorias(){
		return $this->hasMany('SICPA\Categoria');
	}
	
}
