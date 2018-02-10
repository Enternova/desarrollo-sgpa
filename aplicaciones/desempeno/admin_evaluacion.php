<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
		$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
		
		
		$consulta4=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_evaluacion));

		
		if($consulta4[0]==1){
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select id_aspectos_nuevo, nombre_aspectos, puntaje_maximo, puntaje_obtenido FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			
		}
		if($consulta4[0]==2){
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select id_aspectos_nuevo, nombre_aspectos, puntaje_maximo, puntaje_obtenido FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			
		}
		if($consulta4[0]==3){
			
			$consulta=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio FROM vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select id_aspectos_nuevo, nombre_aspectos, puntaje_maximo, puntaje_obtenido FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
		
		}
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n <?php echo $tipo_Criterio; ?></h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>	
<div class="row" >

	
	<table class="responsive-table striped centered" cellspacing="0" width="100%">
  <thead>
	  <tr>
		  <th width="70%" style="font-size:18pt !important; font-weight: 900 !important; color:#000000;">
			Aspectos
		  </th>
		  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important; color:#000000;">
			Puntuaci&oacute;n
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important; color:#000000;">
			Calificaci&oacute;n
		  </th>
	  </tr>
  </thead>
  <tbody>
  
  <?php   
	$query=query_db($select_tabla);
    while($lt=traer_fila_db($query)){  ?>
  	
			<tr >	
			  <td ><input value="<?=$lt[0]?>" type="hidden" name="id_calificados" id="id_calificados" style="background:none; border:none; outline:0; font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;"><input value="<?=$lt[1]?>" type="hidden" name="aspecto_calificados" id="puntos_calificados" style="background:none; border:none; outline:0; font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;"><?=$lt[1]?></td>
			  <td ><input value="<?=$lt[2]?>" type="hidden" name="aspecto_puntos_calificados" id="puntos_calificados" style="background:none; border:none; outline:0; font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;"><?=$lt[2]?></td>
			  <td ><input value ="<?=$lt[3]?>" type="number" name="puntos_calificados" id="puntos_calificados"  placeholder="<?=$lt[2]?>" style="background:none; border:none; outline:0; font-family:Arial, Helvetica, sans-serif; margin:0; padding:0;"></td>
  
  
	
  </tr>
  <?php }  ?>
  </tbody>
</table>
</div>
<br>
<div class="row">
 <? $consulta3=traer_fila_row(query_db("select observacion_general FROM t9_agregar_evaluacion where  id_agregar_criterio=".$id_evaluacion));  ?>
	<div class="input-field"><i class="material-icons prefix">&#xE150;</i><label for="">OBSERVACION GENERAL</label><textarea id="observacion_general" name="observacion_general" type="text" class="validate materialize-textarea" style=""><?=$consulta3[0] ?></textarea></div>
</div>

<div class="row" >

	<?	
		$consulta1="select nombre_observacion FROM t9_observacion where estado='1' and id_estado='7' and id_agrega_criterio=".$id_evaluacion;
		
		$query=query_db($consulta1); 
	
		while($lt=traer_fila_db($query)){
		$imprime3='<label for="" >OBSERVACION DE RECHAZO</label><textarea value="'.$lt[2].'" id="nombre_observacion" name="nombre_observacion" type="text" class="validate materialize-textarea " style="" disabled>'.$lt[0].'</textarea>
		';
		}
		echo $imprime3;
	?>
	
</div>




<div class="row">
	
	<?
		
		boton_sin_icono_accion('right', 'APROBAR', 'enviar_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)', 'background: #229BFF;', 's12 m2 l2');
	?>
</div>

