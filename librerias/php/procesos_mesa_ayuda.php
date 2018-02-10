<?  include("../lib/@session.php");
	include("valida_erros_mesa-ayuda.php");
$hora_log = date("G:i:s");
	verifica_menu("administracion.html"); // verifica que el llamado sea de la pagina principal, si no es lo envia a la pagina error,ubicacion sistem/valida_caracteres.php
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER


if($_POST["accion"]=="NOV001")
	{
		$noticia_id=$_POST["t10_mesa_ayuda_principal_id"];
		
		if($_POST["t10_mesa_ayuda_principal_id"]>=1)
			{
				echo $sql_uodate = "update t10_mesa_ayuda_principal set titulo='".$_POST["titulo"]."', descripcion='".$_POST["descripcion"]."', nombre_categoria='".$_POST["nombre_categoria"]."', fecha_post_ini='', fecha_post_fin='', estado=1,
				mail='', leido=0, imagen='aler.gif', url='', contendio_detalle='".elimina_comillas_2($_POST["camp1_solicitud_5"])."', inicio_vigencia='".$_POST["fecha_inicial"]."', final_vigencia='".$_POST["fecha_final"]."', consecutivo='".$_POST["consecutivo"]."' where noticia_id = $noticia_id";
				
				$sql_ex = query_db($sql_uodate);
				alerta_exitosa_personalizados("El registro se grabo con exito","../aplicaciones/mesa-ayuda/creacion_manual.php?t10_mesa_ayuda_principal_id=".$noticia_id,"contenidos"); 
				
				}
		
		
		
		}

if($_POST["accion"]=="NOV002")
	{
		
		
				echo $sql_uodate = "insert into t10_mesa_ayuda_principal (titulo, descripcion,nombre_categoria, fecha_post_ini, fecha_post_fin,estado,
				mail, leido, imagen, url, contendio_detalle, inicio_vigencia, final_vigencia, consecutivo)
				values ('".$_POST["titulo"]."', '".$_POST["descripcion"]."','".$_POST["nombre_categoria"]."', '', '', 1,'', 0, 'aler.gif', '', '".elimina_comillas_2($_POST["camp1_solicitud_5"])."', '".$_POST["fecha_inicial"]."', '".$_POST["fecha_final"]."', '".$_POST["consecutivo"]."')";
		
					$insert_ejecucion_id=query_db($sql_uodate.$trae_id_insrte);
					$noticia_id = id_insert($insert_ejecucion_id);//id del ITEM NUEVO
				alerta_exitosa_personalizados("El registro se grabo con exito","../aplicaciones/mesa-ayuda/creacion_manual.php?t10_mesa_ayuda_principal_id=".$noticia_id,"contenidos"); 
				
		
		
		}
		
if($_POST["accion"]=="PUB001")
	{
		$noticia_id=$_POST["t10_mesa_ayuda_principal_id"];
		
				echo $sql_uodate = "update t10_mesa_ayuda_principal set estado = 2, fecha_post_ini = '$fecha' where noticia_id = $noticia_id";
	
					$insert_ejecucion_id=query_db($sql_uodate);
				alerta_exitosa_personalizados("El registro se grabo con exito","../aplicaciones/mesa-ayuda/creacion_manual.php?t10_mesa_ayuda_principal_id=".$noticia_id,"contenidos"); 
				
		
		
		}		


if($_POST["accion"]=="ADD001")
	{
		$noticia_id=$_POST["t10_mesa_ayuda_principal_id"];
		
		if($_POST["t10_mesa_ayuda_principal_id"]>=1)
			{
				echo $sql_uodate = "insert into t10_relacion_usuario_novedada (t10_mesa_ayuda_principal_id, us_id, fecha_visto, veces_visto, fecha_firme, estado_firme)
 				 values ($noticia_id, $add_usuario_n,'',0,'',1)";
				
				$sql_ex = query_db($sql_uodate);
				alerta_exitosa_personalizados("El registro se grabo con exito","../aplicaciones/mesa-ayuda/creacion_manual.php?t10_mesa_ayuda_principal_id=".$noticia_id,"contenidos"); 
				
				}
		
		
		}

	
?>

