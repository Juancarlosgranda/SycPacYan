<?php namespace SICPA\Http\Controllers;

use SICPA\Categoria;
use SICPA\Familia;
use SICPA\Producto;
use SICPA\Http\Requests\CrearCategoriaRequest;
use SICPA\Http\Requests\EditarCategoriaRequest;
use Illuminate\Http\Request;

class CategoriaController extends Controller {

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
		$categorias = Categoria::orderBy('fam_id','asc')->get();
		return view('categoria.mostrar',['categorias'=> $categorias]);
	}

	public function getCrear()
	{
		$familias =Familia::orderBy('fam_desc','asc')->get();
		if(Familia::count()==0)
			return redirect('/validado/categoria')->with('error','No existen Familias, debe crear por lo menos una.');
		return view('categoria.crear',['familias'=>$familias]);
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['cat_desc' =>'required|unique:t_categoria']);
		Categoria::create
		(
			[
				'cat_desc' => strtoupper($request->get('cat_desc')),
				'fam_id' => strtoupper($request->get('fam_id'))
			]
		);
		return redirect('/validado/categoria')->with('creado','La categoria ha sido creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['cat_id'=>'required']);
		$cat_id=$request->get('cat_id');
		$categoria = Categoria::find($cat_id);

		$familias =Familia::orderBy('fam_desc','asc')->get();


		return view('categoria.editar',['categoria'=>$categoria,'familias'=>$familias]);
	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['cat_id'=>'required','cat_desc' =>'required']);
		$cat_id=$request->get('cat_id');
		$cat_desc=strtoupper($request->get('cat_desc'));
		$fam_id=strtoupper($request->get('fam_id'));
		$categoria = Categoria::find($cat_id);

		$categoria->cat_desc=$cat_desc;
		$categoria->fam_id=$fam_id;
		$categoria->save();

		return redirect('/validado/categoria')->with('actualizado','Categoria actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['cat_id'=>'required']);
		$cat_id=$request->get('cat_id');
		
		if(Producto::where('cat_id',$cat_id)->count()>0)
			return redirect('/validado/categoria')->with('error','No se puede eliminar, productos dependen de esta categoría');		

		$categoria = Categoria::find($cat_id);
		$categoria->delete();
		return redirect('/validado/categoria')->with('eliminado','Categoria eliminada');
		
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
