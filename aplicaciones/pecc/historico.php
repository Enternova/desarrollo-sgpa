<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));

	
	
	if($id_pecc == 1){
	$comple_sql_histo =" and id_pecc = $id_pecc ";
			$_SESSION['id_peccs'] = "";
			$_SESSION['paginass'] = "";
			$_SESSION['id_tipo_proceso_peccs'] = "";
			$_SESSION['numero1_peccs'] = "";
			$_SESSION['numero2_peccs'] = "";
			$_SESSION['numero3_peccs'] = "";
			$_SESSION['bus_areas'] = "";
			$_SESSION['bus_text1s'] = "";
			$_SESSION['bus_text2s'] = "";
			$_SESSION['bus_text3s'] = "";
			$_SESSION['bus_text4s'] = "";
			$_SESSION['bus_text5s'] = "";	
			$_SESSION['profesional_cycs'] = "";
			$_SESSION['usuario_permisos'] = "";
			$_SESSION['estado_busrs'] = "";
			$_SESSION['tipo_contratacions'] = "";
			$_SESSION['preparador_bs'] = "";
			$_SESSION['muestra_finalizadoss'] = "";
			$_SESSION['tp_proceso_buscas'] = "";
			$_SESSION['num_solped_buss'] = "";	
	}else{
		$comple_sql_histo =" and id_pecc <> 1 ";
		}
		
		
