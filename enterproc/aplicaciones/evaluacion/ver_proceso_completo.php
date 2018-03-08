<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


$id_proceso = elimina_comillas($id_p);
	
if($id_proceso!=""){
	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	$busca_responsable_a = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 1"));
	$busca_responsable_j = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 2"));
	$busca_responsable_t = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 3"));
	$busca_responsable_e = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 4"));
	$trm_vi =$sql_e[42];

	}
	else { $trm_vi = "1800"; }
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="popup2" align="center"><div id="pContent"></div></div>
<div id="oculta_todo_proveedores">
  <table width="900" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td><label>
        <input name="button" type="button" class="buscar" id="button" value="Volver a la evaluaci&oacute;n" onclick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_p;?>','contenidos')" />
      </label></td>
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
    <td ><div align="right"><strong>Consecutivo del proceso:</strong></div></td>
    <td><?=$sql_e[22];?></td>
    <td><div align="right"><strong>Origen de la solicitud:</strong></div></td>
    <td><div align="left"><?=listas_sin_select($tp4,$sql_e[4],1);?></div></td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Tipo de proceso:</strong></div></td>
    <td width="29%"><div align="left">
      <label>
      <?=listas_sin_select($tp2,$sql_e[2],1);?>
      </label>
    </div></td>
    <td width="17%"><div align="right"><strong>Tipo de contrato:</strong></div></td>
    <td width="34%"><div align="left">
      <?=listas_sin_select($tp5,$sql_e[5],1);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Objeto a contratar:</strong></div></td>
    <td colspan="3"><div align="left">
      <?=listas_sin_select($tp6,$sql_e[11],1);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Cuant&iacute;a a contratar:</strong></div></td>
    <td><div align="left">
        <?=listas_sin_select($tp7,$sql_e[13],1);?> $<?=number_format($sql_e[14],0);?>
    </div></td>
    <td><div align="right"><strong>TRM del proceso:</strong></div></td>
    <td><div align="left">
      <?=valida_fecha_vacia($sql_e[42]);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"></div></td>
    <td><div align="left"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Detalle del objeto a contratar:</strong></div></td>
    <td colspan="3">
      <div align="left">
        <?=$sql_e[12];?>
      </div>    </td>
  </tr>
</table>
<br />
<? if($id_proceso>=1){?>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
      <input name="button8" type="button" class="buscar" id="button8" value="Ingresar a la cartelera de aclaraciones" onclick="ajax_carga('../aplicaciones/evaluacion/ver_cartelera.php?id_invitacion_pasa=<?=$id_proceso;?>','contenidos')"/>
      <input name="button3" type="button" class="buscar" id="button3" value="Ingresar a comunicaciones generales" onclick="ajax_carga('../aplicaciones/evaluacion/ver_cartelera_generales.php?id_invitacion_pasa=<?=$id_proceso;?>','contenidos')" />
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
                <td width="13%" class="titulo_tabla_azul_sin_bordes">Actividad</td>
                <td width="30%" class="titulo_tabla_azul_sin_bordes">Cronograma</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Fecha apertura</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Fecha cierre</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">% Global</td>
                <td width="7%" class="titulo_tabla_azul_sin_bordes">% Minimo aceptado</td>
                <td width="9%" class="titulo_tabla_azul_sin_bordes">Responsable</td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td rowspan="3"><div align="right"><strong>Generalidades</strong></div></td>
                <td><div align="right"><strong>Fecha de publicaci&oacute;n:</strong></div></td>
                <td><div align="center">
                  <?=valida_fecha_vacia($sql_e[16]);?>
                </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fecha de apertura y cierre general:</strong></div></td>
                <td><div align="center">
                  <?=valida_fecha_vacia($sql_e[17]);?>
                </div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[18]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fechas de recepci&oacute;n de aclaraciones:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[29]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[34]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td rowspan="2"><div align="right"><strong>Juridico</strong></div></td>
                <td><div align="right"><strong>Fechas 
                  <?=$lenguaje_1;?>
                :</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[23]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[24]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td rowspan="2"><?=listas_sin_select($t1,$busca_responsable_j[1],1);?></td>
              </tr>
              <tr class="campos_gris_cronograma" >
                <td><div align="right"><strong>Segundo periodo de aclaraciones:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[35]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[36]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td rowspan="2"><div align="right"><strong>T&eacute;cnico</strong></div></td>
                <td><div align="right"><strong>Fechas de documentos t&eacute;cnicas:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[25]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[26]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[19]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[20]);?></div></td>
                <td rowspan="2"><?=listas_sin_select($t1,$busca_responsable_t[1],1);?></td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Tercer periodo de aclaraciones:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[37]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[38]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td rowspan="2"><div align="right"><strong>Proceso Econ&oacute;mico</strong></div></td>
                <td><div align="right"><strong>Fecha pre-recepcci&oacute;n ofertas econ&oacute;micas:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[39]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[40]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td rowspan="2"><?=listas_sin_select($t1,$busca_responsable_e[1],1);?></td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td><div align="right"><strong>Fecha recepci&oacute;n ofertas econ&oacute;micas:</strong></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[27]);?></div></td>
                <td><div align="center"><?=valida_fecha_vacia($sql_e[28]);?></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
              </tr>
            </table>
