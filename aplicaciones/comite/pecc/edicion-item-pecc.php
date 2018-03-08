<? include("../../../librerias/lib/@session.php"); 

	header('Content-Type: text/html; charset=ISO-8859-1');
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$permiso_o_adjudica = elimina_comillas(arreglo_recibe_variables($_GET["permiso_o_adjudica"]));
	$conse_div = elimina_comillas(arreglo_recibe_variables($_GET["conse_div"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));

$sel_item_obs = traer_fila_db(query_db("select CAST(objeto_solicitud AS text), CAST(objeto_contrato AS text), CAST(alcance AS text), CAST(justificacion AS text), CAST(recomendacion AS text),CAST(justificacion_tecnica AS text),CAST( criterios_evaluacion AS text) from $pi2 where id_item=".$id_item_pecc));

	if($permiso_o_adjudica == 1  or $sel_item[6] == 7 or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 4 or  $sel_item[6] == 5){
		
		
		$ob_solicitud = $sel_item_obs[0];
		$ob_contrato = $sel_item_obs[1];
		$ob_alcance = $sel_item_obs[2];
		$ob_justificacion = $sel_item_obs[3];
		$ob_recomendacion = $sel_item_obs[4];
		$ob_justificacion_tecnica = $sel_item_obs[5];
		$ob_criterios_evalua = $sel_item_obs[6];
		
		}else{
			
			
		$sel_item_obs_ad = traer_fila_db(query_db("select CAST(ob_solicitud_adjudica AS text), CAST(ob_contrato_adjudica AS text), CAST(alcance_adjudica AS text), CAST(justificacion_adjudica AS text), CAST(recomendacion_adjudica AS text),CAST( justificacion_tecnica_ad AS text),CAST( criterios_evaluacion AS text) from $pi2 where id_item=".$id_item_pecc));
		
		$ob_solicitud = $sel_item_obs_ad[0];
		$ob_contrato = $sel_item_obs_ad[1];
		$ob_alcance = $sel_item_obs_ad[2];
		$ob_justificacion = $sel_item_obs_ad[3];
		$ob_recomendacion = $sel_item_obs_ad[4];
		$ob_justificacion_tecnica = $sel_item_obs_ad[5];
		$ob_criterios_evalua = $sel_item_obs[6];
		
		if($ob_solicitud == ""){
			$ob_solicitud = $sel_item_obs[0];
			}
		if($ob_contrato == ""){
			$ob_contrato = $sel_item_obs[1];
			}
		if($ob_alcance == ""){
			$ob_alcance = $sel_item_obs[2];
			}
		if($ob_justificacion == ""){
			$ob_justificacion = $sel_item_obs[3];
			}
		if($ob_recomendacion == ""){
			$ob_recomendacion = $sel_item_obs[4];
			}
			
		if($ob_justificacion_tecnica == ""){
			$ob_justificacion_tecnica = $sel_item_obs[5];
			}
				
		
			}
		
		if($sel_item[17]==""){
$trm_actual=trm_presupuestal(2015);	
	}else{
$trm_actual=trm_presupuestal($sel_item[17]);
	}
	
		

			$trm=$trm_actual;
	
	$id_item_pecc_marco =$sel_item[26];
	$id_tipo_proceso_pecc = $sel_item[20];
	$activa_otro_si = "NO";
	if($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 11 or $sel_item[6] == 12){
			$sel_contra_otro_si = traer_fila_row(query_db("select * from $v_contra1 where id = ".$sel_item[21]));
			
			$sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, id from $co1 where id = '".$sel_item[21]."'"));
	
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_ontrato[0]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_ontrato[1];
					$numero_contrato4 = $sel_ontrato[2];					
					$num_contra =  numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_ontrato[3]);
			
			$sel_contra_otro_si_valor = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), (sum(valor_usd) + (sum(valor_cop) / $trm)) from $vpeec22 where t7_contrato_id = ".$sel_contra_otro_si[0]." and permiso_o_adjudica = 2 and aprobado = 1 group by trm"));
			
			
			$activa_otro_si = "SI";
			
		}
//	echo "select sum(valor_usd), sum(valor_cop), (sum(valor_cop) / $trm)+sum(valor_usd) from $vpeec22 where id_item = ".$id_item_pecc." and permiso_o_adjudica = ".$permiso_o_adjudica." and (al_valor_inicial_para_marco is null or al_valor_inicial_para_marco = 0) group by trm";
	$valor_solicitud = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), (sum(valor_cop) / $trm)+sum(valor_usd) from $vpeec22 where id_item = ".$id_item_pecc." and permiso_o_adjudica = ".$permiso_o_adjudica." and (al_valor_inicial_para_marco is null or al_valor_inicial_para_marco = 0) group by trm"));
	?>

