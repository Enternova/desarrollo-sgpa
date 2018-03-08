<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	

	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_item_pecc_marco =$sel_item[26];
  $id_item_pecc_aplica=$sel_item[26];
	$sel_item_marco = traer_fila_row(query_db("select * from $pi2 where id_item='".$id_item_pecc_marco."'"));
	$id_tipo_proceso_pecc = $sel_item[20];
	
	
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));



if($sel_item[17]==""){
$trm_actual=trm_presupuestal(2015);	
	}else{
$trm_actual=trm_presupuestal($sel_item[17]);
	}
	
	$sel_pecc[0] = $trm_actual;
	
	
		
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_item[14], $sel_item[0]) == "SI"  and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
	
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		
		if($sel_item[6]== 8){
			$id_tipo_proceso_pecc=3;
			}
		if($sel_item[6]== 7){
			$id_tipo_proceso_pecc=2;
			}

$t1_tipo_proceso_id = $sel_item[6];


 //si es nanky
 if((esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7) or (esprofesionalcompras($id_item_pecc)=="SI" and $id_tipo_proceso_pecc == 3 and $sel_item[14]==16) or (esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[6]==11 and $sel_item[14]==16 )){
	 $edicion_datos_generales = "SI";
	 }
	
	
	/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] < 16) and $sel_item[23] == $_SESSION["id_us_session"]){
	$edicion_datos_generales = "NO";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
	
	if($sel_item[6] == 12){//si es reclasificacin
$sel_tipo_reclasificacion = traer_fila_row(query_db("select t1_tipo_documento_id, id_item from t7_contratos_contrato where id=".$sel_item[21]));
}	

	if($_GET["desde_comite"] == "SI"){//este if es para identificar cuando la consulta biene desde el comite, para modificar los valores directamente por el secretario del comite.
		$desde_comite = "SI";
		$edicion_datos_generales = "SI";
	}


$edita_info_ad_sm = "NO";
if($sel_item[14]==13 and $sel_item[6] == 16 and $sel_item[23] == $_SESSION["id_us_session"]){
	$edita_info_ad_sm = "SI";

}

	?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<? if ($desde_comite == "SI") echo "<br /><br /><br /> ";?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" <? if ($desde_comite == "SI") {echo 'bgcolor="#FFFFFF" width="95%"';} else {echo 'width="100%"';}?>>
  <tr>
    <td colspan="2" valign="top"><? if($desde_comite == "SI"){?><div align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar" onclick="ajax_carga('../aplicaciones/comite/aprobacion.php?id_comite='+document.principal.id_comite.value, 'contenidos')" style="width:100px;" /></div><? }else{ echo encabezado_item_pecc($id_item_pecc);}?></td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    
    <?
    /*-------------------------------------*/
	
	if(($sel_item[6]==4 or $sel_item[6]==5 or $sel_item[6]==13 or $sel_item[6]==14) and $sel_item[21]>0 and $edicion_datos_generales == "SI" and  ($desde_comite != "SI")){
		
		
			
				$id_contrato_carr = $sel_item[21];

				?>
                
				
                <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Valor Inicial del Contrato</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
        <td width="19%" align="center" class="fondo_3">Valor Equivalente USD$</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec19 where id_contrato =".$id_contrato_carr);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
       
        <td align="center"><?=$sel_presu[0]?></td>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center" ><?=number_format($sel_presu[2],0)?></td>
        </tr><?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
      <tr>
        <td colspan="2" align="left"><img src="../imagenes/botones/aviso_observaciones.png" alt="" width="16" height="16" /><strong>ATENCION: </strong><span class="titulos_resumen_alertas">El valor actual del contrato se sumara a esta solicitud para generar el camino que debe tomar en cuanto a firmas en el sistema, firma del comit&eacute; interno y firma de los socios entre otros.	</span></td>
        <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
        </tr>
      
    </table>
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="3" align="center"  class="fondo_3">Valor de los Otro Si</td>
        </tr>
      <tr>
    
        <td width="16%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="24%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
        <td width="19%" align="center" class="fondo_3">Valor Equivalente USD$</td>
        </tr>
      <?
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from $vpeec24 where id_contrato =".$id_contrato_carr);
	$valor_total_usd = 0;
	$valor_total_cop = 0;
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[2];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
      <tr class="<?=$clase?>">
       
        <td align="center"><?=$sel_presu[0]?></td>
        <td align="center"><?=$sel_presu[1]?></td>
        <td align="center" ><?=number_format($sel_presu[2],0)?></td>
        </tr><?
			}
			$total_equivale_usd = $total_equivale_usd +$valor_total_usd ;
		?>
      <tr>
        <td colspan="2" align="left">&nbsp;</td>
        <td align="center" class="titulos_resumen_alertas"><?=number_format($total_equivale_usd)?></td>
        </tr>
      
    </table>
                
                
				<?

		
		
		}
	
	/*-----------------------------------*/
	?>
    
    <?
    
	if(($sel_item[6]== 8 or $sel_item[6]== 7) and $sel_item[26] == 0 and $edicion_datos_generales == "SI"){
		
		
	?><table width="99%" border="0" cellpadding="2" cellspacing="2">
<tr>
  <td width="15%" align="right">Numero de la Solicitud:</td>
  <td width="8%"><select name="numero1_pecc" id="numero1_pecc">
    <?				
                	$sele_numero1=query_db("select num1 from $vpeec4 where t1_tipo_documento_id = 2 group by num1 order by num1");
					while($sel_num = traer_fila_db($sele_numero1)){
				?>
    <option value="<?=$sel_num[0]?>">
      <?=$sel_num[0]?>
      </option>
    <?
					}
				?>
  </select></td>
  <td width="9%"><select name="numero2_pecc" id="numero2_pecc">
    <option value="">Todos</option>
    <?=anos_consulta_ulti_numeros(0)?>
    
  </select></td>
  <td width="10%"><input name="numero3_pecc" type="text" id="numero3_pecc" maxlength="4" /></td>
  <td width="58%" rowspan="9" align="right"><table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="31%" align="right">Alcance:</td>
      <td width="69%"><textarea name="bus_text1" id="bus_text1" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Justificaci&oacute;n:</td>
      <td><textarea name="bus_text2" id="bus_text2" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Recomendaci&oacute;n:</td>
      <td><textarea name="bus_text3" id="bus_text3" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto del Contrato:</td>
      <td><textarea name="bus_text4" id="bus_text4" cols="25" rows="2"></textarea></td>
      </tr>
    <tr>
      <td align="right">Objeto de la Solicitud:</td>
      <td><textarea name="bus_text5" id="bus_text5" cols="25" rows="2"></textarea></td>
      </tr>
  </table></td>
  </tr>
<tr>
  <td align="right">Numero de Contrato:</td>
  <td align="center">C</td>
  <td><select name="n_contrato_ano" id="n_contrato_ano">
    <option value="">Todos</option>
  <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <?=anos_consulta_ulti_numeros(0)?>
  </select></td>
  <td><input name="n_contrato" type="text" id="n_contrato" maxlength="4" /></td>
  </tr>
<tr>
  <td align="right">&Aacute;rea Usuaria:</td>
  <td colspan="3"><select name="bus_area" id="bus_area">
    <?=listas($g12, " estado = 1",0 ,'nombre', 1);?>
  </select></td>
  </tr>
<tr>
  <td align="right">Contratista:</td>
  <td colspan="3"><input name="contra_busca" id="contra_busca" /></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr>
  <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=busqueda_compras_en_edicion&id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&numero1_pecc='+document.principal.numero1_pecc.value+'&numero2_pecc='+document.principal.numero2_pecc.value+'&numero3_pecc='+document.principal.numero3_pecc.value+'&n_contrato='+document.principal.n_contrato.value+'&n_contrato_ano='+document.principal.n_contrato_ano.value+'&bus_area='+document.principal.bus_area.value+'&bus_text1='+document.principal.bus_text1.value+'&bus_text2='+document.principal.bus_text2.value+'&bus_text3='+document.principal.bus_text3.value+'&bus_text4='+document.principal.bus_text4.value+'&bus_text5='+document.principal.bus_text5.value+'&contra_busca='+document.principal.contra_busca.value+'&id_item_pecc=<?=$id_item_pecc?>','carga_lista_contratos_marco')" /></td>
</tr>
<tr>
  <td colspan="5" align="center"><div id="carga_lista_contratos_marco"></div></td>
</tr>

</table><?
	
		}else{
		//si es con solicitudes, OT o Ampliacion y no tienen solicitud relacionada
    $id_item_aplica_contrato_marco = $id_item_pecc_marco;
	//si es orden de trabajo o ampliacion if($sel_item[49]==3)
	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
	?>
    <table width="100%" border="0"><tr><td>
    <?
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <input type="button" name="" id="" value="Desvincular esta Solcitud de Contratos Marco" onclick="quita_solicitud_de_la_relacion()" />
    <?
    }
    ?>
	
    </td></tr></table>
    <?
    if( ($sel_item[14] == 6 or $sel_item[14] == 31 or $desde_comite == "SI" ) and $edicion_datos_generales == "SI"){
    ?>
    <table width="100%" border="0" class="tabla_lista_resultados">
      <tr >
        <td width="30%" align="right">&nbsp;</td>
        <td width="21%" align="center"><strong style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$sel_item[26]?>&eq_moneda=1&fuera_de_reporte=si','carga_detalle_marcos')">Ver disponible en USD$</strong></td>
        <td width="20%" align="center"><strong  style="cursor:pointer" onclick="ajax_carga('../aplicaciones/reportes/detalle_reporte_saldos_disponible.php?id_item_pecc_para_reporte=<?=$sel_item[26]?>&eq_moneda=2&fuera_de_reporte=si','carga_detalle_marcos')">Ver disponible en COP$</strong></td>
        <td width="29%" align="center"><strong onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato="+document.principal.id_contrato_para_reporte.value,"div_carga_busca_sol")' style="cursor:pointer">Ver Reporte de Contrato Marco Completo</strong></td>
      </tr>
      
    </table>
<div id="carga_detalle_marcos">
  <?
$sel_tipo_moneda = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from t2_marco_temporal where id_item =".$id_item_pecc_marco." and id_usuario = ".$_SESSION["id_us_session"]." "));

if($sel_tipo_moneda[0] > 0 and $sel_tipo_moneda[1]>0){
	$eq_moneda = 1;
	}elseif($sel_tipo_moneda[0] > 0){
		$eq_moneda = 1;
		}elseif($sel_tipo_moneda[1] > 0){
			$eq_moneda = 2;		
			}else{
				$eq_moneda = 1;
				}
				$_GET["oculta_session_include"] = "si";
				$_GET["fuera_de_reporte"] = "si";
				$_GET["id_item_pecc_para_reporte"] = $id_item_pecc_marco;
				include('../../aplicaciones/reportes/detalle_reporte_saldos_disponible.php');
?>
</div>
<table width="100%"> <tr><td align="right"></td></tr></table>
    <?
    }//fin muestra disponible actual
	//fin si es orden de trabajao o ampliacion
	}
	?>
    
    
    
    
    
    
    
    <?
    	if($sel_item[6] == 4 or $sel_item[6] == 5){
			
				$id_contrato_carr = $sel_item[21];
				if($id_contrato_carr != ""){
				?>
    <?
    $sele_si_a_tenido_otro_si = traer_fila_row(query_db("select count(*) from $vpeec24 where id_contrato =".$id_contrato_carr." and t2_item_pecc_id < ".$id_item_pecc));
	
	if($sele_si_a_tenido_otro_si[0] > 0){
	?>
    <?
	}//verifica si a tenido otros si
				?>
<br />
                
                
				<?
				}
		}
