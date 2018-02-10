<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");
	
		
	 if($_GET["f_a"]!="")
	 	$complem.= " and  fecha_apertura >= '".$_GET["f_a"]."'";
	 
 	 if($_GET["f_c"]!="")
	 	$complem.= " and fecha_cierre <= '".$_GET["f_c"]."'";
 	 if($_GET["g_b"]>=1)
	 	$complem.= " and tp1_id = ".$_GET["g_b"];

 	 if($_GET["tp3_id_busq"]>=1)
	 	$complem.= " and tp3_id = ".$_GET["tp3_id_busq"];	
 	 if($_GET["tp2_id_bus"]>=1)
	 	$complem.= " and tp2_id = ".$_GET["tp2_id_bus"];	
 	 if($_GET["k_b"]>=1)
	 	$complem.= " and us_id = ".$_GET["k_b"];	
		
		$busca_profecio = traer_fila_row(query_db("select nombre_administrador from $t1 where us_id = $id_us_re "));
		
?>


<table width="98%" border="0" class="tabla_lista_resultados">
          <tr>
         <td align="right" >Estados de procesos de</td>
         <td align="left" ><strong>
           <?=$busca_profecio[0];?>
         </strong></td>
  </tr>

       <?
			 $busca_consolidado = "select nombre, count(*) from v_reporte_deatallado where us_id = $id_us_re $complem group by nombre ";
			$sql_ex_repor = query_db($busca_consolidado);
   			while($lista_proceso = traer_fila_row($sql_ex_repor )){
   ?>
      <tr>
        <td width="45%" align="right" class="columna_subtitulo_resultados"><?=$lista_proceso[0];?>:</td>
        <td width="55%"><?=$lista_proceso[1];?></td>
      </tr>
    <? } ?>
    </table>