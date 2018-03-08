<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id));
	//echo "sdfasdfsa".$id_contrato_arr;
	$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($id_complemento));
	

/*validacion para que el valor del contrato sea igual a las aprobaciones*/
$alert_validacion_valor_contra = valor_contrato_puntual($id_contrato_arr);
/*FIN validacion*/


	if($id_complemento_arr==""){
		$id_complemento_arr=0;
	}
	$class_calendar = "";
	$busca_contrato_tipo = "select t1_tipo_documento_id, gerente,estado, id_item from $co1 where id = $id_contrato_arr";
	$sql_tipo=traer_fila_row(query_db($busca_contrato_tipo));
	$estado_contrato = $sql_tipo[2];
	
	$busca_complemento = "select id,id_contrato,tipo_complemento,tipo_otrosi,gerente,CAST(alcance AS text) as alcance,tiempo,tipo_moneda,valor,clausula,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,numero_otrosi,CAST( observaciones AS TEXT),fecha_inicio,acta_socios,recibido_poliza,camara_comercio,id_item_pecc,valor_cop,sel_representante,legalizacion_final_par,legalizacion_final_par_e,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,congelado,CAST(obs_congelado AS TEXT), fecha_suspencion, fecha_reinicio from $co4 where id = $id_complemento_arr";
	

	//echo $busca_complemento = "select id,id_contrato,tipo_complemento,tipo_otrosi,gerente,CAST(alcance AS text) as alcance,tiempo,tipo_moneda,valor,clausula,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,numero_otrosi,observaciones,fecha_inicio,acta_socios,recibido_poliza,camara_comercio,id_item_pecc,valor_cop,sel_representante,legalizacion_final_par,legalizacion_final_par_e,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,congelado,obs_congelado from $co4 where id = $id_complemento_arr";
	
	$sql_com=traer_fila_row(query_db($busca_complemento));
	$disable="";
	if($id_complemento_arr<>""){
		$id_item_pecc = $sql_com[31];
		if($id_item_pecc>0){
			$id_tipo_complemento = "1,2,3,4";
			$id_tipo_otro_si = "2,3,4,8,9,10,11,12,13,14, 15, 16, 17";
			$edita2=1;
		}else{
			$class_calendar = " onmouseover='calendario_sin_hora(this.name)'";
			$id_tipo_complemento = "1,2,3,4";
			$id_tipo_otro_si = "2,3,4,8,9,10,11,12,13,14, 15, 16, 17";
			$edita2=1;
		}

		$sel_usuario = "select * from $g1 where us_id = $sql_com[4]";
    	$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		if($sql_sel_usuario[0]>0){
		$nombre_generete = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
		}
	
		$style1 = "";	
		$style2 = "";	
		$style3 = "";	
		$style4 = "";
		$style5 = "";
		$style6 = "";
		$style7 = "";
		$style8 = "";	
		if($sql_com[3]==8){
			$disable = "disabled='disabled'";
		}
	}else{
		$style1 = "style='display:none'";	
		$style2 = "style='display:none'";	
		$style3 = "style='display:none'";	
		$style4 = "style='display:none'";
		$style5 = "style='display:none'";
		$style6 = "style='display:none'";
		$style7 = "style='display:none'";	
		$edita2=1;
		$id_tipo_complemento = "1,2,3,4";
		$id_tipo_otro_si = "2,3,4,8,9,10,11,12,13,14";
	}
	
	if($sql_com[2]==1){
		$style1 = "style='display:none'";	
	}
	if($sql_com[2]==2){
		$style2 = "style='display:none'";
	}
	if($sql_com[2]==3 || $sql_com[2]==4){
		$style3 = "style='display:none'";
	}
	
	if($sql_com[3]==2){
		$style4 = "style='display:none'";
	}
	if($sql_com[3]==3 || $sql_com[3]==14){
		$style5 = "style='display:none'";
	}
	if($sql_com[3]==4){
		$style6 = "style='display:none'";
	}
	if($sql_com[3]==8){
		$style7 = "style='display:none'";
	}
	if($sql_com[3]==9){
		//$style8 = "style='display:none'";
	}
	
	if($sql_com[3]==10){
		$style10 = "style='display:none'";
	}
	if($sql_com[3]==11){
		$style11 = "style='display:none'";
	}
	if($sql_com[3]==12){
		$style12 = "style='display:none'";
	}
	if($sql_com[3]==13){
		$style13 = "style='display:none'";
	}
	if($sql_com[3]==15){
		$style15 = "style='display:none'";
	}
	if($sql_com[3]==16){
		$style16 = "style='display:none'";
	}
	if($sql_com[3]==17){
		$style17 = "style='display:none'";
	}
	
	
	
	$lista_poliza_che = "select id,id_contrato,id_poliza from $co2 where id_contrato = $id_contrato_arr and id_poliza = 6";	
	$sql_poliza_che=traer_fila_row(query_db($lista_poliza_che));
	$no_aplica_poliza = 0;
	if($sql_poliza_che[2] == 6){
		$no_aplica_poliza = 1;
	}
		
	$edita = 0;
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	
	


