<?php namespace SICPA\Http\Controllers;

use SICPA\Comprobante;
use SICPA\DetalleComprobante;
use SICPA\IEExterno;
use SICPA\DetalleIE;
use Illuminate\Http\Request;

class CajaController extends Controller {

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
		$tot_compras_dolar = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','dolar')->sum('t_comprobante.comp_tot');

		$tot_compras_soles = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','soles')->sum('t_comprobante.comp_tot');

		$compras_dolar = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','dolar')->get();


		$tot_compras_dolar_sol=0;
		foreach ($compras_dolar as $compra) 
		{
			$tot_compras_dolar_sol=$tot_compras_dolar_sol+($compra->comp_tot*$compra->comp_tipcambio);
		}

		$tot_compras=$tot_compras_dolar_sol+$tot_compras_soles;


		$tot_ventas_dolar = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','dolar')->sum('t_comprobante.comp_tot');

		$tot_ventas_soles = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','soles')->sum('t_comprobante.comp_tot');

		$ventas_dolar = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('comp_est','=','ACTIVO')->where('comp_moneda','=','dolar')->get();


		$tot_ventas_dolar_sol=0;
		foreach ($ventas_dolar as $venta) 
		{
			$tot_ventas_dolar_sol=$tot_ventas_dolar_sol+($venta->comp_tot*$venta->comp_tipcambio);
		}

		$tot_ventas=$tot_ventas_dolar_sol+$tot_ventas_soles;


		//------------


		$tot_ingresos_dolar = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->where('t_operacion.tope_id','=','3')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','dolar')->sum('t_ieexterno.ie_tot');

		$tot_ingresos_soles = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->where('t_operacion.tope_id','=','3')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','soles')->sum('t_ieexterno.ie_tot');

		$ingresos_dolar = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->select('t_ieexterno.*')->where('t_operacion.tope_id','=','3')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','dolar')->get();


		$tot_ingresos_dolar_sol=0;
		foreach ($ingresos_dolar as $ingreso) 
		{
			$tot_ingresos_dolar_sol=$tot_ingresos_dolar_sol+($ingreso->ie_tot*$ingreso->ie_tipcambio);
		}

		$tot_ingresos=$tot_ingresos_dolar_sol+$tot_ingresos_soles;

		//------------

		$tot_egresos_dolar = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->where('t_operacion.tope_id','=','4')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','dolar')->sum('t_ieexterno.ie_tot');

		$tot_egresos_soles = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->where('t_operacion.tope_id','=','4')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','soles')->sum('t_ieexterno.ie_tot');

		$egresos_dolar = IEExterno::join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->select('t_ieexterno.*')->where('t_operacion.tope_id','=','4')->where('t_ieexterno.ie_id','<>','1')->where('ie_moneda','=','dolar')->get();


		$tot_egresos_dolar_sol=0;
		foreach ($egresos_dolar as $egreso) 
		{
			$tot_egresos_dolar_sol=$tot_egresos_dolar_sol+($egreso->ie_tot*$egreso->ie_tipcambio);
		}

		$tot_egresos=$tot_egresos_dolar_sol+$tot_egresos_soles;

		//------------

		$total=$tot_ventas+$tot_ingresos-$tot_compras-$tot_egresos;

		return view('caja.mostrar',['tot_compras_dolar'=> $tot_compras_dolar,'tot_compras_soles'=> $tot_compras_soles,'tot_compras'=> $tot_compras,'tot_ventas_dolar'=> $tot_ventas_dolar,'tot_ventas_soles'=> $tot_ventas_soles,'tot_ventas'=> $tot_ventas,'tot_ingresos_dolar'=> $tot_ingresos_dolar,'tot_ingresos_soles'=> $tot_ingresos_soles,'tot_ingresos'=> $tot_ingresos,'tot_egresos_dolar'=> $tot_egresos_dolar,'tot_egresos_soles'=> $tot_egresos_soles,'tot_egresos'=> $tot_egresos,'total'=> $total]);
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
