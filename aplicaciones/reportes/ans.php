<?php
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores   (dbo.t2_nivel_servicio.aprobacion_comite <> 3) AND (dbo.t2_nivel_servicio.aplica_sondeo = 2)
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>
</head>

<body>
<div id="div_contenidos_carga">
  <div class="titulos_secciones">SECCION: Reporte de ANS</div>
  <br />
  <?=ayuda_alerta("Para realizar la b&uacute;squeda de los ANS debe seleccionar todos los campos de los filtros, estos ir&aacute;n cambiando a medida que va seleccionando cada opci&oacute;n")?><br />

  <table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="fondo_3">Filtrar por:</td>
    </tr>
 
  <tr>
    <td width="30%" align="right">Tipo de Contrataci&oacute;n:</td>
    <td width="50%">
    	<select name="t1_tipo_contratacion_id" id="t1_tipo_contratacion_id" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    	<?
			if($_GET["t1_tipo_contratacion_id"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		?>
    		
    		
    		<?php
			$select_tipo_contratacion="select t1_tipo_contratacion_id, tipocontratacion FROM vista_reporte_ans4 ".$where." group by t1_tipo_contratacion_id, tipocontratacion";
			$result=query_db($select_tipo_contratacion);
			while ($contratacion=traer_fila_db($result)){
				if($selected_id_contratacion==$contratacion[0]){?>
					<option value="<?=$contratacion[0];?>" selected><?=$contratacion[1];?></option>
				<?}else{?>
					<option value="<?=$contratacion[0];?>"><?=$contratacion[1];?></option>
			<?	}
			}
    		?>
    	</select>
    </td>
    
  </tr>
  <tr>
  	<td align="right">El ANS Aplica Socios:</td>
    <td width="24%">
    	<select name="socios" id="socios" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["socios"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		?>
    		<?php
			$aplica_socios="select aplicasocios FROM vista_reporte_ans4 ".$where." group by aplicasocios";
    		$result=query_db($aplica_socios);
			while ($proceso=traer_fila_db($result)){
				if($selected_socios==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected><?
						if($proceso[0]==1){
							echo "Si";
						}else if($proceso[0]==2){
							echo "No";
						}
					?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?
						if($proceso[0]==1){
							echo "Si";
						}else if($proceso[0]==2){
							echo "No";
						}
					?></option>
			<?	}
			}
    		?>
    	</select>
    	
    </td>
  </tr>
  <tr>
  	<td width="18%" align="right">Tipo de Proceso / Monto:</td>
    <td width="32%">
    <?
		//idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios

    	if($selected_id_contratacion=="" and $selected_socios==""){
			
			 $select_tipo_proceso="select idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios FROM vista_reporte_ans4 ".$where." group by idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios order by tipoproceso";
		?>
    	<select name="t1_tipo_proceso_id" id="t1_tipo_proceso_id" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["t1_tipo_proceso_id"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		
    		
    		$result=query_db($select_tipo_proceso);
			while ($proceso=traer_fila_db($result)){
				$proceso[2]=str_replace('.00', '', $proceso[2]);
				$pos = strpos($proceso[2], ">=500000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=200000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=0 <99");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				if($proceso[4]==1){
					$proceso[4]="Aplica Socios SI &nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$proceso[4]="Aplica Socios NO &nbsp;&nbsp;";
				}
				$proceso[2]=$proceso[4].$proceso[2]."&nbsp;&nbsp;".$proceso[3];
				if($selected_id_proceso==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected><?=$proceso[2];?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?=$proceso[2];?></option>
			<?	}
			}
    		?>
    	</select>
    	<?
    	}elseif($selected_id_contratacion!="" and $selected_socios==""){
			
			 $select_tipo_proceso="select idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios FROM vista_reporte_ans4 ".$where." group by idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios order by tipoproceso";
		?>
    	<select name="t1_tipo_proceso_id" id="t1_tipo_proceso_id" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["t1_tipo_proceso_id"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		
    		
    		$result=query_db($select_tipo_proceso);
			while ($proceso=traer_fila_db($result)){
				$proceso[2]=str_replace('.00', '', $proceso[2]);
				$pos = strpos($proceso[2], ">=500000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=200000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=0 <99");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				if($proceso[4]==1){
					$proceso[4]="Aplica Socios SI &nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$proceso[4]="Aplica Socios NO &nbsp;&nbsp;";
				}
				$proceso[2]=$proceso[4].$proceso[2];
				if($selected_id_proceso==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected><?=$proceso[2];?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?=$proceso[2];?></option>
			<?	}
			}
    		?>
    	</select>
    	<?
    	}elseif($selected_id_contratacion=="" and $selected_socios!=""){
			
			 $select_tipo_proceso="select idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios FROM vista_reporte_ans4 ".$where." group by idans, t1_tipo_proceso_id, tipoproceso, tipocontratacion, aplicasocios order by tipoproceso";
		?>
    	<select name="t1_tipo_proceso_id" id="t1_tipo_proceso_id" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["t1_tipo_proceso_id"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		
    		
    		$result=query_db($select_tipo_proceso);
			while ($proceso=traer_fila_db($result)){
				$proceso[2]=str_replace('.00', '', $proceso[2]);
				$pos = strpos($proceso[2], ">=500000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=200000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=0 <99");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				if($proceso[4]==1){
					$proceso[4]="Aplica Socios SI &nbsp;&nbsp;&nbsp;&nbsp;";
				}else{
					$proceso[4]="Aplica Socios NO &nbsp;&nbsp;";
				}
				$proceso[2]=$proceso[2]."&nbsp;&nbsp;".$proceso[3];
				if($selected_id_proceso==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected><?=$proceso[2];?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?=$proceso[2];?></option>
			<?	}
			}
    		?>
    	</select>
    	<?
    	}elseif($selected_id_contratacion!="" and $selected_socios=!""){
			
			 $select_tipo_proceso="select idans, t1_tipo_proceso_id, tipoproceso FROM vista_reporte_ans4 ".$where." group by idans, t1_tipo_proceso_id, tipoproceso order by tipoproceso";
		?>
    	<select name="t1_tipo_proceso_id" id="t1_tipo_proceso_id" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["t1_tipo_proceso_id"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		
    		
    		$result=query_db($select_tipo_proceso);
			while ($proceso=traer_fila_db($result)){
				$proceso[2]=str_replace('.00', '', $proceso[2]);
				$pos = strpos($proceso[2], ">=500000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=200000");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				$pos = strpos($proceso[2], ">=0 <99");
				if ($pos !== false) {//si exixte el id
					$muestra=explode('<', $proceso[2]);
					$proceso[2]=$muestra[0];
				}
				if($selected_id_proceso==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected><?=$proceso[2];?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?=$proceso[2];?></option>
			<?	}
			}
    		?>
    	</select>
    	<?
    	}
    	?>
    </td>
  </tr>
  <tr>
    <td align="right">Estado del ANS:</td>
    <td width="20%">
    	<select name="estado" id="estado" onchange="ajax_carga('../aplicaciones/reportes/ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estado='+document.getElementById('estado').value+'&socios='+document.getElementById('socios').value,'contenidos')">
    		<?
			if($_GET["estado"]>0){
				?><option value="0">Nuevo Filtro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
  		}else{
				?><option value="0">Seleccione&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><?
			}
   		?>
    		<?php
			$estado_ans="select estadoans FROM vista_reporte_ans4 ".$where." group by estadoans";
    		$result=query_db($estado_ans);
			while ($proceso=traer_fila_db($result)){
				if($selected_estado==$proceso[0]){?>
					<option value="<?=$proceso[0];?>" selected="selected"><?
						if($proceso[0]==1){
							echo "Activo";
						}else if($proceso[0]==2){
							echo "Inactivo";
						}
					?></option>
				<?}else{?>
					<option value="<?=$proceso[0];?>"><?
						if($proceso[0]==1){
							echo "Activo";
						}else if($proceso[0]==2){
							echo "Inactivo";
						}
					?></option>
			<?	}
			}
    		?>
    	</select>
    </td>
    
  </tr>
  
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="14%">
    
    <input type="button" name="xx" value="Buscar Reporte ANS" class="boton_buscar"  onclick="valida_reporte_ans()"/>

    
    
    </td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="0" height="0" align="right"><a style="cursor: pointer; color: #013ADF;" onclick="valida_reporte_excel_ans()"><strong><font size="+1">Generar Reporte  en EXCEL</font></strong> <img src="../imagenes/mime/xlsx.gif"></a></td>
  </tr>
</table>
<div id="carga_auditor_1">

</div>
</body>
</html>