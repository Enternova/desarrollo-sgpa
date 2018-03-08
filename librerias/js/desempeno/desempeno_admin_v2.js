// JavaScript Document
function muestra_historico_desempeno(){
	$('#div_historico').css('display', 'block');
	$('#carga_historico_desempeno').css('display', 'none');
	$('#carga_admin_aspectos').css('display', 'none');
	$('#div_resultados').css('display', 'none');
	$('#div_admin').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/lista_pendientes.php', 'carga_admin_pendientes');
	$('#carga_admin_pendientes').css('display', 'block');
	$('#carga_aprobacion_criterio_aspectos').css('display', 'none');
	$('#carga_evaluacion').css('display', 'none');
	$('#carga_aprobacion_evaluacion').css('display', 'none');
	buscador_tabla_historico('body_historico_procesos', 1, 1);
}

function muestra_historico_gestion(id){
	$('#carga_historico_desempeno').css('display', 'block');
	$('#carga_admin_aspectos').css('display', 'none');
	$('#carga_admin_pendientes').css('display', 'none');
	$('#carga_aprobacion_criterio_aspectos').css('display', 'none');
	$('#carga_evaluacion').css('display', 'none');
	$('#carga_aprobacion_evaluacion').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/principal_gestion.php?id_evaluacion='+id, 'carga_historico_desempeno');
}

function definicion_criterio_evaluacion(id){
	
	
	$('#carga_admin_aspectos').css('display', 'block');
	$('#carga_historico_desempeno').css('display', 'none');
	$('#carga_admin_pendientes').css('display', 'none');
	$('#carga_aprobacion_criterio_aspectos').css('display', 'none');
	$('#carga_evaluacion').css('display', 'none');
	$('#carga_aprobacion_evaluacion').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/admin_criterios_tecnicos.php?id_evaluacion='+id, 'carga_admin_aspectos');
}

function aprobacion_criterio_evaluacion(id){
	
	
	$('#carga_aprobacion_criterio_aspectos').css('display', 'block');
	$('#carga_admin_aspectos').css('display', 'none');
	$('#carga_historico_desempeno').css('display', 'none');
	$('#carga_admin_pendientes').css('display', 'none');
	$('#carga_evaluacion').css('display', 'none');
	$('#carga_aprobacion_evaluacion').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/aprobacion_criterio.php?id_evaluacion='+id, 'carga_aprobacion_criterio_aspectos');
}


function aprobacion_evaluacion(id){
	
	
	$('#carga_aprobacion_evaluacion').css('display', 'block');
	$('#carga_aprobacion_criterio_aspectos').css('display', 'none');
	$('#carga_admin_aspectos').css('display', 'none');
	$('#carga_historico_desempeno').css('display', 'none');
	$('#carga_admin_pendientes').css('display', 'none');
	$('#carga_evaluacion').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/aprobacion_evaluacion.php?id_evaluacion='+id, 'carga_aprobacion_evaluacion');
}


function envio_evaluacion(id){
	
	
	$('#carga_evaluacion').css('display', 'block');
	$('#carga_aprobacion_criterio_aspectos').css('display', 'none');
	$('#carga_admin_aspectos').css('display', 'none');
	$('#carga_historico_desempeno').css('display', 'none');
	$('#carga_admin_pendientes').css('display', 'none');
	
	ajax_carga('../../aplicaciones/desempeno/admin_evaluacion.php?id_evaluacion='+id, 'carga_evaluacion');
}





function muestra_resultado_desempeno(){
	$('#div_resultados').css('display', 'block');
	$('#div_historico').css('display', 'none');
	$('#div_admin').css('display', 'none');
}
function muestra_admin_desempeno(){
	$('#div_admin').css('display', 'block');
	$('#div_historico').css('display', 'none');
	$('#div_resultados').css('display', 'none');
}


function carga_criterio_admin(){
	$('#carga_criterio_admin').css('display', 'block');
	$('#carga_aspecto_admin').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/admin_criterios.php', 'carga_criterio_admin');
}


function carga_criterio_admin_iframe(){
	ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_admin_desempeno&function2=carga_criterio_admin', 'contenidos');
}

