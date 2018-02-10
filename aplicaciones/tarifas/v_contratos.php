<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));//ID del contrato en el modulo de tarifas

$sel_estado_contrato = traer_fila_row(query_db("select t6_tarifas_estados_contratos_id from  t6_tarifas_complemento_contrato where tarifas_contrato_id =".$id_contrato_arr));	
	
if($sel_estado_contrato[0] <> 6){
$cuenta_tarifas = traer_fila_row(mssql_query("select count(*) from t6_tarifas_lista where tarifas_contrato_id = $id_contrato_arr"));				
			if($cuenta_tarifas[0]==0){
				$updat = mssql_query("update $t4 set t6_tarifas_estados_contratos_id = 1 where tarifas_contrato_id = $id_contrato_arr ");
				}
}

	$busca_contrato = "select tarifas_contrato_id, t1_moneda_id, nombre, t1_proveedor_id, nit, digito_verificacion, razon_social, consecutivo, valor, objeto_contarto, estado_proveedor, estado_contrato, nombre_estado_contarto, id_contrato, gerente, objeto, especialista, monto_usd, monto_cop, t1_tipo_documento_id, fecha_inicio, vigencia_mes, id_item, estado_contrato_general, tipo_bien_servicio, CAST(ob_estado AS TEXT), ipc, reembolsable, obs_congelado, analista_deloitte from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";

	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	$id_contrato_m_contratos = $sql_con[13];//Se identifica el ID del contrato en el modulo de contratos
			
	$cuenta_descuentos = traer_fila_row(query_db("select count(*) from $v_t_2 where tarifas_contrato_id = $sql_con[0] and estado = 1"));
	
	
	


/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr); // la funcion esta en funciones_general_2015
/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
	
	
	$busca_nombre_jefe_area = traer_fila_row(query_db("select * from $g1 where us_id = $id_jefe_area"));
	
	$busca_nombre_gerente=traer_fila_row(query_db("select * from $g1 where us_id = $sql_con[14]"));

	$busca_si_admin = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and ( id_rol_general = 1) "));


	$busca_descuneto = traer_fila_row(query_db("select count(*) from $v_t_2 where tarifas_contrato_id = $id_contrato_arr  and estado = 1 "));
	
$busca_reembolsable = traer_fila_row(query_db("select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from $v_t_9 where t6_tarifas_contratos_id = $id_contrato_arr  and estado = 1 and porcentaje_administracion >=0"));
//echo "select t6_tarifas_reembosables1_contrato_id, porcentaje_administracion, nombre_administrador, fecha_creacion, estado from $v_t_9 where t6_tarifas_contratos_id = $id_contrato_arr  and estado = 1";
$busca_tarifas_uni = traer_fila_row(query_db("select count(*) from v_tarifas_con_descuentos where tarifas_contrato_id = $id_contrato_arr  "));	
	
$busca_tarifas_ipc = traer_fila_row(query_db("select count(*) from t6_tarifas_ipc_contrato where t6_tarifas_contratos_id = $id_contrato_arr and ipc_administracion = 1 and estado = 1 "));	

