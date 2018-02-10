function v_fi_ff(ai,mi,di,hi,mii,af,mf,df,hf,mif)
{
        anoi = ai; mesi = mi; diai = di; horai = hi; minutoi = mii
        anof = af; mesf = mf; diaf = df; horaf = hf; minutof = mif;
        /* Toma las fechas y las convierte a milisegundos,
        luego hace la resta y convierte a dias[horas] */
        fechafin = new Date((anof*1),(mesf*1-1),(diaf*1),(horaf*1),(minutof*1),0);
        fechaini = new Date((anoi*1),(mesi*1-1),(diai*1),(horai*1),(minutoi*1),0);
        vplazo = ((fechaini - fechafin)/3600); //Esta si es para horas

		//vplazo = ((fechafin - fechaini)/86400000); //Esta si es para días

        if((vplazo<1))
                return -1;
        else
                return 1;
}


function crea_proceso(ano,mes,dia,hora,minu)
	{//esta repetida
var forma = document.principal;
var msg ="";
var fcierre="";

		if(forma.a.value=="0"){
			msg = msg + "* Seleccione el tipo de proceso\n"
			forma.a.className = "select_faltantes";		
		}

if( (forma.p_t.value=="") && ( forma.tipo_solicitud.value==2) )
{
			msg = msg + "* Digite el porcentaje global de la evaluacion tecnica\n"
			forma.p_t.className = "select_faltantes";		
		}

if( (forma.p_t.value=="") && ( forma.tipo_solicitud.value==1) )
{
	forma.p_t.value=100
		}


if(forma.m_t.value=="")
	forma.m_t.value=100

/*	if(forma.consecutivo.value==""){
			msg = msg + "* Digite el consecutivo\n"
			forma.consecutivo.className = "campos_faltantes";		
		}*/

		if(forma.b.value=="0"){
			msg = msg + "* Seleccione el origen de la solicitud\n"
			forma.b.className = "select_faltantes";		
		}

		if(forma.g.value=="0"){
			msg = msg + "* Seleccione el tipo de contrato\n"
			forma.g.className = "select_faltantes";		
		}

		if(forma.tipo_solicitud.value=="0"){
			msg = msg + "* Seleccione el tipo de contratación\n"
			forma.tipo_solicitud.className = "select_faltantes";		
		}

		if(forma.c.value=="0"){
			msg = msg + "* Seleccione el objeto a contratar\n"
			forma.c.className = "select_faltantes";		
		}

		if(forma.d.value==""){
			msg = msg + "* Digite el objeto\n"
			forma.d.className = "campos_faltantes";		
		}

		if(forma.e.value==""){
			forma.e.value = 0;
		}

		if(forma.k.value=="0"){
			msg = msg + "* Seleccione el contacto\n"
			forma.k.className = "select_faltantes";		
		}



	if(forma.i.value==""){
			msg = msg + "* Seleccione la fecha de apertura\n"
			forma.i.className = "campos_faltantes";		
		}

	if(forma.j.value==""){
			msg = msg + "* Seleccione la fecha de cierre\n"
			forma.j.className = "campos_faltantes";		
		}


		if(forma.i.value!="")
				{
					fcierre = forma.i.value.split(" ");
					f4 = fcierre[0].split("-");
					t4 = fcierre[1].split(":");
					if(v_fi_ff(f4[0],f4[1],f4[2],t4[0],t4[1],ano,mes,dia,hora,minu)==-1){
					msg = msg +  "* Seleccione la feha de apertura del proceso no puede ser menor a la actual\n"
					forma.h.className = "campos_faltantes";
					
					}
					
				}

			if(forma.j.value!="")
				{

					fechacierre = forma.j.value.split(" ");
					fcierre = fechacierre[0].split("-");
					hcierre = fechacierre[1].split(":");	
					
					fechaapertura = forma.i.value.split(" ");
					fapertura = fechaapertura[0].split("-");
					hapertura = fechaapertura[1].split(":");
					
									
					
					if(v_fi_ff(fcierre[0],fcierre[1],fcierre[2],hcierre[0],hcierre[1],fapertura[0],fapertura[1],fapertura[2],hapertura[0],hapertura[1])==-1){
					msg = msg +  "* Seleccione la feha de cierre del proceso no puede ser menor a la de apertura\n"
					forma.j.className = "campos_faltantes";
					
					}
				}
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_proceso_continua()', 'Advertencia', '¿está seguro de Grabar esta Informacion?', 20, 10, 18)
		}
		}	
function crea_proceso_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_proceso"
	forma.target="grp"
		forma.submit()
	////window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function modifica_proceso(ano,mes,dia,hora,minu)
	{
var forma = document.principal;
var msg ="";
var fcierre="";
if(forma.p_t.value=="")
	forma.p_t.value=100
if(forma.m_t.value=="")
	forma.m_t.value=100

		if(forma.a.value=="0"){
			msg = msg + "* Seleccione el tipo de proceso\n"
			forma.a.className = "select_faltantes";		
		}

		if(forma.consecutivo.value==""){
			msg = msg + "* Digite el consecutivo\n"
			forma.consecutivo.className = "campos_faltantes";		
		}

		if(forma.b.value=="0"){
			msg = msg + "* Seleccione el origen de la solicitud\n"
			forma.b.className = "select_faltantes";		
		}

		if(forma.g.value=="0"){
			msg = msg + "* Seleccione el tipo de contrato\n"
			forma.g.className = "select_faltantes";		
		}

		if(forma.tipo_solicitud.value=="0"){
			msg = msg + "* Seleccione el tipo de contratación\n"
			forma.tipo_solicitud.className = "select_faltantes";		
		}

		if(forma.c.value=="0"){
			msg = msg + "* Seleccione el objeto a contratar\n"
			forma.c.className = "select_faltantes";		
		}

		if(forma.d.value==""){
			msg = msg + "* Digite el objeto\n"
			forma.d.className = "campos_faltantes";		
		}

		if(forma.e.value==""){
			forma.e.value = 0;
		}

		if(forma.k.value=="0"){
			msg = msg + "* Seleccione el contacto\n"
			forma.k.className = "select_faltantes";		
		}




	if(forma.i.value==""){
			msg = msg + "* Seleccione la fecha de apertura\n"
			forma.i.className = "campos_faltantes";		
		}

	if(forma.j.value==""){
			msg = msg + "* Seleccione la fecha de cierre\n"
			forma.j.className = "campos_faltantes";		
		}

			if(forma.i.value!="")
				{
					fcierre = forma.i.value.split(" ");
					f4 = fcierre[0].split("-");
					t4 = fcierre[1].split(":");
					if(v_fi_ff(f4[0],f4[1],f4[2],t4[0],t4[1],ano,mes,dia,hora,minu)==-1){
					msg = msg +  "* Seleccione la feha de apertura del proceso no puede ser menor a la actual\n"
					forma.h.className = "campos_faltantes";
					
					}
					
				}


		

			if(forma.j.value!="")
				{

					fechacierre = forma.j.value.split(" ");
					fcierre = fechacierre[0].split("-");
					hcierre = fechacierre[1].split(":");	
					
					fechaapertura = forma.i.value.split(" ");
					fapertura = fechaapertura[0].split("-");
					hapertura = fechaapertura[1].split(":");
					
									
					
					if(v_fi_ff(fcierre[0],fcierre[1],fcierre[2],hcierre[0],hcierre[1],fapertura[0],fapertura[1],fapertura[2],hapertura[0],hapertura[1])==-1){
					msg = msg +  "* Seleccione la feha de cierre del proceso no puede ser menor a la de apertura\n"
					forma.j.className = "campos_faltantes";
					
					}
				}


		

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_proceso2_continua()', 'Advertencia', '¿está seguro de modificar este proceso?', 20, 10, 18)
		}
}
		


function modifica_proceso2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="modifica_proceso"
	forma.target="grp"
		forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function crea_proveedor()
	{
var forma = document.principal;
var msg ="";

		if(forma.proveedor.value=="")
			msg = msg + "* Seleccione un proveedor\n"
			
	if( (forma.nuevo_provee_obligato.value==1) && (forma.observa_provee.value == "") )
						msg = msg + "* Digite la razon por la cual invita este proveedor\n"

			
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_proveedor2_continua()', 'Advertencia', '¿está seguro de crear este proveedor?', 20, 10, 18)
	
				}
}

function crea_proveedor2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_proveedor"
	forma.target="grp"
		forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function elimina_proveedor(id_elimina)
	{
var forma = document.principal;
forma.id_elimina.value=id_elimina
var msg ="";
	muestra_alerta_general_solo_texto('elimina_proveedor_continua()', 'Advertencia', 'está seguro de eliminar este proveedor de la invitación', 20, 10, 18)
}
function elimina_proveedor_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_proveedor"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function confirma_asistencia_obli()
	{
var forma = document.principal;
var msg ="";
	muestra_alerta_general_solo_texto('confirma_asistencia_obli_continua()', 'Advertencia', 'está seguro de realizar esta confirmación\n * ATENCION: Si esta seguro de continuar los proveedores que no asistieron a la reunion seran bloqueados', 20, 10, 18)

}
function confirma_asistencia_obli_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="confirma_asistencia_participa";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function crea_archivo()
	{
var forma = document.principal;
var msg ="";

		if(forma.anexos_s.value=="")
			msg = msg + "* Seleccione un archivo\n"
			
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_archivo_continua()', 'Advertencia', '¿está seguro de crear este archivo?', 20, 10, 18)
			}
		
}
function crea_archivo_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_archivo"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function elimina_archivo(id_elimina)
	{
var forma = document.principal;
var msg ="";
	muestra_alerta_general_solo_texto('elimina_archivo_continua()', 'Advertencia', '¿está seguro de eliminar este archivo de la invitación?', 20, 10, 18)
	forma.id_elimina.value=id_elimina
}
function elimina_archivo_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_archivo"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function configura_criterios_evalua_sencilla_tecnicos()
	{
		var forma = document.principal;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion_tecnicos.php";
			forma.accion.value="configura_evaluacion_criterios";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	
	}		
	
function configura_criterios_evalua_sencilla_juridico()
	{
		var forma = document.principal;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_criterios_juridicos";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	
	}			
	
function crea_criterios_evaluacion(ct,n_c)
	{
	var forma = document.principal;


	if(n_c=="")
	{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el nombre del criterio', 20, 10, 18)
		//alert("* Digite el nombre del criterio")
		return;
	}else{

		forma.id_elimina.value=ct
		forma.action = "../librerias/php/procesos_licitacion.php";
		forma.accion.value="crea_criterio_evaluacion"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		forma.id_elimina.value=""

	}
}	

function configura_grupo_evaluacion()
{
	var forma = document.principal;
	if(forma.valorgrupo.value=="")
	{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el nombre de la categoría', 20, 10, 18)
		//alert("* Digite el nombre de la categoría")
		return;
	}else{
		forma.action = "../librerias/php/procesos_licitacion.php";
		forma.accion.value="crea_grupo_evaluacion"
		forma.target="grp"
		forma.submit()
		//window.parent.document.getElementById("cargando").style.display=""
		forma.action = "";
		forma.accion.value=""
		forma.target=""
		forma.id_elimina.value=""
	}
}
function notificar_provvedores(){
	var forma = document.principal;
	
	if(forma.sin_email.value>=1)
		{
			muestra_alerta_error_solo_texto('', 'Error', 'Existen proveedores sin e-mail\n * Por favor incluya el email para porder notificar', 20, 10, 18)
			//alert("Existen proveedores sin e-mail\n por favor incluya el email para porder notificar")
			return;
			}
	muestra_alerta_general_solo_texto('notificar_provvedores2_continua()', 'Advertencia', '¿está seguro de enviar la notificación a los proveedores? * Cualquier modificación futura al proceso sera notificada a los proveedores', 20, 10, 18)
}
function notificar_provvedores2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="notifica_proveedores"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
	
function modifica_proceso_notificado(conf)
{
	var forma = document.principal;

	if(conf==1){
		var forma2 = document.notifica;
		forma.justificacion_final.value = forma2.justificacion_ca.value;
		close_va();
	}
	var msg ="";
	if(forma.a.value=="0")	msg = msg + "* Seleccione el tipo de proceso\n"
	if(msg!="")
	{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: '+msg, 20, 10, 18)
		return
	}else{
		muestra_alerta_general_solo_texto('modifica_proceso_notificado_continua()', 'Advertencia', '¿está seguro de modificar este proceso?', 20, 10, 18)
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="modifica_proceso_notificado_p"
	forma.target="grp"
	forma.id_elimina.value = conf
	
	}
}	

