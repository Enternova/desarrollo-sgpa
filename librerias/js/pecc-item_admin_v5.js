function acciones_administrativas_modifica_cargue_manual() {
    var forma = document.principal
    var mensaje = "";


    if (forma.acci_area.value == 1 && (forma.ob_area.value == "" || forma.ob_area.value == " ")) {
        alert("Digite la observacion para cambiar el area");
        return;
    }

    var alerta = confirm("Esta Seguro de Realizar estos Cambios")
    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "cambios_administrativos_cargue_manual"
        forma.target = "grp"
        forma.submit()
    }
}



function valida_conflicto_interes(id_tipo){
	if(id_tipo == 2){
	window.document.getElementById("carga_conflicto_interes").innerHTML='<br><br><table width="100%" cellpadding="0" cellspacing="0" >	    	<tr >        	<td colspan="4" align="left">         		<table border="0" width="100%">        			        			<td width="99%" align="left" style="font-weight: 900; font-size: 14px;">	  <i><img src="../imagenes/botones/icono_ayuda.png" ></i><font face="roboto" color="#229BFF">     Declaro que he revisado la lista de conflicto de interés suministrada por Cumplimiento en la cual no se registra conflicto de ninguno de los participantes en éste proceso.    			</td>        		</table>        	</td>        </tr></table>';
	}else{
		window.document.getElementById("carga_conflicto_interes").innerHTML=".";
		
	}
}
function ajax_desde_funcion (ruta, div){
	alert(ruta)
	ajax_carga(ruta, div)
	}
/**** PARA EL DES086  ****/
function limpia_session(){
    var forma = document.principal
    forma.action = "procesos-pecc.html";
    forma.accion.value = "limpia_sesion_cierra_modal"
    forma.target = "grp"
    forma.submit()
}
function carga_menu_pecc(var1, var2 ){
    if(var2=="contenidos"){
         var forma = document.principal
         forma.var1.value=''+var1
         forma.var2.value=''+var2
        forma.action = "procesos-pecc.html";
        forma.accion.value = "limpia_sesion_pecc"
        forma.target = "grp"
        forma.submit()
    }else{
        var forma = document.principal
         forma.var1.value=''+var1
         forma.var2.value=''+var2
        forma.action = "procesos-pecc.html";
        forma.accion.value = "llena_sesion_pecc"
        forma.target = "grp"
        forma.submit()
    }
}
/**** FIN PARA EL DES086  ****/
function graba_afe_ceco_edita_adjudicacion(id_campo, afe_ceco, adjunto){
	var forma = document.principal
	 var msg = ""
	 
	if(afe_ceco==""){
		msg = "*ATENCION: Por favor Digite el AFE o CECO"
		}
	if(adjunto==""){
		msg = msg + "\n*ATENCION: Por favor Seleccione un adjunto"
		}
	
	 if (msg != "") {
       // alert("Verifique el formulario\n\n" + msg)
	   muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
//        var alerta = confirm("Esta Seguro de grabar el AFE CECO")

  //      if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_afe_ceco_adjudicacion"
			forma.id_campo_afe_ceco.value = id_campo
            forma.target = "grp"
            forma.submit()
    //    }
    }
		
	}
function graba_afe_ceco_edita(id_campo, afe_ceco, adjunto){
	var forma = document.principal
	 var msg = ""
	 
	if(afe_ceco==""){
		msg = "*ATENCION: Por favor Digite el AFE o CECO"
		}
	if(adjunto==""){
		msg = msg + "\n*ATENCION: Por favor Seleccione un adjunto"
		}
	
	 if (msg != "") {
//        alert("Verifique el formulario\n\n" + msg)
muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
//        var alerta = confirm("Esta Seguro de grabar el AFE CECO")

  //      if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_afe_ceco_edita"
			forma.id_campo_afe_ceco.value = id_campo
            forma.target = "grp"
            forma.submit()
    //    }
    }
		
	}

function graba_afe_ceco(id_campo, afe_ceco, adjunto){
	var forma = document.principal
	 var msg = ""
	 
	if(afe_ceco==""){
		msg = "*ATENCION: Por favor Digite el AFE o CECO"
		}
	if(adjunto==""){
		msg = msg + "\n*ATENCION: Por favor Seleccione un adjunto"
		}
	
	 if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta Seguro de grabar el AFE CECO")

        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_afe_ceco"
			forma.id_campo_afe_ceco.value = id_campo
            forma.target = "grp"
            forma.submit()
        }
    }
		
	}
function graba_valida_modificacion_manual(aprobacion, ob, aprobador, es_carga_pecc){
	var forma = document.principal
	
	if(ob==""){
		alert("ATENCION: Por favor ingrese la observacion")
		return;		
		}
		
	if(es_carga_pecc == 1){
		if(forma.si_observacion_comite.value == 0){
			alert("ATENCION: Seleccione si el comite realizo comentario")
		return;		
		}
		if(forma.si_observacion_comite.value == 1){
		if(valida_texto_espacios(forma.observacion_comite.value) == "NO"  || characterCount(forma.observacion_comite.value,20) != ""){
			alert("ATENCION: Digite la observacion del comite")
			return;		
			}
		}
		
		
		
		}
	
	
		
	forma.aprobacion.value = aprobacion
	forma.observacion.value = ob
	forma.aprobador.value = aprobador
	
	 var alerta = confirm("Esta seguro de Grabar?")
        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_validacion_modificacion"
            forma.target = "grp"
            forma.submit()
        }
	
	}
function finaliza_solicitud_anula_doc_contractual(){
	var forma = document.principal
	 var msg = ""
if (forma.adjunto_finaliza.value == "") {
            msg = msg + "* Debe Seleccionar un Adjunto\n"
            forma.adjunto_finaliza.className = "campos_faltantes";
        } 	else{		
            forma.adjunto_finaliza.className = "";	
        }

if (valida_texto_espacios(forma.ob_finalizar.value) == "NO"  || characterCount(forma.ob_finalizar.value,20) != "") {
        msg = msg + "* Digite la observacion .\n"
        forma.ob_finalizar.className = "textarea_faltantes";
    } else {
        forma.ob_finalizar.className = "";
    }
		
		
		
    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta seguro de Grabar este Remplazo?")

        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "finaliza_solicitud_anula_doc_contractuales"
            forma.target = "grp"
            forma.submit()
        }
    }
	}
function agrega_reemplazo(activaalerta){
	var forma = document.principal
	 var msg = ""
if (forma.usuario_permiso.value == "") {
            msg = msg + "* Seleccione el funcionario ausente o que se ausentara\n"
            forma.usuario_permiso.className = "campos_faltantes";
        } 	else{		
            forma.usuario_permiso.className = "";	
        }
if (forma.usuario_permiso2.value == "") {
            msg = msg + "* Seleccione el funcionario que lo reemplazara\n"
            forma.usuario_permiso2.className = "campos_faltantes";
        } 	else{		
            forma.usuario_permiso2.className = "";	
        }

if (forma.fecha_desde_cuando.value == "") {
            msg = msg + "* Seleccione la fecha desde cuando\n"
            forma.fecha_desde_cuando.className = "campos_faltantes";
        } 	else{		
            forma.fecha_desde_cuando.className = "";	
        }
if (forma.fecha_hasta_cuando.value == "") {
            msg = msg + "* Seleccione la fecha hasta cuando\n"
            forma.fecha_hasta_cuando.className = "campos_faltantes";
        } 	else{		
            forma.fecha_hasta_cuando.className = "";	
        }

if (valida_texto_espacios(forma.ob_reemplazo.value) == "NO"  || characterCount(forma.ob_reemplazo.value,20) != "") {
        msg = msg + "* Digite la observación del reemplazo.\n"
        forma.ob_reemplazo.className = "textarea_faltantes";
    } else {
        forma.ob_reemplazo.className = "";
    }
		
		
		
    if (msg != "") {
      
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
		
		
    } else {
		
		if(activaalerta == ""){
		window.parent.muestra_alerta_general_desde_select('agrega_reemplazo(1)', 'Advertencia','* Está Seguro de Crear este Reemplazo', 40, 5, 12)
		return;
		}
		
		
       // var alerta = confirm("Esta seguro de Grabar este Remplazo?")

       // if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_reemplazo"
            forma.target = "grp"
            forma.submit()
       // }
    }
		
	
	}
function graba_descarga_conflicto2(){
	var forma = document.principal

	 			forma.action = "procesos-pecc.html";
				forma.accion.value = "graba_descarga_conflicto2";
				forma.target = "grp"
				forma.submit()
	}
function graba_descarga_conflicto3(){
    var forma = document.principal

                forma.action = "procesos-pecc.html";
                forma.accion.value = "graba_descarga_conflicto3";
                forma.target = "grp"
                forma.submit()
    }

function graba_gestion_economico(){
	 var forma = document.principal
	 			forma.action = "../librerias/php/funcion_urna_sgpa.php";
				forma.accion.value = "graba_gestion_economico";
				forma.target = "grp"
				forma.submit()
	}
function agrega_gestion_urna_tecnico(){
	 var forma = document.principal
	 			forma.action = "../librerias/php/funcion_urna_sgpa.php";
				forma.accion.value = "graba_gestion_tecnmmico";
				forma.target = "grp"
				forma.submit()
	}
function agrega_gestion_urna_apertura(){
	 var forma = document.principal
	 			forma.action = "../librerias/php/funcion_urna_sgpa.php";
				forma.accion.value = "graba_gestion_apertura";
				forma.target = "grp"
				forma.submit()
	}
	/* FIN solo para pruebas borrar*/
function graba_justificacion_del_presupuesto(){
    var forma = document.principal
var msg = ""	
 if (valida_texto_espacios(forma.detalle_presupuesto.value) == "NO"  || characterCount(forma.detalle_presupuesto.value,20) != "") {
        msg = msg + "* Digite la Justificacion del presupuesto, recuerde que son como minimo 20 caracteres.\n"
        forma.detalle_presupuesto.className = "textarea_faltantes";
    } else {
        forma.detalle_presupuesto.className = "";
    }
	
 if (msg != "") {
//        alert("Verifique el formulario\n\n" + msg)
muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {	
				 window.parent.document.getElementById("cargando_pecc").style.display = "block"
				forma.action = "procesos-pecc.html";
				forma.accion.value = "graba_presupuesto_justificacion";
				forma.target = "grp"
				forma.submit()

	}
	
	
	}
function valida_conflico_firma(valor_conflicto, campo_firma){

//if(valor_conflicto == 1){campo_firma.value = 2} else  {campo_firma.value = 1}
	
	}
function expande_reporte(consecutivo, cuantas_solicitudes) {

    document.getElementById("fila_1-" + consecutivo).style.display = "";
    document.getElementById("fila_2-" + consecutivo).style.display = "";
    document.getElementById("fila_3-" + consecutivo).style.display = "";
    document.getElementById("fila_4-" + consecutivo).style.display = "";
    document.getElementById("fila_5-" + consecutivo).style.display = "";
    document.getElementById("fila_6-" + consecutivo).style.display = "";
    document.getElementById("fila_7-" + consecutivo).style.display = "";
    document.getElementById("fila_8-" + consecutivo).style.display = "";
    document.getElementById("fila_9-" + consecutivo).style.display = "";


    for (var i = 1; i <= cuantas_solicitudes; i++) {

        if (i != consecutivo) {
            document.getElementById("fila_1-" + i).style.display = "none";
            document.getElementById("fila_2-" + i).style.display = "none";
            document.getElementById("fila_3-" + i).style.display = "none";
            document.getElementById("fila_4-" + i).style.display = "none";
            document.getElementById("fila_5-" + i).style.display = "none";
            document.getElementById("fila_6-" + i).style.display = "none";
            document.getElementById("fila_7-" + i).style.display = "none";
            document.getElementById("fila_8-" + i).style.display = "none";
            document.getElementById("fila_9-" + i).style.display = "none";

        }

    }

}

function edita_area_proyecto() {
    var forma = document.principal

    if (forma.nombre.value == "") {
        alert("digite el nombre")
        return;
    }
    var msn = confirm("Esta Seguro Editar esta area/proyecto?")
    if (msn) {

        forma.action = "procesos-pecc.html";
        forma.accion.value = "maestra_edita_area_proyecto";
        forma.target = "grp"
        forma.submit()
    }



}


function graba_area_proyecto() {
    var forma = document.principal

    if (forma.nombre.value == "") {
        alert("digite el nombre")
        return;
    }
    var msn = confirm("Esta Seguro grabar esta area/proyecto?")
    if (msn) {

        forma.action = "procesos-pecc.html";
        forma.accion.value = "maestra_crea_area_proyecto";
        forma.target = "grp"
        forma.submit()
    }



}

function subir_archivo_cargue_ot_correos() {
    var forma = document.principal

    if (forma.sele_arch.value == "") {
        alert("Seleccione el Archivo a Cargar")
        return;
    }
    var msn = confirm("Esta seguro de subir este archivo?")
    if (msn) {

        forma.action = "procesos-pecc.html";
        forma.accion_correo_ot.value = "subir_archivo_correos_ot";
        forma.target = "grp"
        forma.submit()
    }


}
function poner_solicitud_en_estado(estado_queda) {
    var forma = document.principal
    var msn = confirm("Esta seguro de cambiar el estado de esta solicitud, esta accion es irreversible\n ELIMINA LOS DOCUMENTOS CONTRACTUALES CREADOS EN EL MODULO DE CONTRATOS?")
    if (msn) {
        forma.nuevo_estdo_edita.value = estado_queda

        forma.action = "procesos-pecc.html";
        forma.accion.value = "cammbio_de_estado_por_admin";
        forma.target = "grp"
        forma.submit()
    }

}
function carga_datos_solicitud_pecc_modifica(id_item) {
    var forma = document.principal
    forma.pecc_id_sol_modifica.value = id_item
    forma.action = "procesos-pecc.html";
    forma.accion.value = "carga_info_pecc_id_sol_modifica";
    forma.target = "grp"
    forma.submit()

}
function carga_datos_solicitud_informativo(id_item) {
    var forma = document.principal


    document.getElementById("contra_otro_si").innerHTML = '<input name="contratos_normales" type="hidden" id="contratos_normales" size="25"    />'

    forma.solicitud_que_carga.value = id_item
    forma.action = "procesos-pecc.html";
    forma.accion.value = "carga_informacion_sol_informativo";
    forma.target = "grp"
    forma.submit()

}
function envio_correo_ot_admin() {
    var forma = document.principal

    var msn = confirm("Esta seguro de Enviar los correos a los usuarios de SGPA y a los Contratistas")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "envio_correo_desde_admin";
        forma.target = "grp"
        forma.submit()
    }
}
function agrega_quita_correo_ot(tipo, correo_id_relacion) {
    var forma = document.principal
    window.parent.document.getElementById("cargando_pecc").style.display = "block"
    forma.tipo_agrega_quita_correo_ot.value = tipo;
    forma.id_correo_relacion.value = correo_id_relacion;

    forma.action = "procesos-pecc.html";
    forma.accion.value = "agrega_quita_correo_ot";
    forma.target = "grp"
    forma.submit()
}

