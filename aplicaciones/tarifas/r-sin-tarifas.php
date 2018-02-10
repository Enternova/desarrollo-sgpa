<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
 

if($gerentes>=1)
	$complemento_busqueda.= " and t6_tarifas_estados_contratos_id =  $gerentes ";

if($b_contrato!="")
	$complemento_busqueda.= " and consecutivo like  '%$b_contrato%' ";

if($b_provee!="") 
	$complemento_busqueda.= " and razon_social like  '%$b_provee%' ";

	$complemento_busqueda.= " and t6_tarifas_estados_contratos_id =  2 ";

switch($b_activo){
	case 1: $complemento_busqueda.= " and estado < 10 "; break;
	case 2: $complemento_busqueda.= " and estado = 10 ";break;
	case 3: $complemento_busqueda.= " and estado = 32 ";break;
	}

//if($b_congelados != 2) $complemento_busqueda.= " and (analista_deloitte = 0 or analista_deloitte is null ) ";

	
	
/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from v_tarifas_reporte_contratos_parciales where 1=1 $complemento_busqueda";
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
    <td class="titulos_secciones">SECCION: REPORTE  DE TARIFAS CARGADAS A LOS CONTRATOS EN ESTADO PENDIENTE</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
  <tr>
    <td width="3%">P&aacute;gina</td>
    <td width="9%"><select name="pagina" id="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/r-sin-tarifas.php','contenidos')">
      <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
      <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
        <?=$i;?>
        </option>
      <? } ?>
    </select></td>
    <td width="14%"><span class="letra-descuentos">Total de Contratos:
      <?=$sql_cuenta[0];?>
    </span></td>
    <td width="74%">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="13%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="26%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="44%" align="center" class="columna_subtitulo_resultados">Responsable</td>
    <td width="17%" align="center" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
  </tr>
  
<?
$busca_item = "select * from (
select distinct tarifas_contrato_id, consecutivo, objeto, razon_social, t6_tarifas_estados_contratos_id, t1_proveedor_id ,nit,especialista, ROW_NUMBER() OVER(ORDER BY consecutivo desc) AS rownum  from v_tarifas_reporte_contratos_parciales where 1=1 $complemento_busqueda ) as sub
where rownum > $inicio and rownum <= $factor_b ORDER BY rownum asc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_db($sql_ex)){
$nombre_especialista ="";

	if($ls_mr[7]!=""){
	$sel_usuario = "select * from $g1 where us_id = $ls_mr[7]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_especialista = $sql_sel_usuario[1];
	}

	
	if($ls_mr[4]==1) $estado="Sin tarifas";
	elseif($ls_mr[4]==2) $estado="Parcial";
	elseif($ls_mr[4]==3) $estado="En firme";	
	?>
   <tr class="<?=$class;?>">
    <td ><?=$ls_mr[1];?></td>
    <td ><?=$ls_mr[3];?></td>
    <td ><?=$nombre_especialista;?></td>
    <td><?=$estado;?></td>
  </tr>
  
  <? $num_fila++;} ?>
</table>
<table width="100%" border="0">
  <tr>
    <td align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar resultado a excel"  onclick="exporta_r_sin_tarifas_contrato_parcia()" /></td>
  </tr>
</table>
<input type="hidden" name="pre_edita" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />


</div>
</body>
</html>
