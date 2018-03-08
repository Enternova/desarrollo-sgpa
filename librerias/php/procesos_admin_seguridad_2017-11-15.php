<?  include("../lib/@session.php");
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



if($_POST["accion"] == "elimina_area_gestor")
	{
		$pv_id = elimina_comillas($pv_id);
		
		$insert = query_db("delete from tseg19_relacion_usuario_area_gestor_ab where id_gestor_ab = $pv_id and  id_area = '".$_POST["id_area_elimina"]."'");
		
		?>
	 	<script>
			alert("Recargue la paguinas")
			//window.parent.ajax_carga('../aplicaciones/administracion/reasignar_usuarios_gestor_abastecimiento.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?
	}
if($_POST["accion"] == "agrega_area_gestor")
	{
		$pv_id = elimina_comillas($pv_id);
		
		$insert = query_db("insert into tseg19_relacion_usuario_area_gestor_ab (id_gestor_ab, id_area) values ($pv_id, ".$_POST["t1_area"].")");
		
		?>
	 	<script>
			alert("Recargue la paguinas")
			//window.parent.ajax_carga('../aplicaciones/administracion/reasignar_usuarios_gestor_abastecimiento.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?
	}
			
if($_POST["accion"] == "modifica_usuario")
	{
		$pv_id = elimina_comillas($pv_id);
		$verifica_email = comprobar_email($email);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail")
					
				</script>
            <?
			exit();
			}
		
		
		
		if($conta_1!=""){
			 $cambio_contrase_nana = md5($conta_1);
			$complemento = " , contrasena = '".$cambio_contrase_nana."',  contra_temporal = 1 ";
			$n_contrasena_e=$conta_1;
		}
		
			
	
		echo  $cambia_cali="update $g1 set  nombre_administrador ='$ap',  email ='$email', telefono ='$dp' , estado ='$fp', fecha_vigencia = '".$_POST["fecha_vigencia"]."' $complemento  where us_id = $pv_id ";
		 $sql_ex = query_db($cambia_cali);

		 
		
		 
	?>
	 	<script>
			alert("El usuario se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?

		
		}
		if($_POST["accion"] == "elimina_usuario")
	{
		$pv_id = elimina_comillas($pv_id);
		$fecha_elimina=date('Y-m-d');
		echo $cambia_cali="update $g1 set estado ='$fp', fecha_inactivacion='$fecha_elimina'  where us_id = $pv_id ";
		 $sql_ex = query_db($cambia_cali);

		 
		
		 
	?>
	 	<script>
			alert("El usuario se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$pv_id;?>','contenido_aux_sub');
		</script>
	<?

		
		}


if($_POST["accion"] == "crea_usuario")
	{
		
	$verifica_email = comprobar_email($email);
	if($verifica_email=="0"){
	?><script>
		alert("Verifique el e-mail");
		 window.parent.document.getElementById("cargando").style.display="none"
	</script>
	<?
	exit();
	}
			
	$busca_usuario = traer_fila_row(query_db("select us_id from $g1 where usuario = '$usuario_pasa' "));
	if($busca_usuario[0]>=1){
	?>
		<script>
			alert("El usuario ya existe\n Intente con otro usuario")
			 window.parent.document.getElementById("cargando").style.display="none"
		</script>
	<?
	exit();
	}
	if($contra_autom=="si"){
		$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9");
		for($i=0;$i<=8;$i++){
		$generador = rand(0,34);
		$nueva_c.= $alfabeto[$generador];
				}
		$complemento =   "'".md5($nueva_c)."'";
		$n_contrasena_e=$nueva_c;
	}else{
		if($conta_1!="" || $conta_1 == $conta_2){
			$complemento = "'".md5($conta_1)."'";
			$n_contrasena_e=$conta_1;
		}else{
		?>
		<script>
			alert("Verifique la contraseña asignada.")
			 window.parent.document.getElementById("cargando").style.display="none"
		</script>
		<?
        exit();	
		}
	}
		
		// Insert SGPA	
		$insert_usu="insert into $g1 (nombre_administrador, usuario, contrasena, email, telefono, 
		estado, accesos_fallidos, fecha_cambio_contrasena, tipo_usuario, pv_id, pv_principal, contra_temporal)
		values ('$nombre_administrador', '$usuario_pasa', $complemento , '$email','$telefono', '$estado',0,'$fecha',$perfil ,0,0,1)";
		$sql_ex=query_db($insert_usu.$trae_id_insrte);
		$id_usu = id_insert($sql_ex);
		
		// Insert Urna Virtual
		$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
		mysql_select_db($dbbase_mys, $link);
		$inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
values ($id_usu,'$nombre_administrador', '$usuario_pasa', $complemento, '$email', '$telefono',$estado,0,'$fecha $hora', $perfil, 0,0,1)";
$sql_e=mysql_query($inserta_us);

		
		if($id_usu>=1){//si se creo
			//mail($email,$asunto,$mensaje_envio,$cabesa);
		 
		?>
	 	<script>
			alert("El usuario se creo con éxito")
			window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usu;?>','contenidos');
		</script>
		<?

		} //si se creo
		else{
		?>
	 	<script>
			alert("El usuario  No se creo verifique el formulario")
		</script>
		<? 
		}	
	}

