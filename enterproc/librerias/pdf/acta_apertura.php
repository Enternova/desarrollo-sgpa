<style>
body{ font-family:Arial, Helvetica, sans-serif; font-size:12px}

.ancho_logo{ width: 5%; text-align:left; vertical-align:top}
.celdas_encabesado{width: 90%; text-align:left; vertical-align:top; padding-left:10px; font-style:normal;  }
.line_encabezado{width: 90%; border-top:solid 1px #999}
.titulos_principales{ BORDER-BOTTOM: #CCCCCC 1px solid; font-size:18px;}
.tabla_principal{width: 91%; alignment-adjust:central}
.tabla_principal_contenido{width: 98%; alignment-adjust:central}


.celdas_apertura{height:20px;font-size:14px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#9FC2FD}
.celdas_apertura_detalle{ BORDER-BOTTOM: #CCCCCC 2px double; font-size:12px; }

</style>
<?
function elimina_comillas_2_inv($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', "", $id_subastas_arrglo);
		
		$id_subastas_arrglo = ereg_replace( "&aacute;", "á",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Aacute;",  "Á",$id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&eacute;","é",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Eacute;","É",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&iacute;","í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Iacute;","Í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&oacute;", "ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Oacute;", "Ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&uacute;", "ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Uacute;","Ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&ntilde;","ñ",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Ntilde;","Ñ", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("<","=", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace(">","=", $id_subastas_arrglo ); 	
		
		$id_subastas_arrglo = ereg_replace( "á","&aacute;",   $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Á","&Aacute;" ,$id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "é","&eacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "É", "&Eacute;", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "í","&iacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Í","&Iacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ó","&oacute;",   $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "Ó","&Oacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "ú","&uacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("Ú","&Uacute;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("ñ","&ntilde;",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("Ñ","&Ntilde;", $id_subastas_arrglo ); 
		
		
		//$id_subastas_arrglo = ereg_replace("<","", $id_subastas_arrglo ); 		

		
		return $id_subastas_arrglo;
}
$id_invitacion= $id_invitacion;
//$id_invitacion= 4720;
$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));
$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));

function detalle_aspecto($aspecto,$campo){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select pro1_id, $campo from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return $busca_detalle_apertura[1];
	else
	return "Sin apertura";
}
$oferta_vista = 1;   
$valor_apertura_auditor=100000;

             /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
			 
                    if($linvi[13]==1)
                        $cuantia=$linvi[14];
                    elseif($linvi[13]==2)
                    $cuantia=($linvi[14]+1) / 1800;
                    elseif($linvi[13]==3)
                        $cuantia=( ($linvi[14]+1) * 2700 ) / 1800;			
                
                $cuantia_arr = explode(".",$cuantia);		
                $cuantia =$cuantia_arr[0];		
                
				

        $busca_firma=traer_fila_row(query_db("select * from v_apertura_proceso_grantierra where pro1_id = $id_invitacion"));
		
$arregla_conse = elimina_comillas_2_inv($linvi[22]);

$encabezado_header='
    
<table class="tabla_principal">
  <tr>
    <td  rowspan="3"  class="ancho_logo" valign="top"><img src="../../../logo_cliente_email.png" alt="logo" width="118" height="40" /></td>
    <td class="celdas_encabesado"  ><strong>ACTA DE APERTURA DEL PROCESO</strong></td>
   
  </tr>
  <tr>
    <td class="celdas_encabesado">consecutivo: '.$arregla_conse.'</td>
  </tr>
  <tr>
    <td class="celdas_encabesado">Fecha de generacion del reporte: '.fecha_for_hora($fecha." ".$hora).'</td>
  </tr>
  <tr>
    <td colspan="2" class="line_encabezado">&nbsp;</td>
  </tr>

</table>';

?>
<table class="tabla_principal_contenido">
  <tr>
    <td  class="titulos_principales"><strong>Informaci&oacute;n General del Proceso</strong></td>
  </tr>
    <tr>
    <td ></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Consecutivo del proceso:</strong><?=$arregla_conse;?></div></td>
  </tr>
  <tr>
    <td ><strong>Fecha y hora de apertura:</strong><?=fecha_for_hora($linvi[17]);?></td>
  </tr>
  <tr>
    <td><strong>Fecha y hora de cierre:</strong><?=fecha_for_hora($linvi[18]);?></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Detalle y cantidad del objeto a contratar:</strong><?=htmlentities($linvi[12]);?></div></td>
  </tr>
</table>
<br>
<table class="tabla_principal_contenido">
  <tr>
    <td  class="titulos_principales" ><strong>Informaci&oacute;n de apertura de ofertas</strong></td>
  </tr>
  <tr>
    <td ><div align="left"><strong>Fecha de apertura:</strong><?=$buscar_datos_ap[5];?></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Hora de apertura:</strong><?=$buscar_datos_ap[6];?></div></td>
	 </tr>

  <tr>
    <td><strong>Usuario Apertura: </strong><?=htmlentities($busca_firma[2]);?></td>
  </tr>
  <tr>
    <td><strong>Usuario Compras:</strong> <?=htmlentities($busca_firma[3]);?></td>
  </tr>  
</table>

<br>
<table class="tabla_principal_contenido">
  <tr>
		<td colspan="3"  class="titulos_principales"><strong>Apertura evaluaci&oacute;n de requerimientos solicitados en el proceso</strong></td>
  </tr>

  <tr>
    <td class="celdas_apertura"  style="width:33%"  >Criterio</td>
    <td class="celdas_apertura"  style="width:33%"  >Usuario de apertura</td>
    <td class="celdas_apertura"  style="width:33%"  >Fecha de apertura</td>
  </tr>

  <tr >
    <td class="celdas_apertura_detalle" align="right" ><strong>Apertura t&eacute;cnica:</strong></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(2,"nombre_administrador");?></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(2,"fecha_apertura");?></td>
  </tr>
  <tr>
    <td class="celdas_apertura_detalle"  align="right" ><strong>Apertura comercial:</strong></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(1,"nombre_administrador");?></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(1,"fecha_apertura");?></td>
  </tr>

  <tr>
    <td class="celdas_apertura_detalle"  align="right" ><strong>Apertura lista de precios:</strong></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(3,"nombre_administrador");?></td>
    <td class="celdas_apertura_detalle" ><?=detalle_aspecto(3,"fecha_apertura");?></td>
  </tr>

</table>
<br>

<table class="tabla_principal_contenido">
  <tr>
		<td colspan="5"  class="titulos_principales" ><strong>Proponentes</strong></td>
  </tr>

  <tr>
    <td  class="celdas_apertura"  style="width:10%" >NIT</td>
    <td class="celdas_apertura"  style="width:30%" >proveedor</td>
    <td  class="celdas_apertura"  style="width:10%" >Confirma</td>
    <td  class="celdas_apertura"  style="width:10%" >Fecha</td>
    <td  class="celdas_apertura"  style="width:40%">Justificaci&oacute;n</td>
  </tr>

<?

	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup, $t7.observaciones  ,$t7.observaciones_2 from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id <> 1 ");
				while($lp = traer_fila_row($busca_provee)){
 				$busca_confirmacion = traer_fila_row(query_db("select * from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by  fecha desc"));

	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";
?>
<tr>
    <td class="celdas_apertura_detalle"  style="width:10%; vertical-align:text-top"  ><?=elimina_comillas_2_inv($lp[1]);?></td>
    <td  class="celdas_apertura_detalle" style="width:30%; vertical-align:text-top" ><?=elimina_comillas_2_inv($lp[2]);?></td>
	<td class="celdas_apertura_detalle" style="width:10%; vertical-align:text-top"><?=$busca_confirmacion[2];?></td>
    <td class="celdas_apertura_detalle"  style="width:10%; vertical-align:text-top"><?=fecha_for_hora($busca_confirmacion[3]);?></td>
    <td class="celdas_apertura_detalle" style="width:40%; vertical-align:text-top" ><?=elimina_comillas_2_inv($busca_confirmacion[4]);?></td>    
  </tr>
  <?
$num_fila++;   
   
   } 
   ?>
</table>
<br>
		<table class="tabla_principal_contenido">
              <tr>
                <td colspan="5" class="titulos_principales">Resumen de acciones y ofertas enviadas por el proveedor.</td>
              </tr>
              <tr>
                <td class="celdas_apertura"  style="width:49%" >Nombre</td>
                <td  class="celdas_apertura"  style="width:13%" >Fecha de visualiza proceso</td>
                <td class="celdas_apertura"  style="width:14%" >Envio ofertas t&eacute;cnicas</td>
                <td class="celdas_apertura"  style="width:11%" >Envio ofertas comerciales</td>
                <td  class="celdas_apertura"  style="width:11%" >Envio ofertas ec&oacute;nomicas</td>
              </tr>
             <?
              
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			
		  	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";
			$documentos_faltantes = 0;
			$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$lp[0]));
			$busca_confirmacion = traer_fila_row(query_db("select confirmacion  from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by pro4_id desc"));
			$busca_ofertas_tecnicas=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 2  "));
			$busca_ofertas_comercial=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 1  "));
			$busca_ofertas_economica=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v11 where in_id  = $id_invitacion and pv_id = $lp[0] and w_valor != ''  "));
			$busca_comuniocados_faltantes = traer_fila_row(query_db("select count(*) from $t29 where pro1_id = $id_invitacion and pv_id = $lp[0] and tp13_id  in (1,2,3,4) and estado = 1 and quien_ingresa != 'Proveedor'"));
			$busca_docuemntos_anexos=traer_fila_row(query_db("select count(*) from $t6 where pro1_id = $id_invitacion"));
			$busca_docuemntos_descagados=traer_fila_row(query_db("select count(distinct detalle) from $v5 where pro1_id = $id_invitacion and auditor_categoria_id = 3 and pv_id = $lp[0]"));
			$documentos_faltantes = ($busca_docuemntos_anexos[0]-$busca_docuemntos_descagados[0]);
							
			if($busca_confirmacion[0]=='')	$estado_conf="N / C";
			else $estado_conf=$busca_confirmacion[0];
			
			?>
             <tr>
                <td class="celdas_apertura_detalle"  style="width:49%; vertical-align:text-top" ><?=htmlentities($lp[2]);?></td>
                <td class="celdas_apertura_detalle"  style="width:13%; vertical-align:text-top" ><?=$busca_ingresos[4];?></td>
                <td class="celdas_apertura_detalle"  style="width:14%; vertical-align:text-top" ><?=$busca_ofertas_tecnicas[0];?></td>
                <td class="celdas_apertura_detalle"  style="width:11%; vertical-align:text-top" ><?=$busca_ofertas_comercial[0];?></td>
                <td class="celdas_apertura_detalle"  style="width:11%; vertical-align:text-top" ><?=$busca_ofertas_economica[0];?></td>
              </tr>
              <?
               $num_fila++;
			  
			  } 
			  ?>
            </table>
