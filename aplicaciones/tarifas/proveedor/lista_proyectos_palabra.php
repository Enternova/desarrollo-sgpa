<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	
	if($palabra_clave_proyecto!=""){//si biene algo
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

<table width="98%" border="0">
  <tr>
    <td><p class="letra-descuentos">Para habilitar los proyectos, seleccione primero el  municipio de ejecuci&oacute;n del servicio que se muestra a continuaci&oacute;n en el  resultado de la b&uacute;squeda.</p></td>
  </tr>
</table>
<div class="scroll_div">
<table width="98%" border="0">

 
     <? echo $v_t_10;
	  $sql_proyectos = "select distinct municipo, t6_tarifas_municipios_id from $v_t_10 where t6_tarifas_municipios_id <> 6 and  proyecto like '%$palabra_clave_proyecto%'";
		$sql_ex=query_db($sql_proyectos);
		while($ls_pr=traer_fila_row($sql_ex)){ 
		
			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
				if($muni_sele==$ls_pr[1])
				{ $sele_op = "checked='checked' "; $disable=''; }
				else { $sele_op = ""; $disable='disabled="disabled"';}
		
		?>
  <tr class="<?=$class;?>">
    <td width="1%"><input <?=$sele_op;?> name="muni_selecci" type="radio"  class="campos_tarifas_otros" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos_palabra.php?palabra_clave_proyecto=' + document.principal.palabra_clave_proyecto.value + '&muni_sele=' + this.value,'resultado_busqueda_proyecto_clave'); ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos.php?id_municipio=','carga_acciones_permitidas_municipios');" value="<?=$ls_pr[1];?>"  /></td>
    <td  width="99%"><strong>Proyecto(s) en el municipio de: </strong><?=$ls_pr[0];?></td>
  </tr>
  
  <tr >
  	<td>&nbsp;</td>
    <td>
    
    	<table width="98%" border="0">

     <? $sql_proyectos_muni = "select * from $v_t_10 where t6_tarifas_municipios_id =  $ls_pr[1]";
		$sql_ex_pm=query_db($sql_proyectos_muni);
		while($ls_pr_mu=traer_fila_row($sql_ex_pm)){ ?>
              <tr class="<?=$class;?>">
                <td width="1%"><input name="ch_proyectos[]" type="checkbox" value="<?=$ls_pr_mu[3];?>" class="campos_tarifas_otros" <?=$disable;?>/></td>
                <td width="99%"><?=$ls_pr_mu[4];?></td>
              </tr>

          <? } //proyectos segun municipio ?> 
			</table>

          <? $num_fila++; } // municipios ?> 

</table>
</div>
<? } //si biene algo ?>
</body>
</html>
