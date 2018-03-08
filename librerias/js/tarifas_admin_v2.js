function cambia_manual_usuario_pro(){
var forma = document.principal
		if(forma.manual_us.value == ""){
			muestra_alerta_error_solo_texto('', 'Error', '* Por favor seleccione el nuevo manual', 20, 10, 18)
			//alert("Por favor seleccione el nuevo manual");
			return
			}	
			
					forma.action = "procesos-tarifas.html";
					forma.accion.value="carga_nuevo_manual" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
	}

function seleccionar_todas_para_inhabilitar(ids_tarifas, seleccion){
var forma = document.principal
var i = 0;
var	arrayselect = "";
			if(seleccion == 1){
				arrayselect = ids_tarifas.split(",");
			 		for (i = 0; i < arrayselect.length; i++) {
						if(arrayselect[i] > 0){
						document.getElementById("inhabilita_tarifa_"+arrayselect[i]).value = 2
						}
					}
			}

	}
	
	
function valida_inhabilita_tarifa(id_tarifa, campo, adjunto){
	var forma = document.principal 
	forma.t6_tarifas_lista_id.value=id_tarifa
	forma.ob_inhabilita.value=campo
	var msg=""
	if(campo==""){
			muestra_alerta_error_solo_texto('', 'Error', '* Por favor digite la observación por la cual desea inhabilitar esta tarifa', 20, 10, 18)
			//alert("Por favor digite la observación por la cual desea inhabilitar esta tarifa")
			return;		
		}
	if(adjunto==""){
		muestra_alerta_error_solo_texto('', 'Error', '* Por favor seleccione un adjunto', 20, 10, 18)
			//alert("Por favor seleccione un adjunto")
			return;		
		}
	forma.action = "procesos-tarifas.html";
	forma.accion.value="inhabuilita_tarifa"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('valida_inhabilita_tarifa_continua()', 'Advertencia', '¿Está seguro de inhabilitar esta tarifa?', 20, 10, 18)
}
/*function valida_inhabilita_tarifa_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="inhabuilita_tarifa"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crea_lista_tarifa_manual(){
		var forma = document.principal
		var msg=""

	if(forma.detalle_creacion.value==""){
			msg = msg + "* Digite el detalle de la tarifa\n"
		//	forma.detalle_creacion.className = "textarea_faltantes";		
		}
	if(forma.codigo_creacion.value==""){
			msg = msg + "* Digite el item oferta proveedor\n"
		forma.codigo_creacion.className = "campos_faltantes";		
		}		

	if(forma.fecha_vigencia_creacion.value==""){
			msg = msg + "* Seleccione la fecha de inicio de vigencia\n"
			forma.fecha_vigencia_creacion.className = "campos_faltantes";		
		}

	if(forma.unidad_creacion.value==""){
			msg = msg + "* Digite la unidad de medida de la tarifa\n"
			forma.unidad_creacion.className = "campos_faltantes";		
		}

	if(forma.cantidad_creacion.value==""){
			msg = msg + "* Digite la cantidad de la tarifa\n"
			forma.cantidad_creacion.className = "campos_faltantes";		
		}

	if(forma.moneda_creacion.value==""){
			msg = msg + "* Digite la moneda de la tarifa\n"
			forma.moneda_creacion.className = "campos_faltantes";		
		}

	if(forma.valor_creacion.value==""){
			msg = msg + "* Digite el valor de la tarifa\n"
			forma.valor_creacion.className = "campos_faltantes";
		}

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
			}
		else{
			forma.action = "procesos-tarifas.html";
			forma.accion.value="crea_tarifa_manual" 
			forma.target="grp"
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
				//muestra_alerta_general_solo_texto('crea_lista_tarifa_manual_continua()', 'Advertencia', '¿Está seguro de crear este registro?', 20, 10, 18)
			}
}	
/*function crea_lista_tarifa_manual_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crea_tarifa_manual" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function contrato_tarifas_en_firme(descu){
	var forma = document.principal
	if(descu>=1){//si ya ti ene descuentos
					
			forma.action = "procesos-tarifas.html";
			forma.accion.value="contrato_en_firme" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
	}//si ya tiene descuentos
	else{ // si no tiene descuentos



									forma.action = "procesos-tarifas.html";
			forma.accion.value="contrato_en_firme" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""



		}// si no tiene descuentos

	//muestra_alerta_general_solo_texto('contrato_tarifas_en_firme_continua()', 'Advertencia', '¿Está seguro de poner en firme este contrato?', 20, 10, 18)
}
/*function contrato_tarifas_en_firme_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="contrato_en_firme" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function contrato_tarifas_en_excepcion_editado(){
		var forma = document.principal		
	if(forma.ob_excepcion.value==""){
		muestra_alerta_error_solo_texto('', 'Error', '* Por favor ingresar la observación de la excepcion', 20, 10, 18)
		//alert("Por favor ingresar la observación de la excepcion")
		forma.ob_excepcion.className = "textarea_faltantes";	
		return;	
	}
	forma.action = "procesos-tarifas.html";
	forma.accion.value="contrato_en_excepcion_editado" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('contrato_tarifas_en_excepcion_editado_continua()', 'Advertencia', '¿Está seguro de indicar que este contrato tiene excepcion?', 20, 10, 18)
}
/*function contrato_tarifas_en_excepcion_editado_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="contrato_en_excepcion_editado" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function contrato_tarifas_en_parcial_editado(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="contrato_en_parcial_editado" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('contrato_tarifas_en_parcial_editado_continua()', 'Advertencia', '¿Está seguro de poner en parcial este contrato?', 20, 10, 18)
}	
/*function contrato_tarifas_en_parcial_editado_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="contrato_en_parcial_editado" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function edita_tarifa(id_tarifa,campo){
	var forma = document.principal
	if(campo.value==""){
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el valor de la tarifa', 20, 10, 18)
		//alert("* Digite el valor de la tarifa")
		campo.className = "campos_faltantes";
		return;
	}
	else{
		//muestra_alerta_general_solo_texto('edita_tarifa_continua()', 'Advertencia', '¿Está seguro de modificar esta tarifa?', 20, 10, 18) 
		forma.id_tarifa.value=id_tarifa
		forma.action = "procesos-tarifas.html";
		forma.accion.value="modificar_tarifas"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
	}
}	
/*function edita_tarifa_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="modificar_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function edita_tarifa_parcial(id_tarifa,campo){
	var forma = document.principal
	if(campo.value==""){
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el valor de la tarifa', 20, 10, 18)
		//alert("* Digite el valor de la tarifa")
		campo.className = "campos_faltantes";
		return;
	}else{ 
		forma.id_tarifa.value=id_tarifa
		forma.action = "procesos-tarifas.html";
		forma.accion.value="modificar_tarifas_parcial"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		//muestra_alerta_general_solo_texto('edita_tarifa_parcial_continua()', 'Advertencia', '¿Está seguro de modificar esta tarifa?', 20, 10, 18)
	}
}		
/*function edita_tarifa_parcial_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="modificar_tarifas_parcial"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crear_aprobacion(){
	window.parent.document.getElementById("cargando").style.display=""
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crea_aprobacion"
	forma.target="grp"
	forma.submit()
	
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crear_aprobacion_continua()', 'Advertencia', '¿Está seguro de aprobar o no esta tarifa?', 20, 10, 18)
}
/*function crear_aprobacion_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crea_aprobacion"
	forma.target="grp"
	forma.submit()
	window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crear_aprobacion_todos(){
	window.parent.document.getElementById("cargando").style.display=""
	var forma = document.principal		
	forma.action = "procesos-tarifas.html";
	forma.accion.value="aprueba_todas_tarifas" 
	forma.target="grp"
	forma.submit()
	
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crear_aprobacion_todos_continua()', 'Advertencia', '¿Está seguro de aprobar todas las tarifas?', 20, 10, 18)
}	
/*function crear_aprobacion_todos_continua(){
	var forma = document.principal		
	forma.action = "procesos-tarifas.html";
	forma.accion.value="aprueba_todas_tarifas" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crear_recahzo_todos(){
	var forma = document.principal
 	if (valida_texto_espacios(forma.ob_general.value) == "NO"  || characterCount(forma.ob_general.value,20) != "") {
		muestra_alerta_error_solo_texto('', 'Error', '*  Va a rechazar todas las tarifas, por favor digite la observación. Por lo menos debe tener 20 caracteres', 20, 10, 18)
        //alert("* Va a rechazar todas las tarifas, por favor digite la observación. Por lo menos debe tener 20 caracteres\n")
        forma.ob_general.className = "textarea_faltantes";
		return;
	} else {
		forma.ob_general.className = "";
	}
	forma.action = "procesos-tarifas.html";
	forma.accion.value="rechaza_todas_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crear_recahzo_todos_continua()', 'Advertencia', '¿Está seguro de rechazar todas las tarifas?', 20, 10, 18)
}	
/*function crear_recahzo_todos_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="rechaza_todas_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crea_categorias_maestras(){
		var forma = document.principal
		var msg=""

	if(forma.categoria.value==""){
			msg = msg + "* Digite el detalle de la tarifa\n"
			forma.detalle.className = "campos_faltantes";		
		}
		
	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="craer_categoria_maestra" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.categoria.value=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	}	
function crea_descriptor_maestras(id_categoria,campo,tipo){
		var forma = document.principal
		var msg=""

	if(campo.value==""){
			msg = msg + "* Digite el detalle del descriptor\n"
			campo.className = "campos_faltantes";		
		}
		
	if(tipo.value==0){
			msg = msg + "* Seleccione el tipo de campo del descriptor\n"
			tipo.className = "* Select_faltantes";		
		}		
		
	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="craer_descriptor_maestra" 
					forma.target="grp"
					forma.id_categoria.value=id_categoria;
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
function edita_descriptor_maestras(id_categoria,detalle_categoria){
		var forma = document.principal
		var msg=""

	if(detalle_categoria.value==""){
			msg = msg + "* Digite el detalle de la categoria\n"
			detalle_categoria.className = "textarea_faltantes";		
		}
		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="edita_categoria_descritores_maestra" 
					forma.target="grp"
					forma.id_categoria.value=id_categoria;
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	

function elimina_descriptor_maestras(id_descriptor,id_categoria){
	var forma = document.principal
	var msg=""
	//muestra_alerta_general_solo_texto('elimina_descriptor_maestras_continua()', 'Advertencia', '¿Está seguro de eliminar este registro?', 20, 10, 18)
	forma.id_descritor.value=id_descriptor;
	forma.id_categoria.value=id_categoria;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_descritores_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}	
/*function elimina_descriptor_maestras_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_descritores_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function elimina_descritores_maestra(id_categoria){
	var forma = document.principal
	var msg=""
	//muestra_alerta_general_solo_texto('elimina_descritores_maestra_continua()', 'Advertencia', '¿Está seguro de eliminar este registro?', 20, 10, 18)
	forma.id_categoria.value=id_categoria;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_categoria_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
/*function elimina_descritores_maestra_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_categoria_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crea_lista_maestra(){
		var forma = document.principal
		var msg=""

	if(forma.categoria_busca.value==""){
			msg = msg + "* Seleccione la categoria\n"
			forma.categoria_busca.value.className = "campos_faltantes";		
		}

	if(forma.detalle_lista.value==""){
			msg = msg + "* Digite la lista maestra\n"
			forma.detalle_lista.value.className = "campos_faltantes";		
		}
		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_lista_maestra" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.codigo_maestro.value=""
					forma.detalle_lista.value=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
function edita_lista_maestra(id_lista){
		var forma = document.principal
		var msg=""


					
					forma.action = "procesos-tarifas.html";
					forma.accion.value="edita_lista_maestra" 
					forma.target="grp"
					
					forma.id_lista.value=id_lista;
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				
	
	}		
	
function elimina_lista_maestra(id_lista){
	var forma = document.principal
	var msg=""
	//muestra_alerta_general_solo_texto('elimina_lista_maestra_continua()', 'Advertencia', '¿Está seguro de eliminar este registro?', 20, 10, 18)
	forma.id_lista.value=id_lista;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_lista_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
/*function elimina_lista_maestra_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_lista_maestra" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crear_atributo_lista(){
		var forma = document.principal
		var msg=""

	if(forma.nombre_nuevo_atributo.value==""){
			msg = msg + "* Digite el detalle del descriptor\n"
			forma.nombre_nuevo_atributo.className = "campos_faltantes";		
		}
		
	if(forma.tipo_descriptor.value==0){
			msg = msg + "* Seleccione el tipo de campo del descriptor\n"
			forma.tipo_descriptor.className = "* Select_faltantes";		
		}		
		
	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="craer_descriptor_tarifas" 
					forma.target="grp"

					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
	
function elimina_descriptor_tarifas(id_descriptor_pasa){
	var forma = document.principal
	var msg=""
	//muestra_alerta_general_solo_texto('elimina_descriptor_tarifas_continua()', 'Advertencia', '¿Está seguro de eliminar este registro?', 20, 10, 18)
	forma.id_descriptor.value=id_descriptor_pasa;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_descritores_tarifas" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
/*function elimina_descriptor_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_descritores_tarifas" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function modificar_atributo_lista(id_descriptor_pasa){
	var forma = document.principal
	var msg=""
	//(muestra_alerta_general_solo_texto('modificar_atributo_lista_continua()', 'Advertencia', '¿Está seguro de editar este registro?', 20, 10, 18)
	forma.id_descriptor.value=id_descriptor_pasa;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="edita_descritores_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	
}	
/*function modificar_atributo_lista_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="edita_descritores_tarifas"
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function copiar_descritores_tarifas(){
		var forma = document.principal
		var msg=""

	if(forma.nuevo_nombre_lista_re.value==""){
			msg = msg + "* Digite el nombre de la lista\n"
			forma.nuevo_nombre_lista_re.className = "campos_faltantes";		
		}
		

	if(forma.nuevo_nombre_lista_re.value==forma.modifica_nomre_compara.value){
			msg = msg + "* La nueva lista destino no puede tener el mismo nombre de la lista origen, por favor cambie el nombre"
			forma.nuevo_nombre_lista_re.className = "campos_faltantes";		
		}


	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="copiar_descritores_tarifas" 
					forma.target="grp"

					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	
	
function modificar_lista_tarifas_lista(){
		var forma = document.principal
		var msg=""

	if(forma.modifica_nomre.value==""){
			msg = msg + "* Digite el nombre de la lista\n"
			forma.nuevo_nombre_lista_re.className = "campos_faltantes";		
		}
		




	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="modificar_lista_tarifas_lista" 
					forma.target="grp"

					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
	
	

function crear_lista_tarifas_lista(){
		var forma = document.principal
		var msg=""

	if(forma.nueva_lista_lista.value==""){
			msg = msg + "* Digite el nombre de la lista\n"
			forma.nuevo_nombre_lista_re.className = "campos_faltantes";		
		}
		




	

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crear_lista_tarifas_lista" 
					forma.target="grp"

					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
	

function carga_tarifas_masivas(){
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
					forma.action = "menu-tarifas-masivas.html";
					forma.accion.value="cargue_masivo_tarifas" 
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	
	
	
function crea_relacion_uno_uno(tipo_check, id_tarifa){
		var forma = document.principal
		var msg=""
		forma.tarifa_seleccionada.value=id_tarifa
		
		if(tipo_check==true)
			{
				forma.accion.value="crea_relacion_uno_umo" 
				
				}
		else

			{
				forma.accion.value="elimina_relacion_uno_umo" 
				
				}

					forma.action = "menu-tarifas-masivas.html";
					forma.target="grp"
					forma.submit()
					window.parent.document.getElementById("cargando").style.display="none"

					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.tarifa_seleccionada.value=""
	
	
	}		
	
function sin_seleccionar(elemento_chea, id_tarifa, valor)
	{
		
		var forma = document.principal
		
		forma.tarifa_seleccionada.value=id_tarifa
		if(valor!=""){
		
		forma.elements[elemento_chea].checked=1
		crea_relacion_uno_uno(forma.elements[elemento_chea].checked, id_tarifa)
		forma.elements[elemento_chea].checked=1 
		forma.accion.value="crea_relacion_uno_umo" 
		}

		if(valor==""){
		forma.elements[elemento_chea].checked=0
		forma.accion.value="elimina_relacion_uno_umo" 
		
		}


					/*forma.action = "menu-tarifas-masivas.html";
					forma.target="grp"
					forma.submit()
					window.parent.document.getElementById("cargando").style.display="none"

					forma.action = "";
					forma.accion.value=""
					forma.target=""
					//forma.tarifa_seleccionada.value=""
	*/

		}

