<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_complemento_arr = elimina_comillas(arreglo_recibe_variables($id_complemento));
	
	if($id_complemento_arr==""){
		$id_complemento_arr=0;
	}
	
	$busca_complemento = "select id,id_contrato,tipo_complemento,tipo_otrosi,gerente,alcance,tiempo,tipo_moneda,valor,clausula,creacion_sistema,recibido_abastecimiento,sap,revision_legal,firma_hocol,firma_contratista,revision_poliza,legalizacion_final,estado,sap_e,revision_legal_e,firma_hocol_e,firma_contratista_e,revision_poliza_e,legalizacion_final_e,numero_otrosi,observaciones,fecha_inicio,acta_socios,recibido_poliza,camara_comercio,id_item_pecc,valor_cop,sel_representante,legalizacion_final_par,legalizacion_final_par_e,aplica_acta,recibo_poliza,fecha_informativa_e,fecha_informativa from $co4 where id = $id_complemento_arr";
	$sql_com=traer_fila_row(query_db($busca_complemento));
	$disable="";
	if($id_complemento_arr<>""){
		$id_item_pecc = $sql_com[31];
		if($id_item_pecc>0){
			$id_tipo_complemento = "1,2";
			$id_tipo_otro_si = "2,3,4";
			$edita2=1;
		}else{
			$id_tipo_complemento = "1,3,4";
			$id_tipo_otro_si = "8,9";
			$edita2=1;
		}

		$sel_usuario = "select * from $g1 where us_id = $sql_com[4]";
    	$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$nombre_generete = $sql_sel_usuario[1]."----,".$sql_sel_usuario[0]."----,";
	
		$style1 = "";	
		$style2 = "";	
		$style3 = "";	
		$style4 = "";
		$style5 = "";
		$style6 = "";
		$style7 = "";
		$style8 = "";	
		if($sql_com[3]==8){
			$disable = "disabled='disabled'";
		}
	}else{
		$style1 = "style='display:none'";	
		$style2 = "style='display:none'";	
		$style3 = "style='display:none'";	
		$style4 = "style='display:none'";
		$style5 = "style='display:none'";
		$style6 = "style='display:none'";
		$style7 = "style='display:none'";	
		$edita2=1;
		$id_tipo_complemento = "1,3,4";
		$id_tipo_otro_si = "8,9";
	}
	
	if($sql_com[2]==1){
		$style1 = "style='display:none'";	
	}
	if($sql_com[2]==2){
		$style2 = "style='display:none'";
	}
	if($sql_com[2]==3 || $sql_com[2]==4){
		$style3 = "style='display:none'";
	}
	
	
	if($sql_com[3]==2){
		$style4 = "style='display:none'";
	}
	if($sql_com[3]==3){
		$style5 = "style='display:none'";
	}
	if($sql_com[3]==4){
		$style6 = "style='display:none'";
	}
	if($sql_com[3]==8){
		$style7 = "style='display:none'";
	}
	if($sql_com[3]==9){
		$style8 = "style='display:none'";
	}
	
	$edita = 0;
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
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
        <td colspan="4" class="fondo_4">Creación de Modificaci&oacute;n</td>
        </tr>
      <?
      if($id_item_pecc>0){
		 $sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$id_item_pecc;
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
         $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$id_item_pecc));
		 
	  ?>
      <tr>
        <td align="left">Item</td>
        <td><img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$sel_item[0];?>&conse_div=0&permiso_o_adjudica=2')"><font color="#0000FF"><u>
        
           <?=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
         </u></font></strong></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
	  }
      ?>
      <tr>
        <td width="24%" align="left">Tipo Modificaci&oacute;n:</td>
        <td width="20%">
        
        
        <? if($edita2==1 ){?><select name="tipo_complemento" id="tipo_complemento" onchange="activa_otrosi(this.value)">
        
		<?=listas($g8, " estado = 1 and id in ($id_tipo_complemento) ",$sql_com[2],'nombre', 1);?>
        </select><? }else{?><input type="hidden" name="tipo_complemento" id="tipo_complemento" value="<?=$sql_com[2];?>" /><?=llena_valor_lista("id,nombre",$g8,"id=".$sql_com[2])?><? }?>
          
          </td>
        <td width="31%">&nbsp;</td>
        <td width="25%" align="center">&nbsp;</td>
        </tr>
      <tr id="fila1" <?=$style2;?> <?=$style3;?>>
        <td align="left">Tipo OtroSI:</td>
        <td>  <? if($edita2==1 ){?><select name="tipo_otrosi" id="tipo_otrosi" onchange="activa_otrosi_tipo(this.value)">
          <?=listas($g9, " estado = 1 and id in ($id_tipo_otro_si)",$sql_com[3],'nombre', 1);?>
          </select><? }else{?><input type="hidden" name="tipo_otrosi" id="tipo_otrosi" value="<?=$sql_com[3];?>" /><?=llena_valor_lista("id,nombre",$g9,"id=".$sql_com[3])?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr  id="fila2" >
        <td align="left" >Gerente:</td>
        <td><input name="gerente" type="text" id="gerente"  value="<?=$nombre_generete;?>" <?=$disable;?> onkeypress="selecciona_lista_general_irre('gerente','../librerias/php/usuarios_general.php')"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr id="fila3" <?=$style2;?> <?=$style3;?> <?=$style4;?> <?=$style5;?> <?=$style7;?> <?=$style8;?>>
        <td align="left">Alcance:</td>
        <td colspan="3"><? if($edita2==1 ){?><textarea name="alcance" id="alcance" cols="45" rows="4"><?=$sql_com[5];?></textarea><? }else{?><input type="hidden" name="alcance" id="alcance" value="<?=$sql_com[5];?>" /><?=$sql_com[5];?><? }?></td>
        </tr>
      <tr id="fila4" <?=$style1;?> <?=$style3;?> <?=$style8;?>>
        <td align="left" >Fecha Inicio:</td>
        <td><? if($edita2==1 ){?><input name="fecha_inicio" type="text" id="fecha_inicio"  value="<?=$sql_com[27];?>" onMouseOver="calendario_sin_hora(this.name)" readonly="readonly"/><? }else{?><input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?=$sql_com[27];?>" /><?=$sql_com[27];?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr id="fila5" <?=$style3;?> <?=$style5;?> <?=$style6;?> <?=$style7;?> <?=$style8;?>>
        <td align="left">Tiempo(Dias):</td>
        <td><? if($edita2==1 ){?><input name="tiempo" type="text" id="tiempo"  value="<?=$sql_com[6];?>" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"/><? }else{?><input type="hidden" name="tiempo" id="tiempo" value="<?=$sql_com[6];?>" /><?=$sql_com[6];?><? }?></td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr id="fila6" <?=$style3;?> <?=$style4;?> <?=$style6;?> <?=$style7;?> <?=$style8;?>>
        <td align="left">Valor COP:</td>
        <td><? if($edita2==1 ){?><input name="valor2" type="text" id="valor2"  value="<?=valida_numero_imp($sql_com[32]);?>" onkeypress="if (event.keyCode &lt; 48 || event.keyCode &gt; 57) event.returnValue = false;"  onkeyup="puntos(this,this.value.charAt(this.value.length-1))"/><? }else{?><input type="hidden" name="valor2" id="valor2" value="<?=$sql_com[32];?>" /><?=$sql_com[32];?><? }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr id="fila7" <?=$style3;?> <?=$style4;?> <?=$style6;?> <?=$style7;?> <?=$style8;?>>
        <td align="left">Valor USD:</td>
        <td><? if($edita2==1 ){?><input name="valor" type="text" id="valor"  value="<?=valida_numero_imp($sql_com[8]);?>" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"  onKeyUp="puntos(this,this.value.charAt(this.value.length-1))"/><? }else{?><input type="hidden" name="valor" id="valor" value="<?=$sql_com[8];?>" /><?=$sql_com[8];?><? }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      
      <tr id="fila8" <?=$style8;?>>
        <td align="left">Clausula:</td>
        <td colspan="3"><input name="clausula" type="text" id="clausula"  value="<?=$sql_com[9];?>"/></td>
        </tr>
        <tr id="fila9">
        <td align="left">Observaciones:</td>
        <td colspan="3"><label for="textarea"></label>
          <textarea name="observaciones" id="observaciones" cols="45" rows="1"><?=$sql_com[26];?></textarea></td>
        </tr>
         <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Modificaci&oacute;n" onclick="graba_informacion_complemento(<?=$id_complemento_arr;?>)"/></td>
        </tr>
     <?
      if($id_complemento_arr>=1){
	  ?>
      <tr>
        <td colspan="4" class="fondo_4">Registro Fechas:</td>
      </tr>
      <tr>
      <td colspan="4"><table width="100%">
        <?
        	$entro = 0;
			?>
       <tr>
              <td width="16%" valign="top">&nbsp;</td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td width="12%" align="center" valign="top"><strong>Entrega</strong></td>
              <td width="12%" align="center" valign="top"><strong>Recibo</strong></td>
              <td width="35%" align="center" valign="top"><strong>Observaciones</strong></td>
              <td width="13%" valign="top">&nbsp;</td>
            </tr>
        <tr>
          <td valign="top">1. Creaci&oacute;n Sistema</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top"><?=$sql_com[10];?></td>
          <td valign="top">&nbsp;</td>
          <td valign="top" >&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">2. Recibido Abastecimiento</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top"></td>
          <td valign="top"><?
                if ($sql_com[11]<>""){
                    echo $sql_com[11];
                }else{
                ?>
            <input name="recibido_abastecimiento" type="text" id="recibido_abastecimiento" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
          <?
                if ($sql_com[11]<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"recibido_abastecimiento");					
				}else{
					?>
					<textarea name="recibido_abastecimiento_obs" id="recibido_abastecimiento_obs" cols="5" rows="0"></textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if ($sql_com[11]=="" && $entro == 0){
                    $entro = 1;
                ?>
            <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'recibido_abastecimiento')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
          <td valign="top">3. SAP</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top"><?
                if (trim($sql_com[19])<>""){
                    echo $sql_com[19];
                    ?>
            <input name="sap_e" type="hidden" id="sap_e" size="15" maxlength="15" value="<?=$sql_com[19];?>"/>
            <?
                }else{
                    ?>
            <input name="sap_e" type="text" id="sap_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[12])<>""){
                    echo $sql_com[12];
                }else{
                    ?>
            <input name="sap" type="text" id="sap" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
       
           <?
                if (trim($sql_com[12])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"sap");					
				}else{
					?>
					   <textarea name="sap_obs" id="sap_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"sap");?></textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[12])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'sap')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
          <td valign="top">4. Revision Legal</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top"><?
                if (trim($sql_com[20])<>""){
                    echo $sql_com[20];
                    ?>
            <input name="revision_legal_e" type="hidden" id="revision_legal_e" size="15" maxlength="15" value="<?=$sql_com[20];?>"/>
            <?
                }else{
                    ?>
            <input name="revision_legal_e" type="text" id="revision_legal_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[13])<>""){
                    echo $sql_com[13];
                }else{
                    ?>
            <input name="revision_legal" type="text" id="revision_legal" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
         
            <?
                if (trim($sql_com[13])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"revision_legal");					
				}else{
					?>
					   <textarea name="revision_legal_obs" id="revision_legal_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"revision_legal");?>
					   </textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[13])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'revision_legal')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
          <td valign="top" >5. Firma Representante legal</td>
          <td colspan="2" valign="top" ><?
		 
                if($sql_com[33]!=""){
					?>
            <input type="hidden"  name="sel_representante" id="sel_representante" value="<?=$sql_com[33];?>" />
            <?
					if($sql_com[33]==1){
						echo "Contratista";						
					}else{
						echo "Hocol";
					}
				}else{
				?>
            <select name="sel_representante" id="sel_representante" onchange="carga_sel_representante(this.value);">
              <option value="0">Seleccione</option>
              <option value="1">Contratista</option>
              <option value="2">Hocol</option>
              </select>
            <?
				  }
                  ?></td>
          <td valign="top"><?
                if (trim($sql_com[21])<>""){
                    echo $sql_com[21];
                    ?>
            <input name="firma_hocol_e" type="hidden" id="firma_hocol_e" size="15" maxlength="15" value="<?=$sql_com[21];?>"/>
            <?
                }else{
                    ?>
            <input name="firma_hocol_e" type="text" id="firma_hocol_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[14])<>""){
                    echo $sql_com[14];
                }else{
                    ?>
            <input name="firma_hocol" type="text" id="firma_hocol" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
          
          <?
                if (trim($sql_com[14])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"firma_hocol");					
				}else{
					?>
					   <textarea name="firma_hocol_obs" id="firma_hocol_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"firma_hocol");?>
					   </textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[14])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'firma_hocol')"/>
            <?
                }
                ?></td>
        </tr>
        
           <?
             if($sql_com[33]==1){
				 if (trim($sql_com[14])<>""){
			?>
            <tr>
              <td valign="top">5.1. Aplica fecha Paralelo</td>
              <td width="3%" valign="top"><?
			  if(trim($sql_com[45])!=""){
					$che_paralelo = "checked='checked'";
				}
			  if($sql_com[33]==1){
						if (trim($sql_com[14])<>""){
							?>
                            <input type="checkbox" name="activa_fecha_paralelo" id="activa_fecha_paralelo"  value="1" onclick="activa_fecha_paralelo2();" <?=$che_paralelo;?>/>
							<?
						}
					}
			  ?></td>
              <td width="9%" valign="top">&nbsp;</td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td valign="top"></td>
            </tr>
            <?
				 }
			 }
			 ?>
            <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td colspan="2" valign="top">
            <div id="div_sel_representante">
              <? if($sql_com[14] != ""){ $dis_ca = "disabled='disabled'";;}?>
              <?
              if($sql_com[33]==1){
				?>
              <table width="100%">
                <tr>
                  <td width="47%" align="right"><font size="-2">Acta Socios:</font></td>
                  <td width="17%"><select name="aplica_acta" id="aplica_acta" <?=$dis_ca;?>>
                    <option value="1" <? if ($sql_com[36]==1){ echo "selected='selected'";}?> >SI</option>
                    <option value="2" <? if ($sql_com[36]==2){ echo "selected='selected'";}?> >NO</option>
                    </select></td>
                  <td width="6%"><input type="checkbox" name="acta_socios" id="acta_socios"  value="1"  <? if($sql_com[28] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> /></td>
                  <td width="30%">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="right"><font size="-2">Recibido P&oacute;lizas</font>:</td>
                  <td>&nbsp;</td>
                  <td><input type="checkbox" name="recibido_poliza" id="recibido_poliza"  value="1" <? if($sql_com[29] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?>/></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="right"><font size="-2">Camara y Comercio</font>:</td>
                  <td>&nbsp;</td>
                  <td><input type="checkbox" name="camara_comercio" id="camara_comercio" value="1" <? if($sql_com[30] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?>/></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="right"><font size="-2">Recibo de Polizas</font>:</td>
                  <td align="center">&nbsp;</td>
                  <td align="center"><input type="checkbox" name="recibo_poliza" id="recibo_poliza" value="1" <? if($sql_com[37] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                </table>
              <?  
			  }
			  ?>
              </div>
          </td>
          <td valign="top">&nbsp;</td>
          <td valign="top"></td>
        </tr>
       <?
            if($sql_com[33]==1){
				if(trim($sql_com[38])==""){
					$style1_paralelo = "style='display:none'";
				}
			?>
            <tr class="columna_subtitulo_resultados" id="fila_paralelo" <?=$style1_paralelo;?>>
              <td valign="top"><font size="-1">5.2. Fecha Proceso Paralelo</font></td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td align="center" valign="top"><input name="fecha_informativa_e" type="text" id="fecha_informativa_e" size="15" maxlength="15" onmouseover="calendario_sin_hora('fecha_informativa_e')" readonly="readonly" value="<?=$sql_com[38];?>"/></td>
              <td align="center" valign="top"><input name="fecha_informativa" type="text" id="fecha_informativa" size="15" maxlength="15" onmouseover="calendario_sin_hora('fecha_informativa')" readonly="readonly" value="<?=$sql_com[39];?>"/></td>
              <td valign="top"><textarea name="fecha_informativa_obs" id="fecha_informativa_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"fecha_informativa");;?></textarea>
					</td>
              <td valign="top"><input name="button5" type="button" class="boton_grabar" id="button5" value="Grabar Fecha" onclick="graba_fecha_contrato_parale(2,'fecha_informativa')"/>
              </td>
            </tr>
            <?
			}
			?>
        <tr>
          <td valign="top">6. Firma Representante legal </td>
          <td colspan="2" valign="top"><?
                if($sql_com[33]!=""){
					?>
            <input type="hidden"  name="sel_representante" id="sel_representante" value="<?=$sql_com[33];?>" />
            <?
					if($sql_com[33]==2){
						echo "Contratista";						
					}else{
						echo "Hocol";
					}
				}
				?></td>
          <td valign="top"><?
                if (trim($sql_com[22])<>""){
                    echo $sql_com[22];
                    ?>
            <input name="firma_contratista_e" type="hidden" id="firma_contratista_e" size="15" maxlength="15" value="<?=$sql_com[22];?>"/>
            <?
                }else{
                    ?>
            <input name="firma_contratista_e" type="text" id="firma_contratista_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[15])<>""){
                    echo $sql_com[15];
					$dis_ca = "disabled='disabled'";
                }else{
                    ?>
            <input name="firma_contratista" type="text" id="firma_contratista" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
         
           <?
                if (trim($sql_com[15])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"firma_contratista");					
				}else{
					?>
					    <textarea name="firma_contratista_obs" id="firma_contratista_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"firma_contratista");?>
					    </textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[15])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'firma_contratista')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
          <td align="right" valign="top"></td>
          <td colspan="2" align="right" valign="top"></td>
          <td colspan="2" align="right" valign="top">
            <? if($sql_com[28] == 1){ $dis_ca = "disabled='disabled'";;}?>
            <?
              if($sql_com[33]==2){
				?>
            <table width="100%">
              <tr>
                <td width="47%" align="right"><font size="-2">Acta Socios:</font></td>
                <td width="17%"><select name="aplica_acta" id="aplica_acta" <?=$dis_ca;?>>
                  <option value="1" <? if ($sql_com[36]==1){ echo "selected='selected'";}?> >SI</option>
                  <option value="2" <? if ($sql_com[36]==2){ echo "selected='selected'";}?> >NO</option>
                  </select></td>
                <td width="6%"><input type="checkbox" name="acta_socios" id="acta_socios"  value="1"  <? if($sql_com[28] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> /></td>
                <td width="30%">&nbsp;</td>
                </tr>
              <tr>
                <td align="right"><font size="-2">Recibido P&oacute;lizas</font>:</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="recibido_poliza" id="recibido_poliza"  value="1" <? if($sql_com[29] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?>/></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td align="right"><font size="-2">Camara y Comercio</font>:</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="camara_comercio" id="camara_comercio" value="1" <? if($sql_com[30] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?>/></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td align="right"><font size="-2">Recibo de Polizas</font>:</td>
                <td align="center">&nbsp;</td>
                <td align="center"><input type="checkbox" name="recibo_poliza" id="recibo_poliza" value="1" <? if($sql_com[37] == 1){ echo "checked='checked'";}?> <?=$dis_ca;?> <?=$disabled;?>/></td>
                <td>&nbsp;</td>
                </tr>
              </table>
            <?  
			  }
			  ?>
          </td>
          <td align="right" valign="top"></td>
          <td valign="top"></td>
        </tr>
        <tr>
          <td valign="top">7. Revision Polizas</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top"><?
                if (trim($sql_com[23])<>""){
                    echo $sql_com[23];
                    ?>
            <input name="revision_poliza_e" type="hidden" id="revision_poliza_e" size="15" maxlength="15" value="<?=$sql_com[23];?>"/>
            <?
                }else{
                    ?>
            <input name="revision_poliza_e" type="text" id="revision_poliza_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[16])<>""){
                    echo $sql_com[16];
                }else{
                    ?>
            <input name="revision_poliza" type="text" id="revision_poliza" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
         
          <?
                if (trim($sql_com[16])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"revision_poliza");					
				}else{
					?>
					     <textarea name="revision_poliza_obs" id="revision_poliza_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"revision_poliza");?>
					     </textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[16])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'revision_poliza')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
          <td valign="top">8. Legalizacion Final Contrato</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top"><?
                if (trim($sql_com[24])<>""){
                    echo $sql_com[24];
                    ?>
            <input name="legalizacion_final_e" type="hidden" id="legalizacion_final_e" size="15" maxlength="15" value="<?=$sql_com[24];?>"/>
            <?
                }else{
                    ?>
            <input name="legalizacion_final_e" type="text" id="legalizacion_final_e" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top"><?
                if (trim($sql_com[17])<>""){
                    echo $sql_com[17];
                }else{
                    ?>
            <input name="legalizacion_final" type="text" id="legalizacion_final" size="15" maxlength="15" onmouseover="calendario_sin_hora(this.name)" readonly="readonly"/>
            <?
                }
                ?></td>
          <td valign="top">
          
          <?
                if (trim($sql_com[17])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"legalizacion_final");					
				}else{
					?>
					    <textarea name="legalizacion_final_obs" id="legalizacion_final_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"legalizacion_final");?>
					    </textarea>
					<?
				}
				?>
          </td>
          <td valign="top"><?
                if (trim($sql_com[17])=="" && $entro == 0){
                    $entro = 1;
                    ?>
            <input name="button3" type="button" class="boton_grabar" id="button3" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'legalizacion_final')"/>
            <?
                }
                ?></td>
        </tr>
        <tr>
              <td valign="top">9. Legalizacion Final PAR</td>
              <td colspan="2" valign="top">&nbsp;</td>
              <td valign="top"><?
                if (trim($sql_com[35])<>""){
                    echo $sql_com[35];
                    ?>
                <input name="legalizacion_final_par_e" type="hidden" id="legalizacion_final_par_e" size="15" maxlength="15" value="<?=$sql_com[35];?>"/>
                <?
                }else{
                    ?>
                <input name="legalizacion_final_par_e" type="text" id="legalizacion_final_par_e" size="15" maxlength="15" onmouseover="calendario_sin_hora('legalizacion_final_par_e')" readonly="readonly"/>
                <?
                }
                ?></td>
              <td valign="top" ><?
                if (trim($sql_com[34])<>""){
                    echo $sql_com[34];
                }else{
                    ?>
                <input name="legalizacion_final_par" type="text" id="legalizacion_final_par" size="15" maxlength="15" onmouseover="calendario_sin_hora('legalizacion_final_par')" readonly="readonly"/>
                <?
                }
                ?></td>
              <td valign="top">
             
              <?
                if (trim($sql_com[34])<>""){
					echo imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"legalizacion_final_par");					
				}else{
					?>
					     <textarea name="legalizacion_final_par_obs" id="legalizacion_final_par_obs" cols="5" rows="0"><?=imprime_observacion(arreglo_pasa_variables($sql_com[1]),arreglo_pasa_variables($sql_com[0]),"legalizacion_final_par");?>
					     </textarea>
					<?
				}
				?>
              </td>
              <td valign="top"><?
                if (trim($sql_com[34])=="" && $entro == 0){
                    $entro = 1;
                    ?>
                <input name="button" type="button" class="boton_grabar" id="button" value="Grabar Fecha" onclick="graba_fecha_contrato(2,'legalizacion_final_par')"/>
                <?
                }
                ?></td>
            </tr>
      </table></td>
        </tr>
        <?
        }
		?>
     
      
      </table>
      <?
	}
	  ?>
      <BR />
      
      
      
    </td>
  </tr>
   <?
        $lista_poliza_int = "select t7c.id,t7c.id_contrato,t7c.tipo_complemento,t7c.tipo_otrosi,t7c.gerente,t7c.alcance,t7c.tiempo,t7c.tipo_moneda,t7c.valor,t7c.clausula,t7c.creacion_sistema,t7c.recibido_abastecimiento,t7c.sap,t7c.revision_legal,t7c.firma_hocol,t7c.firma_contratista,t7c.revision_poliza,t7c.legalizacion_final,t7c.estado,t7c.sap_e,t7c.revision_legal_e,t7c.firma_hocol_e,t7c.firma_contratista_e,t7c.revision_poliza_e,t7c.legalizacion_final_e,t7c.numero_otrosi,t7c.observaciones,t7c.fecha_inicio,t7c.acta_socios,t7c.recibido_poliza,t7c.camara_comercio,t7c.id_item_pecc,t7c.valor_cop,t1t.id,t1t.nombre,t1t.estado,t1to.id,t1to.nombre,t1to.estado,t1m.t1_moneda_id,t1m.nombre,t7c.legalizacion_final_par from ".$co4." t7c left join ".$g8." t1t on t7c.tipo_complemento = t1t.id left join ".$g9." t1to on t7c.tipo_otrosi = t1to.id left join ".$g5." t1m on t7c.tipo_moneda = t1m.t1_moneda_id  where  id_contrato = $id_contrato_arr";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		?>
  <tr>
    <td valign="top">
    <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      
      <tr class="fondo_3">
      <?
	  $valor_imp = "";
	  if($lista_poliza_int[8]>0){
			$valor_imp = $valor_imp." USD ".number_format($lista_poliza_int[8],0) ;
		}
			  if($lista_poliza_int[32]>0){
			$valor_imp = $valor_imp." COP ".number_format($lista_poliza_int[32],0);
		}
	 if($lista_poliza_int[6]>0){
			$valor_imp = $valor_imp." ".number_format($lista_poliza_int[6],0)." Meses";
		}

	  ?>
        <td width="24%" align="left"><?=$lista_poliza_int[34];?> <?  echo "No. ".$lista_poliza_int[25]." ".$lista_poliza_int[37]." ".$valor_imp;?></td>
        <td width="67%" align="left"><?=$lista_poliza_int[26];?></td>
        <td width="9%" align="right"><span class="titulos_resumen_alertas"><?
    if($edita==1){
	?><img src="../imagenes/botones/editar.jpg" alt="Editar" title="Editar" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/c_complemento.php?id_contrato=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_complemento=<?=arreglo_pasa_variables($lista_poliza_int[0]);?>','carga_acciones_permitidas')"/>&nbsp; <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar" title="Eliminar" width="16" height="16" onclick="elimina_complemento('<?=arreglo_pasa_variables($lista_poliza_int[0]);?>')"/>&nbsp;<? }?></span></td>
      </tr>
      <?
      if($lista_poliza_int[31]>=1){
	  ?>
       <tr>
        <td colspan="3">
        <?
		$sele_items_historico = "select $pi2.num1,$pi2.num2,$pi2.num3 from $pi2 where $pi2.id_item=".$lista_poliza_int[31];
		$sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
		 $sel_item = traer_fila_row(query_db("select t2_pecc_proceso_id from $pi2 where id_item=".$lista_poliza_int[31]));
        ?>
        <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /><strong onclick="abrir_ventana('../aplicaciones/comite/pecc/edicion-item-pecc.php?id_item_pecc=<?=$lista_poliza_int[31];?>&id_tipo_proceso_pecc=<?=$sel_item[0];?>&conse_div=0&permiso_o_adjudica=2')"><font color="#0000FF"><u>
        
           <?=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?>
         </u></font></strong>
        </td>
      </tr>
      <?
	  }
	  ?>
      <tr>
        <td colspan="3">
            <table width="100%">
                <tr >
                    <td width="41%" align="right"><font size="-2">Creaci&oacute;n Sistema:</font></td>
                    <td width="59%"><?=$lista_poliza_int[10];?></td>
                </tr>
                <tr>
                      <td align="right"><font size="-2">Recibido Abastecimiento:</font></td>
                      <td><?=$lista_poliza_int[11];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">SAP:</font></td>
                  <td><?=$lista_poliza_int[12];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Revision Legal:</font></td>
                  <td><?=$lista_poliza_int[13];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Firma Representante legal Hocol</font></td>
                  <td><?=$lista_poliza_int[14];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Firma Representante legal Contratista:</font></td>
                  <td><?=$lista_poliza_int[15];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Revison Polizas:</font></td>
                  <td><?=$lista_poliza_int[16];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Legalizacion Final Contrato:</font></td>
                  <td><?=$lista_poliza_int[17];?></td>
                </tr>
                <tr>
                  <td align="right"><font size="-2">Legalizacion Final PAR:</font></td>
                  <td><?=$lista_poliza_int[41];?></td>
                </tr>
            </table>
        </td>
       </tr>
     
      
    </table>
    </td>
  </tr>
 <?
		}
 ?>
</table>
<input name="id_complemento" type="hidden" value="<?=$id_complemento;?>" />
<input name="campo_fecha" type="hidden" />
</body>
</html>