function carga_aspecto_admin_iframe(){
	ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_admin_desempeno&function2=carga_aspecto_admin', 'contenidos');
}

function recarga_criterio_admin_iframe(){
	window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_admin_desempeno&function2=carga_criterio_admin', 'contenidos');
}

function recarga_aspecto_admin_iframe(){
	window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_admin_desempeno&function2=carga_aspecto_admin', 'contenidos');
}
function recarga_modal_configuracion_aspectos(id_criterio){

	window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=definicion_criterio_evaluacion&function3='+id_criterio, 'contenidos');
	
	
	
}

function recarga_historico_admin_iframe(id){
	window.parent.ajax_carga('../aplicaciones/desempeno/principal.php?function1=muestra_historico_desempeno&function2=muestra_historico_gestion&function3='+id, 'contenidos');
	
	
	
}






function agregar_input(){
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	var imcrementa=0;
	
	
	if (forma.id_contador_agrega_aspectos === undefined){//si el input no está definido
		var id_contador_agrega_aspectos=document.createElement("input");
		id_contador_agrega_aspectos.name="id_contador_agrega_aspectos";
		id_contador_agrega_aspectos.type="hidden";
		id_contador_agrega_aspectos.value=1;
		forma.appendChild(id_contador_agrega_aspectos);imcrementa=1; 
	}else{
		 imcrementa=forma.id_contador_agrega_aspectos.value;
		 imcrementa++;
		 forma.id_contador_agrega_aspectos.value=imcrementa+1;
	}
	
	$('#agregar_fila').append('<div class="input-field col s12 m10 l10 remover'+imcrementa+'"> <i class="material-icons prefix" style="color: #FF0000; cursor: pointer !important; background: trasparent;" onclick="$(&apos;.remover'+imcrementa+'&apos;).remove();"></i><input   name="nombre_aspecto" type="text" class="validate" style=""> </div><div class="input-field col s12 m2 l2 remover'+imcrementa+'"><input   name="puntos_aspecto" type="number" class="validate" style=""> </div>');
	
		
	
}


function actualiza_select(){
	$('select').material_select();
}

function carga_aspecto_admin(){
	
	$('#carga_aspecto_admin').css('display', 'block');
	$('#carga_criterio_admin').css('display', 'none');
	ajax_carga('../../aplicaciones/desempeno/admin_aspectos.php', 'carga_aspecto_admin');
	actualiza_select();
}



function guarda_criterio_admin(){
	
	var opcion_seleccionada = $('#tipo_contrato option:selected').val();
	
	var pasa1=document.getElementById('nombre_criterio').value
	var pasa2=document.getElementById('puntos_criterio').value
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.tipo_contrato === undefined){//si el input no está definido
		var tipo_contrato=document.createElement("input");
		tipo_contrato.name="tipo_contrato";
		tipo_contrato.type="hidden";
		tipo_contrato.value=opcion_seleccionada;
		forma.appendChild(tipo_contrato);
	}else{
		forma.tipo_contrato.value=opcion_seleccionada;
	}
	
	if (forma.nombre_criterio === undefined){//si el input no está definido
		var nombre_criterio=document.createElement("input");
		nombre_criterio.name="nombre_criterio";
		nombre_criterio.type="hidden";
		nombre_criterio.value=pasa1;
		forma.appendChild(nombre_criterio);
	}else{
		forma.nombre_criterio.value=pasa1;
	}
	
	if (forma.puntos_criterio === undefined){//si el input no está definido
		var puntos_criterio=document.createElement("input");
		puntos_criterio.name="puntos_criterio";
		puntos_criterio.type="hidden";
		puntos_criterio.value=pasa2;
		forma.appendChild(puntos_criterio);
	}else{
		forma.puntos_criterio.value=pasa2;
	}
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="crea_criterio";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.tipo_contrato.value="";
	forma.nombre_criterio.value="";
	forma.puntos_criterio.value="";
}



