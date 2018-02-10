<?  include("../librerias/lib/@session.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de cartelera de aclaraciones.xls"); 
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
       <td><strong>proveedor</strong></td>
       <td><strong>fecha de la pregunta</strong></td>
       <td><strong>pregunta</strong></td>
       <td>Tipo de pregunta</td>
       <td>Contiene anexo soporte</td>
     </tr>
     <?

  	$busca_campos = query_db("select * from v_aclaraciones_exportar where pro1_id = $id_invitacion    ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	
	if($l_campo[8]==2) $tipo_aclaracion = "Tecnica";
	elseif($l_campo[8]==1) $tipo_aclaracion = "Economica";
	elseif($l_campo[8]==3) $tipo_aclaracion = "Lista de precios";	
	elseif($l_campo[8]==4) $tipo_aclaracion = "Varias";		
		
	if($l_campo[9]!="") $anexo = "Con anexo soporte";		
	else $anexo = "";		

		 
	?>
     <tr>
       <td><?=$l_campo[2];?></td>
       <td><?=$l_campo[7];?></td>
       <td><?=$l_campo[3];?></td>
       <td><?=$l_campo[4];?></td>
       <td><?=$tipo_aclaracion;?></td>
       <td><?=$anexo;?></td>       
     </tr>
     <? } ?>
   </table>


</body>
</html>
