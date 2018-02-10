<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("administracion.html");

	$busca_proveedor = traer_fila_row(query_db("select * from $g1 where us_id = ".$pv_id));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<style>
pre {text-indent: 30px} 

#tabmenu { 
color: #000; 
border-bottom: 1px solid black; 
margin: 12px 0px 0px 0px; 
padding: 0px; 
z-index: 1; 
padding-left: 10px 
} 

#tabmenu li {
margin-left:10px;
display: inline; 
overflow: hidden; 
list-style-type: none; } 

#tabmenu a, a.active { 
background: #005395;
font: normal 1em verdana, Arial, sans-serif; 
border: 1px solid black; 
padding: 2px 5px 0px 5px; 
margin: 0px; 
text-decoration: none;
cursor:hand; } 

#tabmenu a.active { 
background: #ffffff; 
border-bottom: 3px solid #ffffff; } 

#tabmenu a:hover { 
color: #fff; 
background: #ADC09F; } 

#tabmenu a:visited { 
color: #E8E9BE; } 

#tabmenu a.active:hover { 
background: #ffffff; 
color: #DEDECF; } 

#content {font: 0.9em/1.3em verdana, sans-serif; 
text-align: justify; 
background: #ffffff; 
padding: 10px; 
border: 1px solid black; 
border-top: none; 
z-index: 2; } 

#content a { 
text-decoration: none; 
color: #E8E9BE; } 

#content a:hover { background: #aaaaaa; } 
</style>
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">ADMINISTRACION DE USUARIOS</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="18%" height="34"><div align="right">Nombre:</div></td>
    <td width="33%"><div align="left">
      <label>
      
      <input name="ap" type="text" id="ap" value="<?=$busca_proveedor[1];?>" size="50">      </label>
    </div></td>
    <td width="20%"><div align="right">Usuario:</div></td>
    <td width="29%"><div align="left">
        <?=$busca_proveedor[2];?>
    </div>    </td>
  </tr>
  <tr>
    <td height="35"><div align="right">
      <input type="hidden"  name="perfil" id="perfil" value="<?=$busca_proveedor[9]?>" />
    E-mail:</div></td>
    <td><div align="left">
      <input name="email" type="text" id="email"  value="<?=$busca_proveedor[4];?>" size="50">
    </div></td>
    <td><div align="right">Tel&eacute;fono:</div></td>
    <td><div align="left">
      <input name="dp" type="text" id="dp"  value="<?=$busca_proveedor[5];?>" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33"><div align="right"></div></td>
    <td><div align="left">
      
    </div></td>
    <td><div align="right">Estado:</div></td>
    <td><div align="left">
      <select name="fp" id="fp">
		<option value="0">Estado</option>
		<option value="1"  <? if($busca_proveedor[6]==1) echo "selected";  ?> >Activo</option>
		<option value="2" <? if($busca_proveedor[6]==2) echo "selected";  ?> >Eliminado</option>
                  </select>
</div></td>
  </tr>
  <tr>
    <td height="35"><div align="right">Cambiar contrase&ntilde;a:</div></td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">      </label>
    </div>
      <div align="center"></div></td>
    <td><div align="right">Repetir nueva contrase&ntilde;a:</div></td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" align="right">Fecha de Vigencia:</td>
    <td height="32"><input type="text" name="fecha_vigencia" id="fecha_vigencia" onMouseDown="calendario_sin_hora('fecha_vigencia')" value="<?=$busca_proveedor[14];?>"/></td>
    <td height="32">&nbsp;</td>
    <td height="32" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td height="32" colspan="2">
      <div align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Modificar Usuario" onClick="modifica_usuario()">
        <input name="button2" type="button" class="boton_volver" id="button2" value="Cancelar modificaci&oacute;n" onClick="volver_listado('contenido_aux','contenido_aux_sub')">      </div>
    </td>
    <td height="32">&nbsp;</td>
    <td height="32" align="right"><input name="button3" type="button" class="boton_eliminar" id="button3" value="Eliminar Usuario" onClick="elimina_usuario()"></td>
  </tr>
</table>


