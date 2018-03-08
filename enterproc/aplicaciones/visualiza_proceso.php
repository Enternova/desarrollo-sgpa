<? include("../librerias/lib/@session.php");

header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$id_proceso = elimina_comillas($id_p);
	
if($id_proceso!=""){
	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	$busca_responsable_a = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 1"));
	$busca_responsable_j = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 3"));
	$busca_responsable_t = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 2"));
	$busca_responsable_e = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 5"));
	$trm_vi =$sql_e[42];
	$persona_contacto=$sql_e[15];
	
	$requiere_auditor_c=$sql_e[44];
	$entrega_doc_fisicos=$sql_e[8];
	
	}
	else { $trm_vi = $tr_configu;
	$persona_contacto=$_SESSION["id_us_session"];
	
	 }
	
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="popup2" align="center"><div id="pContent"></div></div>
<div id="oculta_todo_proveedores">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="82%" class="titulos_procesos">SECCION: PROCESOS DE CONTRATACION</td>
    <td width="18%"><? if($ruta_ev==1){ ?><input name="button" type="button" class="cancelar" id="button" value="Volver a la evaluaci&oacute;n" onclick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_p;?>','contenidos')" /><? } ?></td>
  </tr>
</table>
<br />
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="95%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados" ><div align="right"><strong> Consecutivo del proceso:</strong></div></td>
    <td width="23%" class="filas_resultados"><?=$sql_e[22];?>	</td>
    <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud</strong>:</div></td>
    <td width="34%"><div align="left" class="filas_resultados"><?=listas_sin_select($tp3,$sql_e[3],1);?>
     
    </div></td>
  </tr>
  <tr>
    <td width="22%" class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de proceso:</strong></div></td>
    <td colspan="3"><div align="left">
      <?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div>      <div align="right"></div>    <div align="left"></div></td>
    </tr>
  <tr>
    <td class="columna_subtitulo_resultados" ><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td colspan="3">
      <div align="left" class="filas_resultados">
       <?=$sql_e[12];?>
      </div>    </td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados" ><div align="right"><strong> Persona de contacto:</strong></div></td>
    <td colspan="3"><?=listas_sin_select($t1,$persona_contacto,1);?>    <div align="right"></div></td>
    </tr>
</table>
<br />
<? if($id_proceso>=1){?>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
      <input name="button8" type="button" class="buscar" id="button8" value="Ingresar a la cartelera de aclaraciones" onclick="ajax_carga('../aplicaciones/visualiza_cartelera.php?id_invitacion_pasa=<?=$id_proceso;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')"/>
      <input name="button3" type="button" class="buscar" id="button3" value="Ingresar a comunicaciones generales" onclick="ajax_carga('../aplicaciones/visualiza_comunicados.php?id_invitacion_pasa=<?=$id_proceso;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')" />
   </td>
  </tr>
</table>
<? } ?>
</fieldset>
<br />

<fieldset style="width:98%">
			<legend>Cronograma del proceso</legend>
            
            <table width="98%" border="0" cellpadding="3" cellspacing="3" class="tabla_cronograma" >
              <tr>
                <td width="24%" class="titulo_tabla_azul_sin_bordes">Cronograma</td>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Fecha apertura</td>
                <td width="14%" class="titulo_tabla_azul_sin_bordes">Fecha cierre</td>
                <td width="11%" class="titulo_tabla_azul_sin_bordes">% Global</td>
                <td width="13%" class="titulo_tabla_azul_sin_bordes">% Minimo aceptado</td>
                <td width="20%" class="titulo_tabla_azul_sin_bordes">Responsable</td>
                <td width="3%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fechas de apertura y cierre general:</strong></div></td>
                <td><div align="center">
                  <?=valida_fecha_vacia($sql_e[17]);?>
                </div></td>
                <td><div align="center"> <?=valida_fecha_vacia($sql_e[18]);?>
                </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><input name="h" type="hidden" class="f_fechas" id="h"  onmousedown="calendario_se('h')" value="<?=valida_fecha_vacia($sql_e[16]);?>" /><input name="a_j7" type="hidden" class="f_fechas" id="a_t_a" onmousedown="calendario_se('a_t_a')"  value="<?=valida_fecha_vacia($sql_e[37]);?>"/><input name="a_j8" type="hidden" class="f_fechas" id="a_t_c" onmousedown="calendario_se('a_t_c')" value="<?=valida_fecha_vacia($sql_e[38]);?>"/></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td><div align="right"><strong>Periodo de aclaraciones:</strong></div></td>
                <td> <div align="center">
                  <?=valida_fecha_vacia($sql_e[29]);?>
                </div></td><td><div align="center"> <?=valida_fecha_vacia($sql_e[34]);?>
                </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td ><div align="right"><strong>Fecha y hora de reuni&oacute;n informativa:</strong></div></td>
                <td ><div align="center">
                  <?=valida_fecha_vacia($sql_e[41]);?>
                </div></td>
                <td ><div align="right"><strong>Asistencia obligatoria:</strong></div></td>
                <td><?=$entrega_doc_fisicos;?></td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
              <tr class="filas_resultados">
                <td height="32" ><div align="right"><strong>Lugar de reuni&oacute;n informativa</strong>:</div></td>
                <td colspan="6" >
                  <div align="left">
                    <?=$sql_e[30];?>
                  </div></td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td ><div align="right"><strong>Fechas de recepci&oacute;n ofertas  t&eacute;cnicas:</strong></div></td>
                <td ><div align="center">
                  <?=valida_fecha_vacia($sql_e[25]);?>
                </div></td>
                <td ><div align="center"><?=valida_fecha_vacia($sql_e[26]);?>
                </div></td>
                <td><div align="center"> <?=valida_fecha_vacia($sql_e[19]);?>
                </div>
                    <div align="center"></div></td>
                <td ><div align="center"><?=valida_fecha_vacia($sql_e[20]);?>
                </div>
                    <div align="center"></div></td>
                <td ><?=listas_sin_select($t1,$busca_responsable_t[1],1);?></td>
                <td >
                  <? 	if($sql_e[15]==$_SESSION["id_us_session"]){ ?>
                <img src="../imagenes/botones/editar.jpg" width="14" height="15"  onclick="ajax_carga('../aplicaciones/reemplaza_tecnico_proceso.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>','contenidos')"  />
                <? } ?>
                
              </tr>

              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fechas recepci&oacute;n ofertas econ&oacute;micas:</strong></div></td>
                <td> <div align="center">
                  <?=valida_fecha_vacia($sql_e[23]);?>
                </div></td><td><div align="center"> <?=valida_fecha_vacia($sql_e[24]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><?=listas_sin_select($t1,$busca_responsable_j[1],1);?></td>
                <td>&nbsp;</td>
              </tr>

              <tr class="campos_gris_cronograma">
                <td><div align="right"><strong>Fechas recepci&oacute;n lista de precios:</strong></div></td>
                <td> <div align="center">
                  <?=valida_fecha_vacia($sql_e[27]);?>
                </div></td><td><div align="center"><?=valida_fecha_vacia($sql_e[28]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><?=listas_sin_select($t1,$busca_responsable_e[1],1);?></td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <br />
</fieldset>            

<br />


<? if($id_proceso!=""){ ?>

<br />
<fieldset style="width:98%">
			<legend>Proveedores invitados</legend>
<?	if($sql_e[1]<=4){//si ya esta adjudicado	?>
<?	}	?>            
<table width="97%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
              <tr>
                <td width="2%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                <td width="29%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="26%" class="titulo_tabla_azul_sin_bordes">E-mail (Usuario principal)</td>
                <td width="2%" class="titulo_tabla_azul_sin_bordes"><img src="../imagenes/botones/help.gif" width="18" height="18" alt="Se refiere al n&uacute;mero de procesos que ha participado el proveedor, si desea ver el detalle presione sobre el numero" title="Se refiere al n&uacute;mero de procesos que ha participado el proveedor, si desea ver el detalle presione sobre el numero" /></td>
                <td width="3%" class="titulo_tabla_azul_sin_bordes">Inv.</td>
                <td width="12%" class="titulo_tabla_azul_sin_bordes">Otros e-mail</td>
                <td class="titulo_tabla_azul_sin_bordes">Bit&aacute;cora</td>
                <? if($sql_e[31]==1){ ?><? } ?>
               <?	if($sql_e[1]<=4){//si ya esta adjudicado	?> <?	} ?>
              </tr>

                            
              <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			  
			  	$busca_participacion = traer_fila_row(query_db("select count(*) from $t7 where pv_id = $lp[0] "));
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>

              <tr class="<?=$class;?>">
    <td><?=$lp[1];?></td>
                <td><?=$lp[2];?></td>
                <td><?=$lp[4];?></td>
                <td colspan="2"><div align="center"><a href="javascript:void(0)" onclick="msgbox('../aplicaciones/reporte_proveedores-procesos.php?pv_id_pasa=<?=arreglo_pasa_variables($lp[0]);?>');">
                  <?=$busca_participacion[0];?>
                </a></div></td>
                <td><input name="button11" type="button" class="buscar" id="button11" value="Contactos" onclick="ajax_carga('../aplicaciones/visualiza_contactos_proceso.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>&ruta_ev=<?=$ruta_ev;?>','carga_evaluacion');ingresar_listado('oculta_todo_proveedores')" /></td>
          <td width="11%"><label>
                  <input name="button4" type="button" class="buscar" id="button4" value="Bitacora" onclick="ajax_carga('../aplicaciones/visualiza_bitacora.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>&ruta_ev=<?=$ruta_ev;?>','carga_evaluacion');ingresar_listado('oculta_todo_proveedores')" />
                </label></td>
                <? if($sql_e[31]==1){ ?><? } ?>
               <?	if($sql_e[1]<=4){//si ya esta adjudicado	?> <?	} ?>
              </tr>
              <? $num_fila++;} ?>
            </table>
<br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Documentos del proceso</legend>
<?	if($sql_e[1]<=4){//si ya esta adjudicado	?>
<?	}	?>
<table width="97%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tipo documento</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="35%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Tama&ntilde;o</td>
                <td width="22%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes" >Descargar</td>
                <?	if($sql_e[1]<=4){//si ya esta adjudicado	?><?	}	?>
              </tr>
              <? if($requiere_generar_pliego=="Si"){ ?>
               <tr class="<?=$class;?>">
                 <td>Generales</td>
                 <td><img src="../imagenes/mime/pdf.gif" alt="Pdf" /></td>
                 <td>Pliego, terminos y condiciones</td>
                 <td>N/D</td>
                 <td>N/D</td>
                 <td><div align="center"><a href="pliego-terminos-condiciones_<?=$sql_e[22];?>_<?=$id_proceso;?>.pdf"  target="_blank"><img src="../imagenes/botones/descargar_documentos.gif" alt="descargar documento" title="descargar documento" onClick="" /></a></div></td>
               </tr>
               <? } ?>
             
               <?
			 
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga,tipo_archivo,if(origen=1,'Urna','Solicitud'),origen,if(id_origen=0,$t6.pro2_id,id_origen) from $t6, $tp8 where
				$t6.pro1_id =  $id_proceso and $tp8.tp8_id = $t6.tp8_id");
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
                <td><div align="center"><a href="javascript:void(0)"><img src="../imagenes/botones/descarga_doc.png"  alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_generales.php?n1=<?=$lp[8];?>&n2=<?=$lp[2];?>&n3=<?=$lp[7];?>'" /></a></div></td>
                <?	if($sql_e[1]<=4){//si ya esta adjudicado	?><?	} ?>
              </tr>
              
              <? $num_fila++;} ?>
            </table>
  <br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend><?=$lenguaje_12;?></legend>

            <table width="97%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
  <tr>
    <td></td>
  </tr>
   <tr >
    <td width="90%"  align="left"><div align="left"></div></td>
  </tr>
  <tr >
    <td  align="left"><div align="left">
      <input name="button12" type="button" class="guardar" id="button12" onclick="ajax_carga('../aplicaciones/visualiza_tabla_criterios_tecnicos.php?id_invitacion=<?=arreglo_pasa_variables($id_proceso);?>&termino=2&ruta_ev=<?=$ruta_ev;?>','carga_evaluacion');ingresar_listado('oculta_todo_proveedores')" value="Requerimientos t&eacute;cnicos                         " />
    </div></td>
  </tr>
  <tr >
    <td width="90%"  align="left"><div align="left">
      <input name="button13" type="button" class="guardar" id="button13" onclick="ajax_carga('../aplicaciones/visualiza_tabla_criterios.php?id_invitacion=<?=arreglo_pasa_variables($id_proceso);?>&termino=1&ruta_ev=<?=$ruta_ev;?>','carga_evaluacion');ingresar_listado('oculta_todo_proveedores')" value="Requerimientos economicos documentos  " />
    </div></td>
  </tr>

  <tr >
    <td  align="left"><div align="left"><input name="button2" type="button" class="guardar" id="button2" onclick="ajax_carga('../aplicaciones/vista_lista_precios.php?id_invitacion=<?=arreglo_pasa_variables($id_proceso);?>&ruta_ev=<?=$ruta_ev;?>','carga_evaluacion');ingresar_listado('oculta_todo_proveedores')" value="Requerimientos listas de precios              " /></div></td>
  </tr>
  <tr >

    <td  align="left">&nbsp;</td>
  </tr>
</table>
<br />


            
</fieldset>

<br />

<input type="hidden" name="id_proceso" value="<?=$id_proceso;?>" />
<input type="hidden" name="id_elimina"/>


<? 



} ?>
</div>

<div id="muestra_cootactos"></div>
<div id="carga_detalle_pro"></div>
<div id="carga_evaluacion"></div>
</body>
</html>
