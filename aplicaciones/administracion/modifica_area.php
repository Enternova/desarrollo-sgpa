<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("administracion.html");

	$busca_proveedor = traer_fila_row(query_db("select * from t1_area where us_id = ".$pv_id));

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
    <td class="titulos_secciones">ADMINISTRACION DE AREAS</td>
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
    <td width="20%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td height="35">&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right">Tel&eacute;fono:</div></td>
    <td><div align="left">
      <input name="dp" type="text" id="dp"  value="<?=$busca_proveedor[5];?>" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33">&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right">Estado:</div></td>
    <td><div align="left">
      <select name="fp" id="fp">
		<option value="0">Estado</option>
		<option value="1"  <? if($busca_proveedor[2]==1) echo "selected";  ?> >Activo</option>
		<option value="2" <? if($busca_proveedor[1]==2) echo "selected";  ?> >Eliminado</option>
        </select>
</div></td>
  </tr>
  <tr>
    <td height="35">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="32" align="right">&nbsp;</td>
    <td height="32">&nbsp;</td>
    <td height="32">&nbsp;</td>
    <td height="32" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td height="32" colspan="2">
      <div align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Modificar Area" onClick="modifica_usuario()">
        <input name="button2" type="button" class="boton_volver" id="button2" value="Cancelar modificaci&oacute;n" onClick="volver_listado('contenido_aux','contenido_aux_sub')">      
      </div>
    </td>
    <td height="32">&nbsp;</td>
    <td height="32" align="right"><input name="button3" type="button" class="boton_eliminar" id="button3" value="Inactivar Area" onClick="alert('Esta Seguro de eliminar el usuario')"></td>
  </tr>
</table>
<div id="content"></div>

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
