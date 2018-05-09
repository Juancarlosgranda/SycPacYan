@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="panel panel-default">
				<div class="panel-heading">Nueva Compra</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/ingreso/crear">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
											
						<table class="table">
							<tr>
								<th>Nro.</th>
								<th>Tipo</th>
								<th>Entidad</th>
								<th>Fecha</th>
								<th>Subtotal</th>
								<th>IGV</th>
								<th>Total</th>								
								
							</tr>
							<tr>
								<th><input type="text" class="form-control" name="comp_nro"></th>
								<th>
									<select class="form-control" name="ent_id">
										@foreach ($entidades as $entidad)
										   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_desc}}</option>
										@endforeach
									</select>
								</th>
								<th>
									<select class="form-control" name="ent_id">
									@foreach ($entidades as $entidad)
									   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_desc}}</option>
									@endforeach
								</select>
								</th>
								<th><input type="date" class="form-control" name="comp_fecha"></th>
								<th><input type="text" class="form-control" name="comp_subt"></th>
								<th><input type="text" class="form-control" name="comp_igv"></th>
								<th><input type="text" class="form-control" name="comp_tot"></th>
							</tr>
						</table>

						<table class="table">
							<tr>
								<th>Saldo</th> 
								<th>Estado</th>
								<th>Condición</th>
								<th>Moneda</th>
								<th>Tipo de Cambio</th>
							</tr>
							<tr>
								<th>
									<select class="form-control" name="comp_est">
									   <option>Activo</option>
									   <option>Inactivo</option>
									</select>
								</th>
								<th><input type="text" class="form-control" name="comp_saldo"></th>
								<th><input type="text" class="form-control" name="comp_est"></th>
								<th><input type="text" class="form-control" name="comp_cond"></th>
								<th><input type="text" class="form-control" name="comp_moneda"></th>
								<th><input type="text" class="form-control" name="comp_tipcambio"></th>
							</tr>
						</table>

						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="comp_nro">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_dir">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_ciu">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_dir">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Ciudad</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="ent_ciu">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Proveedor</label>
							<div class="col-md-6">
								<select name="tent_id">
									@foreach ($entidades as $entidad)
									   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_desc}}</option>
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
