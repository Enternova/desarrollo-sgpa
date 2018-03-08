<?  include("../lib/@session.php");

date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer


function diaSemana($fecha)
{
if($fecha!=""){//si trae algo
	$separa_espacio = explode(" ",$fecha);
	
	$arreg_fe = explode("-",$separa_espacio[0]);
	$ano=$arreg_fe[0];
	$mes=$arreg_fe[1];
	$dia=$arreg_fe[2];
	
	echo $festivo = $mes."-".$dia;
	
        $dia=date("w",mktime(0,0,0, $mes, $dia, $ano));

	if (($dia==6) || ($dia==0) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas no pueden ser sabados o domingos', 20, 10, 18);
					//alert("* Las fechas no pueden ser sabados o domingos");
					 //window.parent.document.getElementById("cargando").style.display="none"
				</script>
            <?
			exit();
			}
	else
		{// si no fin de semana
		 	$error_festivo=0;

				if($festivo=="01-01")
					$error_festivo=1;
				elseif($festivo=="05-01")
					$error_festivo=1;
				elseif($festivo=="07-20")
					$error_festivo=1;
				elseif($festivo=="08-07")
					$error_festivo=1;
				elseif($festivo=="12-08")
					$error_festivo=1;
				elseif($festivo=="12-25")
					$error_festivo=1;
			
			if($error_festivo==1)
				{// si selecciono festivo
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas no pueden ser festivos', 20, 10, 18);
					//alert("* Las fechas no pueden ser festivos");
					//window.parent.document.getElementById("cargando").style.display="none"
				</script>
            <?
			exit();
					
					}// si selecciono festivo
			
			}// si no fin de semana
            
}//si trae algo
			
}



