<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">GESTION</h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>		
<div class="row">
<?		
		
		
		
		
		$id_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
		
		
		$consulta4=traer_fila_row(query_db("select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_evaluacion));

		
		if($consulta4[0]==1){
			
			
			
			 $result=traer_fila_row(query_db("select convert(varchar(max), objeto), nombre_proveedor, periodo_evaluacion, nombre_gerente, numero_documento,id_documento,id_estado_criterio, id_crea_aspectos,fecha_inicio_ot,fecha_fin_ot FROM vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			 
		
			$objeto_documento=$result[0];
			$nombre_contratista=$result[1];
		
			$periodo = $result[2];
			
			$gerente_solicitante=$result[3];
			$numero_contrato=$result[4];
			$id_documento=$result[5];
			$estado_criterio=$result[6];
			$id_gerente_solicitante=$result[7];
			$fecha_inicial_documento=$result[8];
			$fecha_final_documento=$result[9];
			$jefe=busca_jefe_area_servicio_menor($id_documento, $id_gerente_solicitante);
			
			
		}
		if($consulta4[0]==2){
			
			$result=traer_fila_row(query_db("select fecha_inicio_contrato,fecha_fin_contrato,convert(varchar(max), objeto),nombre_proveedor,periodo_evaluacion,nombre_gerente,numero_documento,id_documento,id_estado_criterio from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			 
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
			
			
		}
		if($consulta4[0]==3){
			
			$result=traer_fila_row(query_db("select fecha_inicio_contrato,fecha_fin_contrato,convert(varchar(max), objeto),nombre_proveedor,periodo_evaluacion,nombre_gerente,numero_documento,id_documento,id_estado_criterio from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			 
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
			
		}
		//echo $jefe;
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
	
		
<div class="row">

<?
	
		//$col, $texto, $estilo_texto_contenido
		menu_banner('s12 m12 l12', '<center>Las etapas de evaluaci&oacuten contienen iconos de diferentes 
		colores de acuerdo al estado: Gris <i class = "material-icons" style="color: #BDBDBD; font-size:30px;">&#xE86C;</i>cuando no se ha iniciado la gesti&oacuten, 
		naranja <i class = "material-icons" style="color: #FFA000; font-size:30px;">&#xE86C;</i> cuando est&aacute 
		en estado de espera de aprobaci&oacuten, rojo <i class = "material-icons" style="color: #D32F2F; font-size:30px;">&#xE86C;</i>
		cuando sea devuelto y verde <i class = "material-icons" style="color: #4CAF50; font-size:30px;">&#xE86C;</i> cuando ya sea aprobado.</center>', 'font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;','color: #229BFF; tex-align:center;','white-grey');
		
		?>

</div>

<div class="row">
	
	<?  
		//$col, $icono_titulo, $titulo, $texto, $icono_footer, $estilo_icono_tilulo, $estilo_texto_titulo, $estilo_icono_footer, $estilo_texto_contenido, $clase_icono_titulo, $clase_icono_footer, $action){
	
		menu_lista('s12 m2 l3', '&#xE254;', '<center>Administraci&oacute;n <br> de Aspectos</center>', 'da click para ir administrar', '&#xE86C;', 
		"color: #229BFF; font-size:60px; margin-left:30%;", 'font-size: 22pt; font-weight: 900 !important; tex-align:center;', $stylo_icono1.'font-size:40px; margin-left:70%;', 'font-size: 12pt; font-weight: 900 !important; tex-align:center;', '', '',$link_definir);
		
		menu_lista('s12 m2 l3', '&#xE8CE;', '<center>Aprobaci&oacuten <br> de Aspectos</center>', 'estado de la aprobaci&oacuten', '&#xE86C;', 
		"color: #229BFF; font-size:60px; margin-left:30%;", 'font-size: 22pt; font-weight: 900 !important; tex-align:center;', $stylo_icono2.' font-size:40px; margin-left:70%;', 'font-size: 12pt; font-weight: 900 !important; tex-align:center;', '', '',$link_definir1);

		
		menu_lista('s12 m2 l3', '&#xE85D;', '<center>Evaluaci&oacuten <br> <span style="color:#ffffff;">&nbps;</span> </center>', 'da click para la evaluaci&oacuten', '&#xE86C;', 
		"color: #229BFF; font-size:60px; margin-left:30%;", 'font-size: 22pt; font-weight: 900 !important; tex-align:center;', $stylo_icono3.'font-size:40px; margin-left:70%;', 'font-size: 12pt; font-weight: 900 !important; tex-align:center;', '', '',$link_definir2);

		
		menu_lista('s12 m2 l3', '&#xE862;', '<center>Aprobaci&oacute;n <br> de Evaluaci&oacute;n</center>', 'estado de la aprobaci&oacuten', '&#xE86C;', 
		"color: #229BFF; font-size:60px; margin-left:30%;", 'font-size: 22pt; font-weight: 900 !important; tex-align:center;', $stylo_icono4.'font-size:40px; margin-left:70%;', 'font-size: 12pt; font-weight: 900 !important; tex-align:center;', '', '',$link_definir3);

	?>
		
</div>


