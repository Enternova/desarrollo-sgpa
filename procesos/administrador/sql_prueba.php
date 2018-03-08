<? include("../../librerias/lib/@session.php"); 
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER


//crea_otro_si(10385);//si se pega el OTRO SI # id de la solicitud
//crea_ots(1621); // si se pega la OT	# Crea Ordenes de trabajo

//crear_en_e_procurement(2);

//echo $_SESSION["id_us_session"];
//envio_correo_ot(1974);

//envio_correo_ot(1881,96);		

		
/*adjudicacion de solicitud si se pega*/
 

$id_item_pecc = "10502";
$sel2 = query_db("select aprobado, num3,id_item from $pi2 where id_item in (".$id_item_pecc.")");
while($sel = traer_fila_db($sel2)){
	if($id_item_pecc != "" and $sel[0] == 2){
		crea_contratos_si_no_funciona($sel[2]);//contratos normales
		//crea_contratos_marco($sel[2]);//contratos marco
		echo "Ya creo los contratos sol N°. ".$sel[1]."<br />";
	}else{
		echo " No Creo Nada";
		}
}

// FIN adjudicacion de solicitud si se pega*/





/*ACTUALIZACION DE ANTECEDENTES NIVELES DE APROBACION*/
/*
$sel_solicitudes = query_db("select id_item, num3 from t2_item_pecc where estado > 19 and estado <= 32 and estado <> 31 and de_historico  is null or de_historico = 'si-ad'");
while($sel_soli = traer_fila_db($sel_solicitudes)){
$aprobacion_nivel =  nivel_aprobacion_solicitud($sel_soli[0], "adjudicacion");

//echo $sel_soli[1]." - ".$aprobacion_nivel."<br />";
$insert_atecedente = query_db("insert into $pi9 (tipo, estado, t2_item_pecc_id, detalle, id_us, adjunto) values ('antecedente', 1, ".$sel_soli[0].", 'Aprobaci&oacute;n de la Adjudicaci&oacute;n por ".$aprobacion_nivel."', 32, '')");
}
*/
/*ACTUALIZACION DE ANTECEDENTES NIVELES DE APROBACION*/	
	

/*


 $busca_procesos = "select * from $g1 where tipo_usuario != 2";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){
		$seleecion_area = traer_fila_row(query_db(" select t2.t1_area_id from tseg3_usuario_areas as t1, t1_area as t2 where t2.estado = 1 and id_usuario =".$ls[0]." and t1.id_area = t2.t1_area_id"));
		if($seleecion_area[0]>0){
			
			$sel_profss = traer_fila_row(query_db("select us_id from $v_seg1 where id_premiso = 8 and id_area = ".$seleecion_area[0]."  group by us_id"));
			if($sel_profss[0]>0){
				$insert = query_db("insert into t2_relacion_usuarios_profesionales (id_usuario, id_profesional) values (".$ls[0].",".$sel_profss[0].")");
			}
			}
		
	}
			
*/		



?>