<head>

<title>Solicitud</title>
<style>
body {
	color:#333333;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	margin-left:15px;
margin-right:15px;

}
.tabla_principal{
	border-left:#000066 4px double;
	border-top:#000066 1px solid;
	border-bottom:#000066 4px double;
	border-right:#000066 1px solid;
	}
.tabla_sub{
	border-left:#7030A0 4px double;
	border-top:#7030A0 1px solid;
	border-bottom:#7030A0 4px double;
	border-right:#7030A0 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#F6F4F8;	
	}
.tabla_sub2{
	border-left:#F9B175 4px double;
	border-top:#F9B175 1px solid;
	border-bottom:#F9B175 4px double;
	border-right:#F9B175 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FEF8F2;	
	}
.tabla_sub3{
	border-left:#C0504D 4px double;
	border-top:#C0504D 1px solid;
	border-bottom:#C0504D 4px double;
	border-right:#C0504D 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FFFFFF;	
	}
.tabla_sub4{
	border-left:#1F497D 4px double;
	border-top:#1F497D 1px solid;
	border-bottom:#1F497D 4px double;
	border-right:#1F497D 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#EFF2F6;	
	}
.tabla_sub5{
	border-left:#9BBB59 4px double;
	border-top:#9BBB59 1px solid;
	border-bottom:#9BBB59 4px double;
	border-right:#9BBB59 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#EFF2F6;	
	}
.tabla_sub6{
	border-left:#385D8A 4px double;
	border-top:#385D8A 1px solid;
	border-bottom:#385D8A 4px double;
	border-right:#385D8A 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FFFFFF;	
	}
	
.tabla_sub7{
	border-left:#8064A2 4px double;
	border-top:#8064A2 1px solid;
	border-bottom:#8064A2 4px double;
	border-right:#8064A2 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FFFFFF;	
	}
.tabla_sub7_1{
	border-left:#8064A2 1px solid;
	border-top:#8064A2 1px solid;
	border-bottom:#8064A2 1px solid;
	border-right:#8064A2 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FFFFFF;	
	}
.tabla_proveedores{
	border-left:#D04040 4px double;
	border-top:#D04040 1px solid;
	border-bottom:#D04040 4px double;
	border-right:#D04040 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#EFF2F6;	
	}


.tabla_montos{
	border-left:#969696 1px solid;
	border-top:#969696 1px solid;
	border-bottom:#969696 1px solid;
	border-right:#969696 1px solid;
	color:#000066;
	font-size:18px;
	background-color:#FFFFFF;
	}
	
.fondo_3{
	background-color:#003366;
	color:#FFFFFF;
	font-size:18px;
	}
.titulo1{
	color:#000066;
	font-size:32px;
	}
.titulo2{
	color:#000066;
	font-size:20px;
	}
.filas_resultados{
	background-color:#FFFFFF;
	}
.texto_justificado{
		text-align:justify;
		
		}
</style>
<script>
function abrir_ventana(pagina) {
 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
 window.open(pagina,"",opciones);
 }
</script>
</head>

