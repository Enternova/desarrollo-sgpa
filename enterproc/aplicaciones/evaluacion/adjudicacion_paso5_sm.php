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

</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">RESUMEN DEL ENVIO</td>
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso4_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos')"></div></td>
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
  <tr>
    <td class="titulos_evaluacion">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</p>


<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco" >
  <tr>
    <td></td>
  </tr>
  <? 
 
  $cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $pv_id and acepta_terminos = 1")); ?>
  <tr>
    <td>ss<?=nl2br($cambia_estado_carta[4]);?></td>
  </tr>
</table>
</p>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
    <td width="45%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="30%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
    <td width="9%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
  </tr>
  <?
		  		$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $pv_id and estado = 1"));

				
				$busca_provee = query_db("select * from $t37 where
				pro1_id =  $id_invitacion and pv_id = $pv_id and pro27_id = $busca_relacion[0]");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[3]);
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
    <td><?=$lp[3];?></td>
    <td><?=fecha_for_hora($lp[4]);?></td>
    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_adjudicacion_provedor.php?n1=<?=$lp[0];?>&n2=<?=$lp[3];?>'" /></div></td>
  </tr>
  <? $num_fila++;} ?>
</table>



</body>
</html>
