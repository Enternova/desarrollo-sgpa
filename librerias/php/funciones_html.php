<?
function boton_con_icono_accion($clases_boton, $icono, $texto, $accion, $estilos_boton, $estilos_icono, $clases_icono, $cols){
	echo '<div class="col '.$cols.'"><a class="waves-effect waves-light btn '.$clases_boton.'" onclick="'.$accion.'" style="'.$estilos_boton.'"><i class="material-icons '.$clases_icono.'" style="'.$estilos_icono.'">'.$icono.'</i>'.$texto.'</a></div>';
}

function boton_sin_icono_accion($clases_boton, $texto, $accion, $estilos_boton, $cols){
	echo '<div class="col '.$cols.'"><a class="waves-effect waves-light btn '.$clases_boton.'" onclick="'.$accion.'" style="'.$estilos_boton.'">'.$texto.'</a></div>';
}





function input($cols, $value, $name, $class_input, $style_input, $text_input, $tipo_input){
	echo '<div class="input-field col '.$cols.'">
          <input value="'.$value.'" id="'.$name.'" name="'.$name.'" type="'.$tipo_input.'" class="'.$class_input.'" style="'.$style_input.'">
          <label for="'.$name.'">'.$text_input.'</label>
        </div>';
}

function input_con_accion($cols, $value, $name, $class_input, $style_input, $text_input, $tipo_input, $ipo_accion, $accion){
	echo '<div class="input-field col '.$cols.'">
          <input value="'.$value.'" id="'.$name.'" name="'.$name.'" type="'.$tipo_input.'" class="'.$class_input.'" style="'.$style_input.'" '.$ipo_accion.'="'.$accion.'">
          <label for="'.$name.'">'.$text_input.'</label>
        </div>';
}

function input_con_accion_texto_grande($cols, $value, $name, $class_input, $style_input, $text_input, $tipo_input, $ipo_accion, $accion, $estilo_lablel){
	echo '<div class="input-field col '.$cols.'">
          <input value="'.$value.'" id="'.$name.'" name="'.$name.'" type="'.$tipo_input.'" class="'.$class_input.'" style="'.$style_input.'" '.$ipo_accion.'="'.$accion.'">
          <label for="'.$name.'" style="'.$estilo_lablel.'">'.$text_input.'</label>
        </div>';
}

function agrega_row_input_con_icono($cols, $value, $name, $class_input, $style_input, $text_input, $descripcion, $tipo_input, $icono, $clases_icono){
       echo $imprime='
        <div class="input-field col '.$cols.'">
			<i class="material-icons '.$clases_icono.'">'.$icono.'</i>
          <input placeholder="'.$descripcion.'" value="'.$value.'" id="'.$name.'" name="'.$name.'" type="'.$tipo_input.'" class="'.$class_input.'" style="'.$style_input.'">
          <label for="first_name">'.$text_input.'</label>
        </div>';
}


function agrega_select_fijo($cols, $text_select, $action, $select, $name){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" id="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	
		$imprime.='<option value="1">Servicio Menor</option>';
		$imprime.='<option value="2">Contrato Puntual</option>';
		$imprime.='<option value="3">Contrato Marco</option>';
	
	$imprime.='</select>
			<label>'.$text_select.'</label>
		  </div>';
	echo $imprime;
}

function agrega_select_fijo1($cols, $text_select, $action, $select, $name){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" id="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	
		$imprime.='<option value="0">Ninguna</option>';
		$imprime.='<option value="1">Contratos Obra Perforacion y Sismica</option>';
		$imprime.='<option value="2">Asesorias Consultorias e Ingenieria</option>';
	
	$imprime.='</select>
			<label>'.$text_select.'</label>
		  </div>';
	echo $imprime;
}



function agrega_select_accion($cols, $text_select, $action, $select, $name){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" id="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'">'.$lt[0].'</option>';
	}
	$imprime.='</select>
			<label>'.$text_select.'</label>
		  </div>';
	echo $imprime;
}
function agrega_select_accion_texto_grande($cols, $text_select, $action, $select, $name, $estilo_lablel){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" id="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'" style="'.$estilo_lablel.'">'.$lt[0].'</option>';
	}
	$imprime.='</select>
			<label style="'.$estilo_lablel.'">'.$text_select.'</label>
		  </div>';
	echo $imprime;
}

function agrega_select_accion_con_get($cols, $text_select, $action, $select, $name, $get){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" id="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		if($get==arreglo_pasa_variables($lt[1])){
			$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'" selected>'.$lt[0].'</option>';
		}else{
			$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'">'.$lt[0].'</option>';
		}
	}
	$imprime.='</select>
			<label>'.$text_select.'</label>
		  </div>';
	echo $imprime;
}


function retorna_select_accion($cols, $text_select, $action, $select, $name){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		$imprime.='<option value="'.arreglo_pasa_variables($lt[0]).'">'.$lt[1].'</option>';
	}
	$imprime.='</select>
			<label>'.$text_select.'</label>
		  </div>';
	return $imprime;
}

function retorna_select_accion_texto_grande($cols, $text_select, $action, $select, $name, $stilo){
	$imprime='<div class="input-field col '.$cols.'">
			<select name="'.$name.'" onchange="'.$action.'">
			  <option value="0" disabled selected>Seleccione</option>';
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		$imprime.='<option value="'.arreglo_pasa_variables($lt[0]).'" style="'.$stilo.'">'.$lt[1].'</option>';
	}
	$imprime.='</select>
			<label style="'.$stilo.'">'.$text_select.'</label>
		  </div>';
	return $imprime;
}









