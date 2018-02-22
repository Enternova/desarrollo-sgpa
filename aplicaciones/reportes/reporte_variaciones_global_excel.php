<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte de Variacion de Tarifas Global.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
include("../../librerias/lib/@session.php"); 

	$filtro_aplica_reporte = "";	
    $titulo_filtro_muestra =  "";
	$titulo_nombre_grafica = "";



$explode_tp_rafica = explode("---",$_GET["tp_grafica"] );

//echo "Tipo: ".$explode_tp_rafica[0]."<br />Grafica: ".$explode_tp_rafica[1]."<br /> Columna/Categoria: ".$explode_tp_rafica[2]."<br />Columna ID: ".$explode_tp_rafica[3]."<br /><br /><br />	";

if($explode_tp_rafica[0]==1){//grafica por area
	/* Titulo General*/
	$filtro_aplica_reporte = $_SESSION["comple_filtro"];	
    $titulo_filtro_muestra =  $_SESSION["titulo_filtro1"];
	$titulo_nombre_grafica = "N&uacute;mero de Contratos por &Aacute;rea Usuaria";
	/* Titulo General*/
	
	
	if($explode_tp_rafica[1]=="TOTALCONTRATOS"){//Pie total contratos
		$titulo_nombre_grafica = "Total de Contratos";
		$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Contratos Con Excepci&oacute;n</span>";
		$filtro_aplica_reporte =$_SESSION["comple_filtro_exepcion"]." and t6_tarifas_estados_contratos_id = 6 ";
	}
	if($explode_tp_rafica[1]=="CONTRATOSPORAREA"){//BARRAS CONTRATOS POR AREAS
		$titulo_nombre_grafica = "N&uacute;mero de Contratos por &Aacute;rea Usuaria";
		$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Contratos Con Excepci&oacute;n</span>";
		$sel_area = traer_fila_row(query_db("select t1_area_id from t1_area where replace(nombre, ' ', '')  like '%".trim(utf8_decode($explode_tp_rafica[2]))."%' and estado=1"));
		$filtro_aplica_reporte =$_SESSION["comple_filtro_exepcion"]." and t6_tarifas_estados_contratos_id = 6 and t1_area_id= ".$sel_area[0];
	}
	
	if($explode_tp_rafica[1]=="ESTADISTICADETARIFAS"){
		
		$filtro_aplica_reporte =$_SESSION["comple_filtro_exepcion"]."";
		
		if($explode_tp_rafica[2]=="TarifasContractuales"){
			$filtro_aplica_reporte.=" and tipo_tarifa_original = 1 ";
				if($explode_tp_rafica[3]=="1"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Total de Tarifas Contractuales</span>";
					$filtro_aplica_reporte.="  and tipo_creacion_modifica =1";
				}
				if($explode_tp_rafica[3]=="2"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Contractuales Usadas</span>";
					$filtro_aplica_reporte.=" and tarifa_usada > 0";
				}		
				if($explode_tp_rafica[3]=="3"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Contractuales Modificadas por IPC</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =4";
				}
				if($explode_tp_rafica[3]=="4"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Contractuales Modificadas por IPC Usadas</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =4 and tarifa_usada > 0";
				}
				if($explode_tp_rafica[3]=="5"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Contractuales Modificadas Otros</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =2";
				}
				if($explode_tp_rafica[3]=="6"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Contractuales Modificadas Otros Usadas</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =2 and tarifa_usada > 0";
				}
		}
		
		if($explode_tp_rafica[2]=="TarifasNuevas"){
				$filtro_aplica_reporte.=" and tipo_tarifa_original = 3";
				if($explode_tp_rafica[3]=="1"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Total de Tarifas Nuevas</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =3 ";
				}
				if($explode_tp_rafica[3]=="2"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Nuevas Usadas</span>";
					$filtro_aplica_reporte.=" and tarifa_usada > 0";
				}
				if($explode_tp_rafica[3]=="3"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Nuevas Modificadas por IPC</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =4";
				}
				if($explode_tp_rafica[3]=="4"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Nuevas Modificadas por IPC Usadas</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =4 and tarifa_usada > 0";
				}
				if($explode_tp_rafica[3]=="5"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Nuevas Modificadas Otros</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =2";
				}
				if($explode_tp_rafica[3]=="6"){
					$titulo_filtro_muestra.="<br /><span style='font-size:14pt'>&nbsp;&#9679;Tarifas Nuevas Modificadas Otros Usadas</span>";
					$filtro_aplica_reporte.=" and tipo_creacion_modifica =2 and tarifa_usada > 0";
				}
		
		}
		
		$titulo_nombre_grafica = "Estad&iacute;stica de Tarifas";
		
		$sel_area = traer_fila_row(query_db("select t1_area_id from t1_area where replace(nombre, ' ', '')  like '%".trim(utf8_decode($explode_tp_rafica[2]))."%' and estado=1"));
		
	}
	
	
	
}
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<style>
@charset "utf-8";
body {
	
	font-weight: 900;
	font-size:12px;
	margin-top: 2px;
	background:#F2F2F2;
}
.tabla_lista_resultados{  
	margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; 
  BORDER-RIGHT: #cccccc 3px  double; 
  BORDER-TOP: #cccccc 1px solid;  	
  BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  
 }
 
 .estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}

