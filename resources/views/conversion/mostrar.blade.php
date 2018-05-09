@extends('app')

@section('content')
@if (Session::has('error'))
	<div class="alert alert-danger">
		<strong>{{Session::get('error')}}</strong>
	</div>
@endif
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
			<div class="panel-heading">Conversión</div>

			<div class="panel-body">
				<a href="/validado/conversion/crear" class="btn btn-success" role="button">Crear Conversión</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>U. Medida 1</th>
							<th>Factor de Conversión</th>							
							<th>U. Medida 2</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($conversiones)>0)
					

					@foreach ($conversiones as $conversion)
						<tr>
							<td>{{$conversion->unidadmedida1->um_desc}}</td>
							<td>{{number_format($conversion->conv_fact,2,'.',',')}}</td>
							<td>{{$conversion->unidadmedida2->um_desc}}</td>
							<td><a href="/validado/conversion/editar?conv_id={{$conversion->conv_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/conversion/eliminar?conv_id={{$conversion->conv_id}}" onclick="
return confirm('Esta seguro que desea eliminar?')"
    class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene conversiones</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
