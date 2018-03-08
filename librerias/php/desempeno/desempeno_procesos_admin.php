<?  include("../../lib/@session.php");
verifica_menu("administracion.html");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
$hora_log = date("G:i:s");




if($_POST["accion"]=="crea_criterio"){
	
	
	if($tipo_contrato==""){
		
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta el Tipo de Documento', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($_POST['nombre_criterio']==""){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite el nombre del criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($_POST['puntos_criterio']==""){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite el Puntaje del criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}else{
				include('function_criterios_aspectos.php');
				$tipo_contrato=$_POST['tipo_contrato'];
				$nombre_criterio=$_POST['nombre_criterio'];
				$puntos_criterio=$_POST['puntos_criterio'];
				$estado='1';
				$tblname = "t9_criterio";//Tabla en base de datos
				$inserta_criterio=insertar_criterio($tblname,$nombre_criterio,$puntos_criterio,$estado,$tipo_contrato);
				
			if($inserta_criterio==1){
				?>
				<script>//alert('Su Criterio Se Ha Registrado')
				window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha guardado el criterio', 40, 5, 12)
				window.parent.carga_criterio_admin_iframe();
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?php
			}else{
				?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Su Criterio No Se Ha Registrado', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
			}
	}
}



if($_POST["accion"]=="crea_aspecto"){

		$id_criterio=elimina_comillas(arreglo_recibe_variables($_POST["tipo_criterio_aspecto"]));	
		$tipo_servicio=$_POST["tipo_servicio"];	
		
	if($id_criterio=="" or $id_criterio==" " or $id_criterio=="0" or $id_criterio==0){
		
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta el Tipo de Criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($tipo_servicio=="" or $tipo_servicio==" "){
		
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta el Tipo de Servicio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($_POST['nombre_aspectos']==""){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta el Nombre del Aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($_POST['puntos_aspectos']==""){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta el Puntaje del Aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}elseif($_POST['nombre_descripcion']==""){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor Falta la Descripcion del Aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}else{
				
		
				include('function_criterios_aspectos.php');
				$nombre_aspectos=$_POST['nombre_aspectos'];
				$puntos_aspectos=$_POST['puntos_aspectos'];
				$nombre_descripcion=$_POST['nombre_descripcion'];
				$id_criterio;
				$tipo_servicio;
				$estado='1';
				$tblname = "t9_aspectos_criterio";//Tabla en base de datos
					$inserta_aspecto=insertar_aspecto($tblname,$id_criterio,$nombre_aspectos,$puntos_aspectos,$nombre_descripcion,$estado,$tipo_servicio);
			
			if($inserta_aspecto==1){
				?>
				<script>//alert('')
				window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha guardado el aspecto', 40, 5, 12)
				window.parent.carga_aspecto_admin_iframe();
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?php
			}else{
				?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Ha Registrado Su Aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
			}
		
				
	}
}

if($_POST["accion"]=="edita_criterio_admin"){
	$id_criterio=elimina_comillas(arreglo_recibe_variables($_POST["id_criterio"]));
	$nombre_criterio=$_POST["nombre_criterio"];//elimina_comillas($_POST["nombre_criterio"]);
	$puntos_criterio=$_POST["puntos_criterio"];//elimina_comillas($_POST["puntos_criterio"]);
	$tipo_contrato=$_POST["tipo_contrato"];//elimina_comillas($_POST["tipo_contrato"]);
	if($nombre_criterio=="" or $nombre_criterio==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite el nombre del criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($puntos_criterio=="" or $puntos_criterio==" " or $puntos_criterio=="0" or $puntos_criterio==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite los puntos del criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	
			
	query_db("UPDATE t9_criterio SET nombre_criterio='".$nombre_criterio."', puntos_criterio='".$puntos_criterio."', tipo_contrato=".$tipo_contrato." WHERE id_criterio=".$id_criterio);
	?>
		<script>
		window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha guardado el criterio', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
}

		?>
				
		
  <?php if($_POST["accion"]=="modal"){ ?>
  
			<script>alert('<?php echo $_POST['id_criterio'] ?>')</script>
			

  
				
		<?php


}




if($_POST["accion"]=="edita_aspecto_admin"){
	$id_aspecto=elimina_comillas(arreglo_recibe_variables($_POST["id_aspecto"]));
	$nombre_aspectos=$_POST["nombre_aspectos"];//elimina_comillas($_POST["nombre_criterio"]);
	$puntos_aspectos=$_POST["puntos_aspectos"];//elimina_comillas($_POST["puntos_criterio"]);
	$nombre_descripcion=$_POST["nombre_descripcion"];//elimina_comillas($_POST["nombre_descripcion"]);
	$tipo_criterio_aspecto=elimina_comillas(arreglo_recibe_variables($_POST["tipo_criterio_aspecto"]));//elimina_comillas($_POST["puntos_criterio"]);
	$tipo_servicio=$_POST["tipo_servicio"];//elimina_comillas($_POST["nombre_descripcion"]);
	
		
		
	
	if($nombre_aspectos=="" or $nombre_aspectos==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite el nombre del aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($puntos_aspectos=="" or $puntos_aspectos==" " or $puntos_aspectos=="0" or $puntos_aspectos==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite los puntos del aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($nombre_descripcion=="" or $nombre_descripcion==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '*Por favor digite la descripcion del aspecto', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_aspectos_criterio SET nombre_aspectos='".$nombre_aspectos."', puntos_aspectos='".$puntos_aspectos."', nombre_descripcion='".$nombre_descripcion."', id_criterio='".$tipo_criterio_aspecto."', tipo_servicio='".$tipo_servicio."' WHERE id_aspectos=".$id_aspecto);
	
	?>
		<script>
		window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha guardado el aspecto', 40, 5, 12)
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
	}

if($_POST["accion"]=="elimina_criterio_admin"){
	$id_criterio=elimina_comillas(arreglo_recibe_variables($_POST["id_criterio"]));
	query_db("UPDATE t9_criterio SET estado=3 WHERE id_criterio=".$id_criterio);
	
	?>
		<script>
		window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha eliminado el criterio', 40, 5, 12)
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
}
if($_POST["accion"]=="elimina_aspecto_admin"){
	$id_aspectos=elimina_comillas(arreglo_recibe_variables($_POST["id_aspectos"]));
	query_db("UPDATE t9_aspectos_criterio SET estado=3 WHERE id_aspectos=".$id_aspectos);
	
	?>
		<script>
		console.log('<?=$query?>');
		window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha eliminado el aspecto', 40, 5, 12)
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
}
if($_POST["accion"]=="modal"){ ?>
  
			<script>alert('<?php echo $_POST['id_criterio'] ?>')</script>
			

  
				
		<?php


}




if($_POST["accion"]=="acepta_criterios"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	$tipo_evlauacio=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_evaluacion));
	if($tipo_evlauacio[0]==1){//si el tipo de evaluacion es servicio menor
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion." group by id_criterio"));
		$puntaje_predefinido=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		$total_predefinida=traer_fila_row(query_db("select sum(puntaje_maximo) as puntaje from t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
		if($puntaje_predefinido[0] > $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser menor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}elseif($puntaje_predefinido[0] < $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser mayor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}
	}elseif($tipo_evlauacio[0]==2){//si el tipo de evaluacion es contrato puntual
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion." group by id_criterio"));
		$puntaje_predefinido=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		$total_predefinida=traer_fila_row(query_db("select sum(puntaje_maximo) as puntaje from t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
		if($puntaje_predefinido[0] > $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser menor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}elseif($puntaje_predefinido[0] < $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser mayor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}
	}elseif($tipo_evlauacio[0]==3){//si el tipo de evaluacion es contrato marco
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion." group by id_criterio"));
		$puntaje_predefinido=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		$total_predefinida=traer_fila_row(query_db("select sum(puntaje_maximo) as puntaje from t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
		if($puntaje_predefinido[0] > $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser menor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}elseif($puntaje_predefinido[0] < $total_predefinida[0]){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos no puede ser mayor a <?=$puntaje_predefinido[0]?> y tiene <?=$total_predefinida[0]?> puntos asignados', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}
	}
	
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='2' WHERE id_agregar_criterio=".$id_evaluacion);
	$tipo_evlauacion=traer_fila_row(query_db("select tipo_documento FROM t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));
	if($tipo_evlauacion[0]==1){
		include('correos_servicio_menor.php');
		envia_aprobacion_aspecto_menor($id_evaluacion);
	}
	if($tipo_evlauacion[0]==2){
		include('correos_contrato_puntual.php');
		envia_aprobacion_aspecto_puntual($id_evaluacion);
	}
	if($tipo_evlauacion[0]==3){
		include('correos_contrato_marco.php');
		envia_aprobacion_aspecto_marco($id_evaluacion);
	}
		
	
			?>
			<script>
			//alert("El archivo se cargo con exito")
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se han enviado sus aspectos.', 40, 5, 12)
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
	}
	
	


if($_POST["accion"]=="aceptar_criterio_aspecto"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='5' WHERE id_agregar_criterio=".$id_evaluacion);
	
	query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='3' and estado='1' and id_agrega_criterio=".$id_evaluacion);
	if($_POST["observacion_evaluaion"]!="" or $_POST["observacion_evaluaion"]!=" "){//validación para saber si hubo un comentario a la hora de aprobar los aspectos
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
			$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where id_estado='4' and id_agrega_criterio=".$id_evaluacion));

			if($consulta1[0]==1){
				query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='4' and id_agrega_criterio=".$id_evaluacion);
			}
			$fecha=date('Y-m-d');
			$hora = date("H:i:s a");
			query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('".$_POST["observacion_evaluaion"]."','$id_evaluacion','4','3', '".$fecha."', '".$hora."')");
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
	}
	
	$tipo_evlauacion=traer_fila_row(query_db("select tipo_documento,id_ot,id_agregar_criterio,id_criterio FROM t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));
	if($tipo_evlauacion[0]==1){
		include('correos_servicio_menor.php');
		envio_aprobacion_aspecto_proveedor_menor($id_evaluacion);
	}elseif($tipo_evlauacion[0]==2){
		include('correos_contrato_puntual.php');
		envio_aprobacion_aspecto_proveedor_puntual($id_evaluacion);
	}elseif($tipo_evlauacion[0]==3){
		
		
		if($tipo_evlauacion[1]!="" and  $tipo_evlauacion[1]!="NULL" and $tipo_evlauacion[1]!=NULL and $tipo_evlauacion[3]=='3'){
		
		include('correos_contrato_marco.php');
		envio_aprobacion_aspecto_proveedor_marco($id_evaluacion);
		
		}else{
			
			query_db("UPDATE t9_criterios_evaluacion SET id_estado='99' WHERE id_criterio='3' and id_agregar_criterio=".$tipo_evlauacion[2]);
			
		}
	}
			?>
			<script>
			//alert("El archivo se cargo con exito")
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se han aprobados los aspectos', 40, 5, 12);
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
	
	}
	
	
if($_POST["accion"]=="aceptar_aprobacion_evaluacion"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='9' WHERE id_agregar_criterio=".$id_evaluacion);
	
	query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='7' and estado='1' and id_agrega_criterio=".$id_evaluacion);
	
	query_db("UPDATE t9_agregar_evaluacion SET id_estado='9' WHERE id_agregar_criterio=".$id_evaluacion);
	if($_POST["observacion_evaluaion"]!="" or $_POST["observacion_evaluaion"]!=" "){//validación para saber si hubo un comentario a la hora de aprobar la evaluación
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
			$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where id_estado='8' and id_agrega_criterio=".$id_evaluacion));

			if($consulta1[0]==1){
				query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='8' and id_agrega_criterio=".$id_evaluacion);
			}
			$fecha=date('Y-m-d');
			$hora = date("H:i:s a");
			query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('".$_POST["observacion_evaluaion"]."','$id_evaluacion','8','3', '".$fecha."', '".$hora."')");
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
	}
			
	$tipo_evlauacion=traer_fila_row(query_db("select tipo_documento,id_documento,id_criterio,id_proveedor FROM t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));
	/* se ha comentariado por instrucciones de maria cock y camila castañeda referente a recomendaciones de juridico
	if($tipo_evlauacion[0]==1){
		//include('correos_servicio_menor.php');
		//envia_aprobacion_proveedor_evaluacion_menor($id_evaluacion);
	}elseif($tipo_evlauacion[0]==2){
		//include('correos_contrato_puntual.php');
		//envia_aprobacion_proveedor_evaluacion_puntual($id_evaluacion);
	}elseif($tipo_evlauacion[0]==3){
		
		//include('correos_contrato_marco.php');
		//envia_aprobacion_proveedor_evaluacion_marco($id_evaluacion);
		
	}  */
	/*
	if($tipo_evlauacion[0]==2 and ($tipo_evlauacion[0]==4 or $tipo_evlauacion[0]==6)){
		include('correos_contrato_puntual.php');
	}
	if($tipo_evlauacion[0]==3 and ($tipo_evlauacion[0]==5 or $tipo_evlauacion[0]==7)){
		include('correos_contrato_marco.php');
	}
	*/
	
	
	if($tipo_evlauacion[0]==2){
		$fecha_actual=date('Y-m-d');
		$vigencia_puntual=traer_fila_row(query_db("select * FROM vista_t9_contratos_definicion_criterios where id_contrato=".$tipo_evlauacion[1]));
				
				$nuevafecha = strtotime ('+1 year' , strtotime($vigencia_puntual[2])); //Se añade un año mas
				$nuevafecha1mas = date ('Y-m-d',$nuevafecha);
					
		if($vigencia_puntual[3]>$nuevafecha1mas){//si es mayor
			
			
		}
		
		if($vigencia_puntual[3]<$nuevafecha1mas){//si es menor
			
			query_db("UPDATE t9_criterios_evaluacion SET fecha_solicitud='".$vigencia_puntual[3]."', fecha_creacion='".$vigencia_puntual[3]."' WHERE  id_documento=".$tipo_evlauacion[1]);
						
		}
	}
	
	
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$vigencia=date("Y-m-d");
	$ano_actual=date("y");
	$mes_actual=date("n");
	$dia_actual=date("j");
	$un_ano_antes =strtotime ( '-1 year' , strtotime ($vigencia) );
	$un_ano_antes=date('Y-m-d', $un_ano_antes);
	$ano_cuatro_digitos=date("Y");
	$mes_dos_digitos=date("m");
	$dia_dos_digitos=date("d");
	
	if($tipo_evlauacion[0]==2){

	
	$cuenta_proveedor=traer_fila_row(query_db("SELECT count(*) FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor"));
	
	if($cuenta_proveedor[0]>0){
	/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor");
	while($lz=traer_fila_db($query)){
		echo "SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC<br><br>";
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=4 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =38"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 4, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=4 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=4 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	
		
		/*** INICIO PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=1 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=6 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =24"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 6, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 2, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=6 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=6 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS PUNTUALES EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
		
	}
	}
	}
	
	
	
	if($tipo_evlauacion[0]==3){

	
	$cuenta_proveedormac=traer_fila_row(query_db("SELECT count(*) FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor"));
	
	if($cuenta_proveedormac[0]>0){
		
		/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=5 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =37"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 5, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=5 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=5 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN HSSE QUE YA ESTÁN LEGALIZADOS ***/
	
	
	
	/*** INICIO PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
	$query=query_db("SELECT id_proveedor FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor='".$tipo_evlauacion[3]."' group by id_proveedor");
	while($lz=traer_fila_db($query)){
		$query5=query_db("SELECT * FROM vista_t9_contratos_definicion_criterios where t1_tipo_documento_id=2 and estado_contrato>=25 and estado_contrato<49 and vigencia_mes>='".$vigencia."' and tipo_servicio in(1,2) and id_proveedor=".$lz[0]." order by fecha_inicio ASC");
		$ls=traer_fila_row($query5);
		//echo "SELECT COUNT(*) FROM t9_criterios_evaluacion where id_documento=".$ls[0]." and fecha_solicitud='".$vigencia."'<br>";
		$consecutivo_num3=traer_fila_row(query_db("SELECT MAX(num3) from t9_criterios_evaluacion"));
		if($consecutivo_num3[0]==""){
			$consecutivo_num3[0]=1;
		}else{
			$consecutivo_num3[0]=$consecutivo_num3[0]+1;
		}
		if($ls[4]==2 and $ls[5]==29){//si es biciesto
			$ls[5]=28;
		}
		$jefe=busca_jefe_area_contrato_id_contrato_mc($ls[0]);
		$valida=traer_fila_row(query_db("SELECT COUNT(*) FROM t9_criterios_evaluacion where id_criterio=7 and  id_proveedor=".$lz[0]." and fecha_solicitud LIKE '%".($ano_cuatro_digitos)."%'"));
		if($valida[0]==0){//evita repetir registros
			//if($mes_actual==$ls[4] and $dia_actual==$ls[5]){//verifica si cumple el año
				$evaluador=traer_fila_row(query_db("select id_usuario FROM tseg12_relacion_usuario_rol where id_rol_general =24"));
				$query2="INSERT INTO t9_criterios_evaluacion(id_evaluador,id_estado,num1,num2,num3,id_criterio,fecha_solicitud,fecha_creacion,id_proveedor,id_documento,tipo_documento,id_crea_aspectos,id_jefe) VALUES(".$evaluador[0].", 5, 'E', '".$ano_actual."', '".$consecutivo_num3[0]."', 7, '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', '".($ano_cuatro_digitos)."-".$ls[4]."-".$ls[5]."', ".$ls[12].", ".$ls[0].", 3, ".$ls[9].", ".$jefe.")";
				$sql_ex=query_db($query2.$trae_id_insrte);
				$id_ingreso = id_insert($sql_ex);//id del contrato
				if($ls[7]==1){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=7 and tipo_servicio=0 and estado=1");
				}elseif($ls[7]==2){//tipo de servicio
					$query3=query_db("INSERT INTO t9_agregar_aspecto(nombre_aspectos,puntaje_maximo, nombre_descripcion, id_estado, id_agregar_criterio, puntaje_obtenido) select nombre_aspectos, puntos_aspectos, nombre_descripcion, 1, $id_ingreso, NULL from t9_aspectos_criterio where id_criterio=7 and tipo_servicio=0 and estado=1");
				}
			//}
		}
	}
	/*** FIN PARA BUSCAR LOS CONTRATOS MARCO EVALUACIÓN ADMINISTRATIVA QUE YA ESTÁN LEGALIZADOS ***/
		
		
	}
	
	}
	/*
			?>
			<script>
			//alert("El archivo se cargo con exito")
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha aprobado la evaluación y se ha enviado al contratista', 40, 5, 12)
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<? */
	
	}
	
	
if($_POST["accion"]=="rechaza_criterio_aspecto"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	$nombre_observacion=$_POST["nombre_observacion"];
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=aprobacion_criterio_evaluacion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($nombre_observacion=="" or $nombre_observacion==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La observación es obligatoria', 40, 5, 12);
		window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=aprobacion_criterio_evaluacion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	
	
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='3' WHERE id_agregar_criterio=".$id_evaluacion);
	
	
	
	
	$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where estado='1' and id_estado='3' and id_agrega_criterio=".$id_evaluacion));
		
		if($consulta1[0]==1){
				query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='3' and id_agrega_criterio=".$id_evaluacion);
	
		
		}
	$fecha=date('Y-m-d');
	$hora = date("H:i:s a");
	query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('$nombre_observacion','$id_evaluacion','3','1', '".$fecha."', '".$hora."')");
		
			?>
			<script>
			//alert("El archivo se cargo con exito")
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se han rechazado los aspectos', 40, 5, 12)
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
	}
	
if($_POST["accion"]=="rechaza_aprobacion_evaluacion"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	$nombre_observacion=$_POST["nombre_observacion"];
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($nombre_observacion=="" or $nombre_observacion==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La observación es obligatoria', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='7' WHERE id_agregar_criterio=".$id_evaluacion);
	
	
	
	
	$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where estado='1' and id_estado='7' and id_agrega_criterio=".$id_evaluacion));
		
		if($consulta1[0]==1){
				query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='7' and id_agrega_criterio=".$id_evaluacion);
	
		
		}
	$fecha=date('Y-m-d');
	$hora = date("H:i:s a");
	query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('$nombre_observacion','$id_evaluacion','7','1', '".$fecha."', '".$hora."')");
	
		
		?>
			<script>
			//alert("El archivo se cargo con exito")
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha rechazado la evaluación', 40, 5, 12);
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=<?=$_POST["id_evaluacion"]?>', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
	
	}
	
	
	

if($_POST["accion"]=="aceptar_evaluacion_aprobacion"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='4' WHERE id_agregar_criterio=".$id_evaluacion);

	
	}
	
	
if($_POST["accion"]=="rechaza_evaluacion_aprobacion"){
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_evaluacion"]));
	
		
	if($id_evaluacion=="" or $id_evaluacion==" " or $id_evaluacion=="0" or $id_evaluacion==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='3' WHERE id_agregar_criterio=".$id_evaluacion);

	
	}



if($_POST["accion"]=="elimina_configuracion_criterio"){
	$id_aspectos=elimina_comillas(arreglo_recibe_variables($_POST["id_aspectos"]));
	$id_criterio_evaluacion=elimina_comillas(arreglo_recibe_variables($_POST["id_criterio_evaluacion"]));
	
		
	if($id_aspectos=="" or $id_aspectos==" " or $id_aspectos=="0" or $id_aspectos==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
			
	query_db("UPDATE t9_agregar_aspecto SET id_estado='3' WHERE id_aspectos_nuevo='".$id_aspectos."' and id_agregar_criterio=".$id_criterio_evaluacion);
	
															?>
															<script>
															//alert("El archivo se cargo con exito")
															window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha eliminado el aspecto correctamente', 40, 5, 12)
															window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=definicion_criterio_evaluacion&function3=<?=$_POST["id_criterio_evaluacion"]?>&function4=muestra_modal_configurar_aspecto', 'contenidos');
															window.parent.$('html, body').animate({scrollTop:0}, 'slow');
															//muestra_modal_configurar_aspecto(id_criterio);
															</script>
															<?
	}
	
	
	
	
if($_POST["accion"]=="crear_nuevo_aspecto_evaluacion"){
	$id_agrega_criterio=elimina_comillas(arreglo_recibe_variables($_POST["id_agrega_criterio"]));
	$tipo_evlauacio=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_agrega_criterio));
	if($tipo_evlauacio[0]==1){//si el tipo de evaluacion es servicio menor
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_servicio_menor where id_evaluacion=".$id_agrega_criterio." group by id_criterio"));
		$puntos_almacenado=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		?>
		<script>
			console.log("SM TOAL PUNTOS <?=$puntos_almacenado[0]?>");
		</script>
		<?
	}elseif($tipo_evlauacio[0]==2){//si el tipo de evaluacion es contrato puntual
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_contrato_puntual where id_evaluacion=".$id_agrega_criterio." group by id_criterio"));
		$puntos_almacenado=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		?>
		<script>
			console.log("PUNTUAL TOAL PUNTOS <?=$puntos_almacenado[0]?>");
		</script>
		<?
	}elseif($tipo_evlauacio[0]==3){//si el tipo de evaluacion es contrato marco
		$id_criterio=traer_fila_row(query_db("select id_criterio from vista_t9_contrato_marco where id_evaluacion=".$id_agrega_criterio." group by id_criterio"));
		$puntos_almacenado=traer_fila_row(query_db("select puntos_criterio from t9_criterio where id_criterio=".$id_criterio[0]));
		?>
		<script>
			console.log("MARCO TOAL PUNTOS <?=$puntos_almacenado[0]?>");
		</script>
		<?
	}
	$puntos_almacenado=$puntos_almacenado[0];
		
	//$puntos_almacenado=40;
	$id=$_POST["id_existente"];
	$nom=$_POST["nombre_existente"];
	$punt=$_POST["puntos_existente"];
	
	$nom1=$_POST["nombre_aspecto"];
	$punt1=$_POST["puntos_aspecto"];
	
	
	$tamaño=sizeof($id);
	$tamaño1=sizeof($nom1);
	
	if($tamaño=="" or $tamaño==" " or $tamaño=="0" or $tamaño==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		</script>
		<?
		exit;
	}
	if($tamaño1>0){//si se agregaron nuevos aspectos
		foreach ( $id as $como => $id_aspecto) {//Se suma el total de los puntos de los aspectos que ya están guardados.
			if($nom[$como]=="" or $nom[$como]==" "){//valida que los nombres de los aspectos que ya etán guardados no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los nombres de los aspectos no pueden estar vacíos.', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($punt[$como]=="" or $punt[$como]==" "){//valida que los puntos de los aspectos que ya etán guardados no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los puntos de los aspectos no pueden estar vacíos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($punt[$como]<0){//valida que los puntos de los aspectos que ya etán guardados no sean negativos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje mínimo de los aspectos es cero(0), los puntos no pueden ser valores negativos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			$puntos_existentes=$puntos_existentes+$punt[$como];
		}
		foreach ( $punt1 as $como => $puntos_nuevos) {//Se suma el total de los puntos de los aspectos nuevos.
			if($nom1[$como]=="" or $nom1[$como]==" "){//valida que los nombres de los aspectos nuevos no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los nombres de los aspectos no pueden estar vacíos.', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($puntos_nuevos=="" or $puntos_nuevos==" "){//valida que los puntos de los aspectos nuevos no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los puntos de los aspectos no pueden estar vacíos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($puntos_nuevos<0){//valida que los puntos de los aspectos nuevos no sean negativos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje mínimo de los aspectos es cero(0), los puntos no pueden ser valores negativos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			$puntos_nuevos_suma=$puntos_nuevos_suma+$puntos_nuevos;
		}
		$puntos_totales=$puntos_existentes+$puntos_nuevos_suma;
		if($puntos_totales==$puntos_almacenado){//si la sumatoria de los puntos hechos por el usuario es igual al total del puntaje de los aspectos preestablecidos.		
			foreach ( $id as $como => $id_aspecto) {//se actualiza los puntos de los aspectos que ya estaban guardados.
				query_db("UPDATE t9_agregar_aspecto SET nombre_aspectos='".$nom[$como]."', puntaje_maximo='".$punt[$como]."' WHERE id_aspectos_nuevo=".$id_aspecto);
			}
			foreach ( $punt1 as $como => $puntos_nuevos) {//Se crean los aspectos nuevos.
				$sql="INSERT INTO t9_agregar_aspecto (nombre_aspectos,puntaje_maximo,id_estado,id_agregar_criterio)  VALUES('".$nom1[$como]."','".$puntos_nuevos."','1','".$id_agrega_criterio."')";
				query_db($sql);
			}
			//se cambia el estado de los aspectos
			query_db("UPDATE t9_criterios_evaluacion SET id_estado='2' WHERE id_agregar_criterio=".$id_agrega_criterio);
				?>
				<script>
				/*** si el proceso es exitoso se limpian todas las variables***/
				window.parent.$('input[name="id_existente[]"]').remove();
				window.parent.$('input[name="nombre_existente[]"]').remove();
				window.parent.$('input[name="puntos_existente[]"]').remove();

				window.parent.$('input[name="nombre_aspecto[]"]').remove();
				window.parent.$('input[name="puntos_aspecto[]"]').remove();
				window.parent.$('input[name="id_agrega_criterio"]').remove();
				/*** fin si el proceso es exitoso se limpian todas las variables***/
				window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se han creado sus aspectos correctamente', 40, 5, 12)
				window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=definicion_criterio_evaluacion&function3=<?=$_POST["id_agrega_criterio"]?>', 'contenidos');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				//return false;
				</script>
				<?
		}elseif($puntos_totales>$puntos_almacenado){//si el total de los puntos creados por el usuario es mayor que los puntos preestablecidos.
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos supera a los establecidos que son <?=$puntos_almacenado?> y hay <?=$puntos_totales?>', 40, 5, 12);
			window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}else{//si el total de los puntos creados por el usuario es menor que los puntos preestablecidos.
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos es menor a los establecidos que son <?=$puntos_almacenado?> y hay <?=$puntos_totales?>', 40, 5, 12);
			window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}
	}else{//si solo son aspectos existentes
		foreach ( $id as $como => $id_aspecto) {//valida que los puntajes no vayan a ser mayores a los preestablecidos.
			if($nom[$como]=="" or $nom[$como]==" "){//valida que los nombres de los aspectos que ya etán guardados no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los nombres de los aspectos no pueden estar vacíos.', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($punt[$como]=="" or $punt[$como]==" "){//valida que los puntos de los aspectos que ya etán guardados no estén vacíos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'Los puntos de los aspectos no pueden estar vacíos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			if($punt[$como]<0){//valida que los puntos de los aspectos que ya etán guardados no sean negativos
				?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje mínimo de los aspectos es cero(0), los puntos no pueden ser valores negativos', 40, 5, 12);
				window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
				window.parent.$('html, body').animate({scrollTop:0}, 'slow');
				</script>
				<?
				exit;
			}
			$puntos_existentes=$puntos_existentes+$punt[$como];
		}
		if($puntos_existentes==$puntos_almacenado){//Si eltotal del puntaje definido por el usuario es igual al total del criterio predefinido entonces actualiza.
			foreach ( $id as $como => $id_aspecto) {
				query_db("UPDATE t9_agregar_aspecto SET nombre_aspectos='".$nom[$como]."', puntaje_maximo='".$punt[$como]."' WHERE id_aspectos_nuevo=".$id_aspecto);
			}
			query_db("UPDATE t9_criterios_evaluacion SET id_estado='2' WHERE id_agregar_criterio=".$id_evaluacion);
			?>
			<script>
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se han creado sus aspectos correctamente', 40, 5, 12);
			/*** si el proceso es exitoso se limpian todas las variables***/
			window.parent.$('input[name="id_existente[]"]').remove();
			window.parent.$('input[name="nombre_existente[]"]').remove();
			window.parent.$('input[name="puntos_existente[]"]').remove();

			window.parent.$('input[name="nombre_aspecto[]"]').remove();
			window.parent.$('input[name="puntos_aspecto[]"]').remove();
			window.parent.$('input[name="id_agrega_criterio"]').remove();
			/*** fin si el proceso es exitoso se limpian todas las variables***/
			window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=definicion_criterio_evaluacion&function3=<?=$_POST["id_agrega_criterio"]?>', 'contenidos');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
		}elseif($puntos_existentes>$puntos_almacenado){
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos supera a los establecidos que son <?=$puntos_almacenado?> y hay <?=$puntos_existentes?>', 40, 5, 12);
			window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}else{
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El total de puntos es menor a los establecidos que son <?=$puntos_almacenado?> y hay <?=$puntos_existentes?>', 40, 5, 12);
			window.parent.$('#iframe_desempeno_admin')[0].contentWindow.muestra_modal_configurar_aspecto('<?=$_POST["id_agrega_criterio"]?>');
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			</script>
			<?
			exit;
		}
	}
}
	
	
		
	
if($_POST["accion"]=="aspectos_calificados_evaluacion"){
	$id_agrega_criterio=elimina_comillas(arreglo_recibe_variables($_POST["id_agrega_criterio"]));
	$id=$_POST["id_calificados"];
	$nom=$_POST["aspecto_calificados"];
	$punt=$_POST["aspecto_puntos_calificados"];
	$fecha=date("Y-m-d");
	$hora = date("H:i:s a");
	$punt1=$_POST["puntos_calificados"];
	$observacion_general=$_POST["observacion_general"];
	$tamaño=sizeof($id);
	if($tamaño=="" or $tamaño==" " or $tamaño=="0" or $tamaño==0){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No Se Pudo Guardar', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		/*** se limpian todas las variables del fromulario forma ***/
		window.parent.$('input[name="id_calificados[]"]').remove();
		window.parent.$('input[name="aspecto_calificados[]"]').remove();
		window.parent.$('input[name="aspecto_puntos_calificados[]"]').remove();
		window.parent.$('input[name="puntos_calificados[]"]').remove();
		window.parent.$('input[name="observacion_general"]').remove();
		window.parent.$('input[name="id_agrega_criterio"]').remove();
		/*** fin se limpian todas las variables del fromulario forma ***/
		</script>
		<?
		exit;
	}
	if($observacion_general=="" or $observacion_general==" "){
		?>
		<script>
		window.parent.muestra_alerta_error_solo_texto('', 'Error', 'La observación es obligatoria', 40, 5, 12);
		window.parent.$('html, body').animate({scrollTop:0}, 'slow');
		/*** se limpian todas las variables del fromulario forma ***/
		window.parent.$('input[name="id_calificados[]"]').remove();
		window.parent.$('input[name="aspecto_calificados[]"]').remove();
		window.parent.$('input[name="aspecto_puntos_calificados[]"]').remove();
		window.parent.$('input[name="puntos_calificados[]"]').remove();
		window.parent.$('input[name="observacion_general"]').remove();
		window.parent.$('input[name="id_agrega_criterio"]').remove();
		/*** fin se limpian todas las variables del fromulario forma ***/
		</script>
		<?
		exit;
	}
	foreach ( $punt1 as $como => $nom) {//valida que los puntajes no vayan a ser mayores a los preestablecidos.
		if($nom>$punt[$como]){
			$nom_aspecto=traer_fila_row(query_db("SELECT nombre_aspectos from t9_agregar_aspecto where id_aspectos_nuevo=".$id[$como]));
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje ingresado <?=$nom?>, en el aspecto <?=utf8_encode($nom_aspecto[0]);?> no puede superar al establecido: <?=$punt[$como]?>', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			/*** se limpian todas las variables del fromulario forma ***/
			window.parent.$('input[name="id_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_puntos_calificados[]"]').remove();
			window.parent.$('input[name="puntos_calificados[]"]').remove();
			window.parent.$('input[name="observacion_general"]').remove();
			window.parent.$('input[name="id_agrega_criterio"]').remove();
			/*** fin se limpian todas las variables del fromulario forma ***/
			</script>
			<?
			exit;
		}
		if($nom=="" or $nom==" "){//valida que los puntajes ingresados no vayan a venir vacíos
			$nom_aspecto=traer_fila_row(query_db("SELECT nombre_aspectos from t9_agregar_aspecto where id_aspectos_nuevo=".$id[$como]));
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje máximo del aspecto <?=utf8_encode($nom_aspecto[0]);?> es de <?=$punt[$como]?>, el  ingresado no puede ser vacío.', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			/*** se limpian todas las variables del fromulario forma ***/
			window.parent.$('input[name="id_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_puntos_calificados[]"]').remove();
			window.parent.$('input[name="puntos_calificados[]"]').remove();
			window.parent.$('input[name="observacion_general"]').remove();
			window.parent.$('input[name="id_agrega_criterio"]').remove();
			/*** fin se limpian todas las variables del fromulario forma ***/
			</script>
			<?
			exit;
		}
		if($nom<0){//valida que los puntajes ingresados no vayan a venir vacíos
			$nom_aspecto=traer_fila_row(query_db("SELECT nombre_aspectos from t9_agregar_aspecto where id_aspectos_nuevo=".$id[$como]));
			?>
			<script>
			window.parent.muestra_alerta_error_solo_texto('', 'Error', 'El puntaje mínimo del aspecto <?=utf8_encode($nom_aspecto[0]);?> es de cero(0), el  ingresado no puede ser un valor negativo.', 40, 5, 12);
			window.parent.$('html, body').animate({scrollTop:0}, 'slow');
			/*** se limpian todas las variables del fromulario forma ***/
			window.parent.$('input[name="id_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_calificados[]"]').remove();
			window.parent.$('input[name="aspecto_puntos_calificados[]"]').remove();
			window.parent.$('input[name="puntos_calificados[]"]').remove();
			window.parent.$('input[name="observacion_general"]').remove();
			window.parent.$('input[name="id_agrega_criterio"]').remove();
			/*** fin se limpian todas las variables del fromulario forma ***/
			</script>
			<?
			exit;
		}
	}
	foreach ( $punt1 as $como => $nom) {//Si cumple todas las validaciones actualiza los registros
		$puntaje_clasificacion=$puntaje_clasificacion+$nom;
		query_db("UPDATE t9_agregar_aspecto SET puntaje_obtenido='".$nom."' WHERE id_aspectos_nuevo=".$id[$como]);
    }
?>
	<script>
	console.log('<?=$puntaje_clasificacion?>');
	</script>
	<?
	if($puntaje_clasificacion<60){
		$clasificacion='1';
	}elseif($puntaje_clasificacion<80){
		$clasificacion='2';
	}elseif($puntaje_clasificacion<90){
		$clasificacion='3';
	}else{
		$clasificacion='4';
	}
	query_db("UPDATE t9_criterios_evaluacion SET id_estado='6' WHERE id_agregar_criterio=".$id_agrega_criterio);
	$consulta1=traer_fila_row(query_db("select count(*) FROM t9_agregar_evaluacion where id_agregar_criterio=".$id_agrega_criterio));
	if($consulta1[0]==1){
		query_db("UPDATE t9_agregar_evaluacion SET observacion_general='$observacion_general', id_clasificacion=".$clasificacion." WHERE id_agregar_criterio=".$id_agrega_criterio);
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
		$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where estado='1' and id_estado='6' and id_agrega_criterio=".$id_agrega_criterio));
		
		if($consulta1[0]==1){
			query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='6' and id_agrega_criterio=".$id_agrega_criterio);
		}
		$fecha=date('Y-m-d');
		$hora = date("H:i:s a");
		query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('$observacion_general','$id_agrega_criterio','6','1', '".$fecha."', '".$hora."')");
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
	}else{
		query_db("insert into t9_agregar_evaluacion (id_agregar_criterio,id_estado,observacion_general,id_clasificacion,fecha_evaluacion, hora) values('".$id_agrega_criterio."','','".$observacion_general."','".$clasificacion."','".$fecha."', '".$hora."')");
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
		$consulta1=traer_fila_row(query_db("select count(*) FROM t9_observacion where estado='1' and id_estado='6' and id_agrega_criterio=".$id_agrega_criterio));
		
		if($consulta1[0]==1){
			query_db("UPDATE t9_observacion SET estado='3' WHERE id_estado='6' and id_agrega_criterio=".$id_agrega_criterio);
		}
		$fecha=date('Y-m-d');
		$hora = date("H:i:s a");
		query_db("insert into t9_observacion (nombre_observacion,id_agrega_criterio,id_estado,estado, fecha, hora) values('$observacion_general','$id_agrega_criterio','6','1', '".$fecha."', '".$hora."')");
		/**** PARA GUADAR TODAS LAS OBSERVACIONES *****/
	}
	
	
	$tipo_evlauacion=traer_fila_row(query_db("select tipo_documento FROM t9_criterios_evaluacion where id_agregar_criterio=".$id_agrega_criterio));
	if($tipo_evlauacion[0]==1){
		include('correos_servicio_menor.php');
		envia_aprobacion_evaluacion_menor($id_agrega_criterio);
	}
	if($tipo_evlauacion[0]==2){
		include('correos_contrato_puntual.php');
		envia_aprobacion_evaluacion_puntual($id_agrega_criterio);
	}
	if($tipo_evlauacion[0]==3){
		include('correos_contrato_marco.php');
		envia_aprobacion_evaluacion_marco($id_agrega_criterio);
	}
		
		
	?>
	<script>
	//alert("El archivo se cargo con exito")
	window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Se ha enviado la evaluación para su revisión de aprobación.', 40, 5, 12)
	window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3=<?=$_POST["id_agrega_criterio"]?>', 'contenidos');
	window.parent.$('html, body').animate({scrollTop:0}, 'slow');
	</script>
	<?
	
}






?>