/**************** $cabecera es en el siginete formato ****************/
/*
texto td | tipo del campo(input, select) | tipo de input(text, number) | nombre del campo(id) | consulta si es select | accion | nombre de la acción | google icon | width de td?
si no aplican a alguna de las condicones se debe pasar con un espacio ' ' signo de preguna es el delimitador del th
*/

 /**************** $funcion1, $funcion2, $funcion3 es en el siginete formato ****************/
/*
nombre de la funcion | icono | clases iconos | estilo icono | otras variables|tolltip(ayuda)
si no aplican a alguna de las condicones se debe pasar con un espacio ' '
*/
/**************** $consulta es en el siginete formato ****************/
/*
la consutla es la que generea el resultado en la tabla
*/
function carga_tabla_hmtl($cabecera, $funcion1, $funcion2, $funcion3, $consulta){
	$inico_tabla='<table id="data-table-proveedor" class="striped centered" cellspacing="0" width="100%" style="">
  <thead>
	  <tr>';
	$th='';
	$th_total=explode('?', $cabecera);
	$size_rows=sizeof($th_total);
	$colspan=sizeof($th_total);
	for ($i=0; $i<sizeof($th_total); $i++){
		$th_campos=explode('|', $th_total[$i]);
		if($th_campos[8]!=" "){			
			$th.='<th width="'.$th_campos[8].'%">';
		}else{
			$th.='<th>';
		}
		if($th_campos[1]=='input'){
			$funcion="";
			if($th_campos[6]==' '){
				$funcion=$th_campos[6].'(this.value)"';
			}
			$accion="";
			if($th_campos[5]==' '){
				$accion=$th_campos[5].'="';
			}
			$th.='<div class="input-field col">
				  <input autocomplete="off" id="'.$th_campos[3].'" '.$accion.$funcion.' name="'.$th_campos[3].'" type="'.$th_campos[2].'" class="validate" >
				  <label for="'.$th_campos[3].'" class="label_for">'.$th_campos[0].'</label></div></th>';

		}elseif($th_campos[1]=='select'){
			$funcion="";
			if($th_campos[6]==' '){
				$funcion=$th_campos[6].'(this.value)"';
			}
			$select_html=retorna_select_accion('', $th_campos[0], $funcion, $th_campos[3], $th_campos[3]);
			$th.=$select_html.'</th>';
		}else{
			$th.=$th_campos[0].'</th>';
		}
	}
	if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
		$colspan=$colspan+1;
		$th.='<th>Acci&oacute;n</th>';
	}
	$inico_tabla.=$th.'</tr></thead><tbody id="cargatodo">';
	$campos_tabla_body="";
	if($consulta!="" and $consulta!=" "){
		$query=query_db($consulta);
		while($lt=traer_fila_db($query)){
			$campos_tabla_body.='<tr>';
			$td="";
			for($i=0; $i<$size_rows; $i++){
				$td.='<td aling ="center">'.$lt[$i].'</td>';
			}
			$acciones="";
			if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
				$acciones.='<td aling="center">';
			}
			if($funcion1!="" and $funcion1!=" "){
				$funcion_nombres=explode('|', $funcion1);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($funcion2!="" and $funcion2!=" "){
				$funcion_nombres=explode('|', $funcion2);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($funcion3!="" and $funcion3!=" "){
				$funcion_nombres=explode('|', $funcion3);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($acciones!=""){
				$acciones.="</td>";
			}
			$campos_tabla_body.=$td.$acciones."</tr>";
		}
	}
	$inico_tabla.=$campos_tabla_body;
  $inico_tabla.='</tbody>
  
  <tfoot>
	<tr>
	  <th colspan="'.$colspan.'">
		<div class="input-field col s6 m6 l6 left" id="load-registers">
		</div>
		<div class="input-field col s4 m4 l4 right" id="pagination">
		  <ul class="pagination" id="list-pagination">

		  </ul>
		</div>
	  </th>
	</tr>
  </tfoot>
</table>';
	echo $inico_tabla;
}

/**************** $cabecera es en el siginete formato ****************/
/*
texto td | tipo del campo(input, select) | tipo de input(text, number) | nombre del campo(id) | consulta si es select | accion | nombre de la acción | google icon | width de td?
si no aplican a alguna de las condicones se debe pasar con un espacio ' ' signo de preguna es el delimitador del th
*/

 /**************** $funcion1, $funcion2, $funcion3 es en el siginete formato ****************/
/*
nombre de la funcion | icono | clases iconos | estilo icono | otras variables|tolltip(ayuda)
si no aplican a alguna de las condicones se debe pasar con un espacio ' '
*/
/**************** $consulta es en el siginete formato ****************/
/*
la consutla es la que generea el resultado en la tabla
*/
function carga_tabla_hmtl_titulo_grande($cabecera, $funcion1, $funcion2, $funcion3, $consulta, $estilo){
	$inico_tabla='<table id="data-table-proveedor" class="striped centered" cellspacing="0" width="100%" style="">
  <thead>
	  <tr>';
	$th='';
	$th_total=explode('?', $cabecera);
	$size_rows=sizeof($th_total);
	$colspan=sizeof($th_total);
	for ($i=0; $i<sizeof($th_total); $i++){
		$th_campos=explode('|', $th_total[$i]);
		if($th_campos[8]!=" "){
			$th.='<th width="'.$th_campos[8].'%" style="'.$estilo.'">';
		}else{
			$th.='<th style="'.$estilo.'">';
		}
		if($th_campos[1]=='input'){
			$funcion="";
			if($th_campos[6]==' '){
				$funcion=$th_campos[6].'(this.value)"';
			}
			$accion="";
			if($th_campos[5]==' '){
				$accion=$th_campos[5].'="';
			}
			$th.='<div class="input-field col">
				  <input autocomplete="off" id="'.$th_campos[3].'" '.$accion.$funcion.' name="'.$th_campos[3].'" type="'.$th_campos[2].'" class="validate" >
				  <label for="'.$th_campos[3].'" class="label_for" style="'.$estilo.'">'.$th_campos[0].'</label></div></th>';

		}elseif($th_campos[1]=='select'){
			$funcion="";
			if($th_campos[6]==' '){
				$funcion=$th_campos[6].'(this.value)"';
			}
			$select_html=retorna_select_accion_texto_grande('', $th_campos[0], $funcion, $th_campos[3], $th_campos[3], $estilo);
			$th.=$select_html.'</th>';
		}else{
			$th.=$th_campos[0].'</th>';
		}
	}
	if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
		$colspan=$colspan+1;
		$th.='<th style="'.$estilo.'">Acci&oacute;n</th>';
	}
	$inico_tabla.=$th.'</tr></thead><tbody id="cargatodo">';
	$campos_tabla_body="";
	if($consulta!="" and $consulta!=" "){
		$query=query_db($consulta);
		while($lt=traer_fila_db($query)){
			$campos_tabla_body.='<tr>';
			$td="";
			for($i=0; $i<$size_rows; $i++){
				$td.='<td aling ="center">'.$lt[$i].'</td>';
			}
			$acciones="";
			if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
				$acciones.='<td aling="center">';
			}
			if($funcion1!="" and $funcion1!=" "){
				$funcion_nombres=explode('|', $funcion1);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($funcion2!="" and $funcion2!=" "){
				$funcion_nombres=explode('|', $funcion2);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($funcion3!="" and $funcion3!=" "){
				$funcion_nombres=explode('|', $funcion3);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<i title="'.$funcion_nombres[5].'" onclick="'.$funcion_pasa.'" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i>';
				}else{
					$acciones.='<i onclick="'.$funcion_pasa.'" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i>';
				}
			}
			if($acciones!=""){
				$acciones.="</td>";
			}
			$campos_tabla_body.=$td.$acciones."</tr>";
		}
	}
	$inico_tabla.=$campos_tabla_body;
  $inico_tabla.='</tbody>
  
  <tfoot>
	<tr>
	  <th colspan="'.$colspan.'">
		<div class="input-field col s6 m6 l6 left" id="load-registers">
		</div>
		<div class="input-field col s4 m4 l4 right" id="pagination">
		  <ul class="pagination" id="list-pagination">

		  </ul>
		</div>
	  </th>
	</tr>
  </tfoot>
</table>';
	echo $inico_tabla;
}

 /**************** $funcion1, $funcion2, $funcion3 es en el siginete formato ****************/
