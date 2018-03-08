

function exporta_tarifas_consulta()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
function elminar_cargue_masivo_previo(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="eliminar_cargue_previo" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('elminar_cargue_masivo_previo_continua()', 'Advertencia', '¿Esta seguro de eliminar el cargue previo?', 20, 10, 18)
}
/*function elminar_cargue_masivo_previo_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="eliminar_cargue_previo" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function valida_graba_reembolsable_temporal(id_rem_elim){
	var forma = document.principal
	forma.id_rem_elimina.value=id_rem_elim
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_reembolsable_temporal" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('valida_graba_reembolsable_temporal_continua()', 'Advertencia', '¿Esta seguro de eliminar este reembolsable temporal?', 20, 10, 18)
}
/*function valida_graba_reembolsable_temporal_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_reembolsable_temporal" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function valida_graba_tiquete_temporal(id_pre_elim){
	var forma = document.principal
	forma.id_pre_elimina.value=id_pre_elim
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_tiquete_temporal" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('valida_graba_tiquete_temporal_continua()', 'Advertencia', '¿Esta seguro de eliminar este tiquete temporal?', 20, 10, 18)
	
}
/*function valida_graba_tiquete_temporal_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_tiquete_temporal" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function busqueda_paginador_nuevo_tarifas_pro(pagina,ruta_pagina,espacio,numero_input)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			var campos_valor = "";
			

		for (i=0;i<numero_input;i++)
			 {
			 	if((forma.elements[i].type!="checkbox") && (forma.elements[i].type!="button")){
				campos_valor = forma.elements[i].value;
				var resul = campos_valor.replace(/&/gi, encodeURIComponent("&"));
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + resul
				
				}
			}
			

//	compl = "actividad_pru=" + cadena_str
	


	ajax_carga(ruta_pagina + '?pag=' + pagina + '&' + cadena_str,espacio)
	
	
	
	}	

function crea_lista_tarifa_manual(activaalerta){
		var forma = document.principal
		var msg=""

	if(forma.categoria.value==""){
			msg = msg + "* Digite la categoria\n"
			forma.categoria.className = "campos_faltantes";		
		}
	if(forma.codigo.value==""){
			msg = msg + "* Digite el Item Oferta Proveedor\n"
			forma.codigo.className = "campos_faltantes";		
		}		
	if(forma.detalle.value==""){
			msg = msg + "* Digite el detalle de la tarifa\n"
			forma.detalle.className = "textarea_faltantes";		
		}
		
	if(forma.unidad.value==""){
			msg = msg + "* Digite la unidad de medida de la tarifa\n"
			forma.unidad.className = "campos_faltantes";		
		}

	if(forma.fecha_vigencia.value==""){
			msg = msg + "* Seleccione la fecha de inicio de vigencia\n"
			forma.fecha_vigencia.className = "campos_faltantes";		
		}

	if(forma.moneda.value==""){
			msg = msg + "* Digite la moneda de la tarifa\n"
			forma.detalle.className = "campos_faltantes";		
		}

	if(forma.valor.value==""){
			msg = msg + "* Digite el valor de la tarifa\n"
			forma.valor.className = "campos_faltantes";		
		}

		if(msg!=""){
			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)
			//alert("Verifique el formulario\n" + msg)
			return
		}
		else{
			//PARA EL DES098
			if(activaalerta == ""){
				window.parent.muestra_alerta_general_solo_texto('crea_lista_tarifa_manual(12)', 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
				return;
			}
			forma.action = "procesos-tarifas-proveedores.html";
			forma.accion.value="crea_tarifa_manual" 
			forma.target="grp"
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
			//muestra_alerta_general_solo_texto('crea_lista_tarifa_manual_continua()', 'Advertencia', '¿Esta seguro de crear este registro?', 20, 10, 18)
		}
}
/*function crea_lista_tarifa_manual_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="crea_tarifa_manual" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}]*/
function edita_creacion_tarifa(trre)
{
					
							var forma = document.principal
		var msg=""
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="modifica_crea_tarifa_manual" 
					forma.id_tarifa.value = trre
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
	}