$busca_sumpletes_responsable = "select tipo_suplencia, us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]." and tipo_suplencia = 2 and   estado = 1 and fecha_suplencia >= '$fecha'";
$sql_suplente=traer_fila_row(query_db($busca_sumpletes_responsable));

	if($sql_suplente[0]==2){//si es gerente_item
			 $permiso_ver_admin = 1;		
		}

	
	$sel_datos_contrato = traer_fila_row(query_db("select t2.especialista, t2.estado from t6_tarifas_contratos as t1, t7_contratos_contrato as t2 where t1.tarifas_contrato_id = ".$id_contrato_arr." and t1.id_contrato = t2.id"));


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<div id="carga_acciones_permitidas">
<table width="99%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="100%" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr class="titulos_secciones">
        <td colspan="3" align="left">CONTRATO: <?=numero_cotnrato_tarifas($id_contrato_arr);?> </td>
        <td align="right"><input type="button" name="button4" class="boton_volver"  id="button4" value="Volver al Historico" onclick="ajax_carga('../aplicaciones/tarifas/modulo-historico-contratos.php?pagina=<?=$_SESSION['pagina_session_session']?>&tipo_actuali_b=<?=$_SESSION['tipo_actuali_b_session']?>&detalle_tarifa=<?=$_SESSION['detalle_tarifa_session']?>&objeto=<?=$_SESSION['objeto_session']?>&nu_contrato=<?=$_SESSION['nu_contrato_session']?>&proveedor=<?=$_SESSION['proveedor_session']?>&roll_gerente=<?=$_SESSION['roll_gerente_session']?>&vigencia_contrato=<?=$_SESSION['vigencia_contrato_session']?>&codigo_tarifa=<?=$_SESSION['codigo_tarifa_session']?>&busca_estado_aprobacion=<?=$_SESSION['busca_estado_aprobacion_session']?>&especialista_bu=<?=$_SESSION['especialista_bu']?>','carga_acciones_permitidas')" /></td>
        </tr>
        
        
      <tr>
        <td colspan="2" rowspan="21" valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
            <?
			/*----------------------- seleccion de informacion general de contratos --------------------*/
			$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil, garantia_seguro
 from $co1 where id = ".$sql_con[13];
 


	$sql_con2=traer_fila_row(query_db($busca_contrato));
$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$sql_con2[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));
	$estado_contrato = $sql_con2[27];
	$alerta1 = "";
	$alerta2 = "";
	$sel_usuario = "select * from $g1 where us_id = $sql_con2[9]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_generete = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
	$nombre_generete_sin_id = $sql_sel_usuario[1];
	
	if($sql_con2[16]!=""){
	$sel_usuario = "select * from $g1 where us_id = $sql_con2[16]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_especialista = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
	}
	
	
	$edita = 0;
	$edita_2=0;//es para que el profesiobnal de aseguramiento grabe 2 campos especificos
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));

/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_con2[9]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