if($_POST["accion"]=="crea_proceso")
	{
	
	if($a==30)
		{
			$conseutivo_arr=consecutivo_automatico_sondeo();
			?>
			<script>
			
				window.parent.document.principal.consecutivo.value='<?=$conseutivo_arr?>';
			</script>
			<? 
				
			}
	elseif($a==31)
		{
			$conseutivo_arr=consecutivo_automatico_compra_crudo();
			?>
			<script>
			
				window.parent.document.principal.consecutivo.value='<?=$conseutivo_arr?>';
			</script>
			<? 
				
			}

		else{
				$conseutivo_arr=$consecutivo;
			}
		
		 $busca_conse_sin_espacio = "select pro1_id from $t5  where REPLACE(consecutivo,' ','') =  REPLACE('".$conseutivo_arr."',' ','') ";

		
		$ejucuta_b_espac = traer_fila_row(query_db($busca_conse_sin_espacio));
		
		if( $ejucuta_b_espac[0]>=1)
			{ ?>
			
            <script>
            	window.parent.muestra_alerta_error_solo_texto('', 'Error', '¡El consecutivo que intenta crear ya existe!', 20, 10, 18);
				//alert("El consecutivo que intenta crear ya existe !")
				//window.parent.document.getElementById("cargando").style.display="none"
			</script>
			
			<? 
			exit();
			}


	diaSemana($i);
	diaSemana($j);
	diaSemana($a_j);
	diaSemana($c_j);
	diaSemana($a_t);
	diaSemana($c_t);
	diaSemana($a_e);
	diaSemana($c_e);
	diaSemana($fecha_informativa);
	diaSemana($fecha_informativa_f);

	
	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/
	
	if( ($fecha_informativa != "") && ($fecha_informativa_f == "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de cierre del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de cierre del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
		
		if( ($fecha_informativa == "") && ($fecha_informativa_f != "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de apertura del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de apertura del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}


	if( ($fecha_informativa != "") && ($fecha_informativa_f != "") )
			{//si tiene aclaracuones
	
	if( ($fecha_informativa < $i) || ($fecha_informativa_f > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($fecha_informativa_f < $i) || ($fecha_informativa > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}		
			
			} // si tiene aclaraciones
	
if($fecha_reu_info!=""){
				
	if( ($fecha_reu_info < $i) || ($fecha_reu_info > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}			
			
}


/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/

if($a_t!=""){//si pone fechas tecnicas

if( ($a_t < $i) || ($c_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_t < $i) || ($a_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	


}//si pone fechas tecnicas
/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/



/******************************************************************************************************/
								/*VALIDA FECHA 	ECONOMICA*/
/******************************************************************************************************/


if($a_j!=""){//si pone fechas economicas

if( ($a_j < $i) || ($c_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_j < $i) || ($a_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	

} //si pone fechas economicas
/******************************************************************************************************/
								/*VALIDA FECHA ECONOMICA*/
/******************************************************************************************************/	
	
	
	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/
	
	
		

	echo	$inserta_procesos="insert into $t5 (tp1_id,tp2_id,tp3_id,tp4_id,tp5_id,cd_id_ejecucion,cd_id_entrega_documentos,
		direccion_entrega_documentos, cd_id_entrega_ofertas, direccion_entrega_ofertas, tp6_id, detalle_objeto, 
		tp7_tipo_moneda, cuantia, us_id_contacto, fecha_publicacion, fecha_apertura, fecha_cierre, peso_tecnico, 
		minimo_tecnico_solicitado, peso_economico,consecutivo,apertura_juridica,cierre_juridica, apertura_tecnica, cierre_tecnica,apertura_economica, cierre_economica, fecha_informativa, lugar, fecha_creacion, us_id, fecha_informativa_final, fecha_aclaraciones_2_inicial, fecha_aclaraciones_2_final, fecha_aclaraciones_3_inicial, fecha_aclaraciones_3_final, fecha_preconomica_inicial, fecha_preconomica_final, nueva_fecha_informativa, trm_actual,origen_duplicidad,us_id_otro_contacto, t1_area_id)
		 values (9, $a,$tipo_solicitud, $b, $g, 0,0,'$l',0,'$docu_fisi',$c, '$d', $f,  $e, $k,'$h','$i','$j',$p_t,$m_t,0,'".$conseutivo_arr."' ,'$a_j','$c_j','$a_t','$c_t','$a_e','$c_e', '$fecha_informativa','$direccion_info' , '$fecha $hora', ".$_SESSION["id_us_session"].", '$fecha_informativa_f','$a_j5','$a_j6','$a_j7','$a_j8','$a_e_p', '$c_e_p', '$fecha_reu_info', '$trm_actual',0,'$us_id_otro_contacto', $id_tipo_proceso)";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		auditor(20,$id_p,"", "");
		
				$sele_car="select * from pv_contactos where  pv_id = $pv_id_b and estado = 1 ";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
			$crea_relacion = query_db("insert into pro33_relacion_contactos_procesos (pro1_id, pv_contactos_id, principal) 
	values ($id_p,".$ls_c[0].",1 )");

				
				}
		
		
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_p,2)");					
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_p,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_p,5)");				
		
		$inserta_tipo_evaluacion_tec = query_db("insert into pro34_relacion_tipo_evaluacion_tecnica (pro1_id,tipo_evaluacion) values ($id_p,25)");	
		if($a!=31){
		$inserta_defaul_tecnico_cate = query_db("insert into $t12 (proc1_id,rel9_id ,porcentaje ,estado_configuracion) values ($id_p, 18,100,1)");			
		$inserta_defaul_tecnico = query_db("insert into $t91 (in_id,rel10_id ,evaluador1_valoresperado ,termino) values ($id_p, 1,100,2)");			
		}
		$inserta_defaul_comercial = query_db("insert into $t91 (in_id,rel10_id ,evaluador1_valoresperado ,termino) values ($id_p, 8,0,1)");	
		$inserta_defaul_lista_economica = query_db("insert into $t19 (pro1_id,nombre ,requiere_aui) values ($id_p, 'LISTA ITEM ECONOMICO ".$conseutivo_arr."',0)");	
		$id_lista = id_insert();		
		if($id_lista>=1)
			{
				$inserta_defaul_lista_economica = query_db("insert into $t94 (in_id,evaluador4_nombre ,evaluador4_tipo, orden_aparacion, pro11_id)
				 values ($id_p, 'VALOR UNITARIO ANTES DE IVA','Valor',0,$id_lista)");	
			}
		
		graba_lugar_ejecucion($id_p);

		
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18); 
		//window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_p;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
        window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
		//window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
        </script>
		<?
		
		
		}
	
	}
     
if($_POST["accion"]=="crea_proveedor")
	{
	echo $proveedor;
		$proveedor = explode("----,",$proveedor);
	
		 echo $inserta_procesos="insert into $t7 (pro1_id,pv_id,lectura_proceso,aceptacion_participacion,estado,observaciones,observaciones_2)
		  values ($id_proceso, $proveedor[1],'', 'N/A', 1 ,'', '$observa_provee' )";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		
		if($nuevo_provee_obligato==1)
			$complemento_audi="; Proveedor incluido despues de la notificación en proceso de invitación a proponer; Comentario: ".$observa_provee;

		auditor(37,$id_proceso,$proveedor[0].$complemento_audi, $proveedor[1]);
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
        </script>
		<?
		
		
		}
	
	}	        





if($_POST["accion"]=="confirma_asistencia_participa")
	{
	
	$cuanto_selecciono = count($asiste_obligat_blo);
	foreach($asiste_obligat_blo as $id_proveedor => $valor_trae)
		{ // for
			if($valor_trae==0)
				$ms_err+=1;
				
				
		
		} // for
	
	
		if($ms_err>=1){
		
			?>
            <script>
            	window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione todos los proveedor', 20, 10, 18);
				//alert("* Seleccione todos los proveedor")
				 //window.parent.document.getElementById("cargando").style.display="none"
			</script>
		<?
		exit();
		}
		
		else{
	
		foreach($asiste_obligat_blo as $id_proveedor => $valor_trae)
		{ // for
		
				$bsca_pro = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $id_proveedor "));
		
			if($valor_trae==1)
				{// si participo
					$update = "update $t7 set lectura_proceso = 1 where pro1_id = $id_proceso and pv_id = $id_proveedor";
					auditor(44,$id_proceso,"Proveedor ".$bsca_pro[0]." asiste a la reunion informativa", $id_proveedor);
				}//

			if($valor_trae==2)
				{// si participo
					$update = "update $t7 set lectura_proceso = 2, estado = 2 where pro1_id = $id_proceso and pv_id = $id_proveedor";					
					auditor(44,$id_proceso,"Proveedor  ".$bsca_pro[0]." NO asiste a la reunion informativa, se bloquea ingreso", $id_proveedor);
				}//

			$ex_sql = query_db($update);
		} // for	
		
		
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se genero con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	
	}
	}

if($_POST["accion"]=="elimina_proveedor")
	{
	
		$bsca_pro = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $id_elimina "));
		$inserta_procesos="delete from $t7 where pv_id = $id_elimina and  pro1_id = $id_proceso";
		$sql_e = query_db($inserta_procesos);
		auditor(38,$id_proceso,$bsca_pro[0], $id_elimina);
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proveedor se elimino con éxito', 20, 10, 18);
		//alert("El proveedor se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}	        








if($_POST["accion"]=="crea_archivo")
	{

		
		$verifica_notificacion = traer_fila_row(query_db("select notificacion from $t5 where pro1_id = $id_proceso"));
		
		$inserta_procesos="insert into $t6 (pro1_id,tp8_id,archivo,peso,fecha_carga,estado,origen,tipo_archivo,id_origen)
		  values ($id_proceso, $tipo_archivo,'$anexos_s_name', '$anexos_s_size', '$fecha $hora',1 ,1,'N/A',0 )";
		$sql_e = query_db($inserta_procesos);
		$id_fichero = id_insert();
		if($id_fichero>=1){
				auditor(22,$id_proceso,$anexos_s_name, "");
				if($verifica_notificacion[0]==1)
					alertas_bitacora(6,$id_proceso,0,"Nuevo archivo en el proceso",$id_fichero);
				
		carga_archivo($anexos_s,"pecc/".$id_fichero."_1");
//		$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");
		
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
        </script>
		<?
		
		
		}
	
	}

if($_POST["accion"]=="elimina_archivo")
	{
	
		$busca_archivo=traer_fila_row(query_db("select * from $t6 where pro2_id = $id_elimina "));
		$inserta_procesos="delete from $t6 where pro2_id = $id_elimina ";
		$sql_e = query_db($inserta_procesos);
		if($busca_archivo[7]==1)
		unlink(SUE_PATH_ARCHIVOS."pecc/".$id_elimina."_1.txt");
		
		auditor(23,$id_proceso,$busca_archivo[3], "");
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El archivo se elimino con éxito', 20, 10, 18);
		//alert("El archivo se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}


//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados
if($_POST["accion"] == "configura_evaluacion_criterios")
	{
		$suma_categoria=0;
		$suma_criterios=0;
		
		$suma_categoria = array_sum($_POST["valor_catego"]);
		if($suma_categoria==100){//SI LAS CATEGORIAS SUMAN 100%
		
		foreach($_POST["valor_catego"] as $id_categoria => $valor_categoria)
			{ // recorre las categorias

				if($valor_categoria!=""){//verifica que las categorias tengan valores
				$id_categoria_no_borrar.=",".$id_categoria;
				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/

					$busca_existe = traer_fila_row(query_db("select * from $t12 where  proc1_id = $id_proceso and rel9_id = $id_categoria"));
						if($busca_existe[0]>=1)
							 $inserta_cr="update $t12 set porcentaje=$valor_categoria where evaluador9_id   = $busca_existe[0]";
						else							
							 $inserta_cr="insert into $t12 (proc1_id, rel9_id, porcentaje) values ($id_proceso,$id_categoria,$valor_categoria )";

					$exc=query_db($inserta_cr);
								

				/****************************************
				INGRESO DE CATEGORIAS A LA BASE DE DATOS
				*****************************************/
				
				
						$suma_criterios = array_sum($_POST["valorcriteri_".$id_categoria]);
						if($suma_criterios==100){//SI LOS CRITERIOS SUMAN 100%
				
								foreach($_POST["valorcriteri_".$id_categoria] as $id_criterio => $valor_criterio)
									{ // recorre los criterios
											if($valor_criterio!=""){//verifica que los criterios tengan valores
												$id_criterios_no_borrar.=",".$id_criterio;								
											
											
											$busca_existe = traer_fila_row(query_db("select * from $t91 where  in_id = $id_proceso and rel10_id = $id_criterio"));
											if($busca_existe[0]>=1)
											 $inserta_cr="update $t91 set evaluador1_valoresperado=$valor_criterio where evaluador1_id  = $busca_existe[0]";
											else							
											 $inserta_cr="insert into $t91 (in_id, rel10_id, evaluador1_valoresperado, termino) values ($id_proceso,$id_criterio,$valor_criterio, 2 )";
				
											$exc=query_db($inserta_cr);
											
											
											
																   }//verifica que los criterios tengan valores
																
									}// recorre los criterios
								
						}//SI LOS CRITERIOS SUMAN 100%	
						else{//SI LOS CRITERIOS SUMAN 100% ?>

							<script> 
							window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Los criterios de las categorías de la evaluación técnica deben sumar el 100%\n * La suma parcial de criterios seleccionados es de <?=$suma_criterios;?>', 20, 10, 18);
                            //alert("ATENCION\n * Los criterios de las categorías de la evaluación técnica deben sumar el 100%\n * La suma parcial de criterios seleccionados es de <?=$suma_criterios;?>")
							window.parent.document.principal.suma_criterio_<?=$id_categoria;?>.className = "campos_faltantes_fecha"
                            


                            </script>            
            
			            <? exit(); } //SI LAS CRITERIOS NO SUMAN 100% 
						
									
										}//verifica que las categorias tengan valores
			} // recorre las categorias
			
					echo $borra="delete from $t12 where proc1_id = $id_proceso and rel9_id  not in (0 $id_categoria_no_borrar) ";
					$exc=query_db($borra);	

					echo $borra="delete from $t91 where in_id = $id_proceso and rel10_id  not in (0 $id_criterios_no_borrar) and termino = 2 ";
					$exc=query_db($borra);
					
					//$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");
					?>
                    	<script>
                    	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se genero con exito', 20, 10, 18);
						//alert("El registro se genero con exito")
						window.parent.ajax_carga('configuracion_criteriostecnicos_<?=$id_vari;?>_2.php','carga_evaluacion')
						</script>
                    
                    
                    <?

			
			}//SI LAS CATEGORIAS SUMAN 100%
			else{//SI LAS CATEGORIAS NO SUMAN 100% ?>

					<script> 
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las categorías de la evaluación técnica deben sumar el 100%\n * La suma total de las categorías seleccionadas es de <?=$suma_categoria;?>', 20, 10, 18);
	                    //alert("ATENCION\n * Las categorías de la evaluación técnica deben sumar el 100%\n * La suma total de las categorías seleccionadas es de <?=$suma_categoria;?>")
                    </script>            
            
            <?

							
			
			 } //SI LAS CATEGORIAS NO SUMAN 100% 
			
			//echo $suma_criterios;
	

}
//---------------------------------------------------------------------------------------------------------------------------------------------------
//generacion de puntos esperados


//configura campos

if($_POST["accion"] == "configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		
		$cambia_cali=query_db("insert into $t94 (in_id, evaluador4_nombre, evaluador4_tipo,orden_aparacion, pro11_id ) values ($id_invitacion, '$n_campo', '$tipo_campo', 0, $id_lista)");
		$id_cargue=id_insert();
		if($id_cargue>=1){
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El campo se creo con éxito', 20, 10, 18);
			//alert("El campo se creo con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?
		} else { ?>		
	 	<script>
	 		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El campo NO se creo', 20, 10, 18);
			//alert("ATENCIÓN: El campo NO se creo")
		</script>
	<?
        		}
		
		}




if($_POST["accion"] == "e_configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		$cambia_cali="update $t94 set  evaluador4_nombre = '".$_POST["n_e_campo_".$id_campo]."', evaluador4_tipo='".$_POST["t_e_campo_".$id_campo]."' where evaluador4_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El campo se modificó con éxito', 20, 10, 18);
			//alert("El campo se modificó con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}
		
if($_POST["accion"] == "elimina_configura_evaluacion_campo")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		echo $cambia_cali="delete from $t94  where evaluador4_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El campo se elimino con éxito', 20, 10, 18);
			//alert("El campo se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}		

if($_POST["accion"] == "elimina_toda_lista")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		echo $cambia_cali="delete from $t95  where in_id = $id_invitacion";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La lista se elimino con éxito', 20, 10, 18);
			//alert("* La lista se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>.html','contenidos');
		</script>
	<?

		
		}
//---------------------------------------------------------------------------------------------------------------------------------------------------
//configura campos

//configura articulos

		
if($_POST["accion"] == "configura_evaluacion_articulo")
	{

		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$cambia_cali=query_db("insert into $t95 (in_id, evaluador5_codigo, evaluador5_detalle,evaluador5_unidad,evaluador5_cantidad,evaluador5_moneda,evaluador5_valor,evaluador5_presupuesto, pro11_id)
		 values ($id_invitacion,'$a_economica', '$b_economica', '$c_economica',$d_economica,'$e_economica','$f_economica','$presupuesto_economica', $id_lista)");
		$id_cargue=id_insert();
		if($id_cargue>=1){
		auditor(24,$id_invitacion,$b_economica, "");
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Producto se creo con éxito', 20, 10, 18);
			//alert("El Producto se creo con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');


		</script>
	<?
		} else { ?>		
	 	<script>
	 		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El Producto NO se creo', 20, 10, 18);
			//alert("ATENCIÓN: El Producto NO se creo")
		</script>
	<?
        		}
		
		}



if($_POST["accion"] == "edita_articulos_lista")
	{

		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);

		$busca_anterior = traer_fila_row(query_db("select evaluador5_detalle from $t95 where evaluador5_id  = $id_campo "));
		$cambia_cali="update $t95 set  evaluador5_codigo = '".$_POST["a2_".$id_campo]."', evaluador5_detalle='".$_POST["b2_".$id_campo]."',evaluador5_unidad='".$_POST["c2_".$id_campo]."', evaluador5_cantidad = '".$_POST["d2_".$id_campo]."' , evaluador5_moneda = '".$_POST["e2_".$id_campo]."' where evaluador5_id  = $id_campo";
		$id_cargue=query_db($cambia_cali);
		
		
		auditor(25,$id_invitacion,$busca_anterior[0]." por ".$_POST["b2_".$id_campo], "");

	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Producto se modificó con éxito', 20, 10, 18);
			//alert("El Producto se modificó con éxito")
		</script>
	<?

		
		}		


if($_POST["accion"] == "elimina_articulo_lista")
	{
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$id_campo = elimina_comillas($campo_id);
		$busca_anterior = traer_fila_row(query_db("select evaluador5_detalle from $t95 where evaluador5_id  = $id_campo "));
		auditor(26,$id_invitacion,$busca_anterior[0], "");
		 $cambia_cali="delete from $t95  where evaluador5_id = $id_campo";
		$sql_ex = query_db($cambia_cali);
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El bien o servicio se elimino con éxito', 20, 10, 18);
			//alert("El bien o servicio se elimino con éxito")
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');
		</script>
	<?

		
		}


//---------------------------------------------------------------------------------------------------------------------------------------------------
//configura articulos




if($_POST["accion"]=="notifica_proveedores")
	{
	
	$tiene_criterios_comerciales=2;
	$tiene_criterios_tecnicos=2;

				$cuenta_criterios_te = "select count(*) from $t91 where in_id = $id_proceso and termino = 2";
				$sql_cu_tec = traer_fila_row(query_db($cuenta_criterios_te));
					if($sql_cu_tec[0]>=1)
						{ // si no tiene criterios
			
							$tiene_criterios_tecnicos = 1;
			
											}// si no tiene criterios

				$cuenta_criterios_te = "select count(*) from $t91 where in_id = $id_proceso and termino = 1";
				$sql_cu_tec = traer_fila_row(query_db($cuenta_criterios_te));
					if($sql_cu_tec[0]>=1)
						{ // si no tiene criterios
			
							$tiene_criterios_comerciales = 1;
			
											}// si no tiene criterios




		/******VALIDACION DE CRITERIOS TECNICOS************/
		/**************************************************/

		if( $confirma_objeto=="")
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Por favor confirme la revisión objeto del servicio', 20, 10, 18);
									//alert("ATENCION: \n Por favor confirme la revisión objeto del servicio")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios


		if( ($a_t!="") && ($tiene_criterios_tecnicos==2) )
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Usted selecciono fecha de recepción de ofertas tecnicas, pero no ha seleccionado criterios tecnicos\n Seleccione los criterios comerciales o elimine la fecha de recepción de ofertas tecnicas', 20, 10, 18);
									//alert("ATENCION: \n Usted selecciono fecha de recepción de ofertas tecnicas, pero no ha seleccionado criterios tecnicos\n Seleccione los criterios comerciales o elimine la fecha de recepción de ofertas tecnicas")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		if( ($a_t=="") && ($tiene_criterios_tecnicos==1) )
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Usted selecciono criterios tecnicos, pero no ha seleccionado la fecha', 20, 10, 18);
									//alert("ATENCION: \n Usted selecciono criterios tecnicos, pero no ha seleccionado la fecha\n ")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		if( ($a_t!="") && ($tiene_criterios_tecnicos==1) )
			{ // si tiene fecha pero no criterios
				if($_POST["responsable_tec"]==0){//si tiene tecnico pero no responsable
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un responsable de la evaluación tecnica', 20, 10, 18);
									//alert("ATENCION: \n Seleccione un responsable de la evaluación tecnica")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						
								
				} //si tiene tecnico pero no responsable

			}// si tiene fecha pero no criterios



		/******VALIDACION DE CRITERIOS TECNICOS************/
		/**************************************************/

		/******VALIDACION DE CRITERIOS COMERCIALES************/
		/**************************************************/
		if( ($a_j!="") && ($tiene_criterios_comerciales==2) )
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Usted selecciono fecha de recepción de ofertas comerciales, pero no ha seleccionado criterios comerciales\n * Seleccione los criterios comerciales o elimine la fecha de recepción de ofertas comerciales', 20, 10, 18);
									//alert("ATENCION: \n Usted selecciono fecha de recepción de ofertas comerciales, pero no ha seleccionado criterios comerciales\n Seleccione los criterios comerciales o elimine la fecha de recepción de ofertas comerciales")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		if( ($a_j=="") && ($tiene_criterios_comerciales==1) )
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Usted seleccionó criterios comerciales, pero no ha seleccionado la fecha', 20, 10, 18);
									//alert("ATENCION: \n Usted selecciono criterios comerciales, pero no ha seleccionado la fecha\n ")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		/******VALIDACION DE CRITERIOS TECNICOS************/
		/**************************************************/


		if( ($tiene_criterios_tecnicos==2) && ($tiene_criterios_comerciales==2) )
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* EL PROCESO DEBE TENER REQUERIMIENTOS TECNICOS O ECONOMICOS', 20, 10, 18);
									//alert("ATENCION: \n eL PROCESO DEBE TENER REQUERIMIENTOS TECNICOS O ECONOMICOS")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios


		if ($i<$fecha." ".$hora)
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* LA FECHA DE APERTURA ES MENOR A LA ACTUAL', 20, 10, 18);
									//alert("ATENCION: \n LA FECHA DE APERTURA ES MENOR A LA ACTUAL")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		if ($j<$fecha." ".$hora)
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* LA FECHA DE CIERRE ES MENOR A LA ACTUAL', 20, 10, 18);
									//alert("ATENCION: \n LA FECHA DE CIERRE ES MENOR A LA ACTUAL")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios

		if ($j<=$i)
			{ // si tiene fecha pero no criterios
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* LA FECHA DE CIERRE ES MENOR A LA APERTURA', 20, 10, 18);
									//alert("ATENCION: \n LA FECHA DE CIERRE ES MENOR A LA APERTURA")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						

			}// si tiene fecha pero no criterios



$busca_si_tiene_proveedores = traer_fila_row(query_db("select count(*) from $t7 where pro1_id = $id_proceso"));	
if($busca_si_tiene_proveedores[0]==0)
			{ // si selecciono proveedores
			
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione por lo menos un proveedor', 20, 10, 18);
									//alert("ATENCION: \n Seleccione por lo menos un proveedor")
									//window.parent.document.getElementById("cargando").style.display="none"
									
								</script>
								
								<? 
								exit();						
											
			}// si selecciono proveedores

$busca_provee_sin_email = traer_fila_row(query_db("select count(*) from $t8, $t7 where
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id and $t8.email = ''"));

if($busca_provee_sin_email[0]>=1)
			{ // si selecciono proveedores
			
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Existen proveedores sin e-mail', 20, 10, 18);
									//alert("ATENCION: \n Existen proveedores sin e-mail")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						
											
			}// si selecciono proveedores				
	
	
	
	   $inserta_procesos="update $t5 set notificacion = 1 where  pro1_id = $id_proceso";
		$sql_e = query_db($inserta_procesos);
		$cambia_estado = query_db("update $t5 set tp1_id = 4 where pro1_id = $id_proceso");


			$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 5"));
		 	$asunto_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[1] );
			$asunto = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_apertura---',fecha_for_hora($sql_e[17]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($sql_e[18]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---objeto_contratar---', listas_sin_select($tp6,$sql_e[11],1), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---detalle_contratar---', $sql_e[12], $id_subastas_arrglo);

			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores
				$graba_correo_pro2="";
					$busca_contrasena="select * from t1_us_usuarios where pv_id = $lp[0]";
					$busca_si_proveedor_cambia_cot= mssql_fetch_row(mssql_query($busca_contrasena));
							

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);

					if($busca_si_proveedor_cambia_cot[12]>=1){
					$id_subastas_arrglo_usuario = str_replace('--contraseña--','Contraseña:', $id_subastas_arrglo_usuario);
					$id_subastas_arrglo_usuario = str_replace('--contra_ingreso--', '321654', $id_subastas_arrglo_usuario);										
					}
					else
					{
					$id_subastas_arrglo_usuario = str_replace('--contraseña--','', $id_subastas_arrglo_usuario);
					$id_subastas_arrglo_usuario = str_replace('--contra_ingreso--', '', $id_subastas_arrglo_usuario);										
					}

					
					
					$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
					$confirma_envio= envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);
					registro_email_enviado_nuevo($id_proceso, $lp[4], $asunto, $mensaje_envio,$confirma_envio,1,1,$lp[0]);
				//alertas_bitacora(8,$id_proceso,$lp[0],"",0);

					$graba_correo_pro.="<li>".$lp[4]."</li>";
					$graba_correo_pro2.=$lp[4].", ";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_proceso and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						$confirma_envio= envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						registro_email_enviado_nuevo($id_proceso, $lp_contactos[0], $asunto, $mensaje_envio,$confirma_envio,1,1,$lp[0]);
						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos
						
						auditor(27,$id_proceso,$lp[2]." | Se envio email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
						}// provvedores

			/****envio de correo a los contactos*/
			
		$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 8"));
		
		$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
		$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---fecha_apertura---',fecha_for_hora($sql_e[17]), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($sql_e[18]), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---objeto_contratar---', listas_sin_select($tp6,$sql_e[11],1), $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('---detalle_contratar---', $sql_e[12], $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace("--provvedores--",$graba_correo_pro, $id_subastas_arrglo );	
								
	 	$asunto_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[1] );
		$asunto = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );

		

		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
		while($destinatario = traer_fila_row($busca_dueno)){
			$confirma_envio=envia_correos($destinatario[0],$asunto,$id_subastas_arrglo,$cabesa);
			registro_email_enviado_nuevo($id_proceso, $destinatario[0], $asunto, $id_subastas_arrglo,$confirma_envio,1,1,0);
			
			}
		


			


			?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La notificación se envio con exito', 20, 10, 18);
		//alert("* La notificación se envio con exito")
		window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_proceso;?>','contenidos');
		</script>
        <?
	
	}


if($_POST["accion"]=="modifica_proceso_notificado_p")
	{


	diaSemana($i);
	diaSemana($j);
	diaSemana($a_j);
	diaSemana($c_j);
	diaSemana($a_t);
	diaSemana($c_t);
	diaSemana($a_e);
	diaSemana($c_e);
	diaSemana($fecha_informativa);
	diaSemana($fecha_informativa_f);

	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/
	
	if( ($fecha_informativa != "") && ($fecha_informativa_f == "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de cierre del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de cierre del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
		
		if( ($fecha_informativa == "") && ($fecha_informativa_f != "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de apertura del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de apertura del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}


	if( ($fecha_informativa != "") && ($fecha_informativa_f != "") )
			{//si tiene aclaracuones
	
	if( ($fecha_informativa < $i) || ($fecha_informativa_f > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($fecha_informativa_f < $i) || ($fecha_informativa > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}		
			
			} // si tiene aclaraciones
	
if($fecha_reu_info!=""){
				
	if( ($fecha_reu_info < $i) || ($fecha_reu_info > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}			
			
}


/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/
if($a_t!=""){//si tiene ofertas tecnicas


if( ($a_t < $i) || ($c_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					// window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_t < $i) || ($a_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	
				if($_POST["responsable_tec"]==0){//si tiene tecnico pero no responsable
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un responsable de la evaluación tecnica', 20, 10, 18);
									//alert("ATENCION: \n Seleccione un responsable de la evaluación tecnica")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						
								
				} //si tiene tecnico pero no responsable
			
			

}//si tiene ofertas tecnicas

/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/



/******************************************************************************************************/
								/*VALIDA FECHA 	ECONOMICA*/
/******************************************************************************************************/
if($a_j!=""){//si pone fechas economicas
if( ($a_j < $i) || ($c_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_j < $i) || ($a_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	

}//si pone fechas economicas

/******************************************************************************************************/
								/*VALIDA FECHA ECONOMICA*/
/******************************************************************************************************/	
	
	
	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/


	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$ms ="";
	if($sql_e[22]!=$consecutivo){
		$ms.="Consecutivo:".$consecutivo."<br>";
		
		
		}
	
	if($sql_e[2]!=$a){
		$ms.="Tipo de proceso:".listas_sin_select($tp2,$a,1)."<br>";
				$up.= " , tp2_id='$a'";
				}

	if($sql_e[3]!=$tipo_solicitud){
		$ms.="Tipo de solicitu:".listas_sin_select($tp3,$tipo_solicitud,1)."<br>";
				$up.= " , tp3_id='$tipo_solicitud'";
				}



	if($sql_e[5]!=$g){
		$ms.="Tipo de contrato:".listas_sin_select($tp5,$g,1)."<br>";
		$up.= " , tp5_id='$g'";
				}
		
	if($sql_e[11]!=$c){
		$ms.="Objeto a contratar:".listas_sin_select($tp6,$c,1)."<br>";
		$up.= " , tp6_id='$c'";
				}
	
	if($sql_e[12]!=$d){
		$ms.="Detalle del objeto a contratar:".$d."<br>";
		$up.= " , detalle_objeto='$d'";
				}
	
	if($sql_e[14]!=$e){
		$ms.="Cuantía a contratar:".$e."<br>";
	$up.= " , cuantia='$e'";
				}		
	
	if($sql_e[13]!=$f){
		$ms.="Moneda:".listas_sin_select($tp7,$f,1)."<br>";
		$up.= " , tp7_tipo_moneda='$f'";
				}	
	
	
	$up.= " , fecha_publicacion='$h'";
			
	if($sql_e[17]!=$i){
		$ms.="Fecha de apertura:".$i."<br>";
		$up.= " , fecha_apertura='$i'";
				}	
		
	
	if($sql_e[18]!=$j){
		$ms.="Fecha de cierre:".$j."<br>";
		$up.= " , fecha_cierre='$j'";
		alertas_bitacora(5,$id_proceso,0,"Modifica fecha de cierre:".$j,0);
		auditor(31,$id_proceso,"Modifica fecha de cierre:".$j, "");
		
				}			

	if($sql_e[15]!=$k){
		$ms.="Persona de contacto:".listas_sin_select($t1,$k,1)."<br>";
		$up.= " , us_id_contacto='$k'";
				}			
		
	
	if($sql_e[41]!=$fecha_reu_info){
		$ms.="Fecha y hora reunión informativa:".$fecha_informativa."<br>";
		$up.= " , fecha_informativa='$fecha_informativa'";
		alertas_bitacora(5,$id_proceso,0,"Modifica fecha y hora reunión informativa:".$fecha_informativa,0);
		auditor(32,$id_proceso,"Modifica fecha y hora reunión informativa:".$fecha_informativa, "");
		

				}			
		
	
	if($sql_e[30]!=$direccion_info){
		$ms.="Lugar reunión informativa:".$direccion_info."<br>";
		$up.= " , lugar='$direccion_info'";
				}			
		
		

		$up.= " , peso_tecnico='$p_t'";
		$up.= " , minimo_tecnico_solicitado='$m_t'";						
		$up.= " , apertura_juridica='$a_j'";
		$up.= " , cierre_juridica='$c_j'";
		$up.= " , apertura_tecnica='$a_t'";						
		$up.= " , cierre_tecnica='$c_t'";
		$up.= " , apertura_economica='$a_e'";
		$up.= " , cierre_economica='$c_e'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , direccion_entrega_documentos ='$l'";
		$up.= " , direccion_entrega_ofertas ='$docu_fisi' ";		
		
		
		$up.= " , fecha_informativa_final='$fecha_informativa_f'";
		$up.= " , fecha_aclaraciones_2_inicial='$a_j5'";
		$up.= " , fecha_aclaraciones_2_final='$a_j6'";						
		$up.= " , fecha_aclaraciones_3_inicial='$a_j7'";
		$up.= " , fecha_aclaraciones_3_final='$a_j8'";
		$up.= " , fecha_preconomica_inicial='$a_e_p'";
		$up.= " , fecha_preconomica_final='$c_e_p'";						
		$up.= " , nueva_fecha_informativa='$fecha_reu_info'";	
		$up.= " , trm_actual='$trm_actual'";	
		$up.= " , us_id_otro_contacto='$us_id_otro_contacto'";			
				
		
	
	
	
	 $inserta_mo = "insert into $t10 (pro1_id, modificaciones, justificacion, us_id, fecha) values ($id_proceso,'$ms','$justificacion_final', ".$_SESSION["id_us_session"].", '$fecha $hora'   )";
	$insert = query_db($inserta_mo);
	
		 $cambia = "update $t5 set consecutivo = '$consecutivo' $up where pro1_id=$id_proceso";
		$insert = query_db($cambia);

		$dele_obser=query_db("delete from $t11  where pro1_id=$id_proceso");
//		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($auditor_proceso,$id_proceso,1)");						
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_proceso,2)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_proceso,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_proceso,5)");				

		graba_lugar_ejecucion($id_proceso,$_POST["crea_lugar"]);

		$cambia_estado = query_db("update $t5 set tp1_id = 4 where pro1_id = $id_proceso");
		
		?>
	
	
    <script>
    	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La notificación se envio con exito', 20, 10, 18);
		//alert("El proceso se modificó con éxito-....")
	</script>
    <?
	

	
	}
	
	
	
if($_POST["accion"]=="modifica_proceso")
	{

		$busca_conse_sin_espacio = "select pro1_id from $t5  where REPLACE(consecutivo,' ','') =  REPLACE('".consecutivo_automatico()."',' ','') and pro1_id <> $id_proceso ";

		
		$ejucuta_b_espac = traer_fila_row(query_db($busca_conse_sin_espacio));
		
		if( $ejucuta_b_espac[0]>=1)
			{ ?>
			
            <script>
            	window.parent.muestra_alerta_error_solo_texto('', 'Error', '* ¡El consecutivo que intenta crear ya existe!', 20, 10, 18);
				//alert("El consecutivo que intenta crear ya existe !")
				 //window.parent.document.getElementById("cargando").style.display="none"
			</script>
			
			<? 
			exit();
			}

	diaSemana($i);
	diaSemana($j);
	diaSemana($a_j);
	diaSemana($c_j);
	diaSemana($a_t);
	diaSemana($c_t);
	diaSemana($a_e);
	diaSemana($c_e);
	diaSemana($fecha_informativa);
	diaSemana($fecha_informativa_f);

	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/
	
	if( ($fecha_informativa != "") && ($fecha_informativa_f == "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de cierre del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de cierre del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
		
		if( ($fecha_informativa == "") && ($fecha_informativa_f != "") )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha de apertura del cartelera de aclaraciones', 20, 10, 18);
					//alert("* Seleccione la fecha de apertura del cartelera de aclaraciones")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}


	if( ($fecha_informativa != "") && ($fecha_informativa_f != "") )
			{//si tiene aclaracuones
	
	if( ($fecha_informativa < $i) || ($fecha_informativa_f > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($fecha_informativa_f < $i) || ($fecha_informativa > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las fechas de la cartelera de aclaraciones debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}		
			
			} // si tiene aclaraciones
	
if($fecha_reu_info!=""){
				
	if( ($fecha_reu_info < $i) || ($fecha_reu_info > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* La fecha de la reunion informativa debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}			
			
}


/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/

if($a_t!=""){//si ha seleccionado fecha tecnica


if( ($a_t < $i) || ($c_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_t < $i) || ($a_t > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas técnicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	

				if($_POST["responsable_tec"]==0){//si tiene tecnico pero no responsable
					?>
								<script>
									window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un responsable de la evaluación tecnica', 20, 10, 18);
									//alert("ATENCION: \n Seleccione un responsable de la evaluación tecnica")
									//window.parent.document.getElementById("cargando").style.display="none"
								</script>
								
								<? 
								exit();						
								
				} //si tiene tecnico pero no responsable



}//si ha seleccionado fecha tecnica

/******************************************************************************************************/
								/*VALIDA FECHA TECNICA*/
/******************************************************************************************************/



/******************************************************************************************************/
								/*VALIDA FECHA 	ECONOMICA*/
/******************************************************************************************************/
if($a_j!=""){//si pone fechas economicas
if( ($a_j < $i) || ($c_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}
			
	if( ($c_j < $i) || ($a_j > $j) )
		{
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso', 20, 10, 18);
					//alert("* Las Fechas de recepción ofertas economicas debe estar dentro de la apertura y cierre general del proceso")
					 //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                           
            <?
			
				exit();
			}	

} //si pone fechas economicas
/******************************************************************************************************/
								/*VALIDA FECHA ECONOMICA*/
/******************************************************************************************************/	
	
	
	/****************************************************************************************************************************/
					/*VALIDA FECHAS*/
	/*****************************************************************************************************************************/





	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
		$sql_e=traer_fila_row(query_db($busca_procesos));
		$ms ="";
		
		
	

		if($sql_e[18]!=$j){
		$ms="Modificación Fecha de cierre:".$j;
		
				}	
		if($sql_e[29]!=$fecha_informativa){
		$ms="Modificación Fecha y hora reunión informativa:".$fecha_informativa;

				}	

				
		$up.= " , tp3_id='$tipo_solicitud'";
		$up.= " , tp2_id='$a'";
		$up.= " , tp5_id='$g'";
		$up.= " , tp6_id='$c'";
		$up.= " , detalle_objeto='$d'";
		$up.= " , cuantia='$e'";
		$up.= " , tp7_tipo_moneda='$f'";
		$up.= " , fecha_apertura='$i'";
		$up.= " , fecha_cierre='$j'";
		$up.= " , peso_tecnico='$p_t'";
		$up.= " , minimo_tecnico_solicitado='$m_t'";						
		$up.= " , apertura_juridica='$a_j'";
		$up.= " , cierre_juridica='$c_j'";
		$up.= " , apertura_tecnica='$a_t'";						
		$up.= " , cierre_tecnica='$c_t'";
		$up.= " , apertura_economica='$a_e'";
		$up.= " , cierre_economica='$c_e'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , direccion_entrega_documentos ='$l'";
		$up.= " , direccion_entrega_ofertas ='$docu_fisi' ";				

		$up.= " , us_id_contacto='$k'";
		$up.= " , fecha_informativa='$fecha_informativa'";
		$up.= " , lugar='$direccion_info'";
		$up.= " , fecha_informativa_final='$fecha_informativa_f'";
		$up.= " , fecha_aclaraciones_2_inicial='$a_j5'";
		$up.= " , fecha_aclaraciones_2_final='$a_j6'";						
		$up.= " , fecha_aclaraciones_3_inicial='$a_j7'";
		$up.= " , fecha_aclaraciones_3_final='$a_j8'";
		$up.= " , fecha_preconomica_inicial='$a_e_p'";
		$up.= " , fecha_preconomica_final='$c_e_p'";						
		$up.= " , nueva_fecha_informativa='$fecha_reu_info'";	
		$up.= " , trm_actual='$trm_actual'";	
		$up.= " , us_id_otro_contacto='$us_id_otro_contacto'";
		$up.= " , t1_area_id=$id_tipo_proceso";																





		$cambia = "update $t5 set consecutivo = '$consecutivo' $up where pro1_id=$id_proceso";
		$insert = query_db($cambia);

		$dele_obser=query_db("delete from $t11  where pro1_id=$id_proceso");
//		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($auditor_proceso,$id_proceso,1)");						
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_tec,$id_proceso,2)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($respo_juridico, $id_proceso,3)");
		$insert_into_responsables = query_db("insert into $t11 (us_id,pro1_id,tipo) values ($responsable_ec,$id_proceso,5)");				
		//graba_lugar_ejecucion($id_proceso);						
		
		
	
			
		?>
	
	
    <script>
    	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se modificó con éxito..', 20, 10, 18);
		//alert("El proceso se modificó con éxito..")
	</script>
    <?

	}	


/*******************************************************************************************************************************/
//CREACION DE CATEGORIAS
/*******************************************************************************************************************************/

if($accion=="crea_grupo_evaluacion")
	{

				$cambia = query_db("insert into $t89 (cl_id,  rel9_detalle,  rel9_estado,rel9_aspecto, tp6_id ) values (".$_SESSION["id_us_session"].",'$valorgrupo',1,$termino,$id_proceso)");
				if($termino==1) $ruta_carga = "configuracion_criterios_".$id_vari."_1.php";
				if($termino==2) $ruta_carga = "configuracion_criteriostecnicos_".$id_vari."_2.php";				
				?>
					<script>
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La categoría se creó exito', 20, 10, 18);
						//alert("* La categoría se creó exito")
						window.parent.ajax_carga('<?=$ruta_carga;?>','contenidos');
					</script>

				<?

	
	  
	}


if($accion=="crea_criterio_evaluacion")
	{

		
		
		echo "insert into $t90 (rel9_id , rel10_detalle , rel10_estado ) values ($id_elimina, '".$_POST["nombre_criterio_".$id_elimina]."',1 )";
				
				$cambia = query_db("insert into $t90 (rel9_id , rel10_detalle , rel10_estado ) values ($id_elimina, '".$_POST["nombre_criterio_".$id_elimina]."',1 )");
				if($termino==1) $ruta_carga = "configuracion_criterios_".$id_vari."_1.php";
				if($termino==2) $ruta_carga = "configuracion_criteriostecnicos_".$id_vari."_2.php";				
				?>
					<script>
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El criterio se creó exito', 20, 10, 18);
						//alert("El criterio se creó exito")
						window.parent.ajax_carga('<?=$ruta_carga;?>','contenidos');
					</script>

				<?

	
	  
	}


/*******************************************************************************************************************************/
//CREACION DE CATEGORIAS
/*******************************************************************************************************************************/



/*******************************************************************************************************************************/
//CONFIGURACION Y ANEXO AL PROCESO CRITERIOS JURIDICOS
/*******************************************************************************************************************************/
if($_POST["accion"] == "configura_evaluacion_criterios_juridicos")
	{
		foreach($_POST["criterio"] as $id_criterio)
			{
				$valor_grupo=$_POST["valorcriteri_$id_criterio"];
				$suma_v+=$valor_grupo;
				$id_criterios.=",".$id_criterio;
			}
		
					echo $borra="delete from $t91 where in_id = $id_proceso and rel10_id  not in (0 $id_criterios) and termino = 1 ";
					$exc=query_db($borra);
					
					foreach($_POST["criterio"] as $id_criterio)
						{// for criterios
							$valor_criterio=$_POST["valorcriteri_$id_criterio"];

							$busca_existe = traer_fila_row(query_db("select * from $t91 where  in_id = $id_proceso and rel10_id = $id_criterio"));
							if($busca_existe[0]>=1)
							echo $inserta_cr="update $t91 set evaluador1_valoresperado=0 where evaluador1_id  = $busca_existe[0]";
							else							
							echo $inserta_cr="insert into $t91 (in_id, rel10_id, evaluador1_valoresperado, termino) values ($id_proceso,$id_criterio,0, 1 )";

							$exc=query_db($inserta_cr);
						}// for criterios
						
				//$cambia_estado = query_db("update $t55 set tp13_id = 12 where in_id = $id_invitacion");

						//$cambia_estado = query_db("update $t5 set tp1_id = 2 where pro1_id = $id_proceso");

						?>
	 							<script>

								window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Los criterios se crearon con exito', 20, 10, 18);
								//alert("Los criterios se crearon con exito")
								window.parent.ajax_carga('configuracion_criterios_<?=$id_vari;?>_1.php','contenidos')
							
									
								</script>
							<?
				
				

}
/*******************************************************************************************************************************/
//CONFIGURACION Y ANEXO AL PROCESO CRITERIOS JURIDICOS
/*******************************************************************************************************************************/


if($accion=="activa_campo_subasta")
	{
	$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	echo "insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor  ) value ($id_invitacion,4,$valor_campo)";
		$borra_anetrios = query_db("delete from $t93 where in_id = $id_invitacion and evaluador3_termino=4 and peso_evaluacion = $id_lista");
		$inserta_campo_subasta = query_db("insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor,peso_evaluacion  ) value ($id_invitacion,4,$valor_campo, $id_lista)");
		?>
        	<script>
        		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La subasta se activo con éxito', 20, 10, 18);
				//alert("* La subasta se activo con éxito")
			</script>
        <?
		
	}

if($accion=="activa_campo_subasta_consolidada")
	{
	$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		$borra_anetrios = query_db("delete from $t93 where in_id = $id_invitacion and evaluador3_termino=10 ");
		if($activa_subasta==10)
		$inserta_campo_subasta = query_db("insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor  ) value ($id_invitacion,10,0)");
		?>
        	<script>
        		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La subasta consolidada se activo con éxito', 20, 10, 18);
				//alert("* La subasta consolidada se activo con éxito")
			</script>
        <?
		
	}

/*******************************************************************************************************************************/
//EVALUACION JURIDICA
/*******************************************************************************************************************************/


if($accion=="evaluacion_juridica")
	{
	$estado_p="";
	$estado_n="";
echo $valor_obtenido." rerere<br>";

foreach($_POST["evaluacion_tecnica"] as $id_evaluacion_enviada => $valor_obtenido)
		{//recorre la evaluacion obtenida
		
			$id_proceso_unit_te = explode("_",$id_evaluacion_enviada);
			$id_evaluacion_enviada_1=$id_proceso_unit_te[0];
				$busca_ob_evalu = mysql_fetch_row(mysql_query("select * from $t32 where evaluador1_id=$id_evaluacion_enviada_1 and pv_id=$pv_id"));	
					if($busca_ob_evalu[0]>=1)
						{
				 							 $cambia_observacion = "update $t32 set observacion = '".$_POST["observa_".$id_evaluacion_enviada_1]."' where evaluador1_id=$id_evaluacion_enviada_1 and pv_id=$pv_id";
					$sql_ob=mysql_query($cambia_observacion);

						}
					else{
											 $cambia_observacion = "insert into $t32 (evaluador1_id, pv_id, observacion) values ($id_evaluacion_enviada_1,$pv_id,'".$_POST["observa_".$id_evaluacion_enviada_1]."' )";
						$sql_ob=mysql_query($cambia_observacion);

					}
echo $cambia_observacion;

		}
 


		foreach($_POST["evaluacion_juridica"] as $id_evaluacion_enviada => $valor_obtenido)
		{//recorre la evaluacion obtenida


			
			if($tipo_configuracion_tecnica==25)
				$valor_obtenido = $evaluacion_juridicacompleto;
			
			
			
			if($valor_obtenido!="0"){//si fue calificado
			
				$busca_exite = mysql_fetch_row(mysql_query("select * from $t96  where evaluador1_id = $id_evaluacion_enviada and pv_id = $pv_id"));
				if($busca_exite[0]>=1){				
				 $cambia_resultado = "update $t96 set resultado_evaluacion = '$valor_obtenido' where evaluador1_id = $id_evaluacion_enviada and pv_id = $pv_id";
				$sql_ex = mysql_query($cambia_resultado);
				}
				else
					{
						$insertar = mysql_query("insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_evaluacion_enviada, '',0,'','','','$valor_obtenido', '' )");
					
					}
				
				if($valor_obtenido==2)
				$estado_n+=1;
				
				
				$busca_ob_evalu = mysql_fetch_row(mysql_query("select * from $t32 where evaluador1_id=$id_evaluacion_enviada and pv_id=$pv_id"));	
					if($busca_ob_evalu[0]>=1)
						{
				 							 $cambia_observacion = "update $t32 set observacion = '".$_POST["observa_".$id_evaluacion_enviada]."' where evaluador1_id=$id_evaluacion_enviada and pv_id=$pv_id";
					$sql_ob=mysql_query($cambia_observacion);

						}
					else{
											 $cambia_observacion = "insert into $t32 (evaluador1_id, pv_id, observacion) values ($id_evaluacion_enviada,$pv_id,'".$_POST["observa_".$id_evaluacion_enviada]."' )";
						$sql_ob=mysql_query($cambia_observacion);

					}
				echo $cambia_observacion."aqui";
				
			}//si fue calificado
			if($valor_obtenido=="Sin")
				$estado_p+=1;
			
			
			
		}//recorre la evaluacion obtenida
		
		//echo $estado_n;
				$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_juri";
				$sql_e_pro=traer_fila_row(query_db($busca_procesos));
				
				$requiere_auditor_c=$sql_e_pro[45];
				$tipo_cronograma=$sql_e_pro[44];	
	
	
			if($estado_p>=1)
				$resultado_evaluacion = "pendiente de evaluación";
			elseif($estado_n>=1)	
				$resultado_evaluacion = "No Cumple";
			else
				$resultado_evaluacion = "Cumple";
				
				
			
			 $busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";	
			$busca_hist = mysql_fetch_row(mysql_query($busca_evaluacion));

			if($busca_hist[0]>=1){// si no se ha creado la evaluacion
				echo $termino_eva."si";
				if($termino_eva==1){
					$cambia_evaluacion = mysql_query("update $t13 set resultado_juridico = '$resultado_evaluacion', observaciones_juridicas= '$obse_juridico' where evaluador10_id = $busca_hist[0]");									

					if( ($tipo_cronograma==2) && ($resultado_evaluacion == "No Cumple") )
						$cambia_estado_proveedore = query_db("update $t7 set estado  = 2 where pro1_id = $id_invitacion_juri and pv_id = $pv_id");
							
											
					}
				elseif($termino_eva==3)
					$cambia_evaluacion = mysql_query("update $t13 set resultado_economico = '$resultado_evaluacion', observaciones_economico= '$obse_juridico' where evaluador10_id = $busca_hist[0]");				
				elseif($termino_eva==4)
					$cambia_evaluacion = mysql_query("update $t13 set resultado_hse = '$resultado_evaluacion', observaciones_hse= '$obse_juridico' where evaluador10_id = $busca_hist[0]");
				elseif($termino_eva==2){
					
					if($_FILES["soporte_avluacion"]["name"]!="")
				
					{
					$modifica_anexo_his = " ,documento = '".$_FILES["soporte_avluacion"]["name"]."'";
					carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$busca_hist[0]."_2");
						
						}


				
					
				    $cambia_evaluacion = mysql_query("update $t13 set resultado_tecnico  = '$resultado_evaluacion', observaciones_tecnico = '$obse_juridico' $modifica_anexo_his where evaluador10_id = $busca_hist[0]");
					if($_FILES["soporte_avluacion"]["name"]!="")
				
					{
						
					carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$busca_hist[0]."_2");
						echo $_FILES["soporte_avluacion"]["tmp_name"];
						
						}
				
				}
				elseif($termino_eva==6)
					$cambia_evaluacion = mysql_query("update $t13 set resultado_experiencias = '$resultado_evaluacion', observaciones_experiencias= '$obse_juridico' where evaluador10_id = $busca_hist[0]");
				elseif($termino_eva==7)
					$cambia_evaluacion = mysql_query("update $t13 set resultado_certificados = '$resultado_evaluacion', observaciones_certificados= '$obse_juridico' where evaluador10_id = $busca_hist[0]");


				}// si no se ha creado la evaluacion

			
			else{
			if($termino_eva==1){
				$sql_ingreso_ev_j= "insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '$resultado_evaluacion', '$obse_juridico', '','',0,'','', '' )";
				
				$cambia_evaluacion = mysql_query($sql_ingreso_ev_j);				
				}
			elseif($termino_eva==3){
				$cambia_evaluacion = mysql_query("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones,resultado_hse,observaciones_hse,resultado_economico,observaciones_economico)
				values ($id_invitacion_juri, $pv_id, '', '', '','',0,'','', '','', '','$resultado_evaluacion', '$obse_juridico' )");				
				}

			elseif($termino_eva==4){
				$cambia_evaluacion = mysql_query("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones,resultado_hse,observaciones_hse,resultado_economico,observaciones_economico)
				values ($id_invitacion_juri, $pv_id, '', '', '','',0,'','', '','$resultado_evaluacion', '$obse_juridico','','' )");				
				}
			elseif($termino_eva==6){
				$cambia_evaluacion = mysql_query("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones,resultado_hse,observaciones_hse,resultado_economico,observaciones_economico,resultado_experiencias,observaciones_experiencias,resultado_certificados,observaciones_certificados)
				values ($id_invitacion_juri, $pv_id, '', '', '','',0,'','', '','', '','','','$resultado_evaluacion', '$obse_juridico','','' )");				
				}
			elseif($termino_eva==7){
				$cambia_evaluacion = mysql_query("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones,resultado_hse,observaciones_hse,resultado_economico,observaciones_economico,resultado_experiencias,observaciones_experiencias,resultado_certificados,observaciones_certificados)
				values ($id_invitacion_juri, $pv_id, '', '', '','',0,'','', '','', '','','','','','$resultado_evaluacion', '$obse_juridico' )");				
				}								
			elseif($termino_eva==2){
				
				$cambia_evaluacion = mysql_query("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '$resultado_evaluacion','$obse_juridico',0,'".$_FILES["soporte_avluacion"]["name"]."','', '' )");	
				
				if($_FILES["soporte_avluacion"]["tmp_name"]!="")
				
					{
						$id_p_ingre = id_insert();										
						carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$id_p_ingre."_2");
						echo $_FILES["soporte_avluacion"]["tmp_name"];
						
						}
				
				}
				
	
				
								
				
	
		}
		if($termino_eva==2)
			$ruta_recarga = "apertura_evaluacion_tecnica";
		else
			$ruta_recarga = "apertura_evaluacion_juridica";
		
			?>
            
            <script>
            	window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 20, 10, 18);
				//alert("El registro se guardo con exito")
				window.parent.ajax_carga('../aplicaciones/evaluacion/<?=$ruta_recarga;?>.php?pasa=<?=arreglo_pasa_variables($id_invitacion_juri);?>&termino_eva=<?=$termino_eva;?>&t=4','carga_resultados_principales')
			</script>
            
            <?

}

/*******************************************************************************************************************************/
//EVALUACION JURIDICA
/*******************************************************************************************************************************/

/*******************************************************************************************************************************/
//EVALUACION TECNICA
/*******************************************************************************************************************************/

if($accion=="evaluacion_tecnica")
	{
	$estado_p="";
	$estado_n="";
		foreach($_POST["evaluacion_tecnica"] as $id_evaluacion_enviada => $valor_obtenido)
		{//recorre la evaluacion obtenida
			
			if($valor_obtenido!=0){//si fue calificado
			$separa_id_evaluacion_enviada = explode("_",$id_evaluacion_enviada);
			
			$id_criterio = $separa_id_evaluacion_enviada[0];
			$valor_categoria = $separa_id_evaluacion_enviada[1];
			$valor_criterio = $separa_id_evaluacion_enviada[2];
			
			

$id_proceso_unit_te = explode("_",$id_evaluacion_enviada);
			$id_evaluacion_enviada_1=$id_proceso_unit_te[0];
				$busca_ob_evalu = mysql_fetch_row(mysql_query("select * from $t32 where evaluador1_id=$id_evaluacion_enviada_1 and pv_id=$pv_id"));	
					if($busca_ob_evalu[0]>=1)
						{
				 							 $cambia_observacion = "update $t32 set observacion = '".$_POST["observa_".$id_evaluacion_enviada_1]."' where evaluador1_id=$id_evaluacion_enviada_1 and pv_id=$pv_id";
					$sql_ob=mysql_query($cambia_observacion);

						}
					else{
											 $cambia_observacion = "insert into $t32 (evaluador1_id, pv_id, observacion) values ($id_evaluacion_enviada_1,$pv_id,'".$_POST["observa_".$id_evaluacion_enviada_1]."' )";
						$sql_ob=mysql_query($cambia_observacion);

					}

			echo $cambia_observacion;

			$participacion_criterio = ( ($valor_criterio*$valor_obtenido) / 100 );
			
			//echo $id_evaluacion_enviada." ".$participacion_criterio." ".$valor_obtenido."<br>";
				
				$busca_exite = traer_fila_row(query_db("select * from $t96  where evaluador1_id = $id_criterio and pv_id = $pv_id"));
				if($busca_exite[0]>=1){			
				
					$cambia_resultado = "update $t96 set resultado_evaluacion = $valor_obtenido , resultado_evaluacion_afectado = '$participacion_criterio' where evaluador1_id = $id_criterio and pv_id = $pv_id";
					$sql_ex = query_db($cambia_resultado);
					}
				else
					{
						echo "insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_evaluacion_enviada, '',0,'','','','$valor_obtenido', '$participacion_criterio' )";
						$insertar = query_db("insert into $t96 (pv_id, evaluador1_id, evaluador6_nombre, evaluador6_tamano, evaluador6_tipo, evaluador6_observaciones, evaluador6_fecha, resultado_evaluacion, resultado_evaluacion_afectado) values ($pv_id,$id_criterio, '',0,'','','','$valor_obtenido', '$participacion_criterio' )");
					
					}
					
			}//si fue calificado
			elseif($valor_obtenido==0)
				$estado_p+=1;
			
			
			
		}//recorre la evaluacion obtenida
		
		
			if($estado_p>=1){
				$resultado_evaluacion = "pendiente de evaluación";
				
				
				
			$busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";
			$busca_hist = traer_fila_row(query_db($busca_evaluacion));

			
			if($busca_hist[0]>=1){
					if($_FILES["soporte_avluacion"]["name"]!="")
				
					{
					$modifica_anexo_his = " ,documento = '".$_FILES["soporte_avluacion"]["name"]."'";
					carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$busca_hist[0]."_2");

						
						}


	    $cambia_evaluacion = query_db("update $t13 set resultado_tecnico  = '$resultado_evaluacion', observaciones_tecnico = '$obse_juridico' $modifica_anexo_his where evaluador10_id = $busca_hist[0]");
				
				
			}
			else{
/*				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '$resultado_evaluacion','$obse_juridico',0,'','', '' )");				
	*/	
				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '$resultado_evaluacion','$obse_juridico',0,'".$_FILES["soporte_avluacion"]["name"]."','', '' )");	
				if($_FILES["soporte_avluacion"]["tmp_name"]!="")
				
					{
						$id_p_ingre = id_insert();										
						carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$id_p_ingre."_2");
						echo $_FILES["soporte_avluacion"]["tmp_name"];
						
						}


			}
		
			?>
            
            <script>
            	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La evaluación se realizo con éxito', 20, 10, 18);
				//alert("* La evaluación se realizo con éxito");
				window.parent.ajax_carga('../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=<?=$id_invitacion_juri;?>&pv_id=<?=$pv_id;?>&calca=1','carga_evaluacion')				
			</script>
            
            <?
			
				}
			else{
				$resultado_evaluacion = "1";
			$busca_evaluacion = "select * from $t13 where proc1_id = $id_invitacion_juri and pv_id = $pv_id";
			$busca_hist = traer_fila_row(query_db($busca_evaluacion));
			
			if($busca_hist[0]>=1){
					if($_FILES["soporte_avluacion"]["name"]!="")
				
					{
					$modifica_anexo_his = " ,documento = '".$_FILES["soporte_avluacion"]["name"]."'";
					carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$busca_hist[0]."_2");
					$cambia_evaluacion = query_db("update $t13 set resultado_tecnico  = '', observaciones_tecnico = '$obse_juridico' $modifica_anexo_his where evaluador10_id = $busca_hist[0]");
			
						
						}

			}
			else
				{
				

				$cambia_evaluacion = query_db("insert into $t13 (proc1_id, pv_id, resultado_juridico, observaciones_juridicas, resultado_tecnico, observaciones_tecnico, adjudicado, documento, fecha_ajudicacion, observaciones)
				values ($id_invitacion_juri, $pv_id, '', '', '','$obse_juridico',0,'".$_FILES["soporte_avluacion"]["name"]."','', '' )");	
			
				if($_FILES["soporte_avluacion"]["tmp_name"]!="")
				
					{
						$id_p_ingre = id_insert();										
						carga_archivo($_FILES["soporte_avluacion"]["tmp_name"],"evaluaciones_admin/".$id_p_ingre."_2");
						echo $_FILES["soporte_avluacion"]["tmp_name"];
						
						}
				
				
						
				
				
				}
						
			?>
            
            <script>
            	window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Mensaje', 'La evaluación se realizo con éxito', 20, 10, 18);
				//alert("* La evaluación se realizo con éxito");
				window.parent.ajax_carga('../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=<?=$id_invitacion_juri;?>&pv_id=<?=$pv_id;?>&calca=1','carga_evaluacion')
				
			</script>
            
            <?				
				
				}			

}

/*******************************************************************************************************************************/
//EVALUACION TECNICA
/*******************************************************************************************************************************/


if($accion=="volver_publica")
	{
	
		$cambia = query_db("update $t15 set publica = 1 where pro7_id = $id_elimina")

		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se modificó con éxito', 20, 10, 18);
		//alert("* La aclaración se modificó con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}

if($accion=="volver_privada")
	{
	
		$cambia = query_db("update $t15 set publica = 0 where pro7_id = $id_elimina")

		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se modificó con éxito', 20, 10, 18);
		//alert("* La aclaración se modificó con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}

if($accion=="crea_pregunta_general_foro")
	{
	

		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
echo "insert into  $t16 (pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica,anexo) 

		values ($id_elimina, 2, ".$_SESSION["id_us_session"].", 0,'$fecha $hora', '".$_POST["p_foro_".$id_elimina]."',1,'".$_FILES["anexo_re_".$id_elimina]["name"]."' )";

		$cambia = query_db("insert into  $t16 (pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica,anexo) 
		values ($id_elimina, 2, ".$_SESSION["id_us_session"].", 0,'$fecha $hora', '".$_POST["p_foro_".$id_elimina]."',2,'".$_FILES["anexo_re_".$id_elimina]["name"]."' )");
		$id_p_archivo = id_insert();
			
		$cambia = query_db("update $t15 set publica = 1 where pro7_id = $id_elimina");		
			
			if($_FILES["anexo_re_".$id_elimina]["name"]!=""){			
				   carga_archivo($_FILES["anexo_re_".$id_elimina]["tmp_name"],"procesos_cartelera/".$id_p_archivo);
		   //$archiv_con = confirma_archivo($sube_archivo_size,"procesos_proveedores/".$id_cargue.".txt");
		   }
		
		$busca_pregunta_sie_publica = traer_fila_row(query_db("select * from pro7_cartelera where pro7_id = $id_elimina "));
		if( ($busca_pregunta_sie_publica[6]==0) && ( $busca_pregunta_sie_publica[7]==1) ){
			$busca_proveedor = explode("|",$busca_pregunta_sie_publica[2]);
			$complemto_p=" and $t8.pv_id = $busca_proveedor[0] ";
			$complemto_c=" and pv_id = $busca_proveedor[0] ";
			}
		if( ($busca_pregunta_sie_publica[6]==0) && ($busca_pregunta_sie_publica[7]==2)){
			$busca_proveedor = str_replace("|",",",$busca_pregunta_sie_publica[2]);
			$complemto_p=" and $t8.pv_id in ($busca_proveedor 0) ";
			$complemto_c=" and pv_id  in ($busca_proveedor 0) ";
			}
			
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1]." de acalaraciones ";
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id $complemto_p");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					//alertas_bitacora(1,$id_invitacion,$lp[0],"Respuesta en la cartelera de aclaraciones / notificaciones",0);
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$confirma_envio= envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);	
			registro_email_enviado_nuevo($id_invitacion, $lp[4], $asunto, $mensaje_envio,$confirma_envio,1,3,$id_p_archivo."|".$lp[0]);	
			
			}
			
			/****envio de correo a los contactos*/
			
				$busca_provee = query_db("select $t30.email_contacto, $t8.razon_social, $t8.email  from $t30,$t8 where
					$t30.pro1_id =  $id_invitacion and  $t8.pv_id = $t30.pv_id $complemto_p");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			$confirma_envio = envia_correos($lp[0],$asunto,$mensaje_envio,$cabesa);	
			registro_email_enviado_nuevo($id_invitacion, $lp[0], $asunto, $mensaje_envio,$confirma_envio,1,3,$id_p_archivo."|".$lp[0]);	
			
			}
			/****envio de correo a los contactos*/
			
			
			
			
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se envio con éxito', 20, 10, 18);
		//alert("* La aclaración se envio con éxito")
		window.parent.ajax_carga('cartelera-aclaraciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}	

if($accion=="crea_pregunta_general_admin")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		
		$cuantos = count($pv_id_carte);
		if($cuantos==0)
			{ ?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* ¡Seleccione un proveedor por lo menos!', 20, 10, 18);
				//alert("* Seleccione un proveedor por lo menos !")
                //window.parent.document.getElementById("cargando").style.display="none"
                </script>
                
				
				<? exit();
				}
		foreach($pv_id_carte as $id_pro){
			$pv_id_p_c.=$id_pro."|";
			$pv_id_p_corr.=$id_pro.",";
			}

	
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		$cambia = query_db("insert into  $t15 (pro1_id ,pv_id ,fecha_pregunta ,pregunta ,us_id ,publica,tipo_aclaracion,tipo_aclaracio,fecha_maxima_respuesta,tipo_aclaracion_solicitada,anexo) 
		values ($id_invitacion, '".$pv_id_p_c."','$fecha $hora', '$pregunta_general',".$_SESSION["id_us_session"].",0,2,2,'$h_m_r',0,'".$_FILES["anexo_re_general"]["name"]."' )");
		$id_p_archivo = id_insert();
		if($_FILES["anexo_re_general"]["name"]!=""){			
			carga_archivo($_FILES["anexo_re_general"]["tmp_name"],"procesos_cartelera/c_g_".$id_p_archivo);	
		}


			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1]." de comunicados ";
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp5,$sql_e[5],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('--consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id in ($pv_id_p_corr 0)");
		
				while($lp = traer_fila_row($busca_provee)){
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					alertas_bitacora(2,$id_invitacion,$lp[0],"Nueva notificación",0);
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			
			$confirma_envio=envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);		
			registro_email_enviado_nuevo($id_invitacion, $lp[4], $asunto, $mensaje_envio,$confirma_envio,1,4,$id_p_archivo."|".$lp[0]);
					
					
					/****envio de correo a los contactos - real verificada*/
					$graba_correo_pro.="<li>".$lp[4]."</li>";
					$graba_correo_pro2.=$lp[4].", ";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						$confirma_envio= envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto, $mensaje_envio,$confirma_envio,1,4,$lp[0]);
						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos
					
					/****envio de correo a los contactos - real verificada*/
					
					auditor(27,$id_invitacion,$lp[2]." | Se envio email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
					
					
						
			
			}
			
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
								while($destinatario = traer_fila_row($busca_dueno)){
								$confirma_envio=envia_correos($destinatario[0],$asunto,$mensaje_envio,$cabesa);
								registro_email_enviado_nuevo($id_invitacion, $destinatario[0], $asunto, $mensaje_envio,$confirma_envio,1,4,0);
								//echo $destinatario[0];

								}
			
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se envio con éxito', 20, 10, 18);
		//alert("* La aclaración se envio con éxito")
		window.parent.ajax_carga('cartelera-comunicaciones_<?=$id_invitacion;?>.php','contenidos');
	</script>

          <?
	
	}



if($accion=="Guardar_formula")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));


		$select_formula = traer_fila_row(query_db("select * from $t18 where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula "));
		
	if($tipo_formula==1){		
		if($select_formula[0]>=1)
			{
				$update = query_db("update $t18 set formula='$formula_1' ,nombre='$nombre_formula' ,min='$formula_2' ,max='$formula_3' where pro10_id = $select_formula[0]");
			
			}
		else
			{

					$update = query_db("insert into $t18 (pro1_id, formula,nombre, min, max, tipo_formula, pro11_id )values ($id_invitacion, '$formula_1','$nombre_formula','$formula_2','$formula_3', $tipo_formula, $id_lista )");
			
			}
		
		}
	else
	{
	
	if($select_formula[0]>=1)
			{
				$update = query_db("update $t18 set formula='$formula_4' ,nombre='$nombre_formula2' ,min='0' ,max='0' where pro10_id = $select_formula[0]");
			
			}
		else
			{

					$update = query_db("insert into $t18 (pro1_id, formula,nombre, min, max, tipo_formula, pro11_id )values ($id_invitacion, '$formula_4','$nombre_formula2','0','0', $tipo_formula, $id_lista )");
			
			}
	
	}
		if($id_lista!=0)
			$ruta = "configuracion_criteriosec_".$id_vari."_".$id_lista.".html";
		else
			$ruta = "configuracion_formulas_".$id_invitacion.".html";
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La formula se guardo con éxito', 20, 10, 18);
		//alert("* La formula se guardo con éxito")
		window.parent.ajax_carga('<?=$ruta;?>','contenidos');
	</script>

          <?
	
	}	
	
	
if($accion=="elimina_formula")
	{

			$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));


				$update = query_db("delete from $t18  where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula ");
		
		  
if($id_lista!=0)
			$ruta = "configuracion_criteriosec_".$id_vari."_".$id_lista.".html";
		else
			$ruta = "configuracion_formulas_".$id_invitacion.".html";
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La formula se elimino con éxito', 20, 10, 18);
		//alert("* La formula se elimino con éxito")
		window.parent.ajax_carga('<?=$ruta;?>','contenidos');
	</script>

          <?		  
	
	}		


if($_POST["accion"]=="crear_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		echo $inserta_procesos="insert into $t19 (pro1_id,nombre )
		values ($id_invitacion, '$nombre_lista')";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		
		
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_p;?>.html','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proceso NO se creó con éxito', 20, 10, 18);
        </script>
		<?
		
		
		}
	
	}
	
	
if($_POST["accion"]=="editar_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		echo $inserta_procesos="update $t19 set nombre = '$edita_lista', requiere_aui = $requiere_aui where pro11_id = $id_lista ";
		$sql_e = query_db($inserta_procesos);
		?>
        <script>
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se edito con éxito', 20, 10, 18);
		//alert("El proceso se edito con éxito")
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_lista;?>.html','contenidos');
		</script>
        <?
		
		
	}	
	
if($_POST["accion"]=="elimina_lista")
	{
	
		$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$inserta_procesos="delete from $t19 where pro11_id = $id_lista ";
		$sql_e = query_db($inserta_procesos);

		$update = query_db("delete from $t18  where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula = $tipo_formula ");
		
		auditor(28,$id_invitacion,"","");
		
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se edito con éxito', 20, 10, 18);
		//alert("El proceso se edito con éxito")
		window.parent.ajax_carga('configuracion_criteriosec_<?=$id_vari;?>_<?=$id_lista;?>.html','contenidos');
		</script>
        <?
		
		
	}		



	if($_POST["accion"]=="adjudica_proceso")
	
	{
			echo $id_invitacion_pasa_original = $id_invitacion_adjudicacion;
			$id_invitacion_pasa = elimina_comillas(arreglo_recibe_variables($id_invitacion_pasa));
			$id_invitacion_pasa =$id_invitacion_pasa_original;
	
		/*	foreach($proveedores_sele as $id_proveedor){
			$id_proveedor_seleccionado.=",".$id_proveedor;
		}
		*/
	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_pasa and $t8.pv_id = $t7.pv_id ");
				while($lp = traer_fila_row($busca_provee))
				$id_proveedor_seleccionado.=",".$lp[0];	
		
		$id_proveedor_seleccionado = "0".$id_proveedor_seleccionado;
		
		if($b==10){// si es dupicacioon
		$cuenta_duplicidades = traer_fila_row(query_db("select count(*) from $t5 where origen_duplicidad = $id_invitacion_pasa"));
		$incremento = ($cuenta_duplicidades[0]+1);

		echo $insert_duli_principal = "insert into $t5 (select NULL,9,	tp2_id,	tp3_id,	tp4_id,	tp5_id,	cd_id_ejecucion,	cd_id_entrega_documentos,	direccion_entrega_documentos,	cd_id_entrega_ofertas,	direccion_entrega_ofertas,	tp6_id,	detalle_objeto,	tp7_tipo_moneda,	cuantia,	us_id_contacto,	fecha_publicacion,	fecha_apertura,	fecha_cierre,	peso_tecnico,	minimo_tecnico_solicitado,	peso_economico,	concat(consecutivo,' DU - ', $incremento),	apertura_juridica,	cierre_juridica,	apertura_tecnica,	cierre_tecnica,	apertura_economica,	cierre_economica,	fecha_informativa,	lugar,	'0',	fecha_creacion,	us_id,	fecha_informativa_final,	fecha_aclaraciones_2_inicial,	fecha_aclaraciones_2_final,	fecha_aclaraciones_3_inicial,	fecha_aclaraciones_3_final,	fecha_preconomica_inicial,	fecha_preconomica_final,	nueva_fecha_informativa,	trm_actual, $id_invitacion_pasa, us_id_otro_contacto, confirma_objeto, t1_area_id from $t5
		 where pro1_id = $id_invitacion_pasa)";
		$sql_ex=query_db($insert_duli_principal);
		$id_p = id_insert();
		if($id_p>=1){//si el registro principal se duplico
		
		$duplica_proveedores=query_db("insert into $t7 (select NULL, $id_p,	pv_id,lectura_proceso,aceptacion_participacion,	estado,observaciones,observaciones_2 from $t7 where pro1_id = $id_invitacion_pasa )");

$duplica_documentos = mysql_query("select * from $t6 where pro1_id = $id_invitacion_pasa");
		while($lis_documentos = traer_fila_row($duplica_documentos))
			{
				
				$insert_docu = mysql_query("insert into $t6 ( pro1_id, tp8_id, archivo, peso, fecha_carga, estado,origen,tipo_archivo,id_origen)  values (
				$id_p,$lis_documentos[2],'$lis_documentos[3]',$lis_documentos[4],'$fecha $hora',1,$lis_documentos[7],'$lis_documentos[8]',$lis_documentos[9])");
				$id_documento = id_insert();
				if($id_documento>=1)
					{
					
						$copia_documento = copy(SUE_PATH_ARCHIVOS."pecc/".$lis_documentos[0]."_".$lis_documentos[7].".txt",SUE_PATH_ARCHIVOS."pecc/".$id_documento."_".$lis_documentos[7].".txt");
						
						echo SUE_PATH_ARCHIVOS."pecc/".$id_documento.".txt<br>";
						echo SUE_PATH_ARCHIVOS."pecc/".$lis_documentos[0].".txt";
					
					}
				
			
			}
			
			
				$duplica_criterios_cat=mysql_query("insert into $t12 (select '', $id_p,	rel9_id,porcentaje,	estado_configuracion from $t12 where proc1_id = $id_invitacion_pasa )");
				$duplica_criterios=mysql_query("insert into $t91 (select '', $id_p,	rel10_id,evaluador1_valoresperado,	termino from $t91 where in_id = $id_invitacion_pasa )");




		$cambia_estado_origen=query_db("update $t5 set tp1_id = $b where pro1_id = $id_invitacion_pasa ");
		$sql_ex_no_ad = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) 
					values ($id_invitacion_pasa,0,0,4,".$_SESSION["id_us_session"].",'$fecha $hora', 1, '".$comentarios_no_adjudica."')";
					$sql_ex_no_ad1=query_db($sql_ex_no_ad);
		
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se grabo con éxito', 20, 10, 18);
		window.parent.ajax_carga('historico-proceso_0.html','contenidos');
		</script>
        
        <?
			
			/*actualiza proceso solicitud*/
		$sel_proceso_urna = mysql_fetch_array(mysql_query("select cd_id_entrega_documentos  from pro1_proceso where pro1_id = $id_invitacion_pasa"));
		$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
		$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
		$select_item = mssql_query("update t2_item_pecc set estado = '12.1' where id_item = ".$sel_proceso_urna[0]);
		$select_item = mssql_query("update t2_nivel_servicio_gestiones set estado = 2 where id_item = ".$sel_proceso_urna[0]." and t2_nivel_servicio_actividad_id > 12 and t2_nivel_servicio_actividad_id <=14");
		
		/*Fin actualiza proceso en solicitudes*/
		
		}//si el registro principal se duplico
		
		}// si es dupicacioon
		elseif($b==7)
			{
			$cambia_estado_origen=query_db("update $t5 set tp1_id = $b where pro1_id = $id_invitacion_pasa ");
			
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_pasa";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 12"));
		 	$asunto_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[1] );
			
			$asunto_arrglo = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );
			$asunto_arrglo = str_replace("---estado_proceso---",listas_sin_select($tp1,$sql_e[1],1), $asunto_arrglo );

			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace("---estado_proceso---",listas_sin_select($tp1,$sql_e[1],1), $id_subastas_arrglo );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_apertura---',fecha_for_hora($sql_e[17]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($sql_e[18]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---objeto_contratar---', listas_sin_select($tp6,$sql_e[11],1), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---detalle_contratar---', $sql_e[12], $id_subastas_arrglo);

		

			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion_pasa and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores
				$graba_correo_pro2="";
							

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					
					$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
					$confirma_envio=envia_correos($lp[4],$asunto_arrglo,$mensaje_envio,$cabesa);
					registro_email_enviado_nuevo($id_invitacion_pasa, $lp[4], $asunto_arrglo, $mensaje_envio,$confirma_envio,1,8,$lp[0]);
					//alertas_bitacora(8,$id_proceso,$lp[0],"",0);
					
					$sql_ex_no_ad = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) 
					values ($id_invitacion_pasa,0,$lp[0],4,".$_SESSION["id_us_session"].",'$fecha $hora', 1, '".$comentarios_no_adjudica."')";
					$sql_ex_no_ad1=query_db($sql_ex_no_ad);
					
					$graba_correo_pro.="<li>".$lp[4]."</li>";
					$graba_correo_pro2.=$lp[4].", ";
						
					$busca_provee_contactos = query_db("select distinct email, contacto from v_relacion_contactos_procesos where pro1_id = $id_invitacion_pasa and pv_id =$lp[0]");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						 $confirma_envio=envia_correos($lp_contactos[0],$asunto_arrglo,$mensaje_envio,$cabesa);
						 registro_email_enviado_nuevo($id_invitacion_pasa, $lp_contactos[0], $asunto_arrglo, $mensaje_envio,$confirma_envio,1,8,$lp[0]);
						
						$graba_correo_pro.="<li>".$lp_contactos[0]."</li>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos
						
						auditor(27,$id_invitacion_pasa,$lp[2]." | Se envio email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
						}// provvedores

			/****envio de correo a los contactos*/
			
			
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 13"));
		 	$asunto_arrglo = str_replace("---estado_proceso---",listas_sin_select($tp1,$sql_e[1],1), $busca_correo[1] );
			$asunto = str_replace("---consecutivo---",$sql_e[22], $asunto_arrglo );
			
			$id_subastas_arrglo = str_replace("---proceso---",listas_sin_select($tp2,$sql_e[2],1), $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('----lista_email---', $graba_correo_pro, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---estado_proceso---', listas_sin_select($tp1,$sql_e[1],1), $id_subastas_arrglo);			
			
			
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
				while($destinatario = traer_fila_row($busca_dueno)){
				$confirma_envio=envia_correos($destinatario[0],$asunto,$id_subastas_arrglo,$cabesa);
				registro_email_enviado_nuevo($id_invitacion_pasa, $destinatario[0], $asunto, $id_subastas_arrglo,$confirma_envio,1,8,0);
				//echo $destinatario[0];
			
			}
			
			?>
                  <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se grabo con éxito..', 20, 10, 18);
		//alert("El proceso se grabo con éxito..")
		window.parent.ajax_carga('historico-proceso_0.html','contenidos');
		</script>
                <?
			
			
			
			}//si es declarado desierto
			
			else{ //para el resto
				$cambia_estado_origen=query_db("update $t5 set tp1_id = $b where pro1_id = $id_invitacion_pasa ");
				$sql_ex_no_ad = "insert into $t46 (pro1_id, pro27_id, pv_id, tipo_adj_no_adj, us_id, fecha_envio, notificado, observacion_admin) 
					values ($id_invitacion_pasa,0,0,4,".$_SESSION["id_us_session"].",'$fecha $hora', 1, '".$comentarios_no_adjudica."')";
					$sql_ex_no_ad1=query_db($sql_ex_no_ad);
				?>
                  <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se grabo con éxito', 20, 10, 18);
		window.parent.ajax_carga('historico-proceso_0.html','contenidos');
		</script>
                <?
				}			
		
		
	}		

if($_POST["accion_apertura"]=="graba_apertura")
	{
	
		$id_vari=$id_invitacion_apertura;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
		
		if($cuantia_pasa>=100000)
			$usuario_firma_gere= "Hugo Fernando Molina Pedroza";
		
				if($responsable_pro==603)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==620)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==619)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==618)
					$usuario_firma= "Viviana Ramirez Medina";
				elseif($responsable_pro==621)
					$usuario_firma= "Javier Acosta";
				elseif($responsable_pro==580)
					$usuario_firma= "Javier Acosta";
				else
					$usuario_firma= "Viviana Ramirez Medina";					
		
		

		$inserta_procesos=query_db("insert into pro12_apertura_proceso (pro1_id, us_auditor, us_comprador, us_usuario, fecha_apertura, hora_apertura, lugar_apertura, estado)
		values ($id_vari,".$_SESSION["id_us_session"].",$responsable_pro,'$usuario_firma','$fecha','$hora','$usuario_firma_gere',1 )");
		$sql_e = query_db($inserta_procesos);

		foreach($proponente as $id_proveedor => $observaciones)
			{
				$observaciones = query_db("update pro3_invitaciones set observaciones = '$observaciones' where pro1_id = $id_vari and pv_id = $id_proveedor ");
			
			}

		foreach($v_proponente as $id_proveedor_v => $observaciones_2)
			{
				$observaciones = query_db("update pro3_invitaciones set observaciones_2 = '$observaciones_2' where pro1_id = $id_vari and pv_id = $id_proveedor_v ");
			
			}

		
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se grabo con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_vari;?>','contenidos');
		</script>
        <?
		
		
	}	

if($_POST["accion"]=="confirma_acta_apertura")
	{
	
		$id_vari=$id_invitacion_pasa;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

		$inserta_procesos="update pro12_apertura_proceso set estado = 1 where pro1_id=$id_invitacion";
		$sql_e = query_db($inserta_procesos);
	
		
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se abrio con éxito', 20, 10, 18);
		//alert("El proceso se abrio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos');
		</script>
        <?
		
	
	}


if($accion=="crea_bitacora")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion);
		
		$cambia = query_db("insert into  $t26 (pro1_id,pv_id,us_id, fecha_hora_gestion,detalle_gestion,proxima_llamada,tp14_id) 
		values ($id_invitacion,".$pv_id_b.",".$_SESSION["id_us_session"].",'$fecha $hora', '$pregunta_general','$h_m_r', $efectividad_bita )");
		
		if($nombre_contacto!="")
			$inserta_contacto=query_db("insert into $t30 (pro1_id, pv_id, nombre_contacto, email_contacto, telefono_contacto) values (
			$id_invitacion, $pv_id_b, '$nombre_contacto','$email_contacto', '$telefono_contacto') ");
			
		foreach($alerta_pendientes as $id_alerta_bitacora => $valor)
			{
				if($valor==2)
					$cambia_estado_alerta=query_db("update $t29 set estado = 2, quien_ingresa='Mesa ayuda' where pro18_id = $id_alerta_bitacora");
			
			}	
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La bitácora se creo con éxito', 20, 10, 18);
		//alert("* La bitácora se creo con éxito")
		window.parent.ajax_carga('../aplicaciones/c_bitacora.php?id_invitacion_pasa=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
	</script>

          <?
	
	}

if($accion=="crea_pregunta_aclaracion_final")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
		
		$cuantos = count($pv_id_carte);
		if($cuantos==0)
			{ ?>
				<script>
				window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un proveedor por lo menos', 20, 10, 18);
				//alert("* Seleccione un proveedor por lo menos !")
                window.parent.document.getElementById("cargando").style.display="none"
                </script>
                
				
				<? exit();
				}
		
		foreach($pv_id_carte as $id_pro){// busca proveedor for
			
			
		$cambia = query_db("insert into  $t27 (pro1_id ,pv_id ,us_id, fecha_solicitud,fecha_limite_respuesta, objeto, detalle ,leida,anexo) 
		values ($id_invitacion_ar, '".$id_pro."',".$_SESSION["id_us_session"].",'$fecha $hora', '$h_m_r','".elimina_comillas_2($asunto_cartelera)."','".elimina_comillas_2($pregunta_general)."',1,'".$_FILES["anexo_re_general"]["name"]."')");
		$id_p_archivo = id_insert();
		
		if($_FILES["anexo_re_general"]["name"]!=""){			
			carga_archivo($_FILES["anexo_re_general"]["tmp_name"],"procesos_cartelera/c_a_f_a_".$id_p_archivo);	
		}
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---"," ", $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8 where
				 $t8.pv_id = $id_pro");
		
				$lp = traer_fila_row($busca_provee);
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);

			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			
			//alertas_bitacora(4,$id_invitacion_ar,$lp[0],"Nueva aclaración final",0);
			
			$confirma_envio = envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);	
			
			registro_email_enviado_nuevo($id_invitacion_ar, $lp[4], "Solicitud de aclaración final", $mensaje_envio,$confirma_envio,1,5,$id_p_archivo."|".$lp[0]);
				
			
/****envio de correo a los contactos*/
			
			$busca_email_contacto = query_db("select email  from pv_contactos where pv_id = ".$lp[0]." and estado = 1 ");
				while($lis_contactos = traer_fila_row($busca_email_contacto)){
						
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			$confirma_envio = envia_correos($lis_contactos[0],$asunto,$mensaje_envio,$cabesa);	
			registro_email_enviado_nuevo($id_invitacion_ar, $lis_contactos[0], "Solicitud de aclaración final", $mensaje_envio,$confirma_envio,1,5,$id_p_archivo."|".$lp[0]);
			
				}
	
			
			
/****envio de correo a los contactos*/
			


		}// busca proveedor for
		
		
			$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33],$sql_e[44])");
								while($destinatario = traer_fila_row($busca_dueno)){
								$confirma_envio=envia_correos($destinatario[0],$asunto,$mensaje_envio,$cabesa);
								registro_email_enviado_nuevo($id_invitacion_ar, $destinatario[0], "Solicitud de aclaración final", $mensaje_envio,$confirma_envio,1,5,$id_p_archivo."|".$lp[0]);
								

								}
			
		
		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se envio con éxito', 20, 10, 18);
		//alert("* La aclaración se envio con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion_ar);?>','carga_resultados_principales');
	</script>

          <?
	
	}


if($accion=="modifica_fecha_limite_final")
	{
		$id_invitacion_ar = arreglo_recibe_variables($id_invitacion_pasa);
		
			
	echo 	$sql_quer = "update $t27 set fecha_limite_respuesta = '$h_m_r_modifica' where pro16_id = $id_pregunta ";	
		$cambia = query_db($sql_quer);
//		$id_p_archivo = id_insert();
		
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion_ar";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 6"));
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			
			$id_subastas_arrglo = str_replace("---proceso---"," ", $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $id_subastas_arrglo);

		
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8 where
				 $t8.pv_id = $id_pro");
		
				$lp = traer_fila_row($busca_provee);
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);

			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			
			//alertas_bitacora(4,$id_invitacion_ar,$lp[0],"Nueva aclaración final",0);
			
			$confirma_envio = envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);	
			
			registro_email_enviado_nuevo($id_invitacion_ar, $lp[4], "Solicitud de aclaración final", $mensaje_envio,$confirma_envio,1,5,$id_p_archivo."|".$lp[0]);
				
			
