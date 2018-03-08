<?  include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));

$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));

function detalle_aspecto($aspecto,$campo){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select pro1_id, $campo from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return $busca_detalle_apertura[1];
	else
	return "Sin apertura";
}

$oferta_vista = 1;   
$valor_apertura_auditor=100000;

             /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
			 
                    if($linvi[13]==1)
                        $cuantia=$linvi[14];
                    elseif($linvi[13]==2)
                    $cuantia=($linvi[14]+1) / 1800;
                    elseif($linvi[13]==3)
                        $cuantia=( ($linvi[14]+1) * 2700 ) / 1800;			
                
                $cuantia_arr = explode(".",$cuantia);		
                $cuantia =$cuantia_arr[0];		
                
				
                /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
		if($buscar_datos_ap[1]>=1){ 
        $busca_firma=traer_fila_row(query_db("select * from v_apertura_proceso_grantierra where pro1_id = $id_invitacion"));
		



?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">

<script>
function calcula_valor()
	{
	var forma = document.formulario

			forma.action = "c_economico4.php";
			forma.submit();

	}



</script>
</head>
<body >
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: ACTA DE APERTURA DEL PROCESO</td>
  </tr>
</table>
<BR>
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>

<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td width="42%" height="26"><div align="left"><strong>Consecutivo del proceso:</strong><?=$linvi[22];?></div></td>
  </tr>
  <tr>
    <td height="26"><strong>Fecha y hora de apertura:</strong><?=fecha_for_hora($linvi[17]);?></td>
  </tr>
  <tr>
    <td height="26"><strong>Fecha y hora de cierre:</strong><?=fecha_for_hora($linvi[18]);?></td>
  </tr>
  <tr>
    <td height="26"><div align="left"><strong>
      <?=$lenguaje_0;?>
      :</strong>
      <?=$linvi[12];?>
</div>     </td>
  </tr>
</table>
</fieldset>
<br>
<fieldset style="width:98%">
			<legend>Informaci&oacute;n de apertura</legend>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="24%"><div align="left"><strong>Fecha de apertura:</strong>
      <?=$buscar_datos_ap[5];?>
    </div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Hora de apertura:</strong>
      <?=$buscar_datos_ap[6];?><input type='hidden' name='lugar_apertura' value="1">
   </div></td>
  </tr>
  <tr>
    <td><strong>Usuario Apertura: 
        <?=$busca_firma[2];?>
    </strong></td>
  </tr>
  <tr>
    <td><strong>Usuario Compras: 
      <?=$busca_firma[3];?>
    </strong></td>
  </tr>  
</table>
</fieldset>
<p>&nbsp;</p>
<fieldset style="width:98%">
			<legend>Apertura de requerimientos</legend>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td  colspan="3" class="columna_titulo_resultados">APERTURA EVALUACION DE REQUERIMIENTOS  SOLICITADOS EN EL PROCESO</td>
  </tr>
  <tr>
    <td width="238" class="columna_subtitulo_resultados">Requerimientos</td>
    <td width="190" class="columna_subtitulo_resultados">Usuario de apertura</td>
    <td width="306" class="columna_subtitulo_resultados">Fecha apertura</td>
  </tr>

  <tr class="campos_gris_listas">
    <td ><div align="right"><strong>Apertura t&eacute;cnica</strong></div></td>
    <td><?=detalle_aspecto(2,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(2,"fecha_apertura");?></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Apertura comercial </strong></div></td>
    <td><?=detalle_aspecto(1,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(1,"fecha_apertura");?></td>
  </tr>

  <tr class="filas_resultados">
    <td class="campos_gris_listas"><div align="right"><strong>Apertura lista de precios</strong></div></td>
    <td class="campos_gris_listas"><?=detalle_aspecto(3,"nombre_administrador");?></td>
    <td class="campos_gris_listas"><?=detalle_aspecto(3,"fecha_apertura");?></td>
  </tr>

</table>
<p><br>
</fieldset>
</p>
<fieldset style="width:98%">
			<legend>Proponentes</legend>

            <input type="hidden" name="accion">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">




<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="139" class="columna_subtitulo_resultados">NIT</td>
    <td width="178" class="columna_subtitulo_resultados">proveedor</td>
    <td width="85" class="columna_subtitulo_resultados">Confirmaci&oacute;n</td>
    <td width="132" class="columna_subtitulo_resultados">Fecha</td>
    <td width="330" class="columna_subtitulo_resultados">Justificaci&oacute;n</td>
  </tr>

<?

	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup, $t7.observaciones  ,$t7.observaciones_2 from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id <> 1 ");
				while($lp = traer_fila_row($busca_provee)){
 				$busca_confirmacion = traer_fila_row(query_db("select * from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by  fecha desc"));

	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
 
 ?>
<tr class="<?=$class;?>">
    <td><?=$lp[1];?></td>
    <td><div align="left"><?=$lp[2];?></div></td>
	<td><?=$busca_confirmacion[2];?></td>
    <td><?=fecha_for_hora($busca_confirmacion[3]);?></td>
    <td><?=$busca_confirmacion[4];?></td>    
  </tr>
  
  <? 

$num_fila++;   
   
   } 
   ?>
</table>

</fieldset>

<br>


<fieldset style="width:98%">
<legend>Resumen</legend>
			<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="5" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Resumen de acciones y ofertas enviadas por el proveedor.</td>
              </tr>
              <tr>
                <td width="49%" class="columna_subtitulo_resultados"><div align="center">Nombre</div></td>
                <td width="13%" class="columna_subtitulo_resultados"><div align="center">Fecha de visualiza proceso</div></td>
                <td width="14%" class="columna_subtitulo_resultados"><div align="center">Envio ofertas t&eacute;cnicas</div></td>
                <td width="11%" class="columna_subtitulo_resultados"><div align="center">Envio ofertas comerciales</div></td>
                <td width="13%" class="columna_subtitulo_resultados"><div align="center">Envio ofertas ec&oacute;nomicas</div></td>
              </tr>
              <?
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
			$documentos_faltantes = 0;
			$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$lp[0]));
			$busca_confirmacion = traer_fila_row(query_db("select confirmacion  from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by pro4_id desc"));
			$busca_ofertas_tecnicas=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 2  "));
			$busca_ofertas_comercial=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 1  "));
			$busca_ofertas_economica=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v11 where in_id  = $id_invitacion and pv_id = $lp[0] and w_valor != ''  "));
			$busca_comuniocados_faltantes = traer_fila_row(query_db("select count(*) from $t29 where pro1_id = $id_invitacion and pv_id = $lp[0] and tp13_id  in (1,2,3,4) and estado = 1 and quien_ingresa != 'Proveedor'"));
			$busca_docuemntos_anexos=traer_fila_row(query_db("select count(*) from $t6 where pro1_id = $id_invitacion"));
			$busca_docuemntos_descagados=traer_fila_row(query_db("select count(distinct detalle) from $v5 where pro1_id = $id_invitacion and auditor_categoria_id = 3 and pv_id = $lp[0]"));
			$documentos_faltantes = ($busca_docuemntos_anexos[0]-$busca_docuemntos_descagados[0]);
							
			if($busca_confirmacion[0]=='')	$estado_conf="N / C";
			else $estado_conf=$busca_confirmacion[0];
  ?>
              <tr class="<?=$class;?>">
                <td><?=$lp[2];?></td>
                <td><?=$busca_ingresos[4];?></td>
                <td><div align="center">
                  <?=$busca_ofertas_tecnicas[0];?>
                </div></td>
                <td><div align="center">
                  <?=$busca_ofertas_comercial[0];?>
                </div></td>
                <td><div align="center">
                  <?=$busca_ofertas_economica[0];?>
                </div></td>
              </tr>
              <? $num_fila++;
			  
			  } ?>
            </table>
