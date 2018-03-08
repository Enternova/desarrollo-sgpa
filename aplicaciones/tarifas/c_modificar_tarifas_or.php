<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
	
	if($sql_con[11]==2) $java_script="edita_tarifa_parcial";
	else $java_script="edita_tarifa";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION: <span class="titulos_resaltado_procesos">CONTRATO:
      <?=$sql_con[7];?>
    </span>    </span>&gt;&gt; ADMINISTRACION DE TARIFAS &gt;&gt; MODIFICAR DE TARIFAS</td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos');ajax_carga('../aplicaciones/tarifas/h_tarifas.php?id_contrato=<?=$id_contrato_arr;?>','carga_acciones_permitidas_inicio')" /></td>
  </tr>
</table>


<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" valign="top" class="fondo_2_sub">Seleccione una lista de este contrato</td>
  </tr>

  <tr>
    <td  valign="top">&nbsp;</td>
    <td colspan="2" valign="top" >&nbsp;</td>
  </tr>
    <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/c_modificar_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=' + this.value,'carga_acciones_permitidas')">
          <?=listas($t12, " tarifas_contrato_id = $id_contrato_arr",$lista_existentes,'nombre', 2);?>
          </select>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div align="right"></div></td>
    <td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="93%" valign="top"><div align="justify"><strong>Seleccione la lista a la que desea configurar descriptores o modificar las propiedades de la misma.</strong></div></td>
  </tr>  
</table>

<br />
<?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));


?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><strong>Usted a seleccionado la lista:<?=$buscar_lista[2];?></strong></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
      <br />
      <?

	$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){ ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel='se refiere a tarifas cargadas en el inicio del contrato' />Se refiere a tarifas cargadas en el inicio del contrato, <img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" /> se refiere a tarifas cargadas posteriormente del inicio del contrato</td>
  </tr>
</table>

<? } else { ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><div align="center">Esta lista  no tiene tarifas cargadas hasta el momento</div></td>
  </tr>
</table>

 <?
 } // si no tiene tarifas
 $nobre_categori_impri="";
 $inicio=0;
 $factor_b=7;
	 	$busca_categorias = "";


	 	echo $busca_detalle = "select * from (
								select * , ROW_NUMBER() OVER(ORDER BY categoria, grupo, fecha_creacion desc) AS rownum from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (1,2,5) and t6_tarifas_listas_lista_id = $lista_existentes 
								) as sub
	where rownum > $inicio and rownum <= $factor_b";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		
		
		if($nobre_categori_impri!=$lista_detalle[2]){//si la categoria es una sola
		 $nombre_boto+=1;
	 ?> 
      
     
     	<? if(chop($lista_detalle[2])<>""){ ?>
        <tr>
          <td>
          
          	<table width="99%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="titulos_secciones">
   <table width="98%" border="0">
  <tr>
    <td width="10%">Categoria: </td>
    <td width="47%"><input type="text" name="categoria_nueva_<?=$nombre_boto;?>" id="textfield" value="<?=$lista_detalle[2];?>" /></td>
    <td width="43%"><input name="categoria_<?=$nombre_boto;?>" type="button" class="boton_edicion" value="Editar categoria" onclick="edita_categoria(<?=$nombre_boto;?>)" />
    <input type="hidden" name="categoria_actual_<?=$nombre_boto;?>" id="categoria_actual_<?=$nombre_boto;?>"  value="<?=$lista_detalle[2];?>" /></td>
  </tr>
</table>
 
     </td>
            </tr>
          </table></td>
        </tr>
            <? }
			 }
	  		$nobre_categori_impri=$lista_detalle[2];
			
			 ?>        
        
        <tr>
          <td>

     <?
	 	$nombre_gupo_imprime="";

			if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo
		
	$titulos_atributos="";
	$ayuda_campo_editar='';	
	$grupo_edita+=1;
	 ?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <? if(chop($lista_detalle[3])<>""){ ?>
  <tr >
              <td colspan="12" class="fondo_4">
                 <table width="98%" border="0">
  <tr>
    <td width="5%">GRUPO:</td>
    <td width="52%"><input type="text" name="grupo_nueva_<?=$grupo_edita;?>"value="<?=$lista_detalle[3];?>" />
      <input type="hidden" name="grupo_actual_<?=$grupo_edita;?>" value="<?=$lista_detalle[3];?>" />
       <input type="hidden" name="categoria_actual_grupo_<?=$grupo_edita;?>"  value="<?=$lista_detalle[3];?>" />
      </td>
    <td width="12%">Mover a categoria:</td>
    <td width="19%" align="right"><input type="text" name="nueva_categoria_grupo_<?=$grupo_edita;?>" /></td>
    <td width="12%"><input name="grupo_<?=$grupo_edita;?>" type="button" class="boton_edicion" value="Editar grupo" onclick="edita_grupo(<?=$grupo_edita;?>)" /></td>
  </tr>
</table>
</td>
            </tr>
            <? } 
			
			} //si ya imprimio el grupo
		  $nombre_gupo_imprime=$lista_grupos[0];
			?>
      
      
      <tr >
              <td colspan="12" >
      
      
            
    
