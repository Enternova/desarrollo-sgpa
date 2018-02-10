<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

if($_SESSION["tipo_usuario"]==1)
	$complemento = " and $l4.lista4_id >=1 ";
else
	$complemento = " and $l4.us_id =  ".$_SESSION["id_us_session"];



//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) 	 from $l4, $tp10, $t1 where 
	$tp10.tp10_id = $l4.estado and
	$t1.us_id = $l4.us_id $complemento "));
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
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">HISTORICO DE SOLICITUDES CREADAS</td>
  </tr>
</table>

<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4" class="titulo_tabla_azul_sin_bordes">Buscador de procesos</td>
  </tr>
  <tr>
    <td width="33%">Categoria:</td>
    <td width="17%"><div align="left">
      <select name="a" id="a">
        <?=listas($tp2, 1,$sql_e[2],'nombre', 1);?>
      </select>
    </div></td>
    <td width="14%">Estado:</td>
    <td width="36%"><div align="left">
      <select name="c" id="c">
        <?=listas($tp10, 1,$sql_e[11],'nombre', 1);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td>Usuario solicitante:</td>
    <td><div align="left">
      <input name="b_usuarios" type="text" id="b_usuarios" size="50" onkeypress="selecciona_lista()" />
    </div></td>
    <td>Proveedor: </td>
    <td><div align="left">
      <input name="proveedor" type="text" id="proveedor" size="50" onkeypress="selecciona_lista()" />
    </div></td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center">
      <label>
      <input name="button" type="submit" class="buscar" id="button" value="Buscar solicitudes" />
      </label>
    </div></td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="1%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="6%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="4%" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="10%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="11%" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
    <td width="19%" class="columna_subtitulo_resultados"><div align="center">Fecha de solicitud</div></td>
    <td width="19%" class="columna_subtitulo_resultados"><div align="center">Valor de la solicitud</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Cantidad Solicitada</div></td>
    <td width="11%" class="columna_subtitulo_resultados"><div align="center">Responsable</div></td>
    <td width="10%" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
  </tr>
  <?  
  	$busca_procesos = "select $l4.lista4_id, $tp10.nombre, $tp10.tp10_id, $l4.fecha_creacion, $t1.nombre_administrador
	 from $l4, $tp10, $t1 where 
	$tp10.tp10_id = $l4.estado and
	$t1.us_id = $l4.us_id $complemento limit $paginador,$numero_pagi	";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){
	$edicion="";
	$auditor="";
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
	
	if($ls[2]!=4){
		$semaforor_estado = 'acitvo.png';
		}
	else{
		$semaforor_estado = 'cerrada.png';
		}

		$suma_valores = query_db("select valor,cantidad from $l5 where lista4_id  = $ls[0]");

		while($total =  traer_fila_row($suma_valores)){
			$valor_soli+=($total[0]*$total[1]);
			$cantidad+=$total[1];
			}

		if($ls[2]==2)
			$edicion="<img src='../imagenes/botones/editar_c.png' title='Cierra Solicitud' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/lista_precios/cierra_solicitudes.php?id_compra=$ls[0]\",\"contenidos\")'/>";
		elseif($ls[2]==4)
			$edicion="<img src='../imagenes/botones/editar_c.png' title='Editar Solicitud' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/lista_precios/edita_solicitudes.php?id_compra=$ls[0]\",\"contenidos\")'/>";
		else{
		$edicion="<img src='../imagenes/botones/editar_c.png' title='Editar Solicitud' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/lista_precios/edita_solicitudes.php?id_compra=$ls[0]\",\"contenidos\")'/>";
		$auditor="<img src='../imagenes/botones/b_cancelar.gif' title='Eliminar solicitud' width='16' height='16' onclick='javascript:liminar_solicitud($ls[1])'/>";		
		}
		

  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/botones/<?=$semaforor_estado;?>" width="16" height="16" /></td>
    <td ><?=$ls[1];?></td>
    <td><?=$ls[0];?></td>
    <td><?=fecha_for_hora($ls[3]);?></td>
    <td><?=number_format($valor_soli,0);?></td>
    <td><?=number_format($cantidad,0);?></td>
    <td><?=$ls[4];?></td>
    <td><div align="center">
      <?=$edicion;?> 
      <?=$auditor;?> 
      <?=$evaluacion;?>     
    </div></td>
  </tr>
  <? $num_fila++; $encontrados++; 
  }// while
  
   ?>
  <tr>
    <td colspan="8" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Solicitudes encontradas:
          <?=$encontrados;?>
        </div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="1%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
            </option>
            <? } ?>
          </select>
        </label></td>
        <td width="6%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/lista_precios/historico_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
