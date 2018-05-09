<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NOTAS DE PEDIDO</title>
		<link href="/css/pdf1.css" rel="stylesheet">
	</head>
	<body onload="window.print()">
		<div>
			<table class="table">
						<tr>
							<th>Nro.</th>
							<th>Proveedor</th>
							<th>Fecha</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Saldo</th>
							<th>Estado</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>	
						</tr>

				@if(sizeof($ordencvs)>0)
					

					@foreach ($ordencvs as $ordencv)
						<tr>
							<td>{{$ordencv->ocv_nro}}</td>
							<td>{{$ordencv->entidad->ent_rz}}</td>
							<td>{{date('d/m/Y', strtotime($ordencv->ocv_fecha))}}</td>
							<td>{{number_format($ordencv->ocv_subt,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_igv,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_tot,2,'.',',')}}</td>
							<td>{{number_format($ordencv->ocv_saldo,2,'.',',')}}</td>
							<td>{{$ordencv->ocv_est}}</td>
							<td>{{$ordencv->ocv_moneda}}</td>
							<td>{{$ordencv->ocv_tipcambio}}</td> 
							
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene Nota de Pedidos</p>
					</div>
				@endif

				</table>

		</div>
  </body>
</html>