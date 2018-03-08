var nav4 = window.Event ? true : false;
function acceptNum(evt){	
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
var key = nav4 ? evt.which : evt.keyCode;	
return (key <= 13 || (key >= 48 && key <= 57));
}	


function acceptNum_punto(e, campo){	
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
/*var key = nav4 ? evt.which : evt.keyCode;
var largo = campo.length
var busca_punto = campo.indexOf(".");
if(busca_punto>=0)
return (key <= 13 || (key >= 48 && key <= 57));
else
return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
*/
var tecla;
 tecla = (document.all) ? e.keyCode : e.which;

if(tecla == 8)
 {return true;}
 var patron;
 var largo = campo.length
	var busca_punto = campo.indexOf(".");
	if(busca_punto=="-1")
	 patron = /[.0123456789]/
	else 
	patron = /[0123456789]/
	// patron = /\d/; //solo acepta numeros
// patron = /\d/; //solo acepta numeros
 var te;
 te = String.fromCharCode(tecla);
 return patron.test(te);


}	

function anexa_documento_2()
	{
		var forma = document.principal;
		if(forma.sube_archivo.value=="")
			{
				//alert("Seleccione un documento")
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un documento', 20, 10, 18)
				return;
			}
		else{
				forma.action = "procesos_proveedor.html";
				forma.accion.value="anexo_invitacion_proveedor"
				forma.target="grp";
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";
		
		}
}

function elimina_anexo_admin2(id_anexo)
{
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_proveedor";
	forma.id_anexo.value=id_anexo;
	forma.submit()
	//muestra_alerta_general_solo_texto('elimina_anexo_admin2_continua()', 'Advertencia', 'Esta seguro de eliminar este anexo ¿está seguro?', 20, 10, 18)
}
/*function elimina_anexo_admin2_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_proveedor";
		forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}	*/
function confirma_partici(id_anexo)
{
	//muestra_alerta_general_solo_texto('confirma_partici_continua()', 'Advertencia', '¿Está seguro enviar la confirmación?', 20, 10, 18)
	var forma = document.principal;
	forma.id_anexo.value = id_anexo;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="confirma_participa";
	forma.submit()
}	
/*function confirma_partici_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="confirma_participa";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}	*/
	
function agrega_info_tecica()
{
	var forma = document.principal;
	if((forma.sube_archivo.value =="") && (forma.observaciones.value=="")){
	muestra_alerta_error_solo_texto('', 'Error', '* Anexe o digite un comentario de oferta para este criterio', 20, 10, 18)
	//alert("ALERTA: Anexe o digite un comentario de oferta para este criterio")
	return;
		}
	else
		{
			forma.target="grp";
			forma.action = "procesos_proveedor.html";
			forma.accion.value="agrega_tecnica";
			forma.submit()
			//muestra_alerta_general_solo_texto('agrega_info_tecica_continua()', 'Advertencia', '¿Esta seguro de agregar esta oferta al criterio?', 20, 10, 18)

		}
}
/*function agrega_info_tecica_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="agrega_tecnica";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function elimina_anexo_tecnico(id_anexo)
{
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_tecnico";
	forma.submit()
	forma.id_anexo.value = id_anexo;
	//muestra_alerta_general_solo_texto('elimina_anexo_tecnico_continua()', 'Advertencia', '¿Esta seguro de eliminar este anexo?', 20, 10, 18)
}
/*function elimina_anexo_tecnico_continua(){
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_tecnico";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";	
}	*/
	
function cambia_contrasena()
{

	var forma = document.principal;
	var msg ="";			

	if(forma.usuario_pro.value==""){
		msg = msg + "* E-mail (Usuario principal)\n"
		forma.usuario_pro.className = "select_faltantes";		
	}

	if(forma.telefono_pro.value==""){
		msg = msg + "* Teléfono de Contacto\n"
		forma.telefono_pro.className = "select_faltantes";		
	}

	if(msg!="")
		{
muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
			//alert("Verifique el formulario\n" + msg)
			return
			}
	else
		{ //si no tiene errores
			if(forma.conta_1.value==forma.conta_2.value){
			forma.target="grp";
			forma.action = "procesos_proveedor.html";
			forma.accion.value="cambia_contrasena_1";
			forma.submit()
			//window.parent.document.getElementById("cargando").style.display="";
			}
			else
			{
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
	forma.action = "procesos_proveedor.html";
	forma.accion.value="cambia_contrasena_1";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	}
	else
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Las contraseñas no coiciden', 20, 10, 18)
		//alert("Las contraseñas no coiciden")
		return
	}
}*/		

