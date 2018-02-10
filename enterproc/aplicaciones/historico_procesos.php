<?   include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
$valor_apertura_auditor=100000;

//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


if($id_proceso!=""){
	
	$id_proceso = str_replace("-","",$id_proceso);
	$id_proceso = str_replace(" ","",$id_proceso);
	
	$complemento_bus = " and (replace($t5.consecutivo,'-','') like '%$id_proceso%' or replace($t5.consecutivo,' ','') like '%$id_proceso%') ";
}

if($detalle_busca!="")
	$complemento_bus.= " and $t5.detalle_objeto like '%$detalle_busca%'";

if( ($g!="") and  ($g!="0"))
	$complemento_bus.= " and $t5.tp1_id = $g ";

if( ($a!="") and  ($a!="0"))
	$complemento_bus.= " and $tp2.tp2_id = $a ";

if( ($k!="") and  ($k!="0"))
	$complemento_bus.= " and $t1.us_id = $k ";

if( ($c!="") and  ($c!="0"))
	$complemento_bus.= " and $t5.tp3_id = $c ";

		/**segmento validacion procesos venta de crudo*/


                if($_SESSION["pv_principal"]!=150){//SI ES EL DUEÑO DEL PROCESO
                    $complemento_bus.= " and $t5.tp2_id <> 31 ";
					$filtro_lista_contra = " tp3_id	 not in (3)";
					$filtro_lista_contra_2 = " tp2_id	 in (1,2,3,8,10,11,16,30) ";	

					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO
	                elseif($_SESSION["pv_principal"]==150){//SI ES EL DUEÑO DEL PROCESO
                    $complemento_bus.= " and $t5.tp2_id = 31 ";
					$filtro_lista_contra = " tp3_id	 in (3)";	
					$filtro_lista_contra_2 = " tp2_id	 in (31) ";	
					
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO		

			/**segmento validacion procesos venta de crudo*/
			
if( ($_SESSION["id_us_session"]!=18194) or ($_SESSION["id_us_session"]!=19927) ){//usuarios especiales	


//if( ($_SESSION["tipo_usuario"]==3) && ( $_SESSION["pv_principal"]!=1) ) {
	
if ($_SESSION["tipo_usuario"]==3)  {
		
	$busca_invitaciones = "select distinct pro1_id from $t11 where us_id = ".$_SESSION["id_us_session"];	
	$sql_invitados = query_db($busca_invitaciones);
	while($bus_invo=traer_fila_row($sql_invitados))
			{
				$aparici+=1;
				$concate_id.=",".$bus_invo[0];
			}
			if($aparici>=1){
			
			$comple_invotad = "  or $t5.pro1_id in (0 $concate_id)";
			
			}
		
	//		$complemento.= " and	( $t5.us_id_contacto =  ".$_SESSION["id_us_session"]." or $t5.us_id =  ".$_SESSION["id_us_session"]."  $comple_invotad) ";	
			if($_SESSION["pv_principal"]==0){//SI ES EL DUEÑO DEL PROCESO
			//$complemento_bus.= " and ($t5.us_id_contacto = ".$_SESSION["id_us_session"]." or $t5.us_id = ".$_SESSION["id_us_session"]."   $comple_invotad) " ;
			}
			$complemento_bus.= "  and ($t5.us_id_contacto = ".$_SESSION["id_us_session"]." or $t5.us_id = ".$_SESSION["id_us_session"]."   $comple_invotad)  " ;
		}

}//usuarios especiales



	  $li_n_c=traer_fila_row(query_db("select count(*) 
	 from $tp2, $tp6, $tp5, $t1, $t5, $tp1 where $t5.tp1_id <> 12 and
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and 
	$tp1.tp1_id  = $t5.tp1_id $complemento_bus "));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;



	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
<link href="../../css/estilo-principal.css?act=2" rel="stylesheet" type="text/css" />
</head>

<body>
<? 

$inhabilita_inbox = "NO";
if($_SESSION["id_us_session"] == 7){// inhabilita el inbox de la urna de maria cock
	$inhabilita_inbox = "SI";
	}

$inhabilita_inbox = "SI";//INHABILITA EL INBOX PARA TODOS LOS USURIOS
if($tipo_ingreso_alerta=='0' or $inhabilita_inbox == "SI")
	$titulo_histo="SECCION: PROCESOS EN CREACION, NOTIFICADOS Y CONGELADOS";
else
	$titulo_histo="SECCION: INBOX";
?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos"><?=$titulo_histo;?></td>
  </tr>
</table>
<br />  
<? if($tipo_ingreso_alerta=='0'  or $inhabilita_inbox == "SI"){?>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4" class="titulo_tabla_azul_sin_bordes">Buscador de Procesos</td>
  </tr>
  <tr>
    <td width="20%"><div align="right">Consecutivo:</div></td>
    <td width="29%"><div align="left"><input type="text" name="id_proceso" id="id_proceso" value="<?=$id_proceso;?>" />    </div></td>
    <td width="26%"><div align="right"><strong>Tipo de Solicitud</strong>:</div></td>
    <td width="25%"><div align="left">
      <select name="c" id="c">
        <?=listas($tp3, $filtro_lista_contra,$c,'nombre', 1);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Estado:</div></td>
    <td><div align="left">
      <select name="g" id="g">
        <?=listas($tp1, "tp1_id  in (4,11,9)",$g,'nombre', 1);?>
      </select>
    </div></td>
    <td><div align="right">Tipo de Proceso:</div></td>
    <td><div align="left">
      <select name="a" id="a">
        <?=listas($tp2, $filtro_lista_contra_2,$a,'nombre', 1);?>
      </select>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Fecha de Apertura:</div></td>
    <td><div align="left">
      <input type="text" name="i" id="i" onclick="calendario_se('i')" value="<?=$sql_e[17];?>"/>
    </div></td>
    <td><div align="right">Fecha de Cierre:</div></td>
    <td><div align="left">
      <input type="text" name="j" id="j" onclick="calendario_se('j')" value="<?=$sql_e[18];?>"/>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">Detalle del Objeto a Contratar:</div></td>
    <td><div align="left">
      <textarea name="detalle_busca" id="detalle_busca" cols="30" rows="1"><?=$detalle_busca;?></textarea>
    </div></td>
    <td><div align="right">Profesional de C&amp;C:</div></td>
    <td><div align="left">
      <select name="k" id="k">
        <!--
        <?=listas($t1, " tipo_usuario in (1,3,4, 10) and estado = 1 ",$k,'nombre_administrador', 1);?>
        -->
        <?=listas($t1." us INNER JOIN pro1_proceso ON us_id_contacto = us.us_id", " tipo_usuario in (1,3,4, 10) and estado = 1 and us.us_id not in (1,32) GROUP BY us.us_id, us.nombre_administrador ",$k,'nombre_administrador', 1);?>
      </select>
    </div></td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><input type="button" name="button" class="buscar" id="button" value="Buscar procesos" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')" /></div></td>
  </tr>
</table>
<br />
<?
$tipo_ingreso_alerta="0";

	

 } else{ 
 
 

$complemento = " and	$t5.tp1_id not in (5, 7, 8) ";

  if($_SESSION["id_us_session"]==30) {//para que no le aprarezcan alertas en el inbox de la urbna
			//$complemento = " and	$t5.tp1_id = 0";

  }
  if($_SESSION["id_us_session"]==7) {//para que no le aprarezcan alertas en el inbox de la urbna
			//$complemento = " and	$t5.tp1_id = 0";

  }


}

	

 ?>
<table width="99%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left"></div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="22" class="columna_subtitulo_resultados">&nbsp;</td>
          <td width="22" class="columna_subtitulo_resultados">&nbsp;</td>
          <td width="69" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
          <td width="88" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
          <td width="201" class="columna_subtitulo_resultados"><div align="center">Detalle del Proceso</div></td>
          <td width="141" class="columna_subtitulo_resultados"><div align="center">Apertura</div></td>
          <td width="122" class="columna_subtitulo_resultados"><div align="center">Cierre</div></td>
          <td width="191" class="columna_subtitulo_resultados"><div align="center">Profesional de C&amp;C</div></td>
          <td colspan="4" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
              </tr>
              <?  
		
					$comple_estado = "and $t5.tp1_id in (4,9,11)";		
					if($_SESSION["id_us_session"]==22759 ){
						$comple_estado = "and $t5.tp1_id in (4,11)";						
					}
				 $busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo, $t5.detalle_objeto , $tp1.nombre estado_procesos , $t5.us_id, $t5.cuantia,$t5.tp7_tipo_moneda,$t5.us_id_contacto,$t5.tp2_id,$t5.notificacion
                 from $tp2, $tp6, $tp5, $t1, $t5, $tp1 where $t5.tp1_id <> 12 and
                $tp2.tp2_id = $t5.tp2_id and
                $tp6.tp6_id = $t5.tp6_id and
                $tp5.tp5_id = $t5.tp5_id and
                $t1.us_id = $t5.us_id_contacto and 
                $tp1.tp1_id  = $t5.tp1_id $comple_estado $complemento $complemento_bus order by $t5.fecha_cierre desc limit $paginador,$numero_pagi	";
				
//				ECHO $busca_procesos;
                $sql_ex = query_db($busca_procesos);
                while($ls=traer_fila_row($sql_ex)){
            
            $busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $ls[0] and estado = 1"));
                        if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
							
				$elimina_p="";
				$edicion_editar="";                            
                $detalle_proce = substr($ls[8],0, 50);
                $largo_detalle = strlen($ls[8]);
                if($largo_detalle>=50)
                $ver_mas = " ... <br><a href='javascript:act_tollti()' class='someClass' title='".$ls[8]."' onmousedown='act_tollti()'>Ver mas</a>";
                else $ver_mas="";
                
				  if($ls[15]==0){
					$semaforor_estado = 'creacion.png';
                    $proc_eliminar="<img src='../imagenes/botones/b_cancelar.gif' title='Eliminar proceso'  onclick='javascript:elimina_proceso_sin_abrir(".$ls[0].")'/>";					
                    $edicion_editar="<img src='../imagenes/botones/editar_c.png' title='Editar procesos' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/crea_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";

				}

				
				elseif($ls[5]>= $fecha." ".$hora){
				
                    $semaforor_estado = 'acitvo.png';
                    $edicion_editar="<img src='../imagenes/botones/editar_c.png' title='Editar procesos' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/crea_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";
					$proc_eliminar="";
                    }
                else{
                    
					$semaforor_estado = 'cerrada.png';
					$proc_eliminar="";
                     if($ls[14]>=1){//SI LICITACION
						$edicion_editar="<img src='../imagenes/botones/editar_c.png' title='Editar procesos' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/visualiza_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";
					}
						else
	                    $edicion_editar="<img src='../imagenes/botones/editar_c.png' title='Editar procesos !' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/crea_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";

                    
                    }
            
                $busca_invitaciones = traer_fila_row(query_db("select pro1_id, tipo from $t11 where us_id = ".$_SESSION["id_us_session"]." and pro1_id = $ls[0]"));	
                $muestra_proceso="0";
                $edicion="";
                $evaluacion="";
                $auditor="";
				$imagen_apertura="";
            
                /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
                    if($ls[12]==1)
                        $cuantia=$ls[11];
                    elseif($ls[12]==2)
                    $cuantia=($ls[11]+1) / 1800;
                    elseif($ls[12]==3)
                        $cuantia=( ($ls[11]+1) * 2700 ) / 1800;			
                
                $cuantia_arr = explode(".",$cuantia);		
                $cuantia =$cuantia_arr[0];		
                
                /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/	
                
		if($busca_apertura[0]>=1){
			$evaluacion="<img src='../imagenes/botones/nuevo_1.png' title='Evaluar Proceso' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/evaluacion/detalle_invitacion.php?id_p=$ls[0]\",\"contenidos\")'/>";
				$imagen_apertura="<img src='../imagenes/botones/con_apertura_2.jpg?u=1' title='Proceso con  apertura' />";
		
}
		elseif($_SESSION["pv_principal"]==150){
			$evaluacion="<img src='../imagenes/botones/nuevo_1.png' title='Evaluar Proceso' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/evaluacion/detalle_invitacion.php?id_p=$ls[0]\",\"contenidos\")'/>";
				//$imagen_apertura="<img src='../imagenes/botones/con_apertura_2.jpg?u=1' title='Proceso con  apertura' />";
		}	
	
		else{
			$evaluacion="<img src='../imagenes/botones/nuevo_1.png' title='Evaluar Proceso' width='16' height='16' onclick='javascript:abre_procesos_evaluacion_con($ls[0])'/>";
			//$imagen_apertura="<img src='../imagenes/botones/sin_apertura.jpg' title='Proceso sin apertura' />";
             }       
                if($ls[10]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
					$elimina_peliminar = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO
            
                if($ls[13]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
					$elimina_peliminar = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO

                if($_SESSION["pv_principal"]==100){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
					//$elimina_p = $proc_eliminar;
                    } //SI ES EL DUEÑO DEL PROCESO


                if ($_SESSION["tipo_usuario"]==1) { // SI ES ADMINSITRADOR DEL SISTEMA
                    $muestra_proceso=1;
					$edicion="<img src='../imagenes/botones/editar_c.png' title='Editar procesos..' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/visualiza_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";
					
             //       $edicion=$edicion_editar;
					$elimina_p = $proc_eliminar;
                    } // SI ES ADMINSITRADOR DEL SISTEMA
                elseif(($busca_invitaciones[0]>=1) && ($busca_invitaciones[1]>=2) ) { //SI ES INVITADO AL PROCESO
                    $muestra_proceso=1;
                    } //SI ES INVITADO AL PROCESO
                elseif(($busca_invitaciones[0]>=1) && ($busca_invitaciones[1]==1) ) {
                    $muestra_proceso=1;
                    }
                elseif($_SESSION["tipo_usuario"]==4) {
                    $muestra_proceso=1;
                    }
				elseif($_SESSION["tipo_usuario"]==10) {
                    $muestra_proceso=1;
					$edicion="<img src='../imagenes/botones/editar_c.png' title='Editar procesos' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/visualiza_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";
                    }			

							
                if($_SESSION["id_us_session"]==18194) {
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
					
                    }
   		
			if($_SESSION["id_us_session"]==19927) {
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
					
                    }					
			
		
/*------------------validador o gestion abastecimiento el rol ------------------*/

/*SI TUVIERA CONEXION CON SQL SERVER ESTE ES EL QUERY PARA SABER SI EL USUARIO TIENE PERMISO DE VALIDADOR ABASTECIMIENTO, PARA QUE PUEDA CREAR URNAS Y DEMAS PERMISOS QUE NO PUEDE HACER EL TIPO USUARIO 4
echo "select count(*) from tseg5_usuario_permisos where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44";
$sele_permiso_validador_abaste = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos234 where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44"));
if($sele_permiso_validador_abaste[0]>0){
$es_validador_abastecimiento = "SI";
}
*/

if($_SESSION["id_us_session"]==29){// COMO NO SE TIENE CONEXION CON SQL SERVER ENTONCES TOCA PONER LOS PERMISOS MANUALMENTE A LOS ID DE USUARIOS DE DELOITTE
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==17){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==57){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18194){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18579){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==19791){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==20296){
$es_validador_abastecimiento = "SI";
}else{
$es_validador_abastecimiento = "NO";
}


/*------------------validador o gestion abastecimiento el rol ------------------*/

if($es_validador_abastecimiento=="SI") {
                    $muestra_proceso=1;
                    $edicion=$edicion_editar;
		    $elimina_p = $proc_eliminar;
					
                    }	

  
					
                 
            if( ($_SESSION["tipo_usuario"]!=4) && ($busca_apertura[0]>=1) ){//si no es auditor 
//              if($_SESSION["tipo_usuario"]!=4){//si no es auditor 
			    if($fecha." ".$hora>=$ls[5])//si ya cerror
                    $evaluacion=$evaluacion;
                else
                    $evaluacion=""; //si ya cerror
					}//si no es auditor 
			 elseif($_SESSION["tipo_usuario"]==4){//si  es auditor 
				
				if($fecha." ".$hora>=$ls[5])//si ya cerror
				  $evaluacion=$evaluacion;
				 else
				 $evaluacion="";
			 }	 
			 elseif($_SESSION["pv_principal"]==150){//si  es auditor 
				
				if($fecha." ".$hora>=$ls[5])//si ya cerror
				  $evaluacion=$evaluacion;
				 else
				 $evaluacion="";
			 }	 
				 else{
                    $evaluacion=""; //si no es auditor 					
					}
                
			
				
            if($_SESSION["id_us_session"]==1)
                $evaluacion="<img src='../imagenes/botones/nuevo_1.png' title='Evaluar Proceso' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/evaluacion/detalle_invitacion.php?id_p=$ls[0]\",\"contenidos\")'/>";			
                
                if($muestra_proceso==1){
          		  			
							if($_SESSION["id_us_session"]==32 or $_SESSION["id_us_session"]==22759){	
							
							$evaluacion="";		
							$edicion="<img src='../imagenes/botones/editar_c.png' title='Editar procesos' width='16' height='16' onclick='javascript:ajax_carga(\"../aplicaciones/visualiza_proceso.php?id_p=$ls[0]\",\"contenidos\")'/>";
							
							
							}
              ?>
        <tr class="<?=$class;?>">
          <td><?=$imagen_apertura;?></td>
          <td><img src="../imagenes/botones/<?=$semaforor_estado;?>" width="16" height="16" /></td>
                <td ><?=$ls[9];?> </td>
                <td><?=$ls[7];?></td>
                <td><?=$detalle_proce.$ver_mas;?></td>
                <td><?=fecha_for_hora($ls[4]);?></td>
                <td><?=fecha_for_hora($ls[5]);?></td>
                <td><?=$ls[6];?></td>
                <td width="17"><a href="javascript:void(0)"><?=$elimina_peliminar;?></a></td>
                <td width="17"><?=$edicion;?></td>
          <td width="17"><?=$evaluacion;?></td>
          <td width="16"><img src="../imagenes/botones/busqueda.gif" title="Observar Proceso" width="16" height="16" onclick="ajax_carga('../aplicaciones/resumen_proceso_obsevador.php?pasa=<?=arreglo_pasa_variables($ls[0]);?>','contenidos')"/></td>
        </tr>
              <tr class="<?=$class;?>">
                <td colspan="5"></td>
                <td colspan="7" id="contrase_<?=$ls[0];?>"></td>
              </tr>
              <? $num_fila++; $encontrados++; }//si es el dueño o es invitado
              }// while
              
               ?>
               </table>
    </td>
               </tr>
  <tr>
    <td colspan="10" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="77%"><div align="left">Procesos activos encontrados:
          <?=$encontrados;?>
        </div></td>
        <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="10%"><label>
          <select name="pagij2" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
            </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>

<div id="abre_procesos_generales"></div>
<input type="hidden" name="id_limpia" />
<input type="hidden" name="id_item_pecc">
<input type="hidden" name="contiene_tecnico">
<iframe name="grp_urna_apertura" frameborder="0" height="0" width="0"></iframe>
</body>
</html>