/*
nombre de la funcion | icono | clases iconos | estilo icono | otras variables|tolltip(ayuda)
si no aplican a alguna de las condicones se debe pasar con un espacio ' '
*/
/**************** $consulta es en el siginete formato ****************/
/*
la consutla es la que generea el resultado en la tabla
*/
function carga_tabla_hmtl_solo_body($funcion1, $funcion2, $funcion3, $consulta, $size_rows, $id_tabla){
	$campos_tabla_body="";
	if($consulta!="" and $consulta!=" "){
		//echo $consulta;
		$query=query_db($consulta);
		while($lt=traer_fila_db($query)){
			$campos_tabla_body.='<tr>';
			$td="";
			for($i=0; $i<$size_rows; $i++){
				$td.='<td aling ="center">'.$lt[$i].'</td>';
			}
			$acciones="";
			if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
				$acciones.='<td aling="center">';
			}
			if($funcion1!="" and $funcion1!=" "){
				$funcion_nombres=explode('|', $funcion1);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion2!="" and $funcion2!=" "){
				$funcion_nombres=explode('|', $funcion2);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion3!="" and $funcion3!=" "){
				$funcion_nombres=explode('|', $funcion3);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."',".$funcion_nombres[4].")";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".arreglo_pasa_variables($lt[$size_rows])."')";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($acciones!=""){
				$acciones.="</td>";
			}
			$campos_tabla_body.=$td.$acciones."</tr>";
		}
	}
	return '<tbody id="'.$id_tabla.'">'.$campos_tabla_body.'</tbody>';
}

