<? include("../../librerias/lib/@session.php");
include("../../librerias/lib/leng_esp.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
    	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
    
    		
    
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_p;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));
	$requiere_auditor_c=4;
	$tipo_cronograma=$sql_e[45];	
	
	 $fecha_cierre_juridica =$sql_e[24];
	 $fecha_cierre_tecnica =$sql_e[26];
	 $fecha_cierre_economica =$sql_e[28];
	 $fecha_cierre_hse =$sql_e[38];
	 $fecha_cierre_lista =$sql_e[40];				

	 $busca_confirmacion_totales = "select count(*) from v_confirmacion where pro1_id = $id_invitacion  and estado = 1 and confirmacion_num = 1 and estado_invitacion = 1 ";
	$b_confirma_total=traer_fila_row(query_db($busca_confirmacion_totales));
	$total_confirmaciones=$b_confirma_total[0];
	
				

if($requiere_auditor_c==4){// si NO requiere auditor	 
	if($_SESSION["id_us_session"]!=1){
	$busca_apertura=traer_fila_row(query_db("select * from $t53 where pro1_id = $id_invitacion and estado = 1"));
	if($busca_apertura[0]=="")
		$inserta_r = query_db("insert into $t53 (pro1_id, us_auditor, us_comprador, us_usuario, fecha_apertura, hora_apertura, lugar_apertura,estado)
		values ($id_invitacion,".$_SESSION["id_us_session"].",".$sql_e[15].",".$_SESSION["id_us_session"].",'$fecha', '$hora','',1 )"); 
	}
	}// si NO requiere auditor
if($_SESSION["pv_principal"]==150){// si NO requiere auditor	 
	if($_SESSION["id_us_session"]!=1){
	$busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion and estado = 1"));
	if($busca_apertura[0]=="")
	
		$inserta_r = query_db("insert into pro12_apertura_proceso(pro1_id, us_auditor, us_comprador, us_usuario, fecha_apertura, hora_apertura, lugar_apertura,estado)
		values ($id_invitacion,".$_SESSION["id_us_session"].",".$sql_e[15].",".$_SESSION["id_us_session"].",'$fecha', '$hora','',1 )"); 
	}
	}// si NO requiere auditor
function bloquea_proveedores($id_invitacion){
global $t7;
	 $busca_confirmacion_totales = "select pv_id from v_confirmacion where pro1_id = $id_invitacion  and estado = 1 and confirmacion_num = 2 and estado_invitacion = 1 ";
	//$b_confirma_total=query_db($busca_confirmacion_totales);
	//while($l_blo = traer_fila_row($b_confirma_total)){
		//$cambia_estado_proveedore = query_db("update $t7 set estado  = 2 where pro1_id = $id_invitacion and pv_id = $l_blo[0]");
		//}

}

function detalle_aspecto($aspecto,$campo){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select pro1_id, $campo from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return $busca_detalle_apertura[1];
	else
	return LENG_483;
}

function detalle_aspecto_apertura($aspecto){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select count(*) from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return 1;
	else
	return 0;
}

function apertura_criterios($id_invitacion,$termino,$fecha_cierre_criterio){
global $fecha, $hora,$total_confirmaciones,$t11;
	global $requiere_auditor_c;
	global $tipo_cronograma;

	$total_proveedores_evaluados=0;
	$total_proveedores_evaluados_pendientes=1; 
	
	
	if($termino==2)
		$confiura_boton_apertura="<input name='button6' type='button' class='calificacion_boton' id='button6' value='".LENG_391." / Evaluaci&oacute;n.' onclick='ajax_carga(\"../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=".arreglo_pasa_variables($id_invitacion)."\",\"carga_resultados_principales\")'>";
	elseif($termino==5)
		$confiura_boton_apertura="<input name='button6' type='button' class='buscar_ajustado' id='button6' value='".LENG_391."' onclick='ajax_carga(\"../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=".arreglo_pasa_variables($id_invitacion)."&termino_eva=".$termino."\",\"carga_resultados_principales\")'>";	
	else
		$confiura_boton_apertura="<input name='button6' type='button' class='buscar_ajustado' id='button6' value='".LENG_391."' onclick='ajax_carga(\"../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=".arreglo_pasa_variables($id_invitacion)."&termino_eva=".$termino."\",\"carga_resultados_principales\")'>";
		
	    $confiura_boton_apertura_auditor="<input name='button6' type='button' class='buscar_ajustado' id='button6' value='Ver ofertas' onClick='ajax_carga(\"../aplicaciones/evaluacion/login_acceso.php?id_p=".$id_invitacion."&terminio=".$termino."\",\"abre_log_".$termino."\")'>";

			
			


	
	if($tipo_cronograma==2)
		{ //requiere apertura parciales
		
	if($termino==2){//bloqueo a usuario diferentes de tecnicos
	
		 $busca_invitaciones_observa = "select pro1_id, tipo from $t11 where us_id = ".$_SESSION["id_us_session"]." and pro1_id = $id_invitacion and tipo  = 2";	
			$busca_perimos_no_tecnicos=traer_fila_row(query_db($busca_invitaciones_observa));
		
	$porveedores_para_evaluar_tecnicamente = "select * from evaluador11_proveedores_con_oferta_tec where pro1_id = $id_invitacion";
	 $sql_cuenta_proveedores_tecnicos = traer_fila_row(query_db($porveedores_para_evaluar_tecnicamente));
		
			if($busca_perimos_no_tecnicos[0]=="") 
				{
					if($sql_cuenta_proveedores_tecnicos[3]==1){ // si no esta evaluado tecnicamente
					$confiura_boton_apertura="Faltan evaluación tecnica";
					$confiura_boton_apertura_auditor="Faltan evaluación tecnica";
					
					}// si no esta evaluado tecnicamente
					}
					
		
	}//bloqueo a usuario diferentes de tecnicos
	
	
	if(($termino==3) || ($termino==5) ){//si es tecnico valida que ya se evaluaron todos los proveedores conformados

	 $porveedores_para_evaluar_tecnicamente = "select * from evaluador11_proveedores_con_oferta_tec where pro1_id = $id_invitacion";
	 $sql_cuenta_proveedores_tecnicos = traer_fila_row(query_db($porveedores_para_evaluar_tecnicamente));
	  $cuenta_proveedores_evaluados = "select count(distinct pv_id) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion  and resultado_evaluacion not in ('Sin','')  and termino = 2";
	  $sql_ex_b_provve = traer_fila_row(query_db($cuenta_proveedores_evaluados)); 

		  $cuenta_proveedores_evaluados_completos = "select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and  resultado_evaluacion = 'Sin' and termino = 2";
		 $sql_ex_b_provve_pendientes = traer_fila_row(query_db($cuenta_proveedores_evaluados_completos)); 
	
		$total_proveedores_evaluados=$sql_ex_b_provve[0];
		$total_proveedores_evaluados_pendientes=$sql_ex_b_provve_pendientes[0]; 
		$total_confirmaciones = $sql_cuenta_proveedores_tecnicos[3];

	
		if(( $total_confirmaciones=="") ||( $total_confirmaciones==1)){
			$confiura_boton_apertura="Faltan evaluación tecnica";
			$confiura_boton_apertura_auditor="Faltan evaluación tecnica";
			}

	
	}//si es tecnico valida que ya se evaluaron todos los proveedores conformados	

		
		
			if(detalle_aspecto_apertura($termino)==1){//ya tiene apertura
					$boton_apertura = $confiura_boton_apertura;
				}//ya tiene apertura
			else{//si NO tiene apertura
			
					if ( $fecha." ".$hora > $fecha_cierre_criterio) {// si ya cerro el criterio 
							$boton_apertura = $confiura_boton_apertura_auditor;
							bloquea_proveedores($id_invitacion);
							}
					else $boton_apertura = " El criterio cierra el: ".$fecha_cierre_criterio;
			
			
			}//si NO tiene apertura
		
		}	//requiere apertura parciales
	elseif($tipo_cronograma==24)
		{ //requiere apertura parciales
		
			if(detalle_aspecto_apertura($termino)==1){//ya tiene apertura
					$boton_apertura = $confiura_boton_apertura;
				}//ya tiene apertura
			else{//si NO tiene apertura
			
			if ( $fecha." ".$hora > $fecha_cierre_criterio){ // si ya cerro el criterio 
					
					if($requiere_auditor_c==3)
						$boton_apertura = $confiura_boton_apertura;
					if($requiere_auditor_c==4)
						$boton_apertura = $confiura_boton_apertura;
					if($requiere_auditor_c==28)
						$boton_apertura = $confiura_boton_apertura_auditor;
						

					
					}
			else $boton_apertura = " El criterio cierra el: ".$fecha_cierre_criterio;
			
			
			}//si NO tiene apertura
		
		}	//requiere apertura parciales		
	else{// NO requiere apertura parciales
	
		$boton_apertura = $confiura_boton_apertura;
	
	}// NO requiere apertura parciales

return $boton_apertura;

}

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
	
input.calificacion_boton{
  background-image:url(../imagenes/botones/calificacion.png); 
background-color: #FFF;
  background-repeat:no-repeat;
	border:1px solid #9DDCBA;
  cursor:pointer;
  width:100%;
  height:25px;
  text-align:left;
  padding-left:22px;
	color: #9B5B0B;

	

}
</style>
<script>
	/*funciones para la muestra de alertas*/
function muestra_alerta_general_desde_select(nombre_funcion, titulo, cuerpo, id_select){
	var texto_select=$('#'+id_select+' option:selected').text();
	var tipo_modal = "select";
	texto_select=texto_select.replace('\n', '');
	texto_select=texto_select.replace(/^\s+|\s+$/g, '');
	cuerpo=cuerpo.replace('<campo>', texto_select);
	cuerpo=cuerpo.replace(' ', '32323232');
	//alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../../../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_general_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
	
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../../../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_general_desde_ajax(ruta,div, titulo, cuerpo, id_select, tipo_modal){

	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../../../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+ruta+"&tipo_modal="+tipo_modal+"&div="+div, "div_carga_busca_sol");
}
function muestra_alerta_error(nombre_funcion, titulo, cuerpo, id_select){
    var texto_select=$('#'+id_select+' option:selected').text();
    var tipo_modal = "select";
    texto_select=texto_select.replace('\n', '');
    texto_select=texto_select.replace(/^\s+|\s+$/g, '');
    cuerpo=cuerpo.replace('<campo>', texto_select);
    cuerpo=cuerpo.replace(' ', '32323232');
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../../../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_error_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../../../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
	    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../../../librerias/php/alerta_informativa.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto_guardado_exito(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../../../librerias/php/alerta_informativa_guarda_exito.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
$(document).ready(function() {
    $('.chips').material_chip();
});
/*FIN funciones para la muestra de alertas*/
	</script>
</head>
<body >


<div id="carga_resultados_principales">





<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: APERTURA Y EVALUACION DE PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<BR>
<table width="900" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Consecutivo del proceso:</strong></div></td>
    <td><?=$sql_e[22];?></td>
    <td width="17%"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
    <td width="34%"><div align="left">
      <?=listas_sin_select($tp3,$sql_e[3],1);?>
    </div></td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Tipo de proceso:</strong></div></td>
    <td width="29%"><div align="left">
      <label>
        <?=listas_sin_select($tp2,$sql_e[2],1);?>
        </label>
    </div></td>
    <td colspan="2"><div align="center"><?
		  if($permiso_total==1){
		  ?><input name="button5" type="button" class="buscar" id="button5" value="Ver informaci&oacute;n completa del proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_p;?>&ruta_ev=1','contenidos')">
          <? }?>
          </div>
    <div align="left"></div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>
      <?=$lenguaje_0;?>
    :</strong></div></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
    </div></td>
  </tr>
</table>
<br>


<?




function tiene_criterios ($id_invitacion,$termino){
global $t89, $t90, $t91;

  $grupo_terminos = "select count(*)  from $t89, $t90, $t91  where
	$t91.in_id = $id_invitacion and 
	$t91.termino = $termino and 
	$t90.rel10_id = $t91.rel10_id and 
	$t89.rel9_id  = $t90.rel9_id";
$sql_ex_tiene = traer_fila_row(query_db($grupo_terminos));

if($sql_ex_tiene[0]>=1)
	return 1;
else
	return 0;

}

$cuenta_lista_eco = traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion"));

	$abre_juridico=0;	
	$abre_tecnico=0;
	$abre_economico=0;
	$abre_hse=0;
	$abre_lista=0;
	$abre_experiencias=0;
	$abre_certificados=0;	


$busca_invitaciones = query_db("select pro1_id, tipo from $t11 where us_id = ".$_SESSION["id_us_session"]." and pro1_id = $id_invitacion");	
while($busca_perimos=traer_fila_row($busca_invitaciones)){
	if($busca_perimos[1]==1) $abre_juridico=1;	
	if($busca_perimos[1]==2) $abre_tecnico=1;
	if($busca_perimos[1]==3) $abre_economico=1;
	if($busca_perimos[1]==4) $abre_hse=1;
	if($busca_perimos[1]==5) $abre_lista=1;
	if($busca_perimos[1]==6) $abre_experiencias=1;
	if($busca_perimos[1]==7) $abre_certificados=1;
	if($busca_perimos[1]==20) $permiso_total=1;
	if($busca_perimos[1]==30) $permiso_total=1;	
	
		
	
	}
	$permiso_cierre_procesos=0;
	 $genera_adjudicacion=0;
//	echo "rene".$sql_e[15]."renes".$_SESSION["id_us_session"];
if($sql_e[15]==$_SESSION["id_us_session"]) { $permiso_total=1; $permiso_cierre_procesos=1; $genera_adjudicacion=1; }
elseif($sql_e[33]==$_SESSION["id_us_session"]) { $permiso_total=1; $permiso_cierre_procesos=1;  $genera_adjudicacion=1;}

elseif ($_SESSION["tipo_usuario"]==1) { $permiso_total=1; $permiso_cierre_procesos=0;  $genera_adjudicacion=0;}
elseif($_SESSION["tipo_usuario"]==4) { $permiso_total=1; $permiso_cierre_procesos=0;  $genera_adjudicacion=0;}
elseif($_SESSION["tipo_usuario"]==10) { $permiso_total=1; $permiso_cierre_procesos=0;  $genera_adjudicacion=0;}
elseif($_SESSION["pv_principal"]==100) { $permiso_total=1; $permiso_cierre_procesos=0;  $genera_adjudicacion=0; }

//echo $_SESSION["pv_principal"]."Aqui";


?>

<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td  colspan="4" class="columna_titulo_resultados"><?=LENG_160;?></td>
    </tr>
  <tr>
    <td width="238" class="columna_subtitulo_resultados"><?=LENG_329;?></td>
    <td width="190" class="columna_subtitulo_resultados"><?=LENG_379;?></td>
    <td width="306" class="columna_subtitulo_resultados"><?=LENG_173;?></td>
    <td width="136" class="columna_subtitulo_resultados"><?=LENG_211;?></td>
    </tr>
    <?
if(tiene_criterios($id_invitacion,10)==1){//si tiene requerimientos juridicos
 if( ($abre_juridico==10) || ($permiso_total==1) ){//si tiene permisos{ ?>
  <tr>
    <td><div align="right"><strong><?=LENG_451;?>:</strong></div></td>
    <td><?=detalle_aspecto(10,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(10,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,10,$fecha_cierre_juridica);?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_1">&nbsp;</td>
    </tr>  
  
<? }//si tiene permisos
}//si tiene requerimientos juridicos





if(tiene_criterios($id_invitacion,2)==1){//si tiene requerimientos tecnicos
 if( ($abre_tecnico==1) || ($permiso_total==1) ){ //si tiene permisos?>  
  <tr class="campos_gris_listas">
    <td><div align="right"><strong><?=LENG_282;?>:</strong></div></td>
    <td><?=detalle_aspecto(2,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(2,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,2,$fecha_cierre_tecnica);?></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_2">&nbsp;</td>
    </tr>   
  <? } //si tiene permisos
}//si tiene requerimientos tecnicos
$valida_us_administra_especial=0; // valida si son andrea, juan davod, viky

if($_SESSION["id_us_session"]==30)
	$valida_us_administra_especial=1;
elseif($_SESSION["id_us_session"]==21107)
	$valida_us_administra_especial=1;
elseif($_SESSION["id_us_session"]==7)
	$valida_us_administra_especial=1;
else
	$valida_us_administra_especial=0;
	
$busca_invitaciones_us_espe = "select * from pro6_observadores_procesos where us_id = ".$_SESSION["id_us_session"]." and pro1_id = $id_invitacion and tipo = 2 "; 
$sql_busca_in_esp = traer_fila_row(query_db($busca_invitaciones_us_espe));// pregunta si tiene evaluación tecnica invitada no muestra economica

if( ($sql_busca_in_esp[0]>=1) && ($valida_us_administra_especial==1) ){
	$abre_economico=0;
	$permiso_total=0;
}
	
  
if(tiene_criterios($id_invitacion,1)==1){//si tiene requerimientos economicos  
  if( ($abre_economico==1) || ($permiso_total==1) ){ //si tiene permisos?>
  <tr >
    <td><div align="right"><strong><?=LENG_279;?>:</strong></div></td>
    <td><?=detalle_aspecto(1,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(1,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,1,$fecha_cierre_economica);?></td>
    </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_3">&nbsp;</td>
    </tr>      
  <? } //si tiene permisos
}//si tiene requerimientos economicos


if(tiene_criterios($id_invitacion,4)==1){//si tiene requerimientos hse  
  if( ($abre_hse==1) || ($permiso_total==1) ){ //si tiene permisos ?>    
  <tr class="filas_resultados" >
    <td align="right"><strong><?=LENG_281LENG_282;?></strong></td>
    <td><?=detalle_aspecto(4,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(4,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,4,$fecha_cierre_hse);?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_4">&nbsp;</td>
    </tr>    
  <? } //si tiene permisos
}//si tiene requerimientos hse  


if(tiene_criterios($id_invitacion,6)==1){//si tiene requerimientos EXPERIENCIAS  
  if( ($abre_experiencias==1) || ($permiso_total==1) ){ //si tiene permisos ?>    
  <tr class="filas_resultados" >
    <td align="right"><strong><?=LENG_281a;?></strong></td>
    <td><?=detalle_aspecto(6,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(6,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,6,$fecha_cierre_hse);?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_4">&nbsp;</td>
    </tr>    
  <? } //si tiene permisos
}//si tiene requerimientos EXPERIENCIAS  

if(tiene_criterios($id_invitacion,7)==1){//si tiene requerimientos certificados  
  if( ($abre_certificados==1) || ($permiso_total==1) ){ //si tiene permisos ?>    
  <tr class="filas_resultados" >
    <td align="right"><strong><?=LENG_281b;?></strong></td>
    <td><?=detalle_aspecto(7,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(7,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,7,$fecha_cierre_hse);?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_4">&nbsp;</td>
    </tr>    
  <? } //si tiene permisos
}//si tiene requerimientos certificados 
  
if($cuenta_lista_eco[0]>=1){//si tiene requerimientos lista
  if( ($abre_lista==1) || ($permiso_total==1) ){ //si tiene permisos ?>  
  <tr class="filas_resultados" >
    <td align="right"><?=LENG_402;?>:</td>
    <td><?=detalle_aspecto(5,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(5,"fecha_apertura");?></td>
    <td><?=apertura_criterios($id_invitacion,5,$fecha_cierre_lista);?></td>
  </tr>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" id="abre_log_5">&nbsp;</td>
    </tr>    
 <? } //si tiene permisos 
 }//si tiene requerimientos lista
 
 ?>
</table>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td><label>
      <div align="center">
       <?
		  if($permiso_total==1){
		  ?>
        <input name="button4" type="button" class="guardar" id="button4" value="Ver / enviar aclaraciones finales del proceso" onClick="ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
        <?
		  
		  }
		  ?>
        </div>
    </label></td>
  </tr>
</table>
<?
 $busca_cierre_c = "select count(*) from $t46 where pro1_id = $id_invitacion and observacion_admin <> '' group by fecha_envio";
 $sql_cuenta=traer_fila_row(query_db($busca_cierre_c));
 if($sql_cuenta[0]>=1){//si tiene observaciones
 
		
	?>
<table width="900" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_subtitulo_resultados"><strong>Detalle del cierre del proceso</strong></td>
    </tr>
  <tr class="columna_titulo_resultados">
    <td width="112">Usuario</td>
    <td width="129">Fecha</td>
    <td width="641">Observaciones</td>
  </tr>
<?
	 $busca_cierre = "select fecha_envio, observacion_admin, us_id from $t46 where pro1_id = $id_invitacion and observacion_admin <> '' group by fecha_envio desc";
		$sql_ex = query_db($busca_cierre );
			while($ls_comentarios = traer_fila_row($sql_ex)){
				$busca_usuario_o = traer_fila_row(query_db("select nombre_administrador, usuario from us_usuarios where us_id = $ls_comentarios[2]"));
				         if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$busca_usuario_o[1];?></td>
    <td><?=$ls_comentarios[0];?></td>
    <td><?=$ls_comentarios[1];?></td>
  </tr>
  <? $num_fila++; } ?>
</table>

   <? } //si tiene observaciones ?> 
<?
	$mustera_expor=0;
	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados
	$mustera_expor=1;
?>
<br>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="8" class="columna_subtitulo_resultados"><strong>Proveedores adjudicados</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Proveedor </strong></div>      <div align="center"></div>      <div align="center"></div></td>
    <td class="columna_titulo_resultados"><strong>Fecha env&iacute;o</strong></td>
    <td class="columna_titulo_resultados"><strong><? if($sql_e[3]==1) echo "Documento"; else echo "Adjudicaci&oacute;n"; ?></strong></td>
    <td class="columna_titulo_resultados"><strong>Aceptaci&oacute;n</strong></td>
    <td width="10%" class="columna_titulo_resultados"><div align="center"><strong>Comentarios</strong></div></td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Visualizaci&oacute;n</strong></div></td>
    <td width="4%" class="columna_titulo_resultados"><div align="center"><strong>Ver </strong></div></td>
  </tr>
  <tr>
    <td class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Indica si ya se envi&oacute; o no la notificaci&oacute;n al proveedor" width="18" height="18" title="Indica si ya se envi&oacute; o no la notificaci&oacute;"></div></td>
    <td width="36%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td width="14%" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL" width="18" height="18" title="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL"></td>
    <td width="9%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td width="8%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL" width="18" height="18" title="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL"></div></td>
    <td width="16%" class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Se refiere a la &uacute;ltima vez que el proveedor ingreso y vio la carta de aceptaci&oacute;n de t&eacute;rminos" width="18" height="18" title="Se refiere a la &uacute;ltima vez que el proveedor ingreso y vio la carta de aceptaci&oacute;n de t&eacute;rminos"></div></td>
    <td class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <?

	


			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado, acepta_terminos,fecha_envio from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado_a="";
				$estado_acep="";
				 $buscar_notificaciones_a = "select * from $t46 where pro1_id = $id_invitacion and tipo_adj_no_adj  = 1 and pv_id = $lp[2] and pro27_id = $lp[0]";
			  	$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));

					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $sql_ex_adjudicados[0] order by fecha_lectura"));
			  
				if($sql_ex_adjudicados[7]==1)//si ya fue notificado y requiere	
					$icono_enviado_a ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
				if($sql_ex_adjudicados[7]=="")//si ya fue notificado y requiere	
					$icono_enviado_a =' <img src="../imagenes/botones/icono_X.gif" alt="Pendiente de notificacion" width="18" height="18" title="Pendiente de notificacion">';
				
				if($lp[9]==0) $estado_acep="Pendiente";
				else
					{
						$busca_estado_ad = "select * from tp18_estados_adjudicacion where tp18_id = $lp[9]";
						$sql_ex_estado = traer_fila_row(query_db($busca_estado_ad ));
						$estado_acep = $sql_ex_estado[1]; 
					}
				
				$busca_hi_com = traer_fila_row(query_db("select count(*) from $vt16 where pro27_id = $lp[0]"));		
				
				         if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$icono_enviado_a;?></td>
    <td><?=$lp[3];?></td>
    <td><?=fecha_for_hora($lp[10]);?></td>
    <td><?=$lp[4];?></td>
    <td>
      <div align="left">
        <?=$estado_acep;?>
      </div></td>
    <td>
      <div align="center">
      <?=$busca_hi_com[0];?></div></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td align="center"><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso6.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>&id_notificacion=<?=$sql_ex_adjudicados[0];?>&pro27_id=<?=$lp[0];?>','contenidos')"></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } // si existen adjudicados?>
<br>

<?

		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados			
$mustera_expor=1;
?>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y con Env&iacute;o de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="25%" class="columna_titulo_resultados"><strong>Nombre proveedor</strong></td>
    <td width="32%" class="columna_titulo_resultados"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="17%" class="columna_titulo_resultados"><strong>Fecha Env&iacute;o</strong></td>
    <td width="20%" class="columna_titulo_resultados"><strong>Visualizaci&oacute;n</strong></td>
    <td width="3%" class="columna_titulo_resultados"><strong>Ver</strong></td>
  </tr>
  <?
			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
    <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
    <td><?=fecha_for_hora($lp[3]);?></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso7.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>','contenidos')">    </td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } //si exiten no adjudicados ?>
<br>

<? 

$busca_provee_noad_sin_en = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social "));
				
if($busca_provee_noad_sin_en[0]>=1){//si no exiten sin envios		
$mustera_expor=1;		
?>				
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y sin env&iacute;o de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="41%" class="columna_titulo_resultados"><div align="left"><strong>Nombre proveedor</strong></div></td>
    <td width="53%" class="columna_titulo_resultados"><strong>Comentario del no envio</strong></td>
    </tr>
  <?
	
$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_X.gif" alt="No requiere notificacion al proveedor" width="18" height="18" title="No requiere notificacion al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
  <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
    </tr>
  <? $num_fila++;} ?>
</table>
<? } //si no exiten sin envios ?>
<br>

<?

		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados	
$mustera_expor=1;		

?>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_subtitulo_resultados">
      <?=listas_sin_select($tp1,$sql_e[1],1);?>
    </td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="25%" class="columna_titulo_resultados"><strong>Nombre proveedor</strong></td>
    <td width="32%" class="columna_titulo_resultados"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="17%" class="columna_titulo_resultados"><strong>Fecha env&iacute;o</strong></td>
    <td width="20%" class="columna_titulo_resultados"><strong>Visualizaci&oacute;n</strong></td>
    <td width="3%" class="columna_titulo_resultados"><strong>Ver</strong></td>
  </tr>
  <?
			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
    <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
    <td><?=fecha_for_hora($lp[3]);?></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso7_otros_estados.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>','contenidos')">    </td>
  </tr>
  <? $num_fila++;} ?>
</table>
<p>
  <? } //si exiten otros estados ?>
  </p>

<? if($mustera_expor==1){ ?>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><input name="button6" type="button" class="guardar" id="button6" value="Exportar acta" onClick="window.open('../librerias/tcpdf/examples/exporta_adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=3')"></div></td>
  </tr>
</table>
<? } ?>
<p>&nbsp;</p>
<p><br>
</p>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td  colspan="5" class="columna_titulo_resultados">HISTORICO DE CONFIRMACION DE PARTICIPACION EN EL PROCESO</td>
  </tr>
  <tr>
    <td width="139" class="columna_subtitulo_resultados">NIT</td>
    <td width="178" class="columna_subtitulo_resultados">proveedor</td>
    <td width="85" class="columna_subtitulo_resultados">Confirmaci&oacute;n</td>
    <td width="132" class="columna_subtitulo_resultados">Fecha</td>
    <td width="330" class="columna_subtitulo_resultados">Justificaci&oacute;n</td>
  </tr>
  <?

 	$busca_confirmacion = query_db("select * from v_confirmacion where pro1_id = $id_invitacion order by razon_social, fecha desc");
	while($b_c=traer_fila_row($busca_confirmacion)){
	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
 
 ?>
<tr class="<?=$class;?>">
    <td><?=$b_c[8];?></td>
    <td><?=$b_c[9];?></td>
    <td><?=$b_c[2];?></td>
    <td><?=fecha_for_hora($b_c[3]);?></td>
    <td><?=$b_c[4];?></td>
  </tr>
  <? $num_fila++;  }  ?>
</table>

<br>

<?

	$abre_ju = detalle_aspecto(1,"nombre_administrador");
	$abre_tec = detalle_aspecto(2,"nombre_administrador");
	$abre_lista = detalle_aspecto(3,"nombre_administrador");		

	if($abre_ju!="Sin apertura")
		$abre_acta=1;
	elseif($abre_tec!="Sin apertura")
		$abre_acta=1;
	elseif($abre_lista!="Sin apertura")
		$abre_acta=1;
	else
		$abre_acta=0;

if( ($_SESSION["id_us_session"]==17) || ($_SESSION["id_us_session"]==17968) || ($_SESSION["id_us_session"]==22070) || ($_SESSION["id_us_session"]==62) ){
?>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Acta" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_acta_grantierra.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Generar y ver acta de apertura</a></td>
    <td width="181">&nbsp;</td>
  </tr>

  </table>
  <? 
} 

if($permiso_cierre_procesos==1){

?>

<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <? if($abre_acta==1){ ?>
  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Acta" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_acta_grantierra.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Generar y ver acta de apertura</a></td>
    <td width="181">&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/auditoria_proceso.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">Detalle de auditoria del proceso</a></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
<? if($sql_e[3]==1){ //si es bienes
	if( ($sql_e[1]!=7) && ($sql_e[1]!=8) ) {// si no es decierto o otra ronda
	?>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_resultados_principales')">Cierre del proceso</a></td>
<?
} // si no es decierto o otra ronda
 } //si es bienes
 
 elseif($sql_e[2]==16){ //si es servcio meno
	if( ($sql_e[1]!=7) && ($sql_e[1]!=8) ) {// si no es decierto o otra ronda
	?>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_sm.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_resultados_principales')">Cierre del proceso</a></td>
<?
} // si no es decierto o otra ronda
 } //si es servcio meno
 
 
 else { 
	
	if( ($sql_e[1]!=7) && ($sql_e[1]!=8) ) {// si no es decierto o otra ronda
?>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_servicios.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Cierre del proceso</a></td>
<? } 
}?>
    <td>&nbsp;</td>
  </tr>


</table>
<p>&nbsp;</p>
<? } ?>
<table width="900" border="0" cellspacing="2" cellpadding="2">


  <tr>
    <td><div align="center">
      <input name="button3" type="button" class="cancelar" id="button3" value="Volver  al hist&oacute;rico" onClick="ajax_carga('../aplicaciones/historico_procesos.php','contenidos')">
          
    </div></td>
  </tr>
</table>

</div>

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">

<input type="hidden" name="id_anexo">
</body>
</html>