</fieldset>

<fieldset style="width:98%">
<legend>Auditoria del proceso</legend>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Se muestra en detalle cualquier acci&oacute;n realizada a este proceso.</div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td width="18%" class="columna_subtitulo_resultados">Accion</td>
    <td width="17%" class="columna_subtitulo_resultados">Nombre usuario</td>
    <td width="15%" class="columna_subtitulo_resultados">Fecha</td>
    <td width="38%" class="columna_subtitulo_resultados">Comentarios</td>
    <td width="12%" class="columna_subtitulo_resultados">IP de conexion</td>
  </tr>
  <?
			  	
			  	$busca_provee = query_db("select * from $v5 where pro1_id =  $id_invitacion  order by fecha_hora desc ");
				while($lp = traer_fila_row($busca_provee)){
				  
				 if($lp[0]==3){
				 	$detalle2=traer_fila_row(query_db("select * from $t6 where pro2_id = $lp[9]"));
					$detalle=$detalle2[3];
					}
				else $detalle=$lp[9];
				
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

	if( ($lp[0]==37) || ($lp[0]==38) )
		$comple=$lp[9];
	else $comple="";
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lp[1];?></td>
    <td><?=$lp[5];?></td>
    <td><?=$lp[8];?></td>
    <td><?=$detalle;?></td>
    <td><?=$lp[10];?></td>
  </tr>
  <? $num_fila++;
			 
			  } ?>
</table>
</fieldset>

<fieldset style="width:98%">
<legend>Firmas</legend>

            <table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="47%">&nbsp;</td>
                <td width="6%">&nbsp;</td>
                <td width="47%">&nbsp;</td>
              </tr>
              <tr>
                <td class="titulos_procesos">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="titulos_procesos">&nbsp;</td>
              </tr>
              <tr>
                <td><strong><?=$busca_firma[3];?></strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  <?=$busca_firma[2];?>
                </strong></td>
              </tr>
              <tr>
                <td><strong>Delegado Compras</strong></td>
                <td>&nbsp;</td>
                <td><strong>Delegado  Apertura</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
</fieldset>

<? } ?>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
      <div align="center">
    <?
		if($buscar_datos_ap[1]>=1){ ?>
<!--	        <input name="button" type="button" class="guardar" id="button" value="Exportar acta" onClick="window.open('apertura_acta_<?=$id_invitacion;?>.html')">-->
	<input name="button" type="button" class="guardar" id="button" value="Exportar acta" onClick="window.open('../librerias/pdf/funcion_pdf.php?id_invitacion=<?=$id_invitacion;?>')">
        <? } else { 
			if($_SESSION["tipo_usuario"]==4) {
		?>
            <input name="button" type="button" class="guardar" id="button" value="Grabar registro" onClick="graba_apertura_licita()">
            <? 
				}
			} ?>
            
            
            <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
    </div>    </td>
  </tr>
</table>
<br>
<input type="hidden" name="id_invitacion_apertura" value="<?=$id_invitacion;?>">
<input type="hidden" name="accion_apertura">
<input type="hidden" name="responsable_pro" value="<?=$linvi[15];?>">
<input type="hidden" name="cuantia_pasa" value="<?=$cuantia;?>">


</body>
</html>
