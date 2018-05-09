<?php
	ob_start();
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	</head>
	<table>

				<tr bgcolor="#E4E2E2" rowspan=9>
					<td><font size='4' color='#084B8A'><center>FILTROS:</center></font></td>
					<td></td><td></td><td></td>
				</tr>
				<tr bgcolor="#E4E2E2" rowspan=9>
					<td><strong>FECHA INICIO:</strong>		{{$filtro[0]}}</td> 
					<td><strong>FECHA FIN:</strong>		{{$filtro[1]}}</td>
				</tr>
				<tr bgcolor="#E4E2E2" rowspan=9>
					<td><strong>VENDEDOR:</strong>		{{$filtro[2]}}</td>
				</tr>
			</table>
	<table border=\"1\" align=\"center\">
		<font size='6' color='#084B8A'><center>RESUMEN</center></font>
					<tr bgcolor=\"#FDFEFE\"  align=\"center\"  height='40'>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Familia</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Producto</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Cant.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>U. Medida</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Prec. Compra</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Prec. Venta</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Tot. Compra</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Tot. Venta</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Margen($.)</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Margen(%)</strong></font></th>
					</tr>
			
			@if(sizeof($registros)>0)
				
				@foreach ($registros as $registro)
					
					<tr>
						<td style="vertical-align: middle; text-align:left;">{{$registro[0]}}</td>
						<td style="vertical-align: middle; text-align:left;">{{$registro[1]}}</td>
						<td style="vertical-align: middle; text-align:right;">{{$registro[2]}}</td>
						<td style="vertical-align: middle; text-align:center;">{{$registro[3]}}</td>
						<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[4],2,'.',',')}}</td>
						<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[5],2,'.',',')}}</td>
						<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[7],2,'.',',')}}</td>
						<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[8],2,'.',',')}}</td>
						<td style="mso-number-format:'#,##0.00;-#,##0.00';vertical-align: middle; text-align:right;">{{number_format($registro[6],2,'.',',')}}</td>
						<?php 
							if($registro[6]!=0)
								$margen=($registro[6]/$registro[8])*100;
							else
								$margen="0";
						?>
						<td style="vertical-align: middle; text-align:right;">{{$margen}}%</td>
					</tr>
				@endforeach

			@else
				<div class="alert alert-danger">
					<p>Al parecer no tiene detallecomprobantes</p>
				</div>
			@endif

			</table>
</html>


<?php
	$reporte = ob_get_clean();
	header("Content-type: application/vnd.ms-excel");  
	header("Content-Disposition: attachment; filename=Resumen.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");   

	echo $reporte;  
?>