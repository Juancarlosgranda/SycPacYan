<?php namespace SICPA\Http\Controllers;

use SICPA\TipoGasto;
use SICPA\IEExterno;
use Illuminate\Http\Request;

class TipoGastoController extends Controller {

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
		$tipogastos = TipoGasto::orderBy('tgasto_desc','asc')->get();
		return view('tipogasto.mostrar',['tipogastos'=> $tipogastos]);
	}

	public function getCrear()
	{
		return view('tipogasto.crear');
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['tgasto_desc' =>'required|unique:t_tipogasto']);
		TipoGasto::create
		(
			[
				'tgasto_desc' => strtoupper($request->get('tgasto_desc'))
			]
		);
		return redirect('/validado/tipogasto')->with('creado','Tipo de Gasto creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['tgasto_id'=>'required']);
		$tgasto_id=$request->get('tgasto_id');
		$tipogasto = TipoGasto::find($tgasto_id);

		return view('tipogasto.editar',['tipogasto'=>$tipogasto]);
	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['tgasto_id'=>'required','tgasto_desc' =>'required|unique:t_tipogasto']);
		$tgasto_id=$request->get('tgasto_id');
		$tgasto_desc=strtoupper($request->get('tgasto_desc'));
		$tipogasto = TipoGasto::find($tgasto_id);

		$tipogasto->tgasto_desc=$tgasto_desc;
		$tipogasto->save();

		return redirect('/validado/tipogasto')->with('actualizado','Tipo de Gasto actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['tgasto_id'=>'required']);
		$tgasto_id=$request->get('tgasto_id');

		$tipogasto = TipoGasto::find($tgasto_id);
		$tipogasto->delete();
		return redirect('/validado/tipogasto')->with('eliminado','Tipo de Gasto eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
