<? include("../../librerias/lib/@session.php"); 
//	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


function busca_responsable($id_responsable)
	{
		$busca_usuario = "select nombre_administrador from t1_us_usuarios where us_id = $id_responsable";
		$sql_usuario=traer_fila_row(query_db($busca_usuario));
		
		return $sql_usuario[0];
	
	
	}

function busca_suplente($roll)
	{
	global $fecha,$sql_con,$v_seg1,$id_contrato_arr;
	$busca_descuneto = "select * from v_tarifas_suplentes where tarifas_contrato_id = $id_contrato_arr  and fecha_suplencia >= '$fecha' and estado = 1 and  t6_tarifas_tipo_suplentes_id = $roll ";
	$traer_descvuentos = traer_fila_row(query_db($busca_descuneto));
	
	if($traer_descvuentos[0]>=1)
		$responsable_aprobacion = $responsable_aprobador = $traer_descvuentos[4];
	elseif($roll==1)
		$responsable_aprobacion = busca_responsable($sql_con[14]);
	elseif($roll==2)
		$responsable_aprobacion = busca_responsable($sql_con[16]);
	elseif($roll==3){
	
		$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr);
	
			$responsable_aprobacion =busca_responsable($id_jefe_area);
	}
	
		return $responsable_aprobacion;
	
	}

function busca_aprobadores($apuntador,$roll_busca,$usuario_activo){
	global $sql_busca_todas_aprobaciones,$sql_con;
	$nuemro_aprobacion = mssql_num_rows($sql_busca_todas_aprobaciones);	
	$valida_resgitro = ($nuemro_aprobacion-1);
	$fecha_apro ="Pendiente";
	$comentarios_apro="Pendiente";
	$aprobacion ="Pendiente";

	
	if( ($nuemro_aprobacion>=1) &&  ($apuntador<=$valida_resgitro)  ){//si hay registros y el apuntador es verdadera
	
	$mueve_apuntador = mssql_data_seek($sql_busca_todas_aprobaciones, $apuntador);
	$sql_busca_todas_aprobaciones_fila=traer_fila_row($sql_busca_todas_aprobaciones);
	
	$busca_responsable_usuario = $sql_busca_todas_aprobaciones_fila[3];	
	$fecha_apro =$sql_busca_todas_aprobaciones_fila[4];
	$comentarios_apro=$sql_busca_todas_aprobaciones_fila[5];
	$aprobacion = $sql_busca_todas_aprobaciones_fila[2];
	
	
	} //si hay registros y el apuntador es verdadera
	
	else{
		if($roll_busca==0)
			$busca_responsable_usuario=busca_responsable($usuario_activo);
		else
			$busca_responsable_usuario=busca_suplente($roll_busca);
	
	
	}
	
	return $busca_responsable_usuario."--|--".$fecha_apro."--|--".$comentarios_apro."--|--".$aprobacion."--|--";
	}

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
$busca_datos_tarifa_actual = "select t6_tarifas_lista_id, categoria, grupo, detalle, unidad_medida, moneda, valor, fecha_inicio_vigencia, tipo_creacion_modifica,us_aprobacion_actual,creada_luego_firme, cantidad, us_id, fecha_creacion from v_tarifas_lista_estados where t6_tarifas_lista_id = $id_tarifa";
$sql_tarifa_actual = traer_fila_row(query_db($busca_datos_tarifa_actual));

$busca_soporte_creacion = traer_fila_row(query_db("select * from t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $sql_tarifa_actual[0]"));


$aplica_descuento_creacion = "No";
$descraga_documento = "No";
$tipo_contrato = "Normal";
if($busca_soporte_creacion[4]==1) $aplica_descuento_creacion = "Si";
if(trim($busca_soporte_creacion[3])!=""){
	
	//echo "select * from t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $sql_tarifa_actual[0]"." - ".$id_tarifa;

$nombre_fichero = SUE_PATH_ARCHIVOS.'tarifas_ane_modifica/'.$busca_soporte_creacion[0].'.txt';
$nombre_fichero2 = SUE_PATH_ARCHIVOS.'tarifas_ane_modifica/'.$id_tarifa.'.txt';
if (file_exists($nombre_fichero)) {
    $id_documento_descarga = $busca_soporte_creacion[0];
	//echo "aca 1";
}
if (file_exists($nombre_fichero2)) {
    $id_documento_descarga = $id_tarifa;
	//echo "aca 2";
}


	 $descraga_documento = "<a href='javascript:void(0)' onclick='javascript:window.parent.location.href=\"../aplicaciones/tarifas/proveedor/descarga_anexo_m.php?id_documen=".$id_documento_descarga."&n2=$busca_soporte_creacion[3]\"'>".$busca_soporte_creacion[3]."</a>";
	 }

if($sql_con[19]==2)	 $tipo_contrato = "Contrato Marco";



			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> DETALLE DE APROBACIONES DE TARIFAS &gt;&gt; CONTRATO:<?=$sql_con[7];?></span></td>
          <td width="8%" >
          <? if($ruta_apro==1){ ?>
          <input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/h_aprobaciones.php?id_contrato=<?=$id_contrato;?>&estado_busca=<?=$_GET["estado_busca"]?>&categoria_existentes=<?=$_GET["categoria_existentes"]?>&grupo_existentes=<?=$_GET["grupo_existentes"]?>&detalle_ta_b=<?=$_GET["detalle_ta_b"]?>&codigo_ta_b=<?=$_GET["codigo_ta_b"]?>','carga_acciones_permitidas')" />
		<? } elseif($ruta_apro==2){ ?>
          <input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/c_aprobaciones.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')" />        
<? } ?>
          </td>
        </tr>
        <tr>
          <td colspan="3" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
        </tr>
      </table>
      <br />
