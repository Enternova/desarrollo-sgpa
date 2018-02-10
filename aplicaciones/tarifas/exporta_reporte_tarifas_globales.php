<?  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tarifas especificas.xls"); 
	header("Content-Transfer-Encoding: binary");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
include("../../librerias/php/funciones_general_2015.php");
   include(SUE_PATH."global.php");

		
	function listas_sin_select($tabla,$where,$columna_trae)
		{
			
		$sel = "select * from ".$tabla;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$where)
				$option =$ls[$columna_trae];
			}

			return $option;
		
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


<table border=1  width="100%" >                	
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="11" align="left" class="titulo1"><strong>REPORTE DE TARIFAS ESPECIFICAS </strong></td>
  </tr>

<tr>
  <td width="5%" align="center" class="titulo3">Numero de contrato</td>
	<td width="5%" align="center" class="titulo3">Contratista</td>
	<td width="5%" align="center" class="titulo3">Fecha inicio del  contrato</td>
	<td width="5%" align="center" class="titulo3" >Fecha fin del contrato</td>
	<td width="5%" align="center" class="titulo3" ><span class="columna_subtitulo_resultados">Consecutivo de la  tarifa</span></td>
	<td width="40%" align="center" class="titulo3"><span class="columna_subtitulo_resultados">Categor&iacute;a</span></td>
    <td width="6%" align="center" class="titulo3"><span class="columna_subtitulo_resultados">Grupo</span></td>
    <td width="8%" align="center" class="titulo3"><span class="columna_subtitulo_resultados">Item de Oferta</span></td>
    <td width="11%" align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Nombre Gen&eacute;rico</span></td>
    <td width="11%" align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Unidad</span></td>    
    <td width="7%" align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Moneda</span></td>
    <td  align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Valor de la tarifa</span></td>
    <td  align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Fecha de Inicio vigencia  tarifa</span></td>
    <td  align="center"  class="titulo3"><span class="columna_subtitulo_resultados">Fecha fin de vigencia  tarifa</span></td>
  
</tr>

<?
	
if($categoria_bu!="")
	$complemento.=	" and categoria like '%$categoria_bu%'";	

if($grupo_bu!="")
	$complemento.=	" and grupo like '%$grupo_bu%'";		
	
if($detalle_bu!="")
	$complemento.=	" and detalle like '%$detalle_bu%'";
	
if($contratista_bu!="")
	$complemento.=	" and razon_social like '%$contratista_bu%'";

	
if($vigencia_bu==1)
	$complemento.=	"   and vigencia_mes >= '$fecha' ";		

if($vigencia_bu==2)
	$complemento.=	" and vigencia_mes <= '$fecha' ";	
	
if($vigencia_bu==3)
	$complemento.=	" and id >=1 ";	

if($vigencia_bu==0)
	$complemento_vigenc.=	"   and vigencia_mes >= '$fecha' ";		





	$complemento_final.=	" where t6_tarifas_estados_contratos_id not in (1,2) and t6_tarifas_estados_tarifas_id in (1,7) ";	

	$where_final = $complemento_final.$complemento.$complemento_vigenc;

if($complemento!=""){ //is realizo alguna busqueda

	 $busca_tarifa_espe = "select * from v_tarifas_reporte_buscador_tarifas_globales $where_final";
	$sql_ex_tari = query_db($busca_tarifa_espe);
	
	while($lista_detalle = traer_fila_row($sql_ex_tari )) {

		if($lista_detalle[14] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$lista_detalle[14];
		
		
 ?> 

            <tr class="<?=$class;?>" >
              			<td><?=$lista_detalle[5];?></td>
                        <td><?=$lista_detalle[6];?></td>
                        <td><?=$lista_detalle[7];?></td>
                        <td><?=$lista_detalle[8];?></td>
                        <td><?=$lista_detalle[9];?></td>
                        <td ><?=$lista_detalle[10];?></td>
			            <td><?=$lista_detalle[11];?></td>
		                <td><?=$lista_detalle[12];?></td>
                        <td><?=$lista_detalle[13];?></td>
                        <td><?=$fecha_fin_vi;?></td>
                        <td><?=listas_sin_select($g5,$lista_detalle[15],1);?></td>
              <td   style="<?=$stilo_excel;?>"  class="titulos_resumen_alertas"><div align="center"><?=number_format($lista_detalle[16],$cantidad_decimales,$formato_numeros_miles,$formato_numeros_decimales);?>
              </div></td>
              <td  align="center"><?=$lista_detalle[17];?></td>
              <td  align="center"><?=$lista_detalle[18];?></td>

              
                        </tr>
           <? $num_fila++; 							
		   
	}
}//is realizo alguna busqueda
							
							
							
							
							?> </table> 

									  
									  
</body>
</html>