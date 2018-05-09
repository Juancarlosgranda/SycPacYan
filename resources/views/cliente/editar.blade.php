@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Cliente</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/cliente/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="ent_id" value="{{$entidad->ent_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">RUC ó DNI</label>
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
							<label class="col-md-4 control-label">Correo</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_correo" value="{{$entidad->ent_correo}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_dir" value="{{$entidad->ent_dir}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Departamento</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_dpto" value="{{$entidad->ent_dpto}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ciu" value="{{$entidad->ent_ciu}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Teléfono</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_tel" value="{{$entidad->ent_tel}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nombre de Contacto</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_cont" value="{{$entidad->ent_cont}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Teléfono de Contacto</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ctel" value="{{$entidad->ent_ctel}}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/cliente" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
