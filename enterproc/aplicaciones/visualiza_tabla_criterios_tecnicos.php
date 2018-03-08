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

	$cajon1='<tr><td align="right"></td><td colspan="3"><input type="hidden" name="termino_pasa" value="'.$termino.'"></td></tr>';
	}
	else
	{
	$cajon2='<input type="text" name="termino_pasa" >';
	
	
	}


if($termino==2){ $titulo_evaluacion = "TECNICAS";}
if($termino==1){ $titulo_evaluacion = "JURIDICAS";}

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
    <td width="87%"  class="titulos_procesos">TABLA DE TERMINOS Y CONDICIONES
      TECNICAS
      <br>
      <strong>Consecutivo del proceso:
        <?=$sql_e[22];?>
      </strong></td>
    <td width="13%"><input name="Submit3" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:volver_listado('oculta_todo_proveedores','carga_evaluacion')"></td>
  </tr>
</table>
<br>
<?
  

  	//$complemento.= " and tp6_id = $busca_fechas[8]";
function lista_criterios($tipo){	

global $t89,$complemento,$v3 ,$t12,$id_invitacion,$suma_apa_categorias,$t90,$t91;
	
	if($tipo==1)//si tiene valores
	 $grupo_terminos = "select distinct rel9_id from $v3 where  rel9_estado=1 and rel9_aspecto = 2 ";
	
	if($tipo==2)//si tiene valores
	  $grupo_terminos = "select distinct rel9_id from $v3 where ( proc1_id  <> $id_invitacion or  proc1_id is NULL) and rel9_estado=1 and rel9_aspecto = 2 "; 
	 

	 
	$terminos=query_db($grupo_terminos);
	while($li_terminos=traer_fila_row($terminos)){//imprime tablas
?>
<br>

 
    <?
		if($tipo==1)//si tiene valores
		 $lista_licitaciones = "select distinct rel9_id, rel9_detalle from $v3 where  rel9_aspecto = 2 and rel9_estado=1 and rel9_id = $li_terminos[0] $complemento order by rel9_detalle desc";
		if($tipo==2)//si tiene valores
		 $lista_licitaciones = "select * from $v3 where  ( proc1_id  <> $id_invitacion or  proc1_id is NULL) and rel9_aspecto = 2 and rel9_estado=1 and rel9_id = $li_terminos[0]  $complemento  order by rel9_detalle";	
	


	$linvi=query_db($lista_licitaciones);
	$num_fila=0;
	while($li=traer_fila_row($linvi)){//imprime categorias
	$valor_categorias=0;
	
  	$bus_his_categorias = traer_fila_row(query_db("select *  from $t12 where proc1_id = $id_invitacion and  rel9_id =$li[0]"));
	$valor_categorias = $bus_his_categorias[3];
	$suma_apa_categorias+=$valor_categorias;

	
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" >
          
          
          <tr>
          	<td colspan="2" id="cate_<?=$li[0];?>" >
          
          <table width="99%" border="0" align="center" cellpadding="4" cellspacing="4" class="tabla_lista_resultados" >
       <tr>
         <td colspan="4" align="right" class="columna_titulo_resultados"><div align="left"><strong>Categoria:<?=$li[1];?></strong></div></td>
         </tr>
                  
          <tr > 
            <td colspan="4" align="left" ><div class="fondo_2"><strong >Seleccione los criterios que le solicitara al proveedor</strong></div></td>
            </tr>
          <?
  	$suma_apa=0;
	$valor = "";
	$lista_criterios = "select * from $t90 where rel9_id = $li[0] and rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);


	while($lcri=traer_fila_row($linvi_cri)){

  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	if($bus_his[0]>=1) $sel="<img src='../imagenes/botones/chulo.jpg' >";
	else  $sel = "";

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
?>
          <tr class="<?=$class;?>" style="text-align:left"> 
            <td width="3%" align="right"><?=$sel;?></td>
            <td width="97%" colspan="3" align="right"><div align="left">
              <?=$lcri[2];?></div>
              <div align="left"></div></td>
            </tr>
          <? $num_fila++;} ?>
          </table>          </td>
         </tr> 
</table>
      <? } //imprime categorias ?>

<? } //imprime tablas
	
	}//final funcion
	
	echo lista_criterios(1);
	//echo lista_criterios(2);
	 ?>
    
   
<br>
<br>
<br>



<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_vari" value="<?=$id_vari;?>">
<input type="hidden" name="valor_actual">

<input type="hidden" name="id_proceso" value="<?=$id_invitacion;?>" />



</body>
</html>
