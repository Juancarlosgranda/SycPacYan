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
			<div class="panel-heading">Orden de Nota de Pedido</div>

			<div class="panel-body">
				<table class="table">
					<tr>
						<th>Nro.</th>
						<th>Proveedor</th>
						<th>Fecha</th>
						<th>Subtotal</th>
						<th>IGV</th>
						<th>Total</th>								
						
					</tr>
					<tr>
						<th>{{$ordencv->ocv_nro}}</th>
						<th>{{$ordencv->entidad->ent_rz}}</th>
						<th>{{date('d/m/Y', strtotime($ordencv->ocv_fecha))}}</th>
						<th>{{$moneda}} {{number_format($ordencv->ocv_subt,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($ordencv->ocv_igv,2,'.',',')}}</th>
						<th>{{$moneda}} {{number_format($ordencv->ocv_tot,2,'.',',')}}</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<a href="/validado/detallenpedido/crear?ocv_id={{$ordencv->ocv_id}}" class="btn btn-success" role="button">+</a>
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
				
				@if(sizeof($detalleordencvs)>0)
					

					@foreach ($detalleordencvs as $detalleordencv)
						<tr>
							<td>{{rtrim($detalleordencv->docv_cant,'.0')}}</td>
							<td>{{$detalleordencv->unidadproducto->unidadmedida->um_desc}}</td>
							<td>{{$detalleordencv->unidadproducto->producto->prod_desc}}</td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detalleordencv->docv_prec,2,'.',',')}}</div></td>
							<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detalleordencv->docv_cant*$detalleordencv->docv_prec,2,'.',',')}}</div></td>
							<td>
							<a href="/validado/detallenpedido/eliminar?docv_id={{$detalleordencv->docv_id}}" onclick="return confirm('Esta seguro que desea eliminar?')" class="btn btn-danger">Eliminar</a>
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

		<a href="/validado/npedido" class="btn btn-danger" role="button">Regresar</a>
	</div>
</div>
@endsection