function sin_seleccionar_borrar(elemento_chea, id_tarifa, valor)
	{
		
		var forma = document.principal
		

		if(valor==""){
		forma.elements[elemento_chea].checked=0
		forma.accion.value="elimina_relacion_uno_umo" 
		
		


					forma.action = "menu-tarifas-masivas.html";
					forma.target="grp"
					forma.submit()
					window.parent.document.getElementById("cargando").style.display="none"

					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.tarifa_seleccionada.value=""
	}

		}
		
		

function confirmar_tarifas_relacion(){
	var forma = document.principal
	forma.accion.value="confirmar_tarifas_relacion" 
	forma.action = "menu-tarifas-masivas.html";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.tarifa_seleccionada.value=""
	//muestra_alerta_general_solo_texto('confirmar_tarifas_relacion_continua()', 'Advertencia', '¿Está seguro de confirmar esta relación?', 20, 10, 18)
}
/*function confirmar_tarifas_relacion_continua(){
	var forma = document.principal
	forma.accion.value="confirmar_tarifas_relacion" 
	forma.action = "menu-tarifas-masivas.html";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.tarifa_seleccionada.value=""
}*/	
function borra_historico_tarifas(){
	var forma = document.principal
	forma.accion.value="borra_historico_tarifas" 
	forma.action = "menu-tarifas-masivas.html";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.tarifa_seleccionada.value=""
	//muestra_alerta_general_solo_texto('borra_historico_tarifas_continua()', 'Advertencia', 'Esta acción borrara todas las tarifas seleccionadas sin confirmación ¿está seguro de continuar?', 20, 10, 18)
}
/*function borra_historico_tarifas_continua(){
	var forma = document.principal
	forma.accion.value="borra_historico_tarifas" 
	forma.action = "menu-tarifas-masivas.html";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.tarifa_seleccionada.value=""
}*/
function sinseleccionar_click(aumenta,id_tarifa)
{
  var forma = document.principal;	
	forma.tarifa_seleccionada.value=id_tarifa
	forma.tarifa_aumenta.value=aumenta
	forma.requiere_funcion.value=1
	
	}
	
