<? include("../../../lib/@session.php"); 
	

if($_POST["area"]!=""){
	$sel_area = traer_fila_row(quer_db("select t1_area_id from t1_area where nombre like '%".$_POST["area"]."%'"));
	$_SESSION["id_area_bus_rep"] = $sel_area[0];
	$comple_filtro2 = $_SESSION["comple_filtro"]." and t1_area_id = ".$_SESSION["id_area_bus_rep"];
}

if($_POST["gerente"]!=""){
	$_SESSION["id_gerente2"] = $_POST["gerente"];
	$comple_filtro2 = $_SESSION["comple_filtro"]." and id_gerente = ".$_SESSION["id_gerente2"];
}

if($_POST["proveedor"]!=""){
	$_SESSION["id_proveedor2"]=$_POST["proveedor"];
	$comple_filtro2 = $_SESSION["comple_filtro"]." and t1_proveedor_id= ".$_SESSION["id_proveedor2"];
}




	
$categorias ="";
$barra1="";
$barra2="";
$total1=0;
$total2=0;
$cart="'XX nombre columna--campo--No. de Tarifas--campo--No. Tarifas Usadas--campo--";//se configuran las categorias o grupos de las graficas


	/*para categoria/grupo contractuales*/
	$sql_barra_1 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 1"));
	$sql_barra_2 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 1 and tarifa_usada > 0"));
	$cart.="Tarifas Contractuales,".$sql_barra_1[0].",".$sql_barra_2[0].",--,--";
    $total1=$total1 + $sql_barra_1[0];
	$total2=$total2 + $sql_barra_2[0];
	/*FIN para contractuales*/

/*para categoria/grupo Nuevas*/
	$sql_barra_1 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 2"));
	$sql_barra_2 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 2 and tarifa_usada > 0"));
	$cart.="Tarifas Nuevas,".$sql_barra_1[0].",".$sql_barra_2[0].",--,--";
    $total1=$total1 + $sql_barra_1[0];
	$total2=$total2 + $sql_barra_2[0];
	/*FIN para nuevas*/

/*para categoria/grupo modificaciones*/
	$sql_barra_1 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 3"));
	$sql_barra_2 = traer_fila_row(query_db("select count(*) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro2"]." and tipo_creacion_modifica = 3 and tarifa_usada > 0"));
	$cart.="Tarifas Modificadas,".$sql_barra_1[0].",".$sql_barra_2[0].",--,--";
    $total1=$total1 + $sql_barra_1[0];
	$total2=$total2 + $sql_barra_2[0];
	/*FIN para modificaciones*/

/*para Total*/
	$cart.="NUMERO TOTAL DE TARIFAS,".$total1.",".$total2.",--,--";
	/*FIN para Total*/


$cart=utf8_decode($cart);//se utiliza la función utf8_decode() para que salgan bien las tíldes en los textos
	$cart=preg_replace('/\s+/', ' ', $cart);
	$cart=preg_replace('/\n/', ' ', $cart);
	//echo $cart;
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento sin t&iacute;tulo</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../../materialize/css/materialize_custom.css">
	<script src="../../../chart/chrat-loader.js" type="text/javascript"></script>
	<script src="../../../jquery/jquery2.js" type="text/javascript"></script>
	<style>
	.div-text {
		width: 90%;
		margin-left: 5%;
		height: auto;
	}
	.div-custom-red2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #E0766B;
	}
	.div-custom-yellow2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FFBE5E;
	}
	.div-custom-green2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #6AC46F;
	}
	.font{
		font-family: 'roboto';
	}
	.f14{
		font-size: 12pt;
	}
	.f12{
		font-size: 9pt;
		font-weight: 900 !important;
	}
	.f10{
		font-size: 8pt;
		color: #000;
	}
	.table-custom{
		width: 98%;
		margin-left: 1%;
		border-collapse:collapse;
	}
	.th-custom{
		/*-webkit-box-shadow: 0 9px 4px #777;
		-moz-box-shadow: 0 9px 4px #777;
		box-shadow: 0 9px 4px #777;*/
		background: transparent;
		color: #FFF;		
		font-weight: 900;
	}
	.td-title-red{
		background: #FE5151;
		color: #FFF;
	}
	.td-title-yellow{
		background: #FEC007;
		color: #FFF;
	}
	.td-title-green{
		background: #4BAE4F;
		color: #FFF;
	}
	.custom-red2{
		color: #FF3333;
	}
	.custom-yellow2{
		color: #E2B700;
	}
	.custom-green2{
		color: #009900;
	}
	.border{
		border: 2px solid #FFF;
	}
	.transparent{
		background: transparent;
	}
