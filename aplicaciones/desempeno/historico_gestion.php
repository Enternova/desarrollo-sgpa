<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	$id_proveedor=elimina_comillas(arreglo_recibe_variables($_GET['id_evaluacion']));
	$tipo=elimina_comillas(arreglo_recibe_variables($_GET['tipo']));
	$_SESSION["id_us_proveedor"]=$_GET['id_evaluacion'];
	$nombre_proveedor=traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$id_proveedor));
if($tipo==1){//si la busqueda viene por contrato
	/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA ***/
			$total_tecnica=NULL;
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=2 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=2 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor);
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
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=3 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=3 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor);
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
					$total_tecnica=$total_tecnica/$total;
					$campos_tabla_body.='<td aling ="center">'.$total_tecnica.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
			/*** FIN SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA ***/
			/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION HSSE ***/
			$total_hsse=NULL;
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=4 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=4 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor);
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
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=5 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=5 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor);
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
					$total_hsse=$total_hsse/$total;
					$campos_tabla_body.='<td aling ="center">'.$total_hsse.'</td>';
				}else{
					$campos_tabla_body.='<td aling ="center">No registra</td>';
				}
			/*** FIN SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION HSSE ***/
			/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION ADMINISTRATIVA ***/
			$total_administrativa=NULL;
			//PARA CONTRATO PUNTUAL
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=6 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_puntual WHERE id_estado_criterio=9 and id_criterio=6 and estado_aspecto=1 and tipo_documento=2 and id_proveedor=".$id_proveedor);
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
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=7 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_contrato_marco WHERE id_estado_criterio=9 and id_criterio=7 and estado_aspecto=1 and tipo_documento=3 and id_proveedor=".$id_proveedor);
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
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #FE5722;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion<90){//BUENO
						$campos_tabla_body.='<td aling ="center"><i class="material-icons" style="color: #FEEA3B;">'.$icono_star.'</i></td>';
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
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #FE5722;">'.$icono_star.'</i></td>';
					}elseif($total_evaluacion_sm<90){//BUENO
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #FEEA3B;">'.$icono_star.'</i></td>';
					}else{//EXCELENTE
						$campos_tabla_body_sm.='<td aling ="center"><i class="material-icons" style="color: #4CAF50;">'.$icono_star.'</i></td>';
					}
				}else{
					$campos_tabla_body_sm.='<td aling ="center"></td>';
				}
			/*** FIN SE VERIFICAN LOS TRES PUNTAJES PARA SABER LA CLASIFICACION ***/
}elseif($tipo==2){//si la busqueda viene por servicio menor
	/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA ***/
			$total_tecnica_sm=NULL;
			//PARA SERVICIOS MENORES
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_servicio_menor WHERE id_estado_criterio=9 and id_criterio=1 and estado_aspecto=1 and tipo_documento=1 and id_proveedor=".$id_proveedor));
				$sel_while=query_db("SELECT puntaje_obtenido as puntaje, id_evaluacion FROM vista_t9_servicio_menor WHERE id_estado_criterio=9 and id_criterio=1 and estado_aspecto=1 and tipo_documento=1 and id_proveedor=".$id_proveedor);
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
}
?>
<div class="row">
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">RESULTADOS GENERALES DEL PROVEEDOR: <?=$nombre_proveedor[0];?></h5></div>
		
		<div class="" style="background: #181818; height: 2px;"></div>
		
</div>		
<div class="row">
	<div class = "col s12 m7 l7" style="">
		<div class = "card  z-depth-3 white-grey" >
			<div class = "card-content" style="width:90% !important;">
				<div id="grafica_resultado" style="height: 33rem !important;"></div>
			</div>
		</div>
	</div>
	<?
	if($tipo==1){//si la busqueda viene por contrato
	?>
	<div class="col s12 m5 l5">
		<div class="row">
			<div class = "col s12 m12 l12">
				<div class = "card  z-depth-3" style="white-grey">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n General: <br><?=$total_evaluacion;?> / 100</span>
					</div>
				</div>
				<div class = "card  z-depth-3" style="white-grey" style="top: -50% !important;">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n T&eacute;cnica: <br><?=$total_tecnica;?> / 40</span>
					</div>
				</div>
				<div class = "card  z-depth-3" style="white-grey" style="top: -50% !important;">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n HSSE: <br><?=$total_hsse;?> / 35</span>
					</div>
				</div>
				<div class = "card  z-depth-3" style="white-grey" style="top: -50% !important;">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n Administrativa: <br><?=$total_administrativa;?> / 25</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
	}elseif($tipo==2){//si la busqueda viene por servicio menor
	?>
	<div class="col s12 m5 l5">
		<div class="row">
			<div class = "col s12 m12 l12">
				<div class = "card  z-depth-3" style="white-grey">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n General: <br><?=$total_tecnica_sm;?> / 100</span>
					</div>
				</div>
				<div class = "card  z-depth-3" style="white-grey" style="top: -50% !important;">
					<div class = "card-content" style="width:90% !important;">
						<span style="font-size: 18pt; font-weight: 900 !important; tex-align:center; tex-align:justify;">Calificaci&oacute;n T&eacute;cnica: <br><?=$total_tecnica_sm;?> / 100</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?
	}
	?>
</div>
<table id="carga_periodo_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="30%">
		  <?
			$accion='buscador_periodo_resultados()';
			input_con_accion_texto_grande('s12 m6 l4', $val_input, 'periodo', 'validate', 'font-size:18pt !important; font-weight: 900 !important;', 'Periodo', 'text', 'onkeyup', $accion, 'font-size:18pt !important; font-weight: 900 !important; color: #000000;');
		  ?>
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Tipo Documento
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n T&eacute;cnica
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n HSSE
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n Administrativa
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			Total
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			Clasificaci&oacute;n
		  </th>
		  <th width="5%" style="font-size:18pt !important; font-weight: 900 !important;">
			Ver
		  </th>
	  </tr>
	</thead>
	<tfoot id="foot_periodo_resultados"></tfoot>
	<tbody id="body_periodo_resultados"></tbody>
</table>