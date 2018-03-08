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
    	<td colspan="3" class="titulos_secciones">Emuladores</td>
    </tr>
    <tr>
    	<td style="width:30%">
        	<table class="table_id display cell-border dataTable">
            	<thead>
                	<tr>
                        <td colspan=""><select name="id_us_emula" id="id_us_emula">
								<?=listas($g1, " estado = 1 and tipo_usuario in (1,3)",null ,'nombre_administrador', 1);?>
                            </select>
                        </td>
                        <td>
                        	<input type="hidden" name="id_emula" id="id_emula" value="" /> 
                        	<input name="button" type="button" class="boton_grabar" id="button" value="Agregar" onClick="agrega_usuario_emula()">
                        </td>
                    </tr>
                </thead>
				<thead>
                	<tr class="fondo_1">
                    	<td>Usuario</td>
                        <td>Opciones</td>
                    </tr>
                </thead>
                <tbody>
                <?php $selEmula = "select * from  t2_relacion_usuarios_emulan where id_us = $pv_id";
				$queryEmula = query_db($selEmula);
				while ($rowEmula = traer_fila_db($queryEmula)){
					
				?>
                	<tr>
                    	<td><?= traer_nombre_muestra($rowEmula['id_us_emula'], $g1,"nombre_administrador","us_id");?></td>
                        <td><img src="../imagenes/botones/eliminada_temporal.gif" width="14" height="15" title="Eliminar" onClick="elimina_usuario_emula(<?= $rowEmula['id']?>)"></td>
                    </tr>
                <?php }?>
                </tbody>
			</table>
        </td>
    </tr>
    </table>



</body>
</html>
