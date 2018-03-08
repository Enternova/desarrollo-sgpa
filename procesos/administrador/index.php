<? 
    //error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");
require_once('../../librerias/php/alertas_contratos_llena_push.php');
	busca_contratos($_SESSION["id_us_session"]);
	       $numero_get = valida_get();
		   $numer = numero_ingresos_get();
	
$id_log = log_de_procesos_sgpa(6, 1, 0, 0, "", "");
/******* VERIFICAR ESTADO DE SOLCITUD PARA NOTIFICACIONES PUSH *****/
$query_alertas=query_db("select id_solicitud, id, dias from  alertas_push where id_solicitud is not null and estado <> 4 AND id_usuario=".$_SESSION["id_us_session"]);
while ($s_actual = traer_fila_db($query_alertas)) {
  $sel_item=traer_fila_row(query_db("select id_item, estado, id_us, id_us_profesional_asignado from t2_item_pecc where id_item=".$s_actual[0]));
  if($sel_item[1]>20){
    $update_alert="update alertas_push set estado=4 where id_solicitud=".$s_actual[0];
    $update=query_db($update_alert);
  }elseif($sel_item[2]!=$_SESSION["id_us_session"] and  $sel_item[3]!=$_SESSION["id_us_session"]){
    $update_alert="update alertas_push set estado=4 where id_solicitud=".$s_actual[0]." and id_usuario=".$_SESSION["id_us_session"];    
    $update=query_db($update_alert);
  }elseif($sel_item[1]!=$s_actual[2]){
    $update_alert="update alertas_push set estado=4 where id_solicitud=".$s_actual[0]." and id_usuario=".$_SESSION["id_us_session"]." and dias <> ".$sel_item[1];
    $update=query_db($update_alert);
  }
}
/*********  FIN VERIFICAR ESTADO DE SOLCITUD PARA NOTIFICACIONES PUSH   ************/

//$alerta_de_archivos = '<br /><strong class="letra-descuentos">El SGPA recibe archivos de máximo 10MB</strong>';
$alerta_de_archivos = ayuda_alerta_pequena("Archivos de máximo 10MB");
$_SESSION["alerta_de_archivos"] = $alerta_de_archivos;

$version_js = str_replace("-", "", elimina_comillas_2($fecha))."_gt11";
$vervion_variable = "_fr45";

$_SESSION["gestor_abste"] = 0;

$instruccion = "select * from v_mesa_ayuda_princiapal  where us_id = ".$_SESSION["id_us_session"]." and estado = 2 and estado_firme = 1 and '$fecha $hora' BETWEEN  inicio_vigencia and final_vigencia";
$cuenta_novedades = traer_fila_row(query_db($instruccion));
/******PARA NOTIFICACIONES PUSH**********/

$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar

$encrypted =codifica_md5($_SESSION["id_us_session"]);

$numero_notificaciones=10;
/******PARA NOTIFICACIONES PUSH**********/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<!--- link href="../css/roboto.css" rel="stylesheet" type="text/css" /   -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />

 <meta http-equiv="X-UA-Compatible" content="IE=9">

<title><?=TITULO;?></title>
<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/DataTables/media/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="../librerias/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/js/desempeno/desempeno_admin_v1.js?version<?=$version_js?>=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/puntos.js"></script>
<script type="text/javascript" src="../librerias/js/procesos_generales_v1.js?version<?=$version_js?>=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/contratos_admin.js?version=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/pecc-item_admin_v5.js?version<?=$vervion_variable?>=<?=$version_js?>" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/comite_admin.js?version=<?=$version_js?>" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/tarifas_admin_v4.js?version=<?=$version_js?>14"></script>
<script type="text/javascript" src="../librerias/js/indicador_admin.js?version=<?=$version_js?>" charset="utf-8"></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/jquery.ajaxQueue.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/thickbox-compressed.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/jquery.autocomplete.js' charset='iso-8859-1'></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/lib/thickbox.css" />
<script type="text/javascript" src="../librerias/js/procesos_manuales.js?version<?=$version_js?>=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/auto_completa_nuevo.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<link href="../librerias/js/alertas/jquery.alerts.css" rel="StyleSheet" type="text/css" />
	<script src="../librerias/js/alertas/jquery.ui.draggable.js" type="text/javascript"></script>
	<script src="../librerias/js/alertas/jquery.alerts.mod.js" type="text/javascript"></script>


<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>

<!--script type="text/javascript" src="../librerias/js/jquery2.js?version=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/materialize/js/chips.js?version<?=$version_js?>=<?=$version_js?>"></script -->


<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />


<!--link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet" -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">

