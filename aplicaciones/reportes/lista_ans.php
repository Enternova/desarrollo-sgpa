<?php
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php"); 

verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
$id_contratacion=""; $id_proceso=""; $monto=""; $estado=""; $where="";
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
/*
if($_SESSION["id_us_session"]==32){
	echo $query;
}*/
$result=query_db($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table width="100%" border="0" class="tabla_lista_resultados">
		<tr>
			<!--td width="7%" align="center" class="fondo_3">No.</td -->
			<td width="27%" align="center" class="fondo_3">Actividad</td>
			<td width="10%" align="center" class="fondo_3">No. D&iacute;as</td>
		</tr>
		<?php
			$cont = 0;
			$const=0;
			$total_dias=0;
			while ($ans=traer_fila_db($result)) {//funcion para dias number_format($dias_ideales_total,0) numero_item_pecc(
				$total_dias=$total_dias+number_format($ans[0],0);
					if($const == $ans[2]){					  	
					}else{
						if($cont==0){
							$clase= "filas_resultados";
							$cont = 1;
							$const=$ans[2];
						}else{
							$clase= "";
						  	$const=$ans[2];
							$cont = 0;
						}					  	
					}
			?>
				<tr style="cursor:pointer" class="<?=$clase?>">	
					<!--td align="center" class="<?=$clase?>"><?=numero_item_pecc($ans[2],$ans[3],$ans[4])?></td -->
					<td align="center" class="<?=$clase?>"><?=$ans[1];?></td>
					<td align="center" class="<?=$clase?>"><?=number_format($ans[0],0)?></td>
				</tr>
			<?}
		?>
		<tr style="cursor:pointer" class="">
			<td align="center" class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="center" class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr style="background: #FFFFCC">	
			<!--td align="center" class="<?=$clase?>"><?=numero_item_pecc($ans[2],$ans[3],$ans[4])?></td -->
			<td align="center" style="background: #FFFFCC">Total D&iacute;as</td>
			<td align="center" style="background: #FFFFCC"><?=$total_dias;?></td>
		</tr>
	</table>
		
</body>
</html>