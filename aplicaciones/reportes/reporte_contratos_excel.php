<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte de Legalizacion.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
	include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
   include("../../librerias/php/funciones_general_2015.php");
	
	$query_comple = "";

	
	
	if($contratista_bu!=""){
		$explode = explode("----,",elimina_comillas_2($contratista_bu));
		$id_contratista = $explode[1];
		$query_comple = $query_comple." and contratista = ".$id_contratista;
	}
	
	if($especialista_bu!="0"){
		//$explode = explode("----,",elimina_comillas_2($especialista_bu));
		$id_especialista = $especialista_bu;
		$query_comple = $query_comple." and profesional_asignado_contrato = ".$id_especialista;
	}
	
	if($objeto_bu!=""){
		$query_comple = $query_comple." and objeto like '%".$objeto_bu."%'";
	}
	
	if($visualiza_con==1){
		$query_comple = $query_comple." and (gerente in (".$_SESSION["id_us_session"]. "$array_usuario) or especialista in (".$_SESSION["id_us_session"]."$array_usuario)) ";
	}
	
	if($tipo_contrato_bu!="0"){
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
	}
	
	
	

	if($vigencia_bu!="0"){
		$fecha_hoy = getdate();
		if($vigencia_bu==1){
			$query_comple = $query_comple." and vc.vigencia_mes >='".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
		if($vigencia_bu==2){
			$query_comple = $query_comple." and vc.vigencia_mes <'".$fecha_hoy["year"]."-".$fecha_hoy["mon"]."-".$fecha_hoy["mday"]."'";
		}
	}
	
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and (id_gerente_contrato = ".$id_gerente." or id_gerente_modificacion=".$id_gerente.")";
	}
	
	

