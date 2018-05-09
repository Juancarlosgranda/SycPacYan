@extends('app')

@section('content')
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
	<div class="col-md-12 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Búsqueda</div>
			<div class="panel-body" style="font-size: 13px">
				<form class="form-inline" role="form" method="POST" action="/validado/salidaexterno">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group col-md-offset-0">
						<label>Nro</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_comp">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>RUC</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_ruc">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Razón Social</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_rz">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Guía de Remisión</label>
						<div>
							<input type="text" class="form-control text-uppercase" name="ie_guia">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Tipo</label>
						<div>
							<select class="form-control text-uppercase" name="ie_tcomp">
								<option  value=0>Elija Tipo</option>
								<option>BOLETA</option>
							   	<option>FACTURA</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Fecha</label>
						<div>
							<input type="date" class="form-control text-uppercase" name="ie_fecha_ini">
							<input type="date" class="form-control text-uppercase" name="ie_fecha_fin">
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Moneda</label>
						<div>
							<select class="form-control text-uppercase" name="ie_moneda">
								<option  value=0>Elija Moneda</option>
							  	<option value="DOLAR">DOLÁR AMERICANO</option>
								<option value="SOLES">SOLES</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-offset-0">
						<label>Vendedor</label>
						<div>
							<select class="form-control text-uppercase" name="vend_id">
								<option  value=0>Elija Funcionario</option>
							   @foreach ($vendedores as $vendedor)
							   		<option  value='{{$vendedor->vend_id}}'>{{$vendedor->vend_nom}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-offset-0">
						</br>
						<button type="submit" name="buscar" value="buscar" class="btn btn-default">
							<img src="/images/buscar.png" title="BUSCAR">
						</button>
						<button type="submit" name="imprimir" value="imprimir" class="btn btn-default">
							<img src="/images/imprimir.png" title="IMPRIMIR">
						</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-12 col-md-offset-0">
		<div class="panel panel-default">
			<div class="panel-heading">Gasto</div>

			<div class="panel-body">
				<a href="/validado/salidaexterno/crear" class="btn btn-success" role="button">Nueva Gasto</a>
				<br/><br/>
				<table class="table" style="font-size: 11px">
						<tr>
							<th>Nro.</th>
							<th>Tipo</th>
							<th>RUC o DNI</th>
							<th>Razón Social</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th><div style="display:inline; float:right">Subtotal</div></th>
							<th><div style="display:inline; float:right">IGV</div></th>
							<th><div style="display:inline; float:right">Total</div></th>
							<th>Moneda</th>
							<th>T. Cambio</th>
							<th>Funcionario</th>
							<th>T. Gasto</th>	
							<th>Acciones</th>	
						</tr>

				@if(sizeof($ieexternos)>0)
					

					@foreach ($ieexternos as $ieexterno)
						<tr>
							<td>{{$ieexterno->ie_comp}}</td>
							<td>{{$ieexterno->ie_tcomp}}</td>
							<td>{{$ieexterno->ie_ruc}}</td>
							<td>{{$ieexterno->ie_rz}}</td>
							<td>{{date('d/m/Y', strtotime($ieexterno->ie_fecha))}}</td>
							<td>{{$ieexterno->ie_guia}}</td>
							<td><div style="display:inline; float:right">{{$ieexterno->ie_subt}}</div></td>
							<td><div style="display:inline; float:right">{{$ieexterno->ie_igv}}</div></td>
							<td><div style="display:inline; float:right">{{$ieexterno->ie_tot}}</div></td>
							<td>{{$ieexterno->ie_moneda}}</td>
							<td>{{$ieexterno->ie_tipcambio}}</td>
							<td>{{$ieexterno->vendedor->vend_nom}}</td>
							<td>{{$ieexterno->ie_tipgasto}}</td>
							<td>
							<a href="/validado/detallesalidaexterno?ie_id={{$ieexterno->ie_id}}"><img src="/images/detalle.png"  title="VER DETALLE"></a>
							<a href="/validado/salidaexterno/editar?ie_id={{$ieexterno->ie_id}}"><img src="/images/editar.png" title="EDITAR"></a>
							<a href="/validado/salidaexterno/eliminar?ie_id={{$ieexterno->ie_id}}" onclick="return confirm('Esta seguro que desea eliminar?')"><img src="/images/eliminar.png" title="ELIMINAR"></a>
							</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene registro de salidas</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
@endsection
