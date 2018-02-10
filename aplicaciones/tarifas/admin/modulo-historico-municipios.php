<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
	

	
if($nu_contrato!=""){
	
	$complemento =	" and municipo like '%$nu_contrato%'";
}
	
	
if($proveedor!="")
	$complemento.=	" and proyecto like '%$proveedor%'";
	
	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from v_tarifas_municipio_proyecto where estado =1 $complemento ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	$es_admin_tarifas = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (1)"));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: HISTORICO DE MUNICIPIOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2">Buscador de municipios</td>
        </tr>
        <tr>
          <td width="23%" ><p align="right"><strong>Por municipio:</strong></p>          </td>
          <td width="31%" >
            <input type="text" name="nu_contrato" id="nu_contrato" value="<?=$nu_contrato;?>" />
          </td>
          <td width="22%" ><div align="right"><strong>Por proyectos</strong></div></td>
          <td width="24%"><input type="text" name="proveedor" id="proveedor" value="<?=$proveedor;?>"/></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <input name="button" type="button" class="boton_buscar" id="button" value="Realizar busqueda" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos')" />
       <?
        if($es_admin_tarifas[0]>0){
	   ?>
       <input name="button2" type="button" class="boton_grabar" id="button2" value="Crear municipio" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/admin/c_municipios.php','contenidos')" />
       <?
		}
	   ?>
       </td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center">P&aacute;gina</div></td>
        <td width="8%">
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </td>
        <td width="7%"> De</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="13%" class="columna_subtitulo_resultados"><div align="center">Ver proyectos</div></td>
    <td width="71%" class="columna_subtitulo_resultados"><div align="center">Municipio</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Cantidad de proyectos</div></td>
  </tr>
  
<?
 $busca_item = "select * from (
select t6_tarifas_municipios_id,municipo,  ROW_NUMBER() OVER(ORDER BY municipo) AS rownum from v_tarifas_municipio_proyecto  where estado = 1  $complemento  group by t6_tarifas_municipios_id,municipo) as sub
where rownum > $inicio and rownum <= $factor_b ";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		
$cuenta_proyectos = traer_fila_row(query_db("select count(*) from v_tarifas_municipio_proyecto where t6_tarifas_municipios_id = $ls_mr[0]"));		

?>  
  
  <tr class="filas_resultados">
    <td align="center" class="filas_resultados"><img src="../imagenes/botones/alerta.png" alt="Ingresar al municipio" title="Ingresar al municipio" width="16" height="16" onclick="ajax_carga('../aplicaciones/tarifas/admin/m_municipios.php?id_municipios=<?=arreglo_pasa_variables($ls_mr[0]);?>','contenidos');"/></td>
    <td class="filas_resultados"><?=$ls_mr[1];?></td>
    <td align="center" class="filas_resultados"><?=number_format($cuenta_proyectos[0],0);?></td>
  </tr>
  
  <? } ?>
  
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center">P&aacute;gina</div></td>
        <td width="8%">
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </td>
        <td width="7%">De</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
