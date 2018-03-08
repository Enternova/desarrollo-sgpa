<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");
	$id_vari=$id_invitacion;
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	$termino = elimina_comillas($termino);
	
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	
	
  if($termino>=1){
  	$complemento = " and rel9_aspecto = $termino";
	$cajon1='<tr><td align="right"></td><td colspan="3"><input type="hidden" name="termino_pasa" value="'.$termino.'"></td></tr>';
	}
	else
	{
	$cajon2='<input type="text" name="termino_pasa" >';
	
	
	}


if($termino==2){ $titulo_evaluacion = "TECNICAS";}
if($termino==1){ $titulo_evaluacion = "ECONOMICAS";}

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >

<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
      
      <td  class="titulos_procesos">TABLA DE TERMINOS Y CONDICIONES <?=$titulo_evaluacion;?></td>
  </tr>
  <tr>
  <td>
  <fieldset style="width:99%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="98%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="26"><strong>Consecutivo del proceso:</strong></td>
    <td width="26%"><div align="left"><?=$sql_e[22];?></div></td>
    <td width="22%"><strong>Tipo de proceso:</strong></td>
    <td width="22%"><div align="left"><?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div>    </td>
  </tr>
  <tr>
    <td height="26"><strong>Detalle y cantidad del objeto a contratar:</strong></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      </textarea>
    </div></td>
  </tr>
</table>
<br>
</fieldset>
  </td>
  </tr>
</table>  
<br>


<br>  

  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr class="administrador_tabla_titulo">
      <td width="38%"><strong>Nueva categor&iacute;a de criterios de evaluaci&oacute;n:</strong></td>
      <td width="48%"><strong>
        <input name="valorgrupo" type="text" value="<?=$linvi[2];?>" size="50">
      </strong></td> 
      <td width="14%"><span class="titulosec">
        <input name="Submit5" type="button" class="guardar" onClick="configura_grupo_evaluacion()" value="Crear catego&iacute;a">
      </span></td>
    </tr>
</table>  
  
<?
  
  if($termino==2)
  	$complemento.= " and tp6_id = $busca_fechas[8]";
	
	$grupo_terminos = "select distinct rel9_aspecto from $t89 where  rel9_estado=1 $complemento ";
	$terminos=query_db($grupo_terminos);
	while($li_terminos=traer_fila_row($terminos)){
	if($li_terminos[0]==1) $titulo_te = " COMERCIALES ";
		if($li_terminos[0]==2) $titulo_te = " TÉCNICAS ";
			if($li_terminos[0]==3) $titulo_te = " ECONÓMICAS ";

?>
  <br>
  <br>
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
 
    <?
	$lista_licitaciones = "select * from $t89 where  rel9_aspecto = $li_terminos[0] and rel9_estado=1 $complemento";
	$linvi=query_db($lista_licitaciones);
	while($li=traer_fila_row($linvi)){

?>
    
    <tr> 
      <td> 
      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" class="columna_titulo_resultados">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td><strong>Categoria: </strong></td>
                    <td colspan="3"><strong>
                      <?=$li[2];?>
                    </strong></td>
                  </tr>
                  <tr>
                    <td width="9%"><div align="left"></div></td>
                    <td width="45%">Crear criterio en esta categor&iacute;a:</td>
                  <td width="31%"><strong>
              <input name="nombre_criterio_<?=$li[0];?>" type="text" value="<?=$linvi[2];?>" size="50">
                    </strong></td>
                  <td width="15%"><span class="titulosec">
                <input name="Submit3" type="button" class="guardar" onClick="crea_criterios_evaluacion(<?=$li[0];?>,document.principal.nombre_criterio_<?=$li[0];?>)" value="Crear criterio">
                    </span></td>
                </tr>
                </table>
           </td>
          </tr>
          <tr > 
            <td width="72" class="titulo_tabla_azul_sin_bordes">Seleccionar</td>
            <td width="801"  class="titulo_tabla_azul_sin_bordes"><div align="left">Criterios de evaluaci&oacute;n</div></td>
        </tr>
          <?
  	$suma_apa=0;
	$lista_criterios = "select * from $t90 where rel9_id = $li[0] and rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);
	$num_fila=0;
	while($lcri=traer_fila_row($linvi_cri)){

  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	if($bus_his[0]>=1)
		{
			$sel="checked";
			$valor = $bus_his[3];
		}
	else
		{
			$sel="";
			$valor = "";
		}
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
?>
          <tr class="<?=$class;?>"> 
            <td> <div align="center"><input name="criterio[]" type="checkbox" class="re_eco" value="<?=$lcri[0];?>" <?=$sel;?>>
            </div></td>
            <td> <div align="left"><strong>
              <?=$lcri[2];?>
            </strong></div></td>
          </tr>
          <? $num_fila++;} ?>
      </table></td>
    </tr>
    <? } ?>
  </table>
  
   <? } ?>
<br>


<br>
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25"><div align="right"></div></td>
    <td width="48%"><label></label></td>
    <td width="15%"><input name="Submit" type="button" class="guardar" value="Guardar terminos y condiciones econ&oacute;micas" onClick="configura_criterios_evalua_sencilla_juridico()"></td>
    <td width="9%"><input name="Submit2" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion;?>','contenidos')"></td>
  </tr>
  <?=$cajon1;?>
</table>
<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_vari" value="<?=$id_vari;?>">

<input type="hidden" name="id_proceso" value="<?=$id_invitacion;?>" />
<input type="hidden" name="id_elimina"/>



</body>
</html>
