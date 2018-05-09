<?php namespace SICPA\Http\Controllers;

use SICPA\OrdenCV;
use SICPA\DetalleOrdenCV;
use SICPA\Entidad;
use SICPA\TipoComprobante;
use SICPA\Comprobante;
use SICPA\Producto;
use SICPA\DetalleComprobante;
use SICPA\Inventario;
use SICPA\Operacion;
use SICPA\Vendedor;
use SICPA\Conversion;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearOrdenCVRequest;
use SICPA\Http\Requests\EditarOrdenCVRequest;
use Illuminate\Database;
use Carbon\Carbon;
use Input;

class NPedidoController extends Controller {

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
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->get(); // tipo cliente
		$ordencvs = OrdenCV::where('ocv_tipo','NPEDIDO')->get();

		return view('npedido.mostrar',['ordencvs'=> $ordencvs,'entidades'=> $entidades]);
	}

	public function postIndex(Request $request)
	{
		$ocv_nro = strtoupper($request->get('ocv_nro'));
		$ocv_fecha_ini = strtoupper($request->get('ocv_fecha_ini'));
		$ocv_fecha_fin = strtoupper($request->get('ocv_fecha_fin'));
		$ocv_cond = strtoupper($request->get('ocv_cond'));
		$ocv_moneda = strtoupper($request->get('ocv_moneda'));
		$ocv_tipo = strtoupper($request->get('ocv_tipo'));
		$ent_id = strtoupper($request->get('ent_id'));

		$ordencvs = OrdenCV::where('ocv_tipo','NPEDIDO')->where('ocv_nro','like','%'.$ocv_nro.'%');

		if($ocv_moneda != "0")
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
		if($ent_id != "0")
		{
			$ordencvs = $ordencvs->where('ent_id','=',$ent_id);
		}

		$ordencvs=$ordencvs->get();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->get(); // tipo CLIENTE

		if(Input::get('imprimir'))
			return view('reporte.npedido',['ordencvs'=> $ordencvs,'entidades'=> $entidades]);
		return view('npedido.mostrar',['ordencvs'=> $ordencvs,'entidades'=> $entidades]);
		
	}

	public function getCrear()
	{
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo CLIENTE
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		return view('npedido.crear',['entidades'=> $entidades,'vendedores'=>$vendedores]);
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
				'ent_id' => strtoupper($request->get('ent_id')),
				'vend_id' => strtoupper($request->get('vend_id')),


				'ocv_dirdesp' => strtoupper($request->get('ocv_dirdesp')),
				'ocv_localidad' => strtoupper($request->get('ocv_localidad')),
				'ocv_transporte' => strtoupper($request->get('ocv_transporte')),
				'ocv_nroopcompra' => strtoupper($request->get('ocv_nroopcompra')),
				'ocv_nroopventa' => strtoupper($request->get('ocv_nroopventa')),
				'ocv_obs' => strtoupper($request->get('ocv_obs')),
				'ocv_fechadepcli' => strtoupper($request->get('ocv_fechadepcli')),
				'ocv_fechadeppro' => strtoupper($request->get('ocv_fechadeppro')),
				'ocv_ref' => strtoupper($request->get('ocv_ref')),
				'ocv_nroop1' => strtoupper($request->get('ocv_nroop1')),
				'ocv_nroop2' => strtoupper($request->get('ocv_nroop2')),
				'ocv_nroop3' => strtoupper($request->get('ocv_nroop3')),
				'ocv_banco1' => strtoupper($request->get('ocv_banco1')),				
				'ocv_banco2' => strtoupper($request->get('ocv_banco2')),
				'ocv_banco3' => strtoupper($request->get('ocv_banco3')),
				'ocv_monto1' => strtoupper($request->get('ocv_monto1')),
				'ocv_monto2' => strtoupper($request->get('ocv_monto2')),
				'ocv_monto3' => strtoupper($request->get('ocv_monto3'))
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

		return redirect("/validado/detallenpedido?ocv_id={$ocv_id}")->with('creado','Nota de Pedido creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		$ordencv = OrdenCV::find($ocv_id);
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get(); // tipo CLIENTE
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		return view('npedido.editar',['ordencv'=>$ordencv,'entidades'=>$entidades,'vendedores'=>$vendedores]);

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
		$vend_id = strtoupper($request->get('vend_id'));

		$ocv_dirdesp = strtoupper($request->get('ocv_dirdesp'));
		$ocv_localidad = strtoupper($request->get('ocv_localidad'));
		$ocv_transporte = strtoupper($request->get('ocv_transporte'));
		$ocv_nroopcompra = strtoupper($request->get('ocv_nroopcompra'));
		$ocv_nroopventa = strtoupper($request->get('ocv_nroopventa'));
		$ocv_obs = strtoupper($request->get('ocv_obs'));
		$ocv_fechadepcli = strtoupper($request->get('ocv_fechadepcli'));
		$ocv_fechadeppro = strtoupper($request->get('ocv_fechadeppro'));
		$ocv_ref = strtoupper($request->get('ocv_ref'));
		$ocv_nroop1 = strtoupper($request->get('ocv_nroop1'));
		$ocv_nroop2 = strtoupper($request->get('ocv_nroop2'));
		$ocv_nroop3 = strtoupper($request->get('ocv_nroop3'));
		$ocv_banco1 = strtoupper($request->get('ocv_banco1'));				
		$ocv_banco2 = strtoupper($request->get('ocv_banco2'));
		$ocv_banco3 = strtoupper($request->get('ocv_banco3'));
		$ocv_monto1 = strtoupper($request->get('ocv_monto1'));
		$ocv_monto2 = strtoupper($request->get('ocv_monto2'));
		$ocv_monto3 = strtoupper($request->get('ocv_monto3'));

		$ordencv = OrdenCV::find($ocv_id);

		$ordencv->ocv_nro=$ocv_nro;
		$ordencv->ocv_fecha=$ocv_fecha;
		$ordencv->ocv_cond=$ocv_cond;
		$ordencv->ocv_tipcambio=$ocv_tipcambio;
		$ordencv->ocv_moneda=$ocv_moneda;
		$ordencv->ocv_tipo=$ocv_tipo;
		$ordencv->ent_id=$ent_id;
		$ordencv->vend_id=$vend_id;

		$ordencv->ocv_dirdesp = $ocv_dirdesp;
		$ordencv->ocv_localidad = $ocv_localidad;
		$ordencv->ocv_transporte = $ocv_transporte;
		$ordencv->ocv_nroopcompra = $ocv_nroopcompra;
		$ordencv->ocv_nroopventa = $ocv_nroopventa;
		$ordencv->ocv_obs = $ocv_obs;
		$ordencv->ocv_fechadepcli = $ocv_fechadepcli;
		$ordencv->ocv_fechadeppro = $ocv_fechadeppro;
		$ordencv->ocv_ref = $ocv_ref;
		$ordencv->ocv_nroop1 = $ocv_nroop1;
		$ordencv->ocv_nroop2 = $ocv_nroop2;
		$ordencv->ocv_nroop3 = $ocv_nroop3;
		$ordencv->ocv_banco1 = $ocv_banco1;
		$ordencv->ocv_banco2 = $ocv_banco2;
		$ordencv->ocv_banco3 = $ocv_banco3;
		$ordencv->ocv_monto1 = $ocv_monto1;
		$ordencv->ocv_monto2 = $ocv_monto2;
		$ordencv->ocv_monto3 = $ocv_monto3;

		$file = $request->file('ocv_doc');
		if($file)
		{
			$ruta='\img';
			$nombre= $ocv_id.'.'.$file->guessExtension();
			$file->move(getcwd().$ruta,$nombre);
			$ordencv->ocv_doc=$nombre;
		}

		$ordencv->save();

		return redirect('/validado/npedido')->with('actualizado','Comprobante actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		
		DetalleOrdenCV::where('ocv_id',$ocv_id)->delete();
		OrdenCV::find($ocv_id)->delete();

		return redirect('/validado/npedido')->with('eliminado','Nota de Pedido eliminado');
	}

	public function getArchivo(Request $request)
	{
		$this->validate($request,['ocv_doc'=>'required']);
		$ocv_doc=$request->get('ocv_doc');
		$ordencv = OrdenCV::find($comp_id);
		$entidades = Entidad::where('tent_id','2')->get();

		return view('npedido.editar',['ordencv'=>$ordencv,'tipocomprobantes'=> $tipocomprobantes,'entidades'=>$entidades]);

	}

	public function getAsignar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');

		$ordencv=OrdenCV::find($ocv_id);
		$tipocomprobantes = TipoComprobante::all();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();

		return view('npedido.asignar',['ordencv'=> $ordencv,'entidades'=> $entidades,'tipocomprobantes'=> $tipocomprobantes,'vendedores'=>$vendedores]);
	}

	public function postAsignar(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');

		$ordencv=OrdenCV::find($ocv_id);

		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->get(); // tipo cliente
		$ordencvs = OrdenCV::where('ocv_tipo','NPEDIDO')->get();

		$detalleordencvs=DetalleOrdenCV::where('ocv_id',$ocv_id)->get();

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
				
				'comp_fpago' => strtoupper($request->get('comp_fpago')),
				'comp_banco' => strtoupper($request->get('comp_banco')),
				'comp_nope' => strtoupper($request->get('comp_nope')),
				'comp_np' => strtoupper($request->get('comp_np')),
				'comp_obs' => strtoupper($request->get('comp_obs')),
				'vend_id' => strtoupper($request->get('vend_id')),
				'tcompinc_id' => '12'

			]
		)->comp_id;

		$comprobante=Comprobante::find($comp_id);
		if($request->get('comp_cond')=="AL CREDITO")
		{
			$comprobante->comp_fven=$request->get('comp_fven');
			$comprobante->save();
		}

		Operacion::create
		(
			[
				'tope_id' => 2, ///// tipo operacion venta 
				'comp_id' => $comp_id,
				'ie_id' => 1 ///// para ie RESGUARDO
			]
		);

		//////////////////////////////DETALLE DE COMPROBANTE

		foreach ($detalleordencvs as $detalleordencv) {

			$dcomp_id=DetalleComprobante::create
			(
				[
					'dcomp_cant'=> $detalleordencv->docv_cant,
					'dcomp_prec'=> $detalleordencv->docv_prec,
					'comp_id'=> $comp_id,
					'up_id'=> $detalleordencv->up_id
				]
			)->dcomp_id;

			$detallecomprobante = DetalleComprobante::find($dcomp_id);
			$detalles = DetalleComprobante::where('comp_id',$comp_id)->get();
			
			///////////////////////// EDITANDO INVENTARIO ///////////////////////////////////////////////////

			$inventario=Inventario::where('prod_id',$detallecomprobante->unidadproducto->prod_id)->get();

			$inv_id=$inventario[0]->inv_id;
			$inventario=Inventario::find($inv_id);

			$um_producto=Producto::find($detallecomprobante->unidadproducto->prod_id)->um_id;
			$um_detalle=$detallecomprobante->unidadproducto->um_id;
			$cantidad=$detallecomprobante->dcomp_cant;
			$cantidad_ant=$inventario->inv_cant;


			if ($um_producto != $um_detalle) {
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
			
			///////////////////////// EDITANDO Comprobante ////////////////////////////////////////////////////////////////
			

			$totalcigv=0;
			$totalsigv=0;

			foreach ($detalles as $detalle) {
				$producto=Producto::find($detalle->unidadproducto->prod_id);
				if($producto->prod_exo=='NO')
				{
					$totalcigv=$totalcigv + ($detalle->dcomp_cant * $detalle->dcomp_prec);
				}
				else
				{
					$totalsigv=$totalsigv + ($detalle->dcomp_cant * $detalle->dcomp_prec);

				}
			}

			$preciotot=$totalcigv+$totalsigv;
			$subtigv=($totalcigv/1.18);

			$comprobante=Comprobante::find($comp_id);			
			$comprobante->comp_subt=$totalsigv+$subtigv;
			$comprobante->comp_igv=$totalcigv-$subtigv;
			$comprobante->comp_tot=$preciotot;
			if($comprobante->comp_cond=="AL CREDITO")
				$comprobante->comp_saldo=$preciotot;
			$comprobante->save();
		}

		$ordencv->ocv_est="ASIGNADO";
		$ordencv->save();
			
		return redirect("/validado/npedido")->with('creado','Comprobante creado correctamente');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
