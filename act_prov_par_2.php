<? session_start();
   ob_start();

	$verifica_https = $_SERVER['HTTPS'];
		

   include("librerias/lib/@include.php");
 
 	function id_insert_sql_ser($sql)
                {
				$tra = mssql_fetch_assoc($sql);
				return $tra['SCOPE_IDENTITY'];
                }	
   
 $trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]";
   
   if($accion=="nuevo_proveedor"){
   
   $cifra_c=md5("321654");
   
		echo $inserta_us = "insert into t1_proveedor (nit, digito_verificacion , razon_social , estado)	values 
		('$nuevo_prove_nit', '', '$nuevo_prove_nombre',1)";
		$sql_ex=mssql_query($inserta_us.$trae_id_insrte);
		$id_ingreso_pro = id_insert_sql_ser($sql_ex);

			if($id_ingreso_pro>=1){//si se creo el proveedor
   
				 $inserta_email_sgpa=mssql_query("insert into t1_proveedor_email (t1_proveedor_id, nombre_responsable, email, tipo, estado) values ($id_ingreso_pro, 
				'PRINCIPAL','$nuevo_prove_email',1,1)");
				

	$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
			mysql_select_db("db_enterproc_hocol", $link);
	
		echo $cambia_cali="insert into  pv_proveedores (pv_id,cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $id_ingreso_pro,678, '$nuevo_prove_nit', '$nuevo_prove_nombre', '','$nuevo_prove_email', '$nuevo_prove_telefono', 1, '' )";
		 $sql_ex = mysql_query($cambia_cali);
					
				
					 echo $inserta_us = "insert into t1_us_usuarios (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
				fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
					values ('$nuevo_prove_nombre', '$nuevo_prove_email', '$cifra_c', '$nuevo_prove_email', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
					$sql_ex_p=mssql_query($inserta_us.$trae_id_insrte);
				$id_ingreso_pro_us = id_insert_sql_ser($sql_ex_p);

 if($id_ingreso_pro_us>=1){//si se creo el usuario		
		 
	  $inserta_us = "insert into us_usuarios (us_id,nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ($id_ingreso_pro_us,'$nuevo_prove_nombre', '$nuevo_prove_email', '$cifra_c', '$nuevo_prove_email', '0',1,0,'$fecha $hora', 2, ".$id_ingreso_pro." ,0,1)";
	$sql_e=mysql_query($inserta_us);

}

   
				
				
				
				}//si se creo el proveedor
		
		
		
   
   
   
   }
 
 

   if($accion=="modofica_proveedor"){
   
 echo "select t1_proveedor_id, nit, razon_social from t1_proveedor where nit = '$nuevo_prove_nit'";
		$busca_provee=mssql_fetch_row(mssql_query("select t1_proveedor_id, nit, razon_social from t1_proveedor where nit = '$nuevo_prove_nit'"));
		if($busca_provee[0]>=1)
			{
echo "update t1_proveedor set razon_social = '$nuevo_prove_nombre' where t1_proveedor_id = $busca_provee[0]";
				$cambia_nombre =mssql_query("update t1_proveedor set razon_social = '$nuevo_prove_nombre' where t1_proveedor_id = $busca_provee[0]");

			$link = mysql_connect("localhost","rene.sterling", "942ASvle*P");
			mysql_select_db("db_enterproc_hocol", $link);
	
			echo $cambia_cali="update pv_proveedores set razon_social = '$nuevo_prove_nombre' where pv_id = $busca_provee[0]";
			 $sql_ex = mysql_query($cambia_cali);
			
			}



}   
   
?>   