<?


	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<th  class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";

	} //lista atributos

?>  
                
					<table border=0 cellspacing="2" cellpadding="2" id="datos2" bgcolor="white" >                	

            <tr>
                            <th width="5%" class="fondo_3">Origen</th>
                            <th  class="fondo_3">Codigo</th>
                            <th  class="fondo_3">Nombre_generico_del_producto_/_servicio</th>
              
              <th width="5%" class="fondo_3"><div align="center">Unidad </div></th>
              <th width="6%" class="fondo_3">Moneda</th>
              <th width="8%" class="fondo_3"><div align="center">Valor_tarifa</div></th>
              <th width="11%" class="fondo_3">Inicio_vigencia</th>
              <th width="7%" class="fondo_3">Modificada</th>
              <th width="8%" class="fondo_3">Aprobaci&oacute;n</th>
              <th colspan="3" class="fondo_3">Administrar</th>
              <?=$titulos_atributos;?>
            </tr>
            
                 <?
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
	 	
		$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
//echo "select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]";
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td><input name="detalle_campo_descriptor_modifica_'.$lista_detalle[0].'['.$busca_valores[0].'-'.$lista_atr[0].']" type="text" id="nombre_nuevo_atributo" size="10" value="'.$busca_valores[3].'" class="campos_tarifas"  /></td>';
	
	} //lista atributos		
			
	 ?> 
            
            <tr class="<?=$class;?>" >
                                      <td height="30"><?=$tipo_creacion;?></td>
                        <td><input name="codigo_m_<?=$lista_detalle[0];?>" type="text" id="codigo" size="2"  value="<?=$lista_detalle[4];?>" /></td>
                        <td><textarea name="detalle_m_<?=$lista_detalle[0];?>" id="detalle" cols="25" rows="1" class="textarea_tarifas_300"><?=$lista_detalle[5];?></textarea></td>

              <td height="30"><div align="center"><input name="unidad_tarifa_<?=$lista_detalle[0];?>" type="text" class="campos_tarifas" value="<?=$lista_detalle[6];?>" size="5" /></div></td>
              <td class="titulos_resumen_alertas"><div align="center"><select name="moneda_tarifa_<?=$lista_detalle[0];?>" id="moneda"><?=listas($g5, " t1_moneda_id  >= 1",$lista_detalle[8],'nombre', 1);?></select></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
                <input name="valor_tarifa_<?=$lista_detalle[0];?>" type="text" id="valor_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[9];?>" class="campos_tarifas" />
              </div></td>
              <input name="cantidad_tarifa_<?=$lista_detalle[0];?>" type="hidden" value="0" class="campos_tarifas" />
              <td class="titulos_resumen_alertas"><input name="vigencia_tarifa_<?=$lista_detalle[0];?>" type="text" id="vigencia_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[14];?>" onmousedown="calendario_sin_hora('vigencia_tarifa_<?=$lista_detalle[0];?>')" class="campos_tarifas" /></td>
              <td class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/editar.jpg" alt="Editar tarifa" title="Editar tarifa" width="14" height="15" onclick="<?=$java_script;?>('<?=arreglo_pasa_variables($lista_detalle[0]);?>',document.principal.valor_tarifa_<?=$lista_detalle[0];?>)" /></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar tarifa" title="Eliminar tarifa" width="16" height="16" /></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/busqueda.gif" alt="ver ficha técnica de esta tarifa" title="ver ficha técnica de esta tarifa" width="16" height="16" /></td>

            <?=$ayuda_campo_editar;?>
            </tr>
           <? $num_fila++; }//detalle ?>
          </table>
          
          </td>
            </tr>
            <br />
          <? 
		
		 ?>
          
     
  </table>

      <?
	  
	  ?>
      </table>
      <? } //si ya selecciono una lista ?>
<input type="hidden" name="id_tarifa" />
<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
<input type="hidden" name="id_nombre_edita">
</body>
</html>
