<? include("../librerias/lib/@session.php");

	//verifica_menu("procesos.html");
	$id_vari=$id_invitacion;
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	$termino = elimina_comillas($termino);
	

	
	
  if($termino>=1){
  	$complemento = " and rel9_aspecto = $termino";
	$cajon1='<tr><td align="right"></td><td colspan="3"><input type="hidden" name="termino_pasa" value="'.$termino.'"></td></tr>';
	}
	else
	{
	$cajon2='<input type="text" name="termino_pasa" >';
	
	
	}


$busca_fechas = traer_fila_row(query_db("select peso_tecnico ,minimo_tecnico_solicitado ,apertura_juridica ,cierre_juridica ,apertura_tecnica ,cierre_tecnica, fecha_apertura, fecha_cierre, tp6_id from $t5
where pro1_id = $id_invitacion"));

if($busca_fechas[4]=="0000-00-00 00:00:00")
	$fecha_apertura_tecnica = $busca_fechas[6];
else
	$fecha_apertura_tecnica = $busca_fechas[4];

if($busca_fechas[5]=="0000-00-00 00:00:00")
	$fecha_cierre_tecnica = $busca_fechas[7];
else
	$fecha_cierre_tecnica = $busca_fechas[5];


if($busca_fechas[2]=="0000-00-00 00:00:00")
	$fecha_apertura_juridica = $busca_fechas[6];
else
	$fecha_apertura_juridica = $busca_fechas[2];

if($busca_fechas[3]=="0000-00-00 00:00:00")
	$fecha_cierre_juridica = $busca_fechas[7];
else
	$fecha_cierre_juridica = $busca_fechas[3];

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../librerias/js/procesos.js"></script>
<script language="JavaScript" type="text/javascript" src="../librerias/js/popup.js"></script>

<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>

<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />

<script type="text/javascript">

	
			$(function(){
				$('#a_t').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
				
					$('#c_t').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
				
			$('#a_j').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
				
					$('#c_j').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});				

				
			});


		</script>

</head>
<body >
 <form name="formulario" method="post" action="" enctype="multipart/form-data" >

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
      
      <td  class="titulos_procesos">TABLA DE TERMINOS Y CONDICIONES</td>
    </tr>
  </table>  
  
<?


if($termino==2){
?>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr >
    <td width="21%">Fecha apertura:</td>
    <td width="16%"><div align="left">
      <input type="text" name="a_t" id="a_t" value="<?=$fecha_apertura_tecnica;?>" />
    </div></td>
    <td width="19%" align="left" ><div align="right">Fecha cierre:</div></td>
    <td width="18%"  align="left"><div align="left">
      <input type="text" name="c_t" id="c_t" value="<?=$fecha_cierre_tecnica;?>" />
    </div></td>
    </tr>
  <tr >
    <td>% de la evaluaci&oacute;n t&eacute;cnica</td>
    <td><div align="left">
      <input type="text" name="p_t" id="p_t" value="<?=$busca_fechas[0];?>" />
    </div></td>
    <td align="left" >Puntos minimos aceptados:</td>
    <td  align="left"><div align="left">
      <input type="text" name="m_t" id="m_t" value="<?=$busca_fechas[1];?>" />
    </div></td>
  </tr>
  <tr >
    <td colspan="4"><div align="center"></div></td>
  </tr>
</table>
<p>
  <? }

if($termino==1){?>
  <br>
  <br>
</p>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr >
    <td width="21%">Fecha apertura:</td>
    <td width="17%"><div align="left">
      <input type="text" name="a_j" id="a_j" value="<?=$fecha_apertura_juridica;?>" />
    </div></td>
    <td width="12%" align="left" ><div align="right">Fecha cierre:</div></td>
    <td width="16%"  align="left"><div align="left">
      <input type="text" name="c_j" id="c_j" value="<?=$fecha_cierre_juridica;?>"/>
    </div></td>
    </tr>
</table>
<? } ?>

  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr class="administrador_tabla_titulo"> 
      <td>GRUPO DE SECCIONES <span class="titulosec">
        <input name="Submit5" type="button" class="guardar" onClick="popup01('configuracion_criterioscg_0_<?=$id_vari;?>_<?=$termino;?>.php', 400, 780, 100, 100, 1, 1)" value="Crear Secciones">
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
  <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
 
    <?
	$lista_licitaciones = "select * from $t89 where  rel9_aspecto = $li_terminos[0] and rel9_estado=1 $complemento";
	$linvi=query_db($lista_licitaciones);
	while($li=traer_fila_row($linvi)){

?>
    <tr> 
      <td align="left"><div align="left" class="tabla_sin_borde_fondo_gris"></div>
        
      <div align="left"></div></td>
    </tr>
    <tr> 
      <td> 
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
          <tr class="administrador_tabla_titulo">
            <td colspan="3" class="tabla_sin_borde_fondo_gris"><div align="left"><strong>
            <img src="../imagenes/botones/nuevo_1.png" style="cursor:pointer" onClick="popup01('configuracion_criterioscsug_<?=$li[0];?>_<?=$id_vari;?>_<?=$termino;?>.php', 400, 780, 100, 100, 1, 1)"  title="Crear condiciones">
              <?=$li[2];?>
            </strong></div></td>
          </tr>
          <tr class="administrador_tabla_titulo"> 
            <td width="17%" class="titulo_tabla_azul_sin_bordes">Seleccionar Criterio</td>
            <td width="67%" class="titulo_tabla_azul_sin_bordes">CONDICIONES</td>
            <td width="16%" class="titulo_tabla_azul_sin_bordes">PESO</td>
          </tr>
          <?
  	$suma_apa=0;
	$lista_criterios = "select * from $t90 where rel9_id = $li[0] and rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);
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

?>
          <tr> 
            <td> <div align="center"><strong> 
              <input type="checkbox" name="criterio[]" value="<?=$lcri[0];?>" <?=$sel;?>>
            </strong> </div></td>
            <td> <strong><?=$lcri[2];?>
              </strong></td>
            <td><div align="center"> 
                <input type="text" name="valorcriteri_<?=$lcri[0];?>" value="<?=$valor;?>"  onKeyPress='return acceptNum(event)'>
              </div></td>
          </tr>
          <? } ?>
      </table></td>
    </tr>
    <? } ?>
  </table>
  
   <? } ?>
<br>


<br>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25"><div align="right"></div></td>
    <td width="48%"><label></label></td>
    <td width="15%"><input name="Submit" type="button" class="guardar" value="Anexar Tabla al Proceso" onClick="configura_criterios_evalua_sencilla()"></td>
    <td width="9%"><input name="Submit2" type="button" class="cancelar" value="Cerrar Ventana" onClick="window.close()"></td>
  </tr>
  <?=$cajon1;?>
</table>
<input type="hidden" name="termino" value="<?=$termino;?>">

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="accion">

</form>
<iframe name="grp" height="0" width="0"></iframe>

</body>
</html>