/****envio de correo a los contactos*/
			
			$busca_email_contacto = query_db("select email  from pv_contactos where pv_id = ".$lp[0]." and estado = 1 ");
				while($lis_contactos = traer_fila_row($busca_email_contacto)){
						
			
					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$id_subastas_arrglo_usuario = str_replace('---usuario---', $lp[4], $id_subastas_arrglo_usuario);
					
			
			$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
			
			$confirma_envio = envia_correos($lis_contactos[0],$asunto,$mensaje_envio,$cabesa);	
			registro_email_enviado_nuevo($id_invitacion_ar, $lis_contactos[0], "Solicitud de aclaración final", $mensaje_envio,$confirma_envio,1,5,$id_p_archivo."|".$lp[0]);
			
				}
	
			
			
/****envio de correo a los contactos*/
			



		?>
      <script>
      	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'La aclaración se modificó con éxito', 20, 10, 18);
		//alert("* La aclaración se modificó con éxito")
		window.parent.ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion_ar);?>','carga_resultados_principales');
	</script>

          <?
	
	}



if($accion == "crea_proveedor_adentro")
	{
		
		$verifica_email = comprobar_email($email_contacto);
		if($verifica_email=="0"){
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Verifique el e-mail', 20, 10, 18);
					//alert("Verifique el e-mail")
					 //window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}
		

		
		$bsca_si_exi=traer_fila_row(query_db("select * from $t8 where nit='$ap'"));

		if($bsca_si_exi[0]>=1){
			?>
            	<script>
            		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El proveedor ya existe', 20, 10, 18);
					//alert("El proveedor ya existe")
					 window.parent.document.getElementById("cargando").style.display="none"
					
				</script>
            <?
			exit();
			}		

$cifra_c=md5("321654");
		
$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

		function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }	


 $alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");

for($i=0;$i<=3;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
}

if($ap=="")
	$ap = $fuente2;

$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
echo $inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values ('$ap', '', '$bp',1)";
$sql_ex=mssql_query($inserta_us.$trae_id_insrte);
$id_ingreso_pro = id_insert_sql_ser($sql_ex);

if($id_ingreso_pro>=1){//si se creo el proveedor

		$cambia_cali="insert into  $t8 (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,$ciuadad, '$ap', '$bp', '$cp','$email_contacto', '$ep', 1, '$g' )";
		 $sql_ex = query_db($cambia_cali);

$inserta_email_sgpa=mssql_query("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
'PRINCIPAL','$email_contacto',1,1)");

	  $inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ('$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_ex_p=mssql_query($inserta_us.$trae_id_insrte);
$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);
		
if($id_ingreso_pro_us>=1){//si se creo el usuario		
		 
	  $inserta_us = "insert into $t1 (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ($id_ingreso_pro_us,'$bp', '$email_contacto', '$cifra_c', '$email_contacto', '$ep',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_e=query_db($inserta_us);

}
	
		 $inserta_procesos="insert into $t7 (pro1_id,pv_id,lectura_proceso,aceptacion_participacion,estado)
		  values (".$id_invitacion_pasa_final.", $id_ingreso_pro,'', 'N/A', 1  )";
		$sql_e = query_db($inserta_procesos);
		 
	?>
	 	<script>
	 		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se creo con éxito', 20, 10, 18);
			//alert("El registro se creo con éxito")
			//window.parent.volver_listado('muestra_cootactos','carga_detalle_pro')
			window.parent.ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa_final;?>','contenidos');
		</script>
	<?

		 
}////si se creo el proveedor
		
		else{ //si no se creo el proveedor
	?>
	 	<script>
	 		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* El PROVEEDOR NO SE PUDO CREAR VERIFIQUE QUE NO EXISTA', 20, 10, 18);
			//alert("ATENCION: El PROVEEDOR NO SE PUDO CREAR VERIFIQUE QUE NO EXISTA")
			return;
		</script>
	<?		
		
		}	//si no se creo el proveedor
		 


		
		}

