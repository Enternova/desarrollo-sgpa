<?php 
	
	include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    
?>




<body onload="lista_criterio('');">


<input  type="text" name="buscar_criterio" id="buscar_criterio" class="form-control" onkeyup="lista_criterio(this.value);" placeholder="Ingrese Nombre Criterio"/>


<div id="ver_criterio"></div>

</body>




<script>
/**  listar criterios  **/
function lista_criterio(valor){
	$.ajax({
		url:'../../librerias/php/desempeno/procesar_criterios.php',
		type:'POST',
		data:'valor='+valor+'&boton=buscar_criterio'
	}).done(function(resp){
		//alert(resp);
		var valores = eval(resp);
		html="<table class='table table-bordered'><thead><tr><th>Tipo de Criterio</th><th>Puntos Globales</th><th>Estado</th><th>Modificar</th><th>Eliminar</th></tr></thead><tbody>";
		for(i=0;i<valores.length;i++){
			datos=valores[i][0]+"*"+valores[i][1]+"*"+valores[i][2]+"*"+valores[i][3];
			html+="<tr><td>"+valores[i][1]+"</td><td>"+valores[i][2]+"</td><td>"+valores[i][3]+"</td><td><button onclick='modificar_criterio("+'"'+valores[i][0]+'"'+");'></button></td><td><button onclick='eliminar_criterio("+'"'+valores[i][0]+'"'+");'></button></td></tr>";
		}
		html+="</tbody></table>"
		$("#ver_criterio").html(html);
	});
}

/**  registrar criterios  **/	
function registrar_criterio(){
			
            var nombre_criterio=$('#nombre_criterio').val();
            var puntos_criterio=$('#puntos_criterio').val();

                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'nombre_criterio='+nombre_criterio+'&puntos_criterio='+puntos_criterio+'&boton=registrar_criterio'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });
         
            
        }
		
/**  modificar criterios  **/		
function modificar_criterio(){
			
            var id_criterio=$('#id_criterio').val();
            var nombre_criterio=$('#nombre_criterio').val();
            var puntos_criterio=$('#puntos_criterio').val();

                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'id_criterio='+id_criterio+'&nombre_criterio='+nombre_criterio+'&puntos_criterio='+puntos_criterio+'&boton=modificar_criterio'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });
            
        }
		
/**  eliminar criterios  **/		
function eliminar_criterio(){
			
            var id_criterio=$('#id_criterio').val();
        
                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'id_criterio='+id_criterio+'&boton=eliminar_criterio'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });
          
        }

/**  registrar aspectos  **/
function registrar_aspectos(){
				
            var id_criterio=$('#id_criterio').val();
			var nombre_aspectos=$('#nombre_aspectos').val();
            var puntos_aspectos=$('#puntos_aspectos').val();
            var nombre_descripcion=$('#nombre_descripcion').val();

                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'id_criterio='+id_criterio+'&nombre_aspectos='+nombre_aspectos+
					'&puntos_aspectos='+puntos_aspectos+'&nombre_descripcion='+nombre_descripcion+'&boton=registrar_aspectos'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });            
        }
		
/**  modificar aspectos  **/		
function modificar_aspectos(){
				
			
            var id_aspectos=$('#id_aspectos').val();
			var nombre_aspectos=$('#nombre_aspectos').val();
            var puntos_aspectos=$('#puntos_aspectos').val();
            var nombre_descripcion=$('#nombre_descripcion').val();

                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'id_aspectos='+id_aspectos+'&nombre_aspectos='+nombre_aspectos+
					'&puntos_aspectos='+puntos_aspectos+'&nombre_descripcion='+nombre_descripcion+'&boton=modificar_aspectos'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });
				
        }

/**  eliminar aspectos  **/		
function eliminar_aspectos(){
				
            var id_aspectos=$('#id_aspectos').val();
			
                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'id_aspectos='+id_aspectos+'&boton=eliminar_aspectos'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });
        }


/**  registrar estados  **/
function registrar_estados(){
				
            var nombre_estados=$('#nombre_estados').val();

                $.ajax({
                    url:'../../librerias/php/desempeno/procesar_criterios.php',
                    type:'POST',
                    data:'nombre_estados='+nombre_estados+'&boton=registrar_estados'
                }).done(function(respuesta){
                    if (respuesta=='exito') {
                        $('#exito').show();
						
						alert(respuesta);
						
                    }
                    else{
                        alert(respuesta);
                    }
                    
                });            
        }		
</script>