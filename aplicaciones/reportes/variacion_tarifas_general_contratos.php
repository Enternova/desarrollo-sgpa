<?
include("../../librerias/lib/@include.php");


	?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../librerias/materialize/css/materialize_custom.css">
<script type="text/javascript" src="../librerias/jquery/jquery2.js"></script>
<script type="text/javascript" src="../librerias/materialize/js/materialize.js"></script>
<style>
	.div-text {
		width: 90%;
		margin-left: 5%;
		height: auto;
	}
	.div-custom-red2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #E0766B;
	}
	.div-custom-yellow2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FFBE5E;
	}
	.div-custom-green2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #6AC46F;
	}
	.font{
		font-family: 'roboto';
	}
	.f14{
		font-size: 12pt;
	}
	.f12{
		font-size: 9pt;
		font-weight: 900 !important;
	}
	.f10{
		font-size: 8pt;
		color: #000;
	}
	.table-custom{
		width: 98%;
		margin-left: 1%;
		border-collapse:collapse;
	}
	.th-custom{
		/*-webkit-box-shadow: 0 9px 4px #777;
		-moz-box-shadow: 0 9px 4px #777;
		box-shadow: 0 9px 4px #777;*/
		background: transparent;
		color: #FFF;		
		font-weight: 900;
	}
	.td-title-red{
		background: #FE5151;
		color: #FFF;
	}
	.td-title-yellow{
		background: #FEC007;
		color: #FFF;
	}
	.td-title-green{
		background: #4BAE4F;
		color: #FFF;
	}
	.custom-red2{
		color: #FF3333;
	}
	.custom-yellow2{
		color: #E2B700;
	}
	.custom-green2{
		color: #009900;
	}
	.border{
		border: 2px solid #FFF;
	}
	.transparent{
		background: transparent;
	}
</style>


<div class="titulos_secciones font" style="font-size:16pt !important; font-weight: 900 !important;">Contratos con Tarifas Creadas o Modificaciones para el &Aacute;rea <?
if($_GET["id_area"] == 0){
	echo "Todas";
}else{
echo saca_nombre_lista($g12,$_GET["id_area"],'nombre','t1_area_id');
}
?></div>
<br />


<table width="100%" border="0">
  <tr>
    <td colspan="2" align="center"><table width="70%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="42%" align="center" class="fondo_3">Numero de Contrato</td>
        <td width="13%" align="center" class="fondo_3">No.  de Tarifas Creadas</td>
        <td width="16%" align="center" class="fondo_3">No. de Tarifas Modificadas</td>
        <td width="29%" align="center" class="fondo_3">Ver Detalle de Variaci&oacute;n</td>
        </tr>
        <?
		if($_GET["id_area"] == 0){
			$where_principal = " fecha_aprobacion is not null and fecha_aprobacion like '%2017-10%' ";
			}else{
				$where_principal = " fecha_aprobacion is not null and fecha_aprobacion like '%2017-10%' and t1_area_id = ".$_GET["id_area"];		
				}
		
		$conteo_creadas = 0;
		$conteo_modificadas = 0;
		$conteo_contratos = 0;
		
		$sql = "select id_contrato_tarifas, contrato, razon_social from v_reporte_general_variacion_tarifas where ".$where_principal." group by id_contrato_tarifas, contrato, razon_social order by contrato";
        $sel_principal_contrato = query_db($sql);
		
		while($sel_p_are = traer_fila_db($sel_principal_contrato)){
			
		$sql_conteo_creadas = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas where ".$where_principal." and tipo_creacion_modifica = 3 and id_contrato_tarifas = ".$sel_p_are[0]." "));
		$sql_conteo_actualizadas = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas where ".$where_principal." and tipo_creacion_modifica = 2 and id_contrato_tarifas = ".$sel_p_are[0]." "));

		
		
		$conteo_creadas = $conteo_creadas + $sql_conteo_creadas[0];
		$conteo_modificadas = $conteo_modificadas + $sql_conteo_actualizadas[0];
		
		
					
			if($cont == 0){
		  	$clase= "#F2F2F2";
			$cont = 1;
		  }else{
		  	$clase= "#FFFFFF";
			$cont = 0;
		  }
		?>
      <tr style="background:<?=$clase?>">
        <td style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;"><?=$sel_p_are[1]?> <?=$sel_p_are[2]?></td>
        <td align="center" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important; "><?=number_format($sql_conteo_creadas[0],0)?></td>
        <td align="center" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important; "><?=number_format($sql_conteo_actualizadas[0],0)?></td>
        <td align="center" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important; color:#229BFF; cursor:pointer" onclick="javascript:exporta_tarifas_consulta_variacion_general(<?=arreglo_pasa_variables($sel_p_are[0]);?>)" >Ver</td>
        </tr>
        <?
		}
		?>
      <tr>
      
        <td align="right">Total:</td>
        <td align="center" class="fondo_3"><?=number_format($conteo_creadas,0)?></td>
        <td align="center" class="fondo_3"><?=number_format($conteo_modificadas,0)?></td>
        <td align="center" class="fondo_3">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_contrato" id="id_contrato" value="<?=$id_contrato;?>" />