if($_POST["accion"]=="elimina_proceso_sin_abrir")
	{
	
		echo $inserta_procesos="update $t5 set tp1_id = 1000 where pro1_id = $id_limpia";
		$sql_e = query_db($inserta_procesos);
		
			/***INSERTA CONCTATOS DEL PROVEEDOR AL PROCESO*/
					
		
		?>
        <script> 
        window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se elimino con éxito', 20, 10, 18);
		//alert("El proceso se elimino con éxito")
		window.parent.ajax_carga('historico-proceso_0.html','contenidos');
		</script>
        <?
	
	}	



echo $_POST["accion"];

if($_POST["accion"]=="poner_firme_evaluacion_tecnica"){

 		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_invitacion_pasa));
		
		if($_POST["numero_proveedores_evaluar_pasa"]!=$_POST["numero_proveedores_ya_evaluador_pasa"])
			{
				auditor(57,$id_invitacion,"Faltan proveedores por evaluar", "");
				?>
				<script>
					window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Para poner la evaluación técnica en firme primero debe evaluar todos los proveedores', 40, 8, 12);
					
					window.parent.document.getElementById("cargando").style.display="none"
				</script>
				<?
				exit();
				}
		
		
		$inserta_procesos="update evaluador11_proveedores_con_oferta_tec set estado = 2 where pro1_id=$id_invitacion";
		$sql_e = query_db($inserta_procesos);
	
	?>
    	<script>
			
			
				var forma = window.parent.document.principal
					
					forma.target="grp_urna";
					forma.action = "../../librerias/php/funcion_urna_sgpa.php";
					forma.accion.value="graba_gestion_tecnmmico";
					forma.contiene_tecnico.value="1"
					forma.submit()
					/*
					forma.target="";
					forma.action = "";
					forma.accion.value="";
					location.href="";
					*/
		</script>

    <?

			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 20"));
			$asunto = str_replace("---consecutivo---",$sql_e[22], $busca_correo[1] );
			

			$cuerpo_confirmacion_envio = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			

		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33], $sql_e[44],17)");
		while($destinatario = traer_fila_row($busca_dueno)){
			$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo($id_invitacion, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,15,0);
			
			}
			auditor(56,$id_invitacion,"", "");
