<?  error_reporting("E_ERROR");
$host="192.168.1.85";
$usr="prueba";
$pwd="OOts871207";
$dbbase="Hocol_sgpa_2017feb28";


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
$ta22="t6_tarifas_reembosables1_contrato";
$ta23="t6_tarifas_reembolables_datos";
$ta24="t6_tarifas_reembolables_categoria";
$ta25="t6_tarifas_reembolables_datos_detalle";

$g5="t1_moneda";

$v_t_1="v_tarifas_contratos";
$v_t_2="v_tarifas_descuentos";
$v_t_3="v_tarifas_lista_estados";
$v_t_4="v_tarifas_aprobaciones";
$v_t_5="v_tarifas_historico";
$v_t_6="v_tarifas_cuenta_relacion";
$v_t_7="v_tarifas_lista_tarifas_completa";
$v_t_8="v_tarifas_listas_mestras";
$v_t_9="v_tarifas_reemblsable_principal";
$v_t_10="v_tarifas_municipio_proyecto";
$v_t_11="v_reembolsables_datos";


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

function elimina_comillas_especiales($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', '', $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('@', '', $id_subastas_arrglo);

		return $id_subastas_arrglo;
}

function arreglo_recibe_variables($variable){
			$id_pasa_arrglado = md5("clave_inicio");
			$id_pasa_arrglado_fina = md5("clave_final");

			$id_subastas_arrglo = str_replace($id_pasa_arrglado, "", $variable );
			$id_subastas_arrglo = str_replace($id_pasa_arrglado_fina, '', $id_subastas_arrglo);


			return $id_subastas_arrglo;

}

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

function arr_caracteres_imprime($valor){

$id_subastas_arrglo = str_replace("-", " - ",$valor); 
$id_subastas_arrglo = str_replace('"', ' ',$id_subastas_arrglo); 
		
		return htmlentities($id_subastas_arrglo);
}


  	$formato_numeros_miles = ",";
	$formato_numeros_decimales = ".";
$cantidad_decimales=5;
$cantidad_decimales_resto=2;
$stilo_excel = "mso-number-format:'#,##0._ 00000';";

function decimales_estandar($valor,$tipo)
	{
		global    	$formato_numeros_miles, $formato_numeros_decimales,$cantidad_decimales,$cantidad_decimales_resto;
		
		$arrglo_decimales = number_format($valor,$cantidad_decimales_resto,$formato_numeros_miles, $formato_numeros_decimales);
		
		$arrglo_decimales_2 = explode(",",$arrglo_decimales);
		$miles_arrglo = $arrglo_decimales_2[0];
		$decimales_arrg = $arrglo_decimales_2[1];
		$valida_decimales = ($decimales_arrg*1);
			if($valida_decimales>=1)
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
			else{
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
				//return $union_decimales = $miles_arrglo;
			}
		
	
		}

function decimales_estilo($valor,$tipo)
	{
		global    	$formato_numeros_miles, $formato_numeros_decimales,$cantidad_decimales;
		
		$arrglo_decimales = number_format(($valor),$cantidad_decimales,$formato_numeros_miles, $formato_numeros_decimales);
		$arrglo_decimales_2 = explode(",",$arrglo_decimales);
		$miles_arrglo = $arrglo_decimales_2[0];
		if($tipo==1) $stilo = "decimales_finales";
		if($tipo==2) $stilo = "decimales_finales_peq";		
		
		
		$decimales_arrg = $arrglo_decimales_2[1];
		$valida_decimales = ($decimales_arrg*1);
			if($valida_decimales>=1)
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
			else{
				return $union_decimales = $miles_arrglo.", ".$decimales_arrg;
				//return $union_decimales = $miles_arrglo;
			}
		//return $arrglo_decimales;
		
		}


	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_reembolsable_arr = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));


	$obejto_reempo_com = elimina_comillas_especiales($sql_con[9]);

	$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1";
	$busca_ree = traer_fila_row(query_db($busca_reembolsables));
	
	 $busca_item = "select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado, fecha_ini, fecha_fin, municipo, municipo ,porcentaje_administracion,tipo_contrato,orden_trabajo,consecutivo
	from $v_t_11  where t6_tarifas_reembolables_datos_id =  $id_reembolsable_arr ";	  
	$sql_ex = traer_fila_row(query_db($busca_item));
	
	if($sql_ex[3]==1)
	$estado_perefactura_final = " EN FIRME ";	
	elseif($sql_ex[3]==2)
	$estado_perefactura_final = " EN BORRADOR ";	
	elseif($sql_ex[3]==3)
	$estado_perefactura_final = " EN FIRME - EDITADO ";	
	
			$fecha_inicial = $sql_ex[4];
			$fecha_final = $sql_ex[5];

			$municipio_pre=$sql_ex[6];
			$proyecto_pre=$sql_ex[7];
			
			
$text='<table width="100%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td style="font-size:34px; "><div align="right"><strong>'.htmlentities($sql_con[6]).'<br>NIT: '.$sql_con[4].'</strong></div></td>
  </tr>


</table>
<br />';



