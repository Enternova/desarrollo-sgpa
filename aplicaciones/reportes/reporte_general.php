<?   header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte niveles de Aprobacion.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
   include("../../librerias/php/funciones_general_2015.php");








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
			
		$comple_sql = " and (fecha_aprobacion_permiso like '%".$mes."%' or fecha_aprobacion_adjudicacion like '%".$mes."%')";
	}
	
if($_GET["comite_ano"] <> 0 and $mes==""){

			$comple_sql = " and (fecha_aprobacion_permiso like '%".$_GET["comite_ano"]."%' or fecha_aprobacion_adjudicacion like '%".$_GET["comite_ano"]."%')";
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
    <td colspan="3" rowspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="28" align="left" class="titulo1"><strong>REPORTE NIVELES DE APROBACION</strong></td>
  </tr>
  <tr class="titulo2">
    <td colspan="2" align="right">Año de Aprobacion:</td>
    <td colspan="26" align="left">
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
    <td colspan="2" align="right">Mes de Aprobacion:</td>
    <td colspan="26" align="left"><?
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
 
  <tr>
    <td align="center" class="titulo3" >Numero de la Solicitud</td>
    <td align="center" class="titulo3">Es Carga Masiva</td>
    <td align="center" class="titulo3">Tipo de Permiso</td>
    <td align="center" class="titulo3">Nivel de Aprobacion</td>
    <td align="center" class="titulo3">Fecha de Aprobacion</td>
    <td align="center" class="titulo3">Usuario que Aprobo</td>
    <td align="center" class="titulo3">Tipo de Proceso</td>
    <td align="center" class="titulo3">Tipo de Otro si</td>
    <td align="center" class="titulo3">Numero de Otro Si</td>
    <td align="center" class="titulo3">Aplica Socios</td>
    <td align="center" class="titulo3">Preparador de la Solicitud</td>
    <td align="center" class="titulo3">Gerente Solicitud</td>
    <td align="center" class="titulo3">Gerente de la OT</td>
    <td align="center" class="titulo3">&Aacute;rea Responsable</td>
    <td align="center" class="titulo3">Profesional Encargado</td>
    <td align="center" class="titulo3">Objeto de la Solicitud</td>
    <td align="center" class="titulo3">Objeto del Contrato</td>
    <td align="center" class="titulo3">Justificaci&oacute; T&eacute;cnica</td>
    <td align="center" class="titulo3">Justificaci&oacute; Comercial</td>  
    <td align="center" class="titulo3">Alcance</td>           
    <td align="center" class="titulo3">Recomendaci&oacute;n</td>
    <td align="center" class="titulo3">N&uacute;mero de Contrato Relacionado</td>
    <td align="center" class="titulo3">Proveedores Relacionados</td>
    <td align="center" class="titulo3">Valor USD</td>
    <td align="center" class="titulo3">Valor COP</td>
    <td align="center" class="titulo3">Rechazado</td>
    <td align="center" class="titulo3">Declarado Desierto</td>
    <td align="center" class="titulo3">Cargue Masivo</td>
    <td align="center" class="titulo3">Destino</td>
    <td align="center" class="titulo3">Duración</td>        
    <td align="center" class="titulo3">Fecha de Creación</td>        
  </tr>
  <?
  $sql="select * from version_2_reporte_niveles_aprobacion where id_item>0 $comple_sql order by num3";
  //echo $sql;
  $sel_repor = query_db($sql);

  while($sel_r = traer_fila_db($sel_repor)){
	  
	  $numero_consecut = numero_item_pecc($sel_r[2],$sel_r[3],$sel_r[4]);

			$fecha_aprueba_ad = "";
			$ob = $sel_r[18];
			$reco = $sel_r[20];	
			
					
		if($ob == ""){
			$ob = $sel_r[17];
			}
		if($reco == ""){
			$reco = $sel_r[19];
			}
			
			$nivel_aprobacion="";
			$fecha_aprobacion ="";
			$usuario_aprueba="";
			$preparador="";
				
		if($sel_r[5] == "Permiso"){
			$nivel_aprobacion = $sel_r[0];
			$fecha_aprobacion =$sel_r[6];
			$observacion_contrato = $sel_r[25];		
			$justificacion_tecnica = $sel_r[29];
			$justificacion_comercial = $sel_r[27];		
			$alcance = $sel_r[31];		
			if($nivel_aprobacion == "Comite"){
			$usuario_aprueba = $sel_r[8];
			}else{
				$usuario_aprueba=traer_nombre_muestra($sel_r[8], $g1,"nombre_administrador","us_id");
				}
				$sel_valor_sol = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from  t2_presupuesto where  t2_item_pecc_id = ".$sel_r[16]." and permiso_o_adjudica = 1"));
			}//fin si es permiso
			
		if($sel_r[5] == "Adjudicacion"){
			$nivel_aprobacion = $sel_r[1];
			$observacion_contrato = $sel_r[24];
			$justificacion_tecnica = $sel_r[26];
			$justificacion_comercial = $sel_r[28];			
			$fecha_aprobacion =$sel_r[7];
			$alcance = $sel_r[30];					
			if($nivel_aprobacion == "Comite"){
			$usuario_aprueba = $sel_r[9];
			}else{
				$usuario_aprueba=traer_nombre_muestra($sel_r[9], $g1,"nombre_administrador","us_id");
				}
				$sel_valor_sol = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from  t2_presupuesto where  t2_item_pecc_id = ".$sel_r[16]." and permiso_o_adjudica = 2"));
			}//fin si es adjudicacion
			
		if($sel_r[11] <> "" and $sel_r[11] <> $sel_r[12]){
			$preparador = $sel_r[11];
			}
		
		$rechazado="";
		$desierto="";
		if($sel_r[21]==1){
			$rechazado="SI";
			}
		if($sel_r[22]==1){
			$desierto="SI";
			}
		
  ?>
  <tr>
    <td><?=$numero_consecut?></td>
    <td><? if ($sel_r[31]=="si" or $sel_r[31]=="Si" or $sel_r[31]=="SI") echo "SI"; else echo "NO";?></td>
    <td><?=$sel_r[5]?></td>
    <td><?=$nivel_aprobacion?></td>
    <td><?=$fecha_aprobacion?></td>
    <td><?=$usuario_aprueba?></td>
    <td><?=$sel_r[10]?></td>
    
    <?
	$numero_otro_si="";
	$tipo_otro_si="";
	if($sel_r[35] == 5 or $sel_r[35] == 4 or $sel_r[35] == 13 or $sel_r[35] == 14){
		
    $sel_otro_si = traer_fila_row(query_db("select t2.nombre, t1.numero_otrosi from t7_contratos_complemento as t1, t1_tipo_otro_si as t2 where t1.id_item_pecc = ".$sel_r[16]." and t1.tipo_otrosi = t2.id"));
	$tipo_otro_si = $sel_otro_si[0];
	$numero_otro_si = $sel_otro_si[1];
	 $explode_contrato = explode(">",contratos_relacionados_solicitud_para_campos($sel_r[16]));
	 $num_contrato_rel =$explode_contrato[1].">";
	 $provedor_rel=$explode_contrato[2];
	}else{
		$num_contrato_rel =contratos_relacionados_solicitud_para_campos($sel_r[16]);
	 	$provedor_rel="";
		}
	?>
    <td><?=$tipo_otro_si;?></td>
    <td><?=$numero_otro_si?></td>
    <td><? if($nivel_aprobacion == "Socios") echo "SI"; else echo "NO";?></td>
    <td><?=$preparador?></td>
    <td><?=$sel_r[12]?></td>
    <td><?=$sel_r[13]?></td>
    <td><?=$sel_r[14]?></td>
    <td><?=$sel_r[15]?></td>
    <td><?=$ob?></td>
    <td><?=$observacion_contrato?></td>   
    <td><?=$justificacion_tecnica?></td> 
    <td><?=$justificacion_comercial?></td>
    <td><?=$alcance?></td>    
    <td><?=$reco?></td>
    <?
	
   
	?>
    
    <td><?=$num_contrato_rel?></td>
    <td><?=$provedor_rel?></td>
    <td><?=number_format($sel_valor_sol[0],0,'.','')?></td>
    <td><?=number_format($sel_valor_sol[1],0,'.','')?></td>
    <td><?=$rechazado;?></td>
    <td><?=$desierto;?></td>
    <td><?=($sel_r[31] == "SI" ? "SI" : "NO")?></td>
 
    <td><?=$sel_r[33]?></td>    
    <td><?=$sel_r[34]?></td>            
    <td><?=$sel_r[32]?></td>       
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