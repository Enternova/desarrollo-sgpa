<?
include("../../librerias/lib/@session.php");
require_once '../../librerias/php/Excel/reader.php';
$id_vari=$id_invitacion_pasa;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

$busca_procesos = "select cierre_economica from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));	

	if($sql_e[0]>=$fecha." ".$hora){//si esta dentro del tiempo



$filename = $archivo_lista;

$us_cliente = $_SESSION["id_proveedor"];

if($filename!= ''){// SI EL ARCHIVO EXISTE

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read($filename);


$cuenta_archivo=0;
$cuenta_buenos=0;

	$cuenta_numero_parte= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_valor !='' "));
	$cuenta_marca= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_presupuesto  !='' "));
	$muestra_campo_mar=0;

	if($cuenta_numero_parte[0]>=1){
		$muestra_campo_mar=1;
		}

	if($cuenta_marca[0]>=1){
		$muestra_campo_mar=+1;
		}


for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
$arreglo_cara=explode(".",$data->sheets[0]['cells'][$i][1]);
$id_5=elimina_comillas($arreglo_cara[0]);
$id_lista=elimina_comillas($arreglo_cara[1]);
$inicio_campo_ingresa = (7+$muestra_campo_mar);
$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
while($l_campo = traer_fila_row($busca_campos)){  // recorre los campos
$id_cargue=0;
 $ins_sql_historico = "insert into evaluador_economica_proveedor_historico  (evaluador5_id, evaluador4_id, pv_id, w_valor, w_fecha_creacion, w_fecha_modifica,oferta) values (
				".$id_5.",$l_campo[0],$us_cliente,'".$data->sheets[0]['cells'][$i][$inicio_campo_ingresa]."','$fecha $hora','',$oferta)";
				$exq=query_db($ins_sql_historico);


$valor_ingresado="";
$verifica_valor="";


echo $data->sheets[0]['cells'][$i][$inicio_campo_ingresa];


if( ($l_campo[3]=="Valor") || ($l_campo[3]=="Numerico") ){//verifica si es num,erico



$verifica_valor = str_replace(",", ".", $data->sheets[0]['cells'][$i][$inicio_campo_ingresa]);
$valor_ingresado = is_numeric('0'.$verifica_valor);

echo $valor_ingresado;


if($valor_ingresado!=""){
 



  echo $ins_sql = "insert into $tabla_economica (evaluador5_id, evaluador4_id, pv_id, w_valor, w_fecha_creacion, w_fecha_modifica,oferta) values (
				".$id_5.",$l_campo[0],$us_cliente,'".$data->sheets[0]['cells'][$i][$inicio_campo_ingresa]."','$fecha $hora','',$oferta)";
				$exq=query_db($ins_sql);
				$id_cargue=mysql_errno();
				
				

					if($id_cargue=="1062")
						{//si no ingreso el registro nuevo
						echo	$modifica = "update $tabla_economica set w_valor = '".$data->sheets[0]['cells'][$i][$inicio_campo_ingresa]."',w_fecha_modifica='$fecha $hora' 
							where pv_id = $us_cliente and evaluador5_id  = ".$id_5." and evaluador4_id = $l_campo[0] and oferta = $oferta ";
							$exq=query_db($modifica);
							$error_modifica+= mysql_affected_rows();
						}//si no ingreso el registro nuevo
						
						}// si valor ingresa do = ""
					else
						{//si ingreso el registro nuevo
							$error_ingresa.="<br>".$id_5;
						}//si ingreso el registro nuevo
						
						
						
						}////verifica si es num,erico
						else {////verifica si es NO num,erico
						
						

				
 				$ins_sql = "insert into $tabla_economica (evaluador5_id, evaluador4_id, pv_id, w_valor, w_fecha_creacion, w_fecha_modifica,oferta) values (
				".$id_5.",$l_campo[0],$us_cliente,'".$data->sheets[0]['cells'][$i][$inicio_campo_ingresa]."','$fecha $hora','',$oferta)";
				$exq=query_db($ins_sql);
				$id_cargue=mysql_errno();
				
				echo "<br>--".$id_cargue."error";

					if($id_cargue=="1062")
						{//si no ingreso el registro nuevo
						echo	$modifica = "update $tabla_economica set w_valor = '".$data->sheets[0]['cells'][$i][$inicio_campo_ingresa]."',w_fecha_modifica='$fecha $hora' 
							where pv_id = $us_cliente and evaluador5_id  = ".$id_5." and evaluador4_id = $l_campo[0] and oferta = $oferta ";
							$exq=query_db($modifica);
							$error_modifica+= mysql_affected_rows();
						}//si no ingreso el registro nuevo
						

					else
						{//si ingreso el registro nuevo
							$error_ingresa.="<br>".$id_5;
						}//si ingreso el registro nuevo
						



						
						
						
						}////verifica si es NO num,erico
						
						$inicio_campo_ingresa++;
						}//recorre los campos
						
			} //for
auditor(17,$id_invitacion,"", "");

 } // SI EL ARCHIVO EXISTE
	


								 
?>

<script>
alert("La oferta se envio con éxito")
  window.parent.ajax_carga('../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=<?=$oferta;?>&pag=<?=$pag;?>&id_lista=<?=$id_lista;?>','contenidos' )

</script>

   <?
		} // si esta dentro del tiempo
		
		else{
		auditor(19,$id_invitacion_ar,"", "");
			?>
            <script>
			  alert("ATENCIÓN:\n El tiempo para enviar la oferta económica expiró.\nEsta oferta economica no se grabo")
	          window.parent.ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos' )
		    </script>
            
            <?
		
		
		}
	
?>