?>
    <?
	 if($sel_item[49]==1){
				  $titilo="Distribuci&oacute;n del Valor para Agregar al Disponible para Crear OTs";
				   $titilo2="Lista del Disponible para Agregar al Contrato";
				  }elseif($sel_item[49]==3){
					  $titilo="Seleccione el valor que desea reclasificar del disponible actual ";
					   $titilo2="Lista de los valores que desea reclasificar";
					  }else{
					   $titilo="Seleccione el Valor - Desde aqu&iacute; podr&aacute; distribuir los valores de la solicitud en varios proyectos";
					   $titilo2="Lista de Valores de esta Solictud";
					  }
          if ($edicion_datos_generales == "SI"){
			  
			 
		  ?>	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center"  class="fondo_3"><?=$titilo?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="right"><?=ayuda_alerta_pequena("El valor debe ser incluido únicamente en la moneda de pago")?> </td>
        <td width="8%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo_edicion()" /></td>
      </tr>
      <tr>
        <td width="24%">
         <?
		 if($id_tipo_proceso_pecc == 3){
			 $numero_contra_ot="";
			 
			 $sl_contra_ot ="select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id";
			 
		 $sele_contrato = traer_fila_row(query_db($sl_contra_ot));
		 
		 	$sel_apl_cota = traer_fila_row(query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_contrato[0]));

					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl_cota[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl_cota[0];
					$numero_contrato4 = $sel_apl_cota[2];
					if($numero_contrato3!=""){
					$numero_contra_ot = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl_cota[3])."<br />";
					}
		
		 }
		 if($numero_contra_ot!=""){
		 echo "Contrato de OT: ".$numero_contra_ot."<input type='hidden' name='aplica_contrato' id='aplica_contrato' value ='".$sel_apl_cota[3]."' />";
		 }else{
			 
			 
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
        <select name="aplica_contrato" id="aplica_contrato" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc_marco?>)">
        	<option value="">Selecci&oacute;n de Contratos</option>
           
           <?
           if($id_tipo_proceso_pecc == 2){
		   ?>
            <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
            
            <?
		   }
		   
		   if ($sel_item[6] == 8){
		   if($id_tipo_proceso_pecc == 3 and $sel_item[4] <> 1){// si es de bienes solo despliega opcion de bienes
										 $comple_sql = " and tipo_bien_servicio like '%Bienes%'";
										 }else{//si es servicios solo despliega contratos de servicios
										 $comple_sql = " and (tipo_bien_servicio not like '%Bienes%' or tipo_bien_servicio is null)";
										 }
		   }
				$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2 $comple_sql");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
					
					 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido, contratista, vigencia_mes,analista_deloitte from $co1 where id = ".$sel_cont[0]));
					 
					 $mustra_contrato = "SI";
			$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			if($sel_contrato[4] < $fecha_hoy or $sel_contrato[5] == 1){// si el contrato esta vencido
				$mustra_contrato = "NO";
				}
				
				if($mustra_contrato == "SI"){
			?>
            <option value="<?=$sel_cont[0]?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?></option>
            <?
				}
				}
			?>
        </select>
        <?
			}
		 }
		?>
        </td>
        <td width="9%" align="center">
        
          <select name="ano" id="ano">
          
            <option value="0">A&Ntilde;O</option>
            <? if($sel_item[49] == 3){ echo anos_consulta("NO"); }?>
			<?=anos_presupuesto();?>
          </select>
         
          </td>
        <td width="16%">
        <?
        /*Sin es una reclasificacion no muetre los proyectos que son de socios*/
		if($sel_item[6] == 12){
			//$query_comple = "and t1_naturaleza_contratacion_id = 2";
			}
        /*Sin es una reclasificacion no muetre los proyectos que son de socios*/
		?>
        <select name="campo" id="campo">
          <option value="">&Aacute;rea/Proyecto</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ".$query_comple,0 ,'nombre', 2);?>
        </select></td>
        <td width="13%" align="right">Valor USD$:</td>
        <td width="30%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
      <tr>
        <td colspan="2" align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td><input name="adjunt_presu" type="file" id="adjunt_presu" size="5" /></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
       <?
       if($id_tipo_proceso_pecc ==3){
	   ?>
        <tr>
          <td align="right">Seleccione la Solicitud a la Cual Aplica:</td>
          <td colspan="5" align="right"> <?
		  
		  if($id_item_pecc_marco==312 ){
			  $sl_com="or t2_item_pecc.id_item_peec_aplica = 350";
			  }
		  
         
		  
		  $sel_sql = "select t2_item_pecc.id_item, t2_item_pecc.num1, t2_item_pecc.num2, t2_item_pecc.num3, t2_item_pecc.objeto_solicitud,t1_trm.valor  from t2_item_pecc, t1_trm where (t2_item_pecc.id_item_peec_aplica = ".$id_item_pecc_marco." $sl_com) and t2_item_pecc.t1_tipo_proceso_id in (7, 12) and (t2_item_pecc.estado >=18 and t2_item_pecc.estado <> 31 and t2_item_pecc.estado <> 33 and t2_item_pecc.estado <> 34)  and t2_item_pecc.t1_trm_id = t1_trm.id_trm";
		  

	

		?>
        
        <select name="solicitud_aplica_ots" id="solicitud_aplica_ots">
                            	<option value="">Seleccione la solicitud a la cual desea cargar la Orden de Trabajo</option>
                                <?
                                $valor_eq_ot=0;
								$valor_eq=0;
                                $sel_valor_sol = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto where t2_item_pecc_id = ".$sel_item_marco[0]." and permiso_o_adjudica = 2 and ano >= 2017 group by ano");	
								while($sel_val = traer_fila_db($sel_valor_sol)){
									$valor_eq = $sel_val[0] + ($sel_val[1] / trm_presupuestal($sel_val[2]));
									}
									
if($valor_eq - $valor_eq_ot > 0){								
                                ?>
                                <option value="0"><?= numero_item_pecc($sel_item_marco[16], $sel_item_marco[17], $sel_item_marco[18]); ?> - Valor Aprobado Eq USD$: <?= number_format($valor_eq, 0) ?>, Valor En OTs Eq USD$ <?= number_format($valor_eq_ot, 0) ?> - Esta solicitud genero los contratos </option>
                                <?
}
                                $sel_ampliaciones = query_db($sel_sql);
                                while($sel_apl = traer_fila_db($sel_ampliaciones)){
								
								$valor_eq_ot=0;
								$valor_eq=0;
                                $sel_valor_sol = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto where t2_item_pecc_id = ".$sel_apl[0]." and permiso_o_adjudica = 1 and ano >= 2017 group by ano");	
								while($sel_val = traer_fila_db($sel_valor_sol)){
									$valor_eq = $valor_eq + $sel_val[0] + ($sel_val[1] / trm_presupuestal($sel_val[2]));
									}
									
                                $sel_valor_ot = query_db("select SUM(valor_usd), SUM(valor_cop), ano from t2_presupuesto where id_item_ots_aplica = ".$sel_apl[0]." and permiso_o_adjudica = 1 and ano >= 2017  group by ano");	
								while($sel_ot = traer_fila_db($sel_valor_ot)){
									$valor_eq_ot = $valor_eq_ot + $sel_ot[0] + ($sel_ot[1] / trm_presupuestal($sel_ot[2]));
									}

if($valor_eq - $valor_eq_ot > 0){
                                ?>
           <option value="<?= $sel_apl[0] ?>" <? if($_GET["id_item_ampliacion"] == $sel_apl[0]) echo 'selected="selected"'?> ><?= numero_item_pecc($sel_apl[1], $sel_apl[2], $sel_apl[3]) ?> - Valor Aprobado Eq USD$: <?= number_format($valor_eq, 0) ?>, Valor En OTs Eq USD$ <?= number_format($valor_eq_ot, 0) ?> - <?= substr($sel_apl[4], 0, 100) ?> </option>
                                <?
                                }
							}
                                ?>
                            </select></td>
        </tr>
		 <?
        }else{
			?><input type="hidden" name="solicitud_aplica_ots" id="solicitud_aplica_ots" value="0" /><?
			}
		?>
		<?
		
		 
		if($sel_item[4] <> 1){
        ?>
        <tr>
        <td colspan="4" align="right">Destino:<img src="../imagenes/botones/help.gif" alt="Validar Sitio de Entrega, Operador Logistico o Campo" title="Validar Sitio de Entrega, Operador Logistico o Campo" width="20" height="20" /></td>
        <td><input type="text" name="destino_presu" id="destino_presu" /></td>
        <td width="8%">&nbsp;</td>
      </tr>
      <?
		}
	  ?>
      <tr>
        <td colspan="4" align="right"><? if($sel_item[49]!=3) {?><div id="carga_contratos_aplica"></div><? }?></td>
        <td>&nbsp;</td>
        <td width="8%">&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="cargo_cota_presu" id="cargo_cota_presu" />
      <div id="carga_presupuesto">