<br />
<?
$explo_email = explode("@", $busca_proveedor[4]);
?>
<input type="text" name="email_valida_empleado" id="email_valida_empleado" value="<?=$explo_email[1];?>" /> 
<input type="hidden" name="pv_id" value="<?=$pv_id;?>" /> 
<input type="hidden" name="id_usuario" id="id_usuario" value="<?=$pv_id;?>" /> 
<input type="hidden" name="id_area" id="id_area" value="" /> 
<input type="hidden" name="usuario_pasa" value="<?=$busca_proveedor[2];?>  " />  

<ul id="tabmenu"> 
<li onClick="makeactive(1);ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$pv_id;?>','contenidos');"><a class="active" id="tab1">Areas usuarias</a></li> 
<li onClick="makeactive(2);ajax_carga('../aplicaciones/administracion/roles_permisos.php?pv_id=<?=$pv_id;?>','content')"><a class="fondo_1" id="tab2">Roles y permisos</a></li> 
<li onClick="makeactive(3);ajax_carga('../aplicaciones/administracion/emuladores.php?pv_id=<?=$pv_id;?>','content')"><a class="fondo_1" id="tab3">Emuladores</a></li>
<li onClick="makeactive(4);ajax_carga('../aplicaciones/administracion/reasignar_usuarios.php?pv_id=<?=$pv_id;?>','content')"><a class="fondo_1" id="tab4">Reasignar Usuarios</a></li> 
<li onClick="makeactive(5);ajax_carga('../aplicaciones/administracion/reasignar_usuarios_gestor_abastecimiento.php?pv_id=<?=$pv_id;?>','content')"><a class="fondo_1" id="tab5">Areas Gestor Abastecimiento</a></li> 
</ul> 
<div id="content">



