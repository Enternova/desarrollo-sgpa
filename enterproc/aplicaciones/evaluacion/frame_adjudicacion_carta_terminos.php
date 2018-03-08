<? include("../../librerias/lib/@session.php");
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	
	$busca_proveedor = traer_fila_row(query_db("select razon_social from pv_proveedores where pv_id = $pv_id"));

if($_POST["ac"]==1)
	{
	
		$cambia_estado_carta = query_db("update $t45 set carta = '$elm1' where pro1_id = $id_invitacion and pv_id = $pv_id and acepta_terminos = 1");
	
	
	}	

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>

<link type="text/css" rel="stylesheet" href="../../librerias/jquery/editor/jquery-te-1.4.0.css">
<script type="text/javascript" src="../../librerias/jquery/editor/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="../../librerias/jquery/editor/jquery-te-1.4.0.min.js" charset="8859-1"></script>

<link href="../../css/principal.css?o=1" rel="stylesheet" type="text/css">
</head>
<body >
<form name="pr_frame" method="post" action="frame_adjudicacion_carta_terminos.php">

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">PASO 3:Configure la carta de adjudicaci&oacute;n y los anexos por cada proveedor seleccionado</td>
    <td width="17%"><div align="left"><input type="button" name="button" class="cancelar" id="button" value="Volver" onClick="window.parent.ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso3.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')"></div></td>
  </tr>
  <tr>
    <td ><strong>Consecutivo:</strong> <span class="texto_paginador_proveedor">
      <?=$sql_e[22];?>
    </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><strong>Objeto:</strong>
        <?=$sql_e[12];?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div>
			<table width="1000" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="300"><input type="submit" name="button2" class="calcular" id="button2" value="       Grabar carta"></td>
                <td width="189">&nbsp;</td>
                <td width="491">&nbsp;</td>
              </tr>
            </table>
          <?
            $cambia_estado_carta = traer_fila_row(query_db("select * from $t45 where pro1_id = $id_invitacion and pv_id = $pv_id and acepta_terminos = 1"));
			?>
            
<textarea name="elm1" class="jqte-test"><?=$cambia_estado_carta[4];?></textarea>

		</div>

<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

<div id="carga_evaluacion"></div>

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">

<input type="hidden" name="id_anexo">
<input type="hidden" name="ac" value="1">
</form>
</body>
</html>
