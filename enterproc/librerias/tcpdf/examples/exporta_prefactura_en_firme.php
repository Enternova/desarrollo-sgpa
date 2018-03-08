<?  error_reporting("E_ERROR");
$host="192.168.100.59";
$usr="us_hocol_sgpa";
$pwd="942ASvle*P";
$dbbase="hocol_sgpa_prueba";


/*


$host="MERCURIOSERVER\SQLEXPRESSE";
$usr="prueba2";
$pwd="123456";
$dbbase="db_sgpa_v1";
*/

$t1="t6_tarifas_contratos";
$t2="t6_tarifas_descuentos";
$t3="t6_tarifas_lista";
$t4="t6_tarifas_complemento_contrato";
$t5="t6_tarifas_estados_contratos";
$t6="t6_tarifas_estados_tarifas";
$t7="t6_tarifas_aprobaciones";
$t8="t6_tarifas_maestras_categoria";
$t9="t6_tarifas_maestras_descriptores";
$t10="t6_tarifas_maestras_lista";
$t11="t6_tarifas_maestras_relacion_tarifas";
$t12="t6_tarifas_listas_lista";
$t13="t6_tarifas_atributos";
$t14="t6_tarifas_listas_valores_atributos";
$t15="t6_tarifas_maestras_valores_descriptores";
$t16="t6_tarifas_proveedor_prefactura";
$t17="t6_tarifas_proveedor_prefactura_detalle";
$t18="t6_tarifas_municipios";
$t19="t6_tarifas_municipios_proyectos";
$t20="t6_tarifas_prefactura_proyectos";
$t21ta="t6_tarifas_prefactura_descunetos_proveedor";



$v_t_1="v_tarifas_contratos";
$v_t_2="v_tarifas_descuentos";
$v_t_3="v_tarifas_lista_estados";
$v_t_4="v_tarifas_aprobaciones";
$v_t_5="v_tarifas_historico";
$v_t_6="v_tarifas_cuenta_relacion";
$v_t_7="v_tarifas_lista_tarifas_completa";
$v_t_8="v_tarifas_listas_mestras";


$link = mssql_connect($host,$usr,$pwd);
$sel = mssql_select_db($dbbase,$link);
		
        function query_db($query)
                {
				global $link;
                $rs = mssql_query($query) ;
                if (!$rs) return 0;
                else return $rs;
                }
        function numfilas_db($rs)
                {
                return mssql_num_rows($rs);
                }
        function numcols_db($rs)
                {
                return mssql_num_fields($rs);
                }
        function traer_fila_db($rs)
                {
                $row = mssql_fetch_array($rs);
				return $row;
                }
		function traer_fila_row($rs)
                {
                $row = mssql_fetch_row($rs);
				return $row;
                }
		function traer_fila_objeto($rs)
                {
                $row = mssql_fetch_object($rs);
				return $row;
                }
				
				function traer_fila_individual($rs)
                {
                $row = mssql_fetch_assoc($rs);
				return $row;
                }
				function id_insert($sql)
                {
				$tra = traer_fila_individual($sql);
				return $tra['SCOPE_IDENTITY'];
                }

require_once('../tcpdf.php');

function fecha_for_hora($fecha_enviada)
	{
		global $fecha, $hora;
		
			$fecha_arr = explode(" ",$fecha_enviada);
			$fecha_arregla = explode("-",$fecha_arr[0]);
			
				if($fecha_arregla[1]=='01')
					$mes_arre = "Ene";
				if($fecha_arregla[1]=='02')
					$mes_arre = "Feb";
				if($fecha_arregla[1]=='03')
					$mes_arre = "Mar";
				if($fecha_arregla[1]=='04')
					$mes_arre = "Abr";
				if($fecha_arregla[1]=='05')
					$mes_arre = "May";
				if($fecha_arregla[1]=='06')
					$mes_arre = "Jun";
				if($fecha_arregla[1]=='07')
					$mes_arre = "Jul";
				if($fecha_arregla[1]=='08')
					$mes_arre = "Ago";
				if($fecha_arregla[1]=='09')
					$mes_arre = "Sep";
				if($fecha_arregla[1]=='10')
					$mes_arre = "Oct";
				if($fecha_arregla[1]=='11')
					$mes_arre = "Nov";
				if($fecha_arregla[1]=='12')
					$mes_arre = "Dic";
					
					return $fecha_arregla[2]." ".$mes_arre." ".$fecha_arregla[0]." ".$fecha_arr[1];
	
	}	

