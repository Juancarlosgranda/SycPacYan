<?php namespace SICPA\Http\Controllers;

use SICPA\DetalleIE;
use SICPA\IEExterno;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearDetalleIERequest;
use SICPA\Http\Requests\EditarDetalleIERequest;
use Carbon\Carbon;

class DetalleSalidaExternoController extends Controller {

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
		$this->validate($request,['ie_id'=>'required']);
		$ie_id=$request->get('ie_id');
		$detalleies = DetalleIE::where('ie_id',$ie_id)->get();
		$ieexterno = IEExterno::find($ie_id);

		if($ieexterno->ie_moneda=='SOLES')
			$moneda='S/. ';
		else
			$moneda='$. ';

		return view('detallesalidaexterno.mostrar',['detalleies'=> $detalleies,'ieexterno'=> $ieexterno,'moneda'=> $moneda]);
	}

	public function getCrear(Request $request)
	{
		$this->validate($request,['ie_id'=>'required']);
		$ie_id=$request->get('ie_id');
		return view('detallesalidaexterno.crear',['ie_id'=> $ie_id]);
	}

	public function postCrear(CrearDetalleIERequest $request)
	{
		$ie_id=strtoupper($request->get('ie_id'));
		$die_cant= strtoupper($request->get('die_cant'));
		$die_prec= strtoupper($request->get('die_prec'));
		$die_desc= strtoupper($request->get('die_desc'));

		$die_id=DetalleIE::create
		(
			[
				'die_cant'=> $die_cant,
				'die_desc'=> $die_desc,
				'die_prec'=> $die_prec,
				'ie_id'=> $ie_id,
			]
		)->die_id;

			
		///////////////////////// EDITANDO Comprobante ////////////////////////////////////////////////////////////////
		
		$detalleies = DetalleIE::where('ie_id',$ie_id)->get();
		$total=0;

		foreach ($detalleies as $detalleie) {
			$total=$total + ($detalleie->die_cant * $detalleie->die_prec);
		}

		$subt=$total/1.18;
		$igv=$total-$subt;

		$ieexterno=IEExterno::find($ie_id);	
		$ieexterno->ie_subt=$subt;
		$ieexterno->ie_igv=$igv;
		$ieexterno->ie_tot=$total;
		$ieexterno->save();
		///////////////////////////////////////////////////////////////////////////////////////////////////////////

		return redirect("/validado/detallesalidaexterno?ie_id={$ie_id}")->with('creado','Detalle Comprobante creado');

	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['die_id'=>'required']);
		$die_id=$request->get('die_id');
		$detalleie = detalleie::find($die_id);

		return view('detallesalidaexterno.editar',['detalleie'=>$detalleie]);

	}

	public function postEditar(EditarDetalleIERequest $request)
	{
		$ie_id=strtoupper($request->get('ie_id'));
		$die_id= strtoupper($request->get('die_id'));
		$die_cant= strtoupper($request->get('die_cant'));
		$die_prec= strtoupper($request->get('die_prec'));
		$die_desc= strtoupper($request->get('die_desc'));

		$detalleie = DetalleIE::find($die_id);

		$detalleie->die_cant=$die_cant;
		$detalleie->die_prec=$die_prec;
		$detalleie->die_desc=$die_desc;
		$detalleie->save();

		///////////////////////// EDITANDO Comprobante ///////////////////////////////////////////////////////////////

		$detalleies = DetalleIE::where('ie_id',$ie_id)->get();
		$total=0;
		
		foreach ($detalleies as $detalleie) {
			$total=$total + ($detalleie->die_cant * $detalleie->die_prec);
		}

		$subt=$total/1.18;
		$igv=$total-$subt;

		$ieexterno=IEExterno::find($ie_id);	
		$ieexterno->ie_subt=$subt;
		$ieexterno->ie_igv=$igv;
		$ieexterno->ie_tot=$total;
		$ieexterno->save();

		return redirect("/validado/detallesalidaexterno?ie_id={$ie_id}")->with('actualizado','Detalle Comprobante actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['die_id'=>'required']);
		$die_id=$request->get('die_id');

		$detalleie = DetalleIE::find($die_id);
		$ie_id=$detalleie->ie_id;

		DetalleIE::find($die_id)->delete();

		
		///////////////////////// EDITANDO Comprobante ////////////////////////////////////////////////////////////////
		

		$detalleies = DetalleIE::where('ie_id',$ie_id)->get();
		$total=0;
		
		foreach ($detalleies as $detalleie) {
			$total=$total + ($detalleie->die_cant * $detalleie->die_prec);
		}

		$subt=$total/1.18;
		$igv=$total-$subt;

		$ieexterno=IEExterno::find($ie_id);	
		$ieexterno->ie_subt=$subt;
		$ieexterno->ie_igv=$igv;
		$ieexterno->ie_tot=$total;
		$ieexterno->save();

		return redirect('/validado/detallesalidaexterno')->with('eliminado','Detalle Comprobante eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