//		$sel_permisos_gestion_abas = traer_fila_row(query_db("select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=44"));

	
	
		$_SESSION['id_peccs'] = $_GET["id_pecc"];
		$selec_las_areas_del_usuario = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_usuario = ".$_SESSION["id_us_session"]." and id_area in (1, 44) and id_usuario not in (53) and estado = 1"));
	
		$areas_in = "0";

		$sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]."");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){

		  					$areas_in = $areas_in.", ".$sel_a_usuario[0];

		  }
		  

		if($selec_las_areas_del_usuario[0]==0 ){//si no es de abastecimiento profesional

			$sel_si_tiene_permiso_de_consulta_general = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 37 and us_id = ".$_SESSION["id_us_session"].""));	
			if($sel_si_tiene_permiso_de_consulta_general[0] == 0){
			
		$comple_sq_us = " and (id_us = ".$_SESSION["id_us_session"]." or id_us_profesional_asignado = ".$_SESSION["id_us_session"]." or t1_area_id in ($areas_in))";
			}
		}
		
		$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		

		/*
		if($sel_us_bodega[0]>0){
			
			$comple_sq_us = " and ( t1_tipo_contratacion_id in (2,3,4))";
			
			}
			*/
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$tp_proceso_busca = arreglo_recibe_variables($_GET["tp_proceso_busca"]);
		
		$muestra_finalizados = arreglo_recibe_variables($_GET["muestra_finalizados"]);
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_provee = arreglo_recibe_variables($_GET["contra_provee"]);
		$num_solped_bus=arreglo_recibe_variables($_GET["num_solped_bus"]);
		$tipo_contratacion = arreglo_recibe_variables($_GET["tipo_contratacion"]);
		$origen_pecc = arreglo_recibe_variables($_GET["origen_pecc"]);
		
		
		$completar_filtros = "";

		if($origen_pecc != "0" and $origen_pecc != ""){
			if($origen_pecc==1){
				$completar_filtros.=" and (origen_pecc <> '' and origen_pecc <> '0' and origen_pecc <> '1')";
				}else{
				$completar_filtros.=" and origen_pecc = '".$origen_pecc."'";
				}
			}
			
		if($numero1_pecc != "0" and $numero1_pecc != ""){
			$completar_filtros.=" and num1 = '".$numero1_pecc."'";
			}
		if($numero2_pecc != "" and $numero2_pecc != 0){
			if($numero2_pecc == 99){
					$completar_filtros.=" and (num2 = '' or num2 = ' ' or num2 is NULL)";		
				}else{
					$completar_filtros.=" and num2 like '%".$numero2_pecc."%'";
				}
			}
		if($numero3_pecc != "" and $numero2_pecc != 99){
			$completar_filtros.=" and num3 = '".$numero3_pecc."'";
			}

		if($num_solped_bus!=""){
			$completar_filtros.=" and num_solped like '%".$num_solped_bus."%'";
			
		}

		
		if($tp_proceso_busca != 0){
			if($tp_proceso_busca==15){
				$completar_filtros.=" and (t1_tipo_proceso_id = ".$tp_proceso_busca." or es_modificacion = 1)";
				}else{
			$completar_filtros.=" and t1_tipo_proceso_id = ".$tp_proceso_busca;
				}
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
				  }elseif($bus_area == 60){
				  $areas_in = $areas_in.", ".$bus_area.", 53";
				  }else{
		  			$areas_in = $areas_in.", ".$bus_area;
					}
					
			$completar_filtros.=" and t1_area_id in (0".$areas_in.")";
			}
			
		
			
		if($bus_text1 != ""){
			$completar_filtros.=" and (alcance like '%".$bus_text1."%' or alcance_adjudica like '%".$bus_text1."%')";
			}
		if($bus_text2 != ""){
			$completar_filtros.=" and (justificacion like '%".$bus_text2."%' or justificacion_adjudica  like '%".$bus_text2."%')";
			}
		if($bus_text3 != ""){
			$completar_filtros.=" and (recomendacion like '%".$bus_text3."%' or recomendacion_adjudica like '%".$bus_text3."%')";
			}
		if($bus_text4 != ""){
			$completar_filtros.=" and (objeto_contrato like '%".$bus_text4."%' or ob_contrato_adjudica like '%".$bus_text4."%')";
			}
		if($bus_text5 != ""){
			$completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%' or ob_solicitud_adjudica like '%".$bus_text5."%')";
			}
		if($_GET["profesional_cyc"] != 0){
				$completar_filtros.=" and id_us_profesional_asignado =".$_GET["profesional_cyc"];
			}
			
				if($_GET["estado_busr"] != 0){
					if($_GET["estado_busr"] == 22){
						$completar_filtros.=" and estado > 20 and estado < 32 and estado <> 31 "; // en legalizacion
						}else{
							
							if($_GET["estado_busr"] == 34){
						$completar_filtros.=" and congelado = 1 and estado <> 33"; // en legalizacion
						}else{					
							if($_GET["estado_busr"] == 33){
						$completar_filtros.=" and estado = 33 and id_us <> 32 and id_us_profesional_asignado <> 32 ";
							}else{
								$completar_filtros.=" and estado =".$_GET["estado_busr"];
								}
						}
						}
						
						
			}else{
				if($_GET["numero3_pecc"] != "" and $_GET["numero3_pecc"] != "0"){
				$completar_filtros.=""; // 
					}else{
				$completar_filtros.=" and estado <> 33"; // no muestre los eliminados
					}
				}
			
			
					
			if($muestra_finalizados == "1"){
				$completar_filtros.=" and de_historico is not null ";//NO muestra los finalizados
				}
			if($muestra_finalizados == "2"){
				$completar_filtros.=" and de_historico is null ";//NO muestra los finalizados
				}
				
				
			
		if($tipo_contratacion <> 0){
			$completar_filtros.=" and t1_tipo_contratacion_id =".$tipo_contratacion;
			}
		
		if($preparador_b <> 0){
			$completar_filtros.=" and id_us_preparador =".$preparador_b;
			}
			
			
			
			
		$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];	
		
		if($id_usuario <> ""){
			$completar_filtros.=" and id_us =".$id_usuario;
			}
			
			
			if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		$_SESSION['paginass'] = $_GET["paginas"];
		}else{

			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
		
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Hist&oacute;rico  </div>
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="7"  class="titulos_secciones">B&uacute;squeda de Solicitudes</td>
    </tr>
  </table>
  <table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="23%" align="right">N&uacute;mero de la Solicitud:</td>
      <td width="6%">
      <? $_SESSION['numero1_peccs'] = $_GET["numero1_pecc"]?>       
      <select name="numero1_pecc" id="numero1_pecc">
       <option value="0" <? if($_GET["numero1_pecc"] == 0) echo "selected='selected'";?>>Todos</option>
        <option value="S" <? if($_GET["numero1_pecc"] == "S") echo "selected='selected'";?>>S</option>
        <option value="B" <? if($_GET["numero1_pecc"] == "B") echo "selected='selected'";?>>B</option>
        <option value="SM" <? if($_GET["numero1_pecc"] == "SM") echo "selected='selected'";?>>SM</option>
       </select></td>
      <td width="10%">
      <? $_SESSION['numero2_peccs'] = $_GET["numero2_pecc"]?>     
      <select name="numero2_pecc" id="numero2_pecc">
      <option value="0" <? if($_GET["numero2_pecc"] == 0) echo "selected='selected'";?>> Todos</option>
      
      <?=anos_consulta_ulti_numeros($_GET["numero2_pecc"])?>
      
      
      
      
      <option value="99" <? if($_GET["numero2_pecc"] == 99) echo "selected='selected'";?>> En Preparaci&oacute;n</option>
        
      </select></td>
      <td width="13%">
      <? $_SESSION['numero3_peccs'] = $_GET["numero3_pecc"]?>
      <input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?=$_GET["numero3_pecc"]?>" /></td>
      <td width="48%" rowspan="14" align="right"><table width="99%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="31%" align="right">Alcance:</td>
          <td width="69%">
          <? $_SESSION['bus_text1s'] = $_GET["bus_text1"]?>
          <textarea name="bus_text1" id="bus_text1" cols="25" rows="2"><?=$_GET["bus_text1"]?></textarea></td>
        </tr>
        <tr>
          <td align="right">Justificaci&oacute;n:</td>
          <td>
          <? $_SESSION['bus_text2s'] = $_GET["bus_text2"]?>          
          <textarea name="bus_text2" id="bus_text2" cols="25" rows="2"><?=$_GET["bus_text2"]?></textarea></td>
        </tr>
        <tr>
          <td align="right">Recomendaci&oacute;n:</td>
          <td>
          <? $_SESSION['bus_text3s'] = $_GET["bus_text3"]?>   
          <textarea name="bus_text3" id="bus_text3" cols="25" rows="2"><?=$_GET["bus_text3"]?></textarea></td>
        </tr>
        <tr>
          <td align="right">Objeto del Contrato:</td>
          <td>
          <? $_SESSION['bus_text4s'] = $_GET["bus_text4"]?>           
          <textarea name="bus_text4" id="bus_text4" cols="25" rows="2"><?=$_GET["bus_text4"]?></textarea></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td align="right">&Aacute;rea Usuaria:</td>
      <td colspan="3">
            <? $_SESSION['bus_areas'] = $_GET["bus_area"]?> 
      <select name="bus_area" id="bus_area">
        <?=listas($g12, " estado = 1",$_GET["bus_area"] ,'nombre', 1);?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Responsable en Abastecimiento:</td>
      <td colspan="3">
                  <? $_SESSION['profesional_cycs'] = $_GET["profesional_cyc"];

				  ?> 
      <select name="profesional_cyc" id="profesional_cyc">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
			
			$sel_profesionales = query_db("select DISTINCT(id_us_profesional_asignado) from t2_item_pecc where estado <> 33 and id_us_profesional_asignado is not null and id_us_profesional_asignado <> 0");
			$profe_aplica=0;
			while($s_prof_sol = traer_fila_db($sel_profesionales)){
				$profe_aplica.=",".$s_prof_sol[0]; 
				}
			
          $sel_profss = query_db("select us_id, nombre_administrador from t1_us_usuarios where us_id in (".$profe_aplica.") order by nombre_administrador");
		  
		  
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $_GET["profesional_cyc"] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select></td>
    </tr>
    <tr>
      <td align="right">Preparador / Usuario que Emula:</td>
      <td colspan="3">
      
      <? $_SESSION['preparador_bs'] = $_GET["preparador_b"]?> 
	  
      <select name="preparador_b" id="preparador_b">
      <option value="0">Todos</option>
 
      <?
	  
	  
      $sele_items_historico = query_db("select id_us_preparador, t1_us_usuarios.nombre_administrador  from v_peec_historico, t1_us_usuarios where v_peec_historico.estado <> 33 and t1_us_usuarios.us_id =  v_peec_historico.id_us_preparador and (select count(*) from t2_relacion_usuarios_emulan where id_us = id_us_preparador) > 0 group by id_us_preparador,t1_us_usuarios.nombre_administrador order by t1_us_usuarios.nombre_administrador" );
	  while($sel_pre = traer_fila_db($sele_items_historico)){
	  ?>
      <option value="<?=$sel_pre[0]?>" <? if ($_GET["preparador_b"] == $sel_pre[0]) echo 'selected="selected"'?>><?=$sel_pre[1]?></option>
      <?
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Solicitante:</td>
      <td colspan="3">
      <? $_SESSION['usuario_permisos'] = $_GET["usuario_permiso"]?>       
      <input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$_GET["usuario_permiso"]?>"/></td>
    </tr>
    <tr>
      <td align="right">Objeto de la Solicitud:</td>
      <td colspan="3">
      <? $_SESSION['bus_text5s'] = $_GET["bus_text5"]?>         
      <textarea name="bus_text5" id="bus_text5" cols="25" rows="2"><?=$_GET["bus_text5"]?></textarea></td>
    </tr>
    <tr>
      <td align="right">Estado:</td>
      <td colspan="3">
      <? $_SESSION['estado_busrs'] = $_GET["estado_busr"]?>              
      <select name="estado_busr" id="estado_busr">
      <option value="0">Seleccione Estado</option>
      <?
	  $sele_items_historico = query_db("select estado, nombre from v_peec_historico where (estado < 21 or estado = 31)   $comple_sql_histo $comple_sq_us group by estado, nombre  order by estado asc" );
	  while($sel_estados = traer_fila_db($sele_items_historico)){
      ?>
      <option value="<?=$sel_estados[0]?>" <? if ($_GET["estado_busr"] == $sel_estados[0]) echo 'selected="selected"'?> ><?=$sel_estados[1]?></option>
      
      
      <?
	  }
	  ?>
      
      <option value="22" <? if ($_GET["estado_busr"] == 22) echo 'selected="selected"'?> >En legalizaci&oacute;n</option>
      <option value="34" <? if ($_GET["estado_busr"] == 34) echo 'selected="selected"'?> >Congelados</option>
      <option value="32" <? if ($_GET["estado_busr"] == 32) echo 'selected="selected"'?> >Finalizado</option>
      <option value="33" <? if ($_GET["estado_busr"] == 33) echo 'selected="selected"'?> >Eliminados / Anulados</option>

      </select></td>
    </tr>
    <tr>
      <td align="right">Ver Solicitudes de Carga Masiva:</td>
      <td colspan="3">
      <? $_SESSION['muestra_finalizadoss'] = $_GET["muestra_finalizados"]?>  
      <select name="muestra_finalizados" id="muestra_finalizados">
      <option value="3" <? if ($_GET["muestra_finalizados"] == 3) echo 'selected="selected"'?> >Todos</option> 
      <option value="2" <? if ($_GET["muestra_finalizados"] == 2) echo 'selected="selected"'?> >NO</option>
           
      <option value="1" <? if ($_GET["muestra_finalizados"] == 1) echo 'selected="selected"'?> >SI</option>
      
      </select></td>
    </tr>
    <tr>
      <td align="right">Tipo de Proceso:</td>
      <td colspan="3">
      <? $_SESSION['tp_proceso_buscas'] = $_GET["tp_proceso_busca"]?>        
      <select name="tp_proceso_busca" id="tp_proceso_busca">
        <?=listas("t1_tipo_proceso", " estado = 1",$_GET["tp_proceso_busca"] ,'nombre', 1);?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Tipo de Solicitud:</td>
      <td colspan="3">
      <? $_SESSION['tipo_contratacions'] = $_GET["tipo_contratacion"]?>          
      <select name="tipo_contratacion" id="tipo_contratacion">
      <option value="0">Todos</option>
      <option value="1" <? if($_GET["tipo_contratacion"] == 1) echo "selected='selected'";?>>Solicitudes de Servicio</option>
      <option value="4" <? if($_GET["tipo_contratacion"] == 4) echo "selected='selected'";?>>Corporativo</option>
      <option value="2" <? if($_GET["tipo_contratacion"] == 2) echo "selected='selected'";?>>MRO Proyectos</option>
      <option value="3" <? if($_GET["tipo_contratacion"] == 3) echo "selected='selected'";?>>MRO Stock</option>
     
      </select></td>
    </tr>
    <tr>
      <td align="right">PECC de Origen de Esta Solicitud:</td>
      <td colspan="3">
       <? $_SESSION['origen_pecc_bus'] = $_GET["origen_pecc"]?> 
      <select name="origen_pecc" id="origen_pecc">
    <option value="0" >Todos</option>
    <option value="1" <? if($_GET["origen_pecc"] == 1) echo "selected='selected'";?>>Todos los A&ntilde;os de PECC</option>
     <?=anos_consulta_defecto_pecc($_GET["origen_pecc"])?>
  </select></td>
    </tr>
    <tr>
      <td align="right">Numero de SOLPED:</td>
      <td colspan="3">
      <? $_SESSION['num_solped_buss'] = $_GET["num_solped_bus"]?> 
      <input type="text" name="num_solped_bus" id="num_solped_bus" value="<?=$_GET["num_solped_bus"]?>"></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/historico.php?tipo_ajax=1&amp;id_pecc=<?=$id_pecc?>&amp;id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&amp;numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&amp;bus_text1='+document.principal.bus_text1.value+'&amp;bus_text2='+document.principal.bus_text2.value+'&amp;bus_text3='+document.principal.bus_text3.value+'&amp;bus_text4='+document.principal.bus_text4.value+'&amp;bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&estado_busr='+document.principal.estado_busr.value+'&tipo_contratacion='+document.principal.tipo_contratacion.value+'&preparador_b='+document.principal.preparador_b.value+'&muestra_finalizados='+document.principal.muestra_finalizados.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&num_solped_bus='+document.principal.num_solped_bus.value+'&origen_pecc='+document.principal.origen_pecc.value,'contenidos')" /></td>
    </tr>
    <tr>
    	<td colspan="5" align="right"><A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/pecc/reportes_historico.php?id_pecc=<?=$id_pecc?>&amp;id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&amp;numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&amp;bus_text1='+document.principal.bus_text1.value+'&amp;bus_text2='+document.principal.bus_text2.value+'&amp;bus_text3='+document.principal.bus_text3.value+'&amp;bus_text4='+document.principal.bus_text4.value+'&amp;bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&estado_busr='+document.principal.estado_busr.value+'&tipo_contratacion='+document.principal.tipo_contratacion.value+'&preparador_b='+document.principal.preparador_b.value+'&muestra_finalizados='+document.principal.muestra_finalizados.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&num_solped_bus='+document.principal.num_solped_bus.value+'&origen_pecc='+document.principal.origen_pecc.value"><strong><font size="+1">Generar Reporte Detallado en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"  /></A>
        
        
        </td>
    </tr>
  </table>
  <br />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
</table>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="11" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="84%" align="right">P&aacute;ginas:</td>
          <td width="16%" align="right">
          <?
		  		  
          $cuantos_registros = traer_fila_row(query_db("select count(*) from t2_item_pecc where estado <> 34 $completar_filtros $comple_sql_histo $comple_sq_us and t1_area_id > 0"));//el estado 34 no existe es simplemente para que no afecte cuenaod quite estado diferente de 33
	  $cunatas_paginas = ($cuantos_registros[0] / $registros_pagina) +1;
	  

	  
		  ?>
          
          <select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/pecc/historico.php?paginas='+this.value+'&tipo_ajax=1&amp;id_pecc=<?=$id_pecc?>&amp;id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&amp;numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&amp;bus_text1='+document.principal.bus_text1.value+'&amp;bus_text2='+document.principal.bus_text2.value+'&amp;bus_text3='+document.principal.bus_text3.value+'&amp;bus_text4='+document.principal.bus_text4.value+'&amp;bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&estado_busr='+document.principal.estado_busr.value+'&tipo_contratacion='+document.principal.tipo_contratacion.value+'&preparador_b='+document.principal.preparador_b.value+'&muestra_finalizados='+document.principal.muestra_finalizados.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value,'contenidos')">
        <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
        <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
          <?=$i?>
          </option>
        <? }?>
      </select></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td width="1%" height="29" align="center" class="columna_subtitulo_resultados">&nbsp;</td>
      <td width="3%" align="center" class="columna_subtitulo_resultados">N&uacute;mero</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Fecha en la que se Puso en Firme</td>
      <td width="6%" align="center" class="columna_subtitulo_resultados">Fecha para Cu&aacute;ndo se Requiere</td>
      <td width="7%" align="center" class="columna_subtitulo_resultados">Tipo de Proceso</td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Contratos Relacionados</td>
      <td width="13%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
      <td width="12%" align="center" class="columna_subtitulo_resultados">Responsable en Abastecimiento</td>
      <td width="21%" align="center" class="columna_subtitulo_resultados">Objeto de la Solicitud</td>
      <td width="7%" align="center" class="columna_subtitulo_resultados">Rol Pendiente para Firmar</td>      
      <td width="16%" align="center" class="columna_subtitulo_resultados">Estado</td>
    </tr>
    <?
	




		
		
		
			
						
						