/**************** ESTA FUNCION ES SOLO PARA EL HISTORICO DE RESULTADOS DE SEMEPENO ****************/
/*
nombre de la funcion | icono | clases iconos | estilo icono | otras variables|tolltip(ayuda)
si no aplican a alguna de las condicones se debe pasar con un espacio ' '
*/
/**************** $consulta es en el siginete formato ****************/
/*
la consutla es la que generea el resultado en la tabla
*/
function carga_tabla_hmtl_solo_body_resultados($funcion1, $funcion2, $funcion3, $consulta, $size_rows, $id_tabla,$icono_star){
	$tabla_completa="";
	if($consulta!="" and $consulta!=" "){
		//echo $consulta;
		$query=query_db($consulta);
		while($lt=traer_fila_db($query)){
			$campos_tabla_body="";
			$campos_tabla_body_sm="";
			$muestra_cotrato="";
			$muestra_sm="";
			$campos_tabla_body='<tr><td aling ="center">'.$lt[0].'</td><td aling ="center">Contrato</td>';
			$campos_tabla_body_sm='<tr><td aling ="center">'.$lt[0].'</td><td aling ="center">Servico Menor</td>';
			$td="";
			/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA ***/
			$total_tecnica=NULL;
			$total_tecnica_sm=NULL;
			//PARA SERVICIOS MENORES
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_servicio_menor WHERE id_estado_criterio=9 and id_criterio=1 and estado_aspecto=1 and tipo_documento=1 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_servicio_menor WHERE id_estado_criterio=9 and id_criterio=1 and estado_aspecto=1 and tipo_documento=1 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total1=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total1++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total1++;
					}
					$suma=$suma+$lt1[0];
				}
				if($suma!=0){
					$total_tecnica_sm=$total_tecnica_sm+$suma;
				}
				if($total_tecnica_sm!="" and $total_tecnica_sm!=" " and $total_tecnica_sm!="NULL" and $total_tecnica_sm!=NULL){
					$total_tecnica_sm=$total_tecnica_sm/$total1;
					$muestra_sm="si";
					$campos_tabla_body_sm.='<td aling ="center">'.$total_tecnica_sm.'</td></td><td aling ="center">No aplica</td><td aling ="center">No aplica</td>';
				}else{
					$campos_tabla_body_sm.='<td aling ="center">No registra</td></td><td aling ="center">No aplica</td><td aling ="center">No aplica</td>';
				}
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=2 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=2 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total1=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total1++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total1++;
					}
					$suma=$suma+$lt1[0];
				}
				if($suma!=0){
					$total_tecnica=$total_tecnica+$suma;
				}
			//PARA CONTRATO MARCO
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=3 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=3 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total++;
					}
					$suma=$suma+$lt1[0];
				}
				$total=$total+$total1;
				if($suma!=0){
					$total_tecnica=$total_tecnica+$suma;
				}
				if($total_tecnica!="NULL" and $total_tecnica!="" and $total_tecnica!=" " and $total_tecnica!=NULL){
					$muestra_cotrato="si";
					$total_tecnica=$total_tecnica/$total;
					$campos_tabla_body.='<td aling ="center">'.$total_tecnica.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
			/*** FIN SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA ***/
			/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION HSSE ***/
			$total_hsse=NULL;
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=4 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=4 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total1=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total1++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total1++;
					}
					$suma=$suma+$lt1[0];
				}
				if($suma!=0){
					$total_hsse=$total_hsse+$suma;
				}
			//PARA CONTRATO MARCO
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=5 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=5 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total++;
					}
					$suma=$suma+$lt1[0];
				}
				$total=$total+$total1;
				if($suma!=0){
					$total_hsse=$total_hsse+$suma;
				}
				if($total_hsse!="NULL" and $total_hsse!="" and $total_hsse!=" " and $total_hsse!=NULL){
					$muestra_cotrato="si";
					$total_hsse=$total_hsse/$total;
					$campos_tabla_body.='<td aling ="center">'.$total_hsse.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
			/*** FIN SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION HSSE ***/
			/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION ADMINISTRATIVA ***/
			$total_administrativa=NULL;
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=6 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=6 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total1=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total1++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total1++;
					}
					$suma=$suma+$lt1[0];
				}
				if($suma!=0){
					$total_administrativa=$total_administrativa+$suma;
				}
			//PARA CONTRATO MARCO
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=7 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=7 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$lt[1]);
				$id_bandera=0;
				$total=0;
				$suma=0;
				while($lt1=traer_fila_db($sel_while)){
					if($id_bandera==0){
						$total++;
						$id_bandera=$lt1[1];
					}
					if($id_bandera!=$lt1[1]){
						$id_bandera=$lt1[1];
						$total++;
					}
					$suma=$suma+$lt1[0];
				}
				$total=$total+$total1;
				if($suma!=0){
					$total_administrativa=$total_administrativa+$suma;
				}
				if($total_administrativa!="NULL" and $total_administrativa!="" and $total_administrativa!=" " and $total_administrativa!=NULL){
					$muestra_cotrato="si";
					$total_administrativa=$total_administrativa/$total;
					$campos_tabla_body.='<td aling ="center">'.$total_administrativa.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
			/*** FIN SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION ADMINISTRATIVA ***/
			/*** SE VERIFICAN LOS TRES PUNTAJES PARA SABER EL PUNTAJE ***/
				$total_evaluacion=NULL;
				if($total_administrativa!="NULL" and $total_administrativa!="" and $total_administrativa!=" " and $total_administrativa!=NULL){
					$total_evaluacion=$total_evaluacion+($total_administrativa);
				}
				if($total_hsse!="NULL" and $total_hsse!="" and $total_hsse!=" " and $total_hsse!=NULL){
					$total_evaluacion=$total_evaluacion+($total_hsse);
				}
				if($total_tecnica!="NULL" and $total_tecnica!="" and $total_tecnica!=" " and $total_tecnica!=NULL){
					$total_evaluacion=$total_evaluacion+($total_tecnica);
				}
				if($total_evaluacion!="NULL" and $total_evaluacion!="" and $total_evaluacion!=" " and $total_evaluacion!=NULL){
					$campos_tabla_body.='<td aling ="center">'.$total_evaluacion.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
				$total_evaluacion_sm=NULL;
				if($total_tecnica_sm!="NULL" and $total_tecnica_sm!="" and $total_tecnica_sm!=" " and $total_tecnica_sm!=NULL){
					$total_evaluacion_sm=$total_tecnica_sm;
					$campos_tabla_body_sm.='<td aling ="center">'.$total_evaluacion_sm.'</td>';
				}else{
					$campos_tabla_body_sm.='<td aling ="center">No registra</td>';
				}
			/*** FIN SE VERIFICAN LOS TRES PUNTAJES PARA SABER EL PUNTAJE ***/
			/*** SE VERIFICAN LOS TRES PUNTAJES PARA SABER LA CLASIFICACION ***/
				if($total_evaluacion!="NULL" and $total_evaluacion!="" and $total_evaluacion!=" " and $total_evaluacion!=NULL){
					if($total_evaluacion<60){//NO CUMPLE
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #F34336;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion<80){//POR MEJORAR
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #FEEA3B;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion<90){//BUENO
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #005395;">'.$icono_star.'</i></td>';
					}else{//EXCELENTE
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #4CAF50;">'.$icono_star.'</i></td>';
					}
				}else{
					$campos_tabla_body.='<td aling ="center"></td>';
				}
				if($total_evaluacion_sm!="NULL" and $total_evaluacion_sm!="" and $total_evaluacion_sm!=" " and $total_evaluacion_sm!=NULL){
					if($total_evaluacion_sm<60){//NO CUMPLE
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #F34336;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion_sm<80){//POR MEJORAR
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #FEEA3B;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion_sm<90){//BUENO
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #005395;">'.$icono_star.'</i></td>';
					}else{//EXCELENTE
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #4CAF50;">'.$icono_star.'</i></td>';
					}
				}else{
					$campos_tabla_body_sm.='<td aling ="center"></td>';
				}
			/*** FIN SE VERIFICAN LOS TRES PUNTAJES PARA SABER LA CLASIFICACION ***/
			$acciones="";
			if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
				$acciones.='<td aling="center">';
			}
			if($funcion1!="" and $funcion1!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion1);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 1)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 1)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'"  >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion2!="" and $funcion2!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion2);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 1)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 1)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons  '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion3!="" and $funcion3!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion3);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 1)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 1)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($acciones!=""){
				$acciones.="</td>";
			}
			//PARA LAS ACCIONES DE SERVICIOS MENORES
			$acciones2="";
			if(($funcion1!="" and $funcion1!=" ") or ($funcion2!="" and $funcion2!=" ") or ($funcion3!="" and $funcion3=" ")){
				$acciones2.='<td aling="center">';
			}
			if($funcion1!="" and $funcion1!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion1);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 2)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 2)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones2.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'"  >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones2.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion2!="" and $funcion2!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion2);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 2)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 2)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones2.='<a title="'.$funcion_nombres[5].'" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons  '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones2.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($funcion3!="" and $funcion3!=" "){
				if(is_int($lt[$size_rows])){
					$id=arreglo_pasa_variables($lt[$size_rows]);
				}else{
					$id=$lt[$size_rows];
				}
				$funcion_nombres=explode('|', $funcion3);
				if($funcion_nombres[4]!="" and $funcion_nombres[4]!=" "){//si la función requiere pasar mas variables
					$funcion_pasa=$funcion_nombres[0]."('".$id."',".$funcion_nombres[4].", 2)";
				}else{
					$funcion_pasa=$funcion_nombres[0]."('".$id."', 2)";
				}
				if($funcion_nombres[5]!="" and $funcion_nombres[5]!=" "){//si el icono tiene texto de ayuda
					$acciones2.='<a title="'.$funcion_nombres[5].'" href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons tooltipped '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" data-position="bottom" data-delay="50" data-tooltip="'.$funcion_nombres[5].'" >'.$funcion_nombres[1].'</i></a>';
				}else{
					$acciones2.='<a href="javascript:'.$funcion_pasa.'" onclick="return true;"><i onclick="" class="material-icons '.$funcion_nombres[2].'" style="'.$funcion_nombres[3].'" >'.$funcion_nombres[1].'</i></a>';
				}
			}
			if($acciones2!=""){
				$acciones2.="</td>";
			}
			if($muestra_cotrato=="si" and $muestra_sm=="si"){
				$campos_tabla_body_sm.=$acciones2."</tr>";
				$campos_tabla_body=$campos_tabla_body.$acciones."</tr>".$campos_tabla_body_sm;
				$tabla_completa.=$campos_tabla_body;
			}elseif($muestra_cotrato=="si"){
				$campos_tabla_body=$campos_tabla_body.$acciones."</tr>";
				$tabla_completa.=$campos_tabla_body;
			}elseif($muestra_sm=="si"){
				$campos_tabla_body_sm.=$acciones2."</tr>";
				$campos_tabla_body=$campos_tabla_body_sm;
				$tabla_completa.=$campos_tabla_body;
			}
			$muestra_cotrato="";
			$muestra_sm="";
		}
	}
	return '<tbody id="'.$id_tabla.'">'.$tabla_completa.'</tbody>';
}
/**************** FIN ESTA FUNCION ES SOLO PARA EL HISTORICO DE RESULTADOS DE SEMEPENO ****************/

