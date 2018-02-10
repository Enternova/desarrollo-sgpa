<? include("../../../librerias/lib/@session.php"); 
	//header('Content-Type: text/xml; charset=ISO-8859-1');
	
?>
<style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .tabla_lista_resultados{  margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
 .xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}

.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>

<table width="5000" border="1">
<tr >
  <td colspan="2" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="5" align="left" class="titulo1"><strong>REPORTE CONGELADOS</strong></td>
</tr>
<tr >
  <td colspan="5" align="left" ><?=$tipo_contrato_bu?></td>
</tr>
<tr >
  <td colspan="5" align="center" >&nbsp;</td>
  </tr>
<tr >
	<td align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Fecha en que se Congel&oacute;</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Funcionario</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Observaci&oacute;n</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Objeto de la Solicitud</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Area</td>
	<td align="center" class="columna_subtitulo_resultados_oscuro">Tipo de Proceso</td>
</tr>
<?
	//$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	$permisos = $permisos.$query_comple ;
	$permisos = str_replace("especialista","especialista_id",$permisos);
	$permisos = str_replace("gerente","gerente_id",$permisos);
	$permisos = str_replace("contratista","contratista_id",$permisos);
	//error_reporting(-1);
	$busca_reportes = "SELECT a.id, a.id_item, MAX(d.id), a.creacion_sistema, a.consecutivo, a.apellido, a.objeto, d.fecha, e.t1_area_id, t1_tipo_proceso_id
					   from  t7_contratos_contrato a, 
					         t7_contratos_contrato_congelado d, 
							 t2_item_pecc e
					   where a.id = d.id_contrato 
					     AND analista_deloitte = 1
						 AND e.id_item = a.id_item
						 AND a.id not in (751, 1021)
					   group by a.id, a.id_item, a.creacion_sistema, a.consecutivo, a.apellido, a.objeto, d.fecha, e.t1_area_id, t1_tipo_proceso_id ";
					   
	$sql_re = query_db($busca_reportes);
	
	while($ls_re=traer_fila_row($sql_re)){
	
		$separa_fecha_crea = explode("-",$ls_re[3]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);	
		
		$busca_congelado = "SELECT congelado, fecha FROM t7_contratos_contrato_congelado WHERE id = " . $ls_re[2];
		
		$sql_re1 = query_db($busca_congelado);
		$ls_re1=traer_fila_row($sql_re1);
		
		$busca_log = "SELECT TOP(1) a.id_log, a.id_us, b.nombre_administrador
						FROM tseg8_log a, t1_us_usuarios b 
					   WHERE id_proceso = ".$ls_re[0]." 
					     AND fecha = '" . $ls_re1[1] . "' 
						 AND b.us_id = a.id_us
					ORDER BY id_log DESC";
		
		$sql_re2 = query_db($busca_log);
		
		if($ls_re2=traer_fila_row($sql_re2)){
		
			$nombre = $ls_re2[2];
			
		
		}else{
		
			
			$busca_reportes_contrato_en_sol = "SELECT b.observacion, b.usuario_admin, b.fecha, a.objeto_solicitud, a.t1_area_id, a.t1_tipo_proceso_id, a.num1, a.num2, a.num3 , a.estado
						 FROM t2_item_pecc a,
							  t2_acciones_admin b
						WHERE a.id_item = b.id_item 
						  AND accion = 'Congelado'
						  and a.id_item = ".$ls_re[1];
		
	$sql_re_congelado_en_solicitud = traer_fila_row(query_db($busca_reportes_contrato_en_sol));
	
				$nombre = "";
				$ob_congela_contrato_des_sol = "";
				$fecha_congela_contrato_des_sol = "";
				
	if($sql_re_congelado_en_solicitud[9]>0){
			if(($sql_re_congelado_en_solicitud[9] >= 20 and $sql_re_congelado_en_solicitud[9] <> 31) and ($sql_re_congelado_en_solicitud[1] =="" or $sql_re_congelado_en_solicitud[1] ==" "))	{
			$nombre  = "LEGAL ELABORACION DE DOCUMENTO CONTRACTUAL";
			}else{
				$nombre = $sql_re_congelado_en_solicitud[1];
			}
				$ob_congela_contrato_des_sol = $sql_re_congelado_en_solicitud[0];
				$fecha_congela_contrato_des_sol = $sql_re_congelado_en_solicitud[2];
		}else{
	
			$nombre = "----" ;
		}
		
		
		
		}
		
		?>
		<tr>

		  <td align="left"><?= numero_item_pecc_contrato("C",$numero_contrato2,$ls_re[4],$ls_re[5]);?></td>
		  <td align="left"><?=$ls_re1[1]?></td>
		  <td align="left"><?=$nombre?></td>
		<?          
           $busca_obs_congelado = "SELECT a.detalle FROM tseg9_log_detalle a, tseg8_log b 
		  						   WHERE a.id_log = b.id_log 
								     AND b.id_tipo_log = 24 
									 AND id_proceso = '" . $ls_re[0] . "'
									 AND campo_imprime LIKE 'Observaciones Congelado'";
    	  $sql_congelado=traer_fila_row(query_db($busca_obs_congelado));  
        ?>  
		  <td align="left"><? if($ob_congela_contrato_des_sol!="") { echo $ob_congela_contrato_des_sol;} else { echo $sql_congelado[0];}?></td>
		  <td align="left"><?=$ls_re[6]?></td>
		<?          
		$busca_maestra = "select t1_area_id,nombre from $g12 where t1_area_id = $ls_re[8]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));          
        ?>
		  <td align="left"><?=$sql_maestra[1]?></td>
          
          
          
		  <td align="left">
          <?= saca_nombre_lista($g13,$ls_re[9],'nombre','t1_tipo_proceso_id');	?>
          </td>
			
		</tr>
		<?
				
	}
	
	$busca_reportes = "SELECT b.observacion, b.usuario_admin, b.fecha, a.objeto_solicitud, a.t1_area_id, a.t1_tipo_proceso_id, a.num1, a.num2, a.num3 , a.estado 
						 FROM t2_item_pecc a,
							  t2_acciones_admin b
						WHERE a.id_item = b.id_item 
						  AND accion = 'Congelado'
						  AND a.estado not in (32,33,21,31)
						  AND congelado = 1";
		
	$sql_re = query_db($busca_reportes);
	
	while($ls_re=traer_fila_row($sql_re)){
	$mostrar = "SI";
	$gestion_muetr_fecha = "";
	$gestion_muetr_funcionario ="";
	$gestion_muetr_observaccion = ""; 
	
	
if($ls_re[9] == 20 and ($ls_re[1] =="" or $ls_re[1] ==" "))	{
	$ls_re[1] = "LEGAL ELABORACION DE DOCUMENTO CONTRACTUAL";
	}

	?>
	
	<tr>
		<td><?=numero_item_pecc($ls_re[6],$ls_re[7],$ls_re[8])?></td>
		<td><?=$ls_re[2]?></td>

		<td><?=$ls_re[1]?></td>
		<td><?=$ls_re[0]?></td>
		<td><?=$ls_re[3]?></td>
		
		<?
		$busca_maestra = "select t1_area_id,nombre from $g12 where t1_area_id = $ls_re[4]";
		$sql_maestra=traer_fila_row(query_db($busca_maestra));          
        ?>
		<td align="left"><?=$sql_maestra[1]?></td>		
		<td align="left">
          <?=saca_nombre_lista($g13,$ls_re[5],'nombre','t1_tipo_proceso_id');	?>
        </td>		
	</tr>
	
	<?

	
	}						  
					  
?>
</table>
<?

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte de Congelados.xls"); 

?>