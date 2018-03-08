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
    <td colspan="4" align="center"><input name="button" type="button" class="buscar" id="button" value="Realizar busqueda" onClick="javascript:busqueda_paginador_nuevo_varios_campos(1,'../aplicaciones/reporte_04.php','contenidos', '6')"></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="titulo_tabla_azul_sin_bordes">
    <td width="6%">&nbsp;</td>
    <td width="7%" height="38"># Proceso SGPA</td>
    <td width="9%">ID Urna Virtual</td>
    <td width="13%"> Responsable del Proceso</td>
    <td width="7%"># SLPD / #ID Contrato</td>
    <td width="5%"># Pedido</td>
    <td width="15%">Nombre Proveedor</td>
    <td width="7%">Fecha Adjudicaci&oacute;n</td>
    <td width="7%">Fecha visualizaci&oacute;n</td>
    <td width="5%">Estatus</td>
    <td width="14%">TextBlog publicado</td>
    <td width="11%">Fecha publicaci&oacute;n</td>
  </tr>
  
  <?
  	$busca_lista_r1 = "select pro1_id,cd_id_entrega_documentos,consecutivo,nombre_administrador, documento,razon_social,fecha_envio,acepta_terminos,fecha_lectura, pregunta, fecha_crea_foro,pro27_id,pro32_id from v_urna_reporte_foros_adjudica where tp3_id = 1 and marca_respuesta = 0 $completo_sql order by fecha_crea_foro desc ";
	$sql_ex = query_db($busca_lista_r1);
	while($lista_r1 = traer_fila_row($sql_ex)){
		
		 if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
	if($lista_r1[7]==0) $estado_acep="Pendiente";
				else
					{
						$busca_estado_ad = "select * from tp18_estados_adjudicacion where tp18_id = $lista_r1[7]";
						$sql_ex_estado = traer_fila_row(query_db($busca_estado_ad ));
						$estado_acep = $sql_ex_estado[1]; 
					}				
				
		
  ?>
 <div >
  <tr class="<?=$class;?>" id="lista_resultado_<?=$lista_r1[12];?>">
    <td><img src='../imagenes/botones/alerta.png' title='Ingresar Proceso' width='16' height='16' onclick='javascript:ajax_carga("../aplicaciones/evaluacion/resumen_adjudicacion_urna_reporte.php?id_p=<?=$lista_r1[0];?>","carga_detalle_adjudicacion");oculta_respuestas_adjudi("carga_detalle_reporte");ver_respuestas_adjudi("carga_detalle_adjudicacion")'/>
    <img src="../imagenes/botones/2.gif" width="16" height="16" onClick="ver_respuestas('carga_obser_cierre_<?=$lista_r1[0];?>')"></td>
    <td><?=$lista_r1[1];?></td>
    <td><?=$lista_r1[2];?></td>
    <td><?=$lista_r1[3];?></td>
    <td><?=$lista_r1[0];?></td>
    <td><?=$lista_r1[4];?></td>
    <td><?=$lista_r1[5];?></td>
    <td><?=$lista_r1[6];?></td>
    <td><?=$lista_r1[8];?></td>
    <td><?=$staus_acep;?></td>
    <td><?=$lista_r1[9];?></td>
    <td><?=$lista_r1[10];?></td>
  </tr>
  <tr class="<?=$class;?>" id="lista_resultado2_<?=$lista_r1[12];?>">
    <td colspan="10"><div id="carga_obser_cierre_<?=$lista_r1[0];?>" style="display:none"  >
      
      <table width="98%" border="0">
        <tr>
          <td colspan="3" class="titulos_evaluacion">Cierre del pedido</td>
          </tr>
        <tr>
          <td width="21%" align="right">Estado:</td>
          <td width="29%">
           <select name="estado_ad_<?=$lista_r1[12];?>" id="estado_ad_<?=$lista_r1[12];?>">
            <option value="0">Seleccione</option>
            <option value="1">Enviar notificación al proveedor</option>
            <option value="2">NO Enviar notificación al proveedor</option>
            </select>
         </td>
          <td width="50%">&nbsp;</td>
        </tr>
  
        <tr>
          <td align="right">Observaciones:</td>
          <td colspan="2">
            <textarea name="observacion_ad_<?=$lista_r1[12];?>" id="observacion_ad_<?=$lista_r1[12];?>" cols="45" rows="5"></textarea></td>
          </tr>
        <tr>
          <td colspan="3" align="center"><input name="button2" type="button" class="guardar" id="button2" value="Guardar cierre de pedido" onClick="nuevo_ad_foro_reporte(<?=$lista_r1[11];?>,<?=$lista_r1[12];?>)"  >
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
<input type="hidden" name="pro32id_pasa"> 
</table>
</div>

<div id="carga_detalle_adjudicacion"></div>
 
</body>
</html>