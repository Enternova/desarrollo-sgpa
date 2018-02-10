<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	$busca_contrato = "select id,id_item,consecutivo,objeto,nit,contratista,contacto_principal,email1,telefono1,gerente,fecha_inicio,vigencia_mes,aplica_acta_inicio,representante_legal,email2,telefono2,especialista,monto_usd,monto_cop,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,t1_tipo_documento_id,acta_socios,recibido_poliza,camara_comercio,ok_fecha,sel_representante,legalizacion_final_par,legalizacion_final_par_e,analista_deloitte,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa,recibido_abastecimiento_e,area_ejecucion,obs_congelado,aplica_portales,destino,aseguramiento_admin, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil, garantia_seguro
 from $co1 where id = $id_contrato_arr";
 


	$sql_con=traer_fila_row(query_db($busca_contrato));
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$sql_con[1]));

/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_con[9]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.filas_sub_resultados {background:#E9E9E9}
</style>
</head>

<body>
     <p>
       <?
echo imprime_cabeza_contrato($id_contrato)
?>
     </p>
     <table width="100%" border="0">
       <tr>
         <td width="84%">&nbsp;</td>
         <td width="16%"><? if($sel_contratos_gestiona[0]>0){?><input type="button" onclick="ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_complemento=0','carga_acciones_permitidas')" value="Crear Evento" style="cursor:pointer" /><? }?></td>
       </tr>
     </table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
      
      
      
    </td>
  </tr>

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr class="fondo_3">
        <td width="6%" align="center">Solicitud SGPA</td>
        <td width="10%" align="center">Tipo de Evento</td>
        <td width="12%" align="center">Tipo Otros&iacute;</td>
        <td width="6%" align="center">N&uacute;mero</td>
        <td width="9%" align="center">Fecha de Creaci&oacute;n</td>
        <td width="11%" align="center">Gerente</td>
        <td width="9%" align="center">Profesional de C&amp;C</td>
        <td width="10%" align="center">Gestor de Abastecimiento</td>
        <td width="4%" align="center">Congelado</td>
        <td width="6%" align="center">Observaci&oacute;n de congelado</td>
        <td width="4%" align="center">Estado</td>
        <td width="4%" align="center">Ver Detalle de la Legalizaci&oacute;n</td>
       <? if($_SESSION["id_us_session"]==32){?>  <td width="9%" align="center">Eliminar</td><? }?>
      </tr>
       <?
	   $sol_relacionadas = $sel_item[43]+0;
   $sel_lista_modificaoin = query_db("select * from v_contrato_lista_modificaciones where id_contrato = ".$id_contrato_arr." order by id desc");
   while($sel_mod = traer_fila_db( $sel_lista_modificaoin)){

if($sel_mod[20] > 0){//si es una modificacion
$sol_relacionadas = $sol_relacionadas." ,".$sel_mod[20];
}

	   if($sel_mod[16] > 0){
		   $sol_relaciona.=",".$sel_mod[16]; 
		   }
		   
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
   ?>
      <tr class="<?=$clase?>">
        <td align="center">
        
		<?
		
        if($sel_mod[17]==2){		
        $sel_ots_relacionados = query_db("select distinct id_item_ots_aplica from t2_presupuesto where t2_item_pecc_id = ".$sel_mod[16]." and permiso_o_adjudica = 1");
		$sel_item_aplica_ot = traer_fila_row(query_db("select t2_pecc_proceso_id, id_item_peec_aplica from $pi2 where id_item=".$sel_mod[16]));
		while($sel_apro = traer_fila_db($sel_ots_relacionados)){
			if($sel_apro[0] ==""){
			$sele_items_relacionado = traer_fila_row(query_db("select $pi2.num1,$pi2.num2,$pi2.num3, $pi2.id_item from $pi2 where $pi2.id_item=".$sel_item_aplica_ot[1]));
				}else{
			$sele_items_relacionado = traer_fila_row(query_db("select $pi2.num1,$pi2.num2,$pi2.num3, $pi2.id_item from $pi2 where $pi2.id_item=".$sel_apro[0]));
				}
				
			echo '<strong onclick=abrir_ventana("../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc='.$sele_items_relacionado[3].'&permiso_o_adjudica=2") style=cursor:pointer>'.numero_item_pecc($sele_items_relacionado[0],$sele_items_relacionado[1],$sele_items_relacionado[2]).'</strong>';
			}
}else{
	echo '<strong onclick=abrir_ventana("../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc='.$sel_mod[16].'&permiso_o_adjudica=2") style=cursor:pointer>'.numero_item_pecc($sel_mod[13],$sel_mod[14],$sel_mod[15]).'</strong>';
	}
		?>
        
		</td>
        <td align="center"><?=$sel_mod[2]?></td>
        <td align="center"><?=$sel_mod[3]?></td>
        <td align="center"><?=$sel_mod[4]?></td>
        <td align="center"><?=$sel_mod[5]?></td>
        <td align="center"><?=$sel_mod[6]?></td>
        <td align="center"><?=$sel_mod[10]?></td>
        <td align="center"><? 
		/*SACA LOS MODIFICACIONES QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_mod[11]));
 echo traer_nombre_muestra($sel_quien_es_gestor[0], $g1,"nombre_administrador","us_id");
/*SACA LOS MODIFICACIONES QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

		?></td>
        <td align="center"><? if($sel_mod[7]==1) echo "SI"; else echo "NO";?></td>
        <td align="center"><?=$sel_mod[8]?></td>
        <td align="center"><?=$sel_mod[9]?></td>
        <td align="center"><img src="../imagenes/botones/editar.jpg" alt="Editar" title="Editar" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/c_complemento.php?id=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_complemento=<?=$sel_mod[0];?>','carga_acciones_permitidas')"/></td>
      <? if($_SESSION["id_us_session"]==32){?>  <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" onclick="elimina_complemento('<?=arreglo_pasa_variables($sel_mod[0]);?>')" /></td><? }?>
      </tr>
      <?
   }
	  ?>
    </table></td>
  </tr>

</table>
<?


 $sel_relacionada = traer_fila_row(query_db("select count(*) from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (7, 9,10,11,12,15,1,2,6,5) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1].")) or id_item in (".$sql_con[1].", ".$sol_relacionadas.") and $pi2.estado <> 33"));
 
 if($sel_relacionada[0]>0){
?>

<table width="100%" border="0" class="tabla_lista_resultados">
    	  <tr>
    	    <td colspan="5" align="center"  class="fondo_3" style="height:30px"> Solicitudes Relacionadas al contrato</td>
    	    <td width="0%" align="center"  class="fondo_3" style="height:30px">&nbsp;</td>

        </tr>
    	  <tr>
    	    <td align="center"  class="fondo_3" width="9%">Solicitud SGPA</td>
    	    <td align="center"  class="fondo_3" width="14%">Tipo Proceso</td>
    	    <td align="center"  class="fondo_3" width="11%">Fecha de Creacion</td>
    	    <td align="center"  class="fondo_3" width="56%">Objeto</td>
    	    <td align="center"  class="fondo_3" width="10%">Estado</td>
   	    </tr>
    	  <? 
		  
	
	
	 
	  $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item, $pi2.t1_tipo_proceso_id, $pi2.es_modificacion from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (7, 9,10,11,12,15,1,2,6,5) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1].")) or id_item in (".$sql_con[1].", ".$sol_relacionadas.") and $pi2.estado <> 33 order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$permiso_ad = 2;
					if($rowSR['t1_tipo_proceso_id'] == 12 or $rowSR['t1_tipo_proceso_id'] == 7){
						$permiso_ad = 1;
						}
					
					?>
    	  <tr>
    	    <td><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$rowSR['id_item']?>&permiso_o_adjudica=<?=$permiso_ad?>')" style="cursor:pointer"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></strong></td>
    	    <td><? if($rowSR[9] == 1) echo "Modificaci&oacute;n"; else echo $rowSR['nombre']?></td>
    	    <td><?= $rowSR[6]?></td>
    	    <td><?= $rowSR['objeto_solicitud']?></td>
    	    <td><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
   	    </tr>
    	  <?php }
				?>
  	  </table>
  <?
 }
  ?>
<input name="id_contrato_arr" id="id_contrato_arr" type="hidden" value="<?=$id_contrato_arr;?>" />
<input name="id_complemento" type="hidden" value="" />
</body>
</html>