function modifica_proceso_notificado_continua(){
	var forma = document.principal;
	forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function suma_valores_tecnicos(valor,espacio){
	espacio.value = ( (espacio.value*1) + (valor.value*1) - (document.principal.valor_actual.value) );
	if((espacio.value*1)>100){
		muestra_alerta_error_solo_texto('', 'Error', 'El porcentaje total de los criterios de esta categoria no puede ser mayor al 100%', 20, 10, 18)
		//alert("El porcentaje total de los criterios de esta categoria no puede ser mayor al 100%")
		espacio.value = ( (espacio.value*1) - (valor.value*1) );
		valor.value="";
	}
}			
function crea_articulo()
	{
	var forma = document.principal
	if(forma.a_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el codigo del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(forma.b_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el detalle del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el detalle del producto que le solicitara al proveedor")
		return;
		}
	if(forma.c_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite la unidad de medida del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}
	if(forma.d_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite la cantidad del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la cantidad del producto que le solicitara al proveedor")
		return;
		}
	if(forma.e_economica.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione la moneda del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}

	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_articulo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

	
	}
	
}
function sube_archivo()
	{
	var forma = document.principal
	if(forma.archivo_lista.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Anexe el archivo de excel con el listado de articulos.', 20, 10, 18)
		//alert("Anexe el archivo de excel con el listado de articulos.")
		return;
		}
	else
	{
			forma.target="grp";
			forma.action = "configuracion_criteriosmasivo.html";
			forma.accion.value="campo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	}
	
}
function crea_campo()
	{


	var forma = document.principal
	if(forma.n_campo.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el nombre del requerimiento', 20, 10, 18)
		//alert("* Digite el nombre del requerimiento")
		return;
		}
	if(forma.tipo_campo.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione el tipo de requerimiento', 20, 10, 18)
		//alert("* Seleccione el tipo de requerimiento")
		return;
		}

	
	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_campo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

	
	}
	
	}

function edita_requerimiento(id_requerimiento,a,b)
	{


	var forma = document.principal

	
	if(a.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el nombre del requerimiento', 20, 10, 18)
		//alert("* Digite el nombre del requerimiento")
		return;
		}
	if(b.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione el tipo de requerimiento', 20, 10, 18)
		//alert("* Seleccione el tipo de requerimiento")
		return;
		}

	
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="e_configura_evaluacion_campo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}

function elimina_requerimiento(id_requerimiento)
	{


	var forma = document.principal
	muestra_alerta_general_solo_texto('elimina_requerimiento_continua()', 'Advertencia', '¿está seguro de eliminar este requerimiento?', 20, 10, 18)
	forma.campo_id.value = id_requerimiento;
}
function elimina_requerimiento_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_configura_evaluacion_campo";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function edita_articulos(id_requerimiento,a,b,c,d,e)
	{


	var forma = document.principal

	
	if(a.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el codigo del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(b.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el detalle del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el detalle del producto que le solicitara al proveedor")
		return;
		}

	if(c.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite la unidad de medida del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}	
	if(d.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite la cantidad del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la cantidad del producto que le solicitara al proveedor")
		return;
		}	
		
	if(e.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione la moneda del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}else{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="edita_articulos_lista";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
	}

	
}

function elimina_articulo(id_requerimiento)
	{
	var forma = document.principal
	muestra_alerta_general_solo_texto('elimina_articulo_continua()', 'Advertencia', '¿está seguro de eliminar este bien o servicio?', 20, 10, 18)
	forma.campo_id.value = id_requerimiento;
	
}
function elimina_articulo_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_articulo_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function activar_subasta(campo_activa){
var forma = document.principal
forma.valor_campo.value = campo_activa;
muestra_alerta_general_solo_texto('activar_subasta_continua()', 'Advertencia', 'está a punto de activar este campo para la subasta ¿está seguro?', 20, 10, 18)
}
function activar_subasta_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="activa_campo_subasta";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function activar_subasta_con(){
muestra_alerta_general_solo_texto('activar_subasta_con_continua()', 'Advertencia', 'está a punto de activar este campo para la subasta ¿está seguro?', 20, 10, 18)
}
function activar_subasta_con_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="activa_campo_subasta_consolidada";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function c_evaluacion_juridica(){
muestra_alerta_general_solo_texto('c_evaluacion_juridica_continua()', 'Advertencia', '¿está seguro de evaluar al proveedor?', 20, 10, 18)
}
function c_evaluacion_juridica_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="evaluacion_juridica";
	forma.submit()
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function c_evaluacion_tecnica(){
	var forma = document.principal

	if(forma.obse_juridico.value =="")
		{
			muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite la observacion general', 20, 10, 18)
			//alert("* Digite la observacion general")
			return
			}
else{
	muestra_alerta_general_solo_texto('c_evaluacion_tecnica_continua()', 'Advertencia', '¿está seguro de evaluar al proveedor?', 20, 10, 18)
	//var msg = confirm("Esta seguro de evaluar al proveedor ?");	
	
	}

}

function c_evaluacion_tecnica_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="evaluacion_tecnica";
	forma.submit()
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function crea_articulo_temp(){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_articulo_temporal";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}
	
	
function crea_articulo_temp_uno(id_articulo){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_articulo_temporal_uno_p";
			forma.id_linea.value=id_articulo
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}	
	
	
function guardar_parcial(){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="guardar_parcialmente";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}	
	

function cambia_cantidad(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="cambia_cantidades";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	



	
function elimina_articulo_lista(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="elimina_articulo";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	
	
	
function abre_proveedores(espacio, id, linea_pasa)
{
	var forma = document.principal
	if(forma.id_elimina.value!="")
		document.getElementById(forma.id_elimina.value).innerHTML = "";
		
		ajax_carga('../aplicaciones/lista_precios/otros_proveedores.php?id_articulo=' + id ,espacio)
		forma.id_elimina.value = espacio
		forma.id_linea.value = linea_pasa
	
	}
	
	
function cerrar_proveedores_lista()
{
	var forma = document.principal
		document.getElementById(forma.id_elimina.value).innerHTML = "";
		forma.id_elimina.value = ""
	
	}	
	
	

function cambia_proveedor_lista(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="cambia_proveedor";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
	
function notifica_prove_lista()	{

			
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="notifica_proveedor_articulo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";
			

	}
	
	
function crea_usuario_lista(){

			var forma = document.principal
			
			if(forma.lista_c.value==0)
				{
					muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione la lista', 20, 10, 18)
					//alert("* Seleccione la lista")
					return;
					
					}
			if(forma.b_usuarios.value=="")
				{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione el usuario', 20, 10, 18)
					//alert("* Seleccione el usuario")
					return;
					
					}

			if(forma.periocidad.value=="0")
				{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Seleccione la periocidad', 20, 10, 18)
					//alert("* Seleccione la periocidad")
					return;
					
					}

			if(forma.monto.value=="")
				{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el monto', 20, 10, 18)
					//alert("* Digite el monto")
					return;
					
					}

else{

forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_usuario_lista";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";
			
}

	}	

function che_lista(){

	var forma = document.principal
	

	if(forma.c_t.checked==true)
		{
	
	 for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
				
				   forma.elements[i].checked=true

				}
		 
		}
		
		}//si lo chequea
		
else
	{
		
	for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
				   forma.elements[i].checked=false

				}
		 
		}
		
		
		
		}
		
}


function ingreso_evaluador_login(){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/valida_ingreso_evaluador.php";
			forma.accion.value="ingreso_evaluacion";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
function abre_procesos_evaluacion_con(linea_pasa)
{
	var forma = document.principal
	

	if(forma.id_limpia.value!="")
		document.getElementById('contrase_'+forma.id_limpia.value).innerHTML = "";
		
		ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p='+linea_pasa,'contrase_'+linea_pasa)
		forma.id_limpia.value = linea_pasa
	
	}
	
	
function cerrar_proveedores_lista()
{
	var forma = document.principal
		document.getElementById('contrase_'+forma.id_limpia.value).innerHTML = "";
		forma.id_limpia.value = ""
	
	}		
	

function volver_listado(muestra,oculta)
{
	
	document.getElementById(oculta).innerHTML = '';
	document.getElementById(muestra).style.display = '';
	
	}

function ingresar_listado(oculta)
{
	
	document.getElementById(oculta).style.display = 'none';
	
	}
	


function modifica_proveedor(){
		var forma = document.principal
		var msg=""
	
	if(forma.ap.value==""){
			msg = msg + "* Digite la identificación\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.bp.value==""){
			msg = msg + "* Digite la razón social\n"
			forma.bp.className = "campos_faltantes";		
		}

	if(forma.cp.value==""){
			msg = msg + "* Digite la dirección\n"
			forma.cp.className = "campos_faltantes";		
		}
	if(forma.dp.value==""){
			msg = msg + "* Digite el e-mail\n"
			forma.dp.className = "campos_faltantes";		
		}
	if(forma.ep.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.ep.className = "campos_faltantes";		
		}
	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione el estado\n"
			forma.fp.className = "select_faltantes";		
		}
	if(forma.pais.value=="0"){
			msg = msg + "* Seleccione el país\n"
			forma.pais.className = "select_faltantes";		
		}
	if(forma.depart.value=="0"){
			msg = msg + "* Seleccione el departamento\n"
			forma.depart.className = "select_faltantes";		
		}	
		

	if(forma.ciuadad.value=="0"){
			msg = msg + "* Seleccione la ciudad\n"
			forma.ciuadad.className = "select_faltantes";		
		}
	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_proveedor_continua()', 'Advertencia', '¿está seguro de modificar este proveedor?', 20, 10, 18)
			}


	
	}	

function modifica_proveedor_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_proveedor.php";
	forma.accion.value="modifica_proveedor"
	forma.target="grp"
		forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
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
	
function volver_publico(id_cartelera){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value = "volver_publica";
			forma.id_elimina.value = id_cartelera;
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
function volver_privada(id_cartelera){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value = "volver_privada";
			forma.id_elimina.value = id_cartelera;
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}	
	
function crea_pregunta_general_cartelera_foro(id_pru, valica)
	{

	var forma = document.principal

		
		if(valica.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el detalle de la respuesta', 20, 10, 18)
				//alert("* Digite el detalle de la respuesta")
				return;
				
				}
		else{
			muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_foro_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
			forma.id_elimina.value=id_pru
		}
	
	}

function crea_pregunta_general_cartelera_foro_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_general_foro";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_pregunta_general_cartelera_admin()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("* Digite el detalle de la pregunta")
				return;
			}
		else{
			muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_admin_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
			//var msg = confirm("ATENCION\n Esta a punto de enviar esta aclaración esta seguro.. ?")
		}
	
	}	

function crea_pregunta_general_cartelera_admin_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_general_admin";
	forma.submit()

	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function envia_armar_formula(id_campo, valor_forma, nombre_campo){
	
		var forma = document.principal
		if(valor_forma=="1")
			{
				forma.formula_1.value = forma.formula_1.value + "b" + id_campo
				
				}

		if(valor_forma=="2")
			{

			if( (forma.formula_2.value!="0") && (forma.formula_2.value!= id_campo ) )
				{
					var msg = confirm("La formula ya contiene un parametro con minimo valor\n Desea reemplasar la formula con este nuevo parametro")
					var cadena = forma.formula_1.value
					var con_cadena = ""
					if(msg)
							{
								
								
								//while(cadena.indexOf("min(b" + forma.formula_2.value + ")")>=0)
								con_cadena = cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								
								forma.formula_1.value = con_cadena
								forma.formula_1.value = forma.formula_1.value + "min(b" + id_campo + ")"
								
								forma.formula_2.value = id_campo
			
								}
					
					}
			else
				{
					forma.formula_1.value = forma.formula_1.value + "min(b" + id_campo + ")"
					forma.formula_2.value =  id_campo
					
					
					}
				}




		if(valor_forma=="3")
			{

			if( (forma.formula_3.value!="0") && (forma.formula_3.value!= id_campo ) )
				{
					var msg = confirm("La formula ya contiene un parametro con maximo valor\n Desea reemplasar la formula con este nuevo parametro")
					var cadena = forma.formula_1.value
					var con_cadena = ""
					if(msg)
							{
								
								
								//while(cadena.indexOf("min(b" + forma.formula_2.value + ")")>=0)
								con_cadena = cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								
								forma.formula_1.value = con_cadena
								forma.formula_1.value = forma.formula_1.value + "max(b" + id_campo + ")"
								forma.formula_3.value = id_campo
			
								}
					
					}
			else
				{
					forma.formula_1.value = forma.formula_1.value + "max(b" + id_campo + ")"
					forma.formula_3.value =  id_campo
					
					
					}
				}






		if(valor_forma=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione una variable', 20, 10, 18)
				//alert("* Seleccione una variable")
				return;
				}

	
	}

	
function guardar_formula(t_formula)
	{

	var forma = document.principal

		
		if(forma.formula_1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite formula', 20, 10, 18)
				//alert("* Digite formula")
				return;
				
				}
		if(forma.nombre_formula.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la formula', 20, 10, 18)
				//alert("* Digite el nombre de la formula")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('guardar_formula_continua()', 'Advertencia', 'está a punto de guardar esta formula ¿está seguro?', 20, 10, 18)
			forma.tipo_formula.value = t_formula
	
		}
	
	}
function  guardar_formula_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="Guardar_formula";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_guardar_formula(t_formula)
	{

	var forma = document.principal
	forma.tipo_formula.value = t_formula
	muestra_alerta_general_solo_texto('elimina_guardar_formula_continua()', 'Advertencia', 'está a punto de guardar esta formula ¿está seguro?', 20, 10, 18)
}
function elimina_guardar_formula_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_formula";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crear_nueva_lista()
	{

	var forma = document.principal

		
		if(forma.nombre_lista.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la lista', 20, 10, 18)
				//alert("* Digite el nombre de la lista")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('crear_nueva_lista_continua()', 'Advertencia', 'está a punto de crear esta lista ¿está seguro?', 20, 10, 18)
			
		}
	
	}
function crear_nueva_lista_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crear_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}	