function seleccionar_todo(){ 
  var forma = document.formulario;
  for (i=0;i<forma.elements.length;i++)
   		{ 
       if(forma.elements[i].type == "checkbox") {
         forma.elements[i].checked=1 
		 forma.elements[i].name = "* Se[]";
		 }
			
			}			
						forma.action = "../../librerias/php/procesos_formularios.php";
						forma.accion.value="activa_proveedor"
						forma.target="grp";
						forma.submit();

  for (i=0;i<forma.elements.length;i++)
   		{ 
       if(forma.elements[i].type == "checkbox") 
	   				{
			 forma.elements[i].name = "* Se";
					 }
			
			}
						
}


	
function deseleccionar_todo(){ 

	  var forma = document.formulario;
  
     for (i=0;i<forma.elements.length;i++) {
	 	
		      if(forma.elements[i].type == "checkbox") 
			  	{
					 forma.elements[i].name = "* Se[]";
				 }
											 }   
//borra
						forma.action = "../../librerias/php/procesos_formularios.php";
						forma.accion.value="elimina_proveedor"
						forma.target="grp";
						forma.submit();
											 

     for (i=0;i<forma.elements.length;i++) {
	 	
		      if(forma.elements[i].type == "checkbox") 
			  	{
        			 forma.elements[i].checked=0 
					 forma.elements[i].name = "* Se";
					 
				 }
											 }   
}	
		