function aceptar_aspectos_evaluacion(id){
	
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.id_evaluacion === undefined){//si el input no está definido
		var id_evaluacion=document.createElement("input");
		id_evaluacion.name="id_evaluacion";
		id_evaluacion.type="hidden";
		id_evaluacion.value=id;
		forma.appendChild(id_evaluacion);
	}else{
		forma.id_evaluacion.value=id;
	}
	
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="acepta_criterios";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_evaluacion.value="";
	
	recarga_historico_admin_iframe(id);
	
}



function rechazar_aspectos_evaluacion(id){
	
	var pasa10=document.getElementById('nombre_observacion').value
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.id_evaluacion === undefined){//si el input no está definido
		var id_evaluacion=document.createElement("input");
		id_evaluacion.name="id_evaluacion";
		id_evaluacion.type="hidden";
		id_evaluacion.value=id;
		forma.appendChild(id_evaluacion);
	}else{
		forma.id_evaluacion.value=id;
	}
	
	if (forma.nombre_observacion === undefined){//si el input no está definido
		var nombre_observacion=document.createElement("textarea");
		nombre_observacion.name="nombre_observacion";
		nombre_observacion.type="hidden";
		nombre_observacion.value=pasa10;
		forma.appendChild(nombre_observacion).style.display='none';
	}else{
		forma.nombre_observacion.value=pasa10;
	}
	
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="rechaza_criterio_aspecto";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_evaluacion.value="";
	forma.nombre_observacion.value="";
	
	recarga_historico_admin_iframe(id);
	
}


function rechazar_aprobacion_evaluacion(id){
	
	var pasa10=document.getElementById('nombre_observacion').value
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.id_evaluacion === undefined){//si el input no está definido
		var id_evaluacion=document.createElement("input");
		id_evaluacion.name="id_evaluacion";
		id_evaluacion.type="hidden";
		id_evaluacion.value=id;
		forma.appendChild(id_evaluacion);
	}else{
		forma.id_evaluacion.value=id;
	}
	
	if (forma.nombre_observacion === undefined){//si el input no está definido
		var nombre_observacion=document.createElement("textarea");
		nombre_observacion.name="nombre_observacion";
		nombre_observacion.type="hidden";
		nombre_observacion.value=pasa10;
		forma.appendChild(nombre_observacion).style.display='none';
	}else{
		forma.nombre_observacion.value=pasa10;
	}
	
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="rechaza_aprobacion_evaluacion";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_evaluacion.value="";
	forma.nombre_observacion.value="";
	
	muestra_historico_gestion(id);
	
}



function aceptar_criterios_evaluacion(id){
	
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.id_evaluacion === undefined){//si el input no está definido
		var id_evaluacion=document.createElement("input");
		id_evaluacion.name="id_evaluacion";
		id_evaluacion.type="hidden";
		id_evaluacion.value=id;
		forma.appendChild(id_evaluacion);
	}else{
		forma.id_evaluacion.value=id;
	}
	
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="aceptar_criterio_aspecto";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_evaluacion.value="";
	
	recarga_historico_admin_iframe(id);
	
}



function aceptar_aprobacion_evaluacion(id){
	
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.id_evaluacion === undefined){//si el input no está definido
		var id_evaluacion=document.createElement("input");
		id_evaluacion.name="id_evaluacion";
		id_evaluacion.type="hidden";
		id_evaluacion.value=id;
		forma.appendChild(id_evaluacion);
	}else{
		forma.id_evaluacion.value=id;
	}
	
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="aceptar_aprobacion_evaluacion";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_evaluacion.value="";
	
	recarga_historico_admin_iframe(id);
	
}



