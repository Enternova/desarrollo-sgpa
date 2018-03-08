<?  include("../../librerias/lib/@session.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte_General.xls"); 
	header("Content-Transfer-Encoding: binary");


	 $id_invitacion =$id_invitacion_pasa;
	

 
											
													

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >

   <table  border="1" >
     <tr>
       <td><strong>consecutivo</strong></td>
       <td><strong>Fecha de apertura</strong></td>
       <td><strong>fecha de cierre</strong></td>
       <td><strong>Objeto</strong></td>
       <td><strong>Administrador</strong></td>
       <td><strong>Tiene apertura</strong></td>
       <td><strong>Estado</strong></td>
       <td><strong>Tipo proceso</strong></td>
       <td><strong>Tipo solicitud</strong></td>
       <td><strong>Proveedores invitados</strong></td>
     </tr>
     <?
	 
	 if($_POST["f_a"]!="")
	 	$complem.= " and  fecha_apertura >= '".$_POST["f_a"]."'";
	 
 	 if($_POST["f_c"]!="")
	 	$complem.= " and fecha_cierre <= '".$_POST["f_c"]."'";
 	 if($_POST["g_b"]>=1)
	 	$complem.= " and tp1_id = ".$_POST["g_b"];

 	 if($_POST["k_b"]>=1)
	 	$complem.= " and us_id = ".$_POST["k_b"];		
		
 if($_POST["tp3_id_busq"]>=1)
	 	$complem.= " and tp3_id = ".$_POST["tp3_id_busq"];	
 	 if($_POST["tp2_id_bus"]>=1)
	 	$complem.= " and tp2_id = ".$_POST["tp2_id_bus"];		
	

                if($_SESSION["pv_principal"]!=150){//SI ES EL DUEÑO DEL PROCESO
                    $complem.= " and tp2_id <> 31 ";
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO	
	                elseif($_SESSION["pv_principal"]==150){//SI ES EL DUEÑO DEL PROCESO
                    $complem.= " and tp2_id = 31 ";
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO	


 
  	$busca_campos = query_db("select pro1_id, consecutivo, fecha_apertura, fecha_cierre, detalle_objeto, cantidad_proveedores, nombre_tipo_proceso,nombre_administrador, nombre, tp3_id  from v_reporte_deatallado where us_id not in (1, 1741)  $complem  order by  fecha_apertura ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	
$cuenta_APERTURA="select if( count(pro1_id) >=1, 'SI', 'NO') from pro12_apertura_proceso where pro1_id = $l_campo[0]";
$sql_cuenta_APERTURA=traer_fila_row(query_db($cuenta_APERTURA));

if($l_campo[9]==1) $tipo_soli = "Bienes";
else $tipo_soli = "Servicios";
		 
	?>
     <tr>
       <td><?=$l_campo[1];?></td>
       <td><?=$l_campo[2];?></td>
       <td><?=$l_campo[3];?></td>
       <td><?=$l_campo[4];?></td>
       <td><?=$l_campo[7];?></td>
       <td><?=$sql_cuenta_APERTURA[0];?></td>
       <td><?=$l_campo[8];?></td>
       <td><?=$l_campo[6];?></td>
       <td><?=$tipo_soli;?></td>
       <td><?=$l_campo[5];?></td>
     </tr>
     <? } ?>
   </table>


</body>
</html>
