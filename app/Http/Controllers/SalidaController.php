<?php namespace SICPA\Http\Controllers;

use SICPA\Comprobante;
use SICPA\DetalleComprobante;
use SICPA\Operacion;
use SICPA\TipoComprobante;
use SICPA\Entidad;
use SICPA\Producto;
use SICPA\Inventario;
use SICPA\Vendedor;
use SICPA\Pago;
use SICPA\Conversion;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearComprobanteRequest;
use SICPA\Http\Requests\EditarComprobanteRequest;
use Illuminate\Database;
use Carbon\Carbon;
use Input;

class SalidaController extends Controller {

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
		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->orderBy('comp_fecha','desc')->orderBy('comp_nro','desc')->limit(25)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo cliente
		$tipocomprobantes = TipoComprobante::where('tcomp_id',1)->orwhere('tcomp_id',2)->get();
		return view('salida.mostrar',['comprobantes'=> $comprobantes,'tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades,'vendedores'=> $vendedores]);
	}

	public function postIndex(Request $request)
	{
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));	

		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('comp_nro','like','%'.$comp_nro.'%')->where('comp_guia','like','%'.$comp_guia.'%');

		if($comp_cond != "0")
		{
			$comprobantes = $comprobantes->where('comp_cond','=',$comp_cond);
		}
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
		if($tcomp_id != "0")
		{
			$comprobantes = $comprobantes->where('tcomp_id','=',$tcomp_id);
		}
		if($ent_id != "TODOS")
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
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo proveedor
		$tipocomprobantes = TipoComprobante::all();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();

