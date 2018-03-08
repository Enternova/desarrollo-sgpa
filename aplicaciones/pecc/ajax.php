<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$tipo_ajax = $_GET["tipo_ajax"];
	$valor = elimina_comillas(arreglo_recibe_variables($_GET["valor"]));
	$aleatorio = elimina_comillas(arreglo_recibe_variables($_GET["aleatorio"]));
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_presupuesto = elimina_comillas(arreglo_recibe_variables($_GET["id_presupuesto"]));
	$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc_marco"]));
	$tipo_anexo = elimina_comillas(arreglo_recibe_variables($_GET["tipo_anexo"]));
	
if($tipo_ajax == "carga_gerentes"){
	
	$sel_gerentes = query_db("select t1_us_usuarios.us_id, t1_us_usuarios.nombre_administrador from tseg10_usuarios_profesional, t1_us_usuarios where tseg10_usuarios_profesional.id_us = t1_us_usuarios.us_id and (id_us_profesional = ".$_SESSION["id_us_session"]." or id_us_prof_compras_corp = ".$_SESSION["id_us_session"]." or t1_us_usuarios.us_id = ".$_SESSION["id_us_session"].")  group by t1_us_usuarios.us_id, t1_us_usuarios.nombre_administrador");
	
	?><select name="gerente_contra" id="gerente_contra">
          <option value="0">Seleccione el Gerente</option>
          <?
          
		  while($s_gerentes = traer_fila_row($sel_gerentes)){
		  ?>
          <option value="<?=$s_gerentes[0]?>" ><?=$s_gerentes[1]?></option>
          <?
		  }
		  ?>
          </select><?
	
}

if($tipo_ajax == "401"){
?><select name="linea_pecc" id="linea_pecc" onchange="carga_detalle_subcategoria(this.value, '<?=$_GET["id_item"]?>')">
      <option value="0">Seleccione</option>
     
       <?
          $lineas_pecc = query_db("select * from t1_lineas_pecc as t1 where estado = 1 and origen_pec=".$_GET["pecc"]);
		  while($ln_pecc = traer_fila_row($lineas_pecc)){
		  ?>
          <option value="<?=$ln_pecc[0]?>" ><?=$ln_pecc[1]?> - <?=$ln_pecc[2]?></option>
          <?
		  }
		  ?>
          
      </select><?
					   }
