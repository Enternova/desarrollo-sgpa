<?   include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
verifica_menu("principal.html");
//paguinacion

if($nombre!="")
	$com_p.=" and pv_nombre like '%$nombre%'";
if($email!="")
	$com_p.=" and pv_email like '%$email%'";
if($nit!="")
$com_p.=" and pv_nit like '%$nit%'";
  

$numero_pagi = 50;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) 
	 from $v2 where 1 $com_p  "));
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
<div id="contenido_aux">
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: HISTORICO DE USUARIOS</td>
  </tr>
</table>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4" class="titulo_tabla_azul_sin_bordes">Buscador de usuarios</td>
  </tr>
  <tr>
    <td width="26%"><div align="right"><strong>Nombre :</strong></div></td>
    <td width="23%"><div align="left">
      <input type="text" name="nombre" id="nombre"  value="<?=$nombre;?>"/>
    </div></td>
    <td width="22%"><div align="right"><strong>Email:</strong></div></td>
    <td width="29%"><div align="left">
      <input type="text" name="email" id="email" email value="<?=$email;?>"/>
    </div></td>
  </tr>
  <tr>
    <td colspan="4">
      <div align="center">
        <input name="button" type="button" class="buscar" id="button" value="Buscar usuarios" onclick="busqueda_paginador_nuevo(1,'../aplicaciones/historico_usuario.php','contenidos', '0')" />
         <input name="button2" type="button" class="buscar" id="button2" value="Crear usuarios" onclick="busqueda_paginador_nuevo(1,'../aplicaciones/crea_usuario.php','contenidos', '0')" />
         <input name="button3" type="button" class="cancelar" id="button3" value="Volver al panel de control" onclick="ajax_carga('panel-control.html','contenidos')" />
      </div>
    </td>
    </tr>
</table>
<br />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">Lista de usuarios</td>
  </tr>
</table>


<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"></div></td>
        <td width="6%"><div align="center"><a href="javascript:void(0)" onclick="busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:void(0)" onclick="busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="5%" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="32%" class="columna_subtitulo_resultados"><div align="center">Nombre</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Usuario</div></td>
    <td width="30%" class="columna_subtitulo_resultados"><div align="center">E-mail</div></td>
    <td width="12%" class="columna_subtitulo_resultados">Perfil</td>
    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
  </tr>
  <?  

/*if($complemento=="")
	$complemento = " and estado_proveedor = 1 ";
  */
  	$busca_procesos = "select * from $t1 where tipo_usuario != 2 and usuario != 'rsterling' $com_p limit $paginador,$numero_pagi	";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
	
	if($ls[6]==1){
		$semaforor_estado = 'acitvo.png';
		}
	elseif($ls[6]==2){
		$semaforor_estado = 'cerrada.png';
		}
		

	if($ls[9]==1){
		$perfil = 'Administrador';
		}
	elseif($ls[9]==3){
		$perfil = 'Comprador';
		}		
	elseif($ls[9]==4){
		$perfil = 'Auditor';
		}		




  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/botones/<?=$semaforor_estado;?>" width="16" height="16" /></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=$ls[4];?></td>
    <td><?=$perfil;?></td>
    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" onclick="ajax_carga('../aplicaciones/modifica_usuario.php?pv_id=<?=$ls[0];?>','contenido_aux_sub');ingresar_listado('contenido_aux')" /></div></td>
  </tr>
  <tr class="<?=$class;?>">
    <td colspan="4"></td>
    <td colspan="2" id="contrase_<?=$ls[0];?>"></td>
  </tr>
  <? $num_fila++; $encontrados++;
  }// while
  
   ?>
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left">Proveedores encontrados:
          <?=$encontrados;?>
        </div></td>
        <td width="6%"><div align="center"><a href="javascript:void(0)" onclick="busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
            </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:void(0)" onclick="busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_usuario.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
<div id="contenido_aux_sub"></div>

<input type="hidden" name="id_limpia" />

</body>
</html>