</style>
	<script>

		// color verde 99C754
		// color azul 54C7C5
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(ano_actual);

		function ano_actual() {
		var arg=[];
		var rows=new Array();

				
		//$.post('../../librerias/chart/contenidos/reporte_tarifas/indicador1_google_charts.php', {}, function(data1) {
			var data1="<?=$cart;?>";
			var data = new google.visualization.DataTable();
		    	//data.addColumn('string', 'Área del Gerente de Contrato');
			//data.addColumn('number', 'Contratos sin Excepción');
			//data.addColumn('number', 'Contratos con Excepción');
			var campos=data1.split("--campo--")
			for(var i=0; i<(campos.length-1); i++){
				campos[i]=campos[i].replace("&Aacute;","&#193;")
				campos[i]=campos[i].replace("&oacute;","ó")
				if(i==0){
					data.addColumn('string', campos[i]);
				}else{
					data.addColumn('number', campos[i]);
				}
				
			}
			//dataTable.addColumn({type: 'string', role: 'tooltip'});
			var arg2=campos[campos.length-1]
			var option=arg2.split('--,--')
			//options2=option[option.length-1]
			for(var i=0; i<option.length-1; i++){
				var row=option[i].split(",")
				data.addRow([""+row[0], parseInt(row[1]), parseInt(row[2])])
				//arg.push([option[i]])
				//console.log(row[0]+"----"+row[1]+"---"+row[2])
				
			}
			//console.log()
				

		      var options = {
			colors: ['#99C754', '#54C7C5'],
			'width':1000,
                    		'height':1000,
                    		'left':0,
                    		bar:{
        				groupWidth: "25%"
			},
			hAxis : { 
        				textStyle : {
            				fontSize: 10 // or the number you want
        				}

   			}
		      };

		      var chart = new google.visualization.ColumnChart(document.getElementById('acumulado_ano_acual'));
		      function selectHandler() {
		      	var colors_pie=""
		          var selectedItem = chart.getSelection()[0];
		          var id=data.getValue(selectedItem.row, 0)
		          		id=id.split("(cod")
		          		id[1]=id[1].replace(")","")
		          if(selectedItem.column==1){		          		
		          		alert("el id: "+id[1]+" se pulsó desde la columna # 1")
		          }else if(selectedItem.column==2){
		          		alert("el id: "+id[1]+" se pulsó desde la columna # 2")
		          }
		          //console.log(data.getValue(selectedItem.row, 0))
		          if (selectedItem) {/*
		          	
		            var topping = data.getValue(selectedItem.row, 0);
		            topping=topping.replace(/\|/gi, "-")
		            $.get('reporte7_carga_pie.asp?fecha_inicial=<%=fecha_inicial%>&fecha_final=<%=fecha_final%>&id_bien=<%=id_bien%>&id_profesional=<%=id_profesional%>&id_area=<%=id_area%>&nombre_area='+topping, function(data) {
		            	//console.log(data)
		            	var fruits_color = [];
							
		            	if(data!=""){
		            		$('#hecho_cumplido').empty()
		            		//$.post('reporte7_carga_session_pie.asp', {data: data}, function(data) {
		            			draw_table=data.split('!')
		            			//console.log(draw_table[1])
		            			draw_data=draw_table[0].split('-')
		            			//console.log(data)
		            			google.charts.setOnLoadCallback(hecho_cumplido);
							    function hecho_cumplido() {
							    	var data1 = new google.visualization.DataTable();
								    data1.addColumn('string', 'ESTRATEGIA');
									data1.addColumn('number', 'TOTAL');
							    	//console.log(draw_data)

							        var data = new google.visualization.DataTable();
								    for(i in draw_data){
								    	var imp=draw_data[i]
								    	imp=imp.split(',')
								    	imp[0]=imp[0].replace("'","")
								    	imp[0]=imp[0].replace(/\|/gi, "")
								    	imp[0]=imp[0].replace(/\'/gi, "")
								    	imp[1]=imp[1].replace("'","")
								    	imp[1]=imp[1].replace(/\|/gi, "")
								    	imp[1]=imp[1].replace(/\'/gi, "")
								    	imp[2]=imp[2].replace(/\|/gi, "")
								    	imp[2]=imp[2].replace(/\'/gi, "")
								    	imp[2]=imp[2].replace(/\ /gi, "")
								    	if(imp[2]=="3"){
								    		data1.addRow([imp[0].toUpperCase(), parseInt(imp[1])]);
								    		fruits_color.push("#FFC000");
								    	}else if(imp[2]=="12"){
								    		data1.addRow([imp[0].toUpperCase(), parseInt(imp[1])]);
								    		fruits_color.push("#FF0000");
								    	}else if(imp[2]=="1"){
								    		data1.addRow([imp[0].toUpperCase(), parseInt(imp[1])]);
								    		fruits_color.push("#974806");
								    	}else if(imp[2]=="0"){
								    		data1.addRow([imp[0].toUpperCase(), parseInt(imp[1])]);
								    		fruits_color.push("#92D050");
								    	}
								    	//console.log(imp[0]+"----"+imp[1]+"----"+imp[2])
								    	//console.log(fruits_color)
								    }
							        //data.addRows(draw_data)
							        //console.log(colors_pie)
							        var options = {
							          title: ''+topping,
							          legend: {position: 'top', textStyle: {color: 'withe', fontSize: 16}},
							          colors: fruits_color
							        };
							        //var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		      						//chart.draw(data, options);
							        var chart = new google.visualization.PieChart(document.getElementById('hecho_cumplido'));

							        chart.draw(data1, options);

							    }
		            		//});
		            		$('#hecho_cumplido').append(draw_table[1])
		            	}
		            });*/
		            //$('body').appe'<iframe src="reporte7_carga_pie.asp?fecha_inicial=<%=fecha_inicial%>&fecha_final=<%=fecha_final%>&id_bien=<%=id_bien%>&id_profesional=<%=id_profesional%>&id_area=<%=id_area%>&nombre_area='+topping+'" frameborder="0" style="display: none; width: 100%; height: 2400px; border: none;"></iframe>'
		          }
		        }

			google.visualization.events.addListener(chart, 'select', selectHandler);
			chart.draw(data, options);
		//});
			
		}
	</script>
</head>
<body>
	<div class="titulos_secciones font" style="font-size:16pt !important; font-weight: 900 !important;">N&uacute;mero  de contratos por &aacute;rea del Gerente de Contrato, en el rango de vigencia desde <?=$_SESSION["fecha_inicial_bus_rep"];?> y hasta <?=$_SESSION["fecha_hasta_bus_rep"]?>  </div>
	<div id="acumulado_ano_acual" style="width: 100% !important; height: 600px; margin-left: 0%!important;"></div>
	
</body>
</html>