<? include("../../librerias/lib/@session.php");
/*	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	*/
if($eq_moneda == 1){
	$moneda = "USD";
	}
if($eq_moneda == 2){
	$moneda = "COP";
	}

	
		

	
		//$sq_comple.=" and vigencia_mes >= '".date("Y-m-d")."'";
	
	


		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		
		$comple_sql = "";
		
		if($numero1_pecc != 0){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != 0){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != 0){
			$comple_sql.=" and num3 = '".$numero3_pecc."'";
			}
			
		
				if($n_contrato != ""){
			$comple_sql.=" and consecutivo = '".$n_contrato."'";
			}
			
					if($n_contrato_ano != ""){
						
						if($n_contrato_ano == 9) $n_contrato_ano = '2009';
						if($n_contrato_ano == 10) $n_contrato_ano = '2010';
						if($n_contrato_ano == 11) $n_contrato_ano = '2011';
						if($n_contrato_ano == 12) $n_contrato_ano = '2012';
						if($n_contrato_ano == 13) $n_contrato_ano = '2013';
						if($n_contrato_ano == 14) $n_contrato_ano = '2014';
						if($n_contrato_ano == 15) $n_contrato_ano = '2015';
						if($n_contrato_ano == 16) $n_contrato_ano = '2016';
						if($n_contrato_ano == 17) $n_contrato_ano = '2017';
						if($n_contrato_ano == 18) $n_contrato_ano = '2018';
						if($n_contrato_ano == 19) $n_contrato_ano = '2019';
						if($n_contrato_ano == 20) $n_contrato_ano = '2020';
			$comple_sql.=" and creacion_sistema like '%".$n_contrato_ano."%'";
			}
			
			

		
	?>


<head>
<title>Documento sin t&iacute;tulo</title>


<style>
@charset "utf-8";
body {
	color:#676767;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	background:#F8F8F8;
}
.tabla_lista_resultados{  
	margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; 
  BORDER-RIGHT: #cccccc 3px  double; 
  BORDER-TOP: #cccccc 1px solid;  	
  BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  
 }
 
 .estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}
