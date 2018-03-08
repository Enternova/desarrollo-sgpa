<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");

$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
$termino_p = arreglo_recibe_variables($termino);
$tipo_ter = $tipo_termino;

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));



  	 $sele_etx = "select  pro35_id, fecha_cierre from v_urna_extratiempo where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and estado_extratiempo = 1 order by estado_extratiempo ";
	$sql_ex_extra = traer_fila_row(query_db($sele_etx));



if ( ($sql_ex_extra[0]>=1) && ($sql_ex_extra[1] > $fecha ." ".$hora) ){
	$fecha_aerr_ext = explode(" ", $sql_e[17]);
	
$fecha = $fecha_aerr_ext[0];
$hora = $fecha_aerr_ext[1];

}



?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">

</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left" class="titulos_procesos">HISTORICO DE  OFERTA PARA EL CRITERIO</div></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
      <?=$sql_e[22];?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
    <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
  </tr>
  <tr>
    <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
    <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
      <?=listas_sin_select($tp2,$sql_e[2],1);?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
    <td ><strong>
      <?=listas_sin_select($tp3, $sql_e[3], 1);?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
    <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td ><strong>
      <?=$sql_e[12];?>
    </strong></td>
  </tr>
</table>
<br>
<?
	$suma_tamano = "select sum(evaluador6_tamano) from v_reportes_ofertas_enviadas where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." ";
	$sql_suma = traer_fila_row(query_db($suma_tamano));
	
	$taman_final_1 = ($sql_suma[0]/1024) / 1024;
	$taman_final = number_format($taman_final_1,2);

?>
<table width="95%" border="0">
  <tr>
    <td><p><span  class="texto_paginador_proveedor">NOTA IMPORTANTE: Capacidad para cargue de archivos hasta 200MB</span>, por favor tenga en cuenta que la totalidad de los anexos que compone su oferta t&eacute;cnica y econ&oacute;mica no deben superar las 200 MB, hasta el momento sus anexos tiene un tama&ntilde;o <span  class="texto_paginador_proveedor"> <?=$taman_final;?> MB de 200MB</span>, permitidos se recomienda:<br>
      <br>
    </p>
    <p>* Enviar los documentos indispensables</p>
    <p>* Puede enviar la oferta comprimida   en formatos .ZIP o .RAR</p></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="32" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Tipo</strong></div></td>
    <td width="153" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Nombre del Documento</strong></div></td>
    <td width="140" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Fecha</strong></div></td>
    <td width="526" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Observaciones</strong></div></td>
    <td width="99" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Acciones</strong></div></td>
  </tr>
  <?

if($tipo_ter==1){
$tipo_juri_tec=4;
$busca_juridico = "select count($t89.rel9_aspecto) from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 1 and
		$t5.pro1_id = $t91.in_id and 
		'".$fecha." ".$hora."' between $t5.apertura_juridica and $t5.cierre_juridica  ";
		$exs=traer_fila_row(query_db($busca_juridico));

if($exs[0]>=1){		
$nueva_oferta ="<table width='95%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td><div align='left' class='titulos_procesos'>ANEXAR NUEVA OFERTA PARA EL CRITERIO</div></td>
  </tr>
</table>
<table width='95%' border='0' cellpadding='3' cellspacing='3' class='tabla_borde_azul_fondo_blanco'>
  <tr>
    <td width='341'><div align='right'><strong>Busque el documento que anexara a la invitaci&oacute;n:</strong></div></td>
    <td width='285'><label>
      <input type='file' name='sube_archivo' id='fileField'>
    </label></td>
    <td width='342'><label></label></td>
  </tr>
  <tr>
    <td><div align='right'><strong>Observaciones:</strong></div></td>
    <td colspan='2'><label>
      <div align='left'>
        <textarea name='observaciones' id='textarea' cols='60' rows='5'></textarea>
      </div>
    </label></td>
  </tr>
</table>";

}

$nueva_oferta.="<table width='95%' border='0' cellpadding='2' cellspacing='2' class='tabla_borde_azul_fondo_blanco'>
  <tr>";
  
  if($exs[0]>=1){  
	$nueva_oferta.="<td width='50%'><div align='center'>
      <input name='Submit' type='button' class='buscar' value='".$lenguaje_3."' onClick='agrega_info_tecica()'>
    </div></td>";
	}
$nueva_oferta.="<td width='50%'><div align='center'>
      <input type='button' name='button' id='button' class='cancelar' value='".$lenguaje_4."' onClick='ajax_carga(\"invitacion_juridica_".$id_invitacion_pasa.".php\",\"contenidos\")'>    

    </div></td>
  </tr>
</table>";

		
		}

