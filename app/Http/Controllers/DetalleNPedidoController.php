<?php namespace SICPA\Http\Controllers;

use SICPA\DetalleOrdenCV;
use SICPA\OrdenCV;
use SICPA\Producto;
use SICPA\UnidadMedida;
use SICPA\UnidadProducto;
use SICPA\Inventario;
use SICPA\Conversion;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearDetalleOrdenCVRequest;
use SICPA\Http\Requests\EditarDetalleOrdenCVRequest;
use Carbon\Carbon;

class DetalleNPedidoController extends Controller {

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
	public function getIndex(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		$detalleordencvs = DetalleOrdenCV::where('ocv_id',$ocv_id)->get();
		$ordencv = OrdenCV::find($ocv_id);

		if($ordencv->ocv_moneda=='SOLES')
			$moneda='S/. ';
		else
			$moneda='$. ';

		return view('detallenpedido.mostrar',['detalleordencvs'=> $detalleordencvs,'ordencv'=> $ordencv,'moneda'=> $moneda]);
	}

	public function getCrear(Request $request)
	{
		$this->validate($request,['ocv_id'=>'required']);
		$ocv_id=$request->get('ocv_id');
		$productos = Producto::orderBy('prod_desc','asc')->get();
		$unidadmedidas = UnidadMedida::orderBy('um_desc','asc')->get();
		return view('detallenpedido.crear',['productos'=> $productos,'unidadmedidas'=> $unidadmedidas,'ocv_id'=> $ocv_id]);
	}