.fondo_3{ background:#005395; color:#FFFFFF;}
.fondo_4{ background:#0F6000; color:#FFFFFF;}

.tabla_paginador{ font-size:14px; color:#666666} 

.filas_resultados_reporte_saldos1{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
.filas_resultados_reporte_saldos2{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 0px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
	

.filas_resultados_blanco{ background:#FFFFFF} 
.filas_resultados{ background:#DBFBDC} 

</style>

<body>

  <?

$cont = 0;
 $query_reporte = "select * from vista_reporte_saldos_marco_1 where id_item > 0 ".$comple_sql.$sq_comple." order by id_item desc";
	$sel_contratos_marco = query_db($query_reporte);
		while($sel_contra = traer_fila_db($sel_contratos_marco)){
	$id_item_pecc = $sel_contra[0];
	$id_contrato = $sel_contra[1];
	
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  if($id_item_pecc != $id_item_envia_funcion){
	  $delete = query_db("delete from t2_reporte_marco_temporal_ejecuciones_excel where id_us=".$_SESSION["id_us_session"]);
	  $delete = query_db("delete from t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones where id_us=".$_SESSION["id_us_session"]);
		  llena_tabla_temporal_reporte_marco("ejecucion", $id_contrato);
		  $id_item_envia_funcion = $id_item_pecc;
		  

		  

/*resta de las reclasificaciones*/	
//$tabla_aplica = "t2_reporte_marco_temporal_ejecuciones_excel";

	//if($saber_si_tiene_reclasificaciones[0]>0){//crea registros para descontar las reclasificaciones.
	$tabla_aplica = "t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones";
		$consulta_tabla_reporte_suman_valor = query_db("select id_us, tipo, id_item, CAST(contratos AS TEXT), ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, id_item_ots_aplica from  t2_reporte_marco_temporal_ejecuciones_excel where id_us= '".$_SESSION["id_us_session"]."'");
		while($c_t_r_s = traer_fila_db($consulta_tabla_reporte_suman_valor)){			
			$trm = trm_presupuestal($c_t_r_s[4]);			
			$saldo_equ_usd=$c_t_r_s[6] + ($c_t_r_s[7]/$trm);
			$saldo_equ_cop=$c_t_r_s[7] + ($c_t_r_s[6]*$trm);
			
			$saldo_equ_usd = number_format($saldo_equ_usd, 0, "", "");
			$saldo_equ_cop = number_format($saldo_equ_cop, 0, "", "");
			
			$contrato = str_replace("<div class=filas_resultados_reporte_saldos1>","",$c_t_r_s[3]);
			$contrato = str_replace("<div class=filas_resultados_reporte_saldos2>","",$contrato);
			$contrato = str_replace("</div>","",$contrato);
			$contrato = str_replace("<font color=blue>","",$contrato);
			$contrato = str_replace("</font>","",$contrato);
			$contrato = str_replace("<font color=#0000FF>","",$contrato);
			$contrato = str_replace("<span >","",$contrato);
			$contrato = str_replace("</span>","",$contrato);
			$contrato = str_replace("<br />","",$contrato);
			$contrato = str_replace(",","",$contrato);
			$contrato = str_replace(" ","",$contrato);

			
				$insert_tabla_para_descontar = query_db("insert into t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones (id_us, tipo, id_item,  ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, id_item_ots_aplica, saldo_eq_usd, saldo_eq_cop, contratos) values ('".$c_t_r_s[0]."', '".$c_t_r_s[1]."', '".$c_t_r_s[2]."',  '".$c_t_r_s[4]."', '".$c_t_r_s[5]."', 0, 0, '".$c_t_r_s[8]."', '".$c_t_r_s[9]."', '".$c_t_r_s[10]."', '".$c_t_r_s[11]."', '".$saldo_equ_usd."', '".$saldo_equ_cop."', '".$contrato."')");
				
				
			}
			
		$sql_descuenta_reclasificaciones = "select  t1.ano, t1.id_campo, CAST(contratos as TEXT), sum(t1.saldo_eq_usd), sum(t1.saldo_eq_cop) from t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') and t2.estado >= 20 and t2.estado <=32 and t2.estado <> 31  group by t1.ano, t1.id_campo, contratos";
     $sql_descuenta = query_db($sql_descuenta_reclasificaciones);
	 		while($descuenta = traer_fila_db($sql_descuenta)){
				$trm = trm_presupuestal($descuenta[0]);
				$valor_por_descontar_eq_usd = $descuenta[3];
				$valor_por_descontar_eq_cop = $descuenta[4];
					$sql_ampli_inicial = query_db("select id_us, tipo, id_item, contratos, ano, campo, saldo_eq_usd, saldo_eq_cop, id_campo, t2_presupuesto_id, num_item, contratista, id_item_ots_aplica from t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial','ampliacion') and ano=".$descuenta[0]." and id_campo=".$descuenta[1]." and contratos like '%".$descuenta[2]."%'");
					while($c_t_r_s = traer_fila_db($sql_ampli_inicial)){
							$nuevo_valor_ampli_eq_usd=0;
							$nuevo_valor_ampli_eq_cop=0;
							
						if($c_t_r_s[6]>=$valor_por_descontar_eq_usd){//descuenta completo de la ampliacion o de la solicitud inicial
							$nuevo_valor_ampli_eq_usd=$c_t_r_s[6]-$valor_por_descontar_eq_usd;
							$nuevo_valor_ampli_eq_cop=$c_t_r_s[7]-$valor_por_descontar_eq_cop;
							$update = query_db("update t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones set saldo_eq_usd='".$nuevo_valor_ampli_eq_usd."', saldo_eq_cop=".$nuevo_valor_ampli_eq_cop." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$c_t_r_s[2]." and ano=".$c_t_r_s[4]." and id_campo=".$c_t_r_s[8]." and contratos like '%".$c_t_r_s[3]."%'");
							$valor_por_descontar_eq_usd = 0;
							$valor_por_descontar_eq_cop = 0;
							}else{// descuenta parcial de la ampliacion o de la solicitud inicial
							$nuevo_valor_ampli_eq_usd=0;
							$nuevo_valor_ampli_eq_cop=0;
							$update = query_db("update t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones set saldo_eq_usd='".$nuevo_valor_ampli_eq_usd."', saldo_eq_cop=".$nuevo_valor_ampli_eq_cop." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$c_t_r_s[2]." and ano=".$c_t_r_s[4]." and id_campo=".$c_t_r_s[8]." and contratos like '%".$c_t_r_s[3]."%'<br />");
							$valor_por_descontar_eq_usd = $valor_por_descontar_eq_usd-$c_t_r_s[6];
							$valor_por_descontar_eq_cop = $valor_por_descontar_eq_cop-$c_t_r_s[7];
								
								}
						
					}
					
				}
		//}
	/*FIN resta de las reclasificaciones*/
  
			
	?>
 <table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      
      <?
  
  if($_GET["id_solicitud"]<>0){
	  $comple_sql = " and id_item=".$_GET["id_solicitud"];
	  }
  

  
 /* 
  $cuantos_solicitudes="select num_item,tipo,id_item from ".$tabla_aplica." where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by num_item,tipo,id_item order by id_item asc";
  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  */
  
  $sel_temporal_sql="select num_item,tipo,".$tabla_aplica.".id_item from ".$tabla_aplica.", t2_item_pecc as t2 where t2.id_item =".$tabla_aplica.".id_item and ".$tabla_aplica.".id_us = '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') and t2.estado >= 20 and t2.estado <=32 and t2.estado <> 31 group by num_item,tipo,".$tabla_aplica.".id_item order by id_item asc";


  ?>
      <tr class="fondo_3">
      
        <td width="38%" align="center"><?=contratos_relacionados_solicitud_para_campos($id_item_pecc)?></td>
        <td width="4%" align="center">
		<? $sel_gerntes = query_db("select t2.nombre_administrador from t7_contratos_contrato as t1, t1_us_usuarios as t2	 where t1.gerente = t2.us_id and t1.id_item = ".$id_item_pecc." group by t2.nombre_administrador");
		while($sel_g = traer_fila_db($sel_gerntes)){
			echo " *".$sel_g[0];
			}
		?></td>
        <td align="center" class="fondo_4"><?
        $sel_provee = query_db("select t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2	 where t1.contratista = t2.t1_proveedor_id and t1.id_item = ".$id_item_pecc." group by t2.razon_social");
		$cuantos_prove = 0;
		while($sel_p = traer_fila_db($sel_provee)){
			$cuantos_prove = $cuantos_prove + 1;
			}
			echo $cuantos_prove;
		
		?></td>
      </tr>
      
      
      <?

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  
  $valor_cop_total_liz =0;
  $valor_usd_total_liz =0;
  $valor_equ_total_liz =0;
  $valor_usd_ots_total=0;
  $valor_cop_ots_total= 0;
  $valor_equivalente_ots_total=0;
  
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	

	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  

	 $cuanta_cuantos_registros=query_db("select count(*) from ".$tabla_aplica." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by id_us, tipo, id_item, contratos, ano, campo, id_campo, num_item, contratista, id_item_ots_aplica");
	 $cuantos_reg = 0;
	 while($cuant_re = traer_fila_db($cuanta_cuantos_registros)){
		 $cuantos_reg = $cuantos_reg + 1;
		 }
	 $convina_rowspan_columna_1=$cuantos_reg;////la columna donde estan los numeros de la solucitud
  

//$sql_sel_ots = "select  id_us, id_us, tipo, id_item, CAST (contratos as text), ano, campo, sum(usd), sum(cop), id_campo, id_campo, num_item, CAST (contratista as text), id_item_ots_aplica from ".$tabla_aplica." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by id_us, tipo, id_item, contratos, ano, campo, id_campo, num_item, contratista, id_item_ots_aplica";

/*nuevo query*/

$sql_sel_ots = "select  id_us, id_us, tipo, id_item, CAST (contratos as text), ano, campo, sum(saldo_eq_usd), sum(saldo_eq_cop), id_campo, id_campo, num_item, CAST (contratista as text), id_item_ots_aplica from ".$tabla_aplica." where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by id_us, tipo, id_item, contratos, ano, campo, id_campo, num_item, contratista, id_item_ots_aplica";
/*nuevo query*/

      $selecciona_valores = query_db($sql_sel_ots);
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  if($cont_estilo != 1){
	$classe2 = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe2 = "";
		$cont_estilo = 2;
		}
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  $comple_sql_ots_sol = " and ano =  ".$s_valores[5]." and id_campo = ".$s_valores[9];
		  
		  $contratos_remplac = str_replace("<div class=filas_resultados_reporte_saldos1>", "", $s_valores[4]);
		  $contratos_remplac = str_replace("<div class=filas_resultados_reporte_saldos2>", "", $contratos_remplac);
		  $contratos_remplac = str_replace("<span >", "", $contratos_remplac);
		  $contratos_remplac = str_replace("</span>,<br />", " ", $contratos_remplac);		  
		  $contratos = str_replace("</div>", " ", $contratos_remplac);
	  ?>
      
      
      <?
	  }
	?>
      
      
      
      
      
      
      <?
  }//fin while principal temporal
	?>
    </table>
  <?
		 
	}			
   ?>
</table>
<?
		}
?>
</body>
</html>
<?
//if($_SESSION["id_us_session"] != 32){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte de Ejecucion.xls"); 
//}

?>