//sin numero de incidente pecc inicio
if($tipo_ajax == "400"){
		
	?>
    <td align="right">L&iacute;nea de la Subcategor&iacute;a Registrada en el PECC:</td>
    <td><? if($_GET['edicion_datos_generales'] == "SI"){ ?>
      <select name="linea_pecc" id="linea_pecc" onchange="carga_detalle_subcategoria(this.value, '<?=$_GET['id_item_pecc']?>','<?=$_GET['pecc']?>')">
        <option value="0">Seleccione</option>
        <?
          $lineas_pecc = query_db("select * from t1_lineas_pecc as t1 where estado = 1 and origen_pec=".$_GET['pecc']);
		  while($ln_pecc = traer_fila_row($lineas_pecc)){
		  ?>
        <option value="<?=$ln_pecc[0]?>" <? if($ln_pecc[0] == $_GET['selec_item']) echo 'selected="selected"'?> >
          <?=$ln_pecc[1]?>
          -
          <?=$ln_pecc[2]?>
        </option>
        <?
		  }
		  ?>
      </select>
      <?
}else{
	if($_GET['selec_item'] > 0){
	$sel_linea = traer_fila_row(query_db("select codigo, detalle from t1_lineas_pecc where id = '".$_GET['selec_item']."' and origen_pec=".$_GET['pecc']));
	echo $sel_linea[0]." - ".$sel_linea[1];
	}
	?>
      <input type="hidden" name="linea_pecc" id="linea_pecc" value="<?=$_GET['selec_item']?>" />
      <?
	}
	?></td>
    <td colspan="2">&nbsp;</td>
 
	
	<?
} //sin numero de incidente pecc fin

	if($tipo_ajax == "15"){
	?>
	
	<table width="200" border="0">
    <?
    $sel_si_tiene_sub = query_db("select id, codigo, nombre from t1_lineas_pecc_sub where id_linea_pecc = ".$_GET["linea"]." and estado = 1");

	while($sel_sub_lineas = traer_fila_db($sel_si_tiene_sub)){
		$check = "";
		$sel_sub_relacionadas = traer_fila_row(query_db("select count(*) from t2_relacion_item_sub_linea_pecc where id_item = ".$id_item_pecc." and id_sub_linea_pecc = ".$sel_sub_lineas[0]));
		if($sel_sub_relacionadas[0] >0){
			$check = "checked='checked'";
			}
	?>
      <tr>
        <td width="20"><input name="linea_sub_<?=$sel_sub_lineas[0]?>" id="linea_sub_<?=$sel_sub_lineas[0]?>" type="checkbox" <?=$check?> value="<?=$sel_sub_lineas[0]?>" /></td>
        <td width="170"><?=$sel_sub_lineas[1]?></td>
      </tr>
     <?
	}
	 ?>
    </table>
    <?
	}
	if($tipo_ajax == "crea_proveedor_serv_menor"){
?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td width="33%" rowspan="4" align="left" class="fondo_3"><span >Diligencie los siguientes datos para proceder a crear el proveedor en la base de datos del SGPA y de esta manera poder agregarlo a este servicio menor.</span></td>
    <td width="23%" align="right">Raz&oacute;n Social:</td>
    <td colspan="4"><input name="nom" type="text" id="nom" size="5" /></td>
    <td width="8%" rowspan="4" align="center"><input name="button5" type="button" class="boton_grabar" id="button5" value="Agregar" onclick="valida_proveedor_nuevo('SM')" /></td>
  </tr>
  <tr>
    <td align="right">
    NIT.:</td>
    <td width="20%"><input name="nit" type="text" id="nit" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" maxlength="11"/></td>
    <td width="2%" align="right">DV:</td>
    <td width="3%"><input name="dver" type="text" id="dver" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" size="5" maxlength="1"/></td>
    <td width="11%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">E-mail:</td>
    <td colspan="4"><input name="email3" type="text" id="email3" size="5" /></td>
  </tr>
  <tr>
    <td align="right">Validaci&oacute;n de Listas Restrictivas: <?=$_SESSION["alerta_de_archivos"]?></td>
    <td colspan="4"><input type="file" name="archivo_lista_restrictiva" id="archivo_lista_restrictiva" /></td>
  </tr>
  
</table>
<?
}	
if($tipo_ajax == "crea_proveedor_serv_menor_solicitante"){
?><br>

<table width="80%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
      <td width="35%" align="right">Proveedores Sugeridos:</td>
    <td width="65%"><textarea name="prove_sugiere" id="prove_sugiere" cols="25" rows="3"></textarea></td>
    
  </tr>
  
  <tr>
    <td align="right"> </td>
    <td align="right"><br><input type="button" value="Crear Servicio Menor con Proveedor(es) Sugerido(s)" class="boton_grabar" onclick="muestra_alerta_general_solo_texto('agrega_proveedor_ser_menor(-comillas-sin_proveedor-comillas-, -comillas--comillas-, -comillas--comillas-, -comillas--comillas-)', 'Advertencia', 'En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni realizar negociaci&oacute;n con ellos')"/></td>
  </tr>
  
</table>
<br>



<?
}	
	if($tipo_ajax == "convierte_marco_edita"){
		?><select name="conbierte_a_marco" id="conbierte_a_marco">
        
        <option value="2" selected="selected">NO</option>
        <option value="1">SI</option>
        
        </select><?
		}
		
	if($tipo_ajax == "convierte_marco"){
		?><select name="conbierte_a_marco" id="conbierte_a_marco" onchange="cambia_titulo_valores(this.value)">
        
        <option value="2" selected="selected">NO</option>
        <option value="1">SI</option>
        
        </select><?
		}
	if($tipo_ajax == 1){
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_busca = arreglo_recibe_variables($_GET["contra_busca"]);
		
		$comple_sql = "";
		
		if($n_contrato_ano == 9){
			$n_contrato_ano = "2009";
			}
		if($n_contrato_ano == 10){
			$n_contrato_ano = "2010";
			}
		if($n_contrato_ano == 11){
			$n_contrato_ano = "2011";
			}
		if($n_contrato_ano == 12){
			$n_contrato_ano = "2012";
			}
		if($n_contrato_ano == 13){
			$n_contrato_ano = "2013";
			}
		if($n_contrato_ano == 14){
			$n_contrato_ano = "2014";
			}
		if($n_contrato_ano == 15){
			$n_contrato_ano = "2015";
			}
		if($n_contrato_ano == 16){
			$n_contrato_ano = "2016";
			}
		if($n_contrato_ano == 17){
			$n_contrato_ano = "2017";
			}
		if($n_contrato_ano == 18){
			$n_contrato_ano = "2018";
			}
		if($n_contrato_ano == 19){
			$n_contrato_ano = "2019";
			}
		if($n_contrato_ano == 20){
			$n_contrato_ano = "2020";
			}
		
		
		
		if($numero1_pecc != ""){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != ""){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != ""){
			$comple_sql.=" and num3 like '%".$numero3_pecc."%'";
			}
			
			$areas_in="";
		if($bus_area != 0){
			
			if($bus_area == 34){
				  $areas_in = $areas_in.", ".$bus_area.", 24";
			  	  }elseif($bus_area == 35){
				  $areas_in = $areas_in.", ".$bus_area.", 25,20";
				  }elseif($bus_area == 36){
				  $areas_in = $areas_in.", ".$bus_area.", 22,26,32";
				  }elseif($bus_area == 37){
				  $areas_in = $areas_in.", ".$bus_area.", 6";
				  }elseif($bus_area == 38){
				  $areas_in = $areas_in.", ".$bus_area.", 21, 29";
				  }elseif($bus_area == 39){
				  $areas_in = $areas_in.", ".$bus_area.", 12";
				  }elseif($bus_area == 40){
				  $areas_in = $areas_in.", ".$bus_area.", 17";
				  }elseif($bus_area == 41){
				  $areas_in = $areas_in.", ".$bus_area.", 18";
				  }elseif($bus_area == 44){
				  $areas_in = $areas_in.", ".$bus_area.", 1";
				  }elseif($bus_area == 46){
				  $areas_in = $areas_in.", ".$bus_area.", 31";
				  }elseif($bus_area == 47){
				  $areas_in = $areas_in.", ".$bus_area.", 13";
				  }elseif($bus_area == 48){
				  $areas_in = $areas_in.", ".$bus_area.", 7";
				  }elseif($bus_area == 49){
				  $areas_in = $areas_in.", ".$bus_area.", 8";
				  }elseif($bus_area == 50){
				  $areas_in = $areas_in.", ".$bus_area.", 14";
				  }elseif($bus_area == 55){
				  $areas_in = $areas_in.", ".$bus_area.", 5";
				  }else{
		  			$areas_in = $areas_in.", ".$bus_area;
					}
					
			$comple_sql.=" and t1_area_id in ( 0 ".$areas_in.")";
			}
		if($bus_text1 != ""){
			$comple_sql.=" and alcance like '%".$bus_text1."%'";
			}
		if($bus_text2 != ""){
			$comple_sql.=" and justificacion like '%".$bus_text2."%'";
			}
		if($bus_text3 != ""){
			$comple_sql.=" and recomendacion like '%".$bus_text3."%'";
			}
		if($bus_text4 != ""){
			$comple_sql.=" and objeto_contrato like '%".$bus_text4."%'";
			}
		if($bus_text5 != ""){
			$comple_sql.=" and objeto_solicitud like '%".$bus_text5."%'";
			}
			
		if($n_contrato != ""){
			$comple_sql.=" and numero_contrato = '".$n_contrato."'";
			}

		if($n_contrato_ano != ""){
			$comple_sql.=" and fecha_crea_contrato like '%".$n_contrato_ano."%'";
			}
		
		if($contra_busca != ""){
			$comple_sql.=" and razon_social like '%".$contra_busca."%'";
			}
			
			
		
	?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td width="8%" align="center" class="fondo_3"><strong>Seleccionar</strong></td>
      <td width="8%" align="center" class="fondo_3"><strong>Numero de la Solicitud</strong></td>
      <td width="7%" align="center" class="fondo_3">Numero del Contrato Marco</td>
      <td width="18%" align="center" class="fondo_3">Contratista</td>
      <td width="19%" align="center" class="fondo_3">Objeto de la solicitud</td>
      <td width="26%" align="center" class="fondo_3">Objeto del Contrato Marco</td>
      <td width="14%" align="center" class="fondo_3">&Aacute;rea Usuaria</td>
  </tr>
      <?
	  
$fecha_hoy = date("Y-m-d");

	  
      	$sel_contratos_marco = query_db("select id_item,num1,num2,num3,numero_contrato,fecha_crea_contrato,objeto_solicitud,objeto_contrato,area,alcance,justificacion,recomendacion, apellido, razon_social, fecha_fin_contrato, id_contrato from $vpeec4 where id_item > 0 and fecha_fin_contrato>= '$fecha_hoy' ".$comple_sql."");
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			$numero_contrato1 = "C";
			
			$separa_fecha_crea = explode("-",$sel_contra[5]);
			$ano_contra = $separa_fecha_crea[0];
			
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sel_contra[4];
			$numero_contrato4 = $sel_contra[12];
			
			$fecha_vence = date("Y-m-d", strtotime($fecha_hoy." + 3 months"));
			$mensaje_alerta="";
			if($sel_contra[14] <= $fecha_vence){
				$mensaje_alerta = "Este Contrato esta Proximo a Vencer ".$sel_contra[14];
				}
			
	  ?>
    <tr>
      <td align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" onclick="ajax_carga('../aplicaciones/pecc/formulario-amplia-pecc.php?id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&id_item_pecc=<?=$sel_contra[0]?>&id_contrato_pass=<?=$sel_contra[15]?>','carga_formulario_solicitud');document.getElementById('buscardor_solicitud_contrato_marco').style.display='none';document.getElementById('carga_formulario_solicitud').style.display=''" /></td>
      <td><strong><?=numero_item_pecc($sel_contra[1],$sel_contra[2],$sel_contra[3])?></strong></td>
      <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[15])?> <span class="titulos_resumen_alertas"><?=$mensaje_alerta?></span></td>
      <td><?=$sel_contra[13]?></td>
      <td><?=$sel_contra[6]?></td>
      <td><?=$sel_contra[7]?></td>
      <td><?=$sel_contra[8]?></td>
  </tr>
      <?
		}
	  ?>
</table>
<?
	}
	
