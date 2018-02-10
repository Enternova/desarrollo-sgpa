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



switch($b_activo){
	case 1: $complemento_busqueda.= " and estado < 10 "; break;
	case 2: $complemento_busqueda.= " and estado = 10 ";break;
	case 3: $complemento_busqueda.= " and estado = 32 ";break;
	}


if($b_congelados == 1) $complemento_busqueda.= " and (analista_deloitte = 0 or analista_deloitte is null)";

	   
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
    <td height="107" colspan="2" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="4" align="left" class="titulo1"><strong>REPORTE DE ESTADO DE TARIFAS CARGADAS A LOS CONTRATOS</strong></td>
  </tr>
 
<tr>
    <tr>
    <td width="11%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="55%" align="center" class="columna_subtitulo_resultados">Objeto</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Nit</td>
    <td width="23%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Area usuaria</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Gerente Contrato </td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Profesional C&C </td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Estado Tarifas</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Estado Contratos</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Fecha Fin</td>
    <td width="5%" align="center" class="columna_subtitulo_resultados">Congelados</td>
    <td width="6%" align="center" class="columna_subtitulo_resultados"><div align="center">Total tarifas</div></td>
  </tr>
    </tr>
  <?
$busca_item = "
select distinct tarifas_contrato_id, consecutivo, objeto, razon_social, t6_tarifas_estados_contratos_id, total_tarifas, vigencia_mes,estado,analista_deloitte,nit,id_item,especialista,gerente,t1_area_id from v_tarifas_reporte where  1=1 $complemento_busqueda";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_db($sql_ex)){
	
	if($ls_mr[4]==1) $estado="Sin tarifas";
	elseif($ls_mr[4]==2) $estado="Parcial";
	elseif($ls_mr[4]==3) $estado="En firme";
				
switch($ls_mr[7]){
	case $ls_mr[7] < 10: $estado_contrato = "En legalizacion"; break;
	case 10: $estado_contrato = "Legalizado"; break;
	case 32: $estado_contrato = "Finalizado"; break;
	}
	
	if($ls_mr[8] == 1) $congelado = "SI";
	else $congelado = "NO";


 if($num_fila%2==0)
	$class="filas_resultados";
else
	$class="";
	?>
		
 
  <tr class="<?=$class;?>">
    <td ><?=$ls_mr[1];?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><?=$ls_mr['nit'];?></td>
    <td ><?=$ls_mr[3];?></td>
    <td ><?= saca_nombre_lista($g12,$ls_mr['t1_area_id'],'nombre','t1_area_id')?></td>
    <td ><?= traer_nombre_muestra($ls_mr['gerente'], $g1,"nombre_administrador","us_id");?></td>
    <td ><?= traer_nombre_muestra($ls_mr['especialista'], $g1,"nombre_administrador","us_id");?></td>
    <td ><?=$estado;?></td>
    <td ><?=$estado_contrato?></td>
    <td ><?=$ls_mr[6];?></td>
    <td ><?=$congelado;?></td>
    <td><div align="center"><?=$ls_mr[5];?></div></td>
  </tr>
  
  <? $num_fila++;} ?>
</table>
</body>
</html>