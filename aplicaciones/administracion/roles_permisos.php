<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("administracion.html");
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >
  
<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
	<tr>
    	<td colspan="2" class="titulos_secciones">Roles de Usuario</td>
        <td colspan="2" class="titulos_secciones">Permisos de Usuario</td>
    </tr>
    <tr>
    	<td style="width:30%">
        	<table class="table_id display cell-border dataTable">
            	<thead>
                	<tr>
                    	<td>Seleccione los roles que desea asignar</td>
                        <td><input name="button" type="button" class="boton_grabar" id="button" value="Agregar" onClick="agrega_usuario_rol()"></td>
                    </tr>
                </thead>
				<thead>
                	<tr class="fondo_1">
                    	<td>Rol</td>
                        <td>Asignar</td>
                    </tr>
                </thead>
                <tbody>
                <?php $selRol = "select * from  tseg11_roles_general where estado = 1";
				$queryRol = query_db($selRol);
				while ($rowRol = traer_fila_db($queryRol)){
					$selRolUsuario = "SELECT count(*) FROM tseg12_relacion_usuario_rol where id_usuario = $pv_id and id_rol_general = ".$rowRol['id_rol'];
					$queryRolUsuario = traer_fila_db(query_db($selRolUsuario));
					$che = "";
					if($queryRolUsuario[0] >= 1){
						$che = "checked='checked'"; 
					}
					
				?>
                	<tr>
                    	<td><?= $rowRol['nombre']?></td>
                        <td><input type="checkbox" name="rol_usuario[]" id="rol_usuario[]" value="<?= $rowRol['id_rol']?>" <?=$che;?>/></td>
                    </tr>
                <?php }?>
                </tbody>
			</table>
        </td>
        <td><td>
        <td valign="top">
        	<table class="table_id display cell-border dataTable">
            	<thead>
                	<tr>
	                    <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    	<td colspan="2">Seleccione los permisos que desea asignar</td>
                        <td><input name="button" type="button" class="boton_grabar" id="button" value="Agregar" onClick="agrega_usuario_permiso()"></td>
                    </tr>
                </thead>
				<thead>
                	<tr class="fondo_1">
                    	<td>Permiso</td>
                        <td>Asignar</td>
                        <td>Permiso</td>
                        <td>Asignar</td>
                        <td>Permiso</td>
                        <td>Asignar</td>
                    </tr>
                </thead>
                <tbody>
                <?php $selPerm = "select * from  $ts2 where estado = 1";
				$queryPerm = query_db($selPerm);
				$col=1;
				while ($rowPerm = traer_fila_db($queryPerm)){
					$selPermUsuario = "SELECT count(*) FROM $ts5 where id_usuario = $pv_id and id_permiso = ".$rowPerm['id_premiso'];
					$queryPermUsuario = traer_fila_db(query_db($selPermUsuario));
					$che = "";
					if($queryPermUsuario[0] >= 1){
						$che = "checked='checked'"; 
					}
					if($col == 1){
				?>
                	<tr>
                    <?php }?>
                    	<td align="left"><?= $rowPerm['nombre']?></td>
                        <td align="left"><input type="checkbox" name="perm_usuario[]" id="perm_usuario[]" value="<?= $rowPerm['id_premiso']?>" <?=$che;?>/></td>
                    <?php if($col == 3){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 4) $col=1;
				}
				
				if($col != 1 && $col!= 3){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        
        <td>
    </tr>
    </table>



</body>
</html>