if($tipo_ajax == "busca_solicitud_pecc_modificado"){
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_busca = arreglo_recibe_variables($_GET["contra_busca"]);
		$profesional_cyc = arreglo_recibe_variables($_GET["profesional_cyc"]);
		$tp_proceso_busca = arreglo_recibe_variables($_GET["tp_proceso_busca"]);
		$tipo_proceso = arreglo_recibe_variables($_GET["tipo_proceso"]);
		
		$explode = explode("----,",$_GET["usuario_permiso"]);
		$id_usuario = $explode[1];
		
		
		$comple_sql = "";
		
		if($n_contrato_ano == 9){
			$n_contrato_ano = "2009";
			}
		if($n_contrato_ano == 10){
			$n_contrato_ano = "2010";
			}
		if($n_contrato_ano == 11){
			$n_contrato_ano = "2011";
			}
		if($n_contrato_ano == 12){
			$n_contrato_ano = "2012";
			}
		if($n_contrato_ano == 13){
			$n_contrato_ano = "2013";
			}
		if($n_contrato_ano == 14){
			$n_contrato_ano = "2014";
			}
		if($n_contrato_ano == 15){
			$n_contrato_ano = "2015";
			}
		if($n_contrato_ano == 16){
			$n_contrato_ano = "2016";
			}
		if($n_contrato_ano == 17){
			$n_contrato_ano = "2017";
			}
		if($n_contrato_ano == 18){
			$n_contrato_ano = "2018";
			}
		if($n_contrato_ano == 19){
			$n_contrato_ano = "2019";
			}
		if($n_contrato_ano == 20){
			$n_contrato_ano = "2020";
			}
			
		if($numero1_pecc != ""){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != ""){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != ""){
			$comple_sql.=" and num3 like '%".$numero3_pecc."%'";
			}
			
		if($n_contrato != ""){
			$comple_sql.=" and numero_contrato like '%".$n_contrato."%'";
			}

		if($n_contrato_ano != ""){
			$comple_sql.=" and fecha_crea_contrato like '%".$n_contrato_ano."%'";
			}
		if($bus_area != 0){
			$comple_sql.=" and t1_area_id = ".$bus_area;
			}
		if($bus_text1 != ""){
			$comple_sql.=" and alcance like '%".$bus_text1."%'";
			}
		if($bus_text2 != ""){
			$comple_sql.=" and justificacion like '%".$bus_text2."%'";
			}
		if($bus_text3 != ""){
			$comple_sql.=" and recomendacion like '%".$bus_text3."%'";
			}
		if($bus_text4 != ""){
			$comple_sql.=" and objeto_contrato like '%".$bus_text4."%'";
			}
		if($bus_text5 != ""){
			$comple_sql.=" and objeto_solicitud like '%".$bus_text5."%'";
			}
		if($contra_busca != ""){
			$comple_sql.=" and razon_social like '%".$contra_busca."%'";
			}
		if($profesional_cyc!=""){
			$comple_sql.=" and id_us_profesional_asignado = ".$profesional_cyc."";
			}
		if($tp_proceso_busca!="0"){
			$comple_sql.=" and t1_tipo_proceso_id = ".$tp_proceso_busca."";
			}else{
				$comple_sql.="and t1_tipo_proceso_id in (1,2,3,6, 5, 7)";
				}
		if($id_usuario!=""){
			$comple_sql.=" and id_us = ".$id_usuario."";
			}
			
			
		
	?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td width="8%" align="center" class="fondo_3"><strong>Seleccionar</strong></td>
      <td width="22%" align="center" class="fondo_3"><strong>Numero de la Solicitud</strong></td>
      <td width="51%" align="center" class="fondo_3">Objeto de la solicitud</td>
      <td width="19%" align="center" class="fondo_3">&Aacute;rea Usuaria</td>
  </tr>
      <?
	  
$fecha_hoy = date("Y-m-d");

	  if($tipo_proceso == 15){
		  $comple = " and t1_tipo_proceso_id in (1,2,5,6)";
		  }
	  
      	$sel_contratos_marco = query_db("select * from vista_busca_solicitudes where id_item > 0 $comple $comple_sql and estado > 7 and estado <=32");
		
		
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			
			
			
	  ?>
    <tr>
      <td align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" class="windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; carga_datos_solicitud_pecc_modifica(<?=$sel_contra[0]?>)' /></td>
      <td><strong><?=numero_item_pecc($sel_contra[1],$sel_contra[2],$sel_contra[3])?></strong></td>
      <td><?=$sel_contra[4]?></td>
      <td><?=$sel_contra[6]?></td>
  </tr>
      <?
		}
	  ?>
</table>
<?
	}
		
	if($tipo_ajax == "busca_solicitud_informativo"){
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_busca = arreglo_recibe_variables($_GET["contra_busca"]);
		$profesional_cyc = arreglo_recibe_variables($_GET["profesional_cyc"]);
		$tp_proceso_busca = arreglo_recibe_variables($_GET["tp_proceso_busca"]);
		$tipo_proceso = arreglo_recibe_variables($_GET["tipo_proceso"]);
		
		$explode = explode("----,",$_GET["usuario_permiso"]);
		$id_usuario = $explode[1];
		
		
		$comple_sql = "";
		
		if($n_contrato_ano == 9){
			$n_contrato_ano = "2009";
			}
		if($n_contrato_ano == 10){
			$n_contrato_ano = "2010";
			}
		if($n_contrato_ano == 11){
			$n_contrato_ano = "2011";
			}
		if($n_contrato_ano == 12){
			$n_contrato_ano = "2012";
			}
		if($n_contrato_ano == 13){
			$n_contrato_ano = "2013";
			}
		if($n_contrato_ano == 14){
			$n_contrato_ano = "2014";
			}
		if($n_contrato_ano == 15){
			$n_contrato_ano = "2015";
			}
		if($n_contrato_ano == 16){
			$n_contrato_ano = "2016";
			}
		if($n_contrato_ano == 17){
			$n_contrato_ano = "2017";
			}
		if($n_contrato_ano == 18){
			$n_contrato_ano = "2018";
			}
		if($n_contrato_ano == 19){
			$n_contrato_ano = "2019";
			}
		if($n_contrato_ano == 20){
			$n_contrato_ano = "2020";
			}
			
		if($numero1_pecc != ""){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != ""){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != ""){
			$comple_sql.=" and num3 = '".$numero3_pecc."'";
			}
			
		if($n_contrato != ""){
			$comple_sql.=" and numero_contrato like '%".$n_contrato."%'";
			}

		if($n_contrato_ano != ""){
			$comple_sql.=" and fecha_crea_contrato like '%".$n_contrato_ano."%'";
			}
		if($bus_area != 0){
			$comple_sql.=" and t1_area_id = ".$bus_area;
			}
		if($bus_text1 != ""){
			$comple_sql.=" and alcance like '%".$bus_text1."%'";
			}
		if($bus_text2 != ""){
			$comple_sql.=" and justificacion like '%".$bus_text2."%'";
			}
		if($bus_text3 != ""){
			$comple_sql.=" and recomendacion like '%".$bus_text3."%'";
			}
		if($bus_text4 != ""){
			$comple_sql.=" and objeto_contrato like '%".$bus_text4."%'";
			}
		if($bus_text5 != ""){
			$comple_sql.=" and objeto_solicitud like '%".$bus_text5."%'";
			}
		if($contra_busca != ""){
			$comple_sql.=" and razon_social like '%".$contra_busca."%'";
			}
		if($profesional_cyc!=""){
			$comple_sql.=" and id_us_profesional_asignado = ".$profesional_cyc."";
			}
			
			
			
			
		if($tp_proceso_busca!="0"){
			$comple_sql.=" and t1_tipo_proceso_id = ".$tp_proceso_busca."";
			}else{
				 
				 
		if($tipo_proceso == 15){
		  $comple = " and t1_tipo_proceso_id in (1,2,5,6)";
		  }else{				
				$comple_sql.="and t1_tipo_proceso_id in (1,2,3,6, 5, 7, 12)";
		  }
				}
		if($id_usuario!=""){
			$comple_sql.=" and id_us = ".$id_usuario."";
			}
			
			
		
	?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td width="8%" align="center" class="fondo_3"><strong>Seleccionar</strong></td>
      <td width="22%" align="center" class="fondo_3"><strong>Numero de la Solicitud</strong></td>
      <td width="51%" align="center" class="fondo_3">Objeto de la solicitud</td>
      <td width="19%" align="center" class="fondo_3">&Aacute;rea Usuaria</td>
  </tr>
      <?
	  
$fecha_hoy = date("Y-m-d");

	 
	  
      	$sel_contratos_marco = query_db("select * from vista_busca_solicitudes where id_item > 0 $comple $comple_sql and estado > 7 and estado <=32");
		
		
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			
			
			
	  ?>
    <tr>
      <td align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" class="windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; carga_datos_solicitud_informativo(<?=$sel_contra[0]?>)' /></td>
      <td><strong><?=numero_item_pecc($sel_contra[1],$sel_contra[2],$sel_contra[3])?></strong></td>
      <td><?=$sel_contra[4]?></td>
      <td><?=$sel_contra[6]?></td>
  </tr>
      <?
		}
	  ?>
