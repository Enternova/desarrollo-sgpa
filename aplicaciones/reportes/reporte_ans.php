<?
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
  header("Content-type: application/force-download");
//  header("Content-type: $tipo");
  header("Content-Disposition: attachment; filename=Reporte de ans.xls"); 
  header("Content-Transfer-Encoding: binary");
//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");
function numero_item_pecc($numero1, $numero2, $numero3){
      
      $cuantos_en_numero = strlen($numero3);
        if($cuantos_en_numero == 1){
            $numero3 = "000".$numero3;
          }
        if($cuantos_en_numero == 2){
            $numero3 = "00".$numero3;
          }
        if($cuantos_en_numero == 3){
            $numero3 = "0".$numero3;
          }
          
      $numero = $numero1.$numero2."-".$numero3;
      return $numero;
    }
if($_GET["t1_tipo_contratacion_id"]){
	if($_GET["t1_tipo_contratacion_id"]!=""){
		if($where==""){
	    	$where=" WHERE t1_tipo_contratacion_id=".$_GET["t1_tipo_contratacion_id"];
	    }else{
	    	$where.=" and t1_tipo_contratacion_id=".$_GET["t1_tipo_contratacion_id"];
	    }
	    $selected_id_contratacion=$_GET["t1_tipo_contratacion_id"];
	}else{
		$selected_id_contratacion="";
	}
}else{
  	$selected_id_contratacion="";
}
if($_GET["t1_tipo_proceso_id"]){
	if($_GET["t1_tipo_proceso_id"]!=""){
	    if($where==""){
	    	$where=" WHERE idans=".$_GET["t1_tipo_proceso_id"];
	    }else{
	    	$where.=" and idans=".$_GET["t1_tipo_proceso_id"];
	    }
	    $selected_id_proceso=$_GET["t1_tipo_proceso_id"];
	}else{
		$selected_id_proceso="";
	}
}else{
  	$selected_id_proceso="";
}
//echo $where;
/*if($_GET["monto"]){
	if($_GET["monto"]!=""){
	    $arr_monto=split('-',$_GET["monto"]);
	    if($where==""){
	    	$where=" WHERE monto_minimo=".$arr_monto[0]." and monto_maximo=".$arr_monto[1];
	    }else{
	    	$where.=" and monto_minimo=".$arr_monto[0]." and monto_maximo=".$arr_monto[1];
	    }
	    $selected_monto=$_GET["monto"];
	}else{
		$selected_monto="";
	}
}else{
  	$selected_monto="";
}*/
if($_GET["estado"]){
	if($_GET["estado"]!=""){
		if($where==""){
	    	$where=" WHERE estadoans=".$_GET["estado"];
	    }else{
	    	$where.=" and estadoans=".$_GET["estado"];
	    }
		$selected_estado=$_GET["estado"];
	}else{
		$selected_estado=1;
	}
}else{
  	$selected_estado=1;
}
if($_GET["socios"]){
	if($_GET["socios"]!=""){
		if($where==""){
	    	$where=" WHERE aplicasocios=".$_GET["socios"];
	    }else{
	    	$where.=" and aplicasocios=".$_GET["socios"];
	    }
		$selected_socios=$_GET["socios"];
	}else{
		$selected_socios="";
	}
}else{
  	$selected_socios="";
}

$query="select tiempo, actividad from vista_reporte_ans3 ".$where." group by actividad, tiempo";
/*if($_SESSION["id_us_session"]==32){
	echo $query;
}*/
$result=query_db($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
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
	<table border=1  width="100%" >
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="24" align="left" class="titulo1"><strong>REPORTE DE ANS</strong></td>
  </tr>
		<tr>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center">Actividad</div></td>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center">No. D&iacute;as</div></td>
		</tr>
		<?php
			$cont = 0;
			$total_dias=0;
			while ($ans=traer_fila_db($result)) {//funcion para dias number_format($dias_ideales_total,0) numero_item_pecc(
				$total_dias=$total_dias+number_format($ans[0],0);
				if($cont == 0){
				  	$clase= "filas_resultados";
					$cont = 1;
				}else{
				  	$clase= "";
					$cont = 0;
				}
			?>
				<tr>
					<td width="5%" class="columna_subtitulo_resultados"><div align="center"><?=$ans[1]?></div></td>
					<td width="5%" class="columna_subtitulo_resultados"><div align="center"><?=number_format($ans[0],0)?></div></td>
				</tr>
			<?}
		?>
		<tr>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
		</tr>
		<tr>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center">Total D&iacute;as</div></td>
			<td width="5%" class="columna_subtitulo_resultados"><div align="center"><?=$total_dias;?></div></td>
		</tr>
	</table>
</body>
</html>