<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');	

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_contacto_arr = elimina_comillas(arreglo_recibe_variables($id_contacto));
	
	if($id_contacto_arr==""){
		$id_contacto_arr=0;
	}
	
	$busca_contacto = "select * from $co6 where id = $id_contacto_arr";
	$sql_com=traer_fila_row(query_db($busca_contacto));
	
	$style1 = "style='display:none'";
	if($sql_com[2]==1){
		$style1 = "";
	}
	
	$busca_contrato = "select estado from t7_contratos_contrato where id =". $id_contrato_arr."";
		$sql_cont=traer_fila_row(query_db($busca_contrato));
		$estado_contrato = $sql_cont[0];
	
	$edita = 0;
	if($estado_contrato != 33){
		$edita = 1;
	}
	
	$disabled = "";
	
	/*$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$edita = 1;
	}
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
    <?
    if($edita==1){
	?>
    <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="4" class="fondo_4">Contacto</td>
        </tr>
      <tr>
        <td width="24%" align="right">Tipo Contacto:</td>
        <td width="23%"><select name="tipo_contacto" id="tipo_contacto" onchange="activa_contrcto_otro(this.value)">
          <?=listas($g18, " estado = 1 ",$sql_com[2],'nombre', 1);?>
          </select></td>
        <td width="24%" align="right">&nbsp;</td>
        <td width="29%">&nbsp;</td>
      </tr>
      <tr id="fila1" <?=$style1 ;?>>
        <td align="right">Cual:</td>
        <td><input name="cual" type="text" id="textfield5" size="5" value="<?=$sql_com[3];?>"/></td>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td align="right">Nombre:</td>
        <td><input name="nombre" type="text" id="nombre" size="5" value="<?=$sql_com[4];?>"/></td>
        <td align="right">Email:</td>
        <td><input name="email" type="text" id="email" size="5" value="<?=$sql_com[7];?>"/></td>
        </tr>
      <tr>
        <td align="right">Celular:</td>
        <td><input name="celular" type="text" id="celular" size="5" value="<?=$sql_com[5];?>"/></td>
        <td align="right">&Aacute;rea Geogr&aacute;fica:</td>
        <td><input name="area_geografica" type="text" id="area_geografica" size="5" value="<?=$sql_com[8];?>"/></td>
        </tr>
      <tr>
        <td align="right">Fijo:</td>
        <td><input name="fijo" type="text" id="fijo" size="5" value="<?=$sql_com[6];?>"/></td>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Contacto" onclick="graba_informacion_contacto(<?=$id_contacto_arr;?>)"/></td>
        </tr>
      
      </table>
      <?
	}
	  ?>
      <BR />
      
      
      
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="8" class="fondo_4">Contacto</td>
        </tr>
      <tr>
        <td width="13%" align="center" class="fondo_3">Usuario Creador</td>
        <td width="13%" align="center" class="fondo_3"><div align="center">Tipo Documento</div></td>
        <td width="9%" align="center" class="fondo_3">Nombre</td>
        <td width="11%" align="center" class="fondo_3"><div align="center">Celular</div></td>
        <td width="11%" align="center" class="fondo_3">Fijo</td>
        <td width="17%" align="center" class="fondo_3">Email</td>
        <td width="20%" align="center" class="fondo_3">Area Geografica</td>
        <td width="6%" align="center" class="fondo_3">&nbsp;</td>
        </tr>
        <?
       $lista_poliza_int = "select t7c.id,t7c.id_contrato,t7c.tipo_contacto,t7c.cual,t7c.nombre,t7c.celular,t7c.fijo,t7c.email,t7c.area_geografica,t1t.id,t1t.nombre,t1t.estado,t7c.estado,t7c.id_usuario_creador,t1u.nombre_administrador from ".$co6." t7c left join ".$g18." t1t on t7c.tipo_contacto = t1t.id left join $g1 t1u on t7c.id_usuario_creador = t1u.us_id where  id_contrato = $id_contrato_arr and t7c.estado = 1";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		?>
      <tr>
        <td><?=$lista_poliza_int[14];?></td>
        <td><?=$lista_poliza_int[10];?></td>
        <td><?=$lista_poliza_int[4];?></td>
        <td><?=$lista_poliza_int[5];?></td>
        <td align="center"><?=$lista_poliza_int[6];?></td>
        <td align="center"><?=$lista_poliza_int[7];?></td>
        <td align="center"><?=$lista_poliza_int[8];?></td>
     <td width="6%" align="right"><span class="titulos_resumen_alertas"><?
    if($edita==1){
	?><img src="../imagenes/botones/editar.jpg" alt="Editar" title="Editar" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/contacto.php?id_contrato=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_contacto=<?=arreglo_pasa_variables($lista_poliza_int[0]);?>','carga_acciones_permitidas')"/>&nbsp; <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar" title="Eliminar" width="16" height="16" onclick="elimina_contacto('<?=arreglo_pasa_variables($lista_poliza_int[0]);?>')"/><? }?>&nbsp;</span></td>
        </tr>
      <?
		}
	  ?>
    </table></td>
  </tr>
</table>
<input name="id_contacto" type="hidden" value="<?=$id_contacto;?>" />
</body>
</html>
