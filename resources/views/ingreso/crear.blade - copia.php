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
	    	$('#tipcam').prop('enable', true);
	    }
	    else
	    {
	    	$('#moneda1').text("nuevos soles");
	    	$('#moneda2').text("nuevos soles");
	    	$('#moneda3').text("nuevos soles");
	    	$('#moneda4').text("nuevos soles");
	    	$('#tipcam').val("0");
	    	$('#tipcam').prop('disabled', true);
	    }
	}
</script>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
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
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="comp_nro">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Proveedor</label>
							<div class="col-md-6">
								<select class="form-control" name="ent_id">
									@foreach ($entidades as $entidad)
									   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo</label>
							<div class="col-md-6">
								<select class="form-control" name="tcomp_id">
								   @foreach ($tipocomprobantes as $tipocomprobante)
								   		<option  value='{{$tipocomprobante->tcomp_id}}'>{{$tipocomprobante->tcomp_desc}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha</label>
							<div class="col-md-6">
								<input type="date" class="form-control" name="comp_fecha">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Estado</label>
							<div class="col-md-6">
								<select class="form-control" name="comp_est">
								   <option>Activo</option>
								   <option>Inactivo</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Condición</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="comp_cond">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control" name="comp_moneda" onchange="getvaltipmon(this)">
								   <option value="DOLAR">DOLÁR AMERICANO</option>
								   <option value="SOLES">SOLES</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Subtotal</label>							
							<div class="col-md-2">
								<input type="text" class="form-control" name="comp_subt">
							</div>
							<label id="moneda1" class="col-md-0 control-label">dólares</label>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">IGV</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="comp_igv">
							</div>
							<label id="moneda2" class="col-md-0 control-label">dólares</label>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Total</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="comp_tot">
							</div>
							<label id="moneda3" class="col-md-0 control-label">dólares</label>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Saldo</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="comp_saldo">
							</div>
							<label id="moneda4" class="col-md-0 control-label">dólares</label>
						</div>						
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control" name="comp_tipcambio">
							</div>
						</div>
						<div class="form-group">
				            <label class="col-md-4 control-label">Nuevo Archivo</label>
				            <div class="col-md-2">
				                <input type="file" class="form-control" name="comp_doc" >
				            </div>
				        </div>
				        
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear y Añadir Detalle
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
