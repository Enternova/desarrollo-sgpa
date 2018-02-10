<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");
	$id_vari=$id_invitacion;
	$id_invitacion = (arreglo_recibe_variables($id_vari));
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
if($termino==1){ $titulo_evaluacion = $lenguaje_16;}
if($termino==3){ $titulo_evaluacion = $lenguaje_15;}

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
      
      <td width="87%"  class="titulos_procesos">TABLA DE TERMINOS Y CONDICIONES <?=$titulo_evaluacion;?>
           <br>
      <strong>Consecutivo del proceso:
      <?=$sql_e[22];?>
      </strong></td>
      <td width="13%"><input name="Submit3" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:volver_listado('oculta_todo_proveedores','carga_evaluacion')"></td>
  </tr>
</table>
<br>
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
                    <td width="9%"><strong>Categoria: </strong></td>
                    <td width="60%" colspan="3"><strong>
                      <?=$li[2];?>
                    </strong></td>
                  </tr>
                </table>           </td>
          </tr>
          <tr > 
            <td colspan="2" class="titulo_tabla_azul_sin_bordes"><div align="left"><strong>Seleccione los criterios que le solicitara al proveedor</strong></div></td>
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
			$sel="<img src='../imagenes/botones/chulo.jpg' >";
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
            <td width="72"> <div align="center"><?=$sel;?></div></td>
            <td width="801"> <div align="left"><strong>
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
<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_vari" value="<?=$id_vari;?>">

<input type="hidden" name="id_proceso" value="<?=$id_invitacion;?>" />




</body>
</html>
