<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	
	   
	if($clave_detalle!="")
		$complemneto = " and detalle like '$clave_detalle'";
	if($proveedor!="")
		$complemneto.= " and razon_social like '$proveedor'";
	if($numero_contrato!="")
		$complemneto.= " and consecutivo like '$numero_contrato'";

	if($con_relacion=="0")  
		$complemneto.= " and estado_relacion is NULL ";		

	if($con_relacion=="1")  
		$complemneto.= " and estado_relacion = 1 ";		
	if($con_relacion=="2")  
		$complemneto.= " and estado_relacion = 2 ";		
	if($con_relacion=="3")  
		$complemneto.= " and estado_relacion = 3 ";		
		
		
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>

<body>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION: RELACION DE TARIFAS CON TARIFAS MAESTRAS</td>
    <td width="9%" class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="fondo_2_sub">Buscador de tarifas</td>
  </tr>
  <tr>
    <td colspan="4"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /> Busque las tarifas ingresadas a los contratos para relacionar con las tarifas maestras</td>
  </tr>
  <tr>
    <td width="37%"><div align="right"><strong>Palabra clave nombre generico del producto /servicio:</strong></div></td>
    <td width="36%"><input type="text" name="clave_detalle" id="clave_detalle" value="<?=$clave_detalle;?>" /></td>
    <td width="13%"><div align="right"><strong>Numero de contrato:</strong></div></td>
    <td width="14%"><input type="text" name="numero_contrato" id="numero_contrato"  value="<?=$numero_contrato;?>"/></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Proveedor:</strong></div></td>
    <td><input type="text" name="proveedor" id="proveedor"   value="<?=$proveedor;?>"/></td>
    <td><div align="right"><strong>Relacionadas:</strong></div></td>
    <td><select name="con_relacion" id="con_relacion">
      <option value="10" <? if($con_relacion==10) echo "selected"; ?>>Todas</option>
      <option value="0" <? if($con_relacion==0) echo "selected"; ?> >No</option>
      <option value="1" <? if($con_relacion==1) echo "selected"; ?>>Si confirmadas</option>
      <option value="2" <? if($con_relacion==2) echo "selected"; ?>>Si no confirmadas</option>      
      <option value="3" <? if($con_relacion==3) echo "selected"; ?>>Eliminadas no confirmadas</option>            
      
    </select>
</td>
  </tr>
  <tr>
    <td colspan="4"><div align="center"><input type="button" name="button" class="boton_buscar" id="button" value="Buscar tarifas para relacionar" onclick="busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/tarifas_maestras/relacion_tarifas_maestras.php','contenidos')" /></div></td>
  </tr>

</table>

<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<tr>
  <td colspan="2" class="fondo_2_sub">Buscador de tarifas maestras</td>
  </tr>
<tr>
  <td><div align="right"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></div></td>
  <td> Si desea relacionar varias tarifas, usted puede buscar la tarifa maestra a continuaci&oacute;n luego seleccione las tarifas encontradas y presione el bot&oacute;n confirmar relaci&oacute;n de tarifas.</td>
