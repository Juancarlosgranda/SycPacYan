<?php namespace SICPA\Http\Controllers;

use SICPA\Familia;
use SICPA\Categoria;
use Illuminate\Http\Request;

class FamiliaController extends Controller {

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
		$familias = Familia::orderBy('fam_desc','asc')->get();
		return view('familia.mostrar',['familias'=> $familias]);
	}

	public function getCrear()
	{
		return view('familia.crear');
	}

	public function postCrear(Request $request)
	{
		$this->validate($request,['fam_desc' =>'required|unique:t_familia']);
		Familia::create
		(
			[
				'fam_desc' => strtoupper($request->get('fam_desc'))
			]
		);
		return redirect('/validado/familia')->with('creado','La Familia ha sido creada');
	}

	public function getEditar(Request $request)
	{
		$this->validate($request,['fam_id'=>'required']);
		$fam_id=$request->get('fam_id');
		$familia = Familia::find($fam_id);

		return view('familia.editar',['familia'=>$familia]);
	}

	public function postEditar(Request $request)
	{
		$this->validate($request,['fam_id'=>'required','fam_desc' =>'required|unique:t_familia']);
		$fam_id=$request->get('fam_id');
		$fam_desc=strtoupper($request->get('fam_desc'));
		$familia = Familia::find($fam_id);

		$familia->fam_desc=$fam_desc;
		$familia->save();

		return redirect('/validado/familia')->with('actualizado','Familia actualizada');
	}

	public function getEliminar(Request $request)
	{
		$this->validate($request,['fam_id'=>'required']);
		$fam_id=$request->get('fam_id');

		if(Categoria::where('fam_id',$fam_id)->count()>0)
			return redirect('/validado/familia')->with('error','No se puede eliminar, productos dependen de ella');
		
		$familia = Familia::find($fam_id);
		$familia->delete();
		return redirect('/validado/familia')->with('eliminado','Familia eliminada');
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

}
