<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id));
	$no_aplica_poliza = 0;
	
	

	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>


<table width="100%" border="0" cellpadding="2" cellspacing="2" >  
	<tr >
	  <td valign="top" align="right"><strong class='link_volver' style='cursor:pointer;' onclick="taer_menu('menu-contratos.html','contenido_menu');setTimeout(function(){ajax_carga('../aplicaciones/contratos/modulo-historico-contratos.php?paginas=<?=$_SESSION["comple_busqueda"]?>&contrato_bu=<?=$_SESSION['contrato_buh']?>&contratista_bu=<?=$_SESSION['contratista_buh']?>&especialista_bu=<?=$_SESSION['especialista_buh']?>&objeto_bu=<?=$_SESSION['objeto_buh']?>&gerente_bu=<?=$_SESSION['gerente_buh']?>&estado_bu=<?=$_SESSION['estado_buh']?>&tipo_contrato_bu=<?=$_SESSION['tipo_contrato_buh']?>&analista_deloitte=<?=$_SESSION['analista_deloitteh']?>&aplica_portales_bu=<?=$_SESSION['aplica_portales_buh']?>&destino_bu=<?=$_SESSION['destino_buh']?>','contenidos')},2000)">Volver a la Busqueda</strong></td>

  </tr>
  <?
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
		
	$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$estado_contrato = $sql_con[27];
	$alerta1 = "";
	$alerta2 = "";
	//echo $estado_contrato."| |".$est_abastecimiento;
	if($estado_contrato==$est_abastecimiento || $estado_contrato==$est_creacion){		
		$alerta1="<font color='#FF0000'>(*)</font>";
	}
	
	if($estado_contrato==$est_firma_contratista && $sql_con[12]==0){		
		$alerta2="<font color='#FF0000'>(*)</font>";
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

	
	if(($sql_sel_permisos[0]>0 or $sel_contratos_gestiona[0] >0) and $estado_contrato!= 33){
		$edita = 1;
	}
	if($edita==0 ){
		$disabled = " disabled='disabled' ";
	}

$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3, $pi2.t1_area_id from $pi2 where $pi2.id_item=".$sql_con[1];
$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
?>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
       <tr >
         <td colspan="2" align="right" valign="top"><img src="../imagenes/botones/help.gif" title="Visualizaci&oacute;n e impresi&oacute;n de la solicitud creada para el contrato" width="20" height="20" /> Item</td>
          <?
         $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con[1]));
		 ?>
         <td colspan="2"><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sql_con[1]?>&id_tipo_proceso_pecc=<?=$sel_item[0];?>&conse_div=0&permiso_o_adjudica=2')"><font color="#0000FF"><u>
        
           <?=$consecu_arreglado=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
         </u></font></strong>  - <strong> <? if ($_SESSION["id_us_session"]==32){ echo saca_nombre_lista($g12,$sql_sele_items_historico[3],'nombre','t1_area_id');} ?></strong>
         
         
         </td>
        <td colspan="2" align="right">&nbsp;</td>
        <td colspan="2">
        <?
		if($_GET["aplica_log"] == 1){//Solo aplica cuando viene desde Inbox o historico
			$id_log = log_de_procesos_sgpa(4, 23, 0, $id_contrato_arr , "0", "0");//inserta consulta
		}
		?>
        </td>
        </tr>

       <tr>
         <td colspan="2" align="right"><strong>Gerente Contrato:</strong></td>
         <td colspan="2"><?=$nombre_generete_sin_id;?></td>
         <td colspan="2" align="right">&nbsp;</td>
         <td colspan="2" class="titulos_resumen_alertas">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2" align="right"><strong>Tipo Contrato:</strong></td>
         <td colspan="6">
		 <?
         if($sql_con[34]==1)
		 	echo "Normal";
		else
			echo "Contrato Marco";
		 ?>
         </td>
       </tr>
       <tr>
         <td colspan="2" align="right"><?=$alerta1;?>
         Objeto:</td>
         <td colspan="6"><? if($edita==1 ){?><textarea name="objeto" id="objeto" cols="25" rows="1"><?=$sql_con[3];?></textarea><? }else{?><input type="hidden" name="objeto" id="objeto" value="<?=$sql_con[3];?>" /><?=$sql_con[3];?><? }?></td>
        </tr>
       <tr>
        <?
		$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$sql_con[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));
		
