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
				<form class="form-inline" role="form" method="POST" action="/validado/ingreso">
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
			<div class="panel-heading">Compra</div>

			<div class="panel-body">
				<a href="/validado/ingreso/crear" class="btn btn-success" role="button">Nueva Compra</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Nro.</th>
							<th>Tipo</th>
							<th>Proveedor</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Saldo</th>
							<th>Estado</th>
							<th>Condición</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>	
							<th>Acciones</th>	
						</tr>

				@if(sizeof($comprobantes)>0)
					

					@foreach ($comprobantes as $comprobante)
						<tr>
							<td>{{$comprobante->comp_nro}}</td>
							<td>{{$comprobante->tipocomprobante->tcomp_desc}}</td>
							<td>{{$comprobante->entidad->ent_rz}}</td>
							<td>{{$comprobante->comp_fecha}}</td>
							<td>{{$comprobante->comp_guia}}</td>
							<td>{{$comprobante->comp_subt}}</td>
							<td>{{$comprobante->comp_igv}}</td>
							<td>{{$comprobante->comp_tot}}</td>
							<td>{{$comprobante->comp_saldo}}</td>
							<td>{{$comprobante->comp_est}}</td>
							<td>{{$comprobante->comp_cond}}</td>
							<td>{{$comprobante->comp_moneda}}</td>
							<td>{{$comprobante->comp_tipcambio}}</td>
							<td>
							<a href="/validado/detalleingreso?comp_id={{$comprobante->comp_id}}" class="btn btn-warning" role="button">Ver Detalle</a>
							<a href="/validado/ingreso/editar?comp_id={{$comprobante->comp_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/ingreso/eliminar?comp_id={{$comprobante->comp_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
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
