<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td width="54%" valign="top"><div id="carga_anexos">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Lista de Documentos Generados</td>
              </tr>
            <tr>
              <td width="54%" align="center" class="fondo_3">Numero de Contrato</td>
              <td width="36%" align="center" class="fondo_3">Tipo</td>
              <td width="10%" align="center" class="fondo_3">Check</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select id, ano, consecutivo,apellido, t1_tipo_documento_id from v_contratos_general where id_item = '".$id_item_pecc."'");
  while($sl_cont = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
		  if($sl_cont[4] == 2){
			  $tipo = "Contrato Marco";
			  }else{
				  $tipo = "Contrato Normal";
				  }

  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=numero_item_pecc_contrato("C",$sl_cont[1],$sl_cont[2], $sl_cont[3], $sl_cont[0]);?></td>
              <td align="center" ><?=$tipo?></td>
              
              <td align="center" >
              <div id="oculta_botom">
              <?
              if(estado_contrato_retu(arreglo_pasa_variables($sl_cont[0]),$co1)=="Elaboraci&oacute;n de contrato"){
			  ?>
              <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar Fecha" onClick="graba_fecha_contrato_sol(1,'recibido_abastecimiento','<?=arreglo_pasa_variables($sl_cont[0]);?>','0')"/>
              
            <?
			  }else{
				echo estado_contrato_retu(arreglo_pasa_variables($sl_cont[0]),$co1); 
			}
			?>
            </div>            
            </td>
            </tr>
            <?
}
  ?>
  </table>
          <br>
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Lista de Modificaciones Generadas</td>
            </tr>
            <tr>
              <td width="54%" align="center" class="fondo_3">Numero de Contrato</td>
              <td width="36%" align="center" class="fondo_3">Tipo</td>
              <td width="10%" align="center" class="fondo_3">Check</td>
            </tr>
            <?
$cont = 0;
  $clase="";
  
  $sql = "select t1.id, t1.creacion_sistema, t1.consecutivo,t1.apellido, t2.tipo_complemento,t2.id as id_complemento 
from t7_contratos_contrato as t1, t7_contratos_complemento as t2 where t2.id_item_pecc = '".$id_item_pecc."' and t1.id = t2.id_contrato ";
  
//  $sql = "select t1.id, t1.ano, t1.consecutivo,t1.apellido, t2.tipo_complemento,t2.id as id_complemento from v_contratos_general as t1, t7_contratos_complemento as t2 where t2.id_item_pecc = '".$id_item_pecc."' and t1.id = t2.id_contrato";
  
  
//  echo $sql;
  $sele_anexos = query_db($sql);
  while($sl_cont = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
		  if($sl_cont[4] == 2){
			  $tipo = "Orden de Trabajo";
			  }else{
				  $tipo = "Otro Sí";
				  }


$separa_fecha_crea = explode("-",$sl_cont[1]);
					$ano_contra = substr($separa_fecha_crea[0], 2, 4);
					
					
  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=numero_item_pecc_contrato("C",$ano_contra,$sl_cont[2], $sl_cont[3], $sl_cont[0]);?> </td>
              <td align="center" ><?=$tipo?></td>
              <td align="center" >
              <div id="oculta_botom">
              <?
              if(estado_contrato_retu(arreglo_pasa_variables($sl_cont[5]),$co4)=="Elaboraci&oacute;n de contrato"){
			  ?>
              <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar Fecha" onClick="graba_fecha_contrato_sol(2,'recibido_abastecimiento','<?=arreglo_pasa_variables($sl_cont[0]);?>','<?=arreglo_pasa_variables($sl_cont[5]);?>')"/>
              
            <?
			  }else{
				echo estado_contrato_retu(arreglo_pasa_variables($sl_cont[5]),$co4); 
			}
			?>
            </div>
              </td>
            </tr>
            <?
}
  ?>
          </table>
          <p>&nbsp;</p>
          <? if($sel_item[14] == 20){?>
          <table width="100%" border="0" class="tabla_lista_resultados">
            <tr>
              <td colspan="2" class="sub_titulos_modulos_1">Finalizar esta solicitud y anular los documentos contractuales relacionados</td>
              </tr>
            <tr>
              <td width="50%" align="right">Observacion:</td>
              <td width="50%">
              <textarea name="anexo" id="anexo"></textarea></td>
            </tr>
            <tr>
              <td align="right">Adjunto:</td>
              <td><input type="file" name="adj_anexo" id="adj_anexo" /></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td><input type="button" class="boton_eliminar" onClick="graba_anexo_edicion(20)" value="Finalizar Solicitud y Anular los documentos Generados" /></td>
            </tr>
          </table>
          <? } ?>
          <p>&nbsp;</p>
        </div></td>
      </tr>
      
    </table></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>


<input name="campo_fecha" type="hidden" />
<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="0" />
<input name="id_complemento" type="hidden" value="0" />
<input name="recibido_abastecimiento" type="hidden" id="recibido_abastecimiento"/>
<input name="recibido_abastecimiento_e" type="hidden" id="recibido_abastecimiento_e" value="<?=date("Y-m-d")?>"/>
                            
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />

<input type="hidden" name="finaliza_solicitud_legal" id="finaliza_solicitud_legal" value="SI" />
</body>
</html>