<body>
<table width="90%" border="0" align="center" class="tabla_principal">
  <tr>
    <td colspan="3"><img src="../../../imagenes/coorporativo/logo-cliente-blanco.jpg" width="130"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="titulo1"><strong><?=saca_nombre_lista($g12,$sel_item[5],'nombre','t1_area_id');?> - <?=numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18])?></strong></td>
  </tr>
  <tr>
    <td colspan="2" class="titulo2"><strong>Informaci&oacute;n B&aacute;sica:</strong></td>
    <td width="47%" align="right">
    
    <strong onClick="abrir_ventana('pdf-edicion-item-pecc.php?id_item_pecc=<?=$sel_item[0]?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>&permiso_o_adjudica=<?=$permiso_o_adjudica?>')" class="titulo_calendario_real_bien" style="cursor:pointer"> Exportar a WORD <img src="../../../imagenes/mime/doc.gif" width="20" height="20"></strong></td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub">
    <?
    if($activa_otro_si == "SI"){
	?>
      <tr>
        <td width="26%" align="right"><strong>Numero de Contrato:</strong></td>
        <td width="29%" align="left"><?=$num_contra?></td>
        <td width="19%" align="right"><strong>Proveedor:</strong></td>
        <td width="26%"><?=$sel_contra_otro_si[6]?></td>
      </tr>
     
      <?
	}
	  ?>
       <tr>
        <td align="right"><strong>Fecha para Cuando se Requiere:</strong></td>
        <td align="left"><?=$sel_item[7]?></td>
        <td align="right"><strong>Tipo de Permiso:</strong></td>
        <td align="left"><? if($permiso_o_adjudica==1) echo "Permiso"; else echo "Adjudicaci&oacute;n";?></td>
      </tr>
      <tr>
        <td align="right"><strong>Objeto de la Solicitud:</strong></td>
        <td colspan="3" align="left"><?=$ob_solicitud?></td>
        </tr>
        <?
        	$sel_id_apro_ultima_permiso = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = 10 and tipo_adj_permiso = 1 and id_item_pecc = ".$id_item_pecc));			
			$sel_ultima_aprobacion_permiso = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima_permiso[0]));			
			$numero_comite_permiso = substr($sel_ultima_aprobacion_permiso[11], -9, 9);
			
			$sel_id_apro_ultima_adjudica = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = 10 and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));			
			$sel_ultima_aprobacion_adjudica = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima_adjudica[0]));			
			$numero_comite_adjudica = substr($sel_ultima_aprobacion_adjudica[11], -9, 9);
			
			if($numero_comite_permiso == ""){
					$numero_comite_permiso  ="N/A";
				}
			if($numero_comite_adjudica == ""){
					$numero_comite_adjudica  ="N/A";
				}
			if($sel_item[6] != 16){
		?>
        <tr>
          <td align="right" ><strong>Objeto del Contrato:</strong></td>
          <td colspan="3" align="left"><?=$ob_contrato?></td>
        </tr>
        <?
			}
		?>
        <tr>
        <td align="right"  width="26%" ><strong>Tipo de Proceso:</strong></td>
        <td align="left" width="29%"><? 
		
		
		$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));
		
		if($sele_tipo_doc_desierto[13]==4){
		echo "Declarar Desierto - ";
		}
		if($sel_item[6] == 4 or $sel_item[6] == 5) { echo "Otro S&iacute;";}else{
			echo saca_nombre_lista($g13,$sel_item[6],'nombre','t1_tipo_proceso_id',$sel_item[0]);
		}
		if($sel_item[6] != 16){
		?></td>
        <td align="right" width="19%"><strong>Comit&eacute; de Permiso:</strong></td>
        <td align="left" width="26%"><?=$numero_comite_permiso;?></td>
        <?
		}
		?>
      </tr>
      <?
      if($sel_item[6] != 16){
	  ?>
      <tr>
        <td align="right"><strong>Negociaci&oacute;n Origen:</strong></td>
        <td align="left"><?  if($activa_otro_si == "SI"){ echo saca_nombre_lista($g13,$sel_contra_otro_si[10],'nombre','t1_tipo_proceso_id');}else{ echo "N/A";}?></td>
        <td align="right"><strong>Comit&eacute; de Adjudicaci&oacute;n:</strong></td>
        <td align="left"><?=$numero_comite_adjudica?></td>
      </tr>
      
      <?
      }
	  ?>
      <tr>
        <td align="right"><strong>Area:</strong></td>
        <td align="left"><? echo saca_nombre_lista("t1_area",$sel_item[5],'nombre','t1_area_id');?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"  class="titulo2"><strong>Monto y Gerencia:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub2">
      <tr>
        <td width="26%" align="right"><strong>Moneda en la que se Pagar&aacute;:</strong></td>
        <td width="15%" align="right">COP $:</td>
        <td width="12%" align="left"><?=number_format($valor_solicitud[1],0)?></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="right">USD $:</td>
        <td align="left"><?=number_format($valor_solicitud[0],0)?></td>
        <td colspan="2" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>Equivalente D&oacute;lares Americanos:</strong></td>
        <td align="right">EQ USD $:</td>
        <td align="left"><?=number_format($valor_solicitud[2],0)?></td>
        <td width="22%" align="right"><strong>Gerente del Item:</strong></td>
        <td width="25%" align="left"><? echo traer_nombre_muestra($sel_item[3], $g1,"nombre_administrador","us_id")?></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td colspan="2" class="titulo2"><strong>Justificaci&oacute;n T&eacute;cnica:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub3">
      <tr>
        <td colspan="4" class="texto_justificado" ><?=$ob_justificacion_tecnica?></td>
      </tr>
    </table></td>
  </tr>
  
  
  <tr>
    <td colspan="2" class="titulo2"><strong>Justificaci&oacute;n Comercial:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub3">
      <tr>
        <td colspan="4"  class="texto_justificado"><?=$ob_justificacion?></td>
      </tr>
    </table></td>
  </tr>
