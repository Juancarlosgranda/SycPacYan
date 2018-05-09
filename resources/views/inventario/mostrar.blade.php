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
	<div class="col-md-9 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Inventario</div>
			<div class="panel-body">
				<!--<a href="/validado/inventario/crear" class="btn btn-success" role="button">Crear Registro</a>-->
				<a href="/validado/inventario/actualizar" class="btn btn-success" role="button">Actualizar</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Unidad</th>
							<th>Última actualización</th>						
							<th>Acciones</th>						
						</tr>

				@if(sizeof($inventarios)>0)
					

					@foreach ($inventarios as $inventario)
						<tr>
							<td>{{$inventario->producto->prod_desc}}</td>
							<td style="text-align:right;">{{$inventario->inv_cant}}</td>
							<td>{{$inventario->producto->unidadmedida->um_desc}}</td>
							<td>{{date('d/m/Y', strtotime($inventario->inv_fecha))}}</td>
							<td><a href="/validado/inventario/editar?inv_id={{$inventario->inv_id}}" class="btn btn-primary" role="button">Editar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene inventarios</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>

	<div class="col-md-3 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Búsqueda</div>
			<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/validado/inventario">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-3 control-label">Producto</label>
							<div class="col-md-8 col-md-offset-1">
								<input type="text" class="form-control text-uppercase" name="prod_desc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Stock</label>
							<div class="col-md-8 col-md-offset-1">
								<input type="number" class="form-control text-uppercase" name="cant_min">
								<input type="number" class="form-control text-uppercase" name="cant_max">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Buscar
								</button>
							</div>
						</div>
					</form>
				</div>
		</div>
	</div>
</div>
@endsection
