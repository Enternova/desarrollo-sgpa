<? include("../../../lib/@session.php"); 
	
 //error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
$sql_comle="";
$titulo="";
$_POST["area"] = utf8_decode($_POST["area"]);
if($_POST["area"]!=""){
	//echo "entro aqui";

	if($_POST["area"]=="TOTALCONTRATOSSINEXCEPCION"){
		
		$_SESSION["id_area_bus_rep"] = "0";
		$_SESSION["comple_filtro2"] = $_SESSION["comple_filtro"];
		$_SESSION["titulo_sub1_area"] = "<br /><br /><span style='font-size:18pt'>Estad&iacute;stica de Tarifas por &Aacute;rea, Origen y Uso <br /><span style='font-size:14pt'> Total - Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span></span>";
	}else{
		
	$sel_area = traer_fila_row(query_db("select t1_area_id from t1_area where replace(nombre, ' ', '')  like replace('%".$_POST["area"]."%',' ','') and estado=1"));
	$_SESSION["id_area_bus_rep"] = $sel_area[0];
	$_SESSION["comple_filtro2"] = $_SESSION["comple_filtro"]." and t1_area_id = ".$_SESSION["id_area_bus_rep"];
	$_SESSION["titulo_sub1_area"] = "<br /><br /><span style='font-size:18pt'>Estad&iacute;stica de Tarifas por &Aacute;rea, Origen y Uso <br /><span style='font-size:14pt'>".saca_nombre_lista($g12,$_SESSION["id_area_bus_rep"],'nombre_html','t1_area_id')."- Desde ".$_SESSION["fecha_inicial_bus_rep"]." y Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span></span>";
	
	}
	$titulo=$_SESSION["titulo_sub1_area"];
	$sql_comle=$_SESSION["comple_filtro2"];
}
if($_POST["gerente"]!=""){
	$sel_ger = traer_fila_row(query_db("select us_id from t1_us_usuarios where replace(nombre_administrador, ' ', '')  like '%".trim(utf8_decode($_POST["gerente"]))."%' and estado=1"));
	$_SESSION["id_gerente2"] = $sel_ger[0];
	$_SESSION["comple_filtro3"] = $_SESSION["comple_filtro"]." and id_gerente = ".$_SESSION["id_gerente2"];
	$sql_comle=$_SESSION["comple_filtro3"];
	
	$_SESSION["titulo_sub1_gerente"] = "<br /><br /><span style='font-size:18pt'>Estad&iacute;stica de Tarifas por Gerente de Contrato, Origen y Uso <br /><span style='font-size:14pt'>".saca_nombre_lista($g1,$_SESSION["id_gerente2"],'nombre_administrador','us_id')." - Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span></span>";
	$titulo=$_SESSION["titulo_sub1_gerente"];
}

if($_POST["proveedor"]!=""){
	$sel_contra = traer_fila_row(query_db("select t1_proveedor_id from t1_proveedor where replace(razon_social, ' ', '')  like '%".trim(utf8_decode($_POST["proveedor"]))."%' and estado=1"));
	$_SESSION["id_proveedor2"] = $sel_contra[0];
	//echo $_SESSION["id_proveedor2"]-"aqui id contratista";
	$_SESSION["comple_filtro4"] = $_SESSION["comple_filtro"]." and t1_proveedor_id= ".$_SESSION["id_proveedor2"];
	$sql_comle=$_SESSION["comple_filtro4"];
	
	$_SESSION["titulo_sub1_proveedor"] = "Estad&iacute;stica de Tarifas por Proveedor, Origen y Uso <br /><span style='font-size:14pt'>".saca_nombre_lista("t1_proveedor",$_SESSION["id_proveedor2"],'razon_social','t1_proveedor_id',0)." - Desde ".$_SESSION["fecha_inicial_bus_rep"]." y Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span>";
	$titulo=$_SESSION["titulo_sub1_proveedor"];
}
$categorias ="";
$barra1="";
$barra2="";
$total1=0;
$total2=0;


