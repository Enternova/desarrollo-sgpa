function fnGo(){
window.scrollTo(0, 0)
}

function graba_objetivos_proceso() {
    var forma = document.principal
    forma.action = "procesos-comite.html";
    forma.accion.value = "graba_objetivos_proceso"
    forma.target = "grp"

    forma.campo_ob_proceso1.value = document.getElementById("campos1").value
    forma.campo_ob_proceso2.value = document.getElementById("campos2").value
    forma.campo_ob_proceso3.value = document.getElementById("campos3").value
    forma.campo_ob_proceso4.value = document.getElementById("campos4").value
    forma.campo_ob_proceso5.value = document.getElementById("campos5").value
    forma.campo_ob_proceso6.value = document.getElementById("campos6").value
    forma.campo_ob_proceso7.value = document.getElementById("campos7").value

    forma.submit()
}

function finalizacion_comite() {

    var forma = document.principal

    //var alerta = confirm("Está seguro de finalizar este comité, se enviará a los interesados vía E-mail el acta de cierre del comité.")
    //if (alerta) {

        forma.action = "procesos-comite.html";
        forma.accion.value = "finalizar_acciones_comite"
        forma.target = "grp"
        forma.submit()
    //}else{
		//window.parent.document.getElementById("cargando_pecc").style.display = "none"
		//}
}

function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
           return false;

        return true;
    }

function graba_nuevo_valor(id_item, valor_cop, valor_usd, id_presupuesto) {

    var forma = document.principal

    if (valor_cop == "" && valor_usd == "") {
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Por favor ingrese un valor', 40, 5, 12)
        return
    }

    var alerta = confirm("Esta seguro de cambiar el valor del ITEM - RECUERDE QUE CAMBIARA TODA LA DISTRIBUCION A 'CORPORATIVO SIN SOCIOS'?")
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item;
        forma.id_presupuesto.value = id_presupuesto;
        forma.valor_usd_dif.value = valor_usd;
        forma.valor_cop_dif.value = valor_cop;
        forma.accion.value = "cambia_valor_item"
        forma.target = "grp"
        forma.submit()
    }

}

