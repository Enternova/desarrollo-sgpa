<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");

	$busca_proveedor = traer_fila_row(query_db("select * from $v2 where pv_id = ".$pv_id));

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
    <td class="titulos_procesos">ADMINISTRACION DE USUARIOS</td>
  </tr>
</table>
<p>&nbsp;</p>
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General </legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="18%" height="34">Identificaci&oacute;n:</td>
    <td width="33%"><div align="left">
      <label>
      
      <input name="ap" type="text" id="ap" value="<?=$busca_proveedor[1];?>" size="50">
      </label>
    </div></td>
    <td width="20%">Raz&oacute;n social:</td>
    <td width="29%"><div align="left">
        <input name="bp" type="text" id="bp" value="<?=$busca_proveedor[2];?>" size="50">
    </div>    </td>
  </tr>
  <tr>
    <td height="35">Direcci&oacute;n:</td>
    <td><div align="left">
      <input name="cp" type="text" id="cp"  value="<?=$busca_proveedor[3];?>" size="50">
    </div></td>
    <td>E-mail:</td>
    <td><div align="left">
      <input name="dp" type="text" id="dp"  value="<?=$busca_proveedor[11];?>" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33">Tel&eacute;fono:</td>
    <td><div align="left">
      <input name="ep" type="text" id="ep" value="<?=$busca_proveedor[10];?>" size="50">
    </div></td>
    <td>Estado:</td>
    <td><div align="left">
      <select name="fp" id="fp">
        <?=listas($tp11,1,$busca_proveedor[13],'nombre',1);?>
                  </select>
<?
	if($busca_proveedor[13]==1){
		$semaforor_estado = 'acitvo.png';
		}
	elseif($busca_proveedor[13]==2){
		$semaforor_estado = 'cerrada.png';
		}

	elseif($busca_proveedor[13]==3){
		$semaforor_estado = 'enproceso.png';
		}

?>      
    <img src="../imagenes/botones/<?=$semaforor_estado;?>" width="16" height="16" /></div></td>
  </tr>
  <tr>
    <td height="35">Pa&iacute;s</td>
    <td><div align="left">
      <select name="pais" id="pais" onChange="ajax_carga('../librerias/php/llena_ciudades.php?depar=1&var=' + this.value ,'div_dp')">
        <?=listas($t2,1,$busca_proveedor[4],'ps_nombre',1);?>
      </select>
    </div></td>
    <td>Departamento / Estado</td>
    <td><div align="left" id="div_dp">
      <select name="depart" id="depart" onChange="ajax_carga('../librerias/php/llena_ciudades.php?depar=2&var=' + this.value ,'grupo_ciudades')">
        <?=listas($t3, ' ps_id = '.$busca_proveedor[4],$busca_proveedor[6],'dp_nombre', 2);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td height="35">Ciudad</td>
    <td><div align="left" id="grupo_ciudades">
      <select name="ciuadad" id="ciuadad">
        <?=listas($t4, ' dp_id = '.$busca_proveedor[6],$busca_proveedor[8],'cd_nombre', 2);?>
      </select>
    </div></td>
    <td>Crear contrase&ntilde;a automatica:</td>
    <td><label>
      
      <div align="left">
        <input name="g" type="checkbox" id="g" value="si">
        </label>
    </div></td>
  </tr>
  <tr>
    <td height="35">Cambiar contrase&ntilde;a</td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">
      </label>
    </div>
      <div align="center"></div></td>
    <td>Repetir nueva contrase&ntilde;a</td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" colspan="4">
      <div align="center">
        <input name="button" type="button" class="guardar" id="button" value="Modificar proveedor" onClick="modifica_proveedor()">
        <input name="button2" type="button" class="cancelar" id="button2" value="Cancelar modificaci&oacute;n" onClick="volver_listado('contenido_aux','contenido_aux_sub')">
      </div>
    </td>
  </tr>
</table>
<br>
</fieldset>

<br />
<fieldset style="width:98%">
			<legend>Usuarios creados </legend>

            <table width="95%" border="0" cellspacing="4" cellpadding="4">
              <tr>
                <td colspan="4"></td>
              </tr>
              <tr>
                <td width="30%" height="34"><div align="right"><strong>Nombre:</strong></div></td>
                <td width="26%"><div align="left"> <input type="text" name="b" id="textfield6"> </div></td>
                <td width="22%"><div align="right"><strong>E-mail:</strong></div></td>
                <td width="22%"><div align="left"> <input type="text" name="d" id="textfield8"> </div></td>
              </tr>
              <tr>
                <td height="35"><div align="right"><strong>Tel&eacute;fono:</strong></div></td>
                <td><div align="left"> <input type="text" name="e" id="textfield9"> </div></td>
                <td colspan="2"><div align="center"><input name="button3" type="button" class="guardar" id="button3" value="Crear usuario" onClick="crea_sub_usuario_j_admin()">                  </div>
                <div align="left"></div></td>
              </tr>
            </table>
            <br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr class="administrador_tabla_titulo">
    <td width="38%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="13%" class="titulo_tabla_azul_sin_bordes">Principal</td>
    <td width="30%" class="titulo_tabla_azul_sin_bordes">Usuario</td>
    <td width="14%" class="titulo_tabla_azul_sin_bordes">Tel&eacute;fono</td>
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Eliminar</td>
  </tr>
  <?
			$busca_respo = query_db("select * from $t1 where  pv_id = ".$pv_id." and estado = 1 ");
			while($lc=traer_fila_row($busca_respo)){
			
			if($lc[11]==0) $principal = "Si";
			else  $principal = "No";
			
		?>
  <tr class="administrador_tabla_generales">
    <td align="right"><div align="right"><?=$lc[1];?></div></td>
    <td><div align="center"><?=$principal;?></div></td>
    <td><?=$lc[4];?></td>
    <td><div align="center"><?=$lc[5];?></div></td>
    <td><? if($lc[11]==1){ ?><img src="../../enterproc/imagenes/botones/eliminar_c.png" width="16" height="16" title="eliminar usuario" onClick="elimina_usuario_proveedor(<?=$lc[0];?>)"><? } ?></td>
  </tr>
  <? } ?>
