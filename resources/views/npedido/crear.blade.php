@extends('app')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
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
<script type="text/javascript">
	$(setup)
	function setup() {
	    $('#intro select').zelect({ placeholder:'Selecciona Cliente...' })
	}
</script>

<style>
    	#hh { font-size: 16px; color: #1e1f19; background-color: #f3f3f3; padding: 10px 20px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
    #hh { color: #7A7A78; }
    #intro { margin-bottom: 8px; }
    #intro:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }

    #intro .zelect {
      display: inline-block;
      background-color: white;
      min-width: 300px;
      cursor: pointer;
      line-height: 36px;
      border: 1px solid #D0D0D0;
      border-radius: 6px;
      position: relative;
    }
    #intro .zelected {
      padding-left: 10px;
    }
    #intro .zelected.placeholder {
      color: #67737A;
    }
    #intro .zelected:hover {
      border-color: #99B8BF;
      box-shadow: inset 0px 5px 8px -6px #D0D0D0;
    }
    #intro .zelect.open {
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }
    #intro .dropdown {
      background-color: white;
      border-bottom-left-radius: 5px;
      border-bottom-right-radius: 5px;
      border: 1px solid #D0D0D0;
      border-top: none;
      position: absolute;
      left:-1px;
      right:-1px;
      top: 36px;
      z-index: 2;
      padding: 3px 5px 3px 3px;
    }
    #intro .dropdown input {
      font-family: sans-serif;
      outline: none;
      font-size: 14px;
      border-radius: 4px;
      border: 1px solid #D0D0D0;
      box-sizing: border-box;
      width: 100%;
      padding: 7px 0 7px 10px;
    }
    #intro .dropdown ol {
      padding: 0;
      margin: 3px 0 0 0;
      list-style-type: none;
      max-height: 150px;
      overflow-y: scroll;
    }
    #intro .dropdown li {
      padding-left: 10px;
    }
    #intro .dropdown li.current {
      background-color: #AFB6B7;
    }
    #intro .dropdown .no-results {
      margin-left: 10px;
    }
</style>
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nueva Nota de Pedido</div>
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

					<form class="form-horizontal" role="form" method="POST" action="/validado/npedido/crear" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="ocv_est" value="ACTIVO" >
						<div class="form-group">
							<label class="col-md-4 control-label">Nro</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ocv_nro">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Cliente</label>
							<div class="col-md-6">
								<section name="intro" id="intro" style="display: block;">
									<select name="ent_id" id="ent_id">
										@foreach ($entidades as $entidad)
										   <option  value='{{$entidad->ent_id}}'>{{$entidad->ent_rz}}</option>
										@endforeach
									</select>
								</section>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Fecha</label>
							<div class="col-md-6">
								<input type="date" class="form-control text-uppercase" name="ocv_fecha">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Dirección de Despacho</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ocv_dirdesp" id="ocv_dirdesp"  value="{{ old('ocv_dirdesp') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Localidad</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ocv_localidad" id="ocv_localidad"  value="{{ old('ocv_localidad') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Transporte</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ocv_transporte" id="ocv_transporte"  value="{{ old('ocv_transporte') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Moneda</label>
							<div class="col-md-6">
								<select class="form-control text-uppercase" name="ocv_moneda" onchange="getvaltipmon(this)">
								   <option value="DOLAR">DOLÁR AMERICANO</option>
								   <option value="SOLES">SOLES</option>
								</select>
							</div>
						</div>												
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Cambio</label>
							<div class="col-md-2">
								<input type="text" id="tipcam" class="form-control text-uppercase" name="ocv_tipcambio"> Según fecha del depósito.
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
							<label class="col-md-4 control-label">Entidad Bancaria</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_banco1" id="ocv_banco1"  value="{{ old('ocv_banco1') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nro. Operación</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_nroop1" id="ocv_nroop1"  value="{{ old('ocv_nroop1') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Monto</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_monto1" id="ocv_monto1"  value="{{ old('ocv_monto1') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Entidad Bancaria</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_banco2" id="ocv_banco2"  value="{{ old('ocv_banco2') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Nro. Operación</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_nroop2" id="ocv_nroop2"  value="{{ old('ocv_nroop2') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Monto</label>
							<div class="col-md-2">
								<input type="text" class="form-control text-uppercase" name="ocv_monto2" id="ocv_monto2"  value="{{ old('ocv_monto2') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observaciones</label>
							<div class="col-md-6">
								<input type="text" class="form-control text-uppercase" name="ocv_obs" value="{{ old('ocv_obs') }}">
							</div>
						</div>

						<div class="form-group">
				            <label class="col-md-4 control-label">Archivo</label>
				            <div class="col-md-2">
				                <input type="file" name="ocv_doc" >
				            </div>
				        </div>

						<input type="hidden" name="ocv_subt" value="0">
						<input type="hidden" name="ocv_igv" value="0">
						<input type="hidden" name="ocv_tot" value="0">
						<input type="hidden" name="ocv_saldo" value="0">
						<input type="hidden" name="ocv_cond" value="-">
						<input type="hidden" name="ocv_tipo" value="NPedido">

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Crear y Añadir Detalle
								</button>
								<a href="/validado/npedido" class="btn btn-danger" role="button">Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