function editar_nueva_lista()
	{

	var forma = document.principal

		
		if(forma.edita_lista.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la lista', 20, 10, 18)
				//alert("* Digite el nombre de la lista")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('editar_nueva_lista_continua()', 'Advertencia', 'está a punto de editar esta lista ¿está seguro?', 20, 10, 18)
		
		}
	
	}
function editar_nueva_lista_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="editar_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function elimina_nueva_lista()
	{
	muestra_alerta_general_solo_texto('elimina_nueva_lista_continua()', 'Advertencia', 'está a punto de eliminar esta lista ¿está seguro?', 20, 10, 18)
}
function elimina_nueva_lista_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function oculta_lista_item(lista)
	{
		var forma = document.principal

		window.parent.document.getElementById("detalle_item").style.display="";
		
		
		
		}
		
function adjudicacion()
	{
		var forma = document.principal
		var cont = 0; 
 
	if(forma.b.value==0)
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un estado del proceso', 20, 10, 18)
		//alert("* Seleccione un estado del proceso")
		return
	}

	if(forma.comentarios_no_adjudica.value==0)
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el comentario', 20, 10, 18)
		//alert("* Digite el comentario")
		return
	}


	else
	{
		muestra_alerta_general_solo_texto('adjudicacion_continua()', 'Advertencia', 'está a punto de cambiar el estado de este proceso ¿está seguro?', 20, 10, 18)
	}
	

}
function adjudicacion_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="adjudica_proceso";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_toda_lista()
	{
	muestra_alerta_general_solo_texto('elimina_toda_lista_continua()', 'Advertencia', 'está a punto de guardar esta lista ¿está seguro?', 20, 10, 18)
	}
function elimina_toda_lista_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_toda_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function graba_apertura_licita()
	{

	var forma = document.principal

		if(forma.lugar_apertura.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el lugar de la apertura', 20, 10, 18)
				//alert("* Digite el lugar de la apertura");
				return;
				}
		muestra_alerta_general_solo_texto('graba_apertura_licita_continua()', 'Advertencia', 'está a punto de guardar y generar el acta de apertura ¿está seguro?', 20, 10, 18)
}
function graba_apertura_licita_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion_apertura.value="graba_apertura";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion_apertura.value="";
}

function muetra_criterios(destino,imagen,id_espacio){
	
		
		if(imagen.name == "muestra_" + id_espacio )
			{
		
				imagen.name = "oculta_" + id_espacio
				document.getElementById(destino).style.display="";
				imagen.src="../imagenes/botones/cierra.png"

				return
				
				}

			if(imagen.name == "oculta_" + id_espacio )
			{
				document.getElementById(destino).style.display="none";
				imagen.name = "muestra_" + id_espacio
				imagen.src="../imagenes/botones/abre.png"				
				return
				
				}

	
	
	}		
	
	


function crear_usuario(){
		var forma = document.principal
		var msg=""

	if(forma.usuario_pasa.value==""){
			msg = msg + "* Digite el usuario\n"
			forma.usuario_pasa.className = "campos_faltantes";		
		}

if(forma.ap.value==""){
			msg = msg + "* Digite el nombre\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.email.value==""){
			msg = msg + "* Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}

	if(forma.dp.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.dp.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "* Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione un estado\n"
			forma.fp.className = "campos_faltantes";		
		}

	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crear_usuario_continua()', 'Advertencia', '¿está seguro de crear este usuario?', 20, 10, 18)
				
			}
}
function crear_usuario_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="crea_usuario" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function modifica_usuario(){
		var forma = document.principal
		var msg=""



if(forma.ap.value==""){
			msg = msg + "* Digite el nombre\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.email.value==""){
			msg = msg + "* Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}

	if(forma.dp.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.dp.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "* Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione un estado\n"
			forma.fp.className = "campos_faltantes";		
		}

	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{

		muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_usuario_continua()', 'Advertencia', '¿está seguro de modificar este usuario?', 20, 10, 18)
			}
}		
function modifica_usuario_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="modifica_usuario" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function crear_registro_n(){
		var forma = document.principal
		var msg=""

	if(forma.n_resgitro.value==""){
			msg = msg + "* Digite el registro\n"
			campo.className = "campos_faltantes";		
		}

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crear_registro_n_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
			}
}
function crear_registro_n_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="crea_registro"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}


function modifica_registro_n(campo,registro){
		var forma = document.principal
		var msg=""

	if(campo.value==""){
			msg = msg + "* Digite el registro\n"
			campo.className = "campos_faltantes";		
		}

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_registro_n_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
					forma.id_maestra.value=registro;
			}
}
function modifica_registro_n_continua(){
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="edita_registro" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

 function exportToXL(eSrc) {
 var oExcel; 
var oExcelSheet; 
var oWkBooks;
 var cols; 
oExcel = new ActiveXObject('Excel.Application');
 oWkBooks = oExcel.Workbooks.Add;
 oExcelSheet = oWkBooks.Worksheets(1);
 oExcelSheet.Activate();
 if (eSrc.tagName != 'TABLE') {
 	muestra_alerta_error_solo_texto('', 'Error', '* No ha sido posible exportar la tabla a excell', 20, 10, 18)
 //alert('No ha sido posible exportar la tabla a excell');
 return false;
 }
 cols = Math.ceil(eSrc.cells.length / eSrc.rows.length);
 for (var i = 0; i < eSrc.cells.length; i ++)
 {
 var c, r;
 r = Math.ceil((i+1) / cols);
 c = (i+1)-((r-1)*cols)
 if (eSrc.cells(i).tagName == 'TH') { 
oExcel.ActiveSheet.Cells(r,c).Font.Bold = true;
 oExcel.ActiveSheet.Cells(r,c).Interior.Color = 14474460; 
}
 if (eSrc.cells(i).childNodes.length > 0 && eSrc.cells(i).childNodes(0).tagName == "B") 
oExcel.ActiveSheet.Cells(r,c).Font.Bold = true;
 oExcel.ActiveSheet.Cells(r,c).Value = eSrc.cells(i).innerText;
 }
 oExcelSheet.Application.Visible = true;
 }

function apertura_proceso_auditor(){
	muestra_alerta_general_solo_texto('apertura_proceso_auditor_continua()', 'Advertencia', '¿está seguro de confirmar la apertura del proceso?', 20, 10, 18)
}
function apertura_proceso_auditor_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="confirma_acta_apertura" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function crea_bitacora()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el detalle de la pregunta', 40, 8, 12)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}
		else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="crea_bitacora";
				forma.submit()
					//////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}		


function crea_cartelera_final()
	{

	var forma = document.principal
		if(forma.asunto_cartelera.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el asunto de la pregunta', 20, 10, 18)
				//alert("* Digite el asunto de la pregunta")
				return;
				
				}
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}	
		if(forma.h_m_r.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite la fecha maxima de respuesta', 20, 10, 18)
				//alert("* Digite la fecha maxima de respuesta")
				return;
				
				}					


		else{
			muestra_alerta_general_solo_texto('crea_cartelera_final_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
		}
	
	}
function crea_cartelera_final_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_aclaracion_final";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_proveedor_adentro(){
		var forma = document.principal
		var msg=""
	
	/*if(forma.ap.value==""){
			msg = msg + "* Digite la identificación\n"
			forma.ap.className = "campos_faltantes";		
		}
*/

	if(forma.bp.value==""){
			msg = msg + "* Digite la razón social\n"
			forma.bp.className = "campos_faltantes";		
		}

	if(forma.cp.value==""){
			msg = msg + "* Digite la dirección\n"
			forma.cp.className = "campos_faltantes";		
		}
	if(forma.email_contacto.value==""){
			msg = msg + "* Digite el e-mail\n"
			forma.email_contacto.className = "campos_faltantes";		
		}
	if(forma.ep.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.ep.className = "campos_faltantes";		
		}
	

	if(forma.ciuadad.value=="0"){
			msg = msg + "* Seleccione la ciudad\n"
			forma.ciuadad.className = "select_faltantes";		
		}
	
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				return
				
				}
		else
			{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="crea_proveedor_adentro";
			forma.submit()
			////window.parent.document.getElementById("cargando").style.display="";
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
					
				}
	}		

function crea_adju_provee(pasa)
	{

	var forma = document.principal
		
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_adjudicacion_proverdor";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	
	}	
	
function crea_adju_provee_servico_menor(pasa)
	{

	var forma = document.principal
		
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion_sm.php";
			forma.accion.value="crea_adjudicacion_proverdor";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	
	}	

function crea_adju_provee_servicios(pasa)
	{

	var forma = document.principal
	
		
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
			forma.accion.value="crea_adjudicacion_proverdor";
			forma.pv_id.value = pasa
			
			
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	
	}	
function edita_adju_provee(pasa)
	{
	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('edita_adju_provee_continua()', 'Advertencia', '¿está seguro de modificar los datos de adjudicación?', 20, 10, 18)
}
function edita_adju_provee_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="ed_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_adju_provee(pasa){
	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('elimina_adju_provee_continua()', 'Advertencia', '¿está seguro de desvincular este proveedor de la adjudicación?', 20, 10, 18)
}
function elimina_adju_provee_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="el_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}	

function edita_adju_provee_sm(pasa)
	{

	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('edita_adju_provee_sm_continua()', 'Advertencia', '¿está seguro de modificar los datos de adjudicación?', 20, 10, 18)
}
function edita_adju_provee_sm_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion_sm.php";
	forma.accion.value="ed_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_adju_provee_sm(pasa)
	{
	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('elimina_adju_provee_sm_continua()', 'Advertencia', '¿está seguro de desvincular este proveedor de la adjudicación?', 20, 10, 18)
}
function elimina_adju_provee_sm_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion_sm.php";
	forma.accion.value="el_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_adju_provee_servicios(pasa)
	{
	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('elimina_adju_provee_servicios_continua()', 'Advertencia', '¿está seguro de desvincular este proveedor de la adjudicación?', 20, 10, 18)
}
function elimina_adju_provee_servicios_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
	forma.accion.value="el_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function add_email(pasa)
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="add_email_c";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	}		
		
