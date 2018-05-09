@extends('app')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
<script type="text/javascript">
	$(setup)
	function setup() {
	    $('#intro select').zelect({ placeholder:'Selecciona Cliente...' })
	}
</script>

<style>
    	#hh { font-size: 16px; color: #1e1f19; background-color: #f3f3f3; padding: 10px 20px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
    #hh { color: #7A7A78; }
    #intro { margin-bottom: 8px; }
    #intro:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }

    #intro .zelect {
      display: inline-block;
      background-color: white;
      min-width: 275px;
      cursor: pointer;
      line-height: 34px;
      border: 1px solid #D0D0D0;
      border-radius: 6px;
      position: relative;
    }
    #intro .zelected {
      padding-left: 10px;
    }
    #intro .zelected.placeholder {
      color: #67737A;
    }
    #intro .zelected:hover {
      border-color: #99B8BF;
      box-shadow: inset 0px 5px 8px -6px #D0D0D0;
    }
    #intro .zelect.open {
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }
    #intro .dropdown {
      background-color: white;
      border-bottom-left-radius: 5px;
      border-bottom-right-radius: 5px;
      border: 1px solid #D0D0D0;
      border-top: none;
      position: absolute;
      left:-1px;
      right:-1px;
      top: 36px;
      z-index: 2;
      padding: 3px 5px 3px 3px;
    }
    #intro .dropdown input {
      font-family: sans-serif;
      outline: none;
      font-size: 14px;
      border-radius: 4px;
      border: 1px solid #D0D0D0;
      box-sizing: border-box;
      width: 100%;
      padding: 0px 0 0px 0px;
    }
    #intro .dropdown ol {
      padding: 0;
      margin: 0px 0 0 0;
      list-style-type: none;
      max-height: 100px;
      overflow-y: scroll;
    }
    #intro .dropdown li {
      padding-left: 10px;
    }
    #intro .dropdown li.current {
      background-color: #AFB6B7;
    }
    #intro .dropdown .no-results {
      margin-left: 10px;
    }
</style>
@section('content')
@if (Session::has('creado'))
	<div class="alert alert-success">
		{{Session::get('creado')}}
	</div>
@endif
@if (Session::has('actualizado'))
	<div class="alert alert-success">
		{{Session::get('actualizado')}}
	</div>
@endif
@if (Session::has('eliminado'))
	<div class="alert alert-success">
		{{Session::get('eliminado')}}
	</div>