function graba_cambio_tp_proceso(id_item) {
    var forma = document.principal

    var alerta = confirm("Esta seguro de grabar cambiar el tipo de proceso?")
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item;
        forma.accion.value = "graba_cambio_tp_proceso"
        forma.target = "grp"
        forma.submit()
    }

}
function graba_comentario_comite(id_item) {
    var forma = document.principal

    var alerta = confirm("Esta seguro de grabar este comentario?")
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item;
        forma.accion.value = "graba_comentario_comite"
        forma.target = "grp"
        forma.submit()
    }

}
function graba_verifica_comite_fer(item_agrega) {
     var forma = document.principal

    var alerta = confirm("Esta seguro de verificar esta solicitud?");
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.accion.value = "verifica_comite_presidente";
        forma.id_item_agrega.value = item_agrega;
        forma.target = "grp";
        forma.submit()
    }
}
function graba_no_verifica_comite(item_agrega, campo_texto) {
     var forma = document.principal

	if(campo_texto.value == "" || campo_texto.value == " " || campo_texto.value == "  " || campo_texto.value == "   "){
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Para poder grabar por favor digite una observación', 40, 5, 12)
		return;
		
		}

    var alerta = confirm("Esta seguro de NO verificar esta solicitud? (se enviara un correo electrónico al profesional encargado)");
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.accion.value = "no_verifica_comite_presidente";
        forma.id_item_agrega.value = item_agrega;
        forma.target = "grp";
        forma.submit()
    }
}
function crea_accion_comite_usuario(item_agrega, asistente, alerta_vencimiento, tipo_firma) {
    var forma = document.principal
	
	if(alerta_vencimiento != "" && (tipo_firma == 1 || tipo_firma == 4)){
		alert (alerta_vencimiento)
		return;
		}
		
    forma.action = "procesos-comite.html";
    forma.accion.value = "crea_accion_aprobacion"
    forma.id_item_agrega.value = item_agrega
    forma.asistente_comote.value = asistente

    forma.target = "grp"
    forma.submit()
}
function garba_edita_comite(tipo_alerta) {
    var forma = document.principal
	
	var msg="";
	
	if(forma.fecha_comite.value == "" || forma.fecha_comite.value == " "){
			 msg = msg + "* Seleccione la fecha del comité"
             forma.fecha_comite.className = "campos_faltantes";
			}else{
				forma.fecha_comite.className = "";
				}
	if(forma.hora_i.value == "100"){
			 msg = msg + "* Seleccione la hora del comité"
             forma.hora_i.className = "select_faltantes";
			}else{
				forma.hora_i.className = "";
				}
	if(forma.minuto_i.value == "100"){
			 msg = msg + "* Seleccione el minuto del comité"
             forma.minuto_i.className = "select_faltantes";
			}else{
				forma.minuto_i.className = "";
				}
	if(forma.formato_i.value == "100"){
			 msg = msg + "* Seleccione si es AM o PM la hora del comité"
             forma.formato_i.className = "select_faltantes";
			}else{
				forma.formato_i.className = "";
				}
	if(forma.lugar_comite.value == "" || forma.lugar_comite.value == " "){
			 msg = msg + "* Digite el lugar del comité"
             forma.lugar_comite.className = "campos_faltantes";
			}else{
				forma.lugar_comite.className = "";
				}
	
	if(msg != ""){
		
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:<br><br>'+msg, 40, 5, 12)
		 return
	}else{
	
		if (forma.estado_comite_abre_cierra.value == 3 && tipo_alerta == "") {
			muestra_alerta_general_solo_texto("garba_edita_comite(1)", "Advertencia", "Se va a enviar el acta de apertura de este comité vía E-mail, desea continuar?", 40, 5, 12)
			return
			
		}
		
		forma.action = "procesos-comite.html";
		forma.accion.value = "edita_comite_info_gen"
		forma.target = "grp"
		forma.submit()
		
	}
	
	
    


}
function edita_comtite_agrega_item(tipo) {
    var forma = document.principal


    forma.action = "procesos-comite.html";
    forma.agregar_mas_items.value = tipo
    forma.accion.value = "agrega_o_no_mas_item"
    forma.target = "grp"
    forma.submit()


}

function funquita_asistente(id_asistente) {
    var forma = document.principal


  //  var alerta = confirm("Esta seguro de quitar de este comité?")
    //if (alerta) {
        forma.action = "procesos-comite.html";
        forma.quita_asistente.value = id_asistente
        forma.accion.value = "quita_asistente"
        forma.target = "grp"
        forma.submit()
    //}
}
function agrega_asistente() {
    var forma = document.principal

    var msg = ""


    if (forma.usuario_permiso.value == "") {
        msg = msg + "* Seleccione el Asistente\n"
        forma.usuario_permiso.className = "campos_faltantes";
    } else {
        forma.usuario_permiso.className = "";
    }
    if (forma.requiere_aprobacion.value == 1) {
        if (forma.rol_comite.value == "") {
            msg = msg + "* Digite el Rol en el Comité\n"
            forma.rol_comite.className = "campos_faltantes";
        } else {
            forma.rol_comite.className = "";
        }
        if (forma.orden_aprueba.value == "") {
            msg = msg + "* Digite el Orden de Aprobación\n"
            forma.orden_aprueba.className = "campos_faltantes";
        } else {
            forma.orden_aprueba.className = "";
        }

    }

    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {

       // var alerta = confirm("Esta seguro de Agregar este Asistente?")

       // if (alerta) {
            forma.action = "procesos-comite.html";
            forma.accion.value = "agrega_asistente"
            forma.target = "grp"
            forma.submit()
       // }
    }
}

function valida_si_es_aprobador(valor) {
    if (valor == 1) {
        window.parent.document.getElementById("oculta_requiere").style.display = ""
        window.parent.document.getElementById("orden_aprobacion").style.display = ""
    } else {
        window.parent.document.getElementById("oculta_requiere").style.display = "none"
        window.parent.document.getElementById("orden_aprobacion").style.display = "none"
    }
}