if($tipo_ter==2){
$tipo_juri_tec=5;
 $busca_tecnico = "select count($t89.rel9_aspecto) from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 2 and
		$t5.pro1_id = $t91.in_id and
		'".$fecha." ".$hora."' between $t5.apertura_tecnica  and $t5.cierre_tecnica  ";
		$exs_te=traer_fila_row(query_db($busca_tecnico));
if($exs_te[0]>=1){		
$nueva_oferta ="<table width='95%' border='0' cellspacing='2' cellpadding='2'>
  <tr>
    <td><div align='left' class='titulos_procesos'>ANEXAR NUEVA OFERTA PARA EL CRITERIO</div></td>
  </tr>
</table>
<table width='95%' border='0' cellpadding='3' cellspacing='3' class='tabla_borde_azul_fondo_blanco'>
  <tr>
    <td width='341'><div align='right'><strong>Busque el documento que anexara a la invitaci&oacute;n:</strong></div></td>
    <td width='285'><label>
      <input type='file' name='sube_archivo' id='fileField'>
    </label></td>
    <td width='342'><label></label></td>
  </tr>
  <tr>
    <td><div align='right'><strong>Observaciones de la oferta:</strong></div></td>
    <td colspan='2'><label>
      <div align='left'>
        <textarea name='observaciones' id='textarea' cols='60' rows='5'></textarea>
      </div>
    </label></td>
  </tr>
</table>";

}

$nueva_oferta.="<table width='95%' border='0' cellpadding='2' cellspacing='2' class='tabla_borde_azul_fondo_blanco'>
  <tr>";
  
  if($exs_te[0]>=1){  
	$nueva_oferta.="<td width='50%'><div align='center'>
      <input name='Submit' type='button' class='buscar' value='Enviar oferta para este criterio t&eacute;cnico' onClick='agrega_info_tecica()'>
    </div></td>";
	}
$nueva_oferta.="<td width='50%'><div align='center'>
      <input type='button' name='button' id='button' class='cancelar' value='Volver a los criterios t&eacute;cnicos' onClick='ajax_carga(\"invitacion_tecnica_".$id_invitacion_pasa.".php\",\"contenidos\")'>    

    </div></td>
  </tr>
</table>";


		
}  
  
  
			$busca_respo = query_db("select * from ".$t96." where pv_id = ".$_SESSION["id_proveedor"]." and evaluador1_id = $termino_p");
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[3]);
			if($ext!="")
				{
					$doocumento_tipo ="<img src='../imagenes/mime/".$ext.".gif' title='Tipo Documento'>";
					$nombre_documento = $lc[3];
					$boton_descraga="<a href='javascript:void(0)'> <img src='../imagenes/botones/nuevo_1.png' title='descargar Documento' onclick='javascript:window.parent.location.href=\"../librerias/php/descarga_documentos_juridicos_tecnicos.php?id_invitacion=$id_invitacion&tipo_juri_tec=$tipo_juri_tec&n1=".$lc[0]."&n2=".$lc[3]."\"'></a>";
				}
			else{
					$doocumento_tipo ="";
					$nombre_documento ="";
					$boton_descraga="";
			}
			
		?>
  <tr class="administrador_tabla_generales">
    <td><?=$doocumento_tipo;?></td>
    <td><div align="left">
      <?=$nombre_documento;?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($lc[7]);?>
    </div></td>
    <td><div align="left">
      <?=$lc[6];?>
    </div></td>
    <td> <?=$boton_descraga;?>
    <? if( ($tipo_ter==2) && ($exs_te[0]>=1) ) { ?>
    <a href="javascript:elimina_anexo_tecnico(<?=$lc[0];?>)"> <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Registro"></a>
    <? } if( ($tipo_ter==1) && ($exs[0]>=1) ) { ?>
       <a href="javascript:elimina_anexo_tecnico(<?=$lc[0];?>)"> <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Registro"></a>
<? } ?>
    </td>
  </tr>
  <? } ?>
</table>
<br>


<?



echo $nueva_oferta;

?>






<input type="hidden" name="id_anexo">

<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_invitacion"  value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="tipo_termino"  value="<?=$tipo_termino;?>">
</body>
</html>
