@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Detalle de Orden de Compra</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/detalleocompra/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="docv_id" value="{{$detalleordencv->docv_id}}" >
						<input type="hidden" name="ocv_id" value="{{$detalleordencv->ocv_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">Cantidad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="docv_cant" value="{{$detalleordencv->docv_cant}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Unidad Medida</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="um_id">
									@foreach ($unidadmedidas as $unidadmedida)
										@if($unidadmedida->um_id == $detalleordencv->um_id)
									   		<option selected value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
									   	@else
											<option  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Producto</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="prod_id">
									@foreach ($productos as $producto)
										@if($producto->prod_id == $detalleordencv->prod_id)
									   		<option selected value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
									   	@else
											<option  value='{{$producto->prod_id}}'>{{$producto->prod_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Precio Unitario</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="docv_prec" value="{{$detalleordencv->docv_prec}}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/detalleocompra?ocv_id={{$detalleordencv->ocv_id}}" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
