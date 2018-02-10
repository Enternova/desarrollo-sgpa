<? include("../../librerias/lib/@session.php"); 
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
//require("../../librerias/php/mail_pecc.php");../../librerias/php/mail_pecc.php
// echo $id_tipo_proceso_pecc;	
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));



$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<p>&nbsp;</p>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" bgcolor="#FFFFFF">
 
  <?
  $edicion_datos_generales = "SI";
         ?>
  <tr>
    <td align="right">Contrato  Relacionado:</td>
    <td colspan="3"><div id="contra_otro_si">
      <? if($edicion_datos_generales == "SI"){
        	
		$select_contra = traer_fila_row(query_db("select  id , razon_social, nit, numero_contrato, apellido, consecutivo,ano, vigencia_mes  from $v_contra1  where id = ".$sel_item[21]));
		
		$fecha_hoy = date("Y-m-d");
		$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";

			if($select_contra[7] <= $fecha_vence){
				$mensaje_alerta = " * Este Contrato esta Proximo a Vencer ".$select_contra[7]." * ";
				}
		
				$numero_contrato = numero_item_pecc_contrato("C",$select_contra[6],$select_contra[5], $select_contra[4], $select_contra[0]);
				
				$nombr_contrta = "-".$numero_contrato." Contratista: ".$select_contra[1]."----,".$select_contra[0]."----".$mensaje_alerta;
				
				if($select_contra[5]==""){
					
					$nombr_contrta="";
					}
					
					if($sel_item[43]==0 or $sel_item[6]==12){
						if($sel_item[6]==11 or $sel_item[6]==12){							
							$completa_auto="infomativo";
							}
							
				
						
						
		?>
      <table width="100%">
        <tr>
          <td width="56%"><input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista('<?=$completa_auto?>')" value="<?=$nombr_contrta?>"/></td>
          <td width="44%">&nbsp;</td>
        </tr>
      </table>
      <?
					}else{
						?>
      <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value=""/>
      <?
						}
		  }else{
			  
			  
			  $select_contra = traer_fila_row(query_db("select  id , razon_social, nit, numero_contrato, apellido, consecutivo,ano  from $v_contra1  where id = ".$sel_item[21]));
			  
			  
				$numero_contrato = numero_item_pecc_contrato("C",$select_contra[6],$select_contra[5], $select_contra[4], $select_contra[0]);
				if($sel_item[21]>0){
				echo $numero_contrato." Contratista: ".$select_contra[1];
				}else if($sel_item[52]>0){
					echo saca_nombre_lista("t1_proveedor",$sel_item[52],'razon_social','t1_proveedor_id',0);
					}else{
						echo "";
						}
				
				
			  ?>
      <input name="contratos_normales" type="hidden" id="contratos_normales" size="25" value="<?=$sel_item[21]?>"/>
      <?
			  }
	?>
    </div></td>
  </tr>
  <?
		 
      ?>
  <?
	  
      if( ($sel_item[14] >= 6 and $sel_item[14] <> 31)  and ($sel_item[6] == 7 or $sel_item[6] == 5 or $sel_item[6] == 15 or $sel_item[6] == 16 or $sel_item[6] == 6)){ 
	  ?>
  <tr>
    <td align="right">Antecedentes <img src="../imagenes/botones/help.gif" alt="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" title="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
    <td colspan="3"><?

?>
      <textarea name="antecedentes_texto" id="antecedentes_texto" cols="25" rows="4"><?=$sel_item_obs[13]?>
      </textarea>
      <br />
      Adjuntar antecedente:
      <input type="file" name="antecedente_anexo" id="antecedente_anexo" />
      <?

		$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /><strong>Antecedente Adjunto:</strong> ";
			  ?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&amp;n1=<?=$sl_anexos[0]?>&amp;n3=2" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /></a>
      <?
	 }
 
}else{
			echo $sel_item_obs[13];
			
			$sl_anexos = traer_fila_row(query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS text), adjunto, estado, id_us, antecedente_comite
 from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente' and antecedente_comite = 1"));
 
 if($sl_anexos[0]>0 and $sl_anexos[5] != " "){
	 echo " <br /> <strong>Antecedente Adjunto:</strong> ";
			  ?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&amp;n1=<?=$sl_anexos[0]?>&amp;n3=2" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /></a>
      <?
 }
			}
		?>
      <input type="hidden" name="con_anexo_antecedente" id="con_anexo_antecedente" value="<?=$sl_anexos[0]?>" /></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="3"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar " onclick="valida_graba_item_edita(1)" /></td>
  </tr>
  
</table>



<p>&nbsp;</p>
</body>
</html>
