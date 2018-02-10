function popup01(URL, alto, ancho, x, y, scrol, resiza) {


day = new Date();
id = day.getTime();
eval(window.open(URL, "_blank", "scrollbars=" + scrol + ",resizable=" + resiza + ",height=" + alto + ",width=" + ancho + ",top=" + x + ",left=" + y + ",screenX=x,screenY=y"));
}


function puntitos(donde,caracter)
{

pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true

if(isNaN(caracter) || pat.test(caracter) == true)
	{
	if (pat.test(caracter)==true) 
		{caracter = "\\" + caracter}
	carcter = new RegExp(caracter,"g")
	valor = valor.replace(carcter,"")
	donde.value = valor
	crtr = false
	}
else
	{
	var nums = new Array()
	cont = 0
	for(m=0;m<largo;m++)
		{
		if(valor.charAt(m) == "." || valor.charAt(m) == " " || valor.charAt(m) == ",")
			{continue;}
		else{
			nums[cont] = valor.charAt(m)
			cont++
			}
		
		}
	}
var cad1="",cad2="",tres=0
if(largo > 3 && crtr == true)
	{
	for (k=nums.length-1;k>=0;k--)
		{
		cad1 = nums[k]
		cad2 = cad1 + cad2
		tres++
		if((tres%3) == 0)
			{
			if(k!=0){
				cad2 = "," + cad2
				}
			}
		}
	 donde.value = cad2
	}
}	


$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "Enero", "Febrero", "Marzo", "April", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]; 
var dayNames= ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year   
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	},1000);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);	
});


function busqueda_paginador_nuevo(pagina,ruta_pagina,espacio, alerta)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			
			

			
			for (i=0;i<nume_elementos;i++)
			 {
			 
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + forma.elements[i].value
			}


	compl = "actividad_pru=" + cadena_str

	
	ajax_carga(ruta_pagina + '?pag=' + pagina + '&tipo_ingreso_alerta=' + alerta +  cadena_str,espacio)
	
	
	
	}
	
	
function copia_fechas(tipo)
	{
		
var forma = document.principal

switch (tipo)
 {
 case 1:
   forma.fecha_informativa.value = forma.i.value
   forma.fecha_informativa_f.value = forma.j.value
   break;


 
  case 2:
   forma.a_j.value = forma.i.value
   forma.c_j.value = forma.j.value
   break;


 
  case 3:
   forma.a_j5.value = forma.i.value
   forma.a_j6.value = forma.j.value
   break;


 
  case 4:
   forma.a_t.value = forma.i.value
   forma.c_t.value = forma.j.value
   break;


 
  case 5:
   forma.a_j7.value = forma.i.value
   forma.a_j8.value = forma.j.value
   break;


 
  case 6:
   forma.a_e_p.value = forma.i.value
   forma.c_e_p.value = forma.j.value
   break;


 
  case 7:
   forma.a_e.value = forma.i.value
   forma.c_e.value = forma.j.value
   break;

 }
 		
		
		
		}
