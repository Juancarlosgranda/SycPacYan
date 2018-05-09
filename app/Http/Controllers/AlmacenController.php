<?php namespace SICPA\Http\Controllers;

use SICPA\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller {

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
		$almacenes = Almacen::all();
		return view('almacen.mostrar',['almacenes'=> $almacenes]);
	}

	public function getCrear()
	{
		return view('almacen.crear');
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['alm_desc' =>'required|unique:t_almacen']);
		Almacen::create
		(
			[
				'alm_desc' => strtoupper($request->get('alm_desc'))
			]
		);
		return redirect('/validado/almacen')->with('creado','El almacen ha sido creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['alm_id'=>'required']);
		$alm_id=$request->get('alm_id');
		$almacen = Almacen::find($alm_id);

		return view('almacen.editar',['almacen'=>$almacen]);

	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['alm_id'=>'required','alm_desc' =>'required|unique:t_almacen']);
		$alm_id=$request->get('alm_id');
		$alm_desc=strtoupper($request->get('alm_desc'));
		$almacen = Almacen::find($alm_id);

		$almacen->alm_desc=$alm_desc;
		$almacen->save();

		return redirect('/validado/almacen')->with('actualizado','Almacen actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['alm_id'=>'required']);
		$alm_id=$request->get('alm_id');
		$almacen = Almacen::find($alm_id);
		$almacen->delete();

		return redirect('/validado/almacen')->with('eliminado','Almacen eliminada');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
