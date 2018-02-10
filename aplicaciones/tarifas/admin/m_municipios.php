<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
	$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));	


 	 $sql_nombre_municipio = "select municipo from v_tarifas_municipio_proyecto where estado = 1 and t6_tarifas_municipios_id = $id_municipios_arr $complemento ";
	 $sql_nombre_municipio_2=traer_fila_row(query_db($sql_nombre_municipio));

	
if($nu_contrato!=""){
	
	$complemento =	" and municipo like '%$nu_contrato%'";
}
	
	
if($proveedor!="")
	$complemento.=	" and proyecto like '%$proveedor%'";
	
	$factor_b_c = 5000;
	$factor_b = 5000;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

$complemento= $complemento." and Estado_proyecto = 1 ";
 	 $sql_cuenta2 = "select  count(*) from v_tarifas_municipio_proyecto where estado = 1 and t6_tarifas_municipios_id = $id_municipios_arr $complemento  ";
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
    <td width="85%" class="titulos_secciones">SECCION: PROYECTOS DEL MUNICIPIO DE: <br /><?=$sql_nombre_municipio_2[0];?></td>
    <td width="15%" class="titulos_secciones"><input name="button2" type="button" class="boton_volver" id="button2" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos')" /></td>
  </tr>
</table>
<?
        if($es_admin_tarifas[0]>0){
	   ?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_2">Modificar municipio</td>
  </tr>
  <tr>
    <td width="22%" ><div align="right"><strong>Modificar municipo:</strong></div></td>
    <td width="24%"><input name="modifica_municipio" type="text" id="modifica_municipio" value="<?=$sql_nombre_municipio_2[0];?>"/></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><input name="button3" type="button" class="boton_buscar" id="button3" value="Modificar municipio" onclick="editar_municipio_tarifas()" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><br />
</p>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="fondo_2">Crear de proyectos</td>
        </tr>
        <tr>
          <td width="22%" ><div align="right"><strong>Nombre del proyecto para crear:</strong></div></td>
          <td width="24%"><input type="text" name="proyecto_crea" id="Proyecto_crea2"/></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top"><input name="button" type="button" class="boton_buscar" id="button" value="Crear proyectos" onclick="crear_proyecto_tarifas()" /></td>
  </tr>
</table>
<? } ?>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_titulo_resultados">Historico de proyectos</td>
  </tr>
  <tr>
    <td width="73%" class="columna_subtitulo_resultados"><div align="center">Proyectos</div></td>
    <td width="27%" class="columna_subtitulo_resultados"><div align="center">Modificar</div></td>
  </tr>
  
<?
$busca_item = "select * from (
select t6_tarifas_municipios_proyectos_id,proyecto,  ROW_NUMBER() OVER(ORDER BY proyecto) AS rownum from v_tarifas_municipio_proyecto  where estado = 1 and t6_tarifas_municipios_id = $id_municipios_arr $complemento  ) as sub
where rownum > $inicio and rownum <= $factor_b ";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		
$cuenta_proyectos = traer_fila_row(query_db("select count(*) from v_tarifas_municipio_proyecto where t6_tarifas_municipios_id = $ls_mr[0]"));		

?>  
  
  <tr class="filas_resultados">
    <td align="center" class="filas_resultados">
    <input type="text" name="m_proyecto_<?=$ls_mr[0];?>" id="textfield" value="<?=$ls_mr[1];?>" /></td>
    <td align="center" class="filas_resultados"><?
        if($es_admin_tarifas[0]>0){
	   ?><input name="Boton_modificar" type="button" class="boton_edicion" id="Boton_modificar" value="Modificar Proyecto" onclick="editar_proyecto_tarifas(<?=$ls_mr[0];?>)" /><? }?></td>
  </tr>
  
  <? } ?>
  
  <tr>
    <td colspan="5" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
</table>

<input type="hidden" name="id_municipios" value="<?=$id_municipios;?>" />
<input type="hidden" name="id_proyecto"  />
</body>
</html>