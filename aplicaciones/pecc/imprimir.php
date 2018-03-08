<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_POST["id_tipo_proceso_pecc"]));

	$sel_item_num = traer_fila_row(query_db("select num1,num2,num3 from $pi2 where id_item=".$id_item_pecc));


header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=Solicitud_".numero_item_pecc($sel_item_num[0],$sel_item_num[1],$sel_item_num[2]).".doc");
header("Pragma: no-cache");
header("Expires: 0");
	
	
	

// echo $id_tipo_proceso_pecc;	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	/*** PARA EL DES002-18 ***/
	$fecha_creacion=$sel_item[22];
	$fecha_creacion=explode('-',$fecha_creacion);
	if($fecha_creacion[0]>=2017){
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	/*** FIN PARA EL DES002-18 ***/
	$sel_pecc = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	
	$edicion_datos_generales = "NO";
	$tiene_rol_profesional == "NO";
	
	
		
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?>
      
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr >
        <td width="41%" align="right">Gerente del ITEM:</td>
        <td width="30%"><? echo traer_nombre_muestra($sel_item[3], $g1,"nombre_administrador","us_id")?></td>
        <td width="29%" align="center">Fecha de Creaci&oacute;n:
          <?=$sel_item[22]?></td>
        </tr>
      <?
        if($sel_item[1] != 1){
		?>
      <tr >
        <td align="right">PECC</td>
        <td>
          <?
       
			echo saca_nombre_lista($pi1,$sel_item[1],'nombre','id_pecc');
			
	   ?>
          </td>
        <td align="right">&nbsp;</td>
        </tr>
      <?
        }else{
	?><input type="hidden" name="id_pecc_seleccion" id="id_pecc_seleccion" value="1" /><?
	}
		
		
		?>
      
      <tr >
        <td align="right">Profesional de C&amp;C:</td>
        <td colspan="2">
          <?
       
			echo saca_nombre_lista($g1,$sel_item[23],'nombre_administrador','us_id');
			
		?>
          </td>
        </tr>
      
      
      <?
        	if (($sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 7) and $es_profesional_designado == "SI"){
		?>
      <tr>
        <td align="right">Requiere Aprobaci&oacute;n Sondeo:</td>
        <td colspan="2">
          <?
        
			if($sel_item[25] == 2) echo "NO";
			if($sel_item[25] == 1) echo "SI";
		
		  ?>
          </td>
        </tr>
      <?
			}
        	if ($sel_item[6] == 8 and $es_profesional_designado == "SI"){
		?>
      <tr>
        <td align="right">Requiere Aprobaci&oacute;n Extra de Comit&eacute;:</td>
        <td colspan="2">
          <?
        
			if($sel_item[24] == 2) echo "NO";
			if($sel_item[24] == 1) echo "SI";
		
		  ?>
          </td>
        </tr>
      <?
			}
	  ?>
      <tr>
        <td align="right">Tipo de Proceso:</td>
        <td colspan="2">
          
          <?
        
				echo saca_nombre_lista($g13,$sel_item[6],'nombre','t1_tipo_proceso_id');
			
		?>  
          </td>
        </tr>
      <?
      if(($sel_item[6] == 4 or $sel_item[6] == 5)){
	  ?>
      <tr>
        <td align="right">Contrato del Otro S&iacute;:</td>
        <td colspan="2">
          <? 
				
				echo $select_contra[3]." Contratista: ".$select_contra[1];
			  
	?>
</td>
        </tr>
     <?
	  }
	 ?>
      <tr>
        <td align="right">Area Usuaria:</td>
        <td colspan="2">
          <?

		echo saca_nombre_lista($g12,$sel_item[5],'nombre','t1_area_id');
	
  ?>      
          </td>
        </tr>
      <tr>
        <td align="right">Fecha en la que se Requiere el Servicio:</td>
        <td colspan="2">
          <?

		echo $sel_item[7];
	
?>
  </td>
        </tr>
      <tr>
        <td align="right">Objeto de la Solicitud:</td>
        <td colspan="2">
          <?

		echo $sel_item[8];
	
		?>
          </td>
        </tr>
      <tr>
        <td align="right">Objeto del Contrato:</td>
        <td colspan="2">
          <?
        	
				echo $sel_item[9];
				
		?>
          </td>
        </tr>
      <tr>
        <td align="right">Alcance:</td>
        <td colspan="2">
          <?
        	
				echo $sel_item[10];
			
		?>
          </td>
        </tr>
      <tr>
        <td align="right">Justificaci&oacute;n :</td>
        <td colspan="2">
          <?

			echo $sel_item[12];
	
		?>
          </td>
        </tr>
      <tr>
        <td align="right">Recomendaci&oacute;n:</td>
        <td colspan="2">
          <?

	echo $sel_item[13];

		?>
          </td>
        </tr>
    </table></td>
  </tr>
  <?
  if ($sel_item[6] != 6 and $sel_item[6] != 7 and $sel_item[6] != 8){//IMPRIMME ASIGNACION PRESUPUESTAL
  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
  ?>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  
  <tr>
    <td colspan="5" align="center"  class="fondo_3">Lista de Valores</td>
    </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td width="16%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
    <td width="19%" align="center" class="fondo_3">Valor USD$</td>
    <td width="19%" align="center" class="fondo_3">Valor COP$</td>
    </tr>
  <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
  <tr class="<?=$clase?>">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					echo "* ".numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)."<br />";
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    </tr>
  <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table></td>
  </tr>
  <?
  }
  ?>
  <?
  if ($sel_item[6] != 6 and $sel_item[6] != 7 and $sel_item[6] != 8){//IMPRIMME PROVEEDORES
  ?>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Lista de Proveedores Propuestos por el Profesional de C&amp;C</td>
        </tr>
      <tr>
        <td width="21%" align="center" class="fondo_3">Registrado en Par Servicios</td>
        <td width="45%" align="center" class="fondo_3">Nombre</td>
        <td width="34%" align="center"  class="fondo_3">Nit</td>
        </tr>
      <?
						
            $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado from $pi13 as t1, $g6 as t2 where t1.id_item = $id_item_pecc and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1");
			while($se_prove = traer_fila_db($sel_proveedores)){
				
				if($se_prove[4] == 1){
					$estado_muestra = "SI";
					}else{
						$estado_muestra = "NO";
						}
			?>
      <tr>
        <td align="center"><?=$estado_muestra?></td>
        <td align="center"><?=$se_prove[1]?></td>
        <td align="center"><?=$se_prove[2]."-".$se_prove[3]?></td>
        </tr>
      <?
            }
			?>
    </table></td>
  </tr>
  <?
  }
  ?>
  <?
  if ($sel_item[25] == 1){//IMPRIMME sondeo
  ?>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="2" align="center"  class="fondo_3">Lista de Documentaci&oacute;n B&aacute;sica del Sondeo</td>
        </tr>
      <tr>
        <td width="54%" align="center" class="fondo_3">Detalle de los Documentos</td>
        <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
        </tr>
      <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'basicosondeo'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
      <tr class="<?=$clase?>">
        <td align="center" ><?=$sl_anexos[4]?></td>
        <td align="center" ><?=saca_nombre_anexo($sl_anexos[5])?>
          <a href="../documentos_peec/<?=$sl_anexos[5]?>" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /> </a></td>
        </tr>
      <?
        }//SI HAY DOCUMENTACION BASICA
		?>
    </table>
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr>
          <td colspan="2" align="center"  class="fondo_3">Lista de Documentaci&oacute;n de Ensamble de la Negociaci&oacute;n</td>
        </tr>
        <tr>
          <td width="54%" align="center" class="fondo_3">Detalle de los Documentos</td>
          <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
        </tr>
        <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'ensamblesondeo'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
        <tr class="<?=$clase?>">
          <td align="center" ><?=$sl_anexos[4]?></td>
          <td align="center" ><?=saca_nombre_anexo($sl_anexos[5])?>
            <a href="../documentos_peec/<?=$sl_anexos[5]?>" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" /> </a></td>
        </tr>
        <?
}
		
  ?>
    </table></td>
  </tr>
  <?
  }
  
  //antecedentes
  ?>
  
  <tr>
    <td valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td width="54%" align="center" class="fondo_3">Lista de los Anexos</td>
      </tr>
      <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'anexo'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
      <tr class="<?=$clase?>">
        <td align="center" ><?=$sl_anexos[4]?></td>
        </tr>
      <?
}
  ?>
    </table></td>
    <td valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td width="54%" align="center" class="fondo_3">Lista de  los Antecedentes</td>
        </tr>
      <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'antecedente'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
      <tr class="<?=$clase?>">
        <td align="center" ><?=$sl_anexos[4]?></td>
        </tr>
      <?
}
  ?>
    </table></td>
  </tr>
   
  <?
  
  
   if($sel_item[14] >= 10 and $sel_item[14] < 31 and ($sel_item[6] ==1 or $sel_item[6] ==2 or $sel_item[6] ==3)){//IMPRIMME nEGOCIACION
  ?>
  <tr>
    <td valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td width="54%" align="center"  class="fondo_3">Lista de Documentaci&oacute;n B&aacute;sica de la Negociaci&oacute;n</td>
        </tr>
      <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_basico'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
      <tr class="<?=$clase?>">
        <td align="center" ><?=$sl_anexos[4]?></td>
        </tr>
      <?
}
  ?>
    </table></td>
    <td valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td width="54%" align="center"  class="fondo_3">Lista de Documentaci&oacute;n de Ensamble de la Negociaci&oacute;n</td>
        </tr>
      <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'doc_ensamble'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
      <tr class="<?=$clase?>">
        <td align="center" ><?=$sl_anexos[4]?></td>
        </tr>
      <?
}
		
  ?>
    </table></td>
  </tr>
  <?
  }
  
    if($sel_item[14] >= 14 and $sel_item[14] != 31 and $id_tipo_proceso_pecc == 1 and $sel_item[6] != 4 and $sel_item[6] != 5){//ADJUDICACION
  ?>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        <td align="center"  class="fondo_3">&nbsp;</td>
        </tr>
      <tr>
        <td width="14%" align="center" class="fondo_3">Proveedor</td>
        <td width="6%" align="center" class="fondo_3">No. Contrato</td>
        <td width="7%" align="center" class="fondo_3">Tipo de Documento</td>
        <td width="6%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="8%" align="center" class="fondo_3">Vegencia en Meses</td>
        <td width="18%" align="center" class="fondo_3">&Aacute;rea</td>
        <td width="9%" align="center" class="fondo_3">Valor USD$</td>
        <td width="9%" align="center" class="fondo_3">Valor COP$</td>
        </tr>
      <?
  $sele_presupuesto = query_db("select * from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[6];
				$valor_total_cop = $valor_total_cop + $sel_presu[7];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center"><?
				if($sel_presu[2] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_presu[3]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_presu[2];
					
					echo numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3);
				}else{
					echo "Sin Crear";
					}
		?></td>
        <td align="center"><?=$sel_presu[9]?></td>
        <td align="center"><?=$sel_presu[4]?></td>
        <td align="center"><?=$sel_presu[15]?></td>
        <td align="center"><?=$sel_presu[5]?></td>
        <td align="center" ><?=number_format($sel_presu[6],0)?></td>
        <td align="center"><?=number_format($sel_presu[7],0)?></td>
        </tr>
      <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
    </table>
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
    </table></td>
  </tr>
  <?
  }
  ?>
 
  
   
 <tr>
     <td valign="top" id="carga_acciones_permitidas3">
     <?
   
	$sele_si_aplica_permiso = traer_fila_row(query_db("select * from $vpeec_aplica where id_item = ".$id_item_pecc." and actividad_estado_id = 7"));
