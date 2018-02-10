<? if($_GET["genera_excel"]=="si"){
header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte de Contrato.xls"); header("Pragma: no-cache"); header("Expires: 0");
include("../../librerias/lib/@session.php"); 
	}else{
include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
}

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id));
	$no_aplica_poliza = 0;
	

	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
@charset "utf-8";
body {
	color:#676767;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	background:#F8F8F8;
}
.tabla_lista_resultados{  
	margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; 
  BORDER-RIGHT: #cccccc 3px  double; 
  BORDER-TOP: #cccccc 1px solid;  	
  BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  
 }
 .letra-descuentos{ color:#FF3300; cursor:pointer;}
 .estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}
.fondo_3{ background:#005395; color:#FFFFFF;}

.tabla_paginador{ font-size:14px; color:#666666} 

.filas_resultados_reporte_saldos1{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
.filas_resultados_reporte_saldos2{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 0px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
	

.filas_resultados_blanco{ background:#FFFFFF} 
.filas_resultados{ background:#DBFBDC} 

.link_volver:hover{
	
	color:#005395;
	
}
</style>
</head>

<body>


<table width="100%" border="0" cellpadding="2" cellspacing="2" > 
<? if($_GET["genera_excel"]!="si"){?> 
	<tr >
	  <td valign="top" align="right"><strong class='link_volver' style='cursor:pointer;' onclick="taer_menu('menu-contratos.html','contenido_menu');setTimeout(function(){ajax_carga('../aplicaciones/contratos/modulo-historico-contratos.php?paginas=<?=$_SESSION["comple_busqueda"]?>&contrato_bu=<?=$_SESSION['contrato_buh']?>&contratista_bu=<?=$_SESSION['contratista_buh']?>&especialista_bu=<?=$_SESSION['especialista_buh']?>&objeto_bu=<?=$_SESSION['objeto_buh']?>&gerente_bu=<?=$_SESSION['gerente_buh']?>&estado_bu=<?=$_SESSION['estado_buh']?>&tipo_contrato_bu=<?=$_SESSION['tipo_contrato_buh']?>&analista_deloitte=<?=$_SESSION['analista_deloitteh']?>&aplica_portales_bu=<?=$_SESSION['aplica_portales_buh']?>&destino_bu=<?=$_SESSION['destino_buh']?>','contenidos')},2000)">Volver a la Busqueda</strong></td>

  </tr>
  
  <?
}
  	$_SESSION["comple_busqueda"] = "";
  	$_SESSION['contrato_buh'] = "";
	$_SESSION['contratista_buh'] = "";
	$_SESSION['especialista_buh'] = "";
	$_SESSION['objeto_buh']= "";
	$_SESSION['gerente_buh'] = "";
	$_SESSION['estado_buh'] = "";
	$_SESSION['tipo_contrato_buh'] = "";
	$_SESSION['analista_deloitteh'] = "";
	$_SESSION['aplica_portales_buh'] = "";
	$_SESSION['destino_buh'] = "";
  ?>
	<tr >
    	<td width="71%" valign="top" id="carga_acciones_permitidas">
  		
        <!-- inicio crea contrato-->
        <?

imprime_cabeza_contrato($id);

?>
        <? 
		
	$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento from $co1 where id = $id_contrato_arr";

	$sql_con=traer_fila_row(query_db($busca_contrato));
$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$sql_con[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));
	$estado_contrato = $sql_con[27];
	$alerta1 = "";
	$alerta2 = "";
	//echo $estado_contrato."| |".$est_abastecimiento;
	if($estado_contrato==$est_abastecimiento || $estado_contrato==$est_creacion){		
		//$alerta1="<font color='#FF0000'>(*)</font>";
	}
	
	if($estado_contrato==$est_firma_contratista && $sql_con[12]==0){		
		//$alerta2="<font color='#FF0000'>(*)</font>";
	}
	

	$sel_usuario = "select * from $g1 where us_id = $sql_con[9]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_generete = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
	$nombre_generete_sin_id = $sql_sel_usuario[1];
	
	if($sql_con[16]!=""){
	$sel_usuario = "select * from $g1 where us_id = $sql_con[16]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_especialista = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
	}
	
	//inicio identifica si tiene todas las polizas
	  	$count_poliza_llena = traer_fila_row(query_db("select count(distinct(tipo_poliza)) from $co3 where id_contrato = $id_contrato_arr"));
	  	$count_poliza_aplica = traer_fila_row(query_db("select count(distinct(id_poliza)) from $co2 where id_contrato = $id_contrato_arr and id_poliza <> 6"));
		$ok_poliza = 0;
		//echo $count_poliza_llena[0]." ".$count_poliza_aplica[0];
	  	if($count_poliza_llena[0] >=$count_poliza_aplica[0] ){
		 	$ok_poliza = 1;
		}

	//fin identifica si tiene todas las polizas
	
	$edita = 0;
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));

/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_con[9]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

	
	if(($sql_sel_permisos[0]>0 or $sel_contratos_gestiona[0] >0) and $estado_contrato!= 33 and $_GET["genera_excel"]!="si"){
		$edita = 1;
	}
	if($edita==0 ){
		$disabled = " disabled='disabled' ";
	}

$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3, $pi2.t1_area_id from $pi2 where $pi2.id_item=".$sql_con[1];
$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
?>
<?
		if($_GET["aplica_log"] == 1){//Solo aplica cuando viene desde Inbox o historico
			$id_log = log_de_procesos_sgpa(4, 23, 0, $id_contrato_arr , "0", "0");//inserta consulta
		}
		?>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
       <tr>
         <td colspan="5" align="right"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
           <tr >
             <td colspan="4" align="center" valign="top" class="fondo_3">Informaci&oacute;n General del Contrato</td>
             </tr>
           <tr >
             <td width="35%" align="right" valign="top"><strong>Solicitud de Aprobaci&oacute;n:</strong></td>
             <?
         $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con[1]));
		 ?>
             <td colspan="3"><strong <? if($_GET["genera_excel"]!="si"){?> onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sql_con[1]?>&amp;id_tipo_proceso_pecc=<?=$sel_item[0];?>&amp;conse_div=0&amp;permiso_o_adjudica=2')"<? } ?>><font color="#0000FF"><u>
               <?=$consecu_arreglado=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
               </u></font></strong> - <strong>
                 <? if ($_SESSION["id_us_session"]==32){ echo saca_nombre_lista($g12,$sql_sele_items_historico[3],'nombre','t1_area_id');} ?>
                </strong></td>
             </tr>
           <tr>
             <td align="right"><strong>Tipo Contrato:</strong></td>
             <td colspan="2"><?
         if($sql_con[34]==1)
		 	echo "Contrato Puntual";
		else
			echo "Contrato Marco";
		 ?></td>
             </tr>
           <tr>
             <td align="right"><strong>Contratista / Proveedor:</strong></td>
             <td colspan="2"><input name="contratista" type="hidden" id="contratista" size="5" value="<?=$sql_con[5];?>"/>
               <?=$sel_pro_q[3];?></td>
             </tr>
           <tr>
             <td align="right"><strong>Gerente del Contrato:</strong></td>
             <td colspan="2"><? if($edita==1 ){?>
               <input name="gerente" type="text" id="gerente" size="5" value="<?=$nombre_generete;?>" onkeypress="selecciona_lista_general_irre('gerente','../librerias/php/usuarios_general.php')"/>
               <? }else{?>
               <input type="hidden" name="gerente" id="gerente"  value="<?=$nombre_generete;?>" />
               <? $explo_nom1 = explode("-",$nombre_generete); echo $explo_nom1[0]?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Profesional de C&amp;C:</strong></td>
             <td colspan="2"><? if($edita==1 ){?>
               <input name="especialista" type="text" id="especialista" size="5" value="<?=$nombre_especialista;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/>
               <? }else{?>
               <input type="hidden" name="especialista" id="especialista"  value="<?=$nombre_especialista;?>" />
               <? $explo_nom2 = explode("-",$nombre_especialista); echo $explo_nom2[0]?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Gestor de Abastecimiento:</strong></td>
             <td colspan="2">Deloitte, Karen Colorado</td>
             </tr>
           <tr>
             <td align="right"><strong>Fecha Incio del Contrato:</strong></td>
             <td colspan="2" align="left"><? if($edita==1 ){?>
               <input name="fecha_inicio" type="text" id="fecha_inicio" size="5" value="<?=$sql_con[10];?>"  onmouseover="calendario_sin_hora('fecha_inicio')" readonly="readonly"/>
               <? }else{?>
               <input type="hidden" name="fecha_inicio" id="fecha_inicio"  value="<?=$sql_con[10];?>" />
               <?=$sql_con[10];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Fecha Fin del Contrato:</strong></td>
             <td colspan="2" align="left"><? if($edita==1 ){?>
               <input name="fecha_fin" type="text" id="fecha_fin" size="5" value="<?=$sql_con[11];?>"  onmouseover="calendario_sin_hora('fecha_fin')" readonly="readonly"/>
               <? }else{?>
               <input type="hidden" name="fecha_fin" id="fecha_fin"  value="<?=$sql_con[11];?>" />
               <?=$sql_con[11];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Objeto:</strong></td>
             <td colspan="2"><? if($edita==1 ){?>
               <textarea name="objeto" id="objeto" cols="25" rows="3"><?=$sql_con[3];?>
           </textarea>
               <? }else{?>
               <input type="hidden" name="objeto" id="objeto" value="<?=$sql_con[3];?>" />
               <?=$sql_con[3];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Monto:</strong></td>
             <td colspan="2"><?
        if($sql_con[34]==2){?>
               <strong onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;block&quot;;ajax_carga(&quot;../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato=<?=$id_contrato_arr?>&quot;,&quot;div_carga_busca_sol&quot;)' style="cursor:pointer">Ver rerpote de contrato Marco</strong>
               <input name="monto_usd" type="hidden" id="monto_usd" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[17]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
               <input name="monto_cop" type="hidden" id="monto_cop" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[18]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
               <? }else{
		?>
               <table width="99%" border="0" cellpadding="2" cellspacing="2" >
                 <tr>
                   <td align="right" width="0" class="titulos_resumen_alertas">USD</td>
                   <td align="left" class="titulos_resumen_alertas"><input name="monto_usd" type="hidden" id="monto_usd" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[17]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
                     <?=valida_numero_imp($sql_con[17]);?></td>
                   </tr>
                 <tr>
                   <td width="8%" align="right" class="titulos_resumen_alertas">COP</td>
                   <td width="92%" align="left" class="titulos_resumen_alertas"><input name="monto_cop" type="hidden" id="monto_cop" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[18]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
                     <?=valida_numero_imp($sql_con[18]);?></td>
                   </tr>
                 <?
  	$lista_poliza = "select * from $g7 where estado = 1 order by orden";

	$sql_poliza=query_db($lista_poliza);
	while($lista_poliza=traer_fila_row($sql_poliza)){
		$lista_poliza_che = "select id,id_contrato,id_poliza from $co2 where id_contrato = $id_contrato_arr and id_poliza = $lista_poliza[0]";	
		$sql_poliza_che=traer_fila_row(query_db($lista_poliza_che));
		$che = "";

		if($sql_poliza_che[0] >= 1){
			$che = "checked='checked'"; 
		}

		if($sql_poliza_che[2] == 6){
			$no_aplica_poliza = 1;
		}
	?>
                 <?
	}
	  ?>
                 </table>
               <?
		}
		?></td>
             </tr>
           <tr>
             <td align="right"><strong>Aplica Portales:</strong></td>
             <td colspan="2"><? if($edita==1 ){?>
               <select name="aplica_portales" id="aplica_portales">
                 <option value="0" <? if($sql_con[50]==1){echo "selected='selected'";}?> >Seleccione</option>
                 <option value="1" <? if($sql_con[50]==1){echo "selected='selected'";}?> >SI</option>
                 <option value="2" <? if($sql_con[50]==2){echo "selected='selected'";}?> >NO</option>
                 </select>
               <? }else{?>
               <input type="hidden" name="aplica_portales" id="aplica_portales"  value="<?=$sql_con[50];?>" />
               <?
        $conge_text1="";
		if($sql_con[50]==1){
			$conge_text1="SI";
		}
		if($sql_con[50]==2){
			$conge_text1="NO";
		}
		echo $conge_text1;
		?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Destino:</strong></td>
             <td colspan="2"><?
        
		$busca_maestra = "select id,nombre from $g25 where id = $sql_con[51]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));

		?>
               <? if($edita==1 ){?>
               <select name="destino" id="destino">
                 <?=listas($g25, " estado = 1 ",$sql_con[51],'nombre', 1);?>
                 </select>
               <? }else{?>
               <input type="hidden" name="destino" id="destino"  value="<?=$sql_con[51];?>" />
               <?=$sql_maestra[1];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>&nbsp;Aplica Acta Incio:</strong></td>
             <td width="15%" >
               <? if($_GET["genera_excel"]!="si" and $edita==1) {?>
               <input type="checkbox" name="aplica_acta_inicio" id="aplica_acta_inicio" <? if($sql_con[12] == 1){ echo "checked='checked'";}?> value="1" <?=$disabled;?>/>
               <? } else{ if($sql_con[12] == 1) {echo "SI";} else echo "NO"; }?>
               </td>
             <td width="50%" colspan="2">&nbsp;</td>
             </tr>
           <tr>
             <td align="right"><strong>Congelado:</strong></td>
             <td colspan="2"><? if($edita==1 ){?>
               <select name="analista_deloitte" id="analista_deloitte">
                 <option value="1" <? if($sql_con[42]==1){echo "selected='selected'";}?> >SI</option>
                 <option value="0" <? if($sql_con[42]!=1){echo "selected='selected'";}?> >NO</option>
                 </select>
               <? }else{?>
               <input type="hidden" name="analista_deloitte" id="analista_deloitte"  value="<?=$sql_con[42];?>" />
               <?
        $conge_text="NO";
		if($sql_con[42]==1){
			$conge_text="SI";
		}
		echo $conge_text;
		?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Observaciones Congelado:</strong></td>
             <td colspan="2"><span class="titulos_resumen_alertas">
               <? if($edita==1 ){?>
               <textarea name="obs_congelado" id="obs_congelado" cols="25" rows="1"><?=$sql_con[49];?>
          </textarea>
               <? }else{?>
               <input type="hidden" name="obs_congelado" id="obs_congelado" value="<?=$sql_con[49];?>" />
               <?=$sql_con[49];?>
               <? }?>
               </span></td>
             </tr>
           <tr>
             <td align="right"><strong>&Aacute;rea Ejecuci&oacute;n:</strong></td>
             <td colspan="2"><?
        
		$busca_maestra = "select id,nombre from $g24 where id = $sql_con[48]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));

		?>
               <? if($edita==1 ){?>
               <select name="area_ejecucion" id="area_ejecucion">
                 <?=listas($g24, " estado = 1 ",$sql_con[48],'nombre', 1);?>
                 </select>
               <? }else{?>
               <input type="hidden" name="area_ejecucion" id="area_ejecucion"  value="<?=$sql_con[48];?>" />
               <?=$sql_maestra[1];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><strong>Aseguramiento Administrativo:</strong></td>
             <td colspan="2"><?
        
		$busca_maestra2 = "select id,nombre from t1_tipo_aseguramiento_admin where id = $sql_con[52]";
		$sql_maestra2=traer_fila_row(query_db($busca_maestra2));

		?>
               <? if($edita==1 ){?>
               <select name="aseguramiento_admin" id="aseguramiento_admin">
                 <?=listas("t1_tipo_aseguramiento_admin", " estado = 1 ",$sql_con[52],'nombre', 1);?>
                 </select>
               <? }else{?>
               <input type="hidden" name="aseguramiento_admin" id="aseguramiento_admin"  value="<?=$sql_con[52];?>" />
               <?=$sql_maestra2[1];?>
               <? }?></td>
             </tr>
           <tr>
             <td align="right"><p><strong>Aplica cl&aacute;usula 6 Retenci&oacute;n en  Garant&iacute;a? :</strong></p></td>
             <td align="left"><? if($edita == 1){?><select name="retencion_garantia" id="retencion_garantia" onchange="retencion_garantia_valida(this.value)">
               <option value="0">Seleccione</option>
               <option value="1" <? if($sql_con[53]==1){echo "selected='selected'"; }?>>SI</option>
               <option value="2" <? if($sql_con[53]==2){echo "selected='selected'"; $sql_con[54]=0; $sql_con[55]=0;}?>>NO</option>
               </select><? }else{ if($sql_con[53]==1) echo "SI"; if($sql_con[53]==2)echo "NO";} ?></td>
             <td colspan="2" align="left"><div id="aplica_garantia" <? if ($sql_con[53] =="" or $sql_con[53]==2) echo 'style="display:none"'?>>
               <table width="99%" border="0" cellpadding="2" cellspacing="2">
                 <tr>
                   <td align="left"><? if($edita == 1){?><select name="porcen_garantia" id="porcen_garantia" onchange="">
                     <option value="0">Porcentaje</option>
                     <option value="1" <? if($sql_con[54]==1){echo "selected='selected'";}?>>1%</option>
                     <option value="5" <? if($sql_con[54]==5){echo "selected='selected'";}?>>5%</option>
                     </select><? }else{ if($sql_con[54]==1) echo "1%"; if($sql_con[54]==5)echo "5%";} ?></td>
                   <td align="left"><? if($edita == 1){?><select name="parcial_final_garantia" id="parcial_final_garantia" onchange="">
                     <option value="0">En que Momento</option>
                     <option value="1"<? if($sql_con[55]==1){echo "selected='selected'";}?>>Parcial</option>
                     <option value="2"<? if($sql_con[55]==2){echo "selected='selected'";}?>>Al Liquidar el contrato</option>
                     </select><? }else{ if($sql_con[55]==1) echo "Parcial"; if($sql_con[55]==2)echo "Al Liquidar el contrato";} ?></td>
                   </tr>
                 </table>
               </div></td>
             </tr>
           </table>
           <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
             <tr>
               <td colspan="4" align="center" class="fondo_3">Informaci&oacute;n del Contratista / Proveedor</td>
              </tr>
             <tr>
               <td align="right" width="35%"><?=$alerta1;?>
                 Contratista / Proveedor:</td>
               <td width="65%" colspan="3" align="left"><input name="contratista2" type="hidden" id="contratista2" size="5" value="<?=$sql_con[5];?>"/>
                 <?=$sel_pro_q[3];?></td>
              </tr>
             <tr>
               <?
		
		
//			$estado_proveedor = readfile('http://www.parservicios.com/parservi/ficha_estado_hocol_2.php?ref=principal.html&pv_id='.$sel_pro_q[1]);
//la conexion a par
/*	if($_SESSION["id_us_session"] == 32){
		echo 'http://www.parservicios.com/parservi/ficha_estado_hocol_2.php?ref=principal.html&pv_id='.$sel_pro_q[1];
		}*/
		 ?>
               <td align="right"><?=$alerta1;?>
                 NIT:</td>
               <td colspan="3" align="left"><input name="nit" type="hidden" id="nit" size="5" value="<?=$sel_pro_q[1];?>"/>                 <?=$sel_pro_q[1];?></td>
              </tr>
             
             <tr>
               <td align="right"><?=$alerta1;?>
                 Contacto Principal:</td>
               <td  colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="contacto_principal" type="text" id="contacto_principal" size="5" value="<?=$sql_con[6];?>"/>
                 <? }else{?>
                 <input type="hidden" name="contacto_principal" id="contacto_principal" value="<?=$sql_con[6];?>" />
                 <?=$sql_con[6];?>
                 <? }?></td>
              </tr>
             <tr>
               <td align="right"><?=$alerta1;?>
                 Email Contacto Principal:</td>
               <td colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="email1" type="text" id="email1" size="5" value="<?=$sql_con[7];?>"/>
                 <? }else{?>
                 <input type="hidden" name="email1" id="email1"  value="<?=$sql_con[7];?>" />
                 <?=$sql_con[7];?>
                 <? }?></td>
              </tr>
             <tr>
               <td align="right"><?=$alerta1;?>
                 Tel&eacute;fono Contacto Principal:</td>
               <td colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="telefono1" type="text" id="telefono1" size="5" value="<?=$sql_con[8];?>"/>
                 <? }else{?>
                 <input type="hidden" name="telefono1" id="telefono1"  value="<?=$sql_con[8];?>" />
                 <?=$sql_con[8];?>
                 <? }?></td>
              </tr>
             <tr>
               <td align="right">Representante Legal:</td>
               <td colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="representante_legal" type="text" id="representante_legal" size="5" value="<?=$sql_con[13];?>"/>
                 <? }else{?>
                 <input type="hidden" name="representante_legal" id="representante_legal"  value="<?=$sql_con[13];?>" />
                 <?=$sql_con[13];?>
                 <? }?></td>
              </tr>
             <tr>
               <td align="right">Email Representante Legal:</td>
               <td colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="email2" type="text" id="email2" size="5" /value="<?=$sql_con[14];?>" />
                 <? }else{?>
                 <input type="hidden" name="email2" id="email2"  value="<?=$sql_con[14];?>" />
                 <?=$sql_con[14];?>
                 <? }?></td>
              </tr>
             <tr>
               <td align="right">Tel&eacute;fono Representante Legal:</td>
               <td colspan="3" align="left"><? if($edita==1 ){?>
                 <input name="telefono2" type="text" id="telefono2" size="5" value="<?=$sql_con[15];?>"/>
                 <? }else{?>
                 <input type="hidden" name="telefono2" id="telefono2"  value="<?=$sql_con[15];?>" />
                 <?=$sql_con[15];?>
                 <? }?></td>
              </tr>
          </table></td>
         <td align="right" valign="top"><table width="95%" border="0" align="center" class="tabla_lista_resultados">
           <tr>
             <td  <? if($edita==1) {?>colspan="2"<? }?> align="center" class="fondo_3">Polizas Aplicables</td>
             </tr>
           <?
  	$lista_poliza = "select * from $g7 where estado = 1 order by orden";

	$sql_poliza=query_db($lista_poliza);
	while($lista_poliza=traer_fila_row($sql_poliza)){
		$lista_poliza_che = "select id,id_contrato,id_poliza from $co2 where id_contrato = $id_contrato_arr and id_poliza = $lista_poliza[0]";	
		$sql_poliza_che=traer_fila_row(query_db($lista_poliza_che));
		$che = "";

		if($sql_poliza_che[0] >= 1){
			$che = "checked='checked'"; 
		}

		if($sql_poliza_che[2] == 6){
			$no_aplica_poliza = 1;
		}
		$muestra="SI";
		
		if($edita!=1 and $che != "checked='checked'"){ $muestra="NO";}
		
		if($muestra=="SI"){
	?>
           <tr>
             <? if($edita==1) {?>
             <td width="4%"><input type="checkbox" name="poliza_aplica[]" id="poliza_aplica[]" value="<?=$lista_poliza[0];?>" <?=$che;?> <?=$disabled;?>/></td><? }?>
             <td >&nbsp;
               <?=$lista_poliza[1];?></td>
             </tr>
           <?
		}
	}
	  ?>
          </table></td>
         <td colspan="3" align="right" valign="top"><table width="100%" align="center" class="tabla_lista_resultados" <? if($_GET["genera_excel"]=="si"){?> border="1" <? }?>>
           <?
        	$entro = 0;
			?>
           <tr class="fondo_3">
             <td colspan="9" align="center">LISTA DE CHEQUEO DE LA LEGALIZACION DEL CONTRATO</td>
           </tr>
           <tr class="fondo_3">
             <td colspan="2" align="center">Detalle</td>
             <td width="10%" align="center"><strong>Inicio</strong></td>
             <td width="10%" align="center"><strong>Fin</strong></td>
             <td width="42%" align="center"><strong>Observaciones</strong></td>
             <td width="5%" align="center">&nbsp;</td>
             <td width="3%" align="center">Dias Estimados</td>
             <td width="2%" align="center">Dias Reales</td>
             <td width="3%" align="center">Dias  Retraso</td>
           </tr>
           <?
			
			$campos_tabla = " * ";
			  $alerta_incompletos ="";
			  if($sql_con[53]==1){
				  $comple_sql_leg = "";
				  }else{
					  $comple_sql_leg = " and id not in (20)";
					  }
              $sel_campos = query_db("select * from t7_relacion_campos_legalizacion where id > 0 ".$comple_sql_leg." order by orden");
			  $conteo1=0;
			  $conteo2=1;
			  
			
$sel_campos_contra = traer_fila_db(query_db("select count(*) from t7_relacion_campos_legalizacion_datos where id_contrato =".$id_contrato_arr));			
if($sel_campos_contra[0]==0){//si tiene creado en la tabla de la relacion de los campos
$insert = query_db("insert into t7_relacion_campos_legalizacion_datos (id_contrato, f_fin_creacion_sistema, f_ini_elaboracion,f_fin_elaboracion) values (".$id_contrato_arr.", '".$sql_con[19]."', '".$sql_con[19]."', '".$sql_con[20]."')");
}else{
$update = query_db("update t7_relacion_campos_legalizacion_datos set f_fin_elaboracion='".$sql_con[47]."' where id_contrato = ".$id_contrato_arr);
	}

$sel_campos_contra = traer_fila_db(query_db("select ".$campos_tabla." from t7_relacion_campos_legalizacion_datos where id_contrato =".$id_contrato_arr));
			  while($s_cam = traer_fila_db($sel_campos)){
				  	$edita_fecha_1=0;
					$edita_fecha_2=0;
					$edita_ob=0;
					
/*ACTUALIZA CAMPOS QUE SE ALIMENTEN DE OTRAS FECHAS fecha_inicial_igual_a_id_relacion_campo*/
if($s_cam[9] != "" and $s_cam[9] != "0"){
	$update =query_db("update t7_relacion_campos_legalizacion_datos set ".$s_cam[3]." = '".$sel_campos_contra[$s_cam[9]]."' where id_contrato =".$id_contrato_arr);
	$sel_campos_contra = traer_fila_db(query_db("select ".$campos_tabla." from t7_relacion_campos_legalizacion_datos where id_contrato =".$id_contrato_arr));
	}
/*ACTUALIZA CAMPOS QUE SE ALIMENTEN DE OTRAS FECHAS fecha_inicial_igual_a_id_relacion_campo*/



			/*INICIO PERMISOS DE EDICION*/
			$sel_permiso_edita_fecha_ini = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (".$s_cam[7].")"));
			$sel_permiso_edita_fecha_fin = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (".$s_cam[8].")"));
			
				  if($s_cam[7] != 0 and $sel_permiso_edita_fecha_ini[0]>0 and ($sel_campos_contra[$s_cam[3]] =="" or $sel_campos_contra[$s_cam[3]] ==" ")){$edita_fecha_1=1; if($s_cam[7] == 21 and $edita != 1) $edita_fecha_1=0; }
				  if($s_cam[8] != 0 and $sel_permiso_edita_fecha_fin[0]>0 and ($sel_campos_contra[$s_cam[4]] =="" or $sel_campos_contra[$s_cam[4]] ==" ")){$edita_fecha_2=1; if($s_cam[8] == 21 and $edita != 1) $edita_fecha_2=0;}
				  if($edita_fecha_1 != 0 or $edita_fecha_2 != 0){
					  $edita_ob=1; 
					   }
		   /*FIN PERMISOS DE EDICION*/  
		   
		   
$dias_reales="";
$dias_retraso="";	
			if($sel_campos_contra[$s_cam[3]] != "" and $sel_campos_contra[$s_cam[3]] != " " and $sel_campos_contra[$s_cam[3]] != "  " and $sel_campos_contra[$s_cam[4]] != "" and $sel_campos_contra[$s_cam[4]] != " " and $sel_campos_contra[$s_cam[4]] != "  "){

				if($sel_campos_contra[$s_cam[3]] <= $sel_campos_contra[$s_cam[4]])
						$dias_retraso=0;
						$dias_reales = dias_habiles_entre_fechas($sel_campos_contra[$s_cam[3]],$sel_campos_contra[$s_cam[4]]);
			}
			
			if($dias_reales!=""){
					$dias_retraso = $dias_reales-$s_cam[11];
					if($dias_retraso <=0) {$dias_retraso=0;}else{ $dias_retraso="<strong class='letra-descuentos'>".$dias_retraso."</strong>";}
				}
				  
				  $expo = explode(".", $s_cam[6]);
				  if($expo[1]==0 or $expo[1]==""){
					  $conteo1=$conteo1+1;
					  if($clase==""){
					  $clase="class='filas_resultados'";
					  }else{
						  $clase="";
						  }
						  $alerta="";
						  if($s_cam[12]!=""){
						  $alerta='<br /><strong class="letra-descuentos"><img src="../imagenes/botones/aler-interro.gif" height="20" /> '.$s_cam[12].'</strong>';
                          }
                          
			  ?>
           <tr <?=$clase?>>
             <td colspan="2" valign="top"><? if($_GET["genera_excel"]!="si"){?>
               <img src="../imagenes/botones/help.gif" alt="<?=$s_cam[5]?>" width="20" height="20" title="<?=$s_cam[5]?>" />
               <? }?>
               <?=$conteo1?>
               .
               <?=$s_cam[2]?></td>
             <td align="center" valign="top"><? if($edita_fecha_1 == 1){?>
               <input name="<?=$s_cam[3]?>" type="text" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>" size="10" maxlength="10" onmouseover="calendario_sin_hora('<?=$s_cam[3]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'ini')"/>
               <? }else{ echo $sel_campos_contra[$s_cam[3]]; ?>
               <input name="<?=$s_cam[3]?>" type="hidden" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>"/>
               <? }?></td>
             <td align="center" valign="top"><? if($edita_fecha_2 == 1){?>
               <input name="<?=$s_cam[4]?>" type="text" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>" size="10" maxlength="10" onmouseover="calendario_sin_hora('<?=$s_cam[4]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'fin', document.principal.<?=$s_cam[3]?>)"/>
               <? } else{ echo $sel_campos_contra[$s_cam[4]]; ?>
               <input name="<?=$s_cam[4]?>" type="hidden" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>"/>
               <? }?></td>
             <td valign="top"><? if($edita_ob == 1){?>
               <textarea name="<?=$s_cam[10]?>" id="<?=$s_cam[10]?>" cols="5" rows="3"><?=$sel_campos_contra[$s_cam[10]]?>
           </textarea>
               <? echo $alerta;} else{ echo $sel_campos_contra[$s_cam[10]];}?></td>
             <td valign="top"><? if($edita_ob == 1){
	if($alerta_incompletos !="" and $s_cam[0] == 12){
		$alerta_incompletos_alerta = "alert('No puede completar este paso hasta que complete: ".$alerta_incompletos."')";
	}else{
		$ob_obligatoria = "NO";
		if($s_cam[13] == 1){
			$ob_obligatoria = "SI";
			}
		$alerta_incompletos_alerta = "graba_fecha_leg(document.principal.".$s_cam[3].", document.principal.".$s_cam[4].", document.principal.".$s_cam[10].", '".$s_cam[3]."', '".$s_cam[4]."', '".$s_cam[10]."','".$ob_obligatoria."')";
		}
	
	?>
               <input name="button" type="button" class="boton_grabar" id="button" value="Grabar" onclick="<?=$alerta_incompletos_alerta?>;"/>
               <? }?></td>
             <td align="center" valign="top"><?=$s_cam[11]?></td>
             <td align="center" valign="top"><?=$dias_reales?></td>
             <td align="center" valign="top"><?=$dias_retraso?></td>
           </tr>
           <?
			  
			  $conteo2=1;
			   if($edita_fecha_1 != 0 or $edita_fecha_2 != 0){
					    if($s_cam[0] != 12) $alerta_incompletos.= "\\n * ".$conteo1.". ".$s_cam[2];
					  }
			  	  }else{
					  if($edita_fecha_1 != 0 or $edita_fecha_2 != 0){
					    if($s_cam[0] != 12) $alerta_incompletos.= "\\n * ".$conteo1.".".$conteo2.". ".$s_cam[2];
					  }
			  ?>
           <tr <?=$clase?>>
             <td width="3%" valign="top" bgcolor="#F7F7F7">&nbsp;</td>
             <td width="22%" valign="top"><? if($_GET["genera_excel"]!="si"){?>
               <img src="../imagenes/botones/help.gif" alt="<?=$s_cam[5]?>" title="<?=$s_cam[5]?>" width="20" height="20"  />
               <? }?>
               <?=$conteo1?>
               .
               <?=$conteo2?>
               .
               <?=$s_cam[2]?></td>
             <td align="center" valign="top"><? if($edita_fecha_1 == 1){?>
               <input name="<?=$s_cam[3]?>" type="text" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>" size="10" maxlength="10" onmouseover="calendario_sin_hora('<?=$s_cam[3]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'ini')"/>
               <? }else{ echo $sel_campos_contra[$s_cam[3]]; ?>
               <input name="<?=$s_cam[3]?>" type="hidden" id="<?=$s_cam[3]?>" value="<?=$sel_campos_contra[$s_cam[3]]?>"/>
               <? }?></td>
             <td align="center" valign="top"><? if($edita_fecha_2 == 1){?>
               <input name="<?=$s_cam[4]?>" type="text" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>" size="10" maxlength="10" onmouseover="calendario_sin_hora('<?=$s_cam[4]?>')" readonly="readonly" onchange="valida_fecha_ideal_legalizacion_contrato(this, 'fin', document.principal.<?=$s_cam[3]?>)"/>
               <? } else{ echo $sel_campos_contra[$s_cam[4]]; ?>
               <input name="<?=$s_cam[4]?>" type="hidden" id="<?=$s_cam[4]?>" value="<?=$sel_campos_contra[$s_cam[4]]?>"/>
               <? }?></td>
             <td valign="top"><? if($edita_ob == 1){?>
               <textarea name="<?=$s_cam[10]?>" id="<?=$s_cam[10]?>" cols="5" rows="3" ><?=$sel_campos_contra[$s_cam[10]]?>
           </textarea>
               <? } else{ echo $sel_campos_contra[$s_cam[10]];}?></td>
             <td valign="top"><? if($edita_ob == 1){?>
               <input name="button" type="button" class="boton_grabar" id="button" value="Grabar" onclick="graba_fecha_leg(document.principal.<?=$s_cam[3]?>, document.principal.<?=$s_cam[4]?>, document.principal.<?=$s_cam[10]?>, '<?=$s_cam[3]?>', '<?=$s_cam[4]?>', '<?=$s_cam[10]?>');"/>
               <? }?></td>
             <td align="center" valign="top"><?=$s_cam[11]?></td>
             <td align="center" valign="top"><?=$dias_reales?></td>
             <td align="center" valign="top"><?=$dias_retraso?></td>
           </tr>
           <?
				$conteo2=$conteo2+1;
				  }
			  }
			?>
         </table></td>
        </tr>
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="36%" colspan="2">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="27%" align="right"><? if($edita==1 ){?><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Informacion Contrato" onclick="graba_informacion_contrato(<?=$estado_contrato;?>);"/><? }?></td>
      </tr>
      <tr>
        <td colspan="9">&nbsp;</td>
      </tr>
      <? if($_GET["genera_excel"]!="si"){?> 
      <tr>
        <td colspan="9" align="right"><strong style="cursor:pointer" onClick="abrir_ventana('../aplicaciones/contratos/v_contratos_excel.php?id=<?=$id?>&genera_excel=si')" >Exportar reporte a Excel <img src="../imagenes/mime/xlsx.gif"  /></strong></td>
      </tr>
      <? }?>
</table>
<input name="campo_fecha" type="hidden" />
<input name="aplica_acta_inicio_env" type="hidden" value="<?=$sql_con[12];?>" />
<input name="ok_poliza" type="hidden" value="<?=$ok_poliza;?>" />
<input name="estado_proveedor" type="hidden" value="<?=$estado_proveedor;?>" />
<input name="no_aplica_poliza" type="hidden" value="<?=$no_aplica_poliza;?>" />

<input name="fecha_inicial" id="fecha_inicial" type="hidden" />
<input name="fecha_final" id="fecha_final" type="hidden" />
<input name="observacion" id="observacion" type="hidden" />

<input name="fecha_inicial_campo" id="fecha_inicial_campo" type="hidden" />
<input name="fecha_final_campo" id="fecha_final_campo" type="hidden" />
<input name="observacion_campo" id="observacion_campo" type="hidden" />



        <!-- fin crea contrato-->
        
        
      </td>
   	</tr>
 
</table>
<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="<?=arreglo_pasa_variables($id_contrato_arr)?>" />

</body>
</html>
