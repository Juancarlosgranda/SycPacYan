<?php namespace SICPA\Http\Controllers;

use SICPA\Entidad;
use SICPA\Comprobante;
use SICPA\TipoEntidad;
use Illuminate\Http\Request;
use SICPA\Http\Requests\EditarEntidadRequest;
use SICPA\Http\Requests\CrearEntidadRequest;

class ProveedorController extends Controller {

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
		$entidades = Entidad::where('tent_id','2')->orderBy('ent_rz')->get();
		return view('proveedor.mostrar',['entidades'=> $entidades]);
	}

	public function getCrear()
	{
		return view('proveedor.crear');
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
				'ent_tel' => strtoupper($request->get('ent_tel')),
				'ent_cont' => strtoupper($request->get('ent_cont')),
				'ent_ctel' => strtoupper($request->get('ent_ctel')),
				'ent_correo' => $request->get('ent_correo'),
				'tent_id' => "2"

			]
		);
		return redirect('/validado/proveedor')->with('creado','Proveedor creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$entidad = Entidad::find($ent_id);

		return view('proveedor.editar',['entidad'=>$entidad]);

	}

	public function postEditar(EditarEntidadRequest $request)
	{
		$ent_id=strtoupper($request->get('ent_id'));
		$ent_ruc=strtoupper($request->get('ent_ruc'));
		$ent_rz=strtoupper($request->get('ent_rz'));
		$ent_dir=strtoupper($request->get('ent_dir'));
		$ent_ciu=strtoupper($request->get('ent_ciu'));
		$ent_tel=strtoupper($request->get('ent_tel'));
		$ent_cont=strtoupper($request->get('ent_cont'));
		$ent_ctel=strtoupper($request->get('ent_ctel'));
		$ent_correo=$request->get('ent_correo');
		$tent_id= "2";
		$entidad = Entidad::find($ent_id);

		$entidad->ent_ruc=$ent_ruc;
		$entidad->ent_rz=$ent_rz;
		$entidad->ent_dir=$ent_dir;
		$entidad->ent_ciu=$ent_ciu;
		$entidad->tent_id=$tent_id;
		$entidad->ent_tel=$ent_tel;
		$entidad->ent_cont=$ent_cont;
		$entidad->ent_ctel=$ent_ctel;
		$entidad->ent_correo=$ent_correo;
		$entidad->save();

		return redirect('/validado/proveedor')->with('actualizado','Proveedor actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');

		if(Comprobante::where('ent_id',$ent_id)->count()>0)
			return redirect('/validado/proveedor')->with('error','No se puede eliminar, comprobantes dependen de este proveedor');		
		$entidad = Entidad::find($ent_id);
		$entidad->delete();

		return redirect('/validado/proveedor')->with('eliminado','Proveedor eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
