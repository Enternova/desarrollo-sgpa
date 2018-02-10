<?     header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tiquetes.xls"); 
	header("Content-Transfer-Encoding: binary");


//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");

 function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

   

if($gerentes>=1)
	$complemento_busqueda.= " and t6_tarifas_estados_contratos_id =  $gerentes ";

if($b_contrato!="")
	$complemento_busqueda.= " and consecutivo like  '%$b_contrato%' ";

if($b_provee!="") 
	$complemento_busqueda.= " and razon_social like  '%$b_provee%' ";

$complemento_busqueda.= " and t6_tarifas_estados_contratos_id =  2 ";

switch($b_activo){
	case 1: $complemento_busqueda.= " and estado < 10 "; break;
	case 2: $complemento_busqueda.= " and estado = 10 ";break;
	case 3: $complemento_busqueda.= " and estado = 32 ";break;
	}




	   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td height="107" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td height="107" colspan="3"  align="left" class="titulo1" valign="middle"><strong>REPORTE DE CONTRATOS PARCIALES CON TARIFAS PENDIENTES DE APROBACION</strong></td>
  </tr>
 
<tr>
    <td width="16%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="30%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="31%" align="center" class="columna_subtitulo_resultados">Responsable</td>
    <td width="23%" align="center" class="columna_subtitulo_resultados">Estado</td>
  </tr>
    </tr>
  <?
$busca_item = "
select distinct tarifas_contrato_id, consecutivo, objeto, razon_social, t6_tarifas_estados_contratos_id, t1_proveedor_id, nit,especialista from v_tarifas_reporte_contratos_parciales where  1=1 $complemento_busqueda ORDER BY consecutivo desc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_db($sql_ex)){
	
	if($ls_mr[4]==1) $estado="Sin tarifas";
	elseif($ls_mr[4]==2) $estado="Parcial";
	elseif($ls_mr[4]==3) $estado="En firme";
	$nombre_especialista = "";
				
	if($ls_mr[7]!=""){
	$sel_usuario = "select * from $g1 where us_id = $ls_mr[7]";
    $sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
	$nombre_especialista = $sql_sel_usuario[1];
	}
	
	
	
 if($num_fila%2==0)
	$class="filas_resultados";
else
	$class="";
	?>
		
 
   <tr class="<?=$class;?>">
    <td ><?=$ls_mr[1];?></td>
    <td ><?=$ls_mr[3];?></td>
    <td ><?=$nombre_especialista;?></td>
    <td><?=$estado;?></td>
  </tr>
  
  <? $num_fila++;} ?>
</table>
</body>
</html>