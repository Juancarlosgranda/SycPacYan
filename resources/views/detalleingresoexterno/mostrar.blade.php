@extends('app')

@section('content')
@if (Session::has('error'))
	<div class="alert alert-danger">
		{{Session::get('error')}}
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
						<th>RUC</th>
						<th>Razón Social</th>
						<th>Fecha</th>
						<th>Subtotal</th>
						<th>IGV</th>
						<th>Total</th>								
						
					</tr>
					<tr>
						<th>{{$ieexterno->ie_comp}}</th>
						<th>{{$ieexterno->ie_tcomp}}</th>
						<th>{{$ieexterno->ie_ruc}}</th>
						<th>{{$ieexterno->ie_rz}}</th>
						<th>{{date('d/m/Y', strtotime($ieexterno->ie_fecha))}}</th>
						<th>{{$moneda}} {{number_format($ieexterno->ie_subt,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($ieexterno->ie_igv,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($ieexterno->ie_tot,2,'.',',')}}</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<a href="/validado/detalleingresoexterno/crear?ie_id={{$ieexterno->ie_id}}" class="btn btn-success" role="button">+</a>
				<br/><br/>

				<table class="table">
						<tr>
							<th>Cantidad</th>
							<th>Descripción</th>
							<th width="130">Precio Unitario</th>
							<th width="130">Precio Total</th>
							<th>Acciones</th>
						</tr>
				
				@if(sizeof($detalleies)>0)
					

					@foreach ($detalleies as $detalleie)
						<tr>
							<td>{{floatval($detalleie->die_cant)}}</td>
							<td>{{$detalleie->die_desc}}</td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detalleie->die_prec,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detalleie->die_cant*$detalleie->die_prec,2,'.',',')}}</div></td>
							<td><a href="/validado/detalleingresoexterno/editar?die_id={{$detalleie->die_id}}" class="btn btn-primary" role="button">Editar</a>
							<a href="/validado/detalleingresoexterno/eliminar?die_id={{$detalleie->die_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
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

		<a href="/validado/ingresoexterno" class="btn btn-danger" role="button">Regresar</a>
	</div>
</div>
@endsection