</tr>
<tr>
            <td width="24%"><div align="right"><strong>Buscador de tarifas maestras:</strong></div></td>
            <td width="76%"><input type="text" name="busca_tarifas_maestras_p" id="busca_tarifas_maestras_p" value="<?=$categoria;?>" onclick="document.principal.requiere_funcion.value='2'" onkeypress="selecciona_lista('busca_tarifas_maestras_p')"  /></td>
            </tr>
        </table>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="3%"><div align="center"><img src="../imagenes/botones/relacionada.png" alt="Seleccionada" width="24" height="24" longdesc="Seleccionada" /></div></td>
    <td width="97%">Se refiere a las tarifas relecionadass con las tarifas maestras y estan confirmadas.</td>
  </tr>
  <tr>
    <td><div align="center"><img src="../imagenes/botones/seleccionada_temporal.png" alt="Seleccionada sin confirmar" width="24" height="24" longdesc="Seleccionada sin confirmar" /></div></td>
    <td>Se refiere a las tarifas relecionas con las tarifas maestras y estan sin confirmaci&oacute;n.</td>
  </tr>
  <tr>
    <td><div align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="Eliminada si confirmar"  longdesc="Eliminada si confirmar" /></div></td>
    <td>Se refiere a las tarifas que estaban relacionadas y se elimino pero estan sin confirmaci&oacute;n.</td>
  </tr>
  <tr>
    <td><img src="../imagenes/botones/sin_relacion.png" alt="Sin relaci&oacute;n" width="24" height="24" longdesc="Sin relaci&oacute;n" /></td>
    <td>Se refiere a las tarifas que no tiene relaciones con las tarifas maestras.</td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="tabla_paginador">
    <td colspan="6" class="fondo_2_sub">Resultado de la busqueda</td>
  </tr>
  <tr class="tabla_paginador">
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Tarifas encontrados: 4</div></td>
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
    <td width="2%" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="2%" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="8%" class="columna_subtitulo_resultados"><strong>Contrato</strong></td>
    <td width="21%" class="columna_subtitulo_resultados"><strong>Proveedor</strong></td>
    <td width="35%" class="columna_subtitulo_resultados"><strong>nombre generico del producto /servicio</strong></td>
    <td width="32%" class="columna_subtitulo_resultados"><strong>Buscar tarifa maestra</strong></td>
  </tr>
  <?
  $auntemta=9;
 $busca_tarifas="select tarifas_contrato_id, tarifa_padre, consecutivo, razon_social, nombre_lista,categoria, grupo, detalle, unidad_medida, nombre_moneda, valor_tarifa , fecha_inicio_vigencia,fecha_fin_vigencia,tipo_creacion
  from $v_t_7 where t6_tarifas_estados_tarifas_id = 1 $complemneto";
  $sql_ex_lista=query_db($busca_tarifas);
  while($lis_tarifa=traer_fila_row($sql_ex_lista)){//while tarfisa
 
 $busca_relaciones = traer_fila_row(query_db("select * from $t11 where t6_tarifas_lista_padre_id = $lis_tarifa[1] order by t6_tarifas_maestras_relacion_tarifas_id desc")); 
 if($busca_relaciones[0]>=1){
 	

		 $lista_inci = "select  t6_tarifas_maestras_lista_id , categoria_maestra + ' => ' + sub_categoria_maestra + ' => ' + nombre_lista_maestra  from $v_t_8  where t6_tarifas_maestras_lista_id = $busca_relaciones[1]  order by categoria_maestra, sub_categoria_maestra,  nombre_lista_maestra ";
		 $sql_ex=query_db($lista_inci);
			$lt=traer_fila_row($sql_ex);
			$tarifa_maestra= $lt[1]."----,".$lt[0]."----, ";
			if($busca_relaciones[3]==1){ $che = "checked";
				 $tipo_relacion='<img src="../imagenes/botones/relacionada.png" alt="Seleccionada"  longdesc="Seleccionada" />';
				 }
			elseif($busca_relaciones[3]==2){ $che = "checked";
				 $tipo_relacion='<img src="../imagenes/botones/seleccionada_temporal.png" alt="Seleccionada sin confirmar" width="24" height="24" longdesc="Seleccionada sin confirmar" />';
				 }
			elseif($busca_relaciones[3]==3){ $che = "";
				 $tipo_relacion='<img src="../imagenes/botones/eliminada_temporal.gif" alt="Eliminada si confirmar"  longdesc="Eliminada si confirmar" />';
				 }

	}
	else{
	 $che = "";
	 $tarifa_maestra="";
	 $tipo_relacion='<img src="../imagenes/botones/sin_relacion.png" alt="Sin relación" width="24" height="24" longdesc="Sin relación" />';
	 }
  	
						     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
							
  ?>
  
  <tr class="<?=$class;?>">
    <td><?=$tipo_relacion;?></td>
    <td><input <?=$che;?> type="checkbox" name="selecion[]" id="selecion[]"  value="<?=$lis_tarifa[1];?>"  onclick="crea_relacion_uno_uno(this.checked,<?=$lis_tarifa[1];?>)"/></td>
    <td><?=$lis_tarifa[2];?></td>
    <td><?=$lis_tarifa[3];?></td>
    <td><?=$lis_tarifa[7];?></td>
    <td><input type="text" name="tarifa_maestra_uni_<?=$lis_tarifa[1];?>" id="tarifa_maestra_uni_<?=$lis_tarifa[1];?>"  onclick="sinseleccionar_click(<?=$auntemta;?>,<?=$lis_tarifa[1];?>)" onkeypress="selecciona_lista('tarifa_maestra_uni_<?=$lis_tarifa[1];?>')" onchange="sin_seleccionar_borrar(<?=$auntemta;?>, <?=$lis_tarifa[1];?>, this.value)" value="<?=$tarifa_maestra;?>"/></td>
  </tr>
  <? $num_fila++;
  	$auntemta+=2;
  }//while tarfisa ?>
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Tarifas encontrados: 4</div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagina2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">
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
</table>
<br />
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2"><p><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /> Las tarifas seleccionadas se guardaran temporalmente con solo seleccionarlas tenga en cuenta lo siguiente:</p>
      <ul>
        <li>Para confirmar la relaci&oacute;n de las tarifas seleccionadas presione el bot&oacute;n &quot;Confirmar relaci&oacute;n de tarifas&quot;</li>
        <li>Usted podra presionar este bot&oacute;n en cualquier momento incluso en una nueva vistita, la selecci&oacute;n no se perdera</li>
        <li>Para borra la selecci&oacute;n presione el bot&oacute;n &quot;Borrar selecci&oacute;n historica&quot;</li>
        <li>Para eliminar una relaci&oacute;n desmarque la tarifa y presione el bot&oacute;n &quot;Confirmar relaci&oacute;n de tarifas&quot;</li>
    </ul></td>
  </tr>
  <tr>
    <td><div align="center"><input type="button" name="button2" class="boton_grabar" id="button2" value="Confirmar relaci&oacute;n de tarifas" onclick="confirmar_tarifas_relacion()" /></div></td>
    <td><div align="center"><input type="button" name="button3" class="boton_eliminar" id="button3" value="Borrar selecci&oacute;n historica" onclick="borra_historico_tarifas()" /></div></td>
  </tr>
</table>
<input type="hidden" name="requiere_funcion">

<input type="hidden" name="nombre_tarifa_seleccionada">
<input type="hidden" name="tarifa_aumenta">
<input type="hidden" name="tarifa_seleccionada">
</body>
</html>
