<? include("../../librerias/lib/@session.php"); 
	

		$quita_apellidos = str_replace("M","", $_GET["busca_solicitud"]);
		$quita_apellidos = str_replace("S","", $_GET["busca_solicitud"]);
		$quita_apellidos = str_replace("SS","", $_GET["busca_solicitud"]);
		$quita_apellidos = str_replace("BS","", $_GET["busca_solicitud"]);
		$quita_apellidos = str_replace("B","", $_GET["busca_solicitud"]);
			
		$q = $quita_apellidos;
		
		
if($_GET["busca_solicitud"] <> ""){
	$sql_comple.= " and cast(num1 +''+ num2+'-'+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+' '+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%' or  cast(num1 +''+ num2+''+  case when cast(num3 as varchar) <10 then '000'+cast(num3 as varchar) else case when cast(num3 as varchar) >=10 and cast(num3 as varchar) < 100 then '00'+cast(num3 as varchar) else case when cast(num3 as varchar) >= 100 and cast(num3 as varchar) < 1000 then '0'+cast(num3 as varchar) else cast(num3 as varchar) end end end  as text) like '%$q%'";

	$sql_comple.= " or cast('C'+ ano+'-'+  case when cast(consecutivo as varchar) <10 then '000'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >=10 and cast(consecutivo as varchar) < 100 then '00'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >= 100 and cast(consecutivo as varchar) < 1000 then '0'+cast(consecutivo as varchar) else cast(consecutivo as varchar) end end end as text) like '%$q%' or  cast('C'+ ano+' '+  case when cast(consecutivo as varchar) <10 then '000'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >=10 and cast(consecutivo as varchar) < 100 then '00'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >= 100 and cast(consecutivo as varchar) < 1000 then '0'+cast(consecutivo as varchar) else cast(consecutivo as varchar) end end end as text) like '%$q%' or  cast('C'+ ano+''+  case when cast(consecutivo as varchar) <10 then '000'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >=10 and cast(consecutivo as varchar) < 100 then '00'+cast(consecutivo as varchar) else case when cast(consecutivo as varchar) >= 100 and cast(consecutivo as varchar) < 1000 then '0'+cast(consecutivo as varchar) else cast(consecutivo as varchar) end end end as text) like '%$q%'";
	
	
	}

	
	
if($_GET["fecha"] <> ""){
	$sql_comple.= " and fecha = '".$_GET["fecha"]."'";
	}
if($_GET["usuario_permiso"] <> ""){
	$sql_comple.= " and id_us = '".$_GET["usuario_permiso"]."'";
	}
if($_GET["modulo"] <> 0){
	$sql_comple.= " and id_modulo = '".$_GET["modulo"]."'";
	}


if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;

	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" src="../../librerias/jquery/fancybox/lib/jquery-1.10.1.min.js"></script>

<script type="text/javascript" src="../../librerias/jquery/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../../librerias/jquery/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	

	
<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			


		});
	</script>


<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0">
  <tr>
    <td width="33%">&nbsp;</td>
    <td width="48%" align="right">Paginas:</td>
    <td width="19%"><?
		  		  
          $cuantos_registros_sql = query_db("select count(*) from vista_log_1 where id_log > 1 $sql_comple group by num1, num2, num3, tipo_log, nombre_administrador, fecha, hora_seg,tipo_log_sub,id_log,id_tipo_log, id_modulo, consecutivo, ano, apellido order by fecha");
		  while($s = traer_fila_db($cuantos_registros_sql)){
			  $cuantos_registros = 1 +$cuantos_registros;
			  }
		  
	  $cunatas_paginas = ($cuantos_registros / $registros_pagina) +1;
	  

	  
		  ?>
          
          <select name="paginas" id="paginas" onchange="window.parent.ajax_carga('../aplicaciones/reportes/auditor_lista_general_frame.php?paginas='+this.value+'&busca_solicitud=<?=$_GET["busca_solicitud"]?>&fecha=<?=$_GET["fecha"]?>&usuario_permiso=<?=$_GET["usuario_permiso"]?>&modulo=<?=$_GET["modulo"]?>','carga_auditor_1')">
        <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
        <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
          <?=$i?>
          </option>
        <? }?>
      </select>
      
    </td>
  </tr>
</table>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td align="center" class="fondo_3">Numero de Proceso</td>
    <td align="center" class="fondo_3">Tipo de LOG</td>
    <td align="center" class="fondo_3">Usuario que Realizo la Accion</td>
    <td align="center" class="fondo_3">Fecha</td>
    <td align="center" class="fondo_3">Hora</td>
  </tr>
  <?
  $cont = 0;
  
  $sql_consulta = "select * from (select num1, num2, num3, tipo_log, nombre_administrador, fecha, hora_seg,tipo_log_sub, id_log, ROW_NUMBER()Over(order by fecha desc, hora_seg desc) As RowNum, id_tipo_log, id_modulo, consecutivo, ano, apellido,id_tipo_log_sub_ventana,de_historico from vista_log_1 where id_log > 1 $sql_comple group by num1, num2, num3, tipo_log, nombre_administrador, fecha, hora_seg,tipo_log_sub,id_log,id_tipo_log, id_modulo, consecutivo, ano, apellido,id_tipo_log_sub_ventana,de_historico ) as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final";



  $sel_logs = query_db($sql_consulta);
  while($s_log = traer_fila_db($sel_logs)){
	  $tipo_sub = explode ("-", $s_log[7]);
	  
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
	  $sel_cuantos_registros = traer_fila_Row(query_db("select count(*) from tseg9_log_detalle where id_log = ".$s_log[8]));
	  
	  
		  
		if($sel_cuantos_registros[0] > 1 or ($s_log[10] >= 18 and $s_log[10] <= 21) or $s_log[15] == 14 or $s_log[10] == 41){
				$link = '<a class="fancybox fancybox.iframe" href="auditor_detalle_general.php?id_log='.$s_log[8].'">'.$s_log[3].' '.$tipo_sub[1].' </a>';
			}else{
				$link = $s_log[3].' '.$tipo_sub[1];
				}
				
		if($s_log[11] == 1 or $s_log[11] == 2){
			$numero_proceso = numero_item_pecc($s_log["num1"],$s_log["num2"],$s_log["num3"]);
			}
		if($s_log[11] == 4){
			$numero_proceso = numero_item_pecc_contrato("C",$s_log["ano"],$s_log["consecutivo"],$s_log["apellido"]);
			}
		if($s_log[11] == 6){
			$numero_proceso = "General";
			}
			
		$masivo="";
		if($s_log["de_historico"] <> ''){
			$masivo="<font color='#FF0000'> Carga Masiva</font>";
			}
		
  ?>
  <tr  class="<?=$clase?>">
    <td width="18%" align="left"><?=$numero_proceso;?> <?=$masivo?></td>
    <td width="37%"><?=$link?></td>
    <td width="25%"><?=$s_log[4]?> </td>
    <td width="11%"><?=$s_log[5]?></td>
    <td width="9%"><?=$s_log[6]?></td>
  </tr>
  <?
  }
  ?>
</table>
</body>
</html>
