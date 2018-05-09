<?php namespace SICPA\Http\Controllers;

use Illuminate\Http\Request;
use SICPA\Http\Requests;
use SICPA\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use SICPA\Comprobante;
use SICPA\DetalleComprobante;
use SICPA\Operacion;
use SICPA\TipoComprobante;
use SICPA\TipoOperacion;
use SICPA\Entidad;
use SICPA\Producto;
use SICPA\TipoCC;
use SICPA\TipoGasto;
use SICPA\IEExterno;
use SICPA\DetalleIE;
use SICPA\Inventario;
use SICPA\Conversion;
use SICPA\NotaCredito;
use SICPA\Vendedor;

class ReporteController extends Controller {

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
		$entidades = Entidad::where('tent_id','2')->orderBy('ent_rz','asc')->get(); // tipo proveedor
		$clientes = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		$tipocomprobantes = TipoComprobante::all();
		$productos = Producto::orderBy('prod_desc','asc')->get();
		$tipoccs = TipoCC::orderBy('tcc_desc','asc')->get();
		$tipogastos = TipoGasto::orderBy('tgasto_desc','asc')->get();

		return view('reporte.mostrar',['tipocomprobantes'=> $tipocomprobantes,'vendedores'=> $vendedores,'entidades'=> $entidades,'clientes'=> $clientes,'productos'=> $productos,'tipoccs'=> $tipoccs,'tipogastos'=> $tipogastos]);
	}

    public function getDvencidas() 
    {
        /*$data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  view('pdf.dvencidas',['data'=> $data,'date'=> $date,'invoice'=> $invoice]);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');*/
        $date = date('Y-m-d');

        $dvencidas = Comprobante::join('t_entidad','t_entidad.ent_id','=','t_comprobante.ent_id')->select('*')->where('t_comprobante.comp_fven','<',$date)->where('t_comprobante.comp_saldo','>','0')->get();

        return view('reporte.dvencidasexcel',['dvencidas'=> $dvencidas,'date'=> $date]);
    }

    public function getDporvencer()
	{
		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->get();
		$entidades = Entidad::where('tent_id','1')->where('ent_id','<>','1')->get(); // tipo cliente
		$tipocomprobantes = TipoComprobante::all();
		return view('reporte.dporvencerexcel',['comprobantes'=> $comprobantes,'tipocomprobantes'=> $tipocomprobantes,'entidades'=> $entidades]);
	}

    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }

    public function postIngreso(Request $request)
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

		$comprobantes = Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_comprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('comp_nro','like','%'.$comp_nro.'%')->where('comp_guia','like','%'.$comp_guia.'%');

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


		$comprobantes=$comprobantes->orderBy('comp_fecha')->get();
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$clientes = Entidad::where('tent_id','1')->where('ent_id','<>','1')->orderBy('ent_rz','asc')->get();
		$tipocomprobantes = TipoComprobante::all();

		return view('reporte.ingresoexcel',['comprobantes'=> $comprobantes,'tipocomprobantes'=> $tipocomprobantes,'clientes'=> $clientes,'entidades'=> $entidades]);
		
	}

	public function postDetalleingreso(Request $request)
	{
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));

		$detallecomprobantes = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');

		if($comp_cond != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_cond','=',$comp_cond);
		}
		if($comp_moneda != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_moneda','=',$comp_moneda);
		}
		if($comp_fecha_ini != "")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_fecha','>=',$comp_fecha_ini);
		}
		if($comp_fecha_fin != "")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_fecha','<=',$comp_fecha_fin);
		}
		if($tcomp_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('tcomp_id','=',$tcomp_id);
		}
		if($ent_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('ent_id','=',$ent_id);
		}
		if($vend_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('vend_id','=',$vend_id);
		}
		if($igv=="C")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_igv','>','0');
		}
		if($igv=="S")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_igv','=','0');
		}
		if($prod_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('prod_id','=',$prod_id);
		}




		$detallecomprobantes=$detallecomprobantes->orderBy('comp_fecha')->orderBy('comp_nro')->get();
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$tipocomprobantes = TipoComprobante::all();

		return view('reporte.detalleingresoexcel',['detallecomprobantes'=> $detallecomprobantes]);
		
	}


    public function postSalida(Request $request)
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


		$comprobantes=$comprobantes->orderBy('comp_fecha')->get();
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$tipocomprobantes = TipoComprobante::all();

		return view('reporte.ingresoexcel',['comprobantes'=> $comprobantes]);
		
	}

	public function postDetallesalida(Request $request)
	{
		$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));



		$detallecomprobantes = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');



		if($comp_cond != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_cond','=',$comp_cond);
		}
		if($comp_moneda != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_moneda','=',$comp_moneda);
		}
		if($comp_fecha_ini != "")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_fecha','>=',$comp_fecha_ini);
		}
		if($comp_fecha_fin != "")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_fecha','<=',$comp_fecha_fin);
		}
		if($tcomp_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('tcomp_id','=',$tcomp_id);
		}
		if($ent_id != "TODOS")
		{
			$detallecomprobantes = $detallecomprobantes->where('ent_id','=',$ent_id);
		}
		if($vend_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('vend_id','=',$vend_id);
		}
		if($igv=="C")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_igv','>','0');
		}
		if($igv=="S")
		{
			$detallecomprobantes = $detallecomprobantes->where('comp_igv','=','0');
		}
		if($prod_id != "0")
		{
			$detallecomprobantes = $detallecomprobantes->where('prod_id','=',$prod_id);
		}


		$detallecomprobantes=$detallecomprobantes->orderBy('comp_fecha')->orderBy('comp_nro')->get();
		$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		$tipocomprobantes = TipoComprobante::all();

		return view('reporte.detallesalidaexcel',['detallecomprobantes'=> $detallecomprobantes]);
		
	}

	public function postDetallegastos(Request $request)
	{
		$ie_fecha_ini = strtoupper($request->get('ie_fecha_ini'));
		$ie_fecha_fin = strtoupper($request->get('ie_fecha_fin'));
		$ie_moneda = strtoupper($request->get('ie_moneda'));
		$vend_id = strtoupper($request->get('vend_id'));
		$ie_tipgasto = strtoupper($request->get('ie_tipgasto'));
		$ie_tipocc = strtoupper($request->get('ie_tipocc'));

		$detalleieexternos = DetalleIE::join('t_ieexterno','t_ieexterno.ie_id','=','t_detalleie.ie_id')->join('t_operacion','t_operacion.ie_id','=','t_ieexterno.ie_id')->select('t_detalleie.*')->where('t_operacion.tope_id','=','4')->where('t_ieexterno.ie_id','<>','1');

		if($vend_id != "0")
		{
			$detalleieexternos = $detalleieexternos->where('vend_id','=',$vend_id);
		}
		if($ie_moneda != "0")
		{
			$detalleieexternos = $detalleieexternos->where('ie_moneda','=',$ie_moneda);
		}
		if($ie_tipgasto != "0")
		{
			$detalleieexternos = $detalleieexternos->where('ie_tipgasto','=',$ie_tipgasto);
		}
		if($ie_tipocc != "0")
		{
			$detalleieexternos = $detalleieexternos->where('ie_tipocc','=',$ie_tipocc);
		}
		if($ie_fecha_ini != "")
		{
			$detalleieexternos = $detalleieexternos->where('ie_fecha','>=',$ie_fecha_ini);
		}
		if($ie_fecha_fin != "")
		{
			$detalleieexternos = $detalleieexternos->where('ie_fecha','<=',$ie_fecha_fin);
		}

		$detalleieexternos=$detalleieexternos->orderBy('ie_fecha','asc')->orderBy('ie_comp','asc')->limit(25)->get();
		$vendedores = Vendedor::orderBy('vend_nom','asc')->get();
		$tipoccs = TipoCC::orderBy('tcc_desc','asc')->get();
		$tipogastos = TipoGasto::orderBy('tgasto_desc','asc')->get();

		return view('reporte.detallegastosexcel',['detalleieexternos'=> $detalleieexternos,'vendedores'=>$vendedores,'tipoccs'=>$tipoccs,'tipogastos'=>$tipogastos]);
		
	}

	public function postResumen4(Request $request)
	{ 
		//$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		//$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$comp_moneda = strtoupper($request->get('comp_moneda'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));

		$registros = array(array("PRODUCTO","COMPRAS","VENTAS","TOTAL"));

		$detallecomprobantescompras = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');

		$detallecomprobantesventas = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');

		$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


		if($comp_cond != "0")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('comp_cond','=',$comp_cond);
			$detallecomprobantesventas = $detallecomprobantesventas->where('comp_cond','=',$comp_cond);
			$filtro[0]=$comp_cond;
		}
		if($comp_moneda != "0")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('comp_moneda','=',$comp_moneda);
			$detallecomprobantesventas = $detallecomprobantesventas->where('comp_moneda','=',$comp_moneda);
			$filtro[1]=$comp_moneda;
		}
		if($comp_fecha_ini != "")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantesventas = $detallecomprobantesventas->where('comp_fecha','>=',$comp_fecha_ini);
			$filtro[2]=$comp_fecha_ini;
		}
		if($comp_fecha_fin != "")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantesventas = $detallecomprobantesventas->where('comp_fecha','<=',$comp_fecha_fin);
			$filtro[3]=$comp_fecha_fin;
		}
		if($tcomp_id != "0")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantesventas = $detallecomprobantesventas->where('tcomp_id','=',$tcomp_id);
			$filtro[4]=TipoComprobante::find($tcomp_id)->tcomp_desc;
		}
		if($ent_id != "TODOS")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('ent_id','=',$ent_id);
			$detallecomprobantesventas = $detallecomprobantesventas->where('ent_id','=',$ent_id);
			$filtro[5]=Entidad::find($ent_id)->ent_rz;
		}
		if($vend_id != "0")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('vend_id','=',$vend_id);
			$detallecomprobantesventas = $detallecomprobantesventas->where('vend_id','=',$vend_id);
			$filtro[6]=Vendedor::find($vend_id)->vend_nom;
		}
		if($prod_id != "0")
		{
			$detallecomprobantescompras = $detallecomprobantescompras->where('prod_id','=',$prod_id);
			$detallecomprobantesventas = $detallecomprobantesventas->where('prod_id','=',$prod_id);

			$detallecomprobantescompras=$detallecomprobantescompras->orderBy('comp_fecha')->orderBy('comp_nro')->get();
			$detallecomprobantesventas=$detallecomprobantesventas->orderBy('comp_fecha')->orderBy('comp_nro')->get();

			$tot_compras=0;
			$tot_ventas=0;
			foreach ($detallecomprobantescompras as $compra) {
				$tot_compras=$tot_compras+($compra->dcomp_cant*$compra->dcomp_prec);
			}

			foreach ($detallecomprobantesventas as $venta) {
				$tot_ventas=$tot_ventas+($venta->dcomp_cant*$venta->dcomp_prec);
			}

			$resta=$tot_compras-$tot_ventas;

			$producto=Producto::find($prod_id);
			array_push($registros,array($producto->prod_desc,$tot_compras,$tot_ventas,$resta));
			$filtro[7]=Producto::find($prod_id)->prod_desc;
		}

		else
		{
			$productos=Producto::all();


			foreach ($productos as $producto) {

				$detallecom = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');

				$detalleven = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO');

				$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


				if($comp_cond != "0")
				{
					$detallecom = $detallecom->where('comp_cond','=',$comp_cond);
					$detalleven = $detalleven->where('comp_cond','=',$comp_cond);
					$filtro[0]=$comp_cond;
				}
				if($comp_moneda != "0")
				{
					$detallecom = $detallecom->where('comp_moneda','=',$comp_moneda);
					$detalleven = $detalleven->where('comp_moneda','=',$comp_moneda);
					$filtro[1]=$comp_moneda;
				}
				if($comp_fecha_ini != "")
				{
					$detallecom = $detallecom->where('comp_fecha','>=',$comp_fecha_ini);
					$detalleven = $detalleven->where('comp_fecha','>=',$comp_fecha_ini);
					$filtro[2]=$comp_fecha_ini;
				}
				if($comp_fecha_fin != "")
				{
					$detallecom = $detallecom->where('comp_fecha','<=',$comp_fecha_fin);
					$detalleven = $detalleven->where('comp_fecha','<=',$comp_fecha_fin);
					$filtro[3]=$comp_fecha_fin;
				}
				if($tcomp_id != "0")
				{
					$detallecom = $detallecom->where('tcomp_id','=',$tcomp_id);
					$detalleven = $detalleven->where('tcomp_id','=',$tcomp_id);
					$filtro[4]=TipoComprobante::find($tcomp_id)->tcomp_desc;
				}
				if($ent_id != "TODOS")
				{
					$detallecom = $detallecom->where('ent_id','=',$ent_id);
					$detalleven = $detalleven->where('ent_id','=',$ent_id);
					$filtro[5]=Entidad::find($ent_id)->ent_rz;
				}
				if($vend_id != "0")
				{
					$detallecom = $detallecom->where('vend_id','=',$vend_id);
					$detalleven = $detalleven->where('vend_id','=',$vend_id);
					$filtro[6]=Vendedor::find($vend_id)->vend_nom;
				}

				$detallecom = $detallecom->where('prod_id','=',$producto->prod_id)->get();
				$detalleven = $detalleven->where('prod_id','=',$producto->prod_id)->get();

				$tot_compras=0;
				$tot_ventas=0;
				foreach ($detallecom as $compra) {
					$tot_compras=$tot_compras+($compra->dcomp_cant*$compra->dcomp_prec);
				}

				foreach ($detalleven as $venta) {
					$tot_ventas=$tot_ventas+($venta->dcomp_cant*$venta->dcomp_prec);
				}

				$resta=$tot_compras-$tot_ventas;

				$product=Producto::find($prod_id);
				array_push($registros,array($producto->prod_desc,$tot_compras,$tot_ventas,$resta));

			}

		}
		//$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		//$tipocomprobantes = TipoComprobante::all();
		unset($registros[0]);
		return view('reporte.resumenexcel',['registros'=> $registros,'filtro'=> $filtro]);
		
	}