function finaliza_ampliacion() {
    var forma = document.principal

    var msn = confirm("Esta seguro de finalizar la ampliacion")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "finli_amplicion";
        forma.target = "grp"
        forma.submit()
    }


}



function crear_otro_si_de_ot() {
    var forma = document.principal

    var msn = confirm("Esta seguro de crear un otro si para esta solicitud y finalizar la ampliacion")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "crea_otro_si_de_ot";
        forma.target = "grp"
        forma.submit()
    }


}

function ValidaMail(mail) {
    var er = /^[0-9a-z_\-\.]+@([a-z0-9\-]+\.?)*[a-z0-9]+\.([a-z]{2,4}|travel)$/i;
    return er.test(mail);
}


function graba_correo() {
    var forma = document.principal



    if (forma.correo_agrega.value == "" || forma.correo_agrega.value == " " || forma.correo_agrega.value == "  ") {
        alert("Por favor digite el correo que desea agregar")
        return;
        forma.correo_agrega.className = "campos_faltantes";
    } else {
        forma.correo_agrega.className = "";
    }


    if (!ValidaMail(forma.correo_agrega.value)) {
        forma.correo_agrega.className = "campos_faltantes";
        alert("La dirección de EMail es incorrecta !!");
        return;
    }


    var msn = confirm("Esta seguro de agregar este correo a la lista de correos de este proveedor")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "agrega_correo_ot"

        forma.target = "grp"
        forma.submit()
    }


}

function graba_revision_sap(id_item) {
    var forma = document.principal

    forma.id_item_graba_revision.value = id_item



    var msn = confirm("Esta seguro de grabar la revision SAP")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "graba_revision_sap"

        forma.target = "grp"
        forma.submit()
    }


}
function agrega_solicitud_a_ot(id_solcitud_relacionada) {
    var forma = document.principal
    var msn = confirm("Esta Seguro de Agregar esta Solicitud de Contratos Marco a la Solcitud en proceso?\n\n!Los Valores Seleccionados se Eliminaran¡")
    if (msn) {
        forma.id_item_pecc_marco.value = id_solcitud_relacionada
        forma.action = "procesos-pecc.html";
        forma.accion.value = "cambia_solcitud_relacionada"
        forma.target = "grp"
        forma.submit()
    }

}

function quita_solicitud_de_la_relacion() {
    var forma = document.principal
    var msn = confirm("Esta Seguro de Desvincular esta Solicitud de Contratos Marco de la Solcitud en proceso?\n\n!Los Valores Seleccionados se Eliminaran¡")
    if (msn) {
        forma.action = "procesos-pecc.html";
        forma.accion.value = "quitar_solcitud_relacionada"
        forma.target = "grp"
        forma.submit()
    }

}



function cambia_profecional_de_usuario(id_usuario, id_profesional) {
    var forma = document.principal
    forma.id_prof.value = id_profesional
    forma.id_usua.value = id_usuario
    forma.action = "procesos-pecc.html";
    forma.accion.value = "cambia_profesional_asignado_a_usua"
    forma.target = "grp"
    forma.submit()

}
function valida_tipo_doc(id_item_pecc, tipo) {
    var forma = document.principal
    //alert(tipo)
	//alert(forma.desde_comite.value)
	if(forma.desde_comite.value == "SI"){
		if (tipo == 2) {//marco
			ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=2'+ '&tipo_seleccion='+tipo+'&desde_comite=SI', 'carga_edicion_valores_'+id_item_pecc)
		}
		if (tipo == 4) {
			ajax_carga('../aplicaciones/pecc/adjudicacion-desierto.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=4'+ '&tipo_seleccion='+tipo+'&desde_comite=SI', 'carga_edicion_valores_'+id_item_pecc)
		}

		if (tipo != 2 && tipo != 4) {
			ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=1'+ '&tipo_seleccion='+tipo+'&desde_comite=SI', 'carga_edicion_valores_'+id_item_pecc)
		}
	}else{
		if (tipo == 2) {//marco
        ajax_carga('../aplicaciones/pecc/adjudicacion-marco.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=2'+ '&tipo_seleccion='+tipo, 'contenidos')
		}
		if (tipo == 4) {
			ajax_carga('../aplicaciones/pecc/adjudicacion-desierto.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=4'+ '&tipo_seleccion='+tipo, 'contenidos')
		}

		if (tipo != 2 && tipo != 4) {
			ajax_carga('../aplicaciones/pecc/adjudicacion.php?id_item_pecc=' + id_item_pecc + '&id_tipo_proceso_pecc=' + forma.id_tipo_proceso_pecc.value + '&tipo_documento=1'+ '&tipo_seleccion='+tipo, 'contenidos')
		}
		
	}


}

//sin numero de incidente pecc inicio
function grabar_informacion_adjudicacion() {
    var forma = document.principal
    var msg = ""


/*sondeos adjudicacion*/
if ((forma.tipo_proceso.value == 6)) {
				
	if (forma.cat_nego_requiere_sondeo.value == 1 || forma.cat_nego_requiere_sondeo.value == 0) {
		if(forma.cat_nego_requiere_sondeo.value == 0){
			 msg = msg + "* ATENCION: Seleccione la justificación de la adjudicación directa\n"
             forma.cat_nego_requiere_sondeo.className = "select_faltantes";
			}else{
				forma.cat_nego_requiere_sondeo.className = "";
				}
			
/*		if((forma.llena_lista_sondeos_l.value == "" || forma.llena_lista_sondeos_l.value == "0") && forma.cat_nego_requiere_sondeo.value == 1){
			 msg = msg + "* ATENCION: Seleccione el sondeo de mercado de la urna virtual\n"
             forma.llena_lista_sondeos_l.className = "campos_faltantes";
			}else{
				forma.llena_lista_sondeos_l.className = "";
				}
*/
			

	}
				
	
	}
	
	/*sondeos adjudicacion*/

			if (valida_texto_espacios(forma.antecedentes_texto.value) == "NO"  || characterCount(forma.antecedentes_texto.value,20) != "") {
            msg = msg + "*  Digite los Antecedentes del proceso\n"
            forma.antecedentes_texto.className = "textarea_faltantes";
			} else {
				forma.antecedentes_texto.className = "";
			}
			
				if (forma.antecedente_anexo.value=="" && forma.origen_pecc.value <= 1) {
						if (forma.con_anexo_antecedente.value==" " || forma.con_anexo_antecedente.value=="") {
							msg = msg + "*  Seleccione un Anexo para el antecedente\n"
							}
						
						}
					
		
		
					if (forma.req_contra_mano_obra_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de mano de obra local\n"
						forma.req_contra_mano_obra_local.className = "select_faltantes";
					}else{		
						forma.req_contra_mano_obra_local.className = "";	
					} 
					if (forma.req_cont_bien_ser_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de bienes o servicios local\n"
						forma.req_cont_bien_ser_local.className = "select_faltantes";
					}else{		
						forma.req_cont_bien_ser_local.className = "";	
					} 


if (forma.origen_pecc.value == "") {
            msg = msg + "* Seleccione el origen de la solicitud\n"
            forma.origen_pecc.className = "select_faltantes";

        } 	else{		
            forma.origen_pecc.className = "";	
        }
		
		if(forma.linea_pecc=== undefined){
			
		}else{
		if(forma.origen_pecc.value > 1 && forma.origen_pecc.value != ""){//si tiene un PECC realacionado
			
			
			if(forma.linea_pecc.value == 0 && forma.pecc_modificado.value ==0){
				msg = msg + "* Por favor seleccione la linea del PECC y si requiere modificacion"
				
				}
				
			
			
			/*if(forma.linea_pecc.value == 0){
				msg = msg + "* Por favor digite la linea del PECC"
				
				}*/
			if(forma.pecc_modificado.value ==1){//si selecciono que el PECC fue modificado
					if(valida_texto_espacios(forma.pecc_observacion_modificacion.value) == "NO"  || characterCount(forma.pecc_observacion_modificacion.value,20) != ""){
						msg = msg + "* Por favor digite la justificacion de la modificacion, esta debe tener como minimo 20 caracteres"
						//return;
						}
					}	
		}
		}
	if(forma.reajuste.value==0){
        msg = msg + "* Seleccione si la solicitud tiene reajustes\n"
        forma.reajuste.className = "select_faltantes";
    }
    if(forma.reembolsable.value==0){
        msg = msg + "* Seleccione si la solicitud tiene reembolsables\n"
        forma.reembolsable.className = "select_faltantes";
    }
    if(forma.como_valida.value==1 && forma.reembolsable.value==forma.como_valida.value){
        if(forma.como_reembolsable.value==0){
            msg = msg + "* Seleccione cómo aplica el reembolsable\n"
            forma.como_reembolsable.className = "select_faltantes";
        }
    }
    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
        //var alerta = confirm("Esta seguro de Grabar esta Información de Adjudicación?")

        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_info_adjudica"
            forma.target = "grp"
            forma.submit()
        //}
    }

}//sin numero de incidente pecc fin
/** INICIO PARA EL DES011-18 **/
function muestra_reajuste_adj(){
	var forma = document.principal
	if(forma.reajuste.value==1){
		window.parent.document.getElementById("observacion_reajuste1").style.display = ""
		window.parent.document.getElementById("observacion_reajuste2").style.display = ""
	}else{
		window.parent.document.getElementById("observacion_reajuste1").style.display = "none"
		window.parent.document.getElementById("observacion_reajuste2").style.display = "none"
	}
	//console.log(forma.reajuste.value)
	//alert(forma.reajuste.value)
}
function muestra_reembolsable_adj(){
	var forma = document.principal
	if(forma.reembolsable.value==1){
		window.parent.document.getElementById("observacion_reembolsable1").style.display = ""
		window.parent.document.getElementById("observacion_reembolsable2").style.display = ""
	}else{
		window.parent.document.getElementById("observacion_reembolsable1").style.display = "none"
		window.parent.document.getElementById("observacion_reembolsable2").style.display = "none"
	}
	//console.log(forma.reembolsable.value)
	//alert(forma.reembolsable.value)
}
function guarda_coment_reajuste(){
	var forma = document.principal
	var cadena=forma.observacion_reajuste.value
	forma.action = "procesos-pecc.html";
	forma.accion.value = "graba_coment_reajuste"
	forma.target = "grp"
	forma.submit()
}
function guarda_coment_reembolsable(){
	var forma = document.principal
	var cadena=forma.observacion_reembolsable.value
	forma.action = "procesos-pecc.html";
	forma.accion.value = "graba_coment_reembolsable"
	forma.target = "grp"
	forma.submit()
}
function elimina_coment_reajuste_reembolsable(dato, tipo, activaalerta){
	if(activaalerta == ""){
		if(tipo==1){
			window.parent.muestra_alerta_general_desde_select('elimina_coment_reajuste_reembolsable(-comillas-'+dato+'-comillas-, -comillas-'+tipo+'-comillas-,1)', 'Advertencia','* Esta Seguro de Eliminar el Comentario de Reajustes.', 40, 5, 12)
			return;
		}else if(tipo==2){
			window.parent.muestra_alerta_general_desde_select('elimina_coment_reajuste_reembolsable(-comillas-'+dato+'-comillas-, -comillas-'+tipo+'-comillas-,1)', 'Advertencia','* Esta Seguro de Eliminar el Comentario de Reembolsable.', 40, 5, 12)
			return;
		}
			
	}else{
		var forma = document.principal
		var cadena=forma.observacion_reajuste.value
		forma.action = "procesos-pecc.html";
		forma.reembolsable_reajuste_pasa.value=dato
		forma.accion.value = "elimina_reajuste_reembolsable"
		forma.target = "grp"
		forma.submit()
	}
}
<<<<<<< HEAD
/** FIN PARA EL DES011-18 **/ 
=======
/** FIN PARA EL DES011-18 **/
>>>>>>> jeison
function imprimir_solictud(id_item) {
    var forma = document.principal
    forma.action = "../aplicaciones/pecc/imprimir.php";
    forma.target = "grp"
    forma.submit()
}
function carga_tiempos_no_estandar(valor, id_item) {
    if (valor == 1) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=13&id_item_pecc=" + id_item, "carga_tiempos")
    } else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_tiempos")
    }
}


function acciones_administrativas_solo_congela() {
    var forma = document.principal
    var mensaje = "";


    if (forma.acci5.value == 1 && (forma.ob5.value == "" || forma.ob5.value == " ")) {
        alert("Para congelar un proceso debe digitar una observacion");
        return;
    }

    var alerta = confirm("Esta Seguro de Realizar estos Cambios")
    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "cambios_administrativos_solo_congelar"
        forma.target = "grp"
        forma.submit()
    }
}

function acciones_administrativas_profesionales() {


    var forma = document.principal
    var mensaje = "";

    if (forma.usuario_permiso.value == "") {
        mensaje = "* Debe Seleccionar el Gerente del Contrato";
       // return;
    }
    if (forma.acci5.value == 1 && (forma.ob5.value == "" || forma.ob5.value == " ")) {
        mensaje = "* Para congelar un proceso debe digitar una observación";
        //return;
    }
	

	if ((forma.acci5.value == 2)) {
	if(forma.estado_congelado_inicial.value == 1){
				if((forma.ob5.value == "" || forma.ob5.value == " ")){
        mensaje = "* Para Descongelar un proceso debe digitar una observación.";
		}

		if(forma.aplica_fecha_cierre_urna.value == "SI"){
			if(forma.fecha_i.value == ""){
				mensaje = mensaje+"* Por favor seleccione la nueva fecha del cierre del proceso.";
				}
		}
	}
    }

	if(mensaje != ""){
		
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+mensaje, 40, 5, 12)
	}else{
		
    //var alerta = confirm("Esta Seguro de Realizar estos Cambios")
    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "cambios_administrativos_profecionales"
        forma.target = "grp"
        forma.submit()
    //}
	}



}


function acciones_administrativas() {
    var forma = document.principal
    var mensaje = "";


    if (forma.acci6.value == 1) {
        //mensaje = " * Va a Eliminar este proceso de los Historicos";
        if (forma.adjunto_para_eliminar.value == "") {
            mensaje = "Debe Seleccionar un archivo adjunto para poder eliminar este proceso";
           
        }
        if (forma.ob6.value == "" || forma.ob6.value == " ") {
            mensaje = "Para Eliminar un proceso debe digitar una observacion";
            
        }

    }

    if (forma.acci8.value == 1) {
      //  mensaje = "\n * Va a Eliminar una Urna";
        if (forma.adjunto_para_eliminar_urna.value == "") {
           mensaje = "Debe Seleccionar un archivo adjunto para poder eliminar";
            
        }
        if (forma.ob8.value == "" || forma.ob6.value == " ") {
            mensaje = "Para Eliminar una urna debe digitar una observacion";
            
        }

    }


    if (forma.usuario_permiso.value == "") {
        mensaje = "Debe Seleccionar el Gerente del Contrato";
        
    }
    /*if (forma.acci5.value == 1 && (forma.ob5.value == "" || forma.ob5.value == " ")) {
        alert("Para congelar un proceso debe digitar una observacion");
        return;
    }*/


	if(mensaje != ""){
		
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+mensaje, 40, 5, 12)
	}else{
		
  
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "cambios_administrativos"
        forma.target = "grp"
        forma.submit()
    }
}
function carga_otros_proveedores(tipo_provee) {

    var tipo_pro = tipo_provee
    if (tipo_pro == 99) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=11", "carga_otro_proveedor")
    } else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_otro_proveedor")
    }

}

