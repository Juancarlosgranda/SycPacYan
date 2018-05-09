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
						<th>Proveedor</th>
						<th>Fecha</th>
						<th>Subtotal</th>
						<th>IGV</th>
						<th>Total</th>								
						
					</tr>
					<tr>
						<th>{{$comprobante->comp_nro}}</th>
						<th>{{$comprobante->tipocomprobante->tcomp_desc}}</th>
						<th>{{$comprobante->entidad->ent_ruc}}</th>
						<th>{{$comprobante->entidad->ent_rz}}</th>
						<th>{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</th>
						<th>{{$moneda}} {{number_format($comprobante->comp_subt,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($comprobante->comp_igv,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($comprobante->comp_tot,2,'.',',')}}</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<a href="/validado/detalleingreso/crear?comp_id={{$comprobante->comp_id}}" class="btn btn-success" role="button">+</a>
				<br/><br/>

				<table class="table">
						<tr>
							<th>Cantidad</th>
							<th>Unidad</th>
							<th>Producto</th>
							<th width="130">Precio Unitario</th>
							<th width="130">Precio Total</th>
							<th>Acciones</th>
						</tr>
				
				@if(sizeof($detallecomprobantes)>0)
					

					@foreach ($detallecomprobantes as $detallecomprobante)
						<tr>
							<td>{{floatval($detallecomprobante->dcomp_cant)}}</td>
							<td>{{$detallecomprobante->unidadproducto->unidadmedida->um_desc}}</td>
							<td>{{$detallecomprobante->unidadproducto->producto->prod_desc}}</td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detallecomprobante->dcomp_prec,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec,2,'.',',')}}</div></td>
							<td>
							<a href="/validado/detalleingreso/eliminar?dcomp_id={{$detallecomprobante->dcomp_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
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

		<a href="/validado/ingreso" class="btn btn-danger" role="button">Regresar</a>
		
	</div>
</div>
@endsection