/*SACA QUIEN ES GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sql_con2[9]));
/*SACA QUIEN ES GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

	
	
	if($edita==0 ){
		$disabled = " disabled='disabled' ";
	}

$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3, $pi2.t1_area_id from $pi2 where $pi2.id_item=".$sql_con2[1];
$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
			/* ------------------ Fin seleccion de informacion general de contratos -------------------*/
			?>
          <tr >
            <td width="35%" align="right" valign="top"><strong>Solicitud de Aprobaci&oacute;n:</strong></td>
            <?
         $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con2[1]));
		 ?>
            <td colspan="3" align="left"><strong <? if($_GET["genera_excel"]!="si"){?> onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sql_con2[1]?>&amp;id_tipo_proceso_pecc=<?=$sel_item[0];?>&amp;conse_div=0&amp;permiso_o_adjudica=2')"<? } ?>><font color="#0000FF"><u>
              <?=$consecu_arreglado=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
              </u></font></strong> - <strong>
                <? if ($_SESSION["id_us_session"]==32){ echo saca_nombre_lista($g12,$sql_sele_items_historico[3],'nombre','t1_area_id');} ?>
                </strong></td>
            </tr>
          <tr>
            <td align="right"><strong>Tipo Contrato:</strong></td>
            <td colspan="2" align="left"><?
         if($sql_con2[34]==1){
		 	
			if($sql_con2[57]==1){
				echo "ACEPTACION DE OFERTA MERCANTIL";
			}else{
				echo "CONTRATO PUNTUAL";
				}

		 }else{
			echo "CONTRATO MARCO";
		 }
		 ?></td>
            </tr>
          <tr>
            <td align="right"><strong>Contratista / Proveedor:</strong></td>
            <td colspan="2" align="left"><input name="contratista" type="hidden" id="contratista" size="5" value="<?=$sql_con2[5];?>"/>
              <?=$sel_pro_q[3];?></td>
            </tr>
          <tr>
            <td align="right"><strong>Gerente del Contrato:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <input name="gerente" type="text" id="gerente" size="5" value="<?=$nombre_generete;?>" onkeypress="selecciona_lista_general_irre('gerente','../librerias/php/usuarios_general.php')"/>
              <? }else{?>
              <input type="hidden" name="gerente" id="gerente"  value="<?=$nombre_generete;?>" />
              <? $explo_nom1 = explode("-",$nombre_generete); echo $explo_nom1[0]?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Profesional de C&amp;C:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <input name="especialista" type="text" id="especialista" size="5" value="<?=$nombre_especialista;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/>
              <? }else{?>
              <input type="hidden" name="especialista" id="especialista"  value="<?=$nombre_especialista;?>" />
              <? $explo_nom2 = explode("-",$nombre_especialista); echo $explo_nom2[0]?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Jefe de area:</strong></td>
            <td colspan="2" align="left"><?=$busca_nombre_jefe_area[1];?></td>
          </tr>
          <tr>
            <td align="right"><strong>Gestor de Abastecimiento:</strong></td>
            <td colspan="2" align="left"><?=traer_nombre_muestra($sel_quien_es_gestor[0], $g1,"nombre_administrador","us_id")?></td>
            </tr>
          <tr>
            <td align="right"><strong>Fecha Inicio del Contrato:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <input name="fecha_inicio" type="text" id="fecha_inicio" size="5" value="<?=$sql_con2[10];?>"  onmouseover="calendario_sin_hora('fecha_inicio')" readonly="readonly"/>
              <? }else{?>
              <input type="hidden" name="fecha_inicio" id="fecha_inicio"  value="<?=$sql_con2[10];?>" />
              <?=$sql_con2[10];?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Fecha Fin del Contrato:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <input name="fecha_fin" type="text" id="fecha_fin" size="5" value="<?=$sql_con2[11];?>"  onmouseover="calendario_sin_hora('fecha_fin')" readonly="readonly"/>
              <? }else{?>
              <input type="hidden" name="fecha_fin" id="fecha_fin"  value="<?=$sql_con2[11];?>" />
              <?=$sql_con2[11];?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Objeto:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <textarea name="objeto" id="objeto" cols="25" rows="3"><?=$sql_con2[3];?>
           </textarea>
              <? }else{?>
              <input type="hidden" name="objeto" id="objeto" value="<?=$sql_con2[3];?>" />
              <?=$sql_con2[3];?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Monto:</strong></td>
            <td colspan="2" align="left"><?
        if($sql_con2[34]==2){?>
              <strong onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;block&quot;;ajax_carga(&quot;../aplicaciones/reportes/lista_reporte_saldos.php?id_contrato=<?=$id_contrato_m_contratos?>&quot;,&quot;div_carga_busca_sol&quot;)' style="cursor:pointer">Ver reporte de contrato marco</strong>
              <input name="monto_usd" type="hidden" id="monto_usd" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con2[17]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
              <input name="monto_cop" type="hidden" id="monto_cop" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con2[18]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
              <? }else{
		?>
              <table width="99%" border="0" cellpadding="2" cellspacing="2" >
                <tr>
                  <td align="right" width="50px" class="titulos_resumen_alertas">USD</td>
                  <td align="left" class="titulos_resumen_alertas"><input name="monto_usd" type="hidden" id="monto_usd" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con2[17]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
                    <?=valida_numero_imp($sql_con2[17]);?></td>
                  </tr>
                <tr>
                  <td width="8%" align="right" class="titulos_resumen_alertas">COP</td>
                  <td width="92%" align="left" class="titulos_resumen_alertas"><input name="monto_cop" type="hidden" id="monto_cop" size="15" maxlength="15" value="<?=valida_numero_imp($sql_con2[18]);?>"  onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;" onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/>
                    <?=valida_numero_imp($sql_con2[18]);?></td>
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
            <td align="right"><strong>Informe HSE:</strong>
              <input type="hidden" name="aplica_portales" id="aplica_portales"  value="<?=$sql_con2[50];?>" /></td>
            <td colspan="2" align="left"><?
		?>
              <? if($edita==1 or $edita_2 == 1 ){?>
              <select name="info_hse" id="info_hse">
                <option value="0">Seleccione</option>
                <option value="SI" <? if($sql_con2[56] == "SI") echo 'selected="selected"';?> >SI</option>
                <option value="NO" <? if($sql_con2[56] == "NO") echo 'selected="selected"';?>>NO</option>
                </select>
              <? }else{?>
              <input type="hidden" name="info_hse" id="info_hse"  value="<?=$sql_con2[56];?>" />
              <?=$sql_maestra[1];?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>&nbsp;Aplica Acta Incio:</strong>
              <input type="hidden" name="destino" id="destino"  value="<?=$sql_con2[51];?>" /></td>
            <td width="16%" align="left" ><? if($_GET["genera_excel"]!="si" and $edita==1) {?>
              <input type="checkbox" name="aplica_acta_inicio" id="aplica_acta_inicio" <? if($sql_con2[12] == 1){ echo "checked='checked'";}?> value="1" <?=$disabled;?>/>
              <? } else{ if($sql_con2[12] == 1) {echo "SI";} else echo "NO"; }?></td>
            <td width="49%" colspan="2" align="left">&nbsp;</td>
            </tr>
          <tr>
            <td align="right"><strong>Congelado:</strong></td>
            <td colspan="2" align="left"><? if($edita==1 ){?>
              <select name="analista_deloitte" id="analista_deloitte">
                <option value="1" <? if($sql_con2[42]==1){echo "selected='selected'";}?> >SI</option>
                <option value="0" <? if($sql_con2[42]!=1){echo "selected='selected'";}?> >NO</option>
                </select>
              <? }else{?>
              <input type="hidden" name="analista_deloitte" id="analista_deloitte"  value="<?=$sql_con2[42];?>" />
              <?
        $conge_text="NO";
		if($sql_con2[42]==1){
			$conge_text="SI";
		}
		echo $conge_text;
		?>
              <? }?></td>
            </tr>
          <tr>
            <td align="right"><strong>Observaciones Congelado:</strong></td>
            <td colspan="2" align="left"><span class="titulos_resumen_alertas">
              <? if($edita==1 ){?>
              <textarea name="obs_congelado" id="obs_congelado" cols="25" rows="1"><?=$sql_con2[49];?>
          </textarea>
              <? }else{?>
              <input type="hidden" name="obs_congelado" id="obs_congelado" value="<?=$sql_con2[49];?>" />
              <?=$sql_con2[49];?>
              <? }?>
              <input type="hidden" name="area_ejecucion" id="area_ejecucion"  value="<?=$sql_con2[48];?>" />
              </span></td>
            </tr>
        
        </table></td>
        <td width="21%" height="26"><div align="right"><strong><img src="../imagenes/botones/help.gif" width="18" height="18" title="Indica si al contrato ya se le registrarón datos como: polizas, actas de inicio, etc." /></strong></div></td>
        <td width="31%" class="titulos_resumen_alertas"><strong>Estado:</strong> <?=$sql_con[12];?><? if($sql_con[11] == 6) echo ". ".$sql_con[25];?></td>
      </tr>
      
     
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>Descuento pactado, Configurado por Abastecimiento:</strong></td>
        <td><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/detalle_descuentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')"> Ver </a></td>
      </tr>
      <tr>
        <td align="right"><strong>Descuentos por tarifas, Configurado por el Proveedor</strong>:</td>
        <td><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/tarifas/detalle_descuentos.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')"> Ver </a></td>
      </tr>
     
      <tr>
        <td align="right"><strong>Incrementos de IPC:</strong></td>
        <td><? if($busca_tarifas_ipc[0]>=1)
			echo "Si";
			else echo "No";
			
			?></td>
      </tr>
      <tr>
        <td align="right"><strong>Reembolsables:</strong></td>
        <td><? if($busca_reembolsable[0]>=1)
			echo "Si, % de administracion: ".$busca_reembolsable[1]." % ";
			else 			echo "No";
			
			?></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><?=busca_tarifas_aiu($id_contrato_arr,2);?></td>
        </tr>
      <tr>
        <td colspan="2" align="left"><?=busca_tarifas_convenciones($id_contrato_arr,1);?></td>
        </tr>
       
       
      <? if ($sql_con[19] <> 2){ ?>
      <?
	  }else{
		  ?>
		  <?
		  }
	  ?>
      
      <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td height="265" colspan="2" valign="top"><?
         if($id_contrato_arr==1166 or $id_contrato_arr==1212){
			 echo "<span class='letra-descuentos'><strong>Excepción Permanente Opex:</strong> <br /> Debe presentar obligatoriamente tiquete de servicio para Capex.<br />Tiene excepción permanente de presentar tiquete de servicio para los servicios de Opex. </span>";
			 }

		 ?></td>
         </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
       </tr>
      <? if($cuenta_descuentos[0]>=1){ // si tiene descuentos?>
      <? } //si tiene descuentos ?>
     <? if($busca_tarifas_uni[0]>=1){ ?>
     <? } ?>
    </table>
    <?
	
	
	

		
		

 if($sql_con[11]!=3 and $sel_datos_contrato[0] == $_SESSION["id_us_session"] and ($sel_datos_contrato[1] != 49 and $sel_datos_contrato[1]!=50)){ ?>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><strong><img src="../imagenes/botones/help.gif" alt="Presionando esta opción el contrato podrá ser visualizado por gerente de contrato y proveedor" width="18" height="18" title="Presionando esta opción el contrato podrá ser visualizado por gerente de contrato y proveedor" /> </strong>Se refiere a que el contrato podr&aacute; ser visualizado  por gerente y proveedor</td>
          <td width="27%"><input name="button" type="button" class="boton_grabar" id="button" value="Contrato de tarifas en firme" onclick="contrato_tarifas_en_firme(<?=$busca_descuneto;?>)" /></td>
        </tr>
      </table>
      <? }

  


 if(($sql_con[11]==1 or $sql_con[11]==3) and $busca_si_admin[0]>0 and ($sel_datos_contrato[1] != 49 and $sel_datos_contrato[1]!=50)){ ?>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="73%"><strong><img src="../imagenes/botones/help.gif" alt="Presionando esta opción el contrato volvera a ser parcial" width="18" height="18" title="Presionando esta opción el contrato volvera a ser parcial" /> </strong>Se refiere a que el contrato NO podr&aacute; ser visualizado  por gerente y proveedor</td>
          <td width="27%"><input name="button" type="button" class="boton_grabar" id="button" value="Contrato de tarifas en parcial" onclick="contrato_tarifas_en_parcial_editado()" /></td>
        </tr>
      </table>

        <? }
 if(($sql_con[11]==1 or $sql_con[11]==2) and $busca_si_admin[0]>0 and ($sel_datos_contrato[1] != 49 and $sel_datos_contrato[1]!=50)){ 
		?>      
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="73%"><strong><img src="../imagenes/botones/help.gif" alt="Presionando esta opci&oacute;n el contrato volvera a ser parcial" width="18" height="18" title="Presionando esta opci&oacute;n el contrato volvera a ser parcial" /></strong>Se refiere a que el contrato NO tiene tarifas y es una excepcion</td>
          <td width="27%"><textarea name="ob_excepcion" id="ob_excepcion"></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="button3" type="button" class="boton_grabar" id="button3" value="Contrato con Excepci&oacute;n" onclick="contrato_tarifas_en_excepcion_editado()" /></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
    </tr>
</table>
<?
		 }

 if(($sql_con[11]==6 or $sql_con[11]==6) and $busca_si_admin[0]>0 and ($sel_datos_contrato[1] != 49 and $sel_datos_contrato[1]!=50)){ 
		?>      
  <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="73%" height="75"><strong><img src="../imagenes/botones/help.gif" alt="Presionando esta opci&oacute;n el contrato volvera a ser parcial" width="18" height="18" title="Presionando esta opci&oacute;n el contrato volvera a ser parcial" /></strong>Se refiere a que el contrato NO tiene tarifas y es una excepcion</td>
          <td width="27%"><textarea name="ob_excepcion_edita" rows="10" id="ob_excepcion_edita"><?=$sql_con[25];?></textarea></td>
          <td width="27%">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="button3" type="button" class="boton_grabar" id="button3" value="Modificar comentario de la excepci&oacute;n" onclick="contrato_tarifas_en_excepcion_editado_comentario()" /></td>
          <td><input name="button2" type="button" class="boton_grabar" id="button2" value="Quitar excepci&oacute;n del contrato" onclick="contrato_en_excepcion_editado_cambia_esatdo()" /></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
    </tr>
</table>
<?

		 }

?>



<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td  valign="top" id="carga_acciones_permitidas_inicio">&nbsp;</td>
  </tr>
</table>
</div>

</body>
</html>