public function postResumen(Request $request)
	{ 
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		$vend_id = strtoupper($request->get('vend_id'));

		$productos=Producto::all();

		$registros = array(array("FAMILIA","PRODUCTO","CANTIDAD","UNIDAD MEDIDA","PROMEDIO COMPRA","PROMEDIO VENTA"));

		foreach ($productos as $producto) {

			$detallecomsol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

			$detallevensol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

			$detallecomdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

			$detallevendol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');



				$filtro= array("TODOS","TODOS","TODOS");

				if($comp_fecha_ini != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevensol = $detallevensol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallecomdol = $detallecomdol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevendol = $detallevendol->where('comp_fecha','>=',$comp_fecha_ini);
					$filtro[0]=$comp_fecha_ini;
				}
				if($comp_fecha_fin != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevensol = $detallevensol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallecomdol = $detallecomdol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevendol = $detallevendol->where('comp_fecha','<=',$comp_fecha_fin);
					$filtro[1]=$comp_fecha_fin;
				}
				if($vend_id != "0")
				{
					$detallecomsol = $detallecomsol->where('vend_id','=',$vend_id);
					$detallevensol = $detallevensol->where('vend_id','=',$vend_id);
					$detallecomdol = $detallecomdol->where('vend_id','=',$vend_id);
					$detallevendol = $detallevendol->where('vend_id','=',$vend_id);
					$filtro[2]=Vendedor::find($vend_id)->vend_nom;
				}

				$detventdol=$detallevendol;

				$detallecomsol = $detallecomsol->where('prod_id','=',$producto->prod_id)->avg('t_detallecomprobante.dcomp_prec');
				$detallevensol = $detallevensol->where('prod_id','=',$producto->prod_id)->avg('t_detallecomprobante.dcomp_prec');
				
				$promediocompradol = $detallecomdol->where('prod_id','=',$producto->prod_id)->avg('t_detallecomprobante.dcomp_prec');

				$promedioventadol = $detallevendol->where('prod_id','=',$producto->prod_id)->avg('t_detallecomprobante.dcomp_prec');
				//return 'hola' + $promedioventadol;

				$totventa=$detventdol->where('prod_id','=',$producto->prod_id)->sum('t_detallecomprobante.dcomp_cant');
				$totcompradol=$promediocompradol*$totventa;
				$totventadol=$promedioventadol*$totventa;
				$resta=$totventadol-$totcompradol;
				
				if($totventa==0)
					array_push($registros,array($producto->categoria->familia->fam_desc, $producto->prod_desc,0,$producto->unidadmedida->um_abrev,0,0,0,0,0));
				else			
					array_push($registros,array($producto->categoria->familia->fam_desc, $producto->prod_desc,$totventa,$producto->unidadmedida->um_abrev,$promediocompradol,$promedioventadol,$resta,$totcompradol,$totventadol));

		}
		//$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		//$tipocomprobantes = TipoComprobante::all();
		unset($registros[0]);
		
		return view('reporte.resumenexcel',['registros'=> $registros,'filtro'=> $filtro]);
		
	}

	public function postResumenAnterior(Request $request)
	{ 
		//$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		//$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));

		

		$registros = array(array("PRODUCTO","COMPRAS","VENTAS","TOTAL","COMPRAS","VENTAS","TOTAL"));

		$detallecomprobantescomprassol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

		$detallecomprobantesventassol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

		$detallecomprobantescomprasdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

		$detallecomprobantesventasdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

		$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


		if($comp_cond != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_cond','=',$comp_cond);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_cond','=',$comp_cond);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_cond','=',$comp_cond);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_cond','=',$comp_cond);
			$filtro[0]=$comp_cond;
		}
		if($comp_fecha_ini != "")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_fecha','>=',$comp_fecha_ini);
			$filtro[1]=$comp_fecha_ini;
		}
		if($comp_fecha_fin != "")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_fecha','<=',$comp_fecha_fin);
			$filtro[2]=$comp_fecha_fin;
		}
		if($tcomp_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('tcomp_id','=',$tcomp_id);
			$filtro[3]=TipoComprobante::find($tcomp_id)->tcomp_desc;
		}
		if($vend_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('vend_id','=',$vend_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('vend_id','=',$vend_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('vend_id','=',$vend_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('vend_id','=',$vend_id);
			$filtro[4]=Vendedor::find($vend_id)->vend_nom;
		}
		if($prod_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('prod_id','=',$prod_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('prod_id','=',$prod_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('prod_id','=',$prod_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('prod_id','=',$prod_id);

			$detallecomprobantescomprassol=$detallecomprobantescomprassol->orderBy('comp_fecha')->orderBy('comp_nro')->get();
			$detallecomprobantesventassol=$detallecomprobantesventassol->orderBy('comp_fecha')->orderBy('comp_nro')->get();
			$detallecomprobantescomprasdol=$detallecomprobantescomprasdol->orderBy('comp_fecha')->orderBy('comp_nro')->get();
			$detallecomprobantesventasdol=$detallecomprobantesventasdol->orderBy('comp_fecha')->orderBy('comp_nro')->get();

			$tot_compras_sol=0;
			$tot_ventas_sol=0;
			foreach ($detallecomprobantescomprassol as $compra_sol) {
				$tot_compras_sol=$tot_compras_sol+($compra_sol->dcomp_cant*$compra_sol->dcomp_prec);
			}

			foreach ($detallecomprobantesventassol as $venta_sol) {
				$tot_ventas_sol=$tot_ventas_sol+($venta_sol->dcomp_cant*$venta_sol->dcomp_prec);
			}

			$resta_sol=$tot_compras_sol-$tot_ventas_sol;

			$tot_compras_dol=0;
			$tot_ventas_dol=0;
			foreach ($detallecomprobantescomprasdol as $compra_dol) {
				$tot_compras_dol=$tot_compras_dol+($compra_dol->dcomp_cant*$compra_dol->dcomp_prec);
			}

			foreach ($detallecomprobantesventasdol as $venta_dol) {
				$tot_ventas_dol=$tot_ventas_dol+($venta_dol->dcomp_cant*$venta_dol->dcomp_prec);
			}

			$resta_dol=$tot_compras_dol-$tot_ventas_dol;

			$product=Producto::find($prod_id);
			array_push($registros,array($product->prod_desc,$tot_compras_sol,$tot_ventas_sol,$resta_sol,$tot_compras_dol,$tot_ventas_dol,$resta_dol));

			$filtro[5]=$product->prod_desc;
		}

		else
		{
			$productos=Producto::all();


			foreach ($productos as $producto) {

				$detallecomsol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

				$detallevensol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

				$detallecomdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

				$detallevendol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

				$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


				if($comp_cond != "0")
				{
					$detallecomsol = $detallecomsol->where('comp_cond','=',$comp_cond);
					$detallevensol = $detallevensol->where('comp_cond','=',$comp_cond);
					$detallecomdol = $detallecomdol->where('comp_cond','=',$comp_cond);
					$detallevendol = $detallevendol->where('comp_cond','=',$comp_cond);
					$filtro[0]=$comp_cond;
				}
				if($comp_fecha_ini != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevensol = $detallevensol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallecomdol = $detallecomdol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevendol = $detallevendol->where('comp_fecha','>=',$comp_fecha_ini);
					$filtro[1]=$comp_fecha_ini;
				}
				if($comp_fecha_fin != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevensol = $detallevensol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallecomdol = $detallecomdol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevendol = $detallevendol->where('comp_fecha','<=',$comp_fecha_fin);
					$filtro[2]=$comp_fecha_fin;
				}
				if($tcomp_id != "0")
				{
					$detallecomsol = $detallecomsol->where('tcomp_id','=',$tcomp_id);
					$detallevensol = $detallevensol->where('tcomp_id','=',$tcomp_id);
					$detallecomdol = $detallecomdol->where('tcomp_id','=',$tcomp_id);
					$detallevendol = $detallevendol->where('tcomp_id','=',$tcomp_id);
					$filtro[3]=TipoComprobante::find($tcomp_id)->tcomp_desc;
				}
				if($vend_id != "0")
				{
					$detallecomsol = $detallecomsol->where('vend_id','=',$vend_id);
					$detallevensol = $detallevensol->where('vend_id','=',$vend_id);
					$detallecomdol = $detallecomdol->where('vend_id','=',$vend_id);
					$detallevendol = $detallevendol->where('vend_id','=',$vend_id);
					$filtro[4]=Vendedor::find($vend_id)->vend_nom;
				}

				$detallecomsol = $detallecomsol->where('prod_id','=',$producto->prod_id)->get();
				$detallevensol = $detallevensol->where('prod_id','=',$producto->prod_id)->get();
				$detallecomdol = $detallecomdol->where('prod_id','=',$producto->prod_id)->get();
				$detallevendol = $detallevendol->where('prod_id','=',$producto->prod_id)->get();

				
				$tot_compras_sol=0;
				$tot_ventas_sol=0;
				foreach ($detallecomsol as $compra_sol) {
					$tot_compras_sol=$tot_compras_sol+($compra_sol->dcomp_cant*$compra_sol->dcomp_prec);
				}

				foreach ($detallevensol as $venta_sol) {
					$tot_ventas_sol=$tot_ventas_sol+($venta_sol->dcomp_cant*$venta_sol->dcomp_prec);
				}

				$resta_sol=$tot_ventas_sol-$tot_compras_sol;

				$tot_compras_dol=0;
				$tot_ventas_dol=0;
				foreach ($detallecomdol as $compra_dol) {
					$tot_compras_dol=$tot_compras_dol+($compra_dol->dcomp_cant*$compra_dol->dcomp_prec);
				}

				foreach ($detallevendol as $venta_dol) {
					$tot_ventas_dol=$tot_ventas_dol+($venta_dol->dcomp_cant*$venta_dol->dcomp_prec);
				}

				$resta_dol=$tot_ventas_dol-$tot_compras_dol;


				array_push($registros,array($producto->prod_desc,$tot_compras_sol,$tot_ventas_sol,$resta_sol,$tot_compras_dol,$tot_ventas_dol,$resta_dol));

			}

		}
		//$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		//$tipocomprobantes = TipoComprobante::all();
		unset($registros[0]);
		
		return view('reporte.resumenexcel',['registros'=> $registros,'filtro'=> $filtro]);
		
	}

	public function postResumenconcliente(Request $request)
	{ 
		//$comp_nro = strtoupper($request->get('comp_nro'));
		$comp_fecha_ini = strtoupper($request->get('comp_fecha_ini'));
		$comp_fecha_fin = strtoupper($request->get('comp_fecha_fin'));
		//$comp_guia = strtoupper($request->get('comp_guia'));
		$comp_cond = strtoupper($request->get('comp_cond'));
		$tcomp_id = strtoupper($request->get('tcomp_id'));
		$ent_id = strtoupper($request->get('ent_id'));
		$prod_id = strtoupper($request->get('prod_id'));
		$vend_id = strtoupper($request->get('vend_id'));
		$igv = strtoupper($request->get('igv'));

		

		$registros = array(array("PRODUCTO","COMPRAS","VENTAS","TOTAL","COMPRAS","VENTAS","TOTAL"));

		$detallecomprobantescomprassol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

		$detallecomprobantesventassol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

		$detallecomprobantescomprasdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

		$detallecomprobantesventasdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

		$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


		if($comp_cond != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_cond','=',$comp_cond);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_cond','=',$comp_cond);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_cond','=',$comp_cond);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_cond','=',$comp_cond);
			$filtro[0]=$comp_cond;
		}
		if($comp_fecha_ini != "")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_fecha','>=',$comp_fecha_ini);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_fecha','>=',$comp_fecha_ini);
			$filtro[1]=$comp_fecha_ini;
		}
		if($comp_fecha_fin != "")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('comp_fecha','<=',$comp_fecha_fin);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('comp_fecha','<=',$comp_fecha_fin);
			$filtro[2]=$comp_fecha_fin;
		}
		if($tcomp_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('tcomp_id','=',$tcomp_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('tcomp_id','=',$tcomp_id);
			$filtro[3]=TipoComprobante::find($tcomp_id)->tcomp_desc;
		}
		if($ent_id != "TODOS")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('ent_id','=',$ent_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('ent_id','=',$ent_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('ent_id','=',$ent_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('ent_id','=',$ent_id);
			$filtro[4]=Entidad::find($ent_id)->ent_rz;
		}
		if($vend_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('vend_id','=',$vend_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('vend_id','=',$vend_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('vend_id','=',$vend_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('vend_id','=',$vend_id);
			$filtro[5]=Vendedor::find($vend_id)->vend_nom;
		}
		if($prod_id != "0")
		{
			$detallecomprobantescomprassol = $detallecomprobantescomprassol->where('prod_id','=',$prod_id);
			$detallecomprobantesventassol = $detallecomprobantesventassol->where('prod_id','=',$prod_id);
			$detallecomprobantescomprasdol = $detallecomprobantescomprasdol->where('prod_id','=',$prod_id);
			$detallecomprobantesventasdol = $detallecomprobantesventasdol->where('prod_id','=',$prod_id);

			$detallecomprobantescompras=$detallecomprobantescompras->orderBy('comp_fecha')->orderBy('comp_nro')->get();
			$detallecomprobantesventas=$detallecomprobantesventas->orderBy('comp_fecha')->orderBy('comp_nro')->get();

			$tot_compras_sol=0;
			$tot_ventas_sol=0;
			foreach ($detallecomprobantescomprassol as $compra_sol) {
				$tot_compras_sol=$tot_compras_sol+($compra_sol->dcomp_cant*$compra_sol->dcomp_prec);
			}

			foreach ($detallecomprobantesventassol as $venta_sol) {
				$tot_ventas_sol=$tot_ventas_sol+($venta_sol->dcomp_cant*$venta_sol->dcomp_prec);
			}

			$resta_sol=$tot_compras_sol-$tot_ventas_sol;

			$tot_compras_dol=0;
			$tot_ventas_dol=0;
			foreach ($detallecomprobantescomprasdol as $compra_dol) {
				$tot_compras_dol=$tot_compras_dol+($compra_dol->dcomp_cant*$compra_dol->dcomp_prec);
			}

			foreach ($detallecomprobantesventasdol as $venta_dol) {
				$tot_ventas_dol=$tot_ventas_dol+($venta_dol->dcomp_cant*$venta_dol->dcomp_prec);
			}

			$resta_dol=$tot_compras_dol-$tot_ventas_dol;

			$producto=Producto::find($prod_id);
			array_push($registros,array($producto->prod_desc,$tot_compras_sol,$tot_ventas_sol,$resta_sol,$tot_compras_dol,$tot_ventas_dol,$resta_dol));
			$filtro[6]=Producto::find($prod_id)->prod_desc;
		}

		else
		{
			$productos=Producto::all();


			foreach ($productos as $producto) {

				$detallecomsol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

				$detallevensol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','SOLES');

				$detallecomdol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','1')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

				$detallevendol = DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->join('t_comprobante','t_comprobante.comp_id','=','t_detallecomprobante.comp_id')->join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->select('t_detallecomprobante.*')->where('t_operacion.tope_id','=','2')->where('t_comprobante.comp_id','<>','1')->where('t_comprobante.comp_est','<>','ANULADO')->where('comp_moneda','=','DOLAR');

				$filtro= array("TODOS","TODOS","TODOS","TODOS","TODOS","TODOS","TODOS");


				if($comp_cond != "0")
				{
					$detallecomsol = $detallecomsol->where('comp_cond','=',$comp_cond);
					$detallevensol = $detallevensol->where('comp_cond','=',$comp_cond);
					$detallecomdol = $detallecomdol->where('comp_cond','=',$comp_cond);
					$detallevendol = $detallevendol->where('comp_cond','=',$comp_cond);
					$filtro[0]=$comp_cond;
				}
				if($comp_fecha_ini != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevensol = $detallevensol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallecomdol = $detallecomdol->where('comp_fecha','>=',$comp_fecha_ini);
					$detallevendol = $detallevendol->where('comp_fecha','>=',$comp_fecha_ini);
					$filtro[1]=$comp_fecha_ini;
				}
				if($comp_fecha_fin != "")
				{
					$detallecomsol = $detallecomsol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevensol = $detallevensol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallecomdol = $detallecomdol->where('comp_fecha','<=',$comp_fecha_fin);
					$detallevendol = $detallevendol->where('comp_fecha','<=',$comp_fecha_fin);
					$filtro[2]=$comp_fecha_fin;
				}
				if($tcomp_id != "0")
				{
					$detallecomsol = $detallecomsol->where('tcomp_id','=',$tcomp_id);
					$detallevensol = $detallevensol->where('tcomp_id','=',$tcomp_id);
					$detallecomdol = $detallecomdol->where('tcomp_id','=',$tcomp_id);
					$detallevendol = $detallevendol->where('tcomp_id','=',$tcomp_id);
					$filtro[3]=TipoComprobante::find($tcomp_id)->tcomp_desc;
				}
				if($ent_id != "TODOS")
				{
					$detallecomsol = $detallecomsol->where('ent_id','=',$ent_id);
					$detallevensol = $detallevensol->where('ent_id','=',$ent_id);
					$detallecomdol = $detallecomdol->where('ent_id','=',$ent_id);
					$detallevendol = $detallevendol->where('ent_id','=',$ent_id);
					$filtro[4]=Entidad::find($ent_id)->ent_rz;
				}
				if($vend_id != "0")
				{
					$detallecomsol = $detallecomsol->where('vend_id','=',$vend_id);
					$detallevensol = $detallevensol->where('vend_id','=',$vend_id);
					$detallecomdol = $detallecomdol->where('vend_id','=',$vend_id);
					$detallevendol = $detallevendol->where('vend_id','=',$vend_id);
					$filtro[5]=Vendedor::find($vend_id)->vend_nom;
				}

				$detallecomsol = $detallecomsol->where('prod_id','=',$producto->prod_id)->get();
				$detallevensol = $detallevensol->where('prod_id','=',$producto->prod_id)->get();
				$detallecomdol = $detallecomdol->where('prod_id','=',$producto->prod_id)->get();
				$detallevendol = $detallevendol->where('prod_id','=',$producto->prod_id)->get();

				
				$tot_compras_sol=0;
				$tot_ventas_sol=0;
				foreach ($detallecomsol as $compra_sol) {
					$tot_compras_sol=$tot_compras_sol+($compra_sol->dcomp_cant*$compra_sol->dcomp_prec);
				}

				foreach ($detallevensol as $venta_sol) {
					$tot_ventas_sol=$tot_ventas_sol+($venta_sol->dcomp_cant*$venta_sol->dcomp_prec);
				}

				$resta_sol=$tot_ventas_sol-$tot_compras_sol;

				$tot_compras_dol=0;
				$tot_ventas_dol=0;
				foreach ($detallecomdol as $compra_dol) {
					$tot_compras_dol=$tot_compras_dol+($compra_dol->dcomp_cant*$compra_dol->dcomp_prec);
				}

				foreach ($detallevendol as $venta_dol) {
					$tot_ventas_dol=$tot_ventas_dol+($venta_dol->dcomp_cant*$venta_dol->dcomp_prec);
				}

				$resta_dol=$tot_ventas_dol-$tot_compras_dol;


				array_push($registros,array($producto->prod_desc,$tot_compras_sol,$tot_ventas_sol,$resta_sol,$tot_compras_dol,$tot_ventas_dol,$resta_dol));

			}

		}
		//$entidades = Entidad::where('tent_id','2')->get(); // tipo proveedor
		//$tipocomprobantes = TipoComprobante::all();
		unset($registros[0]);
		return view('reporte.resumenexcel',['registros'=> $registros,'filtro'=> $filtro]);
		
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