function elim_email_ad(pasa)
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="elimi_email_c";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	}			
	
	function graba_archivo_soporte_adj_proveedor(){
		var forma = document.principal
		var msg=""
	
	if(forma.arc_soporte.value==""){
			msg = msg + "* Seleccione un archivo\n"
			forma.arc_soporte.className = "campos_faltantes";		
		}
	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_archivo_soporte_adj_proveedor";
			forma.submit()
			////window.parent.document.getElementById("cargando").style.display="";
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
					
		}
}		

function elimina_archivo_soporte_adj_proveedor(id_elimina)
	{
var forma = document.principal;
forma.id_anexo.value=id_elimina
muestra_alerta_general_solo_texto('elimina_archivo_soporte_adj_proveedor_continua()', 'Advertencia', '¿está seguro de eliminar este archivo de la invitación?', 20, 10, 18)
}
function elimina_archivo_soporte_adj_proveedor_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_archivo_soporte_adj_proveedor"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function canfirma_notificacion_js()
	{
var forma = document.principal;
var msg ="";

/*				var alerta = confirm("Esta seguro de notificar este proceso ?")
				if(alerta){ */
					
					
					forma.action = "../librerias/php/procesos_adjudicacion.php";
					forma.accion.value="canfirma_notificacion"
					forma.target="grp"
						forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.id_elimina.value=""
					
					//}
		}	

function canfirma_notificacion_js_SERVICIOS()
	{
var forma = document.principal;
var msg ="";

/*				var alerta = confirm("Esta seguro de notificar este proceso ?")
				if(alerta){ */
					
					
					forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
					forma.accion.value="canfirma_notificacion"
					forma.target="grp"
						forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.id_elimina.value=""
					
					//}
		}	

function comentario_adjudicacion()
	{
		var forma = document.principal;
		
		if(forma.observacion_foro.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el comentario.', 20, 10, 18)
				//alert("* Digite el comentario.")
				return
				
				}
		
		else{
				forma.target="grp";
				forma.action = "../librerias/php/procesos_adjudicacion.php";
				forma.accion.value="nuevo_ad_foro";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
		}
	}	

function crea_nuevo_contacto()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="nuevo_add";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	
	

function crea_nuevo_contacto_adj()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="nuevo_add_adjudicacion";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	


function elimina_contacto_todo(id_elimina){
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="elimina_contacto_todo";
				forma.id_elimina.value=id_elimina;
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
						forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}	
	



function elimina_contacto_todo_adj(id_elimina){
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="elimina_contacto_todo_adj";
				forma.id_elimina.value=id_elimina;
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
						forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}	
function crea_elimina(che,id_elimina)	{
	var forma = document.principal;
		if(che==true)
			{
				
				forma.accion.value="nuevo_add_relacion";
				forma.id_elimina.value=id_elimina;
				
				}

		if(che==false)
			{
				
				forma.accion.value="elimina_add_relacion";
				forma.id_elimina.value=id_elimina;
				
				}

			forma.action = "../librerias/php/procesos_nuevos_contactos.php";
			forma.target="grp";
			forma.submit()
			////window.parent.document.getElementById("cargando").style.display="";	
		
		
					forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}		

function notificar_nuevo_contacto()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="notifica_otra_vez_add";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	

	
	
function elim_email_marcados()
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="elimi_email_todos";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
	}	
	
function cheque_todo(valor)
	{

	var forma = document.principal
		
		 for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
					if(valor==true)		
					   forma.elements[i].checked=true
				if(valor==false)		
					   forma.elements[i].checked=false


				}
		 
		}
	}		
	
	
function crea_soporte()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}
		else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_soporte.php";
			forma.accion.value="crea_soporte";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	
	

function crea_plantilla_copia()
	{

	var forma = document.principal

		
		if(forma.sel1.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el comprador', 20, 10, 18)
				//alert("* Seleccione el comprador")
				return;
				
				}
		if(forma.sel2.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el Destino Final /Centro Logístico', 20, 10, 18)
				//alert("* Seleccione el Destino Final /Centro Logístico")
				return;
				
				}

		if(forma.sel3.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el Operadores Logísticos', 20, 10, 18)
				//alert("* Seleccione el Operadores Logísticos")
				return;
				
				}


else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_conbina_plantilla";
				forma.submit()
					//////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	

function elimina_proceso_sin_abrir(id_elimina_p)
	{
	var forma = document.principal
	forma.id_limpia.value=id_elimina_p;
	muestra_alerta_general_solo_texto('elimina_proceso_sin_abrir2_continua()', 'Advertencia', '¿está seguro de eliminar proceso?', 20, 10, 18)
}
function elimina_proceso_sin_abrir2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_proceso_sin_abrir";
	forma.submit()
	forma.campo_id.value = "";
	forma.id_limpia.value="";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_sub_usuario_j_admin()
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
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_sub_usuario_j_admin_continua()', 'Advertencia', '¿está seguro de crear este proceso?', 20, 10, 18)
			}
}
function crea_sub_usuario_j_admin_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_nuevos_contactos.php";
	forma.accion.value="crea_sub_usuario"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function edita_sub_usuario_adm(id_requerimiento,a,b,c)
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
		//alert("* Digite el E-mail")
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
			forma.action = "../librerias/php/procesos_nuevos_contactos.php";
			forma.accion.value="e_sub_usuario";
			forma.submit()
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
	}
	
}	

function crea_contacto_plantilla()
	{

	var forma = document.principal

		
		if(forma.con_grupo.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el grupo', 20, 10, 18)
				//alert("* Digite el grupo")
				return;
				
				}
		if(forma.con_nombre.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre', 20, 10, 18)
				//alert("* Digite el nombre")
				return;
				
				}

		if(forma.con_email.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el e-mail', 20, 10, 18)
				//alert("* Digite el e-mail")
				return;
				
				}


else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_contacto_plantilla";
			forma.submit()
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	

function elimina_contacto_plantilla(id)
	{

	var forma = document.principal
	forma.id_anexo_elimina.value = id;
	muestra_alerta_general_solo_texto('elimina_contacto_plantilla_continua()', 'Advertencia', '¿está seguro de eliminar este registro?', 20, 10, 18)
}
function elimina_contacto_plantilla_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_contacto_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function modifica_datos_plantilla()
	{

	var forma = document.principal
	
		
		if(forma.dato1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la plantilla', 20, 10, 18)
				//alert("* Digite el nombre de la plantilla")
				return;
				
				}
		if(forma.dato2.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el sitio de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el sitio de entrega de la plantilla")
				return;
				
				}

		if(forma.dato3.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el la direccion de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el la direccion de entrega de la plantilla")
				return;
				
				}	
		if(forma.dato4.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el horario de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el horario de entrega de la plantilla")
				return;
				
				}					
	muestra_alerta_general_solo_texto('modifica_datos_plantilla_continua()', 'Advertencia', '¿está seguro de modificar este registro?', 20, 10, 18)
	
	}
function modifica_datos_plantilla_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="modifica_datos_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_datos_plantilla()
	{

	var forma = document.principal
	
		
		if(forma.dato0.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el tipo de plantilla', 20, 10, 18)
				//alert("* Seleccione el tipo de plantilla")
				return;
				
				}
if(forma.dato1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la plantilla', 20, 10, 18)
				//alert("* Digite el nombre de la plantilla")
				return;
				
				}
		if(forma.dato2.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el sitio de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el sitio de entrega de la plantilla")
				return;
				
				}

		if(forma.dato3.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el la direccion de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el la direccion de entrega de la plantilla")
				return;
				
				}	
	muestra_alerta_general_solo_texto('crea_datos_plantilla_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
}
function crea_datos_plantilla_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="crea_datos_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_plantilla_total(id){
	var forma = document.principal
	forma.id_anexo_elimina.value = id;
	muestra_alerta_general_solo_texto('elimina_plantilla_total_continua()', 'Advertencia', 'está seguro de eliminar este registro \n * ALERTA: esta acción eliminara permanentemente la plantilla esta seguro de continuar', 20, 10, 18)
}

function elimina_plantilla_total_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_plantilla_total";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function consecutivo_sondeo(valor)
	{
		var forma = document.principal
		
		if(valor==2)
			{
				
				forma.consecutivo.value="";
				
				document.getElementById('alert_consecutivo').innerHTML = 'El consecutivo se creara automaticamente';
				}
			else
			{
				forma.consecutivo.type="text";
				}
	}
function v_fi_ff(ai,mi,di,hi,mii,af,mf,df,hf,mif)
{
        anoi = ai; mesi = mi; diai = di; horai = hi; minutoi = mii
        anof = af; mesf = mf; diaf = df; horaf = hf; minutof = mif;
        /* Toma las fechas y las convierte a milisegundos,
        luego hace la resta y convierte a dias[horas] */
        fechafin = new Date((anof*1),(mesf*1-1),(diaf*1),(horaf*1),(minutof*1),0);
        fechaini = new Date((anoi*1),(mesi*1-1),(diai*1),(horai*1),(minutoi*1),0);
        vplazo = ((fechaini - fechafin)/3600); //Esta si es para horas

		//vplazo = ((fechafin - fechaini)/86400000); //Esta si es para días

        if((vplazo<1))
                return -1;
        else
                return 1;
}


function crea_proceso(ano,mes,dia,hora,minu)
	{
var forma = document.principal;
var msg ="";
var fcierre="";

		if(forma.a.value=="0"){
			msg = msg + "* Seleccione el tipo de proceso\n"
			forma.a.className = "select_faltantes";		
		}

if( (forma.p_t.value=="") && ( forma.tipo_solicitud.value==2) )
{
			msg = msg + "* Digite el porcentaje global de la evaluacion tecnica\n"
			forma.p_t.className = "select_faltantes";		
		}

if( (forma.p_t.value=="") && ( forma.tipo_solicitud.value==1) )
{
	forma.p_t.value=100
		}


if(forma.m_t.value=="")
	forma.m_t.value=100

/*	if(forma.consecutivo.value==""){
			msg = msg + "* Digite el consecutivo\n"
			forma.consecutivo.className = "campos_faltantes";		
		}*/

		if(forma.b.value=="0"){
			msg = msg + "* Seleccione el origen de la solicitud\n"
			forma.b.className = "select_faltantes";		
		}

		if(forma.g.value=="0"){
			msg = msg + "* Seleccione el tipo de contrato\n"
			forma.g.className = "select_faltantes";		
		}

		if(forma.tipo_solicitud.value=="0"){
			msg = msg + "* Seleccione el tipo de contratación\n"
			forma.tipo_solicitud.className = "select_faltantes";		
		}

		if(forma.c.value=="0"){
			msg = msg + "* Seleccione el objeto a contratar\n"
			forma.c.className = "select_faltantes";		
		}

		if(forma.d.value==""){
			msg = msg + "* Digite el objeto\n"
			forma.d.className = "campos_faltantes";		
		}

		if(forma.e.value==""){
			forma.e.value = 0;
		}

		if(forma.k.value=="0"){
			msg = msg + "* Seleccione el contacto\n"
			forma.k.className = "select_faltantes";		
		}



	if(forma.i.value==""){
			msg = msg + "* Seleccione la fecha de apertura\n"
			forma.i.className = "campos_faltantes";		
		}

	if(forma.j.value==""){
			msg = msg + "* Seleccione la fecha de cierre\n"
			forma.j.className = "campos_faltantes";		
		}


		if(forma.i.value!="")
				{
					fcierre = forma.i.value.split(" ");
					f4 = fcierre[0].split("-");
					t4 = fcierre[1].split(":");
					if(v_fi_ff(f4[0],f4[1],f4[2],t4[0],t4[1],ano,mes,dia,hora,minu)==-1){
					msg = msg +  "* Seleccione la feha de apertura del proceso no puede ser menor a la actual\n"
					forma.h.className = "campos_faltantes";
					
					}
					
				}

			if(forma.j.value!="")
				{

					fechacierre = forma.j.value.split(" ");
					fcierre = fechacierre[0].split("-");
					hcierre = fechacierre[1].split(":");	
					
					fechaapertura = forma.i.value.split(" ");
					fapertura = fechaapertura[0].split("-");
					hapertura = fechaapertura[1].split(":");
					
									
					
					if(v_fi_ff(fcierre[0],fcierre[1],fcierre[2],hcierre[0],hcierre[1],fapertura[0],fapertura[1],fapertura[2],hapertura[0],hapertura[1])==-1){
					msg = msg +  "* Seleccione la feha de cierre del proceso no puede ser menor a la de apertura\n"
					forma.j.className = "campos_faltantes";
					
					}
				}


		

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_proceso2_continua()', 'Advertencia', '¿está seguro de Grabar esta Informacion?', 20, 10, 18)
				//var alerta = confirm("Esta seguro de crear este proceso?")
					forma.action = "../librerias/php/procesos_licitacion.php";
					forma.accion.value="crea_proceso"
					
				
				}
		}
		
