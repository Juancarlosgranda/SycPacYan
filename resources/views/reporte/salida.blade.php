<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VENTAS</title>
		<link href="/css/pdf1.css" rel="stylesheet">
	</head>
	<body onload="window.print()">
		<div>
			<table class="table">
						<tr>
							<th>Nro.</th>
							<th>Tipo</th>
							<th>Cliente</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Saldo</th>
							<th>Estado</th>
							<th>Condición</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>	
						</tr>

				@if(sizeof($comprobantes)>0)
					

					@foreach ($comprobantes as $comprobante)
						<tr>
							<td>{{$comprobante->comp_nro}}</td>
							<td>{{$comprobante->tipocomprobante->tcomp_desc}}</td>
							<td>{{$comprobante->entidad->ent_rz}}</td>
							<td>{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</td>
							<td>{{$comprobante->comp_guia}}</td>
							<td>{{number_format($comprobante->comp_subt,2,'.',',')}}</td>
							<td>{{number_format($comprobante->comp_igv,2,'.',',')}}</td>
							<td>{{number_format($comprobante->comp_tot,2,'.',',')}}</td>
							<td>{{number_format($comprobante->comp_saldo,2,'.',',')}}</td>
							<td>{{$comprobante->comp_est}}</td>
							<td>{{$comprobante->comp_cond}}</td>
							<td>{{$comprobante->comp_moneda}}</td>
							<td>{{$comprobante->comp_tipcambio}}</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene comprobantes</p>
					</div>
				@endif

				</table>

		</div>
  </body>
</html>