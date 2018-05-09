@extends('app')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
      $(document).ready(function () {
          	$('#monto').keyup(function () {
             	var monto = $('#monto').val();
             	var comp_moneda = $('#comp_moneda').val();
             	var moneda = $('#moneda').val();
             	var pago_tipcambio = $('#pago_tipcambio').val();

		        if(moneda!=comp_moneda)
				{
					if(moneda=="DOLAR")
						$('#pago_monto').val((monto*pago_tipcambio).toFixed(2));
					else
						$('#pago_monto').val((monto/pago_tipcambio).toFixed(2));
				}
				else
				{
					$('#pago_monto').val((monto*1).toFixed(2));
				}

          	});
			
      });
</script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        /**
         * Funcion para añadir una nueva columna en la tabla
         */
        $("#add").click(function(){
            
            var nuevaFila="<tr>";
            var trs=$("#historial tr").length;
            nuevaFila+="<td><input type=text style='border-width: 0px' name=pago_fecha"+trs+" value="+$("#pago_fecha").val()+"></input></td>";
            nuevaFila+="<td><input type=text style='border-width: 0px' name=pago_banco"+trs+" value="+$("#pago_banco").val()+"></input></td>";
            nuevaFila+="<td><input type=text style='border-width: 0px' name=pago_nope"+trs+" value="+$("#pago_nope").val()+"></input></td>";
            nuevaFila+="<td><input type=text style='border-width: 0px' name=pago_tipcambio"+trs+" value="+$("#pago_tipcambio").val()+"></input></td>";
            nuevaFila+="<td><input type=text style='border-width: 0px' name=pago_monto"+trs+" value="+$("#pago_monto").val()+"></input></td>";
            nuevaFila+="</tr>";
            $("#historial").append(nuevaFila);
            trs=$("#historial tr").length;
            $('#nro_filas').val(trs);
            $('#cambio').val("SI");
        });
 
        /**
         * Funcion para eliminar la ultima columna de la tabla.
         * Si unicamente queda una columna, esta no sera eliminada
         */
        $("#del").click(function(){
            // Obtenemos el total de columnas (tr) del id "tabla"
            var trs=$("#historial tr").length;
            if(trs>1)
            {
                // Eliminamos la ultima columna
                $("#historial tr:last").remove();
            }

            trs=$("#historial tr").length;
            $('#nro_filas').val(trs);
            $('#cambio').val("SI");
        });
    });
 </script>
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
				<div class="panel-heading">Editar Venta</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/salida/editar">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="comp_id" value="{{$comprobante->comp_id}}" >
						<input type="hidden" name="comp_est" value="ACTIVO" >
						<input type="hidden" name="nro_filas" id="nro_filas" value="0" >
						<input type="hidden" name="cambio" id="cambio" value="NO" >
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
							<label class="col-md-4 control-label">Nro. Nota Pedido</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="comp_np"  value="{{$comprobante->comp_np}}">
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
								<select class="form-control text-uppercase" name="comp_cond" onchange="getcondicion(this)">
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
									@elseif($comprobante->comp_cond=='AL CREDITO')
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
								<label class="col-md-6 control-label">Fecha Vencimiento</label>
								<div class="col-md-6">
									<input type="date" class="form-control text-uppercase" id="comp_fven" name="comp_fven" value="{{$comprobante->comp_fven}}">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="comp_moneda" id="comp_moneda" value="">
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
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="comp_tipcambio" value="{{$comprobante->comp_tipcambio}}"><!--Según fecha del depósito.-->
							</div>
						</div>
						@if($comprobante->comp_fpago!="0000-00-00" || $comprobante->comp_banco!=null || $comprobante->comp_nope!=null)
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha de Pago o Depósito</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="comp_fpago" value="{{$comprobante->comp_fpago}}">
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
						@endif
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="comp_obs" value="{{$comprobante->comp_obs}}">
							</div>
						</div>
						</br>
						<div class="col-md-12 col-md-offset-0">
							<div class="panel panel-default">
								<div class="panel-body"><strong>HISTORIAL DE PAGOS </strong></br><strong>  -Monto Actual: </strong><div style="display:inline; float:right;">{{$comprobante->comp_tot}}</div></br><strong>  -Saldo Actual: </strong><div style="display:inline; float:right;">{{$comprobante->comp_saldo}}</div></div>

								<div class="panel-body">
									<table class="table" style="font-size: 11px">
											<tr>
												<th width="12%">Fecha</th>
												<th  width="12%">Entidad</th>
												<th  width="12%">Nro. de Operación</th>
												<th  width="12%">Moneda</th>
												<th  width="12%">Tipo de Cambio</th>
												<th  width="12%">Monto</th>												
												<th  width="12%"></th>	
												<th  width="6%"></th>	
												<th  width="6%"></th>				
											</tr>

											<tr>
												<td>
													<input type="date" class="form-control text-uppercase" id="pago_fecha" name="pago_fecha">
												</td>
												<td>
													<input type="text" class="form-control text-uppercase" id="pago_banco" name="pago_banco">
												</td>
												<td>
													<input type="text" class="form-control text-uppercase" id="pago_nope" name="pago_nope">
												</td>
												<td>
													<select class="form-control text-uppercase" name="moneda" id="moneda">
														   <option value="DOLAR">DOLÁR</option>
														   <option value="SOLES">SOLES</option>
														</select>
												</td>
												<td>
													<input type="text" class="form-control text-uppercase" name="pago_tipcambio"  id="pago_tipcambio">
												</td>
												<td>
													<input type="text" class="form-control text-uppercase" name="monto" id="monto">
												</td>
												<td>
													<input type="text" class="form-control text-uppercase" name="pago_monto" id="pago_monto">
												</td>
												<td>
												<input type="button" id="add" style="width: 100%; height: 100%; background-color: #5cb85c;border-width: 0px;font-size: 20px; color: #fff; font-style: bold" value="+" ></input>
												</td><td>
												<input type="button" id="del" style="width: 100%; height: 100%; background-color: #d9534f;border-width: 0px;font-size: 20px; color: #fff; font-style: bold" value="-"></input>
												</td>
											</tr>

									</table>

									<div class="panel-body">
										<table class="table" id="historial" name="historial" style="font-size: 11px">
												<tr>
													<th>Fecha</th>
													<th>Entidad</th>
													<th>Nro. de Operación</th>
													<th>Tip. Cambio</th>
													<th>Monto</th>						
												</tr>
												<?php $i=1;?>
												@foreach($comprobante->pagos as $pago)
													
													<tr>
													<td><input type="text" style="border-width: 0px;" name="pago_fecha{{$i}}" value="{{$pago->pago_fecha}}"/></td>
													<td><input type="text" style="border-width: 0px;" name="pago_banco{{$i}}" value="{{$pago->pago_banco}}"/></td>
													<td><input type="text" style="border-width: 0px;" name="pago_nope{{$i}}" value="{{$pago->pago_nope}}"/></td>		
													<td><input type="text" style="border-width: 0px;" name="pago_tipcambio{{$i}}" value="{{$pago->pago_tipcambio}}"/></td>
													<td><input type="text" style="border-width: 0px;" name="pago_monto{{$i}}" value="{{$pago->pago_monto}}"/></td>
													</tr>	
													<?php $i=$i+1;?>
												@endforeach
										</table>

									</div>

								</div>
							</div>
						</div>
						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Editar</button>
								<a href="/validado/salida" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
