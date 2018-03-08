<? include("../../librerias/lib/@session.php");
include("../../librerias/lib/leng_esp.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	verifica_menu("principal.html");
	 
	 if($termino_eva==1){
	 $campo_evaua1=3;
	 $campo_evaua2=4;
	 }
	 elseif($termino_eva==3){
	 $campo_evaua1=13;
	 $campo_evaua2=14;
	 }
	 elseif($termino_eva==4){
	 $campo_evaua1=11;
	 $campo_evaua2=12;
	 }	 
	 	 elseif($termino_eva==6){
	 $campo_evaua1=15;
	 $campo_evaua2=16;
	 }
	 
	 
	 	 elseif($termino_eva==7){
	 $campo_evaua1=17;
	 $campo_evaua2=18;
	 }	  
	 	 
	 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));
	if($_SESSION["id_us_session"]!=1){
	$busca_apertura=traer_fila_row(query_db("select * from $t23 where pro1_id = $id_invitacion and aspecto = $termino_eva"));
	if($busca_apertura[0]=="")
	$inserta_apertua=query_db("insert into $t23 (pro1_id,aspecto,fecha_apertura, usuario_apertura) values ($id_invitacion,$termino_eva,'$fecha $hora',".$_SESSION["id_us_session"].")");
	}

	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	
	$requiere_auditor_c=$sql_e[46];
	$tipo_cronograma=$sql_e[45];
	$tecnico_minimo_r=$sql_e[20];		
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
    <td  valign="top" ><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
    </div></td>
  </tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="5" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> <?=LENG_338;?>.</td>
              </tr>
              <tr>
                <td width="61%" class="columna_subtitulo_resultados"><?=LENG_312;?></td>
                <td width="10%" class="columna_subtitulo_resultados"><?=LENG_38;?></td>
                <td colspan="2" class="columna_subtitulo_resultados"><div align="center"><?=LENG_331;?></div></td>
                <td width="16%" class="columna_subtitulo_resultados">&nbsp;</td>
              </tr>
              
              <?
			  	
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
				
				  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				 $busca_evaluacion_final = "select * from $t13 where proc1_id = $id_invitacion and pv_id = $lp[0]";
				$busca_hist_evaluacion = traer_fila_row(query_db($busca_evaluacion_final));

				if($busca_hist_evaluacion[$campo_evaua1]=="No Cumple") $semaforo='<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">';
				elseif($busca_hist_evaluacion[$campo_evaua1]=="Cumple")  $semaforo= '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">';
				else $semaforo= '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">';
		
				$cuenta_archivos = traer_fila_row(query_db("select count(*) from v_relacion_documentos_evaluacion_criterio where in_id = $id_invitacion and pv_id = $lp[0] and evaluador6_fecha <> '' and termino = $termino_eva"));
				$numero_anexos = $cuenta_archivos[0]." Anexos"; 

				$busca_confirmacion = "select * from v_confirmacion where pro1_id = $id_invitacion and  pv_id = $lp[0] and estado = 1 ";
				$b_confirma=traer_fila_row(query_db($busca_confirmacion));
				
				if( ($tipo_cronograma==2) && ($termino_eva==3) ){//si es ley 80 y es economico
					
					$busca_evaluacion_final_juridica = "select resultado_tecnico from $t13 where proc1_id = $id_invitacion and pv_id = $lp[0]";
					$busca_hist_evaluacion_juridico = traer_fila_row(query_db($busca_evaluacion_final_juridica));
echo $tecnico_minimo_r;
						if( (number_format($busca_hist_evaluacion_juridico[0],2)>=$tecnico_minimo_r) || ($busca_hist_evaluacion_juridico[0]=="Cumple") )
							$boton_imprime = "<input name='button3' type='button' class='buscar_ajustado' id='button3' onClick='ajax_carga(\"../aplicaciones/evaluacion/evaluacion_juridica.php?id_invitacion=".$id_invitacion."&pv_id=".$lp[0]."&termino_eva=".$termino_eva."\",\"carga_evaluacion\")' value='".LENG_391."'/>";
	
						else
								$boton_imprime = "No cumple tecnicamente";
							

				
				}//si es ley 80 y es economico
				else
					{
					
							$boton_imprime = "<input name='button3' type='button' class='buscar_ajustado' id='button3' onClick='ajax_carga(\"../aplicaciones/evaluacion/evaluacion_juridica.php?id_invitacion=".$id_invitacion."&pv_id=".$lp[0]."&termino_eva=".$termino_eva."\",\"carga_evaluacion\")' value='".LENG_391."'/>";
					
					}
				
		?>

  <tr class="<?=$class;?>">
  
                <td><?=$lp[2];?><?=$b_confirma[0];?></td>
                <td><?=$numero_anexos;?></td>
                <td width="3%"><?=$semaforo;;?></td>
                <td width="10%"><? if($busca_hist_evaluacion[$campo_evaua1]=="") echo "Sin evaluación"; else { echo $busca_hist_evaluacion[$campo_evaua1]; }  ?></td>
                <td><div align="center"><?=$boton_imprime;?>
    </div></td>
  </tr>
              <? $num_fila++;
			 
			  } ?>
  </table>
      <table width="95%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><div align="center"><a href='../aplicaciones/evaluacion/descargas_uno/descarga_documentos_juridicos_tecnicos_todos_zip_comerciales.php?evaluador1_id=<?=$id_invitacion;?>'>Descargar todos los archivos del los proveedores</a></div></td>
      </tr>
    </table>

</div>
</body>
</html>
