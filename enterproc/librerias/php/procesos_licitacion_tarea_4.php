<? include("../../librerias/lib/@include.php");
$_SESSION["id_us_session"]=32;
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer


 $busca_procesos_abiertos = "select distinct us_id_contacto from v_aclaraciones_exportar where noticado_comprador = 1 group by pro1_id, us_id_contacto ";
$sql_ex = query_db($busca_procesos_abiertos);

			$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 23"));
			$asunto = $busca_correo[1];


while ($procesos_activos= traer_fila_row($sql_ex )){ // 1 lista los usuarios procesos activos y con visita obligatoria
	$procesos_activos[0]."<br>";
	$tratado=0;
	
		
		$busca_procesos_abiertos_unitarios = "select distinct consecutivo, pro1_id from v_aclaraciones_exportar where us_id_contacto = $procesos_activos[0] and  noticado_comprador = 1 ";
		$sql_ex_2 = query_db($busca_procesos_abiertos_unitarios);
		$lista_consecutivos = "";
				while ($procesos_activos_unitarios= traer_fila_row($sql_ex_2 )){ // 2 lista los procesos activos y con visita obligatoria
					

						
					$lista_consecutivos.=$procesos_activos_unitarios[0]."<br>";
					$lista_consecutivos_gestor.=$procesos_activos_unitarios[0]."<br>";
				echo 	$tratado=1;
					
				$cambia_estado = "update $t15 set noticado_comprador = 2 where pro1_id = $procesos_activos_unitarios[1] ";
				$cambia_estado_carte = query_db($cambia_estado);
	
				}//  2 lista los  procesos activos y con visita obligatoria
				
				
				//envia 1 email con todos los proceso


			$cuerpo_confirmacion_envio = str_replace('----consecutivos----', $lista_consecutivos, $busca_correo[4]);
								
	

		$busca_dueno=query_db("select distinct email, nombre_administrador  from us_usuarios where us_id  in ($procesos_activos[0])");
		$destinatario = traer_fila_row($busca_dueno);
			//$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			echo "Usuario notificado: ".$destinatario[1]."<br>".$cuerpo_confirmacion_envio;
			
			$confirma_envio= envia_correos($destinatario[0].",sgpa-notificaciones@enternova.net",$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo(0, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,16,0);
			
	
				
				//envia 1 email con todos los proceso
				
				
				

		
	
	/**/
	}//  1 lista los procesos usuarios activos y con visita obligatoria

if($tratado==1){
				$cuerpo_confirmacion_envio = str_replace('----consecutivos----', $lista_consecutivos_gestor, $busca_correo[4]);
								
	

		$busca_dueno=query_db("select distinct email, nombre_administrador  from us_usuarios where us_id  in (17)");
		$destinatario = traer_fila_row($busca_dueno);
			//$confirma_envio=envia_correos($destinatario[0],$asunto,$cuerpo_confirmacion_envio,$cabesa);
			echo "Usuario notificado: ".$destinatario[1]."<br>".$cuerpo_confirmacion_envio;
			$confirma_envio= envia_correos($destinatario[0].",sgpa-notificaciones@enternova.net",$asunto,$cuerpo_confirmacion_envio,$cabesa);
			registro_email_enviado_nuevo(0, $destinatario[0], $asunto, $cuerpo_confirmacion_envio, $confirma_envio,1,16,0);
			
			$confirma_envio= envia_correos("rene.sterling@enternova.net",$asunto,$cuerpo_confirmacion_envio,$cabesa);
			
				
				//envia 1 email con todos los proceso
				
}
				


?>
<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>
