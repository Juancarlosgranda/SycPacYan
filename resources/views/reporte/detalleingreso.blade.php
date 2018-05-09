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
			<table class="table">
					<tr>
						<th>Nro.</th>
						<th>Tipo</th>
						<th>RUC o DNI</th>
						<th>Proveedor</th>
						<th>Fecha</th>
						<th>Subtotal</th>
						<th>IGV</th>
						<th>Total</th>
						<th>Saldo</th>
						<th>Moneda</th>
						<th>T. C.</th>
						<th>Cantidad</th>
						<th>Unidad</th>
						<th>Producto</th>
						<th width="130">P. Unitario</th>
						<th width="130">P. Total</th>
					</tr>

			@if(sizeof($detallecomprobantes)>0)
				

				@foreach ($detallecomprobantes as $detallecomprobante)
					<tr>
						<td>{{$detallecomprobante->comprobante->comp_nro}}</td>
						<td>{{$detallecomprobante->comprobante->tipocomprobante->tcomp_desc}}</td>
						<td>{{$detallecomprobante->comprobante->entidad->ent_ruc}}</td>
						<td>{{$detallecomprobante->comprobante->entidad->ent_rz}}</td>
						<td>{{date('d/m/Y', strtotime($detallecomprobante->comprobante->comp_fecha))}}</td>
						<td>{{number_format($detallecomprobante->comprobante->comp_subt,2,'.',',')}}</td>
						<td>{{number_format($detallecomprobante->comprobante->comp_igv,2,'.',',')}}</td>
						<td>{{number_format($detallecomprobante->comprobante->comp_tot,2,'.',',')}}</td>
						<td>{{number_format($detallecomprobante->comprobante->comp_saldo,2,'.',',')}}</td>
						<td>{{$detallecomprobante->comprobante->comp_moneda}}</td>
						<td>{{$detallecomprobante->comprobante->comp_tipcambio}}</td>

						<?php
							$moneda=0;
							if($detallecomprobante->comprobante->comp_moneda=='SOLES')
								$moneda='S/. ';
							else
								$moneda='$. ';
						?>

						<td>{{rtrim($detallecomprobante->dcomp_cant,'.0')}}</td>
						<td>{{$detallecomprobante->unidadproducto->unidadmedida->um_abrev}}</td>
						<td>{{$detallecomprobante->unidadproducto->producto->prod_desc}}</td>
						<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detallecomprobante->dcomp_prec,2,'.',',')}}</div></td>
						<td><div style="display:inline; float:left">{{$moneda}}</div><div style="display:inline; float:right">{{number_format($detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec,2,'.',',')}}</div></td>
					</tr>
				@endforeach

			@else
				<div class="alert alert-danger">
					<p>Al parecer no tiene detallecomprobantes</p>
				</div>
			@endif

			</table>

		</div>
  </body>
</html>