</table>
<?
	}
	
if($tipo_ajax == 2){

            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc." and t1_tipo_documento_id = 2");
				?>
                
<table width="60%" border="0" align="right" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="30%" align="center" class="fondo_3">Selecci&oacute;n</td>
  </tr>
<?
				while($sel_cont = traer_fila_db($sele_contratos)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
				?>
    <tr>
        <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_cont[0])?></td>
        <td align="center"><input type="checkbox" name="contra_<?=$sel_cont[0]?>" id="contra_<?=$sel_cont[0]?>" value="<?=$sel_cont[0]?>" /></td>
	</tr>
    			<?				
				}
				?>
</table>
<?
			
	}
	if($tipo_ajax == 4){	
	?>
	<select name="tipo_proceso" id="tipo_proceso">
    <option value="0">Seleccione</option>
         <?
		 $sel_tipo_proceso = query_db("select t1_tipo_proceso_id, nombre from $vpeec1 where t1_id_otro_si = $valor and t1_tipo_proceso_id <> 7 group by t1_tipo_proceso_id, nombre "); 
		 while($sel_tp = traer_fila_db($sel_tipo_proceso)){
		 ?>
         <option value="<?=$sel_tp[0]?>"><?=$sel_tp[1]?></option>
         <?
		 }
		 ?>
      </select>
      <?
	}
	if($tipo_ajax == 5){	
	?>
	<select name="tipo_proceso" id="tipo_proceso">
    <option value="0">Seleccione</option>
         <?
		 $sel_tipo_proceso = query_db("select t1_tipo_proceso_id, nombre from $vpeec1 where t1_id_otro_si = 7 and t1_tipo_proceso_id = 7 group by t1_tipo_proceso_id, nombre "); 
		 while($sel_tp = traer_fila_db($sel_tipo_proceso)){
		 ?>
         <option value="<?=$sel_tp[0]?>"><?=$sel_tp[1]?></option>
         <?
		 }
		 ?>
      </select>
      <?
	}
if($tipo_ajax == 3){	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_contratacion = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_contratacion"]));
	

	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	if($sel_item[0]>0){
		$id_tipo_contratacion = $sel_item[4];
		}



if($id_item_pecc > 0){
		$comple_sql_presu = "$pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1";
		$var_pasas_marco = "+document.principal.id_item_pecc_marco.value";
	}else{
		$comple_sql_presu = "$pi8.aleatorio ='".$aleatorio."' and permiso_o_adjudica = 1";
		$var_pasas_marco = "+document.principal.id_item_pecc.value";
		}

$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));

$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $comple_sql_presu and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
<tr>
<td colspan="10"><div id="carga_edita_presupuesto"></div>
</td>
</tr>
        <tr>
          <td colspan="10" align="center"  class="fondo_3">Valor de la Solicitud</td>
        </tr>
        <tr>
        <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
          <td width="11%" align="center" class="fondo_3">Contrato(s) Marco</td>
          <?
			}
		  ?>
          <td width="9%" align="center" class="fondo_3">A&ntilde;o</td>
          <td width="17%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
          
         <?
         if($id_tipo_contratacion<>1 and $id_tipo_contratacion<>0){
		 ?>
          <td width="14%" align="center" class="fondo_3">Destino</td>
		  
          <td width="14%" align="center" class="fondo_3">Relacione el AFE/ CECO disponible para la adquisici&oacute;n:</td>
          <?
		 }
		  ?>
          <td width="12%" align="center" class="fondo_3">Valor USD$</td>
          <td width="13%" align="center" class="fondo_3">Valor COP$</td>
          <td width="8%" align="center" class="fondo_3">Ver Adjunto</td>
          <?
      if($id_tipo_proceso_pecc ==3){
	  ?><td width="7%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td>
	  <? }?>
          <td width="9%" align="center" class="fondo_3">Accion</td>
        </tr>
        <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "A la solicitud que genero los contratos ";
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
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
          
          <td align="center"><?
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
		  ?></td>
          
          <?
			}
		  ?>
          <td align="center"><?=$sel_presu[1]?></td>
          <td align="center"><?=$sel_presu[2]?></td>
          
           <?
		   
         if($id_tipo_contratacion<>1 and $id_tipo_contratacion<>0){
		 ?>
          <td align="center" ><?=$sel_presu[6]?></td> 
		  
          <td align="center" ><?=$sel_presu[8]?></td>
         <?
		 }
		  ?>
          <td align="center" ><?=number_format($sel_presu[4],0)?></td>
          <td align="center"><?=number_format($sel_presu[5],0)?></td>
          <td align="center">
		  <?
          if($sel_presu[3] != " "){
		  ?>
		  <?=saca_nombre_anexo($sel_presu[3])?>
    <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
	  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
    </a>
    <?
			}
	?>
    </td>
         <?
      if($id_tipo_proceso_pecc ==3){
	  ?> <td align="center"><?=$num_sol_aplica?></td><? }?>
          
          
          <td align="center">
          <?  if($id_tipo_proceso_pecc <> 3){?>
          <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&tipo_ajax=6&id_presupuesto=<?=$sel_presu[0]?>&id_item_pecc_marco='<?=$var_pasas_marco?>,'carga_edita_presupuesto')" style="cursor:pointer">
          <?
		  }
          ?>
          <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" /></td>
  </tr>
        <?
			}
			$total_equivale_usd = ($valor_total_cop / $trm_actual) + $valor_total_usd ;
		?>
</table>
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?>
          
          <input type="hidden" name="valor_total_js_valida" id="valor_total_js_valida" value="<?=number_format($total_equivale_usd,0)?>" /></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
<?
if($_GET["tipo_proceso"] == 1 or $_GET["tipo_proceso"] == 2 or $_GET["tipo_proceso"] == 5 or $_GET["tipo_proceso"] == 6 or $_GET["tipo_proceso"] == 7){
?>
<table width="80%" border="0" align="center"  class="tabla_lista_resultados">
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

  $sele_proyectos = query_db("select $g15.nombre, $g15.t1_campo_id from $pi8, $g15 where $comple_sql_presu and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.permiso_o_adjudica = 1 and (valor_usd > 0 or valor_cop > 0) group by $g15.nombre, $g15.t1_campo_id");
  $falta_algun_afe_ceco = 0;
  while($sel_pro = traer_fila_db($sele_proyectos)){
	  $sel_afe_ceco = traer_fila_row(query_db("select id, afe_ceco, adjunto from  t2_relacion_afe_ceco where aleatorio = '".$aleatorio."' and id_campo = '".$sel_pro[1]."' and estado = 1"));
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
    <td><input type="text" name="afe_ceco_<?=$sel_pro[1]?>" id="afe_ceco_<?=$sel_pro[1]?>" value="<?=$sel_afe_ceco[1]?>" /></td>
    <td width="33%"><input type="file" name="afe_ceco_adjunto_<?=$sel_pro[1]?>" id="afe_ceco_adjunto_<?=$sel_pro[1]?>" /> </td>
    <td width="19%"><? if($sel_afe_ceco[2] != ""){   
			  ?>
                <?=saca_nombre_anexo($sel_afe_ceco[2])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_afe_ceco[2]?>&n1=<?=$sel_afe_ceco[0]?>&n3=8" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_afe_ceco[2])?>.gif" width="16" height="16" />
                  </a>
                <?
			  }else{
				  ?><img src="../imagenes/botones/aler-interro.gif" height="16" /> <font color="#FF0000">Falta incluir AFE / CECO</font><?
				  $falta_algun_afe_ceco = $falta_algun_afe_ceco +1;
				  }?></td>
    <td><input type="button" value="Grabar" onclick="graba_afe_ceco(<?=$sel_pro[1]?>, document.principal.afe_ceco_<?=$sel_pro[1]?>.value, document.principal.afe_ceco_adjunto_<?=$sel_pro[1]?>.value)" /></td>
  </tr>
  <?
  }
  ?>
</table>
<?
}else{
	$falta_algun_afe_ceco = 0;
	}
