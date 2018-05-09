<?php namespace SICPA\Http\Controllers;

use SICPA\Pago;
use SICPA\Comprobante;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearComprobanteRequest;
use SICPA\Http\Requests\EditarComprobanteRequest;
use Illuminate\Database;
use Carbon\Carbon;

class PagoController extends Controller {

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
		$comp_id=$request->get('comp_id');
		$pagos = Pago::where('comp_id',$comp_id)->get();
		$comprobante = Comprobante::find($comp_id);
		if($comprobante->comp_moneda=="DOLAR")
			$moneda="$. ";
		else
			$moneda="S/. ";
		return view('pago.mostrar',['pagos'=> $pagos,'comp_id'=> $comp_id,'comprobante'=> $comprobante,'moneda'=> $moneda]);
	}

	public function postIndex(Request $request)
	{
		$comp_id=$request->get('comp_id');
		$pagos = Pago::where('comp_id',$comp_id)->get();
		$comprobante = Comprobante::find($comp_id);
		if($comprobante->comp_moneda=="DOLAR")
			$moneda="$. ";
		else
			$moneda="S/. ";
		return view('pago.mostrar',['pagos'=> $pagos,'comp_id'=> $comp_id,'comprobante'=> $comprobante,'moneda'=> $moneda]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['comp_id'=>'required','pago_fecha'=>'required','pago_monto'=>'required','pago_tipcambio'=>'required']);
		$comp_id=$request->get('comp_id');
		$comprobante=Comprobante::find($comp_id);
		$pago_monto=$request->get('pago_monto');

		
		/*if($comprobante->comp_moneda!=$request->get('moneda'))
		{
			if($request->get('moneda')=="DOLAR")
				$pago_monto=$pago_monto*$request->get('pago_tipcambio');
			else
				$pago_monto=$pago_monto/$request->get('pago_tipcambio');
		}*/

		
		if($comprobante->comp_saldo<$pago_monto)
			return redirect("/validado/pago?comp_id={$comp_id}")->with('error','Ingrese un monto correcto');

		Pago::create
		(
			[
				'pago_fecha' => strtoupper($request->get('pago_fecha')),
				'pago_monto' => strtoupper($pago_monto),
				'pago_banco' => strtoupper($request->get('pago_banco')),
				'pago_nope' => strtoupper($request->get('pago_nope')),
				'pago_tipcambio' => strtoupper($request->get('pago_tipcambio')),
				'comp_id' => strtoupper($request->get('comp_id'))
			]
		);

		$tot_pago = Pago::where('comp_id',$comp_id)->sum('pago_monto');

		$comprobante->comp_saldo=$comprobante->comp_tot - $tot_pago;
		if($comprobante->comp_saldo==0)
			$comprobante->comp_cond="CANCELADO";
		$comprobante->save();
		
		return redirect("/validado/pago?comp_id={$comp_id}")->with('creado','Registro creado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['pago_id'=>'required']);
		
		$pago=Pago::find($request->get('pago_id'));

		$comp_id=$pago->comp_id;

		$pago->delete();

		$tot_pago = Pago::where('comp_id',$comp_id)->sum('pago_monto');
		$comprobante=Comprobante::find($comp_id);
		$comprobante->comp_saldo=$comprobante->comp_tot - $tot_pago;
		if($comprobante->comp_saldo>0)
			$comprobante->comp_cond="AL CREDITO";
		$comprobante->save();

		

		return redirect("/validado/pago?comp_id={$comp_id}")->with('eliminado','Registro eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
