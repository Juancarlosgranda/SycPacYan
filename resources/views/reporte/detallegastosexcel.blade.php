<?php
	ob_start();
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	</head>
	<table border=\"1\" align=\"center\">
		<font size='6' color='#084B8A'><center>REPORTE DE VENTAS</center></font>
					<tr bgcolor=\"#FDFEFE\"  align=\"center\"  height='40'>
						<th bgcolor='#1B4F72' width="3000px" ><font color="#FDFEFE"><strong>Nro.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Tipo</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>RUC o DNI</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>R. Social</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Zona</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Vendedor</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Fecha</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Subtotal</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>IGV</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Total</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Moneda</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>T. C.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>CC</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>T. Gasto</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Cant.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Descripción</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>P. Unitario</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>P. Total</strong></font></th>
					</tr>
			
			@if(sizeof($detalleieexternos)>0)
				
				@foreach ($detalleieexternos as $detalleieexterno)
					
					
					<tr>
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->ie_comp}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{substr($detalleieexterno->ieexterno->ie_tcomp,0,3)}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->ie_ruc}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->ie_rz}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->ie_zona}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->vendedor->vend_nom}}</strong></td>
						<td style="vertical-align: middle; text-align:left;"><strong>{{date('d/m/Y', strtotime($detalleieexterno->ieexterno->ie_fecha))}}</strong></td>

						<?php
							if($detalleieexterno->ieexterno->ie_moneda=='SOLES'){?>
								<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_subt,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_igv,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_tot,2,'.',',')}}</strong></td>
							<?php 
							}else { ?>
								<td style="mso-number-format:'#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_subt,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_igv,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detalleieexterno->ieexterno->ie_tot,2,'.',',')}}</strong></td>
						<?php }?>
						
						<td style="vertical-align: middle; text-align:left;"><strong>{{$detalleieexterno->ieexterno->ie_moneda}}</strong></td>
						<td style="vertical-align: middle; text-align:right;"><strong>{{$detalleieexterno->ieexterno->ie_tipcambio}}</strong></td>
						
						<td><strong>{{$detalleieexterno->ieexterno->ie_tipgasto}}</strong></td>
						<td><strong>{{$detalleieexterno->ieexterno->ie_tipocc}}</strong></td>
						<td><strong>{{floatval($detalleieexterno->die_cant)}}</strong></td>
						<td><strong>{{$detalleieexterno->die_desc}}</strong></td>

						<?php
							if($detalleieexterno->ieexterno->ie_moneda=='SOLES'){?>
								<td style="mso-number-format:'#,##0.00;-#,##0.00';"><strong>{{number_format($detalleieexterno->die_prec,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00;-#,##0.00';"><strong>{{number_format($detalleieexterno->die_cant*$detalleieexterno->die_prec,2,'.',',')}}</strong></td>
							<?php 
							}else { ?>
								<td style="mso-number-format:'#,##0.00';"><strong>{{number_format($detalleieexterno->die_prec,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'#,##0.00';"><strong>{{number_format($detalleieexterno->die_cant*$detalleieexterno->die_prec,2,'.',',')}}</strong></td>
						<?php }?>
					</tr>
				@endforeach

			@else
				<div class="alert alert-danger">
					<p>Al parecer no tiene gastos
					</p>
				</div>
			@endif

			</table>
</html>


<?php
	$reporte = ob_get_clean();
	header("Content-type: application/vnd.ms-excel");  
	header("Content-Disposition: attachment; filename=Reporte Gastos.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");   

	echo $reporte;  
?>