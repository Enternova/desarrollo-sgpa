function alertas_confirmatorias(texto, titulo, destino, accion)
	{
	var forma = document.principal
	
	window.parent.document.getElementById("cargando").style.display="";
	jConfirm(texto, titulo, function(r) {// inicio function de confimacion
			if(r){
				
				forma.target="grp";
					forma.action = destino;
					forma.accion.value=accion;
					forma.submit()
				}
				
			else{
					window.parent.document.getElementById("cargando").style.display="none";		
			}
	});// inicio function de confimacion
		
		}
		
function alertas_confirmatorias_elimina(texto, titulo, destino, accion, eli)
	{
	var forma = document.principal
	window.parent.document.getElementById("cargando").style.display="";
	jConfirm(texto, titulo, function(r) {// inicio function de confimacion
			if(r){
				
				forma.target="grp";
					forma.action = destino;
					forma.id_elimina.value = eli;
					forma.accion.value=accion;
					forma.submit()
				}
				
			else{
					window.parent.document.getElementById("cargando").style.display="none";		
			}
	});// inicio function de confimacion
		
		}		


function alertas_confirmatorias_frame(texto, titulo, destino, accion)
	{
	var forma = window.carga_lotes_crea.document.principla1
	window.parent.document.getElementById("cargando").style.display="";
	jConfirm(texto, titulo, function(r) {// inicio function de confimacion
			if(r){
				
					forma.target="grp_frame";
					forma.action = destino;	
					forma.accion.value=accion;
					forma.submit()
				}
				
			else{
					window.parent.document.getElementById("cargando").style.display="none";		
			}
	});// inicio function de confimacion
		
		}




		
function cambia_tipo_cronograma_subastas(valor)
	{
	
		var forma = document.principal;
		var muesta="";
		if(valor==3) muesta = "none";
		if(valor==0) muesta = "none";		
		if(valor==2) muesta = "";
		
	
			for (i=1;i<10;i++){//oculta div cronograma
				var campo_muestra = "muestra_cronograma_" + i;
				//alert("cronograma_etapas_" + i)
				window.document.getElementById(campo_muestra).style.display=muesta
			
			}//oculta div cronograma

		}
		
function cambia_stylo(objet)
	{
		objet.className = ""	
		
		}



function crear_proceso_formulario(texto,titulo, accion)
	{
		alertas_confirmatorias(texto, titulo,  '../librerias/php/procesos_mesa_ayuda.php', accion)		
		}
