<? include("../../librerias/lib/@session.php"); 
	
	

  
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

<table width="100%" border="0" class="tabla_lista_resultados">
  <?
  $s_log = traer_fila_row(query_db("select num1, num2, num3, tipo_log, nombre_administrador, fecha, hora_seg,tipo_log_sub, estado_actual_proceso,estado_resultado,id_modulo, consecutivo, ano, apellido from ".$_GET["vista_aplica"]." where id_log = ".$_GET["id_log"]." group by num1, num2, num3, tipo_log, nombre_administrador, fecha, hora_seg,tipo_log_sub,estado_actual_proceso,estado_resultado,id_modulo, consecutivo, ano, apellido order by fecha, hora_seg"));
	  
	$tipo_sub = explode ("-", $s_log[7]);
//	;

if($s_log[10] == 1 or $s_log[10] == 2){
			$numero_proceso = numero_item_pecc($s_log[0],$s_log[1],$s_log[2]);
			}
		if($s_log[10] == 4 or $s_log[10] == 5){
			$numero_proceso = numero_item_pecc_contrato("C",$s_log[12],$s_log[11],$s_log[13]);
			}
	
if($s_log[10] == 11){//usuarios
			$numero_proceso = $s_log[0];
			}
			
  ?>
  <tr >
   	<?
	if($_GET["vista_aplica"]=="vista_log_3_usuarios_r"){//si es log de usuarios
	?>
    <td width="29%" align="right"><strong>Usuario Gestionado:</strong></td>
    <?}else{?>
    <td width="29%" align="right"><strong>Numero de Proceso:</strong></td>
    <?}?>
    <td width="21%" align="left"><?=$numero_proceso?></td>
    <td width="23%" align="right"><strong>Fecha Hora:</strong></td>
    <td width="27%"><?=$s_log[5]?> <?=$s_log[6]?></td>
  </tr>
  <tr >
    <td align="right"><strong>Tipo de LOG:</strong></td>
    <td colspan="3" align="left"><?=$s_log[3]?> <?=$tipo_sub[1]?></td>
  </tr>
  <?
	if($_GET["vista_aplica"]!="vista_log_3_usuarios_r"){//si es log de usuarios
  ?>
  <tr >
    <td align="right"><strong>Estado Antes de la Accion:</strong></td>
    <td align="left"><?=traer_nombre_muestra($s_log[8], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right"><strong>Estado Resultado:</strong></td>
    <td colspan="3" align="left"><?=traer_nombre_muestra($s_log[9], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
  </tr>
   <?}?>
  <tr >
    <td align="right"><strong>Usuario:</strong></td>
    <td><?=$s_log[4]?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
<br />
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr>
    <td align="center" class="fondo_3">Campo Afectado</td>
    <td align="center" class="fondo_3">Detalle</td>
  </tr>
  <?
  $cont = 0;
		
  $sel_logs = query_db("select campo_imprime, CAST(detalle AS TEXT), tabla_id from ".$_GET["vista_aplica"]." where id_log = ".$_GET["id_log"]."   order by orden");
  while($s_log = traer_fila_db($sel_logs)){

		if($_GET["vista_aplica"]=="vista_log_3_usuarios_r"){
			
			$detalle = $s_log[1];
			}elseif($s_log[2] <> "" and $s_log[2] <> " "){
			
			$detalle = $nom_us_solicitante=traer_nombre_muestra_log($s_log[1], $s_log[2]);
			}else{
				$detalle = $s_log[1];
				}
				
				 if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	
  ?>
  <tr  class="<?=$clase?>">
    <td width="33%" align="left"><?=$s_log[0]?></td>
    <td width="67%"><?=$detalle?> </td>
  </tr>
  <?
  }
  ?>
</table>
</body>
</html>
