<? include("../librerias/lib/@session.php");

header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	



//echo consecutivo_automatico_compra_crudo();

/***** PARA LA CONSULTA A LAS AREAS DE SQL SERVER ****/
//$host="MERCURIOSERVER\SQLEXPRESS";
//$usr="prueba";
//$pwd="OOts871207";
//$dbbase="Hocol_sgpa_2016oct07";
//$dbbase="Hocol_sgpa_2016dic27";
//$dbbase="Hocol_sgpa_2017feb28";
global $host, $usr, $pwd, $dbbase, $dominio_logue;
/** INICIO PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **
$link = mssql_connect($host,$usr,$pwd);
$sel = mssql_select_db($dbbase,$link);
function query_db_sql_server($query)
{
	$rs = mssql_query($query) ;
	if (!$rs) return 0;
	else return $rs;

}
function traer_fila_row_sql_server($rs)
{
	$row =  mssql_fetch_row($rs);
	return $row;
}*/
/***** PARA LA CONSULTA A LAS AREAS DE SQL SERVER ****/
/** FIN PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/



$id_proceso = elimina_comillas($id_p);



if($id_proceso!=""){
	$busca_procesos = "select * from $t5 where pro1_id = $id_proceso";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	$busca_responsable_a = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 0"));
	$busca_responsable_j = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 3"));
	$busca_responsable_t = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 2"));
	$busca_responsable_e = traer_fila_row(query_db("select * from $t11 where pro1_id = $id_proceso and tipo = 4"));
	$trm_vi = $sql_e[42];
	$busca_contacto = $sql_e[15];
	$entrega_doc_fisicos=$sql_e[8];
	$entrega_doc_fisicos=$sql_e[8];
	$entrega_doc_fisicos_etre=$sql_e[10];	
    $otro_contacto_notifica=$sql_e[44];
	$select_asiste_auditor = traer_fila_row(query_db("select count(*) from auditor_detalle where pro1_id = $id_proceso and auditor_categoria_id = 44"));
	
	$confir_objeto = $sql_e[45];
		if($confir_objeto==2) $selecciona_che = "checked";
		else $selecciona_che = "";
	


	}
	else { $trm_vi = $tr_configu; 
	$busca_contacto = $_SESSION["id_us_session"];
	$entrega_doc_fisicos="NO";
	$sql_e[19]=100;
	$sql_e[20]=100;	
	
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="popup2" align="center"><div id="pContent"></div></div>
<div id="oculta_todo_proveedores">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<br />
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="95%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Consecutivo del Proceso:</strong></div></td>
    <td><div class="texto_paginador_proveedor" id="alert_consecutivo" ></div>
	<? if($sql_e[7]>=1) { echo $sql_e[22]; ?>
     <input name="consecutivo" type="hidden" id="consecutivo" value="<?=$sql_e[22];?>" />
    <?
	}
	 elseif($sql_e[2]==200) { echo $sql_e[22]; ?>
     <input name="consecutivo" type="hidden" id="consecutivo" value="<?=$sql_e[22];?>" />
    <?
	}	
	else { echo $sql_e[22];  ?> <input name="consecutivo" type="hidden" id="consecutivo" value="<?=$sql_e[22];?>" /> <?  }?>
			
      <input name="trm_actual" type="hidden" id="trm_actual" value="<?=$trm_vi;?>" /></td>
    <td><div align="right"><strong>Tipo de Contrataci&oacute;n:</strong></div></td>
    <td><div align="left">
    
<? if($sql_e[7]>=1) { echo listas_sin_select($tp3,$sql_e[3],1);
	  ?>
	   <input name="tipo_solicitud" type="hidden" id="tipo_solicitud" value="<?=$sql_e[3];?>" />
	  <?
	  
	  }
  
			else { 		
			
			if($_SESSION["pv_principal"] != 150)
				$filtro_lista_contra =  " tp3_id not in (3)";
			if($_SESSION["pv_principal"] == 150)
				$filtro_lista_contra = " tp3_id	 in (3)";		
			?>
      <select name="tipo_solicitud" id="tipo_solicitud">
        <?=listas($tp3, $filtro_lista_contra,$sql_e[3],'nombre', 1);?>
      </select>
      <? } ?>
    
    </div></td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Tipo de Proceso:</strong></div></td>
    <td width="29%"><div align="left">
      <? if($sql_e[7]>=1) { echo listas_sin_select($tp2,$sql_e[2],1);
	  ?>
	   <input name="a" type="hidden" id="a" value="<?=$sql_e[2];?>" />
	  <?
	  
	  }
 	elseif($sql_e[2]==200) { echo listas_sin_select($tp2,$sql_e[2],1);
	  ?>
	   <input name="a" type="hidden" id="a" value="<?=$sql_e[2];?>" />
	  <?
	  
	  }		  
			else { 
			if($_SESSION["pv_principal"]==150){
				$sql_e[2] = 31;
				}
			if($sql_e[2] <=0){
				$sql_e[2] = 30;
				}
			echo listas_sin_select($tp2,$sql_e[2],1);
	  ?>
	   <input name="a" type="hidden" id="a" value="<?=$sql_e[2];?>" />
	  <? } ?>

      
     
    </div></td>
    <td width="17%"><div align="right"><strong>Usuario para Notificaci&oacute;n:</strong></div></td>
    <td width="34%"><div align="left">
      <select name="us_id_otro_contacto" id="us_id_otro_contacto">
        <?=listas_mayus($t1, " tipo_usuario <> 2 and tipo_usuario <> 10 and estado = 1 ",$otro_contacto_notifica,'nombre_administrador', 1);?>
            </select>
    </div></td>
  </tr>
  <!--  para el area si es sondeo -->
  <?
  if(($sql_e[2]==30 or $sql_e[2]=="") and $jeision=="Esto no esta cirbiendo por eso toco inhabilitarl, tampoco entiendo para que manda un area 999") {
  ?>
  <tr>
    <td ><div align="right"><strong>??rea Usuaria:</strong></div></td>
    <td><div align="left">
      <select name="id_tipo_proceso" id="id_tipo_proceso">
        <option selected="selected" value="0">Seleccione</option>
        <?
          $sel_profss = query_db_sql_server("select t1_area_id, nombre_html from t1_area where estado=1 order by nombre_html asc");
      while($se_area =traer_fila_row_sql_server($sel_profss)){
      ?>
      <option value="<?=$se_area[0]?>" <? if( $sql_e[46] ==$se_area[0]) echo 'selected="selected"'?>  >
        <?=$se_area[1]?>
        </option>
         
      <?
      }
      ?>
       </select>
    </div>
  </td>
    <td><div align="right"></div></td>
    <td><div align="left"></div></td>
  </tr>
  <?
}else{//si no es sondeo asiga el id del area como 999 ?>
<input name="id_tipo_proceso" type="hidden" id="id_tipo_proceso" value="999"/>
<?
}
  ?>
  <!--- fin para el area si es sondeo -->
  <?
  	if($sql_e[2]!=16){//si no es servicio menor
	?>
  <tr>
    <td ><div align="right"><strong><input type="hidden" value="1" name="confirma_objeto" />
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td colspan="3">
      <div align="left">
        <? if($sql_e[7]>=1)  { echo  nl2br($sql_e[12]); ?><input type="hidden" name="d" id="d" value="<?=$sql_e[12];?>" /><? } else {?><textarea name="d" cols="1" rows="2" id="d"><?=$sql_e[12];?></textarea><? }?>
      </div>    </td>
  </tr>

  <?
	}
  	if($sql_e[2]==16){//si  es servicio menor
	?>
	
	  <tr>
    <td ><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td colspan="3">
      <div align="left">
        <? if($sql_e[31]>=1){ echo $sql_e[12]; ?><input type="hidden" name="d" id="d" value="<?=$sql_e[12];?>" /><? } else {?><textarea name="d" cols="1" rows="2" id="d"><?=$sql_e[12];?></textarea><? }?>
      </div>    </td>
  </tr>

<? if($sql_e[31]==0){  ?>
	  <tr>
    <td colspan="4" ><div align="center" >
    
    
     <table width="100%" cellpadding="2" cellspacing="2" style="border-radius: 10px; border-color: #229BFF; border-bottom: 2px solid #229BFF; border-top: 2px solid #229BFF; border-left: 2px solid #229BFF; border-right: 2px solid #229BFF; margin-bottom: -0px;">	
  <?
    	
    ?>
    	<tr style="border-radius: 10px; border-color: #005395;">
        	<td colspan="4" align="left" style="border-radius: 10px;">
        		<table border="0">
        			<td align="left"><i class="material-icons md-36" style="color: <?=$color_icono?>;">&#xE8FD;</i></td>
        			<td align="left">	
        				<h1 style="font-weight: 900;"><font size="3" face="roboto"><strong>Nota:</strong>  Por favor revise y ajuste el campo objeto del servicio menor recuerde que ac&aacute; &uacute;nicamente va el objeto a contratar; si ya lo realizo a continuaci&oacute;n confirme la revisi&oacute;n</font></h1>
        			</td>
        		</table>
        	</td>
        </tr>

    
</table>
    
   </div>
       </td>
    </tr>
  
  	  <tr>
            <td ><div align="right"><strong>Confirmar revisi&oacute;n del objeto:</strong></div></td>
            <td align="left"><input name="confirma_objeto" type="checkbox" class="campo_normales_sint" id="confirma_objeto" value="2" <?=$selecciona_che;?> /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
      </tr>
<? } ?>

<?
	}//si  es servicio menor
	?>


</table>
<br />
<? if($id_proceso>=1){?>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
      <input name="button8" type="button" class="buscar" id="button8" value="Ingresar a la cartelera de aclaraciones" onclick="ajax_carga('cartelera-aclaraciones_<?=$id_proceso;?>.php','contenidos')"/>
      <input name="button3" type="button" class="buscar" id="button3" value="Ingresar a comunicaciones generales" onclick="ajax_carga('cartelera-comunicaciones_<?=$id_proceso;?>.php','contenidos')" />
   </td>
  </tr>
</table>
<? } ?>
</fieldset>
<br />

<fieldset style="width:98%">
			<legend>Cronograma del Proceso</legend>
            
            <table width="98%" border="0" cellpadding="3" cellspacing="3" class="tabla_cronograma" >
              <tr>
                <td width="28%" class="titulo_tabla_azul_sin_bordes">Cronograma</td>
                <td width="2%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Fecha Apertura</td>
                <td width="16%" class="titulo_tabla_azul_sin_bordes">Fecha Cierre</td>
                <td width="13%" class="titulo_tabla_azul_sin_bordes">% Global</td>
                <td width="11%" class="titulo_tabla_azul_sin_bordes">% M&iacute;nimo Aceptado</td>
                <td width="13%" class="titulo_tabla_azul_sin_bordes">Responsable</td>
              </tr>
              
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fechas de Apertura y Cierre General:</strong></div></td>
                <td>&nbsp;</td>
                <td>                  <input name="i" type="text" class="f_fechas" id="i" onmousedown="calendario_se('i')" value="<?=valida_fecha_vacia($sql_e[17]);?>" />                </td>
                <td><div align="center">
                  <input name="j" type="text" class="f_fechas" id="j" onmousedown="calendario_se('j')" value="<?=valida_fecha_vacia($sql_e[18]);?>" />
                </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><input name="h" type="hidden" class="f_fechas" id="h"  onmousedown="calendario_se('h')" value="<?=valida_fecha_vacia($sql_e[16]);?>" /><input name="a_j7" type="hidden" class="f_fechas" id="a_t_a" onmousedown="calendario_se('a_t_a')"  value="<?=valida_fecha_vacia($sql_e[37]);?>"/><input name="a_j8" type="hidden" class="f_fechas" id="a_t_c" onmousedown="calendario_se('a_t_c')" value="<?=valida_fecha_vacia($sql_e[38]);?>"/></td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Periodo de Aclaraciones:</strong></div></td>
                <td><img src="../imagenes/botones/2.gif" width="16" height="16" onclick="copia_fechas(1)" /></td>
                <td><div align="center">
                  <input name="fecha_informativa" type="text" class="f_fechas" id="fecha_informativa" onmousedown="calendario_se('fecha_informativa')" value="<?=valida_fecha_vacia($sql_e[29]);?>" />
                </div></td>
                <td><div align="center">
                  <input name="fecha_informativa_f" type="text" class="f_fechas" id="fecha_informativa_f" onmousedown="calendario_se('fecha_informativa_f')" value="<?=valida_fecha_vacia($sql_e[34]);?>"  />
                </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td ><div align="right"><strong>Fecha y Hora de Reuni&oacute;n Informativa:</strong></div></td>
                <td >&nbsp;</td>
                <td ><input name="fecha_reu_info" type="text" class="f_fechas" id="fecha_reu_info" onmousedown="calendario_se('fecha_reu_info')" value="<?=valida_fecha_vacia($sql_e[41]);?>"/></td>
                <td ><div align="right"><strong>Asistencia obligatoria:</strong></div></td>
                <td>
                <select name="l" id="l">
                <option value="" <? if($entrega_doc_fisicos=="") echo "selected"; ?>>Seleccione</option>
                <option value="Si" <? if($entrega_doc_fisicos=="Si") echo "selected"; ?>>Si</option>
                <option value="No" <? if($entrega_doc_fisicos=="No") echo "selected"; ?>>No</option></select>				</td>
                <td >&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
              <tr>
                <td ><div align="right"><strong>Lugar de Reuni&oacute;n Informativa</strong>:</div></td>
                <td >&nbsp;</td>
                <td colspan="5" ><input name="direccion_info" type="text" id="direccion_info" value="<?=$sql_e[30];?>" /></td>
              </tr>
              <tr class="campos_gris_cronograma">
                <td ><div align="right"><strong>Fechas de Recepci&oacute;n Ofertas T&eacute;cnicas:</strong></div></td>
                <td ><img src="../imagenes/botones/2.gif" alt="Copiar fechas generales" width="16" height="16"  onclick="copia_fechas(4)"/></td>
                <td ><div align="center">
                  <input name="a_t" type="text" class="f_fechas" id="a_t"  onmousedown="calendario_se('a_t')"  value="<?=valida_fecha_vacia($sql_e[25]);?>"/>
                </div></td>
                <td ><div align="center">
                  <input name="c_t" type="text" class="f_fechas" id="c_t" onmousedown="calendario_se('c_t')"  value="<?=valida_fecha_vacia($sql_e[26]);?>"/>
                </div></td>
                <td><div align="center">
                  
                  <input name="p_t" type="text" id="p_t"  value="<?=valida_fecha_vacia($sql_e[19]);?>" size="3" />
                </div>                  <div align="center"></div></td>
                <td ><div align="center">
                  <input name="m_t" type="text" id="m_t"  value="<?=valida_fecha_vacia($sql_e[20]);?>" size="3" />
                </div>                  <div align="center"></div></td>
                <td >
                
                <select name="responsable_tec" id="responsable_tec">
                <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " tipo_usuario <> 2 and estado = 1 and us_id <> ".$_SESSION["id_us_session"]." ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
						
						
						
					?>
                
                  <?=listas_mayus($t1, $traer_tecnicos_compras,$busca_responsable_t[1],'nombre_administrador', 1);?>
                </select></td>
              </tr>
              
              <tr class="campos_blancos_cronograma">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td><div align="right"><strong>Fechas Recepci&oacute;n Ofertas Econ&oacute;micas:</strong></div></td>
                <td><img src="../imagenes/botones/2.gif" width="16" height="16" onclick="copia_fechas(2)" /></td>
                <td><div align="center"> <input name="a_j" type="text" class="f_fechas" id="a_j" onmousedown="calendario_se('a_j')" value="<?=valida_fecha_vacia($sql_e[23]);?>"/> </div></td>
                <td><div align="center"> <input name="c_j" type="text" class="f_fechas" id="c_j" onmousedown="calendario_se('c_j')" value="<?=valida_fecha_vacia($sql_e[24]);?>"/> </div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><select name="respo_juridico" id="respo_juridico">
      <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " pv_principal =100 and estado = 1  ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
						
						if($busca_responsable_j[1] == "" or $busca_responsable_j[1] == ""){
							$busca_responsable_j[1] = $busca_contacto;//si no tiene tecnico relacionado, por defecto selecciona el profesional asignado
							}
						
					?>
                   
                    <?=listas_mayus($t1, $traer_tecnicos_compras,$busca_responsable_j[1],'nombre_administrador', 1);?>                </select></td>
              </tr>
              <tr class="campos_blancos_cronograma">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              
              
              <tr class="campos_gris_cronograma">
                <td><div align="right"><strong>Fechas Recepci&oacute;n Ofertas Lista de Precios:</strong></div></td>
                <td><img src="../imagenes/botones/2.gif" alt="Copiar fechas generales" width="16" height="16"  onclick="copia_fechas(7)"/></td>
                <td><div align="center">
                  <input name="a_e" type="text" class="f_fechas" id="a_e" onmousedown="calendario_se('a_e')" value="<?=valida_fecha_vacia($sql_e[27]);?>"/>
                </div></td>
                <td><div align="center">
                  <input name="c_e" type="text" class="f_fechas" id="c_e"   onmousedown="calendario_se('c_e')" value="<?=valida_fecha_vacia($sql_e[28]);?>"/>
                </div></td>
                <td><div align="center">                <input name="a_j5" type="hidden" class="f_fechas" id="a_j_a" onmousedown="calendario_se('a_j_a')" value=""/><input name="a_e_p" type="hidden" class="f_fechas" id="a_e_p"  onmousedown="calendario_se('a_e_p')"  value="<?=valida_fecha_vacia($sql_e[39]);?>"/>
                    <input name="a_j6" type="hidden" class="f_fechas" id="a_j_c" onmousedown="calendario_se('a_j_c')" value=""/><input name="c_e_p" type="hidden" class="f_fechas" id="c_e_p" onmousedown="calendario_se('c_e_p')" value="<?=valida_fecha_vacia($sql_e[40]);?>"/>
</div></td>
                <td><div align="center"></div></td>
                <td><select name="responsable_ec" id="responsable_ec">
                    <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " tipo_usuario <> 2 and tipo_usuario <> 10 and estado = 1  ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
						
					?>
				  
				  <?=listas_mayus($t1,$traer_tecnicos_compras,$busca_responsable_e[1],'nombre_administrador', 1);?>
                                </select></td>
              </tr>
            </table>
<br />
</fieldset>            

<br />

<fieldset style="width:98%">
			<legend>Informaci&oacute;n de contacto  y ubicaci&oacute;n del proceso</legend>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="4"></td>
  </tr>
 <?=crear_lugar_ejecucion($id_proceso);?>
  <tr>
    <td width="250"><div align="right">Persona de Contacto:</div></td>
    <td><div align="left">
  
                 <?
		if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " pv_principal =100 and estado = 1  ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
		?>   
      <select name="k" id="k">
        <?=listas_mayus($t1, $traer_tecnicos_compras ,$busca_contacto,'nombre_administrador', 1);?>
      </select>
          </div></td>
    <td width="269" colspan="-1"><div align="right"><strong>Entrega de Documentos F&iacute;sicos:</strong></div></td>
    <td width="185"> <select name="docu_fisi" id="docu_fisi">
                <option value="" <? if($entrega_doc_fisicos_etre=="") echo "selected"; ?>>Seleccione</option>
                <option value="Si" <? if($entrega_doc_fisicos_etre=="Si") echo "selected"; ?>>Si</option>
                <option value="No" <? if($entrega_doc_fisicos_etre=="No") echo "selected"; ?>>No</option></select>				</td>

    <input name="auditor_proceso" type="hidden"  size="30" value="0" /></td>
  </tr>
  <tr >
    <td><div align="right"></div></td>
    <td><div align="left"></div></td>
    <td colspan="-1"><div align="right"></div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
      <div align="center">
        <? if($sql_e[31]==0){ //verifica si no fue invitada
		
         	if($id_proceso==""){ ?>
		        <input name="button6" type="button" class="guardar" id="button6" value="Crear Proceso" onclick="crea_proceso('<?=date('Y')?>','<?=date('n')?>','<?=date('j')?>','<?=date('h')?>','<?=date('i')?>')" />
			<? } else { ?>
                <input name="button6" type="button" class="guardar" id="button6" value="Modificar Proceso" onclick="modifica_proceso('<?=date('Y')?>','<?=date('n')?>','<?=date('j')?>','<?=date('h')?>','<?=date('i')?>')" />
        <?
			} // si es modificacion sin invitacion
		 } //si no tiene invitacion
		 
		 else { //si ya fue invitada ?>
        <input name="button6" type="button" class="guardar" id="button6" value="Modifica Proceso" onclick="modifica_proceso_notificado(0)" />
        
 <? }  ?>        
      </div>
</td>
  </tr>
</table>
<? if($id_proceso!=""){ ?>

<br />
<fieldset style="width:98%">
			<legend>Proveedores invitados</legend>

            <table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="3"></td>
              </tr>
              <? if ($sql_e[2]!=16){ // si es servicio menor se bloquea ?>
              <tr>
                <td width="31%"><div align="right">Nombre del proveedor: </div></td>
                <td><div align="left">
                    
                    <input name="proveedor" type="text" id="proveedor" size="50" onkeypress="selecciona_lista()" />      
                </div></td>
                <td width="26%">
                    <div align="left">
                      <input name="button" type="button" class="guardar" id="button" value="Agregar Proveedor" onclick="crea_proveedor()" />                    </div>
                  </td>
              </tr>
              
              <? } // si es servicio menor se bloquea ?>
              
             <? if ( ($sql_e[31]==1) && ($sql_e[2]!=30) ){ ?>
              <tr>
                <td><div align="right">Observaciones para el nuevo proveedor:</div></td>
                <td colspan="2"><textarea name="observa_provee" id="observa_provee" cols="45" rows="2"></textarea>
                <input type="hidden" value="1" name="nuevo_provee_obligato">
                
                </td>
              </tr>
              
              <? } else { ?> <input type="hidden" value="2" name="nuevo_provee_obligato"> <? } ?>
              <tr>
                <td><? if ($sql_e[2]!=16){ // si es servicio menor se bloquea ?><input name="button9" type="button" class="buscar" id="button9" value="Buscar proveedores en RUP PAR SERVICIOS" onclick="ajax_carga('../aplicaciones/crea_contactos_proveedor.php?id_invitacion_pasa=<?=$id_proceso;?>','muestra_cootactos');ingresar_listado('oculta_todo_proveedores')" /><? } ?></td>
                <td><? if ($sql_e[2]!=16){ // si es servicio menor se bloquea ?><input name="button10" type="text" class="buscar" id="button10" value="Crear proveedor" onclick="ajax_carga('../aplicaciones/crea_contactos_proveedor_emergencia.php?id_invitacion_pasa=<?=$id_proceso;?>','muestra_cootactos');ingresar_listado('oculta_todo_proveedores')" /><? } ?></td>
                <td><div align="right">
             <?  if ($entrega_doc_fisicos=="Si"){// si asistencia a reunion esobligatoria
			   if ( ($sql_e[31]==1) && ($select_asiste_auditor[0]==0) ){
			    ?>
                <input name="button12" type="button" class="buscar" id="button12" value="Confirmar asistencia a la reuni&oacute;n informativa" onclick="confirma_asistencia_obli()" />
                <? } 
					} // si asistencia a reunion esobligatoria
					?>
                </div></td>
              </tr>
            </table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
<tr>
                <td width="1%" class="titulo_tabla_azul_sin_bordes">Ver mas</td>
                <td width="70%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="25%" class="titulo_tabla_azul_sin_bordes">E-mail</td>
                <td width="1%" class="titulo_tabla_azul_sin_bordes">Invitaciones</td>
                <td width="1%" class="titulo_tabla_azul_sin_bordes">Otros e-mail</td>
                <td width="1%" class="titulo_tabla_azul_sin_bordes">Bit&aacute;cora</td>
                <td width="1%" class="titulo_tabla_azul_sin_bordes">Eliminar</td>
               <?  if ($entrega_doc_fisicos=="Si"){// si asistencia a reunion es obligatoria
			   if ( ($sql_e[31]==1) && ($sql_e[2]!=0) ){
			    ?>
	                <td width="1%" class="titulo_tabla_azul_sin_bordes">Asistencia</td>
                <? } 
				} // si asistencia a reunion esobligatoria
				?>
</tr>

                            
              <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup,$t7.lectura_proceso from $t8, $t7 where
				$t7.pro1_id =  $id_proceso and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			  
			  	$busca_participacion = traer_fila_row(query_db("select count(*) from $t7 where pv_id = $lp[0] "));
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>

              <tr class="<?=$class;?>">
    <td><input name="button5" type="button" class="buscar" id="button5" value="Ver" onclick="ajax_carga('../aplicaciones/carga_contactos_proveedor.php?pv_nit=<?=$lp[1];?>','muestra_cootactos');ingresar_listado('oculta_todo_proveedores')" /></td>
  
                <td><?=$lp[2];?></td>
                <td><?=$lp[4];?></td>
                <td><a href="javascript:void(0)" onclick="msgbox('../aplicaciones/reporte_proveedores-procesos.php?pv_id_pasa=<?=arreglo_pasa_variables($lp[0]);?>');">
                  <?=$busca_participacion[0];?>
                </a></td>
                <td width="11%"><label><input name="button11" type="button" class="buscar" id="button11" value="Ingresar" onclick="ajax_carga('../aplicaciones/contactos_proceso.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>','contenidos')" /></label></td>
                <td width="11%"><input name="button4" type="button" class="buscar" id="button4" value="Ingresar" onclick="ajax_carga('../aplicaciones/c_bitacora.php?id_invitacion_pasa=<?=$id_proceso;?>&pv_id_b=<?=$lp[0];?>','contenidos')" /></td>
                <td><? if ($sql_e[2]!=16){ // si es servicio menor se bloquea ?><div align="center"><a href="javascript:void(0)" onclick="elimina_proveedor(<?=$lp[0];?>)"><img src="../imagenes/botones/b_cancelar.gif" title="Eliminar Proveedor de la invitaci&oacute;n" /></a></div><? } ?></td>
                <? 
				if ($entrega_doc_fisicos=="Si"){
				if ( ($sql_e[31]==1) && ($sql_e[2]!=0) ){ ?>
                <td><select name="asiste_obligat_blo[<?=$lp[0];?>]">
                <option value="0">seleccione</option>
                <option value="1" <? if($lp[6]==1) echo "selected";  ?> >Si</option>
                <option value="2"  <? if($lp[6]==2) echo "selected";  ?>>No</option>                
                </select></td>
                <? } } ?>
              </tr>
              <? $num_fila++;
			  
			  if($lp[4]=="") $sin_email+=1;
			  
			  } ?>
  </table>
<br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Documentos del proceso</legend>

            <table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td colspan="5"></td>
              </tr>
              <tr>
                <td width="13%">Buscar anexo:</td>
  <td width="26%"><div align="left">
                    <label>
                    <input type="file" name="anexos_s" id="anexos_s" />
                    </label>
                </div></td>
                <td width="18%">Tipo de documento:</td>
                <td width="24%"><select name="tipo_archivo" id="tipo_archivo">
                    <?=listas($tp8, 1,0,'nombre', 1);?>
                </select></td>
<td width="19%"><div align="left"><input name="button2" type="button" class="guardar" id="button2" value="Agregar documento" onclick="crea_archivo()" />
                    </div>
                  </label></td>
              </tr>
            </table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tipo Documento</td>
                <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="35%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Fecha de Cargue</td>
                <td width="17%" class="titulo_tabla_azul_sin_bordes">Etapa Cargue</td>
                <td width="22%" class="titulo_tabla_azul_sin_bordes">Origen del Anexo</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Eliminar</td>
              </tr>
              <? if($requiere_generar_pliego=="Si"){ ?>
               <tr class="<?=$class;?>">
                 <td>Generales</td>
                 <td><img src="../imagenes/mime/pdf.gif" alt="Pdf" /></td>
                 <td>Pliego, terminos y condiciones</td>
                 <td>&nbsp;</td>
                 <td>N/D</td>
                 <td>N/D</td>
                 <td><div align="center"><a href="pliego-terminos-condiciones_<?=$sql_e[22];?>_<?=$id_proceso;?>.pdf"  target="_blank"><img src="../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="" /></a></div></td>
                 <td>&nbsp;</td>
               </tr>
               <? } ?>
             
               <?
			 
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga,tipo_archivo,if(origen=1,'Urna','Solicitud'),origen,if(id_origen=0,$t6.pro2_id,id_origen) from $t6, $tp8 where
				$t6.pro1_id =  $id_proceso and $tp8.tp8_id = $t6.tp8_id order by fecha_carga desc");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[2]);
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  
    <tr class="<?=$class;?>">
                <td><?=$lp[1];?></td>
                <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
                <td><?=$lp[2];?></td>
                <td><?=fecha_for_hora($lp[4]);?></td>
                <td><?=$lp[5];?></td>
                <td><?=$lp[6];?></td>
                <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_generales.php?n1=<?=$lp[8];?>&n2=<?=$lp[2];?>&n3=<?=$lp[7];?>'" /></div></td>
                <td><div align="center"><img src="../imagenes/botones/b_cancelar.gif" title="Eliminar Documento de la invitaci&oacute;n" onclick="elimina_archivo(<?=$lp[0];?>)"/></div></td>
              </tr>
              
              <? $num_fila++;} ?>
            </table>
  <br />
</fieldset>
<br />
<fieldset style="width:98%">
			<legend>Configuraci&oacute;n ofertas solicitadas t&eacute;cnica y econ&oacute;mica</legend>

            <table width="95%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td width="4%"></td>
    <td width="96%"></td>
  </tr>
  <tr >
    <td  align="left"><div align="center"><img src="../imagenes/botones/chulo.jpg" alt="" width="23" height="20" /></div></td>
    <td  align="left"><div align="left"><a href="javascript:void(0)" onclick="ajax_carga('configuracion_criteriostecnicos_<?=arreglo_pasa_variables($id_proceso);?>_2.php','contenidos')">Configurar requerimientos t&eacute;cnicos</a></div></td>
  </tr>
  <tr >
    <td  align="left"><div align="center"><img src="../imagenes/botones/chulo.jpg" width="23" height="20" /></div></td>
    <td  align="left"><div align="left"><a href="javascript:void(0)" onclick="ajax_carga('configuracion_criterios_<?=arreglo_pasa_variables($id_proceso);?>_1.php','contenidos')"> Configurar requerimientos economicos documentos <img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /> Si desea recibir documentos economicos</a></div></td>
  </tr>
  <tr >
    <td  align="left"><div align="center"><img src="../imagenes/botones/chulo.jpg" alt="" width="23" height="20" /></div></td>
    <td  align="left"><div align="left"><a href="javascript:void(0)" onclick="ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_proceso);?>_0.html','contenidos')">Configurar requerimientos lista de precios</a></div></td>
  </tr>
  <tr >
    <td  align="left">&nbsp;</td>
    <td  align="left">&nbsp;</td>
  </tr>
</table>
<br />

<div id="carga_evaluacion"></div>
            
</fieldset>

<br />
<? if($sql_e[31]==0){ ?>

<fieldset style="width:98%">
			<legend>Enviar notificaci&oacute;n a los proveedores</legend>

            <table width="98%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><label>
                  <div align="center">
                    <input name="button7" type="button" class="guardar" id="button7" value="Enviar notificaci&oacute;n de invitaci&oacute;n a los proveedores" onclick="notificar_provvedores()" />
                    </div>
                </label></td>
              </tr>
            </table>
</fieldset>
<? } ?>
<input type="hidden" name="id_proceso" value="<?=$id_proceso;?>" />
<input type="hidden" name="id_elimina"/>

<? 



} ?>

<textarea name="justificacion_final" id="justificacion_final" cols="45" rows="5" style="visibility:hidden"></textarea>

<input name="c" type="hidden" id="c"  value="111" />
<input name="e" type="hidden" id="e"  value="0" />
<input name="f" type="hidden" id="f"  value="1" />
<input name="b" type="hidden" id="b"  value="1" />
<input name="g" type="hidden" id="g"  value="6" />

<input name="sin_email" type="hidden" id="sin_email"  value="<?=$sin_email;?>" />



</div>

<div id="muestra_cootactos"></div>
<div id="carga_detalle_pro"></div>

</body>
</html>
