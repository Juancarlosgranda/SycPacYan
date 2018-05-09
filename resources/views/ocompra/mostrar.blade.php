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
				<form class="form-inline" role="form" method="POST" action="/validado/ocompra">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group col-md-offset-0">
						<label>Nro</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ocv_nro">
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
						<label>Fecha</label>
						<div>
							<input type="date" class="form-control text-uppercase" name="ocv_fecha_ini">
							<input type="date" class="form-control text-uppercase" name="ocv_fecha_fin">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Moneda</label>
						<div>
							<select class="form-control text-uppercase" name="ocv_moneda">
								<option  value=0>Elija Moneda</option>
							   <option value="DOLAR">DOLÁR AMERICANO</option>
							   <option value="SOLES">SOLES</option>
							</select>
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
			<div class="panel-heading">Orden de Compra</div>

			<div class="panel-body">
				<a href="/validado/ocompra/crear" class="btn btn-success" role="button">Nueva Orden de Compra</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Nro.</th>
							<th>Proveedor</th>
							<th>Fecha</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Saldo</th>
							<th>Estado</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>	
							<th width="230">Acciones</th>	
						</tr>

				@if(sizeof($ordencvs)>0)
					

					@foreach ($ordencvs as $ordencv)
						<tr>
							<td>{{$ordencv->ocv_nro}}</td>
							<td>{{$ordencv->entidad->ent_rz}}</td>
							<td>{{date('d/m/Y', strtotime($ordencv->ocv_fecha))}}</td>
							<td>{{number_format($ordencv->ocv_subt,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_igv,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_tot,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_saldo,2,'.',',')}}</td>
							<td>{{$ordencv->ocv_est}}</td>
							<td>{{$ordencv->ocv_moneda}}</td>
							<td>{{$ordencv->ocv_tipcambio}}</td> 
							<td>
							<a href="/validado/detalleocompra?ocv_id={{$ordencv->ocv_id}}"><img src="/images/detalle.png" title="VER DETALLE"></a>
							<a href="/validado/ocompra/editar?ocv_id={{$ordencv->ocv_id}}"><img src="/images/editar.png" title="EDITAR"></a>
							<a href="/validado/ocompra/eliminar?ocv_id={{$ordencv->ocv_id}}" onclick="return confirm('Esta seguro que desea eliminar?')"><img src="/images/eliminar.png" title="ELIMINAR"></a>
							
							@if($ordencv->ocv_doc!='')
								<a target="_blank" href="/img/{{$ordencv->ocv_doc}}"><img src="/images/pdf.png" title="VER ARCHIVO"></a>
							@endif
							@if($ordencv->ocv_est=='ACTIVO')
								<a href="/validado/notacredito/seleccionar?ocv_id={{$ordencv->ocv_id}}"><img src="/images/asignar.png" title="ASIGNAR COMPROBANTE"></a>
							@endif
							</td>

						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene Orden de Compras</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
