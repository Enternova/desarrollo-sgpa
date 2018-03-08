<?  include("../lib/@session.php");
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer

//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados
if($_POST["accion"] == "configura_evaluacion_criterios")
	{
		
		
		foreach($_POST["criterio_tecnico"] as $id_criterio => $id_categoria)
			{ // recorre las categorias

				echo $id_criterio."<br>";
				$id_categoria_no_borrar.=",".$id_categoria;
				$id_criterios_no_borrar.=",".$id_criterio;
				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/

					$busca_existe = traer_fila_row(query_db("select * from $t12 where  proc1_id = $id_proceso and rel9_id = $id_categoria"));
						if($busca_existe[0]>=1)
							 $inserta_cr="";
						else							
							 $inserta_cr="insert into $t12 (proc1_id, rel9_id, porcentaje,estado_configuracion) values ($id_proceso,$id_categoria,0,1 )";

					$exc=query_db($inserta_cr);
								

				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/
				
											
											$busca_existe = traer_fila_row(query_db("select * from $t91 where  in_id = $id_proceso and rel10_id = $id_criterio"));
											if($busca_existe[0]>=1)
											 $inserta_cr="";
											else							
											  $inserta_cr="insert into $t91 (in_id, rel10_id, evaluador1_valoresperado, termino) values ($id_proceso,$id_criterio,0, 2 )";
				
											$exc=query_db($inserta_cr);
											
											
											
											
						
			} // recorre las categorias
			
					 $borra="delete from $t12 where proc1_id = $id_proceso and rel9_id  not in (0 $id_categoria_no_borrar) ";
					$exc=query_db($borra);	

					$borra="delete from $t91 where in_id = $id_proceso and rel10_id  not in (0 $id_criterios_no_borrar) and termino = 2 ";
					$exc=query_db($borra);
					

					?>
                    	<script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La evaluación técnica se genero con exito', 20, 10, 18);
						//alert("n/La evaluación técnica se genero con exito")
						window.parent.ajax_carga('configuracion_criteriostecnicos_<?=$id_vari;?>_2.php','carga_evaluacion')
						</script>
                    
                    
                    <?

			
		
	
			$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
			$sql_e=traer_fila_row(mssql_query($busca_procesos));
			
			if($sql_e[31]==1){ // si ya esta notificado y se modifica
			
			$busca_correo = traer_fila_row(mssql_query("select * from $tp12 where tp12_id = 5"));
		 	$asunto = " Aviso de modificación ". listas_sin_select($tp2,$sql_e[2],1)." ".$sql_e[22];
			$mensaje=$texto_modifica;
			
		
			
			//$id_subastas_arrglo_usuario = str_replace("---mensaje_modifica---",$ms, $id_subastas_arrglo);

			  	$busca_provee = mssql_query("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores
					$mensaje_envio="";
					$id_subastas_arrglo_usuario="";
				
					$busca_contrasena="select * from $t1 where pv_id = $lp[0]";
					$busca_si_proveedor_cambia_cot= traer_fila_row(mssql_query($busca_contrasena));

							
					$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $mensaje );
					$id_subastas_arrglo_usuario = str_replace("---cambia_asunto---",$asunto, $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo_usuario);

					
					
					echo $mensaje_envio = $id_subastas_arrglo_usuario."<br>";
					registra_correos_enviados(10, $id_proceso,$lp[0],0, $lp[4], $asunto, $mensaje_envio);
					//envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);
					//alertas_bitacora(8,$id_proceso,$lp[0],"",0);
					//auditor(27,$id_proceso,"Se envio email", "");
					$graba_correo_pro.=$lp[4]."</br>";
						
						$busca_provee_contactos = mssql_query("select email  from $v41 where
						pro1_id = $id_proceso and pv_id = $lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						registra_correos_enviados(10, $id_proceso,$lp[0],0, $lp_contactos[0], $asunto, $mensaje_envio);
						//envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						echo $graba_correo_pro.=$lp_contactos[0]."</br>";
						
						}//contactos
						
						
						}// provvedores
	
			}// si ya esta notificado y se modifica
}
//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados	
?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>