.fondo_1{ font-size:37px; color: #7A7A7A}
.fondo_2{ font-size:18px; color: #7A7A7A}
.fondo_2_1{ font-size:14px; color: #229BFF}
	
	
	
.fondo_3{ background:#229BFF; color:#FFFFFF; font-size:18px;}


.tabla_paginador{ font-size:14px; color:#666666} 

.filas_resultados_reporte_saldos1{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
.filas_resultados_reporte_saldos2{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 0px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
	

.filas_resultados_blanco{ background:#FFFFFF} 
.filas_resultados{ background:#DBFBDC} 

</style>
</head>
<body>
<table width="2000" border="0" cellpadding="3" cellspacing="3">
  <? $ancho_columnas = (2000/25)."px"; ?>
  <tr>
    <td width="95" align="center">&nbsp;</td>
    <td width="108" align="center">&nbsp;</td>
    <td width="95" align="center">&nbsp;</td>
    <td width="128" align="center">&nbsp;</td>
    <td width="62" align="center">&nbsp;</td>
    <td width="79" align="center">&nbsp;</td>
    <td width="152" align="center">&nbsp;</td>
    <td width="112" align="center">&nbsp;</td>
    <td width="95" align="center">&nbsp;</td>
    <td width="142" align="center">&nbsp;</td>
    <td width="55" align="center">&nbsp;</td>
    <td width="42" align="center">&nbsp;</td>
    <td width="43" align="center">&nbsp;</td>
    <td width="101" align="center">&nbsp;</td>
    <td width="78" align="center">&nbsp;</td>
    <td width="51" align="center">&nbsp;</td>
    <td width="54" align="center">&nbsp;</td>
    <td width="74" align="center">&nbsp;</td>
    <td width="57" align="center">&nbsp;</td>
    <td width="90" align="center">&nbsp;</td>
    <td width="100" align="center">&nbsp;</td>
    <td width="84" align="center">&nbsp;</td>
    <td width="55" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="center" bgcolor="#FFFFFF" class="fondo_1"><strong>Reporte de Variaci&oacute;n de Tarifas Global</strong><br /></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="left" bgcolor="#FFFFFF" class="fondo_2"><strong>Soporte de la Gr&aacute;fica:</strong> <?=$titulo_nombre_grafica?> </td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="left" bgcolor="#FFFFFF" class="fondo_2"><strong>Filtros Aplicados para Generar este Reporte:</strong></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="left" bgcolor="#FFFFFF" class="fondo_2"><?=$titulo_filtro_muestra?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="left" bgcolor="#FFFFFF" class="fondo_2_1"><strong>Nota Importante: </strong>Este es el listado de todas las tarifas seg&uacute;n el filtro efectuado, debe tener en cuenta que a diferencia de la gr&aacute;fica, en este reporte se muestran todas las modificaciones que sufri&oacute; una tarifa.</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  
</table>
<? 		
  
  if($filtro_aplica_reporte != ""){
	
		
	?>
<table width="2000" cellpadding="0" cellspacing="0" border="1">
  
  <? $ancho_columnas = (2000/25)."px"; ?>
  <tr>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Numero de Contrato</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Contrato con Excepci&oacute;n</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Gerente de Contrato</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">&Aacute;rea del Gerente de Contrato</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Proveedor</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Origen de la Tarifa </td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Consecutivo de la Tarifa de Origen</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Consecutivo de Tarifa</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Tipo de Modificaci&oacute;n</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">N&uacute;mero de Veces que se ha Usado</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Categor&iacute;a</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Grupo</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Unidad</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">&Iacute;tem Oferta    Proveedor</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Nombre gen&eacute;rico</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Moneda</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Valor tarifa</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Inicio vigencia</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Fin vigencia</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Fecha de    Creaci&oacute;n</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Fecha de Aprobaci&oacute;n</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Usuario de    Creaci&oacute;n</td>
    <td width="<?=$ancho_columnas?>" align="center" class="fondo_3">Estado</td>
  </tr>
  
  <? 		
  
  
	
	$sql_excel = "select contrato, razon_social, consecutivo_tarifa, categoria, grupo, unidad_medida, codigo_proveedor, detalle, t1_moneda_id, valor, fecha_inicio_vigencia, fecha_fin_vigencia, fecha_creacion, fecha_aprobacion, usuario_creacion, estado_tarifas, tipo_creacion_modifica, tarifa_usada, area, gerente,tipo_tarifa_original, consecutivo_original, t6_tarifas_estados_contratos_id from v_reporte_general_variacion_tarifas ".$filtro_aplica_reporte;
  
	
	
	$sql_excel_sql = query_db($sql_excel);
	while($sel_filas = traer_fila_db($sql_excel_sql)){
		
		
		$valor_unido=0;
		$valor_arr = explode(".",$sel_filas[9]);
		$unidades =$valor_arr[0];
		$decimales =  $valor_arr[1];
		$valor_unido = $unidades.$formato_numeros_miles.$decimales;
	
	?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[0];?></td>
    <td align="center" bgcolor="#FFFFFF"><? if($sel_filas[22]==6) echo "SI";?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[19];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[18];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[1];?></td>
    <td align="center" bgcolor="#FFFFFF"><? if($sel_filas[20]==1) echo "Contractual"; if($sel_filas[20]==3) echo "Nueva"; ?></td>
    <td align="center" bgcolor="#FFFFFF"><? echo $sel_filas[21]; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[2];?></td>
    <td align="center" bgcolor="#FFFFFF"><? if($sel_filas[16]==1) echo ""; if($sel_filas[16]==2) echo "Modificada"; if($sel_filas[16]==3) echo ""; if($sel_filas[16]==4) echo "IPC";?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[17];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[3];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[4];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[5];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[6];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[7];?></td>
    <td align="center" bgcolor="#FFFFFF"><? if($sel_filas[8]==1) echo "COP"; else echo "USD";?></td>
    <td align="center" style="<?=$stilo_excel;?>" bgcolor="#FFFFFF"><?=$valor_unido;?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[10];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[11];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[12];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[13];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[14];?></td>
    <td align="center" bgcolor="#FFFFFF"><?=$sel_filas[15];?></td>
  </tr>
  <? 		
	}
	
	?>
</table>

<?
	
  }else{
	  
	  echo "ERROR NO SE EJECUTO NINGUN FILTRO";
  }?>

</body>
</html>
