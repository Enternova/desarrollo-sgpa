<? include("../../librerias/lib/@session.php"); 

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Soporte Profecionales de CyC.xls");

?><head>
</head>
<html>

<table width="100%" border="1">
  <tr>
    <td width="6%" align="center" bgcolor="#E4E4E4"><pre>N&uacute;mero</pre></td>
    <td width="21%" align="center" bgcolor="#E4E4E4"><pre>Profesional Asignado</pre></td>
    <td width="14%" align="center" bgcolor="#E4E4E4"><pre>Tipo del Proceso</pre></td>
    <td width="4%" align="center" bgcolor="#E4E4E4"><pre>Area</pre></td>
    <td width="19%" align="center" bgcolor="#E4E4E4"><pre>Congelado</pre></td>
    <td width="18%" align="center" bgcolor="#E4E4E4"><pre>Fecha de Creaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha en la que se puso en firme</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Nivel de Aprobaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Estado Actual</pre></td>
    <td align="center" bgcolor="#E4E4E4"><pre>Rechazado</pre></td>
    <td align="center" bgcolor="#E4E4E4"><pre>Declado Desierto</pre></td>
  </tr>
  <?
  

  	$sel_1 = query_db("select * from " . $_SESSION["version_2_indi_soporte_1"] . " ".$_SESSION["comple_filtro3"]);
	
	
	
	while($s_1 = traer_fila_db($sel_1)){
		
		$rechazado="";
		$desierto="";
		if($s_1[19]==1){
			$rechazado="SI";
			}
		if($s_1[20]==1){
			$desierto="SI";
			}
  ?>
  <tr>
    <td><?=numero_item_pecc($s_1[0],$s_1[1],$s_1[2])?></td>
    <td><?=$s_1[3]?></td>
    <td><?=$s_1[5]?>
    <? if($s_1[24]==1) echo " - Modificaci&oacute;n";?></td>
    <td><?=$s_1[6]?></td>
    <td><? if($s_1[7] == 1) {echo "Congelado";} ?></td>
    <td><?=$s_1[4]?></td>
    <td><?=$s_1[25]?></td>
    <td><?
	  echo $s_1[15];/*
		$aprobacion_nivel = nivel_aprobacion_solicitud($s_1[17], "adjudicacion");
		echo $aprobacion_nivel;
		$cuantos_caracteres = strlen($aprobacion_nivel);
		$cuantos_caracteres = $cuantos_caracteres - 13;
		$aprobacion_nivel_su = substr($aprobacion_nivel,0,$cuantos_caracteres);
		echo "-".$aprobacion_nivel_su."-";
		*/
		?></td>
    <td><? if($s_1[14]>=20 and $s_1[14]<32) echo "En Legalizacion"; else echo $s_1[8]; ?></td>
    <td><?=$rechazado?></td>
    <td><?=$desierto?></td>
    <?
    	
	?>
  </tr>
  <?
	}
  ?>
</table>


	</html>