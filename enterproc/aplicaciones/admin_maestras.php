<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">ADMINISTRACION DE MAESTRAS <?=$titulo_maestra;?></td>
  </tr>
</table>



<br>
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td width="30%"><div align="right">Nuevo registro:</div></td>
        <td width="55%"><label>
          <input type="text" name="n_resgitro" id="n_resgitro">
        </label></td>
        <td width="15%"><label>
          <input name="button" type="button" class="guardar" id="button" value="Crear registro" onClick="crear_registro_n()">
        </label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="95%" class="columna_subtitulo_resultados">Nombre</td>
    <td width="5%" class="columna_subtitulo_resultados">Editar</td>
  </tr>

 <?  

/*if($complemento=="")
	$complemento = " and estado_proveedor = 1 ";
  */
  	echo $busca_procesos = "select * from $tabla 	";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
				?>  
  <tr class="<?=$class;?>">
    <td><input type="text" name="n_<?=$ls[0];?>" value="<?=$ls[1];?>"></td>
    <td><div align="center"><img src="../imagenes/botones/editar.jpg" alt="Editar registro" title="Editar registro" onClick="modifica_registro_n(document.principal.n_<?=$ls[0];?>,<?=$ls[0];?>)" width="14" height="15" longdesc="Editar registro"></div></td>
  </tr>
  <? $num_fila++; } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<input type="hidden" name="tabla" value="<?=$tabla;?>" />  
<input type="hidden" name="campo_id" value="<?=$campo_id;?>" />  
<input type="hidden" name="titulo_maestra" value="<?=$titulo_maestra;?>" />  
<input type="hidden" name="id_maestra" />  
  

</p>
</body>
</html>