function nuevo_aspecto_evaluacion(id){
	
	

	
	
		
	
	
	
			
	var forma = window.parent.document.principal
	
	
	var saveData1 = document.getElementsByName('id_existente');
	var saveData2 = document.getElementsByName('nombre_existente');
	var saveData3 = document.getElementsByName('puntos_existente');
	
		var saveData4 = id;
		var saveData5 = document.getElementsByName('nombre_aspecto');
		var saveData6 = document.getElementsByName('puntos_aspecto');
		
	
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
			var id_agrega_criterio=document.createElement("input");
			id_agrega_criterio.name="id_agrega_criterio";
			id_agrega_criterio.type="hidden";
			id_agrega_criterio.value=id;
			forma.appendChild(id_agrega_criterio);
			
		for(i=0; i<saveData5.length; i++)
		
		{	
			var nombre_aspecto=document.createElement("input");
			nombre_aspecto.name="nombre_aspecto[]";
			nombre_aspecto.type="hidden";
			nombre_aspecto.value=saveData5[i]['value'];
			forma.appendChild(nombre_aspecto);
			
			//console.log(saveData[i]['value']);
		}
		
		for(i=0; i<saveData6.length; i++)
		
		{	
			var puntos_aspecto=document.createElement("input");
			puntos_aspecto.name="puntos_aspecto[]";
			puntos_aspecto.type="hidden";
			puntos_aspecto.value=saveData6[i]['value'];
			forma.appendChild(puntos_aspecto);
			
			//console.log(saveData[i]['value']);
		}
		
		for(i=0; i<saveData1.length; i++)
		
		{	
			var id_existente=document.createElement("input");
			id_existente.name="id_existente[]";
			id_existente.type="hidden";
			id_existente.value=saveData1[i]['value'];
			forma.appendChild(id_existente);
			
			//console.log(saveData[i]['value']);
		}
		
		
		
		for(i=0; i<saveData2.length; i++)
		
		{	
			var nombre_existente=document.createElement("input");
			nombre_existente.name="nombre_existente[]";
			nombre_existente.type="hidden";
			nombre_existente.value=saveData2[i]['value'];
			forma.appendChild(nombre_existente);
			
			//console.log(saveData[i]['value']);
		}
		
		
		for(i=0; i<saveData3.length; i++)
		
		{	
			var puntos_existente=document.createElement("input");
			puntos_existente.name="puntos_existente[]";
			puntos_existente.type="hidden";
			puntos_existente.value=saveData3[i]['value'];
			forma.appendChild(puntos_existente);
			
			//console.log(saveData[i]['value']);
		}
		
		
		
		
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/

	forma.action = "procesos-desempeno.html";
	forma.accion.value="crear_nuevo_aspecto_evaluacion";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	//forma.id_agrega_criterio.value="";
	//forma.id_existente.value="";
	//forma.nombre_existente.value="";
	//forma.puntos_existente.value="";
	
	//muestra_historico_gestion(id);*/
	
}





function enviar_evaluacion(id){
	
	

	
	var forma = window.parent.document.principal
	
	
	var saveData1 = document.getElementsByName('id_calificados');
	var saveData2 = document.getElementsByName('aspecto_calificados');
	var saveData3 = document.getElementsByName('aspecto_puntos_calificados');
	var saveData4 = document.getElementsByName('puntos_calificados');
	var pasa10=document.getElementById('observacion_general').value
		
	
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
			var id_agrega_criterio=document.createElement("input");
			id_agrega_criterio.name="id_agrega_criterio";
			id_agrega_criterio.type="hidden";
			id_agrega_criterio.value=id;
			forma.appendChild(id_agrega_criterio);
			
	
		
		for(i=0; i<saveData1.length; i++)
		
		{	
			var id_calificados=document.createElement("input");
			id_calificados.name="id_calificados[]";
			id_calificados.type="hidden";
			id_calificados.value=saveData1[i]['value'];
			forma.appendChild(id_calificados);
			
			//console.log(saveData1[i]['value']);
		}
		
		
		
		for(i=0; i<saveData2.length; i++)
		
		{	
			var aspecto_calificados=document.createElement("input");
			aspecto_calificados.name="aspecto_calificados[]";
			aspecto_calificados.type="hidden";
			aspecto_calificados.value=saveData2[i]['value'];
			forma.appendChild(aspecto_calificados);
			
			//console.log(saveData2[i]['value']);
		}
		
		
		for(i=0; i<saveData3.length; i++)
		
		{	
			var aspecto_puntos_calificados=document.createElement("input");
			aspecto_puntos_calificados.name="aspecto_puntos_calificados[]";
			aspecto_puntos_calificados.type="hidden";
			aspecto_puntos_calificados.value=saveData3[i]['value'];
			forma.appendChild(aspecto_puntos_calificados);
			
			//console.log(saveData3[i]['value']);
		}
		
			for(i=0; i<saveData4.length; i++)
		
		{	
			var puntos_calificados=document.createElement("input");
			puntos_calificados.name="puntos_calificados[]";
			puntos_calificados.type="hidden";
			puntos_calificados.value=saveData4[i]['value'];
			forma.appendChild(puntos_calificados);
			
			//console.log(saveData4[i]['value']);
		}
		
		if (forma.observacion_general === undefined){//si el input no está definido
		var observacion_general=document.createElement("textarea");
		observacion_general.name="observacion_general";
		observacion_general.type="hidden";
		observacion_general.value=pasa10;
		forma.appendChild(observacion_general).style.display='none';
		}else{
			forma.observacion_general.value=pasa10;
		}
	

	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/

	forma.action = "procesos-desempeno.html";
	forma.accion.value="aspectos_calificados_evaluacion";
	forma.target="grp";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	//forma.id_agrega_criterio.value="";
	//forma.id_existente.value="";
	//forma.nombre_existente.value="";
	//forma.puntos_existente.value="";
	
	//muestra_historico_gestion(id);*/
	recarga_historico_admin_iframe(id);
	
}




