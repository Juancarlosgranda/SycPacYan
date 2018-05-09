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
				<form class="form-inline" role="form" method="POST" action="/validado/cliente">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group col-md-offset-0">
						<label>RUC ó DNI</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_ruc">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Razón Social</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_rz">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Dirección</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_dir">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Departamento</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_dpto">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Ciudad</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_ciu">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Contacto</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ent_cont">
						</div>
					</div>
					<div class="col-md-offset-0">
						</br>
						<button type="submit" name="buscar" value="buscar" class="btn btn-default">
							<img src="/images/buscar.png" title="BUSCAR">
						</button>
						<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
							<img src="/images/imprimir.png" title="imprimir">
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div class="col-md-12 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Cliente</div>

			<div class="panel-body">
				<a href="/validado/cliente/crear" class="btn btn-success" role="button">Crear Cliente</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>RUC ó DNI</th>
							<th>Razón Social</th>
							<th>Correo</th>
							<th>Dirección</th>
							<th>Departamento</th>
							<th>Ciudad</th>
							<th>Teléfono</th>
							<th>Contacto</th>
							<th>Teléfono de Contacto</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($entidades)>0)
					

					@foreach ($entidades as $entidad)
						<tr>
							<td>{{strtoupper($entidad->ent_ruc)}}</td>
							<td>{{strtoupper($entidad->ent_rz)}}</td>
							<td>{{$entidad->ent_correo}}</td>
							<td>{{strtoupper($entidad->ent_dir)}}</td>
							<td>{{strtoupper($entidad->ent_dpto)}}</td>
							<td>{{strtoupper($entidad->ent_ciu)}}</td>
							<td>{{strtoupper($entidad->ent_tel)}}</td>
							<td>{{strtoupper($entidad->ent_cont)}}</td>
							<td>{{strtoupper($entidad->ent_ctel)}}</td>
							<td><a href="/validado/cliente/editar?ent_id={{$entidad->ent_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/cliente/eliminar?ent_id={{$entidad->ent_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene clientes</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
