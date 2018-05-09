<?php namespace SICPA\Http\Controllers;

use SICPA\IEExterno;
use SICPA\DetalleIE;
use SICPA\Operacion;
use SICPA\TipoOperacion;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearIEExternoRequest;
use SICPA\Http\Requests\EditarIEExternoRequest;
use Illuminate\Database;
use Carbon\Carbon;

class IngresoExternoController extends Controller {

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
		// tope_id=3 es tipo Ingreso externo
		$ieexternos = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->select('t_ieexterno.*')->where('t_operacion.tope_id','=','3')->where('t_ieexterno.ie_id','<>','1')->orderBy('ie_fecha','desc')->limit(25)->get();

		return view('ingresoexterno.mostrar',['ieexternos'=> $ieexternos]);
	}

	public function postIndex(Request $request)
	{
		$ie_comp = strtoupper($request->get('ie_comp'));
		$ie_fecha_ini = strtoupper($request->get('ie_fecha_ini'));
		$ie_fecha_fin = strtoupper($request->get('ie_fecha_fin'));
		$ie_guia = strtoupper($request->get('ie_guia'));
		$ie_moneda = strtoupper($request->get('ie_moneda'));
		$ie_ruc = strtoupper($request->get('ie_ruc'));
		$ie_rz = strtoupper($request->get('ie_rz'));
		$ie_tcomp = strtoupper($request->get('ie_tcomp'));

		$ieexternos = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->select('t_ieexterno.*')->where('t_operacion.tope_id','=','3')->where('t_ieexterno.ie_id','<>','1')->where('ie_comp','like','%'.$ie_comp.'%')->where('ie_guia','like','%'.$ie_guia.'%')->where('ie_ruc','like','%'.$ie_ruc.'%')->where('ie_rz','like','%'.$ie_rz.'%');

		if($ie_moneda != "0")
		{
			$ieexternos = $ieexternos->where('ie_moneda','=',$ie_moneda);
		}
		if($ie_fecha_ini != "")
		{
			$ieexternos = $ieexternos->where('ie_fecha','>=',$ie_fecha_ini);
		}
		if($ie_fecha_fin != "")
		{
			$ieexternos = $ieexternos->where('ie_fecha','<=',$ie_fecha_fin);
		}
		if($ie_tcomp != "0")
		{
			$ieexternos = $ieexternos->where('ie_tcomp','=',$ie_tcomp);
		}

		$ieexternos=$ieexternos->get();

		return view('ingresoexterno.mostrar',['ieexternos'=> $ieexternos]);
	}

	public function getCrear()
	{
		return view('ingresoexterno.crear');
	}

	public function postCrear(CrearIEExternoRequest $request)
	{
		$ie_id = IEExterno::create
		(
			[
				'ie_comp' => strtoupper($request->get('ie_comp')),
				'ie_ruc' => strtoupper($request->get('ie_ruc')),
				'ie_rz' => strtoupper($request->get('ie_rz')),
				'ie_fecha' => strtoupper($request->get('ie_fecha')),
				'ie_tcomp' => strtoupper($request->get('ie_tcomp')),
				'ie_guia' => strtoupper($request->get('ie_guia')),
				'ie_subt' => strtoupper($request->get('ie_subt')),
				'ie_igv' => strtoupper($request->get('ie_igv')),
				'ie_tot' => strtoupper($request->get('ie_tot')),
				'ie_tipcambio' => strtoupper($request->get('ie_tipcambio')),
				'ie_moneda' => strtoupper($request->get('ie_moneda'))
			]
		)->ie_id;

		Operacion::create
		(
			[
				'tope_id' => 3, ///// tipo operacion compra 
				'ie_id' => $ie_id,
				'comp_id' => 1 ///// para comp RESGUARDO
			]
		);
		
		return redirect("/validado/detalleingresoexterno?ie_id={$ie_id}")->with('creado','Ingreso creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ie_id'=>'required']);
		$ie_id=$request->get('ie_id');
		$ieexterno = IEExterno::find($ie_id);

		return view('ingresoexterno.editar',['ieexterno'=>$ieexterno]);

	}

	public function postEditar(EditarIEExternoRequest $request)
	{
		$ie_id=strtoupper($request->get('ie_id'));
		$ie_comp = strtoupper($request->get('ie_comp'));
		$ie_ruc = strtoupper($request->get('ie_ruc'));
		$ie_rz = strtoupper($request->get('ie_rz'));
		$ie_fecha = strtoupper($request->get('ie_fecha'));
		$ie_tcomp = strtoupper($request->get('ie_tcomp'));
		$ie_guia = strtoupper($request->get('ie_guia'));
		$ie_tipcambio = strtoupper($request->get('ie_tipcambio'));
		$ie_moneda = strtoupper($request->get('ie_moneda'));

		$ieexterno = IEExterno::find($ie_id);		

		$ieexterno->ie_comp=$ie_comp;
		$ieexterno->ie_fecha=$ie_fecha;
		$ieexterno->ie_guia=$ie_guia;
		$ieexterno->ie_ruc=$ie_ruc;
		$ieexterno->ie_rz=$ie_rz;
		$ieexterno->ie_tipcambio=$ie_tipcambio;
		$ieexterno->ie_moneda=$ie_moneda;
		$ieexterno->ie_tcomp=$ie_tcomp;
		$ieexterno->save();

		return redirect('/validado/ingresoexterno')->with('actualizado','Ingreso actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ie_id'=>'required']);
		$ie_id=$request->get('ie_id');
		
		$detalleieexterno = DetalleIE::where('ie_id',$ie_id)->get();
		DetalleIE::where('ie_id',$ie_id)->delete();

		////////////////////////////////////////////////////////////////////////////////////////////

		Operacion::where('ie_id',$ie_id)->delete();

		IEExterno::find($ie_id)->delete();

		return redirect('/validado/ingresoexterno')->with('eliminado','Ingreso eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
