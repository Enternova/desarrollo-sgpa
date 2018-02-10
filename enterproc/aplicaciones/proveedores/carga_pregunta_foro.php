<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	?>
	
                    <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                      <tr>
                        <td colspan="4" class="titulos_evaluacion">Historico de respuestas / nuevas preguntas</td>
                      </tr>
                      <tr>
                        <td width="7%" class="titulo_tabla_azul_sin_bordes">Enviado</td>
                        <td width="14%" class="titulo_tabla_azul_sin_bordes">Fecha</td>
                        <td width="52%" class="titulo_tabla_azul_sin_bordes">Detalle</td>
                        <td width="27%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                      </tr>
<?
			  	$sele_car_foro="select * from $t16 where pro7_id = $id_pr_pasa $complemento_foro order by fecha_foro  desc";
				$sql_ex_c_foro=query_db($sele_car_foro);
				while($ls_c_f=traer_fila_row($sql_ex_c_foro)){
				
												

				if($ls_c_f[2]==1) $imagen = "pregunta_f.png";
				else  $imagen = "respuesta_f.png";
				
		if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

  ?>
			         <tr class="<?=$class;?>">                      
                        <td><img src="../imagenes/botones/<?=$imagen;?>" width="24" height="24"></td>
                        <td><?=fecha_for_hora($ls_c_f[5]);?></td>
                        <td><?=$ls_c_f[6];?></td>
                        <td><?=$ls_c_f[8];?></td>
                      </tr>
                    <? $num_fila++;} ?>
                    </table>