@extends('app')

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
				<form class="form-inline" role="form" method="POST" action="/validado/ingresoexterno">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group col-md-offset-0">
						<label>Nro</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_comp">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>RUC</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_ruc">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Razón Social</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_rz">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Guía de Remisión</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_guia">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Tipo</label>
						<div>
							<select class="form-control text-uppercase" name="ie_tcomp">
								<option  value=0>Elija Tipo</option>
								<option>BOLETA</option>
							   	<option>FACTURA</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Fecha</label>
						<div>
							<input type="date" class="form-control text-uppercase" name="ie_fecha_ini">
							<input type="date" class="form-control text-uppercase" name="ie_fecha_fin">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Moneda</label>
						<div>
							<select class="form-control text-uppercase" name="ie_moneda">
								<option  value=0>Elija Moneda</option>
							  	<option value="DOLAR">DOLÁR AMERICANO</option>
								<option value="SOLES">SOLES</option>
							</select>
						</div>
					</div>
					<div class="col-md-offset-0">
						</br>
						<button type="submit" class="btn btn-primary">
							Buscar
						</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Ingreso</div>

			<div class="panel-body">
				<a href="/validado/ingresoexterno/crear" class="btn btn-success" role="button">Nueva Ingreso</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Nro.</th>
							<th>Tipo</th>
							<th>RUC</th>
							<th>Razón Social</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>	
							<th>Acciones</th>	
						</tr>

				@if(sizeof($ieexternos)>0)
					

					@foreach ($ieexternos as $ieexterno)
						<tr>
							<td>{{$ieexterno->ie_comp}}</td>
							<td>{{$ieexterno->ie_tcomp}}</td>
							<td>{{$ieexterno->ie_ruc}}</td>
							<td>{{$ieexterno->ie_rz}}</td>
							<td>{{date('d/m/Y', strtotime($ieexterno->ie_fecha))}}</td>
							<td>{{$ieexterno->ie_guia}}</td>
							<td>{{$ieexterno->ie_subt}}</td>
							<td>{{$ieexterno->ie_igv}}</td>
							<td>{{$ieexterno->ie_tot}}</td>
							<td>{{$ieexterno->ie_moneda}}</td>
							<td>{{$ieexterno->ie_tipcambio}}</td>
							<td>
							<a href="/validado/detalleingresoexterno?ie_id={{$ieexterno->ie_id}}" class="btn btn-warning" role="button" title="VER DETALLE">Ver Detalle</a>
							<a href="/validado/ingresoexterno/editar?ie_id={{$ieexterno->ie_id}}" class="btn btn-primary" role="button" title="EDITAR">Editar</a>
							<a href="/validado/ingresoexterno/eliminar?ie_id={{$ieexterno->ie_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger" title="ELIMINAR">Eliminar</a>
							</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene registro de ingresos</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