		if(Input::get('imprimir'))
			return view('reporte.ingresoexcel',['comprobantes'=> $comprobantes,'tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades,'vendedores'=> $vendedores]);
		return view('salida.mostrar',['comprobantes'=> $comprobantes,'tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades,'vendedores'=> $vendedores]);
	}

	public function getCrear()
	{
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo cliente
		$tipocomprobantes = TipoComprobante::where('tcomp_id',1)->orwhere('tcomp_id',2)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		return view('salida.crear',['tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades,'vendedores'=> $vendedores]);
	}

	public function postCrear(CrearComprobanteRequest $request)
	{
		$comp_id = Comprobante::create
		(
			[
				'comp_nro' => strtoupper($request->get('comp_nro')),
				'comp_fecha' => strtoupper($request->get('comp_fecha')),
				'comp_guia' => strtoupper($request->get('comp_guia')),
				'comp_est' => strtoupper($request->get('comp_est')),
				'comp_subt' => strtoupper($request->get('comp_subt')),
				'comp_igv' => strtoupper($request->get('comp_igv')),
				'comp_tot' => strtoupper($request->get('comp_tot')),
				'comp_saldo' => strtoupper($request->get('comp_saldo')),
				'comp_cond' => strtoupper($request->get('comp_cond')),	
				'comp_tipcambio' => strtoupper($request->get('comp_tipcambio')),
				'comp_moneda' => strtoupper($request->get('comp_moneda')),
				'tcomp_id' => strtoupper($request->get('tcomp_id')),
				'ent_id' => strtoupper($request->get('ent_id')),
				'vend_id' => strtoupper($request->get('vend_id')),
				
				//'comp_fpago' => strtoupper($request->get('comp_fpago')),
				//'comp_banco' => strtoupper($request->get('comp_banco')),
				//'comp_nope' => strtoupper($request->get('comp_nope')),
				'comp_np' => strtoupper($request->get('comp_np')),
				'comp_obs' => strtoupper($request->get('comp_obs')),
				'tcompinc_id' => '12'
			]
		)->comp_id;

		$comprobante=Comprobante::find($comp_id);
		//if($request->get('comp_cond')=="AL CREDITO")
		//{
			$comprobante->comp_fven=$request->get('comp_fven');
			$comprobante->save();
		//}

		Operacion::create
		(
			[
				'tope_id' => 2, ///// tipo operacion venta 
				'comp_id' => $comp_id,
				'ie_id' => 1 ///// para ie RESGUARDO
			]
		);

		//return view('salida.crear',['comp_id'=> $comp_id,'creado' 'Comprobante creado']);

		/*$detallecomprobantes = DetalleComprobante::where('comp_id',$comp_id)->get();
		$comprobante = Comprobante::find($comp_id);
		return view('detallesalida.mostrar',['detallecomprobantes'=> $detallecomprobantes,'comprobante'=>$comprobante]);*/
		return redirect("/validado/detallesalida?comp_id={$comp_id}")->with('creado','Comprobante creado');
	}

	public function getSanular(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		$comprobante = Comprobante::find($comp_id);
		$comprobante->comp_est="ANULADO";
		$comprobante->save();
		
		$detallecomprobantes = DetalleComprobante::where('comp_id',$comp_id)->get();
		//DetalleComprobante::where('comp_id',$comp_id)->delete();

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

			$inventario->inv_cant=$cantidad_ant + $cantidad;
			$inventario->inv_fecha=Carbon::now();
			$inventario->save();
		
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////

		return redirect('/validado/salida')->with('actualizado','Comprobante ANULADO');

	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		$comprobante = Comprobante::find($comp_id);
		$entidades = Entidad::where('tent_id','1')->orderBy('ent_rz','asc')->get();
		$tipocomprobantes = TipoComprobante::where('tcomp_id',1)->orwhere('tcomp_id',2)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();

		return view('salida.editar',['comprobante'=>$comprobante,'tipocomprobantes'=> $tipocomprobantes,'entidades'=>$entidades,'vendedores'=> $vendedores]);

	}

	public function postEditar(EditarComprobanteRequest $request)
	{
		$comp_id=strtoupper($request->get('comp_id'));
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha = strtoupper($request->get('comp_fecha'));
		$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_est = strtoupper($request->get('comp_est'));
		$comp_cond = strtoupper($request->get('comp_cond'));	
		$comp_tipcambio = strtoupper($request->get('comp_tipcambio'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));		
		$comp_fpago = strtoupper($request->get('comp_fpago'));
		$comp_banco = strtoupper($request->get('comp_banco'));
		$comp_nope = strtoupper($request->get('comp_nope'));
		$comp_fven = strtoupper($request->get('comp_fven'));
		$vend_id = strtoupper($request->get('vend_id'));
		$comp_np = strtoupper($request->get('comp_np'));
		$comp_obs = strtoupper($request->get('comp_obs'));
		
		$comprobante = Comprobante::find($comp_id);


		$comprobante->comp_nro=$comp_nro;
		$comprobante->comp_fecha=$comp_fecha;
		$comprobante->comp_guia=$comp_guia;
		$comprobante->comp_est=$comp_est;
		$comprobante->comp_cond=$comp_cond;
		$comprobante->comp_tipcambio=$comp_tipcambio;
		$comprobante->comp_moneda=$comp_moneda;
		$comprobante->tcomp_id=$tcomp_id;
		$comprobante->ent_id=$ent_id;
		$comprobante->comp_fpago=$comp_fpago;
		$comprobante->comp_banco=$comp_banco;
		$comprobante->comp_nope=$comp_nope;
		$comprobante->vend_id=$vend_id;
		$comprobante->comp_np=$comp_np;
		$comprobante->comp_obs=$comp_obs;

		//if($comp_cond=="AL CREDITO")
			$comprobante->comp_fven=$comp_fven;
		$comprobante->save();

		if($request->get('cambio')=="SI")
		{
			$comprobante->pagos()->delete();
			
			$nro_filas = strtoupper($request->get('nro_filas'));
			
			for ($i=1; $i < $nro_filas ; $i++) { 
				$pago_fecha=$request->get('pago_fecha'.$i);
				$pago_banco=$request->get('pago_banco'.$i);
				$pago_nope=$request->get('pago_nope'.$i);
				$pago_tipcambio=$request->get('pago_tipcambio'.$i);
				$pago_monto=$request->get('pago_monto'.$i);

				Pago::create
				(
					[
						'pago_fecha' => $pago_fecha,
						'pago_monto' => $pago_monto,
						'pago_banco' => $pago_banco,
						'pago_nope' => $pago_nope,
						'pago_tipcambio' => $pago_tipcambio,
						'comp_id' => $comp_id
					]
				);
			}
		}
		
		$tot_pago = Pago::where('comp_id',$comp_id)->sum('pago_monto');

		$comprobante->comp_saldo=$comprobante->comp_tot - $tot_pago;
		if($comprobante->comp_saldo==0 && $comprobante->comp_cond=="AL CREDITO")
			$comprobante->comp_cond="CANCELADO";
		$comprobante->save();
		

		return redirect('/validado/salida')->with('actualizado','Comprobante actualizado');
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

			$inventario->inv_cant=$cantidad_ant + $cantidad;
			$inventario->inv_fecha=Carbon::now();
			$inventario->save();
		
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////

		Operacion::where('comp_id',$comp_id)->delete();

		Comprobante::find($comp_id)->delete();

		return redirect('/validado/salida')->with('eliminado','Comprobante eliminado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