<?
    }
	
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco is null or $pi8.al_valor_inicial_para_marco =0)");


	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	
	
?>
<div id="carga_edita_presupuesto"></div>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="10"><div id="carga_edita_presupuesto"></div></td>
  </tr>
  <tr>
    <td colspan="10" align="center"  class="fondo_3"><?=$titilo2?></td>
  </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
    <td width="13%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    
    <?
    if ($sel_item[4]<>1){
	?>
    <td width="16%" align="center" class="fondo_3">Destino</td>
	
    <td width="16%" align="center" class="fondo_3">Relacione el AFE/ CECO disponible para la adquisici&oacute;n:</td>
    <?
	}
	?>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
    <td width="15%" align="center" class="fondo_3">Ver Adjunto</td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?><td width="11%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td><? }?>
    <td width="11%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "A la solicitud que genero los contratos ".numero_item_pecc($sel_item_marco[16],$sel_item_marco[17],$sel_item_marco[18]);
					}else{
							$sel_sol_aplica_ot = traer_fila_row(query_db("select id_item, num1, num2, num3 from t2_item_pecc where id_item = ".$sel_presu[7].""));		
							$num_sol_aplica = numero_item_pecc($sel_sol_aplica_ot[1],$sel_sol_aplica_ot[2],$sel_sol_aplica_ot[3]);
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
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
    <td align="center"><?
	if($sel_item[49]==3 and ($sel_item[14] >6 and $sel_item[14] <> 31)){//solo si es una reclasificacion de contrato marco no muestre
	echo "";
	}else{
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3])."<br />";
			}
	}
	
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    
     <?
    if ($sel_item[4]<>1){
	?>
    <td align="center" ><?=$sel_presu[6]?></td>
	
    <td align="center" ><?=$sel_presu[8]?></td>
    <?
	}
	?>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"> <? if($sel_presu[3] != " "){?><?=saca_nombre_anexo($sel_presu[3])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
                  </a><? }?></td>
   <?
      if($id_tipo_proceso_pecc ==3){
	  ?> <td align="center"><?=$num_sol_aplica?></td><? }?>
    <td align="center">
    <?
    if ($edicion_datos_generales == "SI"){
		
		if($id_tipo_proceso_pecc <>3 and ($sel_item[6]!=12 or $sel_tipo_reclasificacion[0] != 2)){
	?>
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&tipo_ajax=6&id_presupuesto=<?=$sel_presu[0]?>&id_item_pecc_marco='+document.principal.id_item_pecc_marco.value,'carga_edita_presupuesto')" style="cursor:pointer">
    <?
		}
	?>
    
    <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" />
    <?
	}
	
     if(($sel_item[14] > 18 and $sel_item[14] <> 31) and $sel_item[6] == 8){
			?>
			<div align='right' onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&id_presupuesto=<?=$sel_presu[0]?>')" style="cursor:pointer"><img src='../imagenes/mime/pdf.gif'  /> Imprimir OT</div>
            <?
			}
    ?>
    </td>
  </tr>
  <?
  $total_equivale_usd = ($sel_presu[5] / trm_presupuestal($sel_presu[1])) + $sel_presu[4] + $total_equivale_usd;
			}

			
		?>
