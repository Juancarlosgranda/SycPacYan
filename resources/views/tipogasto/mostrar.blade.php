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
@if (Session::has('error'))
	<div class="alert alert-danger">
		{{Session::get('error')}}
	</div>
@endif
<div class="container-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">Tipo de Gasto</div>

			<div class="panel-body">
				<a href="/validado/tipogasto/crear" class="btn btn-success" role="button">Crear Tipo</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Descripción</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($tipogastos)>0)
					

					@foreach ($tipogastos as $tipogasto)
						<tr>
							<td>{{$tipogasto->tgasto_desc}}</td>
							<td><a href="/validado/tipogasto/editar?tgasto_id={{$tipogasto->tgasto_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/tipogasto/eliminar?tgasto_id={{$tipogasto->tgasto_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene tipogastos</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