?>
		<script>
			//window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se genero con exito', 20, 10, 18);
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'La Evaluación se Puso en Firme con Éxito', 20, 10, 18);
			//alert('El registro se genero con exito')
			window.parent.ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=$id_invitacion_pasa;?>','carga_resultados_principales')
		</script>
<?
  
} //funcion cambia estado abre economica fin evali¿uacion tecnica


if($_POST["accion"]=="devolver_poner_firme_evaluacion_tecnica"){

 $id_invitacion = elimina_comillas(arreglo_recibe_variables($id_invitacion_pasa));

		$inserta_procesos="update evaluador11_proveedores_con_oferta_tec set estado = 1 where pro1_id=$id_invitacion";
		$sql_e = query_db($inserta_procesos);
		
		$inserta_gestion = "insert into pro36_devolucion_tecnica (pro1_id, us_id, fecha_gestion, comentarios_dev) values ($id_invitacion,".$_SESSION["id_us_session"].", '$fecha $hora', '$come_devolucion' )";
		$sql_e = query_db($inserta_gestion);
 auditor(58,$id_invitacion,$come_devolucion, "");
	?>
		<script>
			window.parent.muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'La Evaluación se Puso en Firme con Éxito', 20, 10, 18);
			//alert('El registro se genero con exito')
			window.parent.ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=$id_invitacion_pasa;?>','carga_resultados_principales')

			/*
			window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se genero con exito', 20, 10, 18);
			//alert('El registro se genero con exito')
			window.parent.ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=< ?=$id_invitacion_pasa;?>','carga_resultados_principales')
			*/
		</script>