function crea_descuento(){
		var forma = document.principal
		var msg=""

	if(forma.descuento_detalle.value==""){
			msg = msg + "* Digite el detalle de la categoria\n"
			forma.descuento_detalle.value.className = "textarea_faltantes";		
		}
		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_descuentos" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		
	

function crea_ipc_contrato(){
		var forma = document.principal
		var msg=""


		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Verifique el formulario', 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_ipc_contrato" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		


function crea_aiu_contrato(){
		var forma = document.principal
		var msg=""


		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Verifique el formulario', 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_aiu_contrato" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	
	
function crea_convencion_contrato(){
		var forma = document.principal
		var msg=""


		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Verifique el formulario', 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_convencion_contrato" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		

function crea_reembolsable(){
		var forma = document.principal
		var msg=""


		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Verifique el formulario', 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_reembolsable" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}		

function edita_categoria(cate){
		var forma = document.principal
		var msg=""

					forma.action = "procesos-tarifas.html";
					forma.accion.value="edita_categoria" 
					forma.id_nombre_edita.value = cate
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				

	
	}	
	
function edita_grupo(cate){
		var forma = document.principal
		var msg=""

					forma.action = "procesos-tarifas.html";
					forma.accion.value="edita_grupo" 
					forma.id_nombre_edita.value = cate
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				

	
	}		

function crea_anexos_tarifas(){
		var forma = document.principal
		var msg=""

	if(forma.descuento_detalle.value==""){
			msg = msg + "* Digite el detalle de la categoria\n"
			forma.descuento_detalle.value.className = "textarea_faltantes";		
		}
		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_anexos_tarifas" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	

function crea_suplentes(){
		var forma = document.principal
		var msg=""

	if(forma.usuario_suplente.value=="0"){
			msg = msg + "* Seleccione un usuario\n"
			forma.usuario_suplente.value.className = "textarea_faltantes";		
		}

	if(forma.roll_suplente.value=="0"){
			msg = msg + "* Seleccione un roll\n"
			forma.roll_suplente.value.className = "textarea_faltantes";		
		}	

	if(forma.fecha_inicial.value==""){
			msg = msg + "* Seleccione la fecha de vigencia\n"
			forma.fecha_inicial.value.className = "textarea_faltantes";		
		}				
		
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.action = "procesos-tarifas.html";
					forma.accion.value="crea_suplentes_tarifas" 
					forma.target="grp"
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
				
				}
	
	}	
	
	
	
function elimina_suplentes(id_suple){
	var forma = document.principal 
	forma.id_suplente.value=id_suple
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_suplentes_tarifas"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('elimina_suplentes_continua()', 'Advertencia', '¿Está seguro de eliminar el suplente?', 20, 10, 18)
}
/*function elimina_suplentes_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="elimina_suplentes_tarifas"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function vaciar_lista_tarifas_lista(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="vaciar_lista_tarifas_lista" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('vaciar_lista_tarifas_lista_continua()', 'Advertencia', '¿Está seguro de vaciar esta lista?', 20, 10, 18)
}	
/*function vaciar_lista_tarifas_lista_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="vaciar_lista_tarifas_lista" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function eliminar_lista_tarifas_lista(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="eliminar_lista_tarifas_lista" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('eliminar_lista_tarifas_lista_continua()', 'Advertencia', '¿Está seguro de eliminar esta lista?', 20, 10, 18)
}
/*function eliminar_lista_tarifas_lista_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="eliminar_lista_tarifas_lista" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function muestra_div_o(muestra)
{
	
	document.getElementById(muestra).style.display = '';
	
	}

function oculta_div_o(oculta)
{
	
	document.getElementById(oculta).style.display = 'none';
	
	}	
	
	function baja_arne_tar(vl)
{
	
	window.parent.location.href="../aplicaciones/tarifas/proveedor/descarga_anexo.php?id_documen=" + vl;
	
	}
	
	
function exporta_tiquete()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/reportes/reporte_tarifas_tiquetes_excel.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
function exporta_tiquete_excel_administrador()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/v_prefactura_excel.php";
					forma.target=""

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	}	
function exporta_reembolsable_excel_administrador()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/v_reebolsable_excel.php";
					forma.target=""

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	}	

	function exporta_r_pendienes()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/exp-r-pendientes-aprobacion.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}

function exporta_r_sin_tarifas()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/exporta_r_sin_tarifas.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}	
	
function exporta_r_sin_tarifas_contrato_parcia()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_execel_pendientes_aprobacion.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}		
	
	function exporta_tiquete_contrato_todo()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/v_prefactura_todos_excel.php";
					//forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}

	function exporta_tiquete_contrato()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_tiquetes_exce_contratol.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
	
	function exporta_tiquete_reembolsable_contrato()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_reembolsables_excel_contrato.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}	
	
	
	function exporta_reembolsables_todos()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/v_reebolsable_excel_todo.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}		

	
	function exporta_reembolsables()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/reportes/reporte_tarifas_reembolsable.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}		


	function exporta_tarifas_consulta_usadas()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_usadas_excel.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}	


	function exporta_hisotrico_contratos(){
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/modulo-historico-contratos_excel.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}	

function exporta_tarifas_consulta_variacion_general(id_contrato_pasa){
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel_variacion.php=";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.id_contrato.value = id_contrato_pasa;
	

	
	}	
function exporta_tarifas_consulta_variacion(){
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel_variacion.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}	

function exporta_tarifas_consulta(){
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
function exporta_tarifas_consulta_des03(){
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel_des003.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
	
function crea_municipio_tarifas(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crea_municipio_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crea_municipio_tarifas_continua()', 'Advertencia', '¿Está seguro de crear  el municipio?', 20, 10, 18)
}	
/*function crea_municipio_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crea_municipio_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function editar_municipio_tarifas(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="editar_municipio_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('editar_municipio_tarifas_continua()', 'Advertencia', '¿Está seguro de modificar  el municipio?', 20, 10, 18)
}		
/*function editar_municipio_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="editar_municipio_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function crear_proyecto_tarifas(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crear_proyecto_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crear_proyecto_tarifas_continua()', 'Advertencia', '¿Está seguro de crear el proyecto?', 20, 10, 18)	
}
/*function crear_proyecto_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crear_proyecto_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
function editar_proyecto_tarifas(id_proyecto_pasa){
	var forma = document.principal
	forma.id_proyecto.value=id_proyecto_pasa
	forma.action = "procesos-tarifas.html";
	forma.accion.value="editar_proyecto_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('editar_proyecto_tarifas_continua()', 'Advertencia', '¿Está seguro seguro de modificar el proyecto?', 20, 10, 18)
}
/*function editar_proyecto_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="editar_proyecto_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/
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
function exporta_tarifas_especificas()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/exporta_reporte_tarifas_globales.php";
					forma.target="grp"

					forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
	
	
function crear_nuevo_anexo_tarifas(){
	var forma = document.principal
	var cargue_valida = comprueba_extension(forma, forma.nuevo_anexo_apro.value) 
	if(cargue_valida==0)
		return;
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crear_nuevo_anexo_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	//muestra_alerta_general_solo_texto('crear_nuevo_anexo_tarifas_continua()', 'Advertencia', '¿Está seguro de el anexo?', 20, 10, 18)
}
/*function crear_nuevo_anexo_tarifas_continua(){
	var forma = document.principal
	forma.action = "procesos-tarifas.html";
	forma.accion.value="crear_nuevo_anexo_tarifas" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}*/

function contrato_tarifas_en_excepcion_editado_comentario(){
	var forma = document.principal
	 mierror = ""; 
	if(forma.ob_excepcion_edita.value == ""){
		
		mierror = "* Digite la observación de la excepción"; 
	}
	
	if(mierror!=""){
		muestra_alerta_error_solo_texto('', 'Error', " No se puede Grabar por favor: "+mierror, 20, 10, 18)
		return;
		
	}else{
		
		forma.action = "procesos-tarifas.html";
		forma.accion.value="contrato_tarifas_en_excepcion_editado_comentario" 
		forma.target="grp"
		forma.submit()
		forma.action = "";
		forma.accion.value=""
		forma.target=""

	}
	
}

function contrato_en_excepcion_editado_cambia_esatdo(){
	var forma = document.principal
	 mierror = ""; 
//	if(forma.ob_excepcion_edita.value == ""){
		
	//	mierror = "* Digite la observación de la excepción"; 
//	}
	
	if(mierror!=""){
		muestra_alerta_error_solo_texto('', 'Error', " No se puede Grabar por favor: "+mierror, 20, 10, 18)
		return;
		
	}else{
		
		forma.action = "procesos-tarifas.html";
		forma.accion.value="contrato_en_excepcion_editado_cambia_esatdo" 
		forma.target="grp"
		forma.submit()
		forma.action = "";
		forma.accion.value=""
		forma.target=""

	}
	
}