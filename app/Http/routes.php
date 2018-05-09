<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::get('dropdown', function(){
	$id = Input::get('option');
	$procesos = UnidadProducto::where('prod_id',$id)->get();
	return $procesos->lists('prod_id', 'um_id');
});*/

use SICPA\UnidadMedida;
use SICPA\Producto;
use SICPA\Entidad;
use SICPA\Categoria;
use SICPA\Comprobante;
use SICPA\Provincia;
use SICPA\Distrito;

Route::get('/information/create/ajax-state',function()
{
    $prod_id = Input::get('prod_id');
    $unidadmedidas = UnidadMedida::join('t_unidadproducto','t_unidadproducto.um_id','=','t_unidadmedida.um_id')->select('t_unidadmedida.*')->where('t_unidadproducto.prod_id','=',$prod_id)->get();
    return $unidadmedidas;

});

Route::get('/information/create/ajax-state-obtprovincia',function()
{
    $dpto_id = Input::get('dpto_id');
    $provincias = Provincia::where('dpto_id','=',$dpto_id)->get();
    return $provincias;

});

Route::get('/information/create/ajax-state-obtdistrito',function()
{
    $prov_id = Input::get('prov_id');
    $distritos = Distrito::where('prov_id','=',$prov_id)->get();
    return $distritos;

});


Route::get('/information/create/ajax-state-cat',function()
{
    $cat_id = Input::get('cat_id');
    $fam_id = Categoria::find($cat_id)->fam_id;

    if(Producto::join('t_categoria','t_categoria.cat_id','=','t_producto.cat_id')->where('t_categoria.fam_id',$fam_id)->count()==0)
    {
    	$codigo_fam = 100 + $fam_id;
    	$codigo_prod = $codigo_fam.'0001';
    }
    else
    {
	    $cod_prod = Producto::join('t_categoria','t_categoria.cat_id','=','t_producto.cat_id')->select('t_producto.prod_cod')->where('t_categoria.fam_id',$fam_id)->max('prod_cod');
    	$codigo_prod = $cod_prod + 1;    	
    }

    return $codigo_prod;
});

Route::get('/information/create/ajax-state-vercompi',function()
{
    $comp_nro = Input::get('comp_nro');

    if(Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','1')->where('comp_nro',$comp_nro)->count()>0)
    	return "*Ya existe.";

    return " ";
});

Route::get('/information/create/ajax-state-vercliente',function()
{
    $ent_ruc = Input::get('ent_ruc');

    if(Entidad::where('ent_ruc',$ent_ruc)->count()>0)
    	return "*Ya existe.";

    return " ";
});

Route::get('/information/create/ajax-state-vercomps',function()
{
    $comp_nro = Input::get('comp_nro');

    if(Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->where('t_operacion.tope_id','=','2')->where('comp_nro',$comp_nro)->count()>0)
    	return "*Ya existe.";

    return " ";
});

Route::get('/information/create/ajax-state-vercomprobante',function()
{
    $comp_ref = Input::get('comp_ref');

    $comprobante=Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->join('t_tipocomprobante','t_tipocomprobante.tcomp_id','=','t_comprobante.tcomp_id')->join('t_entidad','t_entidad.ent_id','=','t_comprobante.ent_id')->where('t_operacion.tope_id','=','2')->where('comp_nro',$comp_ref)->get();
    
    return $comprobante[0];
});

Route::get('/information/create/ajax-state-vercomprobante-compra',function()
{
    $comp_ref = Input::get('comp_ref');

    $comprobante=Comprobante::join('t_operacion','t_operacion.comp_id','=','t_comprobante.comp_id')->join('t_tipocomprobante','t_tipocomprobante.tcomp_id','=','t_comprobante.tcomp_id')->join('t_entidad','t_entidad.ent_id','=','t_comprobante.ent_id')->where('t_operacion.tope_id','=','1')->where('comp_nro',$comp_ref)->get();
    
    return $comprobante[0];
});

Route::get('/information/create/ajax-state-prod_um',function()
{
    $prod_id = Input::get('prod_id');
    $producto = Producto::find($prod_id);
    $unidadmedida = UnidadMedida::find($producto->um_id);
    return $unidadmedida;

});

Route::controllers([
	'validacion' => 'Validacion\ValidacionController',
	'validado/usuario'=>'UsuarioController',	
	'validado/almacen'=>'AlmacenController',
	'validado/familia'=>'FamiliaController',
	'validado/conversion'=>'ConversionController',
	'validado/categoria'=>'CategoriaController',
	'validado/vendedor'=>'VendedorController',
	'validado/cliente'=>'ClienteController',
	'validado/proveedor'=>'ProveedorController',
	'validado/producto'=>'ProductoController',
	'validado/unidadmedida'=>'UnidadMedidaController',
	'validado/unidadproducto'=>'UnidadProductoController',
	'validado/ingreso'=>'IngresoController',
	'validado/detalleingreso'=>'DetalleIngresoController',
	'validado/salida'=>'SalidaController',
	'validado/detallesalida'=>'DetalleSalidaController',
	'validado/inventario'=>'InventarioController',
	'validado/ingresoexterno'=>'IngresoExternoController',
	'validado/detalleingresoexterno'=>'DetalleIngresoExternoController',
	'validado/salidaexterno'=>'SalidaExternoController',
	'validado/detallesalidaexterno'=>'DetalleSalidaExternoController',
	'validado/notacredito'=>'NotaCreditoController', 
	'validado/pago'=>'PagoController',
	'validado/caja'=>'CajaController',
	'validado/reporte'=>'ReporteController',
	'validado/ocompra'=>'OCompraController',
	'validado/detalleocompra'=>'DetalleOCompraController',
	'validado/npedido'=>'NPedidoController',
	'validado/detallenpedido'=>'DetalleNPedidoController',
    'validado/tipogasto'=>'TipoGastoController',
	'validado'=>'InicioController',
	
	'/'=>'BienvenidaController'
]);
Route::get('/img/{{archivo}}', function ($archivo) {
     $public_path = public_path();
     $url = $public_path.'/img/'.$archivo;
     //verificamos si el archivo existe y lo retornamos
     if (Storage::exists($archivo))
     {
       return response()->download($url);
     }
     //si no se encuentra lanzamos un error 404.
     abort(404);
 
});