function elimina_creacion_tarifa(trre){
	var forma = document.principal
	forma.id_tarifa.value = trre
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_crea_tarifa_manual"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('elimina_creacion_tarifa_continua()', 'Advertencia', '¿Esta seguro de eliminar esta tarifa?', 20, 10, 18)
}
/*function elimina_creacion_tarifa_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_crea_tarifa_manual"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function elimina_ane_modifica(trre){
	var forma = document.principal
	forma.id_tarifa.value = trre
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_crea_tarifa_manual_anexo"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('elimina_ane_modifica_continua()', 'Advertencia', '¿Esta seguro de eliminar este anexo?', 20, 10, 18)
}	
/*function elimina_ane_modifica_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_crea_tarifa_manual_anexo"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function edita_tarifa(id_tarifa,campo_valor,activaalerta){
	

	var forma = document.principal
	if(campo_valor==""){
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el valor de la tarifa', 20, 10, 18)
			//alert("* Digite el valor de la tarifa")
			forma.campo.className = "campos_faltantes";
			return;
	}else{
		//PARA EL DES098
		if(activaalerta == ""){
			window.parent.muestra_alerta_general_solo_texto("edita_tarifa(-comillas-"+id_tarifa+"-comillas-,"+campo_valor+",12)", 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
			return;
		}else{
		forma.id_tarifa.value=id_tarifa
		forma.action = "procesos-tarifas-proveedores.html";
		forma.accion.value="modificar_tarifas"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		}
		//muestra_alerta_general_solo_texto('edita_tarifa_continua()', 'Advertencia', '¿Esta seguro de modificar esta tarifa?', 20, 10, 18)
	}
}	
/*function edita_tarifa_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="modificar_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function confirma_creacion(vd,t_g){
		var forma = document.principal

	if(vd==1)
		{
			if (forma.valor_descuento.value=="")
				{
					muestra_alerta_error_solo_texto('', 'Error', 'Este contrato tiene pactado descuentos * Si no aplica descuentos digite el valor 0 * Digite la razón por la cual no aplica el descuento', 40, 8, 12)
						//alert("ATENCIÓN: este contrato tiene pactado descuentos\n Si no aplica descuentos digite el valor 0\n Digite la razón por la cual no aplica el descuento")
						forma.valor_descuento.className = "campos_faltantes";
						return;
					
					}
			if( forma.detalle_descuento.value=="") 
				{
					if( (forma.valor_descuento.value=="") || (forma.valor_descuento.value==0) )
															  
						{
							muestra_alerta_error_solo_texto('', 'Error', 'Este contrato tiene pactado descuentos * Digite la razón por la cual no aplica el descuento', 40, 8, 12)
							//alert("ATENCIÓN: este contrato tiene pactado descuentos\n  Digite la razón por la cual no aplica el descuento")
							forma.detalle_descuento.className = "campos_faltantes";
							return;
						
							}									  
															  
				}
			
			}

	if(forma.c_marco.value=="0"){
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si el contrato es de tipo marco', 20, 10, 18)
			//alert("* Seleccione si el contrato es de tipo marco ")
			return;
	}
	if((forma.c_marco.value=="1") && (forma.orden_trabajo.value=="") ){
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de orden de trabajo', 20, 10, 18)
		//alert("* Digite el numero de orden de trabajo ")
		return;
	}
	 
		forma.tipo_de_grabacion.value = t_g;
		forma.action = "procesos-tarifas-proveedores.html";
		forma.accion.value="prefactura_temporal"
		//forma.id_tarifa.value=id_tarifa
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		//muestra_alerta_general_solo_texto('confirma_creacion_continua()', 'Advertencia', '¿Esta seguro de poner en firme este tiquete de servicios?', 20, 10, 18)
}
/*function confirma_creacion_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="prefactura_temporal"
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function confirma_actualizacion(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="confirma_actualizacion" 
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('confirma_actualizacion_continua()', 'Advertencia', '¿Esta seguro de confirmar la actualización de tarifas?', 20, 10, 18)
}	
/*function confirma_actualizacion_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="confirma_actualizacion" 
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function confirma_actualizacion_crea(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="crea_confirma_actualizacion" 
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('confirma_actualizacion_crea_continua()', 'Advertencia', '¿Esta seguro de confirmar la creación de tarifas?', 20, 10, 18)
}	
/*function confirma_actualizacion_crea_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="crea_confirma_actualizacion" 
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function prefactura_temporal(t_g, muestra_alerta){
		var forma = document.principal



	if(forma.fecha_inicial.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha inicial del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha inicial del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if(forma.fecha_final.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha final del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha final del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if ( (forma.aiu_a.value<=2) && (forma.aiu_a_p.value==0) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el porcenatje de administración', 20, 10, 18)
			//alert("* Seleccione el porcenatje de administración")
			forma.aiu_a_p.className = "campos_faltantes";
			return;
		
		}

	if ( (forma.aiu_a.value>=3) && (forma.aiu_a_p.value>=1) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si la administración suma o resta al costo total', 20, 10, 18)
			//alert("* Seleccione si la administración suma o resta al costo total")
			forma.aiu_a.className = "campos_faltantes";
			return;
		
		}
		
		
	if ( (forma.aiu_i.value<=2) && (forma.aiu_i_p.value==0) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el porcenatje de imprevistos', 20, 10, 18)
			//alert("* Seleccione el porcenatje de imprevistos")
			forma.aiu_i_p.className = "campos_faltantes";
			return;
		
		}

	if ( (forma.aiu_i.value>=3) && (forma.aiu_i_p.value>=1) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si los imprevistos suman o restan al costo total', 20, 10, 18)
			//alert("* Seleccione si los imprevistos suman o restan al costo total")
			forma.aiu_i.className = "campos_faltantes";
			return;
		
		}	
		

	if ( (forma.aiu_u.value<=2) && (forma.aiu_u_p.value==0) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el porcenatje de utilidad', 20, 10, 18)
			//alert("* Seleccione el porcenatje de utilidad")
			forma.aiu_u_p.className = "campos_faltantes";
			return;
		
		}

	if ( (forma.aiu_u.value>=3) && (forma.aiu_u_p.value>=1) )
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si la utilidad suma o resta al costo total', 20, 10, 18)
			//alert("* Seleccione si la utilidad suma o resta al costo total")
			forma.aiu_u.className = "campos_faltantes";
			return;
		
		}		
		
	if(forma.c_marco.value=="0")

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si el contrato es de tipo marco', 20, 10, 18)
			//alert("* Seleccione si el contrato es de tipo marco ")
			return;
		
		}		
						
	if((forma.c_marco.value=="1") && (forma.orden_trabajo.value=="") )

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de orden de trabajo', 20, 10, 18)
			//alert("* Digite el numero de orden de trabajo ")
			return;
		
		}

	else
		{

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="prefactura_temporal" 
					forma.tipo_de_grabacion.value=t_g
					forma.muestra_alerta.value=muestra_alerta
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
		}

	}		
	


function prefactura_temporal_crea(t_g){
		var forma = document.principal



	if(forma.fecha_inicial.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha inicial del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha inicial del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if(forma.fecha_final.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha final del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha final del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}
	
	if(forma.tp_moneda.value=="0")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la moneda del tiquete de servicio', 20, 10, 18)
			//alert("* Seleccione la moneda del tiquete de servicio")
			forma.tp_moneda.className = "* Select_faltantes";
			return;
			
			}

	
		
	if(forma.c_marco.value=="0")

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione si el contrato es de tipo marco', 20, 10, 18)
			//alert("* Seleccione si el contrato es de tipo marco ")
			return;
		
		}		
						
	if((forma.c_marco.value=="1") && (forma.orden_trabajo.value=="") )

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de orden de trabajo', 20, 10, 18)
			//alert("* Digite el numero de orden de trabajo ")
			return;
		
		}

	else
		{

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="prefactura_temporal" 
					forma.tipo_de_grabacion.value=t_g
				
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
		}

	}		


function reembolsable_temporal(){
		var forma = document.principal


	

	if(forma.fecha_inicial.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha inicial del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha inicial del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if(forma.fecha_final.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha final del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha final del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if((forma.c_marco.value=="1") && (forma.orden_trabajo.value=="") )

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de orden de trabajo', 20, 10, 18)
			//alert("* Digite el numero de orden de trabajo ")
			return;
		
		}


	else
		{

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="prefactura_reembolsable" 
				
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
		}

	}			
	
	

	

function crea_item_re(){
		var forma = document.principal


	if(forma.categoria_reem.value=="0")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione una categoria', 20, 10, 18)
			//alert("* Seleccione una categoria")
			forma.categoria_reem.className = "campos_faltantes";
			return;
			
			}

	if(forma.valor_r.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el valor', 20, 10, 18)
			//alert("* Digite el valor")
			forma.valor_r.className = "campos_faltantes";
			return;
			
			}
			
	if(forma.moneda_r.value=="0")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione una moneda', 20, 10, 18)
			//alert("* Seleccione una moneda")
			forma.moneda_r.className = "campos_faltantes";
			return;
			
			}	
			

	if(forma.detalle_r.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle', 20, 10, 18)
			//alert("* Digite el detalle")
			forma.detalle_r.className = "campos_faltantes";
			return;
			
			}	
			
	if(forma.factura_r.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de factura', 20, 10, 18)
			//alert("* Digite el numero de factura")
			forma.factura_r.className = "campos_faltantes";
			return;
			
			}

	if(forma.anexo_r.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Anexe la factura', 20, 10, 18)
			//alert("Anexe la factura")
			forma.anexo_r.className = "campos_faltantes";
			return;
			
			}				
							
    





	else
		{

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="prefactura_reembolsable_detalle" 
				
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
		}

	}	
	
	function edita_item_re(id_re){
		var forma = document.principal


	

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="edita_prefactura_reembolsable_detalle" 
				forma.t6_tarifas_reembolables_datos_detalle_id.value = id_re
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
	

	}	
	
	

	
	
function elimina_item_re(id_re){
	var forma = document.principal 
	forma.t6_tarifas_reembolables_datos_detalle_id.value = id_re
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="eliminaprefactura_reembolsable_detalle"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
	//muestra_alerta_general_solo_texto('elimina_item_re_continua()', 'Advertencia', '¿Esta seguro de eliminar este Item?', 20, 10, 18)
}	
/*function elimina_item_re_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="eliminaprefactura_reembolsable_detalle"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
}*/
function confirma_creacion_reem(){
		var forma = document.principal


	if(forma.municipio_pre.value=="0")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre del municipio en el que se desarrollo la actividad', 20, 10, 18)
			//alert("* Digite el nombre del municipio en el que se desarrollo la actividad")
			forma.municipio_pre.className = "campos_faltantes";
			return;
			
			}

	if(forma.fecha_inicial.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha inicial del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha inicial del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if(forma.fecha_final.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la fecha final del servicio', 20, 10, 18)
			//alert("* Seleccione la fecha final del servicio")
			forma.fecha_inicial.className = "campos_faltantes";
			return;
			
			}

	if((forma.c_marco.value=="1") && (forma.orden_trabajo.value=="") )

	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el numero de orden de trabajo', 20, 10, 18)
			//alert("* Digite el numero de orden de trabajo ")
			return;
		
		}


	else
		{

	
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="prefactura_reembolsable_enfirme" 
				
					
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	
		}

	}		
	
