<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
	
$complemento= " and t1_proveedor_id =".$_SESSION["id_proveedor"];
	
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

 	 $sql_cuenta2 = "select  count(*) from $v_t_1 where tarifas_contrato_id >=1 $complemento ";
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
    <td class="titulos_secciones">SECCION: HISTORICO DE CONTRATOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3" valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2">Buscador de contratos</td>
        </tr>
        <tr>
          <td width="23%" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><p align="right"><strong>Por contrato:</strong></p>          </td>
          <td width="31%" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><label>
            <input type="text" name="textfield" id="textfield" />
          </label></td>
          <td width="22%" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por proveedor/contratista</strong></div></td>
          <td width="24%" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><input type="text" name="textfield2" id="textfield2" /></td>
        </tr>
        <tr>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por tipo de actualizaci&oacute;n</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><label>
            <select name="select" id="select">
              <option>Seleccione</option>
              <option>Nueva</option>
              <option>Modificada</option>
            </select>
          </label></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por tipo de aprobaci&oacute;n</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><select name="select2" id="select2">
            <option>Seleccione</option>
            <option>Pendiente</option>
            <option>Aprobadas</option>
            <option>Rechazadas</option>
                    </select></td>
        </tr>
        <tr>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por usuario asignado</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><select name="select3" id="select3">
            <option>Seleccione</option>
            <option>Andrea reyes</option>
                    </select></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por codigo</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><input type="text" name="textfield3" id="textfield3" /></td>
        </tr>
        <tr>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por gerente del contrato:</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><select name="select4" id="select4">
              <option>Seleccione</option>
              <option>Andrea reyes</option>
          </select></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por Objeto del contrato:</strong></div></td>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><input type="text" name="textfield6" id="textfield6" /></td>
        </tr>
        <tr>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por maestra de tarifas</strong></div></td>
          <td colspan="3" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')">
            <div align="left">
              <input type="text" name="textfield4" id="textfield4" />
          </div></td>
        </tr>
        <tr>
          <td onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')"><div align="right"><strong>Por descripci&oacute;n de tarifa</strong></div></td>
          <td colspan="3" onclick="ajax_carga('c_tarifas.php','carga_acciones_permitidas')">
            <div align="left">
              <input type="text" name="textfield5" id="textfield5" />
          </div></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td width="29%" valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
    <td width="29%" valign="top" id="carga_acciones_permitidas2"><label>
      <input name="button" type="botton" class="boton_grabar" id="button" value="Realizar busqueda de contratos" />
    </label></td>
    <td width="29%" valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Contratos encontrados: 1</div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="6%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="47%" class="columna_subtitulo_resultados"><div align="center">Objeto</div></td>
 
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Ver detalle</div></td>
  </tr>
  
<?
 $busca_item = "select * from (
select consecutivo,objeto_contarto,nombre,valor,tarifas_contrato_id,monto_usd, monto_cop, ROW_NUMBER() OVER(ORDER BY tarifas_contrato_id) AS rownum from $v_t_1  where estado_contrato not in (4)  $complemento   ) as sub
where rownum > $inicio and rownum <= $factor_b ";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){

?>  
  
  <tr class="filas_resultados">
    <td class="filas_resultados"><?=numero_cotnrato_tarifas($ls_mr[4]);?></td>
    <td class="filas_resultados"><?=$ls_mr[1];?></td>

    <td class="titulos_resumen_alertas"><div align="center">
 
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick="taer_menu('../aplicaciones/tarifas/proveedor/menu_v_contratos.php?id_contrato=<?=arreglo_pasa_variables($ls_mr[4]);?>','contenido_menu');" /></div></td>
  </tr>
  
  <? } ?>
  
  <tr>
    <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
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
