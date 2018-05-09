@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Egreso</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/salidaexterno/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="ie_id" value="{{$ieexterno->ie_id}}" >
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_comp" value="{{$ieexterno->ie_comp}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">RUC</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_ruc" value="{{$ieexterno->ie_ruc}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Razon Social</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_rz" value="{{$ieexterno->ie_rz}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Funcionario</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="vend_id">
								   	@foreach ($vendedores as $vendedor)
										@if($vendedor->vend_id==$ieexterno->vend_id)
								   			<option selected="" value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
								   		@else
								   			<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
								   		@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Zona</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ie_zona" value="{{$ieexterno->ie_zona}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Centro de Costos</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tipocc">
								   @foreach ($tipoccs as $tipocc)
								   		@if($tipocc->tcc_desc==$ieexterno->ie_tipocc)
								   			<option selected="">{{$tipocc->tcc_desc}}</option>
								   		@else
								   			<option>{{$tipocc->tcc_desc}}</option>
								   		@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Gasto</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tipgasto">
									@foreach ($tipogastos as $tipogasto)
								   		@if($tipogasto->tgasto_desc==$ieexterno->ie_tipgasto)
								   			<option selected="">{{$tipogasto->tgasto_desc}}</option>
								   		@else
								   			<option>{{$tipogasto->tgasto_desc}}</option>
								   		@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Documento</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tcomp">
								   <option>BOLETA</option>
								   <option>FACTURA</option>
								   <option>TICKET</option>
								   <option>OTROS</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="ie_fecha" value="{{$ieexterno->ie_fecha}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Guia de Remisión</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ie_guia" value="{{$ieexterno->ie_guia}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_moneda" onchange="getvaltipmon(this)" value="{{$ieexterno->ie_moneda}}">
								   <option value="DOLAR">DOLÁR AMERICANO</option>
								   <option value="SOLES">SOLES</option>
								</select>
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="ie_tipcambio" value="{{$ieexterno->ie_tipcambio}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_obs" value="{{$ieexterno->ie_obs}}">
							</div>
						</div>
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/salidaexterno" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