<?  if($sel_item[6] != 16){ ?>
  <tr>
    <td colspan="2" class="titulo2"><strong>Criterios de Evaluaci&oacute;n</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub3">
      <tr>
        <td colspan="4"  class="texto_justificado"><?=$ob_criterios_evalua?></td>
      </tr>
    </table></td>
  </tr>
  <?
  }
  ?>
  
  <tr>
    <td colspan="2" class="titulo2"><strong>Recomendaci&oacute;n:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub4">
      <tr>
        <td colspan="4"  class="texto_justificado"><?=$ob_recomendacion?></td>
      </tr>
    </table></td>
  </tr>
  <?

    	if($permiso_o_adjudica == 1 or $sel_item[6] == 7 or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 4 or  $sel_item[6] == 5){
	?>
  <tr>
    <td colspan="3"  class="titulo2"><strong><? if($sel_item[49]==3)  echo "Detalle del valor solicitado para reclasificar"; else echo "Detalle del Monto Solicitado"; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3">
    
    <table width="98%" border="0" align="center"  class="tabla_sub6">
      <tr>
        <td colspan="4" align="right">
        <?
	
	
	
	if($sel_item[6] <> 7 and $sel_item[6] <> 8){
		$aplica_presu = $permiso_o_adjudica;
		}else{
			$aplica_presu = 1;
			}
	
        $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco is null or $pi8.al_valor_inicial_para_marco = 0)");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		?>
        <table width="100%" border="0" align="center"  class="tabla_montos">
          <tr>
            <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
            <td width="16%" align="center" class="fondo_3">Contrato(s) Marco</td>
            <?
			}
		  ?>
            <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
            <td width="19%" align="center" class="fondo_3">Valor USD$</td>
            <td width="19%" align="center" class="fondo_3">Valor COP$</td>
            <td width="14%" align="center" class="fondo_3">Ver Adjunto</td>
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
			
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
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
		  ?>
          
          </td>
            <?
			}
		  ?>
            <td align="center"><?=$sel_presu[1]?></td>
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center" ><?=number_format($sel_presu[4],0)?></td>
            <td align="center"><?=number_format($sel_presu[5],0)?></td>
            <td align="center"><? if($sel_presu[3] != " "){?>
              <?=saca_nombre_anexo($sel_presu[3])?> 

              <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">  
              
              <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" border="0" />
               </a>
              <? }?></td>
            </tr>
          <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
        </table></td>
      </tr>
    </table>
    
    </td>
  </tr>
  <?
		}
		if($sel_item[49]==3){//si es reclasificacion de contrato marco
	?>
    
  <tr>
    <td colspan="3" class="titulo2"><strong>Detalle del valor como se reclasificar&aacute;</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="right">
        <?
	
	
	
	if($sel_item[6] <> 7 and $sel_item[6] <> 8){
		$aplica_presu = $permiso_o_adjudica;
		}else{
			$aplica_presu = 1;
			}
	
        $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco =1)");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		?>
        <table width="100%" border="0" align="center"  class="tabla_montos">
          <tr>
            <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
            <td width="16%" align="center" class="fondo_3">Contrato(s) Marco</td>
            <?
			}
		  ?>
            <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="24%" align="center" class="fondo_3">&Aacute;rea</td>
            <td width="19%" align="center" class="fondo_3">Valor USD$</td>
            <td width="19%" align="center" class="fondo_3">Valor COP$</td>
            <td width="14%" align="center" class="fondo_3">Ver Adjunto</td>
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
			
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
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
		  ?>
          
          </td>
            <?
			}
		  ?>
            <td align="center"><?=$sel_presu[1]?></td>
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center" ><?=number_format($sel_presu[4],0)?></td>
            <td align="center"><?=number_format($sel_presu[5],0)?></td>
            <td align="center"><? if($sel_presu[3] != " "){?>
              <?=saca_nombre_anexo($sel_presu[3])?> 

              <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">  
              
              <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" border="0" />
               </a>
              <? }?></td>
            </tr>
          <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
        </table></td>
  </tr>
  <?
		}
  ?>
  <tr>
    <td colspan="2" class="titulo2"><strong>Anexos, Antecedentes y Documentaci&oacute;n de la Solicitud:</strong></td>
    <td>&nbsp;</td>
  </tr>
  <?
 
  ?>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub4">
      <tr>
        <td width="27%" align="center" class="fondo_3">Categor&iacute;a</td>
        <td width="27%" align="center" class="fondo_3">Tipo</td>
        <td width="27%" align="center" class="fondo_3">Usuario que lo Cargo</td>
        <td width="27%" align="center" class="fondo_3">Detalle de los Antecedentes</td>
        <td width="19%" align="center" class="fondo_3">Archivo Adjunto</td>
        </tr>
      <?
