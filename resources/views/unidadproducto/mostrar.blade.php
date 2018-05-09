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
			<div class="panel-heading">Unidad de Medida por Producto</div>

			<div class="panel-body">
				<a href="/validado/unidadproducto/crear" class="btn btn-success" role="button">Crear Unidad de Medida por Producto</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Producto</th>
							<th>Unidad de Medida</th>
							<th>Acciones</th>
						</tr>

				@if(sizeof($unidadproductos)>0)
					

					@foreach ($unidadproductos as $unidadproducto)
						<tr>
							<td>{{$unidadproducto->producto->prod_desc}}</td>
							<td>{{$unidadproducto->unidadmedida->um_desc}}</td>
							<td><!--<a href="/validado/unidadproducto/editar?up_id={{$unidadproducto->up_id}}" class="btn btn-primary" role="button">Editar</a>-->
							<a href="/validado/unidadproducto/eliminar?up_id={{$unidadproducto->up_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
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
