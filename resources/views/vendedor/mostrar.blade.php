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
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Vendedor</div>

			<div class="panel-body">
				<a href="/validado/vendedor/crear" class="btn btn-success" role="button">Crear Vendedor</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>RUC ó DNI</th>
							<th>Nombre</th>
							<th>Telefono</th>
							<th>Ciudad</th>
							<th>Departamento</th>
							<th>Correo</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($vendedores)>0)
					

					@foreach ($vendedores as $vendedor)
						<tr>
							<td>{{$vendedor->vend_id}}</td>
							<td>{{$vendedor->vend_dni}}</td>
							<td>{{$vendedor->vend_nom}}</td>
							<td>{{$vendedor->vend_tel}}</td>
							<td>{{$vendedor->vend_ciu}}</td>
							<td>{{$vendedor->vend_dpto}}</td>
							<td>{{$vendedor->vend_obs}}</td>
							<td><a href="/validado/vendedor/editar?vend_id={{$vendedor->vend_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/vendedor/eliminar?vend_id={{$vendedor->vend_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene vendedores</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
