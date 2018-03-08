<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

if($requeire_filtro_proveedores_tecnico_aceptados=="Si"){ //si requierre filtro 
$busca_proveedores_apectados = query_db("select * from $t13 where proc1_id = $id_invitacion");
while($lista_prove_apcet=traer_fila_row($busca_proveedores_apectados))
	{
		if($sql_e[20]<=$lista_prove_apcet[5])
			$pv_id_acep_tecnico.=",".$lista_prove_apcet[2];
	
	}
	
	 $filtro_provee_aceptados_tec = "and $t7.pv_id  in (0 ".$pv_id_acep_tecnico.")";
	
	} // si requierre filtro 


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">PASO 2: Seleccione el lugar de entrega y la plantilla de correos de notificaci&oacute;n a los usuarios de HOCOL S.A.</td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    </div></td>
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
</p>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td class="columna_titulo_resultados"><div align="center"><strong>Seleccione comprador</strong></div></td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Destino Final /Centro Log&iacute;stico</strong></div></td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Operadores Log&iacute;sticos</strong></div></td>
  </tr>
  <tr>
    <td><select name="sel1" id="sel1">
    <?=listas("pro26_adjudicacion_plantilla_notificaciones_mail", " pro25_id = 1","","nombre", 2);?>
    </select>
    </td>
    <td><select name="sel2" id="sel2">
    <?=listas("pro25_adjudicacion_plantilla_notificaciones", " destino_final = 2","","nombre_plantilla", 1);?>
        </select></td>
    <td><select name="sel3" id="sel3">
     <?=listas("pro25_adjudicacion_plantilla_notificaciones", " destino_final = 3","","nombre_plantilla", 1);?>
        </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><input type="button" name="button4" class="guardar" id="button4" value="Crear plantilla" onclick="crea_plantilla_copia()"></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?

	$busca_planti = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega from $v14 where pro1_id = $id_invitacion and destino_final = 2"));
	$busca_planti_entrega = traer_fila_row(query_db("select distinct pro25_id,  sitio_entrega, direccion_entrega from $v14 where pro1_id = $id_invitacion and destino_final = 3"));


?>
<table width="99%" border="0">
  <tr>
    <td width="21%" align="right">Proveedor entrega:</td>
    <td width="79%"><strong>
      <?=$busca_planti_entrega[1];?>
    </strong></td>
  </tr>
  <tr>
    <td align="right">Direcci&oacute;n entrega:</td>
    <td><?=$busca_planti_entrega[2];?></td>
  </tr>
  <tr>
    <td align="right">Destino final:</td>
    <td><strong>
      <?=$busca_planti[1];?>
    </strong></td>
  </tr>
  <tr>
    <td align="right">Direcci&oacute;n destino final:</td>
    <td><strong>
      <?=$busca_planti[2];?>
    </strong></td>
  </tr>
</table>

<? $busca_planti = "select distinct pro25_id, nombre_plantilla, sitio_entrega, direccion_entrega, destino_final, direccion_destino, otros_datos from $v14 where pro1_id = $id_invitacion ";
	$sql_plan = query_db($busca_planti);
	while($l_pan=traer_fila_row($sql_plan)){//busca plantillas envio


?>


<table width="99%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
  <tr>
    <td width="6%" align="center" class="columna_titulo_resultados"><strong>Admin</strong></td>
    <td width="4%" align="center" class="columna_titulo_resultados"><input type="checkbox" name="checkbox2" class="campos" id="checkbox2" onclick="cheque_todo(this.checked)"></td>
    <td width="53%" align="center" class="columna_titulo_resultados"><strong>Nombre</strong></td>
    <td width="37%" align="center" class="columna_titulo_resultados"><div align="center"><strong>E-mail de envio</strong></div></td>
  </tr>

<? 
$busca_planti_email_grupo = "select distinct grupo from $v14 where pro1_id = $id_invitacion and  pro25_id = $l_pan[0]";
	$sql_plan_email_gupo = query_db($busca_planti_email_grupo);
	while($l_pan_ema_grupo=traer_fila_row($sql_plan_email_gupo)){//busca grupos plantillas envio
if($l_pan_ema_grupo[0]!=""){
?>
  <tr>
    <td colspan="4" class="columna_titulo_resultados">Grupo: <?=$l_pan_ema_grupo[0];?></td>
  </tr>

<?
		 $busca_planti_email = "select pro28_id , email, nombre from $v14 where pro1_id = $id_invitacion and  pro25_id = $l_pan[0] and grupo = '$l_pan_ema_grupo[0]'";
			$sql_plan_email = query_db($busca_planti_email);
			while($l_pan_ema=traer_fila_row($sql_plan_email)){//busca plantillas envio
			 if($num_fila%2==0)
									$class="campos_blancos_listas";
								else
									$class="campos_gris_listas";

?>
  <tr class="<?=$class;?>">
    <td><div align="center"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar e-mail de envio" title="Eliminar e-mail de envio" width="16" height="16"  onClick="elim_email_ad(<?=$l_pan_ema[0];?>)"></div></td>
    <td><input type="checkbox" name="selec_email[<?=$l_pan_ema[0];?>]" class="campos" id="checkbox" ></td>
    <td align="left"><?=$l_pan_ema[2];?></td>
    <td align="left"><?=$l_pan_ema[1];?></td>
  </tr>

 
<? $num_fila++;} 
  
}// if

}//busca grupos plantillas envio
  ?>
  
    <tr class="<?=$class;?>">
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="<?=$class;?>">
      <td colspan="3"><input type="button" name="button3" class="cancelar" id="button3" value="Eliminar los marcados" onclick="elim_email_marcados()"></td>
      <td>&nbsp;</td>
    </tr>
    <tr class="<?=$class;?>">
      <td colspan="4"><table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="56%"><div align="right"><strong>Nuevo email (Solo para este proceso y plantilla):</strong></div></td>
          <td width="34%"><input type="text" name="nuevo_email<?=$l_pan[0];?>" id="nuevo_email<?=$l_pan[0];?>"></td>
          <td width="10%"><input type="button" name="button" class="guardar" id="button" value="Agregar E-mail" onclick="add_email(<?=$l_pan[0];?>)"></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<? } //busca plantillas envio ?>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="pv_id">
  
  <input type="hidden" name="id_anexo"></p>
</body>
</html>