function cambia_orden_asistente(id_relacion, orden) {
    var forma = document.principal
    forma.action = "procesos-comite.html";
    forma.accion.value = "cambia_orden_asistente"
    forma.id_relacion.value = id_relacion
    forma.orden_cambia.value = orden
    forma.target = "grp"
    forma.submit()
}
function cambia_oprde_ite_comite(id_item_cambia_orden) {
    window.parent.document.getElementById("cargando_pecc").style.display = "block"
    var forma = document.principal
    forma.orden_cambia.value = id_item_cambia_orden
    forma.action = "procesos-comite.html";
    forma.accion.value = "cambia_orden_comite"
    forma.target = "grp"
    forma.submit()

}


function crear_comite() {
    var forma = document.principal


    //var alerta = confirm("Esta seguro de crear este comité?")

    //if (alerta) {
        forma.action = "procesos-comite.html";
        forma.accion.value = "crear_comite"
        forma.target = "grp"
        forma.submit()
    //}
}

function crear_tarea() {
    valida_inserta_tarea();
}
function editar_tarea() {
    valida_modifica_tarea();
}
function responder_gestion(estado,id){
    if ($('#detalle_gestion').val()!="") {
        var archivos=new FormData();
        var request=new XMLHttpRequest();
        request.open('post','procesos-comite.html',true);
        request.onreadystatechange = function(){
            if (request.readyState === 4 && request.status === 200){
                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                //window.parent.alert(request.responseText); respuesta del la pagina visitada
                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                }
                if(estado==3){
                    ajax_carga('../aplicaciones/comite/tareas-comite.php','contenidos');
                }else{
                    ajax_carga('../aplicaciones/comite/tareas-comite.php?id_comite='+$('#id_tarea').val(),'contenidos');
                }*/
            }

        }
        archivos.append('accion','gestion_tarea');
        archivos.append('id_gestion',$('#id_gestion').val());
        archivos.append('id_tarea',id);
        archivos.append('estado',estado);
        archivos.append('gestion',$('#detalle_gestion').val());
        request.send(archivos);
    }else{
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*El campo respuesta no puede estar vacío', 40, 5, 12)
    }
}function archivar_gestion(){
    if(confirm('¿Está seguro que desea archivar esta gestión?')){
        var archivos=new FormData();
        var request=new XMLHttpRequest();
        request.open('post','procesos-comite.html',true);
        request.onreadystatechange = function(){
            if (request.readyState === 4 && request.status === 200){
                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+$('#id_tarea').val(),'contenidos');
                //window.parent.alert(request.responseText); respuesta del la pagina visitada
                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                }
                if(estado==3){
                    ajax_carga('../aplicaciones/comite/tareas-comite.php','contenidos');
                }else{
                    ajax_carga('../aplicaciones/comite/tareas-comite.php?id_comite='+$('#id_tarea').val(),'contenidos');
                }*/
            }

        }
        archivos.append('accion','archivar_tarea');
        archivos.append('id_gestion',$('#id_gestion').val());
        archivos.append('id_tarea',$('#id_tarea').val());
        request.send(archivos);
    }
}
function genera_gestion(estado,id){
    if ($('#genera_detalle_gestion').val()!="") {
        var archivos=new FormData();
        var request=new XMLHttpRequest();
        request.open('post','procesos-comite.html',true);
        request.onreadystatechange = function(){
            if (request.readyState === 4 && request.status === 200){
                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                //window.parent.alert(request.responseText); //respuesta del la pagina visitada
                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                }
                if(estado==3){
                    ajax_carga('../aplicaciones/comite/tareas-comite.php','contenidos');
                }else{
                    ajax_carga('../aplicaciones/comite/tareas-comite.php?id_comite='+$('#id_tarea').val(),'contenidos');
                }*/
            }
        }
        archivos.append('accion','genera_gestion_tarea');
        archivos.append('id_tarea',id);
        archivos.append('estado',estado);
        archivos.append('gestion',$('#genera_detalle_gestion').val());
        request.send(archivos);
    }else{
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*El campo respuesta no puede estar vacío', 40, 5, 12)
    }
}
function quita_comite(id_item) {
    var forma = document.principal
    var coment = document.getElementsByName('comite_coment')[0].value;
    var alerta = confirm("Esta seguro de quitar esta solicitud de este comité?")
    if (alerta) {
        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item
        forma.comite_coment.value = coment
        forma.accion.value = "quita_comite"
        forma.target = "grp"
        forma.submit()
    }
}


