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
	$us_id_aprobador = 0;
	if($traer_descvuentos[0]>=1){
		$responsable_aprobacion = $responsable_aprobador = $traer_descvuentos[4];
		$us_id_aprobador = $traer_descvuentos[4];
	}elseif($roll==1){
		$responsable_aprobacion = busca_responsable($sql_con[14]);
		$us_id_aprobador = $sql_con[14];
	}elseif($roll==2){
		$responsable_aprobacion = busca_responsable($sql_con[16]);
		$us_id_aprobador = $sql_con[16];
	}elseif($roll==3){
	
		$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr);
	
			$responsable_aprobacion =busca_responsable($id_jefe_area);
			$us_id_aprobador = $id_jefe_area;
	}
	
		return $us_id_aprobador;
	
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
	$id_us_aprueba = $sql_busca_todas_aprobaciones_fila[6];
	$id_us_original = $sql_busca_todas_aprobaciones_fila[7];
	
	} //si hay registros y el apuntador es verdadera
	
	else{
		if($roll_busca==0){
			$busca_responsable_usuario=busca_responsable($usuario_activo);
			$id_us_aprueba = $usuario_activo;
		}else{
			$busca_responsable_usuario=busca_suplente($roll_busca);
			$id_us_aprueba = busca_suplente($roll_busca);
		}
	
	}
	
	return $busca_responsable_usuario."--|--".$fecha_apro."--|--".$comentarios_apro."--|--".$aprobacion."--|--".$id_us_aprueba."--|--".$id_us_original;
	}

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
$busca_datos_tarifa_actual = "select t6_tarifas_lista_id, categoria, grupo, detalle, unidad_medida, moneda, valor, fecha_inicio_vigencia, tipo_creacion_modifica,us_aprobacion_actual,creada_luego_firme, cantidad, us_id, fecha_creacion,consecutivo_tarifa, codigo_proveedor, fecha_fin_vigencia, t6_tarifas_estados_tarifas_id from v_tarifas_lista_estados where t6_tarifas_lista_id = $id_tarifa";

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


$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil, garantia_seguro
 from $co1 where id = ".$sql_con[13];
$sql_con2=traer_fila_row(query_db($busca_contrato));

$id_jefe_area = busca_jefe_area_contrato($id_contrato_arr); 

