<?php namespace SICPA\Http\Controllers;

use SICPA\Entidad;
use SICPA\TipoEntidad;
use SICPA\Comprobante;
use Illuminate\Http\Request;
use SICPA\Http\Requests\EditarClienteRequest;
use SICPA\Http\Requests\CrearClienteRequest;
use Input;

class ClienteController extends Controller {

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
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz')->get(); // 1 es el cliente 
		return view('cliente.mostrar',['entidades'=> $entidades]);
	}

	public function postIndex(Request $request)
	{
		$ent_ruc=strtoupper($request->get('ent_ruc'));
		$ent_rz=strtoupper($request->get('ent_rz'));
		$ent_ciu=strtoupper($request->get('ent_ciu'));
		$ent_dpto=strtoupper($request->get('ent_dpto'));
		$ent_dir=strtoupper($request->get('ent_dir'));
		$ent_cont=strtoupper($request->get('ent_cont'));

		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->where('ent_ruc','like','%'.$ent_ruc.'%')->where('ent_rz','like','%'.$ent_rz.'%')->where('ent_ciu','like','%'.$ent_ciu.'%')->where('ent_cont','like','%'.$ent_cont.'%')->where('ent_dir','like','%'.$ent_dir.'%')->where('ent_dpto','like','%'.$ent_dpto.'%')->orderBy('ent_rz')->get(); // 1 es el cliente 
		if(Input::get('imprimir'))
			return view('reporte.cliente',['entidades'=> $entidades]);
		return view('cliente.mostrar',['entidades'=> $entidades]);
	}

	public function getCrear()
	{
		return view('cliente.crear');
	}

	public function postCrear(CrearClienteRequest $request)
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
				'ent_dpto' => strtoupper($request->get('ent_dpto')),
				'ent_correo' => $request->get('ent_correo'),
				'tent_id' => "1"

			]
		);
		return redirect('/validado/cliente')->with('creado','Cliente creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$entidad = Entidad::find($ent_id);

		return view('cliente.editar',['entidad'=>$entidad]);

	}

	public function postEditar(EditarClienteRequest $request)
	{
		$ent_id=strtoupper($request->get('ent_id'));
		$ent_ruc=strtoupper($request->get('ent_ruc'));
		$ent_rz=strtoupper($request->get('ent_rz'));
		$ent_dir=strtoupper($request->get('ent_dir'));
		$ent_ciu=strtoupper($request->get('ent_ciu'));
		$ent_tel=strtoupper($request->get('ent_tel'));
		$ent_cont=strtoupper($request->get('ent_cont'));
		$ent_ctel=strtoupper($request->get('ent_ctel'));
		$ent_dpto=strtoupper($request->get('ent_dpto'));
		$ent_correo=$request->get('ent_correo');
		$tent_id= "1";
		$entidad = Entidad::find($ent_id);

		$entidad->ent_ruc=$ent_ruc;
		$entidad->ent_rz=$ent_rz;
		$entidad->ent_dir=$ent_dir;
		$entidad->ent_ciu=$ent_ciu;
		$entidad->tent_id=$tent_id;
		$entidad->ent_tel=$ent_tel;
		$entidad->ent_cont=$ent_cont;
		$entidad->ent_ctel=$ent_ctel;
		$entidad->ent_dpto=$ent_dpto;
		$entidad->ent_correo=$ent_correo;
		$entidad->save();

		return redirect('/validado/cliente')->with('actualizado','Cliente actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');

		if(Comprobante::where('ent_id',$ent_id)->count()>0)
			return redirect('/validado/cliente')->with('error','No se puede eliminar, comprobantes dependen de ella');		


		$entidad = Entidad::find($ent_id);
		$entidad->delete();

		return redirect('/validado/cliente')->with('eliminado','Cliente eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
