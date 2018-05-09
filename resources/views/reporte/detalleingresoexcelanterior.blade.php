<?php
	ob_start();
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	</head>
	<table border=\"1\" align=\"center\">
		<font size='6' color='#084B8A'><center>REPORTE DE COMPRAS</center></font>
					<tr bgcolor=\"#FDFEFE\"  align=\"center\"  height='40'>
						<th bgcolor='#1B4F72' width="3000px" ><font color="#FDFEFE"><strong>Nro.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Tipo</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>RUC o DNI</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>R. Social</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Fecha</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Subtotal</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>IGV</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Total</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Saldo</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Moneda</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>T. C.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Cant.</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Unidad</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>Producto</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>P. Unitario</strong></font></th>
						<th bgcolor='#1B4F72' ><font color="#FDFEFE"><strong>P. Total</strong></font></th>
					</tr>
			
			@if(sizeof($detallecomprobantes)>0)
				
				<?php  
					$flag=true;
					$nro_ant=0;
					$ruc_ant=0;
				?>

				@foreach ($detallecomprobantes as $detallecomprobante)
					<?php $flag=true; ?>
					@if($nro_ant==$detallecomprobante->comprobante->comp_nro && $ruc_ant==$detallecomprobante->comprobante->entidad->ent_ruc)
						<?php $flag=false; ?>
					@endif
					
					<?php 
						$nro_ant=$detallecomprobante->comprobante->comp_nro;
						$ruc_ant=$detallecomprobante->comprobante->entidad->ent_ruc;
						$nro_det=sizeof($detallecomprobantes->where('comp_id',$detallecomprobante->comprobante->comp_id));
					?>
					
					<tr>
						@if($flag)
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{$detallecomprobante->comprobante->comp_nro}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{substr($detallecomprobante->comprobante->tipocomprobante->tcomp_desc,0,3)}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{$detallecomprobante->comprobante->entidad->ent_ruc}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{$detallecomprobante->comprobante->entidad->ent_rz}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{date('d/m/Y', strtotime($detallecomprobante->comprobante->comp_fecha))}}</strong></td>

						<?php
							if($detallecomprobante->comprobante->comp_moneda=='SOLES'){?>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'S/.#,##0.00;-S/.#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_subt,2,'.',',')}}</strong></td>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'S/.#,##0.00;-S/.#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_igv,2,'.',',')}}</strong></td>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'S/.#,##0.00;-S/.#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_tot,2,'.',',')}}</strong></td>
							<?php 
							}else { ?>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_subt,2,'.',',')}}</strong></td>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_igv,2,'.',',')}}</strong></td>
								<td rowspan="{{$nro_det}}" style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_tot,2,'.',',')}}</strong></td>
						<?php }?>
						
						<td rowspan="{{$nro_det}}" style="mso-number-format:'[$$-en-US]#,##0.00';vertical-align: middle; text-align:right;"><strong>{{number_format($detallecomprobante->comprobante->comp_saldo,2,'.',',')}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{$detallecomprobante->comprobante->comp_moneda}}</strong></td>
						<td rowspan="{{$nro_det}}" style="vertical-align: middle; text-align:right;"><strong>{{$detallecomprobante->comprobante->comp_tipcambio}}</strong></td>
						@endif
						

						<td><strong>{{rtrim($detallecomprobante->dcomp_cant,'.0')}}</strong></td>
						<td><strong>{{$detallecomprobante->unidadproducto->unidadmedida->um_abrev}}</strong></td>
						<td><strong>{{$detallecomprobante->unidadproducto->producto->prod_desc}}</strong></td>

						<?php
							if($detallecomprobante->comprobante->comp_moneda=='SOLES'){?>
								<td style="mso-number-format:'S/.#,##0.00;-S/.#,##0.00';"><strong>{{number_format($detallecomprobante->dcomp_prec,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'S/.#,##0.00;-S/.#,##0.00';"><strong>{{number_format($detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec,2,'.',',')}}</strong></td>
							<?php 
							}else { ?>
								<td style="mso-number-format:'[$$-en-US]#,##0.00';"><strong>{{number_format($detallecomprobante->dcomp_prec,2,'.',',')}}</strong></td>
								<td style="mso-number-format:'[$$-en-US]#,##0.00';"><strong>{{number_format($detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec,2,'.',',')}}</strong></td>
						<?php }?>
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
	header("Content-Disposition: attachment; filename=Reporte Compras.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");   

	echo $reporte;  
?>