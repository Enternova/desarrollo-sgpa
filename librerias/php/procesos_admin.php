<?  include("../lib/@session.php");
	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



if($_POST["accion"] == "elimina_area_gestor")
	{
		$pv_id = elimina_comillas($pv_id);
		
		$insert = query_db("delete from tseg19_relacion_usuario_area_gestor_ab where id_gestor_ab = $pv_id and  id_area = '".$_POST["id_area_elimina"]."'");
		

			/*** PARA el LOG DE LOS USUARIOS AREA GESTOR***/
		$querygestor = "select * from t1_area  where t1_area_id = ".$_POST["id_area_elimina"]." and estado = 1";
		$selegestor = traer_fila_row(query_db($querygestor));
				/***  se envia el id de la relacion al segundo detalle ***/

		/*** PARA el LOG DE LOS USUARIOS AREA  GESTOR***/

		$id_log = log_de_procesos_sgpa(11, 78, 0, $pv_id, 1, 2);//agrega valores
		log_agrega_detalle ($id_log, "Se Eliminó el Area Gestor ".$selegestor[1]." al usuario ", $pv_id , "",1);


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
		



		/*** PARA el LOG DE LOS USUARIOS AREA GESTOR***/
		$querygestor = "select * from t1_area  where t1_area_id = ".$_POST["t1_area"]." and estado = 1";
		$selegestor = traer_fila_row(query_db($querygestor));
				/***  se envia el id de la relacion al segundo detalle ***/
		
			/*** PARA el LOG DE LOS USUARIOS AREA  GESTOR***/

		$id_log = log_de_procesos_sgpa(11, 77, 0, $pv_id, 0, 0);//agrega valores
		log_agrega_detalle ($id_log, "Se Agregó el Area Gestor ".$selegestor[1]." al usuario ", $pv_id , "",1);
		



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
		
			
	
		$cambia_cali="update $g1 set  nombre_administrador ='$ap',  email ='$email', telefono ='$dp' , estado ='$fp', fecha_vigencia = '".$_POST["fecha_vigencia"]."' $complemento  where us_id = $pv_id ";
		 $sql_ex = query_db($cambia_cali);
		
		/*** PARA el LOG DE LOS USUARIOS ***/
		if($fp==1){
			$estado_log="Activo";
		}else{
			$estado_log="Inactivo";
		}
		if($perfil==3){
			$perfil_log="Usuario Normal con Perfiles Definidos por Roles";
		}elseif($perfil==1){
			$perfil_log="Administrador Apertura Urna Virtual";
		}elseif($perfil==4){
			$perfil_log="Auditor Urna Virtual";
		}else{
			$perfil_log="";
		}
		$id_log = log_de_procesos_sgpa(11, 68, 0, $pv_id, 0, 0);//agrega valores
		log_agrega_detalle ($id_log, "Se Agregó el Nombre ", $ap, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Email ", $email, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Telefono ", $dp, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Estado ", $estado_log, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó la Fecha Cambio de Contraseña ", $_POST["fecha_vigencia"], $g1 , 1);
		

		
		 
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
		$cambia_cali="update $g1 set estado ='$fp', fecha_inactivacion='$fecha_elimina'  where us_id = $pv_id ";
		 $sql_ex = query_db($cambia_cali);

		 	/*** PARA el LOG DE LOS USUARIOS ***/
		  $nombre_log=traer_fila_row(query_db("select nombre_administrador from $g1 where us_id=$pv_id"));
		  $id_log = log_de_procesos_sgpa(11, 67, 0, $pv_id, 1, 2);//agrega valores
		  log_agrega_detalle ($id_log, "Se Eliminó al usuario ", $nombre_log[0] , $g1,1);
		

		
		 
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
		
		/*** PARA el LOG DE LOS USUARIOS ***/
		if($estado==1){
			$estado_log="Activo";
		}else{
			$estado_log="Inactivo";
		}
		if($perfil==3){
			$perfil_log="Usuario Normal con Perfiles Definidos por Roles";
		}elseif($perfil==1){
			$perfil_log="Administrador Apertura Urna Virtual";
		}elseif($perfil==4){
			$perfil_log="Auditor Urna Virtual";
		}else{
			$perfil_log="";
		}
		$id_log = log_de_procesos_sgpa(11, 66, 0, $id_usu, 0, 0);//agrega valores
		log_agrega_detalle ($id_log, "Se Agregó el Nombre ", $nombre_administrador, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Usuario ", $usuario_pasa, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó la Contraseña ", $complemento, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Email ", $email, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Telefono ", $telefono, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Estado ", $estado_log, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó la Fecha Cambio de Contraseña ", $fecha." ".$hora, $g1 , 1);
		log_agrega_detalle ($id_log, "Se Agregó el Perfil ", $perfil_log, $g1 , 1);
		
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

				/*** PARA el LOG DE LOS USUARIOS ***/
		$queryArea = "select * from $ts3 where id_usuario = $id_usuario and id_area  = $t1_area and estado = 1";
		$selArea = traer_fila_row(query_db($queryArea));
				/***  se envia el id de la relacion al segundo detalle ***/
		$queryarea = "select * from $g12 where  t1_area_id  = $t1_area and estado = 1";
		$area = traer_fila_row(query_db($queryarea));
			/*** PARA el LOG DE LOS USUARIOS ***/

		$id_log = log_de_procesos_sgpa(11, 69, 0, $id_usuario, 0, 0);//agrega valores
		log_agrega_detalle ($id_log, "Se Agregó el Area ", $area[1] , $ts3,1);
		//log_agrega_detalle ($id_log, "Se Agregó el Area ", $selArea[0] , "",1);



			if($profesional > 0 || $corporativo > 0 || $proyectos > 0 || $stock > 0){
				$proyectos=$corporativo;
				$stock=$corporativo;
				$servi_menor=$corporativo;

				
				$profInsert = "insert into tseg10_usuarios_profesional (id_us,id_us_profesional,id_area,tipo,id_us_prof_compras_corp,id_us_prof_compras_mro,id_us_prof_compras_stok, id_us_prof_servicios_menores)"; 
				$profInsert .= " values ($id_usuario,'$profesional','$t1_area','Admin', '$corporativo','$proyectos','$stock', '$servi_menor') ";
				query_db($profInsert);




				$querypro = "select * from t1_us_usuarios where us_id = $profesional and estado = 1";
				$selpro = traer_fila_row(query_db($querypro));

			//	$id_log = log_de_procesos_sgpa(11, 79, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Profesional C&C ", $selpro[1] , "tseg10_usuarios_profesional",1);


				$querycor = "select * from t1_us_usuarios where us_id = $corporativo and estado = 1";
				$selcor = traer_fila_row(query_db($querycor));

				//$id_log = log_de_procesos_sgpa(11, 80, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Comprador Corporativo ", $selcor[1],  "tseg10_usuarios_profesional",1);


				$queryproy = "select * from t1_us_usuarios where us_id = $proyectos and estado = 1";
				$selproy = traer_fila_row(query_db($queryproy));

			//	$id_log = log_de_procesos_sgpa(11, 81, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Comprador Proyectos ", $selproy[1], "tseg10_usuarios_profesional",1);


				$querystock = "select * from t1_us_usuarios where us_id = $stock and estado = 1";
				$selestock = traer_fila_row(query_db($querystock));

				//$id_log = log_de_procesos_sgpa(11, 82, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Comprador Stock ", $selestock[1], "tseg10_usuarios_profesional",1);


				$querymenor = "select * from t1_us_usuarios where us_id = $servi_menor and estado = 1";
				$selemenor = traer_fila_row(query_db($querymenor));

			//	$id_log = log_de_procesos_sgpa(11, 87, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Servicio Menor ", $selemenor[1], "tseg10_usuarios_profesional",1);





			}
			if($jefatura > 0){
				$jefaturaInsert = "insert into tseg14_relacion_usuario_superintendente (id_us, id_superintendente, id_area) values ($id_usuario,$jefatura,$t1_area)";
				query_db($jefaturaInsert);


				$queryjefatura = "select * from t1_us_usuarios where us_id = $jefatura and estado = 1";
				$selejefatura = traer_fila_row(query_db($queryjefatura));

				//$id_log = log_de_procesos_sgpa(11, 83, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó la Jefatura ", $selejefatura[1], "tseg14_relacion_usuario_superintendente",1);




			}
			if($jefeArea > 0){
				$jefeAreaInsert = "insert into tseg13_relacion_usuario_jefe (id_us, id_jefe_area, id_area) values ($id_usuario,$jefeArea,$t1_area)";
				query_db($jefeAreaInsert);


				$queryjefearea = "select * from t1_us_usuarios where us_id = $jefeArea and estado = 1";
				$selejefearea = traer_fila_row(query_db($queryjefearea));

				//$id_log = log_de_procesos_sgpa(11, 84, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Jefe de Area ", $selejefearea[1], "tseg13_relacion_usuario_jefe",1);




			}
			if($vicepres > 0){
				$vicepresInsert = "insert tseg15_relacion_usuario_vicepresidente (id_us, id_vicepresidente, area) values ($id_usuario,$vicepres,$t1_area)";
				query_db($vicepresInsert);
			


				$queryvicepre = "select * from t1_us_usuarios where us_id = $vicepres and estado = 1";
				$selevicepre = traer_fila_row(query_db($queryvicepre));

				//$id_log = log_de_procesos_sgpa(11, 85, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Vicepresidente ", $selevicepre[1], "tseg15_relacion_usuario_vicepresidente",1);




			}
			if($director > 0){
				$directorInsert = "insert tseg15_relacion_usuario_director (us_id, id_director, id_area) values ($id_usuario,$director,$t1_area)";
				query_db($directorInsert);



				$querydirector = "select * from t1_us_usuarios where us_id = $director and estado = 1";
				$seledirector = traer_fila_row(query_db($querydirector));

				//$id_log = log_de_procesos_sgpa(11, 86, 0, $id_usuario, 0, 0);//agrega valores
				log_agrega_detalle ($id_log, "Se Agregó el Director ", $seledirector[1], "tseg15_relacion_usuario_director",1);



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

	/*** PARA el LOG DE LOS USUARIOS ***/
		$queryArea = "select * from $ts3 where id_usuario = $id_usuario and id_area  = $id_area and estado = 1";
		$selArea = traer_fila_row(query_db($queryArea));
/***  se envia el id de la relacion al segundo detalle ***/



	// Se eliminan todas las configuracion del Area usuaria
	$areaDelete = "delete from $ts3 where id_usuario = $id_usuario and id_area = $id_area";
	query_db($areaDelete);


		
				
		$queryarea = "select * from $g12 where  t1_area_id  = $id_area and estado = 1";
		$area = traer_fila_row(query_db($queryarea));
			/*** PARA el LOG DE LOS USUARIOS ***/

		$id_log = log_de_procesos_sgpa(11, 70, 0, $id_usuario, 1, 2);//agrega valores
		log_agrega_detalle ($id_log, "Se Eliminó el Area ", $area[1], $ts3,1);
		//log_agrega_detalle ($id_log, "Se Eliminó el Area ", $selArea[0] , "",1);
	$query_usuarios=query_db("select id_us_profesional,id_us_prof_compras_corp,id_us_prof_compras_mro,id_us_prof_compras_stok, id_us_prof_servicios_menores from tseg10_usuarios_profesional where id_us = $id_usuario and id_area = $id_area");
	while($lt=traer_fila_db($query_usuarios)){
		$querypro = "select * from t1_us_usuarios where us_id = $lt[0] and estado = 1";
		$selpro = traer_fila_row(query_db($querypro));
		log_agrega_detalle ($id_log, "Se Eliminó el Profesional C&C ", $selpro[1] , "tseg10_usuarios_profesional",1);
		
		$querycor = "select * from t1_us_usuarios where us_id = $lt[1] and estado = 1";
		$selcor = traer_fila_row(query_db($querycor));
		log_agrega_detalle ($id_log, "Se Eliminó el Comprador Corporativo ", $selcor[1],  "tseg10_usuarios_profesional",1);
		
		$queryproy = "select * from t1_us_usuarios where us_id = $lt[2] and estado = 1";
		$selproy = traer_fila_row(query_db($queryproy));
		log_agrega_detalle ($id_log, "Se Eliminó el Comprador Proyectos ", $selproy[1], "tseg10_usuarios_profesional",1);
		
		$querystock = "select * from t1_us_usuarios where us_id = $lt[3] and estado = 1";
		$selestock = traer_fila_row(query_db($querystock));
		log_agrega_detalle ($id_log, "Se Eliminó el Comprador Stock ", $selestock[1], "tseg10_usuarios_profesional",1);
		
		$querymenor = "select * from t1_us_usuarios where us_id = $lt[4] and estado = 1";
		$selemenor = traer_fila_row(query_db($querymenor));
		log_agrega_detalle ($id_log, "Se Eliminó el Servicio Menor ", $selemenor[1], "tseg10_usuarios_profesional",1);
	}
	$profDelete = "delete from tseg10_usuarios_profesional where id_us = $id_usuario and id_area = $id_area";
	query_db($profDelete);
	
	$jefaturaSelect = traer_fila_row(query_db("select id_superintendente from tseg14_relacion_usuario_superintendente where id_us = $id_usuario and id_area = $id_area"));
	$queryjefatura = "select * from t1_us_usuarios where us_id = $jefaturaSelect[0] and estado = 1";
	$selejefatura = traer_fila_row(query_db($queryjefatura));
	log_agrega_detalle ($id_log, "Se Eliminó la Jefatura ", $selejefatura[1], "tseg14_relacion_usuario_superintendente",1);
	$jefaturaDelete = "delete from tseg14_relacion_usuario_superintendente where id_us = $id_usuario and id_area = $id_area";
	query_db($jefaturaDelete);
	
	$jefaturaSelect = traer_fila_row(query_db("select id_jefe_area from tseg13_relacion_usuario_jefe where id_us = $id_usuario and id_area = $id_area"));
	$queryjefatura = "select * from t1_us_usuarios where us_id = $jefaturaSelect[0] and estado = 1";
	$selejefearea = traer_fila_row(query_db($queryjefatura));
	log_agrega_detalle ($id_log, "Se Eliminó el Jefe de Area ", $selejefearea[1], "tseg13_relacion_usuario_jefe",1);
	$jefeAreaDelete = "delete from tseg13_relacion_usuario_jefe where id_us = $id_usuario and id_area = $id_area";
	query_db($jefeAreaDelete);
	
	$jefaturaSelect = traer_fila_row(query_db("select id_vicepresidente from tseg15_relacion_usuario_vicepresidente where id_us = $id_usuario and area = $id_area"));
	$queryvicepre = "select * from t1_us_usuarios where us_id = $jefaturaSelect[0] and estado = 1";
	$selevicepre = traer_fila_row(query_db($queryvicepre));
	log_agrega_detalle ($id_log, "Se Eliminó el Vicepresidente ", $selevicepre[1], "tseg15_relacion_usuario_vicepresidente", 1);
	$vicepresDelete = "delete from tseg15_relacion_usuario_vicepresidente where id_us = $id_usuario and area = $id_area";
	query_db($vicepresDelete);
	
	$jefaturaSelect = traer_fila_row(query_db("select id_director from tseg15_relacion_usuario_director where us_id = $id_usuario and id_area = $id_area"));
	$querydirector = "select * from t1_us_usuarios where us_id = $jefaturaSelect[0] and estado = 1";
	$seledirector = traer_fila_row(query_db($querydirector));
	log_agrega_detalle ($id_log, "Se Eliminó el Director ", $seledirector[1], "tseg15_relacion_usuario_director",1);
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
	/*** PARA el LOG DE LOS USUARIOS ***/
	$selContUser=traer_fila_row(query_db("select count(*) from tseg12_relacion_usuario_rol where id_usuario=$id_usuario"));
	$selUser=traer_fila_row(query_db("select * from $g1 where us_id=$id_usuario"));
	if($selContUser[0]>0){
		$id_log = log_de_procesos_sgpa(11, 72, 0, $id_usuario, 1, 2);//agrega valores
		log_agrega_detalle ($id_log, "Se Eliminaron Rooles al Usuario ", $selUser[1], "tseg12_relacion_usuario_rol",1);
		//log_agrega_detalle ($id_log, "Se Eliminó el Area ", $selArea[0] , "",1);
		$query_usuarios=query_db("select * from tseg12_relacion_usuario_rol where id_usuario=$id_usuario");
		while($lt=traer_fila_db($query_usuarios)){
			$queryrol = "select * from tseg11_roles_general where  id_rol  = $lt[1]";
			$rol_nombre = traer_fila_row(query_db($queryrol));
			log_agrega_detalle ($id_log, "Se Eliminó el Rol al usuario ", $rol_nombre[1] , "tseg12_relacion_usuario_rol",1);
		}
		$delete_sql = "delete from  tseg12_relacion_usuario_rol where id_usuario = $id_usuario";
		$sql_ex=query_db($delete_sql);
	}
	$id_log = log_de_procesos_sgpa(11, 71, 0, $id_usuario, 0, 0);//agrega valores
	log_agrega_detalle ($id_log, "Se Agregaron Roles al Usuario ", $selUser[1], "tseg12_relacion_usuario_rol",1);
		foreach($_POST["rol_usuario"] as $rol){

			/*** se asigna esta consulta para obtener el nombre del rol y se le asigna al detalle del log***/
			$queryrol = "select * from tseg11_roles_general where  id_rol  = ".elimina_comillas_2($rol)." and estado = 1";
			$rol_nombre = traer_fila_row(query_db($queryrol));
			$insert_sql = "insert into tseg12_relacion_usuario_rol (id_usuario,id_rol_general) values ($id_usuario,".elimina_comillas_2($rol).")";
			$sql_ex=query_db($insert_sql);
			log_agrega_detalle ($id_log, "Se Agrega Rol ", $rol_nombre[1], "tseg12_relacion_usuario_rol",1);
		
		}
	?>
	<script>
		alert("Se ha configurado los roles con Exito.");
		//window.parent.ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$id_usuario;?>','contenidos');
	</script>
	<?

}

if($_POST["accion"] == "agrega_usuario_permiso"){
		/*** PARA el LOG DE LOS USUARIOS ***/
	$selContUser=traer_fila_row(query_db("select count(*) from $ts5 where id_usuario=$id_usuario"));
	$selUser=traer_fila_row(query_db("select * from $g1 where us_id=$id_usuario"));
	if($selContUser[0]>0){
		$id_log = log_de_procesos_sgpa(11, 74, 0, $id_usuario, 1, 2);//agrega valores
		log_agrega_detalle ($id_log, "Se Eliminaron Permisos al Usuario ", $selUser[1], $ts5,1);
		//log_agrega_detalle ($id_log, "Se Eliminó el Area ", $selArea[0] , "",1);
		$query_usuarios=query_db("select * from $ts5 where id_usuario=$id_usuario");
		while($lt=traer_fila_db($query_usuarios)){
			$queryperm = "select * from tseg2_permisos where  id_premiso  = $lt[2] and estado = 1";
			$perm_nombre = traer_fila_row(query_db($queryperm));
			log_agrega_detalle ($id_log, "Se Eliminó el Permiso al usuario ", $perm_nombre[3] , $ts5,1);
		}
		$delete_sql = "delete from  $ts5 where id_usuario = $id_usuario";
		$sql_ex=query_db($delete_sql);
	}
	$id_log = log_de_procesos_sgpa(11, 73, 0, $id_usuario, 0, 0);//agrega valores
	log_agrega_detalle ($id_log, "Se Agregaron Roles al Usuario ", $selUser[1], $ts5,1);
		$sql_ex=query_db($delete_sql);
		foreach($_POST["perm_usuario"] as $perm){

			/*** se asigna esta consulta para obtener el nombre del permiso y se le asigna al detalle del log***/
			$queryperm = "select * from tseg2_permisos where  id_premiso  = ".elimina_comillas_2($perm)." and estado = 1";
			$perm_nombre = traer_fila_row(query_db($queryperm));


			$insert_sql = "insert into $ts5 (id_usuario,id_permiso) values ($id_usuario,".elimina_comillas_2($perm).")";
			$sql_ex=query_db($insert_sql);
			log_agrega_detalle ($id_log, "Se Agregó el Permiso", $perm_nombre[3] , $ts5,1);
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



		/*** PARA el LOG DE LOS USUARIOS EMULA***/
		$queryemula = "select * from t1_us_usuarios  where us_id = $id_us_emula and estado = 1";
		$selemula = traer_fila_row(query_db($queryemula));
				/***  se envia el id de la relacion al segundo detalle ***/
		
			/*** PARA el LOG DE LOS USUARIOS EMULA***/

		$id_log = log_de_procesos_sgpa(11, 75, 0, $id_usuario, 0, 0);//agrega valores
		log_agrega_detalle ($id_log, "Se Agregó el Usuario Emula ".$selemula[1]." al usuario ", $id_usuario , "",1);
		

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


		$select_sqlemula = "select * from  t2_relacion_usuarios_emulan where id = $id_emula";
		$selecidemula = traer_fila_row(query_db($select_sqlemula));

		echo $delete_sql = "delete from  t2_relacion_usuarios_emulan where id = $id_emula";
		$sql_ex=query_db($delete_sql);



/*** PARA el LOG DE LOS USUARIOS EMULA ***/
		$queryemula = "select * from t1_us_usuarios  where us_id = ".$selecidemula[2]." and estado = 1";
		$selemula1 = traer_fila_row(query_db($queryemula));
				/***  se envia el id de la relacion al segundo detalle ***/
				
		/*** PARA el LOG DE LOS USUARIOS EMULA***/

		$id_log = log_de_procesos_sgpa(11, 76, 0, $id_usuario, 1, 2);//agrega valores
		log_agrega_detalle ($id_log, "Se Eliminó el Usuario Emula ".$selemula1[1]." al usuario ", $id_usuario , "",1);



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

