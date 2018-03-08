<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	//header('Content-Type: text/xml; charset=ISO-8859-1');
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	*/
	$id_comite = elimina_comillas(arreglo_recibe_variables($_GET["id_comite"]));
	
	
	$sele_comite = traer_fila_row(query_db("select * from $c1 where id_comite = ".$id_comite.""));
	
	$edicion_datos_generales = "NO";
	
	
	
	
	

	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top"><?=encabezado_comite($id_comite)?>
    
    </td>
  </tr>
  <tr>
    <td valign="top">
      
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td colspan="2" align="center"  class="fondo_3">Agregar Asistentes</td>
        </tr>
        
        <tr >
          <td width="50%" align="right"> Asistente:</td>
          <td width="50%" align="left"><input type="text" name="usuario_permiso" id="usuario_permiso" onKeyUp="selecciona_lista()" /></td>
        </tr>
        <tr >
          <td align="right">Requerir Aprobaci&oacute;n:</td>
          <td align="left">
            <select name="requiere_aprobacion" id="requiere_aprobacion" onChange="valida_si_es_aprobador(this.value)">
              
              
              
              <option value="2">NO</option>
              <option value="99">NO - es el Secretario del Comite</option>
              <?
	 $asistentes_cuantos = traer_fila_row(query_db("SELECT count(*) FROM  $c3 where id_comite = ".$id_comite." and requiere_aprobacion = 1"));
		
		if(($sele_comite[11] == "presencial" and $asistentes_cuantos[0] == 0) or ($sele_comite[11] == "virtual")){    
	?>
              <option value="1">SI</option>
              <?
  }
  ?>
            </select>
            
          </td>
        </tr>
        <tr style="display:none" id="oculta_requiere">
          <td align="right">Rol en el comit&eacute;:</td>
          <td align="left">

<select name="rol_comite" id="rol_comite">
            <option value="Presidente">Presidente</option>
            <option value="Visi&oacute;n Legal">Visi&oacute;n Legal</option>
            <option value="Visi&oacute;n T&eacute;cnica">Visi&oacute;n T&eacute;cnica</option>
            <option value="Visi&oacute;n Estrat&eacute;gica">Visi&oacute;n Estrat&eacute;gica</option>
			<option value="Visi&oacute;n Financiera">Visi&oacute;n Financiera</option>
            </select>


  </td>
        </tr>
        <tr  style="display:none" id="orden_aprobacion">
          <td align="right">&nbsp;</td>
          <td align="left">
            
            <input type="hidden" name="orden_aprueba" id="orden_aprueba" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="1"/>
            
          </td>
        </tr>
        <tr >
          <td colspan="2" align="center"><input type="button" name="button" id="button" value="Agregar Asistente" class="boton_grabar" onClick="agrega_asistente()" /></td>
        </tr>
        
      </table>
      
  <br />
      
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td colspan="4" align="center"  class="fondo_3">Lista de Asistentes</td>
        </tr>
        <tr >
          <td width="13%" align="center" class="fondo_3">Asistente</td>
          <td width="15%" align="center" class="fondo_3">Requiere Aprobaci&oacute;n</td>
          <td width="14%" align="center" class="fondo_3">Rol del Comit&eacute;</td>
          <td width="10%" align="center" class="fondo_3">Eliminar</td>
        </tr>
        <?
      $asistentes = query_db("SELECT dbo.t3_comite_asistentes.id_asistente, dbo.t3_comite_asistentes.id_us, dbo.t3_comite_asistentes.id_comite, 
               dbo.t1_us_usuarios.nombre_administrador, dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.rol_aprobacion, 
               dbo.t3_comite_asistentes.orden, dbo.t3_comite_asistentes.estado
FROM  dbo.t1_us_usuarios INNER JOIN
               dbo.t3_comite_asistentes ON dbo.t1_us_usuarios.us_id = dbo.t3_comite_asistentes.id_us
WHERE (dbo.t3_comite_asistentes.estado = 1) and dbo.t3_comite_asistentes.id_comite =".$id_comite."
ORDER BY dbo.t3_comite_asistentes.requiere_aprobacion, dbo.t3_comite_asistentes.id_asistente");
while($se_asiste = traer_fila_db($asistentes)){
		
	
	  ?>
        <tr >
          <td align="center">	<?=$se_asiste[3]?></td>
          <td align="center"><? if($se_asiste[4] == 1) echo "SI"; else echo "NO"?></td>
          <td align="center"><?=$se_asiste[5]?></td>
          <td align="center"><?
        if($se_asiste[4] == 1){
		?><input type="hidden" name="orden_ordena" id="orden_ordena" value="<?=$se_asiste[6]?>" max="3" onChange="cambia_orden_asistente(<?=$se_asiste[0]?>,this.value)"/>
            <?
		}
		?><img src="../imagenes/botones/eliminada_temporal.gif"  onclick="funquita_asistente(<?=$se_asiste[0]?>)" /></td>
        </tr>
        <?
}
		?>
    </table></td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas">
    
    <table width="100%" border="0">
      <tr>
        
       
        
      </tr>
    </table></td>
  </tr>
</table>
<input type="hidden" name="id_comite" id="id_comite" value="<?=$id_comite?>" />
<input type="hidden" name="id_comite_agrega" id="id_comite_agrega"/>
<input type="hidden" name="id_item_agrega" id="id_item_agrega" />
<input type="hidden" name="orden_cambia" id="orden_cambia" />
<input type="hidden" name="id_relacion" id="id_relacion" />
<input type="hidden" name="quita_asistente" id="quita_asistente" />


</body>
</html>
