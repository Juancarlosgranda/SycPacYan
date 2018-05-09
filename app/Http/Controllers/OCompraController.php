<?php namespace SICPA\Http\Controllers;

use SICPA\OrdenCV;
use SICPA\DetalleOrdenCV;
use SICPA\Entidad;
use SICPA\Producto;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearOrdenCVRequest;
use SICPA\Http\Requests\EditarOrdenCVRequest;
use Illuminate\Database;
use Carbon\Carbon;
use Input;

class OCompraController extends Controller {

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
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$ordencvs = OrdenCV::where('ocv_tipo','OCOMPRA')->get();

		return view('ocompra.mostrar',['ordencvs'=> $ordencvs,'entidades'=> $entidades]);
	}

	public function postIndex(Request $request)
	{
		$ocv_nro = strtoupper($request->get('ocv_nro'));
		$ocv_fecha_ini = strtoupper($request->get('ocv_fecha_ini'));
		$ocv_fecha_fin = strtoupper($request->get('ocv_fecha_fin'));
		$ocv_guia = strtoupper($request->get('ocv_guia'));
		$ocv_cond = strtoupper($request->get('ocv_cond'));
		$ocv_moneda = strtoupper($request->get('ocv_moneda'));
		$ocv_tipo = strtoupper($request->get('ocv_tipo'));
		$ent_id = strtoupper($request->get('ent_id'));

		$ordencvs = OrdenCV::where('ocv_tipo','OCOMPRA')->where('ocv_nro','like','%'.$ocv_nro.'%');

		if($comp_moneda != "0")
		{
			$ordencvs = $ordencvs->where('ocv_moneda','=',$ocv_moneda);
		}
		if($ocv_fecha_ini != "")
		{
			$ordencvs = $ordencvs->where('ocv_fecha','>=',$ocv_fecha_ini);
		}
		if($ocv_fecha_fin != "")
		{
			$ordencvs = $ordencvs->where('ocv_fecha','<=',$ocv_fecha_fin);
		}
		if($tocv_id != "0")
		{
			$ordencvs = $ordencvs->where('ocv_tipo','=',$ocv_tipo);
		}
		if($ent_id != "0")
		{
			$ordencvs = $ordencvs->where('ent_id','=',$ent_id);
		}

		$ordencvs=$ordencvs->get();
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor

		if(Input::get('imprimir'))
			return view('reporte.ocompra',['$ordencvs'=> $ordencvs,'entidades'=> $entidades]);
		return view('ocompra.mostrar',['$ordencvs'=> $ordencvs,'entidades'=> $entidades]);
		
	}

	public function getCrear()
	{
		$entidades = Entidad::where('tent_id','2')->orderBy('ent_rz','asc')->get(); // tipo proveedor
		return view('ocompra.crear',['entidades'=> $entidades]);
	}

	public function postCrear(CrearOrdenCVRequest $request)
	{
		$ocv_id = OrdenCV::create
		(
			[
				'ocv_nro' => strtoupper($request->get('ocv_nro')),
				'ocv_fecha' => strtoupper($request->get('ocv_fecha')),
				'ocv_est' => strtoupper($request->get('ocv_est')),
				'ocv_subt' => strtoupper($request->get('ocv_subt')),
				'ocv_igv' => strtoupper($request->get('ocv_igv')),
				'ocv_tot' => strtoupper($request->get('ocv_tot')),
				'ocv_saldo' => strtoupper($request->get('ocv_saldo')),
				'ocv_cond' => strtoupper($request->get('ocv_cond')),	
				'ocv_tipcambio' => strtoupper($request->get('ocv_tipcambio')),
				'ocv_moneda' => strtoupper($request->get('ocv_moneda')),
				'ocv_tipo' => strtoupper($request->get('ocv_tipo')),
				'ent_id' => strtoupper($request->get('ent_id'))
			]
		)->ocv_id;

		$ordencv=OrdenCV::find($ocv_id);

		$file = $request->file('ocv_doc');
		if($file)
		{
			$ruta='\img';
			$nombre= $ocv_id.'.'.$file->guessExtension();
			$file->move(getcwd().$ruta,$nombre);
			$ordencv->ocv_doc=$nombre;
			$ordencv->save();
		}	

		return redirect("/validado/detalleocompra?ocv_id={$ocv_id}")->with('creado','Orden de Compra creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		$ordencv = OrdenCV::find($ocv_id);
		$entidades = Entidad::where('tent_id','2')->orderBy('ent_rz','asc')->get();

		return view('ocompra.editar',['ordencv'=>$ordencv,'entidades'=>$entidades]);

	}

	public function postEditar(EditarOrdenCVRequest $request)
	{
		$ocv_id=strtoupper($request->get('ocv_id'));
		$ocv_nro = strtoupper($request->get('ocv_nro'));
		$ocv_fecha = strtoupper($request->get('ocv_fecha'));
		$ocv_cond = strtoupper($request->get('ocv_cond'));	
		$ocv_tipcambio = strtoupper($request->get('ocv_tipcambio'));
		$ocv_moneda = strtoupper($request->get('ocv_moneda'));
		$ocv_tipo = strtoupper($request->get('ocv_tipo'));
		$ent_id = strtoupper($request->get('ent_id'));

		$ordencv = OrdenCV::find($ocv_id);

		$ordencv->ocv_nro=$ocv_nro;
		$ordencv->ocv_fecha=$ocv_fecha;
		$ordencv->ocv_cond=$ocv_cond;
		$ordencv->ocv_tipcambio=$ocv_tipcambio;
		$ordencv->ocv_moneda=$ocv_moneda;
		$ordencv->ocv_tipo=$ocv_tipo;
		$ordencv->ent_id=$ent_id;

		$file = $request->file('ocv_doc');
		if($file)
		{
			$ruta='\img';
			$nombre= $ocv_id.'.'.$file->guessExtension();
			$file->move(getcwd().$ruta,$nombre);
			$ordencv->ocv_doc=$nombre;
		}

		$ordencv->save();

		return redirect('/validado/ocompra')->with('actualizado','Comprobante actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		
		$detalleordencvs = DetalleComprobante::where('ocv_id',$ocv_id)->get();
		DetalleComprobante::where('ocv_id',$ocv_id)->delete();
		OrdenCV::find($ocv_id)->delete();

		return redirect('/validado/ocompra')->with('eliminado','Orden de Compra eliminado');
	}

	public function getArchivo(Request $request)
	{
		$this->validate($request,['ocv_doc'=>'required']);
		$ocv_doc=$request->get('ocv_doc');
		$ordencv = OrdenCV::find($comp_id);
		$entidades = Entidad::where('tent_id','2')->get();

		return view('ocompra.editar',['ordencv'=>$ordencv,'tipocomprobantes'=> $tipocomprobantes,'entidades'=>$entidades]);

	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