function crea_proceso2_continua(){
	var forma = document.principal;
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function modifica_proceso(ano,mes,dia,hora,minu)
	{
var forma = document.principal;
var msg ="";
var fcierre="";
if(forma.p_t.value=="")
	forma.p_t.value=100
if(forma.m_t.value=="")
	forma.m_t.value=100

		if(forma.a.value=="0"){
			msg = msg + "* Seleccione el tipo de proceso\n"
			forma.a.className = "select_faltantes";		
		}

		if(forma.consecutivo.value==""){
			msg = msg + "* Digite el consecutivo\n"
			forma.consecutivo.className = "campos_faltantes";		
		}

		if(forma.b.value=="0"){
			msg = msg + "* Seleccione el origen de la solicitud\n"
			forma.b.className = "select_faltantes";		
		}

		if(forma.g.value=="0"){
			msg = msg + "* Seleccione el tipo de contrato\n"
			forma.g.className = "select_faltantes";		
		}

		if(forma.tipo_solicitud.value=="0"){
			msg = msg + "* Seleccione el tipo de contratación\n"
			forma.tipo_solicitud.className = "select_faltantes";		
		}

		if(forma.c.value=="0"){
			msg = msg + "* Seleccione el objeto a contratar\n"
			forma.c.className = "select_faltantes";		
		}

		if(forma.d.value==""){
			msg = msg + "* Digite el objeto\n"
			forma.d.className = "campos_faltantes";		
		}

		if(forma.e.value==""){
			forma.e.value = 0;
		}

		if(forma.k.value=="0"){
			msg = msg + "* Seleccione el contacto\n"
			forma.k.className = "select_faltantes";		
		}




	if(forma.i.value==""){
			msg = msg + "* Seleccione la fecha de apertura\n"
			forma.i.className = "campos_faltantes";		
		}

	if(forma.j.value==""){
			msg = msg + "* Seleccione la fecha de cierre\n"
			forma.j.className = "campos_faltantes";		
		}

			if(forma.i.value!="")
				{
					fcierre = forma.i.value.split(" ");
					f4 = fcierre[0].split("-");
					t4 = fcierre[1].split(":");
					if(v_fi_ff(f4[0],f4[1],f4[2],t4[0],t4[1],ano,mes,dia,hora,minu)==-1){
					msg = msg +  "* Seleccione la feha de apertura del proceso no puede ser menor a la actual\n"
					forma.h.className = "campos_faltantes";
					
					}
					
				}


		

			if(forma.j.value!="")
				{

					fechacierre = forma.j.value.split(" ");
					fcierre = fechacierre[0].split("-");
					hcierre = fechacierre[1].split(":");	
					
					fechaapertura = forma.i.value.split(" ");
					fapertura = fechaapertura[0].split("-");
					hapertura = fechaapertura[1].split(":");
					
									
					
					if(v_fi_ff(fcierre[0],fcierre[1],fcierre[2],hcierre[0],hcierre[1],fapertura[0],fapertura[1],fapertura[2],hapertura[0],hapertura[1])==-1){
					msg = msg +  "* Seleccione la feha de cierre del proceso no puede ser menor a la de apertura\n"
					forma.j.className = "campos_faltantes";
					
					}
				}


		

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_proceso_continua()', 'Advertencia', '¿está seguro de modificar este proceso?', 20, 10, 18)
				
			
				
				
			}
}
		

function modifica_proceso_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="modifica_proceso"
	forma.target="grp"
		forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function crea_proveedor()
	{
var forma = document.principal;
var msg ="";

		if(forma.proveedor.value=="")
			msg = msg + "* Seleccione un proveedor\n"
			
	if( (forma.nuevo_provee_obligato.value==1) && (forma.observa_provee.value == "") )
						msg = msg + "* Digite la razon por la cual invita este proveedor\n"

			
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_proveedor_continua()', 'Advertencia', '¿está seguro de crear este proveedor?', 20, 10, 18)
			}
}

	
function crea_proveedor_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_proveedor"
	forma.target="grp"
		forma.submit()
	//window.parent.document.getElementById("cargando").style.display=""
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function elimina_proveedor(id_elimina)
	{
var forma = document.principal;
forma.id_elimina.value=id_elimina
muestra_alerta_general_solo_texto('elimina_proveedor2_continua()', 'Advertencia', '¿está seguro de eliminar este proveedor de la invitación?', 20, 10, 18)
}
function elimina_proveedor2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_proveedor"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function confirma_asistencia_obli()
	{
	muestra_alerta_general_solo_texto('confirma_asistencia_obli2_continua()', 'Advertencia', '¿está seguro de realizar esta confirmación?\n * ATENCION: Si esta seguro de continuar\n los proveedores que no asistieron a la reunion seran bloqueados', 20, 10, 18)
}
function confirma_asistencia_obli2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="confirma_asistencia_participa";
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function crea_archivo()
	{
var forma = document.principal;
var msg ="";

		if(forma.anexos_s.value=="")
			msg = msg + "* Seleccione un archivo\n"
			
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crea_archivo2_continua()', 'Advertencia', '¿está seguro de crear este archivo?', 20, 10, 18)
			}
}
function crea_archivo2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_archivo"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
		
function elimina_archivo(id_elimina)
	{
var forma = document.principal;
forma.id_elimina.value=id_elimina
muestra_alerta_general_solo_texto('elimina_archivo2_continua()', 'Advertencia', '¿está seguro de eliminar este archivo de la invitación?', 20, 10, 18)
}
function elimina_archivo2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_archivo"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function configura_criterios_evalua_sencilla_tecnicos()
	{
		var forma = document.principal;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion_tecnicos.php";
			forma.accion.value="configura_evaluacion_criterios";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	
	}		
	
function configura_evaluacion_criterios_seleccion()
	{
		var forma = document.principal;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion_tecnicos_sencillos.php";
			forma.accion.value="configura_evaluacion_criterios";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	
	}	
function configura_criterios_evalua_sencilla_juridico()
	{
		var forma = document.principal;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_criterios_juridicos";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	
	}			
	
function crea_criterios_evaluacion(ct,n_c)
	{
			var forma = document.principal;


			if(n_c=="")
							{
								muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre del criterio', 20, 10, 18)
								//alert("* Digite el nombre del criterio")
								return;
								}
			
					
						else
							{

								forma.id_elimina.value=ct
								forma.action = "../librerias/php/procesos_licitacion.php";
								forma.accion.value="crea_criterio_evaluacion"
								forma.target="grp"
								forma.submit()
								forma.action = "";
								forma.accion.value=""
								forma.target=""
								forma.id_elimina.value=""
					
							}
}	

function configura_grupo_evaluacion()
	{
		var forma = document.principal;
			if(forma.valorgrupo.value=="")
				{
					muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la categoría', 20, 10, 18)
					//alert("* Digite el nombre de la categoría")
					return;
					}

		
			else
				{
					forma.action = "../librerias/php/procesos_licitacion.php";
					forma.accion.value="crea_grupo_evaluacion"
					forma.target="grp"
						forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.id_elimina.value=""
				}
	}

function notificar_provvedores(){
	var forma = document.principal;
	
	if(forma.sin_email.value>=1)
		{
			muestra_alerta_error_solo_texto('', 'Error', 'Existen proveedores sin e-mail\n * Por favor agrege el email para porder notificar', 40, 8, 12)
			//alert("Existen proveedores sin e-mail\n por favor agrege el email para porder notificar")
			return;
		}
	if(forma.tipo_solicitud.value=="0"){
			muestra_alerta_error_solo_texto('', 'Error', 'Seleccione el tipo de contratación y después guarde la modificación', 40, 8, 12)
			//msg = msg + "* Seleccione el tipo de contratación\n"
			forma.tipo_solicitud.className = "select_faltantes";
			return;
	}
	muestra_alerta_general_solo_texto('notificar_provvedores_continua()', 'Advertencia', '¿está seguro de enviar la notificación a los proveedores ?\n Cualquier modificación futura al proceso sera notificada a los proveedores\n ¿está seguro ? ', 20, 10, 18)
					
	}	

function notificar_provvedores_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="notifica_proveedores"
	forma.target="grp"
		forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}
function modifica_proceso_notificado(conf)
	{
var forma = document.principal;

if(conf==1){
var forma2 = document.notifica;
forma.justificacion_final.value = forma2.justificacion_ca.value;
close_va();
}
	
var msg ="";

		if(forma.a.value=="0")
			msg = msg + "* Seleccione el tipo de proceso\n"
			
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_proceso_notificado2_continua()', 'Advertencia', '¿está seguro de modificar este proceso?', 20, 10, 18)
					forma.id_elimina.value = conf
				
			}
}
function modifica_proceso_notificado2_continua(){
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="modifica_proceso_notificado_p"
	forma.target="grp"
	var forma = document.principal;
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function suma_valores_tecnicos(valor,espacio){
		

		espacio.value = ( (espacio.value*1) + (valor.value*1) - (document.principal.valor_actual.value) );
		if((espacio.value*1)>100){
			muestra_alerta_error_solo_texto('', 'Error', '*El porcentaje total de los criterios de esta categoria no puede ser mayor al 100%', 20, 10, 18)
			//alert("El porcentaje total de los criterios de esta categoria no puede ser mayor al 100%")
			espacio.value = ( (espacio.value*1) - (valor.value*1) );
			valor.value="";
			
		}
	
	
	
	}			

function crea_articulo()
	{
	var forma = document.principal
	if(forma.a_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el codigo del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(forma.b_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el detalle del producto que le solicitara al proveedor")
		return;
		}
	if(forma.c_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite la unidad de medida del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}
	if(forma.d_economica.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite la cantidad del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la cantidad del producto que le solicitara al proveedor")
		return;
		}
	if(forma.e_economica.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la moneda del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}

	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_articulo";
			forma.submit()
	}
	
}

function sube_archivo()
	{
	var forma = document.principal
	if(forma.archivo_lista.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Anexe el archivo de excel con el listado de articulos.', 20, 10, 18)
		//alert("Anexe el archivo de excel con el listado de articulos.")
		return;
		}
	else
	{
			forma.target="grp";
			forma.action = "configuracion_criteriosmasivo.html";
			forma.accion.value="campo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
	}
	
}

function crea_campo()
	{


	var forma = document.principal
	if(forma.n_campo.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre del requerimiento', 20, 10, 18)
		//alert("* Digite el nombre del requerimiento")
		return;
		}
	if(forma.tipo_campo.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el tipo de requerimiento', 20, 10, 18)
		//alert("* Seleccione el tipo de requerimiento")
		return;
		}

	
	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_campo";
				forma.submit()
	}
	
}

