@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nueva Producto</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> Al parecer algo está mal.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="/validado/producto/crear">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Código</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="prod_cod">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Descripción</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="prod_desc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="prod_obs">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Exonerado de IGV</label>
							<div class="col-md-6">
								<input type="radio" checked="checked" class="radio-inline" name="prod_exo" value="SI">Sí
								<input type="radio" class="radio-inline" name="prod_exo" value="NO">No
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Categoría</label>
							<div class="col-md-6">
								<select name="cat_id" class="form-control text-uppercase">
									@foreach ($categorias as $categoria)
									   <option  value='{{$categoria->cat_id}}'>{{$categoria->cat_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">U. Medida en Inventario</label>
							<div class="col-md-6">
								<select name="um_id" class="form-control text-uppercase">
									@foreach ($unidadmedidas as $unidadmedida)
									   <option  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
