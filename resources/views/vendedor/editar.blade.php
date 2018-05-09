@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Vendedor</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/vendedor/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="vend_id" value="{{$vendedor->vend_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">DNI</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase"  name="vend_dni" value="{{$vendedor->vend_dni}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nombre</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase"  name="vend_nom" value="{{$vendedor->vend_nom}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Telefono</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="vend_tel"  value="{{$vendedor->vend_tel}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase"  name="vend_ciu" value="{{$vendedor->vend_ciu}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Departamento</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase"  name="vend_dpto" value="{{$vendedor->vend_dpto}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Correo Electrónico</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase"  name="vend_obs" value="{{$vendedor->vend_obs}}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/vendedor" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
