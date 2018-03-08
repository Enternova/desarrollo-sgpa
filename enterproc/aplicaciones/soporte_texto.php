<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


//paguinacion
if($b_rozon!="")
	$comlem = " and razon_social like '%$b_rozon%'";
if($b_contacto!="")
	$comlem .= " and nombre_solicita like '%$b_contacto%'";

if($b_email!="")
	$comlem .= " and email like '%$b_email%'";

if($b_detalle!="")
	$comlem .= " and mensaje like '%$b_detalle%'";

if ( ($b_solicitud!="0") && ($b_solicitud!="") )
	$comlem .= " and tp17_id = $b_solicitud";

if($b_estado=="") 
	$comlem.= " and resuelto = 1";
	
if( ($b_estado!="3") && ($b_estado!="") )
	$comlem.= " and resuelto = $b_estado";
if( ($b_estado=="3") && ($b_estado!="") )
	$comlem.= " and resuelto >= 1";

	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<? 
	$titulo_histo="SECCION: ALERTA DE SOPORTE TECNICO";
?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos"><?=$titulo_histo;?></td>
  </tr>
</table>
<br />

<table width="98%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados">BUSCADOR DE SOLICITUDES DE SOPORTE TECNICO</td>
  </tr>
  <tr>
    <td width="22%" align="right"><strong>Raz&oacute;n social:</strong></td>
    <td width="38%"><input type="text" name="b_rozon" id="b_rozon"  value="<?=$b_rozon;?>" /></td>
    <td width="13%" align="right"><strong>Contacto:</strong></td>
    <td width="27%"><input type="text" name="b_contacto" id="b_contacto"   value="<?=$b_rozon;?>"/></td>
  </tr>
  <tr>
    <td align="right"><strong>Email:</strong></td>
    <td><input type="text" name="b_email" id="b_email"   value="<?=$b_rozon;?>"/></td>
    <td align="right"><strong>Esatado:</strong></td>
    <td><select name="b_estado" id="b_estado">
      <option value="1" <? if($b_estado==1) echo "selected" ?>>Activo</option>
      <option value="2" <? if($b_estado==2) echo "selected" ?>>Cerrado</option>
      <option value="3" <? if($b_estado==3) echo "selected" ?>>Todos</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><strong>Tipo de solicitud:</strong></td>
    <td><select name="b_solicitud" id="b_solicitud" >
      <?=listas("t1_categoria_help"," tipo = 1 ",$b_solicitud,'nombre',1);?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>Palabra clave en el detalle:</strong></td>
    <td colspan="3"><textarea name="b_detalle" id="b_detalle" cols="45" rows="5"><?=$b_detalle;?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input name="button" type="button" class="buscar" id="button" value="Buscra solicitudes de soporte" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/soporte_texto.php','contenidos')" /></td>
  </tr>
</table>
<br />
	
<table width="99%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"></div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="253" class="columna_subtitulo_resultados"><div align="center">Raz&oacute;n social</div></td>
          <td width="151" class="columna_subtitulo_resultados"><div align="center">Contacto</div></td>
          <td width="97" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
          <td width="338" class="columna_subtitulo_resultados"><div align="center">Detalle</div></td>
          <td width="107" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
              </tr>
              <?  
              
                $busca_procesos = "select *
                 from help_solicitudes where  help_id >= 1 $comlem 	";
                $sql_ex = query_db($busca_procesos);
                while($ls=traer_fila_row($sql_ex)){
            
                      if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
            
              ?>
        <tr class="<?=$class;?>">
         		 <td ><?=$ls[1];?> </td>
                <td><?=$ls[2];?></td>
                <td><?=fecha_for_hora($ls[8]);?></td>
                <td><?=$ls[6];?></td>
                <td><input name="button4" type="button" class="buscar" id="button4" value="Ingresar" onclick="ajax_carga('../aplicaciones/c_soporte_tetnico.php?id_soporte_pasa=<?=$ls[0];?>','contenidos')" /></td>
        </tr>
              <tr class="<?=$class;?>">
                <td colspan="3"></td>
                <td colspan="2" id="contrase_<?=$ls[0];?>"></td>
              </tr>
              <? $num_fila++; $encontrados++; 
              }// while
              
               ?>
               </table>
</td>
               </tr>
  <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left">Procesos activos encontrados:
          <?=$encontrados;?>
        </div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
            </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/alerta_bitacora.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>

<div id="abre_procesos_generales"></div>
<input type="hidden" name="id_limpia" />
</body>
</html>
