<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="formulario" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2">
    <div  class="fondo_cabecera">
    <table width="100%" border="0" cellspacing="2" cellpadding="2" >
      <tr>
        <td width="19%"><img src="../../imagenes/coorporativo/logo-cliente-blanco.jpg" width="179" height="63" /></td>
        <td width="50%" valign="middle" align="left" class="titulo_menu_tarifas">MODULO: GESTION Y SEGUIMIENTO DE TARIFAS</td>
        <td width="31%" valign="top" align="right">          Usuario conectado: Rene Sterling Neira<br />
          Perfil del usuario: Super usuario<br />
          Fecha y hora actual: 10 de Sep de 2012</td>
      </tr>
    </table>
    </div>
    </td>
  </tr>
  <tr>
    <td width="19%" valign="top">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="ajax_carga('alertas.php','div_contenidos_carga')">Alertas</td>
        </tr>
        <tr>
          <td class="fondo_1" align="center">2</td>
          <td class="fondo_2" onclick="ajax_carga('creacion-item-pecc.php','div_contenidos_carga')">Creaci&oacute;n de ITEM</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2"  onclick="ajax_carga('historico.php','div_contenidos_carga')">Historico de ITEM</td>
        </tr>
        <tr>
          <td class="fondo_1" align="center">2</td>
          <td class="fondo_2" onclick="ajax_carga('creacion-item-pecc.php','div_contenidos_carga')">Creaci&oacute;n de ITEM-PECC</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">3</div></td>
          <td class="fondo_2"  onclick="ajax_carga('historico.php','div_contenidos_carga')">Historico de ITEM-PECC</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">4</div></td>
          <td class="fondo_2">Auditoria</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">5</div></td>
          <td class="fondo_2">Volver al inicio</td>
        </tr>
    </table></td>
    <td width="81%" valign="top" >
    
    
    
    <div  class="div_contenidos">
    <div id="div_contenidos_carga">
    <div class="titulos_secciones">SECCION: ALERTAS</div><BR />
   
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
       
      </table>
  		<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
          <tr>
            <td colspan="9" class="columna_titulo_resultados">
            
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                <tr>
                  <td width="72%"><div align="left">Alertas encontradas: 3</div></td>
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
            <td width="2%" height="29" rowspan="2" class="columna_subtitulo_resultados">&nbsp;</td>
            <td width="6%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Numero</div></td>
            <td width="11%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Inicio Estimado</div></td>
            <td width="7%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Inicio Real</div></td>
            <td width="10%" rowspan="2" class="columna_subtitulo_resultados">Fecha del Requerimiento</td>
            <td width="9%" rowspan="2" class="columna_subtitulo_resultados"><div align="center">Tipo de Proceso</div></td>
            <td width="42%" rowspan="2" class="columna_subtitulo_resultados">Objeto</td>
            <td colspan="2" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
            </tr>
          <tr>
            <td width="7%" class="columna_subtitulo_resultados">Tipo</td>
            <td width="6%" class="columna_subtitulo_resultados">Dias</td>
          </tr>
          <tr class="filas_resultados">
            <td ><a href="javascript:ajax_carga('edicion-item-pecc.php?id_pecc=3','div_contenidos_carga')"><img src="../../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
            <td>P120001</td>
            <td >02-ene-13</td>
            <td>---</td>
            <td>23-jun-13</td>
            <td>Invitaci&oacute;n a Proponer</td>
            <td>Contrataci&oacute;n de prueba para la construcci&oacute;n de una carreta de 80Km</td>
            <td>Negociaci&oacute;n</td>
            <td>95</td>
          </tr>
          <tr class="<?=$class;?>">
            <td><img src="../../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
            <td>P120002</td>
            <td >02-feb-13</td>
            <td>---</td>
            <td>23-jun-13</td>
            <td>Invitaci&oacute;n a Proponer</td>
            <td>Contrataci&oacute;n de prueba para la exploraci&oacute;n de un campo</td>
            <td>Negociaci&oacute;n</td>
            <td>105</td>
          </tr>
          <tr class="filas_resultados">
            <td><img src="../../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></td>
            <td>P120003</td>
            <td >25-feb-13</td>
            <td>---</td>
            <td>26-jul-13</td>
            <td>Invitaci&oacute;n a Proponer</td>
            <td>Contrataci&oacute;n de prueba para el mantenimiento de equipos de excavaci&oacute;n</td>
            <td>Negociaci&oacute;n</td>
            <td>130</td>
          </tr>
          <tr class="<?=$class;?>">
            <td colspan="6"></td>
            <td id="contrase_<?=$ls[0];?>"></td>
            <td id="contrase_<?=$ls[0];?>"></td>
            <td id="contrase_<?=$ls[0];?>"></td>
          </tr>
        
          <tr>
            <td colspan="9" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                <tr>
                  <td width="72%"><div align="left">Alertas encontradas: 3</div></td>
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
  		
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    



    
    </td>
  </tr>
</table>

     <div  class="fondo_cabecera">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="../../imagenes/coorporativo/logo final-01.png" width="133" height="36" /></td>
          <td>Si tiene problemas con la funcionabilidad del sistema por favor comun&iacute;quese al PBX (57 1 548 1726),
Dise&ntilde;ado y Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</form>
</div>
</body>
</html>