if($sel_item[14] < 31 and $sele_si_aplica_permiso[0] > 0){//FIRMAS PARA PERMISO
  ?>
     <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
       <tr>
         <td colspan="3" align="center"  class="fondo_3">Lista de Firmas en el Sistema Requeridas para el Permiso</td>
       </tr>
       <tr>
         <td width="11%" align="center" class="fondo_3">Rol Encargado</td>
         <td width="26%" align="center" class="fondo_3">Estado</td>
         <td width="34%" align="center" class="fondo_3">Observaci&oacute;n</td>
       </tr>
       <?
			
				
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		$cont = 0;
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 or $sel_p_real[0] == 8 or $sel_p_real[0] == 10){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and estado = 1 and us_id = ".$_SESSION["id_us_session"]." and id_rol not in (8,15) order by nombre_administrador"));
			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
			
			$es_aprobador_indicado_aprueba = "NO";
			if($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1 and $sel_item[14] == 7){
			$es_aprobador_indicado_aprueba = "SI";
			}
			

if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
		?>
       <tr class="<?=$clase?>">
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <?
		  }
          	
		  ?>
         <td align="left"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <select name="accion_aprueba_<?=$sel_p_real[0]?>" id="accion_aprueba_<?=$sel_p_real[0]?>">
             <option value="1">Firmar</option>
             <option value="2">Rechazar</option>
           </select>
           <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
         <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <textarea name="observa_<?=$sel_p_real[0]?>" cols="10" rows="2" id="observa_<?=$sel_p_real[0]?>"></textarea>
           <?
		  }else{
			  echo $sel_ultima_aprobacion[11];
			  }
		  ?></td>
       </tr>
       <?
		
        }
		?>
       <?

       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol = 10 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 ){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}

		?>
       <tr>
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <? } ?>
         <?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
         <td align="left"><? 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  ?></td>
         <td align="center"><?=$sel_ultima_aprobacion[11];?></td>
       </tr>
       <?
	}
       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol = 11 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1"));

			$es_aprobador_indicado_aprueba = "NO";
			if(verifica_usuario_indicado(11,$id_item_pecc)=="SI" and $sel_item[14] == 9){
			$es_aprobador_indicado_aprueba = "SI";
				}


		?>
       <tr>
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <?
		  }
		  ?>
         <td align="left"><?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 1 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
           <?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <select name="accion_aprueba_<?=$sel_p_real[0]?>" id="accion_aprueba_<?=$sel_p_real[0]?>">
             <option value="1">Firmar</option>
             <option value="2">Rechazar</option>
           </select>
           <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
         <td align="center"><?
          
			  echo $sel_ultima_aprobacion[11];
		
		  ?></td>
       </tr>
       <?
			}
		?>
     </table>
     
     <?
}
	 ?>
     
     </td>
     <td valign="top" id="carga_acciones_permitidas3"> <?
  $sele_si_aplica = traer_fila_row(query_db("select * from $vpeec_aplica where id_item = ".$id_item_pecc." and actividad_estado_id = 16"));
	$muestra = "NO";
	if($sele_si_aplica_permiso[0] <=0 and $sele_si_aplica[0]>=0 and $sel_item[14] >= 6){
		$muestra = "SI";
		}else{
			if($sele_si_aplica[0]>=0 and $sel_item[14] >= 14){
				$muestra = "SI";
				}
			}

