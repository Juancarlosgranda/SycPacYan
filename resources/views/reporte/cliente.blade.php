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
					<th>RUC ó DNI</th>
					<th>Razón Social</th>
					<th>Dirección</th>
					<th>Departamento</th>
					<th>Ciudad</th>
					<th>Teléfono</th>
					<th>Contacto</th>
					<th>Teléfono de Contacto</th>
				</tr>

				@if(sizeof($entidades)>0)
					

					@foreach ($entidades as $entidad)
						<tr>
							<td>{{$entidad->ent_ruc}}</td>
							<td>{{$entidad->ent_rz}}</td>
							<td>{{$entidad->ent_dir}}</td>
							<td>{{$entidad->ent_dpto}}</td>
							<td>{{$entidad->ent_ciu}}</td>
							<td>{{$entidad->ent_tel}}</td>
							<td>{{$entidad->ent_cont}}</td>
							<td>{{$entidad->ent_ctel}}</td>
						</tr>
					@endforeach

				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene clientes</p>
					</div>
				@endif

			</table>


		</div>
  </body>
</html>