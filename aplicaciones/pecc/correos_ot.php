<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	
	
	$es_profesional_designado = verifica_usuario_indicado_solo_si(8,$sel_item[0]);
		
		
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if(($sel_usu_emulan[0]>0 or $es_profesional_designado == "SI" or $sel_item[3] == $_SESSION["id_us_session"]) and ($sel_item[14] == 31 or $sel_item[14] == 6) ){
			$edicion_datos_generales = "SI";
		}
	

$sl_contra_ot ="select $pi8.t2_presupuesto_id from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id";			 
		 $sele_contrato = traer_fila_row(query_db($sl_contra_ot));		 
		 	$sel_apl_cota = traer_fila_row(query_db("select t2.id, t2.contratista, t2.gerente from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_contrato[0]));
			
					
				$tiene_contrato="SI";		

		if($sel_apl_cota[0]==""){
					$texto_error = 'Debe Seleccionar un Contrato, en el link "Valor Ordenes de Trabajo", el cual se encuentra al lado derecho de la pantalla <img src="../imagenes/botones/aler-interro.gif" height="15"/>';
					$tiene_contrato = "NO";
				}
				

				/* actualiza de urna*/
				
		if($tiene_contrato=="SI" and $edicion_datos_generales == "SI"){//si tiene contrato actualize urna
		$id_contratista_ot=$sel_apl_cota[1];
		
				$sel_contratista = traer_fila_row(query_db("select * from t1_proveedor where t1_proveedor_id=".$id_contratista_ot));
		$id_contratista_aplica = $id_contratista_ot;
		
		if(substr_count($sel_contratista[1], ' ') > 1){//si es un nit con espacio por cuadre ejemplo id_proveedor 15950
			$sel_contratista_sin_espacio = query_db("select * from t1_proveedor where nit like '%".str_replace(" ","",$sel_contratista[1])."%' and t1_proveedor_id <> ".$id_contratista_ot);
			
			while($sel_ots_corre_sin_espacio = traer_fila_db($sel_contratista_sin_espacio)){
				$id_contratista_aplica.=",".$sel_ots_corre_sin_espacio[0];
			
		
			
				}
			
			}

		$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
		mysql_select_db($dbbase_mys, $link);
		$sel_correos_urna = mysql_query("select pv_id,nit ,email   from pv_proveedores where pv_id in ($id_contratista_aplica) and (email is not null and email != '') ");		
		while($s_corr_ot = mysql_fetch_array($sel_correos_urna)){
				
				$sel_si_esta = traer_fila_row(query_db("select count(*) from t2_item_ot_correo where id_proveedor = ".$id_contratista_ot." and correo='".$s_corr_ot[2]."'"));
				if($sel_si_esta[0]==0){
				$insert =query_db("insert into t2_item_ot_correo (correo, estado, id_us_agrega, fecha,id_proveedor) values ('".$s_corr_ot[2]."',1,1, '$fecha','".$id_contratista_ot."')");
				}
				
		}

		$sel_correos_urna_usuarios = mysql_query("select email from us_usuarios where pv_id in ($id_contratista_aplica)  and (email is not null and email != '')");		
		while($s_corr_ot_us = mysql_fetch_array($sel_correos_urna_usuarios)){				
				$sel_si_esta = traer_fila_row(query_db("select count(*) from t2_item_ot_correo where id_proveedor = ".$id_contratista_ot." and correo='".$s_corr_ot_us[0]."'"));
				if($sel_si_esta[0]==0){
				$insert =query_db("insert into t2_item_ot_correo (correo, estado, id_us_agrega, fecha,id_proveedor) values ('".$s_corr_ot_us[0]."',1,1, '$fecha','".$id_contratista_ot."')");
				}
				
		}
		
		$sel_correos_urna_usuarios = mysql_query("select email_contacto from pro19_contacto_principal where pv_id in ($id_contratista_aplica)  and (email_contacto is not null and email_contacto != '')");		
		while($s_corr_ot_us = mysql_fetch_array($sel_correos_urna_usuarios)){				
				$sel_si_esta = traer_fila_row(query_db("select count(*) from t2_item_ot_correo where id_proveedor = ".$id_contratista_ot." and correo='".$s_corr_ot_us[0]."'"));
				if($sel_si_esta[0]==0){
				$insert =query_db("insert into t2_item_ot_correo (correo, estado, id_us_agrega, fecha,id_proveedor) values ('".$s_corr_ot_us[0]."',1,1, '$fecha','".$id_contratista_ot."')");
				}
				
		}
		
		$sel_correos_urna_usuarios = mysql_query("select email from pv_contactos where pv_id in ($id_contratista_aplica) and (email is not null and email != '')");		
		while($s_corr_ot_us = mysql_fetch_array($sel_correos_urna_usuarios)){				
				$sel_si_esta = traer_fila_row(query_db("select count(*) from t2_item_ot_correo where id_proveedor = ".$id_contratista_ot." and correo='".$s_corr_ot_us[0]."'"));
				if($sel_si_esta[0]==0){
				$insert =query_db("insert into t2_item_ot_correo (correo, estado, id_us_agrega, fecha,id_proveedor) values ('".$s_corr_ot_us[0]."',1,1, '$fecha','".$id_contratista_ot."')");
				}
				
		}
			
			
			
		
		}/*fin actuliza de urna*/
		
		
		if((esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7) or (esprofesionalcompras($id_item_pecc)=="SI" and $id_tipo_proceso_pecc == 3 and $sel_item[14]==16)){
	 $edicion_datos_generales = "SI";
	 }

	
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
        <td width="54%" valign="top">
        <?
		
		if($sel_apl_cota[0]==""){
					
					echo $texto_error;
				}
				
				
          if ($edicion_datos_generales == "SI" and $tiene_contrato=="SI"){
		  ?>
        <table width="100%" border="0" align="center" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center" class="fondo_3">Agregar Correo Nuevo</td>
          </tr>
          <tr>
            <td width="21%" align="right">Correo Electronico:</td>
            <td width="25%" align="left"><input name="correo_agrega" type="text" id="correo_agrega" value="" size="25"></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar correo" onClick="graba_correo()" /></td>
          </tr>
        </table>
        <?
		  }
		?>
        </td>
      </tr>
      <tr>
        <td width="54%" valign="top">
        <?
        if($tiene_contrato=="SI"){
		?>
        <div id="carga_anexos">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="2" align="center"  class="fondo_3">Lista de Correos Relacionados y a los Cuales se les Enviara esta OT</td>
              </tr>
            <tr>
              <td width="63%" align="center" class="fondo_3">Correo</td>
              <td width="37%" align="center" class="fondo_3">Enviar esta OT al Correo Electronico</td>
              </tr>
            <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from t2_item_ot_correo where id_proveedor = '".$sel_apl_cota[1]."' and estado = 1");
  while($sl_correo = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }

		  $sel_si_esta_relacionado = traer_fila_row(query_db("select * from t2_item_ot_correo_relacion_item where id_item = $id_item_pecc and id_correo_envio_ot =  ".$sl_correo[0]));
		  
		  if($sel_si_esta_relacionado[0]>0){
			  $si_envia = "selected='selected'";
			  }else{
				  $si_envia="";
				  }
  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=$sl_correo[1]?></td>
              <td align="center" >
              <?
              if($edicion_datos_generales == "SI"){
			  ?>
              <select name="envia_correo_<?=$sl_correo[0]?>" id="envia_correo_<?=$sl_correo[0]?>" onChange="agrega_quita_correo_ot(this.value,<?=$sl_correo[0]?>)">
              <option value="2" >NO - Enviar Correo</option>
              <option value="1" <?=$si_envia?>>SI - Enviar Correo</option>
              
              </select>
              <? }else{
				  if($si_envia != ""){
					  	echo "SI - Enviar Correo";
					  }else{
						  echo "NO - Enviar Correo";
						  }
				  
				  } ?>
              </td>
              </tr>
            <?
}
  ?>
  </table> 
          
        </div>
        <p>
          <?
		
		
		

		
		
		
		
		
		
		
		}//fin si tiene relacionado un contrato
		?>
          
          
          
          
          
        </p>
        <p>&nbsp;</p>
        <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
          <tr>
            <td colspan="2" align="center"  class="fondo_3">Lista de Correos Relacionados Automaticamente por el SGPA</td>
          </tr>
          <tr>
            <td width="63%" align="center" class="fondo_3">Correo</td>
            <td width="37%" align="center" class="fondo_3">Enviar esta OT al Correo Electronico</td>
          </tr>
          <?
$cont = 0;
  $clase="";
  
  
  $sele_solicitante_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 15 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
  
  if($sele_solicitante_fecha[1]>0){
	  	$us_solicitante = $sele_solicitante_fecha[1];
	  }else{
		  $us_solicitante = $sel_item[3];
		  }

	$rol_gerente_ot_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 34 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));	
	if($rol_gerente_ot_fecha[1]>0){
	  	$us_ot_gerente = $rol_gerente_ot_fecha[1];
		$us_gerente_ot_solicitu = $rol_gerente_ot_fecha[1]."".$sel_item[42];
	  }else{
		  $us_gerente_ot_solicitu = $sel_item[42];
		  $us_ot_gerente = $sel_item[42];
		  }
		  
