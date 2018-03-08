<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
 function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

 




	
	
/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 30;
	$factor_b = 30;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from v_tarifas_responsable_aprobacion ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="carga_reporte">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: REPORTE DE CONTRATOS CON TARIFAS PENDIENTES DE APROBACION</td>
  </tr>
</table>
<br />
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="3%">P&aacute;gina</td>
        <td width="11%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/r-pendientes-aprobacion.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="86%"><span class="letra-descuentos">Total de Contratos:
          <?=$sql_cuenta[0];?>
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="6%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="31%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="21%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de envio</div></td>
    <td width="16%" align="center" class="columna_subtitulo_resultados">Usuario responsable</td>
    <td width="16%" align="center" class="columna_subtitulo_resultados">Rol</td>
    <td width="10%" align="center" class="columna_subtitulo_resultados">Diferencia dias de aprobaci&oacute;n</td>
    </tr>
  
<?
 $busca_item = "select * from (
select distinct tarifas_contrato_id,id_contrato, consecutivo, us_id, roll, fecha, Expr1, nombre_administrador, ROW_NUMBER() OVER(ORDER BY  fecha desc) AS rownum  from v_tarifas_responsable_aprobacion  ) as sub
where rownum > $inicio and rownum <= $factor_b ORDER BY rownum asc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	
				



			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
		
$interval=0;
		$interval= dias_transcurridos($ls_mr[5],$fecha);
		
		

						?>
                     
 
  
   <tr class="<?=$class;?>">
    <td ><?=$ls_mr[2];?></td>
    <td ><?=$ls_mr[7];?></td>
    <td ><?=$ls_mr[5];?></td>
    <td ><?=$ls_mr[6];?></td>
    <td ><?=$ls_mr[4];?></td>
    <td ><?=$interval;?></td>
    </tr>
  
  <? $num_fila++;} ?>
  
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar resultado a excel"  onclick="javascript:exporta_r_pendienes()" /></td>
  </tr>
</table>
<input type="hidden" name="pre_edita" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />


</div>
</body>
</html>
