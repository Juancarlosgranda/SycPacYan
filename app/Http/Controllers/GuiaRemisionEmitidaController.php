<?php namespace SICPA\Http\Controllers;

use SICPA\Comprobante;
use SICPA\DetalleComprobante;
use SICPA\Operacion;
use SICPA\TipoComprobante;
use SICPA\Entidad;
use SICPA\Producto;
use SICPA\Inventario;
use SICPA\Vendedor;
use SICPA\Conversion;
use SICPA\TipoComprobanteInc;
use SICPA\Unidad;
use SICPA\Departamento;
use SICPA\Provincia;
use SICPA\Distrito;
use SICPA\MotivoTraslado;
use SICPA\AdicionalGuia;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearGuiaRemisionEmitidaRequest;
use SICPA\Http\Requests\EditarNotaCreditoEmitidaRequest;
use Illuminate\Database;
use Carbon\Carbon;
use Input;

class GuiaRemisionEmitidaController extends Controller {

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
		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','7')->where('t_comprobante.comp_id','<>','1')->orderBy('comp_fecha','desc')->orderBy('comp_nro','desc')->limit(25)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo cliente
		//$tipocomprobanteincs = TipoComprobanteInc::where('tcomp_id',3)->get(); // 3 Nota de Credito
		return view('guiaremisionemitida.mostrar',['comprobantes'=> $comprobantes,'entidades'=> $entidades,'vendedores'=> $vendedores]);
	}

	public function postIndex(Request $request)
	{
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		//$comp_guia = strtoupper($request->get('comp_guia'));
		//$comp_cond = strtoupper($request->get('comp_cond'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));	

		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','7')->where('t_comprobante.comp_id','<>','1')->where('comp_nro','like','%'.$comp_nro.'%');

		/*if($comp_cond != "0")
		{
			$comprobantes = $comprobantes->where('comp_cond','=',$comp_cond);
		}*/
		if($comp_moneda != "0")
		{
			$comprobantes = $comprobantes->where('comp_moneda','=',$comp_moneda);
		}
		if($comp_fecha_ini != "")
		{
			$comprobantes = $comprobantes->where('comp_fecha','>=',$comp_fecha_ini);
		}
		if($comp_fecha_fin != "")
		{
			$comprobantes = $comprobantes->where('comp_fecha','<=',$comp_fecha_fin);
		}
		if($ent_id != "0")
		{
			$comprobantes = $comprobantes->where('ent_id','=',$ent_id);
		}
		if($vend_id != "0")
		{
			$comprobantes = $comprobantes->where('vend_id','=',$vend_id);
		}
		if($igv=="C")
		{
			$comprobantes = $comprobantes->where('comp_igv','>','0');
		}
		if($igv=="S")
		{
			$comprobantes = $comprobantes->where('comp_igv','=','0');
		}
		
		$comprobantes=$comprobantes->orderBy('comp_fecha','desc')->orderBy('comp_nro','desc')->get();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo cliente
		//$tipocomprobantes = TipoComprobante::all();
		$tipocomprobanteincs = TipoComprobanteInc::where('tcomp_id',3)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();

		if(Input::get('imprimir'))
			return view('reporte.ingresoexcel',['comprobantes'=> $comprobantes,'tipocomprobanteincs'=> $tipocomprobanteincs,'entidades'=> $entidades,'vendedores'=> $vendedores]);
		return view('guiaremisionemitida.mostrar',['comprobantes'=> $comprobantes,'tipocomprobanteincs'=> $tipocomprobanteincs,'entidades'=> $entidades,'vendedores'=> $vendedores]);
	}

	public function getCrear()
	{
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo cliente
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		$unidades = Unidad::orderBy('uni_desc','asc')->get();
		$departamentos = Departamento::orderBy('dpto_desc','asc')->get();
		$provincias = Provincia::orderBy('prov_desc','asc')->get();
		$distritos = Distrito::orderBy('dist_desc','asc')->get();
		$motivotraslados = MotivoTraslado::orderBy('mtras_desc','asc')->get();
		return view('guiaremisionemitida.crear',['entidades'=> $entidades,'vendedores'=> $vendedores,'unidades'=> $unidades,'departamentos'=> $departamentos,'provincias'=> $provincias,'distritos'=> $distritos,'motivotraslados'=> $motivotraslados]);
	}

	public function postCrear(CrearGuiaRemisionEmitidaRequest $request)
	{
		$comp_ref_id = strtoupper($request->get('comp_ref_id'));
		$comp_referencia= Comprobante::find($comp_ref_id);

		$comp_id = Comprobante::create
		(
			[
				'comp_nro' => strtoupper($request->get('comp_nro')),
				'comp_fecha' => strtoupper($request->get('comp_fecha')),
				'tcomp_id' => 6, // tipo guia remision
				'ent_id' => $comp_referencia->entidad->ent_id,
				'vend_id' => strtoupper($request->get('vend_id')),
				'comp_ref' => $comp_ref_id,
				'comp_obs' => strtoupper($request->get('comp_obs')),
				'tcompinc_id' => '12'
				
			]
		)->comp_id;

		AdicionalGuia::create
		(
			[
				'mtras_id' => strtoupper($request->get('mtras_id')),
				'adig_transprog' => strtoupper($request->get('adig_transprog')),
				'adig_pbruto' => strtoupper($request->get('adig_pbruto')),
				'uni_id' => strtoupper($request->get('uni_id')),
				'adig_nbulto' => strtoupper($request->get('adig_nbulto')),
				'adig_mtrasl' => strtoupper($request->get('adig_mtrasl')),
				'adig_ftrasl' => strtoupper($request->get('adig_ftrasl')),
				'adig_doctrans' => strtoupper($request->get('adig_doctrans')),
				'adig_tdoctrans' => strtoupper($request->get('adig_tdoctrans')),
				'adig_rztrans' => strtoupper($request->get('adig_rztrans')),
				'adig_nroplaca' => strtoupper($request->get('adig_nroplaca')),
				'adig_doccond' => strtoupper($request->get('adig_doccond')),
				'adig_tdoccond' => strtoupper($request->get('adig_tdoccond')),
				'adig_paispart' => strtoupper($request->get('adig_paispart')),
				'dpto_idpart' => strtoupper($request->get('dpto_idpart')),
				'prov_idpart' => strtoupper($request->get('prov_idpart')),
				'dist_idpart' => strtoupper($request->get('dist_idpart')),
				'adig_dirpart' => strtoupper($request->get('adig_dirpart')),
				'adig_paislleg' => strtoupper($request->get('adig_paislleg')),
				'dpto_idlleg' => strtoupper($request->get('dpto_idlleg')),
				'prov_idlleg' => strtoupper($request->get('prov_idlleg')),
				'dist_idlleg' => strtoupper($request->get('dist_idlleg')),
				'adig_dirlleg' => strtoupper($request->get('adig_dirlleg')),
				'adig_ncontenedor' => strtoupper($request->get('adig_ncontenedor')),
				'adig_codpuerto' => strtoupper($request->get('adig_codpuerto')),
				'comp_id' => $comp_id,
				
			]
		);

		//$comprobante=Comprobante::find($comp_id);
		/*if($request->get('comp_cond')=="AL CREDITO")
		{
			$comprobante->comp_fven=$request->get('comp_fven');
			$comprobante->save();
		}*/

		Operacion::create
		(
			[
				'tope_id' => 6, ///// tipo operacion nota credito 
				'comp_id' => $comp_id,
				'ie_id' => 1 ///// para ie RESGUARDO
			]
		);

		$comprobante=Comprobante::find($comp_id);
		
		
		return redirect("/validado/detallenotacreditoemitida?comp_id={$comp_id}")->with('creado','Guia de Remisión creada');
				

		//return view('salida.crear',['comp_id'=> $comp_id,'creado' 'Comprobante creado']);

		/*$detallecomprobantes = DetalleComprobante::where('comp_id',$comp_id)->get();
		$comprobante = Comprobante::find($comp_id);
		return view('detallesalida.mostrar',['detallecomprobantes'=> $detallecomprobantes,'comprobante'=>$comprobante]);*/
		
		//return redirect("/validado/detallenotacreditoemitida?comp_id={$comp_id}")->with('creado','Nota de Crédito creada');
	}


	public function getEditar(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		$comprobante = Comprobante::find($comp_id);
		$comprobante_ref = Comprobante::find($comprobante->comp_ref);
		$entidades = Entidad::where('tent_id','1')->orderBy('ent_rz','asc')->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();

		$unidades = Unidad::orderBy('uni_desc','asc')->get();
		$departamentos = Departamento::orderBy('dpto_desc','asc')->get();
		$provincias = Provincia::orderBy('prov_desc','asc')->get();
		$distritos = Distrito::orderBy('dist_desc','asc')->get();
		$motivotraslados = MotivoTraslado::orderBy('mtras_desc','asc')->get();

		return view('guiaremisionemitida.editar',['comprobante'=>$comprobante,'comprobante_ref'=>$comprobante_ref,'entidades'=>$entidades,'vendedores'=> $vendedores,'unidades'=> $unidades,'departamentos'=> $departamentos,'provincias'=> $provincias,'distritos'=> $distritos,'motivotraslados'=> $motivotraslados]);

	}

	public function postEditar(EditarNotaCreditoEmitidaRequest $request)
	{
		$tcompinc_id = strtoupper($request->get('tcompinc_id'));
		$comp_ref_id = strtoupper($request->get('comp_ref_id'));
		$comp_referencia= Comprobante::find($comp_ref_id);


		$comp_id=strtoupper($request->get('comp_id'));
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha = strtoupper($request->get('comp_fecha'));	
		$comp_tipcambio = $comp_referencia->comp_tipcambio;
		$comp_moneda = $comp_referencia->comp_moneda;
		$tcomp_id = '3';
		$tcompinc_id = strtoupper($request->get('tcompinc_id'));
		$ent_id = $comp_referencia->entidad->ent_id;		
		$vend_id = strtoupper($request->get('vend_id'));
		$comp_obs = strtoupper($request->get('comp_obs'));
		$comp_desc = strtoupper($request->get('comp_desc'));
		$comp_ref = $comp_ref_id;
		$comp_fven = strtoupper($request->get('comp_fven'));
		$comprobante = Comprobante::find($comp_id);


		$comprobante->comp_nro=$comp_nro;
		$comprobante->comp_fecha=$comp_fecha;
		$comprobante->comp_tipcambio=$comp_tipcambio;
		$comprobante->comp_moneda=$comp_moneda;
		$comprobante->tcomp_id=$tcomp_id;
		$comprobante->tcompinc_id=$tcompinc_id;
		$comprobante->ent_id=$ent_id;
		$comprobante->vend_id=$vend_id;
		$comprobante->comp_obs=$comp_obs;
		$comprobante->comp_desc=$comp_desc;
		$comprobante->comp_ref=$comp_ref;
		$comprobante->comp_fven=$comp_fven;
		
		$comprobante->save();

		return redirect('/validado/notacreditoemitida')->with('actualizado','Comprobante actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		
		$detallecomprobantes = DetalleComprobante::where('comp_id',$comp_id)->get();
		DetalleComprobante::where('comp_id',$comp_id)->delete();

		///////////////////////// EDITANDO INVENTARIO ///////////////////////////////////////////////////
		foreach ($detallecomprobantes as $detallecomprobante) {

			$inventario=Inventario::where('prod_id',$detallecomprobante->unidadproducto->prod_id)->get();
			$inv_id=$inventario[0]->inv_id;
			
			$inventario=Inventario::find($inv_id);

			$um_producto=Producto::find($detallecomprobante->unidadproducto->prod_id)->um_id;
			$um_detalle=$detallecomprobante->unidadproducto->um_id;
			$cantidad=$detallecomprobante->dcomp_cant;
			$cantidad_ant=$inventario->inv_cant;

			if ($um_producto != $um_detalle) 
			{
				if((Conversion::where('um_id1',$um_producto)->where('um_id2',$um_detalle)->count())>(Conversion::where('um_id2',$um_producto)->where('um_id1',$um_detalle)->count()))
				{
					$conversion=Conversion::where('um_id1',$um_producto)->where('um_id2',$um_detalle)->get();
					$factor=$conversion[0]->conv_fact;
					$cantidad= ($cantidad/$factor);
				}
				else
				{
					$conversion=Conversion::where('um_id2',$um_producto)->where('um_id1',$um_detalle)->get();
					$factor=$conversion[0]->conv_fact;
					$cantidad= ($cantidad*$factor);
				}
			}

			$inventario->inv_cant=$cantidad_ant - $cantidad;
			$inventario->inv_fecha=Carbon::now();
			$inventario->save();
		
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////

		Operacion::where('comp_id',$comp_id)->delete();

		Comprobante::find($comp_id)->delete();

		return redirect('/validado/notacreditoemitida')->with('eliminado','Comprobante eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
