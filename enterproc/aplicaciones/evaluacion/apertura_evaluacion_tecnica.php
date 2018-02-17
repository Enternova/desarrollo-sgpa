<? include("../../librerias/lib/@session.php");
include("../../librerias/lib/leng_esp.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';





	//verifica_menu("procesos.html");
	 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));

		if($_SESSION["id_us_session"]!=1){
	$busca_apertura=traer_fila_row(query_db("select * from $t23 where pro1_id = $id_invitacion and aspecto = 2"));
	if($busca_apertura[0]=="")
	$inserta_apertua=query_db("insert into $t23 (pro1_id,aspecto,fecha_apertura, usuario_apertura) values ($id_invitacion,2,'$fecha $hora',".$_SESSION["id_us_session"].")");
}
	

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	$requiere_auditor_c=$sql_e[46];
	$tipo_cronograma=$sql_e[45];	
	
$busca_tipo_evaluacion = "select tipo_evaluacion from pro34_relacion_tipo_evaluacion_tecnica where pro1_id = $id_invitacion";
	$sql_ex_tipo_evaluacion = traer_fila_row(query_db($busca_tipo_evaluacion));				



		$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			$estado_proceso="select estado from t2_item_pecc where id_item = $sql_e[7]";
					$sql_estado_proceso= mssql_fetch_row(mssql_query($estado_proceso));
					
					
		
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<div id="carga_evaluacion">
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion"><?=LENG_133;?></td>
    <td width="17%">
      <div align="left">
        <input name="button" type="button" class="cancelar" id="button" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
      </div>        </td></tr>
</table>
<table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="20%" ><div align="right"><strong>Consecutivo del proceso:</strong></div></td>
    <td width="29%"><?=$sql_e[22];?></td>
    <td width="17%"><div align="right"><strong>Tipo de soicitud:</strong></div></td>
    <td width="34%"><div align="left">
      <?=listas_sin_select($tp3,$sql_e[3],1);?>
    </div></td>
  </tr>
  <tr>
    <td valign="top" ><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      </div></td>
  </tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="7" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18">
                  <?=LENG_338;?>
                .</td>
    </tr>
              <tr>
                <td width="42%" class="columna_subtitulo_resultados"><?=LENG_312;?></td>
                <td width="6%" class="columna_subtitulo_resultados"><?=LENG_38;?></td>
                <td width="6%" class="columna_subtitulo_resultados">Texto</td>
                <td colspan="3" class="columna_subtitulo_resultados"><div align="center"><?=LENG_331;?></div></td>
                <td width="1%" class="columna_subtitulo_resultados"><table width="100%" cellpadding="0" cellspacing="0" >	
    	<tr >
        	<td colspan="4" align="right">
        		<table border="0" width="100%">
        			
        			<td width="100%" align="left" style="font-weight: 900; font-size: 12px;">	
        				<i><img src="../../imagenes/botones/icono_ayuda.png" ></i><font face="roboto" color="#229BFF">&nbsp;Ofertas por Proveedor
        			</td>
        		</table>
        	</td>
        </tr>

    
</table></td>
              </tr>
              
              <?

