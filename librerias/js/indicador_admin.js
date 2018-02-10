function carga_reporte_valor_area_proyecto(){
var forma = document.principal

 var alerta = confirm("Esta Seguro actualizar este reporte, recuerde que tardara al rededor de 10 minutos")

        if (alerta) {
			window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "carga_reporte_valor_area_proyecto"
            forma.target = "grp"
            forma.submit()
		}
	
}

function genera_indicador_valor_solicitudes(tipo){
	var forma = document.principal
	
	var msg=""

		
/*
	if(forma.ano.value==0){
		msg = msg + "* Seleccione el año\n"
		forma.ano.className = "select_faltantes";		
	}else{
		forma.ano.className = "";	
		}
		
		if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
			//forma.action = "indicador_general.html";
*/			
			forma.action = "../aplicaciones/reportes/inicio_valor_area_proyecto_grafica_1.php";
			forma.target="genera_indica_1"
			forma.submit()
			
	//}
				
		
	}

function genera_indicador_legalizacion(){
	var forma = document.principal
	
	var msg=""

		

	if(forma.ano.value==0){
		msg = msg + "* Seleccione el año\n"
		forma.ano.className = "select_faltantes";		
	}else{
		forma.ano.className = "";	
		}
		
		if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		
			//forma.action = "indicador_general.html";
			forma.action = "../aplicaciones/indicadores/legalizacion_indicador_1.php";
			forma.target="genera_indica_1"
			forma.submit()
			
	}
				
		
	}


function genera_indicador(tipo){
	var forma = document.principal
	
	var msg=""

		

	if(forma.ano.value==0){
		msg = msg + "* Seleccione el año\n"
		forma.ano.className = "select_faltantes";		
	}else{
		forma.ano.className = "";	
		}
		
		if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
			//forma.action = "indicador_general.html";
			if(tipo == "tiempo"){
			forma.action = "../aplicaciones/indicadores/indicador_pecc_1.php";
			}
			if(tipo == "carga"){
			forma.action = "../aplicaciones/indicadores/indicador_pecc_1_carga_profesional.php";
			}
			forma.target="genera_indica_1"
			forma.submit()
			
	}
				
		
	}
	
	
	function valida_reporte_ans(){
		var forma = document.principal;
		var msg = "";
		if(forma.t1_tipo_contratacion_id.value=="0"){
			msg=msg+'*Seleccione un tipo de contratación\n';
				forma.t1_tipo_contratacion_id.className = "select_faltantes";
		}
		if(forma.t1_tipo_proceso_id.value=="0"){
			msg=msg+'*Seleccione un tipo de de proceso\n';
				forma.t1_tipo_proceso_id.className = "select_faltantes";
		}
		if(forma.estado.value=="0"){
			msg=msg+'*Seleccione un estado\n';
				forma.estado.className = "select_faltantes";
		}
		if(forma.socios.value=="0"){
			msg=msg+'*Seleccione si aplica socios\n';
				forma.socios.className = "select_faltantes";
		}
		if(msg!=""){
			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 30, 8, 14)
//			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:<br><br>'+msg, 40, 5, 12)
			return
		}else{
			ajax_carga('../aplicaciones/reportes/lista_ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estadoans='+document.getElementById('estado').value+'&aplicasocios='+document.getElementById('socios').value,'carga_auditor_1')
		}
	}
	function valida_reporte_excel_ans(){
		var forma = document.principal;
		var msg = "";
		if(forma.t1_tipo_contratacion_id.value=="0"){
			msg=msg+'*Seleccione un tipo de contratación\n';
				forma.t1_tipo_contratacion_id.className = "select_faltantes";
		}
		if(forma.t1_tipo_proceso_id.value=="0"){
			msg=msg+'*Seleccione un tipo de de proceso\n';
				forma.t1_tipo_proceso_id.className = "select_faltantes";
		}
		if(forma.estado.value=="0"){
			msg=msg+'*Seleccione un estado\n';
				forma.estado.className = "select_faltantes";
		}
		if(forma.socios.value=="0"){
			msg=msg+'*Seleccione si aplica socios\n';
				forma.socios.className = "select_faltantes";
		}
		if(msg!=""){
			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 30, 8, 14)
//			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:<br><br>'+msg, 40, 5, 12)
			return
		}else{
			document.location.assign('../aplicaciones/reportes/reporte_ans.php?t1_tipo_contratacion_id='+document.getElementById('t1_tipo_contratacion_id').value+'&t1_tipo_proceso_id='+document.getElementById('t1_tipo_proceso_id').value+'&estadoans='+document.getElementById('estado').value+'&aplicasocios='+document.getElementById('socios').value)
		}
	}

/*
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)
		//alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		muestra_alerta_general_solo_texto('graba_informacion_poliza2_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
	}
}	
function graba_informacion_poliza2_continua(){
	var forma = document.principal
	forma.action = "procesos-contratos.html";
	forma.accion.value="graba_poliza_observacion" 			
	forma.target="grp"
	forma.submit()
}*/
