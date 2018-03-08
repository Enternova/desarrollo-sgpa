<?
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	/***** PARA EL INC-008 *********/
	$estado="";
	$nombre_tipo_documento="";
	$nombre_tipo_proceso="";
	if(isset($tipo_seleccion)){
		$nombre_tipo_proceso=traer_fila_row(query_db("select nombre from $g13 where t1_tipo_proceso_id=$sel_item[6]"));
		$nombre_tipo_proceso=$nombre_tipo_proceso[0];
		$nombre_tipo_documento=traer_fila_row(query_db("select cast(nombre as text) from $g17 where t1_tipo_documento_id=".$_GET["tipo_seleccion"]));
		$nombre_tipo_documento=$nombre_tipo_documento[0];
		//echo $nombre_tipo_documento;
	}else{
		if($sel_item[14]!=31){
			$nombre_tipo_proceso=traer_fila_row(query_db("select nombre from $g13 where t1_tipo_proceso_id=$sel_item[6]"));
			$nombre_tipo_proceso=$nombre_tipo_proceso[0];
			//echo "SELECT t1.razon_social,t3.apellido, t2.valor_usd, t2.valor_cop, t4.nombre from t1_proveedor as t1, t2_presupuesto as t2, t2_presupuesto_proveedor_adjudica as t3, t1_tipo_documento as t4 where t3.t1_tipo_documento_id=t4.t1_tipo_documento_id and t1.t1_proveedor_id=t3.t1_proveedor_id AND t3.t2_presupuesto_id = t2.t2_presupuesto_id and t2.t2_item_pecc_id=$id_item_pecc";
			$result=traer_fila_row(query_db("SELECT t1.razon_social,t3.apellido, t2.valor_usd, t2.valor_cop, t4.nombre from t1_proveedor as t1, t2_presupuesto as t2, t2_presupuesto_proveedor_adjudica as t3, t1_tipo_documento as t4 where t3.t1_tipo_documento_id=t4.t1_tipo_documento_id and t1.t1_proveedor_id=t3.t1_proveedor_id AND t3.t2_presupuesto_id = t2.t2_presupuesto_id and t2.t2_item_pecc_id=$id_item_pecc"));
			$nombre_tipo_documento=$result[4];
			$result=traer_fila_row(query_db("SELECT t1.razon_social,t3.apellido, t4.nombre from t1_proveedor as t1, t2_presupuesto_proveedor_adjudica as t3, t1_tipo_documento as t4 where t3.t1_tipo_documento_id=t4.t1_tipo_documento_id and t1.t1_proveedor_id=t3.t1_proveedor_id and t3.t2_item_pecc_id_marco=$id_item_pecc"));
			if($nombre_tipo_documento=="" or $nombre_tipo_documento==null){
				$nombre_tipo_documento=$result[2];				
			}elseif($result[2]!="" or $result[2]!=null){
				$nombre_tipo_documento=$nombre_tipo_documento.", ".$result[2];
			}
			//echo $nombre_tipo_documento;
		}
		
	}
	//$nombre_tipo_proceso este es para colocar el nombre del proceso amarrado al t2_item_pecc, ferney sugiere se deje fija como adjudicación
	/***** PARA EL INC-008 *********/
?>
<table width="100%" cellpadding="2" cellspacing="2" style="border-radius: 10px; border-color: #229BFF; border-bottom: 2px solid #229BFF; border-top: 2px solid #229BFF; border-left: 2px solid #229BFF; border-right: 2px solid #229BFF; margin-bottom: -0px;">	
  <?
    	if(($nombre_tipo_documento!="" and $nombre_tipo_documento!=null) or ($nombre_tipo_proceso!="" and $nombre_tipo_proceso!=null)){
    		if($nombre_tipo_documento=="" or $nombre_tipo_documento==null){
    			$nombre_tipo_documento="A&uacute;n no se ha especificado";
    		}
    ?>
    	<tr style="border-radius: 10px; border-color: #005395;">
        	<td colspan="4" align="left" style="border-radius: 10px;">
        		<table border="0">
        			<td align="right"><i class="material-icons md-36" style="color: <?=$color_icono?>;">&#xE8FD;</i></td>
        			<td align="left">	
        				<h1 style="font-weight: 900;"><font size="3" face="roboto">Tipo de Esta Adjucicaci&oacute;n: <?=$nombre_tipo_documento?></font></h1>
        			</td>
        		</table>
        	</td>
        </tr>

    <?
    	}
    ?>
</table>
<br>