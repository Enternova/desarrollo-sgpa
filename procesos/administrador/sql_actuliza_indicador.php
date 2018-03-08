<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER


/* Este es para actualizar todos los procesos desde el 2103 
$delete_aprobaciones = query_db("truncate table t2_nivel_aprobacion_relacion");
$sql = "select id_item, num3 from t2_item_pecc where (estado <> 31 and estado <> 33) and estado >= 7 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and t1_tipo_proceso_id > 0 and id_us_profesional_asignado > 0";
/**/

/* Este es para actualizar los procesos desde el 2016
$desde_cuando = 5906;//primer id item del 2016
$delete_aprobaciones = query_db("delete from t2_nivel_aprobacion_relacion where id_item >=".$desde_cuando);
$sql = "select id_item, num3 from t2_item_pecc where id_item >=".$desde_cuando." and (estado <> 31 and estado <> 33) and estado >= 7 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2) and t1_tipo_proceso_id > 0 and id_us_profesional_asignado > 0";



$sel_solicitudes = query_db($sql);
$conte=1;
while($sel_soli = traer_fila_db($sel_solicitudes)){

$nivel_perm = "";
$usuario_perm = "";
$fecha_perm = "";
$nivel_ad = "";
$usuario_ad = "";
$fecha_ad = "";
	
$aprobacion_nivel =  nivel_aprobacion_sol($sel_soli[0], "");

$explo_aprobacion = explode("*",$aprobacion_nivel);

$nivel_perm = $explo_aprobacion[0];
$usuario_perm = $explo_aprobacion[1];
$fecha_perm = $explo_aprobacion[2];

$nivel_ad = $explo_aprobacion[3];
$usuario_ad = $explo_aprobacion[4];
$fecha_ad = $explo_aprobacion[5];

echo $conte." : ".$sel_soli[1]." - PERMISO nivel: $nivel_perm, usuario: $usuario_perm, fecha: $fecha_perm ADJUDICACION nivel: $nivel_ad, usuario: $usuario_ad, fecha: $fecha_ad";

if($nivel_perm <> "" or $usuario_perm<>"" or $fecha_perm<>""){
	echo " ********crea Permiso";	
$conte=$conte+1;
	$insert_atecedente = query_db("insert into t2_nivel_aprobacion_relacion (id_item, id_nivel_aprobacion_permiso, fecha_aprobacion_permiso, id_usuario_aprueba_permiso) values (".$sel_soli[0].",'$nivel_perm','$fecha_perm','$usuario_perm')");

	}
if($nivel_ad <> "" or $usuario_ad<>"" or $fecha_ad<>""){
	echo "********crea Adjudicacion";
	$conte=$conte+1;
	$insert_atecedente = query_db("insert into t2_nivel_aprobacion_relacion (id_item, id_nivel_aprobacion_adjudicacion, fecha_aprobacion_adjudicacion, id_usuario_aprueba_adjudicacion) values (".$sel_soli[0].",'$nivel_ad','$fecha_ad','$usuario_ad')");	
	}
	

echo "<br />";
}


	

function nivel_aprobacion_sol($id_item_pecc, $ad_permiso){
	global $g1;
	$sel_repor = query_db("select * from reporte_general_1 where id_item = $id_item_pecc $comple_sql");
  while($sel_r = traer_fila_db($sel_repor)){

		$tipo_proceso_while=$sel_r[22];
		$id_item_while = $sel_r[0];
		$estado_item_while = $sel_r[20];
		
		
	
		
		$nivel_aprueba_ad = "";
		$usuario_aprueba_ad="";
		$fecha_aprueba_ad="";
		
		$nivel_aprueba_perm="";
		$usuario_aprueba_perm="";
		$fecha_aprueba_perm="";
		
		if($estado_item_while > 18 and $estado_item_while <> 31){// aprobacion adjudicacion
		
		
		
		
		if($nivel_aprueba_ad == ""){			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_ad = 4;
			$usuario_aprueba_ad=$cadena = substr($sel_aprobacion_permiso_comite[0],35,43);
			$fecha_aprueba_ad = $sel_aprobacion_permiso_comite[1];		
			}
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_presidente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_presidente[0]>0){
			$nivel_aprueba_ad = 8;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_presidente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_presidente[1];	
			}			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = 6;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_ad = 3;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_ad = 2;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_jefe_area[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 45"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = 7;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		if($nivel_aprueba_ad == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =2 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 35"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_ad = 7;
			$usuario_aprueba_ad=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_ad = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
	}//FIN APROBACION DE adjudicacion
	
	if($estado_item_while > 7 and $estado_item_while <> 31 and ($tipo_proceso_while == 1 or $tipo_proceso_while == 2 or $tipo_proceso_while == 3)){// aprobacion permiso
		
		if($nivel_aprueba_perm == ""){
			
		$sel_aprobacion_permiso_comite = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.observacion, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 10"));  
			if($sel_aprobacion_permiso_comite[0]!= ""){
			$nivel_aprueba_perm = 4;
			$usuario_aprueba_perm=$cadena = substr($sel_aprobacion_permiso_comite[0],35,43);
			$fecha_aprueba_perm = $sel_aprobacion_permiso_comite[1];		
			}
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 48"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 8;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 43"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 6;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_vicepre = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 20"));  
			if($sel_aprobacion_permiso_vicepre[0]>0){
			$nivel_aprueba_perm = 3;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_vicepre[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_vicepre[1];	
			}
			
		}
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_jefe_area = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 9"));  
			if($sel_aprobacion_permiso_jefe_area[0]>0){
			$nivel_aprueba_perm = 2;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_jefe_area[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_jefe_area[1];	
			}
			
		}
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 45"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_perm = 1;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
		if($nivel_aprueba_perm == ""){
			$sel_aprobacion_permiso_superintendente = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.id_us, t2_agl_secuencia_solicitud_aprobacion.fecha  from t2_agl_secuencia_solicitud,t2_agl_secuencia_solicitud_aprobacion where id_item_pecc = $id_item_while and estado = 1 and tipo_adj_permiso =1 and por_sistema = 2 and  t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud.id_rol = 35"));  
			if($sel_aprobacion_permiso_superintendente[0]>0){
			$nivel_aprueba_perm = 1;
			$usuario_aprueba_perm=$sel_aprobacion_permiso_superintendente[0];	
			$fecha_aprueba_perm = $sel_aprobacion_permiso_superintendente[1];	
			}
			
		}
		
	}//FIN APROBACION DE permiso
	
  }//fin while
  

  
  	$aprobaciones_adjudicacion = $nivel_aprueba_ad."*".$usuario_aprueba_ad."*".$fecha_aprueba_ad;
	$aprobaciones_permiso = $nivel_aprueba_perm."*".$usuario_aprueba_perm."*".$fecha_aprueba_perm;

		return $aprobaciones_permiso."*".$aprobaciones_adjudicacion;	
	  
	}


$sele_items_historico = query_db("select id_item,  fecha_creacion, num3, num2 from t2_item_pecc where de_historico <> ''");

while( $sel_hito = traer_fila_row($sele_items_historico)){
	
	$sel_si_tiene_creacio = traer_fila_row(query_db("select * from t2_nivel_servicio_gestiones where id_item = ".$sel_hito[0]." and estado =1"));
	
	if($sel_si_tiene_creacio[0]<=0){
		
		$separa_fecha = explode(" ",$sel_hito[1]);
		//echo $sel_hito[3]."-".$sel_hito[2]." - poner gestion de creacion historico, fecha ".$separa_fecha[0].", hora ".$separa_fecha[1]."<br />";
		
		$insert_gestion = query_db("insert into t2_nivel_servicio_gestiones (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado, observacion, hora) values (".$sel_hito[0].",1,32,'".$separa_fecha[0]."',0,1,'','".$separa_fecha[1]."')");
		
		}
	
	}
	

$sele_items_historico = query_db("select id_item,  fecha_creacion, num3, num2 from t2_item_pecc where de_historico <> ''");

while( $sel_hito = traer_fila_row($sele_items_historico)){
	$separa_fecha = explode(" ",$sel_hito[1]);
	
	$delete = query_db(" delete from tseg8_log where  id_proceso = ".$sel_hito[0]." and id_tipo_log in (3, 2)");
	$insert = query_db("insert into tseg8_log ( id_tipo_log, id_tipo_log_sub_ventana, id_proceso, estado_actual_proceso, estado_resultado, id_us, fecha, hora_seg) values (2,0,".$sel_hito[0].",0,0,32,'".$separa_fecha[0]."','".$separa_fecha[1]."')");
}

?>

<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>
<? */ ?>