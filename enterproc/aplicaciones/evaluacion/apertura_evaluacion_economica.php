<? include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");
	 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));

	if($_SESSION["id_us_session"]!=1){
	$busca_apertura=traer_fila_row(query_db("select * from $t23 where pro1_id = $id_invitacion and aspecto = 3"));
	if($busca_apertura[0]=="")
	$inserta_apertua=query_db("insert into $t23 (pro1_id,aspecto,fecha_apertura, usuario_apertura) values ($id_invitacion,3,'$fecha $hora',".$_SESSION["id_us_session"].")");
	
	}
	
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">Ofertas econ&oacute;micas recibidas</td>
    <td width="17%">
      <div align="left">
        <input name="button" type="button" class="cancelar" id="button" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
        </div>        </td></tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="4" class="columna_titulo_resultados">Reportes disponibles para su an&aacute;lisis</td>
              </tr>
              <tr>
                <td width="3%" class="columna_subtitulo_resultados">&nbsp;</td>
                <td width="24%" class="columna_subtitulo_resultados">Reporte</td>
                <td width="54%" class="columna_subtitulo_resultados">Interpretaci&oacute;n</td>
                <td width="19%" class="columna_subtitulo_resultados">&nbsp;</td>
              </tr>
              
    
  <tr>
  
                <td><img src="../imagenes/botones/abre.png" alt="reporte" width="22" height="22"></td>
                <td>Oferta total econ&oacute;mica detallada</td>
                <td>Muestra las ofertas recibidas de todos los oferentes en un solo listado por lista</td>
                <td><div align="center">
                  <input name="button3" type="button" class="buscar_ajustado" id="button3" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min','carga_resultados_principales')" value="Ingresar al reporte" />
    </div></td>
  </tr>
  <tr class="campos_gris_listas">
    <td><img src="../imagenes/botones/abre.png" alt="reporte" width="22" height="22"></td>
    <td>Consolidado de ofertas</td>
    <td>Muestra el consolidado de las ofertas recibidas por lista.</td>
    <td><input name="button2" type="button" class="buscar_ajustado" id="button2" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico4.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min','carga_resultados_principales')" value="Ingresar al reporte" /></td>
  </tr>
  <tr>
    <td><img src="../imagenes/botones/abre.png" alt="reporte" width="22" height="22"></td>
    <td>Ofertas consolidas por proveedor</td>
    <td>Muestra a los proveedores con sus mejores ofertas recibidas por lista</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="campos_gris_listas">
    <td><img src="../imagenes/botones/abre.png" alt="reporte" width="22" height="22"></td>
    <td>Consolidado de listas</td>
    <td>Muestra el resumen consolidado de las ofertas recibidas por lista y el consolidado total de las listas</td>
    <td><input name="button4" type="button" class="buscar_ajustado" id="button4" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico5.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min','carga_resultados_principales')" value="Ingresar al reporte" /></td>
  </tr>
  </table>

<div id="carga_evaluacion"></div>
</body>
</html>
