<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
    
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td width="100%" class="fondo_4">Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n</td>
        </tr>
    </table>
    
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><strong><img src="../imagenes/botones/help.gif" alt="El contrato no tiene tarifas cargadas hasta el momento" width="18" height="18" title="El contrato no tiene tarifas cargadas hasta el momento" /></strong> <span class="letra-descuentos">Historico y aprobaciones pendientes, recuerde que para que la tarifa este activa, requiere ser aprobadada por Hocol. Para Ver el detalle de aprobaciones debe ingresar a la opcion de Aprobaciones Pendientes.</span></td>
        </tr>
      </table>
      <?
 
 
	 	$busca_categorias = "select distinct categoria from $v_t_5 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id not in (2,3) and estado_aprobacion = 1";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
	 
	 ?>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <? if(chop($lista_categoria[0])<>""){ ?>
        <tr>
          <td>
          	<table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="titulos_secciones"><?=$lista_categoria[0];?></td>
              </tr>
          </table>
          </td>
        </tr>
        <? } ?>

        <tr>
          <td><?
	 	$busca_grupos = "select distinct grupo from $v_t_5 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_estados_tarifas_id not in (2,3) and estado_aprobacion = 1";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
	
	 ?>
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                <? if(chop($lista_grupos[0])<>""){ ?>
                <tr >
                  <td colspan="5" class="fondo_4">GRUPO:<?=$lista_grupos[0];?></td>
                </tr>
                <? } ?>
                <tr>
                  <td width="27%" rowspan="2" class="fondo_3"><div align="center">Nombre generico del producto / servicio</div></td>
                  <td colspan="4" class="fondo_4"><div align="center" class="fondo_6">Estado de la tarifas actualizadas</div></td>
                </tr>
                <tr>
                  <td width="16%" class="fondo_4"><div align="center" class="fondo_6">Usuario</div></td>
                  <td width="7%" class="fondo_4">Estado</td>
                  <td width="14%" class="fondo_4"><div align="center" class="fondo_6">Fecha</div></td>
                  <td width="36%" class="fondo_4">Comentario</td>
                </tr>
                <?
	 	
		
		
		 $busca_detalle_agrupado = "select distinct t6_tarifas_lista_id from $v_t_5 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' 
		and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id not in (2,3) and estado_aprobacion = 1 
		";
		$sql_detalle_agupado=query_db($busca_detalle_agrupado);
		while($sql_detalle_agupado_sql=traer_fila_row($sql_detalle_agupado)){//detalle agrupado
		
		$busca_detalle = "select top(1) * from $v_t_5 where t6_tarifas_lista_id = $sql_detalle_agupado_sql[0]
		 and t6_tarifas_estados_tarifas_id not in (2,3) and estado_aprobacion = 1 
		order by t6_tarifas_aprobaciones_id desc";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		
		if($lista_detalle[12]==2){
		 $modificada = "NO";
		 $sql_ap=" t6_tarifas_estados_tarifas_id in (1,4,6)";
	 		$busca_detalle_padre = traer_fila_row(query_db("select valor from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_estados_tarifas_id = 1"));		 
		 }
		else{
		$modificada = "SI";
		$sql_ap=" t6_tarifas_estados_tarifas_id in (1,4,5)";
		}
	 	

			
	 ?>
                <tr class="filas_resultados">
                  <td><div align="center"><?=$lista_detalle[5];?></div></td>
                  
                  <?
				  $aprobacine_numero=0;
				$busca_detalle_unitario = "select top(1) * from $v_t_5 where t6_tarifas_lista_id = $sql_detalle_agupado_sql[0]
				order by t6_tarifas_aprobaciones_id desc";
				$sql_detalle_unitario=query_db($busca_detalle_unitario);
				while($lista_detalle_uni=traer_fila_row($sql_detalle_unitario)){//detalle
		
		?>
                  <td class="titulos_resumen_alertas"><?=$lista_detalle_uni[19];?></td>
                  <td class="titulos_resumen_alertas"><?=$lista_detalle_uni[24];?></td>
                  <td class="titulos_resumen_alertas"><?=fecha_for_hora($lista_detalle_uni[20]);?></td>
                  <td class="titulos_resumen_alertas"><?=$lista_detalle_uni[22];?></td>
                  <? $aprobacine_numero++;} 
				  
							  
				  ?>
                </tr>
                <? }//detalle 
				
				}//detalle agrupado
				?>
              </table>
              
              
        </td></tr>
            <br />
              <? }//grupos ?>
       
      </table>
    <? } ?>
    
</td></tr></table>

</body>
</html>
