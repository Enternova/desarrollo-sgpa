<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: ADMINISTRACION EVALUADOR</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="29%" valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        
        <tr>
          <td><ul>			
			<li  onclick="ajax_carga('../aplicaciones/contratos/evaluador/criterios.php','carga_acciones_permitidas')">Criterios</li>
            <li  onclick="ajax_carga('../aplicaciones/contratos/evaluador/h_pregunta_informativa.php','carga_acciones_permitidas')">Preguntas Informativas</li>
            <li  onclick="ajax_carga('../aplicaciones/contratos/evaluador/h_plantilla.php','carga_acciones_permitidas')">Plantillas HSE</li>
            <li  onclick="ajax_carga('../aplicaciones/contratos/evaluador/criterios_hse.php','carga_acciones_permitidas')">Criterios HSE</li>
			
            
            </ul>
          </td>
        </tr>
      </table>      </td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" >&nbsp;</td>
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