$cont = 0;
  $clase="";
  
    $comple_anexos_pecc = traer_anexos_pecc($sel_item[56]);
	
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo not in ('') $comple_anexos_pecc order by t2_anexo_id");
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
        <td align="left" ><? $sel_catergoria = traer_fila_row(query_db("select * from t1_categoria_anexos where id = ".$sl_anexos[9]));
			  echo $sel_catergoria[1]; ?></td>
        <td align="left" ><? 
		if($sl_anexos[3] == "doc_basico") echo "Negociaci&oacute;n: Documentos B&aacute;sicos";
		if($sl_anexos[3] == "anexo_adjudicacion") echo "Anexos de Adjudicaci&oacute;n";
		if($sl_anexos[3] == "anexo") echo "Anexos";
		if($sl_anexos[3] == "antecedente") echo "Antecedentes";
		if($sl_anexos[3] == "doc_ensamble") echo "Negociaci&oacute;n: Documentos de Ensamble";
		if($sl_anexos[3] == "basicosondeo") echo "Sondeo: Documentos B&aacute;sicos";
		if($sl_anexos[3] == "ensamblesondeo") echo "Sondeo: Documentos de Ensamble";
		if($sl_anexos[3] == "") echo " -- ";
	
		
		?></td>
        <td align="center" ><? echo traer_nombre_muestra($sl_anexos[7], $g1,"nombre_administrador","us_id")?></td>
        <td align="left" ><?=$sl_anexos[4]?></td>
        <td align="left" ><?
              if($sl_anexos[5] != " "){
			  ?>
          <?=saca_nombre_anexo($sl_anexos[5])?>
          <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp"> <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" border="0" /> </a>
          <?
			  }
				  ?></td>
        </tr>
      <?
}
  ?>
    </table></td>
  </tr>
  <?
if($sel_item[6] == 7 or $sel_item[6] == 8){ 
	?>
    <tr>
      <td colspan="3">
	<?
          $id_contrato_carr = $sel_item[26];
		  if($sel_item[26] > 0){
	$solicitudes_antecedentes = 0;


	$sele_otros_si = query_db("select id_item from $pi2 where id_item_peec_aplica = ".$id_contrato_carr);
	while($sel_item_otros = traer_fila_db($sele_otros_si)){
		$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
		}
	
	$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item[26];
		  ?>
          
          <table width="98%" border="0" align="center"  class="tabla_sub4">
  <tr>
    <td colspan="3" align="center"  class="fondo_3">Antecedentes de Otras Solicitudes Relacionadas</td>
  </tr>
  <tr>
    <td width="16%" align="center" class="fondo_3">No.</td>
    <td width="57%" align="center" class="fondo_3">Detalle</td>
    <td width="27%" align="center" class="fondo_3">Archivo Adjunto</td>
  </tr>
  <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente' ");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  
	  $sel_numero_item = traer_fila_row(query_db("select num1,num2,num3 from $pi2 where id_item = ".$sl_anexos[1]));
	  
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
  <tr class="<?=$clase?>">
    <td align="center" ><?=numero_item_pecc($sel_numero_item[0],$sel_numero_item[1],$sel_numero_item[2])?></td>
    <td align="center" ><?=$sl_anexos[4]?></td>
    <td align="center" >
      <? if($sl_anexos[5] != " "){?>
      <?=saca_nombre_anexo($sl_anexos[5])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sl_anexos[5]?>&n1=<?=$sl_anexos[0]?>&n3=2" target="grp">
      <img src="../imagenes/mime/<?=saca_extencion_archivo($sl_anexos[5])?>.gif" width="16" height="16" />
      </a>
      <?
	}
	?>
    </td>
  </tr>
  <?
}
  ?>
</table>
<?
		  }
