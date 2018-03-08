<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	$_SESSION["sql_comple_periodo"];
	$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
	$consulta4=traer_fila_row(query_db("select tipo_documento, fecha_periodo_evaluado, id_proveedor  FROM dbo.historico_desempeno_resultados() where id_evaluacion=".$id_evaluacion));
	$periodo2=$consulta4[1];
	$nombre_proveedor=traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$consulta4[2]));
	if($consulta4[0]==1){
			 $result=traer_fila_row(query_db("select convert(varchar(max), objeto), nombre_proveedor, periodo_evaluacion, nombre_gerente, numero_documento,id_documento,id_estado_criterio, id_crea_aspectos, nombre_criterio FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			$fecha_inicial_documento="";
			$fecha_final_documento="";
			$objeto_documento=$result[0];
			$nombre_contratista=$result[1];
			$periodo = $result[2];
			$gerente_solicitante=$result[3];
			$numero_contrato=$result[4];
			$id_documento=$result[5];
			$estado_criterio=$result[6];
			$id_gerente_solicitante=$result[7];
			$nombre_criterio=$result[8];
			$jefe=busca_jefe_area_servicio_menor($id_documento, $id_gerente_solicitante);
		}
		if($consulta4[0]==2){
			$result=traer_fila_row(query_db("select fecha_inicio_contrato,fecha_fin_contrato,convert(varchar(max), objeto),nombre_proveedor,periodo_evaluacion,nombre_gerente,numero_documento,id_documento,id_estado_criterio, nombre_criterio from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			$fecha_inicial_documento=$result[0];
			$fecha_final_documento=$result[1];
			$objeto_documento=$result[2];
			$nombre_contratista=$result[3];
			$periodo = $result[4];
			$gerente_solicitante=$result[5];
			$numero_contrato=$result[6];
			$id_documento=$result[7];
			$estado_criterio=$result[8];
			$nombre_criterio=$result[9];
			$jefe=busca_jefe_area_contrato_id_contrato_mc($id_documento);
		}
		if($consulta4[0]==3){
			$result=traer_fila_row(query_db("select fecha_inicio_contrato,fecha_fin_contrato,convert(varchar(max), objeto),nombre_proveedor,periodo_evaluacion,nombre_gerente,numero_documento,id_documento,id_estado_criterio, nombre_criterio from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			$fecha_inicial_documento=$result[0];
			$fecha_final_documento=$result[1];
			$objeto_documento=$result[2];
			$nombre_contratista=$result[3];
			$periodo = $result[4];
			$gerente_solicitante=$result[5];
			$numero_contrato=$result[6];
			$id_documento=$result[7];
			$estado_criterio=$result[8];
			$jefe=busca_jefe_area_contrato_id_contrato_mc($id_documento);
			$nombre_criterio=$result[9];
		}
		$ano_anterior=strtotime ( '-1 year' , strtotime ($periodo2) );
		$ano_anterior=date('Y-m-d', $ano_anterior);
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">RESULTADOS DEL PERIODO <?=$ano_anterior." / ".$periodo2;?> DEL PROVEEDOR:<br> <?=$nombre_proveedor[0];?></h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>		
<div class="row">
<?
		
		$consulta1=traer_fila_row(query_db("select id_estado,id_evaluador,id_crea_aspectos FROM t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));
		
		if($consulta1[0]==1 or $consulta1[0]==3){
				if($consulta1[2]==$_SESSION['id_us_session']){
			
			
			  $link_definir='definicion_criterio_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)';
			  
				}
					
		}
		
		if($consulta1[0]==2){
						if($jefe==$_SESSION['id_us_session']){
					$link_definir1='aprobacion_criterio_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)';
						}
		}
		
		
		if($consulta1[0]==5 or $consulta1[0]==7){
		
				if($consulta1[1]==$_SESSION['id_us_session']){
							$link_definir2='envio_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)';
						}
		}
		
		if($consulta1[0]==6){
					if($jefe==$_SESSION['id_us_session']){
					 $link_definir3='aprobacion_evaluacion(&apos;'.$_GET['id_evaluacion'].'&apos;)';
				}
		}
		

			/*$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$consulta[10]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $consulta[6];//consecutivo
			$numero_contrato4 = $consulta[11];//apellido
			//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
			$numero_contrato = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $consulta[4]);
			
			*/
			
			

		
			if($estado_criterio<=4){
				
				$estado=$consulta[1];
			}else{
				
				$estado='Aprobar Criterios';
				
			}
			
			if($estado_criterio==1 or $estado_criterio==3){
				
				$stylo_icono1='color: #FFA000;';
				
			}else{
				
				$stylo_icono1='color: #4CAF50;';
			}
			
			
			
			if($estado_criterio==2){
				
				$stylo_icono2='color: #FFA000;';
				
			}elseif($estado_criterio>=4){
				
				$stylo_icono2='color: #4CAF50;';
				
			}elseif($estado_criterio==3){
				
				$stylo_icono2='color: #D32F2F;';
			}else{
				
				$stylo_icono2='color: #BDBDBD;';
			}
			
			
			if($estado_criterio==5 or $estado_criterio==7){
				
				$stylo_icono3='color: #FFA000;';
				
			}elseif($estado_criterio==6 or $estado_criterio>=8){
				
				$stylo_icono3='color: #4CAF50;';
			}elseif($estado_criterio==7){
				
				$stylo_icono3='color: #D32F2F;';
			}else{
				
				$stylo_icono3='color: #BDBDBD;';
			}
			
			
			if($estado_criterio==6){
				
				$stylo_icono4='color: #FFA000;';
				
			}elseif($estado_criterio>=8){
				
				$stylo_icono4='color: #4CAF50;';
				
			}elseif($estado_criterio==7){
				
				$stylo_icono4='color: #D32F2F;';
			}else{
				
				$stylo_icono4='color: #BDBDBD;';
			}
			
	
		
		//$col, $texto, $estilo_texto_contenido
		menu_banner('s12 m12 l12', '<div class="row"><div class="col s12 m6 l8">Numero del Documento Contractual: &nbsp;&nbsp;'.$numero_contrato.'<br>Fecha del Documento: &nbsp;&nbsp;'.$fecha_inicial_documento. '/' .$fecha_final_documento.'<br>Objeto: &nbsp;&nbsp;'.$objeto_documento.'</div><div class="col s12 m6 l4">Nombre Contratista: <br>' .$nombre_contratista.'<br>Periodo A Evaluar: <br>'.$periodo.'<br>Gerente / Solicitante: <br>' .$gerente_solicitante.'</div></div>', 'font-size: 16pt; font-weight: 900 !important; tex-align:center; tex-align:justify; color: #ffffff;','color: #229BFF; tex-align:center;','background:#229BFF !important;');
		
		?>

</div>
<?
if($consulta4[0]!=1){//SI NO ES SERVICIO MENOR
?>
<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 700 !important;">Recuerde que la evaluaci&oacute;n t&eacute;cnica corresponde a 40 puntos del total de la evaluaci&oacute;n, la evaluaci&oacute;n HSSE coresponde a 35 puntos y la evaluaci&oacute;n Administrativa corresponde a 25 puntos.</h5></div>
<?
}
?>
<?
		if($consulta4[0]==1){//SI ES SERVICIO MENOR
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select  nombre_aspectos, puntaje_obtenido FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			?>
			<div class="row">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n T&eacute;cnica</div>
						<div class="collapsible-body">
							<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_tecnica="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_servicio_menor where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(1,2,3) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_tecnica);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}	
							}
							?>		<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
				</ul>
			</div>
			<?
			
		}
		if($consulta4[0]==2){
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			$select_tabla="select  nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			?>
			<div class="row">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n T&eacute;cnica</div>
						<div class="collapsible-body">
							<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_tecnica="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_puntual where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(1,2,3) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_tecnica);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}	
							}
							?>
							<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n HSSE</div>
					 	<div class="collapsible-body">
					 		<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_hsse="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_puntual where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(4,5) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_hsse);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}	
							}
							?>
							<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n Administrativa</div>
						<div class="collapsible-body">
							<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_administrativa="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_puntual where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(6,7) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_administrativa);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}	
							}
							?>
							<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
				</ul>
			</div>
			<?
		}
		if($consulta4[0]==3){
			
			$consulta=traer_fila_row(query_db("SELECT  nombre_criterio, puntos_criterio FROM vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			$tipo_Criterio=$consulta[0];
			
			
			$select_tabla="select  nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;
			?>
			<div class="row">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n T&eacute;cnica</div>
						<div class="collapsible-body">
							<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_tecnica="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_marco where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(1,2,3) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_tecnica);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}	
							}
							?>		<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n HSSE</div>
					 	<div class="collapsible-body">
					 		<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_hsse="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_marco where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(4,5) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_hsse);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}
							}
							?>
							<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
					<li>
					  <div class="collapsible-header" style="font-size:18pt !important; font-weight: 900 !important;">Evaluaci&oacute;n Administrativa</div>
						<div class="collapsible-body">
							<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
								<thead>
								  <tr>
									  <th width="80%" style="font-size:18pt !important; font-weight: 900 !important;">
										Criterios Evaluados
									  </th>
									  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
										Calificaci&oacute;n
									  </th>
								  </tr>
								</thead>
								<tbody id="body_periodo_resultados">
							<?
							$query_administrativa="select nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado from vista_t9_contrato_marco where fecha_periodo_evaluado between '".$ano_anterior."' and '".$periodo2."' and estado_aspecto=1 and id_criterio in(6,7) and id_proveedor=".$consulta4[2]." group by nombre_aspectos, puntaje_obtenido, id_evaluacion, fecha_periodo_evaluado order by fecha_periodo_evaluado desc";
							$total_tecnica=0;
							$bandera=false;
							$id_proceso=0;
							$id_pasa_variable=0;
							$db=query_db($query_administrativa);
							while($lt=traer_fila_db($db) and $bandera==false){
								if($id_proceso==0){
									$id_proceso=$lt[2];
								}
								if($id_proceso==$lt[2]){
									$id_pasa_variable=$id_proceso;
									$total_tecnica=$total_tecnica+$lt[1];
									echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
								}else{
									$bandera=true;
								}
							}
							?>
							<tr><td style="font-size:18pt !important; font-weight: 900 !important;">Total</td><td style="font-size:18pt !important; font-weight: 900 !important;"><?=$total_tecnica;?></td></tr>
								</tbody>
							</table>
							<?
							if($total_tecnica!=0){
							?>
							<div class="row" style="margin-top: 2% !important">
								<div class="right"><a class="waves-effect waves-light btn right" onclick="muestra_modal_comentario_resultado('<?=arreglo_pasa_variables($id_pasa_variable);?>')" style="background: #229BFF;">OBSERVACIONES</a></div>
							</div>
							<?
							}
							?>
						</div>
					</li>
				</ul>
			</div>
			<?
		}
?>