
function novedad_en_firme(){
	var forma = document.principal
			
			forma.action = "../librerias/php/mesa_ayuda_procesos_admin.php";
			forma.accion.value="novedad_en_firme" 
			forma.target="grp"
			forma.submit()
//			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
	
	}
function eliminar_area_gestor(is_area_elim){
	var forma = document.principal
			
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="elimina_area_gestor" 
			forma.id_area_elimina.value=is_area_elim
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
	
	}
function agrega_area_gestor(){
	var forma = document.principal
			
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="agrega_area_gestor" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
	
	}

function busqueda_paginador_nuevo(pagina,ruta_pagina,espacio)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			
			

			
			for (i=0;i<nume_elementos;i++)
			 {
			 
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + forma.elements[i].value
			}


	compl = "actividad_pru=" + cadena_str


	ajax_carga(ruta_pagina + '?pag=' + pagina + '&' + cadena_str,espacio)
	
	
	
	}
	
	
function busqueda_paginador_nuevo_tarifas(pagina,ruta_pagina,espacio,numero_input)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			var campos_valor = "";
			var encontro_id_cont = "NO";
			
			numero_input = 50;
			
			for (i=0;i<numero_input;i++)
			 {
				
			if(forma.elements[i]){//si el campo existe
				if((forma.elements[i].type!="textarea") && (forma.elements[i].type!="button" && forma.elements[i].value != "")){
				campos_valor = forma.elements[i].value;
				var resul = campos_valor.replace(/&/gi, encodeURIComponent("&"));
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + resul
				if(forma.elements[i].name == "id_contrato"){//busca si cojio el id contrato si no para incluirlo mas abajo
				encontro_id_cont == "SI"
				}
				
				}
			}
			}
			
			
			
			if(forma.id_contrato && encontro_id_cont == "NO"){// si el campo existe y no a llenado dicho campo en la cadena del for
				cadena_str = 'id_contrato=' + forma.id_contrato.value +'&'+cadena_str
				}



	compl = "actividad_pru=" + cadena_str
	


	ajax_carga(ruta_pagina + '?pag=' + pagina + '&' + cadena_str,espacio)
	
	
	
	}	
	
	
	function puntitos(donde,caracter)
{

pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true

if(isNaN(caracter) || pat.test(caracter) == true)
	{
	if (pat.test(caracter)==true) 
		{caracter = "\\" + caracter}
	carcter = new RegExp(caracter,"g")
	valor = valor.replace(carcter,"")
	donde.value = valor
	crtr = false
	}
else
	{
	var nums = new Array()
	cont = 0
	for(m=0;m<largo;m++)
		{
		if(valor.charAt(m) == "." || valor.charAt(m) == " " || valor.charAt(m) == ",")
			{continue;}
		else{
			nums[cont] = valor.charAt(m)
			cont++
			}
		
		}
	}


var cad1="",cad2="",tres=0
if(largo > 3 && crtr == true)
	{
	for (k=nums.length-1;k>=0;k--)
		{
		cad1 = nums[k]
		cad2 = cad1 + cad2
		tres++
		if((tres%3) == 0)
			{
			if(k!=0){
				cad2 = "," + cad2
				}
			}
		}
	 donde.value = cad2
	}

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
	

function crear_usuario(){
		var forma = document.principal
		var msg=""

	if(forma.usuario_pasa.value==""){
			msg = msg + "Digite el usuario\n"
			forma.usuario_pasa.className = "campos_faltantes";		
		}

	if(forma.nombre_administrador.value==""){
			msg = msg + "Digite el nombre\n"
			forma.nombre_administrador.className = "campos_faltantes";		
		}


	if(forma.email.value==""){
			msg = msg + "Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}

	if(forma.telefono.value==""){
			msg = msg + "Digite el teléfono\n"
			forma.telefono.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.estado.value=="0"){
			msg = msg + "Seleccione un estado\n"
			forma.estado.className = "campos_faltantes";		
		}

	if(forma.conta_1.value=="" && !forma.contra_autom.checked){
			msg = msg + "Asigne una contraseña o active la casilla de contraseña automática\n"
			forma.conta_1.className = "campos_faltantes";
			forma.contra_autom.className = "campos_faltantes";
		}
	
	if(forma.conta_1.value!=""){
		if(forma.conta_2.value==""){
			msg = msg + "Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
		}
		if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
		}		
	}
	
	if(msg!=""){
		alert("Verifique el formulario\n" + msg)
		return
		}
	else{
		var alerta = confirm("Esta seguro de crear este usuario?")
		if(alerta){
			
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="crea_usuario" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			forma.action = "";
			forma.accion.value=""
			forma.target=""
			}
		
	}
}		
	
	
function modifica_usuario(){
		var forma = document.principal
		var msg=""

if (forma.email_valida_empleado.value != "hocol.com.co" && forma.fecha_vigencia.value == '') {
			msg = msg + "Al ser un usuario contratista es obligatorio que este tenga una fecha de vigencia\n"		
			forma.fecha_vigencia.className = "campos_faltantes";
}
if(forma.ap.value==""){
			msg = msg + "Digite el nombre\n"
			forma.ap.className = "campos_faltantes";		
		}

/*
	if(forma.email.value==""){
			msg = msg + "Digite el email\n"
			forma.email.className = "campos_faltantes";		
		}
*/
	if(forma.dp.value==""){
			msg = msg + "Digite el teléfono\n"
			forma.dp.className = "campos_faltantes";		
		}


	if(forma.perfil.value=="0"){
			msg = msg + "Seleccione un perfil\n"
			forma.perfil.className = "campos_faltantes";		
		}

	if(forma.fp.value=="0"){
			msg = msg + "Seleccione un estado\n"
			forma.fp.className = "campos_faltantes";		
		}

	
	if(forma.conta_1.value!=""){
		
			if(forma.conta_2.value==""){
			msg = msg + "Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
								}
		
		
	}
	

	
		if(msg!="")
			{
				alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				var alerta = confirm("Esta seguro de modificar este usuario ?")
				if(alerta){
					
					forma.action = "../librerias/php/procesos_admin.php";
					forma.accion.value="modifica_usuario" 
					forma.target="grp"
						forma.submit()
					window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					
					}
				
				}


	
	}

function elimina_usuario(){
		var forma = document.principal
		var msg=""
		if(msg!="")
			{
				alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
				var alerta = confirm("Esta seguro de eliminar este usuario ?")
				if(alerta){
					
					forma.action = "../librerias/php/procesos_admin.php";
					forma.accion.value="elimina_usuario" 
					forma.target="grp"
						forma.submit()
					window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
					forma.target=""
					
					}
				
				}


	
	}
	
	function agrega_usuario_area(){
		var forma = document.principal
		var msg=""
		if(forma.t1_area.value=="0"){
			msg = msg + "Seleccione un Area\n"
			forma.t1_area.className = "select_faltantes";		
		}
		
		if(forma.profesional.value!="0"){
			
			if(forma.corporativo.value=="0"){
				msg = msg + "Seleccione un Comprador Corporativo\n"
				forma.corporativo.className = "select_faltantes";		
			}/*
			if(forma.proyectos.value=="0"){
				msg = msg + "Seleccione un Comprador Proyectos\n"
				forma.proyectos.className = "select_faltantes";		
			}
			if(forma.stock.value=="0"){
				msg = msg + "Seleccione un Comprador Stock\n"
				forma.stock.className = "select_faltantes";		
			}*/
		}
		
		if(msg!=""){
			alert("Verifique el formulario\n" + msg)
			return
		}
		else{
		var alerta = confirm("Esta seguro de realizar este cambio ?")
		if(alerta){
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="agrega_usuario_area" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			}
		}

	}
	
	function elimina_usuario_area(id_usuario,id_area){
		var forma = document.principal
		var alerta = confirm("Esta seguro de realizar este cambio ?")
		if(alerta){
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="elimina_usuario_area" 
			forma.id_usuario.value = id_usuario
			forma.id_area.value = id_area
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			}
		}
		
	function agrega_usuario_rol(){
		var forma = document.principal
		var msg=""
		var chks = forma.elements['rol_usuario[]'];
		var hasChecked = true;
		for (var i=0;i<chks.length;i++){
			if (chks[i].checked){
				hasChecked = false;
			}
		}
		if (hasChecked==true){
			msg = msg + "* Debe Seleccionar Roles\n"
			
		}
		if(msg!=""){
			alert("Verifique el formulario\n" + msg)
			return
		}
		else{
		var alerta = confirm("Esta seguro de realizar este cambio ?")
		if(alerta){
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="agrega_usuario_rol" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			}
		}
	}
	
	function agrega_usuario_permiso(){
		var forma = document.principal
		var msg=""
		var chks = forma.elements['perm_usuario[]'];
		var hasChecked = true;
		for (var i=0;i<chks.length;i++){
			if (chks[i].checked){
				hasChecked = false;
			}
		}
		if (hasChecked==true){
			msg = msg + "* Debe Seleccionar Permisos\n"
			
		}
		if(msg!=""){
			alert("Verifique el formulario\n" + msg)
			return
		}
		else{
		var alerta = confirm("Esta seguro de realizar este cambio ?")
		if(alerta){
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="agrega_usuario_permiso" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			}
		}
	}
	
	function agrega_usuario_emula(){
		var forma = document.principal
		var msg=""
		if(forma.id_us_emula.value=="0"){
			msg = msg + "Seleccione un Usuario\n"
			forma.id_us_emula.className = "select_faltantes";		
		}
		if(msg!=""){
			alert("Verifique el formulario\n" + msg)
			return
		}
		else{
		var alerta = confirm("Esta seguro de realizar este cambio ?")
		if(alerta){
			forma.action = "../librerias/php/procesos_admin.php";
			forma.accion.value="agrega_usuario_emula" 
			forma.target="grp"
			forma.submit()
			window.parent.document.getElementById("cargando").style.display=""
			}
		}

	}
	
	function elimina_usuario_emula(id_emula){
	var forma = document.principal
	var alerta = confirm("Esta seguro de realizar este cambio ?")
	if(alerta){
		forma.action = "../librerias/php/procesos_admin.php";
		forma.accion.value="elimina_usuario_emula" 
		forma.id_emula.value = id_emula
		forma.target="grp"
		forma.submit()
		window.parent.document.getElementById("cargando").style.display=""
		}
	}
	
function reasignar_usuarios(relacion){
	var forma = document.principal;
	var msg = "";
	var chks = forma.elements['id_us_'+relacion+'[]'];
	var hasChecked = true;
	for (var i=0;i<=chks.length;i++){
		if (chks[i].checked){
			hasChecked = false;
		}
	}
	if (hasChecked==true){
		msg = msg + "* Debe Seleccionar Usuarios\n"
	}
	switch(relacion){
		case 1:
			if(forma.profesional.value=="0"){
				msg = msg + "* Seleccione un Profesional\n"
				forma.profesional.className = "select_faltantes";		
			}
		break;
		case 2:
			if(forma.corporativo.value=="0"){
				msg = msg + "* Seleccione un Comprador Corporativo\n"
				forma.corporativo.className = "select_faltantes";		
			}
		break;
		case 3:
			if(forma.proyectos.value=="0"){
				msg = msg + "* Seleccione un Comprador Proyectos\n"
				forma.proyectos.className = "select_faltantes";		
			}
		break;
		case 4:
			if(forma.stock.value=="0"){
				msg = msg + "* Seleccione un Comprador Stock\n"
				forma.stock.className = "select_faltantes";		
			}
		break;
		case 5:
			if(forma.jefeArea.value=="0"){
				msg = msg + "* Seleccione un Jefe de Area\n"
				forma.jefeArea.className = "select_faltantes";		
			}
		break;
		case 6:
			if(forma.jefatura.value=="0"){
				msg = msg + "* Seleccione un Usuario de Jefatura de Operacion\n"
				forma.jefatura.className = "select_faltantes";		
			}
		break;
		case 7:
			if(forma.vicepres.value=="0"){
				msg = msg + "* Seleccione un Vicepresidente\n"
				forma.vicepres.className = "select_faltantes";		
			}
		break;
		case 8:
			if(forma.director.value=="0"){
				msg = msg + "* Seleccione un Director\n"
				forma.director.className = "select_faltantes";		
			}
		break;
	}
if(msg!=""){
		alert("Verifique el formulario\n" + msg)
		return
	}
	
	var alerta = confirm("Esta seguro de realizar este cambio ?")
	if(alerta){
		forma.action = "../librerias/php/procesos_admin.php";
		forma.accion.value="reasignar_usuarios" 
		forma.relacion.value = relacion
		forma.target="grp"
		forma.submit()
		window.parent.document.getElementById("cargando").style.display=""
		}
	}
	
	function makeactive(tab) { 
	document.getElementById("tab1").className = "fondo_1"; 
	document.getElementById("tab2").className = "fondo_1"; 
	document.getElementById("tab3").className = "fondo_1";
	document.getElementById("tab"+tab).className = "active";
	}
	
	function validarNum(e, field) {
		key = e.keyCode ? e.keyCode : e.which
		if (key == 8) return true
		if (key > 47 && key < 58) {
		  if (field.value == "") return true
		  regexp = /.[0-9]{10}$/
		  return !(regexp.test(field.value))
		}
		if (key == 46) {
		  if (field.value == "") return false
		  regexp = /^[0-9]+$/
		  return regexp.test(field.value)
		}
		return false
  	}
	
	
		 function busqueda_paginador_nuevo_tarifas_solo_campos_bus(pagina,ruta_pagina,espacio,numero_input)
	{
			var numero_vacios = 0;
			var cadena_str = 0;
			var forma = document.principal
			var nume_elementos = forma.elements.length;
			var campos_valor = "";
			var encontro_id_cont = "NO";
			var nombre_cambo_b = ""
			var nombre_cambo_arr = ""
			var resul = ""
			numero_input = 50;
			for (i=0;i<nume_elementos;i++)
			 { //for recore campos
				 nombre_cambo_b = forma.elements[i].name
				 nombre_cambo_arr=nombre_cambo_b.substring(0, 11);
				 if( (nombre_cambo_arr=='strbusqueda') && (forma.elements[i].value != "") )
				 	{//ubica campos con la etiquta inicial strbusqueda
					
					campos_valor = forma.elements[i].value;
					resul = campos_valor.replace(/&/gi, encodeURIComponent("&"));
					cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + resul
					
						
						}//ubica campos con la etiquta inicial strbusqueda
				 	
				 
			 
			 
			 if(forma.elements[i].name == "id_contrato"){//busca si cojio el id contrato si no para incluirlo mas abajo
				encontro_id_cont = "SI"
				}
			
			}//for recore campos
			
			/*
			for (i=0;i<numero_input;i++)
			 {
				
			if(forma.elements[i]){//si el campo existe
				if((forma.elements[i].type!="textarea") && (forma.elements[i].type!="button" && forma.elements[i].value != "")){
				campos_valor = forma.elements[i].value;
				var resul = campos_valor.replace(/&/gi, encodeURIComponent("&"));
				cadena_str = cadena_str + '&' + forma.elements[i].name +  '=' + resul
				if(forma.elements[i].name == "id_contrato"){//busca si cojio el id contrato si no para incluirlo mas abajo
				encontro_id_cont == "SI"
				}
				
				}
			}
			}
			
	*/		
			
			if(forma.id_contrato && encontro_id_cont == "NO"){// si el campo existe y no a llenado dicho campo en la cadena del for
				cadena_str = 'id_contrato=' + forma.id_contrato.value +'&'+cadena_str
				}



	compl = "actividad_pru=" + cadena_str
	


	ajax_carga(ruta_pagina + '?pag=' + pagina + '&' + cadena_str,espacio)
	
	
	
	}	
function busca_reporte_contrato(){
	//alert('entro')
	var forma = document.principal
	var variable="";
	if(forma.gerente_confirma_asegu2.value=="" && forma.usuario_permiso3.value=="" ){
		muestra_alerta_error_solo_texto('', 'Error', '* Ingrese un nombre de gerente o un nombre de profesional', 20, 10, 18)
		return
	}
	if(forma.usuario_permiso3.value!=""){
		var id_gerente=forma.usuario_permiso3.value;
		id_gerente=id_gerente.split('----,');
		variable=variable+"?id_gerente="+id_gerente[1];
	}
	if(forma.gerente_confirma_asegu2.value!=""){
		var id_profesional=forma.gerente_confirma_asegu2.value;
		id_profesional=id_profesional.split('----,');
		if(variable==""){
			variable=variable+"?id_profesional="+id_profesional[1];
		}else{			
			variable=variable+"&id_profesional="+id_profesional[1];
		}
	}
	$("#busca").addClass('disabled');
	$("#reporte").addClass('disabled');
	//alert(variable)
	ajax_carga('../aplicaciones/reportes/alertas_contratos.php'+variable,'contenidos')
	$("#busca").removeClass('disabled');
	$("#reporte").removeClass('disabled');
}

function busca_reporte_variacion_general(){
	//alert('entro')
var forma = document.principal
	var variable="?genera=1";
	var error =""
	/*if(forma.gerente_confirma_asegu2.value=="" && forma.usuario_permiso3.value=="" ){
		muestra_alerta_error_solo_texto('', 'Error', '* Ingrese un nombre de gerente o un nombre de profesional', 20, 10, 18)
		return
	}
	if(forma.usuario_permiso3.value!=""){
		var id_gerente=forma.usuario_permiso3.value;
		id_gerente=id_gerente.split('----,');
		variable=variable+"?id_gerente="+id_gerente[1];
	}
	if(forma.gerente_confirma_asegu2.value!=""){
		var id_profesional=forma.gerente_confirma_asegu2.value;
		id_profesional=id_profesional.split('----,');
		if(variable==""){
			variable=variable+"?id_profesional="+id_profesional[1];
		}else{			
			variable=variable+"&id_profesional="+id_profesional[1];
		}
	}
	
	$("#busca").addClass('disabled');
	$("#reporte").addClass('disabled');
	//alert(variable)
	*/
	var areas_selec = "";
	obj = forma.area_usuaria_bus_rep; 
		    for (i=0; opt=obj.options[i];i++) {
			if (opt.selected){ 
					areas_selec = areas_selec + ","+opt.value
							 }
			
		  }
	
	
	if(areas_selec!=""){
		
		variable=variable+"&area_usuaria_bus_rep="+areas_selec;
	}
	
	
	if((forma.fecha_inicial.value =="" || forma.fecha_hasta.value=="") && (forma.contratos_normales.value =="" || forma.contratos_normales.value==" ") && (forma.usuario_permiso.value =="" || forma.usuario_permiso.value==" ") && (forma.proveedores_busca.value =="" || forma.proveedores_busca.value==" ")){
		error = "* El rango de fechas de búsqueda es obligatorio y este no puede ser mayor a un año";	
		}else{
	
	variable=variable+"&fecha_inicial="+forma.fecha_inicial.value;
	variable=variable+"&fecha_hasta="+forma.fecha_hasta.value;
	var gerente_pass=forma.usuario_permiso.value.split('----,')
	gerente_pass=gerente_pass[1]
	//console.log(gerente_pass)
	var contratista_pass=forma.proveedores_busca.value.split('----,')
	contratista_pass=contratista_pass[1]
	//console.log(contratista_pass)



	//console.log(contrato)
if(gerente_pass!="" && gerente_pass!="undefined"){
	variable=variable+"&gerente="+gerente_pass;
}
if(contratista_pass !="" && contratista_pass !="undefined"){
	variable=variable+"&proveedor="+contratista_pass;
}
if(forma.contratos_normales.value !="" && forma.contratos_normales.value!=" "){
	variable=variable+"&contrato="+forma.contratos_normales.value;
}

			
	
var fechaInicio = new Date(forma.fecha_inicial.value).getTime();
var fechaFin    = new Date(forma.fecha_hasta.value).getTime();
var diff = fechaFin - fechaInicio;
var rango = (diff/(1000*60*60*24) );


if(rango >  365 && (forma.contratos_normales.value =="" || forma.contratos_normales.value==" ")){
	
	error = "* El rango de fechas de búsqueda no puede ser mayor a un año";
	}
		}

	if(error == ""){
		
		//console.log('../aplicaciones/reportes/variacion_tarifas_general.php'+variable)
	window.parent.document.getElementById("cargando_pecc").style.display = "block"
		
	document.getElementById("cargando_pecc").innerHTML='<table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/Cargando_new.gif" width="150" height="150" /></td></tr></table>';
	
	ajax_carga('../aplicaciones/reportes/variacion_tarifas_general.php'+variable,'contenidos')
	
	}else{
				muestra_alerta_error_solo_texto('', 'Error', 'Para poder generar este reporte por favor: '+error, 20, 10, 18)
		}
	/*$("#busca").removeClass('disabled');
	$("#reporte").removeClass('disabled');
	*/
}