<?
	
	?>
    	<script>
				/****************** PARA DEVOLVER EL ESTADO EN LA SULICITUD ************/
			var forma = window.parent.document.principal
					forma.target="grp_urna";
					forma.action = "../../librerias/php/funcion_urna_sgpa.php";
					forma.accion.value="graba_gestion_apertura";
					forma.contiene_tecnico.value="1"
					forma.submit()
					forma.target="";
					forma.action = "";
					forma.accion.value="";
					location.href="";
		</script>

    <?
	

			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 22"));
			$asunto = str_replace("---consecutivo---",$sql_e[22], $busca_correo[1] );
			

			$cuerpo_confirmacion_envio = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			$cuerpo_confirmacion_envio = str_replace('---detalle_devolucion---', $come_devolucion, $cuerpo_confirmacion_envio);
			
			

		echo $busca_encargado_tecnico = "select us_id from pro6_observadores_procesos where pro1_id = $id_invitacion  and tipo = 2";
	 $sql_busca_encargado_tecnico = traer_fila_row(query_db($busca_encargado_tecnico));
						


		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_busca_encargado_tecnico[0])");
		while($destinatario = traer_fila_row($busca_dueno)){
			$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo($id_invitacion, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,17,0);
			
			}



  
} //funcion cambia estado abre economica fin evali¿uacion tecnica