$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Contrato:</strong> '.$sql_con[7].'</div></td>
  </tr>
   <tr>
    <td style="font-size:30px; "><div align="left"><strong>Rango del reembolsable:</strong>  '.$sql_ex[4].' al '.$sql_ex[5].'</div></td>
  </tr>  
   <tr>
    <td style="font-size:30px; "><div align="left"><strong>El contrato es tipo:</strong>  '; if($sql_ex[9]==1){ $text.='Marco | orden de trabajo:'.$sql_ex[10]; } else $text.='Normal';
	$text.='</div></td>
  </tr>  


  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Objeto del Contrato:</strong> '.arr_caracteres_imprime($obejto_reempo_com).'</div></td>
  </tr>
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Municipio:</strong> '.htmlentities($municipio_pre).'</div></td>
  </tr>


</table>
<br />';			

 $busca_lista_ree_proyecto = "select distinct t6_tarifas_municipios_proyectos_id, proyecto  from v_tarifas_reemblosables_detalle where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr";
	$sql_ree_poyecto = query_db($busca_lista_ree_proyecto);
	while($l_ree_proy=traer_fila_row($sql_ree_poyecto)){//lista reembola proyectos
$num_fila=0;


  	 $busca_lista_ree = "select * from $ta25 where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr and t6_tarifas_municipios_proyectos_id = $l_ree_proy[0]";
		$text.=' <table width="100%" border="0" cellspacing="4" cellpadding="4">';

  $text.='<tr>
    <td colspan="6" class="columna_titulo_resultados">PROYECTO: '.htmlentities(strtoupper($l_ree_proy[1])).'</td>
  </tr>';           
		   
		    $text.='<tr>
              <td width="20%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Categoria</div></td>
              <td width="10%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Item Oferta Proveedor</div></td>
              <td width="10%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Valor</div></td>
              <td width="5%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Moneda</div></td>
			  <td width="45%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Detalle</div></td>
              <td width="10%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Factura No.</div></td>
              </tr>';
            		
	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";	

			  	 
					$sql_ree = query_db($busca_lista_ree);
					while($l_ree=traer_fila_row($sql_ree)){//lista reembola
	
				
 			$text.='  <tr >
              <td '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; ">'.htmlentities(listas_sin_select($ta24,$l_ree[2],1)).'</td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right"></div></td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right">$ '.decimales_estilo($l_ree[5],2).'</div></td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" align="CENTER">'.listas_sin_select($g5,$l_ree[6],1).'</td>
			  <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" align="LEFT">'.htmlentities($l_ree[7]).'</td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($l_ree[8]).'</td>
            </tr>';
           $num_fila++; $total+= ($l_ree[5]*1); 
		   } // lista
$text.='</table>';
            $text.=' <table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
              <td  colspan="6" style=" font-size:20px; border-top: 1px dashed #ff9999; border-bottom: 1px dashed #ff9999; " align="CENTER">FINAL DE REEMBOLSABLES PARA EL PROYECTO: '.htmlentities($l_ree_proy[1]).'</td>
              
			</tr></TABLE>';
 }//lista reembola proyectos

		if($adm==1)
			$valor_admin = ($total*$sql_ex[8])/100;
	  	


if($adm!=3){//si aplica administra solo admisnitracion
$text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">

        <tr><td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">SUB TOTAL DEL REEMBOLSABLE: $ '.decimales_estilo($total,2).'</div></td></tr>
        ';
		if($adm==1){//si aplica administra
		
		$text.='<tr><td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">+ ADMINISTRACION ( % '.$sql_ex[8].') $ '.decimales_estilo($valor_admin,2).'</div></td></tr>';
		}

        $text.=' <tr><td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">TOTAL DEL REEMBOLSABLE: $ '.number_format(($total+$valor_admin),2).'</div></td></tr>		
      </table></p>';
	  		   					

      $text.='<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center">

        <tr>
          <td style="font-size:40px; border-top-color:#C7422F 2px;"><div align="center">Aprobado HOCOL SA </div></td>
        </tr>
      </table>';
}//si aplica administra solo admisnitracion  

else{//si aplica administra solo admisnitracion
$valor_admin = ($total*$sql_ex[8])/100;

$text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">';

		$text.='<tr><td style="font-size:30px; border-bottom-color:#C7422F 2px;"><div align="right">+ ADMINISTRACION ( % '.$sql_ex[8].') $ '.number_format($valor_admin,0).'</div></td></tr>
      </table></p>';
	  		   					

      $text.='<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center">

        <tr>
          <td style="font-size:40px; border-top-color:#C7422F 2px;"><div align="center">Aprobado HOCOL SA </div></td>
        </tr>
      </table>';


}//si aplica administra solo admisnitracion

				$fecha_cre= explode("-",$sql_ex[2]);
								
$consecutivo_reembol="R- ".$sql_ex[11]." - ".$fecha_cre[0]." ".$version;


$texto=$text;
$texto_pie=$text_pie;
$titulo = "REEMBOLSABLES - ".$estado_perefactura_final ;
$consecutivo_proceso=$consecutivo_reembol;
$fecha_hora_generacion=htmlentities("Fecha del reembolsable: ").fecha_for_hora($sql_ex[2]);
// create new PDF document
$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

$pdf->writeHTML($html, true, false, true, false, '');
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