<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
<link href="../../css/estilo-principal.css?act=2" rel="stylesheet" type="text/css" />
</head>
<body >
</p>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">Reporte de estados de procesos</td>
  </tr>
</table>
<br />  


<table width="95%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados">Filtro del Reporte</td>
  </tr>
  <tr>
    <td colspan="4" align="ledt" class="texto_paginador_proveedor"><p>&nbsp;</p>
      <p><br>
    </p></td>
  </tr>
  <tr>
    <td align="right" width="25%">Rango de Fecha Incial:</td>
    <td  width="25%"><input name="f_a" type="text" class="f_fechas" id="f_a" onMouseDown="calendario_se('f_a')" value="<?=$f_a;?>" /></td>
    <td align="right"  width="25%">Rango de Fecha  Final:</td>
    <td  width="25%"><input name="f_c" type="text" class="f_fechas" id="f_c" onMouseDown="calendario_se('f_c')" value="<?=$f_c;?>" /></td>
  </tr>
  <tr>
    <td align="right">Profesional de C&amp;C:</td>
    <td>
               <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " tipo_usuario in (1,3,10) and estado = 1 and us.us_id not in (1,32) and pv_principal <> 150   GROUP BY us.us_id, us.nombre_administrador  ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
						
					?>
                    
      <select name="k_b" id="k_b">
        <?=listas_mayus($t1." us INNER JOIN pro1_proceso ON us_id_contacto = us.us_id", $traer_tecnicos_compras ,$k_b,'nombre_administrador', 1);?>
      </select>
    
    