function agregar_comite_todos() {
    var forma = document.principal
  // var alerta = confirm("Esta seguro de agregar todas las solicitudes al comite?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-comite.html";
        forma.accion.value = "agrega_comite_item_todos"
        forma.target = "grp"
        forma.submit()
    //}
}

function agregar_comite(id_comite, id_item) {
    var forma = document.principal
    //var alerta = confirm("Esta seguro de agregar esta solicitud al comite?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item
        forma.id_comite_agrega.value = id_comite
        forma.accion.value = "agrega_comite_item"
        forma.target = "grp"
        forma.submit()
    //}
}
/*funcion para validar que el id del comite, solisitud tenga valor válido*/
function valida_inserta_tarea(){
  if($('#busca_id_responsable').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar el usuario responsable', 40, 5, 12)
    }else if($('#busca_id_cierre').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar el encargado de cierre', 40, 5, 12)
    }else if($('#busca_id_comite').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar el comité que generó la tarea', 40, 5, 12)
    }else if($('#fecha_cierre').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar una fecha', 40, 5, 12)
    }else if($('#titulo').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe llenar información en el campo titulo', 40, 5, 12)
    }else if($('#detalle').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe llenar información en el campo detalle', 40, 5, 12)
    }else{
        var cadena=$('#busca_id_comite').val();
        var arr_comite=cadena.split('----,');
        cadena=$('#busca_id_responsable').val();
        var arr_responsable=cadena.split('----,');

         cadena=$('#busca_id_cierre').val();
        var arr_cierre=cadena.split('----,');
        if (arr_comite[4]==undefined) {
            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en comite', 40, 5, 12)
        }else if (arr_responsable[1]==undefined || arr_responsable[1]=="" || arr_responsable[1]==0) {
            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en usuario responsable', 40, 5, 12)
        }else if (arr_cierre[1]==undefined || arr_cierre[1]=="" || arr_cierre[1]==0) {
            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en encargado de cierre', 40, 5, 12)
        }else{
            if ($("#agrega_solicitud").is(":checked")) {
                if($('#busca_id_solicitud').val()==""){
                    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en solicitud', 40, 5, 12)
                }else{
                    cadena=$('#busca_id_solicitud').val();
                    var arr_solicitud=cadena.split('----,');
                    if (arr_solicitud[2]==undefined) {
                        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en solicitud', 40, 5, 12)
                    }else{
                        var archivos=new FormData()
                        var request=new XMLHttpRequest();
                        request.open('post','procesos-comite.html',true);
                        request.onreadystatechange = function(){
                            if (request.readyState === 4 && request.status === 200){
                                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                                ajax_carga('../aplicaciones/comite/crea-tarea-comite.php','contenidos');
                                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                                }*/
                            }

                        }
                        archivos.append('accion','crear_tarea');
                        archivos.append('id_responsable',arr_responsable[1]);
                        archivos.append('id_cierre',arr_cierre[1]);
                        archivos.append('id_comite',arr_comite[4]);
                        archivos.append('id_solicitud',arr_solicitud[2]);
                        archivos.append('fecha_cierre',$('#fecha_cierre').val());
                        archivos.append('titulo',$('#titulo').val());
                        archivos.append('detalle',$('#detalle').val());
                        archivos.append('seguimiento',"");
                        archivos.append('estado',"1");
                        request.send(archivos);
                    }
                }
            }else {
                var archivos=new FormData()
                var request=new XMLHttpRequest();
                request.open('post','procesos-comite.html',true);
                request.onreadystatechange = function(){
                    if (request.readyState === 4 && request.status === 200){
                        muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                        ajax_carga('../aplicaciones/comite/crea-tarea-comite.php','contenidos');
                        /*if (request.responseText == "added") // if (xhr.responseText == "added")
                          {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                        }*/
                    }

                }
                archivos.append('accion','crear_tarea');
                archivos.append('id_responsable',arr_responsable[1]);
                archivos.append('id_cierre',arr_cierre[1]);
                archivos.append('id_comite',arr_comite[4]);
                archivos.append('id_solicitud',"");
                archivos.append('fecha_cierre',$('#fecha_cierre').val());
                archivos.append('titulo',$('#titulo').val());
                archivos.append('detalle',$('#detalle').val());
                archivos.append('seguimiento',"");
                archivos.append('estado',"1");
                request.send(archivos);
            }
        }
    }
}
function valida_modifica_tarea(id){
 if($('#busca_id_responsable').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar el usuario responsable', 40, 5, 12)
    }else if($('#busca_id_cierre').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar el encargado de cierre', 40, 5, 12)
    }else if($('#modifica_cierre').val()==undefined){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en emcargado cierre', 40, 5, 12)
    }else if($('#modifica_comite').val()==undefined){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en comité', 40, 5, 12)
    }else if($('#fecha_cierre').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar una fecha', 40, 5, 12)
    }else if($('#titulo').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe llenar información en el campo titulo', 40, 5, 12)
    }else if($('#detalle').val()==""){
    muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe llenar información en el campo detalle', 40, 5, 12)
    }else{
        var cadena=$('#busca_id_responsable').val();
        var arr_responsable=cadena.split('----,');

         cadena=$('#busca_id_cierre').val();
        var arr_cierre=cadena.split('----,');
        if (arr_responsable[1]==undefined || arr_responsable[1]=="" || arr_responsable[1]==0) {
            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en usuario responsable', 40, 5, 12)
        }else if (arr_cierre[1]==undefined || arr_cierre[1]=="" || arr_cierre[1]==0) {
            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en encargado de cierre', 40, 5, 12)
        }else{
                if ($("#agrega_solicitud").is(":checked")) {
                    if($('#modifica_solicitud').val()==undefined){
                        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en usuario responsable', 40, 5, 12)
                    }else{
                        if($('#busca_id_solicitud').val()==""){
                            muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en solicitud', 40, 5, 12)
                        }else{
                            cadena=$('#busca_id_solicitud').val();
                            var arr_solicitud=cadena.split('----,');
                            if (arr_solicitud[2]==undefined) {
                                muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:*Debe seleccionar un valor válido en solicitud', 40, 5, 12)
                            }else{
                                var archivos=new FormData()
                                var request=new XMLHttpRequest();
                                if ($('#estado').val()==3) {
                                    var confirma=confirm('¿Está seguro(a) que desea cerrar esta tarea?')
                                    if (confirma) {
                                        request.open('post','procesos-comite.html',true);
                                        request.onreadystatechange = function(){
                                            if (request.readyState === 4 && request.status === 200){
                                                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                                                ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                                                //window.parent.alert(request.responseText); respuesta del la pagina visitada
                                                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                                                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                                                }*/
                                            }

                                        }
                                        archivos.append('accion','editar_tarea');
                                        archivos.append('id_tarea',$('#modifica_tarea').val());
                                        archivos.append('id_responsable',arr_responsable[1]);
                                        archivos.append('id_cierre',arr_cierre[1]);
                                        archivos.append('id_comite',$('#modifica_comite').val());
                                        archivos.append('id_solicitud',arr_solicitud[2]);
                                        archivos.append('fecha_cierre',$('#fecha_cierre').val());
                                        archivos.append('titulo',$('#titulo').val());
                                        archivos.append('detalle',$('#detalle').val());
                                        archivos.append('seguimiento',"");
                                        archivos.append('estado',$('#estado').val());
                                        request.send(archivos);
                                    }else{
                                        ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                                    }
                                }else{
                                    request.open('post','procesos-comite.html',true);
                                    request.onreadystatechange = function(){
                                        if (request.readyState === 4 && request.status === 200){
                                            muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                                            ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                                            //window.parent.alert(request.responseText); respuesta del la pagina visitada
                                            /*if (request.responseText == "added") // if (xhr.responseText == "added")
                                              {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                                            }*/
                                        }

                                    }
                                    archivos.append('accion','editar_tarea');
                                    archivos.append('id_tarea',$('#modifica_tarea').val());
                                    archivos.append('id_responsable',arr_responsable[1]);
                                    archivos.append('id_cierre',arr_cierre[1]);
                                    archivos.append('id_comite',$('#modifica_comite').val());
                                    archivos.append('id_solicitud',arr_solicitud[2]);
                                    archivos.append('fecha_cierre',$('#fecha_cierre').val());
                                    archivos.append('titulo',$('#titulo').val());
                                    archivos.append('detalle',$('#detalle').val());
                                    archivos.append('seguimiento',"");
                                    archivos.append('estado',$('#estado').val());
                                    request.send(archivos);
                                }
                            }
                        }
                    }
                }else {
                    
                    if ($('#estado').val()==3) {
                        var confirma=confirm('¿Está seguro(a) que desea cerrar esta tarea?')
                        if (confirma) {
                            var archivos=new FormData()
                            var request=new XMLHttpRequest();
                            request.open('post','procesos-comite.html',true);
                            request.onreadystatechange = function(){
                                if (request.readyState === 4 && request.status === 200){
                                    muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                                    ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                                    //window.parent.alert(request.responseText); respuesta del la pagina visitada
                                    /*if (request.responseText == "added") // if (xhr.responseText == "added")
                                      {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                                    }*/
                                }

                            }
                            
                            archivos.append('accion','editar_tarea');
                            archivos.append('id_tarea',$('#modifica_tarea').val());
                            archivos.append('id_responsable',arr_responsable[1]);
                            archivos.append('id_cierre',arr_cierre[1]);
                            archivos.append('id_comite',$('#modifica_comite').val());
                            archivos.append('id_solicitud',$('#modifica_solicitud').val());
                            archivos.append('fecha_cierre',$('#fecha_cierre').val());
                            archivos.append('titulo',$('#titulo').val());
                            archivos.append('detalle',$('#detalle').val());
                            archivos.append('seguimiento',"");
                            archivos.append('estado',$('#estado').val());
                            request.send(archivos);
                        }else{
                            ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                        }
                    }else{
                        var archivos=new FormData()
                        var request=new XMLHttpRequest();
                        request.open('post','procesos-comite.html',true);
                        request.onreadystatechange = function(){
                            if (request.readyState === 4 && request.status === 200){
                                muestra_alerta_iformativa_solo_texto_guardado_exito('', 'Proceso Correcto', 'Los Datos se Almacenarón con Éxito', 40, 5, 12)
                                ajax_carga('../aplicaciones/comite/edicion-comite-tarea.php?id_comite='+id,'contenidos');
                                //window.parent.alert(request.responseText); respuesta del la pagina visitada
                                /*if (request.responseText == "added") // if (xhr.responseText == "added")
                                  {document.getElementById("status").innerHTML = "<p>Added the Record</p>"};
                                }*/
                            }

                        }
                        
                        archivos.append('accion','editar_tarea');
                        archivos.append('id_tarea',$('#modifica_tarea').val());
                        archivos.append('id_responsable',arr_responsable[1]);
                        archivos.append('id_cierre',arr_cierre[1]);
                        archivos.append('id_comite',$('#modifica_comite').val());
                        archivos.append('id_solicitud',$('#modifica_solicitud').val());
                        archivos.append('fecha_cierre',$('#fecha_cierre').val());
                        archivos.append('titulo',$('#titulo').val());
                        archivos.append('detalle',$('#detalle').val());
                        archivos.append('seguimiento',"");
                        archivos.append('estado',$('#estado').val());
                        request.send(archivos);
                    }
                }
        }
    }
}
function muestra_respuesta_tarea(){
    $('#respuesta_tarea_usuario').css('display', 'block');
}
function muestra_respuesta_tarea_admin(){
    $('#respuesta_tarea_admin').css('display', 'block');
}
function oculta_respuesta_tarea(){
    $('#respuesta_tarea_usuario').css('display', 'none');
}
function oculta_respuesta_tarea_admin(){
    $('#respuesta_tarea_admin').css('display', 'none');
}

