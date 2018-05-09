@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Conversión</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/conversion/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="conv_id" value="{{$conversion->conv_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">Unidad de Medida 1</label>
							<div class="col-md-6">
								<select name="um_id1">
									@foreach ($unidadmedidas as $unidadmedida)
										@if($unidadmedida->um_id == $conversion->um_id1)
											<option selected  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
										@else
											<option  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Factor de Conversión</label>
							<div class="col-md-6">
								<input type="text" class="form-control  text-uppercase" name="conv_fact" value="{{$conversion->conv_fact}}" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Unidad de Medida 2</label>
							<div class="col-md-6">
								<select name="um_id2">
									@foreach ($unidadmedidas as $unidadmedida)
										@if($unidadmedida->um_id == $conversion->um_id2)
											<option selected  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
										@else
											<option  value='{{$unidadmedida->um_id}}'>{{$unidadmedida->um_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/conversion" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
