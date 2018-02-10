<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_proveedor_edita = elimina_comillas(arreglo_recibe_variables($_GET["id_proveedor_edita"]));
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$sel_proveedor_edita = traer_fila_row(query_db("select * from $g6 where t1_proveedor_id = $id_proveedor_edita"));
	$sel_proveedor_email_edita = traer_fila_row(query_db("select * from $g20 where t1_proveedor_id = $id_proveedor_edita"));
	
	$sel_prove_sugerido = traer_fila_row(query_db("select proveedores_sugeridos,estado from $pi2 where id_item = ".$id_item_pecc));
	
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_prove_sugerido[1], $id_item_pecc) == "SI" and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
			$permiso_editar_solicitante = "SI";
		}
		
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
			$permiso_editar_solicitante = "SI";
			
		}
		
		
		
		
		$es_profesional_designado = verifica_usuario_indicado(8,$id_item_pecc);
		/*echo "ID del proceso: ".$sel_item[0]."<br />";
	echo "ID Nivel de Servicio: ".$sel_item[2]."<br />";
	echo "ID Estado del Proceso: ".$sel_item[14]."<br />";
	echo "Es el Profesional designado: ".$es_profesional_designado."<br />";
	echo "Tiene Permiso de Edicion ".$edicion_datos_generales."<br />";
	*/
	
	if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7){
	 $edicion_datos_generales = "SI";
	$permiso_editar_solicitante = "SI";
	 }
	 
	 /*----------------- PERMISO PARA SERVICIOS MENORES ---------------------*/

if($sel_item[6]==16){
	if($sel_item[6]==16 and ($sel_item[14] < 16) and $sel_item[23] == $_SESSION["id_us_session"]){
		$edicion_datos_generales = "SI";	
		}
	$permiso_editar_solicitante = "NO";
	if($sel_item[14]==31 and ($sel_item[3] == $_SESSION["id_us_session"] or $sel_item[36] == $_SESSION["id_us_session"])){//es el solicitante
		$permiso_editar_solicitante = "SI";

	}
}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/

$sele_si_proveedores_directo_urna = traer_fila_row(query_db("select count(*) from t2_relacion_proveedor where estado = 1 and id_item = ".$id_item_pecc." and justificacion_ingreso_urna!=''"));