function muestra_div_o(muestra)
{
	
	document.getElementById(muestra).style.display = '';
	
	}

function oculta_div_o(oculta)
{
	
	document.getElementById(oculta).style.display = 'none';
	
	}	
	
	
function edita_pre_en_firme(id_re){
	var forma = document.principal
	forma.pre_edita.value = id_re
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="edita_prefactura_firme"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
	//muestra_alerta_general_solo_texto('edita_pre_en_firme_continua()', 'Advertencia', 'Este tiquete de servicios se encuetra en estado EN FIRME ¿esta seguro de continuar?', 20, 10, 18)
}		
/*function edita_pre_en_firme_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="edita_prefactura_firme"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
}*/
function edita_reem_en_firme(id_re){
	var forma = document.principal
	forma.pre_edita.value = id_re
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="edita_reembolsable_firme"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
	//muestra_alerta_general_solo_texto('edita_reem_en_firme_continua()', 'Advertencia', 'Este reemboosable de servicios se encuetra en estado EN FIRME ¿esta seguro de continuar?', 20, 10, 18)
}			
function edita_reem_en_firme_continua(){
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="edita_reembolsable_firme"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.t6_tarifas_reembolables_datos_detalle_id.value = ""
}
function checkDecimals(fieldName, fieldValue,campo) {

decallowed = 2; // how many decimals are allowed?
var valida_cara_ante_dec = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

if(valida_cara_ante_dec.length>=3)
	{
		
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext		
		}

if (isNaN(fieldValue) || fieldValue == "") {
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext
}
else {
if (fieldValue.indexOf('.') == -1) fieldValue += ".";
dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

if (dectext.length > decallowed)
{
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext
      }
else {
campo.value=campo.value
      }
   }
}



