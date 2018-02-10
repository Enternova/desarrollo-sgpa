<?   include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) 
	 from $v8 where  estado = 1 $complemento"));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;
	
	
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
	$titulo_histo="SECCION: ALERTA DE BITACORA";
?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos"><?=$titulo_histo;?></td>
  </tr>
</table>
<br />
<? if($tipo_ingreso_alerta=='50'){?>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4" class="titulo_tabla_azul_sin_bordes">Buscador de procesos</td>
  </tr>
  <tr>
    <td width="20%"><div align="right">Tipo de proceso:</div></td>
    <td width="29%"><div align="left">
      <select name="a" id="a">
        <?=listas($tp2, 1,$sql_e[2],'nombre', 1);?>
      </select>
    </div></td>
    <td width="26%"><div align="right">Objeto a contratar:</div></td>
    <td width="25%"><div align="left">
      <select name="c" id="c">
        <?=listas($tp6, 1,$sql_e[11],'nombre', 1);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Tipo de contrato:</div></td>
    <td><div align="left">
      <select name="g" id="g">
        <?=listas($tp5, 1,$sql_e[5],'nombre', 1);?>
      </select>
    </div></td>
    <td><div align="right">R&eacute;gimen de contrataci&oacute;n: </div></td>
    <td><div align="left">
      <select name="b" id="b">
        <?=listas($tp4, 1,$sql_e[4],'nombre', 1);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Fecha de apertura:</div></td>
    <td><div align="left">
      <input type="text" name="i" id="i" onclick="calendario_se('i')" value="<?=$sql_e[17];?>"/>
    </div></td>
    <td><div align="right">Fecha de cierre:</div></td>
    <td><div align="left">
      <input type="text" name="j" id="j" onclick="calendario_se('j')" value="<?=$sql_e[18];?>"/>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Detalle del objeto a contratar:</div></td>
    <td><div align="left">
      <textarea name="d" id="d" cols="30" rows="1"><?=$sql_e[12];?>
    </textarea>
    </div></td>
    <td><div align="right">Persona de contacto:</div></td>
    <td><div align="left">
      <select name="k" id="k">
        <?=listas($t1, 1,$sql_e[15],'nombre_administrador', 1);?>
      </select>
    </div></td>
  </tr>
</table>
<br />
<?
$tipo_ingreso_alerta="0";

if($complemento=="")
	$complemento = " and	$t5.tp1_id not in (5, 7, 8) ";
	

 } // ABRE BUSCADOR

	

 ?>
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
          <td width="230" class="columna_subtitulo_resultados"><div align="center">Alerta</div></td>
          <td width="200" class="columna_subtitulo_resultados"><div align="center">Detalle</div></td>
          <td width="115" class="columna_subtitulo_resultados"><div align="center">Fecha alerta</div></td>
          <td width="52" class="columna_subtitulo_resultados"><div align="center">Proceso</div></td>
          <td width="217" class="columna_subtitulo_resultados"><div align="center">Proveedor</div></td>
          <td width="94" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
              </tr>
              <?  
              
                $busca_procesos = "select pro18_id, pro1_id, nombre, detalle_proceso, fecha_generacion, consecutivo, razon_social,pv_id
                 from $v8 where estado = 1 $complemento order by fecha_generacion desc limit $paginador,$numero_pagi	";
                $sql_ex = query_db($busca_procesos);
                while($ls=traer_fila_row($sql_ex)){
            
                      if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
            
              ?>
        <tr class="<?=$class;?>">
         		 <td ><?=$ls[2];?> </td>
                <td><?=$ls[3];?></td>
                <td><?=fecha_for_hora($ls[4]);?></td>
                <td><?=$ls[5];?></td>
                <td><?=$ls[6];?></td>
                <td><input name="button4" type="button" class="buscar" id="button4" value="Ingresar" onclick="ajax_carga('../aplicaciones/c_bitacora.php?id_invitacion_pasa=<?=$ls[1];?>&pv_id_b=<?=$ls[7];?>','contenidos')" /></td>
        </tr>
              <tr class="<?=$class;?>">
                <td colspan="3"></td>
                <td colspan="3" id="contrase_<?=$ls[0];?>"></td>
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
