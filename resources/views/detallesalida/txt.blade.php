<script type="text/javascript">
	function regresar()
	{
		window.location.href="/validado/detallesalida/regresar?comp_id={{$comprobante->comp_id}}" ;
	}
</script>
<!--onload="javascript:history.back()"-->
<body onload="regresar()">

<?php
//Creamos el archivo datos.txt
//ponemos tipo "a' para añadir lineas sin borrar

	if($comprobante->comp_correlativo>0)
	{
		$doc_corre=str_pad($comprobante->comp_correlativo,10, "0", STR_PAD_LEFT);
	}
	else
	{
		$doc_corre=str_pad(($nro_correlativo+1),10, "0", STR_PAD_LEFT);
		$comprobante->comp_correlativo=$nro_correlativo+1;
		$comprobante->save();
	}

	$fechaemision=date('ymd', strtotime($comprobante->comp_fecha));
	$tipocomp=$comprobante->tipocomprobante->tcomp_cod;
	$rucemisor="20447609674";
	$usuarioid=str_pad($comprobante->vend_id,8, "0", STR_PAD_LEFT);

	if($comprobante->comp_fven=="0000-00-00")
		$fechavenc='';
	else
		$fechavenc=date('ymd', strtotime($comprobante->comp_fven));

	if($comprobante->comp_moneda=='SOLES')
			$moneda='PEN';
	else
		$moneda='USD';

	$codiniserie="B";
	if($comprobante->tipocomprobante->tcomp_cod=="FA")
		$codiniserie="F";

	$totalbase=number_format($comprobante->comp_subt-$comprobante->comp_desc,2,'.','');
	$nro_serie=$codiniserie.substr($comprobante->comp_nro,0,strpos($comprobante->comp_nro, '-'));
	$nro_doc=substr($comprobante->comp_nro,strpos($comprobante->comp_nro, '-')+1,strlen($comprobante->comp_nro));
	$nro_doc=str_pad($nro_doc,8, "0", STR_PAD_LEFT);

	if(strlen($comprobante->entidad->ent_ruc)>8)
		$tipodoc_iden='06';
	else
		$tipodoc_iden='01';

	if($comprobante->comp_cond=="MUESTRA GRATUITA")
	{
		$trans_gratuita='01';
		$desc_global='01';
	}
	else
	{
		$trans_gratuita='00';
		$desc_global='00';
	}

	
	// NOMBRE ARCHIVO
	
	$nombre=$rucemisor."001"."DOC".$doc_corre.$fechaemision.$tipocomp;

	$file=fopen($nombre.".txt","w") or die("Problemas");

	//$comp_id_corre=str_pad($comprobante->comp_id,10, "0", STR_PAD_LEFT);

	//vamos añadiendo el contenido

	// CABECERA ARCHIVO

	$cabecera=$doc_corre."|".$tipocomp."|"."00"."|".$rucemisor."|".$comprobante->entidad->ent_ruc."|".$fechaemision."|".$fechavenc."|".$moneda."|".number_format($comprobante->comp_subt,2,'.','')."|".$comprobante->comp_desc."|".$totalbase."|"."0.00"."|".$comprobante->comp_igv."|"."0.00"."|"."0.00"."|".$comprobante->comp_tot."|"."0"."|"."NA"."|"."0000000000"."|".$nro_serie."|".$nro_doc."|".$usuarioid."|".$comprobante->comp_id."|".""."|".$tipodoc_iden."|"."01"."|"."NO"."|".""."|".""."|".$trans_gratuita."|".$desc_global."|"."00"."|"."00"."|"."00"."|";
	
	fputs($file,$cabecera);
	fputs($file,PHP_EOL);

	$detalle="";
	$cont=1;
	foreach($detallecomprobantes as $detallecomprobante)
	{
		$correlativo=str_pad($cont,10, "0", STR_PAD_LEFT);
		$uni_cod=$detallecomprobante->unidadproducto->unidadmedida->unidad->uni_cod;
		$prod_cod=$detallecomprobante->unidadproducto->producto->prod_cod;
		$prod_desc=$detallecomprobante->unidadproducto->producto->prod_desc;
		$imp_tot=$detallecomprobante->dcomp_cant*$detallecomprobante->dcomp_prec - $prod_desc;		

		if($detallecomprobante->unidadproducto->producto->prod_exo=='NO')
		{
			$prod_igv=number_format(($imp_tot - $imp_tot/1.18),2,'.','');
			$tipo_exo='GRAVADO';
		}
		else
		{
			$prod_igv="0.00";
			$tipo_exo='EXONERADO';
		}

		//$base_impo=number_format(($imp_tot-$prod_igv),2,'.','');
		$base_impo=number_format(($imp_tot),2,'.','');

		$detalle=$correlativo."|".$doc_corre."|"."BIEN"."|".$tipo_exo."|".$uni_cod."|".$prod_cod."|".$prod_desc."|".floatval($detallecomprobante->dcomp_cant)."|".number_format(($detallecomprobante->dcomp_prec),2,'.','')."|".$detallecomprobante->dcomp_desc."|".$base_impo."|".$prod_igv."|"."0.00"."|"."0"."|"."0.00"."|"."0.00"."|".number_format($imp_tot,2,'.','')."|"."00"."|";
		fputs($file,$detalle);
		fputs($file,PHP_EOL);
		$cont++;
	}

	$cliente="C"."|".$comprobante->entidad->ent_ruc."|".$comprobante->entidad->ent_rz."|".$comprobante->entidad->ent_dir."|".$comprobante->entidad->ent_tel."|".$comprobante->entidad->ent_correo."|"."PE"."|".$comprobante->entidad->ent_dpto."|".$comprobante->entidad->ent_ciu."|".$comprobante->entidad->ent_cont."|".$comprobante->entidad->ent_rz."|".$tipodoc_iden."|";
	
	fputs($file,$cliente);
	fputs($file,PHP_EOL);

	fclose($file);

?>

</body>