$cart="'XX nombre columna--campo--Tarifas--campo--Tarifas Usadas--campo--Modificadas IPC--campo--Modificadas IPC Usadas--campo--Modificadas Otros--campo--Modificadas Otros Usadas--campo--";//se configuran las categorias o grupos de las graficas


	/*para categoria/grupo contractuales*/

	$sql_barra_1 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tipo_creacion_modifica =1"));
	$sql_barra_2 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tarifa_usada > 0"));

	$sql_barra_3 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tipo_creacion_modifica =4"));
	$sql_barra_4 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tipo_creacion_modifica =4 and tarifa_usada > 0"));

	$sql_barra_5 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tipo_creacion_modifica =2"));
	$sql_barra_6 = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 1 and tipo_creacion_modifica =2 and tarifa_usada > 0"));


	//barras 1, 3, 5 #739DC8
	// Barras 2, 4, 6 #C5C980

	$cart.="Tarifas Contractuales,".$sql_barra_1[0].",".$sql_barra_2[0].",".$sql_barra_3[0].",".$sql_barra_4[0].",".$sql_barra_5[0].",".$sql_barra_6[0].",--,--";
 
	/*FIN para contractuales*/

/*para categoria/grupo Nuevas*/

	$sql_barra_1_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tipo_creacion_modifica =3"));
	$sql_barra_2_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tarifa_usada > 0"));

	$sql_barra_3_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tipo_creacion_modifica =4"));
	$sql_barra_4_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tipo_creacion_modifica =4 and tarifa_usada > 0"));

	$sql_barra_5_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tipo_creacion_modifica =2"));
	$sql_barra_6_n = traer_fila_row(query_db("select COUNT(consecutivo_original) from v_reporte_general_variacion_tarifas ".$sql_comle." and tipo_tarifa_original = 3 and tipo_creacion_modifica =2 and tarifa_usada > 0"));

	$cart.="Tarifas Nuevas,".$sql_barra_1_n[0].",".$sql_barra_2_n[0].",".$sql_barra_3_n[0].",".$sql_barra_4_n[0].",".$sql_barra_5_n[0].",".$sql_barra_6_n[0].",--,--";
	/*FIN para nuevas*/


/* Grafica total de contractuales*/
$total1_con = $sql_barra_1[0]-$sql_barra_2[0];//BARRA 1 TARIFAS
$total2_con = $sql_barra_2[0];//TARIFAS USADAS
/* FIN Grafica total de contractuales*/

/* Grafica total de Nuevas*/
$total1_nue = $sql_barra_1_n[0]-$sql_barra_2_n[0];
$total2_nue = $sql_barra_2_n[0];
/* FIN Grafica total de Nuevas*/

/* Grafica total de total*/
$total1_gen_contra_us = $total2_con;
$total2_gen_nuevas_us = $total2_nue;
$total2_gen_todas = $total1_con + $total1_nue;
/* FIN Grafica total de total*/


/* Total de Modificaciones*/
$total1_modificaciones = $sql_barra_3[0]+0;//Modificaciones Contractuales por IPC #B88563
$total2_modificaciones = $sql_barra_5[0]+0;//Modificaciones Contractuales por Otros Conceptos #B7BB60
$total3_modificaciones = $sql_barra_3_n[0]+0;//Modificaciones de Tarifas Nuevas por IPC #CDA991
$total4_modificaciones = $sql_barra_5_n[0]+0;//Modificaciones de Tarifas Nuevas por Otros Conceptos #CCCF8F
$total5_modificaciones = $sql_barra_1_n[0] - ($sql_barra_3_n[0]+$sql_barra_5_n[0])+0; // total de nuevas
$total6_modificaciones = $sql_barra_1[0] - ($sql_barra_3[0] + $sql_barra_5[0])+0; // total de contractuales
/* FIN Total de Modificaciones*/



/*para Total*/
	//$cart.="NUMERO TOTAL DE TARIFAS,".$total1.",".$total2.",--,--";
	/*FIN para Total*/


	$cart=utf8_decode($titulo."--titulo--".$cart."--grafica--".$total1_con."--campo--".$total2_con."--grafica--".$total1_nue."--campo--".$total2_nue."--grafica--".$total2_gen_todas."--campo--".$total1_gen_contra_us."--campo--".$total2_gen_nuevas_us."--grafica--".$total1_modificaciones."--campo--".$total2_modificaciones."--campo--".$total3_modificaciones."--campo--".$total4_modificaciones."--campo--".$total5_modificaciones."--campo--".$total6_modificaciones);//se utiliza la función utf8_decode() para que salgan bien las tíldes en los textos
	$cart=preg_replace('/\s+/', ' ', $cart);
	$cart=preg_replace('/\n/', ' ', $cart);
	echo $cart;
	?>