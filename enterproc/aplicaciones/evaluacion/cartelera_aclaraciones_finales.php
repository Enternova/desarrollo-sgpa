<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
    verifica_menu("principal.html");
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

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
    <td width="83%" class="titulos_evaluacion">Cartelera de aclaraciones finales para este proceso</td>
    <td width="17%"><div align="left">
      <input name="button5" type="button" class="cancelar" id="button5" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
</table>

<fieldset style="width:98%">
			<legend>Crear pregunta</legend>

<?
	/** INICIO PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
	if($sql_e[15]==$_SESSION["id_us_session"] or $sql_e[15]==a_quien_reemplaza($_SESSION["id_us_session"]) or $sql_e[15]==cual_es_el_reemplazo($_SESSION["id_us_session"])) {
	/** FIN PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
?>
            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><div align="right"><strong>Asunto:</strong></div></td>
                <td><label>
                  <input type="text" name="asunto_cartelera" id="asunto_cartelera">
                </label></td>
              </tr>
              <tr>
                <td width="25%"><div align="right"><strong>Aclaraci&oacute;n:</strong></div></td>
                <td><div align="left">
                  
                  <textarea name="pregunta_general" id="pregunta_general" cols="100" rows="5"></textarea>
                  
                </div>              </td>
              </tr>
              <tr>
                <td><div align="right"><strong>Anexo:</strong></div></td>
                <td><input type="file" name="anexo_re_general" id="anexo_re_<?=$ls_c[0];?>"></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Fecha limite de respuesta:</strong></div></td>
                <td><input name="h_m_r" type="text" class="f_fechas" id="h_m_r"  onmousedown="calendario_se('h_m_r')" /></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Seleccione los proveedores:</strong></div></td>
                <td><div align="left">
                  <table width="98%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                    <tr>
                      <td width="4%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
                      <td width="13%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                      <td width="83%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                    </tr>
                    <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id order by $t8.razon_social");
				while($lp = traer_fila_row($busca_provee)){
			  
			  	$busca_participacion = traer_fila_row(query_db("select count(*) from $t7 where pv_id = $lp[0] "));
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
                    <tr class="<?=$class;?>">
                      <td><label>
                        <input type="checkbox" name="pv_id_carte[]" id="checkbox" value="<?=$lp[0];?>">
                      </label></td>
                      <td><div align="left">
                          <?=$lp[1];?>
                      </div></td>
                      <td><div align="left">
                          <?=$lp[2];?>
                      </div></td>
                    </tr>
                    <? $num_fila++;} ?>
                  </table>
                </div>                </td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                  <?
				  	if($_SESSION["pv_principal"]==100){
						?>
                    <input name="button" type="button" class="guardar" id="button" value="Grabar y enviar pregunta" onClick="crea_cartelera_final()">
                    <? } else { ?>
                    <input name="button" type="button" class="guardar" id="button" value="Grabar y enviar pregunta" onClick="">
                    <? } ?>
                  </div></td>
              </tr>
            </table>

</fieldset>
<br>
<? } ?>
<div align="center"><a href='../aplicaciones/evaluacion/descargas_uno/descarga_documentos_aclaraciones.php?evaluador1_id=<?=$id_invitacion;?>'>
	Descargar todos los archivos de los proveedores</a></div>
<p>

<fieldset style="width:98%">
			<legend>Historico de <strong>aclaraciones de este proceso</strong></legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="7%" class="columna_titulo_resultados">Consecutivo</td>
                <td width="35%" class="columna_titulo_resultados">Asunto</td>
                <td width="7%" class="columna_titulo_resultados">Envio</td>
                <td width="19%" class="columna_titulo_resultados">Enviado a</td>
                <td width="8%" class="columna_titulo_resultados">Fecha limite</td>
                <td width="3%" class="columna_titulo_resultados">Leido</td>
                <td width="3%" class="columna_titulo_resultados">Resp.</td>
                <td width="4%" class="columna_titulo_resultados">Anexos</td>
                <td width="14%" class="columna_titulo_resultados">&nbsp;</td>
              </tr>
              
              <?
			  	$sele_car="select pro16_id, objeto, fecha_solicitud, razon_social, fecha_limite_respuesta, if(leida=1,'No', 'Si') from $v7 where pro1_id = $id_invitacion order by pv_id, fecha_solicitud desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				$cuenta_respuestas = traer_fila_row(query_db("select count(*) from $t28 where pro16_id = $ls_c[0]"));
				$cuenta_respuestas_anexos = traer_fila_row(query_db("select count(*) from $t28 where pro16_id = $ls_c[0] and archivo_soporte <> ''"));
				if($cuenta_respuestas_anexos[0]>=1)
					$pinta_imagen = "<img src='../imagenes/mime/txt.gif'  >";
				else
					$pinta_imagen = "NO";
					
  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$ls_c[0];?></td>
        <td><?=nl2br($ls_c[1]);?></td>
                <td><div align="left">
                  <?=fecha_for_hora($ls_c[2]);?>
        </div></td>
                <td><div align="left">
                  <?=$ls_c[3];?>
                </div></td>
                <td><div align="left">
                  <?=fecha_for_hora($ls_c[4]);?>
                </div></td>
                <td><div align="left">
                  <?=$ls_c[5];?>
                </div></td>
                <td><div align="left"><?=number_format($cuenta_respuestas[0],0);?></div></td>
                <td><?=$pinta_imagen;?></td>
                <td>
                  <input name="button" type="button" class="buscar" id="button" onClick="ajax_carga('../aplicaciones/evaluacion/respuesta_aclaraciones_finales.php?id_pregunta=<?=$ls_c[0];?>&id_invitacion_pasa=<?=$pasa;?>','carga_resultados_principales')" value="Ver Respuestas"></td>
              </tr>
			   
              <tr>
                <td colspan="9" id="div_for_<?=$ls_c[0];?>" style="display:none">&nbsp;</td>
              </tr>
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_elimina">
<input type="hidden" name="ocu_re">

</body>
</html>
