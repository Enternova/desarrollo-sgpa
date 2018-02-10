<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
		$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
		
		
		$consulta4=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_evaluacion));

		
		if($consulta4[0]==1){
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
		if($consulta4[0]==2){
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
		if($consulta4[0]==3){
			
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			
			$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		}
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">Aprobaci&oacute;n de Criterios <?php echo $tipo_Criterio; ?></h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>	
<div class="row" >

	<?	
		
		$cabecera='Aspectos| | | | | | | |70?Puntuaci&oacute;n M&aacute;xima| | | | | | | | |30';
		$estilo='font-size:18pt !important; font-weight: 900 !important; color:#000000;';
		
		carga_tabla_hmtl_titulo_grande($cabecera, '', '', '', $select_tabla, $estilo);
	?>
	
</div>


<div class="row">
	<div class="input-field"><i class="material-icons prefix">&#xE150;</i><label for="">OBSERVACION </label><textarea id="nombre_observacion" name="nombre_observacion" type="text" class="validate materialize-textarea" style=""></textarea></div>
</div>
<div class="row">
	<?

		boton_sin_icono_accion('right', 'RECHAZAR', 'rechazar_aspectos_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)', 'background: #229BFF;', 's12 m7 l7');
	?>
	<?

		boton_sin_icono_accion('right', 'APROBAR', 'aceptar_criterios_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)', 'background: #229BFF;', 's12 m2 l2');
	?>
</div>