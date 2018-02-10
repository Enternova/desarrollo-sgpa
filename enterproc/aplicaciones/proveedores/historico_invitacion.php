<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
      <tr>
        <td class="titulos_procesos"> INVITACIONES EN PROCESO.</td>
      </tr>
    </table>
        <br>
        <br>
        <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
          <tr>
            <td colspan="6" class="titulo_tabla_azul_sin_bordes">Lista de invitaciones en proceso o por abrir</td>
          </tr>
          <tr>
            <td width="12%" class="tabla_sin_borde_fondo_gris"><div align="center">Consecutivo</div></td>
            <td width="31%" class="tabla_sin_borde_fondo_gris"><div align="center">Estado</div></td>
            <td width="15%" class="tabla_sin_borde_fondo_gris"><div align="center">Apertura</div></td>
            <td width="13%" class="tabla_sin_borde_fondo_gris"><div align="center">Cierre</div></td>
            <td width="13%" class="tabla_sin_borde_fondo_gris"><div align="center">Responsable</div></td>
            <td width="16%" class="tabla_sin_borde_fondo_gris"><div align="center">Acciones</div></td>
          </tr>
          <?  
  	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t7 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t7.pro1_id = $t5.pro1_id and
	$t5.fecha_apertura <= '".$fecha." ".$hora."' and 
	$t5.notificacion = 1 and $t7.estado = 1 and
	$t7.pv_id = ".$_SESSION["id_proveedor"];
	
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
$falta_alrta=0;
$busca_alertas_docu = "select evaluador1_id from evaluador1_relacionpreguntas_admin where in_id = $ls[0]";
$cuenta_criterio = query_db($busca_alertas_docu);
while($busca_criterios_alertas = traer_fila_row($cuenta_criterio))
	{
		$busca_alertas_docu_pro = "select count(*) from evaluador6_relaciondocumentos_proveedor where evaluador1_id = $busca_criterios_alertas[0] and pv_id = ".$_SESSION["id_proveedor"]."";		
		$cuenta_criterio_pro = traer_fila_row(query_db($busca_alertas_docu_pro));
		if($cuenta_criterio_pro[0]==0)
			$falta_alrta = 1;
	
	}
	
	if($ls[0]>=4117){
		if($falta_alrta==1)
			{
				$alert_msg = "<strong class='texto_paginador_proveedor'>Falta Ofertas | No enviado a Hocol</strong>";
				}
			else
				{
					$alert_msg = "Documentos completos";
					}
					
	}
	else
					$alert_msg = "N/A";

  ?>
          <tr class="<?=$class;?>">
            <td><?=$ls[7];?></td>
            <td><?=$alert_msg;?></td>
            <td><?=fecha_for_hora($ls[4]);?></td>
            <td><?=fecha_for_hora($ls[5]);?></td>
            <td><?=$ls[6];?></td>
            <td>
            <?
				if (($falta_alrta==1) && ($ls[0]>=4117) )
			{
				?>
            <input name="button" type="button" class="buscar" id="button" value="Ingresar a la Invitaci&oacute;n" onClick="ajax_carga('../aplicaciones/proveedores/alerta_aviso.php?id_invitacion_pasa=<?=arreglo_pasa_variables($ls[0]);?>','contenidos')"></td>
          <? } else { ?>
          <input name="button" type="button" class="buscar" id="button" value="Ingresar a la Invitaci&oacute;n" onClick="ajax_carga('detalle_invitacion_<?=arreglo_pasa_variables($ls[0]);?>.php','contenidos')">
          
          <? } ?>
          </tr>
          <? $num_fila++; } ?>
      </table>
</body>
</html>
