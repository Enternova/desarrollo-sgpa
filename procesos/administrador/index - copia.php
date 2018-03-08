<? 
    //error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");

	       $numero_get = valida_get();
		   $numer = numero_ingresos_get();

$id_log = log_de_procesos_sgpa(6, 1, 0, 0, "", "");


$alerta_de_archivos = '<br /><strong class="letra-descuentos">El SGPA recibe archivos de máximo 10MB</strong>';
$_SESSION["alerta_de_archivos"] = $alerta_de_archivos;

$version_js = str_replace("-", "", elimina_comillas_2($fecha))."_gt11";
$vervion_variable = "_fr45";

$_SESSION["gestor_abste"] = 0;

/*$instruccion = "select * from v_mesa_ayuda_princiapal  where us_id = ".$_SESSION["id_us_session"]." and estado = 2 and estado_firme = 1 and '$fecha $hora' BETWEEN  inicio_vigencia and final_vigencia";
$cuenta_novedades = traer_fila_row(query_db($instruccion));
*/
/******PARA NOTIFICACIONES PUSH**********/
//$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
//$encrypted =codifica_md5($_SESSION["id_us_session"]);
//$numero_notificaciones=10;
/******PARA NOTIFICACIONES PUSH**********/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<!--- link href="../css/roboto.css" rel="stylesheet" type="text/css" /   -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
 <meta http-equiv="X-UA-Compatible" content="IE=9">
 <meta http-equiv="X-UA-Compatible" content="IE=10">
 <meta http-equiv="X-UA-Compatible" content="IE=11">
<title><?=TITULO;?></title>
<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/DataTables/media/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="../librerias/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/js/puntos.js"></script>
<script type="text/javascript" src="../librerias/js/procesos_generales.js?version<?=$version_js?>=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/contratos_admin.js?version=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/pecc-item_admin.js?version<?=$vervion_variable?>=<?=$version_js?>" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/comite_admin.js?version=<?=$version_js?>" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/tarifas_admin.js?version=<?=$version_js?>14"></script>
<script type="text/javascript" src="../librerias/js/indicador_admin.js?version=<?=$version_js?>" charset="utf-8"></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/jquery.ajaxQueue.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/thickbox-compressed.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/jquery.autocomplete.js' charset='iso-8859-1'></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/lib/thickbox.css" />
<script type="text/javascript" src="../librerias/js/procesos_manuales.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<link href="../librerias/js/alertas/jquery.alerts.css" rel="StyleSheet" type="text/css" />
	<script src="../librerias/js/alertas/jquery.ui.draggable.js" type="text/javascript"></script>
	<script src="../librerias/js/alertas/jquery.alerts.mod.js" type="text/javascript"></script>


<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>



<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />



<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">


<script type="text/javascript">
var cont_push=0; var total_push=0;
function modal_lanza(){
$(function() {
$('a[rel*=leanModal222]').leanModal({ top : 200 });
});
}


</script>




<script>



if(history.forward(1)){
// history.replace(history.forward(1));
alert("aqui")
 }
 

/*funcion para seleccionar lista*/
function selecciona_lista_general_irre(id,ruta)
{
/*
$().ready(function() {

    $('.modal').modal();
  Materialize.updateTextFields();
  $('.materialboxed').materialbox();
  $('select').material_select('destroy');
  $('.button-collapse').sideNav({
    menuWidth: 300, // Default is 300
    edge: 'left', // Choose the horizontal origin
    closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    draggable: true // Choose whether you can drag to open on touch screens
  });
});
*/
  

function log(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}

	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	


	$("#" + id).autocomplete(ruta, {
		
		width: 660,
		selectFirst: true,
		max: 1000,
		scroll: true,
		scrollHeight: 300,
		autoFill: false	,
		multiple: true,
		mustMatch: true,
		matchContains: true
	
	});
	
	

}
function selecciona_lista(campo_seleccio){//PARA EL INC-0205

/************ 1 **********************/
if(document.getElementById("gerente_confirma_asegu")){
    document.getElementById("gerente_confirma_asegu").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente_confirma_asegu").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente_confirma_asegu").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente_confirma_asegu").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente_confirma_asegu").val(), q2:coma},
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
                    $("#gerente_confirma_asegu").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#gerente_confirma_asegu").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