if($sel_item[14] < 31 and $muestra == "SI"){//FIRMAS PARA ADJUDICACION
  ?> <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
       <tr>
         <td colspan="3" align="center"  class="fondo_3">Lista de Firmas en el Sistema Requeridas para la Adjudicaci&oacute;n</td>
        </tr>
       <tr>
         <td width="11%" align="center" class="fondo_3">Rol Encargado</td>
         <td width="26%" align="center" class="fondo_3">Estado Ultima Firma</td>
         <td width="34%" align="center" class="fondo_3">Observaci&oacute;n</td>
       </tr>
       <?
			
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){

			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 or $sel_p_real[0] == 15  or $sel_p_real[0] == 8 or $sel_p_real[0] == 10){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and estado = 1 and us_id = ".$_SESSION["id_us_session"]." and id_rol not in (8,15) order by nombre_administrador"));
			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
			
			$es_aprobador_indicado_aprueba = "NO";
			if($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1 and $sel_item[14] == 16){
			$es_aprobador_indicado_aprueba = "SI";
			}
			

		?>
       <tr>
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <?
		  }
          	
		  ?>
         <td align="left"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <select name="accion_aprueba_<?=$sel_p_real[0]?>2" id="accion_aprueba_<?=$sel_p_real[0]?>2">
             <option value="1">Firmar</option>
             <option value="2">Rechazar</option>
           </select>
           <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
         <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <textarea name="observa_<?=$sel_p_real[0]?>2" cols="10" rows="2" id="observa_<?=$sel_p_real[0]?>2"></textarea>
           <?
		  }else{
			  echo $sel_ultima_aprobacion[11];
			  }
		  ?></td>
        </tr>
       <?
		
        }
		?>
       <?

       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol = 10 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 ){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}

		?>
       <tr>
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <? } ?>
         <?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
         <td align="left"><? 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  ?></td>
         <td align="center"><?=$sel_ultima_aprobacion[11];?></td>
        </tr>
       <?
	}
       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol = 11 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2"));

			$es_aprobador_indicado_aprueba = "NO";
			if(verifica_usuario_indicado(11,$id_item_pecc)=="SI" and $sel_item[14] == 18){
			$es_aprobador_indicado_aprueba = "SI";
				}


		?>
       <tr>
         <td align="center"><?=$sel_p_real[1]?></td>
         <?
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
         <?
		  }
		  ?>
         <td align="left"><?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
           <?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <select name="accion_aprueba_<?=$sel_p_real[0]?>2" id="accion_aprueba_<?=$sel_p_real[0]?>2">
             <option value="1">Firmar</option>
             <option value="2">Rechazar</option>
           </select>
           <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
         <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
           <textarea name="observa_<?=$sel_p_real[0]?>2" cols="10" rows="2" id="observa_<?=$sel_p_real[0]?>2"></textarea>
           <?
		  }else{
			  echo $sel_ultima_aprobacion[11];
			  }
		  ?></td>
        </tr>
       <?
			}
		?>
     </table>
     &nbsp; <?
  }
  ?></td>
   </tr>
</table>


</body>
</html>
