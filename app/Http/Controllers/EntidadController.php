<?php namespace SICPA\Http\Controllers;

use SICPA\Entidad;
use SICPA\TipoEntidad;
use Illuminate\Http\Request;
use SICPA\Http\Requests\EditarEntidadRequest;
use SICPA\Http\Requests\CrearEntidadRequest;

class EntidadController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$entidades = Entidad::orderBy('ent_rz','asc')->get();
		return view('entidad.mostrar',['entidades'=> $entidades]);
	}

	public function getCrear()
	{
		return view('entidad.crear');
	}

	public function postCrear(CrearEntidadRequest $request)
	{
		Entidad::create
		(
			[
				'ent_ruc' => strtoupper($request->get('ent_ruc')),
				'ent_rz' => strtoupper($request->get('ent_rz')),
				'ent_dir' => strtoupper($request->get('ent_dir')),
				'ent_ciu' => strtoupper($request->get('ent_ciu')),
				'tent_id' => strtoupper($request->get('tent_id'))

			]
		);
		return redirect('/validado/entidad')->with('creado','El entidad ha sido creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$entidad = Entidad::find($ent_id);

		return view('entidad.editar',['entidad'=>$entidad]);

	}

	public function postEditar(EditarEntidadRequest $request)
	{
		$ent_id=$request->get('ent_id');
		$ent_ruc=($request->get('ent_ruc'));
		$ent_rz=($request->get('ent_rz'));
		$ent_dir=($request->get('ent_dir'));
		$ent_ciu=($request->get('ent_ciu'));
		$tent_id=($request->get('tent_id'));
		$entidad = Entidad::find($ent_id);

		$entidad->ent_ruc=$ent_ruc;
		$entidad->ent_rz=$ent_rz;
		$entidad->ent_dir=$ent_dir;
		$entidad->ent_ciu=$ent_ciu;
		$entidad->tent_id=$tent_id;
		$entidad->save();

		return redirect('/validado/entidad')->with('actualizado','Entidad actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$entidad = Entidad::find($ent_id);
		$entidad->delete();

		return redirect('/validado/entidad')->with('eliminado','Entidad eliminada');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