/***** para el des083 se personaliza la busqueda de proveedores  *****/
function carga_otros_proveedores_adjudicacion(tipo_provee) {

    var tipo_pro = tipo_provee
    if (tipo_pro == 99) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=99", "carga_otro_proveedor")
    } else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_otro_proveedor")
    }

}
/***** fin para el des083 se personaliza la busqueda de proveedores  *****/

function pone_datos_contrato_edicion(id_contra) {
    var confir = confirm("Se perderan los datos que ha ingresado, quiere continuar?");
    if (confir) {
        var id_cot = id_contra.split("----")
        id_cot = id_cot[1]

        var forma = document.principal


        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.id_contrato_otro_si.value = id_contra;
        forma.accion.value = "pone_datos_contrato_otro_si_edicion"
        forma.target = "grp"
        forma.submit()
    }

}

function pone_datos_contrato(id_contra) {

    var id_cot = id_contra.split("----")
    id_cot = id_cot[1]

    ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=12&id_contrato_carr=" + id_cot, "carga_datos_contrato")
    ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=14&id_contrato_carr=" + id_cot, "carga_antecedentes_otro_si")
    var forma = document.principal

    ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
    forma.solicitud_que_carga.value = ""

    window.parent.document.getElementById("cargando_pecc").style.display = "block"
    forma.action = "procesos-pecc.html";
    forma.id_contrato_otro_si.value = id_contra;
    forma.accion.value = "pone_datos_contrato_otro_si"
    forma.target = "grp"
    forma.submit()

}
//sin numero de incidente pecc inicio
function carga_detalle_subcategoria(linea, id_item,pecc1){

	
	window.parent.document.getElementById("id_fila_deallesubcategoria").style.display = ""
	ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=15&id_item_pecc="+id_item+"&linea="+linea+"&pecc1="+pecc1, "carga_detalle_subcategoria")
	
	}
function activa_linea_pecc(pecc,id_item,selec_item,edicion_datos_generales){
	

	
	if(pecc > 1){
		
	ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=400&id_item_pecc="+id_item+"&selec_item="+selec_item+"&pecc="+pecc+"&edicion_datos_generales="+edicion_datos_generales, "carga_liena_pecc")
	window.parent.document.getElementById("carga_liena_pecc3").style.display = "none"
	window.parent.document.getElementById("carga_modificacion_pecc3").style.display = "none"
	
	
	window.parent.document.getElementById("carga_liena_pecc").style.display = ""
	window.parent.document.getElementById("carga_modificacion_pecc").style.display = ""
	
	
	
	
	}
	if(pecc == 1 || pecc == 0){
		
		window.parent.document.getElementById("carga_liena_pecc3").style.display = "none"
		window.parent.document.getElementById("carga_modificacion_pecc3").style.display = "none"
		
		window.parent.document.getElementById("carga_liena_pecc").style.display = "none"
		window.parent.document.getElementById("carga_modificacion_pecc").style.display = "none"
		
		window.parent.document.getElementById("carga_observacion_modifica_pecc").style.display = "none"
		window.parent.document.getElementById("id_fila_deallesubcategoria").style.display = "none"
		
	}
	
	}
	
//sin numero de incidente pecc fin

function activa_filas_modifiaciones_xx(modifica){
		if(modifica == 1){
		//	window.parent.document.getElementById("carga_num_modifica").style.display = ""
			window.parent.document.getElementById("textoxx").style.display = ""
			}else{
			//	window.parent.document.getElementById("carga_num_modifica").style.display = "none"
			window.parent.document.getElementById("textoxx").style.display = "none"
				}
	}


function activa_filas_modifiaciones(modifica){
		if(modifica == 1){
		//	window.parent.document.getElementById("carga_num_modifica").style.display = ""
			window.parent.document.getElementById("carga_observacion_modifica_pecc").style.display = ""
			}else{
			//	window.parent.document.getElementById("carga_num_modifica").style.display = "none"
			window.parent.document.getElementById("carga_observacion_modifica_pecc").style.display = "none"
				}
	}

function alimina_solicitud_modifica_pecc(){

	 window.parent.document.getElementById("busca_sol_modificacion_pecc").innerHTML = '<strong class="windowPopup" style="cursor:pointer" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/pecc/busca-solicitudes_modifica_pecc.php","div_carga_busca_sol")>Buscar solicitud  <img src="../imagenes/botones/aler-interro.gif" width="3"/></strong>';
	
	}

function valida_tipo_proceso(tipo_proceso) {
	
    var tipo_pro = tipo_proceso
    document.getElementById("solicitud_que_carga").value = ""
	
    if (tipo_pro == 1 || tipo_pro == 2 || tipo_pro == 6) {
        document.getElementById("us_par_tecnico").style.display = ""
		document.getElementById("us_geren_contrato").style.display = ""
    }else {
		document.getElementById("us_par_tecnico").style.display = "none"
		document.getElementById("us_geren_contrato").style.display = "none"
		}
		document.getElementById("mustra_objeto_solicitud").style.display = ""
		document.getElementById("muetra_objeto_contrato").style.display = ""
		document.getElementById("muestra_alcance").style.display = ""
		document.getElementById("muestra_proveedores_sugeridos").style.display = ""
		document.getElementById("muestra_justificacion_tecnica").style.display = ""
		document.getElementById("muestra_criterios_evaluacion").style.display = ""
		document.getElementById("muestra_recomendacion").style.display = ""
		document.getElementById("muestra_oportunidad").style.display = ""
		document.getElementById("muestra_calidad").style.display = ""
		document.getElementById("muestra_anexos").style.display = ""
		

		
	
	if(tipo_pro == 4 || tipo_pro == 5) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=10", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=convierte_marco", "contra_otro_si_convierte_marco")
    } else if (tipo_pro == 12) {
		ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
	}else if (tipo_pro == 16) {
		ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=solo_proveedores", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
	}else if (tipo_pro == 15) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=sol_modificaciones", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
		document.getElementById("mustra_objeto_solicitud").style.display = "none"
		document.getElementById("muetra_objeto_contrato").style.display = "none"
		document.getElementById("muestra_alcance").style.display = "none"
		document.getElementById("muestra_proveedores_sugeridos").style.display = "none"
		document.getElementById("muestra_justificacion_tecnica").style.display = "none"
		document.getElementById("muestra_criterios_evaluacion").style.display = "none"
		document.getElementById("muestra_recomendacion").style.display = "none"
		document.getElementById("muestra_oportunidad").style.display = ""
		document.getElementById("muestra_calidad").style.display = ""
		document.getElementById("muestra_anexos").style.display = "none"
		
    }else if (tipo_pro == 11) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=sol_informativo", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
    } else if (tipo_pro == 10) {
		        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
//    		    ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=sol_informativo", "informativo_solicitud")
	        	ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
		}else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
		
    }
	
	if(tipo_pro== 1 || tipo_pro== 2 || tipo_pro== 3 || tipo_pro== 5 || tipo_pro== 7 || tipo_pro== 15 || tipo_pro== 6){
		document.getElementById("carga_objetivos_proceso").style.display = ""
		}else{
			document.getElementById("carga_objetivos_proceso").style.display = "none"
			}
	

    if (tipo_pro == 6 || tipo_pro == 15 || tipo_pro == 12) {
        document.getElementById("tabla_presupuestos_boton").style.display = "none"
		if(tipo_pro == 15  || tipo_pro == 12){
			document.getElementById("boton_poner_firme").style.display = "none"
		
		}

    } else {
        document.getElementById("tabla_presupuestos_boton").style.display = ""

    }
	if (tipo_pro == 6) {
			ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=carga_gerentes", "carga_gerente_contrato")
        
    }
}


function valida_tipo_proceso_edicion(tipo_proceso) {
    var tipo_pro = tipo_proceso.value
    if (tipo_pro == 4 || tipo_pro == 5) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=carga_contrato_edicion", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=convierte_marco_edita", "contra_otro_si_convierte_marco")
    } else if (tipo_pro == 12) {
		ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
	}else if (tipo_pro == 11  || tipo_pro == 15) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=sol_informativo", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
    } else if (tipo_pro == 10) {
		        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=todos_los_contratos", "contra_otro_si")
    		    ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=sol_informativo", "informativo_solicitud")
	        	ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
		} else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "informativo_solicitud")
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "contra_otro_si_convierte_marco")
    }

	


    if (tipo_pro == 6) {
        document.getElementById("tabla_presupuestos_boton").style.display = "none"

    } else {
        document.getElementById("tabla_presupuestos_boton").style.display = ""

    }
    document.getElementById("conflito_intere_sel").value = "0"
}


function cambia_titulo_valores(valor) {
    if (valor == 1) {
        document.getElementById("titulo_valores").innerHTML = 'Distribución del Valor a Solicitar'
        document.getElementById("carga_presupuesto_dispo").style.display = ""
    } else {
        document.getElementById("titulo_valores").innerHTML = 'Valor de la Solicitud <img src="../imagenes/botones/help.gif" alt="Ingresar el monto estimado por año y área, requerido para la solicitud." title="Ingresar el monto estimado por año y área, requerido para la solicitud." width="20" height="20" />'
        document.getElementById("carga_presupuesto_dispo").style.display = "none"
    }
}




function valida_fecha_ideal(fecha) {

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
        alert("La fecha no puede ser anterior a hoy")
        fecha.value = "";
        return;
    }



    //VALIDA FESTIVOS COLOMBIANOS
    if (mes_fecha == 01 && dia_fecha == 01) {
        valido = "NO";
    }
    if (mes_fecha == 05 && dia_fecha == 01) {
        valido = "NO";
    }
    if (mes_fecha == 07 && dia_fecha == 20) {
        valido = "NO";
    }
    if (mes_fecha == 08 && dia_fecha == 07) {
        valido = "NO";
    }
    if (mes_fecha == 12 && dia_fecha == 08) {
        valido = "NO";
    }
    if (mes_fecha == 12 && dia_fecha == 25) {
        valido = "NO";
    }
    //FIN VALIDA FESTIVOS
    if (dia == 0 || dia == 6) {
        valido = "NO";
    }
    if (valido == "NO") {
        fecha.value = "";
        alert("Sabados, Domingos y festivos no Aplican")
    }


}

function aprueba_firma_adjudica(id_rol, tipo_firma, conflicto_interes, observacion, alerta_vencimiento,activaalerta) {
    var forma = document.principal
    var var_tex=""
	//var_tex = "Esta seguro de declarar que no tiene conflicto de intereses y firmar esta solicitud?"
    
	if(alerta_vencimiento != "" && tipo_firma == 1){
		var_tex = "* " + alerta_vencimiento
		//return;
		}
	
	if(conflicto_interes==0){
		var_tex = "* Por favor seleccione si tiene o no conflicto de intereses";
		//return;
	}
	
	if (tipo_firma != 1 && observacion =="") {
       var_tex = "* Si no se va a firmar la solicitud es necesario que digite la observación";
		//return;
    }
	
	if (tipo_firma == 2) {
       // var_tex = "* ESTA SEGURO DE DEVOLVER ESTA SOLICITUD"
    }
	
	if (tipo_firma == 3) {
       // var_tex = "* ESTA SEGURO DE RECHAZAR ESTA SOLICITUD, no se podra volver a utilizar y quedara en estado 'Finalizado - Rechazado'"
    } 
		
	if(tipo_firma==1 && conflicto_interes==1){
		var_tex = "* No puede firmar si tiene conflicto de intereses, lo que debe hacer es devolver el punto y describir el conflicto en la observación";
		//return;
	}
	
	if(var_tex != ""){
		
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+var_tex, 40, 5, 12)
	}else{
	
	if(activaalerta == ""){
		if(tipo_firma == 1){//es para aprobar
			//agregacion de tildes en la alerta relacion inc035-18 inicio
			window.parent.muestra_alerta_general_desde_select('aprueba_firma_adjudica(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-, -comillas-'+alerta_vencimiento+'-comillas-,1)', 'Advertencia','*¿Está Seguro de Firmar esta Solicitud?', 40, 5, 12)
			return;
		}
		if(tipo_firma == 2){//es para devolver
			window.parent.muestra_alerta_general_desde_select('aprueba_firma_adjudica(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-, -comillas-'+alerta_vencimiento+'-comillas-,1)', 'Advertencia','* ¿Está Seguro de Devolver al Profesional de Abastecimiento / Comprador?', 40, 5, 12)
			return;
		}
		if(tipo_firma == 3){//es para rechazar
			window.parent.muestra_alerta_general_desde_select('aprueba_firma_adjudica(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-, -comillas-'+alerta_vencimiento+'-comillas-,1)', 'Advertencia','* ¿Está Seguro de Rechazar la Solicitud?', 40, 5, 12)
			return;
		}
		}
		//agregacion de tildes en la alerta relacion inc035-18 fin
    //var alerta = confirm(var_tex)

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.id_rol_aprueba.value = id_rol
        forma.accion.value = "firma_sistema_suaurio_adjudica"
        forma.target = "grp"
        forma.submit()
		//}
    }


}
function aprueba_firma(id_rol, tipo_firma, conflicto_interes, observacion,activaalerta) {
    var forma = document.principal
    var var_tex=""
	//var_tex = "Esta seguro de declarar que no tiene conflicto de intereses y firmar esta solicitud?"
    
	
	
	if(conflicto_interes==0){
		var_tex = "* Por favor seleccione si tiene o no conflicto de intereses";
		//return;
	}
	
	if (tipo_firma != 1 && observacion =="") {
       var_tex = "* Si no se va a firmar la solicitud es necesario que digite la observación";
		//return;
    }
	
	if (tipo_firma == 2) {
       // var_tex = "* ESTA SEGURO DE DEVOLVER ESTA SOLICITUD"
    }
	
	if (tipo_firma == 3) {
       // var_tex = "* ESTA SEGURO DE RECHAZAR ESTA SOLICITUD, no se podra volver a utilizar y quedara en estado 'Finalizado - Rechazado'"
    } 
		
	if(tipo_firma==1 && conflicto_interes==1){
		var_tex = "* No puede firmar si tiene conflicto de intereses, lo que debe hacer es devolver el punto y describir el conflicto en la observación";
		//return;
	}
	
	if(var_tex != ""){
		
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+var_tex, 40, 5, 12)
	}else{
	
	if(activaalerta == ""){
		if(tipo_firma == 1){//es para aprobar
			window.parent.muestra_alerta_general_desde_select('aprueba_firma(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-,1)', 'Advertencia','* Esta Seguro de Firmar esta Solicitud', 40, 5, 12)
			return;
		}
		if(tipo_firma == 2){//es para devolver
			window.parent.muestra_alerta_general_desde_select('aprueba_firma(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-,1)', 'Advertencia','* Esta Seguro de Devolver al Profesional de Abastecimiento / Comprador', 40, 5, 12)
			return;
		}
		if(tipo_firma == 3){//es para rechazar
			window.parent.muestra_alerta_general_desde_select('aprueba_firma(-comillas-'+id_rol+'-comillas-, -comillas-'+tipo_firma+'-comillas-, -comillas-'+conflicto_interes+'-comillas-, -comillas-'+observacion+'-comillas-,1)', 'Advertencia','* Está Seguro de Rechazar la Solicitud', 40, 5, 12)
			return;
		}
		}
    //var alerta = confirm(var_tex)

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.id_rol_aprueba.value = id_rol
        forma.accion.value = "firma_sistema_suaurio"
        forma.target = "grp"
        forma.submit()
		//}
    }


}

