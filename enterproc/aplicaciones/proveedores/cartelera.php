<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Modulo de cartelera de aclaraciones',$id_invitacion,".$_SESSION["id_proveedor"].")");


$bus_alertas="select * from $t29 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 1";
$sql_alert=traer_fila_row(query_db($bus_alertas));
if($sql_alert[0]>=1){

$cambia_estado_alertas = query_db("update $t29 set estado = 2, quien_ingresa ='Proveedor' where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and tp13_id  = 1 ");

$cambia = query_db("insert into  $t26 (pro1_id,pv_id,us_id, fecha_hora_gestion,detalle_gestion,proxima_llamada,tp14_id) 
		values ($id_invitacion,".$_SESSION["id_proveedor"].",".$_SESSION["id_us_session"].",'$fecha $hora', 'El proveedor visualiza la cartelera de aclaraciones','', 1)");


}


	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

	/*fechas cartelera general*/
		if ( ($fecha." ".$hora >= $sql_e[29]  ) && ($sql_e[34] >= $fecha." ".$hora ) ) 
			$apertura=1;
		elseif ( ($fecha." ".$hora >= $sql_e[35]  ) && ($sql_e[36] >= $fecha." ".$hora ) ) 
			$apertura=1;
		elseif ( ($fecha." ".$hora >= $sql_e[37]  ) && ($sql_e[38] >= $fecha." ".$hora ) ) 
			$apertura=1;
		else
			$apertura=0;
	
		/*fechas cartelera juridico*/
		
			/*fechas cartelera tecnico*/


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">CARTELERA DE ACLARACIONES</td>
  </tr>
</table>


            <table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
                  <?=$sql_e[22];?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
                <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
              </tr>
              <tr>
                <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
                <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
                  <?=listas_sin_select($tp2,$sql_e[2],1);?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
                <td ><strong>
                  <?=listas_sin_select($tp3, $sql_e[3], 1);?>
                </strong></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
                <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><div align="right"><strong>
                    <?=$lenguaje_0;?>
                  :</strong></div></td>
                <td ><strong>
                  <?=$sql_e[12];?>
                </strong></td>
              </tr>
            </table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')">
    </label></td>
  </tr>
</table>
<br>

<br />
<? if ($apertura==1){ // si tiene apertura ?>
<fieldset style="width:98%">
			<legend>Crear pregunta</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="2"><p><span class="telefono_contacto">NOTA: </span>Usted puede enviar todas las preguntas que requiera una a una, tenga en cuenta lo siguiente:<br>
                  * Solo puede ingresar 300 caracteres por pregunta <br>
                  * Si su pregunta es mas larga por favor ingresela segmentada </p>
                  <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Tipo de aclaraci&oacute;n:</strong></div></td>
                <td><select name="tipo_aclaracion_solicitada" id="tipo_aclaracion_solicitada">
                  <option value="0">Seleccione</option>
                  <option value="2">Tecnica</option>
                  <option value="1">Economica</option>
                  <option value="3">Lista de precios</option>

                </select>
</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><table width="100%" border="0">
                  <tr>
                    <td width="17%">Caracteres usados:</td>
                    <td width="17%"><input name="caracteres" type="text" class="campos_blancos_listas" id="caracteres" readonly></td>
                    <td width="66%">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td width="25%"><div align="right"><strong>Pregunta:</strong></div></td>
                <td><div align="left">
                  
                  <textarea name="pregunta_general" id="pregunta_general" cols="100" rows="5" onKeyUp="calcLong('pregunta_general','caracteres',this, 300)"></textarea>
                                    <input type="hidden" name="archi_foro" id="archi_foro">
                </div>                  <div align="left"></div></td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                    <input name="button" type="button" class="guardar" id="button" value="Grabar y enviar pregunta" onClick="crea_pregunta_general_cartelera()">
               	  <input type="hidden" name="tipo_comunicacion" value="1">                  </div></td>
              </tr>
            </table>

</fieldset>

<? } // si tiene apertura ?>

<br>
<fieldset style="width:98%">
			<legend>Historico de preguntas</legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="12%" class="titulo_tabla_azul_sin_bordes">Tipo</td>
                <td width="19%" class="titulo_tabla_azul_sin_bordes">Fecha de pregunta</td>
                <td width="53%" class="titulo_tabla_azul_sin_bordes">Pregunta</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="11%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
              </tr>
              
              <?
			  	$sele_car="select * from $t15 where pro1_id = $id_invitacion and tipo_aclaracio  = 1  order by fecha_pregunta desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
				$busca_pro = strpos(" incio ".$ls_c[2]."|",$_SESSION["id_proveedor"]."|");

			
			if( ($busca_pro>=1) || ($ls_c[6]==1) ){//si es publica o del dueño
	
			if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				if($ls_c[10]==1) { $solicitante = "Economico";  }
				elseif($ls_c[10]==2) $solicitante = "Tecnico";
				elseif($ls_c[10]==3) $solicitante = "Lista de precios";				
				elseif($ls_c[10]==4) $solicitante = "Todas";								
				$ext="";
				$ext=extencion_archivos($ls_c[11]);
				


  ?>
          <tr class="<?=$class_g;?>">
            <td><?=$solicitante;?></td>
                <td><div align="center"><?=fecha_for_hora($ls_c[3]);?>
                </div></td>
                <td><div align="left"><?=$ls_c[4];?>
                </div></td>
                <td><? if($ext!=""){ ?><img src="../imagenes/mime/<?=$ext;?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera_pregunta.php?n1=<?=$ls_c[0];?>&n2=<?=$ls_c[11];?>'"><? } ?></td>
                <td>
                    <input name="ver_conte" type="button" class="buscar" onClick="ver_respuestas('div_for_<?=$ls_c[0];?>')" value="Ver respuestas">                </td>
              </tr>
			   
              <tr>
                <td colspan="5" id="div_for_<?=$ls_c[0];?>" style="display:none">
                <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                   <?
			  	$sele_car_foro="select * from $t16 where pro7_id = $ls_c[0] $complemento_foro order by fecha_foro  desc";
				$sql_ex_c_foro=query_db($sele_car_foro);
				while($ls_c_f=traer_fila_row($sql_ex_c_foro)){
				
												

				if($ls_c_f[2]==1) $imagen = "pregunta_f.png";
				else  $imagen = "respuesta_f.png";
				
		if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
				
				$ext="";
				$ext=extencion_archivos($ls_c_f[8]);

  ?>
          <tr class="<?=$class;?>">
                    <td width="3%"><div align="right"><img src="../imagenes/botones/<?=$imagen;?>" width="24" height="24"></div></td>
                    <td width="9%"><?=fecha_for_hora($ls_c_f[5]);?></td>
                    <td width="80%"><div align="left">
                      <?=$ls_c_f[6];?>
                    </div></td>
                    <td width="8%"><? if($ext!=""){ ?><img src="../imagenes/mime/<?=$ext;?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera.php?n1=<?=$ls_c_f[0];?>&n2=<?=$ls_c_f[8];?>'" ><? } ?></td>
          </tr>
                  <? $num_fila++;} ?>
                  
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  

                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><div align="center">&nbsp;
                      <input name="button3" type="button" class="cancelar" id="button3" value="Cerrar respuestas" onClick="oculat_respuestas('div_for_<?=$ls_c[0];?>')">
                      
                    </div></td>
                    <td>&nbsp;</td>
                  </tr>

                </table>                </td>
              </tr>
				  <? 
				  
				 $num_fila_gene++; } //si es publica o del dueño
				 } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
<input type="hidden" name="ocu_re">

</body>
</html>
