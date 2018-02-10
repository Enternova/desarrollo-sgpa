<?  include("../../librerias/lib/@session.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte_General.xls"); 
	header("Content-Transfer-Encoding: binary");


	 $id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	$us_cliente = $_SESSION["id_proveedor"];

 

$busca_campo_subasta = traer_fila_row(query_db("select evaluador3_valor from $t93 where in_id = $id_invitacion and evaluador3_termino=4"));

$campo_mejor_oferta=$busca_campo_subasta[0];

	$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
	$linvi=traer_fila_row(query_db($lista_licitaciones));


$numero_pagi = 5;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);

		  $li_n_c=traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion "));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;



if($oferta<=0)
$oferta=1;
else
$oferta=$oferta;



  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 

	
	$concatena_titulo = ($numero+5);												

	$nombre_lista1="Codigo";
	$nombre_lista2="Detalle";
	$nombre_lista3="Medida";
	$nombre_lista4="Cantidad";
	$nombre_lista5="Moneda";
	$nombre_lista6="Numero de parte";
	$nombre_lista7="Marca";
	$muestra_cantidad=1;

if($id_invitacion==1){

	$nombre_lista1="Tipo Vehiulo";
	$nombre_lista2="Tipo";
	$nombre_lista3="Capacidad en Toneladas";
	$nombre_lista4="Id";
	$nombre_lista6="Altura hasta Metros";
	$muestra_cantidad=2;

}													

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >
<?
$cuenta_numero_parte= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_valor !='' "));
	$cuenta_marca= traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  and evaluador5_presupuesto  !='' "));
	$muestra_campo_par=1;
	$muestra_campo_mar=1;
	$concatena_titulo_suma=0;
	if($cuenta_numero_parte[0]==0){
		$concatena_titulo=($concatena_titulo-1);
		$muestra_campo_par=0;
		$concatena_titulo_suma=1;
		}

	if($cuenta_marca[0]==0){
		$concatena_titulo=($concatena_titulo-1);
		$muestra_campo_mar=0;
		$concatena_titulo_suma+=1;
		}
		?>
   <table  border="1" >
     <tr>
       <td><strong>consecutivo</strong></td>
       <td><strong><?=$nombre_lista1;?></strong></td>
       <td><strong><?=$nombre_lista2;?></strong></td>
       <td><strong><?=$nombre_lista3;?></strong></td>
       <td><strong><?=$nombre_lista4;?></strong></td>
      <? if($muestra_campo_par==1){ ?> <td><strong><?=$nombre_lista6;?></strong></td><? } ?>
      <? if($muestra_campo_mar==1){ ?> <td><strong><?=$nombre_lista7;?></strong></td><? } ?>
       <td><strong><?=$nombre_lista5;?></strong></td>
		<?=$titulo_campos;?>
     </tr>
     <?
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion and pro11_id = $id_lista   ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	
	$campo_formateado=str_replace("id_articulo",$l_campo[0],$campo_campos);
	$valor_proveedor_buscado="";
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//busca_valor puestos por e proveedor
	$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $us_cliente and oferta = $oferta and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0]"));
	if($l_campo_trae[3]=="Numerico")
		$campo_campos.="<td >$busca_valores_ing[0]</td>";
	if($l_campo_trae[3]=="Valor")
		$campo_campos.="<td >$busca_valores_ing[0]</td>";

	if($l_campo_trae[3]=="Texto Corto")
		$campo_campos.="<td>$busca_valores_ing[0]</td>";
	if($l_campo_trae[3]=="Texto Largo")
		$campo_campos.="<td>$busca_valores_ing[0]</td>";

	if($campo_mejor_oferta==$l_campo_trae[0])
		$valor_proveedor_buscado = ($busca_valores_ing[0]*1);
		
		
		
	} //busca_valor puestos por e proveedor




		 
	?>
     <tr>
       <td><?=$l_campo[0];?>.<?=$id_lista;?></td>
       <td><?=$l_campo[2];?></td>
       <td><?=$l_campo[3];?></td>
       <td><?=$l_campo[4];?></td>
       <td><?=$l_campo[5];?></td>
       <? if($muestra_campo_par==1){ ?><td ><?=$l_campo[7];?></td><? } ?>
      <? if($muestra_campo_mar==1){ ?> <td ><?=$l_campo[8];?></td><? } ?>
       <td><?=$l_campo[6];?></td>
		<?=$campo_campos;?>
     </tr>
     <? } ?>
   </table>


</body>
</html>