function siguiente_nivel_servicio(mensaje) {
    var forma = document.principal


  //  var alerta = confirm(mensaje)

    //if (alerta) {

        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "siguiente_nivel"
        forma.target = "grp"
        forma.submit()
    //}

}



function siguiente_nivel_agl(mensaje, id_secuencia, alerta_vencimiento) {
    var forma = document.principal
    var msg = ""
if(alerta_vencimiento && alerta_vencimiento != ""){
		    var msg = "* " + alerta_vencimiento
		}
		
/*CONFLICTO DE intereses*/
if(mensaje == "Esta Seguro de firmar y declarar que no tiene conflicto de intereses * Declaro que he revisado la lista de conflicto de interés suministrada por Cumplimiento en la cual no se registra conflicto de ninguno de los participantes en éste proceso.?" || mensaje =="Esta Seguro de firmar y declarar que no tiene conflicto de intereses?"){
if (forma.conflito_intere_sel.value == "0") {
                var msg = "* Seleccione si tiene conflicto de intereses\n"
            forma.conflito_intere_sel.className = "select_faltantes";
        } else if(forma.conflito_intere_sel.value == "1"){
			var msg = "* Si tiene conflicto de intereses no puede poner en firme la solicitud\n"
            forma.conflito_intere_sel.className = "select_faltantes";
			}
		else{		
            forma.conflito_intere_sel.className = "";	
        }
		
}
/*FIN CONFLICTO DE intereses*/

if(msg != ""){
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)	
	return
	}
   // var alerta = confirm(mensaje)

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "siguiente_nivel"
        forma.id_secuencia.value = id_secuencia
        forma.target = "grp"
        forma.submit()
    //}


}

function devolver_item_sondeo() {
    var forma = document.principal

    var alerta = confirm("Esta seguro de Devolverle esta Solicitud al Nivel Anterior?")
    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "nivel_anterior_sondeo"
        forma.target = "grp"
        forma.submit()
    }
}
function devolver_item_negociacion() {
    var forma = document.principal

    var alerta = confirm("Esta seguro de Devolverle esta Solicitud al Nivel Anterior?")
    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "nivel_anterior_negociacion"
        forma.target = "grp"
        forma.submit()
    }
}

function devolver_item_a_profesional_desde_admin() {
    var forma = document.principal


    var alerta = confirm("Esta seguro de Devolverle esta Solicitud al Profesional Encargado, ! RECUERDE QUE SE BORRARAN LAS FIRMAS¡?")

    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "devolver_profesional_desde_administrador"
        forma.target = "grp"
        forma.submit()
    }
}

function devolver_item_a_gerente_contrato(tipo) {
    var forma = document.principal
var msg=""
    if (forma.observa_atras.value == "") {
        msg="* Por favor digite una observacion"
    }
	
	if(msg != ""){
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)	
	return
	}
	
	if(tipo==""){
	window.parent.muestra_alerta_general_desde_select('devolver_item_a_gerente_contrato(1)', 'Advertencia','* Esta seguro de Devolver esta Solicitud', 40, 5, 12)
	return
	}
    //var alerta = confirm("Esta seguro de Devolver esta Solicitud?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "devolver_solictud_gerente"
        forma.target = "grp"
        forma.submit()
    //}
}

function elimina_firma_completa_adjudica(id_elimina_firma, adj_permiso) {
    var forma = document.principal


//    var alerta = confirm("Esta seguro de Eliminar Todo el Rol Encargado?")

  //  if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_rol_usuario_de_firmas_adjudica"
        forma.id_secuencia.value = id_elimina_firma
        forma.tipo_adj_permiso.value = adj_permiso
        forma.target = "grp"
        forma.submit()
    //}
}
function elimina_firma_completa(id_elimina_firma, adj_permiso) {
    var forma = document.principal


   // var alerta = confirm("Esta seguro de Eliminar Todo el Rol Encargado?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_rol_usuario_de_firmas"
        forma.id_secuencia.value = id_elimina_firma
        forma.tipo_adj_permiso.value = adj_permiso
        forma.target = "grp"
        forma.submit()
    //}
}


function elimina_usuario_firma_adjudica(id_usuario_elimina, adj_permiso, id_rol) {
    var forma = document.principal
	if(id_rol == 35 || id_rol == 45 || id_rol == 9 || id_rol == 20 || id_rol == 43){
		muestra_alerta_iformativa_solo_texto('', '¡ATENCION! Usted está seguro de quitar este usuario, tenga en cuenta que es un nivel de aprobacion, por favor confirme que este publicado en cartelera de intranet', advertencia, 40, 5, 12)
		//var alerta = confirm("¡ATENCION! Usted está seguro de quitar este usuario, tenga en cuenta que es un nivel de aprobacion, por favor confirme que este publicado en cartelera de intranet")
		}else{
		//var alerta = confirm("Esta seguro de Eliminar este Usuario de las Firmas?")
		}
   // if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_usuario_de_firmas_adjudica"
        forma.id_secuencia.value = id_usuario_elimina
        forma.tipo_adj_permiso.value = adj_permiso
        forma.target = "grp"
        forma.submit()
   // }
}
function elimina_usuario_firma(id_usuario_elimina, adj_permiso, id_rol) {
    var forma = document.principal

if(id_rol == 35 || id_rol == 45 || id_rol == 9 || id_rol == 20 || id_rol == 43){
		muestra_alerta_iformativa_solo_texto('', '¡ATENCION! Usted está seguro de quitar este usuario, tenga en cuenta que es un nivel de aprobacion, por favor confirme que este publicado en cartelera de intranet', advertencia, 40, 5, 12)
	//var alerta = confirm("¡ATENCION! Usted está seguro de quitar este usuario, tenga en cuenta que es un nivel de aprobacion, por favor confirme que este publicado en cartelera de intranet")
		}else{
		//var alerta = confirm("Esta seguro de Eliminar este Usuario de las Firmas?")
		}

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_usuario_de_firmas"
        forma.id_secuencia.value = id_usuario_elimina
        forma.tipo_adj_permiso.value = adj_permiso
        forma.target = "grp"
        forma.submit()
    //}
}
function cambia_orden_firmas(secuencia, orden, adj_permiso) {
    var forma = document.principal
    window.parent.document.getElementById("cargando_pecc").style.display = "block"
    forma.action = "procesos-pecc.html";
    forma.accion.value = "cambia_orden_secuencia"
    forma.id_secuencia.value = secuencia
    forma.orden_edita_secua.value = orden
    forma.tipo_adj_permiso.value = adj_permiso
    forma.target = "grp"
    forma.submit()


}
function agrega_aprobacion(adj_permiso) {
    var forma = document.principal
    var msg = ""

    if (forma.rol_encarga_permiso.value == 0) {
        msg = msg + "* Seleccione el Rol Encargado\n"
        forma.rol_encarga_permiso.className = "select_faltantes";
    } else {
        forma.rol_encarga_permiso.className = "";
    }
	
    if (forma.usuario_permiso.value == "") {
        msg = msg + "* Digite el usuario Encargado\n"
        forma.usuario_permiso.className = "campos_faltantes";
    } else {
        forma.usuario_permiso.className = "";
    }
    if (forma.orden_permiso.value == "") {
        msg = msg + "* Digite el Orden de la Secuencia\n"
        forma.orden_permiso.className = "campos_faltantes";
    } else {
        forma.orden_permiso.className = "";
    }

    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
/*
	if(forma.rol_encarga_permiso.value == 35 || forma.rol_encarga_permiso.value == 45 || forma.rol_encarga_permiso.value == 9 || forma.rol_encarga_permiso.value == 20 || forma.rol_encarga_permiso.value == 43){
	var alerta = confirm("¡ATENCION! Usted está seguro de asignar éste remplazo, por favor confirme que éste publicado en cartelera de intranet")
	}else{
        var alerta = confirm("Esta seguro de Agregar esta Firma en el Sistema?")
	}
        if (alerta) {*/
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.tipo_adj_permiso.value = adj_permiso
            forma.accion.value = "agrega_aprobacion"
            forma.target = "grp"
            forma.submit()
  //      }
    }

}
function eliminar_anexo_edicion(tipo_anexo, id_anexo_elimina) {
    var forma = document.principal
    var nombre = "";
    if (tipo_anexo == 8) {
        nombre = "Anexo";
    }
    if (tipo_anexo == 9) {
        nombre = "Antecedente";
    }
    if (tipo_anexo == 10) {
        nombre = "Documento Básico";
    }
    if (tipo_anexo == 11) {
        nombre = "Documento de Emsamble";
    }
    if (tipo_anexo == 12) {
        nombre = "Documento Básico";
    }
    if (tipo_anexo == 13) {
        nombre = "Documento de Emsamble";
    }

    var alerta = confirm("Esta Seguro de Eliminar este " + nombre + "?")

    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_anexo_edicion"
        forma.tipo_anexo.value = tipo_anexo
        forma.id_anexo_elimina.value = id_anexo_elimina
        forma.target = "grp"
        forma.submit()
    }
}

function eliminar_anexo(tipo_anexo, id_anexo_elimina) {
    var forma = document.principal
    var nombre = "";
    if (tipo_anexo == 8) {
        nombre = "Anexo";
    }
    if (tipo_anexo == 9) {
        nombre = "Antecedente";
    }

    var alerta = confirm("Esta Seguro de Eliminar este " + nombre + "?")

    if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_anexo"
        forma.tipo_anexo.value = tipo_anexo
        forma.id_anexo_elimina.value = id_anexo_elimina
        forma.target = "grp"
        forma.submit()
    }
}
function edita_proveedores_sugeridos() {
    var forma = document.principal
    //var alerta = confirm("Esta Seguro de Modificar los Proveedores Sugeridos?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "edita_proveedores_sugeridos"
        forma.target = "grp"
        forma.submit()
    //}
}
function elimina_proveedor_sm(id_proveedor,tipo_elimina) {
    var forma = document.principal
	if(tipo_elimina==1){
		forma.tipo_elimna_proveedor.value=1
	}
   // var alerta = confirm("Esta Seguro de Eliminar este Proveedor, tambien lo eliminara de la urna que se encuentra activa relacionada a este proceso?")

   // if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "graba_proveedor_elimina_sm_urna"
        forma.id_elim_proveedor.value = id_proveedor
        forma.target = "grp"
        forma.submit()
    //}
}

function elimina_proveedor(id_proveedor,tipo_elimina) {
    var forma = document.principal
	if(tipo_elimina==1){
		forma.tipo_elimna_proveedor.value=1
	}
    //var alerta = confirm("Esta Seguro de Eliminar este Proveedor?")

    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "graba_proveedor_elimina"
        forma.id_elim_proveedor.value = id_proveedor
        forma.target = "grp"
        forma.submit()
    //}
}
function valida_proveedor_edita() {
    var forma = document.principal
    var msg = ""


    if (forma.nom2.value == "") {
        msg = msg + "* Digite el Nombre ó Razon Social del Proveedor\n"
        forma.nom2.className = "select_faltantes";
    } else {
        forma.nom2.className = "";
    }


    if (forma.nit2.value == "") {
        msg = msg + "* Digite el Nit del Proveedor\n"
        forma.nit2.className = "select_faltantes";
    } else {
        forma.nit.className = "";
    }

    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {

        var alerta = confirm("Esta seguro de Grabar los Cambios de este Proveedor?")

        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_proveedor_edita"
            forma.target = "grp"
            forma.submit()
        }
    }

}

function agrega_proveedor_ser_menor(tipo, id_proveedor_relacionado, campo_file_lista_restriccion, campo_justificacion_proveedor) {
    var forma = document.principal
    var msg = ""

	var mesager="";
if(tipo == "nuevo_solictante" || tipo == "sin_proveedor"){
            forma.accion.value = "graba_proveedor_base_nuevo_solictante"
			forma.id_proveedor_a_relacionar.value = id_proveedor_relacionado;
			//mesager="Esta Seguro de Crear este Servicio Menor?";
			}else{
					if(tipo == "edita_solicitante"){
						 forma.accion.value = "graba_proveedor_base_edita_solictante"
							forma.id_proveedor_a_relacionar.value = id_proveedor_relacionado;
						//mesager="Esta Seguro de Agregar este Proveedor?";
					}
				}

	if(tipo == "edita_profesinal"){
					
						 forma.accion.value = "graba_proveedor_base_edita_solictante"
							forma.id_proveedor_a_relacionar.value = id_proveedor_relacionado;
						//mesager="Esta Seguro de Agregar este Proveedor?";
		
		if (campo_file_lista_restriccion.value == "") {
//        alert("Seleccione el archivo de validación de listas restrictivas")
		msg = msg + "* Seleccione el archivo de validación de listas restrictivas"
        campo_file_lista_restriccion.className = "campos_faltantes";
	//		return;
		
    } 
				
				}
	
		if(tipo == "edita_profesinal_directo_urna"){
					
						 forma.accion.value = "graba_proveedor_base_edita_solictante"
							forma.id_proveedor_a_relacionar.value = id_proveedor_relacionado;
						//mesager="Esta Seguro de Agregar este Proveedor?";
		
		if (campo_file_lista_restriccion.value == "") {
//alert("Seleccione el archivo de validación de listas restrictivas")
		msg = msg + "* Seleccione el archivo de validación de listas restrictivas"
        campo_file_lista_restriccion.className = "campos_faltantes";
			return;
		
    } 
			if (campo_justificacion_proveedor.value == "") {
//        alert("Digite la justificación, del por que esta ingresando este proveedor posterior al completamiento.")
		msg = msg + "*Digite la justificación, del por que esta ingresando este proveedor posterior al completamiento." 
        campo_justificacion_proveedor.className = "textarea_faltantes";
			return;
		
    } 
				
				}
	
	
	
	if(msg != ""){
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12);
				return
		}
	
	
       // var alerta = confirm(mesager)

        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.target = "grp"
            forma.submit()
        //}


}