<br>
<br>
<table class="tabla_principal_contenido">
      <tr>
        <td colspan="5"  class="titulos_principales">Auditoria del proceso.</td>
       </tr>

  <tr>
    <td  class="celdas_apertura"  style="width:18%" >Accion</td>
    <td  class="celdas_apertura"  style="width:17%" >Nombre usuario</td>
    <td   class="celdas_apertura"  style="width:15%" >Fecha</td>
    <td  class="celdas_apertura"  style="width:38%" >Comentarios</td>
    <td  class="celdas_apertura"  style="width:12%" >IP de conexion</td>
  </tr>
 
 <?
			  	
			  	$busca_provee = query_db("select * from $v5 where pro1_id =  $id_invitacion  order by fecha_hora desc ");
				while($lp = traer_fila_row($busca_provee)){
				  
				 if($lp[0]==3){
				 	$detalle2=traer_fila_row(query_db("select * from $t6 where pro2_id = $lp[9]"));
					$detalle=$detalle2[3];
					}
				else $detalle=$lp[9];
				
	  	if($num_fila%2==0)
				$class=" bgcolor=\"#CCCCCC\" ";
			else
				$class="";

	if( ($lp[0]==37) || ($lp[0]==38) )
		$comple=$lp[9];
	else $comple="";
	if($lp[0]==3){
		$contend_audi = "select archivo from pro2_documentos where pro2_id = $lp[9]";
		$sql_aud = traer_fila_row(query_db($contend_audi));
	$detalle_auditoria = $sql_aud[0];
		
	}
	else
		$detalle_auditoria = $lp[9];
	
	?>			

	<tr>
    <td class="celdas_apertura_detalle"  style="width:18%; vertical-align:text-top"><?=htmlentities($lp[1]);?></td>
    <td class="celdas_apertura_detalle"  style="width:17%; vertical-align:text-top"><?=htmlentities($lp[5]);?></td>
    <td class="celdas_apertura_detalle"  style="width:15%; vertical-align:text-top"><?=htmlentities($lp[8]);?></td>
    <td class="celdas_apertura_detalle"  style="width:38%; vertical-align:text-top"><?=htmlentities($detalle_auditoria);?></td>
    <td class="celdas_apertura_detalle"  style="width:12%; vertical-align:text-top"><?=htmlentities($lp[10]);?></td>
  </tr>
  
  <?
   $num_fila++;
			 
			  } 
?>
</table>

<br>

<table class="tabla_principal_contenido">
              <tr>
				<td colspan="3"  class="titulos_principales"><strong>Firmas</strong></td>
              </tr>
              <tr>
                <td style="width:47%">&nbsp;</td>
                <td style="width:6%" >&nbsp;</td>
                <td style="width:47%" >&nbsp;</td>
              </tr>			  
              <tr>
                <td class="titulos_principales">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="titulos_principales">&nbsp;</td>
              </tr>
              <tr>
                <td><strong><?=$busca_firma[3];?></strong></td>
                <td>&nbsp;</td>
                <td><strong><?=$busca_firma[2];?></strong></td>
              </tr>
              <tr>
                <td><strong>Delegado Compras</strong></td>
                <td>&nbsp;</td>
                <td><strong>Delegado Apertura</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>