function elimina_comillas($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('.', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('a', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('e', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('i', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('o', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('u', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('@', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace(',', '', $id_subastas_arrglo);
		return $id_subastas_arrglo;
}

function arreglo_recibe_variables($variable){
			$id_pasa_arrglado = md5("clave_inicio");
			$id_pasa_arrglado_fina = md5("clave_final");

			$id_subastas_arrglo = str_replace($id_pasa_arrglado, "", $variable );
			$id_subastas_arrglo = str_replace($id_pasa_arrglado_fina, '', $id_subastas_arrglo);


			return $id_subastas_arrglo;

}

function elimina_comillas_2_inv($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', "", $id_subastas_arrglo);
		
		$id_subastas_arrglo = ereg_replace( "&aacute;", "á",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Aacute;",  "Á",$id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&eacute;","é",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Eacute;","É",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&iacute;","í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Iacute;","Í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&oacute;", "ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Oacute;", "Ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&uacute;", "ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Uacute;","Ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&ntilde;","ñ",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace(  "&Ntilde;","Ñ", $id_subastas_arrglo ); 
		
		return $id_subastas_arrglo;
}

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));

	if($sql_busca_temporal_pre_fa[14]==2) $estado_perefactura_final="EDITADO";
	elseif($sql_busca_temporal_pre_fa[4]==2) $estado_perefactura_final = " BORRADOR ";
	elseif($sql_busca_temporal_pre_fa[4]==1) $estado_perefactura_final = " FIRME ";	

			if($sql_busca_temporal_pre_fa[13]>=1)
				$version = " V ".$sql_busca_temporal_pre_fa[13];
			else
								$version = "";
								
$consecutivo_tiquete="PRE- ".$sql_busca_temporal_pre_fa[5]." - 2013 ".$version;

	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));

$aiu_a=$busca_aiu[2];
$aiu_a_p=$busca_aiu[3];
$aiu_i=$busca_aiu[4];
$aiu_i_p=$busca_aiu[5];
$aiu_u=$busca_aiu[6];
$aiu_u_p=$busca_aiu[7];



			
			$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
			if($id_prefactura_general>=1){ //si ya selecciono una lista
			$consecutivo_factura=$sql_busca_temporal_pre_fa[5];
			$municipio_pre=$sql_busca_temporal_pre_fa[6];
			$proyecto_pre=$sql_busca_temporal_pre_fa[7];
			$busca_municipio=traer_fila_row(query_db("select * from $t18 where t6_tarifas_municipios_id = $municipio_pre"));
			$municipio_pre_text = $busca_municipio[2];  
			 $busca_tarifa_tem="select rango_fecha_inicial, rango_fecha_final from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general order by t6_tarifas_proveedor_prefactura_detalle_id desc";
			$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));

			$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
			
			if(($busca_tari_tem[0]!="") && ($nueva_busqueda!=5) ){//si tiene tarifasa detalle
			$fecha_inicial=$busca_tari_tem[0];
			$fecha_final=$busca_tari_tem[1];
			}//si tiene tarifasa detalle
			
			
$text='<table width="100%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td style="font-size:34px; "><div align="right"><strong>'.htmlentities($sql_con[6]).'<br>NIT: '.$sql_con[4].'</strong></div></td>
  </tr>


</table>
<br />';

 	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){
			$crea_titulo_columna.='<td width="8%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Cantidad</td>';
			$lista_proyectos.=$l_pro[2].", ";
			}

				}

$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Contrato:</strong> '.$sql_con[7].'</div></td>
  </tr>
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Objeto del Contrato:</strong> '.htmlentities($sql_con[9]).'</div></td>
  </tr>
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Rango de fechas del servicio prestado:</strong> '.$busca_tari_tem[0].' al '.$busca_tari_tem[1].'</div></td>
  </tr>

  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Municipio: '.htmlentities($municipio_pre_text).'</strong> </div></td>
  </tr>



</table>
<br />';			

 
 $busca_proyectos_tarifas = "select * from v_tarifas_municipio_proyecto_prefactura where t6_tarifas_prefactira_id = $id_prefactura_general";
 $sql_proyectos_pre=query_db($busca_proyectos_tarifas);
 while($lista_proyectos_pre=traer_fila_row($sql_proyectos_pre)){//while para buscar proyectos de la prefactura e imprimir uno a uno
 
 $text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td style="font-size:30px; border-bottom-color:#C7422F 2px;">PROYECTO: '.htmlentities(strtoupper($lista_proyectos_pre[4])).'</td>
            </tr>
          </table>';
				
	 $busca_tarifa_tem_filtrar=query_db("select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_prefactura_proyectos_id = ".$lista_proyectos_pre[0] );
			while($filtra_ca=traer_fila_row($busca_tarifa_tem_filtrar))
				$id_lista_trae.=$filtra_ca[0].",";

	 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (1,7) and  t6_tarifas_lista_id in ($id_lista_trae 0) ";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
			$categoria_imprime="";

   $text.='  <table width="100%" border="0" cellspacing="4" cellpadding="4">';
     	if(chop($lista_categoria[0])<>""){ 
        $categoria_imprime='<spam style="font-size:30px;">Categoria: '.$lista_categoria[0].'</spam>';
            } 
        
       
        $text.='<tr>
          <td>';

	 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_estados_tarifas_id in (1,7) and  t6_tarifas_lista_id in ($id_lista_trae 0)  ";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
		$grupos_imprime="";
            if(chop($lista_grupos[0])<>""){ 
		           $grupos_imprime=' <spam style="font-size:30px; ">Grupo: '.$lista_grupos[0].'</spam>';
            } 

           $text.=$categoria_imprime.' | '.$grupos_imprime;
          
			$text.=' <br><table width="100%" border="0" cellspacing="2" cellpadding="2">';
   
            $text.='<tr>
              <td width="33%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Nombre generico del producto / servicio</div></td>
              <td width="12%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Valor</div></td>
              <td width="6%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Vigencia</div></td>
              
			  <td width="4%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Cant.</div></td>

              <td width="12%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Sub total</div></td>
              <td width="38%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Cargo Contable</div></td>';
              
			$text.='</tr>';
            

	 	$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final'  order by tarifa_padre, fecha_creacion";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';

		$cantidad="";
		$observa="";
		$sub_total=0;
	
	
$cantidad_item=0;
	
		$crea_campo_columna="";
		
/*	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";		
*/
	$class=" bgcolor=\"#CCCCCC\" ";
		
  //	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
//	$sql_q=query_db($busca_proyectos);
//	while($l_pro=traer_fila_row($sql_q)){
	//		$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
		//	if($busca_proyecto[0]!=""){ $chequeado="checked";
	 		$cantidad="";
			$observa="";
	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $lista_proyectos_pre[0]";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					if($busca_tari_tem[5]>=1){//si tiene valores
					$cantidad+=$busca_tari_tem[5];
					$cantidad_item+=$busca_tari_tem[5];
					$observa=$busca_tari_tem[10];
		
					
		
			$crea_campo_columna.='<td  '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$cantidad.'</td>';
			} //si tiene valores
			//}
			
		
	if($cantidad_item>=1){// si tiene valores
	
	$sub_total=($cantidad_item*$lista_detalle[9]);
	
	$total+=$sub_total;
	

			
			
			$text.=' <tr >
              <td '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lista_detalle[5]).'</td>
              <td  '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right">$ '.number_format($lista_detalle[9],0).' '.$lista_detalle[18].'</div></td>
              <td  '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$lista_detalle[14].'</td>';
              $text.=$crea_campo_columna;
              $text.='<td  '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" align="right">$ '.number_format($sub_total,0).' '.$lista_detalle[18].'</td>
              <td  '.$class.' style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($observa).'</td>
            </tr>';
           $busca_observa= "select t6_tarifas_proveedor_prefactura_observaciones_id, detalle from t6_tarifas_proveedor_prefactura_observaciones where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id = $lista_detalle[0]";
			$bus_ob_ta_r=traer_fila_row(query_db($busca_observa));
			
			if($bus_ob_ta_r[0]>=1){
	   
	     $text.='  <tr >
              <td colspan="6" style="font-size:24px;BORDER-BOTTOM: #CCCCCC 1px double; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comentarios a la tarifa: <strong>'.htmlentities($bus_ob_ta_r[1]).'</strong></td>
            </tr>';
			}
		   } // si tiene valores
		    }//detalle

	$num_fila++;} //while para buscar proyectos de la prefactura e imprimir uno a uno			
	
            $text.='<BR><tr>
              <td  colspan="6" style=" font-size:20px; border-top: 1px dashed #ff9999; border-bottom: 1px dashed #ff9999; " align="CENTER">FINAL DE TARIFAS PARA EL PROYECTO: '.htmlentities(strtoupper($lista_proyectos_pre[4])).'</td>
              
			</tr>';

			
		$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (7) and fecha_fin_vigencia >= '$fecha_inicial'  order by fecha_creacion desc";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	 		$cantidad="";
		$observa="";
		$sub_total=0;
	
	
		$cantidad_item=0;
	
		$crea_campo_columna="";
	

		
  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){ $chequeado="checked";
	 		$cantidad="";
			$observa="";
	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $busca_proyecto[0]";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					$cantidad+=$busca_tari_tem[5];
					$cantidad_item+=$busca_tari_tem[5];
					$observa=$busca_tari_tem[10];
		
					
		
			$crea_campo_columna.='<td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$cantidad.'</td>';
			}
			}
			
		
	if($cantidad_item>=1){// si tiene valores
	
	$sub_total=($cantidad_item*$lista_detalle[9]);
	
	$total+=$sub_total;
	

	    
     $text.='  <tr >
              <td '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lista_detalle[5]).'</td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right">$ '.number_format($lista_detalle[9],0).' '.$lista_detalle[18].'</div></td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$lista_detalle[14].'</td>';
              $text.=$crea_campo_columna;
              $text.='<td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" align="right">$ '.number_format($sub_total,0).' '.$lista_detalle[18].'</td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($observa).'</td>
            </tr>';
           $num_fila++;
		   } // si tiene valores
		    }//detalle
          $text.='</table>
            <br />';
           }//grupos 
          
          $text.='</td>
        </tr>
      </table>

      ';
        } 


     $text_pie=' <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td style="font-size:30px; "><strong>Observaciones del descuento:</strong> ';
		   if ($busca_descuento[3]!="") $text_pie.= htmlentities($busca_descuento[3]);
		    else $text_pie.=' Sin comentarios';
			$text_pie.='</td>
        </tr>
      </table>';

     