function edita_requerimiento(id_requerimiento,a,b)
	{


	var forma = document.principal

	
	if(a.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre del requerimiento', 20, 10, 18)
		//alert("* Digite el nombre del requerimiento")
		return;
		}
	if(b.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el tipo de requerimiento', 20, 10, 18)
		//alert("* Seleccione el tipo de requerimiento")
		return;
		}

	
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="e_configura_evaluacion_campo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}

function elimina_requerimiento(id_requerimiento)
	{
	var forma = document.principal
	forma.campo_id.value = id_requerimiento;
	muestra_alerta_general_solo_texto('elimina_requerimiento2_continua()', 'Advertencia', '¿está seguro de eliminar este requerimiento?', 20, 10, 18)
}
function elimina_requerimiento2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_configura_evaluacion_campo";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function edita_articulos(id_requerimiento,a,b,c,d,e)
	{


	var forma = document.principal

	
	if(a.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el codigo del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(b.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite el detalle del producto que le solicitara al proveedor")
		return;
		}

	if(c.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite la unidad de medida del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}	
	if(d.value=="")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite la cantidad del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Digite la cantidad del producto que le solicitara al proveedor")
		return;
		}	
		
	if(e.value=="0")
		{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la moneda del producto que le solicitara al proveedor', 20, 10, 18)
		//alert("* Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}	
		
			
						
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="edita_articulos_lista";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}

	
	}

function elimina_articulo(id_requerimiento)
	{
	var forma = document.principal
	forma.campo_id.value = id_requerimiento;
	muestra_alerta_general_solo_texto('elimina_articulo2_continua()', 'Advertencia', '¿está seguro de eliminar este bien o servicio?', 20, 10, 18)
}
function elimina_articulo2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_articulo_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function activar_subasta(campo_activa){
var forma = document.principal
forma.valor_campo.value = campo_activa;
muestra_alerta_general_solo_texto('activar_subasta2_continua()', 'Advertencia', 'está a punto de activar este campo para la subasta ¿está seguro?', 20, 10, 18)
}
function activar_subasta2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="activa_campo_subasta";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function activar_subasta_con(){
muestra_alerta_general_solo_texto('activar_subasta_con2_continua()', 'Advertencia', 'está a punto de activar este campo para la subasta ¿está seguro?', 20, 10, 18)
}
function activar_subasta_con2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="activa_campo_subasta_consolidada";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function c_evaluacion_juridica(){
	muestra_alerta_general_solo_texto('c_evaluacion_juridica2_continua()', 'Advertencia', '¿está seguro de evaluar al proveedor?', 20, 10, 18)
}
function c_evaluacion_juridica2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="evaluacion_juridica";
	forma.submit()
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_articulo_temp(){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_articulo_temporal";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}
	
	
function crea_articulo_temp_uno(id_articulo){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_articulo_temporal_uno_p";
			forma.id_linea.value=id_articulo
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}	
	
	
function guardar_parcial(){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="guardar_parcialmente";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			
	
	
	
	}	
	

function cambia_cantidad(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="cambia_cantidades";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	



	
function elimina_articulo_lista(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="elimina_articulo";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";

	}	
	
	
function abre_proveedores(espacio, id, linea_pasa)
{
	var forma = document.principal
	if(forma.id_elimina.value!="")
		document.getElementById(forma.id_elimina.value).innerHTML = "";
		
		ajax_carga('../aplicaciones/lista_precios/otros_proveedores.php?id_articulo=' + id ,espacio)
		forma.id_elimina.value = espacio
		forma.id_linea.value = linea_pasa
	
	}
	
	
function cerrar_proveedores_lista()
{
	var forma = document.principal
		document.getElementById(forma.id_elimina.value).innerHTML = "";
		forma.id_elimina.value = ""
	
	}	
	
	

function cambia_proveedor_lista(id_c){

			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="cambia_proveedor";
			forma.id_elimina.value = id_c
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
	
function notifica_prove_lista()	{

			
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="notifica_proveedor_articulo";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";
			

	}
	
	
function crea_usuario_lista(){

			var forma = document.principal
			
			if(forma.lista_c.value==0)
				{
					muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la lista', 20, 10, 18)
					//alert("* Seleccione la lista")
					return;
					
					}
			if(forma.b_usuarios.value=="")
				{
					muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el usuario', 20, 10, 18)
					//alert("* Seleccione el usuario")
					return;
					
					}

			if(forma.periocidad.value=="0")
				{
					muestra_alerta_error_solo_texto('', 'Error', '* Seleccione la periocidad', 20, 10, 18)
					//alert("* Seleccione la periocidad")
					return;
					
					}

			if(forma.monto.value=="")
				{
					muestra_alerta_error_solo_texto('', 'Error', '* Digite el monto', 20, 10, 18)
					//alert("* Digite el monto")
					return;
					
					}

else{

forma.target="grp";
			forma.action = "../librerias/php/procesos_listas_precios.php";
			forma.accion.value="crea_usuario_lista";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";
			
}

	}	

function che_lista(){

	var forma = document.principal
	

	if(forma.c_t.checked==true)
		{
	
	 for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
				
				   forma.elements[i].checked=true

				}
		 
		}
		
		}//si lo chequea
		
else
	{
		
	for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
				   forma.elements[i].checked=false

				}
		 
		}
		
		
		
		}
		
}


function ingreso_evaluador_login(){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/valida_ingreso_evaluador.php";
			forma.accion.value="ingreso_evaluacion";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
function abre_procesos_evaluacion_con(linea_pasa)
{
	var forma = document.principal
	

	if(forma.id_limpia.value!="")
		document.getElementById('contrase_'+forma.id_limpia.value).innerHTML = "";
		
		ajax_carga('../aplicaciones/evaluacion/login_acceso.php?id_p='+linea_pasa,'contrase_'+linea_pasa)
		forma.id_limpia.value = linea_pasa
	
	}
	
	
function cerrar_proveedores_lista()
{
	var forma = document.principal
		document.getElementById('contrase_'+forma.id_limpia.value).innerHTML = "";
		forma.id_limpia.value = ""
	
	}		
	

function volver_listado(muestra,oculta)
{
	
	document.getElementById(oculta).innerHTML = '';
	document.getElementById(muestra).style.display = '';
	
	}

function ingresar_listado(oculta)
{
	
	document.getElementById(oculta).style.display = 'none';
	
	}
	


function modifica_proveedor(){
		var forma = document.principal
		var msg=""
	
	if(forma.ap.value==""){
			msg = msg + "* Digite la identificación\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.bp.value==""){
			msg = msg + "* Digite la razón social\n"
			forma.bp.className = "campos_faltantes";		
		}

	if(forma.cp.value==""){
			msg = msg + "* Digite la dirección\n"
			forma.cp.className = "campos_faltantes";		
		}
	if(forma.dp.value==""){
			msg = msg + "* Digite el e-mail\n"
			forma.dp.className = "campos_faltantes";		
		}
	if(forma.ep.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.ep.className = "campos_faltantes";		
		}
	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione el estado\n"
			forma.fp.className = "select_faltantes";		
		}
	if(forma.pais.value=="0"){
			msg = msg + "* Seleccione el país\n"
			forma.pais.className = "select_faltantes";		
		}
	if(forma.depart.value=="0"){
			msg = msg + "* Seleccione el departamento\n"
			forma.depart.className = "select_faltantes";		
		}	
		

	if(forma.ciuadad.value=="0"){
			msg = msg + "* Seleccione la ciudad\n"
			forma.ciuadad.className = "select_faltantes";		
		}
	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('modifica_proveedor2_continua()', 'Advertencia', '¿está seguro de modificar este proveedor?', 20, 10, 18)
			}
}
function modifica_proveedor2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_proveedor.php";
	forma.accion.value="modifica_proveedor"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

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
	
function volver_publico(id_cartelera){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value = "volver_publica";
			forma.id_elimina.value = id_cartelera;
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}
	
function volver_privada(id_cartelera){
			var forma = document.principal
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value = "volver_privada";
			forma.id_elimina.value = id_cartelera;
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";


			forma.target="";
			forma.action = "";
			forma.accion.value="";
			forma.id_elimina.value = "";

	}	
	
function crea_pregunta_general_cartelera_foro(id_pru, valica)
	{

	var forma = document.principal

		
		if(valica.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la respuesta', 20, 10, 18)
				//alert("* Digite el detalle de la respuesta")
				return;
				
				}
		else{
			muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_foro2_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
		}
	
}
function crea_pregunta_general_cartelera_foro2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_general_foro";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_pregunta_general_cartelera_admin()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 40, 8, 12)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}
		else{
			muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_admin2_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
			
		}
	
	}	

function crea_pregunta_general_cartelera_admin2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_general_admin";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function envia_armar_formula(id_campo, valor_forma, nombre_campo){
	
		var forma = document.principal
		if(valor_forma=="1")
			{
				forma.formula_1.value = forma.formula_1.value + "b" + id_campo
				
				}

		if(valor_forma=="2")
			{

			if( (forma.formula_2.value!="0") && (forma.formula_2.value!= id_campo ) )
				{
					var msg = confirm("La formula ya contiene un parametro con minimo valor\n Desea reemplasar la formula con este nuevo parametro")
					var cadena = forma.formula_1.value
					var con_cadena = ""
					if(msg)
							{
								
								
								//while(cadena.indexOf("min(b" + forma.formula_2.value + ")")>=0)
								con_cadena = cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								con_cadena = con_cadena.replace("min(b" + forma.formula_2.value + ")","min(b" + id_campo + ")")
								
								forma.formula_1.value = con_cadena
								forma.formula_1.value = forma.formula_1.value + "min(b" + id_campo + ")"
								
								forma.formula_2.value = id_campo
			
								}
					
					}
			else
				{
					forma.formula_1.value = forma.formula_1.value + "min(b" + id_campo + ")"
					forma.formula_2.value =  id_campo
					
					
					}
				}




		if(valor_forma=="3")
			{

			if( (forma.formula_3.value!="0") && (forma.formula_3.value!= id_campo ) )
				{
					var msg = confirm("La formula ya contiene un parametro con maximo valor\n Desea reemplasar la formula con este nuevo parametro")
					var cadena = forma.formula_1.value
					var con_cadena = ""
					if(msg)
							{
								
								
								//while(cadena.indexOf("min(b" + forma.formula_2.value + ")")>=0)
								con_cadena = cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								con_cadena = con_cadena.replace("max(b" + forma.formula_3.value + ")","max(b" + id_campo + ")")
								
								forma.formula_1.value = con_cadena
								forma.formula_1.value = forma.formula_1.value + "max(b" + id_campo + ")"
								forma.formula_3.value = id_campo
			
								}
					
					}
			else
				{
					forma.formula_1.value = forma.formula_1.value + "max(b" + id_campo + ")"
					forma.formula_3.value =  id_campo
					
					
					}
				}






		if(valor_forma=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione una variable', 20, 10, 18)
				//alert("* Seleccione una variable")
				return;
				}

	
	}

function guardar_formula(t_formula)
	{

	var forma = document.principal

		
		if(forma.formula_1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite formula', 20, 10, 18)
				//alert("* Digite formula")
				return;
				
				}
		if(forma.nombre_formula.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la formula', 20, 10, 18)
				//alert("* Digite el nombre de la formula")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('guardar_formula2_continua()', 'Advertencia', 'está a punto de guardar esta formula ¿está seguro?', 20, 10, 18)
			forma.tipo_formula.value = t_formula
		}
	
}
function guardar_formula2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="Guardar_formula";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_guardar_formula(t_formula)
	{
	var forma = document.principal
	forma.tipo_formula.value = t_formula
	muestra_alerta_general_solo_texto('elimina_guardar_formula2_continua()', 'Advertencia', '¿está a punto de guardar esta formula esta seguro?', 20, 10, 18)
}
function elimina_guardar_formula2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_formula";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crear_nueva_lista()
	{

	var forma = document.principal

		
		if(forma.nombre_lista.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la lista', 20, 10, 18)
				//alert("* Digite el nombre de la lista")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('crear_nueva_lista2_continua()', 'Advertencia', 'está a punto de crear esta lista ¿está seguro?', 20, 10, 18)
		}
	
}
function crear_nueva_lista2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crear_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}	

function editar_nueva_lista()
	{

	var forma = document.principal

		
		if(forma.edita_lista.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la lista', 20, 10, 18)
				//alert("* Digite el nombre de la lista")
				return;
				
				}

		else{
			muestra_alerta_general_solo_texto('editar_nueva_lista2_continua()', 'Advertencia', 'está a punto de editar esta lista ¿está seguro?', 20, 10, 18)
		}
}
function editar_nueva_lista2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="editar_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_nueva_lista()
	{
	muestra_alerta_general_solo_texto('elimina_nueva_lista2_continua()', 'Advertencia', '¿está a punto de eliminar esta lista esta seguro?', 20, 10, 18)
}
function elimina_nueva_lista2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function oculta_lista_item(lista)
	{
		var forma = document.principal

		window.parent.document.getElementById("detalle_item").style.display="";
		
		
		
		}
		
