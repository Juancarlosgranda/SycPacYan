@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nuevo Proveedor</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/proveedor/crear">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">RUC</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ruc" value="{{ old('ent_ruc') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Razón Social</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_rz" value="{{ old('ent_rz') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Correo</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_correo" value="{{ old('ent_correo') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_dir" value="{{ old('ent_dir') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ciu" value="{{ old('ent_ciu') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Teléfono</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_tel" value="{{ old('ent_tel') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nombre de Contacto</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_cont" value="{{ old('ent_cont') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Teléfono de Contacto</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ent_ctel" value="{{ old('ent_ctel') }}">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear
								</button>
								<a href="/validado/proveedor" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
