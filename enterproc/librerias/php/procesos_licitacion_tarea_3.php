<? include("../../librerias/lib/@include.php");
$_SESSION["id_us_session"]=32;
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer


 $busca_procesos_abiertos = "select distinct us_id_contacto from $t5 where fecha_cierre > '$fecha $hora' and direccion_entrega_documentos = 'Si' and nueva_fecha_informativa <=  '$fecha $hora' group by pro1_id, us_id_contacto ";
$sql_ex = query_db($busca_procesos_abiertos);

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 21"));
			$asunto = $busca_correo[1];


while ($procesos_activos= traer_fila_row($sql_ex )){ // 1 lista los usuarios procesos activos y con visita obligatoria
	$procesos_activos[0]."<br>";
	$tratado=0;
	
		
		$busca_procesos_abiertos_unitarios = "select consecutivo, pro1_id from $t5 where us_id_contacto = $procesos_activos[0] and  fecha_cierre > '$fecha $hora' and direccion_entrega_documentos = 'Si' and nueva_fecha_informativa <=  '$fecha $hora' ";
		$sql_ex_2 = query_db($busca_procesos_abiertos_unitarios);
		$lista_consecutivos = "";
				while ($procesos_activos_unitarios= traer_fila_row($sql_ex_2 )){ // 2 lista los procesos activos y con visita obligatoria
					
					
					$select_asiste_auditor = traer_fila_row(query_db("select count(*) from auditor_detalle where pro1_id = $procesos_activos_unitarios[1] and auditor_categoria_id = 44"));
		
					if($select_asiste_auditor[0]==0){//si no ha sido tratado
	
						
					$lista_consecutivos.=$procesos_activos_unitarios[0]."<br>";
					$lista_consecutivos_gestor.=$procesos_activos_unitarios[0]."<br>";
					$tratado=1;
					
					}//si no ha sido tratado
	
	
				}//  2 lista los  procesos activos y con visita obligatoria
				
				
				//envia 1 email con todos los proceso

			if($tratado==1){//si debe enviar notificacion
			$cuerpo_confirmacion_envio = str_replace('----consecutivos----', $lista_consecutivos, $busca_correo[4]);
								
	

		$busca_dueno=query_db("select distinct email, nombre_administrador  from us_usuarios where us_id  in ($procesos_activos[0])");
		$destinatario = traer_fila_row($busca_dueno);
			//$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			echo "Usuario notificado: ".$destinatario[1]."<br>".$cuerpo_confirmacion_envio;
			$confirma_envio= envia_correos($destinatario[0].",sgpa-notificaciones@enternova.net",$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo(0, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,16,0);
			
			
				
				//envia 1 email con todos los proceso
				
				$cuerpo_confirmacion_envio = str_replace('----consecutivos----', $lista_consecutivos_gestor, $busca_correo[4]);
				
				
			}//si debe enviar notificacion
		
	
	/**/
	}//  1 lista los procesos usuarios activos y con visita obligatoria

	if($tratado==1){//si debe enviar notificacion
				$cuerpo_confirmacion_envio = str_replace('----consecutivos----', $lista_consecutivos_gestor, $busca_correo[4]);
								
	

		$busca_dueno=query_db("select distinct email, nombre_administrador  from us_usuarios where us_id  in (17)");
		$destinatario = traer_fila_row($busca_dueno);
			//$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			echo "Usuario notificado: ".$destinatario[1]."<br>".$cuerpo_confirmacion_envio;
			$confirma_envio= envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo(0, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,16,0);
			
			$confirma_envio= envia_correos("rene.sterling@enternova.net",$asunto,$cuerpo_confirmacion_envio,$cabesa);
				
				//envia 1 email con todos los proceso
				
				
				
			}//si debe enviar notificacion

?>
<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>
