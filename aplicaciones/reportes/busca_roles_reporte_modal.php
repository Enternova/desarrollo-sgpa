<?
//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
	
   	$sql_comple.= " us_id>1";
	$estado_us = $_GET["estado"];
	if($_GET["number"]!="" and $_GET["number"]!=" " and $_GET["number"]!=null){
		$sql_comple.=" AND id_rol =".$_GET["number"];
	}
	if($_GET["number2"]!="" and $_GET["number2"]!=" " and $_GET["number2"]!=null){
		$sql_comple.=" AND us_id =".$_GET["number2"];
	}

	?>
    <?
    	if($_GET["number2"]){
    		//echo $sql_comple;
	    	//PRIMERO SE GENERA LA SÁBANA PARA LA TAQBLA POR SER UNA TABLA DINAMICA
		$cont = 0;
		$tr1='';
		$titulo="font-size: 16pt;";
		$td="font-size: 12pt;";
		$nombre_rol="";
		$tr3='<tr>';
		$arma_tabla='<table border="1" class="tabla_lista_resultados"><thead>
                  <tr><th style=" background-color: #229BFF; color:#FFFFFF; width: 350px !important;" rowspan="2" align="center">ROL</th>';
		$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 where ".$sql_comple." group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
		while($sel_mod = traer_fila_db($sel_modulos)){
			if($cont==0){
				$color="background-color: #4BAE4F; color: #FFFFFF;";
				$cont++;
			}else{
				$color="background-color: #229BFF; color: #FFFFFF;";
				$cont=0;
			}
			$i=0;
			$sel_cont=query_db("select id_permisos_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by id_permisos_modulo");
			while($sel_cont2 = traer_fila_db($sel_cont)){
				$i++;
			}
			$width=$i*8000;
			$tr2='';
			$tr1.='<th style="'.$color.$titulo.' width: '.$width.'px !important;" colspan="'.$i.'" align="center" bgcolor="#229BFF" class="th">'.$sel_mod[0].'</th>';
			$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where id_modulo=".$sel_mod[1]));
			$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
			while($sel_mod2 = traer_fila_db($sel_modulos2 )){
				$tr2.='<th style="'.$color.$td.' width: 350px !important;" align="center" class="td">'.htmlentities($sel_mod2[0]).'</th>';
			}
			$tr3.=$tr2;
		}
		$tr3.='</tr></thead>';
		$arma_tabla.=$tr1.'</tr>'.$tr3;
		//DESPUÉS DE GENERAR LA SÁBANA AHORA SI SE RECORRE LA BD PARA BUSCAR COINCIDENCIAS POR USUARIO
		$sel_usuario = query_db("select us_id, nombre_administrador, nombre_rol, id_rol from v_roles_des099 where ".$sql_comple." group by us_id, nombre_administrador, nombre_rol, id_rol order by nombre_administrador, nombre_rol, id_rol");
		while($sel_usuario2 = traer_fila_db($sel_usuario)){
			$nombre_rol="Permisos por Rol del Usuario: ".$sel_usuario2[1];
			$tr4='<tr><td style="'.$td.' width: 350px !important;" align="center" class="td">'.$sel_usuario2[2].'</td>';
			$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
			while($sel_mod = traer_fila_db($sel_modulos)){
				$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo, id_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
				while($sel_mod2 = traer_fila_db($sel_modulos2 )){
					$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." and id_permisos_modulo=".$sel_mod2[1]." and us_id=".$sel_usuario2[0]." and id_rol=".$sel_usuario2[3]));
					if($cont_row_span2[0]>0){
						$tr4.='<td align="center" style="'.$td.' width: 350px !important;" class="td" class="td">SI</td>';
					}else{
						$tr4.='<td style="width: 350px !important;"></td>';
					}
				}
			}
			$arma_tabla.=$tr4.'</tr>';
		}
		//echo $arma_tabla;
		$arma_tabla=str_replace("é", "&eacute;", $arma_tabla);
    	}else{
	    	//echo $sql_comple;
	    	//PRIMERO SE GENERA LA SÁBANA PARA LA TAQBLA POR SER UNA TABLA DINAMICA
		$cont = 0;
		$tr1='';
		$titulo="font-size: 16pt;";
		$td="font-size: 12pt;";
		$nombre_rol="";
		$tr3='<tr>';
		$arma_tabla='<table border="1" class="tabla_lista_resultados" style="background-color: #FFFFFF !important;"><tr>';
		$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 where ".$sql_comple." group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
		while($sel_mod = traer_fila_db($sel_modulos)){
			if($cont==0){
				$color="background-color: #4BAE4F; color: #FFFFFF;";
				$cont++;
			}else{
				$color="background-color: #229BFF; color: #FFFFFF;";
				$cont=0;
			}
			$i=0;
			$sel_cont=query_db("select id_permisos_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by id_permisos_modulo");
			while($sel_cont2 = traer_fila_db($sel_cont)){
				$i++;
			}
			$width=$i*80000;
			$tr2='';
			$tr1.='<td style="'.$color.$titulo.' width: '.$width.'px !important;" colspan="'.$i.'" align="center" bgcolor="#229BFF" >'.$sel_mod[0].'</td>';
			$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]));
			$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
			while($sel_mod2 = traer_fila_db($sel_modulos2 )){
				$tr2.='<td align="center" style="'.$color.$td.' width: 350px !important;">'.htmlentities($sel_mod2[0]).'</td>';
			}
			$tr3.=$tr2;
		}
		$tr3.='</tr>';
		$arma_tabla.=$tr1.'</tr>'.$tr3;
		//DESPUÉS DE GENERAR LA SÁBANA AHORA SI SE RECORRE LA BD PARA BUSCAR COINCIDENCIAS POR USUARIO
		$sel_usuario = query_db("select nombre_rol, id_rol from v_roles_des099 where ".$sql_comple." group by nombre_rol, id_rol");
		while($sel_usuario2 = traer_fila_db($sel_usuario)){
			$nombre_rol="Permisos del Rol: ".$sel_usuario2[0];
			$tr4='<tr>';
			//(echo "select nombre_modulo, id_modulo, nombre_rol, id_rol from v_roles_des099 group by orden_modulo, nombre_modulo, id_modulo, nombre_rol, id_rol order by orden_modulo";
			$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 where ".$sql_comple." group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
			while($sel_mod = traer_fila_db($sel_modulos)){
				//echo "select nombre_permiso, id_permisos_modulo, nombre_modulo, id_modulo from v_roles_des099 where id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso";
				$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo, id_modulo from v_roles_des099 where ".$sql_comple." and id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
				while($sel_mod2 = traer_fila_db($sel_modulos2 )){
					$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where ".$sql_comple." and id_rol=".$sel_usuario2[1]." and id_modulo=".$sel_mod[1]." and id_permisos_modulo=".$sel_mod2[1]));
					if($cont_row_span2[0]>0){
						$tr4.='<td align="center" style="'.$td.' width: 350px !important;">SI</td>';
					}else{
						$tr4.='<td style="width: 350px !important;"></td>';
					}
				}
			}
			$arma_tabla.=$tr4.'</tr>';
			$arma_tabla=str_replace("é", "&eacute;", $arma_tabla);
		}

		//echo $arma_tabla.'<input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" style="width: 10%;" onclick="window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;none&quot;">';
	}
  ?>
  <div class="jmgmodal visible" id="modal-alertas" >
	<div class="panel" style="max-height: 60% !important; max-width: 98% !important; margin-left: 0.5%;">
		<div class="title" style="background-color: #FFFFFF !important; min-height: 10% !important">
			<!-- aqui va el titulo 
            	amarillo fuerte FFFF00
                amarillo suave FFFF6A
            -->
			<span><?=utf8_decode($nombre_rol);?></span>
				<a onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; body.style.overflow = "visible";;window.parent.document.getElementById("cargando_pecc").style.display = "none"' class="waves-effect waves-light btn right" style="background-color: #229BFF; float: right; margin-right: 0% !important;"><i class="material-icons left">&#xE5CD;</i></a>
		</div>
		<div class="content alert-general">
			<?=$arma_tabla;?>
		</div>
		
	</div>
</div>
<style>
	.table{
		width: 100%;
	}
	.td{
		width: 400px !important;
	}
</style>