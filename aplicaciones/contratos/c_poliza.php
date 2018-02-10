<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_poliza_arr = elimina_comillas(arreglo_recibe_variables($id_poliza));
	
		$busca_contacto = "select * from t7_contratos_contrato where id =". $id_contrato_arr."";
		$sql_com=traer_fila_row(query_db($busca_contacto));
$estado_contrato = $sql_com[27];

	if($id_poliza_arr==""){
		$id_poliza_arr=0;
	}
	$busca_poliza = "select id,id_contrato,tipo_poliza,tipo_moneda,valor,fecha_inicio,fecha_fin,aseguradora,estado,tipo_aseguradora,numero_modificacion from $co3 where id = $id_poliza_arr";
	$sql_pol=traer_fila_row(query_db($busca_poliza));
	
	$edita = 0;
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=12";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente ='".$sql_com[9]."'"));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/



	
	if(($sql_sel_permisos[0]>0 or $sel_contratos_gestiona[0] >0) and $estado_contrato != 33){
		$edita = 1;
	}
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}
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
        <td colspan="8" class="fondo_4">Creación de Póliza</td>
        </tr>
      <tr>
        <td width="13%" class="fondo_3"><div align="center">Tipo Póliza</div></td>
        <td width="10%" class="fondo_3"># Modificaci&oacute;n</td>
        <td width="10%" class="fondo_3"><div align="center">Tipo Moneda</div></td>
        <td width="11%" class="fondo_3"><div align="center">Valor Asegurado</div></td>
        <td width="10%" class="fondo_3"><div align="center">Fecha Inicio  (yyyy-mm-dd)</div></td>
        <td width="10%" class="fondo_3"><div align="center">Fecha Fin (yyyy-mm-dd)</div></td>
        <td colspan="2" align="center" class="fondo_3">Aseguradora
          <div align="center"></div></td>
        </tr>
      <tr>
        <td>
       
        <select name="tipo_poliza" id="tipo_poliza">
		<option value="0">Seleccione</option>
		<?
		$lista_poliza = "select t1t.id,t1t.nombre from $co2 t7c left join $g7 t1t on t7c.id_poliza = t1t.id where id_contrato = $id_contrato_arr";
		$sql_poliza=query_db($lista_poliza);
		while($lista_poliza=traer_fila_row($sql_poliza)){
			$sel  = "";
			if($sql_pol[2]==$lista_poliza[0]){
				$sel = "selected='selected'";
			}
		?>
    		<option value="<?=$lista_poliza[0];?>" <?=$sel;?>><?=$lista_poliza[1];?></option>
    	<?
		}
		?>
		</select>
        </td>
        <td><select name="numero_modificacion" id="numero_modificacion">
          <option value="0">Seleccione</option>
          <?
			$lista_poliza = "select id,numero_otrosi from $co4 where id_contrato=$id_contrato_arr and eliminado = 0";
			$sql_poliza=query_db($lista_poliza);
			while($lista_poliza=traer_fila_row($sql_poliza)){
				$sel  = "";
				if($sql_pol[10]==$lista_poliza[0]){
					$sel = "selected='selected'";
				}
			?>
			  <option value="<?=$lista_poliza[0];?>" <?=$sel;?>>
				<?=$lista_poliza[1];?>
				</option>
			  <?
			}
		?>
        </select></td>
        <td><select name="tipo_moneda" id="tipo_moneda">
           <?=listas($g5, " t1_moneda_id >=1",$sql_pol[3],'nombre', 1);?>
          </select></td>
        <td><input name="valor" type="text" id="valor" size="5"  onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" value="<?=valida_numero_imp($sql_pol[4]);?>" onKeyUp="puntos(this,this.value.charAt(this.value.length-1))"/></td>
        <td><input name="fecha_inicio" type="text" id="fecha_inicio" size="5" value="<?=$sql_pol[5];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly" /></td>
        <td><input name="fecha_fin" type="text" id="fecha_fin" size="5" value="<?=$sql_pol[6];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/></td>
        <td width="15%"><select name="tipo_aseguradora" id="tipo_aseguradora" onchange="activa_otroase(this.value)">
           <?=listas($g23, " estado = 1 ",$sql_pol[9],'orden', 1);?>
          </select></td>
          <?
		  if($sql_pol[9]!=5){
          	$display_aseguradora = "style='display:none'";
		  }
		  ?>
        <td width="21%"><div id="div_aseguradora" <?=$display_aseguradora;?> ><input name="aseguradora" type="text" id="aseguradora" size="5" value="<?=$sql_pol[7];?>"/></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
        <td>
        <input name="button2" type="button" class="boton_grabar" id="button2" value="Guardar Informaci&oacute;n P&oacute;liza" onclick="graba_informacion_poliza(<?=$id_poliza_arr;?>)"/></td>
        </tr>
      
      </table>
      <?
	}
	  ?>
      <br />
      <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="6" class="fondo_4">Observaci&oacute;n Poliza</td>
        </tr>
      <tr>
        <td colspan="6" class="fondo_3"><div align="center">Observaci&oacute;n</div></td>
        </tr>
        <?
        $busca_poliza_obs = "select * from $co5 where id_contrato = $id_contrato_arr order by id desc";
		$sql_pol_obs=traer_fila_row(query_db($busca_poliza_obs));
		?>
      <tr>
        <td colspan="6">
