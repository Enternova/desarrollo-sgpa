<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
	$id_municipios_arr = elimina_comillas(arreglo_recibe_variables($id_municipios));	


 	 $sql_nombre_municipio = "select municipo from v_tarifas_municipio_proyecto where estado = 1 and t6_tarifas_municipios_id = $id_municipios_arr $complemento  $complemento ";
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

 	 $sql_cuenta2 = "select  count(*) from v_tarifas_municipio_proyecto where estado = 1 and t6_tarifas_municipios_id = $id_municipios_arr $complemento  $complemento ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
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
    <td width="85%" class="titulos_secciones">SECCION: CREACION DE MUNICIPIO</td>
    <td width="15%" class="titulos_secciones"><input name="button2" type="button" class="boton_volver" id="button2" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/admin/modulo-historico-municipios.php','contenidos')" /></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_2">Creacion municipio</td>
  </tr>
  <tr>
    <td width="22%" ><div align="right"><strong>Crear municipo:</strong></div></td>
    <td width="24%"><input name="municipio_crea" type="text" id="municipio_crea"/></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><input name="button3" type="button" class="boton_buscar" id="button3" value="Crear municipio" onclick="crea_municipio_tarifas()" /></td>
  </tr>
</table>
<p><br />
</p>
<input type="hidden" name="id_municipios" value="<?=$id_municipios;?>" />
<input type="hidden" name="id_proyecto"  />
</body>
</html>
