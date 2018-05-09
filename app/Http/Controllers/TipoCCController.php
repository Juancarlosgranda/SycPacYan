<?php namespace SICPA\Http\Controllers;

use SICPA\TipoCC;
use SICPA\IEExterno;
use Illuminate\Http\Request;

class TipoCCController extends Controller {

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
		$tipoccs = TipoCC::orderBy('tcc_desc','asc')->get();
		return view('tipocc.mostrar',['tipoccs'=> $tipoccs]);
	}

	public function getCrear()
	{
		return view('tipocc.crear');
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['tcc_desc' =>'required|unique:t_tipocc']);
		TipoCC::create
		(
			[
				'tcc_desc' => strtoupper($request->get('tcc_desc'))
			]
		);
		return redirect('/validado/tipocc')->with('creado','Centro de Costos creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['tcc_id'=>'required']);
		$tcc_id=$request->get('tcc_id');
		$tipocc = TipoCC::find($tcc_id);

		return view('tipocc.editar',['tipocc'=>$tipocc]);
	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['tcc_id'=>'required','tcc_desc' =>'required|unique:t_tipocc']);
		$tcc_id=$request->get('tcc_id');
		$tcc_desc=strtoupper($request->get('tcc_desc'));
		$tipocc = TipoCC::find($tcc_id);

		$tipocc->tcc_desc=$tcc_desc;
		$tipocc->save();

		return redirect('/validado/tipocc')->with('actualizado','Centro de Costos actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['tcc_id'=>'required']);
		$tcc_id=$request->get('tcc_id');
		$tipocc = TipoCC::find($tcc_id);
		$tipocc->delete();
		return redirect('/validado/tipocc')->with('eliminado','Centro de Costos eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
