<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">PROCESOS DE CONTRATACION</td>
  </tr>
</table>

<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="26"><strong>Consecutivo del proceso:</strong></td>
    <td width="26%"><div align="left"><?=$sql_e[22];?></div></td>
    <td width="22%"><strong>Tipo de proceso:</strong></td>
    <td width="22%"><div align="left"><?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div>    </td>
  </tr>
  <tr>
    <td height="26"><strong>Detalle y cantidad del objeto a contratar:</strong></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      </textarea>
    </div></td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa;?>','contenidos')">
    </label></td>
  </tr>
</table>
<br>
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Crear pregunta</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="2"><span class="texto_paginador_proveedor">Ayuda:</span> <strong>Desde aqu&iacute; solo se envian comunicados, los proponentes no pueden contestar estos mismos, si requiere aclaraciones finales lo puede hacer desde el modulo de evaluaci&oacute;n y apertura del proceso en el bot&oacute;n acalaraciones finales.</strong></td>
              </tr>
              <tr>
                <td width="25%"><div align="right"><strong>Comunicado / pregunta:</strong></div></td>
                <td><div align="left">
                  
                  <textarea name="pregunta_general" id="pregunta_general" cols="100" rows="5"></textarea>
                  
                </div>              </td>
              </tr>
              <tr>
                <td align="right"><strong>Anexo:</strong></td>
                <td><input name="h_m_r" type="hidden" class="f_fechas" id="h_m_r"  onMouseDown="calendario_se('h_m_r')" />                  <input type="file" name="anexo_re_general" id="anexo_re_<?=$ls_c[0];?>"></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Seleccione los proveedores:</strong></div></td>
                <td><div align="left">
                  <table width="98%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                    <tr>
                      <td width="4%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
                      <td width="13%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                      <td width="83%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                    </tr>
                    <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id order by $t8.razon_social");
				while($lp = traer_fila_row($busca_provee)){
			  
			  	$busca_participacion = traer_fila_row(query_db("select count(*) from $t7 where pv_id = $lp[0] "));
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
                    <tr class="<?=$class;?>">
                      <td><label>
                        <input type="checkbox" name="pv_id_carte[]" id="checkbox" value="<?=$lp[0];?>">
                      </label></td>
                      <td><div align="left">
                          <?=$lp[1];?>
                      </div></td>
                      <td><div align="left">
                          <?=$lp[2];?>
                      </div></td>
                    </tr>
                    <? $num_fila++;} ?>
                  </table>
                </div>                </td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                    <input name="button" type="button" class="guardar" id="button" value="Grabar y enviar pregunta" onClick="crea_pregunta_general_cartelera_admin()">
                  </div></td>
              </tr>
            </table>

</fieldset>
<br>
<fieldset style="width:98%">
			<legend>Historico de <strong>comunicado / pregunta</strong></legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="12%" class="columna_titulo_resultados">Fecha de notificaci&oacute;n</td>
                <td width="9%" align="center" class="columna_titulo_resultados">Anexo</td>
                <td width="73%" class="columna_titulo_resultados">Comunicado</td>
                <td width="6%" class="columna_titulo_resultados">&nbsp;</td>
              </tr>
              
              <?
			  	 $sele_car="select * from $t15 where pro1_id = $id_invitacion and tipo_aclaracio  = 2  order by fecha_pregunta desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				if($ls_c[7]==2) $solicitante = "HOCOL SA";
				else{
					$pv_id_pr_p = explode("|",$ls_c[2]);
					$busca_proveedor = traer_fila_row(query_db("select pv_id, razon_social from pv_proveedores where pv_id = $pv_id_pr_p[0]"));
					$solicitante= $busca_proveedor[1];
				}

  ?>
      <tr class="<?=$class_g;?>">
        <td><div align="center"><?=fecha_for_hora($ls_c[3]);?>
          </div></td>
                <td><? if($ls_c[11]!=""){?><div align="center"><img src="../imagenes/mime/<?=extencion_archivos($ls_c[11]);?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera_gene.php?n1=<?=$ls_c[0];?>&n2=<?=$ls_c[11];?>'" ></div><? } ?></td>
                <td><?=nl2br($ls_c[4]);?></td>
                <td>
                  <input name="button" type="button" class="buscar" id="button" onClick="ver_respuestas('div_for_<?=$ls_c[0];?>')" value="Ver   ">
				              </td>
              </tr>
			   
              <tr>
                <td colspan="4" id="div_for_<?=$ls_c[0];?>" style="display:none">
                <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2">                
                   
                 
                  <tr>
                    <td><div class="titulos_procesos">Proponentes notificados</div>
                      <p>&nbsp;</p>                      <?
					$arrglo_provee="";
					$pv_id_pr_p = explode("|",$ls_c[2]);
					 $cuenta_notificados = count($pv_id_pr_p);
					for($i=0;$i<($cuenta_notificados-1);$i++)
						{
							$arrglo_provee .=  $pv_id_pr_p[$i].",";
							
							}
					$busca_proveedor = query_db("select pv_id, razon_social from pv_proveedores where pv_id in ($arrglo_provee 0) order by razon_social");
					while($lista_pro_no = traer_fila_row($busca_proveedor))
						echo "<p>".$lista_pro_no[1]."</p>";
					?>
                    </td>
                  </tr>
                  <tr>
                    <td width="54%"><div align="center">&nbsp;
                      <input name="button3" type="button" class="cancelar" id="button3" value="Cerrar detalle" onClick="oculat_respuestas('div_for_<?=$ls_c[0];?>')">
                      
                    </div></td>
                  </tr>
                </table>                </td>
              </tr>
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_elimina">
<input type="hidden" name="ocu_re">

</body>
</html>