</table>

<?
if($sel_item[6]!= 16){
?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right"><!-- Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
<? } ?>
<?php if($id_tipo_proceso_pecc != 2){ // Para solicitudes diferentes de apliacion?>


<table width="100%">
	<tr>
    	<td width="50%" valign="top">
        	<table width="100%" border="0" class="tabla_lista_resultados">
                <tr>
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n de valores por AÑO</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="40%">Año<td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php $group_presupuesto_ano = query_db("select $pi8.ano,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco is null or $pi8.al_valor_inicial_para_marco = 0) group by $pi8.ano");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['ano']?></td>
                    <td></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
        <td width="50%" valign="top">
        	<table width="100%" border="0" class="tabla_lista_resultados">
                <tr>
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n por Area/Proyecto</td>
                <tr>
                <tr>
                    <td align="center"  class="fondo_3" width="40%">Area/Proyecto<td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php 
                $group_presupuesto_area = query_db("select $g15.nombre,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and ($pi8.al_valor_inicial_para_marco is null or $pi8.al_valor_inicial_para_marco = 0) group by $g15.nombre");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_area)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['nombre']?></td>
                    <td></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
    <!--- PARA EL INC-008 2017 >
    <tr>
    <td width="50%" colspan="2" valign="top"><table width="50%" border="0" class="tabla_lista_resultados">
      <tr>
          <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n por Tipo de Compra</td>
      <tr>
      <tr>
        <td align="center"  class="fondo_3" width="40%">Tipo de Compra<td>
        <td align="center"  class="fondo_3">Total USD</td>
        <td align="center"  class="fondo_3">Total COP</td>
      </tr>
      <?php 
        
        
        $group_presupuesto_ano = query_db("select razon_social,apellido,sum(valor_usd) as valor_usd,sum(valor_cop) as valor_cop from $vpeec18 where t2_item_pecc_id = $id_item_pecc  group by razon_social,apellido");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
      <tr class="<?=$clase?>">
        <td align="center"><? if($rowGPA['apellido']=="B"){ echo "Bien";}else {echo "Servicios";}?></td>
        <td></td>
        <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
        <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
        </tr>
      <?php }?>
      </table></td>
    </tr>
  <PARA EL INC-008 2017 -->
    <tr>
    	<td colspan="2" align="right">
        <? if($_GET["desde_comite"] != "SI"){?>
        <A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/pecc/reporte_solicitud_excel.php?id_item_pecc=<?=$id_item_pecc?>&amp;id_item_pecc_marco=<?= $id_item_pecc_marco?>'">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A><br />
<br />
<? } ?>
<?
if(solicitud_bienes($sel_item[26]) == "SI" and ($sel_item[6] == 8)){
?>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" align="center" class="fondo_3">LINEA PRESUPUESTAL VIGENTE</td>
    </tr>
  <tr>
    <td width="50%" align="right">Relaciones el AFE/ CECO disponible para la adquisici&oacute;n <img src="../imagenes/botones/help.gif" alt="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" title="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" width="20" height="20" />:</td>
    <td width="50%">
    <?
	
	
	
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <textarea name="detalle_presupuesto" id="detalle_presupuesto" cols="25" rows="5"><?=$sel_item[53]?></textarea>
    <?
    }else{
		echo $sel_item[53];
		}
	?>
    
    </td>
  </tr>
   <?
   if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="button" type="button" class="boton_grabar" id="button" value="Grabar la Justificaci&oacute;n" onclick="graba_justificacion_del_presupuesto()" /></td>
  </tr>
  <?
    }
	?>
