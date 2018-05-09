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
			<div class="panel-heading">Unidad de Medida</div>

			<div class="panel-body">
				<a href="/validado/unidadmedida/crear" class="btn btn-success" role="button">Crear Unidad de Medida</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Abreviatura</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($unidadmedidas)>0)
					

					@foreach ($unidadmedidas as $unidadmedida)
						<tr>
							<td>{{$unidadmedida->um_id}}</td>
							<td>{{$unidadmedida->um_desc}}</td>
							<td>{{$unidadmedida->um_abrev}}</td>
							<td><a href="/validado/unidadmedida/editar?um_id={{$unidadmedida->um_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/unidadmedida/eliminar?um_id={{$unidadmedida->um_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene unidades</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
