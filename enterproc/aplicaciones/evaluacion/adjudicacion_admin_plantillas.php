<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	


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
    <td width="83%" class="titulos_evaluacion">Administraci&oacute;n de plantilla de correos de notificaci&oacute;n a los usuarios de HOCOL S.A.</td>
    <td width="17%"><div align="left"></div></td>
  </tr>
</table>
<br>
<table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>CREACION DE PLANTILLA</strong></td>
  </tr>
  <tr>
    <td><div align="right">Tipo de plantilla:</div></td>
    <td><select name="dato0" id="dato0">
      <option value="0">Seleccione</option>
      <option value="2">Centro logistico</option>
      <option value="3">Operador logistico</option>
    </select></td>
  </tr>
  <tr>
    <td width="18%"><div align="right"><strong>Nombre de la plantilla:</strong></div></td>
    <td width="82%"><input type="text" name="dato1" id="dato1"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Sitio de entrega:</strong></div></td>
    <td><input type="text" name="dato2" id="dato2"></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Direcci&oacute;n entrega:</strong></div></td>
    <td><input type="text" name="dato3" id="dato3"></td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><input type="button" name="button" class="guardar" id="button" value="Grabar cambios a la plantilla"  onclick="crea_datos_plantilla()"></div></td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="7" class="columna_titulo_resultados"><strong>HISTORICO DE PLANTILLA</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_subtitulo_resultados"><div align="center"><strong>Ver</strong></div></td>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center"><strong>Tipo</strong></div></td>
    <td width="16%" class="columna_subtitulo_resultados"><strong>Plantilla</strong></td>
    <td width="24%" class="columna_subtitulo_resultados"><div align="center"><strong>Sitio entrega</strong></div></td>
    <td width="22%" class="columna_subtitulo_resultados"><div align="center"><strong>Direcci&oacute;n</strong></div></td>
    <td width="20%" class="columna_subtitulo_resultados"><div align="center"><strong>Horario</strong></div></td>
    <td width="7%" class="columna_subtitulo_resultados"><div align="center"><strong>Eliminar</strong></div></td>
  </tr>
  <?

  	$busca_lista = query_db("select * from $t41 order by destino_final, nombre_plantilla ");
	while($lista_plan = traer_fila_row($busca_lista)){//lista plantillas
            if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
$tipo_pla="";
							
if($lista_plan[4]==1) $tipo_pla = "Compradores";
elseif($lista_plan[4]==2) $tipo_pla = "Centro log.";
elseif($lista_plan[4]==3) $tipo_pla = "Operador log.";
elseif($lista_plan[4]==100) $tipo_pla = "Predeterminados";
							
  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/botones/alerta.png" width="16" height="16" alt="Editar" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas_edita.php?id_invitacion=<?=$id_invitacion;?>&pro25_id=<?=$lista_plan[0];?>','contenidos')"></td>
    <td><?=$tipo_pla;?></td>
    <td><?=$lista_plan[1];?></td>
    <td><?=$lista_plan[2];?></td>
    <td><?=$lista_plan[3];?></td>
    <td><?=$lista_plan[5];?></td>
    <td><img src="../imagenes/botones/b_cancelar.gif" width="16" height="16" title="Eliminar plantilla" onClick="elimina_plantilla_total(<?=$lista_plan[0];?>)"></td>
  </tr>
  
  <? $num_fila++; }//lista plantillas ?>
</table>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="pv_id">
  
  <input type="hidden" name="id_anexo"></p>
 <input type="hidden" name="id_anexo_elimina">  
</body>
</html>