<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
	<tr>
    	<td class="titulos_secciones">Asignar Areas Usuarias</td>
    </tr>
    <tr>
    	<td>Area</td>
        <td>Profesional C&C </td>
        <td>Comprador Corporativo</td>
        <td>Comprador Proyectos</td>
        <td>Comprador Stock</td>
    </tr>
    <tr>
        <td>
        <select name="t1_area" id="t1_area">
        <option value="0"></option>
        <?php $sel_area = query_db("select t1_area_id, nombre from $g12 where estado = 1 order by nombre asc");
		while($rowArea =traer_fila_db($sel_area)){?>
		<option value="<?=$rowArea['t1_area_id']?>"><?=$rowArea['nombre']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <?php 
		$query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (13,17)";// Rol comprador
		$sel_comp = query_db($query);
		$corporativo = query_db($query);
		$proyectos = query_db($query);
		$stock = query_db($query);
		?>
        <select name="profesional" id="profesional">
        <option value="0">Seleccione</option>
		<?php while($rowComp = traer_fila_db($sel_comp)){?>
        <option value="<?=$rowComp['us_id']?>"><?=$rowComp['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <select name="corporativo" id="corporativo">
        <option value="0">Seleccione</option>
		<?php while($rowCorporativo = traer_fila_db($corporativo)){?>
        <option value="<?=$rowCorporativo['us_id']?>"><?=$rowCorporativo['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <select name="proyectos" id="proyectos">
        <option value="0">Seleccione</option>
		<?php while($rowProyectos = traer_fila_db($proyectos)){?>
        <option value="<?=$rowProyectos['us_id']?>"><?=$rowProyectos['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <select name="stock" id="stock">
        <option value="0">Seleccione</option>
		<?php while($rowStock = traer_fila_db($stock)){?>
        <option value="<?=$rowStock['us_id']?>"><?=$rowStock['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
    </tr>
    <tr>
      <td align="left">Nueva Area:<br> <input type="text" name="area_nueva" value=""></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>Jefatura</td>
        <td>Gerente de Area</td>
        <td>Servicios Menores</td>
        <td>Vicepresidente</td>
        <td>Director</td>
    </tr>
    <tr>
    	<td>      
        <?php $query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (23)";
		$jefeArea = query_db($query);?>
        <select name="jefatura" id="jefatura">
        <option value="0">Seleccione</option>
		<?php while($rowjefeArea = traer_fila_db($jefeArea)){?>
        <option value="<?=$rowjefeArea['us_id']?>"><?=$rowjefeArea['nombre_administrador']?></option>
		<?php }?>
		</select>
      </td>
        <td>
        <?php $query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (10)";
		$jefeArea = query_db($query);?>
        <select name="jefeArea" id="jefeArea">
        <option value="0">Seleccione</option>
		<?php while($rowjefeArea = traer_fila_db($jefeArea)){?>
        <option value="<?=$rowjefeArea['us_id']?>"><?=$rowjefeArea['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <?php $query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (13, 17)";
		$corporativo = query_db($query);?>
        <select name="servi_menor" id="servi_menor">
          <option value="0">Seleccione</option>
          <?php while($rowCorporativo = traer_fila_db($corporativo)){?>
          <option value="<?=$rowCorporativo['us_id']?>">
            <?=$rowCorporativo['nombre_administrador']?>
          </option>
          <?php }?>
        </select></td>
        <td>
        <?php 
		$query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (22)";
		$vicepres = query_db($query);?>
        <select name="vicepres" id="vicepres">
        <option value="0">Seleccione</option>
		<?php while($rowVicepres = traer_fila_db($vicepres)){?>
        <option value="<?=$rowVicepres['us_id']?>"><?=$rowVicepres['nombre_administrador']?></option>
		<?php }?>
		</select>
        </td>
        <td>
        <?php 
		$query = "select us_id, nombre_administrador from v_relacion_roles_usuarios where id_rol in (28)";
		$vicepres = query_db($query);?>
        <select name="director" id="director">
        	 <option value="0">Seleccione</option>
		<?php while($rowVicepres = traer_fila_db($vicepres)){?>
        <option value="<?=$rowVicepres['us_id']?>"><?=$rowVicepres['nombre_administrador']?></option>
		<?php }?>
        </select>
        </td>
    </tr>
    <tr>
    	<td colspan="5" align="right">
        	<input name="button" type="button" class="boton_grabar" id="button" value="Agregar" onClick="agrega_usuario_area()">
        </td>
    </tr>
    <tr>
    	<td colspan="5">
        	<table class="table_id display cell-border dataTable">
                <thead>     
                     <tr class="fondo_1">
                     	<td>&nbsp;</td>
                        <td>Area</td>
                        <td>Profesional C&C </td>
                        <td>Comprador Corporativo</td>
                        <td>Comprador Proyectos</td>
                        <td>Comprador Stock</td>
                        <td>Servicios Menores</td>
                        <td>Jefatura</td>
                        <td>Gerente de  Area</td>
                        <td>Vicepresidente</td>
                        <td>Director</td>
                    </tr>
                </thead>
                <tbody>
                <?php $sel_usuarios = query_db("select * from reporte_usuarios where  us_id = $pv_id  order by area");
				while($sel_usu = traer_fila_db($sel_usuarios)){?>
    				<tr>
                    	<td><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" title="Eliminar" onClick="elimina_usuario_area(<?= $pv_id?>,<?= $sel_usu['id_area']?>)"></td>
                    	<td><?= $sel_usu['area']?></td>
                        <td><?= $sel_usu['PROFESIONAL']?></td>
                        <td><?= $sel_usu['COMPRA_CORP']?></td>
                        <td><?= $sel_usu['COMPRA_PROYEC']?></td>
                        <td><?= $sel_usu['COMPRA_STOK']?></td>
                        <td><?= $sel_usu['profesional_serv_menor']?></td>
                        <td><?= $sel_usu['SUPER_INTENDENTE']?></td>
                        <td><?= $sel_usu['JEFE_AREA']?></td>
                        <td><?= $sel_usu['VICEPRESIDENT']?></td>
                        <td><?= $sel_usu['DIRECTOR']?></td>
                    </tr>
    			<?php }?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</div>

<!--
<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados" >
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
                    	<td><?= $rowPerm['nombre']?></td>
                        <td><input type="checkbox" name="perm_usuario[]" id="perm_usuario[]" value="<?= $rowPerm['id_premiso']?>" <?=$che;?>/></td>
                    <?php if($col == 3){?>
                    </tr>
                <?php 
					}
					$col++;
					if($col == 4) $col=1;
				}?>
                </tbody>
			</table>
        
        <td>
    </tr>
    </table>-->



</body>
</html>
