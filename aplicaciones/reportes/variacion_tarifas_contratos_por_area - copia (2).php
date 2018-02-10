<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
	$filtro_aplica = "Todos";
	
	$filtro_aplica = "Todos";
	

		
	$_SESSION["comple_filtro"] = " where fecha_inicio_vigencia >= '".$_GET["fecha_inicial"]."' and (fecha_fin_vigencia <= '".$_GET["fecha_hasta"]."' or fecha_fin_vigencia ='0000-00-00' or fecha_fin_vigencia is null)";

	
$_SESSION["fecha_inicial_bus_rep"] = $_GET["fecha_inicial"];
$_SESSION["fecha_hasta_bus_rep"] = $_GET["fecha_hasta"];

	
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="iso-8859-1">
	<title>Documento sin t&iacute;tulo</title>
	<script src="../../librerias/chart/chrat-loader.js" type="text/javascript"></script>
	<script src="../../librerias/jquery/jquery2.js" type="text/javascript"></script>
	<script>
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(ano_actual);

		function ano_actual() {
		var arg=[];
		var rows=new Array();

				
		$.post('../../librerias/chart/contenidos/reporte_tarifas/indicador1_google_charts.php', {}, function(data1) {
			var data = new google.visualization.DataTable();
		    	data.addColumn('string', 'Área del Gerente de Contrato');
			data.addColumn('number', 'Contratos sin Excepción');
			data.addColumn('number', 'Contratos con Excepción');
			var campos=data1.split("--campo--")
			var arg2=campos[campos.length-1]
			var option=arg2.split('--,--')
			//options2=option[option.length-1]
			for(var i=0; i<option.length-1; i++){
				var row=option[i].split(",")
				data.addRow([""+row[0], parseInt(row[1]), parseInt(row[2])])
				//arg.push([option[i]])
				console.log(row[0]+"----"+row[1]+"---"+row[2])
				
			}
			console.log()
				

		      var options = {
		            'title': '',
		            'subtitle': '',
		        hAxis: {
		          title: 'AREAS USUARIAS'
		        },
		        vAxis: {
		          title: 'NUMERO DE CONTRATOS'
		        },
		        colors: ['#FF0000', '#FFC000', '#974806', '#92D050'],
		        position: "bottom",
		        fontsize: "14px",
		        seriesType: 'bars',
		        series: {
		          3: { type: 'line' }
		        },
		        bar:{
		        	groupWidth: "50%"
		        }
		      };

		      var chart = new google.visualization.ColumnChart(document.getElementById('acumulado_ano_acual'));
		      /*function selectHandler() {
		      	var colors_pie=""
		          var selectedItem = chart.getSelection()[0];
		          if (selectedItem) {
		          	
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
		            });
		            //$('body').appe'<iframe src="reporte7_carga_pie.asp?fecha_inicial=<%=fecha_inicial%>&fecha_final=<%=fecha_final%>&id_bien=<%=id_bien%>&id_profesional=<%=id_profesional%>&id_area=<%=id_area%>&nombre_area='+topping+'" frameborder="0" style="display: none; width: 100%; height: 2400px; border: none;"></iframe>'
		          }
		        }*/

			//google.visualization.events.addListener(chart, 'select', selectHandler);
			chart.draw(data, options);
		});
			
		}
	</script>
</head>
<body onload="">
	<div id="acumulado_ano_acual" style="width: 100%; height: 600px"></div>
	
</body>
</html>