if($_POST["accion"]=="creacion_extratiempo")
	{
		 $msg ="";
		
echo $_POST["accion"];
		if($_POST["fecha_cierre_extratiempo"]==""){
			$msg1 = " * La fecha de cierre de la solicitud  ";	
			$msg=1;
			$err_js.="forma.fecha_cierre_extratiempo.className = 'campos_faltantes';";	
			
			}
		if($_POST["observaciones_extratiempo"]==""){
			$msg2 = " * Digite el Comentarios de la solicitud de oferta extemporánea a este proveedor";	
			$msg=1;
			$err_js.="forma.observaciones_extratiempo.className = 'campos_faltantes';";	
			}			
		if($_POST["numero_aprobacion"]==""){
			$msg3 = " * Digite el numero de aprobacion";	
			$msg=1;
			$err_js.="forma.numero_aprobacion.className = 'campos_faltantes';";	
			}			
		if($_POST["nivel_aprobacion"]==""){
			$msg4 = " * Digite el nivel de aprobacion";	
			$msg=1;
			$err_js.="forma.nivel_aprobacion.className = 'campos_faltantes';";	
			}			
		if($_POST["observaciones_extratiempo_cuerpo"]==""){
			$msg5 = " * Digite Detalle de la solicitud al Proponente (Este texto en el cuerpo del email a que se enviara al proveedor)";	
			$msg=1;
			$err_js.="forma.observaciones_extratiempo_cuerpo.className = 'campos_faltantes';";	
			}			

		if($msg==""){//si esta dodo digtado
		
		$cambia_estado = "update pro35_ampliaciones_extratiempos set estado_extratiempo = 2 where pro1_id =  $id_invitacion and pv_id = $pv_id_b";
		$sql_excute = query_db($cambia_estado);
		
		$inserta_procesos="insert into pro35_ampliaciones_extratiempos (pro1_id, pv_id, fecha_apertura, fecha_cierre, obeservaciones,anexo, estado_extratiempo, us_id, fecha_creacion,numero_aprobacion,nivel_aprobacion,texto_email)
		 values ($id_invitacion, $pv_id_b,'', '".$_POST["fecha_cierre_extratiempo"]."','".$_POST["observaciones_extratiempo"]."','".$_POST["anexos_s"]."',1,".$_SESSION["id_us_session"].", '$fecha $hora','".$_POST["nivel_aprobacion"]."','".$_POST["numero_aprobacion"]."','".$_POST["observaciones_extratiempo_cuerpo"]."' )";
		$sql_e = query_db($inserta_procesos);
		$id_p = id_insert();
		if($id_p>=1){
		auditor(50,$id_invitacion,"Proveedor: ".$_POST["nombre_proee_t"].", fecha de cierre: ".$_POST["fecha_cierre_extratiempo"]." id proveedor: $pv_id_b " , $pv_id_b);
				
			$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
			$sql_e=traer_fila_row(query_db($busca_procesos));
			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 18"));
		 	
			$asunto = str_replace("---consecutivo---",$sql_e[22], $busca_correo[1] );
			

			$id_subastas_arrglo = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			$id_subastas_arrglo = str_replace('---fecha_cierre---', fecha_for_hora($_POST["fecha_cierre_extratiempo"]), $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---detalle_contratar---', $_POST["observaciones_extratiempo_cuerpo"], $id_subastas_arrglo);

			$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);

			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id = $pv_id_b ");
				while($lp = traer_fila_row($busca_provee)){// proveedores
				$graba_correo_pro2="";
					$busca_contrasena="select * from t1_us_usuarios where pv_id = $lp[0]";
					$busca_si_proveedor_cambia_cot= mssql_fetch_row(mssql_query($busca_contrasena));
							

					$id_subastas_arrglo_usuario = str_replace("---proveedor---",$lp[2], $id_subastas_arrglo);
					$nombre_proveedor_princi = $lp[2];
					$graba_correo_pro = $lp[4]."</br>";
				
					
					$mensaje_envio = $id_subastas_arrglo_usuario."<br>";
					$confirma_envio= envia_correos($lp[4],$asunto,$mensaje_envio,$cabesa);
					registro_email_enviado_nuevo($id_proceso, $lp[4], $asunto, $mensaje_envio,$confirma_envio,1,14,$lp[0]);
				//alertas_bitacora(8,$id_proceso,$lp[0],"",0);

					
					$graba_correo_pro2.=$lp[4].", ";
					
					echo "select distinct email, contacto from pv_contactos where  pv_id =$lp[0] and estado = 1";	
					$busca_provee_contactos = query_db("select distinct email, contacto from pv_contactos where  pv_id =$lp[0] and estado = 1");
						
						while($lp_contactos = traer_fila_row($busca_provee_contactos)){// contactos
						
						$confirma_envio= envia_correos($lp_contactos[0],$asunto,$mensaje_envio,$cabesa);
						registro_email_enviado_nuevo($id_invitacion, $lp_contactos[0], $asunto, $mensaje_envio,$confirma_envio,1,14,$lp[0]);
						$graba_correo_pro.=$lp_contactos[0]."</br>";
						$graba_correo_pro2.=$lp_contactos[0].", ";
						
						}//contactos

						auditor(51,$id_proceso,$lp[2]." | Se envio email de ".listas_sin_select($tp1,$sql_e[1],1).", e-mail notificados: ".$graba_correo_pro2, "");
						}// provvedores


			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 19"));
			$asunto = str_replace("---consecutivo---",$sql_e[22], $busca_correo[1] );
			

			$cuerpo_confirmacion_envio = str_replace('---consecutivo---', $sql_e[22], $busca_correo[4]);
			$cuerpo_confirmacion_envio = str_replace('---fecha_cierre---', fecha_for_hora($_POST["fecha_cierre_extratiempo"]), $cuerpo_confirmacion_envio);
			$cuerpo_confirmacion_envio = str_replace("---proveedor---",$nombre_proveedor_princi, $cuerpo_confirmacion_envio);
			$cuerpo_confirmacion_envio = str_replace('---detalle_contratar---', $_POST["observaciones_extratiempo_cuerpo"], $cuerpo_confirmacion_envio);
		    $cuerpo_confirmacion_envio = str_replace("---email_proveedores---",$email_proveedor_princi."</br>".$graba_correo_pro, $cuerpo_confirmacion_envio );	
								
	

		$busca_dueno=query_db("select distinct email  from us_usuarios where us_id  in ($sql_e[15], $sql_e[33], $sql_e[44],17)");
		while($destinatario = traer_fila_row($busca_dueno)){
			$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo($id_proceso, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,15,0);
			
			}


			/****envio de correo a los contactos*/


		}


		
		?>
        <script> 
		window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El proceso se creó con éxito', 20, 10, 18);
		window.parent.ajax_carga('../aplicaciones/visualiza_contactos_proceso.php?id_invitacion_pasa=<?=$id_invitacion;?>&pv_id_b=<?=$pv_id_b;?>','contenidos');
		</script>
        <?
		}
		else{
		?>
        <script> 
		var forma = window.parent.document.principal;
		window.parent.muestra_alerta_error_solo_texto('', 'Error', '* Flatan campos por digitar\n* <?=$msg1;?>\n* <?=$msg3;?>\n* <?=$msg4;?>\n* <?=$msg2;?>\n* <?=$msg5;?>', 40, 8, 12);
		//alert("ATENCIÓN:\nFlatan campos por digitar\n<?=$msg1;?>\n<?=$msg3;?>\n<?=$msg4;?>\n<?=$msg2;?>\n<?=$msg5;?>")
		<?=$err_js;?>
        </script>
		<?
		
		
		}
		
		} //si esta dodo digtado


