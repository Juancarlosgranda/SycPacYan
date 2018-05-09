<?php
	ob_start();
?>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	</head>
	<table border=\"1\" align=\"center\">
		<font size='6' color='#084B8A'><center>REPORTE DE COMPRAS</center><font size='5' color=\"#ffffff\">
					<tr bgcolor=\"#ffffff\"  align=\"center\"  height='40'>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Nro.</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Tipo</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Proveedor</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Fecha</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Guia</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Subtotal</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>IGV</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Total</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Saldo</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Estado</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Condicion</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Moneda</strong></font></th>
						<th bgcolor='#ADB8C2' ><font size='5' color=\"#ffffff\"><strong>Tipo de Cambio</strong></font></th>
					</tr>

			@if(sizeof($comprobantes)>0)
				

				@foreach ($comprobantes as $comprobante)
					<tr>
						<td  align='center'><strong>{{$comprobante->comp_nro}}</strong></td>
						<td  align='center'><strong>{{$comprobante->tipocomprobante->tcomp_desc}}</strong></td>
						<td  align='center'><strong>{{$comprobante->entidad->ent_rz}}</strong></td>
						<td  align='center'><strong>{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</strong></td>
						<td  align='center'><strong>{{$comprobante->comp_guia}}</strong></td>
						<td  align='center'><strong>{{number_format($comprobante->comp_subt,2,'.',',')}}</strong></td>
						<td  align='center'><strong>{{number_format($comprobante->comp_igv,2,'.',',')}}</strong></td>
						<td  align='center'><strong>{{number_format($comprobante->comp_tot,2,'.',',')}}</strong></td>
						<td  align='center'><strong>{{number_format($comprobante->comp_saldo,2,'.',',')}}</strong></td>
						<td  align='center'><strong>{{$comprobante->comp_est}}</strong></td>
						<td  align='center'><strong>{{$comprobante->comp_cond}}</strong></td>
						<td  align='center'><strong>{{$comprobante->comp_moneda}}</strong></td>
						<td  align='center'><strong>{{$comprobante->comp_tipcambio}}</strong></td> 
					</tr>
				@endforeach

			@else
				<div class="alert alert-danger">
					<p>Al parecer no tiene comprobantes</p>
				</div>
			@endif

			</table>
</html>


<?php
	$reporte = ob_get_clean();
	header("Content-type: application/vnd.ms-excel");  
	header("Content-Disposition: attachment; filename=Reporte Compras.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");   

	echo $reporte;  
?>