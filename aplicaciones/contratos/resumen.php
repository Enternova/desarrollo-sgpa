<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$busca_contrato = "select * from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="5" class="fondo_4">Resumen</td>
        </tr>
      <tr >
        <td width="20%" >Fecha Inicio:</td>
        <td width="20%" ><?=$sql_con[10];?></td>
        <td width="20%" >&nbsp;</td>
        <td width="20%" >&nbsp;</td>
        <td width="20%" >&nbsp;</td>
        </tr>
        <!-- inicio contrato normal-->
        <?
        
		//$valor_acumulado_tiempo = $sql_con[11];
		?>
		<tr class="fondo_1" >
            <td >Solicitud</td>
            <td >Tipo</td>
            <td >Valor USD</td>
            <td >Valor COP</td>
            <td >Tiempo (Dias)</td>
        </tr>
        
		<tr >
         <?
			

			$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$sql_con[1];
			$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
    	    $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$sql_con[1]));
			
$valor_solicitud_inicial = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from $vpeec22 where id_item = ".$sql_con[1]." and permiso_o_adjudica = 2 "));

		$valor_acumulado_usd = $valor_solicitud_inicial[0];
		$valor_acumulado_cop = $valor_solicitud_inicial[1];
		
		
			?>
            <td >
            <strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$sql_con[1]?>&id_tipo_proceso_pecc=<?=$sel_item[0];?>&conse_div=0&permiso_o_adjudica=2')"><font color="#0000FF"><u>
        
           <?=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
         </u></font></strong>
            <td >Valor Inicial</td>
            <td ><?=valida_numero_imp($valor_solicitud_inicial[0]);?></td>
            <td ><?=valida_numero_imp($valor_solicitud_inicial[1]);?></td>
            <td ></td>
		</tr>
        <?
       $lista_poliza_int2 = "select * from ".$co4." t7c left join ".$g8." t1t on t7c.tipo_complemento = t1t.id left join ".$g9." t1to on t7c.tipo_otrosi = t1to.id left join ".$g5." t1m on t7c.tipo_moneda = t1m.t1_moneda_id  where  id_contrato = $id_contrato_arr and t7c.estado >= 1 and t7c.eliminado<>1";


		$sql_poliza_int3=query_db($lista_poliza_int2);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int3)){
			
			

		?>
		<tr >
            <?
			$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$lista_poliza_int[31]." and estado <> 33";
			$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
    	    $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$lista_poliza_int[31]));
			$numero_item_pecc_imp = numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2]);
			if ($numero_item_pecc_imp != "-"){
			?>
            <td ><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$lista_poliza_int[31]?>&id_tipo_proceso_pecc=<?=$sel_item[0];?>&conse_div=0&permiso_o_adjudica=2')"><font color="#0000FF"><u>
        
           <?=$numero_item_pecc_imp?>
         </u></font></strong>
            </td>
           <? }
			else{
			?><td style='cursor:default;'>
			<?=$numero_item_pecc_imp?>
			</td>
			<?
			}
		   ?>
            <td >
			<?
			echo $lista_poliza_int[48]." ".$lista_poliza_int[51]." No. ".$lista_poliza_int[25];
				//echo "No. ".$lista_poliza_int[41]." ".$lista_poliza_int[25]." ".$lista_poliza_int[44];
			?></td>
            <td >
			<?
				if($lista_poliza_int[2]==2){
					if($lista_poliza_int[31]!= ""){
						echo "<font color='#FF0000'>".valida_numero_imp($lista_poliza_int[8])."</font>";
					$valor_acumulado_usd = $valor_acumulado_usd-$lista_poliza_int[8];}			
				}else{
					if($lista_poliza_int[31]!= ""){
						echo valida_numero_imp($lista_poliza_int[8]);
						$valor_acumulado_usd = $valor_acumulado_usd+$lista_poliza_int[8];}
				}
			?>
            </td>
            <td >
			<?
            
				if($lista_poliza_int[2]==2){
					echo "<font color='#FF0000'>".valida_numero_imp($lista_poliza_int[32])."</font>";
					$valor_acumulado_cop = $valor_acumulado_cop-$lista_poliza_int[32];			
				}else{
					echo valida_numero_imp($lista_poliza_int[32]);
					$valor_acumulado_cop = $valor_acumulado_cop+$lista_poliza_int[32];
				}
			?>

            </td>
            <td >
			<?
            if($lista_poliza_int[2]!=2){
				echo $lista_poliza_int[6];
				$valor_acumulado_tiempo = $valor_acumulado_tiempo+$lista_poliza_int[6];
			}
			?></td>
		</tr>
        <?
		}
		?>
      	<tr class="filas_resultados" >
            <td >Total</td>
            <td >&nbsp;</td>
            <td ><?=valida_numero_imp($valor_acumulado_usd);?></td>
            <td ><?=valida_numero_imp($valor_acumulado_cop);?></td>
            <td ><?=$valor_acumulado_tiempo;?></td>
		</tr>
        <!-- fin contrato normal-->
      <tr >
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        </tr>
      <tr >
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr >
        <td >Fecha Fin:</td>
        <td >
        <?       
		if($sql_con[10]!=""){
			echo dameFecha($sql_con[11],$valor_acumulado_tiempo);
		}
		?>
        </td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        </tr>
      
      </table>
      <BR />
      
      
      
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
</p>
</body>
</html>