function valida_estados_evaluacion($resultado,$minimo_esperado, $id_invitacion, $pv_id){//funcion valida evaluacion
 
 $busca_criterios_evaluados_completo = "select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and pv_id = $pv_id and resultado_evaluacion = 'Sin' and termino = 2";
  $sql_ex_b = traer_fila_row(query_db($busca_criterios_evaluados_completo)); 

	$busca_tipo_evaluacion = "select tipo_evaluacion from pro34_relacion_tipo_evaluacion_tecnica where pro1_id = $id_invitacion";
	$sql_ex_tipo_evaluacion = traer_fila_row(query_db($busca_tipo_evaluacion));

if($sql_ex_tipo_evaluacion[0]==27){//si es evaluacion procentual
 
  if(($resultado=="") || ($resultado==LENG_536) ) { $imagen_se= '------'; $texto_resultado = LENG_536; $texto_estado = "------"; }
	elseif($resultado=="Sin anexos")  { $imagen_se= '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">'; $texto_resultado = "No cumple"; $texto_estado = "Sin anexos o Texto"; }
    elseif($sql_ex_b[0]>=1)  { $imagen_se= '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">'; $texto_resultado = $texto_resultado = number_format($resultado,2)." %"; $texto_estado = LENG_535;}  
    elseif(($resultado<$minimo_esperado) && ($resultado!="") ) { $imagen_se= '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">'; $texto_resultado = number_format($resultado,2)." %"; $texto_estado = LENG_539;}
	elseif($resultado>=$minimo_esperado) { $imagen_se= '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">'; $texto_resultado = number_format($resultado,2)." %";$texto_estado = LENG_539; }
	//else $imagen_se= '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">';
} //si es evaluacion procentual

else{//si NO es evaluacion procentual
				
				if(($resultado=="") || ($resultado==LENG_536) ) { $imagen_se= '------'; $texto_resultado = LENG_536; $texto_estado = "------"; }
   				elseif($resultado=="Sin anexos")  { $imagen_se= '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">'; $texto_resultado = "No cumple"; $texto_estado = "Sin anexos o Texto"; }
				
				elseif($sql_ex_b[0]>=1)  { $imagen_se= '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">'; $texto_resultado = "Parcial"; $texto_estado = LENG_535;}  
				elseif($resultado=="No Cumple") { $imagen_se='<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">';$texto_resultado = $resultado;$texto_estado = LENG_539; }
				elseif($resultado=="Cumple") { $imagen_se= '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">';$texto_resultado = $resultado;$texto_estado = LENG_539; }

	
	
	}//si NO es evaluacion procentual
return $imagen_se."|".$texto_resultado."|".$texto_estado;
}	//funcion valida evaluacion	
			  
	$busca_procesos = "select peso_tecnico, minimo_tecnico_solicitado from $t5 where pro1_id = $id_invitacion";
	$sql_proceso=traer_fila_row(query_db($busca_procesos));
			  	
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				$cuenta_proveedores_con_ofertas = 0;
				while($lp = traer_fila_row($busca_provee)){ $imagen_se="";
				$resultado_eva="";
			
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

			$buscar_resultado =  traer_fila_row(query_db("select resultado_tecnico from evaluador10_calificacion_obtenida  where pv_id = $lp[0] and proc1_id = $id_invitacion"));

			$cuenta_archivos = traer_fila_row(query_db("select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and pv_id = $lp[0] and evaluador6_fecha <> '' and termino = 2"));

			$cuenta_archivos_finales = traer_fila_row(query_db("select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and pv_id = $lp[0] and evaluador6_fecha <> '' and evaluador6_nombre <> '' and termino = 2"));
			$numero_anexos = $cuenta_archivos_finales[0]." Anexos"; 
			$cuenta_texto_finales = traer_fila_row(query_db("select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and pv_id = $lp[0] and evaluador6_fecha <> '' and evaluador6_observaciones <> '' and termino = 2"));
			$numero_texto = $cuenta_texto_finales[0]." textos"; 

//echo $tipo_cronograma;

			if($tipo_cronograma==2){
				if ($cuenta_archivos[0]>=1){
					$boton_imprime = "<input name='button3' type='button' class='calificacion_boton' id='button3' onClick='ajax_carga(\"../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=".$id_invitacion."&pv_id=".$lp[0]."\",\"carga_evaluacion\")' value='".LENG_391."'/>";
					$cuenta_proveedores_con_ofertas+=1;
				}
				else{
					$boton_imprime = "Sin_anexos";
					if($buscar_resultado[0]==""){//si no tiene anexos y no se a creado la evaluacion automatica
					$insertar_calificacion_automatica = "insert into evaluador10_calificacion_obtenida (proc1_id, pv_id, resultado_tecnico, observaciones_tecnico) values ($id_invitacion, $lp[0], 'Sin anexos','') ";
					$sql_eva_auto = query_db($insertar_calificacion_automatica);
					$buscar_resultado =  traer_fila_row(query_db("select resultado_tecnico from evaluador10_calificacion_obtenida  where pv_id = $lp[0] and proc1_id = $id_invitacion"));
					}//si no tiene anexos y no se a creado la evaluacion automatica
				}
				}
				else
					{
					$boton_imprime = "<input name='button3' type='button' class='calificacion_boton' id='button3' onClick='ajax_carga(\"../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=".$id_invitacion."&pv_id=".$lp[0]."\",\"carga_evaluacion\")' value='".LENG_391." / Evaluaci&oacute;n'/>";
					}
				
 

$resultado_eva = explode("|",valida_estados_evaluacion($buscar_resultado[0],$sql_proceso[1],$id_invitacion,$lp[0]));
$numero_proveedores_evaluar = 0;
$numero_proveedores_ya_evaluador = 0;
if ( ($numero_anexos>=1 ) || ($numero_texto>=1)){ //si tiene ofertas				
  ?>
  <tr class="<?=$class;?>">
  
                <td><?=$lp[2];?></td>
                <td><?=$numero_anexos;?></td>
                <td><?=$numero_texto;?></td>
                <td width="5%"><?=$resultado_eva[0];?></td>
                <td width="8%"><?=$resultado_eva[1];?> </td>
                <td width="13%"><?=$resultado_eva[2];?></td>
                <td><div align="center"><?=$boton_imprime;?>
                  
    </div></td>
  </tr>
              <? $num_fila++;
			  $numero_proveedores_evaluar++;
			  if(LENG_539==$resultado_eva[2])
			  	$numero_proveedores_ya_evaluador++;
}//si tiene ofertas
			  }
			  $porveedores_para_evaluar_tecnicamente = "insert into evaluador11_proveedores_con_oferta_tec (pro1_id, numero_proveedores, estado) values ($id_invitacion, $cuenta_proveedores_con_ofertas,1)";
			  $sql_inser = query_db($porveedores_para_evaluar_tecnicamente);
			  
			  
			  
			   ?>
  </table>
  
<div align="center"><a href='../aplicaciones/evaluacion/descargas_uno/descarga_documentos_juridicos_tecnicos_todos_zip.php?evaluador1_id=<?=$id_invitacion;?>'>Descargar todos los archivos del los proveedores</a></div>
<p>
 