?>
</td></tr>
	<?
	}//si es ampliacion o orden de trabajo
  ?>
  <tr>
    <td width="27%">&nbsp;</td>
    <td width="26%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub7">
      <tr>
        <td width="34%" align="right"><strong>Alcance:</strong></td>
        <td colspan="3" rowspan="2" class="tabla_sub7_1 texto_justificado"  ><?=$ob_alcance?></td>
        </tr>
      <tr>
        <td align="right">&nbsp;</td>
        </tr>
      <tr>
        <td align="right"><strong>Revisi&oacute;n C. Intereses:</strong></td>
        <td width="24%" align="left"><? echo traer_nombre_muestra($sel_item[23], $g1,"nombre_administrador","us_id")?></td>
        <td width="21%" align="left"><?=$sel_item[50]?></td>
        <td width="21%" align="left">&nbsp;</td>
      </tr>
      <?
      if($activa_otro_si == "SI"){
	  ?>
      <tr>
        <td align="right"><strong>Nuevo valor del contrato Equivalente USD$:</strong></td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right"><table width="98%" border="0" align="center" class="tabla_montos">
          <tr>
            <td width="23%" align="center"  class="fondo_3">Valor Actual del Contrato</td>
            <td width="35%" align="center" class="fondo_3">Valor de esta Solicitud</td>
            <td width="21%" align="center" class="fondo_3">Nuevo Valor del Contrato</td>
            </tr>
          <tr>
            <td align="center"><?=number_format($sel_contra_otro_si_valor[2],0)?></td>
            <td align="center"><?=number_format($valor_solicitud[2],0)?></td>
            <td align="center"><?=number_format($valor_solicitud[2]+$sel_contra_otro_si_valor[2],0)?></td>
            </tr>
        </table></td>
        </tr>
        <?
	  }
		?>
    </table></td>
  </tr>
  <? if($sel_item[6] <> 7 and $sel_item[6] <> 8 and $sel_item[6] <> 16){//SI NO ES AMPLIACION IMPRIMA PROVEEDORES?>
  <tr>
    <td colspan="3" class="titulo2"><strong>Proveedores Propuestos por el Gerente del Contrato:</strong></td>
  </tr>
  
  <tr>
    <td colspan="3">
    <table width="98%" border="0" align="center" class="tabla_proveedores">
      <tr>
        <td><?=$sel_item[11]?></td>
      </tr>
    </table>
    <br>
    <?
		$sel_proveedores_si_tiene = traer_fila_row(query_db("select count(*) from $pi13 as t1, $g6 as t2 where t1.id_item = ".$id_item_pecc." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1"));
		
    	if($sel_proveedores_si_tiene[0] > 0){
	?>
    <table width="98%" border="0" align="center"  class="tabla_proveedores">
      <tr>
        <td colspan="3">Lista de Proveedores Propuestos por el Profesional de C&amp;C</td>
        </tr>
      <tr>
        <td width="23%" align="center" class="fondo_3">Registrado en Par Servicios</td>
        <td width="31%" align="center" class="fondo_3">Nombre</td>
        <td width="13%" align="center"  class="fondo_3">Nit</td>
        </tr>
      <?
	  	  
            $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado from $pi13 as t1, $g6 as t2 where t1.id_item = ".$id_item_pecc." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1");
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
    </table>
    <p>
      <?
		}
		if($sel_item[6] <> 7 and $sel_item[6] <> 8 and $sel_item[6] <> 4 and $sel_item[6] <> 5){
		
			
			$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_item[0].""));
			if($sele_tipo_doc[0]>0){
				$es_marco = "SI";
				}else{
					$es_marco = "NO";
				}
				
				
			if($es_marco == "SI"){
			?>    
    <table width="98%" border="0" align="center"  class="tabla_proveedores">
     
      <tr>
        <td colspan="4"><strong>Lista de Proveedores para la Adjudicaci&oacute;n</strong></td>
        </tr>
      <tr>
        <td width="36%" align="center" class="fondo_3">Proveedor</td>
        <td width="8%" align="center" class="fondo_3">No. Contrato</td>
        <td width="8%" align="center" class="fondo_3">Complemento</td>
        <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
        </tr>
      <?
  $sele_presupuesto = query_db("select t1.id_relacion, t2.razon_social, t1.vigencia_mes, t1.apellido, t1.t1_proveedor_id from $pi18 as t1, $g6 as t2 where t1.t2_item_pecc_id_marco ='".$id_item_pecc."' and t1.t1_proveedor_id =  t2.t1_proveedor_id");

		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				
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
		
		$sel_ontrato = traer_fila_row(query_db("select creacion_sistema, consecutivo from $co1 where id_item = $id_item_pecc and contratista = '".$sel_presu[4]."' and apellido = '".$sel_presu[3]."'"));
		
		
				if($sel_ontrato[0] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_ontrato[0]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_ontrato[1];
					
					echo numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3);
				}else{
					echo "Sin Crear";
					}
		?></td>
        <td align="center"><?=$sel_presu[3]?></td>
        <td align="center"><?=$sel_presu[2]?></td>
        </tr>
      <?
			}
		?>
    </table>
    
    <table width="98%" border="0" align="center"  class="tabla_proveedores">
          <tr>
            <td colspan="5" align="center"  class="fondo_3">Valor de la Adjudicaci&oacute;n</td>
          </tr>
          <tr>
            <td width="6%" align="center" class="fondo_3">A&ntilde;o</td>
            <td width="18%" align="center" class="fondo_3">&Aacute;rea</td>
            <td width="9%" align="center" class="fondo_3">Valor USD$</td>
            <td width="9%" align="center" class="fondo_3">Valor COP$</td>
            <td width="9%" align="center" class="fondo_3">Ver Adjunto</td>
          </tr>
          <?
  $sele_presupuesto = query_db("select * from $vpeec25 where t2_item_pecc_id ='".$id_item_pecc."'");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[3];
				$valor_total_cop = $valor_total_cop + $sel_presu[4];
				
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
            <td align="center"><?=$sel_presu[2]?></td>
            <td align="center" ><?=number_format($sel_presu[3],0)?></td>
            <td align="center"><?=number_format($sel_presu[4],0)?></td>
            <td align="center"><? if($sel_presu[5] != " " and $sel_presu[5] != "NULL" and $sel_presu[5] != "" ){?>
              <?=saca_nombre_anexo($sel_presu[5])?>
              <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[5]?>&amp;n1=<?=$sel_presu[6]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[5])?>.gif" width="16" height="16" /> </a>
              <?
	}
				  ?></td>
          </tr>
          <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
        </table>
    
    <p>
      <?
			}else{//fin si es marco
				
				?><table width="98%" border="0" align="center"  class="tabla_proveedores">
     
      <tr>
        <td colspan="7"><strong>Lista de Proveedores para la Adjudicaci&oacute;n</strong></td>
        </tr>
      <tr>
        <td width="36%" align="center" class="fondo_3">Proveedor</td>
        <td width="12%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
        <td width="14%" align="center" class="fondo_3">&Aacute;rea</td>
        <td width="11%" align="center" class="fondo_3">Valor USD$</td>
        <td width="13%" align="center" class="fondo_3">Valor COP$</td>
        <td width="6%" align="center" class="fondo_3">Ver Adjunto</td>
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
        <td align="center"><?=$sel_presu[4]?></td>
        <td align="center"><?=$sel_presu[15]?></td>
        <td align="center"><?=$sel_presu[5]?></td>
        <td align="center" ><?=number_format($sel_presu[6],0)?></td>
        <td align="center"><?=number_format($sel_presu[7],0)?></td>
        <td align="center"><? if($sel_presu[8] != " " and $sel_presu[8] != "NULL" and $sel_presu[8] != "" ){?>
          <?=saca_nombre_anexo($sel_presu[8])?>
          <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[8]?>&n1=<?=$sel_presu[11]?>&n3=3" target="grp"> <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_presu[8])?>.gif" width="16" height="16" border="0" /> </a>
          <?
	}
				  ?></td>
        </tr>
      <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
    </table><?
				
				}// fin si no es marco
		}
	?>
    </td>
  </tr>
  <?
  }else if($sel_item[6] == 16){//FIN SI NO ES AMPLIACION IMPRIMA PROVEEDORES
  ?>
    <tr>
    <td colspan="3" ><table width="98%" border="0" align="center"  class="tabla_proveedores">
      <tr>
        <td>Lista de Proveedores propuestos por el solicitante y adjudicados</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="63%" align="center" class="fondo_3">Raz&oacute;n Social</td>
        <td width="11%" align="center" class="fondo_3">Nit</td>
        <td width="26%" align="center"  class="fondo_3">Agregado por</td>
      </tr>
      <?
	  	  
            $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado, t1.id_us_crea, t1.es_adjudicado from $pi13 as t1, $g6 as t2 where t1.id_item = ".$id_item_pecc." and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1  order by  t1.id_relacion_proveedor desc");
			while($se_prove = traer_fila_db($sel_proveedores)){
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				
			?>
      <tr class="<?=$clase?>">
        <td align="center"><?=$se_prove[1]?> <strong><font color="#33CC33">
	            <? if ($se_prove[6] ==1) echo "Adjudicado";?>
	            </font></strong></td>
        <td align="center"><?=$se_prove[2]?></td>
        <td align="center"><? echo saca_nombre_lista($g1,$se_prove[5],'nombre_administrador','us_id');?></td>
      </tr>
      <?
            }
			?>
    </table></td>
  </tr>
<?
  
  }else{
	  }
  
  ?>

  <tr>
 
    <td colspan="3" class="titulo2"><strong>Firmas en el Sistema para  
	<?
    if($permiso_o_adjudica == 1){ echo "el Permiso"; if($sel_item[6] == 12) $permiso_o_adjudica = 2;}
	if($permiso_o_adjudica == 2){ echo "la Adjudicaci&oacute;n";}
	
	?>:</strong></td>
  </tr>
  <tr>
    <td colspan="3"><table width="98%" border="0" align="center"  class="tabla_sub4">
      <tr>
        <td width="23%" align="center" class="fondo_3">Rol Encargado</td>
        <td width="34%" align="center" class="fondo_3">Gesti&oacute;n</td>
        <td width="34%" align="center" class="fondo_3">Observaci&oacute;n</td>
        <td width="9%" align="center" class="fondo_3">Adjunto</td>
      </tr>
      <?
			
				
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = $permiso_o_adjudica and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		$cont = 0;
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 or $sel_p_real[0] == 8 or $sel_p_real[0] == 10){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and estado = 1 and us_id = ".$_SESSION["id_us_session"]." and id_rol not in (8,15) order by nombre_administrador"));
			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and id_item_pecc = ".$id_item_pecc));
			
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
          <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
        <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <?
		  }else{
			  echo $sel_ultima_aprobacion[11];
			  }
		  ?></td>
        <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <?
		  }else{
			  
			  	if($sel_ultima_aprobacion[9] != ""){
		  ?>
          
          
                <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[9]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=4" target="grp">
                  <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[9])?>.gif" width="16" height="16" border="0" />
                  </a>
          <?
				}
				if($sel_ultima_aprobacion[10] != ""){
		  ?>
          
         
                <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[10]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=5" target="grp">
                  <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[10])?>.gif" width="16" height="16" border="0" />
                  </a>
          <?
				}
		  }
		  ?></td>
        </tr>
      <?
		
        }
		?>
      <?

       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 10 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

			$edita_permiso = "NO";
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
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
        <td align="left"><? 
		  	if($sel_ultima_aprobacion[5] == 1){
					if(($sel_item[6] == 9 or $sel_item[6] == 10) and $sel_p_real[0] == 8 and $sel_item[0] > 5181) {
							echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Informado";
					}else{
							echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Firmado";
						}
					
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  ?></td>
        <td align="center"><?=$sel_ultima_aprobacion[11];?></td>
        <td align="center">&nbsp;</td>
        </tr>
      <?
	}
       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = $permiso_o_adjudica and id_rol = 11 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica"));

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
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_o_adjudica and id_item_pecc = ".$id_item_pecc));
			
//			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db( "select id_item_pecc, id_secuencia_solicitud, id_aprobacion, id_us, fecha, aprobado, nombre_administrador, id_rol, tipo_adj_permiso, adjunto1, adjunto2, CAST(observacion AS TEXT),  estado from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
          <?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <?
		  }else{ 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Firmado";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]." Estado: Rechazado";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
        <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <?
		  }else{
			  echo $sel_ultima_aprobacion[11];
			  }
		  ?></td>
        <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <?
		  }else{
			  	if($sel_ultima_aprobacion[9] != ""){
		  ?>
          
          
                <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[9]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=4" target="grp">
                  <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[9])?>.gif" width="16" height="16" border="0" />
                  </a>
          <?
				}
				if($sel_ultima_aprobacion[10] != ""){
		  ?>
          
         
                <a href="../../../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[10]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=5" target="grp">
                  <img src="../../../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[10])?>.gif" width="16" height="16" border="0" />
                  </a>
          <?
				}
		  }
		  ?></td>
        </tr>
      <?
			}
		?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<iframe name="grp" id="grp" width="0" height="0"></iframe>
</body>
</html>