if($_POST["accion"] == "agrega_usuario_area"){
		// Consulta para validar si el area esta configurada
		$queryArea = "select count(*) from $ts3 where id_usuario = $id_usuario and id_area  = $t1_area and estado = 1";
		$selArea = traer_fila_row(query_db($queryArea));
		
		if($selArea[0] > 0){
		?>
	 	<script>
			alert("Ya existe esta area configurada. Por favor eliminela y vuelvala a configurar");
			window.parent.document.getElementById("cargando").style.display="none";
		</script>
		<? 
		die;
		}else{// Se graba en BD la informacion
			$areaInsert = "insert into $ts3 (id_modulo,id_area,id_usuario,estado) values (1,$t1_area,$id_usuario,1)";
			query_db($areaInsert);
			if($profesional > 0 || $corporativo > 0 || $proyectos > 0 || $stock > 0){
				$proyectos=$corporativo;
				$stock=$corporativo;
				
				$profInsert = "insert into tseg10_usuarios_profesional (id_us,id_us_profesional,id_area,tipo,id_us_prof_compras_corp,id_us_prof_compras_mro,id_us_prof_compras_stok, id_us_prof_servicios_menores)"; 
				$profInsert .= " values ($id_usuario,'$profesional','$t1_area','Admin', '$corporativo','$proyectos','$stock', '$corporativo') ";
				query_db($profInsert);
			}
			if($jefatura > 0){
				$jefaturaInsert = "insert into tseg14_relacion_usuario_superintendente (id_us, id_superintendente, id_area) values ($id_usuario,$jefatura,$t1_area)";
				query_db($jefaturaInsert);
			}
			if($jefeArea > 0){
				$jefeAreaInsert = "insert into tseg13_relacion_usuario_jefe (id_us, id_jefe_area, id_area) values ($id_usuario,$jefeArea,$t1_area)";
				query_db($jefeAreaInsert);
			}
			if($vicepres > 0){
				$vicepresInsert = "insert tseg15_relacion_usuario_vicepresidente (id_us, id_vicepresidente, area) values ($id_usuario,$vicepres,$t1_area)";
				query_db($vicepresInsert);
			}
			if($director > 0){
				$directorInsert = "insert tseg15_relacion_usuario_director (us_id, id_director, id_area) values ($id_usuario,$director,$t1_area)";
				query_db($directorInsert);
			}
			?>
	 	<script>
			alert("Se ha configurado el Area con exito.");
			window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usuario;?>','contenidos');
		</script>
		<?
		}
		
};

