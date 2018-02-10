<? include("../../librerias/lib/@session.php");
/*	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	*/
if($_GET["eq_moneda"] == 1){
	$moneda = "USD";
	}
if($_GET["eq_moneda"] == 2){
	$moneda = "COP";
	}

$id_usuario_reporte = 18463;

		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		
		$comple_sql = " ";
		
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
			

			if($_GET["ano_valores"] != 0){
							$n_contrato_ano=$_GET["ano_valores"];
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
			$comple_sql.=" and ano = '".$n_contrato_ano."'";
			}
		if($_GET["campo"] != 0){
			$comple_sql.=" and id_campo = '".$_GET["campo"]."'";
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
<table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr class="fondo_3">
      
        <td colspan="6" align="center">Aprobaciones </td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="fondo_3">
        <td align="center">Numero de Aprobaci&oacute;n</td>
        <td width="9%" align="center">Contratos</td>
        <td width="5%" align="center">Contratistas</td>
        <td width="5%" align="center">A&ntilde;o</td>
        <td width="16%" align="center">Area / Proyecto</td>
        <td width="8%" align="center">Equivalente Aprobaciones<?=$moneda?>$</td>
        <td width="4%" align="center">TRM</td>
   </tr>
  <?

$cont = 0;
  $query_reporte = "select id_item from t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones where id_item > 0 and tipo in ('inicial', 'ampliacion', 'reclasificacion') and id_us= '".$id_usuario_reporte."' ".$comple_sql." order by id_item desc";
			
	
			
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
	 
		  $id_item_envia_funcion = $id_item_pecc;
		  

		  

  
			
	?>
 
      <?
  
  if($_GET["id_solicitud"]<>0){
	  $comple_sql = " and id_item=".$_GET["id_solicitud"];
	  }
  

  
 
  $tabla_aplica = "t2_reporte_marco_temporal_menos_reclasificaciones_ejecuciones";
  $sel_temporal_sql="select num_item,tipo,".$tabla_aplica.".id_item from ".$tabla_aplica.", t2_item_pecc as t2 where t2.id_item =".$tabla_aplica.".id_item and ".$tabla_aplica.".id_us = '".$id_usuario_reporte ."' and ".$tabla_aplica.".id_item =".$id_item_envia_funcion." ".$comple_sql." and tipo in ('inicial', 'ampliacion', 'reclasificacion') and (t2.estado >= 20 and t2.estado <=32 and t2.estado <> 31) group by num_item,tipo,".$tabla_aplica.".id_item order by id_item asc";
	 
	  
	  


  ?>
      
      
      
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
	  

	 $cuanta_cuantos_registros=query_db("select count(*) from ".$tabla_aplica." where id_us= '".$id_usuario_reporte."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') ".$comple_sql." group by id_us, tipo, id_item, contratos, ano, campo, id_campo, num_item, contratista, id_item_ots_aplica");
	 $cuantos_reg = 0;
	 while($cuant_re = traer_fila_db($cuanta_cuantos_registros)){
		 $cuantos_reg = $cuantos_reg + 1;
		 }
	 $convina_rowspan_columna_1=$cuantos_reg;////la columna donde estan los numeros de la solucitud
  



/*nuevo query*/

$sql_sel_ots = "select  id_us, id_us, tipo, id_item, CAST (contratos as text), ano, campo, sum(saldo_eq_usd), sum(saldo_eq_cop), id_campo, id_campo, num_item, CAST (contratista as text), id_item_ots_aplica from ".$tabla_aplica." where id_us= '".$id_usuario_reporte."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') ".$comple_sql." group by id_us, tipo, id_item, contratos, ano, campo, id_campo, num_item, contratista, id_item_ots_aplica";
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
		  
		  $contratista_remplac = str_replace("<div class=filas_resultados_reporte_saldos1>", "", $s_valores[12]);
		  $contratista_remplac = str_replace("<div class=filas_resultados_reporte_saldos2>", "", $contratista_remplac);
		  $contratista_remplac = str_replace("<span >", "", $contratista_remplac);
		  $contratista_remplac = str_replace("</span>,<br />", " ", $contratista_remplac);		  
		  $contratistas = str_replace("</div>", " ", $contratista_remplac);
	  ?>
      <tr id="fila_1-<?=$consecutivo?>" class="<?=$classe2?>" >
        
        <?
	if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		//$es_el_primero =1;
    ?>
        <td rowspan="<?=$convina_rowspan_columna_1?>" align="center" id="fila_7-<?=$consecutivo?>" class="<?=$classe2?>"><?=$sel_temp[0]?>
          <?   if($sel_item_masivo[0]<>""){echo "Carga Masiva";} ?></td>
        <?
      if($sel_temp[1]=="inicial2"){//si es iniicial
	  
	  echo '<td id="fila_8-'.$consecutivo.'"  rowspan="'.$convina_rowspan_columna_1.'" align="center" class="'.$classe2.'">'.$contratos.'</td>';
	  ?>
        
        <?
	  }else{
		   ?>
        <td align="center" class="<?=$classe2?>" ><?=$contratos?></td>
        <td align="center"><?=$contratistas?></td>
        <? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial2"){
		
		echo '<td align="center" class="'.$classe2.'">'.$contratos.'</td> <td align="center" class="'.$classe2.'">'.$contratistas.'</td>';
		?>
        
        <? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	
		$trm=trm_presupuestal($s_valores[5]);
	
	$valor_equivalente = 0;
	if($moneda == "USD"){
	$valor_equivalente = $s_valores[7] + ($s_valores[8]/$trm);
	$valor_equivalente =$s_valores[7];
	}
	if($moneda == "COP"){
	$valor_equivalente = $s_valores[8] + ($s_valores[7]*$trm);
	$valor_equivalente =$s_valores[8];
	}
	
	$valor_usd_t=$s_valores[7]+$valor_usd_t;
	$valor_cop_t=$valor_cop_t+$s_valores[8];
	$valor_eqi_t=$valor_equivalente+$valor_eqi_t;
	
	
  $valor_cop_total_liz = $valor_cop_total_liz + $s_valores[8];
  $valor_usd_total_liz = $valor_usd_total_liz + $s_valores[7];
  $valor_equ_total_liz = $valor_equ_total_liz + $valor_equivalente;
	
	
	
	 if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0 
         $comple_sql_ots =" and id_item_ots_aplica=0";
         }else{
             $comple_sql_ots =" and id_item_ots_aplica=".$sel_temp[2];
             }
			 
			 /*suma aprobaciones por solicitud*/
$valor_usd_saldo= 0;
$valor_cop_saldo= 0;
$valor_equivalente_saldo=0;
			  
/*suma aprobaciones por solicitud*/

/*suma ejecuciones*/
$solo_contratos = str_replace("<font color=blue>","",$contratos);
$solo_contratos = str_replace("<font color=#0000FF>","",$solo_contratos);
$solo_contratos = str_replace("</font>","",$solo_contratos);
$solo_contratos = str_replace("<div class=filas_resultados_reporte_saldos1>","",$solo_contratos);
$solo_contratos = str_replace("<div class=filas_resultados_reporte_saldos2>","",$solo_contratos);
$solo_contratos = str_replace("</div>","",$solo_contratos);
$solo_contratos = str_replace("<span >","",$solo_contratos);
$solo_contratos = str_replace("</span>","",$solo_contratos);
$solo_contratos = str_replace("<br/>","",$solo_contratos);
$solo_contratos = str_replace(" ","",$solo_contratos);
$solo_contratos = str_replace(",","",$solo_contratos);




				 $valor_usd_ots=0;
		  		$valor_cop_ots=0;
		  		$valor_equivalente_ots=0;
				$eq_usd_ots=0;
				

	  
		  
	  
	  	  
	 	 
	  ?>
        
        
        
        
        <td align="center"><?=$s_valores[5]?></td>
        <td align="center"><?=$s_valores[6]?></td>
        <td width="8%" align="center"><?=number_format($valor_equivalente,0,'','')?></td>
        <td width="4%" align="center"><?=number_format($trm,0,'','')?></td>
        
        <?
        
       // if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		$es_el_primero =1;
		
		$valor_usd_saldo= $s_valores[7]- $valor_usd_ots;
		  $valor_cop_saldo= $s_valores[8]-$valor_cop_ots;
		  $valor_equivalente_saldo=$valor_equivalente - $valor_equivalente_ots;
		  
		$valor_usd_ots_total=$valor_usd_ots + $valor_usd_ots_total;
		  $valor_cop_ots_total= $valor_cop_ots + $valor_cop_ots_total;
		  $valor_equivalente_ots_total=$valor_equivalente_ots + $valor_equivalente_ots_total;
		  
		  $convina_rowspan_columna_1=0;
    ?>
        <?
	  
	//}
        ?>
        
        
        </tr>
      
      
      <?
	  }
	?>
      
      
      
      
      
      
      <?
  }//fin while principal temporal
	?>
      
    
  <?
		 
	}			
   ?>

<?
		}
?>

</table>
</body>
</html>
<?
//if($_SESSION["id_us_session"] != 32){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Aprobaciones Area - Proyecto.xls"); 
//}

?>