@endif
<div class="container-fluid">
	<div class="col-md-12 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Reportes</div>
				<div class="panel-body">
					<!--<div class="col-md-12 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">COMPRAS</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="POST" action="/validado/reporte/ingreso">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
									<div class="form-group col-md-offset-0">
										<label>Nro</label>
										<div>
											<input type="text" class="form-control text-uppercase" name="comp_nro">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Proveedor</label>
										<div>
											<select class="form-control text-uppercase" name="ent_id">
												<option  value=0>Elija Proveedor</option>
												@foreach ($entidades as $entidad)
												   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Guía de Remisión</label>
										<div>
											<input type="text" class="form-control text-uppercase" name="comp_guia">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Tipo</label>
										<div>
											<select class="form-control text-uppercase" name="tcomp_id">
												<option  value=0>Elija Tipo</option>
											   @foreach ($tipocomprobantes as $tipocomprobante)
											   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Fecha</label>
										<div>
											<input type="date" class="form-control text-uppercase" name="comp_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_fin">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Condición</label>
										<div>
											<select class="form-control text-uppercase" name="comp_cond">
													<option  value=0>Elija Condición</option>
													<option >AL CONTADO</option>
													<option >MUESTRA GRATUITA</option>
													<option >AL CREDITO</option>
													<option >Otro</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Moneda</label>
										<div>
											<select class="form-control text-uppercase" name="comp_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>									
									<div class="form-group col-md-offset-0">
										<label>Vendedor</label>
										<div>
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>IGV</label>
										<div>
											<input type="radio" name="igv" value="C">CON IGV</input>
											<input type="radio" name="igv" value="S">SIN IGV</input>
											<input type="radio" name="igv" value="A">AMBOS</input>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>-->
					<div class="col-md-3 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">DETALLE DE COMPRAS</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="POST" action="/validado/reporte/detalleingreso">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
									<div class="form-group">
										<label class="col-md-3 col-md-offset-0">Nro</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="text" class="form-control text-uppercase" name="comp_nro">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Proveedor</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="ent_id">
												<option  value=0>Elija Proveedor</option>
												@foreach ($entidades as $entidad)
												   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Guía de Remisión</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="text" class="form-control text-uppercase" name="comp_guia">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Tipo</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="tcomp_id">
												<option  value=0>Elija Tipo</option>
											   @foreach ($tipocomprobantes as $tipocomprobante)
											   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Producto</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" id="prod_id" name="prod_id">
												<option value=0>Elija Producto</option>
												@foreach ($productos as $producto)										
												   	<option  value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>	
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Fecha</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_fin">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Condición</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_cond">
													<option  value=0>Elija Condición</option>
													<option >AL CONTADO</option>
													<option >MUESTRA GRATUITA</option>
													<option >AL CREDITO</option>
													<option >Otro</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Moneda</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>									
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Vendedor</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">IGV</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="radio" name="igv" value="C">CON IGV</input>
											<input type="radio" name="igv" value="S">SIN IGV</input>
											<input type="radio" name="igv" value="A">AMBOS</input>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
					<!--<div class="col-md-12 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">VENTAS</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="POST" action="/validado/reporte/salida">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
									<div class="form-group col-md-offset-0">
										<label>Nro</label>
										<div>
											<input type="text" class="form-control text-uppercase" name="comp_nro">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Proveedor</label>
										<div>
											<select class="form-control text-uppercase" name="ent_id">
												<option  value=0>Elija Proveedor</option>
												@foreach ($entidades as $entidad)
												   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Guía de Remisión</label>
										<div>
											<input type="text" class="form-control text-uppercase" name="comp_guia">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Tipo</label>
										<div>
											<select class="form-control text-uppercase" name="tcomp_id">
												<option  value=0>Elija Tipo</option>
											   @foreach ($tipocomprobantes as $tipocomprobante)
											   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Fecha</label>
										<div>
											<input type="date" class="form-control text-uppercase" name="comp_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_fin">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Condición</label>
										<div>
											<select class="form-control text-uppercase" name="comp_cond">
													<option  value=0>Elija Condición</option>
													<option >AL CONTADO</option>
													<option >MUESTRA GRATUITA</option>
													<option >AL CREDITO</option>
													<option >Otro</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>Moneda</label>
										<div>
											<select class="form-control text-uppercase" name="comp_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>									
									<div class="form-group col-md-offset-0">
										<label>Vendedor</label>
										<div>
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label>IGV</label>
										<div>
											<input type="radio" name="igv" value="C">CON IGV</input>
											<input type="radio" name="igv" value="S">SIN IGV</input>
											<input type="radio" name="igv" value="A">AMBOS</input>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>-->
					<div class="col-md-3 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">DETALLE DE VENTAS</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="POST" action="/validado/reporte/detallesalida">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Nro</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="text" class="form-control text-uppercase" name="comp_nro">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Cliente</label>
										<div class="col-md-9 col-md-offset-0">
											<section name="intro" id="intro" style="display: block;">
												<select name="ent_id" id="ent_id">
													<option  value='todos'>TODOS</option>
													@foreach ($clientes as $cliente)
													   <option  value='{{$cliente->ent_id}}'>{{$cliente->ent_rz}}</option>
													@endforeach
												</select>
											</section>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Guía de Remisión</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="text" class="form-control text-uppercase" name="comp_guia">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Tipo</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="tcomp_id">
												<option  value=0>Elija Tipo</option>
											   @foreach ($tipocomprobantes as $tipocomprobante)
											   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Producto</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" id="prod_id" name="prod_id">
												<option value=0>Elija Producto</option>
												@foreach ($productos as $producto)										
												   	<option  value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>	
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Fecha</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_fin">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Condición</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_cond">
													<option  value=0>Elija Condición</option>
													<option >AL CONTADO</option>
													<option >MUESTRA GRATUITA</option>
													<option >AL CREDITO</option>
													<option >Otro</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Moneda</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>									
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Vendedor</label>
										<div class="col-md-9 col-md-offset-0">
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">IGV</label>
										<div class="col-md-9 col-md-offset-0">
											<input type="radio" name="igv" value="C">CON IGV</input>
											<input type="radio" name="igv" value="S">SIN IGV</input>
											<input type="radio" name="igv" value="A">AMBOS</input>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">GASTOS</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="POST" action="/validado/reporte/detallegastos">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<!--<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Cliente</label>
										<div class="col-md-9 col-md-offset-0">
											<section name="intro" id="intro" style="display: block;">
												<select name="ent_id" id="ent_id">
													<option  value='todos'>TODOS</option>
													@foreach ($clientes as $cliente)
													   <option  value='{{$cliente->ent_id}}'>{{$cliente->ent_rz}}</option>
													@endforeach
												</select>
											</section>
										</div>
									</div>-->
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Fecha</label>
										<div class="col-md-10 col-md-offset-0">
											<input type="date" class="form-control text-uppercase" name="ie_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="ie_fecha_fin">
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Moneda</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="ie_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>							
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Vendedor</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Centro de Costos</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="ie_tipocc">
												<option  value=0>Elija C. Costos</option>
											   @foreach ($tipoccs as $tipocc)
											   		<option>{{$tipocc->tcc_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Tipo de Gasto</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="ie_tipgasto">
												<option  value=0>Elija Tipo</option>
												@foreach ($tipogastos as $tipogasto)
											   		<option>{{$tipogasto->tgasto_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>

					<!--<div class="col-md-2 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">DEUDAS VENCIDAS</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="POST" action="/validado/reporte/dvencidas">
									<div class="col-md-offset-0">
										</br>
										<button type="submit" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-2 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">DEUDAS POR VENCER</div>
							<div class="panel-body">
								<form class="form-inline" role="form" method="POST" action="/validado/reporte/dporvencer">
									<div class="col-md-offset-0">
										</br>
										<button type="submit" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>-->
					<div class="col-md-4 col-md-offset-0">
						<div class="panel panel-default">
							<div class="panel-heading">RESUMEN</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form" method="POST" action="/validado/reporte/resumen">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<!--<div class="form-group col-md-offset-0">
										<label class="col-md-3 col-md-offset-0">Cliente</label>
										<div class="col-md-9 col-md-offset-0">
											<section name="intro" id="intro" style="display: block;">
												<select name="ent_id" id="ent_id">
													<option  value='todos'>TODOS</option>
													@foreach ($clientes as $cliente)
													   <option  value='{{$cliente->ent_id}}'>{{$cliente->ent_rz}}</option>
													@endforeach
												</select>
											</section>
										</div>
									</div>
									___________________________
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Tipo</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="tcomp_id">
												<option  value=0>Elija Tipo</option>
											   @foreach ($tipocomprobantes as $tipocomprobante)
											   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Producto</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" id="prod_id" name="prod_id">
												<option value=0>Elija Producto</option>
												@foreach ($productos as $producto)										
												   	<option  value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
												@endforeach
											</select>
										</div>
									</div>	-->
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Fecha</label>
										<div class="col-md-10 col-md-offset-0">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_ini">
											<input type="date" class="form-control text-uppercase" name="comp_fecha_fin">
										</div>
									</div>
									<!--<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Condición</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_cond">
													<option  value=0>Elija Condición</option>
													<option >AL CONTADO</option>
													<option >MUESTRA GRATUITA</option>
													<option >AL CREDITO</option>
													<option >Otro</option>
											</select>
										</div>
									</div>
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Moneda</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="comp_moneda">
												<option  value=0>Elija Moneda</option>
											   <option value="DOLAR">DOLÁR AMERICANO</option>
											   <option value="SOLES">SOLES</option>
											</select>
										</div>
									</div>	-->								
									<div class="form-group col-md-offset-0">
										<label class="col-md-2 col-md-offset-0">Vendedor</label>
										<div class="col-md-10 col-md-offset-0">
											<select class="form-control text-uppercase" name="vend_id">
												<option  value=0>Elija Vendedor</option>
											   @foreach ($vendedores as $vendedor)
											   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-offset-0">
										</br>
										<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
											<img src="/images/imprimir.png" title="IMPRIMIR">
										</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
				</div>
				
		</div>
	</div>
</div>
@endsection
