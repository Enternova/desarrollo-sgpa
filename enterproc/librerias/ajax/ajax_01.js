// JavaScript Document
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