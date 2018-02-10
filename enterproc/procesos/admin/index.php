<?   include("../../librerias/lib/@session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
 <meta http-equiv="X-UA-Compatible" content="IE=9">
 <meta http-equiv="X-UA-Compatible" content="IE=10">
 <meta http-equiv="X-UA-Compatible" content="IE=11">
<title><?=TITULO;?></title>

<link href="css/reloj.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/milonic_src.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/mmenudom.js"></script>

<script type="text/javascript" src="../librerias/js/procesos_v3.js?acti=1"></script>
<? include("../../librerias/jquery/menu1/contenido_admin.php");?>

<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../librerias/js/popup.js"></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/jquery.ajaxQueue.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/thickbox-compressed.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/jquery.autocomplete.js' charset='iso-8859-1'></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/lib/thickbox.css" />

<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />


<script type="text/javascript" src="../librerias/jquery/popup/jquery.bpopup-0.6.0.min.js"></script>

<script type="text/javascript" src="../librerias/jquery/tooltips/jquery.tipTip.js"></script>
<script type="text/javascript" src="../librerias/jquery/tooltips/jquery.tipTip.minified.js"></script>


<link href="../../css/principal.css?act=2" rel="stylesheet" type="text/css">
<link href="../../css/estilo-principal.css?act=2" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">


<script type="text/javascript">


function close_va()
{
	$('#popup2').bPopup().close()
}

function msgbox(ruta)
	{
		
		
		 $(document).ready(function() {
	        
	        
	            $("#popup2").bPopup({  contentContainer: '#pContent', loadUrl: ruta });
	        
	    });

	}
function selecciona_lista(campo_seleccio){//PARA EL INC-0205

/************ 1 **********************/
if(document.getElementById("proveedor")){
    document.getElementById("proveedor").onchange=function() {
        var busca=document.getElementById("proveedor").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("proveedor").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("proveedor").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedor").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedor").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#proveedor").parent().append('<div id="gerente_confirma_asegu_div" style="width: 60%; margin: 0 auto; position: absolute; background: #fff;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000; margin-left: 40px;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/autocompleta.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedor").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #fff; color: #000; } div > #gerente_confirma_asegu_list:leave { display: none }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#proveedor").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                    li.addEventListener("mouseover",function(){
                        $("#proveedor").val($(this).text())
                    }); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#proveedor").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                  });
                    li.attachEvent("mouseover", function(){
                        $("#proveedor").val($(this).text())
                    });
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 2 **********************/
if(document.getElementById("articulos")){
    document.getElementById("articulos").onchange=function() {
        var busca=document.getElementById("articulos").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("articulos").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("articulos").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#articulos").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#articulos").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#articulos").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/autocompleta_articulos.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#articulos").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #fff; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#articulos").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                    li.addEventListener("mouseover",function(){
                    $("#articulos").val($(this).text())
                    }); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#articulos").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                  });
                    li.attachEvent("mouseover", function(){
                        $("#articulos").val($(this).text())
                    });
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 3 **********************/
if(document.getElementById("b_usuarios")){
    document.getElementById("b_usuarios").onchange=function() {
        var busca=document.getElementById("b_usuarios").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("b_usuarios").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("b_usuarios").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#b_usuarios").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#b_usuarios").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#b_usuarios").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/autocompleta_usuarios.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#b_usuarios").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #fff; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#b_usuarios").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                    li.addEventListener("mouseover",function(){
                    $("#b_usuarios").val($(this).text())
                    }); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#b_usuarios").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                  });
                    li.attachEvent("mouseover", function(){
                        $("#b_usuarios").val($(this).text())
                    });
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

}

    function selecciona_lista3() {

        $().ready(function() {

            function log(event, data, formatted) {
                $("<li>").html(!data ? "No match!" : "Selected: " + formatted).appendTo("#result");
            }

            function formatItem(row) {
                return row[0] + " (<strong>id: " + row[1] + "</strong>)";
            }
            function formatResult(row) {
                return row[0].replace(/(<.+?>)/gi, '');
            }



            /*$("#proveedor").autocomplete("../librerias/php/autocompleta.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });


  $("#articulos").autocomplete("../librerias/php/autocompleta_articulos.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });

  $("#b_usuarios").autocomplete("../librerias/php/autocompleta_usuarios.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });*/

           




        });

        function changeOptions() {
            var max = parseInt(window.prompt('Please type number of items to display:', jQuery.Autocompleter.defaults.max));
            if (max > 0) {
                $("#suggest1").setOptions({
                    max: max
                });
            }
        }

        function changeScrollHeight() {
            var h = parseInt(window.prompt('Please type new scroll height (number in pixels):', jQuery.Autocompleter.defaults.scrollHeight));
            if (h > 0) {
                $("#suggest1").setOptions({
                    scrollHeight: h
                });
            }
        }
function changeToMonths(){
	$("#suggest1")
		// clear existing data
		.val("")
		// change the local data to months
		.setOptions({data: months})
		// get the label tag
		.prev()
		// update the label tag
		.text("Month (local):");
		//alert(1)
}

}
</script>