	public function postCrear(CrearDetalleOrdenCVRequest $request)
	{
		$ocv_id=strtoupper($request->get('ocv_id'));
		$docv_cant= strtoupper($request->get('docv_cant'));
		$docv_prec= strtoupper($request->get('docv_prec'));
		$prod_id= strtoupper($request->get('prod_id'));
		$um_id= strtoupper($request->get('um_id'));

		$up_id=UnidadProducto::where('prod_id',$prod_id)->where('um_id',$um_id)->get();
		$up_id=$up_id[0]->up_id;

		if(DetalleOrdenCV::where('ocv_id',$ocv_id)->where('up_id',$up_id)->count()>0)
		{
			return redirect("/validado/detalleocompra?ocv_id={$ocv_id}")->with('error','ESTE PRODUCTO YA EXISTE');
		}
		
		$docv_id=DetalleOrdenCV::create
		(
			[
				'docv_cant'=> strtoupper($request->get('docv_cant')),
				'docv_prec'=> strtoupper($request->get('docv_prec')),
				'ocv_id'=> $request->get('ocv_id'),
				'up_id'=> $up_id
			]
		)->docv_id;

		$detalleordencv = DetalleOrdenCV::find($docv_id);
		$detalles = DetalleOrdenCV::where('ocv_id',$ocv_id)->get();
		
		///////////////////////// EDITANDO Comprobante ////////////////////////////////////////////////////////////////
		

		$totalcigv=0;
		$totalsigv=0;

		foreach ($detalles as $detalle) {
			$producto=Producto::find($detalle->unidadproducto->prod_id);
			if($producto->prod_exo=='NO')
			{
				$totalcigv=$totalcigv + ($detalle->docv_cant * $detalle->docv_prec);
			}
			else
			{
				$totalsigv=$totalsigv + ($detalle->docv_cant * $detalle->docv_prec);

			}
		}

		$preciotot=$totalcigv+$totalsigv;
		$subtigv=($totalcigv/1.18);

		$ordencv=OrdenCV::find($ocv_id);
		$ordencv->ocv_subt=$totalsigv+$subtigv;
		$ordencv->ocv_igv=$totalcigv-$subtigv;
		$ordencv->ocv_tot=$preciotot;
		$ordencv->save();
		///////////////////////////////////////////////////////////////////////////////////////////////////////////

		return redirect("/validado/detallenpedido?ocv_id={$ocv_id}")->with('creado','Detalle Nota de Pedido creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['docv_id'=>'required']);
		$docv_id=$request->get('docv_id');
		$detalleordencv = DetalleOrdenCV::find($docv_id);
		$productos = Producto::orderBy('prod_desc','asc')->get();
		$unidadmedidas = UnidadMedida::orderBy('um_desc','asc')->get();

		return view('detallenpedido.editar',['detallecomprobante'=>$detallecomprobante,'productos'=>$productos,'unidadmedidas'=>$unidadmedidas]);

	}

	public function postEditar(EditarDetalleOrdenCVRequest $request)
	{
		$docv_id=strtoupper($request->get('docv_id'));
		$docv_cant = strtoupper($request->get('docv_cant'));
		$docv_prec = strtoupper($request->get('docv_prec'));
		$ocv_id = strtoupper($request->get('ocv_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$um_id= strtoupper($request->get('um_id'));

		$detalleordencv = DetalleOrdenCV::find($docv_id);

		$up_id=UnidadProducto::where('prod_id',$prod_id)->where('um_id',$um_id)->get();
		$up_id=$up_id[0]->up_id;

		$detalleordencv->docv_cant=$docv_cant;
		$detalleordencv->docv_prec=$docv_prec;
		$detalleordencv->up_id=$up_id;
		$detalleordencv->save();

		///////////////////////// EDITANDO Comprobante ///////////////////////////////////////////////////////////////

		$detalles = DetalleOrdenCV::where('ocv_id',$ocv_id)->get();

		$totalcigv=0;
		$totalsigv=0;

		foreach ($detalles as $detalle) {
			$producto=Producto::find($detalle->unidadproducto->prod_id);
			if($producto->prod_exo=='NO')
			{
				$totalcigv=$totalcigv + ($detalle->docv_cant * $detalle->docv_prec);
			}
			else
			{
				$totalsigv=$totalsigv + ($detalle->docv_cant * $detalle->docv_prec);

			}
		}

		$preciotot=$totalcigv+$totalsigv;
		$subtigv=($totalcigv/1.18);

		$ordencv=OrdenCV::find($ocv_id);
		$ordencv->ocv_subt=$totalsigv+$subtigv;
		$ordencv->ocv_igv=$totalcigv-$subtigv;
		$ordencv->ocv_tot=$preciotot;
		$ordencv->save();

		return redirect("/validado/detallenpedido?ocv_id={$ocv_id}")->with('actualizado','Detalle Orden Compra actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['docv_id'=>'required']);
		$docv_id=$request->get('docv_id');

		$detalleordencv = DetalleOrdenCV::find($docv_id);
		$ocv_id=$detalleordencv->ocv_id;

		DetalleOrdenCV::find($docv_id)->delete();

		///////////////////////// EDITANDO Comprobante ////////////////////////////////////////////////////////////////
		

		$detalles = DetalleOrdenCV::where('ocv_id',$ocv_id)->get();

		$totalcigv=0;
		$totalsigv=0;

		foreach ($detalles as $detalle) {
			$producto=Producto::find($detalle->unidadproducto->prod_id);
			if($producto->prod_exo=='NO')
			{
				$totalcigv=$totalcigv + ($detalle->docv_cant * $detalle->docv_prec);
			}
			else
			{
				$totalsigv=$totalsigv + ($detalle->docv_cant * $detalle->docv_prec);

			}
		}

		$preciotot=$totalcigv+$totalsigv;
		$subtigv=($totalcigv/1.18);

		$ordencv=OrdenCV::find($ocv_id);
		$ordencv->ocv_subt=$totalsigv+$subtigv;
		$ordencv->ocv_igv=$totalcigv-$subtigv;
		$ordencv->ocv_tot=$preciotot;
		$ordencv->save();

		return redirect('/validado/detallenpedido')->with('eliminado','Detalle Nota de Pedido eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
