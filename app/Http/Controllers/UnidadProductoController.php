<?php namespace SICPA\Http\Controllers;

use SICPA\UnidadProducto;
use SICPA\Producto;
use SICPA\DetalleComprobante;
use SICPA\UnidadMedida;
use Illuminate\Http\Request;

class UnidadProductoController extends Controller {

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
		$unidadproductos = UnidadProducto::join('t_producto','t_producto.prod_id','=','t_unidadproducto.prod_id')->select('t_unidadproducto.*')->orderBy('t_producto.prod_desc')->get();
		return view('unidadproducto.mostrar',['unidadproductos'=> $unidadproductos]);
	}

	public function getCrear()
	{
		$productos = Producto::orderBy('prod_desc','asc')->get();
		$unidadmedidas = UnidadMedida::orderBy('um_desc','asc')->get();
		return view('unidadproducto.crear',['productos'=>$productos,'unidadmedidas'=>$unidadmedidas]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['um_id' =>'required','prod_id' =>'required']);
		UnidadProducto::create
		(
			[
				'um_id' => $request->get('um_id'),
				'prod_id' => $request->get('prod_id')
			]
		);
		return redirect('/validado/unidadproducto')->with('creado','Unidad de Medida de Producto creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['up_id'=>'required']);
		$up_id=$request->get('up_id');
		$unidadproducto = UnidadProducto::find($up_id);

		return view('unidadproducto.editar',['unidadproducto'=>$unidadproducto]);

	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['up_id'=>'required','um_id' =>'required','prod_id' =>'required']);
		$up_id=$request->get('up_id');
		$um_id=$request->get('um_id');
		$prod_id=$request->get('prod_id');
		$unidadproducto = UnidadProducto::find($up_id);

		$unidadproducto->um_id=$um_id;
		$unidadproducto->prod_id=$prod_id;
		$unidadproducto->save();

		return redirect('/validado/unidadproducto')->with('actualizado','Unidad de Medida de Producto actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['up_id'=>'required']);
		$up_id=$request->get('up_id');

		if(DetalleComprobante::where('up_id',$up_id)->count()>0)
		{	
			return redirect('/validado/unidadproducto')->with('error','No se pudo eliminar ya que varios comprobantes se registraron con esta unidad');
		}

		$unidadproducto = UnidadProducto::find($up_id);
		$unidadproducto->delete();
		return redirect('/validado/unidadproducto')->with('eliminado','Unidad de Medida de Producto eliminada');


		
	}


	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
