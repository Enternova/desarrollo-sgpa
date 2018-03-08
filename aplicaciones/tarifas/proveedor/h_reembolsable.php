<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
	
/*	
if($consec_bu!="")
	$arr_where .= " and consecutivo like '%$consec_bu%'";
if($municipio_bus>=1)
	$arr_where .= " and municipio = $municipio_bus";		
	*/
if($esatdo_bus>=1)	$arr_where .= " and estado = $esatdo_bus"; else{ $arr_where .= " and estado in (1,2)"; }


/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	  $sql_cuenta2 = "select  count(*) from   $v_t_11  where tarifas_contrato_id =  $id_contrato_arr  $arr_where";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: HISTORICO DE REEMBOLSABLES</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Contratos encontrados: <?=$sql_cuenta[0];?></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/tarifas/proveedor/h_reembolsable.php','carga_acciones_permitidas')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/proveedor/h_reembolsable.php','carga_acciones_permitidas')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/tarifas/proveedor/h_reembolsable.php','carga_acciones_permitidas')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="16%" class="columna_subtitulo_resultados">Consecutivo</td>
    <td width="24%" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="35%" class="columna_subtitulo_resultados"><div align="center">Municipio</div></td>
    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Ver detalle</div></td>
    <td width="4%" align="center" class="columna_subtitulo_resultados">Eliminar</td>
  </tr>
  
<?
$busca_item = "select * from (
select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado,  municipo, consecutivo, editado, numero_ediciones, ROW_NUMBER() OVER(ORDER BY t6_tarifas_reembolables_datos_id desc) AS rownum from $v_t_11  where tarifas_contrato_id =  $id_contrato_arr  ) as sub
where rownum > $inicio and rownum <= $factor_b $arr_where";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){


	if($ls_mr[6]==2) $estado="En firme - editado";
	elseif($ls_mr[3]==2) $estado="temporal";
	elseif($ls_mr[3]==1) $estado="En firme";
	elseif($ls_mr[3]==3) $estado="Eliminado Temporal";


	if($ls_mr[7]>=1)
				$version = " V".$ls_mr[7];
			else
				$version = "";

			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";

$fecha_cre= "";
					
$consecutivo_reembol="";							
							

$fecha_cre= explode("-",$ls_mr[2]);
					
$consecutivo_reembol="R- ".$ls_mr[5]." - ".$fecha_cre[0]." ".$version;							
				
						?>
                     
 
  
   <tr class="<?=$class;?>">
    <td ><?=$estado;?></td>
    <td ><?=$consecutivo_reembol;?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><div align="center"><?=$ls_mr[4];?></div></td>
    <td ><div align="center">
 <? if ($ls_mr[3]==2){ ?>
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/e_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=$ls_mr[0];?>','carga_acciones_permitidas');" />
 <? } else { ?>
   <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura_or=<?=$ls_mr[0];?>','carga_acciones_permitidas');" />
<? } ?>
</div></td>
    <td ><? if($ls_mr[3] == 2){?><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="valida_graba_reembolsable_temporal(<?=$ls_mr[0];?>)" /><? }?></td> 
  </tr>
  
  <? $num_fila++;} ?>
  
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
 <input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
 <input type="hidden" name="id_rem_elimina" />
</body>
</html>