if($_POST["accion"] == "elimina_usuario_area"){
	// Se eliminan todas las configuracion del Area usuaria
	$areaDelete = "delete from $ts3 where id_usuario = $id_usuario and id_area = $id_area";
	query_db($areaDelete);
	$profDelete = "delete from tseg10_usuarios_profesional where id_us = $id_usuario and id_area = $id_area";
	query_db($profDelete);
	$jefaturaDelete = "delete from tseg14_relacion_usuario_superintendente where id_us = $id_usuario and id_area = $id_area";
	query_db($jefaturaDelete);
	$jefeAreaDelete = "delete from tseg13_relacion_usuario_jefe where id_us = $id_usuario and id_area = $id_area";
	query_db($jefeAreaDelete);
	$vicepresDelete = "delete from tseg15_relacion_usuario_vicepresidente where id_us = $id_usuario and area = $id_area";
	query_db($vicepresDelete);
	$directorDelete = "delete from tseg15_relacion_usuario_director where us_id = $id_usuario and id_area = $id_area";
	query_db($directorDelete);
	?>
	<script>
		alert("Se ha eliminado la configuracion con exito.");
		window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usuario;?>','contenidos');
	</script>
	<?
}
if($_POST["accion"] == "agrega_usuario_rol"){

		$delete_sql = "delete from  tseg12_relacion_usuario_rol where id_usuario = $id_usuario";
		$sql_ex=query_db($delete_sql);
		foreach($_POST["rol_usuario"] as $rol){
			$insert_sql = "insert into tseg12_relacion_usuario_rol (id_usuario,id_rol_general) values ($id_usuario,".elimina_comillas_2($rol).")";
			$sql_ex=query_db($insert_sql);
		}
	?>
	<script>
		alert("Se ha configurado los roles con Exito.");
		//window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usuario;?>','contenidos');
	</script>
	<?

}

if($_POST["accion"] == "agrega_usuario_permiso"){

		echo $delete_sql = "delete from  $ts5 where id_usuario = $id_usuario";
		$sql_ex=query_db($delete_sql);
		foreach($_POST["perm_usuario"] as $perm){
			$insert_sql = "insert into $ts5 (id_usuario,id_permiso) values ($id_usuario,".elimina_comillas_2($perm).")";
			$sql_ex=query_db($insert_sql);
		}
	?>
	<script>
		alert("Se ha configurado los permisos con Exito.");
		//window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usuario;?>','contenidos');
	</script>
	<?
}

if($_POST["accion"] == "agrega_usuario_emula"){

		$select_sql = "select count (*) from  t2_relacion_usuarios_emulan where id_us = $id_usuario and id_us_emula = $id_us_emula";
		$selSql = traer_fila_row(query_db($select_sql));
		if($selSql[0] == 0){
			echo $insert_sql = "insert into t2_relacion_usuarios_emulan (id_us,id_us_emula) values ($id_usuario,$id_us_emula)";
			$sql_ex=query_db($insert_sql);
			?>
			<script>
                alert("Se ha agregado el Emulador con Exito.");
                window.parent.ajax_carga('../aplicaciones/administracion/emuladores.php?pv_id=<?=$id_usuario;?>','content');
            </script>
            <?
		}else{
		?>
		<script>
			alert("El emulador ya ha sido asignado, por favor revise el formulario.");
		</script>
		<?
		}
}

if($_POST["accion"] == "elimina_usuario_emula"){

		echo $delete_sql = "delete from  t2_relacion_usuarios_emulan where id = $id_emula";
		$sql_ex=query_db($delete_sql);
		?>
		<script>
			alert("Se ha eliminado el Emulador con Exito.");
			window.parent.ajax_carga('../aplicaciones/administracion/emuladores.php?pv_id=<?=$id_usuario;?>','content');
		</script>
		<?
		
}

