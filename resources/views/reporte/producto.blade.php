<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>PRODUCTOS</title>
		<link href="/css/pdf1.css" rel="stylesheet">
	</head>
	<body onload="window.print()">
		<div>
			<table class="table">
						<tr>
							<th>Código</th>
							<th>Descripción</th>
							<th>Observaciones</th>
							<th>Exonerado</th>
							<th>U. Medida</th>
							<th>Familia</th>
							<th>Subfamilia</th>							
						</tr>

				@if(sizeof($productos)>0)
					

					@foreach ($productos as $producto)
						<tr>
							<td>{{$producto->prod_cod}}</td>
							<td>{{$producto->prod_desc}}</td>
							<td>{{$producto->prod_obs}}</td>
							<td>{{$producto->prod_exo}}</td>
							<td>{{$producto->unidadmedida->um_desc}}</td>
							<td>{{$producto->categoria->familia->fam_desc}}</td>
							<td>{{$producto->categoria->cat_desc}}</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene productos</p>
					</div>
				@endif

				</table>

		</div>
  </body>
</html>