function carga_paginador_hmtl_solo_body($desde, $hasta, $total, $posicion_pagina, $pagina_actual, $cols, $id_div, $total_paginas, $accion){
	$li='';
	if($posicion_pagina==1 and $pagina_actual>1){//si es la primera posición pero no el primer registro
		//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
		$j=1;
		for($i=($pagina_actual-1); $i<($pagina_actual+4); $i++){
			//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
			if($j==2){
				$li.='<li class="color-blue-light-hocol"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}else{
				$li.='<li class="waves-effect color-blue-light-hocol-hover"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}
			$j++;
		}
	}elseif($posicion_pagina==5 and ($desde <$total and $hasta <$total)){//si es la última posición pero no el último registro
		$j=1;
		for($i=($pagina_actual-3); $i<=($pagina_actual+1); $i++){
			//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
			if($j==4){
				$li.='<li class="color-blue-light-hocol"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}else{
				$li.='<li class="waves-effect color-blue-light-hocol-hover"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}
			$j++;
		}
	}elseif($posicion_pagina==5 and ($desde > $total or $hasta > $total)){//si es la última posición pero no el último registro
		$j=1;
		for($i=($pagina_actual-4); $i<=$pagina_actual; $i++){
			//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
			if($j==5){
				$li.='<li class="color-blue-light-hocol"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}else{
				$li.='<li class="waves-effect color-blue-light-hocol-hover"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
			}
			$j++;
		}
	}else{
		//echo "aqui 4";
		if($total_paginas>=5){//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
			if($posicion_pagina==1){
				$desde1=$pagina_actual;
				$hasta1=$pagina_actual+4;
			}elseif($posicion_pagina==2){
				$desde1=$pagina_actual-1;
				$hasta1=$pagina_actual+3;
			}elseif($posicion_pagina==3){
				$desde1=$pagina_actual-2;
				$hasta1=$pagina_actual+2;
			}elseif($posicion_pagina==4){
				$desde1=$pagina_actual-3;
				$hasta1=$pagina_actual+1;
			}elseif($posicion_pagina==5){
				$desde1=$pagina_actual-4;
				$hasta1=$pagina_actual;
			}
			$j=1;
			for($i=$desde1; $i<=$hasta1; $i++){
				//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
				if($j==$posicion_pagina){
					$li.='<li class="color-blue-light-hocol"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
				}else{
					$li.='<li class="waves-effect color-blue-light-hocol-hover"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
				}
				$j++;
			}
		}else{
			$j=1;
			for($i=1; $i<=$total_paginas; $i++){//SE LE RESTA UN NUMERO A LA POSICIÓN ACTUAL.
				if($i==$posicion_pagina){
					$li.='<li class="color-blue-light-hocol"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
				}else{
					$li.='<li class="waves-effect color-blue-light-hocol-hover"> <a href="javascript:'.$accion.'(&apos;'.$i.'&apos;, &apos;'.$j.'&apos;, &apos;'.$id_div.'&apos;);" onclick="return true;">'.$i.'</a></li>';
				}
				$j++;
			}
		}
	}
	if($desde>$total){
		$desde=$total;
	}
	if($hasta>$total){
		$hasta=$total;
	}
	$echo='<tfoot id="'.$id_div.'">
	<tr>
	  <th colspan="'.$cols.'">
	  	<div class="row">
		<div class="input-field col s12 m7 l8 left" id="load-registers">
		<label class="left">MOSTRANDO REGISTROS: '.$desde.' AL '.$hasta.' DE '.$total.'</label>
		</div>
		<div class="input-field col s12 m5 l4 right" id="pagination">
		  <ul class="pagination" id="list-pagination">'.$li.'
		  </ul
		</div>
		</div>
	  </th>
	</tr></tfoot>';
	return $echo;
}

function carga_modal_criterio($titulo, $boton1, $boton2, $id_criterio){
	$datos_criterio=traer_fila_row(query_db("SELECT nombre_criterio, puntos_criterio, id_criterio, tipo_contrato FROM   t9_criterio where id_criterio=".$id_criterio));
	$imprime='<div class="row"><div class="input-field col s12 m12 l12">
			<select name="tipo_contrato_edicion" id="tipo_contrato_edicion">
			  <option value="0" disabled selected>Seleccione</option>';
		if($datos_criterio[3]==1){
			$imprime.='<option value="1" selected>Servicio Menor</option>';
		}else{
			$imprime.='<option value="1">Servicio Menor</option>';
		}
		if($datos_criterio[3]==2){
			$imprime.='<option value="2" selected>Contrato Puntual</option>';
		}else{
			$imprime.='<option value="2">Contrato Puntual</option>';
		}
		if($datos_criterio[3]==3){
		$imprime.='<option value="3" selected>Contrato Marco</option>';
		}else{
		$imprime.='<option value="3">Contrato Marco</option>';
		}
	
	$imprime.='</select>
			<label>Tipo de documento</label>
		  </div></div>';
	$modal='<div id="modal_criterio" class="modal"><div class="modal-content"><h4 style="font-size:18pt !important; font-weight: 700 !important;">'.$titulo.'</h4>'.$imprime.'<div class="row"><div class="input-field col s12 m6 18"><input value="'.$datos_criterio[0].'" id="nombre_criterio_edicion" name="nombre_criterio_edicion" type="text" class="validate" style=""><label for="nombre_criterio_edicion" class="">Criterio</label></div><div class="input-field col s12 m6 14"><input value="'.$datos_criterio[1].'" id="puntos_criterio_edicion" name="puntos_criterio_edicion" type="number" class="validate" style=""><label for="puntos_criterio_edicion">Puntos</label></div></div>';
	$modal.='</div><div class="modal-footer"><a onclick="$(&apos;#modal1&apos;).hide();" class="modal-action modal-close waves-effect waves-red btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Cancelar</a><a onclick="'.$boton1.'" class="modal-action modal-close waves-effect waves-green btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Guardar</a></div></div>';
	echo $modal;
}


function carga_modal_aspecto($titulo, $boton1, $boton2, $id_criterio){
	$datos_criterio=traer_fila_row(query_db("SELECT nombre_aspectos, puntos_aspectos, nombre_descripcion, id_aspectos, id_criterio, tipo_servicio FROM   t9_aspectos_criterio where id_aspectos=".$id_criterio));
	/*** PARA TRAER EL SELECT DEL TIPO DE CRITERIO DE LA BASE DE DATOS ***/
	$imprime='<div class="row"><div class="input-field col s12 m12 l12">
			<select name="tipo_criterio_aspecto_edicion" id="tipo_criterio_aspecto_edicion">';
	$select = "select nombre_criterio+'('+case when (tipo_contrato=1) then 'Servicio Menor' when (tipo_contrato=2) then 'Contrato Puntual' else 'Contrato Marco' end+')' as criterio, id_criterio from t9_criterio where estado=1 order by tipo_contrato";
	$query=query_db($select);
	while($lt=traer_fila_db($query)){
		if($lt[1]==$datos_criterio[4]){
			$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'" selected>'.$lt[0].'</option>';
		}else{
			$imprime.='<option value="'.arreglo_pasa_variables($lt[1]).'">'.$lt[0].'</option>';
		}
	}
	$imprime.='</select>
			<label>Criterios</label>
		  </div></div>';
	/*** PARA TRAER EL SELECT DEL TIPO DE CRITERIO DE LA BASE DE DATOS ***/
	/*** PARA EL SELECT DEL TIPO DE SERVICIO ***/
	$imprime1='<div class="row"><div class="input-field col s12 m12 l12">
			<select name="tipo_servicio_edicion" id="tipo_servicio_edicion">';
	if($datos_criterio[5]==0){
		$imprime1.='<option value="0" selected>Ninguna</option>';
	}else{
		$imprime1.='<option value="0">Ninguna</option>';
	}
	if($datos_criterio[5]==1){
		$imprime1.='<option value="1" selected>Contratos Obra Perforacion y Sismica</option>';
	}else{
		$imprime1.='<option value="1">Contratos Obra Perforacion y Sismica</option>';
	}
	if($datos_criterio[5]==2){
		$imprime1.='<option value="2" selected>Asesorias Consultorias e Ingenieria</option>';
	}else{
		$imprime1.='<option value="2">Asesorias Consultorias e Ingenieria</option>';
	}
	
	$imprime1.='</select>
			<label>Tipo de Servicio</label>
		  </div></div>';
	/*** PARA EL SELECT DEL TIPO DE SERVICIO ***/
	$modal='<div id="modal_criterio" class="modal"><div class="modal-content"><h4 style="font-size:18pt !important; font-weight: 700 !important;">'.$titulo.'</h4>'.$imprime.$imprime1.'<div class="row"><div class="input-field col s12 m8 18"><input value="'.$datos_criterio[0].'" id="nombre_aspecto_edicion" name="nombre_aspecto_edicion" type="text" class="validate" style=""><label for="nombre_aspecto_edicion" class="">Aspecto</label></div><div class="input-field col s12 m2 12"><input value="'.$datos_criterio[1].'" id="puntos_aspecto_edicion" name="puntos_aspecto_edicion" type="number" class="validate" style=""><label for="puntos_aspecto_edicion">Puntos</label></div>
	<div class="input-field col s12"><textarea   value="'.$datos_criterio[2].'" id="descripcion_aspecto_edicion" name="descripcion_aspecto_edicion" type="text" class="validate materialize-textarea" style="">'.$datos_criterio[2].'</textarea><label for="descripcion_aspecto_edicion">Descripcion</label></div></div>';
	$modal.='</div><div class="modal-footer"><a onclick="$(&apos;#modal1&apos;).hide();" class="modal-action modal-close waves-effect waves-red btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Cancelar</a><a onclick="'.$boton1.'" class="modal-action modal-close waves-effect waves-green btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Guardar</a></div></div>';
	echo $modal;
}




/*<div class="row"><div class="input-field col s12 m8 18">
	
	<input value="'.$datos_criterio[0].'" id="nombre_aspecto_edicion" name="nombre_aspecto_edicion" type="text" class="validate" style="">
	<label for="nombre_aspecto_edicion" class="">Aspecto</label>
	
	</div>
	<div class="input-field col s12 m2 12">
	
	<input value="'.$datos_criterio[1].'" id="puntos_aspecto_edicion" name="puntos_aspecto_edicion" type="number" class="validate" style="">
	<label for="puntos_aspecto_edicion">Puntos</label>
	
	</div>*/


function carga_modal_configurar_aspecto($titulo, $boton1, $boton2, $id_criterio_evaluacion, $tipo){
	$select="SELECT id_aspectos_nuevo, nombre_aspectos, puntaje_maximo FROM  t9_agregar_aspecto where id_estado='1' and id_agregar_criterio=".$id_criterio_evaluacion;
	
	
	$modal='<div id="modal_criterio" class="modal" style="width:90% !important;"><div class="modal-content"><h4 style="font-size:18pt !important; font-weight: 900 !important;">'.$titulo.'</h4><p style="font-size:18pt !important; font-weight: 900 !important;">Agrege o elimine los criterios o modifique los puntajes y luego guarde. Recuerde que la suma de los puntos de los criterios no puede superar un total de 100, y que la evaluaci&oacute;n t&eacute;cnica corresponde a un 40% para contratos y un 100% para servicios menores.</p><div class="row" id="agregar_fila" style="width:90% !important;">';
	
	$query=query_db($select); 
	
	while($lt=traer_fila_db($query)){
		$imprime1.='
		
		<div class="input-field col s12 m10 l10 " id="'.arreglo_pasa_variables($lt[0]).'"><input value="'.$lt[0].'"  name="id_existente" type="hidden" class="validate" style=""> 
		<i class="material-icons prefix" style="color: #FF0000; cursor: pointer !important; background: trasparent;" onclick="elimina_configuracion_criterio(&apos;'.arreglo_pasa_variables($lt[0]).'&apos;,&apos;&apos;,&apos;'.arreglo_pasa_variables($id_criterio_evaluacion).'&apos;)">&#xE92B;</i>
		<input value="'.$lt[1].'"  name="nombre_existente" type="text" class="validate" style=""> </div>
		<div class="input-field col s12 m2 l2 " id="'.arreglo_pasa_variables($lt[0]).'" >
		<input value="'.$lt[2].'"  name="puntos_existente" type="number" class="validate" style=""> </div>';
	}
	
	
	$modal.=$imprime1.'</div></div><div class="modal-footer"><a onclick="agregar_input()" class="modal-action waves-effect waves-green btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Agregar</a><a onclick="'.$boton1.'" class="modal-action modal-close waves-effect waves-green btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">Guardar</a></div></div>';
	echo $modal;
}

function carga_modal_comentario_resultado($titulo, $boton1, $boton2, $id_criterio_evaluacion, $tipo){
	$select="SELECT nombre_observacion, fecha, hora, id_estado from t9_observacion where id_agrega_criterio=".$id_criterio_evaluacion." order by id_observacion, fecha, hora";
	$tipo_evaluacion=traer_fila_row(query_db("select tipo_documento from dbo.historico_desempeno_resultados() where id_evaluacion=".$id_criterio_evaluacion));
	if($tipo_evaluacion[0]==1){
		$vista_aplica="vista_t9_servicio_menor";
	}elseif($tipo_evaluacion[0]==2){
		$vista_aplica="vista_t9_contrato_puntual";
	}elseif($tipo_evaluacion[0]==3){
		$vista_aplica="vista_t9_contrato_marco";
	}
	$sel="SELECT fecha_periodo_evaluado, nombre_criterio, id_evaluador, id_crea_aspectos, id_jefe from ".$vista_aplica." where id_evaluacion=".$id_criterio_evaluacion." group by fecha_periodo_evaluado, nombre_criterio, id_evaluador, id_crea_aspectos, id_jefe";
	$datos_evaluacion=traer_fila_row(query_db("SELECT fecha_periodo_evaluado, nombre_criterio, id_evaluador, id_crea_aspectos, id_jefe from ".$vista_aplica." where id_evaluacion=".$id_criterio_evaluacion." group by fecha_periodo_evaluado, nombre_criterio, id_evaluador, id_crea_aspectos, id_jefe"));
	$modal='<div id="modal_comentario" class="modal" style="width:90% !important;"><div class="modal-content"><h4 style="font-size:18pt !important; font-weight: 900 !important;">'.$titulo.'</h4><p style="font-size:18pt !important; font-weight: 900 !important;">Ac&aacute; encontratrar&aacute; todas las observaciones de la evaluaci&oacute;n </p><div class="row" id="agregar_fila" style="width:90% !important;"><table id="carga_periodo_resultado" class="striped centered" cellspacing="0" width="100%"><thead><tr><th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">Fecha</th><th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">Usuario</th><th width="60%" style="font-size:18pt !important; font-weight: 900 !important;">Comentario</th></tr></thead><tbody id="body_periodo_resultados"></tbody>';
	$tr='';
	$query=query_db($select); 
	
	while($lt=traer_fila_db($query)){
		$id_consulta=0;
		if($lt[3]==3 or $lt[3]==4 or $lt[3]>=7){
			$id_consulta=$datos_evaluacion[4];
		}elseif($lt[3]==5 or $lt[3]==6){
			$id_consulta=$datos_evaluacion[2];
		}
		if($lt[0]!="" and $lt[0]!=" " and $lt[0]!=NULL){
			$usuario=traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$id_consulta));
			$tr.='<tr><td>'.$lt[1].' '.$lt[2].'</td><td>'.$usuario[0].'</td><td>'.$lt[0].'</td></tr>';
		}
	}
	
	
	$modal.=$tr.'</table></div></div><div class="modal-footer"><a  class="modal-action modal-close waves-effect waves-red btn-flat " style="font-size:18pt !important; font-weight: 700 !important;">CERRAR</a></div></div>';
	echo $modal;
}