</table>

<?
    }
	?>
</td>
    </tr>
    
</table>	

<?php } // Fin if diferente de ampliacion?>

</div>
<?


}//fin si es con solicitudes, OT o Ampliacion y no tienen solicitud relacionada
$valor_total_cop=0;
$valor_total_usd=0;

if(($sel_item[6]==5 and $sel_item[49]==1) or ($sel_item[6]==12 and $sel_item[49]==3) or ($sel_item[6]==16 and ($sel_item[14]>=13 and $sel_item[14]<> 31))){

if ($edicion_datos_generales == "SI" or $edita_info_ad_sm == "SI"){
?>


<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="6" align="center"  class="fondo_3"><? 
	if($sel_item[49]==3) echo "Seleccione como quiere distribuir el valor seleccionado para reclasificar"; elseif($sel_item[6]==16) echo "Seleccione el Valor Servicio Menor"; else echo "Seleccione el Valor Disponible Actual del Contrato que se Convertira a Marco"?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><?=ayuda_alerta_pequena("El valor debe ser incluido únicamente en la moneda de pago")?></td>
    <td width="9%" rowspan="3"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="graba_presupuesto_nuevo_edicion_ini_contrato()" /></td>
  </tr>
  <tr>
    <td width="24%"><?
		 if($id_tipo_proceso_pecc == 3){
			 $numero_contra_ot="";
			 
			 $sl_contra_ot ="select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id";
			 
		 $sele_contrato = traer_fila_row(query_db($sl_contra_ot));
		 
		 	$sel_apl_cota = traer_fila_row(query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_contrato[0]));

					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl_cota[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl_cota[0];
					$numero_contrato4 = $sel_apl_cota[2];
					if($numero_contrato3!=""){
					$numero_contra_ot = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl_cota[3])."<br />";
					}
		
		 }
		 if($numero_contra_ot!=""){
		 echo "Contrato de OT: ".$numero_contra_ot."<input type='hidden' name='aplica_contrato' id='aplica_contrato' value ='".$sel_apl_cota[3]."' />";
		 }else{
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3){
		?>
      <select name="aplica_contrato2" id="aplica_contrato2" onchange="carga_contratos_sin_valores(this.value,<?=$id_item_pecc_marco?>)">
        <option value="">Selecci&oacute;n de Contratos</option>
        <?
          // if($id_tipo_proceso_pecc == 2){
		   ?>
        <option value="0">Uno &oacute; Varios SIN Valores Especificos</option>
        <?
		//   }
            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2");
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
			?>
        <option value="<?=$sel_cont[0]?>">
          <?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[0])?>
          </option>
        <?
				}
			?>
      </select>
      <?
			}else{
				?><input type="hidden" value="0" name="aplica_contrato2" id="aplica_contrato2" /><?
				}
		 }
	/*********SERVICIOS MENORES*******/
	if($sel_item[6]==16){
		
		?><select name="proveedores_busca_adjudicacion_sm" id="proveedores_busca_adjudicacion_sm">
    <option value="">Seleccione el proveedor que sea adjudicar o declare desierto el proceso</option>
    <option value="1">DECLARAR DESIERTO ESTE SERVICIO MENOR</option>
    <?
     $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado, t1.id_us_crea, t1.es_adjudicado, t1.id_relacion_proveedor, t1.listas_restrictivas, t1.justificacion_ingreso_urna, t2.estado_parservicios from $pi13 as t1, $g6 as t2 where t1.id_item = $id_item_pecc and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and (t1.es_adjudicado <> 1 or t1.es_adjudicado is null)  and t1.estado=1 order by  t1.id_relacion_proveedor desc");
			while($se_prove = traer_fila_db($sel_proveedores)){
	?>
    <option value="<?=$se_prove[0]?>"><?=$se_prove[1]?></option>
    <?
			}
	?>
    </select><?
	}
	/**/////////FIN SERVICIOS MENORES ***********/
	
	
		?></td>
    <td width="9%" align="center"><select name="ano2" id="ano2">
      <option value="0">A&Ntilde;O</option>
      <?=anos_presupuesto();?>
    </select></td>
    <td width="16%"><select name="campo2" id="campo2">
      <option value="">&Aacute;rea/Proyecto</option>
      <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
    </select></td>
    <td width="13%" align="right">Valor USD$:</td>
    <td width="29%"><input name="valor_usd2" type="text" id="valor_usd2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
    </tr>
  <tr>
    <td colspan="2" align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
    <td><input name="adjunt_presu2" type="file" id="adjunt_presu2" size="5" /></td>
    <td align="right">Valor COP$:</td>
    <td><input name="valor_cop2" type="text" id="valor_cop2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td colspan="4" align="right"><div id="carga_contratos_aplica"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
       if($id_tipo_proceso_pecc ==3){
	   ?>
  <?
        }else{
			?>
  <input type="hidden" name="solicitud_aplica_ots2" id="solicitud_aplica_ots2" value="0" />
  <?
			}
		?>
  <?
		
		 
		if($sel_item[4] <> 1){
        ?>
  <?
		}
	  ?>