?>


<input type="hidden" name="id_campo_afe_ceco" id="id_campo_afe_ceco" />
<input type="hidden" name="falta_algun_afe_ceco" id="falta_algun_afe_ceco" value="<?=$falta_algun_afe_ceco?>" />

<?
}
if($tipo_ajax == "carga_valor_actual_contra"){	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_contratacion = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_contratacion"]));
	
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	if($sel_item[0]>0){
		$id_tipo_contratacion = $sel_item[4];
		}



if($id_item_pecc > 0){
		$comple_sql_presu = "$pi8.t2_item_pecc_id = ".$id_item_pecc." and permiso_o_adjudica = 1";
		$var_pasas_marco = "+document.principal.id_item_pecc_marco.value";
	}else{
		$comple_sql_presu = "$pi8.aleatorio ='".$aleatorio."' and permiso_o_adjudica = 1";
		$var_pasas_marco = "+document.principal.id_item_pecc.value";
		}

$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));

$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $comple_sql_presu and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco =1");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
?>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
<tr>
<td colspan="10"><div id="carga_edita_presupuesto"></div>
</td>
</tr>
        <tr>
          <td colspan="10" align="center"  class="fondo_3">Valor de la Solicitud</td>
        </tr>
        <tr>
        <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
          <td width="11%" align="center" class="fondo_3">Contrato(s) Marco</td>
          <?
			}
		  ?>
          <td width="9%" align="center" class="fondo_3">A&ntilde;o</td>
          <td width="17%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
          
         <?
         if($id_tipo_contratacion<>1 and $id_tipo_contratacion<>0){
		 ?>
          <td width="14%" align="center" class="fondo_3">Destino</td>
		  
          <td width="14%" align="center" class="fondo_3">Relacione el AFE/ CECO disponible para la adquisici&oacute;n:</td>
          <?
		 }
		  ?>
          <td width="12%" align="center" class="fondo_3">Valor USD$</td>
          <td width="13%" align="center" class="fondo_3">Valor COP$</td>
          <td width="8%" align="center" class="fondo_3">Ver Adjunto</td>
          <?
      if($id_tipo_proceso_pecc ==3){
	  ?><td width="7%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td>
	  <? }?>
          <td width="9%" align="center" class="fondo_3">Accion</td>
        </tr>
        <?
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
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
          
          <td align="center"><?
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
		  ?></td>
          
          <?
			}
		  ?>
          <td align="center"><?=$sel_presu[1]?></td>
          <td align="center"><?=$sel_presu[2]?></td>
          
           <?
		   
         if($id_tipo_contratacion<>1 and $id_tipo_contratacion<>0){
		 ?>
          <td align="center" ><?=$sel_presu[6]?></td>
          <td align="center" ><?=$sel_presu[8]?></td>
          <?
		 }
		  ?>
          <td align="center" ><?=number_format($sel_presu[4],0)?></td>
          <td align="center"><?=number_format($sel_presu[5],0)?></td>
          <td align="center">
		  <?
          if($sel_presu[3] != " "){
		  ?>
		  <?=saca_nombre_anexo($sel_presu[3])?>
    <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[3]?>&n1=<?=$sel_presu[0]?>&n3=3" target="grp">
	  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[3])?>.gif" width="16" height="16" />
    </a>
    <?
			}
	?>
    </td>
         <?
      if($id_tipo_proceso_pecc ==3){
	  ?> <td align="center"><?=$num_sol_aplica?></td><? }?>
          
          
          <td align="center">
          <?  if($id_tipo_proceso_pecc <> 3){?>
          <img src="../imagenes/botones/editar.jpg" width="14" height="15" alt="Editar" title="Editar" onclick="ajax_carga('../aplicaciones/pecc/ajax.php?id_tipo_proceso_pecc='+document.principal.id_tipo_proceso_pecc.value+'&tipo_ajax=6&id_presupuesto=<?=$sel_presu[0]?>&id_item_pecc_marco='<?=$var_pasas_marco?>,'carga_edita_presupuesto')" style="cursor:pointer">
          <?
		  }
          ?>
          <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto(<?=$sel_presu[0]?>)" /></td>
  </tr>
        <?
			}
			$total_equivale_usd = ($valor_total_cop / $trm_actual) + $valor_total_usd ;
		?>
</table>
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="titulos_resumen_alertas">
          <td width="23%" align="right"><!--Total Equivalente USD$:--></td>
          <td width="13%" align="left"><? //=number_format($total_equivale_usd)?>
          
          <input type="hidden" name="valor_total_js_valida2" id="valor_total_js_valida2" value="<?=number_format($total_equivale_usd,0)?>" /></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>
<?
}

if($tipo_ajax == 8){	
	if($tipo_anexo == 8){
		$nombre_gen = "Anexos";
		$nombre_anexo = "anexo";
		}
	if($tipo_anexo == 9){
		$nombre_gen = "Antecedentes";
		$nombre_anexo = "antecedente";
		}

?>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="4" align="center"  class="fondo_3">Lista de <?=$nombre_gen?></td>
  </tr>
  <tr>
   <td width="54%" align="center" class="fondo_3">Categor&iacute;a <?=$nombre_gen?></td>
    <td width="54%" align="center" class="fondo_3">Detalle de los <?=$nombre_gen?></td>
    <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
    <td width="10%" align="center" class="fondo_3">Eliminar</td>
  </tr>
  <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS TEXT), adjunto, estado, id_us, id_categoria
 from $pi9 where aleatorio = '".$aleatorio."' and estado = 1 and tipo = '".$nombre_anexo."'");
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
  <td width="54%" align="center"><?
              $sel_catergoria = traer_fila_row(query_db("select * from t1_categoria_anexos where id = ".$sl_anexos[8]));
			  echo $sel_catergoria[1];
			  ?></td>
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
    <td align="center" ><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="eliminar_anexo(<?=$tipo_anexo?>, <?=$sl_anexos[0]?>)"></td>
  </tr>
  <?
}
  ?>
</table>
<?
}
if($tipo_ajax == 9){	
if($tipo_anexo == 8){
		$nombre_gen = "Anexos";
		$nombre_anexo = "anexo";
		}
	if($tipo_anexo == 9){
		$nombre_gen = "Antecedentes";
		$nombre_anexo = "antecedente";
		}

?>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="3" align="center"  class="fondo_3">Lista de <?=$nombre_gen?></td>
  </tr>
  <tr>
    <td width="54%" align="center" class="fondo_3">Detalle de los <?=$nombre_gen?></td>
    <td width="36%" align="center" class="fondo_3">Archivo Adjunto</td>
    <td width="10%" align="center" class="fondo_3">Eliminar</td>
  </tr>
  <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select t2_anexo_id, t2_item_pecc_id, aleatorio, tipo, CAST(detalle AS TEXT), adjunto, estado, id_us from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = '".$nombre_anexo."'");
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
    <td align="center" ><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="eliminar_anexo_edicion(<?=$tipo_anexo?>, <?=$sl_anexos[0]?>)"></td>
  </tr>
  <?
}
  ?>
