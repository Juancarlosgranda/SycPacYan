<?php namespace SICPA\Http\Controllers;

use SICPA\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller {

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
		$vendedores = Vendedor::orderBy('vend_id','asc')->get();
		return view('vendedor.mostrar',['vendedores'=> $vendedores]);
	}

	public function getCrear()
	{
		return view('vendedor.crear');
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['vend_dni' =>'required','vend_nom' =>'required','vend_tel' =>'required','vend_ciu' =>'required']);
		Vendedor::create
		(
			[
				'vend_dni' => strtoupper($request->get('vend_dni')),
				'vend_nom' => strtoupper($request->get('vend_nom')),
				'vend_tel' => strtoupper($request->get('vend_tel')),
				'vend_ciu' => strtoupper($request->get('vend_ciu')),
				'vend_dpto' => strtoupper($request->get('vend_dpto')),
				'vend_obs' => strtoupper($request->get('vend_obs'))

			]
		);
		return redirect('/validado/vendedor')->with('creado','El Vendedor ha sido creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['vend_id'=>'required']);
		$vend_id=$request->get('vend_id');
		$vendedor = Vendedor::find($vend_id);

		return view('vendedor.editar',['vendedor'=>$vendedor]);

	}

	public function postEditar(Request $request)
	{
		$vend_id=$request->get('vend_id');
		$vend_dni=($request->get('vend_dni'));
		$vend_nom=($request->get('vend_nom'));
		$vend_tel=($request->get('vend_tel'));
		$vend_ciu=($request->get('vend_ciu'));
		$vend_dpto=($request->get('vend_dpto'));
		$vend_obs=($request->get('vend_obs'));
		$vendedor = Vendedor::find($vend_id);

		$vendedor->vend_dni=$vend_dni;
		$vendedor->vend_nom=$vend_nom;
		$vendedor->vend_tel=$vend_tel;
		$vendedor->vend_ciu=$vend_ciu;
		$vendedor->vend_dpto=$vend_dpto;
		$vendedor->vend_obs=$vend_obs;
		$vendedor->save();

		return redirect('/validado/vendedor')->with('actualizado','Vendedor actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['vend_id'=>'required']);
		$vend_id=$request->get('vend_id');
		$vendedor = Vendedor::find($vend_id);
		$vendedor->delete();

		return redirect('/validado/vendedor')->with('eliminado','Vendedor eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
