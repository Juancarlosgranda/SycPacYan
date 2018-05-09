@extends('app')
<script type="text/javascript">
	function getvaltipmon(sel)
	{	    
	    if(sel.value=="DOLAR")
	    {
	    	$('#moneda1').text("dólares");
	    	$('#moneda2').text("dólares");
	    	$('#moneda3').text("dólares");
	    	$('#moneda4').text("dólares");
	    }
	    else
	    {
	    	$('#moneda1').text("nuevos soles");
	    	$('#moneda2').text("nuevos soles");
	    	$('#moneda3').text("nuevos soles");
	    	$('#moneda4').text("nuevos soles");
	    	$('#tipcam').val("0.00");
	    }
	}

	function getcondicion(sel)
	{	    
	    if(sel.value=="AL CREDITO")
	    {
	    	//$('#comp_fven').prop('disabled', false);
	    	$('#comp_fpago').prop('disabled', true);
	    	$('#tipcam').prop('disabled', true);
	    	$('#comp_banco').prop('disabled', true);
	    	$('#comp_nope').prop('disabled', true);
	    }
	    else
	    {
	    	//$('#comp_fven').prop('disabled', true);
	    	$('#comp_fpago').prop('disabled', false);
	    	$('#tipcam').prop('disabled', false);
	    	$('#comp_banco').prop('disabled', false);
	    	$('#comp_nope').prop('disabled', false);
	    }
	}

</script>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Venta</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/npedido/asignar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="ocv_id" value="{{$ordencv->ocv_id}}" >
						<input type="hidden" name="comp_est" value="ACTIVO" >
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="comp_nro">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Cliente</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ent_id">
									@foreach ($entidades as $entidad)
										@if($entidad->ent_id == $ordencv->ent_id)
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
								   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="comp_fecha">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Guia de Remisión</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_guia">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nro. Nota Pedido</label>
							<div class="col-md-2">
								<input type="text" disabled="" class="form-control text-uppercase" name="comp_np"  value="{{$ordencv->ocv_nro}}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Vendedor</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="vend_id">
								   @foreach ($vendedores as $vendedor)
								   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Condición</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="comp_cond" onchange="getcondicion(this)">
										<option >AL CONTADO</option>
										<option >MUESTRA GRATUITA</option>
										<option >AL CREDITO</option>
										<option >Otro</option>
								</select>
							</div>
							<label class="col-md-6 control-label">Fecha Vencimiento</label>
							<div class="col-md-4">
								<input type="date" class="form-control text-uppercase" id="comp_fven" name="comp_fven">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="comp_moneda">
									@if($ordencv->ocv_moneda=='SOLES')
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
								<input type="date" class="form-control text-uppercase" name="comp_fpago" id="comp_fpago">
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="comp_tipcambio" value="{{$ordencv->ocv_tipcambio}}">Según fecha del depósito.
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Entidad Bancaria</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_banco" id="comp_banco">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nro. Operación</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_nope" id="comp_nope">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<textarea class="form-control text-uppercase" name="comp_obs" value="{{ old('comp_obs') }}"></textarea>
							</div>
						</div>
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">ASIGNAR</button>
								<a href="/validado/npedido" class="btn btn-danger" role="button">REGRESAR</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
