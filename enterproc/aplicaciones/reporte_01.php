<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");


if($id_urna_v!="")
	{
		$completo_sql.= " and consecutivo like '%$id_urna_v%'";
		}

if($id_urna_v!="")
	{
		$completo_sql.= " and consecutivo like '%$id_urna_v%'";
		}
if($k>=1)
	{
		$completo_sql.= " and us_id_contacto = $k";
		}
if($no_pedido_u!="")
	{
		$completo_sql.= " and documento like '%$no_pedido_u%'";
		}

if($proveedor_urna!="")
	{
		$completo_sql.= " and razon_social like '%$proveedor_urna%'";
		}


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">REPORTE: Pedido SIN VISUALIZACI&Oacute;N en la Urna Virtual por parte del proveedor</td>
  </tr>
</table>

<div id="carga_detalle_reporte">
<table width="98%" border="0">
  <tr>
    <td colspan="4" >FILTROS DE REPORTE</td>
  </tr>
  <tr>
    <td width="24%" align="right">Proceso SGPA:</td>
    <td width="25%"><label for="textfield"></label>
    <input type="text" name="textfield" id="textfield"></td>
    <td width="18%" align="right">ID Urna Virtual:</td>
    <td width="33%"><input name="id_urna_v" type="text" id="id_urna_v" value="<?=$id_urna_v;?>"></td>
  </tr>
  <tr>
    <td align="right">Nombre Responsable del Proceso:</td>
    <td><select name="k" id="k">
      <?=listas_mayus($t1, " tipo_usuario <> 2 and tipo_usuario <> 10 and us_id <> 597 and estado =1",$k,'nombre_administrador', 1);?>
    </select></td>
    <td align="right"># SLPD / #ID Contrato:</td>
    <td><input type="text" name="textfield3" id="textfield3"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"># Pedido:</td>
    <td><input name="no_pedido_u" type="text" id="no_pedido_u" value="<?=$no_pedido_u;?>"></td>
  </tr>
  <tr>
    <td align="right">Nombre Proveedor:</td>
    <td colspan="3"><input name="proveedor_urna" type="text" id="proveedor_urna" value="<?=$proveedor_urna;?>"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input name="button" type="button" class="buscar" id="button" value="Realizar busqueda" onClick="javascript:busqueda_paginador_nuevo_varios_campos(1,'../aplicaciones/reporte_01.php','contenidos', '6')"></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="titulo_tabla_azul_sin_bordes">
    <td width="6%">&nbsp;</td>
    <td width="9%" height="38"># Proceso SGPA</td>
    <td width="10%">ID Urna Virtual</td>
    <td width="17%">Nombre Responsable del Proceso</td>
    <td width="15%"># SLPD / #ID Contrato</td>
    <td width="8%"># Pedido</td>
    <td width="18%">Nombre Proveedor</td>
    <td width="8%">Fecha Adjudicaci&oacute;n</td>
    <td width="9%"># d&iacute;as vencidos (visualizaci&oacute;n)</td>
  </tr>
  
  <?
  	$busca_lista_r1 = "select pro1_id,cd_id_entrega_documentos,consecutivo,nombre_administrador, documento,razon_social,fecha_envio,DATEDIFF('$fecha',fecha_envio), pro27_id from v_urna_reporte_adjudicacion_r1 where tp3_id = 1 and acepta_terminos < 1 $completo_sql and pro31_id is NULL order by pro27_id";
	$sql_ex = query_db($busca_lista_r1);
	while($lista_r1 = traer_fila_row($sql_ex)){
		
		 if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
  ?>
 <div >
  <tr class="<?=$class;?>" id="lista_resultado_<?=$lista_r1[8];?>">
    <td><img src='../imagenes/botones/alerta.png' title='Ingresar Proceso' width='16' height='16' onclick='javascript:ajax_carga("../aplicaciones/evaluacion/resumen_adjudicacion_urna_reporte.php?id_p=<?=$lista_r1[0];?>","carga_detalle_adjudicacion");oculta_respuestas_adjudi("carga_detalle_reporte");ver_respuestas_adjudi("carga_detalle_adjudicacion")'/>
    <img src="../imagenes/botones/2.gif" width="16" height="16" onClick="ver_respuestas('carga_obser_cierre_<?=$lista_r1[0];?>')"></td>
    <td align="right"><?=$lista_r1[1];?></td>
    <td align="right"><?=$lista_r1[2];?></td>
    <td align="right"><?=$lista_r1[3];?></td>
    <td align="right"><?=$lista_r1[0];?></td>
    <td align="right"><?=$lista_r1[4];?></td>
    <td align="right"><?=$lista_r1[5];?></td>
    <td align="center"><?=$lista_r1[6];?></td>
    <td align="center"><?=$lista_r1[7];?></td>
  </tr>
  <tr class="<?=$class;?>" id="lista_resultado2_<?=$lista_r1[8];?>">
    <td colspan="9"><div id="carga_obser_cierre_<?=$lista_r1[0];?>" style="display:none"  >
      
      <table width="98%" border="0">
        <tr>
          <td colspan="3" class="titulos_evaluacion">Cierre del pedido</td>
          </tr>
        <tr>
          <td width="21%" align="right">Estado:</td>
          <td width="29%">
           <select name="estado_ad_<?=$lista_r1[8];?>" id="estado_ad_<?=$lista_r1[8];?>">
            <?=listas("tp18_estados_adjudicacion" , " tp18_id >= 3 ",0,'nombre', 1);?>
            </select>
         </td>
          <td width="50%">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">Anexo:</td>
          <td>
            <input type="file" name="anexo_ad_<?=$lista_r1[8];?>" id="anexo_ad_<?=$lista_r1[8];?>">  </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right">Observaciones:</td>
          <td colspan="2">
            <textarea name="observacion_ad_<?=$lista_r1[8];?>" id="observacion_ad_<?=$lista_r1[8];?>" cols="45" rows="5"></textarea></td>
          </tr>
        <tr>
          <td colspan="3" align="center"><input name="button2" type="button" class="guardar" id="button2" value="Guardar cierre de pedido" onClick="cierra_adjudica_reporte(<?=$lista_r1[8];?>)"  >
&nbsp;
<input name="button3" type="button" class="cancelar" id="button3" value="Cerrar respuestas" onClick="oculat_respuestas('carga_obser_cierre_<?=$lista_r1[0];?>')"></td>
          </tr>
      </table>
    </div></td>
  </tr>
  </div>
  <? $num_fila++; } ?>
 <input type="hidden" name="ocu_re">
 <input type="hidden" name="pro1_id_pasa">
</table>
</div>

<div id="carga_detalle_adjudicacion"></div>
 
</body>
</html>
