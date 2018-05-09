<?php namespace SICPA\Http\Controllers;

use SICPA\UnidadMedida;
use SICPA\Unidad;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller {

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
		$unidadmedidas = UnidadMedida::all();
		return view('unidadmedida.mostrar',['unidadmedidas'=> $unidadmedidas]);
	}

	public function getCrear()
	{
		$unidades = Unidad::all();
		return view('unidadmedida.crear',['unidades'=> $unidades]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['um_desc' =>'required|unique:t_unidadmedida','um_abrev' =>'required']);
		UnidadMedida::create
		(
			[
				'um_desc' => strtoupper($request->get('um_desc')),
				'um_abrev' => strtoupper($request->get('um_abrev')),
				'uni_id' => strtoupper($request->get('uni_id'))
			]
		);
		return redirect('/validado/unidadmedida')->with('creado','Unidad de Medida creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['um_id'=>'required']);
		$um_id=$request->get('um_id');
		$unidadmedida = UnidadMedida::find($um_id);
		$unidades = Unidad::all();

		return view('unidadmedida.editar',['unidadmedida'=>$unidadmedida,'unidades'=> $unidades]);

	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['um_id'=>'required','um_desc' =>'required','um_abrev' =>'required']);
		$um_id=$request->get('um_id');
		$um_desc=strtoupper($request->get('um_desc'));
		$um_abrev=strtoupper($request->get('um_abrev'));
		$uni_id=strtoupper($request->get('uni_id'));
		$unidadmedida = UnidadMedida::find($um_id);

		$unidadmedida->um_desc=$um_desc;
		$unidadmedida->um_abrev=$um_abrev;
		$unidadmedida->uni_id=$uni_id;
		$unidadmedida->save();

		return redirect('/validado/unidadmedida')->with('actualizado','Unidad de Medida actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['um_id'=>'required']);
		$um_id=$request->get('um_id');
		$unidadmedida = UnidadMedida::find($um_id);
		$unidadmedida->delete();

		return redirect('/validado/unidadmedida')->with('eliminado','Unidad de Medida eliminada');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