</table>
<? } ?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="10"><div id="carga_edita_presupuesto2"></div></td>
  </tr>
  <tr>
    <td colspan="10" align="center"  class="fondo_3"><? if($sel_item[49]==3) echo "Como quiere distribuir el valor seleccionado para reclasificar"; elseif($sel_item[6]==16) echo "Valor del Servicio Menor Posterior a la Urna Virtual"; else echo "Valor disponible Actual del Contrato"?></td>
  </tr>
  <tr>
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3 or ($sel_item[6]==16)){
		?>
    <td width="13%" align="center" class="fondo_3"><? if($sel_item[6]==16){ echo "Proveedor";}else{ echo "Contrato(s) Marco";}?></td>
    <?
			}
		  ?>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <?
    if ($sel_item[4]<>1){
	?>
    <td width="16%" align="center" class="fondo_3">Destino</td>
    <td width="16%" align="center" class="fondo_3">Cago Contable</td>
    <?
	}
	?>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
    <td width="15%" align="center" class="fondo_3">Ver Adjunto</td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?>
    <td width="11%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td>
    <? }?>
    <td width="11%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?
  
  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable,$pi8.id_relacion_pro_sm from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco =1");
	


		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "Al Valor General del Contrato";
					}else{
							$sel_sol_aplica_ot = traer_fila_row(query_db("select id_item, num1, num2, num3 from t2_item_pecc where id_item = ".$sel_presu[7].""));		
							$num_sol_aplica = numero_item_pecc($sel_sol_aplica_ot[1],$sel_sol_aplica_ot[2],$sel_sol_aplica_ot[3]);
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
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3 or $sel_item[49]==3 or $sel_item[6]==16){
		?>
    <td align="center"><?
				if($sel_item[6]==16){
					
					$sel_pro = traer_fila_row(query_db("select id_proveedor from  t2_relacion_proveedor where id_relacion_proveedor=".$sel_presu[9]));
					if($sel_pro[0]>0){
					echo saca_nombre_lista("t1_proveedor",$sel_pro[0],'razon_social','t1_proveedor_id');
					}
				}else{
				
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3])."<br />";
				}
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    <?
    if ($sel_item[4]<>1){
	?>
    <td align="center" ><?=$sel_presu[6]?></td>
    <td align="center" ><?=$sel_presu[8]?></td>
    <?
	}
	?>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"><? if($sel_presu[3] != " "){?>
      <?=saca_nombre_anexo($sel_presu[3])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&amp;n1=<?=$sel_presu[0]?>&amp;n3=3" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" /> </a>
      <? }?></td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?>
    <td align="center"><?=$num_sol_aplica?></td>
    <? }?>
    <td align="center"><?
    if ($edicion_datos_generales == "SI" or $edita_info_ad_sm == "SI"){
		
		
	?>
      <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" />
      <?
	}
	
     if(($sel_item[14] > 18 and $sel_item[14] <> 31) and $sel_item[6] == 8){
			?>
      <div align='right' onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&amp;id_presupuesto=<?=$sel_presu[0]?>')"><img src='../imagenes/mime/pdf.gif'  /> Imprimir OT</div>
      <?
			}
    ?></td>
  </tr>
  <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr class="titulos_resumen_alertas">
    <td width="34%" align="right"><!--Total de Toda la Solicitud Equivalente USD$:--></td>
    <td width="10%" align="left"><? //=number_format($total_equivale_usd)?></td>
    <td width="11%" align="right">Total USD$:</td>
    <td width="14%" align="left"><?=number_format($valor_total_usd)?></td>
    <td width="11%" align="right">Total COP$:</td>
    <td width="20%" align="left"><?=number_format($valor_total_cop)?></td>
  </tr>
</table>

<?
}
?>
<br />


</td>
<? if ($desde_comite != "SI") {?>
    <td width="23%" rowspan="2" valign="top"><?  echo carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc); ?></td>
 <? }?> 
  </tr>
  <tr>
    <td valign="top"><?
if(solicitud_bienes($sel_item[26]) == "SI" and ($sel_item[6] == 7)){
?>
  <table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td colspan="2" align="center" class="fondo_3">Justificaci&oacute;n del Presupuesto</td>
      </tr>
    <tr>
      <td width="50%" align="right">Detalle de la distribucion del presupuesto de esta solicitud <img src="../imagenes/botones/help.gif" alt="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" title="En este campo el comprador con base en el detalle del estimado justifica, si se encuentra dentro de lo solicitado ó si a pesar de no estar estimado puede gastarse y porque? Ejemplo : No se hará ya el suministro estimado en el pozo x por lo que se puede usar en el pozo" width="20" height="20" />:</td>
      <td width="50%">
        <?
	
	
	
    if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
        <textarea name="detalle_presupuesto" id="detalle_presupuesto" cols="25" rows="5"><?=$sel_item[53]?></textarea>
        <?
    }else{
		echo $sel_item[53];
		}
	?>
        
        </td>
      </tr>
    <?
   if( $sel_item[14] == 6 and $edicion_datos_generales == "SI"){
	?>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="button" type="button" class="boton_grabar" id="button" value="Grabar la Justificaci&oacute;n" onclick="graba_justificacion_del_presupuesto()" /></td>
      </tr>
    <?
    }
	?>
  </table>
      
  <p>
    <?
    }
	?>
  </p>
  
  <table width="200" border="0" class="tabla_lista_resultados">
    <tr class="fondo_3">
      <td align="center">A&Ntilde;O</td>
      <td align="center">TRM</td>
    </tr>
    <tr>
          <td align="center">2013</td>
          <td align="center"><?=number_format(trm_presupuestal(2013),0)?></td>
        </tr>
        <tr>
          <td align="center">2014</td>
          <td align="center"><?=number_format(trm_presupuestal(2014),0)?></td>
        </tr>
        <tr>
          <td align="center">2015</td>
          <td align="center"><?=number_format(trm_presupuestal(2015),0)?></td>
        </tr>
        <tr>
          <td align="center">2016</td>
          <td align="center"><?=number_format(trm_presupuestal(2016),0)?></td>
        </tr>
        <tr>
          <td align="center">2017</td>
          <td align="center"><?=number_format(trm_presupuestal(2017),0)?></td>
        </tr>
        <tr>
          <td align="center">2018</td>
          <td align="center"><?=number_format(trm_presupuestal(2018),0)?></td>
        </tr>
    
  </table>
