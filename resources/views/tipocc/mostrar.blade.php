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
			<div class="panel-heading">Centro de Costos</div>

			<div class="panel-body">
				<a href="/validado/tipocc/crear" class="btn btn-success" role="button">Crear</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Descripción</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($tipoccs)>0)
					

					@foreach ($tipoccs as $tipocc)
						<tr>
							<td>{{$tipocc->tcc_desc}}</td>
							<td><a href="/validado/tipocc/editar?tcc_id={{$tipocc->tcc_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/tipocc/eliminar?tcc_id={{$tipocc->tcc_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene tipoccs</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