//			$estado_proveedor = readfile('http://www.parservicios.com/parservi/ficha_estado_hocol_2.php?ref=principal.html&pv_id='.$sel_pro_q[1]);
//la conexion a par
/*	if($_SESSION["id_us_session"] == 32){
		echo 'http://www.parservicios.com/parservi/ficha_estado_hocol_2.php?ref=principal.html&pv_id='.$sel_pro_q[1];
		}*/
		 ?>
         <td colspan="2" align="right"><?=$alerta1;?>
         NIT:</td>
         <td colspan="2"><input name="nit" type="hidden" id="nit" size="5" value="<?=$sel_pro_q[1];?>"/><?=$sel_pro_q[1];?></td>
         <td colspan="2" align="right">Congelado:</td>
         <td colspan="2" ><? if($edita==1 ){?> <select name="analista_deloitte" id="analista_deloitte">
        <option value="1" <? if($sql_con[42]==1){echo "selected='selected'";}?> >SI</option>
        <option value="0" <? if($sql_con[42]!=1){echo "selected='selected'";}?> >NO</option>
        </select><? }else{?><input type="hidden" name="analista_deloitte" id="analista_deloitte"  value="<?=$sql_con[42];?>" />
		<?
        $conge_text="NO";
		if($sql_con[42]==1){
			$conge_text="SI";
		}
		echo $conge_text;
		?>
		<? }?>
        </td>

       </tr>
       <tr>
        <td colspan="2" align="right"><?=$alerta1;?>
         Contratista:</td>
        
        <td colspan="2"><input name="contratista" type="hidden" id="contratista" size="5" value="<?=$sql_con[5];?>"/><?=$sel_pro_q[3];?></td>
        <td colspan="2" align="right">Observaciones Congelado:</td>
         <td colspan="2" class="titulos_resumen_alertas"><? if($edita==1 ){?><textarea name="obs_congelado" id="obs_congelado" cols="25" rows="1"><?=$sql_con[49];?></textarea><? }else{?><input type="hidden" name="obs_congelado" id="obs_congelado" value="<?=$sql_con[49];?>" /><?=$sql_con[49];?><? }?></td>        
      </tr>
       <tr>
         <td colspan="2" align="right"><?=$alerta1;?>
         Contacto Principal:</td>
         <td colspan="2">
         <? if($edita==1 ){?><input name="contacto_principal" type="text" id="contacto_principal" size="5" value="<?=$sql_con[6];?>"/><? }else{?><input type="hidden" name="contacto_principal" id="contacto_principal" value="<?=$sql_con[6];?>" /><?=$sql_con[6];?><? }?>
         </td>
         <td colspan="2" align="right">Representante Legal:</td>
         <td colspan="2" >
         <? if($edita==1 ){?><input name="representante_legal" type="text" id="representante_legal" size="5" value="<?=$sql_con[13];?>"/><? }else{?><input type="hidden" name="representante_legal" id="representante_legal"  value="<?=$sql_con[13];?>" /><?=$sql_con[13];?><? }?>
         </td>
       </tr>
       <tr>
         <td colspan="2" align="right"><?=$alerta1;?>
         Email:</td>
         <td colspan="2">
         <? if($edita==1 ){?><input name="email1" type="text" id="email1" size="5" value="<?=$sql_con[7];?>"/><? }else{?><input type="hidden" name="email1" id="email1"  value="<?=$sql_con[7];?>" /><?=$sql_con[7];?><? }?>
         </td>
         <td colspan="2" align="right">Email:</td>
         <td colspan="2"> <? if($edita==1 ){?><input name="email2" type="text" id="email2" size="5" /value="<?=$sql_con[14];?>"><? }else{?><input type="hidden" name="email2" id="email2"  value="<?=$sql_con[14];?>" /><?=$sql_con[14];?><? }?></td>
       </tr>
       <tr>
         <td colspan="2" align="right"><?=$alerta1;?>
         Tel&eacute;fono:</td>
         <td colspan="2"><? if($edita==1 ){?><input name="telefono1" type="text" id="telefono1" size="5" value="<?=$sql_con[8];?>"/><? }else{?><input type="hidden" name="telefono1" id="telefono1"  value="<?=$sql_con[8];?>" /><?=$sql_con[8];?><? }?></td>
         <td colspan="2" align="right">Tel&eacute;fono:</td>
         <td colspan="2"><? if($edita==1 ){?><input name="telefono2" type="text" id="telefono2" size="5" value="<?=$sql_con[15];?>"/><? }else{?><input type="hidden" name="telefono2" id="telefono2"  value="<?=$sql_con[15];?>" /><?=$sql_con[15];?><? }?></td>
       </tr>
      <tr>
        <td colspan="2" align="right"><?=$alerta1;?>
        Gerente:</td>
        <td colspan="2"><? if($edita==1 ){?><input name="gerente" type="text" id="gerente" size="5" value="<?=$nombre_generete;?>" onkeypress="selecciona_lista_general_irre('gerente','../librerias/php/usuarios_general.php')"/><? }else{?><input type="hidden" name="gerente" id="gerente"  value="<?=$nombre_generete;?>" /><?=$nombre_generete;?><? }?></td>
        <td colspan="2" align="right"><?=$alerta1;?>&nbsp;Profesional de C&amp;C:</td>
        <td colspan="2"><? if($edita==1 ){?><input name="especialista" type="text" id="especialista" size="5" value="<?=$nombre_especialista;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/><? }else{?><input type="hidden" name="especialista" id="especialista"  value="<?=$nombre_especialista;?>" /><?=$nombre_especialista;?><? }?></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?=$alerta2;?>
        Fecha Incio:</td>
        <td colspan="2"><? if($edita==1 ){?><input name="fecha_inicio" type="text" id="fecha_inicio" size="5" value="<?=$sql_con[10];?>"  onMouseOver="calendario_sin_hora('fecha_inicio')" readonly="readonly"/><? }else{?><input type="hidden" name="fecha_inicio" id="fecha_inicio"  value="<?=$sql_con[10];?>" /><?=$sql_con[10];?><? }?></td>
        <td colspan="2" align="right"><?=$alerta1;?>
          &nbsp;&Aacute;rea Ejecuci&oacute;n:</td>
        <td colspan="2" align="left">
        <?
        
		$busca_maestra = "select id,nombre from $g24 where id = $sql_con[48]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));

		?>
        <? if($edita==1 ){?> <select name="area_ejecucion" id="area_ejecucion">
          <?=listas($g24, " estado = 1 ",$sql_con[48],'nombre', 1);?>
        </select><? }else{?><input type="hidden" name="area_ejecucion" id="area_ejecucion"  value="<?=$sql_con[48];?>" /><?=$sql_maestra[1];?><? }?>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?=$alerta2;?>
          Fecha Fin:</td>
        <td colspan="2"><? if($edita==1 ){?>
          <input name="fecha_fin" type="text" id="fecha_fin" size="5" value="<?=$sql_con[11];?>"  onmouseover="calendario_sin_hora('fecha_fin')" readonly="readonly"/>
          <? }else{?>
          <input type="hidden" name="fecha_fin" id="fecha_fin"  value="<?=$sql_con[11];?>" />
          <?=$sql_con[11];?>
          <? }?></td>
        <td colspan="2" align="right"><?=$alerta1;?>
          Monto:</td>
        <td align="center" class="titulos_resumen_alertas">USD</td>
        <td class="titulos_resumen_alertas"><input name="monto_usd" type="hidden" id="monto_usd" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[17]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
          <?=valida_numero_imp($sql_con[17]);?></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?=$alerta1;?>Aplica Portales:</td>
        <td colspan="2">
        <? if($edita==1 ){?>
        <select name="aplica_portales" id="aplica_portales">
        <option value="0" <? if($sql_con[50]==1){echo "selected='selected'";}?> >Seleccione</option>
          <option value="1" <? if($sql_con[50]==1){echo "selected='selected'";}?> >SI</option>
          <option value="2" <? if($sql_con[50]==2){echo "selected='selected'";}?> >NO</option>
        </select>
        <? }else{?><input type="hidden" name="aplica_portales" id="aplica_portales"  value="<?=$sql_con[50];?>" />
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
		<? }?>
        </td>
        <td colspan="2" align="right">&nbsp;</td>
        <td width="6%" align="center" class="titulos_resumen_alertas">COP</td>
        <td width="26%" class="titulos_resumen_alertas"><input name="monto_cop" type="hidden" id="monto_cop" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con[18]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
          <?=valida_numero_imp($sql_con[18]);?></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><?=$alerta1;?>Destino:</td>
        <td colspan="2">
         <?
        
		$busca_maestra = "select id,nombre from $g25 where id = $sql_con[51]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));

		?>
        <? if($edita==1 ){?>
        <select name="destino" id="destino">
          <?=listas($g25, " estado = 1 ",$sql_con[51],'nombre', 1);?>
        </select>
        <? }else{?><input type="hidden" name="destino" id="destino"  value="<?=$sql_con[51];?>" /><?=$sql_maestra[1];?><? }?>
        </td>
        <td colspan="2" align="right"><?=$alerta1;?>Aseguramiento Administrativo:</td>
        <td colspan="2">
        
         <?
        
		$busca_maestra2 = "select id,nombre from t1_tipo_aseguramiento_admin where id = $sql_con[52]";
		$sql_maestra2=traer_fila_row(query_db($busca_maestra2));

		?>
        <? if($edita==1 ){?>
        <select name="aseguramiento_admin" id="aseguramiento_admin">
          <?=listas("t1_tipo_aseguramiento_admin", " estado = 1 ",$sql_con[52],'nombre', 1);?>
        </select>
        <? }else{?><input type="hidden" name="aseguramiento_admin" id="aseguramiento_admin"  value="<?=$sql_con[52];?>" /><?=$sql_maestra2[1];?><? }?>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="right">&nbsp;Aplica Acta Incio:</td>
        <td width="3%"><input type="checkbox" name="aplica_acta_inicio" id="aplica_acta_inicio" <? if($sql_con[12] == 1){ echo "checked='checked'";}?> value="1" <?=$disabled;?>/></td>
        <td width="31%">&nbsp;</td>
        <td colspan="2" align="right">&nbsp;</td>
        <td colspan="2" class="titulos_resumen_alertas"><? if($_SESSION["id_us_session"]==1){ ?><a href="../librerias/php/tarifas_procesos_admin.php?contrato_a=<?=$id_contrato_arr?>&tipo_creaci=1&consecu=<?=imprime_cabeza_contrato_limpio($id);?>" target="grp">Crear tarifas</a><? } ?></td>
      </tr>
      <tr>
        <td colspan="8" class="fondo_4"><?=$alerta1;?>
        Polizas Aplicables:</td>
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
      <tr>
        <td width="4%"><input type="checkbox" name="poliza_aplica[]" id="poliza_aplica[]" value="<?=$lista_poliza[0];?>" <?=$che;?> <?=$disabled;?>/></td>
        <td colspan="5">&nbsp;<?=$lista_poliza[1];?></td>
        <td colspan="2" class="titulos_resumen_alertas">&nbsp;</td>
      </tr>
      <?
	}
	  ?>
      <tr>
        <td>&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><? if($edita==1 ){?><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Informacion Contrato" onclick="graba_informacion_contrato(<?=$estado_contrato;?>);"/><? }?></td>
      </tr>
      <tr>
        <td colspan="8"  class="fondo_4">Registro Fechas:</td>
        </tr>
      <tr>
        <td colspan="8">
		<table width="100%">
        	<?
        	$entro = 0;
			?>
            <tr>
              <td width="16%">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td width="12%" align="center"><strong>Entrega</strong></td>
              <td width="12%" align="center"><strong>Recibo</strong></td>
              <td width="35%" align="center"><strong>Observaciones</strong></td>
              <td width="13%">&nbsp;</td>
            </tr>
            <tr>
              <td valign="top">1. Creaci&oacute;n Sistema</td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td align="center" valign="top"></td>
              <td align="center" valign="top"><?=$sql_con[19];?></td>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr>
                <td valign="top">2. Recibido Abastecimiento</td>
                <td colspan="2" valign="top">&nbsp;</td>
                
                <td align="center" valign="top">
                <?
                if (trim($sql_con[47])<>""){
                    echo $sql_con[47];
                    ?>
                  <input name="recibido_abastecimiento_e" type="hidden" id="recibido_abastecimiento_e" size="15" maxlength="15" value="<?=$sql_con[47];?>" />
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?> <input name="recibido_abastecimiento_e" type="text" id="recibido_abastecimiento_e" size="15" maxlength="15"  readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top">
                <?
                if (trim($sql_con[20])<>""){
                    echo $sql_con[20];
                }else{
                ?>
                   <? if($edita==1 ){?> <input name="recibido_abastecimiento" type="text" id="recibido_abastecimiento" size="15" maxlength="15" onMouseOver="calendario_sin_hora('recibido_abastecimiento')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                <td valign="top">
                <?
                if (trim($sql_con[20])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"recibido_abastecimiento");					
				}else{
					?>
					<textarea name="recibido_abastecimiento_obs" id="recibido_abastecimiento_obs" cols="5" rows="0" <?=$disabled;?>></textarea>
					<?
				}
				?>
                </td>
                <td valign="top">
                <?
				if($sql_con[38]==0){
				  $entro = 1;
				}
				if(trim($sql_con[47])==""){
				  $entro = 1;
				}
                if (trim($sql_con[20])=="" && $entro == 0 && $sql_con[38]==1 && trim($sql_con[47])!="" ){
                    $entro = 1;
                ?>
                    <? if($edita==1 ){?><div id="boton_fecha_recibido_abastecimiento"><input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'recibido_abastecimiento');"/></div><? }?>
                <?
                }
                ?>            
                </td>
            </tr>
            <tr>
                <td valign="top">3. SAP</td>
              
                <td colspan="2" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[28])<>""){
                    echo $sql_con[28];
                    ?>
                  <input name="sap_e" type="hidden" id="sap_e" size="15" maxlength="15" value="<?=$sql_con[28];?>" />
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?> <input name="sap_e" type="text" id="sap_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('sap_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
                if (trim($sql_con[21])<>""){
                    echo $sql_con[21];
                }else{
                    ?>
                    <? if($edita==1 ){?><input name="sap" type="text" id="sap" size="15" maxlength="15" onMouseOver="calendario_sin_hora('sap')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                  <td valign="top">
                 
                  <?
                if (trim($sql_con[21])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"sap");					
				}else{
					?>
					 <textarea name="sap_obs" id="sap_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"sap");?></textarea>
					<?
				}
				?>
                  </td>
                <td valign="top">
                <?
                if (trim($sql_con[21])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                    <? if($edita==1 ){?><div id="boton_fecha_sap"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'sap');"/></div>   <? }?>       	<?
                }
                ?>
                </td>
            </tr>
            <tr>
                <td valign="top">4. Revisi&oacute;n Legal</td>
                
                <td colspan="2" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[29])<>""){
                    echo $sql_con[29];
                    ?>
                  <input name="revision_legal_e" type="hidden" id="revision_legal_e" size="15" maxlength="15" value="<?=$sql_con[29];?>"/>
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?><input name="revision_legal_e" type="text" id="revision_legal_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('revision_legal_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
                if (trim($sql_con[22])<>""){
                    echo $sql_con[22];
                }else{
                    ?>
                    <? if($edita==1 ){?><input name="revision_legal" type="text" id="revision_legal" size="15" maxlength="15" onMouseOver="calendario_sin_hora('revision_legal')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                <td valign="top">
                
                <?
                if (trim($sql_con[22])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"revision_legal");					
				}else{
					?>
					 <textarea name="revision_legal_obs" id="revision_legal_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"revision_legal");?></textarea>
					<?
				}
				?>
                </td>
                <td valign="top">
                <?
                if (trim($sql_con[22])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                   <? if($edita==1 ){?> <div id="boton_fecha_revision_legal"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'revision_legal');"/> </div>     <? }?>    	<?
                }
                ?>
                </td>
            </tr>
            <tr>
                <td valign="top" >5. Firma Representante legal</td>
                <td colspan="2" valign="top" >
                <?
                if($sql_con[39]!=""){
					?>
					<input type="hidden"  name="sel_representante" id="sel_representante" value="<?=$sql_con[39];?>" />
                    <?
					if($sql_con[39]==1){
						echo "Contratista";
						$fecha_entrega = $sql_con[30];										
					}else{
						echo "Hocol";
					}
				}else{
				?>
                <select name="sel_representante" id="sel_representante" onchange="carga_sel_representante(this.value);" <?=$disabled;?>>
                  <option value="0">Seleccione</option>
                  <option value="1">Contratista</option>
                  <option value="2">Hocol</option>                
                  </select>
                  <?
				  }
                  ?>
               </td>
               
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[30])<>""){
                    echo $sql_con[30];
                    ?>
                  <input name="firma_hocol_e" type="hidden" id="firma_hocol_e" size="15" maxlength="15" value="<?=$sql_con[30];?>"/>
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?> <input name="firma_hocol_e" type="text" id="firma_hocol_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('firma_hocol_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
                if (trim($sql_con[23])<>""){
                    echo $sql_con[23];
                }else{
                    ?>
                   <? if($edita==1 ){?> <input name="firma_hocol" type="text" id="firma_hocol" size="15" maxlength="15" onMouseOver="calendario_sin_hora('firma_hocol')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                 <td valign="top">
                
                  <?
                 if (trim($sql_con[23])){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"firma_hocol");					
				}else{
					?>
					  <textarea name="firma_hocol_obs" id="firma_hocol_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"firma_hocol")?></textarea>
					<?
				}
				?>
                 </td>
                <td valign="top">
                <?
                if (trim($sql_con[23])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                   <? if($edita==1 ){?> <div id="boton_fecha_firma_hocol"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'firma_hocol');"/> </div>     <? }?>    	<?
                }
                ?>
                </td>
            </tr>
            <?
             if($sql_con[39]==1){
				 if (trim($sql_con[23])<>""){
			?>
            
            <tr>
              <td align="left" valign="top">5.1. Aplica fecha Paralelo</td>
              <td width="3%" valign="top">
              <?
			  if(trim($sql_con[45])!=""){
					$che_paralelo = "checked='checked'";
				}
			  if($sql_con[39]==1){
						if (trim($sql_con[23])<>""){
							?>
                            <input type="checkbox" name="activa_fecha_paralelo" id="activa_fecha_paralelo"  value="1" onclick="activa_fecha_paralelo2();" <?=$che_paralelo;?> <?=$disabled;?>/>
							<?
						}
					}
			  ?>
              </td>
              <td width="9%" valign="top">&nbsp;</td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td valign="top"></td>
            </tr>
            <?
				 }
			 }
			?>
            <tr>
              <td valign="top"></td>
              <td colspan="2" valign="top">
              
              </td>
              <td colspan="2" valign="top">
                <div id="div_sel_representante">
                  <? if(trim($sql_con[23]) != ""){ $dis_ca = "disabled='disabled'";}?>
                  <?
              if($sql_con[39]==1){
				?>
                  <table width="100%">
                    <tr>
                      <td width="46%" align="right"><font size="-2">Acta Socios:</font></td>
                      <td width="19%" align="center"><select name="aplica_acta" id="aplica_acta" <?=$dis_ca;?>>
                        <option value="1" <? if ($sql_con[43]==1){ echo "selected='selected'";}?> >SI</option>
                        <option value="2" <? if ($sql_con[43]==2){ echo "selected='selected'";}?> >NO</option>
                        </select></td>
                      <td width="15%" align="center"><input type="checkbox" name="acta_socios" id="acta_socios"  value="1"  <? if($sql_con[35] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                      <td width="20%">&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="right"><font size="-2">Recibido P&oacute;lizas</font>:</td>
                      <td align="center">&nbsp;</td>
                      <td align="center"><input type="checkbox" name="recibido_poliza" id="recibido_poliza"  value="1" <? if($sql_con[36] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="right"><font size="-2">Camara y Comercio</font>:</td>
                      <td align="center">&nbsp;</td>
                      <td align="center"><input type="checkbox" name="camara_comercio" id="camara_comercio" value="1" <? if($sql_con[37] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="right"><font size="-2">Recibo de Polizas</font>:</td>
                      <td align="center">&nbsp;</td>
                      <td align="center"><input type="checkbox" name="recibo_poliza" id="recibo_poliza" value="1" <? if($sql_con[44] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="right">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    </table>
                  <?  
			  }
			  ?>
                  </div>
              </td>
              <td valign="top">&nbsp;</td>
              <td valign="top"></td>
            </tr>
            <?
            if($sql_con[39]==1){
				if(trim($sql_con[45])==""){
					$style1_paralelo = "style='display:none'";
				}
			?>
            <tr class="columna_subtitulo_resultados" id="fila_paralelo" <?=$style1_paralelo;?>>
              <td valign="top"><font size="-1">5.2. Fecha Proceso Paralelo</font></td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td align="center" valign="top"><input name="fecha_informativa_e" type="text" id="fecha_informativa_e" size="15" maxlength="15" readonly="readonly" value="<?=$fecha_entrega;?>" <?=$disabled;?>/></td>
              <td align="center" valign="top"><input name="fecha_informativa" type="text" id="fecha_informativa" size="15" maxlength="15" onmouseover="calendario_sin_hora('fecha_informativa')" readonly="readonly" value="<?=$sql_con[46];?>" <?=$disabled;?>/></td>
              <td valign="top"><textarea name="fecha_informativa_obs" id="fecha_informativa_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"fecha_informativa");?></textarea></td>
              <td valign="top"><input name="button5" type="button" class="boton_grabar" id="button5" value="Grabar Fecha" onclick="graba_fecha_contrato_parale(1,'fecha_informativa');" <?=$disabled;?>/>
              </td>
            </tr>
            <?
			}
			?>
            <tr>
                <td valign="top">6. Firma Representante legal </td>
                <td colspan="2" valign="top"> <?
                if($sql_con[39]!=""){
					?>
					<input type="hidden"  name="sel_representante" id="sel_representante" value="<?=$sql_con[39];?>" />
                    <?
					if($sql_con[39]==2){
						echo "Contratista";						
					}else{
						echo "Hocol";
					}
				}
				?>
					</td>
               
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[31])<>""){
                    echo $sql_con[31];
                    ?>
                  <input name="firma_contratista_e" type="hidden" id="firma_contratista_e" size="15" maxlength="15" value="<?=$sql_con[31];?>"/>
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?><input name="firma_contratista_e" type="text" id="firma_contratista_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('firma_contratista_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
				$dis_ca = "";
                if (trim($sql_con[24])<>""){
                    echo $sql_con[24];
					$dis_ca = "disabled='disabled'";
                }else{
                    ?>
                    <? if($edita==1 ){?><input name="firma_contratista" type="text" id="firma_contratista" size="15" maxlength="15" onMouseOver="calendario_sin_hora('firma_contratista')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                 <td valign="top">
                 
                  <?
                if (trim($sql_con[24])){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"firma_contratista");					
				}else{
					?>
					 <textarea name="firma_contratista_obs" id="firma_contratista_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"firma_contratista");?></textarea>
					<?
				}
				?>
                 </td>
                <td valign="top"><?

                if (trim($sql_con[24])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                    <? if($edita==1 ){?><div id="boton_fecha_firma_contratista"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'firma_contratista');"/> </div>     <? }?>    	<?
                }
                ?>
                
                </td>
            </tr>
            
            <tr>
              <td align="right" valign="top"></td>
              <td colspan="2" align="right" valign="top"></td>
              <td colspan="2" align="right" valign="top">
                <? if(trim($sql_con[24]) != ""){ $dis_ca = "disabled='disabled'";}?>
                <?
              if($sql_con[39]==2){
				?>
                <table width="100%">
                  <tr>
                    <td width="46%" align="right"><font size="-2">Acta Socios:</font></td>
                    <td width="19%" align="center"><select name="aplica_acta" id="aplica_acta" <?=$dis_ca;?>>
                      <option value="1" <? if ($sql_con[43]==1){ echo "selected='selected'";}?> >SI</option>
                      <option value="2" <? if ($sql_con[43]==2){ echo "selected='selected'";}?> >NO</option>
                      </select></td>
                    <td width="17%" align="center"><input type="checkbox" name="acta_socios" id="acta_socios"  value="1"  <? if($sql_con[35] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                    <td width="18%">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right"><font size="-2">Recibido P&oacute;lizas</font>:</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><input type="checkbox" name="recibido_poliza" id="recibido_poliza"  value="1" <? if($sql_con[36] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right"><font size="-2">Camara y Comercio</font>:</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><input type="checkbox" name="camara_comercio" id="camara_comercio" value="1" <? if($sql_con[37] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                    <td></td>
                    </tr>
                  <tr>
                    <td align="right"><font size="-2">Recibo de Polizas</font>:</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><input type="checkbox" name="recibo_poliza" id="recibo_poliza" value="1" <? if($sql_con[44] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td></td>
                    </tr>
                  </table>
                <?  
			  }
			  ?>            
              </td>
              <td align="right" valign="top"></td>
              <td valign="top">&nbsp;</td>
            </tr>
           
            <tr>
                <td valign="top">7. Revision Polizas</td>
               
                <td colspan="2" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[32])<>""){
                    echo $sql_con[32];
                    ?>
                  <input name="revision_poliza_e" type="hidden" id="revision_poliza_e" size="15" maxlength="15" value="<?=$sql_con[32];?>"/>
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?><input name="revision_poliza_e" type="text" id="revision_poliza_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('revision_poliza_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
                if (trim($sql_con[25])<>""){
                    echo $sql_con[25];
                }else{
                    ?>
                    <? if($edita==1 ){?><input name="revision_poliza" type="text" id="revision_poliza" size="15" maxlength="15" onMouseOver="calendario_sin_hora('revision_poliza')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                 <td valign="top">
                
                  <?
                if (trim($sql_con[25])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"revision_poliza");					
				}else{
					?>
					 <textarea name="revision_poliza_obs" id="revision_poliza_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"revision_poliza");?></textarea>
					<?
				}
				?>
                 </td>
                <td valign="top">
                <?
                if (trim($sql_con[25])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                    <? if($edita==1 ){?><div id="boton_fecha_revision_poliza"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'revision_poliza');"/> </div>  <? }?>       	<?
                }
                ?>
                </td>
            </tr>
             <tr>
              <td valign="top">8. Gerente Contrato</td>
              
              <td colspan="2" valign="top">&nbsp;</td>
              <td align="center" valign="top"><?
                if (trim($sql_con[41])<>""){
                    echo $sql_con[41];
                    ?>
                <input name="legalizacion_final_par_e" type="hidden" id="legalizacion_final_par_e" size="15" maxlength="15" value="<?=$sql_con[41];?>"/>
                <?
                }else{
                    ?>
                <? if($edita==1 ){?><input name="legalizacion_final_par_e" type="text" id="legalizacion_final_par_e" size="15" maxlength="15" onmouseover="calendario_sin_hora('legalizacion_final_par_e')" readonly="readonly"/><? }?>
                <?
                }
                ?></td>
              <td align="center" valign="top"><?
                if (trim($sql_con[40])<>""){
                    echo $sql_con[40];
                }else{
                    ?>
                <? if($edita==1 ){?><input name="legalizacion_final_par" type="text" id="legalizacion_final_par" size="15" maxlength="15" onmouseover="calendario_sin_hora('legalizacion_final_par')" readonly="readonly"/><? }?>
                <?
                }
                ?></td>
                <td valign="top">
               
                <?
                if ($sql_con[40]<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"legalizacion_final_par");					
				}else{
					?>
					  <textarea name="legalizacion_final_par_obs" id="legalizacion_final_par_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"legalizacion_final_par");?></textarea>
					<?
				}
				?>
                </td>
              <td valign="top"><?
                if (trim($sql_con[40])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                <? if($edita==1 ){?><div id="boton_fecha_legalizacion_final_par"><input name="button" type="button" class="boton_grabar" id="button" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'legalizacion_final_par');"/></div><? }?>
                <?
                }
                ?></td>
            </tr>
            <tr>
                <td valign="top">9. Legalizacion Final Contrato</td>

                <td colspan="2" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                  <?
                if (trim($sql_con[33])<>""){
                    echo $sql_con[33];
                    ?>
                  <input name="legalizacion_final_e" type="hidden" id="legalizacion_final_e" size="15" maxlength="15" value="<?=$sql_con[33];?>"/>
                  <?
                }else{
                    ?>
                  <? if($edita==1 ){?><input name="legalizacion_final_e" type="text" id="legalizacion_final_e" size="15" maxlength="15" onMouseOver="calendario_sin_hora('legalizacion_final_e')" readonly="readonly"/><? }?>
                  <?
                }
                ?>
                </td>
                <td align="center" valign="top"><?
                if (trim($sql_con[26])<>""){
                    echo $sql_con[26];
                }else{
                    ?>
                   <? if($edita==1 ){?> <input name="legalizacion_final" type="text" id="legalizacion_final" size="15" maxlength="15" onMouseOver="calendario_sin_hora('legalizacion_final')" readonly="readonly"/><? }?>
                <?
                }
                ?>
                </td>
                 <td valign="top">
                 
                  <?
                if (trim($sql_con[26])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"legalizacion_final");					
				}else{
					?>
					 <textarea name="legalizacion_final_obs" id="legalizacion_final_obs" cols="5" rows="0" <?=$disabled;?>><?=imprime_observacion(arreglo_pasa_variables($sql_con[0]),arreglo_pasa_variables(0),"legalizacion_final");?></textarea>
					<?
				}
				?>
                 </td>
                <td valign="top">
                <?
                if (trim($sql_con[26])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                    <? if($edita==1 ){?><div id="boton_fecha_legalizacion_final"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(1,'legalizacion_final');this.onclick=''"/>  </div>     <? }?>   	<?
                }
                ?>
                </td>
            </tr>
           
		</table>       

	</td>
	</tr>
</table>
<input name="campo_fecha" type="hidden" />
<input name="aplica_acta_inicio_env" type="hidden" value="<?=$sql_con[12];?>" />
<input name="ok_poliza" type="hidden" value="<?=$ok_poliza;?>" />
<input name="estado_proveedor" type="hidden" value="<?=$estado_proveedor;?>" />
<input name="no_aplica_poliza" type="hidden" value="<?=$no_aplica_poliza;?>" />



        <!-- fin crea contrato-->
        
        
      </td>
   	</tr>
 
</table>
<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="<?=arreglo_pasa_variables($id_contrato_arr)?>" />
<style>
.link_volver:hover{
	
	color:#005395;}
</style>
</body>
</html>