//			$sele_items_historico_codigo = "select id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id, t1_tipo_contratacion_id, congelado,id_us_preparador from v_peec_historico where estado <> 33  $completar_filtros $comple_sql_histo $comple_sq_us group by id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id,t1_tipo_contratacion_id, congelado,id_us_preparador order by id_item desc";
			
			$sele_items_historico_codigo = "select * from ( select id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id, t1_tipo_contratacion_id, congelado,id_us_preparador,ROW_NUMBER()Over(order by id_item desc) As RowNum,solicitud_rechazada,solicitud_desierta, ob_solicitud_adjudica, fecha_creacion, es_modificacion,fecha_en_firme from v_peec_historico where estado <> 35  $completar_filtros $comple_sql_histo $comple_sq_us and t1_area_id > 0 group by id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id,t1_tipo_contratacion_id, congelado,id_us_preparador,solicitud_rechazada,solicitud_desierta, ob_solicitud_adjudica,  fecha_creacion, es_modificacion,fecha_en_firme ) as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final";

if($_SESSION["id_us_session"]==32){
	//echo $sele_items_historico_codigo;
	}




    	$sel_histo_sql = query_db( $sele_items_historico_codigo);

		
		while($sel_para_insert = traer_fila_db($sel_histo_sql)){
			
			
			
			$id_us_genera=$_SESSION["id_us_session"];
			$id_item=$sel_para_insert[0];
			$sel_item = traer_fila_row(query_db("select estado from $pi2 where id_item=".$id_item)); 	#Query de primera instancia para roles pendientes

			$id_tipo_proceso_pecc = 1;
			if($sel_para_insert[8] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_para_insert[8] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				$_SESSION['id_tipo_proceso_peccs'] = $id_tipo_proceso_pecc;

			$fecha_requiere=$sel_para_insert[4];
			$tipo_proceso=$sel_para_insert[8]+0;
			$contratos_relacionados=contratos_relacionados_solicitud_para_campos($sel_para_insert[0]);
			$usuario_solicitante=$sel_para_insert[11]+0;
			
			if($sel_para_insert[20] != "" and $sel_para_insert[20] != " " and $sel_para_insert[20] != "  " and $sel_para_insert[20] != "	"){
			$objeto_solicitud=$sel_para_insert[20];
			}else{	
			$objeto_solicitud=$sel_para_insert[6];
			}

			$estado=$sel_para_insert[10];
			$area=$sel_para_insert[13]+0;
			$profecional=$sel_para_insert[12]+0;
			$preparador=$sel_para_insert[16]+0;
			$tipo_solicitud=$sel_para_insert[14]+0;
			$tp_proceso="0";
			if ($sel_para_insert[8] == 8 and $sel_para_insert[14] <> 1) { $nom_tipo_proceso = "Orden de Pedido Contrato Marco/Lista de Precios";}else{
      $nom_tipo_proceso = $sel_para_insert[7];
	  
	  }
	  
$comple_est="";
			$numero_proceso=numero_item_pecc($sel_para_insert[1],$sel_para_insert[2],$sel_para_insert[3]);
			$nom_us_solicitante=traer_nombre_muestra($sel_para_insert[11], $g1,"nombre_administrador","us_id");
			if($sel_para_insert[10] > 20 and $sel_para_insert[10] < 32 and $sel_para_insert[10] <> 31){
			  $nom_estado = "En legalizaci&oacute;n";
			  }else{
				  if($sel_para_insert[10]==32 and $sel_para_insert[18]==1){
					  $comple_est=" - RECHAZADO";
					  }
				 if($sel_para_insert[10]==32 and $sel_para_insert[19]==1){
					  $comple_est=" - DECLARADO DESIERTO";
					  }
				  $nom_estado = $sel_para_insert[5].$comple_est;
				  
				  }
				  
				  
		if($sel_para_insert[15] == 1){
				
				$sel_ob_cnogelado = traer_fila_row(query_db("select observacion from t2_acciones_admin where id_item = $id_item and accion = 'Congelado' order by id_accion_admin desc"));
				$nom_estado = "Congelado - ".$sel_ob_cnogelado[0];
			}
			
			
			
			
			
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item." and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		$cont = 0;



  if($sel_para_insert[8]==1 and $sel_para_insert[0] <= 5393) $nom_tipo_proceso =  "Invitacion a Proponer";
  if($sel_para_insert[8]==6 and $sel_para_insert[0] <= 5393) $nom_tipo_proceso =  "Adjudicacion Directa Sondeo";


if($sel_para_insert[8] == 15){ 
	$link_envia = "adjudicacion";
	}elseif(($sel_para_insert[8] == 1 or $sel_para_insert[8] == 2 or $sel_para_insert[8] == 3 or $sel_para_insert[8] == 6) and ($sel_para_insert[10] >=14 and $sel_para_insert[10] !=31 and $sel_para_insert[10] !=33)){ 
	
	$sele_tipo_doc = traer_fila_row(query_db("select count(*) from $vpeec25 where t2_item_pecc_id =".$sel_para_insert[0].""));
			if($sele_tipo_doc[0]>0){
				$link_envia = "adjudicacion-marco";
				}else{
					$sele_tipo_doc_desierto = traer_fila_row(query_db("select * from $vpeec18 where t2_item_pecc_id ='".$sel_para_insert[0]."'"));
					if($sele_tipo_doc_desierto[13]==4){
						$link_envia = "adjudicacion-desierto";
						}else{			
						$link_envia = "adjudicacion";
						}
				}
				
	
		
}else {$link_envia = "edicion-item-pecc";}

//$select_minmima_gestion = traer_fila_row(query_db("select MIN(fecha_real) from t2_nivel_servicio_gestiones where id_item=".$sel_para_insert[0]." and estado = 1"));
//$fecha_puso_firme="";
//if($select_minmima_gestion[0]!=""){
	//$fecha_puso_firme = fecha_en_firme($sel_para_insert[0]);
	$fecha_puso_firme=$sel_para_insert[23];
	//}
				  
	?>
    <tr class="<?=$clase?>">
      <td ><a href="javascript:ajax_carga('../aplicaciones/pecc/<?=$link_envia?>.php?id_item_pecc=<?=$id_item?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
      <td><?=$numero_proceso?></td>
      <td align="center"><?=$fecha_puso_firme?></td>
      <td  align="center"><?=$fecha_requiere?></td>
      <td><? if($sel_para_insert[22]==1){echo "Modificaci&oacute;n";}else {echo $nom_tipo_proceso;}?></td>
      <td><?=$contratos_relacionados?></td>
      <td><?=$nom_us_solicitante?></td>
      <td><? echo saca_nombre_lista($g1,$sel_para_insert[12],'nombre_administrador','us_id');?></td>
      <td><?=$objeto_solicitud?></td>
      <td>
      <?
	  if($sel_item[0] == 7 || $sel_item[0] == 16){
	  $_coma = false;
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$id_item." and id_rol = ".$sel_p_real[0]." and estado = 1 and us_id = ".$_SESSION["id_us_session"]." order by nombre_administrador"));

			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = " .(($sel_item[0] == 7) ? "1" : "2") . "and id_item_pecc = ".$id_item));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));

			if(!($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1)){

				if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2 and $sel_ultima_aprobacion[5] <> 3){

		       		if($_coma){
					
						echo ",<br>";
						
					}
					echo $sel_p_real[1];
					$_coma = true;
				}
			}
			
			
			}	
		}		
      ?>
      </td>
      <td><?=$nom_estado?></td>
    </tr>
    <?
		}
	?>
    <tr class="<?=$class;?>">
      <td colspan="10"></td>
    </tr>
    <tr>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
      <td class="columna_titulo_resultados">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="85%" align="right">Paginas:</td>
          <td width="15%"> <select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/pecc/historico.php?paginas='+this.value+'&tipo_ajax=1&amp;id_pecc=<?=$id_pecc?>&amp;id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&amp;numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&amp;bus_text1='+document.principal.bus_text1.value+'&amp;bus_text2='+document.principal.bus_text2.value+'&amp;bus_text3='+document.principal.bus_text3.value+'&amp;bus_text4='+document.principal.bus_text4.value+'&amp;bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&estado_busr='+document.principal.estado_busr.value+'&tipo_contratacion='+document.principal.tipo_contratacion.value+'&preparador_b='+document.principal.preparador_b.value+'&muestra_finalizados='+document.principal.muestra_finalizados.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value,'contenidos')">
        <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
        <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
          <?=$i?>
          </option>
        <? }?>
      </select></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

</body>
</html>