if(document.getElementById("categoria_busca")){
    document.getElementById("categoria_busca").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#categoria_busca").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#categoria_busca").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#categoria_busca").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_categorias.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#categoria_busca").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#categoria_busca").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#categoria_busca").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
if(document.getElementById("proveedores_busca_adjudicacion")){
    document.getElementById("proveedores_busca_adjudicacion").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca_adjudicacion").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca_adjudicacion").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#proveedores_busca_adjudicacion").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_en_par_servicios.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca_adjudicacion").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#proveedores_busca_adjudicacion").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#proveedores_busca_adjudicacion").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
/************ 4 **********************/
if(document.getElementById("proveedores_busca")){
    document.getElementById("proveedores_busca").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#proveedores_busca").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#proveedores_busca").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#proveedores_busca").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
/************ 5 **********************/
if(document.getElementById("busca_id_responsable")){
    document.getElementById("busca_id_responsable").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_responsable").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_responsable").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_id_responsable").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_responsable").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#busca_id_responsable").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#busca_id_responsable").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
/************ 6 **********************/
if(document.getElementById("busca_id_cierre")){
    document.getElementById("busca_id_cierre").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_cierre").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_cierre").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_id_cierre").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_cierre").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#busca_id_cierre").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#busca_id_cierre").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
/************ 7 **********************/
if(document.getElementById("busca_id_comite")){
    document.getElementById("busca_id_comite").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_comite").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_comite").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_id_comite").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_comite.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_comite").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#busca_id_comite").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#busca_id_comite").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
/************ 8 **********************/
if(document.getElementById("busca_id_solicitud")){
    document.getElementById("busca_id_solicitud").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_solicitud").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_solicitud").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_id_solicitud").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_id_solicitud.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_solicitud").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#busca_id_solicitud").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#busca_id_solicitud").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
