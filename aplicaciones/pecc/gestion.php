<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
		
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

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
        <td width="54%" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td width="54%" valign="top">
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td align="center"  class="fondo_3">Lista de Gestiones</td>
              <td align="center"  class="fondo_3">&nbsp;</td>
              <td align="center"  class="fondo_3">&nbsp;</td>
              <td align="center"  class="fondo_3">&nbsp;</td>
              <td align="center"  class="fondo_3">&nbsp;</td>
              <td align="center"  class="fondo_3">&nbsp;</td>
              </tr>
            <tr>
              <td width="15%" align="center" class="fondo_3">Secci&oacute;n</td>
              <td width="17%" align="center" class="fondo_3">Actividad</td>
              <td width="15%" align="center" class="fondo_3">Usuario</td>
              <td width="14%" align="center" class="fondo_3">Fecha de Gesti&oacute;n</td>
              <td width="33%" align="center" class="fondo_3">Observaci&oacute;n</td>
              <td width="6%" align="center" class="fondo_3">Devoluci&oacute;n</td>
              </tr>
          <?
		  
		  $cont = 0;
  $clase="";
          	$sel_gestiones=query_db("select seccion,actividad,encargado,nom_us_gestiona,fecha_real,CAST(observacion AS text),devolucion,hora from v_pecc_gestiones where id_item = ".$id_item_pecc." order by t2_gestion");
			
			while($s_gest = traer_fila_db($sel_gestiones)){
			
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  $hora_gestion="";
		  if($s_gest[7] <> ""){
			  	$hora_gestion = " ".$s_gest[7];
			  }
		  ?>
            <tr class="<?=$clase?>">
              <td align="center" ><?=$s_gest[0]?></td>
              <td align="center" ><?=$s_gest[1]?></td>
              <td align="center" ><?=$s_gest[3]?></td>
              <td align="center" ><?=$s_gest[4]?><?=$hora_gestion?></td>
              <td align="left" ><?=nl2br($s_gest[5])?></td>
              <td align="center" ><? if ($s_gest[6] == 1) echo "SI"; else echo "";?></td>
              </tr>
            <?
			}
			?>
  </table> 
          
      </td>
      </tr>
      
    </table></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
</body>
</html>
