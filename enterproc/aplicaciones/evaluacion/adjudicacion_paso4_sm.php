<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

if($requeire_filtro_proveedores_tecnico_aceptados=="Si"){ //si requierre filtro 
$busca_proveedores_apectados = query_db("select * from $t13 where proc1_id = $id_invitacion");
while($lista_prove_apcet=traer_fila_row($busca_proveedores_apectados))
	{
		if($sql_e[20]<=$lista_prove_apcet[5])
			$pv_id_acep_tecnico.=",".$lista_prove_apcet[2];
	
	}
	
	 $filtro_provee_aceptados_tec = "and $t7.pv_id  in (0 ".$pv_id_acep_tecnico.")";
	
	} // si requierre filtro 


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
    <td width="83%" class="titulos_evaluacion">PASO 3: Confirmar adjudicaci&oacute;n y enviar notificaci&oacute;n a proveedores y usuarios de HOCOL S.A.</td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
  <tr>
    <td ><strong>Consecutivo:</strong> <span class="texto_paginador_proveedor">
      <?=$sql_e[22];?>
    </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><strong>Objeto:</strong>
        <?=$sql_e[12];?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</p>


<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="texto_paginador_proveedor" id="error_no_adj">&nbsp;</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              
              <tr>
                <td colspan="3" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados</strong></td>
              </tr>
              <tr>
                <td width="5%" class="columna_titulo_resultados"><strong>Enviar</strong></td>
                <td width="25%" class="columna_titulo_resultados"><div align="left"><strong>Nombre proveedor</strong></div></td>
                <td width="70%" class="columna_titulo_resultados"><strong>Comentarios: Si usted no desea notificar a un proveedor sobre la no adjudicaci&oacute;n, digite la raz&oacute;n</strong>. </td>
              </tr>
           
              <?
			  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];

	
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t7.pv_id not in (0 $not_in) $filtro_provee_aceptados_tec  order by $t8.razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 $buscar_notificaciones = "select * from $t46 where pro1_id = $id_invitacion and tipo_adj_no_adj  = 2 and pv_id = $lp[0]";
			  	$sql_ex_no_adjudicados=traer_fila_row(query_db($buscar_notificaciones));
				
				if($sql_ex_no_adjudicados[0]==""){//si ya fue notificado			
					echo "<input type='hidden' name='pv_no_adjudicados[]' id='pv_no_adjudicados[]' value='".$lp[0]."'>";
					
					}
				
				if($sql_ex_no_adjudicados[7]==1)//si ya fue notificado y requiere	
					$icono_enviado ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
				if($sql_ex_no_adjudicados[7]==3)//si ya fue notificado y requiere	
					$icono_enviado =' <img src="../imagenes/botones/icono_X.gif" alt="No requiere notificacion al proveedor" width="18" height="18" title="No requiere notificacion al proveedor">';

			  ?>
  
				    
                
              

	<input type="hidden" name="nombre_provee_<?=$lp[0];?>" id="nombre_provee_<?=$lp[0];?>" value="<?=$lp[2];?>">

  <tr class="<?=$class;?>">
    <td><? if($sql_ex_no_adjudicados[0]>=1) echo $icono_enviado; else echo '<input type="checkbox" name="no_adjudicados_'.$lp[0].'" id="checkbox" value="1" checked></td>'; ?>
    <td><?=$lp[2];?></td>
    <td><? if($sql_ex_no_adjudicados[0]>=1) echo $sql_ex_no_adjudicados[8]; else echo '<textarea name="detalle_no_adjudicados_'.$lp[0].'" id="textarea" cols="45" rows="2"></textarea></td>'; ?>
     </tr>
              <? $num_fila++;} ?>
</table>


<p>&nbsp;</p>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="texto_paginador_proveedor" id="error_adj">&nbsp;</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7" class="columna_subtitulo_resultados"><strong>Proveedores adjudicados</strong></td>
  </tr>
  <tr>
    <td width="5%" class="columna_titulo_resultados"><strong>Notificado</strong></td>
    <td width="30%" class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
    <td width="12%" class="columna_titulo_resultados"><div align="center"><strong>Contato, OP, OS</strong></div></td>
    <td width="18%" class="columna_titulo_resultados"><div align="center"><strong>Fecha de entrega</strong></div></td>
    <td width="15%" class="columna_titulo_resultados"><div align="center"><strong>Contacto</strong></div></td>
    <td width="15%" class="columna_titulo_resultados"><div align="center"><strong>Lugar de entrega</strong></div></td>
    <td width="5%" class="columna_titulo_resultados"><div align="center"><strong>Resumen</strong></div></td>
  </tr>
  <?

	

			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado_a="";
				 $buscar_notificaciones_a = "select * from $t46 where pro1_id = $id_invitacion and tipo_adj_no_adj  = 1 and pv_id = $lp[2] and pro27_id = $lp[0]";
			  	$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));
			  
				if($sql_ex_adjudicados[7]==1)//si ya fue notificado y requiere	
					$icono_enviado_a ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
				if($sql_ex_adjudicados[7]=="")//si ya fue notificado y requiere	
					$icono_enviado_a =' <img src="../imagenes/botones/icono_X.gif" alt="Pendiente de notificacion" width="18" height="18" title="Pendiente de notificacion">';
				
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$icono_enviado_a;?></td>
    <td><?=$lp[3];?><input type="hidden" name="nombre_provee_<?=$lp[2];?>" id="nombre_provee_<?=$lp[2];?>" value="<?=$lp[3];?>"></td>
                <td><?=$lp[4];?></td>
                <td><?=$lp[5];?></td>
                <td><?=$lp[6];?></td>
                <td align="center"><?=listas_sin_select($t41,$lp[7],1);?></td>
                <td align="center"><img src="../imagenes/botones/editar_c.png"  title="Editar datos de adjudicación" alt="Editar datos de adjudicaci&oacute;n" width="16" height="16" longdesc="Editar datos de adjudicación" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso5_sm.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>','contenidos')"></td>
  </tr>

  <? $num_fila++;} ?>
</table>
<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td><div align="center"><input type="button" name="button" class="guardar" id="button" value="Enviar notificaci&oacute;n.  " onClick="canfirma_notificacion_js()"></div></td>
  </tr>
</table>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="pv_id">
  
  <input type="hidden" name="id_anexo"></p>
</body>
</html>
