<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";



	$sql_con=traer_fila_row(query_db($busca_contrato));
	$id_contrato_modulo_contrato =  $sql_con[13]; // Id contrato en modulo contratos
	$cuenta_descuentos = traer_fila_row(query_db("select count(*) from $v_t_2 where tarifas_contrato_id = $sql_con[0] and estado = 1"));
	

$id_log = log_de_procesos_sgpa(5, 55, 0, $id_contrato_modulo_contrato, 0, 0);//agrega valores

log_agrega_detalle ($id_log, "Consulta del contrato", $fecha , "",1);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<div id="carga_acciones_permitidas">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr class="titulos_secciones">
        <td colspan="4">CONTRATO: <?=$sql_con[7];?></td>
        </tr>
      <tr>
        <td width="29%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="38%" class="titulos_resumen_alertas"><strong>Estado del contrato:</strong>          <?=$sql_con[12];?></td>
      </tr>
      <tr>
        <td><div align="right"><strong>Fecha de Inicio:</strong></div></td>
        <td colspan="3"><?=$sql_con[20];?></td>
      </tr>
      <tr>
        <td align="right"><strong>Fecha de Fin:</strong>          <div align="right"></div></td>
        <td colspan="3"><?=$sql_con[21];?></td>
      </tr>
      <tr>
        <td valign="top"><div align="right"><strong>Objeto del contrato:</strong></div></td>
        <td colspan="3"><?=$sql_con[9];?></td>
        </tr>
       <? if($cuenta_descuentos[0]>=1){ // si tiene descuentos?>  <? } //si tiene descuentos ?>
     
    
    </table>    </td>
  </tr>
</table>
<br />
</div>

</body>
</html>