function handleSelectChange(event) {

    var selectElement = event.target;
    var value = selectElement.value;
    alert(value);
}



function guarda_aspecto_admin(){
	
	var opcion_seleccionada = $('#tipo_criterio_aspecto option:selected').val();
	
	var opcion_seleccionada1 = $('#tipo_servicio option:selected').val();
	
	var pasa1=document.getElementById('nombre_aspectos').value
	var pasa2=document.getElementById('puntos_aspectos').value
	var pasa3=document.getElementById('nombre_descripcion').value
	
	
	var forma = window.parent.document.principal
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	if (forma.tipo_servicio === undefined){//si el input no está definido
		var tipo_servicio=document.createElement("input");
		tipo_servicio.name="tipo_servicio";
		tipo_servicio.type="hidden";
		tipo_servicio.value=opcion_seleccionada1;
		forma.appendChild(tipo_servicio);
	}else{
		forma.tipo_servicio.value=opcion_seleccionada1;
	}
	if (forma.tipo_criterio_aspecto === undefined){//si el input no está definido
		var tipo_criterio_aspecto=document.createElement("input");
		tipo_criterio_aspecto.name="tipo_criterio_aspecto";
		tipo_criterio_aspecto.type="hidden";
		tipo_criterio_aspecto.value=opcion_seleccionada;
		forma.appendChild(tipo_criterio_aspecto);
	}else{
		forma.tipo_criterio_aspecto.value=opcion_seleccionada;
	}
	
	if (forma.nombre_aspectos === undefined){//si el input no está definido
		var nombre_aspectos=document.createElement("input");
		nombre_aspectos.name="nombre_aspectos";
		nombre_aspectos.type="hidden";
		nombre_aspectos.value=pasa1;
		forma.appendChild(nombre_aspectos);
	}else{
		forma.nombre_aspectos.value=pasa1;
	}
	
	if (forma.puntos_aspectos === undefined){//si el input no está definido
		var puntos_aspectos=document.createElement("input");
		puntos_aspectos.name="puntos_aspectos";
		puntos_aspectos.type="hidden";
		puntos_aspectos.value=pasa2;
		forma.appendChild(puntos_aspectos);
	}else{
		forma.puntos_aspectos.value=pasa2;
	}
	
	if (forma.nombre_descripcion === undefined){//si el input no está definido
		var nombre_descripcion=document.createElement("input");
		nombre_descripcion.name="nombre_descripcion";
		nombre_descripcion.type="hidden";
		nombre_descripcion.value=pasa3;
		forma.appendChild(nombre_descripcion);
	}else{
		forma.nombre_descripcion.value=pasa3;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="crea_aspecto" 
	forma.target="grp"
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
    forma.tipo_criterio_aspecto.value="";
    forma.tipo_servicio.value="";
    forma.nombre_aspectos.value="";
    forma.puntos_aspectos.value="";
    forma.nombre_descripcion.value="";
}




function abrir_modal(variable){
	
				// Create the instance
			var modal = new LightFace.Request({
				width: 400,
				height: 300,
				title: 'User Information',
				url: 'carga_modal.php',
				request: {
					method: 'post',
					data: {
						userID: 3
					}
				}
			});

			// Open!
			modal.open();

			// Load a different url!
			modal.load('','Static Content');
	
	//ejecuta_modal('modal1');
	/*var forma = window.parent.document.principal
	forma.action = "procesos-desempeno.html";
	forma.accion.value="modal" 
	forma.target="grp"
	forma.id_criterio.value=variable;
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""

	//ejecuta_modal('modal1');*/

	}

function ejecuta_modal(variable){
	//$(document).ready(function () {
		$('#'+variable).modal('open');
	//});
}






function muestra_modal_editar_criterio_admin(id){
	ajax_carga('../../aplicaciones/desempeno/carga_modal_criterio.php?id_criterio='+id, 'carga_modal');
	setTimeout(function(){ $('#modal_criterio').modal('open');
	//$('#modal_criterio').show();
						 }, 500);
	
}

function muestra_modal_editar_aspecto_admin(id){
	ajax_carga('../../aplicaciones/desempeno/carga_modal_aspecto.php?id_criterio='+id, 'carga_modal');
	setTimeout(function(){ $('#modal_criterio').modal('open');
	//$('#modal_criterio').show();
						 }, 500);
	
}


function muestra_modal_configurar_aspecto(id){
	
	ajax_carga('../../aplicaciones/desempeno/cargar_modal_configurar_aspectos.php?id_criterio='+id, 'carga_modal_configurar_aspecto');
	setTimeout(function(){ $('#modal_criterio').modal('open');
	//$('#modal_criterio').show();
						 }, 500);
	
}

function edita_criterio_admin(id){
	var forma = window.parent.document.principal
	var pasa1=document.getElementById('nombre_criterio_edicion').value;
	var pasa2=document.getElementById('puntos_criterio_edicion').value;
	var pasa3=document.getElementById('tipo_contrato_edicion').value;
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	if (forma.nombre_criterio === undefined){//si el input no está definido
		var nombre_criterio=document.createElement("input");
		nombre_criterio.name="nombre_criterio";
		nombre_criterio.type="hidden";
		nombre_criterio.value=pasa1;
		forma.appendChild(nombre_criterio);
	}else{
		forma.nombre_criterio.value=pasa1;
	}
	if (forma.tipo_contrato === undefined){//si el input no está definido
		var tipo_contrato=document.createElement("input");
		tipo_contrato.name="tipo_contrato";
		tipo_contrato.type="hidden";
		tipo_contrato.value=pasa3;
		forma.appendChild(tipo_contrato);
	}else{
		forma.tipo_contrato.value=pasa3;
	}
	if (forma.puntos_criterio === undefined){//si el input no está definido
		var puntos_criterio=document.createElement("input");
		puntos_criterio.name="puntos_criterio";
		puntos_criterio.type="hidden";
		puntos_criterio.value=pasa2;
		forma.appendChild(puntos_criterio);
	}else{
		forma.puntos_criterio.value=pasa2;
	}
	
	if (forma.id_criterio === undefined){//si el input no está definido
		var id_criterio=document.createElement("input");
		id_criterio.name="id_criterio";
		id_criterio.type="hidden";
		id_criterio.value=id;
		forma.appendChild(id_criterio);
	}else{
		forma.id_criterio.value=id;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="edita_criterio_admin";
	forma.target="grp";
	forma.submit();
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.nombre_criterio.value="";
	forma.puntos_criterio.value="";
	forma.id_criterio.value="";
	forma.tipo_contrato.value="";
	recarga_criterio_admin_iframe();
}


function edita_aspecto_admin(id){
	var forma = window.parent.document.principal;
	var pasa1=document.getElementById('nombre_aspecto_edicion').value;
	var pasa2=document.getElementById('puntos_aspecto_edicion').value;
	var pasa3=document.getElementById('descripcion_aspecto_edicion').value;
	var pasa4=document.getElementById('tipo_criterio_aspecto_edicion').value;
	var pasa5=document.getElementById('tipo_servicio_edicion').value;
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	if (forma.nombre_aspectos === undefined){//si el input no está definido
		var nombre_aspectos=document.createElement("input");
		nombre_aspectos.name="nombre_aspectos";
		nombre_aspectos.type="hidden";
		nombre_aspectos.value=pasa1;
		forma.appendChild(nombre_aspectos);
	}else{
		forma.nombre_aspectos.value=pasa1;
	}
	
	if (forma.puntos_aspectos === undefined){//si el input no está definido
		var puntos_aspectos=document.createElement("input");
		puntos_aspectos.name="puntos_aspectos";
		puntos_aspectos.type="hidden";
		puntos_aspectos.value=pasa2;
		forma.appendChild(puntos_aspectos);
	}else{
		forma.puntos_aspectos.value=pasa2;
	}
	if (forma.tipo_servicio === undefined){//si el input no está definido
		var tipo_servicio=document.createElement("input");
		tipo_servicio.name="tipo_servicio";
		tipo_servicio.type="hidden";
		tipo_servicio.value=pasa5;
		forma.appendChild(tipo_servicio);
	}else{
		forma.tipo_servicio.value=pasa5;
	}
	if (forma.tipo_criterio_aspecto === undefined){//si el input no está definido
		var tipo_criterio_aspecto=document.createElement("input");
		tipo_criterio_aspecto.name="tipo_criterio_aspecto";
		tipo_criterio_aspecto.type="hidden";
		tipo_criterio_aspecto.value=pasa4;
		forma.appendChild(tipo_criterio_aspecto);
	}else{
		forma.tipo_criterio_aspecto.value=pasa4;
	}
	if (forma.nombre_descripcion === undefined){//si el input no está definido
		var nombre_descripcion=document.createElement("input");
		nombre_descripcion.name="nombre_descripcion";
		nombre_descripcion.type="hidden";
		nombre_descripcion.value=pasa3;
		forma.appendChild(nombre_descripcion);
	}else{
		forma.nombre_descripcion.value=pasa3;
	}
	
	if (forma.id_aspecto === undefined){//si el input no está definido
		var id_aspecto=document.createElement("input");
		id_aspecto.name="id_aspecto";
		id_aspecto.type="hidden";
		id_aspecto.value=id;
		forma.appendChild(id_aspecto);
	}else{
		forma.id_aspecto.value=id;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="edita_aspecto_admin";
	forma.target="grp";
	forma.submit();
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.nombre_aspectos.value="";
	forma.puntos_aspectos.value="";
	forma.nombre_descripcion.value="";
	forma.id_aspecto.value="";
	forma.tipo_criterio_aspecto.value="";
	forma.tipo_servicio.value="";
	recarga_aspecto_admin_iframe();
}



function elimina_criterio_admin(id, actviva_alerta){
	if(actviva_alerta==''){
		window.parent.muestra_alerta_general_solo_texto('elimina_criterio_admin(-comillas-'+id+'-comillas-,-comillas-12-comillas-)', 'Advertencia','*Está Seguro de Eliminar Este Criterio?', 40, 10, 12);
		return;
	}
	var forma = window.parent.document.principal;
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	if (forma.id_criterio === undefined){//si el input no está definido
		var id_criterio=document.createElement("input");
		id_criterio.name="id_criterio";
		id_criterio.type="hidden";
		id_criterio.value=id;
		forma.appendChild(id_criterio);
	}else{
		
		forma.id_criterio.value=id;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="elimina_criterio_admin";
	forma.target="grp";
	forma.submit();
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_criterio.value="";
	recarga_criterio_admin_iframe();
}


function elimina_aspecto_admin(id, actviva_alerta){
	if(actviva_alerta==''){
		window.parent.muestra_alerta_general_solo_texto('elimina_aspecto_admin(-comillas-'+id+'-comillas-,-comillas-12-comillas-)', 'Advertencia','*Está Seguro de Eliminar Este Aspecto?', 40, 10, 12);
		return;
	}
	var forma = window.parent.document.principal;
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	if (forma.id_aspectos === undefined){//si el input no está definido
		var id_aspectos=document.createElement("input");
		id_aspectos.name="id_aspectos";
		id_aspectos.type="hidden";
		id_aspectos.value=id;
		forma.appendChild(id_aspectos);
	}else{
		
		forma.id_aspectos.value=id;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="elimina_aspecto_admin";
	forma.target="grp";
	forma.submit();
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_aspectos.value="";
	recarga_aspecto_admin_iframe();
}


function elimina_configuracion_criterio(id, actviva_alerta, id_criterio){
	
	
	console.log(id);
	
	console.log(actviva_alerta);
	
	console.log(id_criterio);
	
	if(actviva_alerta==''){
		window.parent.muestra_alerta_general_solo_texto('elimina_configuracion_criterio(-comillas-'+id+'-comillas-,-comillas-12-comillas-,-comillas-'+id_criterio+'-comillas-)', 'Advertencia','*Está Seguro de Eliminar Este Aspecto?', 40, 10, 12);
		return;
	}
	
	var forma = window.parent.document.principal;
	/**** SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	if (forma.id_aspectos === undefined){//si el input no está definido
		var id_aspectos=document.createElement("input");
		id_aspectos.name="id_aspectos";
		id_aspectos.type="hidden";
		id_aspectos.value=id;
		forma.appendChild(id_aspectos);
	}else{
		
		forma.id_aspectos.value=id;
	}
	
	if (forma.id_criterio_evaluacion === undefined){//si el input no está definido
		var id_criterio_evaluacion=document.createElement("input");
		id_criterio_evaluacion.name="id_criterio_evaluacion";
		id_criterio_evaluacion.type="hidden";
		id_criterio_evaluacion.value=id_criterio;
		forma.appendChild(id_criterio_evaluacion);
	}else{
		
		forma.id_criterio_evaluacion.value=id_criterio_evaluacion;
	}
	/**** FIN SE UTILIZA ESTE METODO PORQUE EL MÓDULO ESTÁ DENTRO DE UN IFRAME ****/
	
	
	forma.action = "procesos-desempeno.html";
	forma.accion.value="elimina_configuracion_criterio";
	forma.target="grp";
	forma.submit();
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value="";
	forma.target="";
	forma.id_aspectos.value="";
	forma.id_criterio_evaluacion.value="";
	recarga_modal_configuracion_aspectos(id_criterio);
}




function guarda_aspectos_evaluacion(){
	var pasa1=document.getElementById('nombre_criterio').value
	var pasa2=document.getElementById('puntos_criterio').value
	var forma = window.parent.document.principal
	forma.action = "procesos-desempeno.html";
	forma.accion.value="crea_criterio" 
	forma.target="grp"
	forma.nombre_criterio.value=pasa1;
	forma.puntos_criterio.value=pasa2;
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function buscador_tabla_historico(div, pagina, posicion){
	if(document.getElementById("estado_evaluacion")!=null){
		var caracter1=document.getElementById('estado_evaluacion').value;
	}else{
		var caracter1="";
	}
	if(document.getElementById('nombre_proveedor')!=null){
		var caracter2=document.getElementById('nombre_proveedor').value;
	}else{
		var caracter2="";
	}
	ajax_carga('../../aplicaciones/desempeno/buscador_hitorico_admin.php?caracter1='+caracter1+'&caracter2='+caracter2, div);
	paginador_tabla_historico(pagina, posicion, 'foot_historico_procesos');
}
function paginador_tabla_historico(pagina, posicion, div){
	if(document.getElementById("estado_evaluacion")!=null){
		var caracter1=document.getElementById('estado_evaluacion').value;
	}else{
		var caracter1="";
	}
	if(document.getElementById('nombre_proveedor')!=null){
		var caracter2=document.getElementById('nombre_proveedor').value;
	}else{
		var caracter2="";
	}
	var val_actual=document.getElementsByClassName('color-blue-light-hocol');
	ajax_carga('../../aplicaciones/desempeno/paginador_hitorico_admin.php?caracter1='+caracter1+'&caracter2='+caracter2+'&pagina='+pagina+'&posicion='+posicion+'&val_actual='+val_actual, div);
	buscador_tabla_historico('body_historico_procesos', pagina, posicion);
}

















