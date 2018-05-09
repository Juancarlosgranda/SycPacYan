@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Entidad</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/entidad/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="conv_id" value="{{$entidad->ent_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">RUC</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ruc" value="{{$entidad->ent_ruc}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Razón Social</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_rz" value="{{$entidad->ent_rz}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_dir" value="{{$entidad->ent_dir}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ciu" value="{{$entidad->ent_ciu}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Entidad</label>
							<div class="col-md-6">
								<select name="tent_id" class="form-control text-uppercase">
									@foreach ($tipoentidades as $tipoentidad)
										@if($tipoentidad->tent_id == $entidad->tent_id)
											<option selected value='{{$tipoentidad->tent_id}}'>{{$tipoentidad->tent_desc}}</option>
										@else
											<option  value='{{$tipoentidad->tent_id}}'>{{$tipoentidad->tent_desc}}</option>
										@endif									   
									@endforeach
								</select>
							</div>
						</div>
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/entidad" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