</table>
<?
}


if($tipo_ajax == 6){	
	$sele_item_pecc_ma = traer_fila_row(query_db("select id_pecc from $pi2 where id_item =".$id_item_pecc_marco));
	$sele_presu_edita = traer_fila_row(query_db("select * from $pi8 where t2_presupuesto_id = $id_presupuesto"));
	$sele_contrato_edita = traer_fila_row(query_db("select * from $pi12 where t2_presupuesto_id =".$id_presupuesto.""));

	
?>
<table width="95%" border="0" align="center" class="tabla_lista_resultados">
<tr>
<td colspan="3" class="fondo_3" align="center">Edici&oacute;n de Linea de Valor de la Solicitud</td>
</tr>
<? if($id_tipo_proceso_pecc==2 or $id_tipo_proceso_pecc==3){
	 $sele_contratos_varios = traer_fila_row(query_db("select count(*) from $pi12 where t2_presupuesto_id =".$id_presupuesto.""));
	
	?>
  <tr>
    <td width="28%" align="right">Seleccion de Contratos Marco:</td>
    <td width="29%" align="left"><select name="aplica_contrato_edita" id="aplica_contrato_edita" onchange="carga_contratos_sin_valores_edita(this.value,<?=$id_item_pecc?>,<?=$id_presupuesto?>)">
          
           <?
           if($id_tipo_proceso_pecc == 2){
		  
		   if($sele_contratos_varios[0] > 0){
			   	$select_contra_varios = 'selected="selected"';
			   }
		   ?>
            <option value="0" <?=$select_contra_varios?>>Uno &oacute; Varios SIN Valores Especificos</option>
            
            <?
		   }			   	

            	$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2");
				
				while($sel_cont = traer_fila_db($sele_contratos)){
					
			
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					
			?>
            <option value="<?=$sel_cont[0]?>" <? if ($sel_cont[0] == $sele_contrato_edita[2] and $sele_contratos_varios[0] == 1) echo 'selected="selected"'?>><?=numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)?></option>
            <?
			
				
		   }
			?>
        </select></td>
    <td width="43%" rowspan="6" valign="top" align="center">
                
<div id="carga_contratos_varios_id_edita">&nbsp;
<?
if($sele_contratos_varios[0] > 1){
?>


<table width="60%" border="0" align="center" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="30%" align="center" class="fondo_3">Selecci&oacute;n</td>
  </tr>
<?
				
				
				$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato from $vpeec4 where id_item =".$id_item_pecc_marco." and t1_tipo_documento_id = 2");
				$select_cont = '';
				while($sel_cont = traer_fila_db($sele_contratos)){
				$sele_contsvar= traer_fila_row(query_db("select count(*) from $pi12 where t2_presupuesto_id =".$id_presupuesto." and t7_contrato_id = ".$sel_cont[0]));
				if($sele_contsvar[0] > 0){					
					$select_cont = 'checked="checked"';
				}else{
					$select_cont = '';
					}
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
				?>
    <tr>
        <td align="center"><?=numero_item_pecc($numero_contrato1,$numero_contrato2,$numero_contrato3)?></td>
        <td align="center"><input type="checkbox" <?=$select_cont?> name="contra_<?=$sel_cont[0]?>_edita" id="contra_<?=$sel_cont[0]?>_edita" value="<?=$sel_cont[0]?>" /></td>
	</tr>
    			<?				
				}
				?>
</table>
<?
		}
?>

</div>
			<?
			

	?></td>
  </tr>
  <?
}else{
	?><input type="hidden" name="aplica_contrato_edita" id="aplica_contrato_edita" value="0" /><?
	}
  ?>
  <tr>
    <td align="right" width="28%">A&ntilde;o:</td>
    <td align="left">
          <select name="ano_edita" id="ano_edita">
            <?=anos_presupuesto($sele_presu_edita[7])?>
           
          </select>
          </td>
  </tr>
  <tr>
    <td align="right">&Aacute;rea/Proyecto:</td>
    <td align="left"><select name="campo_edita" id="campo_edita">
          <option>&Aacute;rea</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",$sele_presu_edita[2] ,'nombre', 2);?>
        </select></td>
  </tr>
  <tr>
    <td align="right">Valor USD$:</td>
    <td align="left"><input name="valor_usd_edita" type="text" id="valor_usd_edita" size="5" value="<?=number_format($sele_presu_edita[5],0)?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td align="right">Valor COP$:</td>
    <td align="left"><input name="valor_cop_edita" type="text" id="valor_cop_edita" size="5" value="<?=number_format($sele_presu_edita[6],0)?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td align="right">Seleccione Archivo Adjunto para Cambiarlo:</td>
    <td align="left"><input name="adj_presupuesto_edita" type="file" id="adj_presupuesto_edita" size="5" /></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Cambios en esta Linea de Presupuesto" onclick="graba_presupuesto_edita()" /></td>
  </tr>
</table>
<input type="hidden" value="<?=$id_presupuesto?>" name="id_presupuesto_edita" id="id_presupuesto_edita" />

<?
}
?>



<?
    	if($tipo_ajax == 7){
		
				
				?>
                
<div id="carga_contratos_varios_id_edita"><table width="60%" border="0" align="center" class="tabla_lista_resultados" cellpadding="2" cellspacing="2">
  <tr>
    <td width="70%" align="center" class="fondo_3">Numero del Contrato Marco</td>
    <td width="30%" align="center" class="fondo_3">Selecci&oacute;n</td>
  </tr>
<?
				$sele_contratos = query_db("select id_contrato,numero_contrato,fecha_crea_contrato, apellido from $vpeec4 where id_item =".$id_item_pecc." and t1_tipo_documento_id = 2");
				$select_cont = '';
				while($sel_cont = traer_fila_db($sele_contratos)){
				$sele_contsvar= traer_fila_row(query_db("select count(*) from $pi12 where t2_presupuesto_id =".$id_presupuesto." and t7_contrato_id = ".$sel_cont[0]));
				if($sele_contsvar[0] > 0){					
					$select_cont = 'checked="checked"';
				}else{
					$select_cont = '';
					}
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_cont[2]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_cont[1];
					$numero_contrato4 = $sel_cont[3];
				?>
    <tr>
        <td align="center"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_cont[0])?></td>
        <td align="center"><input type="checkbox" <?=$select_cont?> name="contra_<?=$sel_cont[0]?>_edita" id="contra_<?=$sel_cont[0]?>_edita" value="<?=$sel_cont[0]?>" /></td>
	</tr>
    			<?				
				}
				?>
