<?php namespace SICPA\Http\Controllers;

use SICPA\Producto;
use SICPA\Inventario;
use SICPA\UnidadMedida;
use SICPA\UnidadProducto;
use SICPA\Categoria;
use SICPA\Familia;
use SICPA\DetalleComprobante;
use Illuminate\Http\Request;
use SICPA\Http\Requests\CrearProductoRequest;
use SICPA\Http\Requests\EditarProductoRequest;
use Carbon\Carbon;
use Input;


class ProductoController extends Controller {

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
		$productos = Producto::orderBy('prod_cod','asc')->get();

		$categorias =Categoria::orderBy('cat_desc','asc')->get();
		$familias =Familia::orderBy('fam_desc','asc')->get();

		$unidadmedidas =UnidadMedida::orderBy('um_desc','asc')->get();
		return view('producto.mostrar',['productos'=> $productos,'categorias'=>$categorias,'familias'=>$familias,'unidadmedidas'=>$unidadmedidas]);
	}

	public function postIndex(Request $request)
	{
		$prod_desc=strtoupper($request->get('prod_desc'));
		$prod_cod=strtoupper($request->get('prod_cod'));
		$prod_exo=strtoupper($request->get('prod_exo'));
		$cat_id=strtoupper($request->get('cat_id'));
		$fam_id=strtoupper($request->get('fam_id'));
		$um_id=strtoupper($request->get('um_id'));

		$productos = Producto::where('prod_cod','like','%'.$prod_cod.'%')->where('prod_desc','like','%'.$prod_desc.'%');

		if($prod_exo != "A")
		{
			$productos = $productos->where('prod_exo','=',$prod_exo);
		}
		if($cat_id != "0")
		{
			$productos = $productos->where('cat_id','=',$cat_id);
		}
		if($um_id != "0")
		{
			$productos = $productos->where('um_id','=',$um_id);
		}
		if($fam_id != "0")
		{
			if(Categoria::where('fam_id',$fam_id)->count()>0)
			{
				$cats=Categoria::where('fam_id',$fam_id)->get();
				$array[0]=0;
				$i=0;
				foreach($cats as $cat)
				{
					$array[$i]=$cat->cat_id;
					$i++;
				}

				$productos = $productos->whereIn('cat_id',$array);
			}
		}

		$productos=$productos->orderBy('prod_cod','asc')->get();
		$categorias =Categoria::orderBy('cat_desc','asc')->get();
		$familias =Familia::orderBy('fam_desc','asc')->get();
		$unidadmedidas =UnidadMedida::orderBy('um_desc','asc')->get();

		if(Input::get('imprimir'))
			return view('reporte.producto',['productos'=> $productos,'categorias'=>$categorias,'familias'=>$familias,'unidadmedidas'=>$unidadmedidas]);
		return view('producto.mostrar',['productos'=> $productos,'categorias'=>$categorias,'familias'=>$familias,'unidadmedidas'=>$unidadmedidas]);
	}

	public function getMostrarbusqueda(Request $request)
	{
		$prod_desc=strtoupper($request->get('prod_desc'));
		$prod_cod=strtoupper($request->get('prod_cod'));
		$prod_exo=strtoupper($request->get('prod_exo'));
		$cat_id=strtoupper($request->get('cat_id'));
		$um_id=strtoupper($request->get('um_id'));

		$productos = Producto::where('prod_cod','like',$prod_cod)->where('prod_desc','like',$prod_desc);

		if($prod_exo != "A")
		{
			$productos = $productos->where('prod_exo','=',$prod_exo);
		}
		if($cat_id != "0")
		{
			$productos = $productos->where('cat_id','=',$cat_id);
		}
		if($um_id != "0")
		{
			$productos = $productos->where('um_id','=',$um_id);
		}

		$productos=$productos->get();
		$categorias =Categoria::all();
		$unidadmedidas =UnidadMedida::all();
		return view('producto.mostrar',['productos'=> $productos,'categorias'=>$categorias,'unidadmedidas'=>$unidadmedidas]);
	}

	public function getCrear()
	{
		$categorias =Categoria::orderBy('cat_desc','asc')->get();
		$unidadmedidas =UnidadMedida::orderBy('um_desc','asc')->get();

		return view('producto.crear',['categorias'=>$categorias],['unidadmedidas'=>$unidadmedidas]);
	}

	public function postCrear(CrearProductoRequest $request)
	{
		$prod_id=Producto::create
		(
			[
				'prod_desc' => strtoupper($request->get('prod_desc')),
				'prod_cod' => strtoupper($request->get('prod_cod')),
				'prod_obs' => $request->get('prod_obs'),
				'prod_exo' => strtoupper($request->get('prod_exo')),
				'cat_id' => strtoupper($request->get('cat_id')),
				'um_id' => strtoupper($request->get('um_id'))
			]
		)->prod_id;

		Inventario::create
		(
			[
				'inv_cant'=> '0',
				'inv_fecha'=> Carbon::now(),
				'prod_id'=> $prod_id,
				'alm_id'=> '1'
			]
		);

		return redirect('/validado/producto')->with('creado','Producto creado');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['prod_id'=>'required']);
		$prod_id=$request->get('prod_id');
		$producto = Producto::find($prod_id);
		$categorias =Categoria::orderBy('cat_desc','asc')->get();
		$unidadmedidas =UnidadMedida::orderBy('um_desc','asc')->get();

		return view('producto.editar',['producto'=>$producto,'categorias'=>$categorias,'unidadmedidas'=>$unidadmedidas]);
	}

	public function postEditar(EditarProductoRequest $request)
	{
		$prod_id=strtoupper($request->get('prod_id'));
		$prod_desc=strtoupper($request->get('prod_desc'));
		$prod_cod=strtoupper($request->get('prod_cod'));
		$prod_obs=$request->get('prod_obs');
		$prod_exo=strtoupper($request->get('prod_exo'));
		$cat_id=strtoupper($request->get('cat_id'));
		$um_id=strtoupper($request->get('um_id'));

		$producto = Producto::find($prod_id);

		$producto->prod_desc=$prod_desc;
		$producto->prod_cod=$prod_cod;
		$producto->prod_obs=$prod_obs;
		$producto->prod_exo=$prod_exo;
		$producto->cat_id=$cat_id;
		$producto->um_id=$um_id;
		$producto->save();

		return redirect('/validado/producto')->with('actualizado','Producto Actualizado');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['prod_id'=>'required']);
		$prod_id=$request->get('prod_id');
		$producto = Producto::find($prod_id);

		$reg=DetalleComprobante::join('t_unidadproducto','t_unidadproducto.up_id','=','t_detallecomprobante.up_id')->where('t_unidadproducto.prod_id',$prod_id)->count();

		if($reg>0)
			return redirect('/validado/producto')->with('error','No se puede eliminar, comprobantes dependen de este producto');

		UnidadProducto::where('prod_id',$prod_id)->delete();

		$Inventario = Inventario::where('prod_id',$prod_id)->where('alm_id','1')->delete();

		$producto->delete();		

		return redirect('/validado/producto')->with('eliminado','Producto eliminado');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