$text_pie.='<table width="100%" border="0" cellspacing="2" cellpadding="2">

        <tr>
          <td width="80%" style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">SUB TOTAL DEL TIQUETE DE SERVICIOS:</div></td>
          <td align="right" width="20%" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format($total,0).'</td>
        </tr>
        <tr>
          <td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">- DESCUENTO:</div></td>
          <td align="right" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format($busca_descuento[2],0).'</td>
        </tr>';
	        
			$subtotal_menos_descuentos = ($total-$busca_descuento[2]);
			
			 if( ($aiu_a==1) || ($aiu_a==2) ) {
			 
			 if($aiu_a==1) $op_a= "+";
			 if($aiu_a==2) $op_a= "-";
			 
			 $porcentaje_a = ($subtotal_menos_descuentos*$aiu_a_p)/100; 
			 $total_admini = $op_a.$porcentaje_a;
			
                     $text_pie.='<tr>
                      <td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">'.$op_a.' ADMINISTRACION('.$aiu_a_p.'%):</div></td>
                      <td align="right" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format($porcentaje_a,0).'</td>
                    </tr>';
			 }
			 
		 if( ($aiu_i==1) || ($aiu_i==2) ) {
			 
			 if($aiu_i==1) $op_i= "+";
			 if($aiu_i==2) $op_i= "-";
			 
			 $porcentaje_i = ($subtotal_menos_descuentos*$aiu_i_p)/100; 
			 $total_impr = $op_i.$porcentaje_i;
			  $text_pie.='<tr>
                      <td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">'.$op_i.' IMPREVISTOS('.$aiu_i_p.'%):</div></td>
                      <td align="right" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format($porcentaje_i,0).'</td>
                    </tr>';

			 
			 }
			 
		 if( ($aiu_u==1) || ($aiu_u==2) ) {
			 
			 if($aiu_u==1) $op_u= "+";
			 if($aiu_u==2) $op_u= "-";
			 
			 $porcentaje_u = ($subtotal_menos_descuentos*$aiu_u_p)/100; 
			 $total_utilidad = $op_u.$porcentaje_u;
			  $text_pie.='<tr>
                      <td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">'.$op_u.' UTILIDAD('.$aiu_u_p.'%):</div></td>
                      <td align="right" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format($porcentaje_u,0).'</td>
                    </tr>';
			 
			 }				 			 
      

        
        
        $text_pie.='<tr>
          <td  style="font-size:30px; border-bottom-color:#C7422F 2px;" align="right">TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td align="right" style="font-size:30px; border-bottom-color:#C7422F 2px;">$'.number_format(($subtotal_menos_descuentos+$total_admini+$total_impr+$total_utilidad),0).'</td>
        </tr>
        
        <tr>
          <td class="titulos_secciones">&nbsp;</td>
          <td class="titulos_secciones">&nbsp;</td>
        </tr>
      </table>	 ';
	  
	  
	 
	 

        $text_pie.=' </p></p></p></p></p>';

      $text_pie.='<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center">

        <tr>
          <td style="font-size:40px; border-top-color:#C7422F 2px;"><div align="center">Aprobado HOCOL SA </div></td>
        </tr>
      </table>';
        } //si ya selecciono una lista

$texto=$text;
$texto_pie=$text_pie;
$titulo = "TIQUETE DE SERVICIO ".$estado_perefactura_final;
$consecutivo_proceso=$consecutivo_tiquete;
$fecha_hora_generacion=htmlentities("Fecha del tiquete: ").fecha_for_hora($sql_busca_temporal_pre_fa[2]);
// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($sql_e[1]);
$pdf->SetTitle('Solicitud de Oferta de Servicios');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData("logo_cliente_email.png", PDF_HEADER_LOGO_WIDTH, $titulo, "Consecutivo: ".$consecutivo_proceso." \n".$fecha_hora_generacion);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(1, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)




// output some RTL HTML content
//$html.= '<div style="text-align:center">The words &#8220;<span dir="rtl">&#1502;&#1494;&#1500; [mazel] &#1496;&#1493;&#1489; [tov]</span>&#8221; mean &#8220;Congratulations!&#8221;</div>';
$html=$texto;



// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->AddPage();
$html=$text_pie;
$pdf->writeHTML($html, true, false, true, false, '');
//text_pie



// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// test pre tag


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Acta_proceso_'.$consecutivo_proceso.'pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+

?>




</body>
</html>