function crea_sub_usuario_j()
{
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
	if(msg!="")
	{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
		//alert("Verifique el formulario\n" + msg)
		return
	}
	else
		{
	forma.action = "procesos_proveedor.html";
	forma.accion.value="crea_sub_usuario"
	forma.target="grp"
	forma.submit()
	window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
		//muestra_alerta_general_solo_texto('crea_sub_usuario_j_continua()', 'Advertencia', '¿Esta seguro de crear este proceso?', 20, 10, 18)
	
		}
}
/*function crea_sub_usuario_j_continua(){
	var forma = document.principal
	forma.action = "procesos_proveedor.html";
	forma.accion.value="crea_sub_usuario"
	forma.target="grp"
	forma.submit()
	window.parent.document.getElementById("cargando").style.display=""
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
		//alert("digite el nombre")
		return;
		}
	if(b.value=="")
		{
			
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el E-mail', 20, 10, 18)
		//alert("Digite el E-mail")
		return;
		}

	if(c.value=="")
		{
			muestra_alerta_error_solo_texto('', 'Error', '* Digite el teléfono', 20, 10, 18)
		//alert("Digite el teléfono")
		return;
		}		
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "procesos_proveedor.html";
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
			forma.action = "procesos_proveedor.html";
			forma.accion.value="cambia_con_subusuario";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	
	
	
function elimina_usuario(id_requerimiento)
{
	var forma = document.principal
	forma.campo_id.value = id_requerimiento;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
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
	forma.action = "procesos_proveedor.html";
	forma.accion.value="elimina_usuario";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}*/
function ver_respuestas(muestra)
{
	var forma = document.principal
	
	if(forma.ocu_re.value!=""){
		document.getElementById(forma.ocu_re.value).style.display = 'none';
	}
	
	document.getElementById(muestra).style.display = '';
	forma.ocu_re.value = muestra
	
	}	

function oculat_respuestas(oculta)
{
		var forma = document.principal
	document.getElementById(oculta).style.display = 'none';
	forma.ocu_re.value = ""
	
	}	
	
	
function crea_pregunta_general_cartelera()
{
var forma = document.principal
	if(forma.pregunta_general.value=="")
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
		//alert("Digite el detalle de la pregunta")
		return;
	}
	if(forma.tipo_aclaracion_solicitada.value=="0")
	{
			muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el tipo de aclaracion', 20, 10, 18)
			//alert("Seleccione el tipo de aclaracion")
			return;

	}else{
		forma.target="grp";
		forma.action = "procesos_proveedor.html";
		forma.accion.value="crea_pregunta_general";
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display="";
		forma.campo_id.value = "";
		forma.target="";
		forma.action = "";
		forma.accion.value="";
		//muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_continua()', 'Advertencia', 'Esta a punto de enviar esta aclaración ¿esta seguro?', 20, 10, 18)
	}
}
/*function crea_pregunta_general_cartelera_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="crea_pregunta_general";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}*/
function crea_pregunta_general_cartelera_foro(id_pru, valica)
{
	var forma = document.principal		
	if(valica.value=="")
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
		//alert("Digite el detalle de la pregunta")
		return;

	}else{
		forma.id_anexo.value=id_pru
		forma.target="grp";
		forma.action = "procesos_proveedor.html";
		forma.accion.value="crea_pregunta_general_foro";
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display="";
		forma.campo_id.value = "";
		forma.target="";
		forma.action = "";
		forma.accion.value="";
		//muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_foro_continua()', 'Advertencia', 'Esta a punto de enviar esta aclaración ¿esta seguro?', 20, 10, 18)
	}
}			
/*function crea_pregunta_general_cartelera_foro_continua(){
	var forma = document.principal
	forma.id_anexo.value=id_pru
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="crea_pregunta_general_foro";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}*/
function sube_archivo(){
var forma = document.principal
			forma.target="grp";
			forma.action = "../aplicaciones/proveedores/sube_plantilla_proveedor.php";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";
}



