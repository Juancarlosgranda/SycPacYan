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
	<div class="col-md-9 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Producto</div>

			<div class="panel-body">
				<a href="/validado/producto/crear" class="btn btn-success" role="button">Crear Producto</a>
				<br/><br/>
				<table class="table">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Observaciones</th>
							<th>Exonerado</th>
							<th>U. Medida</th>
							<th>Familia</th>
							<th>Subfamilia</th>	
							<th>Acciones</th>						
						</tr>

				@if(sizeof($productos)>0)
					

					@foreach ($productos as $producto)
						<tr>
							<td>{{$producto->prod_cod}}</td>
							<td>{{$producto->prod_desc}}</td>
							<td>{{$producto->prod_obs}}</td>
							<td>{{$producto->prod_exo}}</td>
							<td>{{$producto->unidadmedida->um_desc}}</td>
							<td>{{$producto->categoria->familia->fam_desc}}</td>
							<td>{{$producto->categoria->cat_desc}}</td>
							<td><a href="/validado/producto/editar?prod_id={{$producto->prod_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/producto/eliminar?prod_id={{$producto->prod_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene productos</p>
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
					<form class="form-horizontal" role="form" method="POST" action="/validado/producto">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-3 control-label">Código</label>
							<div class="col-md-8 col-md-offset-1">
								<input type="text" class="form-control text-uppercase" name="prod_cod">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Descripción</label>
							<div class="col-md-8 col-md-offset-1">
								<input type="text" class="form-control text-uppercase" name="prod_desc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Exonerado</label>
							<div class="col-md-8 col-md-offset-1">
								<input type="radio" checked="checked" class="radio-inline" name="prod_exo" value="A">Ambos
								<input type="radio" class="radio-inline" name="prod_exo" value="SI">Sí
								<input type="radio" class="radio-inline" name="prod_exo" value="NO">No
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">Familia</label>
							<div class="col-md-8 col-md-offset-1">
								<select name="fam_id" class="form-control text-uppercase">
									<option  value=0>Elija Familia</option>
									@foreach ($familias as $familia)
									   <option  value='{{$familia->fam_id}}'>{{$familia->fam_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Categoría</label>
							<div class="col-md-8 col-md-offset-1">
								<select name="cat_id" class="form-control text-uppercase">
									<option  value=0>Elija Categoría</option>
									@foreach ($categorias as $categoria)
									   <option  value='{{$categoria->cat_id}}'>{{$categoria->cat_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Unidad</label>
							<div class="col-md-8 col-md-offset-1">
								<select name="um_id" class="form-control text-uppercase">
									<option  value=0>Elija Unidad</option>
									@foreach ($unidadmedidas as $unidadmedida)
									   <option  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-3 col-md-offset-2">
								<button type="submit" name="buscar" value="buscar" class="btn btn-default">
									<img src="/images/buscar.png" title="BUSCAR">
								</button>
							</div>
							<div class="col-md-3 col-md-offset-2">
								<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
									<img src="/images/imprimir.png" title="IMPRIMIR">
								</button>
							</div>
						</div>
					</form>
				</div>
		</div>
	</div>
	<div class="col-md-9 col-md-offset-0">
		<a href="/validado/producto" class="btn btn-danger" role="button">Regresar</a>
	</div>
</div>
@endsection
