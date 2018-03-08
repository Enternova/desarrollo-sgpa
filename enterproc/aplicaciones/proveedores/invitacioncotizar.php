<?
include("../../librerias/lib/session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

	$lista_licitaciones = "select * from $t55 where in_id = $id_invitacion";
	$linvi=traer_fila_row(query_db($lista_licitaciones));
	
	if($linvi[14]>=2)
			$bloquea = "readonly";

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/general.css" rel="stylesheet" type="text/css">
<link href="../../css/css_parservicios.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr> 
      
    <td class="titulosec"> INVITACI&Oacute;N A COTIZAR</td>
    </tr>
  </table>  
  
<table width="1000" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr > 
    <td width="15%">&nbsp;</td>
  </tr>
</table>
<table width="1000" border="0" align="center" cellpadding="3" cellspacing="3" class="administrador_tabla_generales">
  <tr> 
    <td colspan="4" class="administrador_tabla_titulo">INFORMACI&Oacute;N DEL PROCESO  DE LA INVITACION 
      A COTIZAR</td>
  </tr>
  <tr> 
    <td width="21%" class="administrador_contenido_celdas"> <div align="right"><strong>C&oacute;digo 
        de la petici&oacute;n de oferta:</strong></div></td>
    <td width="29%" class="administrador_contenido_celdas">
      <?=$linvi[4];?>
    </td>
    <td width="13%" class="administrador_contenido_celdas"><div align="right"><strong>Nombre 
        de la petici&oacute;n de oferta:</strong></div></td>
    <td width="37%" class="administrador_contenido_celdas">
      <?=$linvi[5];?>
    </td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas"> <div align="right"><strong>Fecha 
        y Hora Apertura Ofertas:</strong></div></td>
    <td class="administrador_contenido_celdas"> <strong> 
      <?=$linvi[6];?>
      </strong></td>
    <td class="administrador_contenido_celdas"><div align="right"><strong>Nombre 
        de la petici&oacute;n de oferta:</strong></div></td>
    <td class="administrador_contenido_celdas">
      <?=$linvi[8];?>
    </td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas"> <div align="right"><strong>Fecha 
        Reuni&oacute;n Informativa :</strong></div></td>
    <td class="administrador_contenido_celdas"> <strong> 
      <?=$linvi[7];?>
      </strong></td>
    <td class="administrador_contenido_celdas"><div align="right"><strong>Lugar 
        de la Reuni&oacute;n</strong>:</div></td>
    <td class="administrador_contenido_celdas">
      <?=$linvi[10];?>
    </td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas"> <div align="right"><strong>Responsable 
        del proceso de la petici&oacute;n de oferta:</strong></div></td>
    <td class="administrador_contenido_celdas"> 
      <?
			$lc = traer_fila_row(query_db("select * from $t1 where us_id = $linvi[9]"));
	        echo $lc[3]; ?>
    </td>
    <td class="administrador_contenido_celdas"><div align="right"><strong>Tipo 
        de moneda :</strong></div></td>
    <td class="administrador_contenido_celdas"> 
      <?
			$lc = traer_fila_row(query_db("select * from $t38 where tp6_id  = $linvi[3]"));
	        echo $lc[1]; ?>
    </td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas"> <div align="right"><strong>Objeto 
        de la petici&oacute;n de oferta </strong>:</div></td>
    <td colspan="3" rowspan="3" class="administrador_contenido_celdas">
      <?=$linvi[11];?>
    </td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas"> <div align="right"></div></td>
  </tr>
  <tr> 
    <td class="administrador_contenido_celdas">&nbsp;</td>
  </tr>
</table>
<br>
<table width="1000" border="0" align="center" cellpadding="3" cellspacing="3" class="administrador_tabla_generales">
  <tr> 
    <td width="100%" class="administrador_contenido_celdas"> <table width="84%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr> 
          <td colspan="5" class="titulosec"> Archivos anexos de la invitaci&oacute;n para el proveedor</td>
        </tr>
        <tr class="administrador_tabla_titulo"> 
          <td width="3%">&nbsp;</td>
          <td width="48%">Nombre de los Archivos</td>
          <td width="26%">Fecha de Envio del Comprador</td>
          <td width="12%">Tama&ntilde;o</td>
          <td width="11%">Acciones</td>
        </tr>
        <?
			$busca_respo = query_db("select * from $t58 where in_id = $id_invitacion");
			while($lc=traer_fila_row($busca_respo)){
			$extencion = explode(".",$lc[2]);
		?>
        <tr class="administrador_tabla_generales"> 
          <td><img src="../../imagenes/mime/<?=$extencion[1];?>.gif"></td>
          <td> 
            <?=$lc[2];?>          </td>
          <td> 
            <?=$lc[5];?>          </td>
          <td> 
            <?=number_format($lc[3]/1024,2);?>
            KB</td>
          <td> <div align="center">
              <input name="button" type="button" class="buttonverde" id="button" value="Descargar Archivo" onClick="window.parent.location.href='../generales/complementos/baja_anexo_invita_admin.php?n1=<?=$lc[0];?>&n2=<?=$lc[2];?>'">
              </div></td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
</table>
<br>
<table width="1000" border="0" align="center" cellpadding="3" cellspacing="3" class="administrador_tabla_generales">
  <tr> 
    <td colspan="4" class="administrador_tabla_titulo">RESPUESTA DEL PROVEEDOR</td>
  </tr>
  <tr> 
    <td width="31%" class="administrador_contenido_celdas"> <div align="right"><strong>Seleccionar 
        archivo:</strong></div></td>
    <td width="69%" colspan="3" class="administrador_contenido_celdas"> <input type="file" name="sube_archivo"> 
      <input name="Submit" type="button" class="buttonverde" value="Enviar Archivo al Comprador" onClick="anexa_documento_2()"></td>
  </tr>
  <tr> 
    <td colspan="4" class="administrador_contenido_celdas"> <table width="84%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr> 
          <td colspan="5" class="titulosec"> Archivos anexos de la oferta para el cliente - 
            comprador </td>
        </tr>
        <tr class="administrador_tabla_titulo"> 
          <td width="3%">&nbsp;</td>
          <td width="48%">Nombre de los Archivos</td>
          <td width="26%">Fecha de Envio</td>
          <td width="12%">Tama&ntilde;o</td>
          <td width="11%">Acciones</td>
        </tr>
        <?
			$busca_respo = query_db("select * from $t60 where in_id = $id_invitacion and pv_id = $us_cliente");
			while($lc=traer_fila_row($busca_respo)){
			$extencion = explode(".",$lc[3]);
		?>
        <tr class="administrador_tabla_generales"> 
          <td><img src="../../imagenes/mime/<?=$extencion[1];?>.gif"></td>
          <td> 
            <?=$lc[3];?>
          </td>
          <td> 
            <?=$lc[6];?>
          </td>
          <td> 
            <?=number_format($lc[4]/1024,2);?>
            KB</td>
          <td> <div align="center"><a href='../generales/complementos/baja_anexo_invita_proveedor.php?n1=<?=$lc[0];?>&n2=<?=$lc[3];?>'> 
              <img src="../../imagenes/botones/buscar02.gif"></a> <a href="javascript:elimina_anexo_admin2(<?=$lc[0];?>)"> 
              <img src="../../imagenes/botones/eliminar.gif" width="14" height="13"></a> 
            </div></td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
</table>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="id_anexo">
</body>
</html>
