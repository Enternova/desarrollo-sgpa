<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	

	
$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
	
	
/*buscador*/
if($consec_bu!="")
	$arr_where .= " and consecutivo like '%$consec_bu%'";
if($municipio_bus>=1)
	$arr_where .= " and municipio = $municipio_bus";		
if($esatdo_bus>=1)	$arr_where .= " and estado = $esatdo_bus"; else{ $arr_where .= " and estado in (1,2)"; }

/*buscador*/
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

 	 $sql_cuenta2 = "select  count(*) from   $t16  where tarifas_contrato_id =  $id_contrato_arr $arr_where ";
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
    <td class="titulos_secciones">SECCION: HISTORICO DE TIQUETES DE SERVICIOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="titulos_secciones_tarifas">Buscador de tiquetes de servicios</td>
  </tr>
  <tr>
    <td width="24%" align="right"><strong>Consecutivo:</strong></td>
    <td width="33%">
    <input type="text" name="consec_bu" id="consec_bu" value="<?=$consec_bu;?>" /></td>
    <td width="17%" align="right"><strong>Estado:</strong></td>
    <td width="26%"><label for="esatdo_bus"></label>
      <select name="esatdo_bus" id="esatdo_bus">
        <option value="0">Seleccione</option>
        <option value="1" <? if($esatdo_bus==1) echo "selected"; ?> >En firme</option>
        <option value="2" <? if($esatdo_bus==2) echo "selected"; ?>>Temporal</option>
        <option value="3" <? if($esatdo_bus==3) echo "selected"; ?>>Temporal Eliminado</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><strong>Municipio:</strong></td>
    <td><select name="municipio_bus" id="municipio_bus" >
      <?=listas($t18, " estado = 1 ",$municipio_bus,'municipo', 2);?>
    </select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input name="button" type="button" class="boton_buscar" id="button" value="Buscar tiquetes de servicios" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/proveedor/h_prefactura.php','carga_acciones_permitidas')" /></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Contratos encontrados: <?=$sql_cuenta[0];?></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/proveedor/h_prefactura.php','carga_acciones_permitidas')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="10%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="8%" class="columna_subtitulo_resultados">Consecutivo</td>
    <td width="15%" class="columna_subtitulo_resultados"><div align="center">Fecha de creaci&oacute;n</div></td>
    <td width="13%" class="columna_subtitulo_resultados"><div align="center">Municipio</div></td>
    <td width="46%" class="columna_subtitulo_resultados"><div align="center">Proyecto</div></td>
    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Ver detalle</div></td>
    <td width="3%" align="center" class="columna_subtitulo_resultados">Eliminar</td>
  </tr>
  
<?
 $busca_item = "select * from (
select t6_tarifas_proveedor_prefactura_id, tarifas_contrato_id, fecha_creacion, estado, consecutivo, municipio, proyecto, ediciones,editado,ROW_NUMBER() OVER(ORDER BY consecutivo desc, ediciones desc) AS rownum from $t16  where tarifas_contrato_id =  $id_contrato_arr $arr_where ) as sub
where rownum > $inicio and rownum <= $factor_b ";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	if($ls_mr[8]==2) $estado="En firme - editado";
	elseif($ls_mr[3]==2) $estado="temporal";
	elseif($ls_mr[3]==1) $estado="En firme";
	elseif($ls_mr[3]==3) $estado="Temporal Eliminado";
	
	$lista_proyectos="";
				$busca_municipio=traer_fila_row(query_db("select * from $t18 where t6_tarifas_municipios_id = $ls_mr[5]"));
			$municipio_pre_text = $busca_municipio[2];  

	  	 $busca_proyectos="select proyecto from v_tarifas_municipio_proyecto_prefactura where t6_tarifas_prefactira_id = $ls_mr[0] and t6_tarifas_municipios_id = $ls_mr[5] order by proyecto";
		$sql_q=query_db($busca_proyectos);
	
	while($l_pro=traer_fila_row($sql_q)){
		//echo "select * from $t20 where t6_tarifas_prefactira_id = $ls_mr[0] and t6_tarifas_proyectos_id = $l_pro[0] <br>";
			//$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $ls_mr[0] and t6_tarifas_proyectos_id = $l_pro[0]"));
			
			$lista_proyectos.=$l_pro[0].", ";
			

				}

			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
			if($ls_mr[7]>=1)
				$version = " V".$ls_mr[7];
			else
								$version = "";
								
								
								
							
							
							$fecha_cre= explode("-",$ls_mr[2]);
							
							
						?>
                     
 
  
   <tr class="<?=$class;?>">
    <td ><?=$estado;?></td>
    <td >PRE- <?=$ls_mr[4];?> - <?=$fecha_cre[0]?> <?=$version;?></td>
    <td ><?=$ls_mr[2];?></td>
    <td ><div align="center"><?=$municipio_pre_text;?></div></td>
    <td><div align="center"><?=$lista_proyectos;?></div></td>
    <td ><div align="center">
 <? if ($ls_mr[3]==2){ ?>
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$ls_mr[0];?>','carga_acciones_permitidas');" /></div></td>
    <td align="center" ><? if($ls_mr[3] == 2){?><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" onclick="valida_graba_tiquete_temporal(<?=$ls_mr[0];?>)" /><? }?></td>
 <? } else { ?>
   <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$ls_mr[0];?>','carga_acciones_permitidas');" />
   

	 
<td width="0%"></td> 
<? } ?>
  </tr>
  
  <? $num_fila++;} ?>
  
  <tr>
    <td colspan="7" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<input type="hidden" name="pre_edita" />
<input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
<input type="hidden" name="id_pre_elimina" />


</p>
</body>
</html>
