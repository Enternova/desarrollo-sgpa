<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=paises.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<table width="100%" border="1">
  <tr>
    <td align="center">Numero del Comité</td>
    <td align="center">Fecha del Comité</td>
    <td align="center">Tipo de Permiso</td>
    <td align="center">Tipo de Proceso </td>
    <td align="center">Numero de la Solicitud</td>
    <td align="center">Resultado del Comité</td>
    <td align="center">Area Responsable</td>
    <td align="center">Gerente Solicitud</td>
    <td align="center">Objeto de la Solcitud</td>
    <td align="center">Recomendacion</td>
    <td align="center">Contratista</td>
    <td align="center">Valor USD</td>
    <td align="center">Valor COP</td>
    <td align="center">Equivalente USD</td>
    <td align="center">TRM</td>
    <td align="center">Comentario del Comité</td>
    <td align="center">Fecha Aprobacion Adjudicacion</td>
  </tr>
  <?
  $sel_repor = query_db("select * from vista_reporte_comite");
  while($sel_r = traer_fila_db($sel_repor)){
	  
	  $numero_comite = numero_item_pecc($sel_r[0],$sel_r[1],$sel_r[2]);
	  $numero_consecut = numero_item_pecc($sel_r[6],$sel_r[7],$sel_r[8]);
	  
	  	
		if($sel_r[4] ==1){
			$nombre_tp = "Permiso";
			
			$valor_usd=$sel_r[16];
			$valor_cop=$sel_r[17];
			
			$fecha_aprueba_ad = "";
			
			}else{
				$nombre_tp = "Adjudicacion";
				
				$valor_usd=$sel_r[18];
				$valor_cop=$sel_r[19];
				if($sel_r[9] == 1){
				$fecha_aprueba_ad = $sel_r[3];
				}
				}
		if($sel_r[14] <> ""){
			$ob = $sel_r[14];
				$reco = $sel_r[15];
			}else{
			$ob = $sel_r[12];
			$reco = $sel_r[13];	
				}
		
		if($sel_r[9] == 1){
			$res_comi = "APROBADO";
			}else{
				$res_comi = "DEVUELTO AL PROFESIONAL";
				}
		
  ?>
  <tr>
    <td><?=$numero_comite?></td>
    <td><?=$sel_r[3]?></td>
    <td><?=$nombre_tp?></td>
    <td><?=$sel_r[5]?></td>
    <td><?=$numero_consecut?></td>
    <td><?=$res_comi?></td>
    <td><?=$sel_r[10]?></td>
    <td><?=$sel_r[11]?></td>
    <td><?=$ob?></td>
    <td><?=$reco?></td>
    <td>&nbsp;</td>
    <td><?=number_format($valor_usd, 0)?></td>
    <td><?=number_format($valor_cop, 0)?></td>
    <td><?=number_format(($valor_cop/1780) +($valor_usd), 0)?></td>
    <td>1.780</td>
    <td><?=$sel_r[20]?></td>
    <td><?=$fecha_aprueba_ad?></td>
  </tr>
  <?
  $numero_contrato="";
  }
  ?>
</table>