function valida_proveedor_nuevo_base_datos() {
    var forma = document.principal
    var msg = ""


    if (forma.proveedores_busca_adjudicacion.value == "") {
        msg = msg + "* Digite el Nombre ó Razon Social del Proveedor\n"
        forma.proveedores_busca_adjudicacion.className = "select_faltantes";
    } else {
        forma.proveedores_busca_adjudicacion.className = "";
    }



    if (msg != "") {
//        alert("Verifique el formulario\n\n" + msg)
muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {

       // var alerta = confirm("Esta seguro de Grabar este Proveedor?")

      //  if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_proveedor_base"
            forma.target = "grp"
            forma.submit()
       // }
    }

}
function valida_proveedor_nuevo(tipo) {
    var forma = document.principal
    var msg = ""


    if (forma.nom.value == "") {
        msg = msg + "* Digite el Nombre ó Razon Social del Proveedor\n"
        forma.nom.className = "campos_faltantes";
    } else {
        forma.nom.className = "";
    }

if(tipo == "SM"){
	
	if (forma.nit.value == "" || forma.dver.value == "") {
        msg = msg + "* Digite el NIT completo inclusive con el digito de verificación (DV)\n"
        forma.nit.className = "campos_faltantes";
		forma.dver.className = "campos_faltantes";
    } else {
        forma.nit.className = "";
		forma.dver.className = "";
    }
	
	if (forma.archivo_lista_restrictiva.value == "") {
        msg = msg + "* Seleccione el archivo de validación de listas restrictivas\n"
        forma.archivo_lista_restrictiva.className = "campos_faltantes";
		
    } else {
        forma.archivo_lista_restrictiva.className = "";
		
    }
	
}

    if (msg != "") {
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12);
       // alert("Verifique el formulario\n\n" + msg)
        return
    } else {

        //var alerta = confirm("Esta seguro de Grabar este Proveedor?")

        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
			if(forma.id_item_pecc.value > 0){
            forma.accion.value = "graba_proveedor";
			//}else{
				//forma.accion.value = "graba_proveedor_nuevo_solicitante";				
				//}
            forma.target = "grp"
            forma.submit()
        }
    }

}


function carga_contratos_sin_valores(id_contrato, id_item) {
    if (id_contrato == 0 && id_contrato != "") {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=2&id_item_pecc=" + id_item, "carga_contratos_aplica")
    } else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_contratos_aplica")
    }
}
function carga_contratos_sin_valores_edita(id_contrato, id_item, id_presupuesto) {
    if (id_contrato == 0) {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=7&id_item_pecc=" + id_item + "&id_presupuesto=" + id_presupuesto, "carga_contratos_varios_id_edita")
    } else {
        ajax_carga("../aplicaciones/pecc/ajax.php?tipo_ajax=0", "carga_contratos_varios_id_edita")
    }
}

function valida_texto_espacios(campo_texto) {

    var lleno = "SI";
    var cadena = "";


    cadena = campo_texto.replace(" ", "");

    for (var i = 0; i < campo_texto.length; i++) {
        cadena = cadena.replace(" ", "");
    }

    if (cadena == "") {
        lleno = "NO";
    }
    return lleno;

}

