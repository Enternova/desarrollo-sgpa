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

    var alerta = confirm("Esta seguro de finalizar este COMITE?")
    if (alerta) {

        forma.action = "procesos-comite.html";
        forma.accion.value = "finalizar_acciones_comite"
        forma.target = "grp"
        forma.submit()
    }
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
        alert("Por favor ingrese un valor")
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

	if(campo_texto.value == ""){
		alert("Para poder grabar por favor digite una observación");
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
function crea_accion_comite_usuario(item_agrega, asistente) {
    var forma = document.principal
    forma.action = "procesos-comite.html";
    forma.accion.value = "crea_accion_aprobacion"
    forma.id_item_agrega.value = item_agrega
    forma.asistente_comote.value = asistente

    forma.target = "grp"
    forma.submit()
}
function garba_edita_comite() {
    var forma = document.principal
    if (forma.estado_comite_abre_cierra.value == 3) {
        var confrim = confirm("Se va a notificar a los asistentes via E-mail, desea continuar?")
        if (confrim) {

        } else {
            return;
        }
    }


    forma.action = "procesos-comite.html";
    forma.accion.value = "edita_comite_info_gen"
    forma.target = "grp"
    forma.submit()


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


    var alerta = confirm("Esta seguro de quitar de este comité?")
    if (alerta) {
        forma.action = "procesos-comite.html";
        forma.quita_asistente.value = id_asistente
        forma.accion.value = "quita_asistente"
        forma.target = "grp"
        forma.submit()
    }
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
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {

        var alerta = confirm("Esta seguro de Agregar este Asistente?")

        if (alerta) {
            forma.action = "procesos-comite.html";
            forma.accion.value = "agrega_asistente"
            forma.target = "grp"
            forma.submit()
        }
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


    var alerta = confirm("Esta seguro de crear este comité?")

    if (alerta) {
        forma.action = "procesos-comite.html";
        forma.accion.value = "crear_comite"
        forma.target = "grp"
        forma.submit()
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

function agregar_comite(id_comite, id_item) {
    var forma = document.principal
    var alerta = confirm("Esta seguro de agregar esta solicitud al comite?")

    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-comite.html";
        forma.id_item_agrega.value = id_item
        forma.id_comite_agrega.value = id_comite
        forma.accion.value = "agrega_comite_item"
        forma.target = "grp"
        forma.submit()
    }
}

$(".windowPopup").live('click',function(){
    $("body").css('overflow','hidden');
    $("#div_carga_busca_sol").css('overflow','scroll');
});

$(".windowPopupClose").live('click',function(){
    $("body").css('overflow','scroll');
});