<? if($edita==1 ){?><textarea name="observaciones" id="observaciones" cols="45" rows="1"><?=$sql_pol_obs[3];?></textarea><? }else{?><input type="hidden" name="observaciones" id="observaciones" value="<?=$sql_pol_obs[3];?>" /><?=$sql_pol_obs[3];?><? }?></td>
        </tr>
      <tr>
        <td width="16%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="18%" align="right"><? if($edita==1 ){?><input name="button2" type="button" class="boton_grabar" id="button2" value="Guardar Observaci&oacute;n" onclick="graba_informacion_poliza2(<?=$id_poliza_arr;?>)"/><? }else{?> <input name="button" type="button" class="boton_email" id="button" value="Envia Email" onclick="graba_informacion_observacion()"/><? }?></td>
        </tr>
      
      </table>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <?
        
		$lista_poliza = "select distinct t1t.id,t1t.nombre from ".$co3." t7c left join ".$g7." t1t on t7c.tipo_poliza = t1t.id where  id_contrato = $id_contrato_arr";
		$sql_poliza=query_db($lista_poliza);
		while($lista_poliza=traer_fila_row($sql_poliza)){
		?>
        <tr>
          <td>
          <table width="99%" border="0" cellspacing="2" cellpadding="2">
          	<tr>
              <td class="titulos_secciones"><?=$lista_poliza[1];?></td>
            </tr>
          </table>
          </td>
        </tr>      
        <tr>
          <td>
          <table width="98%" border="0" align="right" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
            <tr>
              <td width="9%" class="fondo_3"># Modificaci&oacute;n</td>
              <td width="8%" class="fondo_3"><div align="center">Tipo Moneda</div></td>
              <td width="12%" class="fondo_3"><div align="center">Valor Asegurado</div></td>
              <td width="12%" class="fondo_3"><div align="center">Fecha Inicio</div></td>
              <td width="11%" class="fondo_3"><div align="center">Fecha Fin</div></td>
              <td colspan="2" class="fondo_3"><div align="center">Aseguradora</div></td>
              <td width="21%" class="fondo_3">&nbsp;</td>
              </tr>
              <?
        $lista_poliza_int = "select ".$co3.".id,".$co3.".id_contrato,".$co3.".tipo_poliza,".$co3.".tipo_moneda,".$co3.".valor,".$co3.".fecha_inicio,".$co3.".fecha_fin,".$co3.".aseguradora,".$co3.".estado,".$co3.".tipo_aseguradora,".$g5.".t1_moneda_id,".$g5.".nombre,".$g23.".nombre,".$g23.".id,t7c.numero_otrosi from ".$co3." left join ".$g5." on ".$g5.".t1_moneda_id = ".$co3.".tipo_moneda left join ".$g23." on ".$g23.".id=".$co3.".tipo_aseguradora left join ".$co4." t7c on t7_contratos_poliza.numero_modificacion=t7c.id where  ".$co3.".id_contrato = $id_contrato_arr and tipo_poliza = $lista_poliza[0] and ".$co3.".estado = 1";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		?>
            <tr class="filas_resultados">
              <td><?=$lista_poliza_int[14];?></td>
              <td><?=$lista_poliza_int[11];?></td>
              <td><?=valida_numero_imp($lista_poliza_int[4]);?></td>
              <td ><?=$lista_poliza_int[5];?></td>
              <td ><?=$lista_poliza_int[6];?></td>
              <td  width="11%" ><?=$lista_poliza_int[12];?></td>
              <td width="16%" >
			  <?
			  if($lista_poliza_int[13]==5){
	              echo $lista_poliza_int[7];
			  }
			  ?></td>
              <td class="titulos_resumen_alertas"><? if($edita==1 ){?><img src="../imagenes/botones/editar.jpg" alt="Editar Póliza" title="Editar Póliza" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/c_poliza.php?id_contrato=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_poliza=<?=arreglo_pasa_variables($lista_poliza_int[0]);?>','carga_acciones_permitidas')"/>&nbsp; <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar Póliza" title="Eliminar Póliza" width="16" height="16" onclick="elimina_poliza('<?=arreglo_pasa_variables($lista_poliza_int[0]);?>')"/><? }?>&nbsp;</td>
              </tr>
               <?
		}
		?>            
          </table>
          </td>
        </tr>
       
        <?
		}
		?>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <BR />
      
      
      
    </td>
  </tr>
</table>
<input name="id_poliza" type="hidden" value="<?=$id_poliza;?>" />
<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="<?=arreglo_pasa_variables($id_contrato_arr)?>" />
</body>
</html>