<script type="text/javascript">
var cont_push=0; var total_push=0; var actual_push=0; var actual_push2=0; var muestra_numero=0;
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
$().ready(function() { jorge gonzales

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
  /************ 18 **********************/
if(document.getElementById("" + id)){
    document.getElementById("" + id).onchange=function() {
        var busca=document.getElementById("" + id).value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("" + id).value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("" + id).onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#" + id).val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#" + id).empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#" + id).parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: ruta,
            type: 'POST',
            dataType: 'html',
            data: {q:$("#" + id).val(), q2:coma},
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
                    $("#" + id).val($(this).text())
                    $('#gerente_confirma_asegu_list').css('display', 'none')
                    //alert(this.id)
                  });
                    li.addEventListener("mouseover",function(){
                        $("#" + id).val($(this).text())
                    }); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("click", function(){
                        $("#" + id).val($(this).text())
                        $('#gerente_confirma_asegu_list').css('display', 'none')
                        //alert(this.id)
                  });
                    li.attachEvent("mouseover", function(){
                        $("#" + id).val($(this).text())
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
/*function log(event, data, formatted) {
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
	
	});*/
	
	

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
$(document).ready(function() {
		if (document.addEventListener){
			document.getElementById('muestra-notifiaciones').addEventListener("mouseover",function(){
				//if(document.getElementById('load-hystory').style.display=="block"){
					$('#load-hystory').css('display', 'block');
				//}
			},false);
			document.getElementById('load-hystory').addEventListener("mouseleave",function(){
				//if(document.getElementById('load-hystory').style.display=="block"){
					$('#load-hystory').css('display', 'none');
				//}
			},false);
		}else {
			document.getElementById('numero_novedades').attachEvent('mouseover',function(){
				$('#load-hystory').css('display', 'block');
			});
			document.getElementById('muestra-notifiaciones').attachEvent('mouseleave',function(){
				$('#load-hystory').css('display', 'none');
			});
		}
        $('input').attr('autocomplete', 'off');
        $("#gerente_confirma_asegu").attr('autocomplete', 'off');
        $("#proveedores_busca_adjudicacion").attr('autocomplete', 'off');
        $("#categoria_busca").attr('autocomplete', 'off');
        $("#proveedores_busca").attr('autocomplete', 'off');
        $("#busca_id_responsable").attr('autocomplete', 'off');
        $("#busca_id_cierre").attr('autocomplete', 'off');
        $("#busca_id_comite").attr('autocomplete', 'off');
        $("#busca_id_solicitud").attr('autocomplete', 'off');
        $("#contratos_normales").attr('autocomplete', 'off');
        $("#usuario_permiso").attr('autocomplete', 'off');
        $("#gerente").attr('autocomplete', 'off');
        $("#usuario_permiso2").attr('autocomplete', 'off');
        $("#partecnico_bus_us").attr('autocomplete', 'off');
        $("#gerente_contrato_bus_us").attr('autocomplete', 'off');
        $("#busca_solicitud").attr('autocomplete', 'off');
        $("#llena_lista_sondeos_l").attr('autocomplete', 'off');
        $("#tarifas_busca_contratos").attr('autocomplete', 'off');
        $('#usuario_permiso').change(function(event) {
            alert($('#usuario_permiso').val())
        });
});
function evalua_click(){
	//console.log(document.getElementById('load-hystory').style.display)
	if(document.getElementById('load-hystory').style.display=="none"){
		$('#load-hystory').css('display', 'block');
	}else{
		$('#load-hystory').css('display', 'none');
	}
}
function funcionando()
{//funcion para notifiaciones push   
	
	
	
	actual_push++; actual_push2++;
    $.post('../librerias/php/verifica_notificacion.php', {cadena: '<?=$encrypted?>'}, function(data) {
		//console.log(data)
        var data2=JSON.parse(data);
        var total_sin=data2.total_sin;
        var total_todo=data2.total_todo;
        if(total_sin.total_sin!=0){
            var pendientes=data2.pendiente;
            $('#close_message_id').val(pendientes.id_sin);
            $('#action').val(pendientes.id_sin);
            //$('.table_caraga_push').empty();
			//console.log(data2.pendiente);
			var size_array=data2.pendiente.length
			var cont_id=0;
			var arr_func=new Array(size_array);
			for(var i in data2.pendiente){
                //total_push++;
                var todo=data2.pendiente[i];
				//console.log(cont_push);
			if(todo['id']!=undefined){
				if(document.getElementById("derecha"+todo['id'])){
					
				}else{
				var count = $("#table_caraga_push").children().length;
				if(count<6){
				var mensaje=todo['mensaje']
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.split('<br>')
				//console.log(mensaje.length);
				cont_id=i;
				var tabla=document.getElementById('table_caraga_push');
				var div1=document.createElement("div");
				div1.className="derecha "+todo['estilo_borde'];
				div1.id="derecha"+todo['id'];
				var div2=document.createElement("div");
				div2.className="close_push";
				div2.id="cierra"+todo['id']
				var div3=document.createElement("div");
				div3.id="carga"+todo['id']
				div3.className="body_push";
				var div4=document.createElement("div");
				div4.id="image"+todo['id']
				div4.className="image_push";
				var p_body=document.createElement("p");
				var p_body2=document.createElement("p");
				for(var i=0; i<mensaje.length; i++){					
					var msj=mensaje[i];
					if(mensaje[i].length>32){
						msj=msj.substring(0, 32)
						msj=msj+'...'
					}
					//console.log(msj)
					var span_tittle=document.createElement("span");
					if(i==0){
						if(todo['estilo_borde']=="custom-red-border"){
							span_tittle.className="custom-red-text";
						}else if(todo['estilo_borde']=="custom-yellow-border"){
							span_tittle.className="custom-yellow-text";
						}else if(todo['estilo_borde']=="custom-green-border"){
							span_tittle.className="custom-green-text";
						}
					}
					var tex_body=document.createTextNode(msj);
					span_tittle.appendChild(tex_body)
					p_body.appendChild(span_tittle)				
					var br=document.createElement("br");
					p_body.appendChild(br)
				}
				var div5=document.createElement("div");
				div5.className="dias_push";
				var dias=""
				if(todo['dias']==0){
					dias="Hoy"
				}else{
					if(todo['dias']==1){
						dias="Hace "+todo['dias']+" día";
					}else{
						dias="Hace "+todo['dias']+" días";
					}
				}
				var tex_dias=document.createTextNode(dias);
				p_body.appendChild(p_body2)
				div3.appendChild(p_body)
				div5.appendChild(tex_dias)
				div1.appendChild(div3)
				div1.appendChild(div4)
				div1.appendChild(div2)
				div1.appendChild(div5)
				tabla.appendChild(div1)
				if (div3.addEventListener){
					div3.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('carga','');
						leer_push(id_div)
					},false);
				}else { 
					div3.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('carga','');
						leer_push(id_div)
					}); 
				}
				if (div2.addEventListener){
					div2.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('cierra','');
						cerrar_push(id_div)
					},false);
				} else { 
					div2.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('cierra','');
						cerrar_push(id_div)
					}); 
				}
				
					$("#cierra"+todo['id']).append('<i id="i'+todo['id']+'" class="material-icons md-18">&#xE5CD;</i>');
					if(todo['estilo_borde']=="custom-red-border"){						
						$("#image"+todo['id']).append('<i class="material-icons md-48 custom-red" style="margin-left: 2px;">&#xE000;</i>');
					}else if(todo['estilo_borde']=="custom-yellow-border"){
						$("#image"+todo['id']).append('<i class="material-icons md-48 custom-yellow" style="margin-left: 2px;">&#xE002;</i>');
					}else if(todo['estilo_borde']=="custom-green-border"){
						$("#image"+todo['id']).append('<i class="material-icons md-48 custom-green" style="margin-left: 2px;">&#xE88E;</i>');
					}
				$("#derecha"+todo['id']).css('margin-left', '10px');
				}
				}
			}
            }
            $('.table_caraga_push').css('display', 'block');
        }else{
            $('.table_caraga_push').css('display', 'none');
        }
        if(total_todo.total_todo!=0){
            for(var i in data2.todo){
                var todo=data2.todo[i];
			if(todo['id']!=undefined){
				if(document.getElementById("notificacion"+todo['id'])){
					
				}else{
                total_push++;
				var count = $("#alertas_notifiaciones").children().length;
				//console.log('total : '+total_push+' posicion: '+todo['posicion'])
				//if(actual_push2==todo['posicion']){//para cargar una por una
				muestra_numero++;
				//console.log(todo['id'])
				cont_id=i;
				var mensaje=todo['mensaje']
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.split('<br>')
				var tabla=document.getElementById('alertas_notifiaciones');
				var div1=document.createElement("div");
				div1.className="derecha2 "+todo['estilo_borde'];
				div1.id="notificacion"+todo['id'];
				var div2=document.createElement("div");
				div2.className="close_push_notificacion";
				div2.id="cierra_notificacion"+todo['id']
				var div3=document.createElement("div");
				div3.id="carga_notificacion"+todo['id']
				div3.className="body_push_notificacion";
				var div4=document.createElement("div");//SI SE HABILITAN LOS ICONOS
				div4.id="image_notificacion"+todo['id']//SI SE HABILITAN LOS ICONOS
				div4.className="image_push_notificacion";//SI SE HABILITAN LOS ICONOS
				var p_body=document.createElement("p");
				var p_body2=document.createElement("p");
				for(var i=0; i<mensaje.length; i++){					
					var msj=mensaje[i];
					if(mensaje[i].length>32){
						msj=msj.substring(0, 32)
						msj=msj+'...'
					}
					//console.log(msj)
					var span_tittle=document.createElement("span");
					if(i==0){
						if(todo['estilo_borde']=="custom-red-border"){
							span_tittle.className="custom-red-text";
						}else if(todo['estilo_borde']=="custom-yellow-border"){
							span_tittle.className="custom-yellow-text";
						}else if(todo['estilo_borde']=="custom-green-border"){
							span_tittle.className="custom-green-text";
						}
					}
					var tex_body=document.createTextNode(msj);
					span_tittle.appendChild(tex_body)
					p_body.appendChild(span_tittle)					
					var br=document.createElement("br");
					p_body.appendChild(br)
				}
				var div6=document.createElement("div");
				div6.className="dias_push_notificacion";
				var dias=""
				if(todo['dias']==0){
					dias="Hoy"
				}else{
					if(todo['dias']==1){
						dias="Hace "+todo['dias']+" día";
					}else{
						dias="Hace "+todo['dias']+" días";
					}
				}
				var tex_dias=document.createTextNode(dias);
				p_body.appendChild(p_body2)
				div3.appendChild(p_body)
				div1.appendChild(div2)
				div1.appendChild(div3)
				div1.appendChild(div4) //SI SE HABILITAN LOS ICONOS
				var div5=document.createElement("div");
				div5.className="divider2";				
				div6.appendChild(tex_dias)					
				div1.appendChild(div6)					
				div1.appendChild(div5)
				tabla.appendChild(div1)
				if (div3.addEventListener){
					div3.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('carga_notificacion','');
						leer_push_notificacion(id_div)
					},false);
				}else { 
					div3.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('carga_notificacion','');
						leer_push_notificacion(id_div)
					}); 
				}
				if (div2.addEventListener){
					div2.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('cierra_notificacion','');
						cerrar_push_notificacion(id_div)
					},false);
				} else { 
					div2.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('cierra_notificacion','');
						cerrar_push_notificacion(id_div)
					}); 
				}
				
					$("#cierra_notificacion"+todo['id']).append('<i id="i'+todo['id']+'" class="material-icons md-18" style="display: none;">&nbsp;</i>');
					/*if(todo['estilo_borde']=="custom-red-border"){						
						$("#image_notificacion"+todo['id']).append('<i class="material-icons md-48 custom-red" style="margin-left: 2px;">&#xE000;</i>');
					}else if(todo['estilo_borde']=="custom-yellow-border"){
						$("#image_notificacion"+todo['id']).append('<i class="material-icons md-48 custom-yellow" style="margin-left: 2px;">&#xE002;</i>');
					}else if(todo['estilo_borde']=="custom-green-border"){
						$("#image_notificacion"+todo['id']).append('<i class="material-icons md-48 custom-green" style="margin-left: 2px;">&#xE88E;</i>');
					}*/
				$("#carga_notificacion"+todo['id']).css('margin-left', '10px');
				}
				//}//para cargar una por una
			}
            }
			var texto="";
			if(total_push==1){
				texto="Notificación";
			}else{
				texto="Notificaciones";
			}
			$('#span-push').empty();
			$('#span-push').append(''+muestra_numero+' '+texto);
            $('#span-push').css('display', 'block');
            $('#muestra-notifiaciones').css('display', 'block');
        }else{            
            if(muestra_numero==0){
            	$('#muestra-notifiaciones').css('display', 'none');
            	$('#span-push').css('display', 'none');
			}
        }
    });
    timeout=setTimeout("funcionando()",60000);
}
function funcionando_novedades()
{//funcion para notifiaciones push
    $.post('../aplicaciones/mesa-ayuda/noticias_inbox_llena_push.php', {cadena: '<?=$encrypted?>'}, function(data) {
		console.log(muestra_numero)
		//console.log(data)
        var data2=JSON.parse(data);
        //var total_sin=data2.total_sin;
        var total_todo=data2.total_todo;
        if(total_todo.total_todo!=0){
            for(var i in data2.todo){
                var todo=data2.todo[i];
			if(todo['id']!=undefined){
				if(document.getElementById("novedad"+todo['id'])){
					
				}else{
				muestra_numero++;
                total_push++;
				var count = $("#alertas_novedades").children().length;
				//console.log('total : '+total_push+' posicion: '+todo['posicion'])
				//console.log(todo['id'])
				cont_id=i;
				var mensaje=todo['mensaje']
				//console.log(todo['mensaje'])
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.replace("&oacute;", "ó");
				mensaje=mensaje.replace("&Oacute;", "Ó");
				mensaje=mensaje.replace("&iacute;", "í");
				mensaje=mensaje.replace("&Íacute;", "Í");
				mensaje=mensaje.replace("&aacute;", "á");
				mensaje=mensaje.replace("&Aacute;", "Á");
				mensaje=mensaje.replace("&uacute;", "ú");
				mensaje=mensaje.replace("&Uacute;", "Ú");
				mensaje=mensaje.replace("&eacute;", "é");
				mensaje=mensaje.replace("&Eacute;", "É");
				mensaje=mensaje.replace("&ntilde;", "ñ");
				mensaje=mensaje.replace("&Ntilde;", "Ñ");
				mensaje=mensaje.split('<br>')
				var tabla=document.getElementById('alertas_novedades');
				var div1=document.createElement("div");
				div1.className="derecha2 "+todo['estilo_borde'];
				div1.id="novedad"+todo['id'];
				var div2=document.createElement("div");
				div2.className="close_push_notificacion";
				div2.id="cierra_novedad"+todo['id']
				var div3=document.createElement("div");
				div3.id="carga_novedad"+todo['id']
				div3.className="body_push_notificacion";
				var div4=document.createElement("div");//SI SE HABILITAN LOS ICONOS
				div4.id="image_novedad"+todo['id']//SI SE HABILITAN LOS ICONOS
				div4.className="image_push_notificacion";//SI SE HABILITAN LOS ICONOS
				var p_body=document.createElement("p");
				var p_body2=document.createElement("p");
				for(var i=0; i<mensaje.length; i++){					
					var msj=mensaje[i];
					if(mensaje[i].length>50){
						msj=msj.substring(0, 50)
						msj=msj+'...'
					}
					//console.log(msj)
					var tex_body=document.createTextNode(msj);
					p_body.appendChild(tex_body)					
					var br=document.createElement("br");
					p_body.appendChild(br)
				}
				var div6=document.createElement("div");
				div6.className="dias_push_notificacion";
				var dias=""
				if(todo['dias']==0){
					dias="Hoy"
				}else{
					if(todo['dias']==1){
						dias="Hace "+todo['dias']+" día";
					}else{
						dias="Hace "+todo['dias']+" días";
					}
				}
				var tex_dias=document.createTextNode(dias);
				p_body.appendChild(p_body2)
				div3.appendChild(p_body)
				div1.appendChild(div2)
				div1.appendChild(div3)
				div1.appendChild(div4) //SI SE HABILITAN LOS ICONOS
				var div5=document.createElement("div");
				div5.className="divider2";				
				div6.appendChild(tex_dias)					
				div1.appendChild(div6)					
				div1.appendChild(div5)
				tabla.appendChild(div1)
				if (div3.addEventListener){
					div3.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('carga_novedad','');
						leer_push_novedad(id_div)
					},false);
				}else { 
					div3.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('carga_novedad','');
						leer_push_novedad(id_div)
					}); 
				}
				if (div2.addEventListener){
					div2.addEventListener("click",function(){
						var id_div=this.id;
						id_div=id_div.replace('cierra_novedad','');
						//cerrar_push_novedad(id_div)
					},false);
				} else { 
					div2.attachEvent('click',function(){
	  					var id_div=this.id;
						id_div=id_div.replace('cierra_novedad','');
						//cerrar_push_novedad(id_div)
					}); 
				}
				
					$("#cierra_novedad"+todo['id']).append('<i id="i'+todo['id']+'" class="material-icons md-18" style="display: none;">&#xE5CD;</i>');
					if(todo['estilo_borde']=="custom-red-border"){						
						$("#image_novedad"+todo['id']).append('<i class="material-icons md-48 custom-red" style="margin-left: 2px;">&#xE000;</i>');
					}else if(todo['estilo_borde']=="custom-yellow-border"){
						$("#image_novedad"+todo['id']).append('<i class="material-icons md-48 custom-yellow" style="margin-left: 2px;">&#xE002;</i>');
					}else if(todo['estilo_borde']=="custom-green-border"){
						$("#image_novedad"+todo['id']).append('<i class="material-icons md-48 custom-green" style="margin-left: 2px;">&#xE88E;</i>');
					}
				$("#carga_novedad"+todo['id']).css('margin-left', '10px');
				}
			}
            }			
			$('#span-push').empty();
			$('#span-push').append(muestra_numero);
            $('#span-push').css('display', 'block');
            $('#muestra-notifiaciones').css('display', 'block');
        }else{
			if(muestra_numero==0){
            	$('#muestra-notifiaciones').css('display', 'none');
            	$('#span-push').css('display', 'none');
			}
        }
    });
    timeout=setTimeout("funcionando_novedades()",5000);
}
function anima_campana(){
	var texto="";
	if(total_push!=0){ 
		if(total_push==1){
			texto="Notificación";
		}else{
			texto="Notificaciones";
		}
		if(cont_push==0){
			$('#muestra-notifiaciones').empty();
			$('#muestra-notifiaciones').append('<i class="material-icons md-24" style="color: #FE7243 !important;">&#xE7F7;</i>');
			cont_push++;
		}else if(cont_push==1){
			$('#muestra-notifiaciones').empty();
			$('#muestra-notifiaciones').append('<i class="material-icons md-24" style="color: #FE7243 !important;">&#xE7F4;</i>');
			cont_push++;
		}else{
			$('#muestra-notifiaciones').empty();
			$('#muestra-notifiaciones').append('<i class="material-icons md-24" style="color: #FE7243 !important;">&#xE7F7;</i>');
			cont_push=0;
		}
	}
	timeout=setTimeout("anima_campana()",300);
}
function leer_push_novedad(id){
	ajax_carga("../aplicaciones/mesa-ayuda/contenido_novedad.php?id_no="+id,"carga_noticias")
	document.getElementById("carga_alertas").style.display = "none";
	document.getElementById("cargando_noticias_inbox").style.display = "none";
	//alert(id)
	/*$("#image"+id).empty();
	$("#cierra"+id).empty();
	$("#carga"+id).empty();	
	$("#derecha"+id).empty();
	$("#image"+id).remove();
	$("#cierra"+id).remove();
	$("#carga"+id).remove();
	$("#derecha"+id).remove();	
	$("#cierra_notificacion"+id).empty();
	$("#carga_notificacion"+id).empty();	
	$("#notificacion"+id).empty();
	$("#cierra_notificacion"+id).remove();
	$("#carga_notificacion"+id).remove();
	$("#notificacion"+id).remove();
    $.post('../librerias/php/verifica_notificacion.php', {action: 'lee', cadena: '<?=$encrypted?>', value: id}, function(data) {
			actual_push2=0;
			actual_push=0;
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
			result=result.replace("\n","")
			result=result.replace("[\n\r]", "");
			eval(result)
    });*/
}
function cerrar_push(id){
	$("#image"+id).empty();
	$("#cierra"+id).empty();
	$("#carga"+id).empty();	
	$("#derecha"+id).empty();
	$("#image"+id).remove();
	$("#cierra"+id).remove();
	$("#carga"+id).remove();
	$("#derecha"+id).remove(); 
	$.post('../librerias/php/verifica_notificacion.php', {action: 'gestiona', cadena: '<?=$encrypted?>', value: id}, function(data) {
			var data2=JSON.parse(data);
			if(data2["mensaje"]=="si"){
				actual_push=0;
				actual_push2=0;
			}
	});
}
function leer_push(id){
	$("#image"+id).empty();
	$("#cierra"+id).empty();
	$("#carga"+id).empty();	
	$("#derecha"+id).empty();
	$("#image"+id).remove();
	$("#cierra"+id).remove();
	$("#carga"+id).remove();
	$("#derecha"+id).remove();	
	/*$("#cierra_notificacion"+id).empty();
	$("#carga_notificacion"+id).empty();	
	$("#notificacion"+id).empty();
	$("#cierra_notificacion"+id).remove();
	$("#carga_notificacion"+id).remove();
	$("#notificacion"+id).remove();*/
    $.post('../librerias/php/verifica_notificacion.php', {action: 'lee', cadena: '<?=$encrypted?>', value: id}, function(data) {
			//console.log(data)
			actual_push2=0;
			actual_push=0;
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
			result=result.replace("\n","")
			result=result.replace("[\n\r]", "");
			eval(result)
    });
}
function cerrar_push_notificacion(id){
	/*$("#cierra_notificacion"+id).empty();
	$("#carga_notificacion"+id).empty();	
	$("#notificacion"+id).empty();
	$("#cierra_notificacion"+id).remove();
	$("#carga_notificacion"+id).remove();
	$("#notificacion"+id).remove();*/
	$("#image"+id).empty();
	$("#cierra"+id).empty();
	$("#carga"+id).empty();	
	$("#derecha"+id).empty();
	$("#image"+id).remove();
	$("#cierra"+id).remove();
	$("#carga"+id).remove();
	$("#derecha"+id).remove();
	$.post('../librerias/php/verifica_notificacion.php', {action: 'gestiona', cadena: '<?=$encrypted?>', value: id}, function(data) {
			var data2=JSON.parse(data);
			if(data2["mensaje"]=="si"){
				actual_push2=0;
				actual_push=0;
				cont_push--
			}
	});
}
function leer_push_notificacion(id){
	/*$("#cierra_notificacion"+id).empty();
	$("#carga_notificacion"+id).empty();	
	$("#notificacion"+id).empty();
	$("#cierra_notificacion"+id).remove();
	$("#carga_notificacion"+id).remove();
	$("#notificacion"+id).remove();*/
	$("#image"+id).empty();
	$("#cierra"+id).empty();
	$("#carga"+id).empty();	
	$("#derecha"+id).empty();
	$("#image"+id).remove();
	$("#cierra"+id).remove();
	$("#carga"+id).remove();
	$("#derecha"+id).remove();
	cont_push--;
    $.post('../librerias/php/verifica_notificacion.php', {action: 'lee', cadena: '<?=$encrypted?>', value: id}, function(data) {			
			console.log(data)
			actual_push2=0;			
			actual_push=0;
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
			result=result.replace("\n","")
			result=result.replace("[\n\r]", "");
			eval(result)
    });
}
	
	function abrir_ventana_excel(grafica) {
			var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
			window.open("../aplicaciones/reportes/reporte_variaciones_global_excel.php?tp_grafica="+grafica,"",opciones);
			
	}
