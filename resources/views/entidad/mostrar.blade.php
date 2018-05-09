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
			<div class="panel-heading">Entidad</div>

			<div class="panel-body">
				<a href="/validado/entidad/crear" class="btn btn-success" role="button">Crear Entidad</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>RUC</th>
							<th>Razón Social</th>
							<th>Dirección</th>
							<th>Ciudad</th>
							<th>Tipo</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($entidades)>0)
					

					@foreach ($entidades as $entidad)
						<tr>
							<td>{{$entidad->conv_id}}</td>
							<td>{{$entidad->conv_fact}}</td>
							<td>{{$entidad->unidadmedida1->um_desc}}</td>
							<td>{{$entidad->unidadmedida2->um_desc}}</td>
							<td><a href="/validado/entidad/editar?conv_id={{$entidad->conv_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/entidad/eliminar?conv_id={{$entidad->conv_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene entidades</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