<script type="text/javascript">

	function calendario_se(obje){
			$(function(){
				$('#' + obje).datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}

	function calendario_sin_hora(obje){
			$(function(){
				$('#' + obje).datepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd'

				});
			});
}

		</script>

<script>

function act_tollti(){

$(function(){

$(".someClass").tipTip({maxWidth: "auto", edgeOffset: 10});

});

}
	
	
/*funciones para la muestra de alertas*/
function muestra_alerta_general_desde_select(nombre_funcion, titulo, cuerpo, id_select){
	var texto_select=$('#'+id_select+' option:selected').text();
	var tipo_modal = "select";
	texto_select=texto_select.replace('\n', '');
	texto_select=texto_select.replace(/^\s+|\s+$/g, '');
	cuerpo=cuerpo.replace('<campo>', texto_select);
	cuerpo=cuerpo.replace(' ', '32323232');
	//alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_general_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
	
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_general_desde_ajax(ruta,div, titulo, cuerpo, id_select, tipo_modal){

	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+ruta+"&tipo_modal="+tipo_modal+"&div="+div, "div_carga_busca_sol");
}
	
	
	
function muestra_alerta_error(nombre_funcion, titulo, cuerpo, id_select){
    var texto_select=$('#'+id_select+' option:selected').text();
    var tipo_modal = "select";
    texto_select=texto_select.replace('\n', '');
    texto_select=texto_select.replace(/^\s+|\s+$/g, '');
    cuerpo=cuerpo.replace('<campo>', texto_select);
    cuerpo=cuerpo.replace(' ', '32323232');
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_error_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
	    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto_guardado_exito(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa_guarda_exito.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
	
$(document).ready(function() {
    $('.chips').material_chip();
});
/*FIN funciones para la muestra de alertas*/
</script>
<?

$nombre_ie_css = "chips-ms12";
?>
<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   // echo $u_agent;
  
  
  
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
    ?>
         <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
  
?>
</head>

<?
	/*
	
	function query_db_sql_server($query)
{
	$rs = mssql_query($query) ;
	if (!$rs) return 0;
	else return $rs;

}
function traer_fila_row_sql_server($rs)
{
	$row =  mssql_fetch_row($rs);
	return $row;
}
	
	function cual_es_el_reemplazo($id_usuario){
global $fecha;
		

		//echo "select id_reemplazo from tseg_reemplazos where estado = 1 and id_us = ".$id_usuario." and  desde_cuando <='".$fecha."' and hasta_cuando >= '".$fecha."'";
	$sel_reemplazo = traer_fila_row_sql_server(query_db_sql_server("select id_reemplazo from tseg_reemplazos where estado = 1 and id_us = ".$id_usuario." and  desde_cuando <='".$fecha."' and hasta_cuando >= '".$fecha."'" ));
	if($sel_reemplazo[0]>0){
		$id_usuario = $sel_reemplazo[0];
		}
	return $id_usuario;
		
	}*/

	/* FIN funcion de SGPA*/
	
	if($_POST["id_procurement_alerta"]!=""){
	
	$sql_b = traer_fila_row(query_db("select fecha_cierre, tp2_id, us_id_contacto from $t5 where pro1_id = ".$_POST["id_procurement_alerta"]));
	
	
	if ($sql_b[2]<> $_SESSION["id_us_session"] and $_SESSION["id_us_session"] <> cual_es_el_reemplazo($sql_b[2])) 
	
		{
			 $busca_invitaciones = "select distinct pro1_id from v_vista_invitados_observadores where pro1_id = ".$_POST["id_procurement_alerta"]." and  us_id = ".$_SESSION["id_us_session"]." and estado = 1";	
				$sql_invitados = mysql_fetch_row(mysql_query($busca_invitaciones));
					
					if($sql_invitados[0]>=1)
						{
								$boton_ingreso="evaluacion/detalle_invitacion.php";		
							
							}
			
			
			
			
			}
	
	else{
		 if ( ($sql_b[0]<= $fecha." ".$hora) && ($sql_b[1]>=1) ) 
		    
			{//SI LICITACION
					$boton_ingreso="visualiza_proceso.php";
			}	
		else{
		 		    $boton_ingreso="crea_proceso.php";
					
					}
	}
		
?>
<body onLoad="ajax_carga('../aplicaciones/<?=$boton_ingreso;?>?id_p=<?=$_POST["id_procurement_alerta"];?>','contenidos')">

<?
	} else{
?>
<body onLoad="ajax_carga('../aplicaciones/historico_procesos.php?tipo_ingreso_alerta=1','contenidos')">
<?
global $texto_modulo_pruebas;
echo $texto_modulo_pruebas?>
<? } 



/*------------------validador o gestion abastecimiento el rol ------------------*/

/*SI TUVIERA CONEXION CON SQL SERVER ESTE ES EL QUERY PARA SABER SI EL USUARIO TIENE PERMISO DE VALIDADOR ABASTECIMIENTO, PARA QUE PUEDA CREAR URNAS Y DEMAS PERMISOS QUE NO PUEDE HACER EL TIPO USUARIO 4
echo "select count(*) from tseg5_usuario_permisos where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44";
$sele_permiso_validador_abaste = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos234 where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44"));
if($sele_permiso_validador_abaste[0]>0){
$es_validador_abastecimiento = "SI";
}
*/

if($_SESSION["id_us_session"]==29){// COMO NO SE TIENE CONEXION CON SQL SERVER ENTONCES TOCA PONER LOS PERMISOS MANUALMENTE A LOS ID DE USUARIOS DE DELOITTE
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==57){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18194){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18579){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==19791){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==20296){
$es_validador_abastecimiento = "SI";
}else{
$es_validador_abastecimiento = "NO";
}


/*------------------validador o gestion abastecimiento el rol ------------------*/

?>



<?=banner();?>
<form name="principal" method="post" enctype="multipart/form-data">

  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="200px" valign="top">
    <table width="218" border="0" align="left" cellpadding="2" cellspacing="2">
    <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">0</div></td>
        <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='../../sistema-sgpa/administracion.html'"><div align="left">Menu SGPA</div></td>
        </tr>
  
  
    <? if(($_SESSION["tipo_usuario"]!=4) && ($_SESSION["tipo_usuario"]!=10 and $_SESSION["id_us_session"]!=22759 and $_SESSION["id_us_session"]!=32) or ($es_validador_abastecimiento == "SI" or $_SESSION["id_us_session"] ==22070) ){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso.</div></td>
      </tr>
    <? } ?>
    
     <? if($_SESSION["id_us_session"]==19927){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso</div></td>
      </tr>
    <? } ?>

     <? if($_SESSION["id_us_session"]==18194){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso</div></td>
      </tr>
    <? } 
        ?>
       <tr>
        <td class="fondo_1"><div align="center">2</div></td>
        <td class="fondo_2"  onclick="ajax_carga('historico-proceso_0.html','contenidos')"><div align="left">Procesos activos<br /></div></td>
      </tr>
      <?
											   if ( $_SESSION["id_us_session"]!=22759){?>
		
       <tr>
        <td class="fondo_1"><div align="center">3</div></td>
        <td class="fondo_2"  onclick="ajax_carga('../aplicaciones/historico_procesos_todos.php','contenidos')"><div align="left">Historico todos los procesos</div></td>
      </tr>

<? 
																					  }
		if(($_SESSION["tipo_usuario"]!=4) && ($_SESSION["tipo_usuario"]!=10) and $_SESSION["id_us_session"]!=22759 or ($es_validador_abastecimiento == "SI") or ($_SESSION["id_us_session"] ==17968  or $_SESSION["id_us_session"] ==22070 or $_SESSION["id_us_session"] ==7)){?>
      <tr>
        <td class="fondo_1"><div align="center">4</div></td>
        <td class="fondo_2" onClick="ajax_carga('historico-proveedores.html','contenidos')"><div align="left">Admin. proveedores</div></td>
      </tr>
      
      <tr>
        <td class="fondo_1"><div align="center">5</div></td>
        <td class="fondo_2" onClick="ajax_carga('alerta-bitacora.html','contenidos')"><div align="left">Alertas bitacora</div></td>
      </tr>
      
<? } if($_SESSION["id_us_session"]==22759){?>
      <tr>
        <td class="fondo_1"><div align="center">4</div></td>
        <td class="fondo_2" onClick="ajax_carga('historico-proveedores.html','contenidos')"><div align="left">Admin. proveedores</div></td>
      </tr>
 
 

 
  
      <tr>
        <td align="center" class="fondo_1">6</td>
        <td class="fondo_2" onClick="ajax_carga('soporte-tecnico.html','contenidos')"><div align="left">Soporte t&eacute;cnico</div></td>
      </tr>
      <?

		?>
      <? } if ($_SESSION["tipo_usuario"]==1) {?>   
      <tr>
        <td class="fondo_1"><div align="center">7</div></td>
        <td class="fondo_2" onClick="ajax_carga('panel-control.html','contenidos')"><div align="left">Panel de control</div></td>
      </tr>
<? } 

if ( ($_SESSION["id_us_session"]==1) || ($_SESSION["id_us_session"]==18122)){?>      
      <tr>
        <td class="fondo_1"><div align="center">7</div></td>
        <td class="fondo_2" onClick="ajax_carga('panel-control.html','contenidos')"><div align="left">Panel de control</div></td>
      </tr>
      
<? }       

if ( $_SESSION["id_us_session"]!=22759){?>
      
 

      <tr>
        <td class="fondo_1"><div align="center">8</div></td>
        <td class="fondo_2" onClick="ajax_carga('../aplicaciones/reportes/re1.php','contenidos')"><div align="left">Reportes estados procesos</div></td>
      </tr>
      <? } ?>  

    </table></td>
    <td width="100%" valign="top"  class="contenido_principal_de_trabajo" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="95%" align="left" id="contenidos">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>


<input type="hidden" name="accion" />  

<script>
function cambia_fecha_srev(i)
		{
//
			if(i>=5)
				{
				//alert(i)
				ajax_carga_02('muestra-reloj_ad.php','reloj_general');
					i=0;
				}
			i++;
			y=i	
			setTimeout("cambia_fecha_srev(y)",1000);		
		}
		
//cambia_fecha_srev(1)
</script>


</form>
<?

$tam=0;
if($_SESSION["id_us_session"]==18131){
	$tam=800;
	}

			
?>
<iframe name="grp" frameborder="0" height="<?=$tam?>" width="<?=$tam?>"></iframe>
<div id="div_carga_busca_sol"  style="display:none"></div>
</body>
</html>
