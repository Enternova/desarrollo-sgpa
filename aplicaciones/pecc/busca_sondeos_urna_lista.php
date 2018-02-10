<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
$valor_apertura_auditor=100000;


 

$tp2="tp2_tipo_proceso"; 
  $tp6="tp6_tipo_objetos";
  $tp5="tp5_tipo_contrato";
  $t1='us_usuarios';
  $t5="pro1_proceso";
  $tp1="tp1_estado_proceso";

if($consecutivo_bu!=""){
	
	$consecutivo_bu = str_replace("-","",$consecutivo_bu);
	$consecutivo_bu = str_replace(" ","",$consecutivo_bu);
	
	$complemento_bus = " and (replace($t5.consecutivo,'-','') like '%$consecutivo_bu%' or replace($t5.consecutivo,' ','') like '%$consecutivo_bu%') ";
}

if($detalle_busca!="")
	$complemento_bus.= " and $t5.detalle_objeto like '%$detalle_busca%'";

if( ($estado_bu!="") and  ($estado_bu!="0"))
	$complemento_bus.= " and $t5.tp1_id = $estado_bu ";

if( ($profesional_bu!="") and  ($profesional_bu!="0"))
	$complemento_bus.= " and $t1.us_id = $profesional_bu ";

if( ($tp_solicitud_bu!="") and  ($tp_solicitud_bu!="0"))
	$complemento_bus.= " and $t5.tp3_id = $tp_solicitud_bu ";
	
  	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>

    <td width="22" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="69" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="88" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
    <td width="201" class="columna_subtitulo_resultados"><div align="center">Detalle del proceso</div></td>
    <td width="141" class="columna_subtitulo_resultados"><div align="center">Apertura</div></td>
    <td width="122" class="columna_subtitulo_resultados"><div align="center">Cierre</div></td>
    <td width="191" class="columna_subtitulo_resultados"><div align="center">Profesional de C&amp;C</div></td>
  </tr>
  <? 

  $link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
  

				$busca_procesos22 = mysql_query("select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo, $t5.detalle_objeto , $tp1.nombre estado_procesos , $t5.us_id, $t5.cuantia,$t5.tp7_tipo_moneda,$t5.us_id_contacto,$t5.tp2_id,$t5.notificacion from $tp2, $tp6, $tp5, $t1, $t5, $tp1 where $t5.tp2_id= 30 and $t5.tp1_id not in (1,2,3,6, 9,11,10) and $t5.tp1_id <> 12 and $tp2.tp2_id = $t5.tp2_id and $tp6.tp6_id = $t5.tp6_id and $tp5.tp5_id = $t5.tp5_id and $t1.us_id = $t5.us_id_contacto and $tp1.tp1_id  = $t5.tp1_id $complemento $complemento_bus order by $t5.fecha_cierre desc ");
				



                while($ls = mysql_fetch_array($busca_procesos22)){
					
            
                        if($num_fila%2==0){
                            $class="campos_blancos_listas";
                        }else{
                            $class="campos_gris_listas";
						}
							
				$elimina_p="";
				$edicion_editar="";                            
                $detalle_proce = substr($ls[8],0, 150);
                $largo_detalle = strlen($ls[8]);
                
		
		
              ?>
  <tr class="<?=$class;?>">

    <td><img src="../imagenes/botones/chulo.jpg" width="23" height="20" onclick="getElementById('llena_lista_sondeos_l').value = '<?=$ls[0]?>';getElementById('llena_lista_sondeos_2').value = '<?=$ls[7]?>';getElementById('llena_lista_sondeos_2').type='text'; window.parent.document.getElementById('div_carga_busca_sol').style.display='none';body.style.overflow ='visible'" /></td>
    <td ><?=$ls[9];?></td>
    <td><?=$ls[7];?></td>
    <td><?=$detalle_proce;?></td>
    <td><?=$ls[4];?></td>
    <td><?=$ls[5];?></td>
    <td><?=$ls[6];?></td>

  </tr>
 
  <?
  
   $num_fila++; 
              }// while
             
               ?>
</table>
</body>
</html>