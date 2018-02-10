<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	
	
	
	
$sel_admin_ot = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 33"));
		if($sel_admin_ot[0]>0){
			$activa_admin_ot = "SI";
		}	
	
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">
        <?
          if ($edicion_datos_generales == "SI"){
		  ?>
        <?
		  }
		?>
        </td>
      </tr>
      <tr>
        <td width="54%" valign="top"><div id="carga_anexos">
          
          <?
          if($sel_item[3]==$_SESSION["id_us_session"]){
		  ?>
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Posibles Acciones para las Ampliaciones</td>
              </tr>
            <tr>
              <td colspan="3" align="center" class="fondo_3">Crear OT</td>
              </tr>
            
            <tr class="">
              <td width="35%" align="center" >&nbsp;</td>
              <td width="30%" align="center" ><input type="button" name="c" value="Ir a Crear la OT" onClick="ajax_carga('../aplicaciones/pecc/formulario-amplia-pecc.php?id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=3&id_item_pecc=<?=$sel_item[26]?>&id_item_ampliacion=<?=$id_item_pecc?>','contenidos')"/></td>
              <td width="35%" align="center" >&nbsp;</td>
              </tr>
            <tr class="">
              <td colspan="3" align="center" >Se direcciona esta solicitud a la ventana de creación de &oacute;rdenes de trabajo y cuando se firme se finaliza y se podrá imprimir la orden de trabajo.</td>
              </tr>
            
          </table>
          
          <?
		  }elseif($activa_admin_ot=="SI"){
		  
		  
		  ?>
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="3" align="center"  class="fondo_3">Posibles Acciones para las Ampliaciones</td>
            </tr>
            <tr>
              <td width="36%" align="center" class="fondo_3">Crear OT</td>
              <td width="32%" align="center" class="fondo_3">Crear Otro S&iacute;</td>
              <td width="32%" align="center" class="fondo_3">No hacer nada (Finalizar)</td>
            </tr>
            <tr class="">
              <td align="center" ><input type="button" name="c2" value="Ir a Crear la OT" onClick="ajax_carga('../aplicaciones/pecc/formulario-amplia-pecc.php?id_pecc=<?=$id_pecc?>&id_tipo_proceso_pecc=3&id_item_pecc=<?=$sel_item[26]?>&id_item_ampliacion=<?=$id_item_pecc?>','contenidos')"/></td>
              <td align="center" ><input type="button" name="c2" value="Crear un Otro S&iacute;" onClick="crear_otro_si_de_ot()" /></td>
              <td align="center" ><input type="button" name="c2" value="Solo Finalizar la Ampliaci&oacute;n" onClick="finaliza_ampliacion()" /></td>
            </tr>
            <tr class="">
              <td align="center" >Se direcciona esta solicitud a la ventana de creaci&oacute;n de &oacute;rdenes de trabajo y cuando se firme se finaliza y se podr&aacute; imprimir la orden de trabajo.</td>
              <td align="center" >Al dar click pasa a legalizaci&oacute;n la ampliaci&oacute;n y se redirecciona al Inbox de legalizaci&oacute;n de contratos</td>
              <td align="center" >Solo Finaliza esta ampliaci&oacute;n sin realizar ninguna acci&oacute;n.</td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </div></td>
      </tr>
      
    </table>
    
    <?
		  }else{
			  echo "No tiene permisos, las personas en cargados son el Gerente de la OT o el Administrador de OTs";
			  }
	?>
    </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />

</body>
</html>
