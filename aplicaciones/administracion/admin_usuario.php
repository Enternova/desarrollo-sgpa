<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
verifica_menu("administracion.html");
//paguinacion

$com_p.=" tipo_usuario <>2 and estado = 1";

if($nombre!="")
	$com_p.=" and nombre_administrador like '%$nombre%'";
if($email!="")
	$com_p.=" and email like '%$email%'";
if($nit!="")
$com_p.=" and usuario like '%$nit%'";
  

/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 300;
	$factor_b = 300;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from $g1 where   $com_p ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenido_aux">
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">SECCION: HISTORICO DE USUARIOS</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<tr align="center">
    	<td>Modulo creacion de Usuarios SGPA y Urna Virtual</td>
    </tr>
	<tr align="center">
    	<td colspan="4" class="titulo_tabla_azul_sin_bordes">
        	<input name="button" type="button" class="boton_grabar" id="button" value="Agregar usuarios" onclick="javascript:ajax_carga('../aplicaciones/administracion/crea_usuario.php','contenidos')" />
        </td>
  	</tr>
</table>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
        <input name="button" type="button" class="boton_buscar" id="button" value="Buscar usuarios" onclick="busqueda_paginador_nuevo(1,'../aplicaciones/administracion/admin_usuario.php','contenidos', '0')" /></div>    </td>
    </tr>
</table>
<br />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Lista de usuarios</td>
  </tr>
</table>


<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados">
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="81%">&nbsp;</td>
        <td width="14%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/administracion/admin_usuario.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
            </select>
        </label></td>
        <td width="5%"><a href="javascript:busqueda_paginador_nuevo(2,'../aplicaciones/administracion/admin_usuario.php','contenidos')"></a></td>
      </tr>
    </table>
    
    </td>
  </tr>
  <tr>

    <td width="21%" class="columna_subtitulo_resultados"><div align="center">Nombre</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Usuario</div></td>
    <td width="30%" class="columna_subtitulo_resultados"><div align="center">E-mail</div></td>

    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
  </tr>
  <?  

/*if($complemento=="")
	$complemento = " and estado_proveedor = 1 ";
  */
  $cont=0;
  $busca_procesos = "select * from (select * , ROW_NUMBER() OVER(ORDER BY nombre_administrador) AS rownum from $g1 where  $com_p  ) as sub
where rownum > $inicio and rownum <= $factor_b	";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	


		


  ?>
  <tr class="<?=$clase;?>">

    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=$ls[4];?></td>

    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" onclick="ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$ls[0];?>','contenido_aux_sub');ingresar_listado('contenido_aux')" /></div></td>
  </tr>
  <tr class="<?=$class;?>">
    <td colspan="2"></td>
    <td colspan="0" id="contrase_<?=$ls[0];?>"></td>
  </tr>
  <? $num_fila++; $encontrados++;
  }// while
  
   ?>
</table>
</div>
<div id="contenido_aux_sub"></div>

<input type="hidden" name="id_limpia" />
<input type="hidden" name="id_usua" />
<input type="hidden" name="id_prof" />

</body>
</html>
