@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Compra</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/ingreso/editar" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="comp_id" value="{{$comprobante->comp_id}}" >
						<input type="hidden" name="vend_id" value="1" >
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="comp_nro" value="{{$comprobante->comp_nro}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Proveedor</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ent_id">
									@foreach ($entidades as $entidad)
										@if($entidad->ent_id == $comprobante->ent_id)
									   		<option selected value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
									   	@else
											<option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="tcomp_id">
									@foreach ($tipocomprobantes as $tipocomprobante)
										@if($tipocomprobante->tcomp_id == $comprobante->tcomp_id)
									   		<option selected value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
									   	@else
											<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="comp_fecha"  value="{{$comprobante->comp_fecha}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Guia de Remisión</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_guia" value="{{$comprobante->comp_guia}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Vendedor</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="vend_id">
									@foreach ($vendedores as $vendedor)
										@if($vendedor->vend_id == $comprobante->vend_id)
									   		<option selected value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
									   	@else
											<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Condición</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="comp_cond">
									@if($comprobante->comp_cond=='AL CONTADO')
										<option selected>AL CONTADO</option>
										<option >MUESTRA GRATUITA</option>
										<option >AL CREDITO</option>
										<option >Otro</option>
									@elseif($comprobante->comp_cond=='MUESTRA GRATUITA')
										<option >AL CONTADO</option>
										<option selected >MUESTRA GRATUITA</option>
										<option >AL CREDITO</option>
										<option >Otro</option>
									@elseif($comprobante->comp_cond=='CONCESION')
										<option >AL CONTADO</option>
										<option >MUESTRA GRATUITA</option>
										<option selected >AL CREDITO</option>
										<option >Otro</option>
									@else
								   		<option >AL CONTADO</option>
										<option >MUESTRA GRATUITA</option>
										<option >AL CREDITO</option>
										<option selected >Otro</option>
									@endif
								</select>	
							</div>
						</div>				
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="comp_moneda" value="">
									@if($comprobante->comp_moneda=='SOLES')
										<option selected value="SOLES">SOLES</option>
										<option value="DOLAR">DOLÁR AMERICANO</option>
									@else
								   		<option value="SOLES">SOLES</option>
										<option selected value="DOLAR">DOLÁR AMERICANO</option>
									@endif								   
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha de Pago o Depósito</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="comp_fpago" value="{{$comprobante->comp_fpago}}">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="comp_tipcambio" value="{{$comprobante->comp_tipcambio}}">Según fecha del depósito.
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Entidad Bancaria</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_banco" value="{{$comprobante->comp_banco}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nro. Operación</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_nope" value="{{$comprobante->comp_nope}}">
							</div>
						</div>
						<div class="form-group">
				            <label class="col-md-4 control-label">Archivo</label>
				            <div class="col-md-2">
				                <input type="file" name="comp_doc" >
				            </div>
				        </div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/ingreso" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
