<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$id_vari=$id_invitacion;
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));


$select_formula = traer_fila_row(query_db("select * from $t18 where pro1_id = $id_invitacion"));

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />


</head>
<body >

<table width="95%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td  class="titulos_procesos">Activar subasta inversa consolidada</td>
  </tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="62%" class="titulo_tabla_azul_sin_bordes"><div align="center">Requerimientos</div></td>
  </tr>
  <tr>
    <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
     
      <tr>
        <td width="40%">Activar Subasta inversa consolidada:
        </td>
        <td width="60%">
              <div align="left">
              <?
			  	$busca_activacion = traer_fila_row(query_db("select evaluador3_termino from  $t93 where in_id=$id_invitacion and evaluador3_termino = 10"));
			  	if($busca_activacion[0]==10) $selecciona = "checked";
			  ?>
                <input type="checkbox" name="activa_subasta" id="activa_subasta" value="10" <?=$selecciona;?> >
              </div>

</td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td><label>
      <input name="button2" type="button" class="guardar" id="button2" value="Guardar campos activaci&oacute;n de subasta inversa" onClick="activar_subasta_con()">
    </label></td>
  </tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td  class="titulos_procesos">Configurar campos obligatorios</td>
  </tr>
</table>
 
   
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="62%" class="titulo_tabla_azul_sin_bordes"><div align="center">Requerimientos</div></td>
  </tr>
  <tr>
    <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >

      <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
		if( ($l_campo[3]=="Numerico") || ($l_campo[3]=="Valor") ){
	 ?>
      <tr>
        <td width="40%"><?=$l_campo[2];?>        </td>
        <td width="60%"><label>
          <div align="left">
            <input type="checkbox" name="checkbox" id="checkbox">
            </div>
        </label>
          <label>
          <div align="left"></div>
        </label></td>
        </tr>
      <? } ?>
      <? 
	$numero++;
	
	}
	
	?>
    </table></td>
  </tr>
  <tr>
    <td><label>
      <input name="button" type="button" class="guardar" id="button" value="Guardar campos obligatorios" onClick="guardar_formula()">
    </label></td>
  </tr>
</table>
<br>
   <input type="hidden" name="id_multilista" value="<?=$id_multilista;?>">
   <input type="hidden" name="valor_campo">
<input type="hidden" name="campo_id">
	<input type="hidden" name="id_invitacion" value="<?=$id_vari;?>">


</body>
</html>
