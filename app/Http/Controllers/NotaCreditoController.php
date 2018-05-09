<?php namespace SICPA\Http\Controllers;

use SICPA\NotaCredito;
use SICPA\CompraNCredito;
use SICPA\Comprobante;
use SICPA\DetalleComprobante;
use SICPA\Operacion;
use SICPA\TipoComprobante;
use SICPA\TipoComprobanteInc;
use SICPA\TipoOperacion;
use SICPA\Entidad;
use SICPA\Producto;
use SICPA\Inventario;
use SICPA\Conversion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotaCreditoController extends Controller {

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
		$notacreditos = NotaCredito::all();
		return view('notacredito.mostrar',['notacreditos'=> $notacreditos]);
	}

	public function getCrear(Request $request)
	{
		$comp_id=$request->get('comp_id');
		$comprobante = Comprobante::find($comp_id);
		return view('notacredito.crear',['comprobante'=>$comprobante]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		$ncred_num=$request->get('ncred_num');
		$ncred_obs=$request->get('ncred_obs');
		$comprobante = Comprobante::find($comp_id);
		
		NotaCredito::create
		(
			[
				'ncred_tot' => $comprobante->comp_tot,
				'ncred_saldo' => $comprobante->comp_tot,
				'comp_id' => $comp_id,
				'ncred_num' => $ncred_num,
				'ncred_obs' => $ncred_obs
			]
		);

		$comprobante->comp_est="ANULADO";
		$comprobante->save();
		
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


		return redirect('/validado/ingreso')->with('eliminado','Comprobante anulado');
	}

	public function getCrearncemitida(Request $request)
	{
		$comp_id=$request->get('comp_id');
		$comprobante = Comprobante::find($comp_id);
		$tcomp_id = TipoComprobante::where('tcomp_desc',"Nota de Crédito")->get()[0]->tcomp_id;
		$tipocomprobanteincs = TipoComprobanteInc::where('tcomp_id',$tcomp_id)->get();
		return view('notacredito.crearncemitida',['comprobante'=>$comprobante,'tipocomprobanteincs'=>$tipocomprobanteincs]);
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$notacredito = NotaCredito::find($ent_id);

		return view('notacredito.editar',['notacredito'=>$notacredito]);

	}

	public function postEditar(Request $request)
	{
		$ent_id=$request->get('ent_id');
		$ent_ruc=($request->get('ent_ruc'));
		$ent_rz=($request->get('ent_rz'));
		$ent_dir=($request->get('ent_dir'));
		$ent_ciu=($request->get('ent_ciu'));
		$tent_id=($request->get('tent_id'));
		$notacredito = NotaCredito::find($ent_id);

		$notacredito->ent_ruc=$ent_ruc;
		$notacredito->ent_rz=$ent_rz;
		$notacredito->ent_dir=$ent_dir;
		$notacredito->ent_ciu=$ent_ciu;
		$notacredito->tent_id=$tent_id;
		$notacredito->save();

		return redirect('/validado/notacredito')->with('actualizado','Notacredito actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['ent_id'=>'required']);
		$ent_id=$request->get('ent_id');
		$notacredito = NotaCredito::find($ent_id);
		$notacredito->delete();

		return redirect('/validado/notacredito')->with('eliminado','Notacredito eliminada');
	}

	public function getIngreso()
	{
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$tipocomprobantes = TipoComprobante::all();
		return view('ingreso.crear',['tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades]);
	}

	public function postIngreso(CrearComprobanteRequest $request)
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
				'ent_id' => strtoupper($request->get('ent_id'))
			]
		)->comp_id;

		$comprobante=Comprobante::find($comp_id);

		$file = $request->file('comp_doc');
		if($file)
		{
			$ruta='\img';
			$nombre= $comp_id.'.'.$file->guessExtension();
			$file->move(getcwd().$ruta,$nombre);
			$comprobante->comp_doc=$nombre;
			$comprobante->save();
		}	
		
		Operacion::create
		(
			[
				'tope_id' => 1, ///// tipo operacion compra 
				'comp_id' => $comp_id,
				'ie_id' => 1 ///// para ie RESGUARDO
			]
		);

		
		
		//return view('ingreso.crear',['comp_id'=> $comp_id,'creado' 'Comprobante creado']);

		/*$detallecomprobantes = DetalleComprobante::where('comp_id',$comp_id)->get();
		$comprobante = Comprobante::find($comp_id);
		return view('detalleingreso.mostrar',['detallecomprobantes'=> $detallecomprobantes,'comprobante'=>$comprobante]);*/
		return redirect("/validado/detalleingreso?comp_id={$comp_id}")->with('creado','Comprobante creado');
	}

	public function getSeleccionar(Request $request)
	{
		$this->validate($request,['comp_id'=>'required']);
		$comp_id=$request->get('comp_id');
		return view('notacredito.seleccionar',['comp_id'=> $comp_id]);
	}

	public function postSeleccionar(Request $request)
	{
		$this->validate($request,['comp_id'=>'required','ncred_num'=>'required','monto'=>'required']);
		$ncred_num=$request->get('ncred_num');
		$comp_id=$request->get('comp_id');
		$monto=$request->get('monto');
		$comprobante = Comprobante::find($comp_id);
		$notacredito = NotaCredito::where('ncred_num',$ncred_num)->get();
		$notacredito = $notacredito[0];

		if(NotaCredito::where('ncred_num',$ncred_num)->count()==0)
		{
			return redirect("/validado/notacredito/seleccionar?comp_id={$comp_id}")->with('creado','No existe Nota de Credito');
		}
		if($notacredito->ncred_saldo >= $monto)
		{
			CompraNCredito::create
			(
				[
					'compranc_monto' => $monto,
					'comp_id' => $comprobante->comp_id,
					'ncred_id' => $notacredito->ncred_id
				]
			);

			$notacredito->ncred_saldo=$notacredito->ncred_saldo-$monto;
			$notacredito->save();

			return redirect("/validado/ingreso")->with('creado','Se asigno la nota de crédito correctamente');
		}
		else 
		{
			return redirect("/validado/ingreso")->with('creado','El monto excede a la nota de credito');
		}

		
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