$rol_gerente_ot_contrato = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 23 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));	
	if($rol_gerente_ot_contrato[1]>0){
	  	$us_gerente_contrato = $rol_gerente_ot_contrato[1];
	  }else{
		  $us_gerente_contrato = $sel_apl_cota[2];
		  }
		  
		  
		  	/*--------- SELECCIONAR LAS PERSONAS DE GESTION ABASTECIMIENTO ----------------*/
$sel_contratos_gestiona = query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente in (".$us_gerente_ot_solicitu.") group by gestor_abastecimiento");
$concatena_gestor =",0";
while($sel_gestores = traer_fila_db($sel_contratos_gestiona)){
	if($sel_item[5] == 1 or $sel_item[5]== 44){
				if($sel_gestores[0] == 19791){
				$concatena_gestor.=",".$sel_gestores[0];
				}
			}else{
				$concatena_gestor.=",".$sel_gestores[0];		
			}
			
	}
	/*--------- SELECCIONAR LAS PERSONAS DE GESTION ABASTECIMIENTO ----------------*/
		  

  $sele_anexos = query_db("select email from t1_us_usuarios where us_id in (".$us_solicitante.",".$sel_item[23].",".$sel_item[36].",".$us_ot_gerente.", ".$us_gerente_contrato.$concatena_gestor.")");
  while($sl_correo = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }

		  
  ?>
          <tr class="<?=$clase?>">
            <td align="center" ><?=$sl_correo[0]?></td>
            <td align="center" >SI - Enviar Correo</td>
          </tr>
          <?
}
  ?>
        </table>
        <p>&nbsp;</p></td>
      </tr>
      
    </table>
      <table width="100%" border="0" align="center" class="tabla_lista_resultados">
        <tr>
          <td width="54%"><?
          if($_SESSION["id_us_session"]==32){
			  ?>
			  <strong onClick="envio_correo_ot_admin()">Enviar Correos electronicos</strong>
			  <?
			  
			  }
		  ?></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>      
      </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_contratista_ot" id="id_contratista_ot" value="<?=$sel_apl_cota[1]?>" />
<input type="hidden" name="tipo_agrega_quita_correo_ot" id="tipo_agrega_quita_correo_ot" value="" />
<input type="hidden" name="id_correo_relacion" id="id_correo_relacion" value="" />
</body>
</html>
