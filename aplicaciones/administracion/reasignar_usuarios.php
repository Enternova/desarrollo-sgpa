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
  
<table width="99%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
	<tr>
    	<td colspan="3" class="titulos_secciones">Reasignar Usuarios</td>
    </tr><input type="hidden" name="relacion" id="relacion" value="" /> 
    <tr>
        <td>
            <table style="width:50%">
                <tr>
                    <td style="width:40%">Seleccione el Area</td>
                    <td>
                    <?php //$queryArea = "select id_area,nombre from $ts3 inner join $g12 on t1_area_id = id_area where id_usuario = $pv_id and $g12.estado = 1";
					$nombre = traer_nombre_muestra($pv_id, $g1,"nombre_administrador","us_id");
					$queryArea = "
					select distinct id_area,area from reporte_usuarios 
					where PROFESIONAL = '$nombre'or 
					COMPRA_CORP = '$nombre' or 
					COMPRA_PROYEC = '$nombre' or 
					COMPRA_STOK = '$nombre' or  
					SUPER_INTENDENTE = '$nombre' or  
					JEFE_AREA = '$nombre' or 
					VICEPRESIDENT = '$nombre' or  
					DIRECTOR = '$nombre' order by area asc
					";
                    $selArea = query_db($queryArea);
                    ?>
                    <select name="id_area" id="id_area" onChange="ajax_carga('../aplicaciones/administracion/reasignar_usuarios.php?pv_id=<?=$pv_id;?>&id_area=' + this.value,'content')">
                    <option value="0">Seleccione</option>
                    <?php while($rowArea = traer_fila_db($selArea)){?>
                    <option value="<?=$rowArea['id_area']?>" <?= ($rowArea['id_area'] == $id_area)?'selected':''?>><?=$rowArea['area']?></option>
                    <?php }?>
                    </select>
                    </td>
                </tr>
            </table>
    	</td>
    </tr>
    <tr>
    	<td style="width:50%" valign="top">
        <?php 
		$query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (13)";// Rol profesional
		$sel_comp = query_db($query);//profeisonal
		
		$query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (17)";// Rol comprador
		$corporativo = query_db($query);
		$proyectos = query_db($query);
		$stock = query_db($query);
		?>
        	<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Profesional C&C </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Profesional de CYC-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(1)"></td>
                    <td colspan="1">
                        <select name="profesional" id="profesional">
                        <option value="0">Seleccione</option>
                        <?php while($rowComp = traer_fila_db($sel_comp)){?>
                        <option value="<?=$rowComp['us_id']?>"><?=$rowComp['nombre_administrador']?></option>
                        <?php }?>
                        </select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg10_usuarios_profesional where id_us_profesional = $pv_id and id_area = $id_area");
					$col=1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){
					?>
                	<tr>
                    <?php }?>
                
                    
                    	<td><input type="checkbox" name="id_us_1[]" id="id_us_1[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
    			?>
                </tbody>
			</table>
        </td>
        
        <!--   JEFE DE AREA-->
        
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Gerente de Area</td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Jefe de Area-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(5)"></td>
                    <td colspan="1">
                        <?php $query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (10)";
						$jefeArea = query_db($query);?>
						<select name="jefeArea" id="jefeArea">
						<option value="0">Seleccione</option>
						<?php while($rowjefeArea = traer_fila_db($jefeArea)){?>
						<option value="<?=$rowjefeArea['us_id']?>"><?=$rowjefeArea['nombre_administrador']?></option>
						<?php }?>
						</select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg13_relacion_usuario_jefe where id_jefe_area = $pv_id and id_area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_5[]" id="id_us_5[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
        
    </tr>
    
    <tr>
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Comprador Corporativo <strong>* Solo este comprador es necesario</strong></td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Comprador Corporativo-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(2)"></td>
                    <td colspan="1">
                        <select name="corporativo" id="corporativo">
                        <option value="0">Seleccione</option>
                        <?php while($rowCorporativo = traer_fila_db($corporativo)){?>
                        <option value="<?=$rowCorporativo['us_id']?>"><?=$rowCorporativo['nombre_administrador']?></option>
                        <?php }?>
                        </select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg10_usuarios_profesional where id_us_prof_compras_corp = $pv_id and id_area = $id_area");
					$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){
					?>
                	<tr>
                    <?php }?>
                
                    
                    	<td><input type="checkbox" name="id_us_2[]" id="id_us_2[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
        
        <!-- Jefatura de Operacion-->
        
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Jefatura </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Jefatura de Operacion-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(6)"></td>
                    <td colspan="1">
                        <select name="jefatura" id="jefatura">
							<?=listas($g1, " estado = 1 and tipo_usuario in (1,3)",null ,'nombre_administrador', 1);?>
                        </select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg14_relacion_usuario_superintendente where id_superintendente = $pv_id and id_area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_6[]" id="id_us_6[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
    </tr>
    
    <tr>
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Comprador Proyectos </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Comprador Proyectos-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(3)"></td>
                    <td colspan="1">
                        <select name="proyectos" id="proyectos">
                        <option value="0">Seleccione</option>
                        <?php while($rowProyectos = traer_fila_db($proyectos)){?>
                        <option value="<?=$rowProyectos['us_id']?>"><?=$rowProyectos['nombre_administrador']?></option>
                        <?php }?>
                        </select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg10_usuarios_profesional where  id_us_prof_compras_mro = $pv_id and id_area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_3[]" id="id_us_3[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
        <!-- Vicepresidente-->
        
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Vicepresidente </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Vicepresidente-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(7)"></td>
                    <td colspan="1">
                       <?php 
					   $query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (22)";// Rol comprador
					   $vicepres = query_db($query);?>
        <select name="vicepres" id="vicepres">
        <option value="0">Seleccione</option>
		<?php while($rowVicepres = traer_fila_db($vicepres)){?>
        <option value="<?=$rowVicepres['us_id']?>"><?=$rowVicepres['nombre_administrador']?></option>
		<?php }?>
		</select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg15_relacion_usuario_vicepresidente where id_vicepresidente = $pv_id and area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_7[]" id="id_us_7[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
    </tr>
    
    <tr>
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Comprador STOCK </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Comprador Stock-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(4)"></td>
                    <td colspan="1">
                        <select name="stock" id="stock">
                        <option value="0">Seleccione</option>
                        <?php while($rowStock = traer_fila_db($stock)){?>
                        <option value="<?=$rowStock['us_id']?>"><?=$rowStock['nombre_administrador']?></option>
                        <?php }?>
                        </select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select id_us from tseg10_usuarios_profesional where  id_us_prof_compras_stok = $pv_id and id_area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_4[]" id="id_us_4[]" value="<?= $sel_usu['id_us']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['id_us'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
        <!-- Director-->
        
        <td style="width:50%" valign="top">
       		<table class="table_id display cell-border dataTable">
            	<thead>
                <tr class="fondo_1">
                	<td colspan="2" align="center"> Director </td><!-- Usuarios asignados cuando el rol del usuario que se esta ajustando es Director-->
                    <td><input name="button" type="button" class="boton_grabar" id="button" value="Reasignar a" onClick="reasignar_usuarios(8)"></td>
                    <td colspan="1">
                       <?php $vicepres = query_db($query);?>
        <select name="director" id="director">
        <option value="0">Seleccione</option>
		<?php while($rowVicepres = traer_fila_db($vicepres)){?>
        <option value="<?=$rowVicepres['us_id']?>"><?=$rowVicepres['nombre_administrador']?></option>
		<?php }?>
		</select>
                        </td>
                </tr>
                	<tr class="fondo_1">
                    	<td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                        <td style="width:15%">&nbsp;</td>
                        <td style="width:35%">Usuario</td>
                    </tr>
                </thead>
                <tbody>
                	<?php 
					$sel_usuarios = query_db("select us_id from tseg15_relacion_usuario_director where id_director = $pv_id and id_area = $id_area");
				$col = 1;
				while($sel_usu = traer_fila_db($sel_usuarios)){
                    if($col == 1){?>
                	<tr>
                    <?php }?>
                    	<td><input type="checkbox" name="id_us_8[]" id="id_us_8[]" value="<?= $sel_usu['us_id']?>"/></td>
                    	<td><?= traer_nombre_muestra($sel_usu['us_id'], $g1,"nombre_administrador","us_id");?></td>
                        
                    <?php if($col == 2){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 3) $col=1;
				}
				
				if($col != 1 && $col!= 2){
				echo "</tr>";
				}
				?>
                </tbody>
			</table>
        </td>
    </tr>
    </table>

</body>
</html>