function menu_lista($col, $icono_titulo, $titulo, $texto, $icono_footer, $estilo_icono_tilulo, $estilo_texto_titulo, $estilo_icono_footer, $estilo_texto_contenido, $clase_icono_titulo, $clase_icono_footer, $action){
		
	
	$imprime='<a onclick="'.$action.'" style="cursor:pointer;"><div class = "col '.$col.' ">
				
			<div class = "card white-grey z-depth-3">
				<div class = "card-action" >
                  
                    <i class = "material-icons" style="'.$estilo_icono_tilulo.'">'.$icono_titulo.'</i>
				</div>
			   <div class = "card-content" style="width:90% !important;">  
				  
                  <span style="'.$estilo_texto_titulo.'">'.$titulo.'</span>
              
				  
                  <span style="'.$estilo_texto_contenido.'">'.$texto.'</span>
               </div>
                    <i class = "material-icons" style="'.$estilo_icono_footer.'">'.$icono_footer.'</i>
				
         </div>
		 </div></a>';
		 
		 echo $imprime;
	
	
}


function menu_banner($col, $texto, $estilo_texto_contenido, $estilo_link, $estilo_card){
		
	
	$imprime='<div class = "col '.$col.'">
				
			<div class = "card  z-depth-3" style="'.$estilo_card.'">
				
               <div class = "card-content" style="width:90% !important;">  
				  
                  <span style="'.$estilo_texto_contenido.'">'.$texto.'</span>
               </div>
               
               
         </div>
		 </div>';
		 
		 echo $imprime;
	
	
}
?>