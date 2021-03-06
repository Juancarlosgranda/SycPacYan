@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Unidad de Medida</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/unidadmedida/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="um_id" value="{{$unidadmedida->um_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">Unidad</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="uni_id">
									@foreach ($unidades as $unidad)
									   @if($unidad->uni_id == $unidadmedida->uni_id)
									   		<option selected value='{{$unidad->uni_id}}'>{{$unidad->uni_desc}}</option>
									   	@else
											<option  value='{{$unidad->uni_id}}'>{{$unidad->uni_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Descripción</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="um_desc" value="{{$unidadmedida->um_desc}}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Abreviatura</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="um_abrev" value="{{$unidadmedida->um_abrev}}" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/unidadmedida" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
