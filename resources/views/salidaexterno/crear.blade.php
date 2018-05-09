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
</script>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nueva Gasto</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/salidaexterno/crear">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_comp">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">RUC o DNI</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_ruc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Razon Social</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_rz">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Funcionario</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="vend_id">
								   @foreach ($vendedores as $vendedor)
								   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Zona</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ie_zona">
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Gasto</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tipgasto">
								   <option>OFICINA</option>
								   <option>ADMINISTRATIVO</option>
								</select>
							</div>
						</div>-->
						<div class="form-group">
							<label class="col-md-4 control-label">Centro de Costos</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tipocc">
								   @foreach ($tipoccs as $tipocc)
								   		<option>{{$tipocc->tcc_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Gasto</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_tipgasto">
								   @foreach ($tipogastos as $tipogasto)
								   		<option>{{$tipogasto->tgasto_desc}}</option>
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
								<input type="date" class="form-control text-uppercase" name="ie_fecha">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Guia de Remisión</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ie_guia">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ie_moneda" onchange="getvaltipmon(this)">
								   <option value="DOLAR">DOLÁR AMERICANO</option>
								   <option value="SOLES">SOLES</option>
								</select>
							</div>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="ie_tipcambio">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ie_obs">
							</div>
						</div>

						<input type="hidden" name="ie_igv" value="0">
						<input type="hidden" name="ie_tot" value="0">
						<input type="hidden" name="ie_subt" value="0">

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear y Añadir Detalle
								</button>
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