function adjudicacion()
	{
		var forma = document.principal
		var cont = 0; 
 
	if(forma.b.value==0)
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Seleccione un estado del proceso', 20, 10, 18)
		//alert("* Seleccione un estado del proceso")
		return
	}

	if(forma.comentarios_no_adjudica.value==0)
	{
		muestra_alerta_error_solo_texto('', 'Error', '* Digite el comentario', 20, 10, 18)
		//alert("* Digite el comentario")
		return
	}


	else
	{
		muestra_alerta_general_solo_texto('adjudicacion2_continua()', 'Advertencia', 'está a punto de cambiar el estado de este proceso ¿está seguro?', 20, 10, 18)
	}
}
function adjudicacion2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="adjudica_proceso";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_toda_lista()
	{
	muestra_alerta_general_solo_texto('elimina_toda_lista2_continua()', 'Advertencia', 'está a punto de guardar esta lista ¿está seguro?', 20, 10, 18)
}
function elimina_toda_lista2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_toda_lista";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function graba_apertura_licita()
	{

	var forma = document.principal

		if(forma.lugar_apertura.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el lugar de la apertura', 20, 10, 18)
				//alert("* Digite el lugar de la apertura");
				return;
				}
	muestra_alerta_general_solo_texto('graba_apertura_licita2_continua()', 'Advertencia', 'está a punto de guardar y generar el acta de apertura ¿está seguro?', 20, 10, 18)
}
function graba_apertura_licita2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion_apertura.value="graba_apertura";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion_apertura.value="";
}

function muetra_criterios(destino,imagen,id_espacio){
	
		
		if(imagen.name == "muestra_" + id_espacio )
			{
		
				imagen.name = "oculta_" + id_espacio
				document.getElementById(destino).style.display="";
				imagen.src="../imagenes/botones/cierra.png"

				return
				
				}

			if(imagen.name == "oculta_" + id_espacio )
			{
				document.getElementById(destino).style.display="none";
				imagen.name = "muestra_" + id_espacio
				imagen.src="../imagenes/botones/abre.png"				
				return
				
				}

	
	
	}		
	
	


