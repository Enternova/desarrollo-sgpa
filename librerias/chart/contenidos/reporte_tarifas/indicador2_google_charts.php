<? include("../../../lib/@session.php");
if($_GET["muestra"]=="si"){//si se  muestra la grafica
$sql="select t1_proveedor_id, razon_social from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]."  group by t1_proveedor_id, razon_social order by razon_social";

$categorias ="";
$barra1="";
$barra2="";
$cart="Área del Gerente de Contrato--campo--Contratos sin Excepción--campo--Contratos con Excepción--campo--";
//se utiliza la función utf8_decode() para que salgan bien las tíldes en los textos
$cart=utf8_decode($cart);
$selec_t_pro = query_db($sql);
	$contratos_con_excepcion = 0;
	$contratos_sin_excepcion = 0;
while($sel_pro = traer_fila_db($selec_t_pro)){
	$categorias.="<category name='".$sel_pro[1]."' hoverText='cat2'/>";
	
	$sql_barra_1 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t1_proveedor_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id <> 6"));
	//$barra1.="<set value='".($sql_barra_1[0])."' link='F-grafica_detalle_area-variacion_tarifas_detalle_area.php?id_area=".$sel_pro[0]."'/>";
	$barra1.="<set value='".($sql_barra_1[0])."' link='JavaScript:carga_grafica_detalle_area(".$sel_pro[0].")'/>";
	
	$sql_barra_2 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro_exepcion"]." and t1_proveedor_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id = 6"));
	$barra2.="<set value='".($sql_barra_2[0])."' link='JavaScript:contratos_exepcion_graf(".$sel_pro[0].")' />";
	$contratos_con_excepcion = $contratos_con_excepcion+$sql_barra_2[0];
	$contratos_sin_excepcion = $contratos_sin_excepcion+$sql_barra_1[0];
	$cart.=$sel_pro[1].",".$sql_barra_1[0].",".$sql_barra_2[0].",".$sel_pro[0].",--,--";
}
	//SE ELIMINAN TODOS LOS SÁLTOS DE LÍNEA EN LA VARIABLE
	$cart=preg_replace('/\s+/', ' ', $cart);
	$cart=preg_replace('/\n/', ' ', $cart);
	//echo $cart;
	$cart2="";
	//$sql_barra_1 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and t6_tarifas_estados_contratos_id <> 6"));
	$cart2.="['TOTAL CONTRATOS SIN EXCEPCION', ".number_format($contratos_sin_excepcion,0).", '".number_format($contratos_sin_excepcion,0)."']";
	//$sql_barra_2 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t6_tarifas_estados_contratos_id = 6"));
	$cart2.=",['TOTAL CONTRATOS CON EXCEPCION', ".number_format($contratos_con_excepcion,0).", '".number_format($contratos_con_excepcion,0)."']";
	//$cart2.=",['TOTAL DE CONTRATOS', ".number_format($sql_barra_1[0] + $sql_barra_2[0],0).", '".number_format($sql_barra_1[0] + $sql_barra_2[0],0)."']";
	$titulo_pie="TOTAL DE CONTRATOS ".number_format($contratos_sin_excepcion + $contratos_con_excepcion,0);
	$cart2=preg_replace('/\s+/', ' ', $cart2);
	$cart2=preg_replace('/\n/', ' ', $cart2);
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Documento sin t&iacute;tulo</title>
	<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
	   //echo $u_agent;

	  $nombre_ie_css = "chips-ms12";

	  
	    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
	    { ?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
	    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
	    { ?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
	    <?}elseif(preg_match('/Firefox/i',$u_agent))
	    {?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/chips-moz.css?version=<?=$hora?>" />  
	    <?} 
	    elseif(preg_match('/Chrome/i',$u_agent)) 
	    {?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/chips-webkit.css?version=<?=$hora?>" />  
	    <?} 
	    elseif(preg_match('/Safari/i',$u_agent)) 
	    {?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/chips-safari.css?version=<?=$hora?>" />  
	    <?} 
	    elseif(preg_match('/Opera/i',$u_agent)) 
	    {?>
	        <link rel="stylesheet" type="text/css" href="../../../../css/chips/chips-opera.css?version=<?=$hora?>" />  
	    <? } 
	    else  { 
	    ?>
	         <link rel="stylesheet" type="text/css" href="../../../../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
	    <?
	    }

	?>
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
	.grafica{
		margin-left: 0%!important;
		border-bottom: 1px solid #ccc;
		border-right:  1px solid #ccc;
		border-radius: 0px 0px 15px 0px;
		margin-top: 2%;
		box-shadow: 8px 7px 5px 0px #ccc;
	}
</style>
	<script>

		// color verde 99C754
		// color azul 54C7C5
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(carta_pie_total);
		function carta_pie_total() {
			var data_pie = new google.visualization.DataTable();
			data_pie.addColumn('string', 'TIPO DE TOAL');
			data_pie.addColumn('number', 'TOTAL');
			data_pie.addColumn({type:'string', role:'annotation'});
			data_pie.addRows([<?=$cart2;?>])
			var options = {
			title: '<?=$titulo_pie?>',
			legend: {position: 'right'},
			colors: ['#99C754', '#54C7C5', '#DC3912'],
			'width':500,
                    		'height':200,
                    		'left':0,
                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
                    		pieSliceText: 'value',
                    		titleTextStyle: {
			        fontName: 'roboto', // i.e. 'Times New Roman'
			        fontSize: 18, // 12, 18 whatever you want (don't specify px)
			        bold: true,    // true or false
					annotations: {
						alwaysOutside: true
					}
			}
			};
			var chart = new google.visualization.PieChart(document.getElementById('total_pie'));
			chart.draw(data_pie, options);

		}
		google.charts.setOnLoadCallback(ano_actual);
		function ano_actual() {
		var arg=[];
		var rows=new Array();
			var data1="<?=$cart;?>";//se recive la variable en formato de cadena
			var data = new google.visualization.DataTable();
			var campos=data1.split("--campo--")//se busca llos delimitadores para saber cuales son las columnas
			for(var i=0; i<(campos.length-1); i++){//se recorre el arreglo para agregar las columnas de forma dinámica, éstas se deben declarar de primeras
				if(i==0){
					data.addColumn('string', campos[i]);//si es cero es la primera posición que corresponde al nombre de las areas
				}else{
					data.addColumn('number', campos[i]);//si es mayor que cero, son las columnas que van a almacenar los datos por eso se declaran de tipo numero
				}
			}
			var arg2=campos[campos.length-1]
			var option=arg2.split('--,--')//se obtinee el delimitador para saber cuales son los datos que van a llenar la grafica
			for(var i=0; i<option.length-1; i++){//se recorre el arreglo para llenar los datos de forma dinamica
				var row=option[i].split(",")
				data.addRow([""+row[0], parseInt(row[1]), parseInt(row[2])])//se agrega un registro a la grafica
			}
		      var options = {//se definen los atributos de la gráfica
			colors: ['#99C754', '#54C7C5'],
			'width':1090,
                    		'height':1100,
                    		'left':0,
                    		'title': '',//se le da el título a la gráfica
                    		bar:{
        				groupWidth: "25%"
			},
			vAxis : {
				title: '',
        				textStyle : {
            				fontSize: 10 //tamño de la letra en el nombre de las areas
        				}

   			},
   			'chartArea': {'width': '60%', 'height': '95%'},
   				legend: { position: 'top' }//para ubicar los titulos al lado de arriba
		      };
		      var chart = new google.visualization.BarChart(document.getElementById('nivel_1'));//se le pasa el id del div donde se va a cargar la gráfica
		      function selectHandler() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
		      	var colors_pie=""
		          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
		          		var selectedItem = chart.getSelection()[0];//se almacena el dato
		          		var id=data.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          if(selectedItem.column==1){//se evalua desde que columna viene la accción para saber que ejecutar
			         	 	muestra_carga1()
			          		oculta_boton_sub1()
			          		nivel_sub1(id)
			          		//alert("--"+id+"--")
			          }else if(selectedItem.column==2){
			          		//alert("el id: "+id+" se pulsó desde la columna # 2")
			          }
		          }
		        }
			google.visualization.events.addListener(chart, 'select', selectHandler);//se le asigna el evento que va a escuchar las acciones a la gráfica
			//chart.draw(data, options);
			google.visualization.events.addListener(chart, 'onmouseover', uselessHandler2);
			google.visualization.events.addListener(chart, 'onmouseout', uselessHandler3);
			chart.draw(data, options);

			function uselessHandler2() {
			 $('#nivel_1').css('cursor','pointer')
			  }  
			        function uselessHandler3() {
			 $('#nivel_1').css('cursor','default')
			  }
			setTimeout(function(){ oculta_carga1(); }, 3000);
		}
		function nivel_sub1(id){//éste se ejecuta para la columna número 1
			///$("#sub_nivel_1").empty();//se limpia el contendio del div 2 donde se cargan las gráficas
			id=id.replace(/^\s+|\s+$/g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			id=id.replace(/ /g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			$.post('indicador1_sub1_google_charts.php', {proveedor: id}, function(data5) {//se pasa por post la variable para esperar la respuesta con los datos para armar la otra gráfica
				var graficas=data5.split('--grafica--')
				var titulo=graficas[0].split('--titulo--')
				var data1=titulo[1];
				var data2 = new google.visualization.DataTable();
				var campos=data1.split("--campo--")
				for(var i=0; i<(campos.length-1); i++){
					campos[i]=campos[i].replace("&Aacute;","&#193;")
					campos[i]=campos[i].replace("&oacute;","ó")
					if(i==0){
						data2.addColumn('string', campos[i]);
					}else{
						data2.addColumn('number', campos[i]);
					}
					
				}
				var arg2=campos[campos.length-1]
				var option=arg2.split('--,--')
				for(var i=0; i<option.length-1; i++){
					var row=option[i].split(",")
					data2.addRow([""+row[0], parseInt(row[1]), parseInt(row[2]), parseInt(row[3]), parseInt(row[4]), parseInt(row[5]), parseInt(row[6])])
				}
			      var options = {
				colors: ['#739DC8', '#9DBAD8', '#B88563', '#CDA991', '#B7BB60', '#CCCF8F'],
				'width':1100,
	                    		'height':400,
	                    		'left':0,
	                    		'title': '',//se le da el título a la gráfica
	                    		bar:{
	        				groupWidth: "25%"
				},
				hAxis : { 
	        				textStyle : {
	            				fontSize: 16
	        				}

	   			},
   				'chartArea': {'width': '90%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div
   				legend: { position: 'top',  textStyle: {fontSize: 13}}//para ubicar los titulos al lado de arriba
			      };
			      var chart = new google.visualization.ColumnChart(document.getElementById('sub_nivel_1'));
			      function selectHandler2() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
			      	var colors_pie=""
			          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
			          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          		var id=data2.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          		/*id=id.split('(cod')
			          		id=id[1]
			          		id=id.replace(')','')*/
				          if(selectedItem.column==1 || selectedItem.column==3 || selectedItem.column==5){//se evalua desde que columna viene la accción para saber que ejecutar
				          		muestra_carga1()
				          		nivel_sub2(id,1)
				          		//alert("el id: "+id+" se pulsó desde la columna # 1")
				          }else if(selectedItem.column==2){
				          		nivel_sub2(id,2)
				          		//alert("el id: "+id+" se pulsó desde la columna # 2")
				          }
			          }
			      }
			      //$("#sub_nivel_1").append('<h1>este es el titulo de la segunda gráfica</h1>');//se le agrega el título a la gráfica
			      google.visualization.events.addListener(chart, 'select', selectHandler2);//se le asigna el evento que va a escuchar las acciones a la gráfica
			      //chart.draw(data2, options);
			       google.visualization.events.addListener(chart, 'onmouseover', uselessHandler2);
			      google.visualization.events.addListener(chart, 'onmouseout', uselessHandler3);
			      chart.draw(data2, options);
			     function uselessHandler2() {
				$('#nivel_1').css('cursor','pointer')
			     }  
			     function uselessHandler3() {
				$('#nivel_1').css('cursor','default')
			     }
			      $('#titulo_sub1').empty()
			      $('#titulo_sub1').append(titulo[0])
			      $('#boton1_sub1').css('display', 'block');
			      $('#boton2_sub1').css('display', 'block');
			      //PARA LOS TOTALES EN EL PIE
				//GRAFICA 1
				google.charts.setOnLoadCallback(carta_pie_total1);
				function carta_pie_total1() {
					var grfica2=graficas[1].split('--campo--')
					var data_pie2 = new google.visualization.DataTable();
					data_pie2.addColumn('string', 'TIPO DE TOAL');
					data_pie2.addColumn('number', 'TOTAL');
					data_pie2.addColumn({type:'string', role:'annotation'});
					data_pie2.addRow(['TARIFAS SIN USAR', parseInt(grfica2[0]), grfica2[0].toString()])
					data_pie2.addRow(['TARIFAS USADAS', parseInt(grfica2[1]), grfica2[1].toString()])

					var options = {
					title: 'USO DE TARIFAS CONTRACTUALES',
					legend: {position: 'right'},
					colors: ['#739DC8', '#C5C980'],
					'width':450,
		                    		'height':260,
		                    		'left':0,
		                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
		                    		pieSliceText: 'value',
		                    		titleTextStyle: {
					        fontName: 'roboto', // i.e. 'Times New Roman'
					        fontSize: 18, // 12, 18 whatever you want (don't specify px)
					        bold: true,    // true or false
							annotations: {
								alwaysOutside: true
							}
					}
					};
					var chart = new google.visualization.PieChart(document.getElementById('sub_nivel_21'));
					function selectHandler1() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
					          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
					          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          				var id=data_pie2.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          				abre_ventana_excel('TOTAL TARIFAS CONTRACTUALES',id)
			          				//alert(id)
					          }
					}
					google.visualization.events.addListener(chart, 'select', selectHandler1);//se le asigna el evento que va a escuchar las acciones a la gráfica
					chart.draw(data_pie2, options);
				}
				// FIN GRAFICA 1
				//GRAFICA 2
				google.charts.setOnLoadCallback(carta_pie_total2);
				function carta_pie_total2() {
					var grfica3=graficas[2].split('--campo--')
					var data_pie3 = new google.visualization.DataTable();
					data_pie3.addColumn('string', 'TIPO DE TOAL');
					data_pie3.addColumn('number', 'TOTAL');
					data_pie3.addColumn({type:'string', role:'annotation'});
					data_pie3.addRow(['TARIFAS SIN USAR', parseInt(grfica3[0]), grfica3[0].toString()])
					data_pie3.addRow(['TARIFAS USADAS', parseInt(grfica3[1]), grfica3[1].toString()])

					var options = {
					title: 'USO DE TARIFAS NUEVAS',
					legend: {position: 'right'},
					colors: ['#739DC8', '#C5C980'],
					'width':450,
		                    		'height':260,
		                    		'left':0,
		                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
		                    		pieSliceText: 'value',
		                    		titleTextStyle: {
					        fontName: 'roboto', // i.e. 'Times New Roman'
					        fontSize: 18, // 12, 18 whatever you want (don't specify px)
					        bold: true,    // true or false
							annotations: {
								alwaysOutside: true
							}
					}
					};
					var chart = new google.visualization.PieChart(document.getElementById('sub_nivel_22'));
					function selectHandler1() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
					          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
					          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          				var id=data_pie3.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          				abre_ventana_excel('TOTAL TARIFAS NUEVAS',id)
			          				//alert(id)
					          }
					}
					google.visualization.events.addListener(chart, 'select', selectHandler1);//se le asigna el evento que va a escuchar las acciones a la gráfica
					chart.draw(data_pie3, options);
				}
				// FIN GRAFICA 2
				//GRAFICA 3
				google.charts.setOnLoadCallback(carta_pie_total3);
				function carta_pie_total3() {
					var grfica4=graficas[3].split('--campo--')
					var data_pie4 = new google.visualization.DataTable();
					data_pie4.addColumn('string', 'TIPO DE TOAL');
					data_pie4.addColumn('number', 'TOTAL');
					data_pie4.addColumn({type:'string', role:'annotation'});
					data_pie4.addRow(['TOTAL DE TARIFAS SIN USAR', parseInt(grfica4[0]), grfica4[0].toString()])
					data_pie4.addRow(['TARIFAS USADAS CONTRACTUALES', parseInt(grfica4[1]), grfica4[1].toString()])
					data_pie4.addRow(['TARIFAS USADAS NUEVAS', parseInt(grfica4[2]), grfica4[2].toString()])

					var options = {
					title: 'TOTAL DE USO DE TARIFAS',
					legend: {position: 'right'},
					colors: ['#739DC8', '#C5C980', '#B88563'],
					'width':450,
		                    		'height':260,
		                    		'left':0,
		                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
		                    		pieSliceText: 'value',
		                    		titleTextStyle: {
					        fontName: 'roboto', // i.e. 'Times New Roman'
					        fontSize: 18, // 12, 18 whatever you want (don't specify px)
					        bold: true,    // true or false
							annotations: {
								alwaysOutside: true
							}
					}
					};
					var chart = new google.visualization.PieChart(document.getElementById('sub_nivel_23'));
					function selectHandler1() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
					          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
					          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          				var id=data_pie4.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          				abre_ventana_excel('TOTAL TARIFAS',id)
			          				//alert(id)
					          }
					}
					google.visualization.events.addListener(chart, 'select', selectHandler1);//se le asigna el evento que va a escuchar las acciones a la gráfica
					chart.draw(data_pie4, options);
				}
				// FIN GRAFICA 3
				//GRAFICA 4
				google.charts.setOnLoadCallback(carta_pie_total4);
				function carta_pie_total4() {
					var grfica5=graficas[4].split('--campo--')
					var data_pie5 = new google.visualization.DataTable();
					data_pie5.addColumn('string', 'TIPO DE TOAL');
					data_pie5.addColumn('number', 'TOTAL');
					data_pie5.addColumn({type:'string', role:'annotation'});
					data_pie5.addRow(['Modificaciones Contractuales por IPC', parseInt(grfica5[0]), grfica5[0].toString()])
					data_pie5.addRow(['Modificaciones Contractuales por Otros', parseInt(grfica5[1]), grfica5[1].toString()])
					data_pie5.addRow(['Tarifas Contractuales', parseInt(grfica5[5]), grfica5[5].toString()])
					data_pie5.addRow(['Modificaciones de Tarifas Nuevas por IPC', parseInt(grfica5[2]), grfica5[2].toString()])
					data_pie5.addRow(['Modificaciones de Tarifas Nuevas por Otros Conceptos', parseInt(grfica5[3]), grfica5[3].toString()])
					data_pie5.addRow(['Tarifas Nuevas', parseInt(grfica5[4]), grfica5[4].toString()])
					

					var options = {
					title: 'BALANCE DE MODIFICACION DE TARIFAS',
					legend: {position: 'right'},
					colors: ['#B88563', '#B7BB60', '#739DC8' , '#CDA991', '#CCCF8F', '#9DBAD8'],
					'width':450,
		                    		'height':260,
		                    		'left':0,
		                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
		                    		pieSliceText: 'value',
		                    		titleTextStyle: {
					        fontName: 'roboto', // i.e. 'Times New Roman'
					        fontSize: 18, // 12, 18 whatever you want (don't specify px)
					        bold: true,    // true or false
							annotations: {
								alwaysOutside: true
							}
					}
					};
					var chart = new google.visualization.PieChart(document.getElementById('sub_nivel_24'));
					function selectHandler1() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
					          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
					          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          				var id=data_pie5.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          				abre_ventana_excel('BALANCE DE MODIFICACION DE TARIFAS',id)
			          				//alert(id)
					          }
					}
					google.visualization.events.addListener(chart, 'select', selectHandler1);//se le asigna el evento que va a escuchar las acciones a la gráfica
					chart.draw(data_pie5, options);
				}
				// FIN GRAFICA 3
				//GRAFICA 4
				google.charts.setOnLoadCallback(carta_pie_total4);
				function carta_pie_total4() {
					var grfica5=graficas[4].split('--campo--')
					var data_pie5 = new google.visualization.DataTable();
					data_pie5.addColumn('string', 'TIPO DE TOAL');
					data_pie5.addColumn('number', 'TOTAL');
					data_pie5.addColumn({type:'string', role:'annotation'});
					data_pie5.addRow(['Modificaciones Contractuales por IPC', parseInt(grfica5[0]), grfica5[0].toString()])
					data_pie5.addRow(['Modificaciones Contractuales por Otros', parseInt(grfica5[1]), grfica5[1].toString()])
					data_pie5.addRow(['Tarifas Contractuales', parseInt(grfica5[5]), grfica5[5].toString()])
					data_pie5.addRow(['Modificaciones de Tarifas Nuevas por IPC', parseInt(grfica5[2]), grfica5[2].toString()])
					data_pie5.addRow(['Modificaciones de Tarifas Nuevas por Otros Conceptos', parseInt(grfica5[3]), grfica5[3].toString()])
					data_pie5.addRow(['Tarifas Nuevas', parseInt(grfica5[4]), grfica5[4].toString()])
					

					var options = {
					title: 'BALANCE DE MODIFICACION DE TARIFAS',
					legend: {position: 'right'},
					colors: ['#B88563', '#B7BB60', '#739DC8' , '#CDA991', '#CCCF8F', '#9DBAD8'],
					'width':450,
		                    		'height':260,
		                    		'left':0,
		                    		'chartArea': {'width': '100%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div,
		                    		pieSliceText: 'value',
		                    		titleTextStyle: {
					        fontName: 'roboto', // i.e. 'Times New Roman'
					        fontSize: 18, // 12, 18 whatever you want (don't specify px)
					        bold: true,    // true or false
							annotations: {
								alwaysOutside: true
							}
					}
					};
					var chart = new google.visualization.PieChart(document.getElementById('sub_nivel_24'));
					function selectHandler1() {//se crea un evento, el cual  se va a ejecutar cuando se de click sobre cualquiera de los datos
					          if(chart.getSelection()[0]!=undefined && chart.getSelection()[0].row!=null){//se valida que sea un dato válido
					          		var selectedItem = chart.getSelection()[0];//se almacena el dato
			          				var id=data_pie5.getValue(selectedItem.row, 0)//se obiene el valor de la columna
			          				abre_ventana_excel('BALANCE DE MODIFICACION DE TARIFAS',id)
			          				//alert(id)
					          }
					}
					google.visualization.events.addListener(chart, 'select', selectHandler1);//se le asigna el evento que va a escuchar las acciones a la gráfica
					chart.draw(data_pie5, options);
				}
			      setTimeout(function(){ oculta_carga1(); }, 3000);
			});
		}
		function nivel_sub2(text, col){//éste se ejecuta para la columna número 1
			text=text.replace(/^\s+|\s+$/g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			text=text.replace(/ /g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			//alert(text+"----"+col)
			$.post('indicador1_sub2_google_charts.php', {categoria: text, usadas: col, tp_grafica: 3}, function(data6) {//se pasa por post la variable para esperar la respuesta con los datos para armar la otra gráfica
				var titulo=data6.split('--titulo--')
				var data1=titulo[1];
				var data9 = new google.visualization.DataTable();
				var num_col=data1.split("--num_col--")
				var campos=num_col[1].split("--campo--")
				for(var i=0; i<(campos.length-1); i++){
					campos[i]=campos[i].replace("&Aacute;","&#193;")
					campos[i]=campos[i].replace("&oacute;","ó")
					if(i==0){
						data9.addColumn('string', campos[i]);
					}else{
						data9.addColumn('number', campos[i]);
						data9.addColumn({type:'string', role:'annotation'});
					}
					
				}
				var arg2=campos[campos.length-1]
				var option=arg2.split('--,--')
				for(var i=0; i<option.length-1; i++){
					var row=option[i].split(",")
					var fila=row[1].split("(toltip)")
					data9.addRow([""+row[0], parseInt(fila[0]), fila[1].toString()])
					/*if(parseInt(num_col[0])==0){
						data9.addRow([""+row[0], parseInt(row[1])])
					}else{
						data9.addRow([""+row[0], parseInt(row[1]), parseInt(row[2]),parseInt(fila[0]), fila[1].toString()])
					}*/
				}
				//setTimeout(function(){ oculta_carga1(); }, 3000);
			      var options = {
				colors: ['#99C754', '#54C7C5'],
				'width':1000,
	                    		'height':1100,
	                    		'left':0,
	                    		'title': '',//se le da el título a la gráfica
	                    		bar:{
	        				groupWidth: "25%"
				},
				vAxis : {
					title: '',
	        				textStyle : {
	            				fontSize: 10 //tamño de la letra en el nombre de las areas
	        				}

	   			},
	   			'chartArea': {'width': '60%', 'height': '95%'},
   				legend: { position: 'top' }//para ubicar los titulos al lado de arriba
			      };
			      var chart = new google.visualization.BarChart(document.getElementById('sub_nivel_2'));
			      chart.draw(data9, options);
			      $('#titulo_sub2').empty()
			      $('#titulo_sub2').append(titulo[0])
			      setTimeout(function(){ oculta_carga1(); }, 3000);
			});
		}
		function abrir_ventana(pagina) {
			var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
			window.open(pagina,"",opciones);
		}
		function oculta_boton_sub1(){
			$('#boton1_sub1').css('display', 'none');
			$('#boton2_sub1').css('display', 'none');
		}
		function oculta_carga1(){
			window.parent.oculta_carga();
		}
		function muestra_carga1(){
			window.parent.muestra_carga();
		}
	</script>
</head>
<body onload="$('#boton1_sub1').css('display', 'none');$('#boton2_sub1').css('display', 'none');">
	<div class="row">
		<div class="input-field col col s12 m6 l6 left">
			<div class="titulos_secciones font" style="font-size:18pt !important; font-weight: 900 !important;"><br>N&uacute;mero de Contratos por Proveedor<?=$_SESSION["titulo_filtro2"];?> <?=ayuda_alerta_pequenaaling_izq_in_iframe("Para ver el detalle de esta gr&aacute;fica, de un click en cualquiera de las barras Verdes (Contratos sin Exepci&oacute;n) y a continuaci&oacute;n en la parte inferior a esta se abrir&aacute; una nueva gr&aacute;fica. ");?></div>
			<a onclick="abrir_ventana('../../../../aplicaciones/reportes/reporte_variaciones_global_tabla_grafica1.php?tp_grafica1=area')" class="waves-effect waves-light btn" style="background-color: #229BFF; margin-top: 10% !important;"><i class="material-icons left">&#xE8F0;</i>Generar Tabla</a>
			<a onclick="abrir_ventana('../../../../aplicaciones/reportes/reporte_variaciones_global_excel.php?tp_grafica=proveedor1')" class="waves-effect waves-light btn" style="background-color: #229BFF; margin-top: 10% !important;"><i class="material-icons left">&#xE2C0;</i>Descargar Soporte a Excel</a>
		</div>
		<div class="input-field col s12 m6 l6 right">
			<div id="total_pie" style="width: 98% !important; height: 210px;" class="grafica"></div>
		</div>
	</div>
	<div id="nivel_1" style="width: 100% !important; height: 1100px; margin-left: 0%!important; margin-top: 0px !important;" class="grafica"></div>
	<div class="row">
		<div class="input-field col col s12 m6 l6 left">
		<div class="titulos_secciones font" id="titulo_sub1" style="font-size:16pt !important; font-weight: 900 !important;"></div>
		</div>
		<div class="input-field col s12 m6 l6 right " id="boton1_sub1">
			<!--a onclick="abrir_ventana('../../../../aplicaciones/reportes/reporte_variaciones_global_tabla_grafica1.php?tp_grafica1_sub1=area')" class="waves-effect waves-light btn" style="background-color: #229BFF; margin-top: 10% !important;" id=""><i class="material-icons left">&#xE8F0;</i>Generar Tabla</a
			<a onclick="abrir_ventana('../../../../aplicaciones/reportes/reporte_variaciones_global_excel.php?tp_grafica=proveedor1_sub1')" class="waves-effect waves-light btn" style="background-color: #229BFF; margin-top: 10% !important;" id=""><i class="material-icons left">&#xE2C0;</i>Descargar Soporte a Excel2</a> -->
		</div>
	</div>
	<div id="sub_nivel_1" style="width: 100% !important; height: 410px; margin-left: 0%!important;" class="grafica"></div>
	<div id="sub_nivel_3" style="width: 98% !important; height: 610px;" class="grafica">
		<div id="sub_nivel_21" style="width: 45% !important; height: 270px; float: left; margin-right: -15% !important;" class="grafica"></div>
		<div id="sub_nivel_22" style="width: 45% !important; height: 270px; float: right; margin-left: -10% !important;" class="grafica"></div>
		<div id="sub_nivel_24" style="width: 45% !important; height: 270px; float: left;" class="grafica"></div>
		<div id="sub_nivel_23" style="width: 45% !important; height: 270px; float: right;" class="grafica"></div>
	</div>
	<div class="titulos_secciones font" id="titulo_sub2" style="font-size:16pt !important; font-weight: 900 !important;"></div>
	<div id="sub_nivel_2" style="width: 100% !important; height: 1100px; margin-left: 0%!important;"></div>
</body>
</html>
<?
}else{//si no seleccionó por lo menos un registro en gerente de contrato o contratista  ?>
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
	.font{
		font-family: 'roboto';
	}
</style>
</head>
<body>
<style>
	.po_tabla_principal{
			
			border-radius: 10px 10px 10px 10px !important;
		-moz-border-radius: 10px 10px 10px 10px !important;
		-webkit-border-radius: 10px 10px 10px 10px !important;
		border: 0px solid #cccccc !important;
			
			-webkit-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		-moz-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
			
			border: 1px solid #CCCCCC !important;
			
		}
	</style>
	<br><br>
<table width="90%" border="0" align="center" class="po_tabla_principal">
   <tr>
      <td><div class="font" style="font-size:16pt !important; font-weight: 900 !important; padding: 10px;"><br>ATENCION GRAFICA POR PROVEEDOR: <br> <br>No se puede mostrar esta gr&aacute;fica porque debe filtrar por alguno de los siguientes criterios:<br><br>
		&nbsp;&nbsp;&nbsp;&#9679; Gerente de contrato<br>
		&nbsp;&nbsp;&nbsp;&#9679; Contrato<br>
		&nbsp;&nbsp;&nbsp;&#9679; Proveedor<br>
        </div></td>
    </tr>
 
</table>
</body>
</html>
<?}
?>