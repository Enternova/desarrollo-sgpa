<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> CREACION DE TARIFAS MASIVAS &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="13%" ><span class="titulos_secciones"><input type="button" name="button2" class="boton_volver"  id="button2" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></span></td>
  </tr>
  <tr>
    <td width="25%" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Proveedor:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[6];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Objeto del contrato:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[9];?>
    </span></td>
  </tr>
</table>
<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" valign="top" class="fondo_2_sub">Seleccione una lista de este contrato</td>
  </tr>

  <tr>
    <td  valign="top">&nbsp;</td>
    <td colspan="2" valign="top" >&nbsp;</td>
  </tr>
  <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/c_tarifas_masivas.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=' + this.value,'carga_acciones_permitidas')">
          <?=listas($t12, " tarifas_contrato_id = $id_contrato_arr",$lista_existentes,'nombre', 2);?>
          </select>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div align="right"></div></td>
    <td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="93%" valign="top"><div align="justify"><strong>Seleccione la lista a la que desea configurar descriptores o modificar las propiedades de la misma.</strong></div></td>
  </tr>  
</table>

<br />
<?




if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><strong>Usted ha seleccionado la lista:<?=$buscar_lista[2];?></strong></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2_sub"><strong >Crear tarifas masivas </strong></td>
        </tr>
        <tr>
          <td width="4%" valign="top"><br />
            <img src="../imagenes/botones/crague_masivo.gif" alt="Cargue masivo desde excel" width="32" height="32" longdesc="Cargue masivo desde excel" /></td>
            <td width="46%"><p>Cargue al sistema las tarifas de esta lista masivamente desde archivo excel siguiendo estos pasos:</p>
                <ul>
                  <li><a href="javascript:void(0);" onclick="window.parent.location.href='../aplicaciones/tarifas/expotar_plantilla_tarifas.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=<?=$lista_existentes;?>'">Descargue aqu&iacute; la plantilla</a></li>
                  <li>No elimine o a&ntilde;ada mas columnas de la plantilla</li>
                  <li>Guarde la plantilla diligenciada en formato excel 97.</li>
                  <li>Busque la plantilla diligenciada y guardada<input type="file" name="carga_tarifas" id="carga_tarifas" /></li>
                  <li>
                  <?
                  
				  $sel_id_contrato_modulo = traer_fila_row(query_db("select t1.fecha_inicio from t7_contratos_contrato as t1, t6_tarifas_contratos as t2 where t1.id = t2.id_contrato and t2.tarifas_contrato_id =".$id_contrato_arr));

				  if($sel_id_contrato_modulo[0]!="" and $sel_id_contrato_modulo[0]!=" "){
				  ?>
                  <input type="button" name="button" class="boton_grabar" id="button" value="Presione este comando para cargar la plantilla" onclick="carga_tarifas_masivas()" />
                  <?
				  }else{
					  echo "<strong class='letra-descuentos'>Para poder cargar las tarifas, primero el gestor de abastecimiento debe ingresar la fecha de inicio del contrato en el m&oacute;dulo de contratos.</strong>";
					  }
				  ?>
                  </li>
                </ul></td>
            <td width="8%" valign="top">&nbsp;</td>
            <td width="42%" valign="top">&nbsp;</td>
        </tr>
      </table>
      <br />
     
 <? } //si ya selecciono una lista ?>
  <input type="hidden" name="id_tarifa" />
  <input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
</body>
</html>
