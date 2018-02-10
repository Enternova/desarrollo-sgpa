<? include("../../librerias/lib/@session.php"); 

	
	$id_proveedor = elimina_comillas(arreglo_recibe_variables($_GET["id_proveedor"]));
	$muestra_cotrato="";
	$muestra_sm="";
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
		/*** SELECT PARA TRAER LOS TOTALTES DEL PROVEEDOR DE LA EVALUACION TECNICA SERVICIO MENOR ***/
			$total_tecnica_sm=NULL;
			//PARA SERVICIOS MENORES
				$total_servicio_menor=traer_fila_row(query_db("SELECT SUM(puntaje_obtenido) as puntaje FROM vista_t9_servicio_menor WHERE id_estado_criterio=9 and id_criterio=1 and estado_aspecto=1 and tipo_documento=1 and id_proveedor=".$id_proveedor));
				if($total_servicio_menor[0]!="" and $total_servicio_menor[0]!=" " and $total_servicio_menor[0]!="NULL" and $total_servicio_menor[0]!=NULL){
					$muestra_sm="si";
					$total_tecnica_sm=$total_tecnica_sm+$total_servicio_menor[0];
					$campos_tabla_body_sm.='<td aling ="center">'.$total_tecnica_sm.'</td></td><td aling ="center">No aplica</td><td aling ="center">No aplica</td>';
				}else{
					$campos_tabla_body_sm.='<td aling ="center">No registra</td></td><td aling ="center">No aplica</td><td aling ="center">No aplica</td>';
				}
	if($muestra_sm="si" and $muestra_cotrato="si"){
		
	}
	$Sel_proverdor = traer_fila_row(query_db("select * from t1_proveedor where t1_proveedor_id=".$id_proveedor));
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<p>&nbsp;</p>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones" align="center">Reporte General de Evaluaci&oacute;n del Proveedor (Promedio) <br><?=$Sel_proverdor[3]?></td>
  </tr>
  <tr>
    <td colspan="7"  class="titulos_secciones" align="center">Clasificaci&oacute;n del Proveedor: Excelente(90-100), Bueno(80-89), Por Mejorar(60-79) y No Cumple(0-59).</td>
  </tr>
  <tr class="fondo_3">
        <td width="25%" align="center">Evaluaci&oacute;n T&eacute;cnica</td>
        <td width="25%" align="center">Evaluaci&oacute;n HSSE</td>
        <td width="25%" align="center">Evaluaci&oacute;n Administrativa</td>
        <td width="25%" align="center">Total</td>
      </tr>
      <tr><?=$campos_tabla_body;?></tr>
</table>
</body>
</html>
