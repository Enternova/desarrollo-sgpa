<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<p>&nbsp;</p>
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="34">Consecutivo del proceso:</td>
    <td width="26%"><div align="left"><?=$sql_e[22];?></div></td>
    <td width="22%">Tipo de proceso:</td>
    <td width="22%"><div align="left"><?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div>    </td>
  </tr>
  <tr>
    <td height="35">Tipo de contrato:</td>
    <td><div align="left"><?=listas_sin_select($tp5,$sql_e[5],1);?></div></td>
    <td>Fecha de publicaci&oacute;n:</td>
    <td><div align="left"><?=$sql_e[16];?></div></td>
  </tr>
  <tr>
    <td height="33">Fecha de apertura:</td>
    <td><div align="left"><?=fecha_for_hora($sql_e[17]);?></div></td>
    <td>Fecha de cierre:</td>
    <td><div align="left"><?=fecha_for_hora($sql_e[18]);?></div></td>
  </tr>
  <tr>
    <td height="35">Objeto a contratar:</td>
    <td colspan="3"><div align="left">
        <?=listas_sin_select($tp6,$sql_e[11],1);?>
    </div></td>
  </tr>
  <tr>
    <td height="32">Detalle y cantidad del objeto a contratar:</td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      </textarea>
    </div></td>
  </tr>
</table>
<br>
</fieldset>
<br />

<fieldset style="width:98%">
			<legend>Informaci&oacute;n de contacto  y ubicaci&oacute;n del proceso</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="30%">Persona de contacto:</td>
                <td width="25%"><div align="left">
                  <?=listas_sin_select($t1, $sql_e[15], 1);?>
                </div></td>
                <td width="23%">Direcci&oacute;n entrega f&iacute;sica:</td>
                <td width="22%"><div align="left">
                  <?=$sql_e[8];?>
                </div></td>
              </tr>
              <? if($sql_e[29]!="0000-00-00 00:00:00") { ?>
              <tr>
                <td>Fecha y hora reuni&oacute;n informativa:</td>
                <td><div align="left">
                  <?=$sql_e[29];?>
                </div></td>
                <td>Lugar reuni&oacute;n informativa:</td>
                <td><div align="left">
                  <?=$sql_e[30];?>
                </div></td>
              </tr>
              <? } ?>
            </table>
            <br>
</fieldset>

<br>            
<fieldset style="width:98%">
			<legend>Documentos Anexos</legend>

<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tipo documento</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="35%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Tama&ntilde;o</td>
                <td width="22%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
              </tr>
             
               <?
			  
			   
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga from $t6, $tp8 where
				$t6.pro1_id =  $id_invitacion and $tp8.tp8_id = $t6.tp8_id");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[2]);
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
                <td><?=$lp[1];?></td>
                <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
                <td><?=$lp[2];?></td>
                <td><?=number_format(($lp[3]/1024),2);?> KB</td>
                <td><?=fecha_for_hora($lp[4]);?></td>
  </tr>
              
              <? $num_fila++;} ?>
</table>
<br>
</fieldset>
<br>
<fieldset style="width:98%">
			<legend>Confirmaci&oacute;n de participaci&oacute;n en el proceso</legend>
            
            <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="21%" class="titulo_tabla_azul_sin_bordes">Fecha</td>
                <td width="10%" class="titulo_tabla_azul_sin_bordes">Confirmaci&oacute;n</td>
                <td width="52%" class="titulo_tabla_azul_sin_bordes">Justificaci&oacute;n</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Usuario</td>
              </tr>
              <?

			  	$busca_provee = query_db("select $t1.nombre_administrador, $t9.fecha, $t9.justificacion,if($t9.confirmacion =1,'Si','No') from $t1, $t9 where
				$t9.pro1_id =  $id_invitacion and $t9.pv_id = ".$_SESSION["id_proveedor"]." and $t1.us_id = $t9.us_id order by $t9.fecha desc");
				while($lp = traer_fila_row($busca_provee)){
			   			  
				if($num_fila%2==0)
				$class="campos_blancos_listas";
				else
				$class="campos_gris_listas";
  ?>
              <tr class="<?=$class;?>">
                <td><?=$lp[1];?></td>
                <td><?=$lp[3];?></td>
                <td><?=$lp[2];?></td>
                <td><?=$lp[0];?></td>
              </tr>
              <? $num_fila++;} ?>
            </table>
            <br>
</fieldset>


<br />
<fieldset style="width:98%">
			<legend>Archivos anexados </legend>

            <br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="5" class="titulos_procesos"> Archivos anexos de la oferta para el cliente </td>
  </tr>
  <tr class="administrador_tabla_titulo">
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
    <td width="36%" class="titulo_tabla_azul_sin_bordes">Nombre de los Archivos</td>
    <td width="32%" class="titulo_tabla_azul_sin_bordes">Fecha de Envio</td>
    <td width="17%" class="titulo_tabla_azul_sin_bordes">Tama&ntilde;o</td>
    <td width="10%" class="titulo_tabla_azul_sin_bordes">Acciones</td>
  </tr>
  <?
			$busca_respo = query_db("select * from $t60 where in_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]);
			while($lc=traer_fila_row($busca_respo)){

			$ext=extencion_archivos($lc[3]);
		?>
  <tr class="administrador_tabla_generales">
    <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
    <td><?=$lc[3];?>    </td>
    <td><?=fecha_for_hora($lc[6]);?>    </td>
    <td><?=number_format($lc[4]/1024,2);?>
      KB</td>
    <td><div align="center"><a href='../generales/complementos/baja_anexo_invita_proveedor_generales.php?n1=<?=$lc[0];?>&n2=<?=$lc[3];?>&us_cliente_pasa=<?=$us_cliente_pasa;?>'> <img src="../imagenes/botones/nuevo_1.png"></a></div></td>
  </tr>
  <? } ?>
</table>
<br>
</fieldset>

<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
</body>
</html>