/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_com[4]));
$sel_contratos_gestiona_del_contrato = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_tipo[1]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	
	if(($id_complemento_arr == 0 or $sql_sel_permisos[0]>0 or $sel_contratos_gestiona[0]>0 or $sel_contratos_gestiona_del_contrato[0]>0) and $estado_contrato != 50){
		$edita = 1;
	}
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.filas_sub_resultados {background:#E9E9E9}
</style>
</head>

<body>
<div id="carga_acciones_permitidas">
     <?
       
echo imprime_cabeza_contrato($id);

?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
    <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="4" class="fondo_3" align="center">DATOS</td>
        </tr>
    <?
	
    if($edita==1 or ($id_complemento_arr != 0 and $id_complemento_arr != "" )){
	//	if($id_complemento_arr == 0){

	?>
    
      <?
	  
      if($id_item_pecc>0){
		 $sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$id_item_pecc;
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
         $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id, id_item_peec_aplica from $pi2 where id_item=".$id_item_pecc));
		 
	  }
	  ?>
      <tr>
        <td align="right">Solicitud de Aprobaci&oacute;n en SGPA:</td>
        <td>
  <? 

if($sql_com[2]==2){		
        $sel_ots_relacionados = query_db("select distinct id_item_ots_aplica from t2_presupuesto where t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1");
		while($sel_apro = traer_fila_db($sel_ots_relacionados)){
			if($sel_apro[0] ==""){
				$sele_items_relacionado = traer_fila_row(query_db("select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sel_item[1]));
				$id_item_rel = $sel_item[1];
				$id_tipo_proceso_pecc = 1;
				}else{
			$sele_items_relacionado = traer_fila_row(query_db("select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sel_apro[0]));
			$id_item_rel = $sel_apro[0];
			$id_tipo_proceso_pecc = 2;
				}
			
			}
}

if($sql_com[2]==3 or $sql_com[2]==4) {
			$sele_items_relacionado = traer_fila_row(query_db("select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_tipo[3]));
			$id_item_rel = $sql_tipo[3];
			$id_tipo_proceso_pecc = 1;
	}
			
$numeros_aplica.= "  <strong  style='cursor:pointer' onclick=abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=".$id_item_rel."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."&conse_div=0&permiso_o_adjudica=2')><font color='#0000FF'>".numero_item_pecc($sele_items_relacionado[0],$sele_items_relacionado[1],$sele_items_relacionado[2])."</font></strong>";		
		
//		""

 if($sql_com[2]==2) { echo $numeros_aplica; }else { 
 ?>
<strong style="cursor:pointer"  onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$id_item_pecc;?>&id_tipo_proceso_pecc=1&conse_div=0&permiso_o_adjudica=2')" } >
 <font color="#0000FF"><?  if($id_item_pecc !="" and $id_item_pecc!=0){ echo numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2]); }?></font></strong>
 <?
	  
	  if($id_item_pecc =="" or $id_item_pecc==0){
		  $sel_lista_modificaoin = query_db("select * from v_contrato_lista_modificaciones where id_contrato = ".$id_contrato_arr." order by id desc");
   while($sel_mod = traer_fila_db( $sel_lista_modificaoin)){

	   if($sel_mod[16] > 0){
		  // $sol_relaciona.=",".$sel_mod[16]; 
		   }
   }


		  $sel_relacionada = query_db("select num1,num2,num3,nombre, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (5,7, 9,10,11,12,15,1, 2, 6) and (id_solicitud_relacionada in (".$sql_tipo[3]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_tipo[3].") or id_item in (".$sql_tipo[3]."))  and ($pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31) order by fecha_creacion desc");
			?><select name="sol_aprobacion" id="sol_aprobacion">
				<option value="0">Ninguna</option><?
				while ($rowSR = traer_fila_db($sel_relacionada)){
					?><option value="<?=$rowSR[4]?>"><?=numero_item_pecc($rowSR[0],$rowSR[1],$rowSR[2])?></option><?
				}
			?></select><?
		  }
		  
		 
 ?>
 
 </td>
        <td></td>
        <td align="center">&nbsp;</td>
      </tr>
      <?

	 
	
	   
	  
	}
		   	$numero_otro_si_imp = $sql_com[25];
	  
      ?>
      <?
       
	 

	?>
      <tr>
        <td align="right"><? 

		if($sql_com[2]==2) echo "Orden de Trabajo"; 
		elseif($sql_com[2]==1) echo "N&uacute;mero OtroS&iacute;"; 
		elseif($sql_com[2]==3) echo "N&uacute;mero Suspencion"; 
		elseif($sql_com[2]==4) echo "N&uacute;mero Reinicio";
		else echo "Numero";?>:</td>
        <td>
        <? if($sql_com[2]==2){ ?>
        <font color="#0000FF"><strong style="cursor:pointer" onclick=abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$id_item_pecc;?>')><?=$numero_otro_si_imp;?></strong></font>
        
        <input name="numero_modificacion" type="hidden" id="numero_modificacion"  value="<?=$numero_otro_si_imp;?>" />
        <?
		}else{
			if($edita ==1){
		?>
        <input name="numero_modificacion" type="text" id="numero_modificacion"  value="<?=$numero_otro_si_imp;?>" />
        <?
			}else{
				echo $numero_otro_si_imp;
				}
		}
		?>
        
        
        
        </td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="24%" align="right">Tipo de Evento:</td>
        <td width="20%">
        
        
        <? if($edita2==1 and $sql_com[2] =="" and $edita == 1 ){?><select name="tipo_complemento" id="tipo_complemento" onchange="activa_otrosi(this.value)"  <?=$disabled?>>
        
		<?=listas($g8, " estado = 1 and id in ($id_tipo_complemento) ",$sql_com[2],'nombre', 1);?>
        </select><? }else{?><input type="hidden" name="tipo_complemento" id="tipo_complemento" value="<?=$sql_com[2];?>" /><?=llena_valor_lista("id,nombre",$g8,"id=".$sql_com[2])?><? }?>
          
          </td>
        <td width="31%">&nbsp;</td>
        <td width="25%" align="center">&nbsp;</td>
        </tr>
      <tr id="fila1" <?=$style2;?> <?=$style3;?>>
        <td align="right">Tipo OtroSI:</td>
        <td>  <? if($edita2==1 and $edita == 1 ){?><select name="tipo_otrosi" id="tipo_otrosi" onchange="activa_otrosi_tipo(this.value)">
          <?=listas($g9, " estado = 1 and id in ($id_tipo_otro_si)",$sql_com[3],'nombre', 1);?>
          </select><? }else{?><input type="hidden" name="tipo_otrosi" id="tipo_otrosi" value="<?=$sql_com[3];?>" /><?=llena_valor_lista("id,nombre",$g9,"id=".$sql_com[3])?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr  id="fila2" <?=$style2?><?=$style5?><?=$style6?><?=$style7?><?=$style11?><?=$style12?><?=$style13?><?=$style15?><?=$style16?><?=$style17?><?=$style10?>>
        <td align="right" ><? if($sql_com[2]=="") echo "Gerente"; if($sql_com[2]==2) echo "Gerente Orden de Trabajo"; if($sql_com[2]==1) echo "Gerente OtroS&iacute;"; if($sql_com[2]==3) echo "Gerente de Suspencion"; if($sql_com[2]==4) echo "Gerente del Reinicio";?>:</td>
        <td><? if($edita == 1){?><input name="gerente" type="text" id="gerente"  value="<?=$nombre_generete;?>"  onkeypress="selecciona_lista_general_irre('gerente','../librerias/php/usuarios_general.php')"/><? }?></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr id="fila3" <?=$style3;?> <?=$style4;?> <?=$style5;?> <?=$style7;?> <?=$style8;?><?=$style13;?> <?=$style15?><?=$style17?>>
        <td align="right">
		<? 
		if($id_complemento_arr==0){
			if($sql_tipo[0]==1){
					echo "Alcance:";
			}
			if($sql_tipo[0]==2){
					echo "Objeto Orden de Trabajo:";
			}
			if($sql_com[2]=="" or $sql_com[2]==0){
					echo "Objeto";
			}
		}else{
			if($sql_com[2]==1){
					echo "Alcance:";
			}
			if($sql_com[2]==2){
					echo "Objeto Orden de Trabajo:";
			}
			
		
		}
		?>
        
        </td>
        <td colspan="3"><? if($edita2==1 and $edita == 1 ){?><textarea name="alcance" id="alcance" cols="45" rows="4"><?=$sql_com[5];?></textarea><? }else{?><input type="hidden" name="alcance" id="alcance" value="<?=$sql_com[5];?>" /><?=$sql_com[5];?><? }?></td>
        </tr>
      
      <?
      if($sql_com[2]==3 or $sql_com[2]==4){
		  
		  if($sql_com[2]==4 and $sql_com[43] == ""){
			  $sel_ultima_suspencion = traer_fila_row(query_db("select top(1) fecha_suspencion from t7_contratos_complemento where id_contrato = ".$id_contrato_arr." and tipo_complemento = 3"));
			  $sql_com[43] = $sel_ultima_suspencion[0];
			  }
	  ?>
      <tr >
        <td align="right" >Fecha de Suspencion:</td>
        <td><? if($edita2==1 and $edita == 1 and $sql_com[2]==3){?><input name="fecha_suspencion" type="text" id="fecha_suspencion"  value="<?=$sql_com[43];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/><? }else{?><?=$sql_com[43];?><input name="fecha_suspencion" type="hidden" id="fecha_suspencion"  value="<?=$sql_com[43];?>"/><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
	  }
	  if($sql_com[2]==4){
	  ?>
      <tr >
        <td align="right" >Fecha de Reinicio:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="fecha_reinicio" type="text" id="fecha_reinicio"  value="<?=$sql_com[44];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/><? }else{?><?=$sql_com[44];?><input name="fecha_reinicio" type="hidden" id="fecha_reinicio"  value="<?=$sql_com[44];?>"/><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
	  }
	  ?>
      <tr id="fila4" <?=$style1;?> <?=$style3;?> <?=$style8;?> <?=$style15?><?=$style16?> <?=$style17?>>
        <td align="right" >Fecha Inicio:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="fecha_inicio" type="text" id="fecha_inicio"  value="<?=$sql_com[27];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/><? }else{?><input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?=$sql_com[27];?>" /><?=$sql_com[27];?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr id="fila5" <?=$style2;?> <?=$style3;?> <?=$style5;?> <?=$style6;?> <?=$style7;?> <?=$style8;?><?=$style11;?> <?=$style15?> <?=$style17?>>
        <td align="right">Dias de Ampliaci&oacute;n del Contrato:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="tiempo" type="text" id="tiempo"  value="<?=$sql_com[6];?>" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/><? }else{?><input type="hidden" name="tiempo" id="tiempo" value="<?=$sql_com[6];?>" /><?=$sql_com[6];?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr id="fila10" <?=$style3;?> <?=$style4;?> <?=$style5;?><?=$style6;?> <?=$style7;?> <?=$style8;?><?=$style10;?><?=$style11;?><?=$style12;?><?=$style13;?> <?=$style15?> <?=$style16?><?=$style17?>>
        <td align="right">Fecha Fin:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="fecha_fin" type="text" id="fecha_fin"  value="<?=$sql_com[6];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/><? }else{?><input type="hidden" name="fecha_fin" id="fecha_fin" value="<?=$sql_com[6];?>" /><?=$sql_com[6];?><? }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id="fila6" <?=$style3;?> <?=$style4;?> <?=$style6;?> <?=$style7;?> <?=$style8;?><?=$style12;?><?=$style15?><?=$style16?>>
        <td align="right">Valor COP:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="valor2" type="text" id="valor2"  value="<?=valida_numero_imp($sql_com[32]);?>" onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;"  onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/><? }else{?><input type="hidden" name="valor2" id="valor2" value="<?=$sql_com[32];?>" /><?=number_format($sql_com[32],0);?><? }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr id="fila7" <?=$style3;?> <?=$style4;?> <?=$style6;?> <?=$style7;?> <?=$style8;?><?=$style12;?><?=$style15?><?=$style16?>>
        <td align="right">Valor USD:</td>
        <td><? if($edita2==1 and $edita == 1 ){?><input name="valor" type="text" id="valor"  value="<?=valida_numero_imp($sql_com[8]);?>" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"  onKeyUp="puntos(this,this.value.charAt(this.value.length-1))"/><? }else{?><input type="hidden" name="valor" id="valor" value="<?=$sql_com[8];?>" /><?=number_format($sql_com[8],0);?><? }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      
  <?
	if($sql_com[2]==1 or $sql_com[2]==0 or $sql_com[2]==""){
  ?>
      <tr id="fila8" >
        <td align="right">Clausula Modificada:</td>
        <td colspan="3"><? if($edita == 1){?><input name="clausula" type="text" id="clausula"  value="<?=$sql_com[9];?>"/><? } else { echo $sql_com[9];}?></td>
        </tr>
  <?
	}else{
		?>
		<input name="clausula" type="hidden" id="clausula"  value="<?=$sql_com[9];?>"/>
		<?
		}
  ?>
        
        
        
        <tr id="fila9">
        <td align="right">Observaciones:</td>
        <td colspan="3">
          <? if($edita == 1){?><textarea name="observaciones" id="observaciones" cols="45" rows="3"><?=$sql_com[26];?></textarea><? } else { echo $sql_com[26];}?></td>
        </tr>
         <tr>
           <td align="right">Congelado:</td>
           <td>
           <? if($edita == 1){?>
           <select name="congelado" id="congelado">
             <option value="1" <? if($sql_com[41]==1){echo "selected='selected'";}?> >SI</option>
             <option value="0" <? if($sql_com[41]!=1){echo "selected='selected'";}?> >NO</option>
           </select>
           <? }else{ if($sql_com[41]==1) echo "SI"; else  echo "NO";} ?>
           </td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
        </tr>
         <tr>
           <td align="right">Observaciones Congelado:</td>
           <td colspan="3"><span class="titulos_resumen_alertas">
           <? if($edita == 1){?>
             <textarea name="obs_congelado" id="obs_congelado" cols="25" rows="1"><?=$sql_com[42];?>
             </textarea><? } else { echo $sql_com[42];}?>
           </span></td>
        </tr>
        <? if($edita == 1){?>
         <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
        <?
		$funci = "graba_informacion_complemento(".$id_complemento_arr.")";
        if($alert_validacion_valor_contra != ""){
			$funci = "alert('".$alert_validacion_valor_contra."')";
			}
		?>
        <input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Proceso" onclick="<?=$funci?>"/></td>
        </tr>
        <? }?>
     <?
      if($id_complemento_arr>=1){
	  ?>
      <tr>
        <td colspan="4"> <?
			
			legalizaciones_de_contratos("modificacion", $id_complemento_arr, $edita)
			
			?></td>
      </tr>
        <?
        }
		?>
     
      
      </table>
      <?
	}
	  ?>
      <BR />
      

      
    </td>
  </tr>     
      
    </table>
    </td>
  </tr>
 <?
 

 ?>
</table>
<input name="id_complemento" type="hidden" value="<?=$id_complemento;?>" />
<input name="campo_fecha" type="hidden" />
<input name="no_aplica_poliza" type="hidden" value="<?=$no_aplica_poliza;?>"/>

<input name="id_actividad_guarda" id="id_actividad_guarda" type="hidden" />
<input name="fecha_inicial" id="fecha_inicial" type="hidden" />
<input name="fecha_final" id="fecha_final" type="hidden" />
<input name="observacion" id="observacion" type="hidden" />
<input name="observacion_rol2" id="observacion_rol2" type="hidden" />

<input name="fecha_inicial_campo" id="fecha_inicial_campo" type="hidden" />
<input name="fecha_final_campo" id="fecha_final_campo" type="hidden" />
<input name="observacion_campo" id="observacion_campo" type="hidden" />
<input name="observacion_campo_rol2" id="observacion_campo_rol2" type="hidden" />

<input name="id_campo_legalizacion" id="id_campo_legalizacion" type="hidden" />

<input name="id_rol_fecha1" id="id_rol_fecha1" type="hidden" />
<input name="id_rol_fecha2" id="id_rol_fecha2" type="hidden" />

<input name="da" id="da" type="hidden" value="<?=$_GET["da"]?>" />

<input name="edita_fecha_2" id="edita_fecha_2" type="hidden" value="<?=$edita_fecha_2?>" />
<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="<?=$id?>" />
</div>
</body>
</html>
