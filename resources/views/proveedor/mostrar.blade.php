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
			<div class="panel-heading">Proveedor</div>

			<div class="panel-body">
				<a href="/validado/proveedor/crear" class="btn btn-success" role="button">Crear Proveedor</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>RUC</th>
							<th>Razón Social</th>
							<th>Correo</th>
							<th>Dirección</th>
							<th>Ciudad</th>
							<th>Teléfono</th>
							<th>Contacto</th>
							<th>Teléfono de Contacto</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($entidades)>0)
					

					@foreach ($entidades as $entidad)
						<tr>
							<td>{{$entidad->ent_ruc}}</td>
							<td>{{$entidad->ent_rz}}</td>
							<td>{{$entidad->ent_correo}}</td>
							<td>{{$entidad->ent_dir}}</td>
							<td>{{$entidad->ent_ciu}}</td>
							<td>{{$entidad->ent_tel}}</td>
							<td>{{$entidad->ent_cont}}</td>
							<td>{{$entidad->ent_ctel}}</td>
							<td><a href="/validado/proveedor/editar?ent_id={{$entidad->ent_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/proveedor/eliminar?ent_id={{$entidad->ent_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene Proveedores</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