$permiso_cargar_anexo = 0;
if($sql_con2[9]==$_SESSION["id_us_session"]) $permiso_cargar_anexo = 1;//gerente
elseif($sql_con2[16]==$_SESSION["id_us_session"]) $permiso_cargar_anexo = 1;//profecional
elseif($id_jefe_area==$_SESSION["id_us_session"]) $permiso_cargar_anexo = 1;//profecional
else $permiso_cargar_anexo = 0;
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
          <input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/h_aprobaciones.php?id_contrato=<?=$id_contrato;?>&estado_busca=<?=$_GET["estado_busca"]?>&categoria_existentes=<?=$_GET["categoria_existentes"]?>&grupo_existentes=<?=$_GET["grupo_existentes"]?>&detalle_ta_b=<?=$_GET["detalle_ta_b"]?>&codigo_ta_b=<?=$_GET["codigo_ta_b"]?>&str_consecutivo_bus=<?=$_GET["str_consecutivo_bus"]?>','carga_acciones_permitidas')" />
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

	$busca_todas_aprobaciones = "select t6_tarifas_aprobaciones_id, t6_tarifas_lista_id, nombre, nombre_administrador,fecha_aprobacion,observaciones,us_id, id_us_original from v_tarifas_aprobaciones where t6_tarifas_lista_id = $id_tarifa order by t6_tarifas_aprobaciones_id asc";
	$sql_busca_todas_aprobaciones=query_db($busca_todas_aprobaciones);

			if($sql_tarifa_actual[16] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$sql_tarifa_actual[16];		
	
	
	  $siguinete=0;
	  
	  ?>
      <br />
<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="titulos_secciones">Datos de la tarifa actualizada, por el proveedor</td>
        </tr>
        <tr>
          <td align="right"><strong>
          <?=TITULO_CONSECUTIVO;?>
          :</strong></td>
          <td><?=$sql_tarifa_actual[14];?></td>
  </tr>
        <tr>
          <td width="21%" align="right"><strong>
          <?=TITULO_2;?>
          :</strong></td>
          <td width="79%"><?=$sql_tarifa_actual[1];?></td>
        </tr>
        <tr>
          <td align="right"><strong>
          <?=TITULO_3;?>
          :</strong></td>
          <td><?=$sql_tarifa_actual[2];?></td>
        </tr>
        <tr>
          <td align="right"><strong>
          <?=TITULO_4;?>
          :</strong></td>
          <td><?=$sql_tarifa_actual[4];?></td>
        </tr>
        <tr>
          <td align="right"><strong>
          <?=TITULO_5;?>
          :</strong></td>
          <td><?=$sql_tarifa_actual[15];?></td>
        </tr>        
        <tr>
          <td><div align="right"><strong>
          <?=TITULO_6;?>
          :</strong></div></td>
          <td><?=$sql_tarifa_actual[3];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>
          <?=TITULO_7;?>
          :</strong></div></td>
          <td><?=$sql_tarifa_actual[5];?> </td>
        </tr>
        <tr>
          <td><div align="right"><strong>
          <?=TITULO_8;?>
          :</strong></div></td>
          <td><?=decimales_estandar($sql_tarifa_actual[6],2);?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>
          <?=TITULO_9;?>
          :</strong></div></td>
          <td><?=$sql_tarifa_actual[7];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>
            <?=TITULO_18;?>
          :</strong></div></td>
          <td><?=$fecha_fin_vi;?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Aplica descuentos :</strong></div></td>
          <td><?=$aplica_descuento_creacion;?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Observaciones de la creaci&oacute;n :</strong></div></td>
          <td><?=$busca_soporte_creacion[2];?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Documento anexo :</strong></div></td>
          <td><?=$descraga_documento;?></td>
        </tr>
        <tr>
          <td><div align="right"><strong>Tipo de contrato :</strong></div></td>
          <td><?=$tipo_contrato;?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
          <?
		  	if($permiso_cargar_anexo==1){//puede cargar anexos
			?>
          <table width="80%" border="0">
            <tr>
              <td width="38%" align="right" class="columna_subtitulo_resultados"><strong>Cargar nuevo anexo:</strong> <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR, hasta 5MG</span></td>
              <td width="34%"><input type="file" name="nuevo_anexo_apro" id="nuevo_anexo_apro" /></td>
              <td width="28%"><input name="nue_anexo" type="button" class="boton_grabar" id="nue_anexo" value="Crear nuevo anexo" onclick="crear_nuevo_anexo_tarifas()" /></td>
            </tr>
          </table>
          <? } //puede cargar anexos ?>
            <br />
            
               <?
		  	if($_SESSION["tipo_usuario"]!=2){//puede cargar anexos
			?>
            <table width="80%" border="0" class="tabla_lista_resultados">
            <tr>
              <td colspan="4" align="center" class="columna_titulo_resultados"><strong>Documentos cargados en las aprobaciones / rechazos</strong></td>
            </tr>
            <tr class="columna_subtitulo_resultados">
              <td align="center"><strong>Usuario</strong></td>
              <td align="center"><strong>Fecha</strong></td>
              <td align="center"><strong>Anexo</strong></td>
              <td align="center"><strong>Descargar</strong></td>
            </tr>
            <?
				$busca_anexos_apr = "select t6_tarifas_aprobaciones_anexos_id, nombre_administrador, fecha_cargue, nombre_archivo from v_tarifas_anexos_aprobaciones where t6_tarifas_aprobaciones_id = $id_contrato_arr and t6_tarifas_lista_id = $id_tarifa order by fecha_cargue";
				$sql_ex_anexos = query_db($busca_anexos_apr);
				while($lis_anexo = traer_fila_row($sql_ex_anexos)){
				$descraga_documento_apro="";
					 $descraga_documento_apro = "<a href='javascript:void(0)' onclick='javascript:window.parent.location.href=\"../aplicaciones/tarifas/descarga_anexo_aprobaciones.php?id_documen=".$lis_anexo[0]."&n2=$lis_anexo[3]\"'>Descargar</a>";

			?>
            
            <tr>
              <td><?=$lis_anexo[1];?></td>
              <td><?=$lis_anexo[2];?></td>
              <td><?=$lis_anexo[3];?></td>
              <td><?=$descraga_documento_apro;?></td>
            </tr>
            <?
				}
				
			}//si no es proveedor
			?>
            
          </table></td>
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
			
			$es_reemplazo="";
				 if(($resultado_apro[4] != "" and $resultado_apro[5] != "") and ($resultado_apro[4] != $resultado_apro[5])){ 
			   $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$resultado_apro[5],'nombre_administrador','us_id')."</strong>";}
			
			?>
            
            <tr>
              <td><div align="right"><strong>Solicita creaci&oacute;n:</strong></div></td>
              <td class="filas_resultados"><? if(is_numeric($resultado_apro[0])) {   echo ver_si_tiene_reemplazo($resultado_apro[0]);  }else{  echo $resultado_apro[0].$es_reemplazo; }?></td>
              <td class="filas_resultados"><?=$resultado_apro[1];?></td>
              <td class="filas_resultados"><?=$resultado_apro[3];?></td>
              <td class="filas_resultados"><?=$resultado_apro[2];?></td>
            </tr>
            <? } ?> 
            
            <?
				$resultado_apro =	explode("--|--",busca_aprobadores( (0 + $siguinete),1,0 ));
				$es_reemplazo="";
				 if(($resultado_apro[4] != "" and $resultado_apro[5] != "") and ($resultado_apro[4] != $resultado_apro[5])){ 
			   $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$resultado_apro[5],'nombre_administrador','us_id')."</strong>";}
			?>           
            <tr>
              <td><div align="right"><strong>Gerente de contrato:</strong></div></td>
              <td class="filas_resultados"><? if(is_numeric($resultado_apro[0]) ) {  if($sql_tarifa_actual[17] !=4) echo ver_si_tiene_reemplazo($resultado_apro[0]);  }else{  echo $resultado_apro[0].$es_reemplazo; }?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[1];?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[3];?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[2];?></td>
            </tr>
     <?
				$resultado_apro =	explode("--|--",busca_aprobadores( (1 + $siguinete),2,0 ));
				$es_reemplazo="";
				 if(($resultado_apro[4] != "" and $resultado_apro[5] != "") and ($resultado_apro[4] != $resultado_apro[5])){ 
			   $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$resultado_apro[5],'nombre_administrador','us_id')."</strong>";}
			?>             
            <tr>
              <td><div align="right"><strong>Profesional de C&C :</strong></div></td>
              <td><? if(is_numeric($resultado_apro[0])) {  if($sql_tarifa_actual[17] !=4) echo ver_si_tiene_reemplazo($resultado_apro[0]);  }else{  echo $resultado_apro[0].$es_reemplazo; }?></td>
              <td><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[1];?></td>
              <td><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[3];?></td>
              <td><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[2];?></td>
            </tr>
<?
				$resultado_apro =	explode("--|--",busca_aprobadores( (2 + $siguinete),3,0 ));
				$es_reemplazo="";
				 if(($resultado_apro[4] != "" and $resultado_apro[5] != "") and ($resultado_apro[4] != $resultado_apro[5])){ 
			   $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$resultado_apro[5],'nombre_administrador','us_id')."</strong>";}
			?>                
            <tr>
              <td><div align="right"><strong>Jefe de area:</strong></div></td>
              <td class="filas_resultados"><? if(is_numeric($resultado_apro[0])) { if($sql_tarifa_actual[17] !=4)  echo ver_si_tiene_reemplazo($resultado_apro[0]);  }else{  echo $resultado_apro[0].$es_reemplazo; }?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[1];?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[3];?></td>
              <td class="filas_resultados"><? if($resultado_apro[1] == "Pendiente" and $sql_tarifa_actual[17] !=3) echo ""; else echo $resultado_apro[2];?></td>
            </tr>
            
            <?
			}//no es contractual
			?>
          </table></td>
        </tr>
      </table>
      
<input type="hidden" name="id_tarifa" value="<?=$id_tarifa;?>" />
<input type="hidden" name="ruta_apro" value="<?=$ruta_apro;?>" />

</body>
</html>
