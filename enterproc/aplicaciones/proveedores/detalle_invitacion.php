<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));
	
	$inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Detalle invitación',$id_invitacion,".$_SESSION["id_proveedor"].")");
	
	
	$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]));

	if($busca_ingresos[0]>=1)
		$actualiza_visualizacion = query_db("update $t36 set us_id_ultimo_ingreso= ".$_SESSION["id_us_session"].",fecha_ultimo_ingreso='$fecha $hora', ip_ultimo_ingreso= '".$_SERVER['REMOTE_ADDR']."' where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]);
	else
	$inserta_visualizacion = query_db("insert into $t36 (pro1_id, pv_id, us_id, fecha_vista, ip, us_id_ultimo_ingreso, fecha_ultimo_ingreso, ip_ultimo_ingreso) values ($id_invitacion, ".$_SESSION["id_proveedor"].", ".$_SESSION["id_us_session"].", '$fecha $hora', '".$_SERVER['REMOTE_ADDR']."', ".$_SESSION["id_us_session"].", '$fecha $hora', '".$_SERVER['REMOTE_ADDR']."')");

	      	 $busca_adjudicacion = "select pro30_id, pro27_id from $vt15 where pro1_id = $id_invitacion  and pv_id = ".$_SESSION["id_proveedor"]." and estado = 1 and notificado = 1 and tipo_adj_no_adj = 1";
		$busca_adjudicacion_sql = traer_fila_row(query_db($busca_adjudicacion)); 
		if($busca_adjudicacion_sql[1]>=1) { $si_adjudica=1; $pro27_id = $busca_adjudicacion_sql[1]; $pro30_id = $busca_adjudicacion_sql[0]; }
		
		 $busca_adjudicacion = "select pro30_id, pro27_id from $vt15 where pro1_id = $id_invitacion  and pv_id = ".$_SESSION["id_proveedor"]." and notificado = 1 and tipo_adj_no_adj = 2";
		$busca_adjudicacion_sql = traer_fila_row(query_db($busca_adjudicacion)); 
		if($busca_adjudicacion_sql[0]>=1) {$no_adjudica=1; $pro27_id_no = $busca_adjudicacion_sql[1]; $pro30_id_no = $busca_adjudicacion_sql[0]; }


		/*echo $busca_adjudicacion = "select pro30_id, pro27_id from $vt15 where pro1_id = $id_invitacion  and pv_id = ".$_SESSION["id_proveedor"]." and notificado = 1 and tipo_adj_no_adj = 4";
		$busca_adjudicacion_sql = traer_fila_row(query_db($busca_adjudicacion)); 
		if($busca_adjudicacion_sql[0]>=1) $otros_estados=1;*/
		
		
		$sele_car=traer_fila_row(query_db("select count(*) from $v7 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"])) ;


		
$busca_alertas_docu = "select evaluador1_id from evaluador1_relacionpreguntas_admin where in_id = $id_invitacion and termino = 1";
$cuenta_criterio = query_db($busca_alertas_docu);
while($busca_criterios_alertas = traer_fila_row($cuenta_criterio))
	{
		$busca_alertas_docu_pro = "select count(*) from evaluador6_relaciondocumentos_proveedor where evaluador1_id = $busca_criterios_alertas[0] and pv_id = ".$_SESSION["id_proveedor"]."";		
		$cuenta_criterio_pro = traer_fila_row(query_db($busca_alertas_docu_pro));
		if($cuenta_criterio_pro[0]==0)
			$falta_alrta_economica = 1;
	
	}	
