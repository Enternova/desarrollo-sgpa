<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">ADMINISTRACION DE MAESTRA AREA / PROYECTO</td>
  </tr>
</table>
<br>


<table width="100%" border="0">
  <tr>
    <td width="28%">&nbsp;</td>
    <td width="22%"><input type="button" name="s" value="Crear una Nueva" class="boton_grabar" onClick="ajax_carga('../aplicaciones/administracion/maestra_area_proyecto_crea.php','crea_edita')" style="cursor:pointer" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr>
        <td width="42%" align="center" class="fondo_3">Nombre</td>
        <td width="24%" align="center" class="fondo_3">Naturaleza de Contrataci&oacute;n</td>
        <td width="18%" align="center" class="fondo_3">Automina para Socios USD$</td>
        <td width="16%" align="center" class="fondo_3">Estado</td>
      </tr>
      <?
	  $cont = 0;
      $sel_areas = query_db("select * from t1_campo order by nombre");
	  while($s = traer_fila_row($sel_areas)){
		  
		  $monto_socios="";
		  if($s[1]==1){$naturaleza="Socios";}
		  if($s[1]==2){$naturaleza="Corporativo";}
		  if($s[4]<>"99999999999"){$monto_socios=number_format($s[4],0);}
		 
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	  ?>
      <tr class="<?=$clase?>">
        <td height="34" ><strong onClick="ajax_carga('../aplicaciones/administracion/maestra_area_proyecto_edita.php?id=<?=$s[0]?>','crea_edita')" style="cursor:pointer"><?=$s[2]?></strong></td>
        <td><?=$naturaleza?></td>
        <td><?=$monto_socios?></td>
        <td><?
         if($s[3]==1){ echo "Activo";}
		 if($s[3]==2){ echo "Inactivo";}

		?></td>
      </tr>
      <?
	  }
	  ?>
    </table></td>
    <td width="50%" valign="top"><div id="crea_edita"></div></td>
  </tr>
</table>
<br />
<input type="hidden" name="accion_correo_ot" id="accion_correo_ot"/>  
  

</p>
</body>
</html>