function crea_ofertas()
{
	var forma = document.principal;
	forma.target="grp";
	forma.action = "../solicitudes-en-proceso/procesos_proveedor_economica.html";
	forma.accion.value="c_invitacion_economica";
	forma.submit()
	//muestra_alerta_general_solo_texto('crea_ofertas_continua()', 'Advertencia', 'Esta apunto de enviar la oferta económica de los artículos de esta página únicamente ¿esta seguro?', 20, 10, 18)
	
}	
/*function crea_ofertas_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../solicitudes-en-proceso/procesos_proveedor_economica.html";
	forma.accion.value="c_invitacion_economica";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function cambia_oferta(oferta_entra)
	{
	var forma = document.formulario
			forma.target="";
			forma.action = "c_economico.php";
			forma.oferta.value = oferta_entra;
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";
	
	}	
function cambia_oferta_accion()

	{
	var forma = document.formulario
			forma.target="";
			forma.action = "c_economico.php";
			forma.accion_crea.value = "crea_oferta";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";
	
	
	}	
	

function paginacion_lista(pagi)
	{
	var forma = document.principal
	 ajax_carga('../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=' + forma.id_invitacion_pasa.value + '&termino=2&oferta=' + forma.oferta.value + '&pag=' + pagi + '&id_lista=' + forma.id_lista.value,'contenidos' )
	}
	
function paginacion_lista_histo(pagi)
	{


	var forma = document.principal
	 ajax_carga('../aplicaciones/proveedores/c_economico_historico.php?id_invitacion_pasa=' + forma.id_invitacion_pasa.value + '&termino=2&oferta=' + forma.oferta.value + '&pag=' + pagi + '&id_lista=' + forma.id_lista.value,'contenidos' )


	
	}	
	
function agrega_respuestas_aclaracion_final()
{
	var forma = document.principal;
	if((forma.sube_archivo.value =="") && (forma.observaciones.value=="")){
	muestra_alerta_error_solo_texto('', 'Error', '* Anexe o digite una respuesta', 20, 10, 18)
	//alert("ALERTA: Anexe o digite una respuesta")
	return;
		}
	else{
		forma.target="grp";
		forma.action = "procesos_proveedor.html";
		forma.accion.value="respuesta_final_aclaracion";
		forma.submit()
		//muestra_alerta_general_solo_texto('agrega_respuestas_aclaracion_final_continua()', 'Advertencia', '¿Esta seguro de enviar esta respuesta?', 20, 10, 18)
	}
}	
/*function agrega_respuestas_aclaracion_final_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="respuesta_final_aclaracion";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function elimina_anexo_aclaracion_final(id_anexo)
{
	//muestra_alerta_general_solo_texto('elimina_anexo_aclaracion_final_continua()', 'Advertencia', '¿Esta seguro de eliminar esta respuesta?', 20, 10, 18)
	var forma = document.principal;
	forma.id_anexo.value = id_anexo;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_aclaracion";
	forma.submit()


}
/*function elimina_anexo_aclaracion_final_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="anexo_elimina_aclaracion";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function confirma_terminos_condici()
{
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="confirma_terminos";
	forma.submit()
	//muestra_alerta_general_solo_texto('confirma_terminos_condici_continua()', 'Advertencia', '¿Esta seguro enviar la confirmación de aceptación de los terminos y condiciones del pedido?', 20, 10, 18)
}	
/*function confirma_terminos_condici_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="confirma_terminos";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function noconfirma_terminos_condici()
{
	var forma = document.principal;
	if(forma.observacion_no_acepta.value=="")
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la no aceptación', 20, 10, 18)
		//alert("Digite el detalle de la no aceptación.")
		return
	}else{
		forma.target="grp";
		forma.action = "procesos_proveedor.html";
		forma.accion.value="confirma_terminos_no";
		forma.submit()
		//muestra_alerta_general_solo_texto('noconfirma_terminos_condici_continua()', 'Advertencia', '¿Esta seguro enviar la NO aceptación de los terminos y condiciones del pedido?', 20, 10, 18)
	}
}
/*function noconfirma_terminos_condici_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "procesos_proveedor.html";
	forma.accion.value="confirma_terminos_no";
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display="";
}*/
function comentario_adjudicacion()
	{
		var forma = document.principal;
		
		if(forma.observacion_foro.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el comentario', 20, 10, 18)
				//alert("Digite el comentario.")
				return
				
				}
		
		else{
				forma.target="grp";
				forma.action = "procesos_proveedor.html";
				forma.accion.value="nuevo_ad_foro";
					forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";
			
		
	
		}
	}		
	

function envia_soporte()
	{
		
		var forma = document.principal;
		var msg ="";			
		
		if(forma.nombre_solicita.value==""){
			msg = msg + "* Digite la persona de contacto\n"
		}

		if(forma.telefono.value==""){
			msg = msg + "* Digite el teléfono de Contacto\n"
		}
		
		if(forma.email.value==""){
			msg = msg + "* Digite el e-mail de Contacto\n"
		}

		if(forma.mensaje.value==""){
			msg = msg + "* Digite mensaje\n"
		}				

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{ //si no tiene errores
		
						forma.target="grp";
						forma.action = "procesos_proveedor.html";
						forma.accion.value="envia_soporte";
							forma.submit()
							//window.parent.document.getElementById("cargando").style.display="";
	
			}//si no tiene errores

}

function crea_soporte()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("Digite el detalle de la pregunta")
				return;
				
				}
		else{
			forma.target="grp";
			forma.action = "procesos_proveedor.html";
			forma.accion.value="crea_soporte";
				forma.submit()
					//window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
		
	}
	
	

      function calcLong(txt, dst, formul, maximo)

      {
	var forma = document.principal
		  
      var largo

      largo = forma.pregunta_general.value.length

      if (largo > maximo)

      forma.pregunta_general.value = forma.pregunta_general.value.substring(0,maximo)

      forma.caracteres.value = largo

      }