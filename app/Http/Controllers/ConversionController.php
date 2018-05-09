<?php namespace SICPA\Http\Controllers;

use SICPA\Conversion;
use SICPA\UnidadMedida;
use Illuminate\Http\Request;

class ConversionController extends Controller {

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
		$conversiones = Conversion::orderBy('um_id1','asc')->get();;
		return view('conversion.mostrar',['conversiones'=> $conversiones]);
	}

	public function getCrear()
	{
		$unidadmedidas = UnidadMedida::all();
		return view('conversion.crear',['unidadmedidas'=>$unidadmedidas]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['conv_fact'=>'required','um_id1'=>'required','um_id2'=>'required']);
		$conv_fact = strtoupper($request->get('conv_fact'));
		$um_id1 = strtoupper($request->get('um_id1'));
		$um_id2 = strtoupper($request->get('um_id2'));

		$cant=Conversion::where('um_id1',$um_id1)->where('um_id2',$um_id2)->count();
		if($cant==0)
		{
			Conversion::create
			(
				[
					'conv_fact' => $conv_fact,
					'um_id1' => $um_id1,
					'um_id2' => $um_id2,
				]
			);
			return redirect('/validado/conversion')->with('creado','La conversión ha sido creada');
		}
		return redirect('/validado/conversion')->with('error','Esta conversión ya existe');
		
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['conv_id'=>'required']);
		$conv_id=$request->get('conv_id');
		$conversion = Conversion::find($conv_id);
		$unidadmedidas = UnidadMedida::all();

		return view('conversion.editar',['conversion'=>$conversion],['unidadmedidas'=>$unidadmedidas]);
	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['conv_id'=>'required','conv_fact'=>'required','um_id1'=>'required','um_id2'=>'required']);
		$conv_id=$request->get('conv_id');
		$conv_fact=strtoupper($request->get('conv_fact'));
		$um_id1=strtoupper($request->get('um_id1'));
		$um_id2=strtoupper($request->get('um_id2'));
		$conversion = Conversion::find($conv_id);

		$conversion->conv_fact=$conv_fact;
		$conversion->um_id1=$um_id1;
		$conversion->um_id2=$um_id2;
		$conversion->save();

		return redirect('/validado/conversion')->with('actualizado','Conversion actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['conv_id'=>'required']);
		$conv_id=$request->get('conv_id');

		
		$almacen = Conversion::find($conv_id);
		$almacen->delete();

		return redirect('/validado/conversion')->with('eliminado','Conversión eliminada');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
