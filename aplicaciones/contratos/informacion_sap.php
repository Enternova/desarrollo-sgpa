<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

	$busca_contrato = "select * from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	$valor_acumulado_usd = $sql_con[17];
	$valor_acumulado_cop = $sql_con[18];
	
	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$sql_con[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];//consecutivo
			$numero_contrato4 = $sql_con[43];//apellido
			$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con[0]);
			$numero_contrato_fin = str_replace("-","",$numero_contrato_fin);
			$numero_contrato_fin = str_replace(" ","",$numero_contrato_fin);
			/*
  $lista_poliza_int = "select * from ".$co4." t7c left join ".$g8." t1t on t7c.tipo_complemento = t1t.id left join ".$g9." t1to on t7c.tipo_otrosi = t1to.id left join ".$g5." t1m on t7c.tipo_moneda = t1m.t1_moneda_id  where  id_contrato = $id_contrato_arr and t7c.estado = $est_finalizado";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		if($lista_poliza_int[2]!=2){
			$valor_acumulado_usd = $valor_acumulado_usd-$lista_poliza_int[8];	
			$valor_acumulado_cop = $valor_acumulado_cop-$lista_poliza_int[32];
		}
	}
	*/
	$busca_ejecucion ="select t7e.id,t7e.id_usuario,t7e.fecha,t7e.mes_corte,t7e.estado,t7ej.id,t7ej.id_cargue,t7ej.id_contrato,t7ej.num_contrato,t7ej.por_ejecucion,t7ej.ejecucion_usd,t7ej.ejecucion_cop from $co9 t7e left join $co10 t7ej on t7ej.id_cargue = t7e.id where t7ej.id_contrato = $id_contrato_arr order by t7e.id desc";
	$sql_busca_ejecucion=traer_fila_row(query_db($busca_ejecucion));
	$mes = $sql_busca_ejecucion[3];
	$valor_ejecutado_usd = $sql_busca_ejecucion[10];
	$valor_ejecutado_cop = $sql_busca_ejecucion[11];
	$porcentaje = $sql_busca_ejecucion[9];
	
	if($mes == 1)
		$imp_mes = "Enero";
	if($mes == 2)
		$imp_mes = "Febrero";
	if($mes == 3)
		$imp_mes = "Marzo";
	if($mes == 4)
		$imp_mes = "Abril";
	if($mes == 5)
		$imp_mes = "Mayo";
	if($mes == 6)
		$imp_mes = "Junio";
	if($mes == 7)
		$imp_mes = "Julio";
	if($mes == 8)
		$imp_mes = "Agosto";
	if($mes == 9)
		$imp_mes = "Septiembre";
	if($mes == 10)
		$imp_mes = "Octubre";
	if($mes == 11)
		$imp_mes = "Noviembre";
	if($mes == 12)
		$imp_mes = "Diciembre";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="4" class="fondo_4">Informaci&oacute;n Ejecuci&oacute;n</td>
        </tr>
      <tr >
        <td align="right" >Mes Corte:</td>
        <td colspan="3" ><?=$imp_mes;?></td>
      </tr>
      <tr >
        <td align="right" >% Ejecutado:</td>
        <td colspan="3" ><?=$porcentaje;?></td>
      </tr>
      <tr >
        <td align="right" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr >
        <td width="16%" align="right" >&nbsp;</td>
        <td width="14%" align="left" >&nbsp;</td>
        <td width="16%" align="left" >&nbsp;</td>
        <td width="54%" >&nbsp;</td>
      </tr>
      <tr >
        <td align="right" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr >
        <td align="right" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td align="left" >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      
      </table>
      <BR />
      
      
      
    </td>
  </tr>
</table>

</body>
</html>