if($_POST["accion"]=="elimina_usuario_proveedor")
{
	$update_mysq = "update $t1 set estado = 2 where us_id = $pv_id_usuario_elimin";
	$sql_w = query_db($update_mysq);
	
				$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
				$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
				
					$update_mysq = "update t1_us_usuarios set estado = 2 where us_id = $pv_id_usuario_elimin";
					$sql_w = mssql_query($update_mysq);
?>
	        <script> 
	    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se elimino con éxito', 20, 10, 18);
		//alert("El registro se elimino con éxito")
		window.parent.ajax_carga('../aplicaciones/modifica_proveedor.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
<?
	
	
	}
	
	
if($_POST["accion"]=="cambia_evaluador_tecnico")
{

		$busca_responsable_t = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_invitacion and tipo = 2"));
		$anterior = listas_sin_select($t1,$busca_responsable_t[1],1);
		$nuevo = listas_sin_select($t1,$responsable_tec_nuevo,1);
		$cambia_evaluador = query_db("update $t11 set us_id = $responsable_tec_nuevo where pro1_id = $id_invitacion and tipo = 2 ");
		auditor(55,$id_invitacion,"Cambia de evaluador tecnico: de $anterior a $nuevo, Observaciones: $observacion_cambia_tecnico", "");



			
?>
	        <script> 
	    window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El registro se genero con éxito', 20, 10, 18);
		//alert("El registro se genero con éxito")
		window.parent.ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_invitacion;?>','contenidos');
		</script>
<?
	
	
	}




?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>