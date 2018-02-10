<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



?>
<table width="100%" border="1">
  <tr>
    <td colspan="5" align="center">General</td>
    <td colspan="10" align="center">Permiso</td>
    <td colspan="7" align="center">Adjudicacion</td>
    <td colspan="6" align="center">Documentos</td>
  </tr>
  <tr>
    <td align="center">id solicitud</td>
    <td align="center">numero solicitud</td>
    <td align="center">tipo de proceso</td>
    <td align="center">estado</td>
    <td align="center">area</td>
    <td align="center">ob solicitud</td>
    <td align="center">ob contrato</td>
    <td align="center">alcance </td>
    <td align="center">justificacion</td>
    <td align="center">recomendacion</td>
    <td align="center">proveedores sugeridos</td>
    <td align="center">Gerente Solicutd</td>
    <td align="center">Profesional de C&amp;C</td>
    <td align="center">Valor USD</td>
    <td align="center">valor COP</td>
    <td align="center">Objeto solicitud Adjudicacion</td>
    <td align="center">Objeto contrato adjudicacion</td>
    <td align="center">Alcance Adjudicacion</td>
    <td align="center">Justificacion adjudicacion</td>
    <td align="center">recomendacion adjudicacion</td>
    <td align="center">valor adjudicacion USD</td>
    <td align="center">valor adjudicacion COP</td>
    <td align="center">Numero de Contrato</td>
    <td align="center">Gerente del Contrato</td>
    <td align="center">Especialista</td>
    <td align="center">Tipo de Contrato</td>
    <td align="center">Contratista</td>
    <td align="center">Numero Otro SI</td>
  </tr>
  <?
  $sel_repor = query_db("select * from vista_reporte_edwin_3");
  while($sel_r = traer_fila_db($sel_repor)){
	  
	  $numero_consecut = numero_item_pecc($sel_r[1],$sel_r[2],$sel_r[3]);
	  
	  	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$sel_r[25]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sel_r[24];//consecutivo
		$numero_contrato4 = $sel_r[26];//apellido
		if($numero_contrato1 <> ""){
	 $numero_contrato =  numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
		}
  ?>
  <tr>
    <td><?=$sel_r[0]?></td>
    <td><?=$numero_consecut?></td>
    <td><?=$sel_r[4]?></td>
    <td><?=$sel_r[5]?></td>
    <td><?=$sel_r[6]?></td>
    <td><?=$sel_r[7]?></td>
    <td><?=$sel_r[8]?></td>
    <td><?=$sel_r[9]?></td>
    <td><?=$sel_r[10]?></td>
    <td><?=$sel_r[11]?></td>
    <td><?=$sel_r[12]?></td>
    <td><?=$sel_r[13]?></td>
    <td><?=$sel_r[14]?></td>
    <td><?=$sel_r[15]?></td>
    <td><?=$sel_r[16]?></td>
    <td><?=$sel_r[17]?></td>
    <td><?=$sel_r[18]?></td>
    <td><?=$sel_r[19]?></td>
    <td><?=$sel_r[20]?></td>
    <td><?=$sel_r[21]?></td>
    <td><?=$sel_r[22]?></td>
    <td><?=$sel_r[23]?></td>
    <td><?=$numero_contrato?></td>
    <td><?=$sel_r[34]?></td>
    <td><?=$sel_r[33]?></td>
    <td><?=$sel_r[27]?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  $numero_contrato="";
  }
  ?>
</table>

