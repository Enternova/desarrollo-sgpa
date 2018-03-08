<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	if($id_municipio>=1){//si trae algo
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<div class="scroll_div">
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3" align="left"><strong>Proyectos del municipio seleccionado:</strong></td>
  </tr>
  <tr>
    <td align="right">Buscar proyecto:</td>
    <td align="left"><img src="../imagenes/botones/busqueda.gif" width="16" height="16" /></td>
    <td align="left"><input type="text" name="buscador_proyectos_pro" id="buscador_proyectos_pro" value="<?=$palabra_busqu_proy;?>" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_proyectos.php?id_municipio=' + document.principal.id_municipio.value + '&palabra_busqu_proy=' + document.principal.buscador_proyectos_pro.value,'carga_acciones_permitidas_municipios')" /></td>
    </tr>
 
    <? 
	if($palabra_busqu_proy !="")
		$cople_tari = " and proyecto like '%$palabra_busqu_proy%' ";
		
		$sql_proyectos = " select * from $t19 where t6_tarifas_municipios_id = $id_municipio and estado = 1 $cople_tari order by proyecto";
		$sql_ex=query_db($sql_proyectos);
		while($ls_pr=traer_fila_row($sql_ex)){ 
		
				     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
		?>
         <tr >
  <td width="17%" align="right">&nbsp;</td>
    <td width="2%" class="<?=$class;?>"><input name="ch_proyectos[]" type="checkbox" value="<?=$ls_pr[0];?>" class="campos_tarifas_otros"/></td>
    <td width="81%" class="<?=$class;?>"><?=$ls_pr[2];?></td>
  </tr>            
          <? $num_fila++; } ?>
    


</table>
</div>
<input type="hidden" name="id_municipio" value="<?=$id_municipio?>" />
<? } //si trae algo ?>
</body>
</html>