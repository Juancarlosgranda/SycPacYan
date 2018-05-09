<div class="container-fluid">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">

			<div class="panel-body">
				<br/><br/><br/><br/>
				<br/><br/><br/><br/>
				<table class="table">
					<tr>
						<th width="50"></th>
						<th align="left">{{$comprobante->entidad->ent_rz}}</th>
					</tr>
					<tr>
						<th width="50"></th>
						<th align="left">{{$comprobante->entidad->ent_dir}}</th>
					</tr>
				</table>
				<table class="table">
					<tr>
						<th width="50"></th>
						<th align="left" width="300">{{$comprobante->entidad->ent_ruc}}</th>
						<th align="left">{{$comprobante->comp_guia}}</th>
					</tr>
					<tr>
						<th width="50"></th>
						<th align="left">{{date('d/m/Y', strtotime($comprobante->comp_fecha))}}</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<br/><br/>

				<table class="table">
				
				@if(sizeof($detallecomprobantes)>0)
					<?php $j=0;$i=0;?>

					@foreach ($detallecomprobantes as $detallecomprobante)
						<?php $j++;?>
						<tr>
							<td align="left" width="50">{{$detallecomprobante->dcomp_cant}}</td>
							<td align="left" width="50">{{$detallecomprobante->unidadproducto->unidadmedida->um_abrev}}</td>
							<td align="left" width="600">{{$detallecomprobante->unidadproducto->producto->prod_desc}}</td>
							<td align="left" width="70">{{$moneda}} {{number_format($detallecomprobante->dcomp_prec,2,'.',',')}}</td>
							<td align="left" width="80">{{$moneda}} {{number_format($detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec,2,'.',',')}}</td>
						</tr>
					@endforeach
				</table>
					@for($i=0;$i<=(14-$j);$i++)
						<br/>
					@endfor

				<table class="table">				
						<tr>
							<td width="770"></td>
							<td align="left">{{$moneda}} {{number_format($comprobante->comp_subt,2,'.',',')}}</td>
						</tr>
						<tr>
							<td width="770"></td>
							<td align="left">{{$moneda}} {{number_format($comprobante->comp_igv,2,'.',',')}}</td>
						</tr>
						<tr>
							<td width="770"></td>
							<td align="left">{{$moneda}} {{number_format($comprobante->comp_tot,2,'.',',')}}</td>
						</tr>
				@else
					<div class="alert alert-danger">
						<p>Al parecer no tiene productos</p>
					</div>
				@endif

				</table>

			</div>
		</div>
	</div>
</div>
