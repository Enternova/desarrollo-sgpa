<? include("../lib/@session.php");
    verifica_menu("procesos.html");

$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
$us_cliente = $_SESSION["id_proveedor"];

if($_POST["accion"] == "c_invitacion_economica")
	{

	$busca_procesos = "select cierre_economica from $t5 where pro1_id = $id_invitacion_ar";
	$sql_e=traer_fila_row(query_db($busca_procesos));	

	if($sql_e[0]>=$fecha." ".$hora){//si esta dentro del tiempo
	auditor(18,$id_invitacion_ar,"", "");
		foreach($campo_pro as $id_general => $valor)
			{//for 1
			$separa_llaves = explode("-",$id_general);
				
				$modifica_busca = traer_fila_row(query_db("select * from $tabla_economica 
							where pv_id = $us_cliente and evaluador5_id  = $separa_llaves[0] and evaluador4_id = $separa_llaves[1] and oferta = $oferta "));
							
				if($modifica_busca[0]>=1)	
						{//si no ingreso el registro nuevo
							 $modifica = "update $tabla_economica set w_valor = '$valor',w_fecha_modifica='$fecha $hora' 
							where w_id = $modifica_busca[0] ";
							$exq=query_db($modifica);
							//$error_modifica+= mysql_affected_rows();
						}//si no ingreso el registro nuevo	
				else{			
				
				if($valor!=""){//si el campo no es vacio
				$ins_sql = "insert into $tabla_economica (evaluador5_id, evaluador4_id, pv_id, w_valor, w_fecha_creacion, w_fecha_modifica,oferta) values (
				$separa_llaves[0],$separa_llaves[1],$us_cliente,'$valor','$fecha $hora','',$oferta)";
				$exq=query_db($ins_sql);
				$id_cargue=mysql_errno();
								}//si el campo no es vacio
				
				}
				
				if($valor!=""){//si el campo no es vacio
				$ins_sql_hist = "insert into evaluador_economica_proveedor_historico (evaluador5_id, evaluador4_id, pv_id, w_valor, w_fecha_creacion, w_fecha_modifica,oferta) values (
				$separa_llaves[0],$separa_llaves[1],$us_cliente,'$valor','$fecha $hora','',$oferta)";
				$exq=query_db($ins_sql_hist);
								}//si el campo no es vacio

			}//for 2
			
			function valida_valor_cero($valor_pasa)
				{
					if($valor_pasa=="")
						return 0;
					else
						return $valor_pasa;
				
				}
			
			if($_POST["pa_requiere_aui"]==1)
				{
					$busca_si_aui=traer_fila_row(query_db("select * from $t24 where pro1_id=$id_invitacion_ar and  pro11_id=$id_lista and  pv_id=$us_cliente"));
					if($busca_si_aui[0]>=1)
					$inserta_aiu="update $t24 set administracion=".valida_valor_cero($administracion).", imprevisto=".valida_valor_cero($imprevisto).", utilidad=".valida_valor_cero($utilidad)." where pro1_id=$id_invitacion_ar and  pro11_id=$id_lista and  pv_id=$us_cliente";
					else					
					$inserta_aiu="insert into $t24 (pro1_id, pro11_id, pv_id, administracion, imprevisto, utilidad, iva) values (
					$id_invitacion_ar, $id_lista, $us_cliente,".valida_valor_cero($administracion).",".valida_valor_cero($imprevisto).",".valida_valor_cero($utilidad).",16)";
					
					$inserta_aui=query_db($inserta_aiu);
					
				
				}
			
			?>
            <script>
			window.parent.muestra_alerta_iformativa_solo_texto( '','La oferta se envió con éxito', 20, 10, 18)
			  //alert("La oferta se envió con éxito.")
	          window.parent.ajax_carga('../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=<?=$oferta;?>&pag=<?=$pag;?>&id_lista=<?=$id_lista;?>','contenidos' )
		    </script>
            
            <?
		} // si esta dentro del tiempo
		
		else{
		auditor(19,$id_invitacion_ar,"", "");
			?>
            <script>
			muestra_alerta_error_solo_texto('', 'Error', 'El tiempo para enviar la oferta económica expiró. *Esta oferta economica no se grabo', 20, 10, 18)
			  //alert("ATENCIÓN:\n El tiempo para enviar la oferta económica expiró.\nEsta oferta economica no se grabo")
	          window.parent.ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos' )
		    </script>
            
            <?
		
		
		}
	}
?>