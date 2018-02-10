<?  include("../lib/@session.php");
/*******************************************************************************************************************************/
//AÑADE ARTICULO A LA LISTA
/*******************************************************************************************************************************/

if($_POST["accion"]=="crea_articulo_temporal")
	{
		$articulo = explode("----,",$articulos);
		$busca_mejor_articulo = "select * from $l6 where lista2_id = $articulo[0] and estado = 1  order by valor asc limit 0,1";
		$sql_busca = traer_fila_row(query_db($busca_mejor_articulo));
		if($sql_busca[0]>=1){//si hay proveedores asociados a lista
			
			$insert = "insert into $l5 (session_compra, lista4_id, lista6_id, cantidad, valor, observaciones, dias_prometidos, dias_ajustados, aceptacion_proveedor, observaciones_proveedor) values (
			'$session_compra', '$id_compra',$sql_busca[0], $cantidad ,$sql_busca[3],'', $sql_busca[4],0,0,''  )";
			
			if($id_compra>=1) $ruta = "edita_solicitudes.php?id_compra=".$id_compra;
			else $ruta = "crea_solicitudes.php?session_compra=".$session_compra;
			$sql_insert=query_db($insert );
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?
		
		
		}//si hay proveedores asociados a lista
		

	}
	
	
if($_POST["accion"]=="crea_articulo_temporal_uno_p")
	{
			
		$busca_mejor_articulo = "select * from $l6 where lista6_id  = $id_linea";
		$sql_busca = traer_fila_row(query_db($busca_mejor_articulo));
				
			echo $insert = "insert into $l5 (session_compra, lista4_id, lista6_id, cantidad, valor, observaciones, dias_prometidos, dias_ajustados, aceptacion_proveedor, observaciones_proveedor) values (
			'$session_compra', '$id_compra',$id_linea, ".$_POST["cantidad_so_".$id_linea]." ,$sql_busca[3],'', $sql_busca[4],0,0,''  )";
			

			if($id_compra>=1) $ruta = "edita_solicitudes.php?id_compra=".$id_compra."&pag=$pagij";
			else $ruta = "crea_solicitudes.php?session_compra=".$session_compra."&pag=$pagij";
			$sql_insert=query_db($insert );
			echo $ruta ;
			?>
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			<?

	}	
/*******************************************************************************************************************************/
//AÑADE ARTICULO A LA LISTA
/*******************************************************************************************************************************/

if($_POST["accion"]=="guardar_parcialmente")
	{
		$insert = query_db("insert into $l4 (us_id, fecha_creacion, observaciones, estado) values (".$_SESSION["id_us_session"].", '$fecha $hora', '',1) ");
		$id_p = id_insert();
		if($id_p>=1){
		echo "update $l5 set lista4_id = '$id_p' where session_compra = '$session_compra'";
			$cambia = query_db("update $l5 set lista4_id = '$id_p' where session_compra = '$session_compra'");
			$sql_insert=query_db($insert );
			$ruta = "edita_solicitudes.php?id_compra=".$id_p."&pag=$pagij";
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?		
		
		
		}


	}
	

if($_POST["accion"]=="cambia_cantidades")
	{
		echo "update $l5 set cantidad = '".$_POST["cantidad_".$id_elimina]."' where lista5_id= $id_elimina";
			$cambia = query_db("update $l5 set cantidad = '".$_POST["cantidad_".$id_elimina]."' where lista5_id= $id_elimina");
		
				if($id_compra>=1) $ruta = "edita_solicitudes.php?id_compra=".$id_compra."&pag=$pagij";
			else $ruta = "crea_solicitudes.php?session_compra=".$session_compra."&pag=$pagij";
			$sql_insert=query_db($insert );
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?
	}	
	

if($_POST["accion"]=="elimina_articulo")
	{

			$cambia = query_db("delete from $l5  where lista5_id= $id_elimina");
		
				if($id_compra>=1) $ruta = "edita_solicitudes.php?id_compra=".$id_compra."&pag=$pagij";
			else $ruta = "crea_solicitudes.php?session_compra=".$session_compra."&pag=$pagij";
			$sql_insert=query_db($insert );
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?

	}		


if($_POST["accion"]=="cambia_proveedor")
	{
		
		$cambia = query_db("delete from $l5  where lista5_id= $id_linea");
		
		 $busca_mejor_articulo = "select * from $l6 where lista6_id = $id_elimina";
		$sql_busca = traer_fila_row(query_db($busca_mejor_articulo));
			
			$insert = "insert into $l5 (session_compra, lista4_id, lista6_id, cantidad, valor, observaciones, dias_prometidos, dias_ajustados, aceptacion_proveedor, observaciones_proveedor) values (
			'$session_compra', '$id_compra',$sql_busca[0], '".$_POST["cantidad_".$id_linea]."' ,$sql_busca[3],'', $sql_busca[4],0,0,''  )";
			
			if($id_compra>=1) $ruta = "edita_solicitudes.php?id_compra=".$id_compra."&pag=$pagij";
			else $ruta = "crea_solicitudes.php?session_compra=".$session_compra."&pag=$pagij";
			$sql_insert=query_db($insert );
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?
		
		

		

	}


if($_POST["accion"]=="crea_usuario_lista")
	{
		
		$b_usuarios = explode("----,",$b_usuarios);
		
		 echo $busca_mejor_articulo = "update $l3 set estado = 2 where us_id =  $b_usuarios[1] and lista1_id  = $lista_c";
		 $sql_busca = query_db($busca_mejor_articulo);
			
			$insert = "insert into $l3 (lista1_id , us_id, periocidad , monto_maximo, observaciones, estado) values (
			$lista_c, $b_usuarios[1],'$periocidad', $monto ,'',1 )";
			$sql_busca = query_db($insert);
			
		
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/usuarios.php','contenidos');
                    </script>
			
			<?
		
		

		

	}

	

if($_POST["accion"]=="notifica_proveedor_articulo")
	{

			$insert = query_db("update $l4 set fecha_creacion = '$fecha $hora' where lista4_id = $id_compra");
			$ruta = "cierra_solicitudes.php?id_compra=".$id_compra."&pag=$pagij";
			?>
            
					<script> 
                    window.parent.ajax_carga('../aplicaciones/lista_precios/<?=$ruta;?>','contenidos');
                    </script>
			
			<?

	}	

	
	 ?>