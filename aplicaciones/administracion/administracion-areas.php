<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
verifica_menu("administracion.html");
//paguinacion


	
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
    <td class="titulos_secciones">SECCION: HISTORICO DE AREAS</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	<tr align="center">
    	<td class="titulo_tabla_azul_sin_bordes">
        	<input name="button" type="button" class="boton_grabar" id="button" value="Agregar Area" onclick="javascript:ajax_carga('../aplicaciones/administracion/crea_usuario.php','contenidos')" />
        </td>
  	</tr>
</table>
<br />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Lista de Areas</td>
  </tr>
</table>


<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    
    <td width="21%" class="columna_subtitulo_resultados"><div align="center">Nombre</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="30%" class="columna_subtitulo_resultados">&nbsp;</td>
    
    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
  </tr>
  <?  

/*if($complemento=="")
	$complemento = " and estado_proveedor = 1 ";
  */
  $cont=0;
  $busca_procesos = "select *  from t1_area ";
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
    <td><? if ($ls[2]==1) echo "Activo"; else echo "Inactivo";?></td>
    <td>&nbsp;</td>

    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" onclick="ajax_carga('../aplicaciones/administracion/modifica_area.php?pv_id=<?=$ls[0];?>','contenido_aux_sub');ingresar_listado('contenido_aux')" /></div></td>
  </tr>
  <tr class="<?=$class;?>">
    <td colspan="2"></td>
    <td colspan="0" id="contrase_<?=$ls[0];?>"></td>
  </tr>
  <? 
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