</table>
<br>
</fieldset>

<br>
<?

	if($nomostrar_hasta_mayo==1){
		?>
<fieldset style="width:98%">
			<legend>Historico de procesos invitados </legend>

            <br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  
  <tr class="administrador_tabla_titulo">
    <td width="10%" class="titulo_tabla_azul_sin_bordes"><div align="center">Consecutivo</div></td>
    <td width="17%" class="titulo_tabla_azul_sin_bordes"><div align="center">Tipo de proceso</div></td>
    <td width="19%" class="titulo_tabla_azul_sin_bordes"><div align="center">Objeto a Contratar</div></td>
    <td width="13%" class="titulo_tabla_azul_sin_bordes"><div align="center">Apertura</div></td>
    <td width="17%" class="titulo_tabla_azul_sin_bordes"><div align="center">Cierre</div></td>
    <td width="12%" class="titulo_tabla_azul_sin_bordes"><div align="center">Responsable</div></td>
    <td width="12%" class="titulo_tabla_azul_sin_bordes"><div align="center">Adjudicado</div></td>
  </tr>
  <?  
  	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t7 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t7.pro1_id = $t5.pro1_id and
	$t5.notificacion = 1 and
	$t7.pv_id = ".$pv_id;
	
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
			
			$busca_adjudicaciones = traer_fila_row(query_db("select if(adjudicado=1,'Si', 'No') from $t13 where pv_id = $pv_id and proc1_id = $ls[0] "));
			if($busca_adjudicaciones[0]!="")
				$adj=$busca_adjudicaciones[0];
			else				
				$adj="No";

  ?>
  <tr class="<?=$class;?>">
    <td><?=$ls[7];?></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=fecha_for_hora($ls[4]);?></td>
    <td><?=fecha_for_hora($ls[5]);?></td>
    <td><?=$ls[6];?></td>
    <td><?=$adj;?></td>
  </tr>
  <? $num_fila++; } ?>
</table>

</fieldset>

<? } ?>
<br>
<fieldset style="width:98%">
			<legend>Historico de procesos invitados </legend>

            <br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  
  <tr class="administrador_tabla_titulo">
    <td width="10%" class="titulo_tabla_azul_sin_bordes"><div align="center">Consecutivo</div></td>
    <td width="17%" class="titulo_tabla_azul_sin_bordes"><div align="center">Tipo de proceso</div></td>
    <td width="19%" class="titulo_tabla_azul_sin_bordes"><div align="center">Objeto a Contratar</div></td>
    <td width="13%" class="titulo_tabla_azul_sin_bordes"><div align="center">Apertura</div></td>
    <td width="17%" class="titulo_tabla_azul_sin_bordes"><div align="center">Cierre</div></td>
    <td width="12%" class="titulo_tabla_azul_sin_bordes"><div align="center">Responsable</div></td>
    <td width="12%" class="titulo_tabla_azul_sin_bordes"><div align="center">Adjudicado</div></td>
  </tr>
  <?  
  	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t7 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t7.pro1_id = $t5.pro1_id and
	$t5.notificacion = 1 and
	$t7.pv_id = ".$pv_id;
	
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
			
			$busca_adjudicaciones = traer_fila_row(query_db("select if(adjudicado=1,'Si', 'No') from $t13 where pv_id = $pv_id and proc1_id = $ls[0] "));
			if($busca_adjudicaciones[0]!="")
				$adj=$busca_adjudicaciones[0];
			else				
				$adj="No";

  ?>
  <tr class="<?=$class;?>">
    <td><?=$ls[7];?></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=fecha_for_hora($ls[4]);?></td>
    <td><?=fecha_for_hora($ls[5]);?></td>
    <td><?=$ls[6];?></td>
    <td><?=$adj;?></td>
  </tr>
  <? $num_fila++; } ?>
</table>

</fieldset>

<input type="hidden" name="pv_id" value="<?=$pv_id;?>" />  
<input type="hidden" name="pv_id_usuario_elimin"  />  
  
</p>
</body>
</html>
