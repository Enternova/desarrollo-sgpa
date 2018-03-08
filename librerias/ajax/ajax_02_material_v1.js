// JavaScript Document
function inicia_select()
  	{
	$(document).ready(function() {
    $('select').material_select();
	$('.collapsible').collapsible();
	Materialize.updateTextFields();
	$('ul.tabs').tabs();
	$('.tooltipped').tooltip({delay: 50});
});
 /* $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Agos', 'Sep', 'Oct', 'Nov', 'Dic' ],
	weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Vienes', 'Sabado' ],
	weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'  ],
	show_weekdays_short: true,
    today: 'Hoy',
    clear: 'limpiar',
    close: 'Aceptar',
    closeOnSelect: true // Close upon selecting a date,
  });


  });

 $('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
    
  */
		}
		
		
function inicia_modal()
  	{
		$(document).ready(function() {
			//$('.modal-trigger').leanModal();
			$('.modal').modal();
			$('.tooltipped').tooltip({delay: 50});
		});
		
	}
		
function ajax_carga (url, id_contenedor)
{
//displayMessage('/parservi/librerias/dhtml/avisos/cargando.htm');
 document.getElementById("cargando").style.display=""

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
cargarpagina (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

function cargarpagina (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{

document.getElementById(id_contenedor).innerHTML = "";
document.getElementById(id_contenedor).innerHTML = pagina_requerida.responseText;
//close_va();
document.getElementById("cargando").style.display="none"
}
	inicia_select();
	inicia_modal();
}


// desde iframe

function ajax_carga_02(url, id_contenedor)
{

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
cargarpagina_02 (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

function cargarpagina_02 (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{
window.parent.document.getElementById(id_contenedor).innerHTML = "";
window.parent.document.getElementById(id_contenedor).innerHTML = pagina_requerida.responseText;
}
}




function autocom (url)
{

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta

cargarpagina_auto (pagina_requerida);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

function cargarpagina_auto (pagina_requerida)
{ 

if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{
Tip(pagina_requerida.responseText, CLOSEBTN, true, CLOSEBTNCOLORS, ['', '#66ff66', 'white', '#00cc00'], STICKY, true)
}
}



function borracambia(dato)
	{
	var forma = document.formulario
	forma.clave_a.value = "";
	forma.clave_a.value = dato;
	}
	
	
	
//PARA CARGAR CALENDARIO
function ajax_carga_c (url, id_contenedor)
{

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
cargarpagina_calendario (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

function cargarpagina_calendario (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{
document.getElementById(id_contenedor).innerHTML = "";
document.getElementById(id_contenedor).innerHTML = pagina_requerida.responseText;


}
}




///

function ajax_carga_menu_g(url, id_contenedor)
{
document.getElementById('edita_resultado').innerHTML = "";
document.getElementById('contenidos').style.display = '';
document.getElementById('contenidos').innerHTML = "";

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
cargarpagina__menu_g (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

function cargarpagina__menu_g (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{
window.parent.document.getElementById(id_contenedor).innerHTML = "";
window.parent.document.getElementById(id_contenedor).innerHTML = pagina_requerida.responseText;
}
}





//FUNCION DE reloj
function ajax_carga_reloj_auditor(url, id_contenedor)
{

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
cargarpagina_rejoj (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function cargarpagina_rejoj (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{

//reloj_ofertas_activas('t_1','18/12/2012')

var response = pagina_requerida.responseText;
//var update = new Array();
var consolidado = "";
var semaforo_general="";
var semaforo = "";
var separa = new Array();;
var separa = response.split('$$');
consolidado = separa[0];

document.getElementById('acualiza_consolidado_es').innerHTML = consolidado;

semaforo_general = separa[1].split('|');



if(semaforo_general.length>=1){
for(i=0;i<semaforo_general.length-1;i++){//for
	semaforo = semaforo_general[i].split('--');
	
	document.getElementById(semaforo[0]).innerHTML = semaforo[1];

} // for

}//if para el rloj





}
}


/****************************************************************************/
/*CARGA MENU*/
//FUNCION DE reloj
function taer_menu(url, id_contenedor)
{

var pagina_requerida = false;
if (window.XMLHttpRequest)
{
// Si es Mozilla, Safari etc
pagina_requerida = new XMLHttpRequest ();
} else if (window.ActiveXObject)
{
// pero si es IE
try 
{
pagina_requerida = new ActiveXObject ("Msxml2.XMLHTTP");
}
catch (e)
{
// en caso que sea una versión antigua
try
{
pagina_requerida = new ActiveXObject ("Microsoft.XMLHTTP");
}
catch (e)
{
}
}
} 
else
return false;
pagina_requerida.onreadystatechange = function ()
{
// función de respuesta
carga_taer_menu (pagina_requerida, id_contenedor);
}
pagina_requerida.open ('POST', url, true); // asignamos los métodos open y send
pagina_requerida.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
pagina_requerida.send (null);
}

// todo es correcto y ha llegado el momento de poner la información requerida
// en su sitio en la pagina xhtml
function carga_taer_menu (pagina_requerida, id_contenedor)
{ 
if (pagina_requerida.readyState == 4 && (pagina_requerida.status == 200 || window.location.href.indexOf ("http") == - 1))
{

//reloj_ofertas_activas('t_1','18/12/2012')

var response = pagina_requerida.responseText;
//var update = new Array();
var menu_c = "";
var titulo_c="";
var contenido_c = "";
var separa = new Array();
var separa = response.split('$$');


document.getElementById('contenido_menu').innerHTML = separa[0];
document.getElementById('titulo_modulo').innerHTML = separa[1];
ajax_carga(separa[2],'contenidos');





}//if para el rloj


}



/****************************************************************************/
/*CARGA PROCUREMENT*/
//FUNCION DE reloj
function carga_urna(id_contenedor)
{
	
	var forma = document.principal;
	forma.id_procurement_alerta.value=id_contenedor;
	forma.action = "../enterproc/administracion-general/principal.html"
	forma.submit()
	//window.parent.location.href="../enterproc/administracion-general/principal.html";
	//window.parent.ajax_carga("../aplicaciones/crea_proceso.php?id_p=" + id_contenedor,"contenidos")
}//if para el rloj