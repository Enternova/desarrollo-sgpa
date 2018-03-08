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
    <td width="83%" class="titulos_evaluacion">PASO 2:Configure la carta de adjudicaci&oacute;n y los anexos por cada proveedor seleccionado</td>
    <td width="17%"><div align="left"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
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


<table width="99%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
              <tr>
                <td width="55%" class="columna_subtitulo_resultados"><div align="center"></div></td>
                <td class="columna_subtitulo_resultados"><div align="center"><strong>Contactos</strong></div></td>
                <td class="columna_subtitulo_resultados"><div align="center"><strong>Terminos y condiciones</strong></div></td>
                <td colspan="2" class="columna_subtitulo_resultados"><div align="center"><strong>Anexos de la Adjudicaci&oacute;n</strong></div></td>
  </tr>
              <tr>
                <td class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
                <td width="14%" class="columna_titulo_resultados"><div align="center"><strong>Configurar</strong></div></td>
                <td width="10%" class="columna_titulo_resultados"><div align="center"><strong>Configurar</strong></div></td>
                <td width="10%" class="columna_titulo_resultados"><div align="center"><strong># anexos</strong></div></td>
                <td width="11%" class="columna_titulo_resultados"><div align="center"><strong>Subir anexos</strong></div></td>
              </tr>
           
              <?

	
			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social  ");
				while($lp = traer_fila_row($busca_provee)){
				//$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $lp[2] and estado = 1"));
			  
				$cuenta_anexos = traer_fila_row(query_db("select count(*) from $t37 where pro1_id =  $id_invitacion and pv_id = $lp[2] and pro27_id = $lp[0]"));
				
  ?>

  <tr class="<?=$class;?>">
    <td><?=$lp[3];?></td>
                <td><input type="button" name="button" class="buscar_ajustado" id="button" value="Ingresar " onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_contactos_proceso_sm.php?id_invitacion=<?=$id_invitacion;?>&pv_id_b=<?=$lp[2];?>','contenidos')"></td>
                <td><input type="button" name="button3" class="buscar_ajustado" id="button3" value="Ingresar" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_carta_terminos_sm.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>','contenidos')"></td>
                <td align="center"><strong><?=$cuenta_anexos[0];?></strong></td>
                <td><input type="button" name="button4" class="buscar_ajustado" id="button4" value="Anexar" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_anexos_sm.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>','contenidos')"></td>
  </tr>
              <? $num_fila++;} ?>
</table>



<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion;?>">

<input type="hidden" name="id_anexo">
</body>
</html>
