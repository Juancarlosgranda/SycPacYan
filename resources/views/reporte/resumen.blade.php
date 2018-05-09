

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>COMPRAS</title>
		<link href="/css/pdf1.css" rel="stylesheet">
	</head>
	<body onload="window.print()">
		<div>

			<table>
				<tr>
					<td>CONDICIÓN:		{{$filtro[0]}}</td>
					<td>MONEDA:		{{$filtro[1]}}</td>
					<td>FECHA INICIO:		{{$filtro[2]}}</td> 
					<td>FECHA FIN:		{{$filtro[3]}}</td>
					<td>T. COMPROBANTE:		{{$filtro[4]}}</td>
					<td>CLIENTE:		{{$filtro[5]}}</td> 
					<td>VENDEDOR:		{{$filtro[6]}}</td>
					<td>PRODUCTO:		{{$filtro[7]}}</td>
				</tr>
			</table>
			<table class="table">
					<tr>
						<th>PRODUCTO</th>
						<th>TOTAL COMPRAS</th>
						<th>TOTAL VENTAS</th>
						<th>RESUMEN</th>
					</tr>

			@if(sizeof($registros)>0)
				

				@foreach ($registros as $registro)
					<tr>
						<td style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[0],2,'.',',')}}</td>
						<td style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[1],2,'.',',')}}</td>
						<td style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[2],2,'.',',')}}</td>
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