<?
if(($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 5 or $sel_item[6] == 6 or $sel_item[6] == 7) and $desde_comite != "SI"){
?>
  <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="titulo_afe_ceco" align="center">Relacione el AFE/ CECO disponible para la adquisici&oacute;n <img src="../imagenes/botones/help.gif" alt="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" title="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" width="20" height="20" /></td>
  </tr>
  <tr>
  <td width="14%" align="center" class="fondo_3">PROYECTO.</td>
    <td width="24%" align="center" class="fondo_3">AFE / CECO</td>
    <td colspan="2" align="center" class="fondo_3">ADJUNTO</td>
    <td width="10%" class="fondo_3">&nbsp;</td>

  </tr>
  <?
  $sele_proyectos = query_db("select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)  group by $g15.nombre, $g15.t1_campo_id");
  $falta_algun_afe_ceco = 0;
   if($edicion_datos_generales == "SI"){ 
		  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/botones/aler-interro.gif" height="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."<strong class='letra-descuentos_grande'>Por favor revisar la relaci&oacute;n de AFE / CECO</strong><br />";
		  }
  while($sel_pro = traer_fila_db($sele_proyectos)){
	  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1"));
	  	if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		 
  ?>
  <tr class="<?=$clase?>">
  <td ><?=$sel_pro[0]?></td>
    <td><? if($edicion_datos_generales == "SI"){?><input type="text" name="afe_ceco_<?=$sel_pro[1]?>" id="afe_ceco_<?=$sel_pro[1]?>" value="<?=$sel_afe_ceco[1]?>" /><? }else{ echo $sel_afe_ceco[1]; } ?></td>
    <td width="<? if($edicion_datos_generales == "SI"){ echo "33%";}else{ echo"5%";}?>"><? if($edicion_datos_generales == "SI"){?><input type="file" name="afe_ceco_adjunto_<?=$sel_pro[1]?>" id="afe_ceco_adjunto_<?=$sel_pro[1]?>" /><? }?> </td>
    <td width="19%"><? if($sel_afe_ceco[2] != ""){   
			  ?>
                <?=saca_nombre_anexo($sel_afe_ceco[2])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_afe_ceco[2]?>&n1=<?=$sel_afe_ceco[0]?>&n3=8" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_afe_ceco[2])?>.gif" width="16" height="16" />
                  </a>
                <?
			  }else{
				  if($edicion_datos_generales == "SI"){
				  ?><img src="../imagenes/botones/aler-interro.gif" height="16" /> <font color="#FF0000">Falta incluir AFE / CECO</font><?
				  $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
				  }
			  }?></td>
    <td><? if($edicion_datos_generales == "SI"){?><input type="button" value="Grabar" onclick="graba_afe_ceco_edita(<?=$sel_pro[1]?>, document.principal.afe_ceco_<?=$sel_pro[1]?>.value, document.principal.afe_ceco_adjunto_<?=$sel_pro[1]?>.value)" /><? } ?></td>
  </tr>
  <?
  }
  ?>
</table>
<?
}else{
	$falta_algun_afe_ceco = 0;
	}
/***************************************************************************************
********* INICIO PARA LAS ORDENES DE TRABAJO DEL CONTRATO SERVICIOS TEMPORALES*********/
if($id_item_pecc_aplica==316){
?>
  <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="titulo_afe_ceco" align="center">Relacione el AFE/ CECO disponible para la adquisici&oacute;n <img src="../imagenes/botones/help.gif" alt="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" title="Si no hay cargo contable indicar el estado de aprobaci&oacute;n en el que se encuentra" width="20" height="20" /></td>
  </tr>
  <tr>
  <td width="14%" align="center" class="fondo_3">PROYECTO</td>
    <td width="24%" align="center" class="fondo_3">AFE / CECO</td>
    <td colspan="2" align="center" class="fondo_3">ADJUNTO</td>
    <td width="10%" class="fondo_3">&nbsp;</td>

  </tr>
  <?
  //echo "select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)  group by $g15.nombre, $g15.t1_campo_id";
  //echo "SELECT $g15.nombre, $g15.t1_campo_id, CASE WHEN($pi8.valor_cop)<> 0.00 THEN $pi8.valor_cop ELSE $pi8.valor_usd END AS valor, CASE WHEN($pi8.valor_cop)<> 0.00 THEN 'COP' ELSE 'USD' END AS moneda FROM $pi8, $g15 WHERE $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)";
  $sele_proyectos = query_db("SELECT $g15.nombre, $g15.t1_campo_id, CASE WHEN($pi8.valor_cop)<> 0.00 THEN $pi8.valor_cop ELSE $pi8.valor_usd END AS valor, CASE WHEN($pi8.valor_cop)<> 0.00 THEN 'COP' ELSE 'USD' END AS moneda FROM $pi8, $g15 WHERE $pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and (valor_usd > 0 or valor_cop > 0)");
  $falta_algun_afe_ceco = 0;
   if($edicion_datos_generales == "SI"){ 
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../imagenes/botones/aler-interro.gif" height="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'."<strong class='letra-descuentos_grande'>Por favor revisar la relaci&oacute;n de AFE / CECO</strong><br />";
      }
  while($sel_pro = traer_fila_db($sele_proyectos)){
    //echo "select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1";
    $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where id_item = '".$id_item_pecc."' and id_campo = '".$sel_pro[1]."' and estado = 1 and permiso_adjudica = 1"));
      if($cont == 0){
        $clase= "filas_resultados";
      $cont = 1;
      }else{
        $clase= "";
      $cont = 0;
      }
     
  ?>
  <tr class="<?=$clase?>">
  <td ><?=$sel_pro[0]."-".number_format($sel_pro[2])." ".$sel_pro[3]?></td>
    <td><? if($edicion_datos_generales == "SI"){?><input type="text" name="afe_ceco_<?=$sel_pro[1]?>" id="afe_ceco_<?=$sel_pro[1]?>" value="<?=$sel_afe_ceco[1]?>" /><? }else{ echo $sel_afe_ceco[1]; } ?></td>
    <td width="<? if($edicion_datos_generales == "SI"){ echo "33%";}else{ echo"5%";}?>"><? if($edicion_datos_generales == "SI"){?><input type="file" name="afe_ceco_adjunto_<?=$sel_pro[1]?>" id="afe_ceco_adjunto_<?=$sel_pro[1]?>" /><? }?> </td>
    <td width="19%"><? if($sel_afe_ceco[2] != ""){   
        ?>
                <?=saca_nombre_anexo($sel_afe_ceco[2])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_afe_ceco[2]?>&n1=<?=$sel_afe_ceco[0]?>&n3=8" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_afe_ceco[2])?>.gif" width="16" height="16" />
                  </a>
                <?
        }else{
          if($edicion_datos_generales == "SI"){
          ?><img src="../imagenes/botones/aler-interro.gif" height="16" /> <font color="#FF0000">Falta incluir AFE / CECO</font><?
          $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
          }
        }?></td>
    <td><? if($edicion_datos_generales == "SI"){?><input type="button" value="Grabar" onclick="graba_afe_ceco_edita(<?=$sel_pro[1]?>, document.principal.afe_ceco_<?=$sel_pro[1]?>.value, document.principal.afe_ceco_adjunto_<?=$sel_pro[1]?>.value)" /><? } ?></td>
  </tr>
  <?
  }
  ?>
</table>
<?
}else{
  $falta_algun_afe_ceco = 0;
  }
