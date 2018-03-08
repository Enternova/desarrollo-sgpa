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

  <table width="94%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr class="administrador_tabla_titulo">
      <td width="42%"><strong>Nueva categor&iacute;a de criterios de evaluaci&oacute;n: </strong></td>
      <td width="43%"><strong>
        <input name="valorgrupo" type="text" value="<?=$linvi[2];?>" size="50">
      </strong></td> 
      <td width="15%"><span class="titulosec">
        <input name="Submit5" type="button" class="guardar" onClick="configura_grupo_evaluacion()" value="Crear catego&iacute;a">
      </span></td>
    </tr>
</table>  
  
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
  <br>
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" >
 
    <?
		if($tipo==1)//si tiene valores
		 $lista_licitaciones = "select distinct rel9_id, rel9_detalle from $v3 where  rel9_aspecto = 2 and rel9_estado=1 and rel9_id = $li_terminos[0] $complemento order by porcentaje desc";
		if($tipo==2)//si tiene valores
		 $lista_licitaciones = "select * from $v3 where  ( proc1_id  <> $id_invitacion or  proc1_id is NULL) and rel9_aspecto = 2 and rel9_estado=1 and rel9_id = $li_terminos[0]  $complemento  order by rel9_detalle";	
	

	
	$linvi=query_db($lista_licitaciones);
	$num_fila=0;
	while($li=traer_fila_row($linvi)){//imprime categorias
	$valor_categorias=0;
	
  	$bus_his_categorias = traer_fila_row(query_db("select *  from $t12 where proc1_id = $id_invitacion and  rel9_id =$li[0]"));
	$valor_categorias = $bus_his_categorias[3];
	$suma_apa_categorias+=$valor_categorias;

	if($valor_categorias[0]!=""){
		$oculta="";
		$nobre_img="oculta_".$li[0];
		$src_im="cierra.png";
		}
	else{
		$oculta="none";
		$nobre_img="muestra_".$li[0];
		$src_im="abre.png";
		
		}
	
?>
    
    <tr> 
      <td> 
       <p>&nbsp;</p>
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr >
            <td colspan="2" class="columna_titulo_resultados">

              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="60%" ><div align="left"><img src="../imagenes/botones/<?=$src_im;?>" name="<?=$nobre_img;?>" onClick="muetra_criterios('cate_<?=$li[0];?>',this,<?=$li[0];?>)"><strong>Categoria:<?=$li[1];?></strong></div></td>
                    <td width="32%"  align="left"><strong>%  de evaluaci&oacute;n de la categoria:</strong></td>
                    <td width="8%"  align="left"><input name="valor_catego[<?=$li[0];?>]" type="text" class="re_eco"  onFocus="document.principal.valor_actual.value = this.value" onChange="suma_valores_tecnicos(this,document.principal.suma_evluacion_total)" value="<?=$valor_categorias;?>">                    </td>
                    <td width="1%"  align="left">&nbsp;</td>
                </tr>
                </table>  
                
            </td>
          </tr>
          
          <tr>
          	<td colspan="2" id="cate_<?=$li[0];?>" style="display:<?=$oculta;?>" >
          
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco" >
       <tr>
                    <td width="49%" align="right" class="tabla_sin_borde_fondo_gris"><div align="left" class="tabla_sin_borde_fondo_gris">
                      <div align="right">Crear criterio en esta categor&iacute;a: </div>
                    </div></td>
                    <td width="37%" align="right" class="tabla_sin_borde_fondo_gris"><span class="tabla_sin_borde_fondo_gris"><strong>
                      <input name="nombre_criterio_<?=$li[0];?>" type="text" value="<?=$linvi[2];?>">
                    </strong></span></td>
                    <td align="right" class="tabla_sin_borde_fondo_gris"><span class="tabla_sin_borde_fondo_gris">
                      <input name="Submit3" type="button" class="guardar" onClick="crea_criterios_evaluacion(<?=$li[0];?>,document.principal.nombre_criterio_<?=$li[0];?>)" value="Crear criterio">
                    </span></td>
           </tr>
                  
          <tr > 
            <td colspan="2" align="center"  class="titulo_tabla_azul_sin_bordes">&nbsp;Criterios de evaluaci&oacute;n</td>
            <td width="14%"  class="titulo_tabla_azul_sin_bordes"><div align="center">% del criterio</div></td>
        </tr>
          <?
  	$suma_apa=0;
	$valor = "";
	$lista_criterios = "select * from $t90 where rel9_id = $li[0] and rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);


	while($lcri=traer_fila_row($linvi_cri)){

  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	$valor = $bus_his[3];
	$suma_apa+=$valor;
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
?>
          <tr class="<?=$class;?>" style="text-align:left"> 
            <td colspan="2" align="right"> <?=$lcri[2];?>:&nbsp;&nbsp;</td>
            <td>
              <div align="left">
                <input name="valorcriteri_<?=$li[0];?>[<?=$lcri[0];?>]" type="text" onFocus="document.principal.valor_actual.value = this.value" onChange="suma_valores_tecnicos(this,document.principal.suma_criterio_<?=$li[0];?>)" value="<?=$valor;?>" size="3">
              </div></td>
          </tr>
          <? $num_fila++;} ?>
          
          <tr >
            <td colspan="2" class="columna_titulo_resultados">Porcentaje total de los criterios en esta categoria:&nbsp;&nbsp;</td>
            <td class="columna_titulo_resultados" >
              <div align="left">
                <input name="suma_criterio_<?=$li[0];?>" type="text" class="f_fechas" value="<?=$suma_apa;?>" size="3" readonly >
              </div></td>
          </tr>
          </table>
         
          
          </td>
         </tr> 
          
          
          
      </table>
      <? } //imprime categorias ?>
      
 </td>
 </tr>
 </table>
    <? } //imprime tablas
	
	}//final funcion
	
	echo lista_criterios(1);
	//echo lista_criterios(2);
	 ?>
    
   
<br>
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="90%" class="columna_titulo_resultados">Porcentaje total de la evaluaci&oacute;n t&eacute;cnica:</td>
    <td width="10%" class="columna_titulo_resultados"><div align="center">
      <input name="suma_evluacion_total" type="text" class="re_eco" readonly value="<?=$suma_apa_categorias;?>" >
    </div></td>
  </tr>
</table>
 
      
 
  

<br> 

<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr align="center">
    <td height="25"><div align="center">&nbsp;      
        <input name="Submit" type="button" class="guardar" value="Guardar terminos y condiciones t&eacute;cnicas en firme" onClick="configura_criterios_evalua_sencilla_tecnicos()">
      &nbsp;      
      <input name="Submit2" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
  <?=$cajon1;?>
</table>
  

<br>



<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_vari" value="<?=$id_vari;?>">
<input type="hidden" name="valor_actual">

<input type="hidden" name="id_proceso" value="<?=$id_invitacion;?>" />
<input type="hidden" name="id_elimina"/>


</body>
</html>
