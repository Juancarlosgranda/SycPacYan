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
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">Caja</div>
			
			<div class="panel-body">
				<label>Ventas</label>
				<table class="table">
						<tr>
							<th width="33%">Total Soles</th>
							<th width="33%">Total Doláres</th>
							<!--<th width="33%">Total</th>-->
						</tr>
						<tr>
							<td style="text-align: right;">S/. {{number_format($tot_ventas_soles,2,'.',',')}}</td>
							<td style="text-align: right;">$. {{number_format($tot_ventas_dolar,2,'.',',')}}</td>
							<!--<td style="text-align: right;">S/. {{number_format($tot_ventas,2,'.',',')}}</td>-->
						</tr>
					
				</table>
			</div>
			
			<div class="panel-body">
				<label>Compras</label>
				<table class="table">
						<tr>
							<th width="33%">Total Soles</th>
							<th width="33%">Total Doláres</th>
							<!--<th width="33%">Total</th>-->
						</tr>
						<tr>
							<td style="text-align: right;">S/. {{number_format($tot_compras_soles,2,'.',',')}}</td>
							<td style="text-align: right;">$. {{number_format($tot_compras_dolar,2,'.',',')}}</td>
							<!--<td style="text-align: right;">S/. {{number_format($tot_compras,2,'.',',')}}</td>-->
						</tr>
					
				</table>
			</div>

			<div class="panel-body">
				<label>Gastos</label>
				<table class="table">
						<tr>
							<th width="33%">Total Soles</th>
							<th width="33%">Total Doláres</th>
							<!--<th width="33%">Total</th>-->
						</tr>
						<tr>
							<td style="text-align: right;">S/. {{number_format($tot_egresos_soles,2,'.',',')}}</td>
							<td style="text-align: right;">$. {{number_format($tot_egresos_dolar,2,'.',',')}}</td>
							<!--<td style="text-align: right;">S/. {{number_format($tot_egresos,2,'.',',')}}</td>-->
						</tr>
					
				</table>
			</div>

			<div class="panel-body">
				<label>TOTAL BRUTO</label>
				<table class="table">
						<!--<tr>
							<th width="33%">TOTAL BRUTO</th>
							<th width="33%">S/. {{number_format($total,2,'.',',')}}</th>
						</tr>-->	
						<tr>
							<th width="33%" style="text-align: right;">S/. {{number_format(($tot_ventas_soles-$tot_compras_soles-$tot_egresos_soles),2,'.',',')}}</th>
							<th width="33%" style="text-align: right;">$. {{number_format(($tot_ventas_dolar-$tot_compras_dolar-$tot_egresos_dolar),2,'.',',')}}</th>
							<!--<th width="33%" style="text-align: right;">S/. {{number_format(($tot_ventas-$tot_compras-$tot_egresos),2,'.',',')}}
						</th>-->
						</tr>				
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