/************************************************************************************
********* FIN PARA LAS ORDENES DE TRABAJO DEL CONTRATO SERVICIOS TEMPORALES*********/
?>
<input type="hidden" name="id_campo_afe_ceco" id="id_campo_afe_ceco" />
<input type="hidden" name="falta_algun_afe_ceco" id="falta_algun_afe_ceco" value="<?=$falta_algun_afe_ceco?>" />
  <?
 /* ----------- VALOR APROBADO VS SOLICTADO ---------------*/
  $id_comite_ad = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$id_item_pecc." and permiso_o_adjudica = 2 order by id_relacion desc"));
  $id_comite_per = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$id_item_pecc." and permiso_o_adjudica = 1 order by id_relacion desc"));
  $permiso_o_adjudica = 1;
  
	  if($id_comite_ad[0]>0 or $id_comite_per[0]>0){
		$id_comite_apro = $id_comite_per[0];
		$permiso_ad = 1;
		if($id_comite_ad[0]>0){
			$id_comite_apro = $id_comite_ad[0];
			$permiso_ad = 2;
			}	  
	  $sel_datos_comite = traer_fila_Row(query_db("select num1, num2, num3 from t3_comite where id_comite = ".$id_comite_apro));
	  

	  $sel_valores_solicitados = traer_fila_row(query_db("select valor_solicitado_usd, valor_solicitado_cop,  valor_solicitado_eq from  t3_comite_relacion_item where id_item = ".$id_item_pecc." and id_comite = ".$id_comite_apro));
	  
	  
	  
	 if ($sel_item[6] == 11) {
                            $sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        } elseif ($sel_item[6] == 5 or $sel_item[3] == 7) {
					$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
                        }elseif ($sel_item[6] == 12 and $sel_item[49] == 3){//si es reclasificacion de contrato marco							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1 and al_valor_inicial_para_marco = 1"));		
						}elseif ($sel_item[6] == 12 and $sel_item[49] != 3){//si es reclasificacion de contrato puntual							
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));		
							}else{
							$sel_presupuesto = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id = " . $sel_item[0] . " and permiso_o_adjudica = 1"));
							}
							
			if((($sel_valores_solicitados[0] != $sel_presupuesto[0]) or ($sel_valores_solicitados[1] != $sel_presupuesto[1]) and $sel_item[6] <> 12) and  $no_aplica=="aun no aplica"){
	  
	?>
    <table width="100%" border="0">
    <tr >
    <td class="titulos_secciones">&nbsp;</td>
  </tr>
  <tr >
    <td class="titulos_secciones">Valor Solicitado Vs Valor Aprobado en el Comit&eacute; <?=numero_item_pecc($sel_datos_comite[0],$sel_datos_comite[1],$sel_datos_comite[2])?></td>
  </tr>
</table>

    <table width="50%" border="0" align="center" class="tabla_lista_resultados">
  
  <tr class="filas_resultados">
    <td width="38%" rowspan="2" align="right">Valor Solicitado:</td>
    <td width="15%" align="right">USD $: </td>
    <td width="47%"><?=number_format($sel_valores_solicitados[0], 0)?></td>
  </tr>
  <tr class="filas_resultados">
    <td align="right">COP $: </td>
    <td><?=number_format($sel_valores_solicitados[1], 0)?></td>
  </tr>
  <tr>
    <td rowspan="2" align="right">Valor Aprobado en el Comit&eacute;:</td>
    <td align="right">USD $: </td>
    <td><?=number_format($sel_presupuesto[0])?></td>
  </tr>
  <tr>
    <td align="right">COP $: </td>
    <td><?=number_format($sel_presupuesto[1])?></td>
  </tr>
    </table>
<table width="100%" border="0">
  <tr >
    <td class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
    
  
  <?
			}
	  }
/* ----------- FIN VALOR APROBADO VS SOLICTADO ---------------*/
	  ?>
  </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_item_pecc_real" id="id_item_pecc_real" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc_marco" id="id_item_pecc_marco" value="<?=$id_item_pecc_marco?>" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_item[15]?>" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="<?=$sel_item[4]?>" />
<input type="hidden" name="tipo_proceso" value="<?=$t1_tipo_proceso_id?>"/>

<input type="hidden" name="desde_comite" value="<?=$desde_comite?>"/>
<input type="hidden" name="desde_comite_id_comite" value="<?=$_POST["id_comite"]?>"/>
<input type="hidden" name="desde_comite_id_item_pecc" value="<?=$id_item_pecc?>"/>


<input type="hidden" name="reclasificacion_marco" value="<?=$sel_item[49]?>"/>
<input type="hidden" name="id_contrato_para_reporte" value="<?=$id_contrato_para_reporte?>"/>

<?
//imprime_para_comparar();
?>
<div align='right' ><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$sel_item[0]?>&id_presupuesto=<?=$sel_presu[0]?>')">-</strong></div>
</body>
</html>