$busca_alertas_docu = "select evaluador1_id from evaluador1_relacionpreguntas_admin where in_id = $id_invitacion and termino = 2";
$cuenta_criterio = query_db($busca_alertas_docu);
while($busca_criterios_alertas = traer_fila_row($cuenta_criterio))
	{
		$busca_alertas_docu_pro = "select count(*) from evaluador6_relaciondocumentos_proveedor where evaluador1_id = $busca_criterios_alertas[0] and pv_id = ".$_SESSION["id_proveedor"]."";		
		$cuenta_criterio_pro = traer_fila_row(query_db($busca_alertas_docu_pro));
		if($cuenta_criterio_pro[0]==0)
			$falta_alrta_tecnica = 1;
	
	}	


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
    <td class="titulos_procesos">PROCESOS DE CONTRATACION</td>
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
<? if ($id_invitacion>=4117){ ?>

<? if ($falta_alrta_economica==1){ ?>
<table width="98%" border="0" align="center">
  <tr class="titulo_tabla_proveedor2">
    <td><strong class="texto_paginador_proveedor">ALERTA SU OFERTA NO HA SIDO ENVIADA A HOCOL SA,  FALTA COMPLETAR OFERTA ECONOMICA</strong></td>
  </tr>
</table>
<? } ?>
<? if ($falta_alrta_tecnica==1){ ?>
<table width="98%" border="0" align="center">
  <tr class="titulo_tabla_proveedor2">
    <td><strong class="texto_paginador_proveedor">ALERTA SU OFERTA NO HA SIDO ENVIADA A HOCOL SA,  FALTA COMPLETAR OFERTA TECNICA </strong></td>
  </tr>
</table>
<? } ?>
<? } ?>
<p>&nbsp;</p>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="24%" class="columna_titulo_resultados"><div align="center"><strong><img src="../imagenes/botones/aviso_observaciones.png" title="Aclaraciones al proceso" width="16" height="16"> Cartelera de aclaraciones</strong></div></td>
    <td width="25%" class="columna_titulo_resultados"><div align="center"><strong><img src="../imagenes/botones/2.gif" title="Comunicados generales" width="16" height="16"> Comunicados generales</strong></div></td>
    <? if($si_adjudica==1){ ?>
    <td width="18%" class="columna_titulo_resultados"><div align="center"><strong> <img src="../imagenes/botones/chulo.jpg" width="23" height="20"> Carta de adjudicaci&oacute;n</strong></div></td>
    <? } elseif($no_adjudica==1) { ?>
    <td width="16%" class="columna_titulo_resultados"><div align="center"><strong>Carta de NO adjudicaci&oacute;n</strong></div></td>
    <? } elseif($otros_estados==1) { ?>
    
    <td width="17%" class="columna_titulo_resultados"><strong><img src="../imagenes/botones/chulo.jpg" alt="Estados del proceso" width="23" height="20">Carta de estado del proceso</strong></td>
    <? }  ?>
    <?	if($sql_e[18] < $fecha." ".$hora){//si esta dentro del tiempo 
			if($sele_car[0]>=1){//si tiene aclaraciones
	 ?>
    <td width="17%" class="columna_titulo_resultados"><div align="center"><strong>Aclaraciones finales</strong></div></td>
    <? } } ?>
  </tr>
  <tr>
    <td valign="top" class="filas_resultados"><div align="left">La cartelera de aclaraciones estar&aacute; abierta durante el periodo se&ntilde;alado en el cronograma</div></td>
    <td valign="top"><div align="left">Tenga en cuenta que no se consideraran aclaraciones al proceso desde aqu&iacute;.</div></td>
    <? if($si_adjudica==1){ ?>
    <td valign="top" class="filas_resultados"><div align="left">Desde aqu&iacute; usted podra ver la carta y documento de la adjudicaci&oacute;n</div></td>
    <? } elseif($no_adjudica==1) { ?>
    <td valign="top" class="filas_resultados"><div align="left">Desde aqu&iacute; usted podra ver la carta de NO adjudicaci&oacute;n</div></td>
    <? } elseif($otros_estados==1) { ?>
    <td valign="top"><div align="left">Desde aqu&iacute; usted podra ver la carta de declaraci&oacute;n desierta</div></td>
    <? }  ?>
    <?	if($sql_e[18] < $fecha." ".$hora){//si esta dentro del tiempo 
			if($sele_car[0]>=1){//si tiene aclaraciones
	 ?>
    <td valign="top"><div align="left">Estara abierta durante el periodo se&ntilde;alado por el comprador</div></td>
    <? } } ?>
  </tr>
  <tr>
    <td class="filas_resultados"><input name="button10" type="button" class="buscar_ajustado" id="button10" value="Ingresar a la cartelera de aclaraciones" onClick="ajax_carga('cartelera-aclaraciones_<?=$id_invitacion_pasa;?>.php','contenidos')"></td>
    <td><input name="button10" type="button" class="buscar_ajustado" id="button11" value="Ingresar  a comunicaciones generales" onClick="ajax_carga('cartelera-comunicaciones_<?=$id_invitacion_pasa;?>.php','contenidos')"></td>
    <? if($si_adjudica==1){ ?>
    <td class="filas_resultados"><input name="button10" type="button" class="buscar_ajustado" id="button12" value="Ver carta de adjudicaci&oacute;n" onClick="ajax_carga('../aplicaciones/proveedores/adjudicacion_paso1.php?id_invitacion_pasa=<?=arreglo_pasa_variables($id_invitacion);?>&id_notificacion=<?=$pro30_id;?>&pro27_id=<?=$pro27_id;?>','contenidos')"></td>
    <? } elseif($no_adjudica==1) { ?>
    <td class="filas_resultados"><input name="button10" type="button" class="buscar_ajustado" id="button13" value=" Ver carta de No adjudicaci&oacute;n" onClick="ajax_carga('../aplicaciones/proveedores/adjudicacion_paso1_no.php?id_invitacion_pasa=<?=arreglo_pasa_variables($id_invitacion);?>&id_notificacion=<?=$pro30_id_no;?>&pro27_id=<?=$pro27_id_no;?>','contenidos')"></td>
    <? } elseif($otros_estados==1) { ?>
    	<td><span class="filas_resultados"><input name="button6" type="button" class="buscar_ajustado" id="button6" value=" Ver carta otros estados" onClick="ajax_carga('../aplicaciones/proveedores/adjudicacion_paso1_otros.php?id_invitacion_pasa=<?=arreglo_pasa_variables($id_invitacion);?>&id_notificacion=<?=$busca_adjudicacion_sql[0];?>&pro27_id=<?=$busca_adjudicacion_sql[1];?>','contenidos')"></span></td>
    <? }  ?>
    <?	if($sql_e[18] < $fecha." ".$hora){//si esta dentro del tiempo 
	 	$sele_car=traer_fila_row(query_db("select count(*) from $v7 where pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"])) ;
			if($sele_car[0]>=1){//si tiene aclaraciones
	 ?>
    <td><input name="button10" type="button" class="buscar_ajustado" id="button14" value="Ingresar aclaraciones finales" onClick="ajax_carga('cartelera-aclaraciones-finales_<?=$id_invitacion_pasa;?>.php','contenidos')"></td>
    <? } }?>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="4" cellspacing="4" class="tabla_lista_resultados" >
  <tr>
    <td colspan="3" class="columna_titulo_resultados"><strong>Cronograma del proceso</strong></td>
  </tr>
  <tr>
    <td width="33%" class="titulo_tabla_azul_sin_bordes">Cronograma</td>
    <td width="23%" class="titulo_tabla_azul_sin_bordes">Fecha apertura</td>
    <td width="44%" class="titulo_tabla_azul_sin_bordes">Fecha cierre</td>
  </tr>
  <tr class="campos_gris_cronograma">
    <td><div align="right"><strong>
      Fecha de apertura y cierre general
    :</strong></div></td>
    <td><div align="center">
      <?=fecha_for_hora($sql_e[17]);?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($sql_e[18]);?>
    </div></td>
  </tr>
  <tr class="campos_blancos_cronograma">
    <td><div align="right"><strong> Fecha de recepci&oacute;n de  aclaraci&oacute;n      :</strong></div></td>
    <td><div align="center">
      <?=fecha_for_hora($sql_e[29]);?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($sql_e[34]);?>
    </div></td>
  </tr>
  <? if($sql_e[41]!=""){?>
  <tr  >
    <td ><div align="right" class="fondo_2"><strong>
    Fecha y hora de reuni&oacute;n informativa      :</strong></div></td>
    <td colspan="2"><div align="center" class="fondo_2">
      <div align="left">
        <?=fecha_for_hora($sql_e[41]);?>
        <strong>| Asistencia obligatoria</strong>:
        <?=$sql_e[8];?>
      </div>
    </div></td>
  </tr>
  <? } ?>
  <? if($sql_e[30]!=""){?>
  <tr  >
    <td><div align="right" class="fondo_2"><strong>Lugar de reuni&oacute;n informativa:</strong></div></td>
    <td colspan="2" class="fondo_2"><?=$sql_e[30];?></td>
  </tr>
  <? } ?>
  <? if($sql_e[35]!=""){?>
  
  <? } ?>
  <tr class="campos_gris_cronograma">
    <td><div align="right"><strong>
      Fechas de recepci&oacute;n ofertas t&eacute;cnicas      :</strong></div></td>
    <td><div align="center">
      <?=fecha_for_hora($sql_e[25]);?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($sql_e[26]);?>
    </div></td>
  </tr>
  <tr class="campos_blancos_cronograma">
    <td><div align="right"><strong>
      Fecha envio documentos econ&oacute;micos      :</strong></div></td>
    <td><div align="center">
      <?=fecha_for_hora($sql_e[23]);?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($sql_e[24]);?>
    </div></td>
  </tr>

  <tr class="campos_gris_cronograma">
    <td><div align="right"><strong>
    Fecha envio ofertas econ&oacute;micas      :</strong></div></td>
    <td><div align="center"><?=fecha_for_hora($sql_e[27]);?> </div></td>
    <td><div align="left">
      <?=fecha_for_hora($sql_e[28]);?> 
    </div></td>
  </tr>