function valida_graba_item_info_sm(tipo) {
	 var forma = document.principal
    var msg = ""
	var advertencia = ""
	

	
	
			if (valida_texto_espacios(forma.objeto_solicitud_ad_sm.value) == "NO"  || characterCount(forma.objeto_solicitud_ad_sm.value,20) != "") {
            msg = msg + "*  Digite el objeto de la solicitud"
            forma.objeto_solicitud_ad_sm.className = "textarea_faltantes";
			} else {
				forma.objeto_solicitud_ad_sm.className = "";
			}
	

 if (forma.reajuste.value == 0) {
        msg = msg + "* Seleccione Si tiene reajustes"
        forma.reajuste.className = "select_faltantes";
    } else {
        forma.reajuste.className = "";
    }
			if (valida_texto_espacios(forma.objeto_contrato_ad_sm.value) == "NO"  || characterCount(forma.objeto_contrato_ad_sm.value,20) != "") {
            msg = msg + "*  Digite el objeto de la orden de servicio"
            forma.objeto_contrato_ad_sm.className = "textarea_faltantes";
			} else {
				forma.objeto_contrato_ad_sm.className = "";
			}
			if (valida_texto_espacios(forma.alcance_ad_sm.value) == "NO"  || characterCount(forma.alcance_ad_sm.value,20) != "") {
            msg = msg + "*  Digite el alcance"
            forma.alcance_ad_sm.className = "textarea_faltantes";
			} else {
				forma.alcance_ad_sm.className = "";
			}
			if (valida_texto_espacios(forma.justificacion_ad_sm.value) == "NO"  || characterCount(forma.justificacion_ad_sm.value,20) != "") {
            msg = msg + "*  Digite la justificación comercial"
            forma.justificacion_ad_sm.className = "textarea_faltantes";
			} else {
				forma.justificacion_ad_sm.className = "";
			}
			if (valida_texto_espacios(forma.recomendacion_ad_sm.value) == "NO"  || characterCount(forma.recomendacion_ad_sm.value,20) != "") {
            msg = msg + "*  Digite la recomendación"
            forma.recomendacion_ad_sm.className = "textarea_faltantes";
			} else {
				forma.recomendacion_ad_sm.className = "";
			}
			
	if (forma.antecedentes_texto) {
			if (valida_texto_espacios(forma.antecedentes_texto.value) == "NO"  || characterCount(forma.antecedentes_texto.value,20) != "") {
            msg = msg + "*  Digite los Antecedentes del proceso\n"
            forma.antecedentes_texto.className = "textarea_faltantes";
			} else {
				forma.antecedentes_texto.className = "";
			}
			
			if(forma.tipo_proceso.value != 16){
					if (forma.antecedente_anexo.value=="") {
						if (forma.con_anexo_antecedente.value==" " || forma.con_anexo_antecedente.value=="") {
							msg = msg + "*  Seleccione un Anexo para el antecedente\n"
							}
						
						}
					
			}
		}

    if (msg != "") {
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
		 // alert("Verifique el formulario\n\n" + msg)
        return
    } else {
		
       	if(advertencia !=""){
				muestra_alerta_iformativa_solo_texto('', 'Advertencia', advertencia, 40, 5, 12)
		}
               
            forma.accion.value = "graba_presupuesto_item_edita_sm"
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.tipo_graba.value = tipo

            forma.target = "grp"
            forma.submit()
       }

	
}
function valida_graba_item_edita(tipo) {
    var forma = document.principal
    var msg = ""
	var advertencia = ""

    if (forma.usuario_permiso.value == 0 || forma.gerente_contra.value == "") {
        msg = msg + "» Seleccione el Gerente de la OT<br>"
        forma.usuario_permiso.className = "campos_faltantes";
    } else {
        forma.usuario_permiso.className = "";
    }


    if (forma.gerente_contra.value == 0 || forma.gerente_contra.value == "") {
        msg = msg + "» Seleccione el Gerente del Item\n"
        forma.gerente_contra.className = "campos_faltantes";
    } else {
        forma.gerente_contra.className = "";
    }
    if (forma.area_usuaria.value == 0) {
        msg = msg + "» Seleccione el Área Usuaria\n"
        forma.area_usuaria.className = "select_faltantes";
    } else {
        forma.area_usuaria.className = "";
    }

    if ((tipo == 2 || tipo == 3) && (forma.tipo_proceso.value==forma.tipo_proceso_anterior.value)) {
		
if(forma.alertas_modal.value != ""){
	msg = msg + forma.alertas_modal.value
	}

        if (forma.tipo_proceso.value == 0) {
            msg = msg + "* Seleccione el tipo de Proceso\n"
            forma.tipo_proceso.className = "select_faltantes";
        } else {
            forma.tipo_proceso.className = "";
            if (forma.tipo_proceso.value == 4 || forma.tipo_proceso.value == 5 || forma.tipo_proceso.value == 12) {
                if (forma.contratos_normales.value == "" || forma.contratos_normales.value == "-C- Contratista: ----,----," || forma.contratos_normales.value == " ") {
                    msg = msg + "* Seleccione el Contrato/Proveedor al Cual Aplica\n"
                    forma.contratos_normales.className = "campos_faltantes";
                } else {
                    forma.contratos_normales.className = "";
                }
            
            }
		
			if (forma.tipo_proceso.value == 8 && tipo == 2) {//servicios menores - solicitante
				  if (forma.justificacion.value == 0 ) {
					msg = msg + "*  Digite la Justificación";
					forma.justificacion.className = "textarea_faltantes";
				} else {
					forma.justificacion.className = "";
				}
            }
			
		if (forma.tipo_proceso.value == 16 && tipo == 2) {//servicios menores - solicitante
                  if (forma.reembolsable.value == 0 ) {
					msg = msg + "*  Seleccione si este servicio menor tiene reembolsables";
					forma.reembolsable.className = "select_faltantes";
				} else {
					forma.reembolsable.className = "";
				}
				
            }
		
		if (forma.tipo_proceso.value == 16 && tipo == 2) {//servicios menores - solicitante
			if (valida_texto_espacios(forma.objeto_contrato.value) == "NO" || characterCount(forma.objeto_contrato.value,20) != "") {
            msg = msg + "*  Digite el Objeto de la Orden de Servicio "+characterCount(forma.objeto_contrato.value,20);
            forma.objeto_contrato.className = "textarea_faltantes";
        } else {
            forma.objeto_contrato.className = "";
        }
		}
		
		/*if (forma.tipo_proceso.value == 16 && tipo == 3) {//servicios menores - solicitante
                  if (forma.reajuste.value == 0 ) {
					msg = msg + "*  Seleccione si este servicio menor tiene reajustes";
					forma.reajuste.className = "select_faltantes";
				} else {
					forma.reajuste.className = "";
				}
            }*/
		
		
			if (forma.tipo_proceso.value == 16 && tipo == 3) {//servicios menores 
                  if (valida_texto_espacios(forma.justificacion.value) == "NO"  || characterCount(forma.justificacion.value,20) != "" ) {
					msg = msg + "*  Digite la Justificacion Comercial" + characterCount(forma.justificacion.value,20);
					forma.justificacion.className = "textarea_faltantes";
				} else {
					forma.justificacion.className = "";
				}
            }
			
            if (forma.tipo_proceso.value == 11) {
                if ((forma.contratos_normales.value == "" || forma.contratos_normales.value == "-C- Contratista: ----,----,") && (forma.solicitud_que_carga.value == "" || forma.solicitud_que_carga.value == 0)) {
                    advertencia = advertencia + "* Va a crear la solicitud sin relacionar contrato ni solicitud"
                }
            }


        }
		
		/*sondeos - Por ahora queda opcional para las negociaciones directas
	if (forma.tipo_proceso.value == 2 && tipo == 3) {
		if((forma.llena_lista_sondeos_l.value == "" || forma.llena_lista_sondeos_l.value == "0")){
			 msg = msg + "* ATENCION: Seleccione el sondeo de mercado de la urna virtual\n"
             forma.llena_lista_sondeos_l.className = "campos_faltantes";
			}else{
				forma.llena_lista_sondeos_l.className = "campos_faltantes";
				}
				

	}*/
	if ((forma.tipo_proceso.value == 5 || forma.tipo_proceso.value == 2) && tipo == 3) {
		if(forma.llena_lista_sondeos_l.value == ""){
			advertencia = advertencia + "* Recuerde que usted puede relacionar un sondeo de mercado"
		}

	}

	/*sondeos*/	
	
/*validacion PECC*/

/*FIN vlidaciones PECC*/		

/*CONFLICTO DE intereses*/
if(tipo == 2 ){
	 if (forma.falta_algun_afe_ceco.value > 0) {
msg = msg + "* Para poner en firme la solicitud debe completar la informacion de AFE / CECO, si no tiene esta informacion por favor guarde la solicitud temporalmente."
//SE COMENTAREA YA QUE LA VALIDACION SE TRASLADA AL PHP
} 
	
if (forma.conflito_intere_sel.value == "0") {
            msg = msg + "* Seleccione si tiene conflicto de intereses\n"
            forma.conflito_intere_sel.className = "select_faltantes";
        } else if(forma.conflito_intere_sel.value == "1"){
			msg = msg + "* Si tiene conflicto de intereses no puede poner en firme la solicitud\n"
            forma.conflito_intere_sel.className = "select_faltantes";
			}
		else{		
            forma.conflito_intere_sel.className = "";	
        }
		
}
/*FIN CONFLICTO DE intereses*/
        if (forma.fecha.value == "" || forma.fecha.value == " ") {
            msg = msg + "*  Seleccione la Fecha\n"
            forma.fecha.className = "campos_faltantes";
        } else {
            forma.fecha.className = "";
        }




        if (valida_texto_espacios(forma.objeto_solicitud.value) == "NO"  || characterCount(forma.objeto_solicitud.value,20) != "" ) {
            msg = msg + "*  Digite el Objeto de la Solicitud " + characterCount(forma.objeto_solicitud.value,20);
            forma.objeto_solicitud.className = "textarea_faltantes";
        } else {
            forma.objeto_solicitud.className = "";
        }




		if(forma.id_tipo_contratacion.value == "1"){
   		 if ((valida_texto_espacios(forma.alcance.value) == "NO" || characterCount(forma.alcance.value,20) != "") && forma.tipo_proceso.value != 8) {
            msg = msg + "*  Digite el Alcance "+characterCount(forma.alcance.value,20);
            forma.alcance.className = "textarea_faltantes";
        } else {
            forma.alcance.className = "";
        }
}else{//si no es una solicitud de servicios se muestra de manera informativa
    if ((valida_texto_espacios(forma.alcance.value) == "NO" || characterCount(forma.alcance.value,20) != "") && forma.tipo_proceso.value != 8) {
            muestra_alerta_iformativa_solo_texto('', 'Verifique los Siguientes Campos','* Recuerde Digitar el Alcance', 20, 10, 18);
        }
}
        if ((valida_texto_espacios(forma.justificacion2.value) == "NO" || characterCount(forma.justificacion2.value,20) != "") && forma.tipo_proceso.value != 8) {
            msg = msg + "*  Digite la Justificación Técnica "+characterCount(forma.justificacion2.value,20);
            forma.justificacion2.className = "textarea_faltantes";
        } else {
            forma.justificacion2.className = "";
        }
        
        /* Criterios de Evaluacion*/
		
		
        if (valida_texto_espacios(forma.recomendacion.value) == "NO" || characterCount(forma.recomendacion.value,20) != "") {
            msg = msg + "*  Digite la Recomendación "+characterCount(forma.recomendacion.value,20);
            forma.recomendacion.className = "textarea_faltantes";
        } else {
            forma.recomendacion.className = "";
        }
		
		
		

		
			
			if (forma.tipo_proceso.value != 16) {
        if ((valida_texto_espacios(forma.criterios_evaluacion.value) == "NO" || characterCount(forma.criterios_evaluacion.value,20) != "") && forma.tipo_proceso.value != 8) {
            msg = msg + "* Digite los Criterios de Evaluacion "+characterCount(forma.criterios_evaluacion.value,20)
            forma.criterios_evaluacion.className = "textarea_faltantes";
        } else {
            forma.criterios_evaluacion.className = "";
        }
		if (valida_texto_espacios(forma.objeto_contrato.value) == "NO" || characterCount(forma.objeto_contrato.value,20) != "") {
            msg = msg + "*  Digite el Objeto del Contrato "+characterCount(forma.objeto_contrato.value,20);
            forma.objeto_contrato.className = "textarea_faltantes";
        } else {
            forma.objeto_contrato.className = "";
        }
		}
		
titulo1 = "Digitar la oportunidad";
	titulo3 = "Digite la Calidad";
if(forma.id_item_pecc.value > 0){
	titulo1 = "Bajo Costo";
	titulo3 = "Capacidad Técnica";
	}

if(forma.tipo_proceso.value== 1 || forma.tipo_proceso.value== 2 || forma.tipo_proceso.value== 3 || forma.tipo_proceso.value== 5 || forma.tipo_proceso.value== 7 || forma.tipo_proceso.value== 15 || forma.tipo_proceso.value== 6){
		if (valida_texto_espacios(forma.campos1.value) == "NO"  || characterCount(forma.campos1.value,20) != "" ) {
            msg = msg + "*"+titulo1+"  \n" + characterCount(forma.campos1.value,20);
            forma.campos1.className = "textarea_faltantes";
        } else {
            forma.campos1.className = "";
        }
		if (valida_texto_espacios(forma.campos3.value) == "NO"  || characterCount(forma.campos3.value,20) != "" ) {
            msg = msg + "*"+titulo3+"  \n" + characterCount(forma.campos3.value,20);
            forma.campos3.className = "textarea_faltantes";
        } else {
            forma.campos3.className = "";
        }
        if (valida_texto_espacios(forma.campos4.value) == "NO"  || characterCount(forma.campos4.value,20) != "" ) {
            msg = msg + "*  Digite Gestión de Entorno\n" + characterCount(forma.campos4.value,20);
            forma.campos4.className = "textarea_faltantes";
        } else {
            forma.campos4.className = "";
        }
		if (tipo == 3) {
        if (valida_texto_espacios(forma.campos5.value) == "NO"  || characterCount(forma.campos5.value,20) != "" ) {
            msg = msg + "*  Digite Trazabilidad\n" + characterCount(forma.campos5.value,20);
            forma.campos5.className = "textarea_faltantes";
        } else {
            forma.campos5.className = "";
        }
        if (valida_texto_espacios(forma.campos6.value) == "NO"  || characterCount(forma.campos6.value,20) != "" ) {
            msg = msg + "*  Digite Transparencia\n" + characterCount(forma.campos6.value,20);
            forma.campos6.className = "textarea_faltantes";
        } else {
            forma.campos6.className = "";
        }
		
		}
        if (valida_texto_espacios(forma.campos7.value) == "NO"  || characterCount(forma.campos7.value,20) != "" ) {
            msg = msg + "*  Digite Agilidad\n" + characterCount(forma.campos7.value,20);
            forma.campos7.className = "textarea_faltantes";
        } else {
            forma.campos7.className = "";
        }
}
		


				/*if (forma.tipo_proceso.value == 12) {
					 if (forma.req_crear_otro_si.value == "0") {
						msg = msg + "* ATENCION: Seleccione si esta reclasificación requiere otrosí y por favor complete el objeto del otrosí en el campo de recomendación.\n"
						forma.req_crear_otro_si.className = "select_faltantes";
					}else{		
						forma.req_crear_otro_si.className = "";	
					}
				 }*/
			if(forma.estado_actual_del_proceso.value != 31){
				 if (forma.tipo_proceso.value == 1 || forma.tipo_proceso.value == 2 || forma.tipo_proceso.value == 6 || forma.tipo_proceso.value == 3) {
					if (forma.req_contra_mano_obra_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de mano de obra local\n"
						forma.req_contra_mano_obra_local.className = "select_faltantes";
					}else{		
						forma.req_contra_mano_obra_local.className = "";	
					} 
					if (forma.req_cont_bien_ser_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de bienes o servicios local\n"
						forma.req_cont_bien_ser_local.className = "select_faltantes";
					}else{		
						forma.req_cont_bien_ser_local.className = "";	
					} 
				 }
			}

    

    if (tipo == 3) {
        if (forma.us_prof.value == 0) {
            msg = msg + "*  Seleccione el Profesional Designado\n"
            forma.us_prof.className = "textarea_faltantes";
        } else {
            forma.us_prof.className = "";
        }
		
		/*if (forma.antecedentes_texto) {
			if (valida_texto_espacios(forma.antecedentes_texto.value) == "NO"  || characterCount(forma.antecedentes_texto.value,20) != "") {
            msg = msg + "*  Digite los Antecedentes del proceso\n"
            forma.antecedentes_texto.className = "textarea_faltantes";
			} else {
				forma.antecedentes_texto.className = "";
			}
			
			if(forma.tipo_proceso.value != 16){
					if (forma.antecedente_anexo.value=="") {
						if (forma.con_anexo_antecedente.value==" " || forma.con_anexo_antecedente.value=="") {
							msg = msg + "*  Seleccione un Anexo para el antecedente\n"
							}
						
						}
					
			}
		}*/


       /* if (valida_texto_espacios(forma.equipo_negociador.value) == "NO"  || characterCount(forma.equipo_negociador.value,20) != "" ) {
            msg = msg + "* ATENCION: Digite el Equipo Negociador\n"
            forma.equipo_negociador.className = "textarea_faltantes";
        } else {
            forma.equipo_negociador.className = "";
        }*/

if(forma.tipo_proceso.value==forma.tipo_proceso_anterior.value){
	if(forma.tipo_proceso.value == 8){	

        if (valida_texto_espacios(forma.justificacion.value) == "NO"  || characterCount(forma.justificacion.value,20) != "" ) {
            msg = msg + "*  Digite la Justificación\n"
            forma.justificacion.className = "textarea_faltantes";
        } else {
            forma.justificacion.className = "";
        }
	}
}
/*		
		if (valida_texto_espacios(forma.conflicto_intereses.value) == "NO") {
            msg = msg + "*  Digite el Conflicto de intereses\n"
            forma.conflicto_intereses.className = "textarea_faltantes";
        } else {
            forma.conflicto_intereses.className = "";
        }*/
		
		
		
    }
	
	//if(tipo == 3){

	if(forma.origen_pecc.value > 1 && forma.origen_pecc.value != ""){//si tiene un PECC realacionado
			if(forma.linea_pecc.value == 0 && forma.pecc_modificado.value ==0){
				msg = msg + "*Por favor seleccione la linea del PECC y si requiere modificacion"
			
				}
				

			if(forma.linea_pecc.value == 0){
				msg = msg + "*Por favor digite la linea del PECC"
				
				}

			if(forma.pecc_modificado.value ==0){
				msg = msg + "*Por favor seleccione si el PECC requiere modificacion"
	
				}else if(forma.pecc_modificado.value ==1){//si selecciono que el PECC fue modificado
					if(valida_texto_espacios(forma.pecc_observacion_modificacion.value) == "NO"  || characterCount(forma.pecc_observacion_modificacion.value,20) != ""){
						msg = msg + "*Por favor digite la justificacion de la modificacion, esta debe tener como minimo 20 caracteres"
					
						}
					}
				
				
		}


	}// fin si no cambio el tipo de proceso
	//}
	
	/*if (forma.origen_pecc.value == "") {
            msg = msg + "* Seleccione el origen de la solicitud\n"
            forma.origen_pecc.className = "select_faltantes";
        } 
			else{		
            forma.origen_pecc.className = "";	
        }*/
	
	

    if (msg != "") {
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
		 // alert("Verifique el formulario\n\n" + msg)
        return
    } else {
		
        if (tipo == 1) {
           // var alerta = confirm("Esta seguro de Grabar esta Solicitud Temporalmente?")
        }
        if (tipo == 2) {
           // var alerta = confirm("Esta seguro de Grabar esta Solicitud y Poner en Firme?")
        }

        if (tipo == 3) {

			if(advertencia !=""){
				muestra_alerta_iformativa_solo_texto('', 'Advertencia', advertencia, 40, 5, 12)
		}
           // var alerta = confirm("Esta seguro de Grabar este Proceso")
            forma.accion.value = "graba_presupuesto_item_edita_profesional"

        } else {
            forma.accion.value = "graba_presupuesto_item_edita"
        }

       // if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.tipo_graba.value = tipo

            forma.target = "grp"
            forma.submit()
       // }
    }
}
function graba_solped_compras() {
    var forma = document.principal
    var msg = ""
    if (forma.num_solped.value == "") {
        msg = msg + "* Digite el Numero de la SolPed\n"
        forma.num_solped.className = "campos_faltantes";
    } else {
        forma.num_solped.className = "";
    }

    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {

        var alerta = confirm("Esta seguro de grabar esta MRO y enviar al completamiento?")

        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_solped_compra"
            forma.target = "grp"
            forma.submit()
        }
    }

}
function valida_graba_item(tipo) {
    var forma = document.principal
    var msg = ""
	var advertencia = ""

    if (forma.usuario_permiso.value == 0 || forma.usuario_permiso.value == "") {
        msg = msg + "* Seleccione el Gerente de la OT\n"
        forma.usuario_permiso.className = "campos_faltantes";
    } else {
        forma.usuario_permiso.className = "";
    }

    if (forma.gerente_contra.value == 0 || forma.gerente_contra.value == "") {
        msg = msg + "* Seleccione el Gerente del Item\n"
        forma.gerente_contra.className = "campos_faltantes";
    } else {
        forma.gerente_contra.className = "";
    }

    if (forma.area_usuaria.value == 0 || forma.area_usuaria.value == "") {
        msg = msg + "* Seleccione el Área Usuaria\n"
        forma.area_usuaria.className = "select_faltantes";
    } else {
        forma.area_usuaria.className = "";
    }
	
	if (forma.tipo_proceso.value == 15){
		 if (forma.id_solicitud_relacionada.value == 0 || forma.id_solicitud_relacionada.value == "") {
        msg = msg + "* Seleccione la solicitud que desea modificar\n"
   		 }
		
		}
	
    if (tipo == 2) {
        
		/*
         if(forma.valor_total_js_valida.value == 0){
         alert("El Valor de la Solicitud No Puede Ser 0");
         return;
         }
         */
 if (forma.falta_algun_afe_ceco.value > 0) {
        alert("ATENCION: Para poner en firme la solicitud debe completar la informacion de AFE / CECO, si no tiene esta informacion por favor guarde la solicitud temporalmente.\n")
		return;
    } 

        if (forma.tipo_proceso.value == 0) {
            msg = msg + "* Seleccione el tipo de Proceso\n"
            forma.tipo_proceso.className = "select_faltantes";
        } else {
            forma.tipo_proceso.className = "";
            if (forma.tipo_proceso.value == 4 || forma.tipo_proceso.value == 5 || forma.tipo_proceso.value == 12 ) {
                if (forma.contratos_normales.value == "" || forma.contratos_normales.value == "-C- Contratista: ----,----," ) {
                    msg = msg + "* Seleccione el Contrato/Proveedor al Cual Aplica\n"
                    forma.contratos_normales.className = "campos_faltantes";
                } else {
                    forma.contratos_normales.className = "";
                }
            }
			
			if (forma.tipo_proceso.value == 16) {
                if ((forma.proveedores_busca.value == "" || forma.proveedores_busca.value == "- ----,----")) {
                    msg = msg + "* Seleccione el Proveedor el cual se desea relacionar para crear el servicio menor\n"
					forma.proveedores_busca.className = "campos_faltantes";
                }else{
                    forma.proveedores_busca.className = "";
					}
            }
			
            if (forma.tipo_proceso.value == 11) {
                if ((forma.contratos_normales.value == "" || forma.contratos_normales.value == "-C- Contratista: ----,----,") && (forma.solicitud_que_carga.value == "" || forma.solicitud_que_carga.value == 0)) {
                    advertencia = "* Va a crear la solicitud sin relacionar contrato ni solicitud"

                }
            }
/*
				 if (forma.tipo_proceso.value == 12) {
					 if (forma.req_crear_otro_si.value == "0") {
						msg = msg + "* ATENCION: Seleccione si esta reclasificación requiere otrosí y por favor complete el objeto del otrosí en el campo de recomendación.\n"
						forma.req_crear_otro_si.className = "select_faltantes";
					}else{		
						forma.req_crear_otro_si.className = "";	
					}
				 }
				 
				 if (forma.tipo_proceso.value == 1 || forma.tipo_proceso.value == 2 || forma.tipo_proceso.value == 6 || forma.tipo_proceso.value == 3) {
					if (forma.req_contra_mano_obra_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de mano de obra lozal\n"
						forma.req_contra_mano_obra_local.className = "select_faltantes";
					}else{		
						forma.req_contra_mano_obra_local.className = "";	
					} 
					if (forma.req_cont_bien_ser_local.value == "0") {
						msg = msg + "* Seleccione si requiere contratacion de bienes o servicios local\n"
						forma.req_cont_bien_ser_local.className = "select_faltantes";
					}else{		
						forma.req_cont_bien_ser_local.className = "";	
					} 
				 }
				 */

        }
		
					 


if (forma.conflito_intere_sel.value == "0") {
            msg = msg + "* Seleccione si tiene conflicto de intereses\n"
            forma.conflito_intere_sel.className = "select_faltantes";
        } else if(forma.conflito_intere_sel.value == "1"){
			msg = msg + "* Si tiene conflicto de intereses no puede poner en firme la solicitud\n"
            forma.conflito_intere_sel.className = "select_faltantes";
			}
		else{		
            forma.conflito_intere_sel.className = "";	
        }
		
		
        if (forma.fecha.value == "") {
            msg = msg + "* Seleccione la Fecha\n"
            forma.fecha.className = "campos_faltantes";
        } else {
            forma.fecha.className = "";
        }
        
        
        if (valida_texto_espacios(forma.objeto_solicitud.value) == "NO"  || characterCount(forma.objeto_solicitud.value,20) != "" ) {
            msg = msg + "*  Digite el Objeto de la Solicitud\n" + characterCount(forma.objeto_solicitud.value,20);
            forma.objeto_solicitud.className = "textarea_faltantes";
        } else {
            forma.objeto_solicitud.className = "";
        }


        if (valida_texto_espacios(forma.objeto_contrato.value) == "NO" || characterCount(forma.objeto_contrato.value,20) != "") {
            msg = msg + "*  Digite el Objeto del Contrato\n"+characterCount(forma.objeto_contrato.value,20);
            forma.objeto_contrato.className = "textarea_faltantes";
        } else {
            forma.objeto_contrato.className = "";
        }


if(forma.id_tipo_contratacion.value == "1"){
    if ((valida_texto_espacios(forma.alcance.value) == "NO" || characterCount(forma.alcance.value,20) != "") && forma.tipo_proceso.value != 8) {
            msg = msg + "*  Digite el Alcance\n"+characterCount(forma.alcance.value,20);
            forma.alcance.className = "textarea_faltantes";
        } else {
            forma.alcance.className = "";
        }
}

        if (valida_texto_espacios(forma.justificacion2.value) == "NO" || characterCount(forma.justificacion2.value,20) != "") {
            msg = msg + "*  Digite la Justificación Técnica\n"+characterCount(forma.justificacion2.value,20);
            forma.justificacion2.className = "textarea_faltantes";
        } else {
            forma.justificacion2.className = "";
        }
        if (valida_texto_espacios(forma.recomendacion.value) == "NO" || characterCount(forma.recomendacion.value,20) != "") {
            msg = msg + "*  Digite la Recomendación\n"+characterCount(forma.recomendacion.value,20);
            forma.recomendacion.className = "textarea_faltantes";
        } else {
            forma.recomendacion.className = "";
        }
   /* Criterios de Evaluacion*/
        if ((valida_texto_espacios(forma.criterios_evaluacion.value) == "NO" || characterCount(forma.criterios_evaluacion.value,20) != "") && forma.tipo_proceso.value != 8) {
            msg = msg + "* Digite los Criterios de Evaluacion\n"+characterCount(forma.criterios_evaluacion.value,20)
            forma.criterios_evaluacion.className = "textarea_faltantes";
        } else {
            forma.criterios_evaluacion.className = "";
        }

        if ((valida_texto_espacios(forma.proveedores_sugeridos.value) == "NO" || characterCount(forma.proveedores_sugeridos.value,20) != "") && forma.tipo_proceso.value != 8 && forma.tipo_proceso.value != 7) {
            msg = msg + "* Digite los proveedores Sugeridos\n"+characterCount(forma.proveedores_sugeridos.value,20)
            forma.proveedores_sugeridos.className = "textarea_faltantes";
        } else {
            forma.proveedores_sugeridos.className = "";
        }

/*OBJETIVOS DEL PROCESO*/

if(forma.tipo_proceso.value== 1 || forma.tipo_proceso.value== 2 || forma.tipo_proceso.value== 3 || forma.tipo_proceso.value== 5 || forma.tipo_proceso.value== 7 || forma.tipo_proceso.value== 15 || forma.tipo_proceso.value== 6){
		if (valida_texto_espacios(forma.campos1.value) == "NO"  || characterCount(forma.campos1.value,20) != "" ) {
            msg = msg + "*  Digitar la oportunidad\n" + characterCount(forma.campos1.value,20);
            forma.campos1.className = "textarea_faltantes";
        } else {
            forma.campos1.className = "";
        }
		if (valida_texto_espacios(forma.campos3.value) == "NO"  || characterCount(forma.campos3.value,20) != "" ) {
            msg = msg + "*  Digite la Calidad\n" + characterCount(forma.campos3.value,20);
            forma.campos3.className = "textarea_faltantes";
        } else {
            forma.campos3.className = "";
        }
        if (valida_texto_espacios(forma.campos4.value) == "NO"  || characterCount(forma.campos4.value,20) != "" ) {
            msg = msg + "*  Digite Gestión de Entorno\n" + characterCount(forma.campos4.value,20);
            forma.campos4.className = "textarea_faltantes";
        } else {
            forma.campos4.className = "";
        }
        if (valida_texto_espacios(forma.campos5.value) == "NO"  || characterCount(forma.campos5.value,20) != "" ) {
            msg = msg + "*  Digite Trazabilidad\n" + characterCount(forma.campos5.value,20);
            forma.campos5.className = "textarea_faltantes";
        } else {
            forma.campos5.className = "";
        }
        if (valida_texto_espacios(forma.campos6.value) == "NO"  || characterCount(forma.campos6.value,20) != "" ) {
            msg = msg + "*  Digite Transparencia\n" + characterCount(forma.campos6.value,20);
            forma.campos6.className = "textarea_faltantes";
        } else {
            forma.campos6.className = "";
        }
        if (valida_texto_espacios(forma.campos7.value) == "NO"  || characterCount(forma.campos7.value,20) != "" ) {
            msg = msg + "*  Digite Agilidad\n" + characterCount(forma.campos7.value,20);
            forma.campos7.className = "textarea_faltantes";
        } else {
            forma.campos7.className = "";
        }
}
/*FIN OBJETIVOS DEL PROCESO*/
    }// fin si es poner en firme

    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
		if(advertencia !=""){
		muestra_alerta_general_solo_texto('', 'Advertencia', advertencia, 40, 5, 12)
		}

        if (tipo == 1) {
        //    var alerta = confirm("Esta seguro de Grabar este ITEM Temporalmente?")
        }
        if (tipo == 2) {
         //   var alerta = confirm("Esta seguro de Grabar este ITEM y Poner en Firme?")
        }
       // if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.tipo_graba.value = tipo
            forma.accion.value = "graba_presupuesto_item"
            forma.target = "grp"
            forma.submit()
        //}
    }
}