/*funciones para la muestra de alertas*/
function muestra_alerta_general_desde_select(nombre_funcion, titulo, cuerpo, id_select){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
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
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
  
  document.getElementById("div_carga_busca_sol").style.display="block";
  ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_general_desde_ajax(ruta,div, titulo, cuerpo, id_select, tipo_modal){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");

  document.getElementById("div_carga_busca_sol").style.display="block";
  ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+ruta+"&tipo_modal="+tipo_modal+"&div="+div, "div_carga_busca_sol");
}
function muestra_alerta_error(nombre_funcion, titulo, cuerpo, id_select){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
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
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto_guardado_exito(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa_guarda_exito.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_manuales_exito(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa_manuales.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_manuales_advertencia(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
  cuerpo = cuerpo.replace("<br>", "");
  cuerpo = cuerpo.replace("<br />", "");
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_advertencia_manuales.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
/*FIN funciones para la muestra de alertas*/

/*calendario de la urna para descongelar procesos*/
function calendario_se(obje){
			$(function(){
				$('#' + obje).datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}
/*calendario de la urna para descongelar procesos*/


</script>
<?
$nombre_ie_css = "chips-ms12";
?>
<link href="../css/estilo-principal.css?version=<?=$hora?>" rel="stylesheet" type="text/css" />

<?=$texto_modulo_pruebas?>
<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   //echo $u_agent;
	
	
	
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


<body onload="<?=$link_alertas?>; <? if ($cuenta_novedades[0]>=1) { ?> document.getElementById('cargando_noticias_inbox').style.display = ''; <? } ?>funcionando();anima_campana();" >

<div class="table_caraga_push" id="table_caraga_push" width=""></div>
<!--div style="height: 25rem; width: 50%; background-color: aqua;" onClick="alert('')"></div -->
<div id="cargando_noticias_inbox" style="display:none" > 

<div id="central">
<div class="volver_cerrar_ciadro"><input name="cerra" type="button" value="Cerrar y ver Inbox" class="boton_volver"  onclick="document.getElementById('cargando_noticias_inbox').style.display = 'none'"> </div>

<div class="tiutulo_novedades">Novedades del sistema SGPA</div>

           
<?

 
   // Enviar consulta
 
     // if (isset($categoria) && $categoria != "Todas")
        // $instruccion = $instruccion . " where us_id = ".$_SESSION["id_us_session"]." and estado_firme = 1";
 
    $instruccion = $instruccion . " order by inicio_vigencia desc";
      $consulta = query_db($instruccion)
         or die ("Fallo en la consulta");
 

 
   // Mostrar resultados de la consulta
      $nfilas = mssql_num_rows ($consulta);
      if ($nfilas > 0)
      {
 
         for ($i=0; $i<$nfilas; $i++)
         {
            $resultado = mssql_fetch_array ($consulta);
	
		 	$url_carga_pagina = "";
            echo "<div class='service_list' id='". $resultado['noticia_id'] ."' data='". $resultado['noticia_id'] ."'>";
            echo "<div class='center_block'>";
 			?>
            <a href='javascript:ajax_carga("../aplicaciones/mesa-ayuda/contenido_novedad.php?id_no=<?=$resultado['noticia_id'];?>","carga_noticias");' onclick='document.getElementById("carga_alertas").style.display = "none";document.getElementById("cargando_noticias_inbox").style.display = "none";'  class='product_img_link' target='_blank' > <img width='66' height='66' src='../images_noticias/<?=$resultado['imagen'];?>'   ></a> 
            
            <h3 onclick='ajax_carga("../aplicaciones/mesa-ayuda/contenido_novedad.php?id_no=<?=$resultado['noticia_id'];?>","carga_noticias");document.getElementById("carga_alertas").style.display = "none";document.getElementById("cargando_noticias_inbox").style.display = "none";'><?=$resultado['titulo'];?></h3>
            <?
            echo '<p class="product_desc">' . $resultado['descripcion'] . '';
            echo '<p class="info_general">Modulo: '. $resultado['nombre_categoria'] .'<br>Publicado: '. $resultado['fecha_post_ini'] .' visto: '. $resultado['veces_visto'] .' veces</p>'; 
             echo"</div>";

             
             echo "</div>";
 
}
 
      }
      //si no hay noticias mostramos el mensaje
      else
        print '<div class="no_noticia">No hay noticias disponibles... </div>';
             echo "</div>";
			 ?>
            
</div>


<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando-20seg.gif" width="320" height="250" /></td></table></div>

<div id="div_carga_busca_sol"  style="display:none"></div>
<div id="carga_modal_pecc"  style="display:none; width: 92.5%;"></div>



<?=banner();?>

<form name="principal" method="post" enctype="multipart/form-data" autocomplete="off">


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



    <? if(permiso_ingreso(1) == "SI"){?>
    <tr>
      <td class="fondo_1" align="center">2</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-item.html','contenido_menu')"><div align="left">M&oacute;dulo SOLICITUDES</div></td>
    </tr>
    <? } ?>
    <?
       
        if(permiso_ingreso(40) == "SI"){
    ?>
    <tr>
      <td class="fondo_1" align="center">3</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-comite.html','contenido_menu')"><div align="left">M&oacute;dulo COMITE</div></td>
    </tr>
    <? }
     if(permiso_ingreso(19) == "SI"){?>
    <tr>
      <td class="fondo_1" align="center">4</td>
      <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='../enterproc/administracion-general/principal.html'"><div align="left">M&oacute;dulo URNA VIRTUAL</div></td>
    </tr>
    <?
									}
		  if(permiso_ingreso(30) == "SI"){
		  ?>
    <tr>
      <td class="fondo_1" align="center">5</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-contratos.html','contenido_menu')"><div align="left">M&oacute;dulo CONTRATOS</div></td>
    </tr>
    <? } ?>
     <? if(permiso_ingreso(46) == "SI"){?>
    <tr>
      <td class="fondo_1" align="center">6</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-tarifas.html','contenido_menu')"><div align="left">M&oacute;dulo TARIFAS</div></td>
      <!--<td colspan="2" align="center" class="fondo_2"onclick="alert('En este momento nos encontramos trabajando en este modulo. Para mejorar la velocidad. Este servicio se restaurara el dia 11 de marzo de 2015 a las 8 am.')"><div align="left">Modulo TARIFAS</div></td>-->
    </tr>
      <? }
		  if(permiso_ingreso(60) == "SI"){?>
        <tr>
          <td class="fondo_1" align="center">7</td>
          <td class="fondo_2" onClick="taer_menu('menu-indicador.html','contenido_menu')">M&oacute;dulo REPORTES</td>
        </tr>
        
         <?
		 
	  }
		if($_SESSION["id_us_session"]!=24516 and $_SESSION["id_us_session"] !=24515 )  {//temporal mientras se agrega a los roles
	?>
	  <tr>
    	<td width="17%" class="fondo_1" align="center">9</td>
    	<td width="83%" class="fondo_2" onClick="taer_menu('menu-desempeno.html','contenido_menu')">M&oacute;dulo DESEMPE&Ntilde;O</td>
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
    <td width="100%" valign="top" class="contenido_principal_de_trabajo" ><div id="carga_alertas"></div><div id="carga_noticias"></div></td>
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
          <td class="letra_azul_pequena">Si tiene problemas con la funcionalidad del sistema por favor comun&iacute;quese con soporte del SGPA (57 1 488 4000 Ext 4548),
 Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</div>
<input type="hidden" name="accion" />
<!-- PARA EL DESARROLLO DE LAS MODIFICACIONES -->
<input type="hidden" name="var1" />
<input type="hidden" name="var2" />
<!-- PARA EL DESARROLLO DE LAS MODIFICACIONES -->
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
