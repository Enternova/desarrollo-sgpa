<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_pregunta_arr = elimina_comillas(arreglo_recibe_variables($id_pregunta));
	$pregunta_qu = traer_fila_row(query_db("select * from ".$ev4."  where id =".$id_pregunta_arr));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

	
	<tr>
		<td width="20%" align="right" >Pregunta Informativa:</td>
		<td colspan="2" ><input type="text" name="pregunta" id="pregunta" value="<?=$pregunta_qu[3];?>" /></td>
	</tr>
	<tr>
	  <td >&nbsp;</td>
	  <td colspan="2" align="left" >
      <?
      if($id_pregunta_arr!=""){
		?>
      	<input name="button2" type="button" class="boton_grabar" id="button2" value="Editar Pregunta" onclick="graba_pregunta(<?=$id_pregunta_arr;?>)"/>&nbsp;&nbsp;
      <?  
	  }else{
	  ?>
      <input name="button2" type="button" class="boton_grabar" id="button2" value="Crear Pregunta" onclick="graba_pregunta(99)"/>&nbsp;&nbsp;
      <?
	  }
	  ?>
      </td>
  </tr>
	<tr>
	  <td >&nbsp;</td>
	  <td width="70%" ></td>
	  <td width="10%" ></td>
  </tr>
	<tr class="fondo_4">
	  <td colspan="3" >Listado de Preguntas</td>
  </tr>
  <tr class="columna_subtitulo_resultados">
	  <td colspan="2" >Preguntas</td>
      <td  >Editar</td>
  </tr>
  <?
	$lista_poliza_int = "select id,nombre,estado from ".$evf2."  where estado = 1 order by id";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
	?>    

  <tr >
	  <td colspan="2" ><?=$lista_poliza_int[1];?></td>
      <td  ><img src="../imagenes/botones/editar.jpg" alt="Editar Póliza" title="Editar Póliza" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/evaluador/h_pregunta.php?id_pregunta=<?=arreglo_pasa_variables($re_lista_preguntas[0]);?>','carga_acciones_permitidas')"/></td>
  </tr>
  <?
	}
  ?>
  	
</table>
<input name="id_pregunta" type="hidden" value="<?=$id_pregunta;?>" />
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