if($_SESSION["tipo_carga"]=="1"){//si es del modal de consulta bloquea edicion
	$es_profesional_designado="NO";
	$edita_info_ad_sm = "NO";
	$edicion_datos_generales_pecc = "NO";
	$edicion_datos_generales="NO";
}
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top">
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td align="center"  class="fondo_3">Proveedores Sugeridos por el Gerente de la Solicitud</td>
        </tr>
      <tr>
        <td align="left">
        <? if($edicion_datos_generales == "SI" and $permiso_editar_solicitante == "SI"){
			if($permiso_editar_solicitante == "SI"){ //echo '<br /><span class="letra-descuentos">En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni  realizar negociaci&oacute;n con ellos</span>';
			}
			
			?>
        <textarea name="prove_sugiere" id="prove_sugiere" cols="25" rows="2"><?=$sel_prove_sugerido[0]?></textarea>
        <? } else{
	?>
			<?=nl2br($sel_prove_sugerido[0])?><input type="hidden" name="prove_sugiere" id="prove_sugiere" value="<?=$sel_prove_sugerido[0]?>" />
			<?
	
}?>
        </td>
        </tr>
      <tr>
        <td align="right">
        <? 

		if($edicion_datos_generales == "SI"  and $permiso_editar_solicitante == "SI"){?>
        <input name="button4" type="button" class="boton_grabar" id="button4" value="Editar Proveedores Sugeridos" onclick="muestra_alerta_general_solo_texto('edita_proveedores_sugeridos()', 'Advertencia', 'En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni realizar negociaci&oacute;n con ellos')" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?
		}
		?>
        </td>
      </tr>
    </table>
    <? if ($sel_item[6] <> 16) { // si es servicios menores?>
    
      <br />
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      
        <tr>
          <td colspan="7" align="center"  class="fondo_3">Proveedores Propuestos por el Profesional de C&amp;C</td>
        </tr>
        <tr>
         <? if(($edicion_datos_generales == "SI" and $es_profesional_designado == "SI" and ($sel_item[14] == 6 or $sel_item[14] == 14) )or (esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7)){?>
          <td width="32%" align="right" class="fondo_3"><span >Buscar Proveedor en Base de Datos:</span></td>
          <td width="24%" align="right"><label for="select4">Buscar  por Nombre  &oacute; NIT:</label></td>
          <td colspan="4"><input name="proveedores_busca_adjudicacion" type="text" id="proveedores_busca_adjudicacion" size="5"  onkeypress="selecciona_lista()"/></td>
          <td width="10%" align="right"><input name="button" type="button" class="boton_grabar" id="button" value="Agregar" onclick="valida_proveedor_nuevo_base_datos()"/></td>
        </tr>
        

        <tr>
          <td rowspan="3" align="right" class="fondo_3"><span >Si no se encuentra registrado en la Base de Datos:</span></td>
          <td align="right">Nombre del Proveedor :</td>
          <td colspan="4"><input name="nom" type="text" id="nom" size="5" /></td>
          <td rowspan="3" align="center"><input name="button2" type="button" class="boton_grabar" id="button2" value="Agregar" onclick="valida_proveedor_nuevo()" /></td>
        </tr>
        <tr>
          <td align="right">NIT. Del Proveedor:</td>
          <td width="25%"><input name="nit" type="text" id="nit" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" /></td>
          <td width="2%" align="center">-</td>
          <td width="5%" align="left"><input name="dver" type="text" id="dver" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="5" maxlength="1"/></td>
          <td width="2%" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">E-mail del Proveedor:</td>
          <td colspan="4"><input name="email" type="text" id="email" size="5" /></td>
        </tr>
        
        <?
		 }
		?>
        <tr>
          <td colspan="7">
          <?
          if ($id_proveedor_edita > 0){
		  ?>
          <table width="90%" border="0" align="center"  class="tabla_lista_resultados">
            <tr align="center">
              <td colspan="5"  class="fondo_3">Editar Proveedor</td>
              </tr>
            <tr>
              <td width="50%" align="right">Nombre:</td>
              <td colspan="4" align="center"><input name="nom2" type="text" id="nom2" size="5" value="<?=$sel_proveedor_edita[3]?>" /></td>
              </tr>
            <tr>
              <td align="right">Nit:</td>
              <td width="37%" align="center"><input name="nit2" type="text" id="nit2" size="5"  onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" value="<?=$sel_proveedor_edita[1]?>"/></td>
              <td width="5%" align="center">-</td>
              <td width="6%" align="center"><input name="dver2" type="text" id="dver2" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="5" maxlength="1"   value="<?=$sel_proveedor_edita[2]?>"/></td>
              <td width="2%" align="center">&nbsp;</td>
              </tr>
            <tr>
              <td align="right">E-mail:</td>
              <td colspan="4" align="center"><input name="email2" type="text" id="email2" size="5"  value="<?=$sel_proveedor_email_edita[3]?>"/></td>
              </tr>
            <tr align="center">
              <td colspan="5"><input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Cambios en este Proveedor" onclick="valida_proveedor_edita()" /></td>
              </tr>
          </table>
          <?
		  }
		  ?>
          </td>
        </tr>
        <tr>
          <td colspan="7"><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="5" align="center"  class="fondo_3">Lista de Proveedores Propuestos por el Profesional de C&amp;C</td>
            </tr>
            <tr>
              <td width="23%" align="center" class="fondo_3">Registrado en Par Servicios</td>
              <td width="31%" align="center" class="fondo_3">Nombre</td>
              <td width="13%" align="center"  class="fondo_3">Nit</td>
              <td width="15%" align="center"  class="fondo_3">Ver Calificaci&oacute;n</td>
              <td width="18%" align="center"  class="fondo_3">Acciones</td>
            </tr>
            <?
						
            $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado,  t1.id_relacion_proveedor, creado_actualizado_desde_par from $pi13 as t1, $g6 as t2 where t1.id_item = $id_item_pecc and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado=1");
			while($se_prove = traer_fila_db($sel_proveedores)){
				
				
				if ($se_prove[6] == "SI"){
					$estado_muestra = "SI";
					}else{
						$estado_muestra = "NO";
						}
//$estado_muestra = $se_prove[6];
			?>
            <tr>
              <td align="center"><?=$estado_muestra?></td>
              <td align="center"><?=$se_prove[1]?></td>
              <td align="center"><? if($estado_muestra=="SI") {echo $se_prove[2]."-".$se_prove[3]; }?></td>
              <td align="center"><img title="Calificaciones" src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/desempeno/reporte_general_proveedor.php?id_proveedor=<?=arreglo_pasa_variables($se_prove[0])?>')" /></td>
              <td align="center">
              <? if($edicion_datos_generales == "SI"  and $es_profesional_designado == "SI"){?>
             
              <? if ($estado_muestra == "NO-quitar"){?>
              <img src="../imagenes/botones/editar.jpg" alt="Editar" width="14" height="15" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&id_proveedor_edita=<?=$se_prove[0]?>','contenidos')" />
            <?
			  }
			?>  
              <img src="../imagenes/botones/eliminada_temporal.gif" alt="Eliminar" title="Eliminar" width="16" height="16" onclick="elimina_proveedor('<?=$se_prove[5]?>', 0)" />
                           
              <?
			
			  }
			  ?>
              
              </td>
            </tr>
            <?
            }
			?>
          </table></td>
        </tr>
    </table>
    <? }else{ // fin si es servicios menores?>
   
	<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
	  <? if($edicion_datos_generales == "SI" and $sel_item[14] != 13){?>
	  
	  <tr>
	    <td width="64%"><table width="100%" border="0" align="center"  class="tabla_borde_griz">
	      <tr>
	        <td colspan="3" align="center"  class="fondo_3">Buscar para Agregar Proveedores al Servicio Menor</td>
	        </tr>
	      <tr>
	        <td width="341" align="right">Buscar  por Raz&oacute;n Social </td>
	        <td width="569"><input name="proveedores_busca" type="text" id="proveedores_busca" size="20" value="<?=$proveedores_busca?>"/></td>
	        <td width="328" align="center">&nbsp;</td>
	        </tr>
	      <tr>
	        <td align="right">NIT:</td>
	        <td><input name="nit_busca" type="text" id="nit_busca" size="20" value="<?=$nit_busca?>"/></td>
	        <td align="center"><input name="button_busca2" type="button" class="boton_buscar" id="button_busca2" value="Realizar Busqueda" onclick="ajax_carga('../aplicaciones/pecc/proveedores.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=1&proveedores_busca='+document.principal.proveedores_busca.value+'&nit_busca='+document.principal.nit_busca.value,'contenidos');"/></td>
	        </tr>
	      <tr>
	        <td colspan="3" align="right"><? if($permiso_editar_solicitante == "SI"){ //echo '<br /><span class="letra-descuentos">En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni  realizar negociaci&oacute;n con ellos</span>';
			} 
				if($sel_item[14]>12 and $sel_item[14]<>31){
//					echo '<br /><span class="letra-descuentos">Los proveedores que ingrese en este Servicio Menor, ser&aacute;n agregados a la urna virtual que se encuentre activa y que est&eacute; relacionada a este proceso. </span>';
					
				}
				?></td>
	        </tr>
	      </table>
          </td>
	    </tr>
                <?
		 }
		?>
        <? if($edicion_datos_generales == "SI" and $sel_item[14] == 13 and $yano_aoplica=="esta seccion ahora se maneja en el valor"){?>
	  
	  <tr>
	    <td width="100%">
        
        <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="6" align="center"  class="fondo_3">Agregar Proveedor a ADJUDICAR</td>
    </tr>
  <tr>
    <td width="31%" align="right"><label for="select2">Buscar  por Nombre  &oacute; NIT:</label><input type="hidden" name="prove_adjudicado" id="prove_adjudicado" value="1" /></td>
    <td colspan="4"><!--<input name="proveedores_busca_adjudicacion" type="text" id="proveedores_busca_adjudicacion" size="5"  onkeypress="selecciona_lista()"/>-->
    <select name="proveedores_busca_adjudicacion" id="proveedores_busca_adjudicacion">
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
    </select>
    </td>
    <td width="10%" align="right"><input name="button5" type="button" class="boton_grabar" id="button5" value="Agregar" onclick="muestra_alerta_general_solo_texto('valida_proveedor_nuevo_base_datos()', 'Advertencia', 'Esta seguro de grabar esta acci&oacute;n de Adjudicaci&oacute;n?')"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  
        </table>
          </td>
	    </tr>
                <?
		 }
		?>
        
	  <tr>
	    <td><?
		
$proveedores_busca = elimina_comillas_2($_GET["proveedores_busca"]);	
$nit_busca = elimina_comillas_nit($_GET["nit_busca"]);	

if($proveedores_busca != "" or $nit_busca != ""){// solo si realizo busqueda
?>
      <table width="100%" border="0" align="center"  class="tabla_borde_griz">
        <tr>
          <td colspan="<?	if($permiso_editar_solicitante == "NO" and $edicion_datos_generales == "SI"){ echo "8";}else{echo "7";}
			?>" align="center"  class="fondo_3">Resultado de la Busqueda</td>
        </tr>
        <tr>
          <td width="14%" align="center" class="fondo_3">Estado Par Servicios</td>
          <td width="20%" align="center" class="fondo_3">Raz&oacute;n Social</td>
          <td width="10%" align="center"  class="fondo_3">Nit</td>
          <td width="11%" align="center"  class="fondo_3">Valor Disponible en<strong> USD$</strong><br />
            (Incluso restando este servicio menor)</td>
          <td width="5%" align="center"  class="fondo_3">Ver Reporte</td>
          <?
			
			if($permiso_editar_solicitante == "NO" and $edicion_datos_generales == "SI"){
			?>
          <td width="31%" align="center"  class="fondo_3">Lista<br />
Restrictiva</td>
         
         
         <?
			}
			if($sel_item[14]>12 and $sel_item[14]<>31){
			?> 
         
         <td width="9%" align="center"  class="fondo_3">Justificaci&oacute;n de incluci&oacute;n de Proveedor</td>
         <? }?>
          <td width="9%" align="center"  class="fondo_3">Agregar este proveedor a este servicio menor</td>
        </tr>
        <?
					$comple_sql = "";
					
					if($nit_busca != ""){
						$comple_sql = " nit like '%".$nit_busca."%'";
						}
					if($proveedores_busca != ""){	
						if($nit_busca != ""){ $comple_sql.=" or ";}					
						$comple_sql.= " razon_social  like '%".$proveedores_busca."%'";
						}
					
            $sel_proveedores = query_db("select * from t1_proveedor where $comple_sql and creado_actualizado_desde_par = 'SI' and (estado_parservicios not in  ('Sin Pago')) and t1_proveedor_id not in (select t1.id_proveedor from $pi13 as t1, $g6 as t2 where t1.id_item = $id_item_pecc and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado=1 )  and estado = 1  " );
			
			
									 
												
			while($se_prove = traer_fila_db($sel_proveedores)){
				
			$valores_sm = explode("*",disponible_serv_menor_ano_atras($se_prove[0], 0));
//				[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual  --- [4]=valor_disponible

if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			
			
			$sel_presu = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $pi8 where t2_item_pecc_id =".$id_item_pecc." and permiso_o_adjudica = 1"));
				$valor_solicitud = ($sel_presu[0]) + (($sel_presu[1])/trm_actual());
				
			//$sel_fecha_actualizacion_par = traer_fila_row(query_db("select fecha_creacion from Zlog_parservicios where nit = '".$se_prove[1]."' order by id_ingreso desc"));
			?>
        <tr  class="<?=$clase?>">
          <td align="center"><?=$se_prove[6]?> <? if($sel_fecha_actualizacion_par[0]!="") {?><br />Actualizaci&oacute;n: <?=$sel_fecha_actualizacion_par[0]?><? }?></td>
          <td align="center"><?=$se_prove[3]?></td>
          <td align="center"><?=comprobar_nit_en_par($se_prove[1])?></td>
          <td align="center"><? echo number_format($valores_sm[4] - $valor_solicitud,0); if($valores_sm[4] - $valor_solicitud <= 0) echo "<strong class='letra-descuentos'> - Sin Disponible</strong> ";?></td>
          <td align="center"><img src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/pecc/reporte_ser_menor.php?id_proveedor=<?=$se_prove[0]?>&id_item_pecc_actual=<?=$id_item_pecc?>')" /><img title="Calificaciones" src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/desempeno/reporte_general_proveedor.php?id_proveedor=<?=arreglo_pasa_variables($se_prove[0])?>')" /></td>
          <?
			
			if($permiso_editar_solicitante == "NO" and $edicion_datos_generales == "SI"){
			?><td align="center"><input type="file" name="archivo_lista_restrictiva_<?=$se_prove[0]?>" id="archivo_lista_restrictiva_<?=$se_prove[0]?>" /></td>
          
         <?
			
			}
				$tipo = "edita_solicitante";
				$campo_funct_justifi ="''";
				$campo_funct_adjunto ="''";
				if($permiso_editar_solicitante == "NO" and $edicion_datos_generales == "SI"){
					$tipo = "edita_profesinal";
					$campo_funct_adjunto ="document.principal.archivo_lista_restrictiva_".$se_prove[0];
				}
				
				$link_agrga_proveedor = "agrega_proveedor_ser_menor('".$tipo."', ".$se_prove[0].",".$campo_funct_adjunto.",".$campo_funct_justifi.")";
				if($sel_item[14] == 31){
									
					$link_agrga_proveedor="muestra_alerta_general_solo_texto('agrega_proveedor_ser_menor(-comillas-".$tipo."-comillas-, ".$se_prove[0].",-comillas--comillas-,-comillas--comillas-)', 'Advertencia', 'En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni realizar negociaci&oacute;n con ellos')";
					}
				
				if($sel_item[14]>12 and $sel_item[14]<>31){
					$tipo = "edita_profesinal_directo_urna";
					$campo_funct_justifi ="document.principal.justificacion_inclucion_pro_".$se_prove[0];
			?>
         <td align="center"><textarea name="justificacion_inclucion_pro_<?=$se_prove[0]?>" id="justificacion_inclucion_pro_<?=$se_prove[0]?>"></textarea></td>
         <? } ?>
          <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" width="23" height="20"  onclick="<? if(($valores_sm[4] - $valor_solicitud) < 0) { echo " muestra_alerta_error_solo_texto('', 'Error', 'El proveedor que intenta agregar al servicio menor super&oacute; el monto de USD $".number_format($_SESSION["valor_maximo_ser_menor"],0)." anuales, por favor consulte el reporte para mayor detalle', 17, 5, 20) ";} else { echo $link_agrga_proveedor; }?> "/></td>
        </tr>
       
        <?
            }
						
			?>
             <tr>
               <td colspan="8" align="left">&nbsp;</td>
             </tr>
             <tr>
          <td colspan="8" align="left">
          <? if($permiso_editar_solicitante == "SI"){
			?>
             <table width="100%" cellpadding="2" cellspacing="2" style="border-radius: 10px; border-color: #229BFF; border-bottom: 2px solid #229BFF; border-top: 2px solid #229BFF; border-left: 2px solid #229BFF; border-right: 2px solid #229BFF; margin-bottom: -0px;">	
  <?
    	
    ?>
    	<tr style="border-radius: 10px; border-color: #005395;">
        	<td colspan="4" align="left" style="border-radius: 10px;">
        		<table border="0">
        			<td align="left"><i class="material-icons md-36" style="color: <?=$color_icono?>;">&#xE8FD;</i></td>
        			<td align="left">	
        				<strong>Nota:</strong> Si el proveedor no aparece en la lista del resultado, ingr&eacute;selo en el campo de proveedores sugeridos </font>
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>
			
			<?	
			}else{?>
          <strong>Nota:</strong> Si el proveedor no aparece en la lista del resultado, pruebe haciendo la b&uacute;squeda, escribiendo la raz&oacute;n social completa o raz&oacute;n social corta o sigla o tambi&eacute;n con el NIT sin digito de verificaci&oacute;n, si de todas formas a&uacute;n no encuentra el proveedor por favor de un <font color="#0000FF" style="cursor:pointer" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=crea_proveedor_serv_menor','carga_form_prove_crear')">Click aqu&iacute; para crear un proveedor. </font>
          <?
			}
			  ?>
          
          </td>
        </tr>
             <tr>
               <td colspan="8" align="left"><div  id="carga_form_prove_crear"></div></td>
             </tr>
      </table>
      <?
      }// solo si realizo busqueda
	  ?></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" align="center"  class="tabla_lista_resultados">
	      <tr>
	        <td colspan="10" align="center"  class="fondo_7">Lista de Proveedores Agregados a este Servicio Menor</td>
	        </tr>
	      <tr>
	        <td width="30%" align="center" class="fondo_3">Nombre</td>
	        <td width="10%" align="center"  class="fondo_3">Nit</td>
	        <td width="10%" align="center"  class="fondo_3">Valor de Servicios Menores<br />
	          desde
	          <? $nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; echo  date ( 'Y-m-j' , $nuevafecha ); ?>
	          <strong>USD$</strong></td>
	        <td width="9%" align="center"  class="fondo_3">Valor de esta solicitud <strong>USD$</strong></td>
	        <td width="9%" align="center"  class="fondo_3">Valor Disponible <strong>USD$<br />
	            </strong>
	            (Incluso restando este servicio menor)	        </td>
	        <td width="5%" align="center"  class="fondo_3">Ver<br />
	          Reporte</td>
	        <td width="12%" align="center"  class="fondo_3">Agregado por</td>
	        <td width="6%" align="center"  class="fondo_3">Lista<br />
	          Restrictiva</td>
	          <?
			  if($sele_si_proveedores_directo_urna[0]>0){
			  ?>
	        <td width="10%" align="center"  class="fondo_3">Justificaci&oacute;n de incluci&oacute;n de Proveedor</td>
	        <?
			  }
			  ?>
	        <td width="15%" align="center"  class="fondo_3">Eliminar</td>
	        </tr>
	      <?

            $sel_proveedores = query_db("select t1.id_proveedor, t2.razon_social, t2.nit, t2.digito_verificacion, t2.estado, t1.id_us_crea, t1.es_adjudicado, t1.id_relacion_proveedor, t1.listas_restrictivas, t1.justificacion_ingreso_urna, t2.estado_parservicios from $pi13 as t1, $g6 as t2 where t1.id_item = $id_item_pecc and t1.id_proveedor = t2.t1_proveedor_id and t1.permiso_o_adjudica = 1 and t1.estado=1 order by  t1.id_relacion_proveedor desc");
			while($se_prove = traer_fila_db($sel_proveedores)){
				
				$valores_sm = explode("*",disponible_serv_menor_ano_atras($se_prove[0], $id_item_pecc));
//				[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual  --- [4]=valor_disponible
			
						$sel_fecha_actualizacion_par = traer_fila_row(query_db("select fecha_creacion from Zlog_parservicios where nit = '".$se_prove[2]."' order by id_ingreso desc"));
						
						if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			?>
	      <tr class="<?=$clase?>">
	        <td align="center"><?=$se_prove[1]?><strong>	         <? if ($se_prove[6] ==1 and $se_prove[0] !=1) echo "<font color='#33CC33'>Adjudicado</font>"; if ($se_prove[6] ==1 and $se_prove[0] ==1) echo "<font color='#FF0000'>Declarado Desierto</font>";?>	            </strong><? if($sel_fecha_actualizacion_par[0]!="") {?><br />Estado ParServ. <?=$se_prove[10]?> Actualizaci&oacute;n: <?=$sel_fecha_actualizacion_par[0]?><? }?></td>
	        <td align="center"><? echo $se_prove[2]; if($se_prove[3] != ' ' and $se_prove[3] != '') echo "-".$se_prove[3];?></td>
	        <td align="center"><? echo number_format($valores_sm[1] + $valores_sm[2],0); ?></td>
	        <td align="center"><? echo number_format($valores_sm[3],0); ?></td>
	        <td align="center"><? echo number_format($valores_sm[4],0); if($valores_sm[4] < 0) echo "<strong class='letra-descuentos'> - Sin Disponible</strong> ";?></td>
	        <td align="center"><img src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/pecc/reporte_ser_menor.php?id_proveedor=<?=$se_prove[0]?>&id_item_pecc_actual=<?=$id_item_pecc?>')" /><img title="Calificaciones" src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/desempeno/reporte_general_proveedor.php?id_proveedor=<?=arreglo_pasa_variables($se_prove[0])?>')" /></td>
	        <td align="center"><? echo saca_nombre_lista($g1,$se_prove[5],'nombre_administrador','us_id');?></td>
	        <td align="center"><?
              if($se_prove[8] != " " and $se_prove[8] != ""){
			  ?>
                
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$se_prove[8]?>&n1=<?=$se_prove[7]?>&n3=11" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($se_prove[8])?>.gif" width="16" height="16" />
                  </a>
                <?
			  }
				  ?></td>
        <?
			  if($sele_si_proveedores_directo_urna[0]>0){
			  ?>
	        <td align="center"><?=nl2br($se_prove[9])?></td>
	        <?
			  }
			  ?>
	        <td align="center"><? if($edicion_datos_generales == "SI" and  (($sel_item[14]<=12 or $sel_item[14]==31) or ($se_prove[9] !="" and ($sel_item[14]>12 and $sel_item[14]<13) and $sel_item[14]<>31))){
				  $function_elimina = "elimina_proveedor(".$se_prove[7].",1)";
				  if($se_prove[9] !=""){
					  $function_elimina = "elimina_proveedor_sm(".$se_prove[7].",1)";
					  
				  }
			if($sel_item[23]==$_SESSION["id_us_session"]){//SÓLO SI ES EL PROFESIONAL ASIGNADO SE LE PIEDE COMENTARIOS
			?>
          		<textarea name="comment_elimina_<?=$se_prove[7]?>" id="comment_elimina_<?=$se_prove[7]?>" cols="60" rows="5" placeholder="Ingrese un comentario para poder eliminar el proveedor"></textarea>
          	<?
			}
			?>
	          <img src="../imagenes/botones/eliminada_temporal.gif" alt="Eliminar" title="Eliminar" width="16" height="16" onclick="muestra_alerta_general_solo_texto('<?=$function_elimina?>', 'Advertencia', 'Esta seguro de eliminar este proveedor, tambien lo eliminara de la urna que se encuentra activa relacionada a este proceso?')" />
	          <?
			
			  }
			  ?></td>
	        </tr>
	      <?
            }
			?>
	      </table></td>
	    </tr>
	  </table>
<?
	}
	?>
    </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_proveedor_edita" id="id_proveedor_edita" value="<?=$id_proveedor_edita?>" />
<input type="hidden" name="id_elim_proveedor" id="id_elim_proveedor" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
<input type="hidden" name="id_proveedor_a_relacionar" id="id_proveedor_a_relacionar" />
<input type="hidden" name="tipo_elimna_proveedor" id="tipo_elimna_proveedor" value="0" />



</body>
</html>
