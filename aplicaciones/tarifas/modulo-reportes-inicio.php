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
    <td class="titulos_secciones">SECCION: REPORTES</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="29%" valign="top">
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td class="fondo_2">Reportes permitidos</td>
        </tr>
        <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/h_prefactura_prove_reporte.php','contenidos')" style="cursor:pointer" >
          <ul>
            <li>Reporte de Tiquetes de Servicio en Firme, generados por los proveedores          </li>
          </ul></td>
        </tr>
        
        
 <tr>
          <td onclick="ajax_carga('../aplicaciones/tarifas/h_reembolsables_prove_reporte.php','contenidos')"  style="cursor:pointer">
          <ul>
            <li>Reporte de Tiquetes de Reembolsables en Firme, generados por los proveedores          </li>
          </ul></td>
        </tr>
        
          <?
        if($_SESSION["id_us_session"]==17968){
	   ?>      
        
       
 <tr>
   <td onclick="ajax_carga('../aplicaciones/tarifas/r-pendientes-aprobacion.php','contenidos')"  style="cursor:pointer"><ul>
            <li>Contratos con tarifas pendientes de aprobaci&oacute;n</li>
          </ul></td>
 </tr>
 
 <tr>
   <td onclick="ajax_carga('../aplicaciones/tarifas/r-sin-tarifas.php','contenidos')"  style="cursor:pointer"><ul>
            <li>Contratos parciales con tarifas pendientes de aprobaci&oacute;n</li>
          </ul></td>
 </tr>



 <?
		}
		
		$sel_permiso = traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (1, 2, 13, 17, 6, 23)"));
 	if( ($sel_permiso[0]>0)){
 
 ?>   

 <tr>
   <td onclick="ajax_carga('../aplicaciones/tarifas/reporte_tarifas_especificas.php','contenidos')"  style="cursor:pointer"><ul>
            <li>Reporte de Tarifas Especificas</li></ul></td>
 </tr>
 
  
  <? } ?>
     
      </table>      </td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas">&nbsp;</td>
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
