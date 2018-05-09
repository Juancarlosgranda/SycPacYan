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
							<th>RUC o DNI</th>
							<th>Razón Social</th>
							<th>Fecha</th>
							<th>Guía</th>
							<th>Subtotal</th>
							<th>IGV</th>
							<th>Total</th>
							<th>Moneda</th>
							<th>Tipo de Cambio</th>
							<th>Funcionario</th>
							<th>Tipo de Gasto</th>
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
							<td>{{$ieexterno->ie_subt}}</td>
							<td>{{$ieexterno->ie_igv}}</td>
							<td>{{$ieexterno->ie_tot}}</td>
							<td>{{$ieexterno->ie_moneda}}</td>
							<td>{{$ieexterno->ie_tipcambio}}</td>
							<td>{{$ieexterno->ie_funcionario}}</td>
							<td>{{$ieexterno->ie_tipgasto}}</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene registro de salidas</p>
					</div>
				@endif

				</table>

		</div>
  </body>
</html>