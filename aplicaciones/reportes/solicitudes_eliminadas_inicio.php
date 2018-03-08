<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	

	  

		
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
		
		$fecha1 = arreglo_recibe_variables($_GET["fecha1"]);
		$fecha2 = arreglo_recibe_variables($_GET["fecha2"]);
		$completar_filtros = "";

			
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
			$completar_filtros.=" and tipo_proceso_id = ".$tp_proceso_busca;
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
					
			$completar_filtros.=" and t1_area_id in (0".$areas_in.")";
			}
			
		
			
		
		if($bus_text5 != ""){
			$completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%' or ob_solicitud_adjudica like '%".$bus_text5."%')";
			}
		if($_GET["profesional_cyc"] != 0){
				$completar_filtros.=" and profesional_id =".$_GET["profesional_cyc"];
			}
			
			
			
			
			
		$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];	
		
		if($id_usuario <> ""){
			$completar_filtros.=" and solicitante_id =".$id_usuario;
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
		
		if($fecha1!=""){
			$completar_filtros.=" and fecha>='".$fecha1."'";
			}
		if($fecha1!=""){
			$completar_filtros.=" and fecha<='".$fecha2."'";
			}
		
		
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="div_contenidos_carga">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <tr>
      <td colspan="7"  class="titulos_secciones">B&uacute;squeda de solicitudes eliminadas</td>
    </tr>
  </table>
  <table width="99%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="27%" align="right">Numero de la Solicitud:</td>
      <td width="15%">
      <? $_SESSION['numero1_peccs'] = $_GET["numero1_pecc"]?>       
      <select name="numero1_pecc" id="numero1_pecc">
       <option value="0" <? if($_GET["numero1_pecc"] == 0) echo "selected='selected'";?>>Todos</option>
        <option value="S" <? if($_GET["numero1_pecc"] == "S") echo "selected='selected'";?>>S</option>
        <option value="B" <? if($_GET["numero1_pecc"] == "B") echo "selected='selected'";?>>B</option>
        <option value="SM" <? if($_GET["numero1_pecc"] == "SM") echo "selected='selected'";?>>SM</option>
       </select></td>
      <td width="8%">
      <? $_SESSION['numero2_peccs'] = $_GET["numero2_pecc"]?>     
      <select name="numero2_pecc" id="numero2_pecc">
      <option value="0" <? if($_GET["numero2_pecc"] == 0) echo "selected='selected'";?>> Todos</option>
      
      <?=anos_consulta_ulti_numeros($_GET["numero2_pecc"])?>
      
      
      
      
        
      </select></td>
      <td width="10%">
      <input name="numero3_pecc" type="text" id="numero3_pecc" size="5" maxlength="4" value="<?=$_GET["numero3_pecc"]?>" /></td>
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    
    <tr>
      <td align="right">&Aacute;rea Usuaria:</td>
      <td colspan="3">
      <select name="bus_area" id="bus_area">
        <?=listas($g12, " estado = 1",$_GET["bus_area"] ,'nombre', 1);?>
      </select></td>
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Responsable en Abastecimiento:</td>
      <td colspan="3">
               
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
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Solicitante:</td>
      <td colspan="3">

      <input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()" value="<?=$_GET["usuario_permiso"]?>"/></td>
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Objeto de la Solicitud:</td>
      <td colspan="3">
      <textarea name="bus_text5" id="bus_text5" cols="25" rows="2"><?=$_GET["bus_text5"]?></textarea></td>
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Tipo de Proceso:</td>
      <td colspan="3">
      <select name="tp_proceso_busca" id="tp_proceso_busca">
        <?=listas("t1_tipo_proceso", " estado = 1",$_GET["tp_proceso_busca"] ,'nombre', 1);?>
      </select></td>
      <td width="40%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Rango inicial de Eliminaci&oacute;n:</td>
      <td colspan="2" ><input type="text" name="fecha1" id="fecha1"  onmousedown="calendario_sin_hora('fecha1')" value="<?=$fecha1?>" /></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Rango Final de Eliminaci&oacute;n:</td>
      <td colspan="2" ><input type="text" name="fecha2" id="fecha2"  onmousedown="calendario_sin_hora('fecha2')" value="<?=$fecha2?>" /></td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="27%" align="right">&nbsp;</td>
      <td colspan="5" align="center"><input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/reportes/solicitudes_eliminadas_inicio.php?numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&fecha1='+document.principal.fecha1.value+'&fecha2='+document.principal.fecha2.value,'contenidos')" /></td>
    </tr>
    <tr>
    	<td colspan="5" align="right"><A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/reportes/solicitudes_eliminadas_excel.php?numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&fecha1='+document.principal.fecha1.value+'&fecha2='+document.principal.fecha2.value">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A>
        
        
        </td>
    </tr>
  </table>
  <br />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
</table>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
      <td colspan="3" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
        <tr>
          <td width="63%" align="right">Paginas:</td>
          <td width="37%" align="right"><?

          $cuantos_registros = traer_fila_row(query_db("select count(*) from v_reporte_solicitudes_eliminadas where id_item > 0  $completar_filtros $comple_sql_histo $comple_sq_us "));//el estado 34 no existe es simplemente para que no afecte cuenaod quite estado diferente de 33
	  $cunatas_paginas = ($cuantos_registros[0] / $registros_pagina) +1;
	  

	  
		  ?>
            <select name="paginas2" id="paginas2" onchange="ajax_carga('../aplicaciones/reportes/solicitudes_eliminadas_inicio.php?paginas='+this.value+'&numero1_pecc='+document.principal.numero1_pecc.value+'&amp;numero2_pecc='+document.principal.numero2_pecc.value+'&amp;numero3_pecc='+document.principal.numero3_pecc.value+'&amp;bus_area='+document.principal.bus_area.value+'&bus_text5='+document.principal.bus_text5.value+'&profesional_cyc='+document.principal.profesional_cyc.value+'&usuario_permiso='+document.principal.usuario_permiso.value+'&tp_proceso_busca='+document.principal.tp_proceso_busca.value+'&fecha1='+document.principal.fecha1.value+'&fecha2='+document.principal.fecha2.value,'contenidos')">
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
      <td width="4%" height="29" align="center" class="columna_subtitulo_resultados">Numero</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Fecha de Creacion</td>
      <td width="4%" align="center" class="columna_subtitulo_resultados">Tipo de Proceso</td>
      <td width="7%" align="center" class="columna_subtitulo_resultados">Area de la Solicitud</td>
      <td width="9%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
      <td width="8%" align="center" class="columna_subtitulo_resultados">Responsable en Abastecimiento</td>
      <td width="14%" align="center" class="columna_subtitulo_resultados">Objeto de la Solicitud</td>
      <td width="10%" align="center" class="columna_subtitulo_resultados">Fecha en la que se Elimino</td>
      <td width="10%" align="center" class="columna_subtitulo_resultados">Usuario que Elimino</td>      
      <td width="18%" align="center" class="columna_subtitulo_resultados">Observacion de Eliminacion</td>
      <td width="11%" align="center" class="columna_subtitulo_resultados">Estado Antes de Eliminar</td>
      <td width="11%" align="center" class="columna_subtitulo_resultados">Soporte de Eliminacion</td>
    </tr>
    <?
	




		
		
		
			
						
						
			
	$sele_items_historico_codigo = "select * from ( select id_item, num1, num2, num3, fecha_creacion, t1_area_id, area, objeto_solicitud, tipo_proceso_id, tipo_proceso, solicitante, solicitante_id, profesional, profesional_id, preparador, preparador_id, id_accion_admin, fecha, adjunto, usuario_admin,observacion, (select max(t2_nivel_servicio_actividad_id) from t2_nivel_servicio_gestiones where t2_nivel_servicio_gestiones.estado = 1 and t2_nivel_servicio_gestiones.id_item = v_reporte_solicitudes_eliminadas.id_item) as ultima_gestion, ROW_NUMBER()Over(order by fecha desc) As RowNum from v_reporte_solicitudes_eliminadas where id_item > 0  $completar_filtros $comple_sql_histo $comple_sq_us group by id_item, num1, num2, num3, fecha_creacion, t1_area_id, area, objeto_solicitud, tipo_proceso_id, tipo_proceso, solicitante, solicitante_id, profesional, profesional_id, preparador, preparador_id, id_accion_admin, fecha, adjunto, usuario_admin, observacion ) as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final";




    	$sel_histo_sql = query_db( $sele_items_historico_codigo);

		
		while($sel_para_insert = traer_fila_db($sel_histo_sql)){
			
			
			
			$numero_proceso=numero_item_pecc($sel_para_insert[1],$sel_para_insert[2],$sel_para_insert[3]);		
			
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }

 $estado = "";
 
 if($sel_para_insert[1]==""){$estado = 31;}else{
	 
	 if($sel_para_insert[21]>0){
		 if($sel_para_insert[21]== 1){
			 $estado = 6;
			 }else{
		$estado =  $sel_para_insert[21];}
		 }else{
			 $estado = 31;
			 }
	 }
 

 
				  
	?>
    <tr class="<?=$clase?>">
      <td><?=$numero_proceso?></td>
      <td align="center"><?=$sel_para_insert[4]?></td>
      <td><?=$sel_para_insert[9]?></td>
      <td><?=$sel_para_insert[6]?></td>
      <td><?=$sel_para_insert[10]?></td>
      <td><?=$sel_para_insert[12]?></td>
      <td><?=$sel_para_insert[7]?></td>
      <td><?=$sel_para_insert[17]?></td>
      <td><?=$sel_para_insert[19]?></td>
      <td><?=$sel_para_insert[20]?></td>
      <td><?=traer_nombre_muestra($estado, "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      <td>
      <?=saca_nombre_anexo($sel_para_insert[18])?>
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_para_insert[18]?>&n1=<?=$sel_para_insert[16]?><?=$sel_para_insert[0]?>&n3=4" target="grp"> <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_para_insert[18])?>.gif" width="16" height="16" /></a></td>
    </tr>
    <?
		}
	?>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

</body>
</html>