</table>

<br>

<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<tr>
  <td colspan="5" class="columna_titulo_resultados"><strong>Documentos del proceso</strong></td>
  </tr>
<tr>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tipo documento</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="35%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="22%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
                <?	if(($sql_e[1]==2) || ($sql_e[1]==4) ){//si esta dentro del tiempo ?>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
                <?	}//si esta dentro del tiempo ?>
              </tr>
             
	                      <? if($requiere_generar_pliego=="Si"){ ?>
               <tr class="<?=$class;?>">
                 <td>Generales</td>
                 <td><img src="../imagenes/mime/pdf.gif" alt="Pdf" /></td>
                 <td>Pliego, terminos y condiciones</td>
                 <td>N/D</td>
                 <td><div align="center">
                  <input name="button" type="button" class="buscar" id="button" onClick="window.open('pliego-terminos-condiciones_<?=$sql_e[22];?>_<?=$id_invitacion;?>.pdf')" value="Descargar documento">
</div></td>
               </tr>
               <? } ?>

             
               <?
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga ,origen,if(id_origen=0,$t6.pro2_id,id_origen) from $t6, $tp8 where
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
                <td><?=fecha_for_hora($lp[4]);?></td>
                <?	if(($sql_e[1]==2) || ($sql_e[1]==4) ){//si esta dentro del tiempo ?>  <td>
                  <input name="button" type="button" class="buscar" id="button" onClick="window.parent.location.href='../librerias/php/descarga_documentos_generales.php?n1=<?=$lp[6];?>&n2=<?=$lp[2];?>&id_invitacion=<?=$id_invitacion;?>&n3=<?=$lp[5];?>'" value="Descargar documento">
               
                </td><? }//si esta dentro del tiempo ?>
  </tr>
              
              <? $num_fila++;} ?>