function checkDecimals_2(fieldName, fieldValue,campo) {

decallowed = 5; // how many decimals are allowed?
var valida_cara_ante_dec = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

if(valida_cara_ante_dec.length>=12)
	{
		
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext		
		}

if (isNaN(fieldValue) || fieldValue == "") {
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext
}
else {
if (fieldValue.indexOf('.') == -1) fieldValue += ".";
dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

if (dectext.length > decallowed)
{
dectext = fieldValue.substring(0, fieldValue.length-1);
campo.value=dectext
      }
else {
campo.value=campo.value
      }
   }
}



function carga_espacio(muestra,espacio)
{
	var forma = document.principal
	if(muestra==1)
		document.getElementById(espacio).style.display = '';
	else{
		document.getElementById(espacio).style.display = 'none';
		forma.orden_trabajo.value=""
		}
	
	}

function cambia_contrasena(){
	var forma = document.principal;
	var msg ="";			
	if(forma.usuario_pro.value==""){
		msg = msg + "* E-mail (Usuario principal)\n"
		forma.usuario_pro.className = "* Select_faltantes";		
	}
	if(forma.telefono_pro.value==""){
		msg = msg + "* Teléfono de Contacto\n"
		forma.telefono_pro.className = "* Select_faltantes";		
	}
	if(msg!=""){
			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
			//alert("Verifique el formulario\n" + msg)
			return

	}else{ //si no tiene errores
		if(forma.conta_1.value==forma.conta_2.value){
			forma.target="grp";
			forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
			forma.accion.value="cambia_contrasena_1";
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display="";
		}else{
			muestra_alerta_error_solo_texto('', 'Error', '* Las contraseñas no coiciden', 20, 10, 18)
			//alert("Las contraseñas no coiciden")
			return
		}
		//muestra_alerta_general_solo_texto('cambia_contrasena_continua()', 'Advertencia', '¿Esta seguro de actualizar la información?', 20, 10, 18)
	}//si no tiene errores
}
/*function cambia_contrasena_continua(){
	var forma = document.principal;
	if(forma.conta_1.value==forma.conta_2.value){
		forma.target="grp";
		forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
		forma.accion.value="cambia_contrasena_1";
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display="";
	}else{
		muestra_alerta_error_solo_texto('', 'Error', '* Las contraseñas no coiciden', 20, 10, 18)
		//alert("Las contraseñas no coiciden")
		return
	}
}*/
function crea_sub_usuario_j(){
	var forma = document.principal;
	var msg ="";
	if(forma.b.value==""){
		msg = msg + "* Digite el nombre\n"
		forma.b.className = "campos_faltantes";		
	}
	if(forma.d.value==""){
		msg = msg + "* Digite el e-mail\n"
		forma.d.className = "campos_faltantes";		
	}
	if(forma.e.value==""){
		msg = msg + "* Digite el teléfono\n"
		forma.e.className = "campos_faltantes";		
	}
	if(msg!=""){
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
		//alert("Verifique el formulario\n" + msg)
		return
	}else{
		forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
		forma.accion.value="crea_sub_usuario"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		//muestra_alerta_general_solo_texto('crea_sub_usuario_j_continua()', 'Advertencia', '¿Esta seguro de crear este proceso?', 20, 10, 18)
	}
}
/*function crea_sub_usuario_j_continua(){
	var forma = document.principal
	forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
	forma.accion.value="crea_sub_usuario"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function edita_sub_usuario(id_requerimiento,a,b,c)
	{


	var forma = document.principal

	
	if(a.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre', 20, 10, 18)
		//alert("* Digite el nombre")
		return;
		}
	if(b.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el E-mail', 20, 10, 18)
		//alert("* aigite el E-mail")
		return;
		}

	if(c.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el teléfono', 20, 10, 18)
		//alert("* Digite el teléfono")
		return;
		}		
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
			forma.accion.value="e_sub_usuario";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}	
function soli_cam_contra(id_requerimiento)
	{


	var forma = document.principal

			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
			forma.accion.value="cambia_con_subusuario";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	
	
	
function elimina_usuario(id_requerimiento){
	var forma = document.principal
	forma.campo_id.value = id_requerimiento;
	forma.target="grp";
	forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
	forma.accion.value="elimina_usuario";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
	//muestra_alerta_general_solo_texto('elimina_usuario_continua()', 'Advertencia', 'Esta a punto de elimiar este usuario ¿esta seguro?', 20, 10, 18)
}	
/*function elimina_usuario_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../enterproc/librerias/php/usuarios_proveedor.php";
	forma.accion.value="elimina_usuario";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}*/
