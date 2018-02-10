<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
	// INicio Permisos para visualizar un contrato
  	//$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	// INicio Permisos para visualizar un contrato
	

	if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=50;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
	$query_comple = "";
	
	
	if($contratista_bu!=""){
		$explode = explode("----,",elimina_comillas_2($contratista_bu));
		$id_contratista = $explode[1];
		$query_comple = $query_comple." and t1_proveedor_id = ".$id_contratista;
	}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: BUSCADOR DE PROVEEDORES</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="fondo_2">Buscador Proveedores</td>
        </tr>
        <tr>
          <td width="15%" ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
          <td width="85%" ><input type="text" name="contratista_bu" id="contratista_bu" value="<?=$contratista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/proveedores_general.php')"/></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top" id="carga_acciones_permitidas2"><label>
      <input name="button" type="button" class="boton_grabar" id="button" value="Realizar busqueda de Proveedores" onclick="ajax_carga('../aplicaciones/contratos/hse/modulo-historico.php?paginas='+this.value+'&contratista_bu='+document.principal.contratista_bu.value,'contenidos')"/>
    </label></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="86%" align="right"><strong>
          <?
      $cuantos_registros = traer_fila_row(query_db("select count(*) from $g6 where estado = 1 ".$query_comple.$permisos));
	  $cunatas_paginas = ($cuantos_registros[0] / $registros_pagina) +1;
	  
	  ?>
          Paginas:</strong></td>
        <td width="6%"><select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/contratos/hse/modulo-historico.php?paginas='+this.value+'&contratista_bu='+document.principal.contratista_bu.value,'contenidos')">
        <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
        <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
          <?=$i?>
          </option>
        <? }?>
      </select></td>
        <td width="8%">de <?=intval($cunatas_paginas)?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="3%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center">NIT</div></td>
    <td width="43%" class="columna_subtitulo_resultados"><div align="center">Proveedor / Contratista</div></td>
    <td width="12%" class="columna_subtitulo_resultados"><div align="center">#Evaluaciones</div></td>
  </tr>
  <?
	$lista_contrato = "select * from (select ROW_NUMBER()Over(Order by razon_social Asc) As RowNum, * from $g6 where estado = 1".$query_comple.$permisos.") as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final";

	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
	
		
		
	?>
  <tr class="filas_resultados">
    <td ><a href="javascript:taer_menu('../aplicaciones/contratos/hse/menu.php?id=<?=arreglo_pasa_variables($lista_contrato[1]);?>','contenido_menu')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
    <?
	$digito = "";
    if(trim($lista_contrato[3])!=""){
		$digito = "-".$lista_contrato[3];
	}
	?>
    <td><?=$lista_contrato[2].$digito;?></td>
    <td><?=$lista_contrato[4];?></td>
      <td>&nbsp;</td>
  </tr>
  <?
	}
	?>
  <tr>
    <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="86%" align="right"><strong>
        
          Paginas:</strong></td>
        <td width="6%"><select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/contratos/hse/modulo-historico.php?paginas='+this.value+'&contratista_bu='+document.principal.contratista_bu.value,'contenidos')">
          <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
          <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
            <?=$i?>
            </option>
          <? }?>
        </select></td>
        <td width="8%">de
          <?=intval($cunatas_paginas)?></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
</p>
</body>
</html>
