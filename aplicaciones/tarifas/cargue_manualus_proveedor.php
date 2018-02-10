<? include("../../librerias/lib/@session.php"); 
	

	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: CARGUE DE MANUAL DE USUARIO PARA LOS PROVEEDORES</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="29%" valign="top">
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td width="43%" align="right"  >Seleccione el manual de usuario nuevo:</td>
          <td width="57%"  ><input type="file" name="manual_us" id="manual_us" /></td>
        </tr>
        <tr>
          <td align="right"  >&nbsp;</td>
          <td ><input type="button" name="" value="Cambiar Manual" onclick="cambia_manual_usuario_pro()" /></td>
        </tr>
        
         
     
      </table>      </td>
  </tr>
  <?
  $sel_ultimo_manual = traer_fila_row(query_db("select id, adjunto, fecha, hora, id_us_carga from t6_tarifas_manual_usuario_prov where estado=1"));
  ?>
  <tr>
    <td valign="top" id="carga_acciones_permitidas2"><strong>Manual Actual:</strong>  <?=$sel_ultimo_manual[1];?> <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n1=<?=$sel_ultimo_manual[0]?>&n3=10&n2=<?=$sel_ultimo_manual[1]?>" target="grp"><img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultimo_manual[1])?>.gif" width="16" height="16" /></a> <br />
 <strong>Cargado Por:</strong> <? echo traer_nombre_muestra($sel_ultimo_manual[4], $g1,"nombre_administrador","us_id");?>; el 
  <?=$sel_ultimo_manual[2]." ".$sel_ultimo_manual[3]?>; </td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>

</body>
</html>