</table></div>
			<?
			
			}
			
			
			if($tipo_ajax == 10){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="50%"><input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista()"  />
    </td>
    
    <td><span onclick="pone_datos_contrato(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span> <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' /></td>
  </tr>
</table>
			
			  <?
			
			}
			
			if($tipo_ajax == "solo_proveedores"){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="50%"><input name="proveedores_busca" type="text" id="proveedores_busca" size="25"  onkeypress="selecciona_lista()"  />
    </td>
    
    <td><span onclick="pone_datos_contrato(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span> <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' /></td>
  </tr>
</table>
			
			  <?
			
			}
			
			if($tipo_ajax == "todos_los_contratos"){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="50%"><input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista('infomativo')"  />
    </td>
    
    <td><span onclick="pone_datos_contrato(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span> <img src='../imagenes/botones/eliminada_temporal.gif' onClick='valida_tipo_proceso(11)' /></td>
  </tr>
</table>
			
			  <?
			
			}
			
			if($tipo_ajax == "sol_modificaciones"){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="92%"><strong style="cursor:pointer" class="windowPopup" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca-solicitudes.php?modificacion=1","div_carga_busca_sol"); body.style.overflow = "hidden"'><img src="../imagenes/botones/2.gif" /> Buscar solicitud para relacionar a esta solicitud <img src="../imagenes/botones/aler-interro.gif" width="3" /> </strong> <span id="solicitud_relacionada_actual"><input type='hidden' name='id_solicitud_relacionada' value='0' /></span></td>
  </tr>
</table>
			
<?
			
			}
			if($tipo_ajax == "sol_informativo"){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="92%"><strong style="cursor:pointer" class="windowPopup" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca-solicitudes.php","div_carga_busca_sol"); body.style.overflow = "hidden"'><img src="../imagenes/botones/2.gif" /> Buscar solicitud para relacionar a esta solicitud <img src="../imagenes/botones/aler-interro.gif" width="3" /> </strong> <span id="solicitud_relacionada_actual"></span></td>
  </tr>
</table>
			
<?
			
			}
			
			
			if($tipo_ajax == "carga_contrato_edicion"){	
			?>
			<table width="100%" border="0">
  <tr>
    <td width="92%"><input name="contratos_normales" type="text" id="contratos_normales" size="25"  onkeypress="selecciona_lista()" />
    <span onclick="pone_datos_contrato_edicion(document.principal.contratos_normales.value)">Cargar Informaci&oacute;n del Contrato <img src="../imagenes/botones/2.gif"  /></span></td>
  </tr>
</table>
			
			  <?
			
			}
	?>
<?
    	if($tipo_ajax == 11){
		
				
				?>
                
                
			<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
			  <tr class="filas_resultados">
			    
			    <td width="32%" align="right" class="fondo_3"><span >Buscar Proveedor en Base de Datos:</span></td>
			    <td width="24%" align="right"><label for="select2">Buscar  por Nombre  &oacute; NIT:</label></td>
			    <td colspan="4"><input name="proveedores_busca" type="text" id="proveedores_busca" size="5"  onkeypress="selecciona_lista()"/>
		        <input name="nom3" type="hidden" id="nom3" size="5" />
		        <input name="nit3" type="hidden" id="nit3" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" />
                <input name="dver3" type="hidden" id="dver3" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="5" maxlength="1"/>
                <input name="email3" type="hidden" id="email3" size="5" /></td>
		      </tr>
              <!--
			  <tr>
			    <td rowspan="3" align="right" class="fondo_3"><span >Si no se encuentra registrado en la base de datos; Registrelo, por lo menos con el nombre</span></td>
			    <td align="right">Nombre del Proveedor:</td>
			    <td colspan="4">&nbsp;</td>
		      </tr>
			  <tr>
			    <td align="right">NIT. Del Proveedor:</td>
			    <td width="25%">&nbsp;</td>
			    <td width="2%" align="center">&nbsp;</td>
			    <td width="5%" align="left">&nbsp;</td>
			    <td width="2%" align="left">&nbsp;</td>
		      </tr>
			  <tr>
			    <td align="right">E-mail del Proveedor:</td>
			    <td colspan="4">&nbsp;</td>
		      </tr>
              
        -->      
			  
</table>
<?
		}
?>

<?
	/***** PARA EL DES083 SE ARMA UN BUSCADOR PERSONALIZADO*********/
    	if($tipo_ajax == 99){
		
				
				?>
                
                
			<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
			  <tr class="filas_resultados">
			    
			    <td width="32%" align="right" class="fondo_3"><span >Buscar Proveedor en Base de Datos:</span></td>
			    <td width="24%" align="right"><label for="select2">Buscar  por Nombre  &oacute; NIT:</label></td>
			    <td colspan="4"><input name="proveedores_busca" type="text" id="proveedores_busca_adjudica" size="5"  onkeypress="selecciona_lista()"/>
		        <input name="nom3" type="hidden" id="nom3" size="5" />
		        <input name="nit3" type="hidden" id="nit3" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" />
                <input name="dver3" type="hidden" id="dver3" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="5" maxlength="1"/>
                <input name="email3" type="hidden" id="email3" size="5" /></td>
		      </tr>
              <!--
			  <tr>
			    <td rowspan="3" align="right" class="fondo_3"><span >Si no se encuentra registrado en la base de datos; Registrelo, por lo menos con el nombre</span></td>
			    <td align="right">Nombre del Proveedor:</td>
			    <td colspan="4">&nbsp;</td>
		      </tr>
			  <tr>
			    <td align="right">NIT. Del Proveedor:</td>
			    <td width="25%">&nbsp;</td>
			    <td width="2%" align="center">&nbsp;</td>
			    <td width="5%" align="left">&nbsp;</td>
			    <td width="2%" align="left">&nbsp;</td>
		      </tr>
			  <tr>
			    <td align="right">E-mail del Proveedor:</td>
			    <td colspan="4">&nbsp;</td>
		      </tr>
              
        -->      
			  
</table>
<?
		}
		/***** FIN PARA EL DES083 *********/
?>

