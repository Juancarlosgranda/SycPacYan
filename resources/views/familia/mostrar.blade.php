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
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Familia</div>

			<div class="panel-body">
				<a href="/validado/familia/crear" class="btn btn-success" role="button">Crear Familia</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($familias)>0)
					

					@foreach ($familias as $familia)
						<tr>
							<td>{{$familia->fam_id}}</td>
							<td>{{$familia->fam_desc}}</td>
							<td><a href="/validado/familia/editar?fam_id={{$familia->fam_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/familia/eliminar?fam_id={{$familia->fam_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene familias</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
