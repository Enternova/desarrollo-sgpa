<? include("../../../lib/@session.php"); 
	
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores

$titulo_grafica ="";
$titulo="";
$num_columnas=0;
/* confiuracion de titulos*/
if($_POST["categoria"]=="TarifasContractuales"){
	
	$cart="XX nombre columna--campo--No. Tarifas Contractuales--campo--";//se configuran las categorias o grupos de las graficas
	
	$titulo_grafica =" Tarifas Contractuales";
}

if($_POST["categoria"]=="TarifasNuevas"){
	$cart="XX nombre columna--campo--No. Tarifas Nuevas--campo--";//se configuran las categorias o grupos de las graficas
	$titulo_grafica =" Tarifas Nuevas";
}

if($_POST["categoria"]=="TarifasModificadas"){
	$cart="XX nombre columna--campo--No. Tarifas Modificadas--campo--";//se configuran las categorias o grupos de las graficas
	$titulo_grafica =" Tarifas Modificadas";
}

if($_POST["categoria"]=="NUMEROTOTALDETARIFAS"){
	$num_columnas=3;
	$cart="XX nombre columna--campo--No. Tarifas Contractuales--campo--No. de Tarifas Nuevas--campo--No. de Tarifas Modificadas--campo--";//se configuran las categorias o grupos
	$titulo_grafica =" Tarifas de Todos los Tipos de Cargue al SGPA,";
	if($_POST["usadas"] == 2){
	$titulo_grafica =" Tarifas Usadas de Todos los Tipos de Cargue al SGPA,";
	}
	
}else{
	if($_POST["usadas"] == 2){
	$titulo_grafica =$titulo_grafica." Usadas";
	}
	
	}


/* FIN confiuracion de titulos*/

$complet_sql="";
if($_POST["tp_grafica"]==1){//Area
	$complet_sql = $_SESSION["comple_filtro2"];
	$mombre_admin=saca_nombre_lista($g12,$_SESSION["id_area_bus_rep"],'nombre','t1_area_id');
	$mombre_admin=preg_replace('/,/', '', $mombre_admin);
	
	$_SESSION["titulo_sub2_area"] = "<br /><br />".$titulo_grafica." del Área ".$mombre_admin." por Contrato<br> <span style='font-size:14pt'>Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span><br /><br />";
	$titulo=$_SESSION["titulo_sub2_area"];
}
if($_POST["tp_grafica"]==2){//Gerente
	$complet_sql = $_SESSION["comple_filtro3"];
	$mombre_admin=saca_nombre_lista($g1,$_SESSION["id_gerente2"],'nombre_administrador','us_id');
	$mombre_admin=preg_replace('/,/', '', $mombre_admin);
	
	$_SESSION["titulo_sub2_gerente"] = "<br /><br />".$titulo_grafica." del Gerente de Contrato ".$mombre_admin." por Contrato<br><span style='font-size:14pt'>Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span><br /><br />";
	$titulo=$_SESSION["titulo_sub2_gerente"];
	
}
if($_POST["tp_grafica"]==3){//Proveedor
	$complet_sql = $_SESSION["comple_filtro4"];
	$mombre_admin=saca_nombre_lista("t1_proveedor",$_SESSION["id_proveedor2"],'razon_social','t1_proveedor_id',0);
	$mombre_admin=preg_replace('/,/', '', $mombre_admin);
	
	$_SESSION["titulo_sub2_proveedor"] = "<br /><br />".$titulo_grafica." del Proveedor ".$mombre_admin." por Contrato<br> <span style='font-size:14pt'>Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span><br /><br />";
	$titulo=$_SESSION["titulo_sub2_proveedor"];
}



if($_POST["usadas"] == 1){//total de tarifas
				
	}
	if($_POST["usadas"] == 2){//total de tarifas Usadas
		
		$complet_sql.= " and tarifa_usada > 0 ";
				
	}


//echo "* CAtegoria: ".$_POST["categoria"]."* TP grafica: ".$_POST["tp_grafica"]."* Usadas: ".$_POST["usadas"]."*<br>";
$barra1="";
$barra2="";
$barra3="";
$sql=query_db("select contrato,id_contrato_tarifas, razon_social from v_reporte_general_variacion_tarifas ".$complet_sql."  group by contrato,id_contrato_tarifas, razon_social order by contrato");
//echo $sql;


	
while($sel_contra = traer_fila_db($sql)){
$num_contrato = $sel_contra[0];
$complet_sql_while =$complet_sql." and id_contrato_tarifas = ".$sel_contra[1];
	
	
	
if($_POST["categoria"]=="TarifasContractuales"){
	$sql_barra_1 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 1 "));
	$cart.=$num_contrato.",".$sql_barra_1[0]."(toltip)".$sel_contra[2].",--,--";
}

if($_POST["categoria"]=="TarifasNuevas"){
	$sql_barra_2 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 3 "));
	$cart.=$num_contrato.",".$sql_barra_2[0]."(toltip)".$sel_contra[2].",--,--";
}

if($_POST["categoria"]=="TarifasModificadas"){
	$sql_barra_3 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 2 "));
	$cart.=$num_contrato.",".$sql_barra_3[0]."(toltip)".$sel_contra[2].",--,--";
}

if($_POST["categoria"]=="NUMEROTOTALDETARIFAS"){
	$sql_barra_1 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 1 "));
	$sql_barra_2 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 3 "));
	$sql_barra_3 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$complet_sql_while." and tipo_creacion_modifica = 2 "));
	$cart.=$num_contrato.",".$sql_barra_1[0].",".$sql_barra_2[0].",".$sql_barra_3[0]."(toltip)".$sel_contra[2].",--,--";
}
}


	$cart=utf8_decode($titulo."--titulo--".$num_columnas."--num_col--".$cart);//se utiliza la función utf8_decode() para que salgan bien las tíldes en los textos
	$cart=preg_replace('/\s+/', ' ', $cart);
	$cart=preg_replace('/\n/', ' ', $cart);
	echo $cart;
	?>