function muestra_gestion_tarea(){
    $('#genera_gestion_tarea_usuario').css('display', 'block');
}
function muestra_gestion_tarea_admin(){
    $('#genera_gestion_tarea_admin').css('display', 'block');
}
function oculta_gestion_tarea(){
    $('#genera_gestion_tarea_usuario').css('display', 'none');
}
function oculta_gestion_tarea_admin(){
    $('#genera_gestion_tarea_admin').css('display', 'none');
}
$(".windowPopup").live('click',function(){
    $("body").css('overflow','hidden');
    $("#div_carga_busca_sol").css('overflow','scroll');
});

$(".windowPopupClose").live('click',function(){
    $("body").css('overflow','scroll');
});

function graba_conflicto_comite(id){
    //alert($('#idsolicitud'+id).val());
    var forma = document.principal
    if($('#'+id).val()==1){
        if($('#comite_coment'+id).val()==""){
			 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:<br><br>Si la solicitud tiene conflicto de intereses por favor ingrese el comentario correspondiente al conflicto', 40, 5, 12)
            //alert('Por favor Verifique el formulario\nSi la solicitud tiene conflicto de intereses por favor ingrese el comentario correspondiente al conflicto');
            //forma.(comite_coment+id).className="campos_faltantes";
            $('#comite_coment'+id).addClass("textarea_faltantes");
            $('#'+id).val(0);
        }else{
            forma.id_solicitud_pasa.value=$('#idsolicitud'+id).val();
            forma.comite_coment.value=$('#comite_coment'+id).val();
            forma.valor_solicitud_pasa.value=$('#'+id).val();
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_conflicto_comite";
            forma.target = "grp"
            forma.submit()
        }
    }else{
        forma.id_solicitud_pasa.value=$('#idsolicitud'+id).val();
        forma.valor_solicitud_pasa.value=$('#'+id).val();
        forma.action = "procesos-pecc.html";
        forma.accion.value = "graba_conflicto_comite";
        forma.target = "grp"
        forma.submit()
    }
}
function quita_comite2(id){
    //alert($('#idsolicitud'+id).val());
    var forma = document.principal
    if($('#comite_coment'+id).val()==""){
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: *Para eliminar la solicitud debe ingresar un motivo en el campo Comentarios', 30, 10, 15)
        //alert('Por favor Verifique el formulario\nPara eliminar la solicitud debe ingresar un motivo en el campo Comentarios');
        //forma.(comite_coment+id).className="campos_faltantes";
        $('#comite_coment'+id).addClass("campos_faltantes");
        $('#'+id).val(0);
    }else{
        var confirma=confirm('¿Está seguro(a) que desea eliminar esta solicitud del comité?')
        if (confirma) {
            forma.id_solicitud_pasa.value=$('#idsolicitud'+id).val();
            forma.comite_coment.value=$('#comite_coment'+id).val();
            forma.action = "procesos-pecc.html";
            forma.accion.value = "quita_comite";
            forma.target = "grp"
            forma.submit()
        }
    }
}
function graba_descarga_conflicto(){
	var forma = document.principal

	 			forma.action = "procesos-pecc.html";
				forma.accion.value = "graba_descarga_conflicto";
				forma.target = "grp"
				forma.submit()
	}