if(document.getElementById("contratos_normales")){
    if(campo_seleccio=="infomativo"){
        /************ 9 **********************/
        document.getElementById("contratos_normales").onkeyup=function(evt) {
            //alert(evt.keyCode)
            var coma=$("#contratos_normales").val()
            coma=coma.replace(" ",", ");
            var cadena1=""
            $("#contratos_normales").empty();
            if($('#gerente_confirma_asegu_list').length==0){
                $("#contratos_normales").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
                $("#gerente_confirma_asegu_div").mouseleave(function (){
                    $("#gerente_confirma_asegu_div").css('display', 'none')
                });
            }
            $.ajax({
                url: '../librerias/php/contratos_normales_y_marco.php',
                type: 'POST',
                dataType: 'html',
                data: {q:$("#contratos_normales").val(), q2:coma},
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
                    var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                    var style = document.createElement("style");
                    style.appendChild(
                        document.createTextNode(style_text)
                    );
                    document.querySelector("head").appendChild(style);
                    var li=document.createElement('li');
                    li.id=id_li;
                    if (li.addEventListener) {  // all browsers except IE before version 9
                      li.addEventListener("click",function(){
                        $("#contratos_normales").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                      });
                    } else {
                      if (li.attachEvent) {   // IE before version 9
                        li.attachEvent("click", function(){
                            $("#contratos_normales").val($(this).text())
                            $('#gerente_confirma_asegu_list').css('display', 'none')
                            //alert(this.id)
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
    }else{
        
    /************ 10 **********************/
        document.getElementById("contratos_normales").onkeyup=function(evt) {
            //alert(evt.keyCode)
            var coma=$("#contratos_normales").val()
            coma=coma.replace(" ",", ");
            var cadena1=""
            $("#contratos_normales").empty();
            if($('#gerente_confirma_asegu_list').length==0){
                $("#contratos_normales").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
                $("#gerente_confirma_asegu_div").mouseleave(function (){
                    $("#gerente_confirma_asegu_div").css('display', 'none')
                });
            }
            $.ajax({
                url: '../librerias/php/contratos_normales_no_marco.php',
                type: 'POST',
                dataType: 'html',
                data: {q:$("#contratos_normales").val(), q2:coma},
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
                    var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                    var style = document.createElement("style");
                    style.appendChild(
                        document.createTextNode(style_text)
                    );
                    document.querySelector("head").appendChild(style);
                    var li=document.createElement('li');
                    li.id=id_li;
                    if (li.addEventListener) {  // all browsers except IE before version 9
                      li.addEventListener("click",function(){
                        $("#contratos_normales").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                      });
                    } else {
                      if (li.attachEvent) {   // IE before version 9
                        li.attachEvent("click", function(){
                            $("#contratos_normales").val($(this).text())
                            $('#gerente_confirma_asegu_list').css('display', 'none')
                            //alert(this.id)
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


/************ 11 **********************/
if(document.getElementById("usuario_permiso")){
    document.getElementById("usuario_permiso").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#usuario_permiso").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#usuario_permiso").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#usuario_permiso").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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


/************ 12 **********************/
if(document.getElementById("gerente")){
    document.getElementById("gerente").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#gerente").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#gerente").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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


/************ 12 **********************/
if(document.getElementById("usuario_permiso2")){
    document.getElementById("usuario_permiso2").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso2").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso2").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#usuario_permiso2").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso2").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#usuario_permiso2").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#usuario_permiso2").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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


/************ 13 **********************/
if(document.getElementById("partecnico_bus_us")){
    document.getElementById("partecnico_bus_us").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#partecnico_bus_us").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#partecnico_bus_us").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#partecnico_bus_us").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#partecnico_bus_us").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#partecnico_bus_us").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#partecnico_bus_us").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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


/************ 14 **********************/
if(document.getElementById("gerente_contrato_bus_us")){
    document.getElementById("gerente_contrato_bus_us").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente_contrato_bus_us").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente_contrato_bus_us").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente_contrato_bus_us").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente_contrato_bus_us").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#gerente_contrato_bus_us").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#gerente_contrato_bus_us").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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

/************ 15 **********************/
if(document.getElementById("busca_solicitud")){
    document.getElementById("busca_solicitud").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_solicitud").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_solicitud").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_solicitud").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_solicitudes.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_solicitud").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#busca_solicitud").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#busca_solicitud").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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

/************ 16 **********************/
if(document.getElementById("llena_lista_sondeos_l")){
    document.getElementById("llena_lista_sondeos_l").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#llena_lista_sondeos_l").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#llena_lista_sondeos_l").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#llena_lista_sondeos_l").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_solicitudes_sondeo.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#llena_lista_sondeos_l").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#llena_lista_sondeos_l").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#llena_lista_sondeos_l").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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

/************ 17 **********************/
if(document.getElementById("tarifas_busca_contratos")){
    document.getElementById("tarifas_busca_contratos").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#tarifas_busca_contratos").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#tarifas_busca_contratos").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#tarifas_busca_contratos").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_contratos.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#tarifas_busca_contratos").val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#tarifas_busca_contratos").val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#tarifas_busca_contratos").val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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

/************ 18 **********************/
if(document.getElementById("" + campo_seleccio)){
    document.getElementById("" + campo_seleccio).onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#" + campo_seleccio).val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#" + campo_seleccio).empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#" + campo_seleccio).parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_contratos.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#" + campo_seleccio).val(), q2:coma},
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
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("click",function(){
                    $("#" + campo_seleccio).val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#" + campo_seleccio).val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
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
 function selecciona_lista3(campo_seleccio) {

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


	/*nombre y ajax del campo a buscar	
            $("#categoria_busca").autocomplete("../librerias/php/tarifas_autocompleta_categorias.php", {

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
			
	/*nombre y ajax del campo a buscar*/

	/*cargar_PROVEEDORES EN PAR SERVICIOS*
            $("#proveedores_busca_adjudicacion").autocomplete("../librerias/php/proveedores_en_par_servicios.php", {

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
			
	/*cargar_PROVEEDORES EN PAR SERVICIOS*/
	/*cargar_PROVEEDORES EN GENERAL
            $("#proveedores_busca").autocomplete("../librerias/php/proveedores_general.php", {

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
			
	/*cargar_PROVEEDORES EN GENERAL*/
	/*cargar_usuarios_general
  $("#busca_id_responsable").autocomplete("../librerias/php/usuarios_general.php", {

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
  $("#busca_id_cierre").autocomplete("../librerias/php/usuarios_general.php", {

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
  $("#busca_id_comite").autocomplete("../librerias/php/busca_comite.php", {

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
  $("#busca_id_solicitud").autocomplete("../librerias/php/busca_id_solicitud.php", {

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

            $("#usuario_permiso").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			 $("#gerente").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			/*$("#gerente_confirma_asegu").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			$("#usuario_permiso2").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			$("#partecnico_bus_us").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			$("#gerente_contrato_bus_us").autocomplete("../librerias/php/usuarios_general.php", {

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
			
			$("#busca_solicitud").autocomplete("../librerias/php/busca_solicitudes.php", {

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
			
			$("#llena_lista_sondeos_l").autocomplete("../librerias/php/busca_solicitudes_sondeo.php", {

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
			
	/*cargar_usuarios_general*/
	
	/*CARGAR CONTRATOS NORMALES NO MARCOS

	if(campo_seleccio=="infomativo"){
            $("#contratos_normales").autocomplete("../librerias/php/contratos_normales_y_marco.php", {

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
	}else{
		$("#contratos_normales").autocomplete("../librerias/php/contratos_normales_no_marco.php", {

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
		}
			
	/*FIN CARGAR CONTRATOS NORMALES NO MARCOS*/
	
	/*nombre y ajax del campo a buscar
            $("#tarifas_busca_contratos").autocomplete("../librerias/php/tarifas_autocompleta_contratos.php", {

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
	/*nombre y ajax del campo a buscar*/	

	/*nombre y ajax del campo a buscar tarifas maestras*/	
            $("#" + campo_seleccio).autocomplete("../librerias/php/tarifas_autocompleta_tarifas_maestras.php", {

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
	/*nombre y ajax del campo a buscar*/		
	
	   });


	   
	}
			


/*funcion para seleccionar lista poner el id del campo*/	

/*funcion para calendario*/
	function calendario_se(obje){
			$(function(){
				$('#' + obje).datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}	
function hora(obje){
            $(function(){
                $('#' + obje).datetimepicker({
                    dateFormat: '',
                    timeFormat: 'hh:mm tt'


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
/*funcion para cambiar id del comite en tareas-comite*/
function cambia_id_comite(){
  var cadena=$('#busca_id_comite').val();
  var arrid=cadena.split(',');

  $('#id_comite').val(arrid[5]);
}

/*funcion para cambiar id de la solicitud en tareas-comite*/
function cambia_id_comite(){
  var cadena=$('#busca_id_solicitud').val();
  var arrid=cadena.split(',');

  $('#id_solicitud').val(arrid[5]);
}
/*funcion para cambiar id de la solicitud en edicion-comite-tareas*/
function cambia_id_solicitud(){
  var cadena=$('#busca_id_solicitud').val();
  var arrid=cadena.split(',');
  alert(arrid[5]);
  $('#modifica_solicitud').val(arrid[5]);
}
/*funcion para calendario*/
function mueve(){
alert(document.datos2.scrollLeft)
}

function abrir_ventana(pagina) {

 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
 window.open(pagina,"",opciones);
 }
 
 
 
function valida_grega_solicitud(){
  if ($("#agrega_solicitud").is(":checked")) {
    $("#busca_id_solicitud").attr('disabled', false);
    $("#modifica_busca_id_solicitud").attr('disabled', false);
  }else {
    $("#busca_id_solicitud").attr('disabled', true);
    $("#modifica_busca_id_solicitud").attr('disabled', true);
    $("#busca_id_solicitud").val('');
    $("#modifica_busca_id_solicitud").val('');
  }
}

//function area_edicion_texto(){
	


</script>
<script type="text/javascript" src="../librerias/jquery/tinymce_4.1.7_jquery/js/tinymce/tinymce.min.js"></script>


<script type="text/javascript">


function carga_texto_avanzado(){
	
	var navegador = navigator.userAgent;
  if (navigator.userAgent.indexOf('MSIE') !=-1) {
    
  } else {
    tinymce.remove();	
  }

tinymce.init({
	//script_url : '../librerias/tinymce_4.1.7_jquery/js/tinymce/tinymce.min.js',
    selector: "textarea.tinymce",
	menubar: false,
	language : 'es',
	plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor fullscreen code preview"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fullscreen | print | paste | code | preview ", 
 });
	
}
		
function funcionando()
{//funcion para notifiaciones push            
    $.post('../librerias/php/verifica_notificacion.php', {cadena: '<?=$encrypted?>'}, function(data) {
        var data2=JSON.parse(data);
        var total_sin=data2.total_sin;
        var total_todo=data2.total_todo;
        if(total_sin.total_sin!=0){
            var pendientes=data2.pendiente;
            $('#close_message_id').val(pendientes.id_sin);
            $('#action').val(pendientes.id_sin);
            /*if(total_todo.total_todo>1){
                $('#more').css('display', 'block');
            }else{
                $('#more').css('display', 'none');
            }
			
			'<tr><td><div class="light-blue" class="div_carga_push" style="display: none;"><div class="close-pending" onclick="cerrar_push('+todo['id']+')"><i class="material-icons">&#xE5CD;</i><input type="hidden" name="close_message_id" id="close_message_id" value="'+todo['id']+'"></div><div class="content-pending">'+todo['mensaje']+'</div><div class="footer-pending"><button class="action-pending" onclick="leer_push(this.value)" value="'+todo['id']+'">OK</button></div></div></td></tr>'
			
			*/			
            $('.table_caraga_push').empty();
			//console.log(data2.pendiente);
			for(var i in data2.pendiente){
                //total_push++;
                var todo=data2.pendiente[i];
				//console.log(todo['id']+'---'+todo['mensaje'])
				$('.table_caraga_push').append('<tr><td><div class="light-blue" class="div_carga_push"><div class="close-pending" onclick="cerrar_push('+todo['id']+')"><i class="material-icons">&#xE5CD;</i><input type="hidden" name="close_message_id" id="close_message_id" value="'+todo['id']+'"></div><div class="content-pending">'+todo['mensaje']+'</div><div class="footer-pending"><button class="action-pending" onclick="leer_push(this.value)" value="'+todo['id']+'">OK</button></div></div></td></tr>');
                //$('#carga-hystory').append('<div id="'+todo['id']+'"><a href="javascript:confirma_push('+todo['id']+')"><i class="material-icons">&#xE913;</i></a>'+todo['mensaje']+'</div>');
                //$('#carga-hystory').append('<div class="divider'+todo['id']+'"></div>');
                //console.log(i.id+'--'+i.ruta+'--'+i.tipo+'--'+i.mensaje+'\n')
            }
            $('.table_caraga_push').append('<tr><td>asdfsadf</td></tr>');
            $('.table_caraga_push').css('display', 'block');
        }else{
            $('.table_caraga_push').css('display', 'none');
        }
        if(total_todo.total_todo!=0){
            if(cont_push==0){
                $('#muestra-notifiaciones').empty();
                $('#muestra-notifiaciones').append('<i class="material-icons md-8">&#xE7F4;</i>');
                cont_push++;
            }else{
                $('#muestra-notifiaciones').empty();
                $('#muestra-notifiaciones').append('<i class="material-icons md-8">&#xE7F7;</i>');
                cont_push=0;
            }
            $('#carga-hystory').empty();
            total_push=0;
            for(var i in data2.todo){
                total_push++;
                var todo=data2.todo[i];
                $('#carga-hystory').append('<div id="'+todo['id']+'"><a href="javascript:confirma_push('+todo['id']+')"><i class="material-icons">&#xE913;</i></a>'+todo['mensaje']+'</div>');
                $('#carga-hystory').append('<div class="divider'+todo['id']+'"></div>');
                //console.log(i.id+'--'+i.ruta+'--'+i.tipo+'--'+i.mensaje+'\n')
            }

            $('#muestra-notifiaciones').css('display', 'block');
        }else{            
            $('#muestra-notifiaciones').css('display', 'none');
        }
    });
    //timeout=setTimeout("funcionando()",1000);
}
function cerrar_push(){
    //alert($('#close_message_id').val())
    var val=$('#close_message_id').val();
    $.post('../librerias/php/verifica_notificacion.php', {action: 'lee', cadena: '<?=$encrypted?>', value: val}, function(data) {
        //alert(data)
    });
    $('.table_caraga_push').css('display', 'none')
}
function leer_push(val){
    //alert(val)
    $.post('../librerias/php/verifica_notificacion.php', {action: 'lee', cadena: '<?=$encrypted?>', value: val}, function(data) {
        //alert(data)
    });
    $('.table_caraga_push').css('display', 'none')
}
function confirma_push(id){
    //alert(id)
    total_push--;
    //alert(total_push)
    if(total_push==0){
        $('#carga-hystory').css('display', 'none');
    }
    $.post('../librerias/php/verifica_notificacion.php', {action: 'gestiona', cadena: '<?=$encrypted?>', value: id}, function(data) {
        //alert(data)
    });
}
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
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+ruta+"&tipo_modal="+tipo_modal+"&div="+div, "div_carga_busca_sol");
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
</script>
<?
$nombre_ie_css = "chips-ms12";
?>
<link href="../css/estilo-principal.css?version=<?=$hora?>" rel="stylesheet" type="text/css" />

<?=$texto_modulo_pruebas?>
<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   // echo $u_agent;
	
	
	
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
		?>
         <link rel="stylesheet" type="text/css" href="../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
	
?>
</head>
<?
if($_SESSION["id_us_session"]==18245 or $_SESSION["id_us_session"]==19401){
	$link_alertas="ajax_carga('../procesos/administrador/alertas_elaboracion.php','carga_alertas')";
/*}elseif($_SESSION["id_us_session"]==57){
	$link_alertas="ajax_carga('../procesos/administrador/alertas.php','carga_alertas')";
	*/}else{
		$link_alertas="ajax_carga('../procesos/administrador/alertas_sin_elaboracion.php','carga_alertas')";
		

		}
	
		
?>


<body onload="<?=$link_alertas?>; <? if ($cuenta_novedades[0]>=1) { ?> document.getElementById('cargando_noticias_inbox').style.display = ''; <? } ?>funcionando()" >

<table class="table_caraga_push" width="25%"></table>



<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando-20seg.gif" width="320" height="250" /></td></table></div>

<div id="div_carga_busca_sol"  style="display:none"></div>



<?=banner();?>
<form name="principal" method="post" enctype="multipart/form-data">


<table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>
    <td width="1" valign="top" id="contenido_menu">
      <table width="187" border="0" cellspacing="2" cellpadding="2">
    <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='administracion.html'"><div align="left">Men&uacute; SGPA</div></td>
        </tr>
        <!--
    <tr>
      <td class="fondo_1" align="center">1</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-pecc.html','contenido_menu')"><div align="left">Modulo PECC</div></td>
    </tr>
    -->



    <? if($_SESSION["id_us_session"] != 21932){?>
    <tr>
      <td class="fondo_1" align="center">2</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-item.html','contenido_menu')"><div align="left">M&oacute;dulo SOLICITUDES</div></td>
    </tr>
    <? } ?>
    <?
        $query="select count(t1.nombre_administrador) as total from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2 where t1.us_id=t2.id_usuario and t1.estado=1 and t2.id_rol_general in(13, 17, 23, 30, 11, 24, 6) and t1.us_id=".$_SESSION["id_us_session"];
        $total=traer_fila_row(query_db($query));
        if($total[0]!=0){
    ?>
    <tr>
      <td class="fondo_1" align="center">3</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-comite.html','contenido_menu')"><div align="left">M&oacute;dulo COMITE</div></td>
    </tr>
    <? }
     if($_SESSION["id_us_session"] != 21932){?>
    <tr>
      <td class="fondo_1" align="center">4</td>
      <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='../enterproc/administracion-general/principal.html'"><div align="left">M&oacute;dulo URNA VIRTUAL</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">5</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-contratos.html','contenido_menu')"><div align="left">M&oacute;dulo CONTRATOS</div></td>
    </tr>
    <? } ?>
    
    <tr>
      <td class="fondo_1" align="center">6</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-tarifas.html','contenido_menu')"><div align="left">M&oacute;dulo TARIFAS</div></td>
      <!--<td colspan="2" align="center" class="fondo_2"onclick="alert('En este momento nos encontramos trabajando en este modulo. Para mejorar la velocidad. Este servicio se restaurara el dia 11 de marzo de 2015 a las 8 am.')"><div align="left">Modulo TARIFAS</div></td>-->
    </tr>
      <? if($_SESSION["id_us_session"] != 21932){?>
        <tr>
          <td class="fondo_1" align="center">7</td>
          <td class="fondo_2" onClick="taer_menu('menu-indicador.html','contenido_menu')">M&oacute;dulo REPORTES</td>
        </tr>
        
         <?
		 
	  }

	  $sele_permiso_profesional = traer_fila_row(query_db("select count(*) from $v_seg1 where us_id in (".$_SESSION["usuarios_con_reemplazo"].") and id_premiso = 8"));
	  
	   if($sele_permiso_profesional[0]>0 or $_SESSION["id_us_session"] == "32"  or $_SESSION["id_us_session"] == "4" or $_SESSION["id_us_session"] == "7" or $_SESSION["id_us_session"] == "30"  or $_SESSION["id_us_session"] == "21107"  ){//si es profesional
	  ?>
	  <tr>
           <td class="fondo_1" align="center">&nbsp;</td>
           <td class="fondo_2" onClick="ajax_carga('../aplicaciones/pecc/reemplazos_de_index.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>','contenidos')">ADM. Reemplazos</td>
         </tr>
	  <?
	   }
    if($_SESSION["id_us_session"]==32){  
	?>
         
         <tr>
           <td class="fondo_1" align="center">&nbsp;</td>
           <td class="fondo_2" onClick="ajax_carga('../aplicaciones/administracion/administracion-tp_proceso.php','contenidos')">ADM. Tp Procesos</td>
         </tr>
         <tr>
           <td class="fondo_1" align="center">&nbsp;</td>
           <td class="fondo_2" onClick="ajax_carga('../aplicaciones/administracion/administracion-areas.php','contenidos')">ADM. Areas</td>
         </tr>
         <tr>
          <td width="17%" class="fondo_1" align="center">&nbsp;</td>
          <td width="83%" class="fondo_2" onClick="ajax_carga('../aplicaciones/administracion/admin_usuario.php','contenidos')">ADM. usuarios</td>
        </tr>
         <tr>
          <td width="17%" class="fondo_1" align="center">&nbsp;</td>
          <td width="83%" class="fondo_2" onClick="ajax_carga('../aplicaciones/mesa-ayuda/historico_manual.php','contenidos')">ADM. manuales</td>
        </tr>

<!--
        <tr>
          <td class="fondo_1"><div align="center">9</div></td>
          <td class="fondo_2">Admin. proveedores</td>
        </tr>
       
    
   
        <tr>
          <td class="fondo_1"><div align="center">9</div></td>
          <td class="fondo_2" onClick="ajax_carga('../aplicaciones/administracion/maestras.php','carga_alertas')">Admin. maestras</td>
        </tr>
       -->  
 <?
	}
if($_SESSION["id_us_session"]==69 or $_SESSION["id_us_session"]==32){        
		?>
        <tr>
          <td class="fondo_1"><div align="center"></div></td>
          <td class="fondo_2" onClick="ajax_carga('../aplicaciones/administracion/subir_correo_ot_contratista.php','carga_alertas')">ADM. correos OT</td>
        </tr>
        <?
}


			
			
			// else para el nuevo perfil de compra de crudo
			 
if($es_local=="NO"){
		?>
        <tr>
          <td class="fondo_1"><div align="center"></div></td>
          <td class="fondo_2" onClick="window.parent.location.href='../'">Salida Segura</td>
        </tr>
        <?
}

		?>
    </table>
    
    <div id="id_div_sub"></div>
    
    </td>
    <td width="100%" valign="top" ><div id="carga_alertas"></div><div id="carga_noticias"></div></td>
  </tr>
  <tr>
    <td colspan="2">
    


    
    </td>
  </tr>
</table>

<div  class="fondo_cabecera">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="../imagenes/coorporativo/logo final-01.png" width="133" height="36" /></td>
          <td class="letra_azul_pequena">Si tiene problemas con la funcionalidad del sistema por favor comun&iacute;quese al PBX (57 1 381 65 21),
Dise&ntilde;ado y Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</div>
<input type="hidden" name="accion" />
<input type="hidden" name="id_procurement_alerta" />
</form>



<?

$tam=0;
if($_SESSION["id_us_session"]==32 ){
	$tam=800;
	}
				

?>

<iframe name="grp" frameborder="0" height="<?=$tam?>" width="<?=$tam?>"></iframe>
<div class="carga-chips"><h4></h4></div>


</body>
</html>
