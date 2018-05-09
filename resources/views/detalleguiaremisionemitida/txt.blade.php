<script type="text/javascript">
	function regresar()
	{
		window.location.href="/validado/detalleguiaremisionemitida/regresar?comp_id={{$comprobante->comp_id}}" ;
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

	$fechaemision=date('Ymd', strtotime($comprobante->comp_fecha));
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

	$tipodocref=$comprobante_ref->tipocomprobante->tcomp_cod;
	$coddocref="B";
	$codiniserie="GR";
	if($tipodocref=="FA")
	{
		$coddocref="F";
		$codiniserie="GR";
	}

	$totalbase=number_format($comprobante->comp_subt-$comprobante->comp_desc,2,'.','');
	$nro_serie="G".substr($comprobante->comp_nro,0,strpos($comprobante->comp_nro, '-'));
	$nro_doc=substr($comprobante->comp_nro,strpos($comprobante->comp_nro, '-')+1,strlen($comprobante->comp_nro));
	$nro_doc=str_pad($nro_doc,8, "0", STR_PAD_LEFT);

	if(strlen($comprobante->entidad->ent_ruc)>8)
		$tipodoc_iden='06';
	else
		$tipodoc_iden='01';
	
	// NOMBRE ARCHIVO
	
	$nombre=$rucemisor."001"."DOC".$doc_corre.$fechaemision.$tipocomp;

	$file=fopen($nombre.".txt","w") or die("Problemas");

	$nrodocref=$coddocref.$comprobante_ref->comp_nro;

	//$comp_id_corre=str_pad($comprobante->comp_id,10, "0", STR_PAD_LEFT);

	//vamos añadiendo el contenido

	// CABECERA ARCHIVO

	$mtrasladocod=$comprobante->adicionalguia->motivotraslado->mtras_cod;
	$mtrasladodesc=$comprobante->adicionalguia->motivotraslado->mtras_desc;
	$pesobruto=$comprobante->adicionalguia->adig_pbruto;
	$unidadpbruto=strtoupper($comprobante->adicionalguia->unidad->uni_desc);
	$nrobultos=$comprobante->adicionalguia->adig_nbulto;
	$fechatrasl=date('Ymd', strtotime($comprobante->adicionalguia->adig_ftrasl));
	$doctrans=$comprobante->adicionalguia->adig_doctrans;
	$rztrans=$comprobante->adicionalguia->adig_rztrans;
	$nroplaca=$comprobante->adicionalguia->adig_nroplaca;
	$doccond=$comprobante->adicionalguia->adig_doccond;
	$coddptopart=$comprobante->adicionalguia->departamentopart->dpto_cod;
	$codprovpart=$comprobante->adicionalguia->provinciapart->prov_cod;
	$coddistpart=$comprobante->adicionalguia->distritopart->dist_cod;
	$direccionpart=$comprobante->adicionalguia->adig_dirpart;
	$coddptolleg=$comprobante->adicionalguia->departamentolleg->dpto_cod;
	$codprovlleg=$comprobante->adicionalguia->provincialleg->prov_cod;
	$coddistlleg=$comprobante->adicionalguia->distritolleg->dist_cod;
	$direccionlleg=$comprobante->adicionalguia->adig_dirlleg;
	$nrocontenedor=$comprobante->adicionalguia->adig_ncontenedor;
	$codpuerto=$comprobante->adicionalguia->adig_codpuerto;

	if($comprobante->adicionalguia->adig_transprog=="SI")
		$indtransbordo="1";
	else
		$indtransbordo="0";

	if($comprobante->adicionalguia->adig_mtrasl=="TRANSPORTE PUBLICO")
		$modtraslado="01";
	else
		$modtraslado="02";

	if($comprobante->adicionalguia->adig_tdoctrans=="RUC")
		$tipodoctrans='06';
	else
		$tipodoctrans='01';

	if($comprobante->adicionalguia->adig_tdoccond=="RUC")
		$tipodoccond='06';
	else
		$tipodoccond='01';

	$cabecera=$nro_serie."|".$nro_doc."|"."2.0"."|".$fechaemision."|".$tipocomp."|".$comprobante->comp_obs."|"."0000"."|".""."|".""."|".$nrodocref."|".$tipodocref."|".$rucemisor."|"."06"."|"."AGROIMPORT E.I.R.L"."|".$comprobante->entidad->ent_ruc."|".$tipodoc_iden."|".$comprobante->entidad->ent_rz."|".""."|".""."|".""."|".$mtrasladocod."|".$mtrasladodesc."|".$indtransbordo."|".$pesobruto."|".$unidadpbruto."|".$nrobultos."|".$modtraslado."|".$fechatrasl."|".$doctrans."|".$tipodoctrans."|".$rztrans."|".$nroplaca."|".$doccond."|".$tipodoccond."|"."PE"."|".$coddptolleg."|".$codprovlleg."|".$coddistlleg."|".$direccionlleg."|".$nrocontenedor."|"."PE"."|".$coddptopart."|".$codprovpart."|".$coddistpart."|".$direccionpart."|".$codpuerto."|";
	
	fputs($file,$cabecera);
	fputs($file,PHP_EOL);

	$detalle="";
	$cont=1;
	foreach($detallecomprobantes as $detallecomprobante)
	{
		$correlativo=str_pad($cont,4, "0", STR_PAD_LEFT);
		$uni_cod=$detallecomprobante->unidadproducto->unidadmedida->unidad->uni_desc;
		$prod_cod=$detallecomprobante->unidadproducto->producto->prod_cod;
		$prod_desc=$detallecomprobante->unidadproducto->producto->prod_desc;
		

		$detalle=$correlativo."|".floatval($detallecomprobante->dcomp_cant)."|".$uni_cod."|".$prod_desc."|".$prod_cod."|";
		fputs($file,$detalle);
		fputs($file,PHP_EOL);
		$cont++;
	}

	fclose($file);

?>

</body>