</table>
<br>


<?	if($sql_e[18]>=$fecha." ".$hora){//si esta dentro del tiempo ?>
<br>

            
            <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="2" class="columna_titulo_resultados"><strong >Confirmaci&oacute;n de participaci&oacute;n en el proceso</strong></td>
              </tr>
              <tr>
                <td width="31%"><div align="right"><strong>Confirma participar en la invitaci&oacute;n ?:</strong></div></td>
                <td width="69%"><div align="left">
                  <label>
                  <select name="confirmacion" id="confirmacion">
                    <option value="0">Seleccione</option>
                    <option value="1" <? if($busca_confirmacion[3]==1) echo "selected";?> >Si</option>
                    <option value="2" <? if($busca_confirmacion[3]==2) echo "selected";?> >No</option>
                  </select>
                  </label>
                </div></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Justificaci&oacute;n:</strong></div></td>
                <td><label>
                  <div align="left">
                    <textarea name="justifica" id="justifica" cols="100" rows="2"><?=$busca_confirmacion[5];?></textarea>
                    </div>
                </label></td>
              </tr>
              <tr>
                <td colspan="2"><div align="center">
                  <label>
                  <input name="button2" type="button" class="guardar" id="button2" onClick="confirma_partici()" value="Enviar confirmaci&oacute;n">                  </label>
                </div></td>
              </tr>
            </table>


            <p>
  <?

}//si esta dentro del tiempo