/* Funcion cuenta caracteres*/

function characterCount(content,count){
    var msj = "";
    if (content.length < count) {
        msj = ", El campo debe contener minimo "+count+" caracteres.\n";
    }
    return msj;
}

function carga_formulario_pecc_item(id_pecc_seleccion, id_tipo_proceso_pecc) {
    if (id_tipo_proceso_pecc == 1) {
        ajax_carga("../aplicaciones/pecc/formulario-solicitud-pecc.php?id_pecc=" + id_pecc_seleccion + '&id_tipo_proceso_pecc=' + id_tipo_proceso_pecc, "carga_formulario")
    }
    if (id_tipo_proceso_pecc == 2) {
        ajax_carga("../aplicaciones/pecc/busca-amplia-pecc.php?id_pecc=" + id_pecc_seleccion + '&id_tipo_proceso_pecc=' + id_tipo_proceso_pecc, "carga_formulario")
    }
    if (id_tipo_proceso_pecc == 3) {

    }

}
function carga_ajax(valor, tipo_ajax) {
    if (tipo_ajax == 1) {
        if (valor == 7) {
//			alert(1)
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=1&valor=7', 'carga_otrosi')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=2&valor=2', 'carga_ot')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=4&valor=7', 'carga_tipo_proceso')
        } else {
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=1&valor=' + valor, 'carga_otrosi')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=2&valor=9999', 'carga_ot')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=4&valor=' + valor, 'carga_tipo_proceso')
        }
    }

    if (tipo_ajax == 2) {
        if (valor == 2) {
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=1&valor=7', 'carga_otrosi')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=2&valor=2', 'carga_ot')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=4&valor=7', 'carga_tipo_proceso')
        } else {
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=2&valor=1', 'carga_ot')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=1&valor=9999', 'carga_otrosi')
            ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=5&valor=7', 'carga_tipo_proceso')
        }
    }
}

function eliminar_presupuesto_adjudica_marco(id_presupuesto) {
    var forma = document.principal
    forma.id_presupuesto_elimina.value = id_presupuesto
   // var alerta = confirm("Esta seguro de Eliminar este Valor de la Adjudicacón?")
    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_presupuesto_adjudica_marco"
        forma.target = "grp"
        forma.submit()
    //}

}

function eliminar_presupuesto_adjudica_proveedor_marco(id_presupuesto) {
    var forma = document.principal
    forma.id_presupuesto_elimina.value = id_presupuesto
    //var alerta = confirm("Esta seguro de Eliminar este Proveedor?")
    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_presupuesto_adjudica_proveedor_marco"
        forma.target = "grp"
        forma.submit()
    //}

}

function eliminar_presupuesto_adjudica(id_presupuesto) {
    var forma = document.principal
    forma.id_presupuesto_elimina.value = id_presupuesto
    //var alerta = confirm("Esta seguro de Eliminar este Valor de la Adjudicacón?")
    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_presupuesto_adjudica"
        forma.target = "grp"
        forma.submit()
    //}

}

function eliminar_presupuesto(id_presupuesto) {
    var forma = document.principal
    forma.id_presupuesto_elimina.value = id_presupuesto
   // var alerta = confirm("Esta seguro de Eliminar este Valor de la Solicitud?")
    //if (alerta) {
        window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "elimina_presupuesto"
        forma.target = "grp"
        forma.submit()
    //}

}
function graba_presupuesto_edita() {
    var forma = document.principal
    var msg = ""

    if (forma.aplica_contrato_edita.value == "") {
        msg = msg + "* Seleccione el ó los contratos a los cuales aplica esta solicitud\n"
        forma.aplica_contrato_edita.className = "select_faltantes";
    } else {
        forma.aplica_contrato_edita.className = "";
    }

    if (forma.ano_edita.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano_edita.className = "select_faltantes";
    } else {
        forma.ano_edita.className = "";
    }
    if (forma.campo_edita.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo_edita.className = "select_faltantes";
    } else {
        forma.campo_edita.className = "";
    }
    /*if(forma.valor_usd_edita.value+forma.valor_cop_edita.value<=0){
     msg = msg + "* Digite el Valor en USD o COP\n"
     forma.valor_usd_edita.className = "campos_faltantes";		
     }else{
     forma.valor_usd_edita.className = "";
     }
     */


    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta seguro de Grabar los cambios de este Presupuesto?")
        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_edita"
            forma.target = "grp"
            forma.submit()
        }
    }
}

function graba_presupuesto_nuevo_edicion_adjudicacion_marco() {
    var forma = document.principal
    var msg = ""

    forma.tipo_documento.value == 2

	
    if (forma.ano.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano.className = "select_faltantes";
    } else {
        forma.ano.className = "";
    }
    if (forma.campo.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo.className = "select_faltantes";
    } else {
        forma.campo.className = "";
    }
    if (forma.valor_usd.value == "" && forma.valor_cop.value == "") {
        msg = msg + "* Digite el Valor en USD o COP\n"
        forma.valor_usd.className = "campos_faltantes";
    } else {
        forma.valor_usd.className = "";
    }



    if (msg != "") {
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
       // alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        //var alerta = confirm("Esta seguro de Grabar este Valor?")
        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo_edita_adjudica_marco"
            forma.target = "grp"
            forma.submit()
        //}
    }
}

function graba_presupuesto_nuevo_edicion_adjudicacion_proveedor_marco() {
    var forma = document.principal
    var msg = ""
if (forma.sele_proveedor.value == "") {
        msg = msg + "* Seleccione o digite el proveedor al cual se le adjudicara\n"
        forma.sele_proveedor.className = "select_faltantes";
    } else {
        forma.sele_proveedor.className = "";
    }
	
    if (forma.sele_proveedor.value == 99) {
        if (forma.proveedores_busca.value == "" && forma.nom3.value == "") {
            msg = msg + "* Seleccione o digite el proveedor al cual se le adjudicara\n"
            forma.proveedores_busca.className = "campos_faltantes";
        } else {
            forma.proveedores_busca.className = "";
        }
    }

    if (forma.tipo_documento.value == 0) {
        msg = msg + "* Seleccione el tipo de documento\n"
        forma.tipo_documento.className = "select_faltantes";
    } else {
        forma.tipo_documento.className = "";
    }
    if (forma.vigencia_mes.value == 0 || forma.vigencia_mes.value == "") {
        msg = msg + "* Digite la vigencia en meses\n"
        forma.vigencia_mes.className = "campos_faltantes";
    } else {
        forma.vigencia_mes.className = "";
    }
	
 if (forma.complemento_num_contra.value == "0") {
        msg = msg + "* Seleccione si el contrato sera de bienes o de servicios\n"
        forma.complemento_num_contra.className = "select_faltantes";
    } else {
        forma.complemento_num_contra.className = "";
    }


    if (msg != "") {
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
       // alert("Verifique el formulario\n\n" + msg)
        return
    } else {
		muestra_alerta_iformativa_solo_texto('', 'Advertencia', 'Asegúrese que este proveedor adjudicado, fue aprobado previamente para participar en el proceso', 40, 5, 12)
       // var alerta = confirm("Esta seguro de Grabar este proveedor?")
        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo_edita_adjudica_proveedor_marco"
            forma.target = "grp"
            forma.submit()
        //}
    }
}

function graba_presupuesto_nuevo_edicion_adjudicacion() {
    var forma = document.principal
    var msg = ""

    if (forma.sele_proveedor.value == "") {
        msg = msg + "* Seleccione o digite el proveedor al cual se le adjudicara\n"
        forma.sele_proveedor.className = "select_faltantes";
    } else {
        forma.sele_proveedor.className = "";
    }
	
	 if (forma.complemto_contrato.value == "0") {
        msg = msg + "* Seleccione si el contrato sera de bienes o de servicios\n"
        forma.complemto_contrato.className = "select_faltantes";
    } else {
        forma.complemto_contrato.className = "";
    }

    if (forma.sele_proveedor.value == 99) {
        if (forma.proveedores_busca.value == "" && forma.nom3.value == "") {
            msg = msg + "* Seleccione o digite el proveedor al cual se le adjudicara\n"
            forma.proveedores_busca.className = "campos_faltantes";
        } else {
            forma.proveedores_busca.className = "";
        }
    }

    if (forma.tipo_documento.value == 0) {
        msg = msg + "* Seleccione el tipo de documento\n"
        forma.tipo_documento.className = "select_faltantes";
    } else {
        forma.tipo_documento.className = "";
    }
    if (forma.vigencia_mes.value == 0 || forma.vigencia_mes.value == "") {
        msg = msg + "* Digite la vigencia en meses\n"
        forma.vigencia_mes.className = "campos_faltantes";
    } else {
        forma.vigencia_mes.className = "";
    }
    if (forma.ano.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano.className = "select_faltantes";
    } else {
        forma.ano.className = "";
    }
    if (forma.campo.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo.className = "select_faltantes";
    } else {
        forma.campo.className = "";
    }
    if (forma.valor_usd.value == "" && forma.valor_cop.value == "") {
        msg = msg + "* Digite el Valor en USD o COP\n"
        forma.valor_usd.className = "campos_faltantes";
    } else {
        forma.valor_usd.className = "";
    }



    if (msg != "") {
		 muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
       // alert("Verifique el formulario\n\n" + msg)
        return
    } else {
		muestra_alerta_iformativa_solo_texto('', 'Advertencia', 'Asegúrese que este proveedor adjudicado, fue aprobado previamente para participar en el proceso', 40, 5, 12)
        //var alerta = confirm("Esta seguro de Grabar este Presupuesto?")
        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo_edita_adjudica"
            forma.target = "grp"
            forma.submit()
        //}
    }
}
function graba_reembolsable(id){
    var forma = document.principal
    var msg = "";
    var variable='valor'+id;
    var ano='ano'+id;
    if ($('#valor'+id).val()==''){
        msg=msg+'El valor del año '+$('#ano'+id).val()+' no contiene ningún valor\n';
        $('#ano'+id).addClass('campos_faltantes')
    }
    if(msg!=''){
        alert('Verifique el formulario\n'+msg)
    }else{
        //alert($('#valor'+id).val())
        forma.valor_ano.value=""+$('#ano'+id).val()
        forma.valor_valor.value=""+$('#valor'+id).val()
        if ($('#razon'+id).val()!="") {
            forma.valor_razon_social.value=""+$('#razon'+id).val()
        }else{
            forma.valor_razon_social.value=""
        }
        //window.parent.document.getElementById("cargando_pecc").style.display = "block"
        forma.action = "procesos-pecc.html";
        forma.accion.value = "graba_reembolsable"
        forma.target = "grp"
        forma.submit()
    }
}
function graba_presupuesto_nuevo() {
    var forma = document.principal
    var msg = ""

    if (forma.aplica_contrato.value == "") {
        msg = msg + "* Seleccione el ó los contratos a los cuales aplica esta solicitud\n"
        forma.aplica_contrato.className = "select_faltantes";
    } else {
        forma.aplica_contrato.className = "";
    }

/*para que lo busque despues*/
    if (forma.id_tipo_contratacion.value == 4) {/*

        if (forma.cargo_cota_presu.value == "") {
            msg = msg + "* Digite el cargo contable\n"
            forma.cargo_cota_presu.className = "campos_faltantes";
        }
        else {
            forma.cargo_cota_presu.className = "";
        }
    */}
	
	if (forma.tipo_proceso.value == 8) {
			if(forma.solicitud_aplica_ots.value == "" ){
			 	msg = msg + "* Seleccione la solicitud a la cual desea cargar la Orden de trabajo\n"
            	forma.solicitud_aplica_ots.className = "select_faltantes";
        	}else {
            	forma.solicitud_aplica_ots.className = "";
        	}
		
	}
		
			
	if (forma.tipo_proceso.value == 12) {

        if (forma.valor_usd.value > 0) {
            msg = msg + "* Para solicitudes de tipo (Reclasificacion) el valor USD debe ser 0 (cero)\n"
            forma.valor_usd.className = "campos_faltantes";
        }
        else {
            forma.valor_usd.className = "";
        }
		if (forma.valor_cop.value > 0) {
            msg = msg + "* Para solicitudes tipo (Reclasificacion) el valor COP debe ser 0 (cero)\n"
            forma.valor_cop.className = "campos_faltantes";
        }
        else {
            forma.valor_cop.className = "";
        }
    }
	

    if (forma.ano.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano.className = "select_faltantes";
    } else {
        forma.ano.className = "";
    }
    if (forma.campo.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo.className = "select_faltantes";
    } else {
        forma.campo.className = "";
    }

    /*if(forma.valor_usd.value+forma.valor_cop.value<=0){
     msg = msg + "* Digite el Valor en USD o COP\n"
     forma.valor_usd.className = "campos_faltantes";		
     }else{
     forma.valor_usd.className = "";
     }
     */



    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta seguro de Grabar este Presupuesto?")
        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo"
            forma.target = "grp"
            forma.submit()
        }
    }
}
function graba_presupuesto_nuevo_2() {
    var forma = document.principal
    var msg = ""

    if (forma.aplica_contrato2.value == "") {
        msg = msg + "* Seleccione el ó los contratos a los cuales aplica esta solicitud\n"
        forma.aplica_contrato2.className = "select_faltantes";
    } else {
        forma.aplica_contrato2.className = "";
    }



    if (forma.ano2.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano2.className = "select_faltantes";
    } else {
        forma.ano2.className = "";
    }
    if (forma.campo2.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo2.className = "select_faltantes";
    } else {
        forma.campo2.className = "";
    }

    /*if(forma.valor_usd.value+forma.valor_cop.value<=0){
     msg = msg + "* Digite el Valor en USD o COP\n"
     forma.valor_usd.className = "campos_faltantes";		
     }else{
     forma.valor_usd.className = "";
     }
     */



    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta seguro de Grabar este Presupuesto?")
        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo2"
            forma.target = "grp"
            forma.submit()
        }
    }
}