<?
    	if($tipo_ajax == 12){
			
				$id_contrato_carr = elimina_comillas(arreglo_recibe_variables($_GET["id_contrato_carr"]));
				if($id_contrato_carr != ""){
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
	  $sele_presupuesto = query_db("select ano, nombre_campo,eq_usd from v_pecc_n_servicio_1 where contrato_id =".$id_contrato_carr);
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
		}
		
		if($tipo_ajax == 13){
			?>
        <table width="100%" border="1" class="tabla_lista_resultados">
                  <tr>
                    <td class="fondo_3">Actividad</td>
                    <td class="fondo_3">Tiempo Estandar</td>
                    <td class="fondo_3">Tiempo no Estandar</td>
                  </tr>
                  <?
                  	$sel_tiempos = query_db("select * from $vpeec21 where id_item = ".$id_item_pecc." order by actividad_estado_id");
					while($s_t = traer_fila_db($sel_tiempos)){
				  ?>
                  <tr>
                    <td><?=$s_t[2]?></td>
                    <td><?=number_format($s_t[3],0)?></td>
                    <td><input type="text" name="tiem_no_est_<?=$s_t[1]?>" id="tiem_no_est_<?=$s_t[1]?>" value="<?=number_format($s_t[4],0)?>" /></td>
                  </tr>
                  <?
					}
				  ?>
                  
                </table><?
		}
		
if($tipo_ajax == 14){	
$id_contrato_carr = elimina_comillas(arreglo_recibe_variables($_GET["id_contrato_carr"]));
	$solicitudes_antecedentes = 0;
	
	$solicitud_madre = traer_fila_row(query_db("select id_item from $co1 where id =".$id_contrato_carr));	
	$sele_otros_si = query_db("select id_item from $pi2 where contrato_id = ".$id_contrato_carr);
	while($sel_item_otros = traer_fila_db($sele_otros_si)){
		$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$sel_item_otros[0];
		}
	
	$solicitudes_antecedentes = $solicitudes_antecedentes.", ".$solicitud_madre[0];
	
	
	
?>

<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
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
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id in (".$solicitudes_antecedentes.") and estado = 1 and tipo = 'antecedente'");
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

if($tipo_ajax == "busqueda_compras"){
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_busca = arreglo_recibe_variables($_GET["contra_busca"]);
		
		$comple_sql = "";
		
		if($numero1_pecc != ""){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != ""){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != ""){
			$comple_sql.=" and num3 like '%".$numero3_pecc."%'";
			}
			
		if($n_contrato != ""){
			$comple_sql.=" and numero_contrato like '%".$n_contrato."%'";
			}

		if($n_contrato_ano != ""){
			$comple_sql.=" and fecha_crea_contrato like '%".$n_contrato_ano."%'";
			}
		if($bus_area != 0){
			$comple_sql.=" and t1_area_id = ".$bus_area;
			}
		if($bus_text1 != ""){
			$comple_sql.=" and alcance like '%".$bus_text1."%'";
			}
		if($bus_text2 != ""){
			$comple_sql.=" and justificacion like '%".$bus_text2."%'";
			}
		if($bus_text3 != ""){
			$comple_sql.=" and recomendacion like '%".$bus_text3."%'";
			}
		if($bus_text4 != ""){
			$comple_sql.=" and objeto_contrato like '%".$bus_text4."%'";
			}
		if($bus_text5 != ""){
			$comple_sql.=" and objeto_solicitud like '%".$bus_text5."%'";
			}
		if($contra_busca != ""){
			$comple_sql.=" and razon_social like '%".$contra_busca."%'";
			}
			
			
		
	?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td width="8%" align="center" class="fondo_3"><strong>Seleccionar</strong></td>
      <td width="8%" align="center" class="fondo_3"><strong>Numero de la Solicitud</strong></td>
      <td width="7%" align="center" class="fondo_3">Numero del Contrato Marco</td>
      <td width="18%" align="center" class="fondo_3">Contratista</td>
      <td width="19%" align="center" class="fondo_3">Objeto de la solicitud</td>
      <td width="26%" align="center" class="fondo_3">Objeto del Contrato Marco</td>
      <td width="14%" align="center" class="fondo_3">&Aacute;rea Usuaria</td>
  </tr>
      <?
      	$sel_contratos_marco = query_db("select id_item,num1,num2,num3,numero_contrato,fecha_crea_contrato,objeto_solicitud,objeto_contrato,area,alcance,justificacion,recomendacion, apellido, razon_social, id_contrato from $vpeec4 where id_item > 0 ".$comple_sql);
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			$numero_contrato1 = "C";
			
			$separa_fecha_crea = explode("-",$sel_contra[5]);
			$ano_contra = $separa_fecha_crea[0];
			
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sel_contra[4];
			$numero_contrato4 = $sel_contra[12];
			
	  ?>
    <tr>
      <td align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" onclick="ajax_carga('../aplicaciones/pecc/formulario-amplia-pecc-compras.php?id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&id_item_pecc=<?=$sel_contra[0]?>','carga_formulario_solicitud');document.getElementById('buscardor_solicitud_contrato_marco').style.display='none';document.getElementById('carga_formulario_solicitud').style.display=''" /></td>
      <td><strong><?=numero_item_pecc($sel_contra[1],$sel_contra[2],$sel_contra[3])?></strong></td>
      <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[14])?></td>
      <td><?=$sel_contra[13]?></td>
      <td><?=$sel_contra[6]?></td>
      <td><?=$sel_contra[7]?></td>
      <td><?=$sel_contra[8]?></td>
  </tr>
      <?
		}
	  ?>
</table>
<?
	}
	
if($tipo_ajax == "busqueda_compras_en_edicion"){
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_busca = arreglo_recibe_variables($_GET["contra_busca"]);
		
		$comple_sql = "";
		
		if($numero1_pecc != ""){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != ""){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != ""){
			$comple_sql.=" and num3 like '%".$numero3_pecc."%'";
			}
			
		if($n_contrato != ""){
			$comple_sql.=" and numero_contrato like '%".$n_contrato."%'";
			}

		if($n_contrato_ano != ""){
			$comple_sql.=" and fecha_crea_contrato like '%".$n_contrato_ano."%'";
			}
		if($bus_area != 0){
			$comple_sql.=" and t1_area_id = ".$bus_area;
			}
		if($bus_text1 != ""){
			$comple_sql.=" and alcance like '%".$bus_text1."%'";
			}
		if($bus_text2 != ""){
			$comple_sql.=" and justificacion like '%".$bus_text2."%'";
			}
		if($bus_text3 != ""){
			$comple_sql.=" and recomendacion like '%".$bus_text3."%'";
			}
		if($bus_text4 != ""){
			$comple_sql.=" and objeto_contrato like '%".$bus_text4."%'";
			}
		if($bus_text5 != ""){
			$comple_sql.=" and objeto_solicitud like '%".$bus_text5."%'";
			}
		if($contra_busca != ""){
			$comple_sql.=" and razon_social like '%".$contra_busca."%'";
			}
			
		$sel_item_b = traer_fila_row(query_db("select num1 from t2_item_pecc where id_item=".$_GET["id_item_pecc"]));
		if($_GET["id_tipo_proceso_pecc"] != 2 and $sel_item_b[0] == 'B'){//si es una solicitud "S" de servicios
				$comple_sql.= " and tipo_bien_servicio like '%Bienes%' ";
				}
		if($_GET["id_tipo_proceso_pecc"] != 2 and $sel_item_b[0] == 'S'){//si es una solicitud "S" de servicios
				$comple_sql.= " and tipo_bien_servicio like '%Servicios%' ";
				}
		
			

		
	?>
<table width="100%" border="0" class="tabla_lista_resultados">
    <tr>
      <td width="8%" align="center" class="fondo_3"><strong>Seleccionar</strong></td>
      <td width="8%" align="center" class="fondo_3"><strong>Numero de la Solicitud</strong></td>
      <td width="7%" align="center" class="fondo_3">Numero del Contrato Marco</td>
      <td width="18%" align="center" class="fondo_3">Contratista</td>
      <td width="19%" align="center" class="fondo_3">Objeto de la solicitud</td>
      <td width="26%" align="center" class="fondo_3">Objeto del Contrato Marco</td>
      <td width="14%" align="center" class="fondo_3">&Aacute;rea Usuaria</td>
  </tr>
      <?
      	$sel_contratos_marco = query_db("select id_item,num1,num2,num3,numero_contrato,fecha_crea_contrato,objeto_solicitud,objeto_contrato,area,alcance,justificacion,recomendacion, apellido, razon_social, id_contrato from $vpeec4 where id_item > 0 ".$comple_sql);
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			$numero_contrato1 = "C";
			
			$separa_fecha_crea = explode("-",$sel_contra[5]);
			$ano_contra = $separa_fecha_crea[0];
			
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sel_contra[4];
			$numero_contrato4 = $sel_contra[12];
			
	  ?>
    <tr>
      <td align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" onclick="agrega_solicitud_a_ot(<?=$sel_contra[0]?>)" /></td>
      <td><strong><?=numero_item_pecc($sel_contra[1],$sel_contra[2],$sel_contra[3])?></strong></td>
      <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[14]);?></td>
      <td><?=$sel_contra[13]?></td>
      <td><?=$sel_contra[6]?></td>
      <td><?=$sel_contra[7]?></td>
      <td><?=$sel_contra[8]?></td>
  </tr>
      <?
		}
	  ?>
</table>
<?
	}
	
	
	if($tipo_ajax == "guarda_kpi_ajax"){
		
	$aleatorio = elimina_comillas(arreglo_recibe_variables($_GET["aleatorio"]));

	if($aleatorio){
		$id_item_pecc = $aleatorio;
	}
	$tipo_kpi = $_GET["tipo_kpi"];
	$nombre = $_GET["nombre"];
	$descripcion = $_GET["descripcion"];
	$formula = $_GET["formula"];
	$objetivo = $_GET["objetivo"];
	$periodo = $_GET["periodo"];

	$insert_kpi = query_db("insert into t8_kpi_plantilla (id_item_pecc, id_kpi_tipo, nombre,descripcion,formula,objetivo,periodo,id_usuario) values ($id_item_pecc,$tipo_kpi,'$nombre','$descripcion','$formula','$objetivo',$periodo, ".$_SESSION["id_us_session"].")");

}



	
?>