$busca_juridico = "select count($t89.rel9_aspecto),$t5.apertura_juridica,$t5.cierre_juridica from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 1 and
		$t5.pro1_id = $t91.in_id  GROUP BY $t89.rel9_aspecto";
		$exs=traer_fila_row(query_db($busca_juridico));


		$busca_tecnico = "select count($t89.rel9_aspecto), $t5.apertura_tecnica  , $t5.cierre_tecnica  from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 2 and
		$t5.pro1_id = $t91.in_id  GROUP BY rel9_pregutas_evaluador.rel9_aspecto ";
		$exs_te=traer_fila_row(query_db($busca_tecnico));
		
		
		  $busca_economico = "select count(evaluador5_id ) from $t95 where 
		in_id = $id_invitacion    ";
		$exs_eco=traer_fila_row(query_db($busca_economico));

	$total_eva = ($exs[0]+$exs_te[0]+$exs_eco[0]);
	
	//if($total_eva==0){//si tiene evaluacion no solicita documentos

?>
              
              
              
  <br>

<? if ($id_invitacion>=4117){ ?>

<? if ($falta_alrta_economica==1){ ?>
<table width="98%" border="0" align="center">
  <tr class="titulo_tabla_proveedor2">
    <td><strong class="texto_paginador_proveedor">ALERTA SU OFERTA NO HA SIDO ENVIADA A HOCOL SA,  FALTA COMPLETAR OFERTA ECONOMICA</strong></td>
  </tr>
</table>
<? } ?>
<? if ($falta_alrta_tecnica==1){ ?>
<table width="98%" border="0" align="center">
  <tr class="titulo_tabla_proveedor2">
    <td><strong class="texto_paginador_proveedor">ALERTA SU OFERTA NO HA SIDO ENVIADA A HOCOL SA,  FALTA COMPLETAR OFERTA TECNICA </strong></td>
  </tr>
</table>
<? } ?>
<? } ?>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <td class="columna_titulo_resultados"><strong >INGRESE SUS OFERTAS TECNICAS Y ECONOMICAS</strong></td>
              </tr>
            </table>
            <table width="98%" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <? if ($exs_te[0]>=1){
				

  $grupo_terminos = query_db("select distinct $t89.rel9_detalle,$t89.rel9_id from $t89, $t90, $t91
	 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t89.rel9_aspecto=2");
	 while($l_grupo=traer_fila_row($grupo_terminos)){  
 
			//---------------------------------------------------------------------------------------------------------------
		  $grupo_criterio = query_db("select $t90.rel10_detalle,$t91.evaluador1_id from $t89, $t90, $t91
			 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t90.rel9_id = $l_grupo[1]");
			 while($l_criterio=traer_fila_row($grupo_criterio)){  
		
			  $cuenta_archivos = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
			  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_nombre !=''"));
		
			  $cuenta_observa = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
			  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_observaciones !=''"));
				
				$si_no = ($cuenta_archivos[0]+$cuenta_observa[0]);
				  
			  if($si_no>=1){
				$ima_archivo='<img src="../imagenes/botones/icono_aceptar.gif" alt="El criterio tiene por lo menos un archivo" />';
				$respuesta_te= $cuenta_archivos[0]." documentos enviados";
				$class_tec="oferta_ganadora";
				}
			 else{
				$ima_archivo='<img src="../imagenes/botones/icono_X.gif" alt="El criterio NO tiene archivos" />';
				$respuesta_te="No ha enviado documentos";
				$class_tec="oferta_perdedora";
				}
		}
		
	}
		
		//---------------------------------------------------------------------------------------------------------------
		
		
//-------------------------------comercial--------------------------------------------

 $grupo_terminos = query_db("select distinct $t89.rel9_detalle,$t89.rel9_id from $t89, $t90, $t91
	 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t89.rel9_aspecto=1");
	 while($l_grupo=traer_fila_row($grupo_terminos)){  
 
			//---------------------------------------------------------------------------------------------------------------
		  $grupo_criterio = query_db("select $t90.rel10_detalle,$t91.evaluador1_id from $t89, $t90, $t91
			 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t90.rel9_id = $l_grupo[1]");
			 while($l_criterio=traer_fila_row($grupo_criterio)){  
		
			  $cuenta_archivos = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
			  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_nombre !=''"));
		
			  $cuenta_observa = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
			  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_observaciones !=''"));
				
				$si_no_co= ($cuenta_archivos[0]+$cuenta_observa[0]);
				  
			  if($si_no_co>=1){
				$ima_archivo_co='<img src="../imagenes/botones/icono_aceptar.gif" alt="El criterio tiene por lo menos un archivo" />';
				$respuesta_co= $cuenta_archivos[0]." documentos enviados";
				$class_co="oferta_ganadora";
				}
			 else{
				$ima_archivo_co='<img src="../imagenes/botones/icono_X.gif" alt="El criterio NO tiene archivos" />';
				$respuesta_co="No ha enviado documentos";
				$class_co="oferta_perdedora";
				}
		}
		
	}
//---------------------------------------------------------------------------------------------------------------		


$busca_ofertas_economica=traer_fila_row(query_db("select if(count(*)>=1,'1', '0') from $v11 where in_id  = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." and w_valor != ''  "));

	  if($busca_ofertas_economica[0]==1){
				$ima_archivo_eco='<img src="../imagenes/botones/icono_aceptar.gif" alt="El criterio tiene por lo menos un archivo" />';
				$respuesta_eco= " Existen valores digitados";
				$class_eco="oferta_ganadora";
				}
			 else{
				$ima_archivo_eco='<img src="../imagenes/botones/icono_X.gif" alt="El criterio NO tiene archivos" />';
				$respuesta_eco="No existen valores digitados";
				$class_eco="oferta_perdedora";
				}						
				
				 ?><td width="33%" valign="top">
                 <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" height="150px">
                  <tr>
                    <td width="5%"><?=$ima_archivo;?></td>
                    <td class="<?=$class_tec;?>" ><?=$respuesta_te;?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="justify"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18">
                      Desde aqu&iacute; usted  puede enviar &uacute;nicamente los documentos t&eacute;cnicos solicitados en el proceso,&nbsp;<strong>NO </strong>envi&eacute;  ofertas comerciales ni econ&oacute;micas
                    </div></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="center"><input name="button5" type="button" class="buscar" id="button5" onClick="ajax_carga('invitacion_tecnica_<?=$id_invitacion_pasa;?>.php','contenidos')" value="  Ingresar ofertas  t&eacute;cnicas" /></div></td>
                  </tr>
                </table></td> <? } ?>
                <? if ($exs[0]>=1){ ?>
                
                <td width="33%" valign="top">
                <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" height="150px">
                  <tr>
                    <td width="5%"><?=$ima_archivo_co;?></td>
                    <td class="<?=$class_co;?>" ><?=$respuesta_co;?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="justify"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Desde  aqu&iacute; usted puede enviar &uacute;nicamente los documentos con su oferta comercial y econ&oacute;mica.</div></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="center"><input name="button3" type="button" class="buscar" id="button3" onClick="ajax_carga('invitacion_juridica_<?=$id_invitacion_pasa;?>.php','contenidos')" value="  Ingresar oferta comercial" /></div></td>
                  </tr>
                </table></td><? } ?>
                <? if($exs_eco[0]>=1){ ?><td width="33%"><table width="86%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" height="150px">
                  <tr>
                    <td width="5%"><?=$ima_archivo_eco;?></td>
                    <td class="<?=$class_eco;?>" ><?=$respuesta_eco;?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="justify"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18">
                    Desde aqu&iacute; usted puede digitar los valores econ&oacute;micos  solicitados en el proceso.</div></td>
                  </tr>
                  <tr>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><div align="center">
                      <?  if ( ($fecha." ".$hora >= $sql_e[27]  ) && ($sql_e[28] >= $fecha." ".$hora ) ) { 	 ?>
                      <input name="button4" type="button" class="buscar" id="button4" onClick="ajax_carga('../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=1','contenidos' )" value="  Ingresar ofertas econ&oacute;micas"/>
                      <? } else { ?>
                      <input name="button4" type="button" class="buscar" id="button4" onClick="ajax_carga('../aplicaciones/proveedores/c_economico_historico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=1','contenidos' )" value="  Ingresar ofertas econ&oacute;micas"/>
                      <? }//si esta dentro del tiempo 
				
				
				?>
                    </div></td>
                  </tr>
                </table></td><? } ?>
              </tr>
            </table>
  
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
</body>
</html>