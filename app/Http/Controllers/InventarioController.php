<?php namespace SICPA\Http\Controllers;

use SICPA\Inventario;
use SICPA\Producto;
use SICPA\DetalleComprobante;
use SICPA\Conversion;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearProductoRequest;
use SICPA\Http\Requests\EditarProductoRequest;
use Carbon\Carbon;


class InventarioController extends Controller {

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
		$inventarios = Inventario::join('t_producto','t_producto.prod_id','=','t_inventario.prod_id')->select('t_inventario.*')->orderBy('prod_desc','asc')->get();
		return view('inventario.mostrar',['inventarios'=> $inventarios]);
	}

	public function postIndex(Request $request)
	{
		$prod_desc = strtoupper($request->get('prod_desc'));
		$cant_min = strtoupper($request->get('cant_min'));
		$cant_max = strtoupper($request->get('cant_max'));	

		$inventarios = Inventario::join('t_producto','t_producto.prod_id','=','t_inventario.prod_id')->select('t_inventario.*')->where('t_producto.prod_desc','like','%'.$prod_desc.'%');

		if($cant_min != "")
		{
			$inventarios = $inventarios->where('inv_cant','>=',$cant_min);
		}
		if($cant_max != "")
		{
			$inventarios = $inventarios->where('inv_cant','<=',$cant_max);
		}

		$inventarios=$inventarios->orderBy('prod_desc','asc')->get();

		return view('inventario.mostrar',['inventarios'=> $inventarios]);
	}

	public function getCrear()
	{
		$productos =Producto::all();
		return view('inventario.crear',['productos'=>$productos]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['inv_id'=>'required']);

		Inventario::create
		(
			[
				'inv_cant'=> strtoupper($request->get('inv_cant')),
				'inv_fecha'=> Carbon::now(),
				'prod_id'=> strtoupper($request->get('prod_id')),
				'alm_id'=> '1'
			]
		);
		return redirect('/validado/inventario')->with('creado','Inventario creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['inv_id'=>'required']);
		$inv_id=$request->get('inv_id');
		$inventario = Inventario::find($inv_id);
		return view('inventario.editar',['inventario'=>$inventario]);
	}

	public function postEditar(Request $request)
	{
		$inv_id=strtoupper($request->get('inv_id'));
		$inv_cant=strtoupper($request->get('inv_cant'));
		$inv_fecha=Carbon::now();
		$prod_id=strtoupper($request->get('prod_id'));
		$alm_id='1';

		$inventario = Inventario::find($inv_id);

		$inventario->inv_cant=$inv_cant;
		$inventario->inv_fecha=$inv_fecha;
		$inventario->prod_id=$prod_id;
		$inventario->alm_id=$alm_id;
		$inventario->save();

		return redirect('/validado/inventario')->with('actualizado','Inventario Actualizado');
	}

	public function getActualizar()
	{
		$inventarios=Inventario::all();

		foreach ($inventarios as $inventario) {
			
			$prod_id=$inventario->prod_id;
			$detalles = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('prod_id','=',$prod_id)->get();



			$total_compra=0;

			foreach ($detalles as $detalle) {

				$um_producto=Producto::find($prod_id)->um_id;
				$um_detalle=$detalle->unidadproducto->um_id;
				$cantidad=$detalle->dcomp_cant;


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

				$total_compra=$total_compra + $cantidad;
			}

			//---------------

			$detalles = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('prod_id','=',$prod_id)->get();
			

			$total_venta=0;

			foreach ($detalles as $detalle) {

				$um_producto=Producto::find($prod_id)->um_id;
				$um_detalle=$detalle->unidadproducto->um_id;
				$cantidad=$detalle->dcomp_cant;


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

				$total_venta=$total_venta + $cantidad;
			}


			$inv = Inventario::find($inventario->inv_id);
			$inv->inv_cant=$total_compra - $total_venta;
			$inv->inv_fecha=Carbon::now();
			$inv->save();

		}

		return redirect('/validado/inventario')->with('actualizado','Inventario Actualizado');
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