<?
	 $porveedores_para_evaluar_tecnicamente = "select count(*) from evaluador11_proveedores_con_oferta_tec where pro1_id = $id_invitacion and estado = 1";
	 $sql_cuenta_proveedores_tecnicos = traer_fila_row(query_db($porveedores_para_evaluar_tecnicamente));
	 /** INICIO PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
	 $busca_encargado_tecnico = "select count(*) from pro6_observadores_procesos where pro1_id = $id_invitacion and us_id in (".$_SESSION["id_us_session"].", ".a_quien_reemplaza($_SESSION["id_us_session"]).") and tipo = 2";
	/** FIN PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
	 $sql_busca_encargado_tecnico = traer_fila_row(query_db($busca_encargado_tecnico));
	 
	 if( ($sql_cuenta_proveedores_tecnicos[0]==1) && ($sql_busca_encargado_tecnico[0]>=1) ) {
?>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
      <tr>
    <td><div align="center"><input type="button" class="guardar" name="button2" id="button2" value="Poner en firme y finalizar evaluacion t&eacute;cnica  " onClick="poner_firme_evaluacion_tecnica()"></div></td>
      </tr>
    </table>
    
    <? } 
			

	 if($sql_cuenta_proveedores_tecnicos[0]==1)
	 	$estado_evaluacion = "<div align='left' class='apertura_pendiente'>Evaluaci&oacute;n t&eacute;cnica pendiente de finalizaci&oacute;n</div>";
	 else
		$estado_evaluacion = "<div align='left' class='apretrura_firme'>Evaluaci&oacute;n t&eacute;cnica finalizada</div>";
?>
    

<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr>
    <td width="51%" ><div align="right" class="columna_subtitulo_resultados">Estado de la evaluaci&oacute;n t&eacute;cnica:</div></td>
    <td width="49%" align="left" ><?=$estado_evaluacion;?></td>
    </tr>
  </table>
    
<br>



<?



 if( ($sql_cuenta_proveedores_tecnicos[0]==0) && ($_SESSION["pv_principal"]==100) ){
	 
	 if( ($sql_estado_proceso[0]==13) && ($sql_busca_encargado_tecnico[0]==0 )){//si no ha terminado de negacia
	 
	  ?>

<table width="95%" border="0" class="tabla_lista_resultados">
      <tr>
        <td height="43" colspan="2"><strong class="titulos_procesos">Devolver  evaluaci&oacute;n t&eacute;cnica:</strong> Desde aqu&iacute; usted podr&aacute; devolver al evaluador t&eacute;cnico este  proceso, debe incluir los comentarios de esta decisi&oacute;n</td>
      </tr>
      <tr>
        <td width="17%" align="right" valign="top" class="titulos_evaluacion">Comentarios de la devoluci&oacute;n:</td>
        <td width="83%" valign="top"><textarea name="come_devolucion" id="come_devolucion" cols="45" rows="5"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="button" class="guardar" name="button3" id="button3" value="Devolver la evaluacion t&eacute;cnica  " onClick="devolver_poner_firme_evaluacion_tecnica()"></td>
      </tr>
    </table>
            		
				<? 
				
	 }//si no ha terminado de negacia
				
				} 
				
				 $busca_devoluciones = "select count(*) from v_urna_detalle_devolucion_tecnica where pro1_id =  $id_invitacion ";
		$sql_ex_de = traer_fila_row(query_db($busca_devoluciones));
				
				if($sql_ex_de[0]>=1){//si tiene devoluciones
				
				?>
    
    <table width="95%" border="0" class="tabla_lista_resultados">
      <tr>
        <td colspan="3" class="titulos_procesos">Historico de devoluciones t&eacute;cnicas</td>
      </tr>
      <tr class="columna_titulo_resultados">
        <td width="10%">Usuario</td>
        <td width="13%">Fecha</td>
        <td width="77%">Detalle</td>
      </tr>
    <?
		 $busca_devoluciones = "select nombre_administrador, fecha_gestion, comentarios_dev from v_urna_detalle_devolucion_tecnica where pro1_id =  $id_invitacion ";
		$sql_ex_de = query_db($busca_devoluciones);
	
		while($lista_devo = traer_fila_row($sql_ex_de)){
	?>
    
      <tr>
        <td><?=$lista_devo[0];?></td>
        <td><?=$lista_devo[1];?></td>
        <td><?=$lista_devo[2];?></td>
      </tr>
      
      <? } ?>
    </table>
    
    <? } //si tiene devoluciones ?>
  <input type="hidden" name="id_item_pecc" value="<?=$sql_e[7];?>">
<input type="hidden" name="contiene_tecnico">
<input type="hidden" name="numero_proveedores_evaluar_pasa" value="<?=$numero_proveedores_evaluar;?>">
<input type="hidden" name="numero_proveedores_ya_evaluador_pasa" value="<?=$numero_proveedores_ya_evaluador;?>">



<iframe name="grp_urna" frameborder="0" height="0" width="0"></iframe>

</p>
</div>
</body>
</html>
