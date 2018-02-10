<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
			
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
		
		
		$consulta4=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_evaluacion));

		
		if($consulta4[0]==1){
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select  nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			$select_criterio_anterior="select id_proveedor, id_crea_aspectos, fecha_periodo_evaluado from vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
		if($consulta4[0]==2){
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select  nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			$select_criterio_anterior="select id_proveedor, id_crea_aspectos, fecha_periodo_evaluado from vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
		if($consulta4[0]==3){
			
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			
			$select_tabla="select  nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			$select_criterio_anterior="select id_proveedor, id_crea_aspectos, fecha_periodo_evaluado from vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
		$ids=traer_fila_row(query_db($select_criterio_anterior));
		
		
		
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">Administraci&oacute;n de Criterios <?php echo $tipo_Criterio; ?></h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>
<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important; color: #229BFF; cursor: pointer;" onClick="abrir_ventana('../../aplicaciones/desempeno/criterios_anteriores.php?p1=<?=arreglo_pasa_variables($ids[0])?>&p2=<?=arreglo_pasa_variables($ids[1])?>&p3=<?=arreglo_pasa_variables($ids[2])?>')">Ver Criterios de la evaluaci&oacute;n anterior.</h5></div>
<div class="row" >

	<?	
		
		$cabecera='Aspectos| | | | | | | |70?Puntuaci&oacute;n M&aacute;xima| | | | | | | | |30';
		$estilo='font-size:18pt !important; font-weight: 900 !important; color:#000000;';
		
		carga_tabla_hmtl_titulo_grande($cabecera, '', '', '', $select_tabla, $estilo);
	?>
	
</div>


<div class="row" >

	<?	
		$consulta1="select nombre_observacion FROM t9_observacion where estado='1' and id_estado='3' and id_agrega_criterio=".$id_evaluacion;
		
		$query=query_db($consulta1); 
	
		while($lt=traer_fila_db($query)){
		$imprime3='<label for="">OBSERVACION</label><textarea value="'.$lt[2].'"  type="text" class="validate materialize-textarea" style="">'.$lt[0].'</textarea>
		';
		}
		echo $imprime3;
	?>
	
</div>


<div class="row">
	<?

		boton_sin_icono_accion('right', 'CONFIGURACI&oacuteN', 'muestra_modal_configurar_aspecto(&apos;'.$_GET['id_evaluacion'].'&apos;)', 'background: #229BFF;', 's12 m7 l7');
	?>
	<?

		boton_sin_icono_accion('right', 'APROBAR', 'aceptar_aspectos_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)', 'background: #229BFF;', 's12 m2 l2');
	?>
</div>

