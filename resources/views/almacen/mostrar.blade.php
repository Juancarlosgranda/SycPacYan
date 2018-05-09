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
			<div class="panel-heading">Almacen</div>

			<div class="panel-body">
				<a href="/validado/almacen/crear" class="btn btn-success" role="button">Crear Almacen</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($almacenes)>0)
					

					@foreach ($almacenes as $almacen)
						<tr>
							<td>{{$almacen->alm_id}}</td>
							<td>{{$almacen->alm_desc}}</td>
							<td><a href="/validado/almacen/editar?alm_id={{$almacen->alm_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/almacen/eliminar?alm_id={{$almacen->alm_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene almacenes</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
