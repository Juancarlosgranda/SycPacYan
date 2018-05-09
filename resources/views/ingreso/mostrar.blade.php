@extends('app')
<script type="text/javascript">
	function imprimir(){
	  var objeto=document.getElementById('imprimir');  //obtenemos el objeto a imprimir
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
	}
</script>
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
			<div class="panel-heading">Búsqueda</div>
			<div class="panel-body">
				<form class="form-inline" role="form" method="POST" action="/validado/ingreso"  style="font-size: 11px">
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
						<label>IGV</label>
						<div>
							<input type="radio" name="igv" value="C">CON IGV</input>
							<input type="radio" name="igv" value="S">SIN IGV</input>
							<input type="radio" name="igv" value="A">AMBOS</input>
						</div>
					</div>
					<div class="col-md-offset-0">
						</br>
						<button type="submit" name="buscar" value="buscar" class="btn btn-default">
							<img src="/images/buscar.png" title="BUSCAR">
						</button>
						<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
							<img src="/images/imprimir.png" title="IMPRIMIR">
						</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-md-offset-0" id="imprimir">
		<div class="panel panel-default">
			<div class="panel-heading">Compra</div>

			<div class="panel-body">
				<a href="/validado/ingreso/crear" class="btn btn-success" role="button">Nueva Compra</a>
				<br/><br/>
				<table class="table" style="font-size: 11px">
						<tr>
							<th>Nro.</th>
							<th>Tipo</th>
							<th>Proveedor</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th><div style="display:inline; float:right">Subtotal</div></th>
							<th><div style="display:inline; float:right">IGV</div></th>
							<th><div style="display:inline; float:right">Total</div></th>
							<th><div style="display:inline; float:right">Saldo</div></th>
							<th>Estado</th>
							<th>Condición</th>
							<th>Moneda</th>
							<th>T. Cambio</th>	
							<th width="230">Acciones</th>	
						</tr>

				@if(sizeof($comprobantes)>0)
					

					@foreach ($comprobantes as $comprobante)
						<tr>
							<td>{{$comprobante->comp_nro}}</td>
							@if($comprobante->tipocomprobante->tcomp_desc=="Boleta")
								<td>BV</td>
							@else
								<td>FAC</td>
							@endif
							<td>{{$comprobante->entidad->ent_rz}}</td>
							<td>{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</td>
							<td>{{$comprobante->comp_guia}}</td>
							<td><div style="display:inline; float:right">{{number_format($comprobante->comp_subt,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:right">{{number_format($comprobante->comp_igv,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:right">{{number_format($comprobante->comp_tot,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:right">{{number_format($comprobante->comp_saldo,2,'.',',')}}</div></td>
							<td>{{$comprobante->comp_est}}</td>
							<td>{{$comprobante->comp_cond}}</td>
							<td>{{$comprobante->comp_moneda}}</td>
							<td>{{$comprobante->comp_tipcambio}}</td> 
							<td>
							<a href="/validado/detalleingreso?comp_id={{$comprobante->comp_id}}"><img src="/images/detalle.png" title="VER DETALLE"></a>
							<a href="/validado/ingreso/editar?comp_id={{$comprobante->comp_id}}"><img src="/images/editar.png" title="EDITAR"></a>
							<a href="/validado/ingreso/eliminar?comp_id={{$comprobante->comp_id}}" onclick="return confirm('Esta seguro que desea eliminar?')"><img src="/images/eliminar.png" title="ELIMINAR"></a>

							@if($comprobante->comp_doc!='')
								<a target="_blank" href="/img/{{$comprobante->comp_doc}}"><img src="/images/pdf.png" title="VER ARCHIVO"></a>
							@endif
							@if($comprobante->comp_est!='ANULADO')
								<a href="/validado/ingreso/sanular?comp_id={{$comprobante->comp_id}}" onclick="return confirm('Esta seguro que desea anular?')"><img src="/images/anular.png" title="ANULAR"></a>
								<!--<a href="/validado/notacredito/crear?comp_id={{$comprobante->comp_id}}" onclick="return confirm('Esta seguro que desea anular con NOTA DE CRÉDITO?')"><img src="/images/ncredito.png" title="ANULAR CON NOTA DE CRÉDITO"></a>
								<a href="/validado/notacredito/seleccionar?comp_id={{$comprobante->comp_id}}"><img src="/images/asignarnc.png" title="PAGAR CON NOTA DE CRÉDITO"></a>-->
							@endif
							</td>

						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene comprobantes</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
