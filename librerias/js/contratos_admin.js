function cambia_ayuda(id){
			
			window.parent.document.getElementById("ayuda_admin_id_6").style.display="none"
			window.parent.document.getElementById("ayuda_admin_id_7").style.display="none"
			window.parent.document.getElementById("ayuda_admin_id_8").style.display="none"
			window.parent.document.getElementById("ayuda_admin_id_9").style.display="none"
			window.parent.document.getElementById("ayuda_admin_id_10").style.display="none"

			
			
			
			window.parent.document.getElementById("ayuda_admin_id_"+id).style.display=""
			
	}
function pone_fecha_fin (fecha_fin, fecha_inicio, fecha_actual){
	var forma = document.principal
	if(fecha_inicio.value == "" || fecha_inicio.value == " "){
			muestra_alerta_error_solo_texto('', 'Error', '* Para poder grabar esta fecha, la persona encargada primero debe diligenciar la fecha de inicio', 20, 10, 18)
			//alert("Para poder grabar esta fecha, la persona encargada primero debe diligenciar la fecha de inicio")
			return;
		}else{
			fecha_fin.value = fecha_actual;
			}
	}
	
function devolver_anterior(fecha_ini, ob,id_campo, fecha_ini_campo, ob_campo, rol1, rol2, ob_rol2, ob_campo_rol2, activa){
	var forma = document.principal
		if (valida_texto_espacios(ob_rol2.value) == "NO"  || characterCount(ob_rol2.value,20) != "") {
			muestra_alerta_error_solo_texto('', 'Error', '* Digite la Observación, recuerde que son como minimo 20 caracteres', 20, 10, 18)
			//alert("Digite la Observacion, recuerde que son como minimo 20 caracteres.")
			return;
			}
	var fecha_ini_pass = fecha_ini.name
	fecha_ini_pass = "document.principal."+fecha_ini_pass
	
	var ob_pass = ob.name
	ob_pass = "document.principal."+ob_pass
	
	var ob_rol2_pass = ob_rol2.name
	ob_rol2_pass = "document.principal."+ob_rol2_pass
	
	
	forma.fecha_inicial.value = fecha_ini.value
	forma.observacion.value = ob.value
	forma.id_campo_legalizacion.value = id_campo
	forma.observacion_rol2.value = ob_rol2.value
	
	
	forma.fecha_inicial_campo.value = fecha_ini_campo
	forma.observacion_campo.value = ob_campo
	forma.observacion_campo_rol2.value = ob_campo_rol2
	
	forma.id_rol_fecha1.value = rol1
	forma.id_rol_fecha2.value = rol2
	
	if(activa==""){//si es la primera vez que entra a la funcion, ejecutado por el usaurio
	
	//var alerta = confirm("Esta seguro de devolver este paso?")
	muestra_alerta_general_solo_texto('devolver_anterior('+fecha_ini_pass+', '+ob_pass+',-comillas-'+id_campo+'-comillas-, -comillas-'+fecha_ini_campo+'-comillas-, -comillas-'+ob_campo+'-comillas-, -comillas-'+rol1+'-comillas-, -comillas-'+rol2+'-comillas-, '+ob_rol2_pass+', -comillas-'+ob_campo_rol2+'-comillas-,1)', 'Advertencia', '¿Está seguro de devolver este paso?', 20, 10, 18)
	}
	if(activa==1){
			forma.action = "procesos-contratos.html";
			forma.accion.value="devuelve_proceso_legalizacion" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}

function graba_fecha_leg(fecha_ini, fecha_fin, ob, fecha_ini_campo, fecha_fin_campo, ob_campo, ob_obligatorio, ob_rol2, ob_campo_rol2, rol1, rol2, edita_fecha_2, id_actividad){
	var forma = document.principal
	
	if(ob_obligatorio == "SI"){

		if(edita_fecha_2 != 1){
			if (valida_texto_espacios(ob.value) == "NO"  || characterCount(ob.value,20) != "") {
				muestra_alerta_error_solo_texto('', 'Error', 'Digite la Observacion, recuerde que son como minimo 20 caracteres.', 20, 10, 18)
				//alert("1. Digite la Observacion, recuerde que son como minimo 20 caracteres.")
				return;
				}
		}
		
		if(edita_fecha_2 == 1){
						
				if (valida_texto_espacios(ob_rol2.value) == "NO"  || characterCount(ob_rol2.value,20) != "") {
					muestra_alerta_error_solo_texto('', 'Error', 'Digite la Observacion, recuerde que son como minimo 20 caracteres.', 20, 10, 18)
					//alert("2. Digite la Observacion, recuerde que son como minimo 20 caracteres.")
					return;
					}
		}
		
		
		
		}
		
		
	forma.id_actividad_guarda.value = id_actividad.value
	forma.fecha_inicial.value = fecha_ini.value
	forma.fecha_final.value = fecha_fin.value
	forma.observacion.value = ob.value
	forma.observacion_rol2.value = ob_rol2.value
	
	forma.fecha_inicial_campo.value = fecha_ini_campo
	forma.fecha_final_campo.value = fecha_fin_campo
	forma.observacion_campo.value = ob_campo
	forma.observacion_campo_rol2.value = ob_campo_rol2
	muestra_alerta_general_solo_texto('graba_fecha_leg_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
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
function graba_fecha_leg_continua(){
	var forma = document.principal
	forma.action = "procesos-contratos.html";
	forma.accion.value="graba_fecha_legalizacion" 
	forma.target="grp"
	forma.submit()
}
function valida_fecha_ideal_legalizacion_contrato(fecha, cual, fecha_anterior) {

    var factual = new Date();
    var valido = "SI"
	
    var fecha_de_form = fecha.value
    var fecha_split = fecha_de_form.split("-")
    var dia_fecha = fecha_split[2]
    var mes_fecha = fecha_split[1]
    var ano_fecha = fecha_split[0]
    var fecha_new = new Date(ano_fecha, mes_fecha - 1, dia_fecha)
	
    var dia = fecha_new.getDay() // 1 y 2 sabado y domingo
    var fecha_actual = new Date(factual.getFullYear(), (factual.getMonth()), factual.getDate())

    if (fecha_new < fecha_actual) {
    	muestra_alerta_error_solo_texto('', 'Error', '* La fecha no puede ser anterior a hoy', 20, 10, 18)
        alert("La fecha no puede ser anterior a hoy")
        fecha.value = "";
        return;
    }
/*
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)

	muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_admin_continua()', 'Advertencia', 'Esta a punto de enviar esta aclaración ¿esta seguro?', 20, 10, 18)
*/
if(cual == "fin"){
	var fecha_new_ant ="";
	
if(fecha_anterior.value != "" && fecha_anterior.value != " " && fecha_anterior.value != "	"){
	var fecha_de_form_ant = fecha_anterior.value
    var fecha_split_ant = fecha_de_form_ant.split("-")
    var dia_fecha_ant = fecha_split_ant[2]
    var mes_fecha_ant = fecha_split_ant[1]
    var ano_fecha_ant = fecha_split_ant[0]
    fecha_new_ant = new Date(ano_fecha_ant, mes_fecha_ant - 1, dia_fecha_ant)
}
	if (fecha_new < fecha_new_ant || fecha_new_ant =="") {
        alert("La fecha no puede ser anterior a la inicial")
        fecha.value = "";
        return;
    }
}
	
	


}

function retencion_garantia_valida(id_seleccion){
	var forma = document.principal
	
	if(id_seleccion == 1){
		window.parent.document.getElementById("aplica_garantia").style.display = ""
		}else{
			window.parent.document.getElementById("aplica_garantia").style.display = "none"
			}


	}
function graba_informacion_contrato(graba_aseguramiento_admin){
		var forma = document.principal
		var msg=""
		
				
		
	if(graba_aseguramiento_admin==1){
		
		
		
		if(forma.aseguramiento_admin.value=="0"){
			msg = msg + "* Seleccione Aseguramiento Administrativo\n"
			forma.aseguramiento_admin.className = "select_faltantes";		
		}
		
		if(forma.info_hse.value=="0"){
			msg = msg + "* Seleccione Informe HSE \n"
			forma.info_hse.className = "select_faltantes";		
		}
		if(forma.gerente_confirma_asegu.value==""){
			msg = msg + "* Seleccione el Gerente del Contrato \n"
			forma.gerente_confirma_asegu.className = "campos_faltantes";		
		}
		if(forma.notifica_email.value==1){
			if(forma.gerente_antiguo.value==0){				
				msg = msg + "* Seleccione el Gerente del Contrato Anterior \n"
				forma.gerente_antiguo.className = "campos_faltantes";		
			}		
		}
		if(forma.gerente_confirma_asegu.value!=""){
			if (forma.gerente_antiguo.value!=0) {
				var id_gerente_confirma=forma.gerente_confirma_asegu.value;
				var arr=id_gerente_confirma.split('----,');
				if(forma.gerente_antiguo.value==arr[1]){
					msg = msg + "* El Gerente Antiguo no Puede ser Igual que el Gerente Actual \n"
				}
			}
		}
		forma.accion.value="graba_contrato_admin_aseguramiento"
	}else{
		forma.accion.value="graba_contrato"
		if(forma.objeto.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Objeto del Contrato\n"
			forma.objeto.className = "textarea_faltantes";
		}	
		if(forma.nit.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el NIT\n"
			forma.nit.className = "campos_faltantes";		
		}	
		if(forma.contratista.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Contratista\n"
			forma.contratista.className = "campos_faltantes";		
		}	
		if(forma.contacto_principal.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Contacto Principal\n"
			forma.contacto_principal.className = "campos_faltantes";		
		}	
		if(forma.email1.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Email\n"
			forma.email1.className = "campos_faltantes";		
		}	
		if(forma.telefono1.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Telefono\n"
			forma.telefono1.className = "campos_faltantes";		
		}	
		if(forma.gerente.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Gerente\n"
			forma.gerente.className = "campos_faltantes";		
		}	
		if(forma.especialista.value.replace(/\s/g,"")==""){
			msg = msg + "* Digite el Especialista\n"
			forma.especialista.className = "campos_faltantes";		
		}	
		/*if(forma.area_ejecucion.value=="0"){
			msg = msg + "* Seleccione Area Ejecucion\n"
			forma.area_ejecucion.className = "select_faltantes";		
		}*/	
		
		if(forma.monto_usd.value.replace(/\s/g,"")=="" && forma.monto_cop.value==""){
			msg = msg + "* Digite el Monto\n"
			forma.monto_usd.className = "campos_faltantes";		
		}
		
		if(forma.analista_deloitte.value==1){
			if(forma.obs_congelado.value.replace(/\s/g,"")==""){
				msg = msg + "* Debe Digitar una observacion\n"
				forma.obs_congelado.className = "textarea_faltantes";		
			}	
		}
	/*	if(forma.aplica_portales.value=="0"){
			msg = msg + "* Seleccione si Aplica portales\n"
			forma.aplica_portales.className = "select_faltantes";		
		}
		
		if(forma.aplica_portales.value==1){
			if(forma.destino.value=="0"){
				msg = msg + "* Debe Seleccionar Destino\n"
				forma.destino.className = "select_faltantes";		
			}	
		}*/	
		
		
		if(forma.retencion_garantia.value=="0"){
			msg = msg + "* Seleccione si Aplica Retencion en Garantia\n"
			forma.retencion_garantia.className = "select_faltantes";		
		}
		
		if(forma.retencion_garantia.value=="1"){
			if(forma.porcen_garantia.value=="0"){
			msg = msg + "* Seleccione el Porcentaje de la Retencion en Garantia\n"
			forma.porcen_garantia.className = "select_faltantes";		
			}
			if(forma.parcial_final_garantia.value=="0"){
			msg = msg + "* Seleccione en que momento Aplica la Retencion en Garantia\n"
			forma.parcial_final_garantia.className = "select_faltantes";		
			}
		}
		
		
		
		if(forma.representante_legal.value==""){
			msg = msg + "* Digite el representante legal\n"
			forma.representante_legal.className = "campos_faltantes";		
		}
		if(forma.telefono2.value==""){
			msg = msg + "* Digite el telefono del representante legal\n"
			forma.telefono2.className = "campos_faltantes";		
		}
		if(forma.email2.value==""){
			msg = msg + "* Digite el email del representante legal\n"
			forma.email2.className = "campos_faltantes";		
		}
		if(forma.fecha_inicio.value==""){
			msg = msg + "* Seleccione la fecha de inicio del contrato\n"
			forma.fecha_inicio.className = "campos_faltantes";		
		}

		if(forma.fecha_fin.value==" " || forma.fecha_fin.value==" " || forma.fecha_fin.value=="	"){
			msg = msg + "* Seleccione la fecha de finalizacion del contrato\n"
			forma.fecha_fin.className = "campos_faltantes";		
		}
	
		if(forma.garantia_seguros.value=="0"){
			msg = msg + "* Seleccione si Garantia y/o Seguros\n"
			forma.garantia_seguros.className = "select_faltantes";		
		}
		var chks = forma.elements['poliza_aplica[]'];
		if(forma.garantia_seguros.value=="1" && chks){
			
			var hasChecked = true;

			for (var i=0;i<chks.length;i++){
				if (chks[i].checked){
					hasChecked = false;
				}
			}
			if (hasChecked==true){
				msg = msg + "* Debe Seleccionar Polizas\n"
				
			}
		}
	}
	


	
	if(msg!=""){
		//alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)
		return
	}else{
		muestra_alerta_general_solo_texto('graba_informacion_contrato_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
	 /*window.parent.document.getElementById("cargando_pecc").style.display = "block"
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			
		}*/
	}
}
function graba_informacion_contrato_continua(){
	var forma = document.principal
	forma.action = "procesos-contratos.html";
			 
			forma.target="grp"
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display=""
}
function muestra_gerente_antiguo(){
	var forma = document.principal
	if(forma.notifica_email.value==1){
		$('.muestra_gerente_antiguo_titulo').css('display', 'block');
	}else{
		forma.gerente_antiguo.value=0;
		$('.muestra_gerente_antiguo_titulo').css('display', 'none');
	}
}
function graba_informacion_poliza(id_poliza){
		var forma = document.principal
		var msg=""

	if(forma.tipo_poliza.value=="0"){
		msg = msg + "* Seleccione el Tipo de Poliza\n"
		forma.tipo_poliza.className = "select_faltantes";		
	}
	if(forma.tipo_moneda.value=="0"){
		msg = msg + "* Seleccione el Tipo de Moneda\n"
		forma.tipo_moneda.className = "select_faltantes";		
	}
	if(forma.valor.value=="0" || forma.valor.value==""){
		msg = msg + "* Digite el Valor Asegurado\n"
		forma.valor.className = "campos_faltantes";		
	}
	if(forma.fecha_inicio.value==""){
		msg = msg + "* Seleccione Fecha Inicio\n"
		forma.fecha_inicio.className = "campos_faltantes";		
	}
	if(forma.fecha_fin.value==""){
		msg = msg + "* Seleccione Fecha Fin\n"
		forma.fecha_fin.className = "campos_faltantes";		
	}
	if(forma.tipo_aseguradora.value=="0"){
		msg = msg + "* Seleccione el Tipo Aseguradora\n"
		forma.tipo_aseguradora.className = "select_faltantes";		
	}else{
		if(forma.tipo_aseguradora.value=="5"){
			if(forma.aseguradora.value==""){
				msg = msg + "* Digite Otra Aseguradora\n"
				forma.aseguradora.className = "campos_faltantes";		
			}
		}
	}
	
	if(msg!=""){

		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)
		//alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		muestra_alerta_general_solo_texto('graba_informacion_poliza_continua('+id_poliza+')', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
	}
}	
function graba_informacion_poliza_continua(id_poliza){
	var forma = document.principal
		forma.action = "procesos-contratos.html";
		if(id_poliza>=1){
			forma.accion.value="graba_poliza_edita" 			
		}else{
			forma.accion.value="graba_poliza_nueva" 			
		}
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
}
function graba_informacion_poliza2(){
		var forma = document.principal
		var msg=""
	if(forma.observaciones.value=="0" || forma.observaciones.value=="" || forma.observaciones.value==null || forma.observaciones.value==" "){
		msg = msg + "* Digite la Observacion\n"
		forma.observaciones.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
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
}
function elimina_poliza(id_poliza){
	var forma = document.principal
	forma.id_poliza.value=id_poliza
		muestra_alerta_general_solo_texto("elimina_poliza_continua()", "Advertencia", "¿Esta seguro de Eliminar esta Poliza?", 20, 10, 18)	
}	
function elimina_poliza_continua(){
	var forma = document.principal
	forma.action = "procesos-contratos.html";
	forma.accion.value="eliminar_poliza"
	forma.target="grp"
	forma.submit()
}
function graba_fecha_contrato (tipo,campo){
	var forma = document.principal
	var msg=""
	
	/*
	if(campo=="recibido_abastecimiento"){
		if(window.parent.document.getElementById(campo).value==""){
			msg = msg + "* Seleccione La fecha\n"
		}
	}else{
		
			if(window.parent.document.getElementById(campo).value!="" && window.parent.document.getElementById(campo+"_e").value=="" ){
				msg = msg + "* Seleccione La fecha de Entrega\n"
			}
		
	}
	*/
	
	if(window.parent.document.getElementById(campo).value!="" && window.parent.document.getElementById(campo+"_e").value=="" ){
		msg = msg + "* Seleccione La fecha de Entrega\n"
	}
	
	if(campo=="firma_hocol"){
		if(window.parent.document.getElementById("sel_representante").value==0){
			msg = msg + "* Seleccione si es representante Hocol o Contratista\n"
			forma.sel_representante.className = "select_faltantes";	
		}else{
			if(window.parent.document.getElementById("sel_representante").value==1 && window.parent.document.getElementById(campo).value!=""){
				
				if(forma.acta_socios.checked==false && forma.aplica_acta.value == 1){
					msg = msg + "* Seleccione Acta de Socios\n"
				}
				
				if(forma.camara_comercio.checked==false){
					msg = msg + "* Seleccione Camara y Comercio\n"
				}
				
				if(forma.no_aplica_poliza.value==0){
					if(forma.recibido_poliza.checked==false){
						msg = msg + "* Seleccione Recibido Poliza\n"
					}
					
					if(forma.recibo_poliza.checked==false){
						msg = msg + "* Seleccione Recibo Poliza\n"
					}
				}
				if(tipo==1){
				if(forma.aplica_acta_inicio.checked==false){
					if(forma.fecha_inicio.value.replace(/\s/g,"")==""){
						msg = msg + "* Seleccione Fecha Inicio\n"
					}
					if(forma.fecha_fin.value.replace(/\s/g,"")==""){
						msg = msg + "* Seleccione Fecha Fin\n"
					}
				}
				}
				
			}	
		}	
	}
	
	if(campo=="firma_contratista"){
		if(window.parent.document.getElementById("sel_representante").value==0){
			msg = msg + "* Seleccione si es representante Hocol o Contratista\n"
			forma.sel_representante.className = "select_faltantes";	
		}else{
			if(window.parent.document.getElementById("sel_representante").value==2 && window.parent.document.getElementById(campo).value!=""){
				
				if(forma.acta_socios.checked==false && forma.aplica_acta.value == 1){
					msg = msg + "* Seleccione Acta de Socios\n"
				}
				
				
				if(forma.camara_comercio.checked==false){
					msg = msg + "* Seleccione Camara y Comercio\n"
				}
				
				if(forma.no_aplica_poliza.value==0){
					if(forma.recibo_poliza.checked==false){
						msg = msg + "* Seleccione Recibo Poliza\n"
					}
					if(forma.recibido_poliza.checked==false){
						msg = msg + "* Seleccione Recibido Poliza\n"
					}
				}
				if(tipo==1){
				if(forma.aplica_acta_inicio.checked==false){
					if(forma.fecha_inicio.value.replace(/\s/g,"")==""){
						msg = msg + "* Seleccione Fecha Inicio\n"
					}
					if(forma.fecha_fin.value.replace(/\s/g,"")==""){
						msg = msg + "* Seleccione Fecha Fin\n"
					}
				}
				}
				
			}	
		}	
	}
	
	if(campo=="revision_poliza" && window.parent.document.getElementById(campo).value!="" && tipo==1){
		if(forma.ok_poliza.value==0){
			msg = msg + "* La Informacion de las Polizas no esta Completa\n"
		}
	}

	if(campo=="legalizacion_final" && window.parent.document.getElementById(campo).value!="" && tipo==1){
		if(forma.estado_proveedor.value!=8){
			//msg = msg + "* El estado de contratista No esta completo\n"
		}
	}
		
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		document.getElementById('boton_fecha_'+campo).innerHTML = 'Cargando';
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(tipo==1){
			forma.accion.value="graba_fecha"
			}
			if(tipo==2){
			forma.accion.value="graba_fecha_co"
			}
			
			forma.campo_fecha.value=campo 			
			forma.target="grp"
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	



function graba_fecha_contrato_sol (tipo,campo,id,id_complemento){
	var forma = document.principal
	var msg=""
	forma.id_contrato_arr_envia.value=id	
	forma.id_complemento.value=id_complemento
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		//var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		//if(alerta){			
			document.getElementById('oculta_botom').innerHTML = 'Recibido Abastecimiento';
			forma.action = "procesos-contratos.html";
			if(tipo==1){
			forma.accion.value="graba_fecha"
			}
			if(tipo==2){
			forma.accion.value="graba_fecha_co"
			}
			
			forma.campo_fecha.value=campo 			
			forma.target="grp"
			forma.submit()

		//}
	}
}	


function activa_otrosi(valor){
	window.parent.document.getElementById("fila1").style.display=""
	//window.parent.document.getElementById("fila2").style.display=""
	window.parent.document.getElementById("fila3").style.display=""
	window.parent.document.getElementById("fila4").style.display=""
	window.parent.document.getElementById("fila5").style.display=""
	window.parent.document.getElementById("fila6").style.display=""
	window.parent.document.getElementById("fila7").style.display=""
	window.parent.document.getElementById("fila8").style.display=""
	window.parent.document.getElementById("fila9").style.display=""
	window.parent.document.getElementById("fila10").style.display=""
		
	if(valor==1){
		window.parent.document.getElementById("fila4").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==2){
		window.parent.document.getElementById("fila1").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		
	}
	
	if(valor==3 || valor==4){
		window.parent.document.getElementById("fila1").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila4").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
		
}
function activa_otrosi_tipo(valor){
	window.parent.document.getElementById("fila2").style.display=""
	window.parent.document.getElementById("fila3").style.display=""
	window.parent.document.getElementById("fila5").style.display=""
	window.parent.document.getElementById("fila6").style.display=""
	window.parent.document.getElementById("fila7").style.display=""
	window.parent.document.getElementById("fila8").style.display=""
	window.parent.document.getElementById("fila9").style.display=""
	window.parent.document.getElementById("fila10").style.display=""
	
	
	if(valor==2){
		
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==3){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==4){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==8){
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==9){
		/*
		//window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"		
		window.parent.document.getElementById("fila8").style.display="none"*/
		window.parent.document.getElementById("fila10").style.display="none"
		
	}
	if(valor==10){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==11){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==12){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==13){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==14){
		//window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==15){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila4").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==16){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila4").style.display="none"
		window.parent.document.getElementById("fila6").style.display="none"
		window.parent.document.getElementById("fila7").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	if(valor==17){
		window.parent.document.getElementById("fila2").style.display="none"
		window.parent.document.getElementById("fila3").style.display="none"
		window.parent.document.getElementById("fila4").style.display="none"
		window.parent.document.getElementById("fila5").style.display="none"
		window.parent.document.getElementById("fila10").style.display="none"
	}
	
}
function graba_informacion_complemento(id_complemento){
		var forma = document.principal
		var msg=""
	
	if(forma.numero_modificacion.value=="0" || forma.numero_modificacion.value=="" ){
		msg = msg + "* Digite el numero del Complemento\n"
		forma.numero_modificacion.className = "campos_faltantes";		
	}else{forma.numero_modificacion.className = "";}
	
	if(forma.tipo_complemento.value=="0"){
		msg = msg + "* Seleccione el Tipo de Complemento\n"
		forma.tipo_complemento.className = "select_faltantes";		
	}else{forma.tipo_complemento.className = "";}
	if(forma.tipo_complemento.value==1){
		if(forma.tipo_otrosi.value=="0"){
			msg = msg + "* Seleccione el Tipo de OtroSI\n"
			forma.tipo_otrosi.className = "select_faltantes";		
		}else{forma.tipo_otrosi.className = "";}
		if(forma.tipo_otrosi.value==8){
			if(forma.gerente.value=="" && id_complemento>=1){
				msg = msg + "* Seleccione el Gerente\n"
				forma.gerente.className = "campos_faltantes";		
			}	
		}
		/*if(forma.tipo_otrosi.value==9){ SE DEJÓ OBLIGATORIO PARA TODOS
			if(forma.observaciones.value==""){
				msg = msg + "* Digite la Observación\n"
				forma.observaciones.className = "textarea_faltantes";		
			}	
		}*/
		if(forma.observaciones.value==""){
			msg = msg + "* Digite la Observación\n"
			forma.observaciones.className = "textarea_faltantes";
		}
		if(forma.clausula.value=="" || forma.clausula.value==" "){
			msg = msg + "* Digite la Cláusula Modificada\n"
			forma.clausula.className = "campos_faltantes";
		}
			
	}
	
	if(forma.congelado.value==1){
			if(forma.obs_congelado.value.replace(/\s/g,"")==""){
				msg = msg + "* Debe Digitar una observacion\n"
				forma.obs_congelado.className = "textarea_faltantes";		
			}	
			
		}	
		if(id_complemento>=1){
		}else{
			if(forma.gerente.value==""){
				msg = msg + "* Seleccione el Gerente\n"
				forma.gerente.className = "campos_faltantes";		
			}else {forma.gerente.className = "";}
			if(forma.tipo_complemento.value==1 || forma.tipo_complemento.value==2){
				if(forma.tipo_otrosi.value!=8 && forma.tipo_otrosi.value!=9){
					if(forma.sol_aprobacion.value==0){
						msg = msg + "* Seleccione la solicitud de aprobacion del SGPA\n"
						forma.sol_aprobacion.className = "select_faltantes";		
					}	else{forma.sol_aprobacion.className = "";}
				}
				
			}
			
			}

	
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)
		//alert("Verifique el formulario\n\n" + msg)
		return
	}else{
			forma.action = "procesos-contratos.html";
			if(id_complemento>=1){
				forma.accion.value="graba_complemento_edita" 
			}else{
				forma.accion.value="graba_complemento_nueva" 
			}
			muestra_alerta_general_solo_texto('graba_informacion_complemento_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
			
	}
}	
function graba_informacion_complemento_continua(){
	var forma = document.principal
	forma.target="grp"
	forma.submit()
}
function elimina_complemento(id_complemento){
		var forma = document.principal
		var msg=""

	
		var alerta = confirm("Esta seguro de Eliminar este Complemento?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			forma.accion.value="eliminar_complemento" 
			forma.id_complemento.value=id_complemento			
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	
}	

function activa_contrcto_otro(valor){
	if(valor==1){
		window.parent.document.getElementById("fila1").style.display=""
	}else{
		window.parent.document.getElementById("fila1").style.display="none"
	}
	
}

function graba_informacion_contacto(id_contacto){
		var forma = document.principal
		var msg=""

	if(forma.tipo_contacto.value=="0"){
		msg = msg + "* Seleccione el tipo de contacto\n"
		forma.tipo_contacto.className = "select_faltantes";		
	}else{
		forma.tipo_contacto.className = "";		
	}
	
	if(forma.celular.value=="" && forma.fijo.value=="" && forma.email.value==""){
		msg = msg + "* Debe digitar por lo menos un Dato de Contacto\n"
		forma.celular.className = "campos_faltantes";
		forma.fijo.className = "campos_faltantes";
		forma.email.className = "campos_faltantes";		
	}else{
		forma.celular.className = "";
		forma.fijo.className = "";
		forma.email.className = "";		
	}
	
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
		return
	}else{
		forma.action = "procesos-contratos.html";
		if(id_contacto>=1){
			forma.accion.value="graba_contacto_edita" 
		}else{
			forma.accion.value="graba_contacto_nueva" 
		}
		muestra_alerta_general_solo_texto('graba_informacion_contacto_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
			forma.target="grp"
			forma.submit()
	}
	
}	
function graba_informacion_contacto_continua(){
	var forma = document.principal
	forma.target="grp"
	forma.submit()
}
function elimina_contacto(id_contacto){
		var forma = document.principal
		var msg=""

	
		var alerta = confirm("Esta seguro de Eliminar este Contacto?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			forma.accion.value="eliminar_contacto" 
			forma.id_contacto.value=id_contacto			
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	
}	

function graba_informacion_documento(id_documento){
		var forma = document.principal
		var msg=""

	if(forma.tipo_documento.value=="0"){
		msg = msg + "* Seleccione el tipo de Documento\n"
		forma.tipo_documento.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
		return
	}else{
		muestra_alerta_general_solo_texto('graba_informacion_documento_continua()', 'Advertencia', '¿Esta seguro de Grabar esta Informacion?', 20, 10, 18)
			forma.action = "procesos-contratos.html";
			if(id_documento>=1){
				forma.accion.value="graba_documento_edita" 
			}else{
				forma.accion.value="graba_documento_nueva" 
			}
	}
}
function graba_informacion_documento_continua(){
	var forma = document.principal
	forma.target="grp"
	forma.submit()
}
function graba_contrato_area(){
		var forma = document.principal
		var msg=""

	if(forma.id_area.value=="0"){
		msg = msg + "* Seleccione una area\n"
		forma.id_area.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("¿Está seguro de agregar esta área a este contrato?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			forma.accion.value="graba_contrato_area"
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}

function elimina_contrato_area(id){
	var forma = document.principal
	var alerta = confirm("¿Está seguro de eliminar esta área a este contrato?")
	if(alerta){
		forma.id_elimina.value=id
		forma.action = "procesos-contratos.html";
		forma.accion.value="elimina_contrato_area"
		forma.target="grp"
		forma.submit()
		window.parent.document.getElementById("cargando").style.display=""
	}
}

function elimina_documento(id_documento){
		var forma = document.principal
		var msg=""

	
		var alerta = confirm("Esta seguro de Eliminar este Contacto?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			forma.accion.value="eliminar_documento" 
			forma.id_documento.value=id_documento			
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	
}	
//evaluador********************************************
function graba_tipo_pregunta(id_tipo_pregunta){
	var forma = document.principal
	var msg=""
	
	if(forma.nombre.value==""){
		msg = msg + "* Digite el Nombre de la Plantilla\n"
		forma.nombre.className = "textarea_faltantes";		
	}
	for(var i=1;i<=5;i++){
		if(window.parent.document.getElementById("puntaje_"+i).value!=""){
			if(window.parent.document.getElementById("texto_"+i).value==""){
					msg = msg + "* Digite Texto a puntaje "+window.parent.document.getElementById("puntaje_"+i).value+" \n"
					forma.nombre.className = "textarea_faltantes";
			}
		}
		if(window.parent.document.getElementById("texto_"+i).value!=""){
			if(window.parent.document.getElementById("puntaje_"+i).value==""){
					msg = msg + "* Digite Puntaje a Texto "+window.parent.document.getElementById("texto_"+i).value+" \n"
					forma.nombre.className = "textarea_faltantes";
			}
		}
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(id_tipo_pregunta==99){
				forma.accion.value="graba_tipo_pregunta_nuevo" 			
			}else{
				forma.accion.value="graba_tipo_pregunta_edita" 			
			}
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	

function graba_grupo(id_grupo){
	var forma = document.principal
	var msg=""
	
	if(forma.nombre.value==""){
		msg = msg + "* Digite el Nombre del Grupo \n"
		forma.nombre.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(id_grupo==99){
				forma.accion.value="graba_grupo_nuevo" 			
			}else{
				forma.accion.value="graba_grupo_edita" 			
			}
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	

function graba_pregunta(id_pregunta){
	var forma = document.principal
	var msg=""
	
	if(forma.grupo.value=="0"){
		msg = msg + "* Seleccione el Grupo\n"
		forma.grupo.className = "textarea_faltantes";		
	}
	
	if(forma.pregunta.value==""){
		msg = msg + "* Digite La Pregunta\n"
		forma.pregunta.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(id_pregunta==99){
				forma.accion.value="graba_pregunta_nuevo" 			
			}else{
				forma.accion.value="graba_pregunta_edita" 			
			}
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	
function graba_plantilla(id_plantilla){
	var forma = document.principal
	var msg=""
	
	if(forma.nombre.value==""){
		msg = msg + "* Digite el Nombre de la Plantilla \n"
		forma.nombre.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(id_plantilla==0){
				forma.accion.value="graba_plantilla_nuevo" 			
			}else{
				forma.accion.value="graba_plantilla_edita" 			
			}
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	
function valida_cien_int_grupo(id_grupo,id_pregunta_actual){
	var forma = document.principal
	var suma_fin = 0
	var suma_ba = 0
	
	if(id_grupo==0){
		for(i=1;i<=forma.con_pregunta.value;i++){	
			valor_par = 0	
			if(window.parent.document.getElementById("tipo_pregunta_"+i).value != ""){
				if(parseInt(window.parent.document.getElementById("tipo_pregunta_"+i).value)<=100){
					valor_par = parseInt(window.parent.document.getElementById("tipo_pregunta_"+i).value)
					suma_fin = suma_fin + valor_par
				}else{
					alert("El valor del peso Pregunta no puede Exceder 100")
					window.parent.document.getElementById("tipo_pregunta_"+i).value=""
				}
			}
			
			window.parent.document.getElementById("total_pre_").value=suma_fin
			if(suma_fin>100){
				suma_fin = suma_fin - parseInt(window.parent.document.getElementById("tipo_pregunta_"+id_pregunta_actual).value)
				alert("La Suma de los Puntajes no puede Exceder 100")
				window.parent.document.getElementById("tipo_pregunta_"+id_pregunta_actual).value=""
				window.parent.document.getElementById("total_pre_").value=suma_fin
			}
			
			window.parent.document.getElementById("graba_tbg_b").disabled = ""
			
			if(suma_fin<100){		
				window.parent.document.getElementById("graba_tbg_b").disabled = "disabled"
			}
		}
	}else{
		array_pregunta_grupo = window.parent.document.getElementById("arr_pregunta_grupo_"+id_grupo).value 
		array_pregunta_grupo_fin =array_pregunta_grupo.split(",") 
		for(i=0;i<array_pregunta_grupo_fin.length;i++){	
			valor_par = 0	
			if(window.parent.document.getElementById("aplica_pregunta_"+array_pregunta_grupo_fin[i]).value != ""){
				if(parseInt(window.parent.document.getElementById("aplica_pregunta_"+array_pregunta_grupo_fin[i]).value)<=100){
					valor_par = parseInt(window.parent.document.getElementById("aplica_pregunta_"+array_pregunta_grupo_fin[i]).value)
					suma_fin = suma_fin + valor_par
				}else{
					alert("El valor del peso Pregunta no puede Exceder 100")
					window.parent.document.getElementById("aplica_pregunta_"+id_pregunta_actual).value=""
				}
			}
			
			window.parent.document.getElementById("total_pre_"+id_grupo).value=suma_fin
			if(suma_fin>100){
				suma_fin = suma_fin - parseInt(window.parent.document.getElementById("aplica_pregunta_"+id_pregunta_actual).value)
				alert("La Suma de los Puntajes no puede Exceder 100")
				window.parent.document.getElementById("aplica_pregunta_"+id_pregunta_actual).value=""
				window.parent.document.getElementById("total_pre_"+id_grupo).value=suma_fin
			}
			
			window.parent.document.getElementById("graba_tbg_b").disabled = ""
			
			if(suma_fin<100){		
				window.parent.document.getElementById("graba_tbg_b").disabled = "disabled"
			}
		}	
	}
	
	valida_cien()
}

function valida_cien(){
	var forma = document.principal
	var suma_fin = 0
	var int_si = 0
	
	array_grupo = forma.array_grupo_env.value
	array_grupo_fin =array_grupo.split(",") 
	for(i=0;i<array_grupo_fin.length;i++){	
		if(array_grupo_fin[i]!=5){
			valor_par = 0	
			if(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value != "" && window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value != "0"){
				valor_par = parseInt(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value)
				if(window.parent.document.getElementById("total_pre_"+array_grupo_fin[i]).value<100){
					int_si = 1
				}
			}
			suma_fin = suma_fin + valor_par
		}
	}	
	valor_par = 0	
	valor_par = parseInt(window.parent.document.getElementById("puntaje_grupo_5").value)
	if(valor_par>20){
		alert("El valor Agregado no Puede ser mayor a 20")
		window.parent.document.getElementById("puntaje_grupo_5").value = ""
	}
			
	valor_par = 0	
	if(window.parent.document.getElementById("puntaje_grupo_tbg").value != "" && window.parent.document.getElementById("puntaje_grupo_tbg").value != "0"){
		valor_par = parseInt(window.parent.document.getElementById("puntaje_grupo_tbg").value)		
		if(window.parent.document.getElementById("total_pre_").value<100){
			int_si = 1
		}
	}

	suma_fin = suma_fin + valor_par
	if(suma_fin > 100){
		alert("La suma de los Grupos no debe ser mas de 100 Puntos")
		window.parent.document.getElementById("graba_tbg_b").disabled = "disabled"
	}else{
		if(suma_fin == 100){
			if(int_si==0){
				window.parent.document.getElementById("graba_tbg_b").disabled = ""
			}else{
				window.parent.document.getElementById("graba_tbg_b").disabled = "disabled"
			}
		}else{
			window.parent.document.getElementById("graba_tbg_b").disabled = "disabled"
		}
	}
	
	
}
function suma_cien(){
	var forma = document.principal
	var suma_fin = 0
	
	array_grupo = forma.array_grupo_todos_env.value
	array_grupo_fin =array_grupo.split(",") 
	for(i=0;i<array_grupo_fin.length;i++){	
		if(array_grupo_fin[i]!=5){
			valor_par = 0	
			if(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value != "" && window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value != "0"){
				valor_par = parseInt(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value)
			}
			suma_fin = suma_fin + valor_par
		}
	}	
	valor_par = 0	
	if(window.parent.document.getElementById("puntaje_grupo_tbg").value != "" && window.parent.document.getElementById("puntaje_grupo_tbg").value != "0"){
		valor_par = parseInt(window.parent.document.getElementById("puntaje_grupo_tbg").value)
	}

	suma_fin = suma_fin + valor_par
	window.parent.document.getElementById("total").value = suma_fin
}

function calcular_valor(){
	var forma = document.principal
	var suma_fin = 0
	var suma_fin2 = 0
	var suma_fin3 = 0
	var peso_grupo = 0
	var peso_pregunta = 0
	var peso_acumulado_grupo = 0
	var peso_acumulado_grupo_fin = 0
	var calificacion = 0
	var calificacion_par = 0
	var calificacion_par2 = 0
	
	array_grupo = forma.array_enviar.value
	array_grupo_fin =array_grupo.split("|") 
	
	for(i=0;i<array_grupo_fin.length;i++){	
		array_grupo_int = array_grupo_fin[i]
		array_grupo_int_fin =array_grupo_int.split(";") 		
			window.parent.document.getElementById("total2_"+array_grupo_int_fin[0]).value=0
	}	
	window.parent.document.getElementById("total3").value=0

	for(i=0;i<array_grupo_fin.length;i++){	
		array_grupo_int = array_grupo_fin[i]
		array_grupo_int_fin =array_grupo_int.split(";") 		
		if(array_grupo_int_fin[0]!=0){
			peso_grupo = parseInt(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_int_fin[0]).value)
			
			peso_acumulado_grupo = parseFloat(window.parent.document.getElementById("total2_"+array_grupo_int_fin[0]).value)
			peso_acumulado_grupo = peso_acumulado_grupo.toFixed(2)
			peso_acumulado_grupo = parseFloat(peso_acumulado_grupo)
			
			peso_acumulado_grupo_fin = parseFloat(window.parent.document.getElementById("total3").value)
			peso_acumulado_grupo_fin = peso_acumulado_grupo_fin.toFixed(2)
			peso_acumulado_grupo_fin = parseFloat(peso_acumulado_grupo_fin)
			
			if(window.parent.document.getElementById("calificacion_"+array_grupo_int_fin[1]).value != ""){
				calificacion = parseInt(window.parent.document.getElementById("calificacion_"+array_grupo_int_fin[1]).value)
				if(calificacion>100){
					alert("La calificacion no Puede ser mayor a 100")
					window.parent.document.getElementById("calificacion_"+array_grupo_int_fin[1]).value = ""
					calificacion = parseInt(0)
				}
			}else{
				calificacion = parseInt(0)
			}
			
			peso_pregunta = parseInt(window.parent.document.getElementById("peso_pregunta_"+array_grupo_int_fin[1]).value)
			
			if(peso_grupo != "" && calificacion!= ""){
				suma_fin = ((((peso_pregunta*calificacion)/100)*peso_grupo)/100).toFixed(2) 								
				suma_fin = parseFloat(suma_fin)
				
				calificacion_par = ((((peso_pregunta*calificacion)/100))).toFixed(2) 
				calificacion_par = parseFloat(calificacion_par)

				calificacion_par2 = (peso_acumulado_grupo+calificacion_par).toFixed(2) 
				calificacion_par2 = parseFloat(calificacion_par2)
				
				suma_fin2 = (peso_acumulado_grupo+suma_fin).toFixed(2) 
				suma_fin2 = parseFloat(suma_fin2)
				suma_fin3 = (peso_acumulado_grupo_fin+suma_fin).toFixed(2) 
				suma_fin3 = parseFloat(suma_fin3)
				
				window.parent.document.getElementById("total2_"+array_grupo_int_fin[0]).value=calificacion_par2
				window.parent.document.getElementById("total3").value=suma_fin3
			}
		}else{
			peso_grupo = parseInt(window.parent.document.getElementById("puntaje_grupo_tbg").value)
			
			peso_acumulado_grupo = parseFloat(window.parent.document.getElementById("total2_"+array_grupo_int_fin[0]).value)
			peso_acumulado_grupo = peso_acumulado_grupo.toFixed(2)
			peso_acumulado_grupo = parseFloat(peso_acumulado_grupo)
			
			peso_acumulado_grupo_fin = parseFloat(window.parent.document.getElementById("total3").value)
			peso_acumulado_grupo_fin = peso_acumulado_grupo_fin.toFixed(2)
			peso_acumulado_grupo_fin = parseFloat(peso_acumulado_grupo_fin)
			

			if(window.parent.document.getElementById("calificacion_tbg_"+array_grupo_int_fin[1]).value != ""){
				calificacion = parseInt(window.parent.document.getElementById("calificacion_tbg_"+array_grupo_int_fin[1]).value)
				if(calificacion>100){
					alert("La calificacion no Puede ser mayor a 100")
					window.parent.document.getElementById("calificacion_tbg_"+array_grupo_int_fin[1]).value = ""
					calificacion = parseInt(0)
				}
			}else{
				calificacion = parseInt(0)
			}
			peso_pregunta = parseInt(window.parent.document.getElementById("peso_pregunta_tbg_"+array_grupo_int_fin[1]).value)
			
			if(peso_grupo != 0 && peso_pregunta!= 0){
				suma_fin = ((((peso_pregunta*calificacion)/100)*peso_grupo)/100).toFixed(2) 
				suma_fin = parseFloat(suma_fin)
				
				calificacion_par = ((((peso_pregunta*calificacion)/100))).toFixed(2) 
				calificacion_par = parseFloat(calificacion_par)

				calificacion_par2 = (peso_acumulado_grupo+calificacion_par).toFixed(2) 
				calificacion_par2 = parseFloat(calificacion_par2)
				
				suma_fin2 = (peso_acumulado_grupo+suma_fin).toFixed(2) 
				suma_fin2 = parseFloat(suma_fin2)
				suma_fin3 = (peso_acumulado_grupo_fin+suma_fin	).toFixed(2) 
				suma_fin3 = parseFloat(suma_fin3)
				
				window.parent.document.getElementById("total2_"+array_grupo_int_fin[0]).value=calificacion_par2
				window.parent.document.getElementById("total3").value=suma_fin3	
			}
		}
	}	

	
}


function graba_tbg(){
	var forma = document.principal
	var msg=""
	var array_puntaje_grupo = ""
	var coma = ""
	var entro = 0
	
		if(window.parent.document.getElementById("puntaje_grupo_tbg").value!=0 && window.parent.document.getElementById("puntaje_grupo_tbg").value!=""){
			for(fr=1;fr<=forma.con_pregunta.value;fr++){	
				if(window.parent.document.getElementById("pregunta_"+fr).value == "" && window.parent.document.getElementById("tipo_pregunta_"+fr).value!=0){
					msg = msg + "* Digite la Pregunta\n"
					window.parent.document.getElementById("pregunta_"+fr).className = "textarea_faltantes";		
				}					
				if(window.parent.document.getElementById("pregunta_"+fr).value != "" && window.parent.document.getElementById("tipo_pregunta_"+fr).value==0){
					msg = msg + "* Seleccione Tipo Pregunta\n"
					window.parent.document.getElementById("tipo_pregunta_"+fr).className = "select_faltantes";		
				}	
				if(window.parent.document.getElementById("pregunta_"+fr).value != "" && window.parent.document.getElementById("tipo_pregunta_"+fr).value!=0){
					entro=1		
				}					
				
			}
			if(entro == 0){
				msg = msg + "* Debe Digitar Por lo menos una Pregunta.\n"
			}
		}	else{
				if(forma.con_pregunta.value>=1){
					msg = msg + "* Debe Digitar El peso del TBG.\n"
				}
		
		}
	
	array_grupo = forma.array_grupo_todos_env.value
	array_grupo_fin =array_grupo.split(",") 
	
	for(i=0;i<array_grupo_fin.length;i++){	
		if(array_puntaje_grupo!="")
			coma= ","
			
			if(window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value==""){
				array_puntaje_grupo = array_puntaje_grupo+coma+"0"	
			}else{
				array_puntaje_grupo = array_puntaje_grupo+coma+window.parent.document.getElementById("puntaje_grupo_"+array_grupo_fin[i]).value
			}
		
	}	

	array_puntaje_grupo = array_puntaje_grupo+coma+window.parent.document.getElementById("puntaje_grupo_tbg").value
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){		
			forma.action = "procesos-contratos.html";
			forma.accion.value="graba_plantilla_tbg" 			
			forma.puntaje_final.value= array_puntaje_grupo
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""		
		}
	}
}	

function graba_pregunta2(id_pregunta){
	var forma = document.principal
	var msg=""
	
	if(forma.nombre.value==""){
		msg = msg + "* Digite la Pregunta \n"
		forma.nombre.className = "textarea_faltantes";		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(id_pregunta==99){
				forma.accion.value="graba_pregunta_nuevo2" 			
			}else{
				forma.accion.value="graba_pregunta_edita2" 			
			}
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	
//evaluador********************************************

function cargar_formulario_evaluador(id_evaluacion,requiere_edicion,id_contrato,peso_tgb,marco){
	var msg=""
	if(marco==2){
		if(document.getElementById('orden_trabajo').value==0){
			msg=msg+"*Seleccione OT \n"
		}
	}
	if(id_evaluacion==0){
		msg=msg+"*Seleccione Tipo Plantilla \n"
	}
	if(requiere_edicion==0){
		msg=msg+"*Seleccione Si requiere Edicion \n"
	}
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		document.getElementById('carga_plantilla_evaluador').innerHTML = '';
		
		if(requiere_edicion==1){
			ajax_carga('../aplicaciones/contratos/c_evaluacion.php?id_evaluacion='+id_evaluacion+'&requiere_edicion='+requiere_edicion+'&id_contrato='+id_contrato+'&peso_tbg_env='+peso_tgb,'carga_plantilla_evaluador')
		}
		
		if(requiere_edicion==2){
			ajax_carga('../aplicaciones/contratos/c_evaluacion_final.php?id_evaluacion='+id_evaluacion+'&requiere_edicion='+requiere_edicion+'&id_contrato='+id_contrato,'carga_plantilla_evaluador')
		}
	}
}

function agrega_pregunta(id,ano,nombre_boton,tipo) {
	var forma = document.principal
	var numero_actual = id.substring(2,4)

		numero_siguiente = (numero_actual*1+1)
		nombre_boton.id = "c_" + numero_siguiente
		
		con_pregunta = "con_pregunta"
		forma.elements[con_pregunta].value = numero_actual
		ajax_carga('../aplicaciones/contratos/ajax.php?numero_actual='+numero_actual+'&numero_siguiente=' + numero_siguiente + '&tipo='+tipo	,'div_pregunta_'+numero_actual)
		
}

function graba_plantilla_fin(id_plantilla){
	var forma = document.principal
	var msg=""
	
	
	
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			forma.accion.value="graba_plantilla_final" 			
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	

function carga_sel_representante (valor){
	if(valor==1){
		ajax_carga('../aplicaciones/contratos/ajax.php?id_sel_representante='+valor+'&tipo=2','div_sel_representante')	
	}else{
		document.getElementById('div_sel_representante').innerHTML = '';
	}
	
}

function valida_ponderado(id_grupo,id_pregunta_actual){
	var forma = document.principal
	var suma_fin = 0
	var suma_ba = 0
	alert(window.parent.document.getElementById("array_enviar").value )
	
}

function activa_fecha_paralelo2(){
	var forma = document.principal
	if(forma.activa_fecha_paralelo.checked==false){
		window.parent.document.getElementById("fila_paralelo").style.display="none"
	}else{
		window.parent.document.getElementById("fila_paralelo").style.display=""
	}
}
				

function graba_fecha_contrato_parale (tipo,campo){
	var forma = document.principal
	var msg=""

	
		
	if(msg!=""){
		alert("Verifique el formulario\n\n" + msg)
		return
	}else{
		var alerta = confirm("Esta seguro de Grabar esta Informacion?")
		if(alerta){
			forma.action = "procesos-contratos.html";
			if(tipo==1){
			forma.accion.value="graba_fecha_pa"
			}
			if(tipo==2){
			forma.accion.value="graba_fecha_co_pa"
			}
			
			forma.campo_fecha.value=campo 			
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
		}
	}
}	

function carga_detalle_sol(id_item_pecc){
	text = window.document.getElementById("array_id_item_pecc_env").value
	var new_text = text.split(',');
	
	for (var i=0;i<new_text.length;i++){
		document.getElementById('detalle_solicitud_'+new_text[i]).innerHTML = '';		
	}


	ajax_carga('../aplicaciones/contratos/reportes/marco_detalle.php?id_item_pecc_env='+id_item_pecc,'detalle_solicitud_'+id_item_pecc)
	
}

function activa_otroase(valor){
	
	if(valor==5){
		window.parent.document.getElementById("div_aseguradora").style.display=""
	}else{
		window.parent.document.getElementById("div_aseguradora").style.display="none"
	}
		
}

function acciones_admin_contratos() {
    var forma = document.principal
    var mensaje = "";

    if (forma.acci1.value == 1) {
        mensaje = "\n * Va a Eliminar este contrato de los Historicos";
        if (forma.file_delete.value == "") {
        	muestra_alerta_error_solo_texto('', 'Error', 'Debe Seleccionar un archivo adjunto para poder eliminar este proceso', 20, 10, 18)
            //alert("Debe Seleccionar un archivo adjunto para poder eliminar este proceso");
            return;
        }
        if (forma.ob1.value == "" || forma.ob1.value == " ") {
        	muestra_alerta_error_solo_texto('', 'Error', 'Para Eliminar un contrato debe digitar una observación', 20, 10, 18)
            //alert("Para Eliminar un contrato debe digitar una observación");
            return;
        }
    }
    muestra_alerta_general_solo_texto('acciones_admin_contratos_continua()', 'Advertencia', '¿Esta Seguro de Realizar estos Cambios?'+mensaje, 20, 10, 18)
        //window.parent.document.getElementById("cargando_pecc").style.display = "block"
}

function acciones_admin_contratos_continua(){
	var forma = document.principal
    forma.action = "procesos-contratos.html";
    forma.accion.value = "acciones_admin_contratos"
	forma.target = "grp"
    forma.submit()
}