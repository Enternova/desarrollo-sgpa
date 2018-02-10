<? include("../librerias/lib/@session.php");
include("../librerias/lib/leng_esp.php");
include("funcion_criterios_tecnicos.php");

header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	





	function listas_lenguaje($tabla, $where,$seleccion,$orden, $columna_trae)
		{
		
			if($seleccion=="--n-a--") $id_trae = 3;
			else $id_trae = 0;
			
			$option="<option value='0'>".LENG_342."</option>";
			$sel = "select * from ".$tabla." where ".$where." order by ".$orden;
			$sql_ex=query_db($sel);
			while($ls = traer_fila_row($sql_ex)){
			if($ls[0]==$seleccion)
				$slecciona = "selected";
			else
				$slecciona = "";
			
			$option.="<option value='".$ls[$id_trae]."' ".$slecciona.">".traduccion_lista($ls[$columna_trae])."</option>";
			}
			
			return $option;

		
		}

	//verifica_menu("procesos.html");

		$id_vari=$id_invitacion;
 	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	$termino_trae = elimina_comillas($termino);
	$termino_explode = explode("--",$termino_trae);
	$tipo_evaluacion = $termino_explode[0];
	$tipo_accion =$termino_explode[1];
	$muestra_creacion_criterios = 0;
	
	$busca_configura = "select * from $t54 where pro1_id = $id_invitacion ";
		$sql_busca_conf = traer_fila_row(query_db($busca_configura));
		if($sql_busca_conf[0]>=1){
			$muestra_creacion_criterios = 1;
		}
	if($tipo_accion==10000){
		
		if($sql_busca_conf[0]>=1){
		$cambia_eva = query_db("update $t54 set tipo_evaluacion = $tipo_evaluacion where pro1_id = $id_invitacion");
		$muestra_creacion_criterios = 1;
		
		}
		else{
		$cambia_eva = query_db("insert into  $t54 (pro1_id, tipo_evaluacion) values ($id_invitacion,$tipo_evaluacion ) ");
		$muestra_creacion_criterios = 1;
		}
		}
	

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_tipo_evaluacion = "select tipo_evaluacion from $t54 where pro1_id = $id_invitacion";
	$sql_tipo_evaluacion=traer_fila_row(query_db($busca_tipo_evaluacion));






?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="84%"  class="titulos_procesos"><?=LENG_357;?>  <?=LENG_362;?>
        <br>
        <strong>
          <?=LENG_85;?>
          :
          <?=$sql_e[22];?>
      </strong></td>
    <td width="16%"><div align="right">
      <input name="Submit4" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
</table>
<table width="99%" border="0" align="center" class="tabla_lista_resultados">
  <tr class="columna_titulo_resultados">
    <td width="33%" align="center"><strong>Tipo de evaluaci&oacute;n</strong></td>
    <td width="33%" align="center"><strong>Crear categoria</strong></td>
    <td colspan="2" width="25" align="center"><strong>Cargar criterios masivamente</strong></td>
  </tr>
  <tr>
    <td class="columna_interna_1"><select name="tipo_evaluacion" id="tipo_evaluacion" onChange="ajax_carga('configuracion_criteriostecnicos_<?=arreglo_pasa_variables($id_invitacion);?>_' + this.value + '--10000.php','contenidos')" >
      <?=listas_lenguaje($t51, " tipo_configuracion = 6 ",$sql_tipo_evaluacion[0],'otro_id asc', 2);?>
    </select></td>
    <td class="columna_interna_2"><strong>
      <input name="valorgrupo" type="text" value="<?=$linvi[2];?>" size="50">
    </strong></td>
    <td colspan="2" class="columna_interna_3">descargue la <a href="../attfiles/plantilla/plantilla_criterios.xls">plantilla aqui</a></td>
  </tr>
  <tr>
    <td class="columna_interna_1">&nbsp;</td>
    <td class="columna_interna_2"><input name="Submit5" type="button" class="guardar" onClick="configura_grupo_evaluacion()" value="<?=LENG_97;?>"></td>
    <td class="columna_interna_3">Buscar_plantilla:</td>
    <td class="columna_interna_3"><input type="file" name="fileField" id="fileField"></td>
  </tr>
  <tr>
    <td class="columna_interna_1">&nbsp;</td>
    <td class="columna_interna_2">&nbsp;</td>
    <td class="columna_interna_3">&nbsp;</td>
    <td class="columna_interna_3"><input name="Submit2" type="button" class="guardar" onClick="configura_grupo_evaluacion()" value="Cargar criterios"></td>
  </tr>
</table>
<br>
<?
  

  
	
	echo lista_criterios_seleccion($sql_tipo_evaluacion[0]);
//	echo lista_criterios(1);
	//echo lista_criterios(2);
	 ?>
    
   
<br>

 
      
 
  

<br> 

<table width="99%" border="0" align="center" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr align="center">
    <td height="25"><div align="center">&nbsp;      
        <? if($sql_tipo_evaluacion[0]==27){ ?>
        <input name="Submit" type="button" class="guardar" value="<?=LENG_196;?>" onClick="configura_criterios_evalua_sencilla_tecnicos()">
		<? } else { ?>
        <input name="Submit" type="button" class="guardar" value="<?=LENG_196;?> sel" onClick="configura_evaluacion_criterios_seleccion()">        
        <? } ?>
    &nbsp;</div></td>
  </tr>
  <?=$cajon1;?>
</table>
  

<br>



<input type="hidden" name="termino" value="2">
<input type="hidden" name="termino_pasa" value="2">

<input type="hidden" name="id_vari" value="<?=$id_vari;?>">
<input type="hidden" name="valor_actual">

<input type="hidden" name="id_proceso" value="<?=$id_invitacion;?>" />
<input type="hidden" name="id_elimina_criterios"/>
<input type="hidden" name="id_elimina"/>



</body>
</html>	