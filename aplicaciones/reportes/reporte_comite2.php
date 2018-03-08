<? header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Consolidado de Comite.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");








	$muestra_consolidado = "NO";
if($_GET["comite_numero"] <> 0){
	$muestra_consolidado = "SI";
	$comple_sql = " and id_comite = ".$_GET["comite_numero"];
	}
	$mes="";
if($_GET["comite_mes"] <> 0){
		$mes = $_GET["comite_mes"];
		if($mes<10){
			$mes = "0".$mes;
			}	
			
			$mes = "-".$mes."-";
			
		if($_GET["comite_ano"] <> 0){
			$mes = $_GET["comite_ano"].$mes;
			}	
			
		$comple_sql = " and fecha like '%".$mes."%' ";
	}
	
if($_GET["comite_ano"] <> 0 and $mes==""){

			$comple_sql = " and fecha like '%".$_GET["comite_ano"]."%' ";
			}	
	

	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td colspan="2" rowspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="21" align="left" class="titulo1"><strong>CONSOLIDADO ACTAS DE COMITÉ</strong></td>
  </tr>
  <tr class="titulo2">
    <td align="right">&nbsp;</td>
    <td align="right">Año del Comit&eacute;:</td>
    <td colspan="19" align="left">
	<?
    if($_GET["comite_ano"] <> 0){
		echo $_GET["comite_ano"];
		}else{
			echo "Todos";
			}
	?>
    </td>
  </tr>
  <tr class="titulo2">
    <td align="right">&nbsp;</td>
    <td align="right">Mes del Comit&eacute;:</td>
    <td colspan="19" align="left"><?
    if($_GET["comite_mes"] <> 0){
		if($_GET["comite_mes"] == 1){
			$mes_muestra = "Enero";
			}
		if($_GET["comite_mes"] == 2){
			$mes_muestra = "Febrero";
			}
		if($_GET["comite_mes"] == 3){
			$mes_muestra = "Marzo";
			}
		if($_GET["comite_mes"] == 4){
			$mes_muestra = "Abril";
			}
		if($_GET["comite_mes"] == 5){
			$mes_muestra = "Mayo";
			}
		if($_GET["comite_mes"] == 6){
			$mes_muestra = "Junio";
			}
		if($_GET["comite_mes"] == 7){
			$mes_muestra = "Julio";
			}
		if($_GET["comite_mes"] == 8){
			$mes_muestra = "Agosto";
			}
		if($_GET["comite_mes"] == 9){
			$mes_muestra = "Septiembre";
			}
		if($_GET["comite_mes"] == 10){
			$mes_muestra = "Actubre";
			}
		if($_GET["comite_mes"] == 11){
			$mes_muestra = "Noviembre";
			}
		if($_GET["comite_mes"] == 12){
			$mes_muestra = "Diciembre";
			}
		echo $mes_muestra;
		
		
		}else{
			echo "Todos";
			}
	?></td>
  </tr>
  <?
  if(	$muestra_consolidado == "SI"){
		
		$sele_comite_uno = traer_fila_row(query_db("select * from $c1 where id_comite = ".$_GET["comite_numero"]));
		
  ?>
  <tr class="titulo2">
    <td colspan="4" align="right">Comit&eacute; N&uacute;mero:</td>
    <td colspan="19" align="left"><?=numero_item_pecc($sele_comite_uno[6],$sele_comite_uno[7],$sele_comite_uno[8])?></td>
  </tr>
  <tr class="titulo2">
    <td colspan="4" align="right" style="vertical-align:middle">Asistentes que Aprobar&oacute;n:</td>
    <td colspan="19" align="left"><?
    $sel_asistentes = query_db("select t1.rol_aprobacion, t2.nombre_administrador  from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_comite = ".$_GET["comite_numero"]." and t1.requiere_aprobacion = 1 and t1.id_us = t2.us_id order by t1.orden");
	while($sel_asis = traer_fila_db($sel_asistentes)){
		
		echo $sel_asis[0]." - ".$sel_asis[1]."<br />";
		}
	?></td>
  </tr>
  <tr class="titulo2">
    <td colspan="4" align="right"  style="vertical-align:middle">Otros Asistentes:</td>
    <td colspan="19" align="left"><?
    $sel_asistentes = query_db("select t1.rol_aprobacion, t2.nombre_administrador  from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_comite = ".$_GET["comite_numero"]." and t1.requiere_aprobacion <> 1 and t1.id_us = t2.us_id order by t1.orden");
	while($sel_asis = traer_fila_db($sel_asistentes)){
		
		echo $sel_asis[0]." - ".$sel_asis[1]."<br />";
		}
	?></td>
  </tr>
  <?
  
  }
  ?>
  <tr>
    <td align="center" class="titulo3" >Numero del Comité</td>
    <td align="center" class="titulo3">Fecha del Comité</td>
    <td align="center" class="titulo3">Tipo de Comit&eacute;</td>
    <td align="center" class="titulo3">Tipo de Permiso</td>
    <td align="center" class="titulo3">Tipo de Proceso </td>
    <td align="center" class="titulo3">Tipo de la Solicitud</td>
    <td align="center" class="titulo3">Numero de la Solicitud</td>
    <td align="center" class="titulo3">Resultado del Comité</td>
    <td align="center" class="titulo3">Verificacion del Presidente</td>
    <td align="center" class="titulo3">&Aacute;rea Responsable</td>
    <td align="center" class="titulo3">Gerente Solicitud</td>
    <td align="center" class="titulo3">Profesional Encargado</td>
    <td align="center" class="titulo3">Objeto de la Solicitud</td>
    <td align="center" class="titulo3">Recomendaci&oacute;n</td>
    <td align="center" class="titulo3">Aplica Socios</td>
    <td align="center" class="titulo3">Fecha de la Respuesta de los Socios</td>
    <td align="center" class="titulo3">Respuesta de los Socios</td>
    <td align="center" class="titulo3">Número de Contrato</td>
    <td align="center" class="titulo3">Contratista</td>
    <td align="center" class="titulo3">Valor USD</td>
    <td align="center" class="titulo3">Valor COP</td>
    <td align="center" class="titulo3">Equivalente USD</td>

    <td align="center" class="titulo3">Comentario del Comité</td>
    
  </tr>
  <?

  $sel_repor = query_db("select * from vista_reporte_comite where Expr4 <> 33 $comple_sql order by num3 asc, valor_solicitud_comite desc");
  while($sel_r = traer_fila_db($sel_repor)){
	  $comple_texto_tp_proceso="";
	$res_comi="";
	  $rechazado="";
		$desierto="";
		if($sel_r[30]==1){
			$rechazado="SI";
			}
		if($sel_r[31]==1){
			$desierto="SI";
			}
	  
	  $numero_comite = numero_item_pecc($sel_r[0],$sel_r[1],$sel_r[2]);
	  $numero_consecut = numero_item_pecc($sel_r[6],$sel_r[7],$sel_r[8]);
	  
	  	
		if($sel_r[4] ==1){
			$nombre_tp = "PERMISO";
			
			$valor_usd=$sel_r[16];
			$valor_cop=$sel_r[17];
			
			$fecha_aprueba_ad = "";
			$ob = $sel_r[12];
			$reco = $sel_r[15];	
			
					
		if($ob == ""){
			$ob = $sel_r[13];
			}
		if($reco == ""){
			$reco = $sel_r[14];
			}
				
				$sel_si_socios = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_rol = 11 and tipo_adj_permiso = 1 and estado = 1 and id_item_pecc = ".$sel_r[25]));
			}else{
				$nombre_tp = "ADJUDICACION";
				
				$valor_usd=$sel_r[18];
				$valor_cop=$sel_r[19];
				
				if($sel_r[9] == 1){
				$fecha_aprueba_ad = $sel_r[3];
				
				
				}
				
				$ob = $sel_r[13];
				$reco = $sel_r[14];
				
				if($ob == ""){
			$ob = $sel_r[12];
			}
		if($reco == ""){
			$reco = $sel_r[15];
			}
				
		$sel_si_socios = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud where id_rol = 11 and tipo_adj_permiso = 1 and estado = 1 and id_item_pecc = ".$sel_r[25]));
				}// FIN SI ES ADJUDICACION
				
		if($sel_si_socios[0]>0){//si tiene socios
				$tex_socios = "SI";	
				$sel_fecha_aprob = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_si_socios[0]));
				if($sel_fecha_aprob[0]>0){
				if($sel_fecha_aprob[4] == 1 or $sel_fecha_aprob[4] == 4){
						if($sel_r[23]==11){
							$resultado_socios = "INFORMADO";
							}else{
								$resultado_socios = "APROBADO";
							}
					}else{
						if($sel_r[23]==11){
							$resultado_socios = "NO INFORMADO - DEVUELTO AL PROFESIONAL";
							}else{
						$resultado_socios = "DEVUELTO AL PROFESIONAL";
							}
						}
				}else{
					$resultado_socios = "SIN RESPUESTA";
					}
						
					$fecha_socios = $sel_fecha_aprob[3];
				
			}else{// si no tiene socios
				$tex_socios = "NO";	
				$fecha_socios="N/A";
				$resultado_socios = "N/A";		
				}
		
		if($sel_r[9] == 1){
			if($sel_r[23]==11){
			$res_comi = "INFORMADO";
			}else{
				$res_comi = "APROBADO";
				}
			}else{
				if($sel_r[9] == 2){
					$res_comi = "PENDIENTE";
					}else{
				if($sel_r[23]==11){
					$res_comi = "NO INFORMADO - DEVUELTO AL PROFESIONAL";
				}else{
					$res_comi = "DEVUELTO AL PROFESIONAL";
					}
					}
				}
				
				
				if($sel_r[9] == 10){
					$res_comi="RECHAZADO";
					}
					$comple_texto="";
				if($sel_r[31]==1){
					$res_comi="DECLARADO DESIERTO";
					$comple_texto_tp_proceso="DECLARADO DESIERTO - ";
					}

					
					if($sel_r[29]==3){
						$res_comi="SIN ACCIONES";
						}
				
		if($sel_r[26] == 1){
			$text_tipo_solici = "SERVICIO";
			}else{
				$text_tipo_solici = "BIENES";
				}
		
  ?>
  <tr>
    <td><?=$numero_comite?></td>
    <td><?=$sel_r[3]?></td>
    <td><? if ($sel_r[28] == 1) echo "EXTRAORDINARIO"; else echo "NORMAL";?></td>
    <td><?=$nombre_tp?></td>
    <td><?=$comple_texto_tp_proceso?><?=$sel_r[5]?></td>
    <td><?=$text_tipo_solici?></td>
    <td><?=$numero_consecut?></td>
    <td><?=$res_comi?></td>
    <td><?
    
	
		if($sel_r["aplica_presidente"] == 1 and $sel_r[21] < 117 ){
		
		if($sel_r["presidente"]==1){
				echo "Verificado el ".$sel_r["presidente_fecha"];
			}else{
				echo "Aun no se ha verificado";
				}
		
		}else{
			echo "No requiere";
			}
	
	?>
    
    
    </td>
    <td><?=$sel_r[10]?></td>
    <td><?=$sel_r[11]?></td>
    <td><?=$sel_r[22]?></td>
    <td><?=$ob?></td>
    <td><?=$reco?></td>
    <td><?=$tex_socios?></td>
    <td><?=$fecha_socios?></td>
    <td><?=$resultado_socios?></td>
    <td><?
    $contratista = "";
	$tiene_coma = "";
	$coma_contratista="";
	if($sel_r[23] == 4 or $sel_r[23] == 5 or $sel_r[23] == 11 or $sel_r[23] == 12){

		$sel_contr = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id = ".$sel_r[24]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
					$contratista=  $sel_apl[3];
			}
		
		}
		
		if(($sel_r[23] == 1 or $sel_r[23] == 2 or $sel_r[23] == 3 or $sel_r[23] == 6) and $sel_r[4] ==2){
			
								
					
					$sel_contr_sql = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id_item = ".$sel_r[25]);
					
						while($sel_contr = traer_fila_db($sel_contr_sql)){
						
							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_contr[1]);
							$ano_contra = $separa_fecha_crea[0];
							
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_contr[0];
							$numero_contrato4 = $sel_contr[2];
						
						if($tiene_coma <> ""){
							echo $tiene_coma;
							$coma_contratista = ", ";
						}else{
							$tiene_coma = ", ";
							}
							
							echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
							$contratista.=  $coma_contratista.$sel_contr[3];
						}	
							
			
			
		}
		
				
			if($sel_r[23] == 7 or $sel_r[23] == 8){
				
		
				
				$sel_contr_ampl = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista from $pi12 as t1, $co1 as t2, t2_presupuesto as t3 where t1.t7_contrato_id = t2.id and t1.t2_presupuesto_id = t3.t2_presupuesto_id and t3.t2_item_pecc_id = ".$sel_r[25]." group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista");
				
			while($sel_apl = traer_fila_db($sel_contr_ampl)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					if($tiene_coma <> ""){
							echo $tiene_coma;
							$coma_contratista = ", ";
						}else{
							$tiene_coma = ", ";
							}
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
					
					$sel_contratisr = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id = ".$sel_apl[3]));
					$contratista.=  $coma_contratista.$sel_contratisr[0];
			}
				
				
			}
			
	$contratis_permi="";
	
	if(($sel_r[23] == 1 or $sel_r[23] == 2 or $sel_r[23] == 3 or $sel_r[23] == 6) and $sel_r[4] ==1){

	$contratistas_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_r[25]." and t1.id_proveedor = t2.t1_proveedor_id");
	while ($sel_pro_permiso = traer_fila_db($contratistas_permiso)){
	
	$contratis_permi = $sel_pro_permiso[0]." - ".$contratis_permi;
	
	}
	if($contratis_permi == ""){
	$contratis_permi=$sel_r[32];
	}
	}
	?></td>
    <td><?=$contratista?> <?=$contratis_permi?></td>
    <td><?=number_format($valor_usd, 0, ",",".")?></td>
    <td><?=number_format($valor_cop, 0, ",",".")?></td>
    <td><?=number_format(($valor_cop/1780) +($valor_usd), 0, ",",".")?></td>
   <td><?
    

		$text_coment = "";
	
	$sel_comentarios_ind = query_db("select observacion,  id_asistente from  t3_comite_aprobacion where id_comite = ".$sel_r[21]." and id_item = ".$sel_r[25]." and observacion is not null and observacion <> ''");

	
	
	while($sel_coment = traer_fila_db($sel_comentarios_ind)){
	
	$sel_usuario_asistente = traer_fila_row(query_db("select t2.nombre_administrador from t3_comite_asistentes as t1, t1_us_usuarios as t2 where t1.id_asistente = ".$sel_coment[1]." and t1.id_us = t2.us_id"));

		$text_coment = $text_coment." [".$sel_usuario_asistente[0]." - ".$sel_coment[0]."]";
		}
		if($sel_r[20] <> "" and $sel_r[20] <> " " and $sel_r[20] <> "  "){
			$text_coment = "[Secretario del Comite - ".$sel_r[20]."] ".$text_coment;
			}
			
		echo $text_coment;
	?></td>
    
  </tr>
  <?
  $numero_contrato="";
  }
  ?>
</table>
</body>
</html>
<?

?>