<br />
</fieldset>            

<br />

<fieldset style="width:98%">
			<legend>Informaci&oacute;n de contacto  y ubicaci&oacute;n del proceso</legend>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="6"></td>
  </tr>
  <tr>
    <td><div align="right">Auditor del proceso:</div></td>
    <td colspan="3"><div align="left"><?=listas_sin_select($t1,$busca_responsable_a[1],1);?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250"><div align="right">Persona de contacto:</div></td>
    <td colspan="3"><div align="left"><?=listas_sin_select($t1,$sql_e[15],1);?></div></td>
    <td width="269"><div align="right"><strong>Entrega de documentos fisicos:</strong></div></td>
    <td width="185"><?=$sql_e[8];?></td>
  </tr>
  <tr >
    <td><div align="right"><strong>Fecha y hora de reuni&oacute;n informativa:</strong></div></td>
    <td colspan="3"><div align="left"><?=valida_fecha_vacia($sql_e[41]);?></div></td>
    <td><div align="right"><strong>Lugar de reuni&oacute;n informativa</strong>:</div></td>
    <td><?=$sql_e[30];?></td>
  </tr>
</table>
</fieldset>

<? if($id_proceso!=""){ ?>

<br />
<fieldset style="width:98%">
			<legend>Proveedores invitados</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="57%"></td>
              </tr>
            </table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="13%" class="titulo_tabla_azul_sin_bordes">Ver mas</td>
                <td width="13%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                <td width="38%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="7%" class="titulo_tabla_azul_sin_bordes">Tel&eacute;fono</td>
                <td width="27%" class="titulo_tabla_azul_sin_bordes">E-mail</td>
                <td width="9%" class="titulo_tabla_azul_sin_bordes">Invitaciones</td>
                <td class="titulo_tabla_azul_sin_bordes">Bit&aacute;cora</td>
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
    <td><input name="button5" type="button" class="buscar" id="button5" value="Ver" onclick="ajax_carga('../aplicaciones/carga_contactos_proveedor.php?pv_nit=<?=$lp[1];?>','muestra_cootactos');ingresar_listado('oculta_todo_proveedores')" /></td>
  
                <td><?=$lp[1];?></td>
                <td><?=$lp[2];?></td>
                <td><?=$lp[3];?></td>
                <td><?=$lp[4];?></td>
                <td><a href="javascript:void(0)" onclick="msgbox('../aplicaciones/reporte_proveedores-procesos.php?pv_id_pasa=<?=arreglo_pasa_variables($lp[0]);?>');">
                  <?=$busca_participacion[0];?>
                </a></td>
                <td width="9%"><label>
                  <input name="button4" type="button" class="buscar" id="button4" value="Ingresar" onclick="ajax_carga('../aplicaciones/c_bitacora.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>','contenidos')" />
                </label></td>
              </tr>
              <? $num_fila++;} ?>
            </table>
<br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Documentos del proceso</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="100%"></td>
              </tr>
            </table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tipo documento</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="35%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Tama&ntilde;o</td>
                <td width="22%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
              </tr>
             
               <?
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga from $t6, $tp8 where
				$t6.pro1_id =  $id_proceso and $tp8.tp8_id = $t6.tp8_id ");
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
                <td><div align="center"><img src="../../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_generales.php?n1=<?=$lp[0];?>&n2=<?=$lp[2];?>'" /></div></td>
              </tr>
              
              <? $num_fila++;} ?>
            </table>
  <br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Configuraci&oacute;n evaluaci&oacute;n jur&iacute;dica, t&eacute;cnica y econ&oacute;mica</legend>

            <table width="95%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td width="4%"></td>
    <td width="96%"></td>
  </tr>
  <tr >
    <td  align="left"><div align="center"><img src="../imagenes/botones/chulo.jpg" alt="" width="23" height="20" /></div></td>
    <td  align="left"><div align="left"><a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/evaluacion/ver_tabla_economica.php?id_invitacion=<?=arreglo_pasa_variables($id_proceso);?>','contenidos')">Configurar requerimientos econ&oacute;micos</a></div></td>
  </tr>
  <tr >
    <td  align="left">&nbsp;</td>
    <td  align="left">&nbsp;</td>
  </tr>
</table>
<br />

<div id="carga_evaluacion"></div>
            
</fieldset>

<br />
<? if($sql_e[31]==0){ ?>

<fieldset style="width:98%">
			<legend>Enviar notificaci&oacute;n a los proveedores</legend>

            <table width="98%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><label>
                  <div align="center">
                    <input name="button7" type="button" class="guardar" id="button7" value="Enviar notificaci&oacute;n de invitaci&oacute;n a los proveedores" onclick="notificar_provvedores()" />
                    </div>
                </label></td>
              </tr>
            </table>
</fieldset>
<? } ?>
<input type="hidden" name="id_proceso" value="<?=$id_proceso;?>" />
<input type="hidden" name="id_elimina"/>

<? 



} ?>
<label>
<textarea name="justificacion_final" id="justificacion_final" cols="45" rows="5" style="visibility:hidden"></textarea>

</label>
</div>

<div id="muestra_cootactos"></div>
</body>
</html>
