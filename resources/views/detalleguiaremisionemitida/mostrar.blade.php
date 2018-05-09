@extends('app')

@section('content')
@if (Session::has('error'))
	<div class="alert alert-danger">
		<strong>{{Session::get('error')}}</strong>
	</div>
@endif
@if (Session::has('creado'))
	<div class="alert alert-success">
		{{Session::get('creado')}}
	</div>
@endif
@if (Session::has('actualizado'))
	<div class="alert alert-success">
		{{Session::get('actualizado')}}
	</div>
@endif
@if (Session::has('eliminado'))
	<div class="alert alert-success">
		{{Session::get('eliminado')}}
	</div>
@endif

<script type="text/javascript">

	

	function borrarColumna()
	{
	  var fila;
	  fila=document.getElementById("tabla").getElementsByTagName('tr');
	  ultimaColumna=fila.length-1;
	  for(var i=0;ultimaColumna;i++)
	  {
	  	fila[i].getElementsByTagName('td')[5].style.display="none";
	  }
	}

	function deshabilitar()
	{
		var tcompinc_cod= <?php echo $comprobante->tipocomprobanteinc->tcompinc_cod; ?>

		if(tcompinc_cod=='1' || tcompinc_cod=='2' || tcompinc_cod=='6')
		{
			$('#crear').attr("disabled",true);
			$('#eliminar').attr("disabled",true);
			borrarColumna();
		}
		
	}



</script>

<body>
<div class="container-fluid">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">Comprobante</div>

			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Nro.</th>
						<th>Tipo</th>
						<th>RUC o DNI</th>
						<th>Cliente</th>
						<th>Fecha</th>							
						
					</tr>
					<tr>
						<th>{{$comprobante->comp_nro}}</th>
						<th>{{$comprobante->tipocomprobante->tcomp_desc}}</th>
						<th>{{$comprobante->entidad->ent_ruc}}</th>
						<th>{{$comprobante->entidad->ent_rz}}</th>
						<th>{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<a href="/validado/detalleguiaremisionemitida/crear?comp_id={{$comprobante->comp_id}}" id="crear" class="btn btn-success" role="button">+</a>
				<br/><br/>

				<table id="tabla" class="table">
						<tr>
							<td><strong>Cantidad</strong></td>
							<td><strong>Unidad</strong></td>
							<td><strong>Producto</strong></td>
							<td width="130"><strong>Peso Total</strong></td>
							<td><strong>Acciones</strong></td>
						</tr>
				
				@if(sizeof($detallecomprobantes)>0)
					

					@foreach ($detallecomprobantes as $detallecomprobante)
						<tr>
							<td>{{floatval($detallecomprobante->dcomp_cant)}}</td>
							<td>{{$detallecomprobante->unidadproducto->unidadmedida->um_desc}}</td>
							<td>{{$detallecomprobante->unidadproducto->producto->prod_desc}}</td>
							<td>{{floatval($detallecomprobante->dcomp_prec)}} {{$comprobante->adicionalguia->unidad->uni_desc}}</td>
							<td>
							<a id="eliminar" href="/validado/detalleguiaremisionemitida/eliminar?dcomp_id={{$detallecomprobante->dcomp_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a></td>
						</tr>
					@endforeach
					
				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene productos</p>
					</div>
				@endif

				</table>

			</div>
		</div>

		<!--<a href="/validado/detallesalida/imprimir?comp_id={{$comprobante->comp_id}}" class="btn btn-info" role="button">Imprimir</a>-->
		<a href="/validado/detalleguiaremisionemitida/generartxt?comp_id={{$comprobante->comp_id}}" class="btn btn-info" role="button">Generar Txt</a>
		<a style="float: right;" href="/validado/guiaremisionemitida" class="btn btn-danger" role="button">Regresar</a>
		
	</div>
</div>
</body>
@endsection