</td>
    <td align="right">Estado:</td>
    <td><select name="g_b" id="g_b">
      <?=listas($tp1, " tp1_id not in (1,2,3,6) ",$g_b,'nombre', 1);?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Tipo de Proceso:</td>
    <td>
               <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " tp2_id in (1,2,3,8,10,11,16,30)  ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " tp2_id in (31) ";
						
					?>
                    
    <select name="tp2_id_bus" id="tp2_id_bus">
      <?=listas($tp2, $traer_tecnicos_compras ,$tp2_id_bus,'nombre', 1);?>
    </select></td>
    <td align="right">Tipo de Solicitud:</td>
    <td>
    <?
			if($_SESSION["pv_principal"] != 150)
			$filtro_lista_contra =  " tp3_id not in (3)";
		if($_SESSION["pv_principal"] == 150)
			$filtro_lista_contra = " tp3_id	 in (3)";		
			?>
            
    <select name="tp3_id_busq" id="tp3_id_busq">
      <?=listas($tp3, $filtro_lista_contra,$tp3_id_busq,'nombre', 1);?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center"><input type="button" name="button" class="buscar" id="button" value="Generar reporte" onClick="javascript:busqueda_paginador_nuevo_reporte(1,'../aplicaciones/reportes/re1.php','contenidos', '1')" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<? 
	if( ($f_a!="") && ($f_c!="") ) {
		
	 if($_GET["f_a"]!="")
	 	$complem.= " and  fecha_apertura >= '".$_GET["f_a"]."'";
	 
 	 if($_GET["f_c"]!="")
	 	$complem.= " and fecha_cierre <= '".$_GET["f_c"]."'";
 	 if($_GET["g_b"]>=1)
	 	$complem.= " and tp1_id = ".$_GET["g_b"];

 	 if($_GET["tp3_id_busq"]>=1)
	 	$complem.= " and tp3_id = ".$_GET["tp3_id_busq"];	
		
 	 if($_GET["tp2_id_bus"]>=1)
	 	$complem.= " and tp2_id = ".$_GET["tp2_id_bus"];	
		
 	 if($_GET["k_b"]>=1)
	 	$complem.= " and us_id = ".$_GET["k_b"];	
		
	
                if($_SESSION["pv_principal"]!=150){//SI ES EL DUEÑO DEL PROCESO
                    $complem.= " and tp2_id <> 31 ";
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO	
	                elseif($_SESSION["pv_principal"]==150){//SI ES EL DUEÑO DEL PROCESO
                    $complem.= " and tp2_id = 31 ";
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO	
		
		
		 $busca_consolidado = "select count(*), sum(cantidad_proveedores) from v_reporte_deatallado where us_id not in (1, 1741)  $complem ";
			$sql_ex_repor = traer_fila_row(query_db($busca_consolidado));

	  	$busca_campos_proveedores_invitados = "select count(*) from v_urna_reporte_proveedores_invidatos where us_id not in (1, 1741)  $complem  ";
		$sql_ex_proveedores_invitados = traer_fila_row(query_db($busca_campos_proveedores_invitados));

			
		 $busca_consolidado_prove_uni = "select count(distinct pv_id)  from v_urna_reporte_proveedores_invidatos where us_id not in (1, 1741)  $complem ";
			$sql_ex_repor_uni = traer_fila_row(query_db($busca_consolidado_prove_uni));
			
		$busca_consolidado_tecnicas_enviadas = "select count(*)  from v_reportes_ofertas_enviadas where termino = 1 and us_id not in (1, 1741)  $complem ";
			$sql_ex_repor_tecnicas = traer_fila_row(query_db($busca_consolidado_tecnicas_enviadas));
			
		$busca_consolidado_econo_enviadas = "select count(*)  from v_reportes_ofertas_enviadas where termino = 2 and us_id not in (1, 1741)  $complem ";
			$sql_ex_repor_economica = traer_fila_row(query_db($busca_consolidado_econo_enviadas));
			
			
			
		?>

<table width="98%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="titulos_procesos">Consolidado</td>
    <td width="19%"><input name="genera" type="button" class="buscar" id="genera" value="Exportar reporte a excel    " onClick="exporta_reporte()"></td>
  </tr>
  <tr>
    <td width="31%" align="right" class="columna_subtitulo_resultados">Fecha Inicial del reporte:</td>
    <td width="19%"><?=$f_a;?></td>
    <td width="31%" align="right" class="columna_subtitulo_resultados">Fecha Final del reporte:</td>
    <td><?=$f_c;?></td>
  </tr>
  <tr>
    <td align="right" class="columna_subtitulo_resultados">Procesos encontrados:</td>
    <td><?=number_format($sql_ex_repor[0],0);?></td>
    <td align="right" class="columna_subtitulo_resultados">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="columna_subtitulo_resultados">Proveedores invitados sin repetir<br>
    <span class="columna_subtitulo_resultados_economico">Se refiere a contar una sola vez el proveedor</span></td>
    <td><?=number_format($sql_ex_repor_uni[0],0);?></td>
    <td align="right" class="columna_subtitulo_resultados">Proveedores totales invitados:<br>
    <span class="columna_subtitulo_resultados_economico">Se refiere a contar todos los proveedores sin importar que este envitado varias veces</span></td>
    <td><?=number_format($sql_ex_proveedores_invitados[0],0);?>  <a href="javascript:exporta_reporte_pr()"> Exportar reporte aqu&iacute;</a></td>
  </tr>
  <tr>
    <td align="right" class="columna_subtitulo_resultados">Ofertas tecnicas enviadas</td>
    <td><?=number_format($sql_ex_repor_tecnicas[0],0);?></td>
    <td align="right" class="columna_subtitulo_resultados">Ofertas economicas enviadas</td>
    <td><?=number_format($sql_ex_repor_economica[0],0);?></td>
  </tr>
</table>
<br>
<table width="98%" border="0">
  <tr>
    <td width="53%" class="titulos_procesos">Tipo de procesos</td>
    <td width="47%" class="titulos_procesos">Estados del proceso</td>
  </tr>
  <tr>
    <td valign="top">
   <table width="98%" border="0" class="tabla_lista_resultados">
   <?
		$totaliza_tipo=0;
			 $busca_consolidado = "select nombre_tipo_proceso, count(*) from v_reporte_deatallado where us_id not in (1, 1741)  $complem group by nombre_tipo_proceso ";
			$sql_ex_repor = query_db($busca_consolidado);
   			while($lista_proceso = traer_fila_row($sql_ex_repor )){
				$totaliza_tipo=$totaliza_tipo+$lista_proceso[1];
   ?>
      <tr>
        <td width="37%" align="right" class="columna_subtitulo_resultados"><?=$lista_proceso[0];?>:</td>
        <td width="63%"><?=$lista_proceso[1];?></td>
      </tr>
    <? } ?>
      <tr>
        <td width="37%" align="right" class="columna_subtitulo_resultados">TOTAL:</td>
        <td width="63%" class="columna_subtitulo_resultados"><?=$totaliza_tipo;?></td>
      </tr>
    
    </table>
    
    </td>
    <td valign="top"><table width="98%" border="0" class="tabla_lista_resultados">
       <?
			$totaliza_estado=0;
			 $busca_consolidado = "select nombre, count(*) from v_reporte_deatallado where us_id not in (1, 1741) and tp1_id not in(4)  $complem group by nombre ";
			$sql_ex_repor = query_db($busca_consolidado);
   			while($lista_proceso = traer_fila_row($sql_ex_repor )){
				$totaliza_estado=$totaliza_estado+$lista_proceso[1];
   ?>
      <tr>
        <td width="38%" align="right" class="columna_subtitulo_resultados"><?=$lista_proceso[0];?>:</td>
        <td width="63%"><?=$lista_proceso[1];?></td>
      </tr>
    <? } ?>
     	<? /***** PARA BUSCCAR LOS PROCESOS QUE ESTÁN EN ESTADO DE EVALCUÓN TÉCNICA   ********/
			$cuenta_notificado=0;
			$totaliza_urna=0;
			 $busca_consolidado = "select * from pro1_proceso where us_id not in (1, 1741) and tp1_id=4  $complem";
			$sql_ex_repor = query_db($busca_consolidado);
   			while($lista_proceso = traer_fila_row($sql_ex_repor )){
				$totaliza_estado++;
				$cuenta_notificado++;
				$busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $lista_proceso[0] and estado = 1"));
				if($busca_apertura[0]>=1){
					$totaliza_urna++;
				}else{
					$cuenta_notificado++;
				}
   ?>
      
    <? } ?>
     <tr>
        <td width="38%" align="right" class="columna_subtitulo_resultados">Notificado:</td>
        <td width="63%"><?=$cuenta_notificado;?></td>
      </tr>
      <tr>
        <td width="38%" align="right" class="columna_subtitulo_resultados">TOTAL:</td>
        <td width="63%" class="columna_subtitulo_resultados"><?=$totaliza_estado;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="titulos_procesos">Profesional de C&amp;C</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">Ayuda: Presionando sobre el profesional de C&amp;C, mostrara el estado de los procesos del mismo<br>
      <table width="98%" border="0" class="tabla_lista_resultados">
      <?
			$totaliza_profesional=0;
			 $busca_consolidado = "select nombre_administrador, count(*), us_id from v_reporte_deatallado where us_id not in (1, 1741)  $complem group by nombre_administrador, us_id ";
			$sql_ex_repor = query_db($busca_consolidado);
   			while($lista_proceso = traer_fila_row($sql_ex_repor )){
				$totaliza_profesional=$totaliza_profesional+$lista_proceso[1];
   ?>
      <tr>
        <td width="37%" align="right" class="columna_subtitulo_resultados"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/reportes/complemento_1.php?f_a=<?=$f_a;?>&f_c=<?=$f_c;?>&g_b=<?=$g_b;?>&tp3_id_busq=<?=$tp3_id_busq;?>&tp2_id_bus=<?=$tp2_id_bus;?>&k_b=<?=$k_b;?>&id_us_re=<?=$lista_proceso[2];?>','detalle_estados_usuario')"><?=$lista_proceso[0];?>:</a></td>
        <td width="63%"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/reportes/complemento_1.php?f_a=<?=$f_a;?>&f_c=<?=$f_c;?>&g_b=<?=$g_b;?>&tp3_id_busq=<?=$tp3_id_busq;?>&tp2_id_bus=<?=$tp2_id_bus;?>&k_b=<?=$k_b;?>&id_us_re=<?=$lista_proceso[2];?>','detalle_estados_usuario')"><?=$lista_proceso[1];?></a></td>
      </tr>
      <? } ?>
      <tr>
        <td width="37%" align="right" class="columna_subtitulo_resultados">TOTAL:</td>
        <td width="63%" class="columna_subtitulo_resultados"><?=$totaliza_profesional;?></td>
      </tr>
    </table></td>
    <td valign="top" id="detalle_estados_usuario">&nbsp;</td>
  </tr>
</table>

<? } ?>
<p>&nbsp;</p>
</body>
</html>