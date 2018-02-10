<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	


	$busca_datos = "select * from $t41 where pro25_id = $pro25_id";
	$datos_pla = traer_fila_row(query_db($busca_datos));


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion"> Administraci&oacute;n de plantilla de correos de notificaci&oacute;n a los usuarios de HOCOL S.A.</td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>Modificar datos de la plantilla</strong></td>
  </tr>
  <tr>
    <td width="18%"><div align="right"><strong>Nombre de la plantilla:</strong></div></td>
    <td width="82%"><input type="text" name="dato1" id="dato1" value="<?=$datos_pla[1];?>"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Sitio de entrega:</strong></div></td>
    <td><input type="text" name="dato2" id="dato2" value="<?=$datos_pla[2];?>"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Direcci&oacute;n entrega:</strong></div></td>
    <td><input type="text" name="dato3" id="dato3" value="<?=$datos_pla[3];?>"></td>
  </tr>
  <? if($datos_pla[4]==3) { ?>
  <tr>
    <td><div align="right"><strong>Horario de atenci&oacute;n:</strong></div></td>
    <td><input type="text" name="dato4" id="dato4" value="<?=$datos_pla[5];?>"></td>
  </tr>
  <? } else echo '<input type="hidden" name="dato4" id="dato4" value="'.$datos_pla[5].'">';  ?>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><input type="button" name="button" class="guardar" id="button" value="Grabar cambios a la plantilla"  onclick="modifica_datos_plantilla()"></div></td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>Crear nuevo contacto</strong></td>
  </tr>
  <tr>
    <td width="18%"><div align="right"><strong>Grupo:</strong></div></td>
    <td width="82%"><input type="text" name="con_grupo" id="con_grupo"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Nombre:</strong></div></td>
    <td><input type="text" name="con_nombre" id="dato_6"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>E-mail:</strong></div></td>
    <td><input type="text" name="con_email" id="dato_7"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><input type="button" name="button3" class="guardar" id="button3" value="Crear nuevo contacto" onclick="crea_contacto_plantilla()"></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <tr>
    <td width="21%" class="columna_subtitulo_resultados"><div align="center"><strong>Grupo</strong></div></td>
    <td width="36%" class="columna_subtitulo_resultados"><strong>Nombre</strong></td>
    <td width="34%" class="columna_subtitulo_resultados"><div align="center"><strong>Email</strong></div></td>
    <td width="6%" class="columna_subtitulo_resultados"><div align="center"><strong>Eliminar</strong></div></td>
  </tr>
  <?

  	$busca_lista = query_db("select * from $t42  where pro25_id = $pro25_id order by grupo, nombre ");
	while($lista_plan = traer_fila_row($busca_lista)){//lista plantillas
            if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";

							
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lista_plan[4];?></td>
    <td><?=$lista_plan[2];?></td>
    <td><?=$lista_plan[3];?></td>
    <td><img src="../imagenes/botones/alerta.png" width="16" height="16" title="Eliminar contacto" onClick="elimina_contacto_plantilla(<?=$lista_plan[0];?>)"></td>
  </tr>
  
  <? $num_fila++; }//lista plantillas ?>
</table>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pro25_id" value="<?=$pro25_id;?>">  
  <input type="hidden" name="pv_id">
  
  <input type="hidden" name="id_anexo_elimina"></p>
</body>
</html>