function elimina_ane_descue(id_requerimiento){
	var forma = document.principal
	forma.id_an_e.value = id_requerimiento;
	forma.target="grp";
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_anex";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
	//muestra_alerta_general_solo_texto('elimina_ane_descue_continua()', 'Advertencia', 'Esta a punto de elimiar este anexo ¿esta seguro?', 20, 10, 18)
}					
function elimina_ane_descue_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="elimina_anex";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function modificar_tarifas_ipc(activaalerta){
		var forma = document.principal

	if(forma.valor_ipc.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el valor del IPC', 20, 10, 18)
			//alert("* Digite el valor del IPC")
			campo.className = "campos_faltantes";
			return;
			
			}
	if(forma.vigencia_IPC.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el inicio de la vigencia', 20, 10, 18)
			//alert("* Digite el inicio de la vigencia")
			campo.className = "campos_faltantes";
			return;
			
			}	
	if(forma.observaciones_IPC.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite las observaciones', 20, 10, 18)
			//alert("* Digite las observaciones")
			campo.className = "campos_faltantes";
			return;
			
			}
	if(forma.archivo_ipc.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el anexo soporte', 20, 10, 18)
			//alert("* Seleccione el anexo soporte")
			campo.className = "campos_faltantes";
			return;
			
			}									
	else{
		//PARA EL DES098
		if(activaalerta == ""){
			window.parent.muestra_alerta_general_solo_texto('modificar_tarifas_ipc(12)', 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
			return;
		}
		forma.action = "procesos-tarifas-proveedores.html";
		forma.accion.value="modificar_tarifas_ipc" 
		//forma.id_tarifa.value=id_tarifa
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		//muestra_alerta_general_solo_texto('modificar_tarifas_ipc_continua()', 'Advertencia', '¿Esta seguro de modificar todas las tarifas?', 20, 10, 18)
	}
}		
function modificar_tarifas_ipc_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas-proveedores.html";
	forma.accion.value="modificar_tarifas_ipc" 
	//forma.id_tarifa.value=id_tarifa
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function carga_tarifas_masivas(activaalerta){
		var forma = document.principal
		var msg=""

	if(forma.carga_tarifas.value==""){
			msg = msg + "* Seleccione el archivo excel con las tarifas\n"
			forma.carga_tarifas.className = "campos_faltantes";		
		}
		



	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				//PARA EL DES098
				if(activaalerta == ""){
					window.parent.muestra_alerta_general_solo_texto('carga_tarifas_masivas(12)', 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
					return;
				}
					forma.action = "../librerias/php/tarifas_procesos_cargue_masivo_pro.php";
					forma.accion.value="cargue_masivo_tarifas" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	
	
	function carga_tarifas_masivas_actualizacion_IPC(activaalerta){
		var forma = document.principal
		var msg=""

	if(forma.carga_tarifas.value==""){
			msg = msg + "* Seleccione el archivo excel con las tarifas\n"
			forma.carga_tarifas.className = "campos_faltantes";		
		}
		
	if(forma.modi_convencion_0.value=="0"){
			msg = msg + "* Seleccione si la modificacion es por Convencion\n"
			//forma.carga_tarifas.className = "campos_faltantes";		
		}

	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				//PARA EL DES098
				if(activaalerta == ""){
					window.parent.muestra_alerta_general_solo_texto('carga_tarifas_masivas_actualizacion_IPC(12)', 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
					return;
				}
					forma.action = "../librerias/php/tarifas_procesos_cargue_masivo_pro_acutali_ipc.php";
					forma.accion.value="cargue_masivo_tarifas" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					 window.parent.document.getElementById("cargando_pecc").style.display = "block"
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}
	
function carga_tarifas_masivas_actualizacion(activaalerta){
		var forma = document.principal
		var msg=""

	if(forma.carga_tarifas.value==""){
			msg = msg + "* Seleccione el archivo excel con las tarifas\n"
			forma.carga_tarifas.className = "campos_faltantes";		
		}
		
	if(forma.modi_convencion_0.value=="0"){
			msg = msg + "* Seleccione si la modificacion es por Convencion\n"
			//forma.carga_tarifas.className = "campos_faltantes";		
		}

	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				//PARA EL DES098
				if(activaalerta == ""){
					window.parent.muestra_alerta_general_solo_texto('carga_tarifas_masivas_actualizacion(12)', 'Advertencia','Favor tener en cuenta:*1.    La creación y/o modificación de tarifas que está efectuando no implica, de ninguna manera, incremento en el valor del contrato.*2.    La creación y/o modificación de la(s) tarifa(s) se requiere(n) esencialmente para cumplir con el objeto del mismo del contrato.*Estas creaciones y/o modificaciones se harán mediante una comunicación escrita, firmada y sellada por el gerente del contrato (contratos puntuales) y en los contratos marco tanto por la persona que solicita el trabajo como por el gerente del contrato de Hocol.', 60, 5, 10)
					return;
				}
					forma.action = "../librerias/php/tarifas_procesos_cargue_masivo_pro_acutali.php";
					forma.accion.value="cargue_masivo_tarifas" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					 window.parent.document.getElementById("cargando_pecc").style.display = "block"
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}

function comprueba_extension(formulario, archivo) { 
   extensiones_permitidas = new Array(".zip", ".rar"); 
   mierror = ""; 
   if (!archivo) { 
      //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario 
      	mierror = "* No has seleccionado ningún archivo"; 
   }else{ 
      //recupero la extensión de este nombre de archivo 
      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
      //alert (extension); 
      //compruebo si la extensión está entre las permitidas 
      permitida = false; 
      for (var i = 0; i < extensiones_permitidas.length; i++) { 
         if (extensiones_permitidas[i] == extension) { 
         permitida = true; 
         break; 
         } 
      } 
      if (!permitida) { 
         mierror = "* Comprueba la extensión de los archivos a subir. * Sólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join(); 
		 //return 0;
      	}else{ 
         	//submito! 
        // alert ("Todo correcto. Voy a submitir el formulario."); 
         //formulario.submit(); 
         return 1; 
      	} 
   } 
   //si estoy aqui es que no se ha podido submitir
	muestra_alerta_error_solo_texto('', 'Error', mierror, 20, 10, 18)
   //alert (mierror); 
   return 0; 
}
	
function confirma_actualizacion_masiva_ipc_c(){
		var forma = document.principal
		var msg=""

var cargue_valida = comprueba_extension(forma, forma.anexo_soporte_0.value)

if(cargue_valida==0)
	return;


	if(forma.anexo_soporte_0.value==""){
			msg = msg + "* Seleccione Anexo soporte(Diferente a la plantilla de cargue)\n"
			//forma.carga_tarifas.className = "campos_faltantes";		
		}


		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="confirma_actualizacion_masiva_ipc" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	function confirma_actualizacion_masiva(){
		var forma = document.principal
		var msg=""

var cargue_valida = comprueba_extension(forma, forma.anexo_soporte_0.value)

if(cargue_valida==0)
	return;


	if(forma.anexo_soporte_0.value==""){
			msg = msg + "* Seleccione Anexo soporte(Diferente a la plantilla de cargue)\n"
			//forma.carga_tarifas.className = "campos_faltantes";		
		}


		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas-proveedores.html";
					forma.accion.value="confirma_actualizacion_masiva" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	