function crear_usuario(){
		var forma = document.principal
		var msg=""

	if(forma.usuario_pasa.value==""){
			msg = msg + "* Digite el usuario\n"
			forma.usuario_pasa.className = "campos_faltantes";		
		}

if(forma.ap.value==""){
			msg = msg + "* Digite el nombre\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.email.value==""){
			msg = msg + "* Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}

	if(forma.dp.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.dp.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "* Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione un estado\n"
			forma.fp.className = "campos_faltantes";		
		}

	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				muestra_alerta_general_solo_texto('crear_usuario2_continua()', 'Advertencia', '¿está seguro de crear este usuario?', 20, 10, 18)
			}
}
function crear_usuario2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="crea_usuario" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function modifica_usuario(){
		var forma = document.principal
		var msg=""



if(forma.ap.value==""){
			msg = msg + "* Digite el nombre\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.email.value==""){
			msg = msg + "* Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}

	if(forma.dp.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.dp.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "* Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.fp.value=="0"){
			msg = msg + "* Seleccione un estado\n"
			forma.fp.className = "campos_faltantes";		
		}

	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
		{
			muestra_alerta_general_solo_texto('modifica_usuario2_continua()', 'Advertencia', '¿está seguro de modificar este usuario?', 20, 10, 18)
		}
}
function modifica_usuario2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="modifica_usuario" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function crear_registro_n(){
		var forma = document.principal
		var msg=""

	if(forma.n_resgitro.value==""){
			msg = msg + "* Digite el registro\n"
			campo.className = "campos_faltantes";		
		}

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
		{
			muestra_alerta_general_solo_texto('crear_registro_n2_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
		}
}
function crear_registro_n2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="crea_registro"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function modifica_registro_n(campo,registro){
		var forma = document.principal
		var msg=""

	if(campo.value==""){
			msg = msg + "* Digite el registro\n"
			campo.className = "campos_faltantes";		
		}

		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
		{
			muestra_alerta_general_solo_texto('modifica_registro_n2_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
			forma.id_maestra.value=registro;
		}
}
function modifica_registro_n2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_admin.php";
	forma.accion.value="edita_registro"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

 function exportToXL(eSrc) {
 var oExcel; 
var oExcelSheet; 
var oWkBooks;
 var cols; 
oExcel = new ActiveXObject('Excel.Application');
 oWkBooks = oExcel.Workbooks.Add;
 oExcelSheet = oWkBooks.Worksheets(1);
 oExcelSheet.Activate();
 if (eSrc.tagName != 'TABLE') {
 	muestra_alerta_error_solo_texto('', 'Error', '* No ha sido posible exportar la tabla a excell', 20, 10, 18)
 //alert('No ha sido posible exportar la tabla a excell');
 return false;
 }
 cols = Math.ceil(eSrc.cells.length / eSrc.rows.length);
 for (var i = 0; i < eSrc.cells.length; i ++)
 {
 var c, r;
 r = Math.ceil((i+1) / cols);
 c = (i+1)-((r-1)*cols)
 if (eSrc.cells(i).tagName == 'TH') { 
oExcel.ActiveSheet.Cells(r,c).Font.Bold = true;
 oExcel.ActiveSheet.Cells(r,c).Interior.Color = 14474460; 
}
 if (eSrc.cells(i).childNodes.length > 0 && eSrc.cells(i).childNodes(0).tagName == "B") 
oExcel.ActiveSheet.Cells(r,c).Font.Bold = true;
 oExcel.ActiveSheet.Cells(r,c).Value = eSrc.cells(i).innerText;
 }
 oExcelSheet.Application.Visible = true;
 }

function apertura_proceso_auditor(){
	muestra_alerta_general_solo_texto('apertura_proceso_auditor2_continua()', 'Advertencia', '¿está seguro de confirmar la apertura del proceso?', 20, 10, 18)
}
function apertura_proceso_auditor2_continua(){
	var forma = document.principal
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="confirma_acta_apertura" 
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function crea_bitacora()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos: * Digite el detalle de la pregunta', 40, 8, 12)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}
		else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="crea_bitacora";
				forma.submit()
					//////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}		


function crea_cartelera_final()
	{

	var forma = document.principal
		if(forma.asunto_cartelera.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el asunto de la pregunta', 20, 10, 18)
				//alert("* Digite el asunto de la pregunta")
				return;
				
				}
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}	
		if(forma.h_m_r.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite la fecha maxima de respuesta', 20, 10, 18)
				//alert("* Digite la fecha maxima de respuesta")
				return;
				
				}					


		else{
			muestra_alerta_general_solo_texto('crea_cartelera_final2_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
		}
}
function crea_cartelera_final2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="crea_pregunta_aclaracion_final";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_proveedor_adentro(){
		var forma = document.principal
		var msg=""
	
	/*if(forma.ap.value==""){
			msg = msg + "* Digite la identificación\n"
			forma.ap.className = "campos_faltantes";		
		}
*/

	if(forma.bp.value==""){
			msg = msg + "* Digite la razón social\n"
			forma.bp.className = "campos_faltantes";		
		}

	if(forma.cp.value==""){
			msg = msg + "* Digite la dirección\n"
			forma.cp.className = "campos_faltantes";		
		}
	if(forma.email_contacto.value==""){
			msg = msg + "* Digite el e-mail\n"
			forma.email_contacto.className = "campos_faltantes";		
		}
	if(forma.ep.value==""){
			msg = msg + "* Digite el teléfono\n"
			forma.ep.className = "campos_faltantes";		
		}
	

	if(forma.ciuadad.value=="0"){
			msg = msg + "* Seleccione la ciudad\n"
			forma.ciuadad.className = "select_faltantes";		
		}
	
			if(forma.conta_2.value==""){
			msg = msg + "* Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="crea_proveedor_adentro";
			forma.submit()
			//////window.parent.document.getElementById("cargando").style.display="";
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
					
				}


	
	}		

function crea_adju_provee(pasa)
	{

	var forma = document.principal
		
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_adjudicacion_proverdor";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	
	}	
	

function crea_adju_provee_servicios(pasa)
	{

	var forma = document.principal
	
		
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
			forma.accion.value="crea_adjudicacion_proverdor";
			forma.pv_id.value = pasa
			
			
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	
	}	
function edita_adju_provee(pasa)
	{

	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('edita_adju_provee2_continua()', 'Advertencia', '¿está seguro de modificar los datos de adjudicación?', 20, 10, 18)
}
function edita_adju_provee2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="ed_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_adju_provee(pasa)
	{

	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('elimina_adju_provee2_continua()', 'Advertencia', '¿está seguro de desvincular este proveedor de la adjudicación?', 20, 10, 18)
}
function elimina_adju_provee2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="el_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_adju_provee_servicios(pasa)
	{

	var forma = document.principal
	forma.pv_id.value = pasa
	muestra_alerta_general_solo_texto('elimina_adju_provee_servicios2_continua()', 'Advertencia', '¿está seguro de desvincular este proveedor de la adjudicación?', 20, 10, 18)
}
function elimina_adju_provee_servicios2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
	forma.accion.value="el_adjudicacion_proverdor";
	forma.submit()
	forma.pv_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function add_email(pasa)
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="add_email_c";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	}		
		
function elim_email_ad(pasa)
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="elimi_email_c";
			forma.pv_id.value = pasa
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	
	}			
	
	function graba_archivo_soporte_adj_proveedor(){
		var forma = document.principal
		var msg=""
	
	if(forma.arc_soporte.value==""){
			msg = msg + "* Seleccione un archivo\n"
			forma.arc_soporte.className = "campos_faltantes";		
		}
	
		if(msg!="")
			{
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_archivo_soporte_adj_proveedor";
			forma.submit()
			////window.parent.document.getElementById("cargando").style.display="";
			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
					
				}


	
	}		

function elimina_archivo_soporte_adj_proveedor(id_elimina)
	{
var forma = document.principal;
forma.id_anexo.value=id_elimina
muestra_alerta_general_solo_texto('elimina_archivo_soporte_adj_proveedor2_continua()', 'Advertencia', '¿está seguro de eliminar este archivo de la invitación?', 20, 10, 18)
}
function elimina_archivo_soporte_adj_proveedor2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_archivo_soporte_adj_proveedor"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
	forma.id_elimina.value=""
}

function canfirma_notificacion_js()
	{
var forma = document.principal;
var msg ="";

/*				var alerta = confirm("Esta seguro de notificar este proceso ?")
				if(alerta){ */
					
					
					forma.action = "../librerias/php/procesos_adjudicacion.php";
					forma.accion.value="canfirma_notificacion"
					forma.target="grp"
						forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.id_elimina.value=""
					
					//}
		}	

function canfirma_notificacion_js_SERVICIOS()
	{
var forma = document.principal;
var msg ="";

/*				var alerta = confirm("Esta seguro de notificar este proceso ?")
				if(alerta){ */
					
					
					forma.action = "../librerias/php/procesos_adjudicacion_servicios.php";
					forma.accion.value="canfirma_notificacion"
					forma.target="grp"
						forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					forma.id_elimina.value=""
					
					//}
		}	

function comentario_adjudicacion()
	{
		var forma = document.principal;
		
		if(forma.observacion_foro.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el comentario.', 20, 10, 18)
				//alert("* Digite el comentario.")
				return
				
				}
		
		else{
				forma.target="grp";
				forma.action = "../librerias/php/procesos_adjudicacion.php";
				forma.accion.value="nuevo_ad_foro";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
		}
	}	

function crea_nuevo_contacto()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="nuevo_add";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	
	

function crea_nuevo_contacto_adj()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="nuevo_add_adjudicacion";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	


function elimina_contacto_todo(id_elimina){
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="elimina_contacto_todo";
				forma.id_elimina.value=id_elimina;
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
						forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}	
	



function elimina_contacto_todo_adj(id_elimina){
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="elimina_contacto_todo_adj";
				forma.id_elimina.value=id_elimina;
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
						forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}	
function crea_elimina(che,id_elimina)	{
	var forma = document.principal;
		if(che==true)
			{
				
				forma.accion.value="nuevo_add_relacion";
				forma.id_elimina.value=id_elimina;
				
				}

		if(che==false)
			{
				
				forma.accion.value="elimina_add_relacion";
				forma.id_elimina.value=id_elimina;
				
				}

			forma.action = "../librerias/php/procesos_nuevos_contactos.php";
			forma.target="grp";
			forma.submit()
			////window.parent.document.getElementById("cargando").style.display="";	
		
		
					forma.action = "";
					forma.target="";
					forma.id_elimina.value=0;
	
	}		

function notificar_nuevo_contacto()	{
	var forma = document.principal;
		

				forma.target="grp";
				forma.action = "../librerias/php/procesos_nuevos_contactos.php";
				forma.accion.value="notifica_otra_vez_add";
					forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";
			
		
	
	}	

	
	
function elim_email_marcados()
	{

	var forma = document.principal
		
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="elimi_email_todos";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.pv_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";
	}	
	
function cheque_todo(valor)
	{

	var forma = document.principal
		
		 for (i=0;i<forma.elements.length;i++)
   		{ 
       		if(forma.elements[i].type == "checkbox")
			   	{
					if(valor==true)		
					   forma.elements[i].checked=true
				if(valor==false)		
					   forma.elements[i].checked=false


				}
		 
		}
	}		
	
	
function crea_soporte()
	{

	var forma = document.principal

		
		if(forma.pregunta_general.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
				//alert("* Digite el detalle de la pregunta")
				return;
				
				}
		else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_soporte.php";
			forma.accion.value="crea_soporte";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	

function crea_plantilla_copia()
	{

	var forma = document.principal

		
		if(forma.sel1.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el comprador', 20, 10, 18)
				//alert("* Seleccione el comprador")
				return;
				
				}
		if(forma.sel2.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el Destino Final /Centro Logístico', 20, 10, 18)
				//alert("* Seleccione el Destino Final /Centro Logístico")
				return;
				
				}

		if(forma.sel3.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el Operadores Logísticos', 20, 10, 18)
				//alert("* Seleccione el Operadores Logísticos")
				return;
				
				}


else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_conbina_plantilla";
				forma.submit()
					//////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	

function elimina_proceso_sin_abrir(id_elimina_p)
	{

	var forma = document.principal		
		muestra_alerta_general_solo_texto('elimina_proceso_sin_abrir_continua()', 'Advertencia', '¿está seguro de eliminar proceso?', 20, 10, 18)
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="elimina_proceso_sin_abrir";
			forma.id_limpia.value=id_elimina_p;	
	}	

function elimina_proceso_sin_abrir_continua(){
	var forma = document.principal;
	forma.submit()
	forma.campo_id.value = "";
	forma.id_limpia.value="";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
function crea_sub_usuario_j_admin()
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
				muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)
				//alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
		{
			muestra_alerta_general_solo_texto('crea_sub_usuario_j_admin2_continua()', 'Advertencia', '¿está seguro de crear este proceso?', 20, 10, 18)
		}
}
function crea_sub_usuario_j_admin2_continua(){
	var forma = document.principal;
	forma.action = "../librerias/php/procesos_nuevos_contactos.php";
	forma.accion.value="crea_sub_usuario"
	forma.target="grp"
	forma.submit()
	forma.action = "";
	forma.accion.value=""
	forma.target=""
}

function edita_sub_usuario_adm(id_requerimiento,a,b,c)
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
		//alert("* Digite el E-mail")
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
					forma.action = "../librerias/php/procesos_nuevos_contactos.php";
			forma.accion.value="e_sub_usuario";
				forma.submit()
					////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
}	

function crea_contacto_plantilla()
	{

	var forma = document.principal

		
		if(forma.con_grupo.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el grupo', 20, 10, 18)
				//alert("* Digite el grupo")
				return;
				
				}
		if(forma.con_nombre.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre', 20, 10, 18)
				//alert("* Digite el nombre")
				return;
				
				}

		if(forma.con_email.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el e-mail', 20, 10, 18)
				//alert("* Digite el e-mail")
				return;
				
				}


else{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_adjudicacion.php";
			forma.accion.value="crea_contacto_plantilla";
				forma.submit()
					//////window.parent.document.getElementById("cargando").style.display="";

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

		}
	
	}	

function elimina_contacto_plantilla(id)
	{

	var forma = document.principal
	forma.id_anexo_elimina.value = id;
	muestra_alerta_general_solo_texto('elimina_contacto_plantilla2_continua()', 'Advertencia', '¿está seguro de eliminar este registro?', 20, 10, 18)
}
function elimina_contacto_plantilla2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_contacto_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function modifica_datos_plantilla()
	{

	var forma = document.principal
	
		
		if(forma.dato1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la plantilla', 20, 10, 18)
				//alert("* Digite el nombre de la plantilla")
				return;
				
				}
		if(forma.dato2.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el sitio de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el sitio de entrega de la plantilla")
				return;
				
				}

		if(forma.dato3.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el la direccion de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el la direccion de entrega de la plantilla")
				return;
				
				}	
		if(forma.dato4.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el horario de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el horario de entrega de la plantilla")
				return;
				
				}					
	muestra_alerta_general_solo_texto('modifica_datos_plantilla2_continua()', 'Advertencia', '¿está seguro de modificar este registro?', 20, 10, 18)
}
function modifica_datos_plantilla2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="modifica_datos_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_datos_plantilla()
	{

	var forma = document.principal
	
		
		if(forma.dato0.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el tipo de plantilla', 20, 10, 18)
				//alert("* Seleccione el tipo de plantilla")
				return;
				
				}
if(forma.dato1.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el nombre de la plantilla', 20, 10, 18)
				//alert("* Digite el nombre de la plantilla")
				return;
				
				}
		if(forma.dato2.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el sitio de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el sitio de entrega de la plantilla")
				return;
				
				}

		if(forma.dato3.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite el la direccion de entrega de la plantilla', 20, 10, 18)
				//alert("* Digite el la direccion de entrega de la plantilla")
				return;
				
			}	
				
	muestra_alerta_general_solo_texto('crea_datos_plantilla2_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
}
function crea_datos_plantilla2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="crea_datos_plantilla";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function elimina_plantilla_total(id)
	{

	var forma = document.principal
	forma.id_anexo_elimina.value = id;
	muestra_alerta_general_solo_texto('elimina_plantilla_total2_continua()', 'Advertencia', '¿está seguro de eliminar este registro? * ALERTA: esta acción eliminara permanentemente la plantilla esta seguro de continuar', 20, 10, 18)
}
function elimina_plantilla_total2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="elimina_plantilla_total";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function consecutivo_sondeo()
	{
		var forma = document.principal
		if(forma.a.value==2)
			{
				forma.consecutivo.type="hidden";
				document.getElementById('alert_consecutivo').innerHTML = 'El consecutivo se creara automaticamente';
				}
			else
			{
				forma.consecutivo.type="text";
				}
	}

function ver_respuestas_adjudi(muestra)
{
	var forma = document.principal
	
	document.getElementById(muestra).style.display = '';

	
	}	

function oculta_respuestas_adjudi(muestra)
{
	var forma = document.principal
	
	document.getElementById(muestra).style.display = 'none';

	
	}

	
function cierra_adjudica_reporte(pro1_id_pasa_a)
	{

	var forma = document.principal
	forma.pro1_id_pasa.value = pro1_id_pasa_a;
	muestra_alerta_general_solo_texto('cierra_adjudica_reporte2_continua()', 'Advertencia', '¿está seguro de modificar este registro?', 20, 10, 18)
}
function cierra_adjudica_reporte2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="cierra_adjudica_reporte";
	forma.submit()
	forma.pro1_id_pasa.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function nuevo_ad_foro_reporte(pro1_id_pasa_a, pro32id_pasa_a)
	{

	var forma = document.principal
	forma.pro1_id_pasa.value = pro1_id_pasa_a;
	forma.pro32id_pasa.value = pro32id_pasa_a;
	muestra_alerta_general_solo_texto('nuevo_ad_foro_reporte2_continua()', 'Advertencia', '¿está seguro de modificar este registro?', 20, 10, 18)
}
function nuevo_ad_foro_reporte2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_adjudicacion.php";
	forma.accion.value="nuevo_ad_foro_reporte";
	forma.submit()
	forma.pro1_id_pasa.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

	function poner_firme_evaluacion_tecnica(){
		muestra_alerta_general_solo_texto('poner_firme_evaluacion_tecnica2_continua()', 'Advertencia', '¿está seguro de poner en firme la evaluacion?', 20, 10, 18)
}
function poner_firme_evaluacion_tecnica2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="poner_firme_evaluacion_tecnica";
	forma.submit()
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function exporta_reporte_pr ()
	{
		var forma = document.principal;
					forma.action = "../aplicaciones/reportes/re1_excel_2.php";
					forma.accion.value="confirma_descarga_documentos"
					forma.target="grp"
						forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
		}

function exporta_reporte ()
	{
		var forma = document.principal;
					forma.action = "../aplicaciones/reportes/re1_excel.php";
					forma.accion.value="confirma_descarga_documentos"
					forma.target="grp"
						forma.submit()
					////window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
		}
		
function modifica_fecha_limite_final ()
	{
	muestra_alerta_general_solo_texto('modifica_fecha_limite_final2_continua()', 'Advertencia', 'está a punto de modificar la fecha limite d erespuesta ¿desea continuar?', 20, 10, 18)
}
function modifica_fecha_limite_final2_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="modifica_fecha_limite_final";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function crea_extratiempo()
	{
	muestra_alerta_general_solo_texto('crea_extratiempo2_continua()', 'Advertencia', '¿está a punto de crear esta solicitud antes de apertura?', 20, 10, 18)
}
function crea_extratiempo2_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="creacion_extratiempo";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}	

function elimina_usuario_proveedor(id_pv_s)
	{
		var forma = document.principal;
		forma.pv_id_usuario_elimin.value=id_pv_s;
		muestra_alerta_general_solo_texto('elimina_usuario_proveedor2_continua()', 'Advertencia', 'está a punto de eliminar este usuario ¿está seguro?', 20, 10, 18)
}
function elimina_usuario_proveedor2_continua(){
	var forma = document.principal;
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="elimina_usuario_proveedor";
	forma.submit()
	forma.campo_id.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

function devolver_poner_firme_evaluacion_tecnica(){
muestra_alerta_general_solo_texto('devolver_poner_firme_evaluacion_tecnica2_continua()', 'Advertencia', '¿está seguro de devolver la evaluacion?', 20, 10, 18)
}
function devolver_poner_firme_evaluacion_tecnica2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="devolver_poner_firme_evaluacion_tecnica";
	forma.submit()
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}

		function busqueda_paginador_nuevo_reporte(pagina,ruta_pagina,espacio, alerta)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			
			if(forma.f_a.value == ""){
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el rango de fecha inicial del reporte', 20, 10, 18)
				//alert("* Seleccione el rango de fecha inicial del reporte")
				return
			}
			if(forma.f_c.value == ""){
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el rango de fecha final del reporte', 20, 10, 18)
				//alert("* Seleccione el rango de fecha final del reporte")
				return
			}

			
			for (i=0;i<nume_elementos;i++)
			 {
			 
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + forma.elements[i].value
			}


	compl = "actividad_pru=" + cadena_str

	
	ajax_carga(ruta_pagina + '?pag=' + pagina + '&tipo_ingreso_alerta=' + alerta +  cadena_str,espacio)
	
	
	
	}

	function grabar_evaluacion_tecnico()
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			//var nume_elementos = forma.elements.length;
			
		if(forma.responsable_tec_nuevo.value=="0")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Seleccione el nuevo evaluador técnico', 20, 10, 18)
				//alert("* Seleccione el nuevo evaluador técnico")
				return;
				
				}	
		if(forma.observacion_cambia_tecnico.value=="")
			{
				muestra_alerta_error_solo_texto('', 'Error', '* Digite las observaciones del cambio', 20, 10, 18)
				//alert("* Digite las observaciones del cambio")
				return;
				
				}					
			muestra_alerta_general_solo_texto('grabar_evaluacion_tecnico2_continua()', 'Advertencia', '¿está seguro de crear este registro?', 20, 10, 18)
}
function grabar_evaluacion_tecnico2_continua(){
	var forma = document.principal
	forma.target="grp";
	forma.action = "../librerias/php/procesos_licitacion.php";
	forma.accion.value="cambia_evaluador_tecnico";
	forma.submit()
	forma.id_anexo_elimina.value = "";
	forma.target="";
	forma.action = "";
	forma.accion.value="";
}
/*
	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', '* Digite el detalle de la pregunta', 20, 10, 18)
	
	window.parent.muestra_alerta_iformativa_solo_texto( '','* Digite el detalle de la pregunta', 20, 10, 18)

	muestra_alerta_error_solo_texto('', 'Error', 'Por favor verificar los siguientes campos:'+msg, 40, 8, 12)

	muestra_alerta_general_solo_texto('crea_pregunta_general_cartelera_admin_continua()', 'Advertencia', 'está a punto de enviar esta aclaración ¿está seguro?', 20, 10, 18)
*/