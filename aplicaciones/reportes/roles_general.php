<?
error_reporting(E_ALL);  // LÃ­neas para mostart errores
ini_set('display_errors', '1');  // LÃ­neas para mostart errores
header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte de Usuarios.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
	
   	$sql_comple.= " us_id>1";
	$estado_us = $_GET["estado"];
	if($_GET["rol"]!="" and $_GET["rol"]!=" " and $_GET["rol"]!=null){
		$sql_comple.=" AND nombre_rol like '%".$_GET["rol"]."%'";
	}
	/*$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];
	if($id_usuario > 0){
	$sql_comple.=" and us_id = ".$id_usuario;	
		}*/
	if($_GET["usuario_permiso"]!="" and $_GET["usuario_permiso"]!=" " and $_GET["usuario_permiso"]!=null){
		$sql_comple.=" AND nombre_administrador like '%".$_GET["usuario_permiso"]."%'";
	}
	
	if($estado_us!=0){
	if($estado_us==1){
	$sql_comple.= " and estado = 1";
	}else{
		$sql_comple.= " and estado not in(1)";
		}
	}/*
	if($estado_us==2){
	$sql_comple.= " and estado = 2 and contrasena = 'Bloqueado'";
	}
	if($estado_us==3){
	$sql_comple.= " and estado = 2 and contrasena = 'Eliminado'";
	}*/
	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>


</head>

<body>
    <?
    	//echo $sql_comple;
    	//PRIMERO SE GENERA LA SÁBANA PARA LA TAQBLA POR SER UNA TABLA DINAMICA
	$cont = 0;
	$tr1='';
	
	
	$tr3='<tr><td style=" background-color: #229BFF; width: 150px !important;">ROL</td>';
	$arma_tabla='<table border="1" class="tabla_lista_resultados"><tr><td  align="center" bgcolor="#229BFF" class="fondo_3"></td>';
	$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
	while($sel_mod = traer_fila_db($sel_modulos)){
		if($cont==0){
			$color="background-color: #4BAE4F;";
			$cont++;
		}else{
			$color="background-color: #229BFF;";
			$cont=0;
		}
		$i=0;
		$sel_cont=query_db("select id_permisos_modulo from v_roles_des099 where id_modulo=".$sel_mod[1]." group by id_permisos_modulo");
		while($sel_cont2 = traer_fila_db($sel_cont)){
			$i++;
		}
		$width=$i*200;
		$tr2='';
		$tr1.='<td style="'.$color.' width: '.$width.'px !important;" colspan="'.$i.' " align="center" bgcolor="#229BFF" class="fondo_3">'.$sel_mod[0].'</td>';
		$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where id_modulo=".$sel_mod[1]));
		$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo from v_roles_des099 where id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
		while($sel_mod2 = traer_fila_db($sel_modulos2 )){
			$tr2.='<td style="'.$color.' width: 150px !important;"  >'.$sel_mod2[0].'</td>';
		}
		$tr3.=$tr2;
	}
	$tr3.='</tr>';
	$arma_tabla.=$tr1.'</tr>'.$tr3;
	//DESPUÉS DE GENERAR LA SÁBANA AHORA SI SE RECORRE LA BD PARA BUSCAR COINCIDENCIAS POR USUARIO
	$sel_usuario = query_db("select nombre_rol, id_rol from v_roles_des099 where ".$sql_comple." group by nombre_rol, id_rol");
	while($sel_usuario2 = traer_fila_db($sel_usuario)){
		$tr4='<tr><td>'.$sel_usuario2[0].'</td>';
		//(echo "select nombre_modulo, id_modulo, nombre_rol, id_rol from v_roles_des099 group by orden_modulo, nombre_modulo, id_modulo, nombre_rol, id_rol order by orden_modulo";
		$sel_modulos = query_db("select nombre_modulo, id_modulo from v_roles_des099 group by orden_modulo, nombre_modulo, id_modulo order by orden_modulo");
		while($sel_mod = traer_fila_db($sel_modulos)){
			//echo "select nombre_permiso, id_permisos_modulo, nombre_modulo, id_modulo from v_roles_des099 where id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso";
			$sel_modulos2 = query_db("select nombre_permiso, id_permisos_modulo, nombre_modulo, id_modulo from v_roles_des099 where id_modulo=".$sel_mod[1]." group by orden_modulo, orden_premiso, nombre_permiso, id_permisos_modulo, nombre_modulo,id_modulo order by orden_modulo, orden_premiso");
			while($sel_mod2 = traer_fila_db($sel_modulos2 )){
				$cont_row_span2=traer_fila_row(query_db("select count(*) from v_roles_des099 where id_rol=".$sel_usuario2[1]." and id_modulo=".$sel_mod[1]." and id_permisos_modulo=".$sel_mod2[1]));
				if($cont_row_span2[0]>0){
					$tr4.='<td align="center" style="width: 150px !important;">SI</td>';
				}else{
					$tr4.='<td  style="width: 150px !important;"></td>';
				}
			}
		}
		$arma_tabla.=$tr4.'</tr>';
	}
	echo $arma_tabla;
  ?>



</body>
</html>
