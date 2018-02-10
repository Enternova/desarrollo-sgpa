<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<div class="titulos_secciones">SECCION: INBOX</div>
<br />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/aviso_observaciones.png" width="16" height="16" /></td>
    <td><strong>ATENCION:</strong></td>
  </tr>
  <tr>
    <td width="3%">&nbsp;</td>
    <td width="97%" class="titulos_resumen_alertas">Usted tiene 2 aprobaciones pendiente por nuevas tarifas, presione aqu&iacute; para listarlas a continuaci&oacute;n.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="titulos_resumen_alertas">Usted tiene 1 aprobaciones pendiente por modificaci&oacute;n de tarifas, presione aqu&iacute; para listarlas a continuaci&oacute;n.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="titulos_resumen_alertas">Usted tiene 1 notifiaci&oacute;n sin leer, presione aqu&iacute; para listarlas a continuaci&oacute;n.</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="72%"><div align="left">Alertas encontradas: 5</div></td>
        <td width="9%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="9%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="3%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Asunto</div></td>
    <td width="42%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="29%" class="columna_subtitulo_resultados"><div align="center">Proveedor / Contratista</div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
  </tr>
  <tr class="filas_resultados">
    <td ><a href="javascript:ajax_carga('../aplicaciones/tarifas/v_contratos.php?i=1','contenidos')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
    <td >Aprobaci&oacute;n nueva tarifa </td>
    <td>El proveedor / contratista ingreso una nueva tarifa y esta pendiente de aprobaci&oacute;n</td>
    <td>C12-001</td>
    <td>Enternova S.A.S.</td>
    <td>9  Sep  2012</td>
  </tr>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
    <td >Aprobaci&oacute;n modificaci&oacute;n tarifa </td>
    <td>El proveedor / contratista modifico una tarifa y esta pendiente de aprobaci&oacute;n</td>
    <td>C12-002</td>
    <td>Enternova S.A.S.</td>
    <td>9  Sep  2012</td>
  </tr>
  <tr class="filas_resultados">
    <td><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
    <td >Aprobaci&oacute;n nueva tarifa </td>
    <td>El proveedor / contratista ingreso una nueva tarifa y esta pendiente de aprobaci&oacute;n</td>
    <td>C12-003</td>
    <td>Enternova S.A.S.</td>
    <td>9  Sep  2012</td>
  </tr>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
    <td >lectura de notificaci&oacute;n</td>
    <td>Notificaci&oacute;n de creaci&oacute;n de contrato y esta pendiente de ingresar las tarifas</td>
    <td>C12-002</td>
    <td>Enternova S.A.S.</td>
    <td>9  Sep  2012</td>
  </tr>
  <tr class="filas_resultados">
    <td><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
    <td >lectura de notificaci&oacute;n</td>
    <td>Notificaci&oacute;n de creaci&oacute;n de contrato y esta pendiente de ingresar las tarifas</td>
    <td>C12-003</td>
    <td>Enternova S.A.S.</td>
    <td>9  Sep  2012</td>
  </tr>
  <tr class="<?=$class;?>">
    <td colspan="5"></td>
    <td id="contrase_<?=$ls[0];?>"></td>
  </tr>
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="72%"><div align="left">Alertas encontradas: 5</div></td>
        <td width="9%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
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
        <td width="9%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