//echo "<br /> Estado Busca: ".$estado_bu."<br />";
	if($estado_bu!="0" and $estado_bu!=""){
		
				$query_comple = $query_comple." and (estado_id_contrato = ".$estado_bu." or estado_id_modificacion = ".$estado_bu.")";	
			
	}
	
	if($gestor_abste!="0" and $gestor_abste!=""){
		
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_contratos_gestiona = query_db("select usuario_gerente from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$gestor_abste);
$aplica_gerentes = "0";
while($aplica_gere = traer_fila_db($sel_contratos_gestiona)){
	$aplica_gerentes.=",".$aplica_gere[0];
	}
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$query_comple.= " and (id_gerente_contrato in (".$aplica_gerentes.") or id_gerente_modificacion in (".$aplica_gerentes."))";
	}
	
	$query_comple_temp="";

	
	
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
</style>
<style>
.titulo1 {
	font-size:12px;
	background-color:#4DBF40;
	color:#FFF;
		
}
.titulo3 {
	font-size:12px;
	background-color:#135798;
	color:#FFF;
		
}
.fila_resulta {
	font-size:12px;
		
}
</style>
<table width="5000" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="149" align="center" class="titulo3">Solicitud    de Aprobaci&oacute;n del Contrato</td>
    <td width="159" align="center" class="titulo3">Tipo de    Negociaci&oacute;n</td>
    <td width="141" align="center" class="titulo3">Tipo Contrato</td>
    <td width="145" align="center" class="titulo3">N&uacute;mero de Contrato</td>
    <td width="336" align="center" class="titulo3">Proveedor</td>
    <td width="91" align="center" class="titulo3">Fecha Inicio del    Contrato</td>
    <td width="91" align="center" class="titulo3">Fecha Fin del    Contrato</td>
    <td width="317" align="center" class="titulo3">Objeto del    Contrato</td>
    <td width="87" align="center" class="titulo3">Gerente del    Contrato</td>
    <td width="143" align="center" class="titulo3">&Aacute;rea Usuaria del    Gerente</td>
    <td width="105" align="center" class="titulo3">Profesional    C&amp;C</td>
    <td width="111" align="center" class="titulo3">Gestor    Abastecimiento</td>
    <td width="81" align="center" class="titulo3">Contrato    Congelado</td>
    <td width="153" align="center" class="titulo3">Observaci&oacute;n del contrato Congelado</td>
    <td width="58" align="center" class="titulo3">Informe HSE</td>
    <td width="147" align="center" class="titulo3">Aseguramiento    Administrativo</td>
    <td width="133" align="center" class="titulo3">Garant&iacute;as y    Seguros</td>
    <td width="115" align="center" class="titulo3">Aplica Clausula    6 de Retenci&oacute;n de Garant&iacute;a</td>
    <td width="118" align="center" class="titulo3">Porcentaje de    la Retenci&oacute;n de Garant&iacute;a</td>
    <td width="132" align="center" class="titulo3">En que Momento    Aplica la Retenci&oacute;n de Garant&iacute;a</td>
    <td width="128" align="center" class="titulo3">Estado del    Contrato</td>
    <td width="167" align="center" class="titulo3">Ultima Gesti&oacute;n</td>
    <td width="224" align="center" class="titulo3">Observaci&oacute;n Ultima Gesti&oacute;n</td>
    <td width="117" align="center" class="titulo1">Solicitud SGPA</td>
    <td width="104" align="center" class="titulo1">Tipo de Evento   </td>
    <td width="100" align="center" class="titulo1">Tipo de Otros&iacute;</td>
    <td width="77" align="center" class="titulo1">N&uacute;mero</td>
    <td width="174" align="center" class="titulo1">Gerente</td>
    <td width="315" align="center" class="titulo1">&Aacute;rea Usuaria del    Gerente</td>
    <td width="140" align="center" class="titulo1">Gestor de Abastecimiento</td>
    <td width="119" align="center" class="titulo1">Congelado</td>
    <td width="132" align="center" class="titulo1">Observaci&oacute;n  Congelado</td>
    <td width="90" align="center" class="titulo1">Estado del Proceso</td>
    <td width="90" align="center" class="titulo1">Ultima Gesti&oacute;n</td>
    <td width="139" align="center" class="titulo1">Observaci&oacute;n Ultima Gesti&oacute;n</td>
  </tr>
  
  <?
   $sql_sel_rep = " select id_contrato, num1, num2, num3, tipo_proceso, tipo_contrato, consecutivo, creacion_sistema, apellido, razon_social, fecha_inicio, vigencia_mes, objeto, 
                         gerente_contrato, profesional_abastecimiento, congelado_contrato, obs_congelado_contrato, informe_hse, aseguramiento_admin, seguro_garantia, aplica_garantia, 
                         porcentaje, en_que_momento, estado_id_contrato, estado_contrato, num1_mod, num2_mod, num3_mod, tipo_modificacion, tipo_otrosi, numero_otrosi, 
                         gerente_modificacion, congelado_modificacion, obs_congelado_modificacion, estado_id_modificacion, estado_modificacion_35, id_modificacion, id_gerente_contrato, id_gerente_modificacion, tipo_complemento from v_contratos_reporte where  (congelado_contrato is null or congelado_contrato = 0) and (congelado_modificacion is null or congelado_modificacion = 0)  and ((eliminado =0 and id_modificacion is not null) or (eliminado is null and id_modificacion  is null))".$query_comple;
						 
						
//echo $sql_sel_rep;


  $sql_query_sel_rep=query_db($sql_sel_rep);
  while($sel_rep = traer_fila_db($sql_query_sel_rep)){
  ?>
  <tr class="fila_resulta">
    <td align="center"><?=numero_item_pecc($sel_rep[1],$sel_rep[2],$sel_rep[3])?></td>
    <td align="center"><?=$sel_rep[4]?></td>
    <td align="center"><?=$sel_rep[5]?></td>
    <td align="center"><?
     				$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_rep[7]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_rep[6];
					$numero_contrato4 = $sel_rep[8];
					
					$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_rep[0]);
					echo $num_impri;
					
	?></td>
    <td align="center"><?=$sel_rep[9]?></td>
    <td align="center"><?=$sel_rep[10]?></td>
    <td align="center"><?=$sel_rep[11]?></td>
    <td align="center"><?=$sel_rep[12]?></td>
    <td align="center"><?=$sel_rep[13]?></td>
    <td align="center"><?
	
    		$sel_areas = query_db("select t1.id_area, t2.nombre from tseg3_usuario_areas t1, t1_area t2 where t1.id_usuario = ".$sel_rep[37]." and t1.id_area = t2.t1_area_id and t2.estado=1");
			$sel_quien_es_gestor = traer_fila_row(query_db("select nombre_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_rep[37]));
			$coma = "";
			$sel_areas_id="";
			$sel_areas_nombre="";
			while($sel_a = traer_fila_db($sel_areas)){
				
				$sel_areas_id.= $coma.$sel_a[0];
				$sel_areas_nombre.= $coma.$sel_a[1];
				
				
				if($coma == ""){$coma=",";}
				}
				echo $sel_areas_nombre;
	?></td>
    <td align="center"><?=$sel_rep[14]?></td>
    <td align="center"><?=$sel_quien_es_gestor[0]?></td>
    <td align="center"><? if($sel_rep[15]==1) echo "SI"; else echo"NO";?></td>
    <td align="center"><?=$sel_rep[16]?></td>
    <td align="center"><? if($sel_rep[17] != "" and $sel_rep[17] != "0") echo $sel_rep[17];?></td>
    <td align="center"><?=$sel_rep[18]?></td>
    <td align="center"><?=$sel_rep[19]?></td>
    <td align="center"><? if($sel_rep[20]==1) echo "SI"; else echo "NO";?></td>
    <td align="center"><? if($sel_rep[21]>0) echo $sel_rep[21]."%";?></td>
    <td align="center"><? if($sel_rep[22]==1) echo "PARCIAL"; if($sel_rep[22]==2) echo "AL LIQUIDAR EL CONTRATO";?></td>
    <td align="center"><?=$sel_rep[24]?></td>
    <td align="center"><?
    $sel_ultima_gestion = traer_fila_row(query_db("select t2.nombre, t1.ob from  t7_relacion_campos_legalizacion_gestiones as t1, t7_relacion_campos_legalizacion as t2 where  t1.id_t7_relacion_campos_legalizacion = t2.id and t1.id_contrato=".$sel_rep[0]." and estado = 1"));
	echo $sel_ultima_gestion[0];
	?></td>
    <td align="center"><?=$sel_ultima_gestion[1]?></td>
    <td align="center"><? if($sel_rep[34] > 0) { echo numero_item_pecc($sel_rep[25],$sel_rep[26],$sel_rep[27]); }?></td>
    <td align="center"><?=$sel_rep[28]?></td>
    <td align="center"><?=$sel_rep[29]?></td>
    <td align="center"><?=$sel_rep[30]?></td>
    <td align="center"><?=$sel_rep[31]?></td>
    <td align="center"><? if($sel_rep[34] > 0) {//si es modificacion

			$sel_quien_es_gestor[0]="";
			$coma = "";
			$sel_areas_id="";
			$sel_areas_nombre="";
    		$sel_areas = query_db("select t1.id_area, t2.nombre from tseg3_usuario_areas t1, t1_area t2 where t1.id_usuario = ".$sel_rep[38]." and t1.id_area = t2.t1_area_id and t2.estado=1");
			$sel_quien_es_gestor = traer_fila_row(query_db("select nombre_gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_rep[38]));
			
			while($sel_a = traer_fila_db($sel_areas)){
				
				$sel_areas_id.= $coma.$sel_a[0];
				$sel_areas_nombre.= $coma.$sel_a[1];
				
				
				if($coma == ""){$coma=",";}
				}
				echo $sel_areas_nombre;

		
		
		}?></td>
    <td align="center"><? if($sel_rep[34] > 0) { echo  $sel_quien_es_gestor[0]; }?></td>
    <td align="center"><? if($sel_rep[34] > 0) {if($sel_rep[32]==1) echo "SI"; else echo"NO"; }?></td>
    <td align="center"><?=$sel_rep[33]?></td>
    <td align="center"><?=$sel_rep[35]?></td>
    <td align="center"><?
    $sel_ultima_gestion_mod = traer_fila_row(query_db("select t2.nombre,t2.nombre_en_suspencion, t2.nombre_en_reinicio, t1.ob from  t7_relacion_campos_legalizacion_gestiones as t1, t7_relacion_campos_legalizacion as t2 where  t1.id_t7_relacion_campos_legalizacion = t2.id and t1.id_modificacion=".$sel_rep[36]." and estado = 1"));
	if($sel_rep[39]==4){//reinicio
		echo $sel_ultima_gestion_mod[2];
	}elseif($sel_rep[39]==3){//suspencion
		echo $sel_ultima_gestion_mod[1];
		}else{//otrosi OT
			echo $sel_ultima_gestion_mod[0];
			}
	?></td>
    <td align="center"><?=$sel_ultima_gestion_mod[3]?></td>
  </tr>
  <?
  }
  ?>
</table>
<?
?>