<?

	$busca_todas_aprobaciones = "select t6_tarifas_aprobaciones_id, t6_tarifas_lista_id, nombre, nombre_administrador,fecha_aprobacion,observaciones from v_tarifas_aprobaciones where t6_tarifas_lista_id = $id_tarifa order by t6_tarifas_aprobaciones_id asc";
	$sql_busca_todas_aprobaciones=query_db($busca_todas_aprobaciones);


	
	
	  $siguinete=0;
	  
	  ?>
      <br />
<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="titulos_secciones">Datos de la tarifa actualizada, por el proveedor</td>
        </tr>
        <tr>
          <td width="21%"><div align="right"><strong>Detalle:</strong></div></td>
          <td width="79%"><?=$sql_tarifa_actual[3];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Valor:</strong></div></td>
          <td><?=$sql_tarifa_actual[5];?> <?=$sql_tarifa_actual[6];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Fecha de inicio de vigencia:</strong></div></td>
          <td><?=$sql_tarifa_actual[7];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Aplica descuentos:</strong></div></td>
          <td><?=$aplica_descuento_creacion;?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Observaciones de la creaci&oacute;n</strong></div></td>
          <td><?=$busca_soporte_creacion[2];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Documento anexo:</strong></div></td>
          <td><?=$descraga_documento;?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Tipo de contrato:</strong></div></td>
          <td><?=$tipo_contrato;?></td>
        </tr>
        <tr>
          <td colspan="2" class="titulos_secciones">Aprobaciones</td>
        </tr>
        <tr>
          <td colspan="2"><table width="99%" border="0" cellspacing="3" cellpadding="3">
          
            <tr>
              <td width="13%">&nbsp;</td>
              <td width="32%" align="center" class="columna_titulo_resultados">Usuario responsable</td>
              <td width="10%" align="center" class="columna_titulo_resultados">Fecha</td>
              <td width="9%" align="center" class="columna_titulo_resultados">Aprobaci&oacute;n</td>
              <td width="36%" align="center" class="columna_titulo_resultados">Comentarios</td>
            </tr>
<tr>
              <td align="right"><strong>Creaci&oacute;n de la Tarifa:</strong></td>
              <td><? $sel_usuario = traer_fila_row(query_db("select nombre_administrador, tipo_usuario from ".$g1." where us_id = ".$sql_tarifa_actual[12]));
			  if($sel_usuario[1] == 2) echo "USUARIO, CONTRATISTA: ";
			  echo $sel_usuario[0];
			  ?></td>
              <td><?=$sql_tarifa_actual[13]?></td>
              <td>Creaci&oacute;n</td>
              <td>&nbsp;</td>
            </tr>
            <?
            
			$no_es_contractual = "NO";
			
			if($sql_tarifa_actual[10] == 1){
				$no_es_contractual = "SI";
				}
			
			if($no_es_contractual == "NO"){
			
		  	if($sql_con[19]==2)	{ 
			$resultado_apro =	explode("--|--",busca_aprobadores(0,0,$sql_tarifa_actual[9]));
			$siguinete = 1;
			
			
			?>
            
            <tr>
              <td><div align="right"><strong>Solicita creaci&oacute;n:</strong></div></td>
              <td><?=$resultado_apro[0];?></td>
              <td><?=$resultado_apro[1];?></td>
              <td><?=$resultado_apro[3];?></td>
              <td><?=$resultado_apro[2];?></td>
            </tr>
            <? } ?> 
            
            <?
				$resultado_apro =	explode("--|--",busca_aprobadores( (0 + $siguinete),1,0 ));
			?>           
            <tr>
              <td><div align="right"><strong>Gerente de contrato:</strong></div></td>
              <td class="filas_resultados"><?=$resultado_apro[0];?></td>
              <td class="filas_resultados"><?=$resultado_apro[1];?></td>
              <td class="filas_resultados"><?=$resultado_apro[3];?></td>
              <td class="filas_resultados"><?=$resultado_apro[2];?></td>
            </tr>
     <?
				$resultado_apro =	explode("--|--",busca_aprobadores( (1 + $siguinete),2,0 ));
			?>             
            <tr>
              <td><div align="right"><strong>Profesional de C&C :</strong></div></td>
              <td><?=$resultado_apro[0];?></td>
              <td><?=$resultado_apro[1];?></td>
              <td><?=$resultado_apro[3];?></td>
              <td><?=$resultado_apro[2];?></td>
            </tr>
<?
				$resultado_apro =	explode("--|--",busca_aprobadores( (2 + $siguinete),3,0 ));
			?>                
            <tr>
              <td><div align="right"><strong>Jefe de area:</strong></div></td>
              <td class="filas_resultados"><?=$resultado_apro[0];?></td>
              <td class="filas_resultados"><?=$resultado_apro[1];?></td>
              <td class="filas_resultados"><?=$resultado_apro[3];?></td>
              <td class="filas_resultados"><?=$resultado_apro[2];?></td>
            </tr>
            
            <?
			}//no es contractual
			?>
          </table></td>
        </tr>
      </table>
      
     

</body>
</html>