function graba_presupuesto_nuevo_edicion_ini_contrato() {
    var forma = document.principal
    var msg = ""



    if (forma.ano2.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano2.className = "select_faltantes";
    } else {
        forma.ano2.className = "";
    }
    if (forma.campo2.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo2.className = "select_faltantes";
    } else {
        forma.campo2.className = "";
    }
	if (forma.aplica_contrato2.value == "") {
        msg = msg + "* Seleccione el contrato\n"
        forma.aplica_contrato2.className = "select_faltantes";
    } else {
        forma.aplica_contrato2.className = "";
    }
	if(forma.proveedores_busca_adjudicacion_sm){
		if (forma.proveedores_busca_adjudicacion_sm.value == "") {
        msg = msg + "* Seleccione el Proveedor Adjudicado\n"
        forma.proveedores_busca_adjudicacion_sm.className = "select_faltantes";
    } else {
        forma.proveedores_busca_adjudicacion_sm.className = "";
    }
		
	}
	
    /*if(forma.valor_usd.value == "" && forma.valor_cop.value == ""){
     msg = msg + "* Digite el Valor en USD o COP\n"
     forma.valor_usd.className = "campos_faltantes";		
     }else{
     forma.valor_usd.className = "";
     }
     */


    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
//        var alerta = confirm("Esta seguro de Grabar este Presupuesto?")
  //      if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo_edita_contrato_ini"
            forma.target = "grp"
            forma.submit()
    //    }
    }
}


function graba_presupuesto_nuevo_edicion() {
    var forma = document.principal
    var msg = ""

    if (forma.id_tipo_proceso_pecc.value == 2 || forma.id_tipo_proceso_pecc.value == 3) {
        if (forma.aplica_contrato.value == "") {
            msg = msg + "* Seleccione el ó los contratos a los cuales aplica esta solicitud\n"
            forma.aplica_contrato.className = "select_faltantes";
        } else {
            forma.aplica_contrato.className = "";
        }
    }
	if (forma.id_tipo_proceso_pecc.value == 3) {
			if(forma.solicitud_aplica_ots.value == "" ){
			 	msg = msg + "* Seleccione la solicitud a la cual desea cargar la Orden de trabajo\n"
            	forma.solicitud_aplica_ots.className = "select_faltantes";
        	}else {
            	forma.solicitud_aplica_ots.className = "";
        	}
		
	}
/*para que lo busque despues*/
    if (forma.id_tipo_contratacion.value == 4) {/*

        if (forma.cargo_cota_presu.value == "") {
            msg = msg + "* Digite el cargo contable\n"
            forma.cargo_cota_presu.className = "campos_faltantes";
        }
        else {
            forma.cargo_cota_presu.className = "";
        }
    */}
	
	if (forma.tipo_proceso.value == 12 && forma.reclasificacion_marco.value !=3) {
		

        if (forma.valor_usd.value != 0 && forma.valor_usd.value != '') {
            msg = msg + "* Para solicitudes tipo (Reclasificacion) el valor USD debe ser 0 (cero)\n"
            forma.valor_usd.className = "campos_faltantes";
        }
        else {
            forma.valor_usd.className = "";
        }
		if (forma.valor_cop.value != 0 && forma.valor_cop.value != '') {
            msg = msg + "* Para solicitudes tipo (Reclasificacion) el valor COP debe ser 0 (cero)\n"
            forma.valor_cop.className = "campos_faltantes";
        }
        else {
            forma.valor_cop.className = "";
        }
    }

    if (forma.ano.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano.className = "select_faltantes";
    } else {
        forma.ano.className = "";
    }
    if (forma.campo.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo.className = "select_faltantes";
    } else {
        forma.campo.className = "";
    }
    /*if(forma.valor_usd.value == "" && forma.valor_cop.value == ""){
     msg = msg + "* Digite el Valor en USD o COP\n"
     forma.valor_usd.className = "campos_faltantes";		
     }else{
     forma.valor_usd.className = "";
     }
     */


    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
//        var alerta = confirm("Esta seguro de Grabar este Presupuesto?")
  //      if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_presupuesto_nuevo_edita"
            forma.target = "grp"
            forma.submit()
    //    }
    }
}



function graba_devolucion() {
    var forma = document.principal
    var msg = ""

    if (forma.aplica_contrato.value == "") {
        msg = msg + "* Seleccione el ó los contratos a los cuales aplica esta solicitud\n"
        forma.aplica_contrato.className = "select_faltantes";
    } else {
        forma.aplica_contrato.className = "";
    }

    if (forma.file1.value == "") {
        msg = msg + "* Seleccione el Anexo\n"
        forma.file1.className = "campos_faltantes";
    } else {
        forma.file1.className = "";
    }

    if (forma.ano.value == 0) {
        msg = msg + "* Seleccione el Año\n"
        forma.ano.className = "select_faltantes";
    } else {
        forma.ano.className = "";
    }
    if (forma.campo.value == "") {
        msg = msg + "* Seleccione el Área\n"
        forma.campo.className = "select_faltantes";
    } else {
        forma.campo.className = "";
    }
    if (forma.valor_usd.value + forma.valor_cop.value <= 0) {
        msg = msg + "* Digite el Valor en USD o COP\n"
        forma.valor_usd.className = "campos_faltantes";
    } else {
        forma.valor_usd.className = "";
    }



    if (msg != "") {
        alert("Verifique el formulario\n\n" + msg)
        return
    } else {
        var alerta = confirm("Esta seguro de Devolver este Presupuesto?")
        if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.action = "procesos-pecc.html";
            forma.accion.value = "devolucion_presupuesto"
            forma.target = "grp"
            forma.submit()
        }
    }
}




function graba_anexo_edicion(tipo, id_item_comite) {
    var forma = document.principal
    var msg = ""


if (tipo == 20) {
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un archivo anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de grabar esta gestion?";
    }
	
    if (tipo == 19) {

        forma.id_item_pecc.value = id_item_comite
        texto_mensaje = "Esta seguro de grabar este anexo?";
    }

    if (tipo == 18) {
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un archivo anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este anexo?";
    }

    if (tipo == 17) {
		if(forma.ct_anexo.value == 0){
			msg = msg + "* Seleccione la categoria del anexo\n"
            forma.ct_anexo.className = "select_faltantes";
			}
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un archivo anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este anexo?";
    }

    if (tipo == 14) {
		if(forma.ct_anexo.value == 0){
			msg = msg + "* Seleccione la categoria del anexo\n"
            forma.ct_anexo.className = "select_faltantes";
			}
			
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un archivo anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este anexo?";
    }

    if (tipo == 13) {
        if (forma.doc_ensamble.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.doc_ensamble.className = "campos_faltantes";
        } else {
            forma.doc_ensamble.className = "";
        }
        if (forma.adj_doc_ensamble.value == "") {
            msg = msg + "* Seleccione un archivo documento\n"
            forma.adj_doc_ensamble.className = "campos_faltantes";
        } else {
            forma.adj_doc_ensamble.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este documento?";
    }
    if (tipo == 12) {
        if (forma.doc_basico.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.doc_basico.className = "campos_faltantes";
        } else {
            forma.doc_basico.className = "";
        }
        if (forma.adj_doc_basico.value == "") {
            msg = msg + "* Seleccione un archivo documento\n"
            forma.adj_doc_basico.className = "campos_faltantes";
        } else {
            forma.adj_doc_basico.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este documento?";

    }
    if (tipo == 11) {
        if (forma.doc_ensamble.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.doc_ensamble.className = "campos_faltantes";
        } else {
            forma.doc_ensamble.className = "";
        }
        if (forma.adj_doc_ensamble.value == "") {
            msg = msg + "* Seleccione un archivo documento\n"
            forma.adj_doc_ensamble.className = "campos_faltantes";
        } else {
            forma.adj_doc_ensamble.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este documento?";
    }
    if (tipo == 10) {
        if (forma.doc_basico.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.doc_basico.className = "campos_faltantes";
        } else {
            forma.doc_basico.className = "";
        }
        if (forma.adj_doc_basico.value == "") {
            msg = msg + "* Seleccione un archivo documento\n"
            forma.adj_doc_basico.className = "campos_faltantes";
        } else {
            forma.adj_doc_basico.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este documento?";
    }

    if (tipo == 8) {
		if(forma.ct_anexo.value == 0){
			msg = msg + "* Seleccione la categoria del anexo\n"
            forma.ct_anexo.className = "select_faltantes";
			}
			
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un archivo anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este anexo?";
    }

    if (tipo == 9) {
        if (forma.ancedente.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.ancedente.className = "campos_faltantes";
        } else {
            forma.ancedente.className = "";
        }

        texto_mensaje = "Esta seguro de grabar este antecedente?";
    }
    if (tipo == 15) {
        if (forma.comunicados.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.comunicados.className = "campos_faltantes";
        } else {
            forma.comunicados.className = "";
        }

        texto_mensaje = "Esta seguro de grabar y enviar e-mail?";
    }

    if (tipo == 16) {
        if (forma.comunicados.value == 0) {
            msg = msg + "* Digite un detalle\n"
            forma.comunicados.className = "campos_faltantes";
        } else {
            forma.comunicados.className = "";
        }

        texto_mensaje = "Esta seguro de grabar esta observacion?";
    }

    if (msg != "") {
        //alert("Verifique el formulario\n\n" + msg)
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
       // var alerta = confirm(texto_mensaje)
        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.tipo_anexo.value = tipo
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_anexo_nuevo_edicion"
            forma.target = "grp"
            forma.submit()
        //}
    }
}

function graba_anexo(tipo) {
    var forma = document.principal
    var msg = ""

    if (tipo == 8) {
		if(forma.ct_anexo.value == 0){
			msg = msg + "* Seleccione la categoria del anexo\n"
            forma.ct_anexo.className = "select_faltantes";
			}
			
        if (forma.anexo.value == 0) {
            msg = msg + "* Digite un Detalle\n"
            forma.anexo.className = "campos_faltantes";
        } else {
            forma.anexo.className = "";
        }
        if (forma.adj_anexo.value == "") {
            msg = msg + "* Seleccione un Archivo Anexo\n"
            forma.adj_anexo.className = "campos_faltantes";
        } else {
            forma.adj_anexo.className = "";
        }

        texto_mensaje = "Esta seguro de Grabar este Anexo?";
    }

    if (tipo == 9) {
        if (forma.ancedente.value == 0) {
            msg = msg + "* Digite un Detalle\n"
            forma.ancedente.className = "campos_faltantes";
        } else {
            forma.ancedente.className = "";
        }

        texto_mensaje = "Esta seguro de Grabar este Antecedente?";
    }

    if (msg != "") {
        muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 5, 12)
        return
    } else {
      //  var alerta = confirm(texto_mensaje)
        //if (alerta) {
            window.parent.document.getElementById("cargando_pecc").style.display = "block"
            forma.tipo_anexo.value = tipo
            forma.action = "procesos-pecc.html";
            forma.accion.value = "graba_anexo_nuevo"
            forma.target = "grp"
            forma.submit()
        //}
    }
}
/*
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
	
	window.parent.muestra_alerta_iformativa_solo_texto( '','* Digite el detalle de la pregunta', 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
	
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 60, 5, 10)

	muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_admin_continua()', 'Advertencia', 'Esta a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
	
	window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El Contrato se Grabó con Exito', 20, 10, 18);
*/
//function envia_email_solicitudes(id_item) {
//
//    var alerta = confirm("Esta seguro de enviar por correo electronico?");
//    if (alerta) {
//        $.ajax({
//            data: {
//                "id_item": id_item
//            },
//            type: "GET",
//            url: "../librerias/php/mail_pecc.php",
//            beforeSend: function(xhr) {
//                // Loading
//            },
//            success: function(data) {
//                alert("El mensaje se ha enviado con exito.");
//            }
//        });
//
//    }
//}