if($_POST["accion"] == "reasignar_usuarios"){
	$id_area = $_POST['id_area'];
		switch($relacion){
			case 1: 
				$profesional = $_POST['profesional'];
				foreach($_POST["id_us_1"] as $rowProf){
					$insert_sql = "update tseg10_usuarios_profesional set id_us_profesional = $profesional  where id_area = $id_area and id_us = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 2:
				$corporativo = $_POST['corporativo'];
				foreach($_POST["id_us_2"] as $rowProf){
					$insert_sql = "update tseg10_usuarios_profesional set id_us_prof_compras_corp = $corporativo,id_us_prof_compras_mro = $corporativo, id_us_prof_compras_stok = $corporativo, id_us_prof_servicios_menores = $corporativo  where id_area = $id_area and id_us = ".elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 3: 
			$proyectos = $_POST['proyectos'];
				foreach($_POST["id_us_3"] as $rowProf){
					$insert_sql = "update tseg10_usuarios_profesional set id_us_prof_compras_mro = $proyectos  where id_area = $id_area and id_us = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 4: 
			$stock = $_POST['stock'];
				foreach($_POST["id_us_4"] as $rowProf){
					$insert_sql = "update tseg10_usuarios_profesional set id_us_prof_compras_stok = $stock  where id_area = $id_area and id_us = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 5: 
			$jefeArea = $_POST['jefeArea'];
				foreach($_POST["id_us_5"] as $rowProf){
					$insert_sql = "update tseg13_relacion_usuario_jefe set id_jefe_area = $jefeArea  where id_area = $id_area and id_us = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 6: 
			$jefatura = $_POST['jefatura'];
				foreach($_POST["id_us_6"] as $rowProf){
					$insert_sql = "update tseg14_relacion_usuario_superintendente set id_superintendente = $jefatura  where id_area = $id_area and id_us = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
			case 7: 
			$vicepres = $_POST['vicepres'];
				foreach($_POST["id_us_7"] as $rowProf){
					$insert_sql = "update tseg15_relacion_usuario_vicepresidente set id_vicepresidente = $vicepres  where area = $id_area and id_us = ".					elimina_comillas_2($rowProf);

					$sql_ex=query_db($insert_sql);
				}
			break;
			case 8: 
			$director = $_POST['director'];
				foreach($_POST["id_us_8"] as $rowProf){
					$insert_sql = "update tseg15_relacion_usuario_director set id_director = $director  where id_area = $id_area and us_id = ".					elimina_comillas_2($rowProf);
					$sql_ex=query_db($insert_sql);
				}
			break;
		}
		
		?>
		<script>
			alert("Se ha reasignado con Exito.");
			window.parent.ajax_carga('../aplicaciones/administracion/reasignar_usuarios.php?pv_id=<?=$id_usuario;?>&id_area=<?=$id_area;?>','content');
		</script>
		<?
		
}
	
if($_POST["accion"] == "crea_registro")
	{
			
		echo  $cambia_cali="insert into $tabla 	values (NULL,'$n_resgitro')";
		 $sql_ex = query_db($cambia_cali);
			$id_p = id_insert();
				if($id_p>=1){//si se creo
		?>
	 	<script>
			alert("El registro se creo con éxito")
			window.parent.ajax_carga('../aplicaciones/admin_maestras.php?tabla=<?=$tabla;?>&campo_id=<?=$campo_id;?>&titulo_maestra=<?=$titulo_maestra;?>','contenidos');
			
		</script>
	<?

		} //si se creo
			else{
?>
	 	<script>
			alert("El registro  No se creo verifique el formulario")
		</script>
	<?			
			
			}
		
		}
		

if($_POST["accion"] == "edita_registro")
	{
		
		
			
		echo  $cambia_cali="update $tabla 	set nombre ='".$_POST["n_".$id_maestra]."' where $campo_id = $id_maestra ";
		 $sql_ex = query_db($cambia_cali);
		 
	?>
	 	<script>
			alert("El registro se modifico con éxito")
			window.parent.ajax_carga('../aplicaciones/admin_maestras.php?tabla=<?=$tabla;?>&campo_id=<?=$campo_id;?>&titulo_maestra=<?=$titulo_maestra;?>','contenidos');
			
		</script>
	<?

		
		
		}		
		
 ?>

<script>
 window.parent.document.getElementById("cargando").style.display="none"
 </script>

