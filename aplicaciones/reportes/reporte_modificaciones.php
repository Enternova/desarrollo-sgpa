<?php include("../../librerias/lib/@session.php");
verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');

$query_comple = "";

if ($contratista_bu != "") {
    $explode = explode("----,", elimina_comillas_2($contratista_bu));
    $id_contratista = $explode[1];
    $query_comple = $query_comple . " and contratista = " . $id_contratista;
}

if ($especialista_bu != "") {
    $explode = explode("----,", elimina_comillas_2($especialista_bu));
    $id_especialista = $explode[1];
    $query_comple = $query_comple . " and especialista = " . $id_especialista;
}

if ($objeto_bu != "") {
    $query_comple = $query_comple . " and objeto like '%" . $objeto_bu . "%'";
}

if ($tipo_contrato_bu != "0") {
    $query_comple = $query_comple . " and t1_tipo_documento_id =" . $tipo_contrato_bu . "";
}
if ($area_bu != "0") {
			$query_comple.= busca_area_emula('t1_area_id',$area_bu);
}

if ($gerente_bu != "") {
    $explode = explode("----,", elimina_comillas_2($gerente_bu));
    $id_gerente = $explode[1];
    $query_comple = $query_comple . " and gerente = " . $id_gerente;
}

$query_comple_temp = "";
if ($contrato_bu != "") {
    $contrato_bu2 = str_replace("-", "", $contrato_bu);
    $contrato_bu2 = str_replace(" ", "", $contrato_bu2);

    $query_comple_temp = $query_comple_temp . " and (consecutivo like '%" . $contrato_bu2 . "%')";

    $query_create = "CREATE TABLE #t7_contratos_contrato_temp (id int, consecutivo varchar(50))";
    $sql_contrato = query_db($query_create);

    $lista_contrato = "select * from $co1 where estado >= 1 and estado <> 33" . $query_comple . $permisos;
    $sql_contrato = query_db($lista_contrato);
    while ($rs_array = traer_fila_row($sql_contrato)) {
        $numero_contrato1 = "C"; // los campos de la tabla t7_contratos_contrato			
        $separa_fecha_crea = explode("-", $rs_array[19]); //fecha_creacion
        $ano_contra = $separa_fecha_crea[0];
        $numero_contrato2 = substr($ano_contra, 2, 2);
        $numero_contrato3 = $rs_array[2]; //consecutivo
        $numero_contrato4 = $rs_array[43]; //apellido
        $numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $rs_array[0]);
        $numero_contrato_fin = str_replace("-", "", $numero_contrato_fin);
        $numero_contrato_fin = str_replace(" ", "", $numero_contrato_fin);

        //echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
        $query_create_int = "insert into #t7_contratos_contrato_temp values (" . $rs_array[0] . ",'" . $numero_contrato_fin . "')";
        $sql_contrato_int = query_db($query_create_int);
    }

    $lista_contrato_temp = "select * from #t7_contratos_contrato_temp where id > 0 " . $query_comple_temp;
    $sql_contrato_temp = query_db($lista_contrato_temp);

    $array_id_bu = "0";
    while ($rs_array_temp = traer_fila_row($sql_contrato_temp)) {
        $array_id_bu = $array_id_bu . "," . $rs_array_temp[0];
    }

    $query_comple = $query_comple . " and id in (" . $array_id_bu . ")";
}
?>
<style>
    .columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
                                          BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
    .tabla_lista_resultados{  margin:1px;
                              BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
                              border-spacing:2px;
                              overflow:scroll;
                              cursor:pointer;
    }
</style>



<?php
    if ($xls != 1) {
        ?>
        <table width="100%">
            <tr>
                <td align="center" width="25%">&nbsp;</td>
                <td align="center">
                    <A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/reportes/reporte_modificaciones.php?xls=1&paginas='+this.value
                       +'&contrato_bu='+document.principal.contrato_bu.value
                       +'&contratista_bu='+document.principal.contratista_bu.value
                       +'&especialista_bu='+document.principal.especialista_bu.value
                       +'&objeto_bu='+document.principal.objeto_bu.value
                       +'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value
                       +'&gerente_bu='+document.getElementById('gerente_bu').value
                       +'&area_bu='+document.getElementById('area_bu').value
                       ">Exportar a Excel</A>
                </td>
            </tr>
        </table>
        <?php
    }
    ?>
    


<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">

    
    <tr >
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Contrato</td>
        <td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Contratista</td>
        <td width="35%" align="center" class="columna_subtitulo_resultados_oscuro">Objeto del Contrato</td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">&Aacute;rea Usuaria</td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo Contrato</td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo Evento</td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Tipo Otros&iacute;</td>
        <!--
        <td width="15%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha de Creacion de la Modificacion</td>
        <td width="15%" align="center" class="columna_subtitulo_resultados_oscuro">Recibido Abastecimiento de la Modificacion</td>
        <td width="15%" align="center" class="columna_subtitulo_resultados_oscuro">Recibido Abastecimiento del Contrato</td>
        
        <td width="18%" align="center" class="columna_subtitulo_resultados_oscuro">Area Ejecuci&oacute;n</td>-->
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero </td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Profesional C&C </td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Gerente</td>
        <td width="5%" align="center" class="columna_subtitulo_resultados_oscuro">Estado</td>  
        <!--<td width="17%" align="center" class="columna_subtitulo_resultados_oscuro">Contrato USD</td>  
        <td width="17%" align="center" class="columna_subtitulo_resultados_oscuro">Contrato COP</td>  
        <td width="17%" align="center" class="columna_subtitulo_resultados_oscuro">Modificaci&oacute;n USD</td>  
        <td width="17%" align="center" class="columna_subtitulo_resultados_oscuro">Modificaci&oacute;n COP</td>-->
        <td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Aprobaciones</td>
    </tr>
    <?php
    $permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
    $permisos = $permisos . $query_comple;
    $permisos = str_replace("especialista", "especialista_id", $permisos);
    $permisos = str_replace("gerente", "gerente_id", $permisos);
    $permisos = str_replace("contratista", "contratista_id", $permisos);

    $busca_reportes = "select * from $v_contra_modif where id is not null $permisos order by id";
    $sql_re = query_db($busca_reportes);
    
    
    while ($ls_re = traer_fila_db($sql_re)) {
        ?>
        <tr class="filas_resultados">
            <td>
                <?php
                $numero_contrato1 = "C"; // los campos de la tabla t7_contratos_contrato			
                $separa_fecha_crea = explode("-", $ls_re['creacion_sistema']); //fecha_creacion
                $ano_contra = $separa_fecha_crea[0];
                $numero_contrato2 = substr($ano_contra, 2, 2);
                $numero_contrato3 = $ls_re['consecutivo']; //consecutivo
                $numero_contrato4 = $ls_re['apellido']; //apellido
                //echo $sql_con[19]." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
                echo numero_item_pecc_contrato($numero_contrato1, $numero_contrato2, $numero_contrato3, $numero_contrato4, $ls_re['id']);
                ?>
            </td>
            <td><?= $ls_re['nombre_contratista'] ?></td>
            <td><?= $ls_re['objeto']?></td>
            <td><?= saca_nombre_lista($g12,$ls_re['t1_area_id'],'nombre','t1_area_id');?></td>
            <td><?= $ls_re['tipo_documento'];?></td>
            <td><?= $ls_re['tipo_complemento_nombre'];?></td>
            <td><?= $ls_re['tipo_otro_si'];?></td>
            <!--
            <td><?= $ls_re[26] ?></td>
            <td><?= $ls_re[25] ?></td>
            <td><?= $ls_re['recibido_abastecimiento'] ?></td>
            <td><?= $ls_re['tipo_area_ejecucion']?></td> 
            -->
            
            <td><?= $ls_re['numero_otrosi'] ?></td>
            <td><?= $ls_re['nombre_especialista'] ?></td>
            <td><?= $ls_re['nombre_gerente'] ?></td>
            <td><?= estado_contrato_retu(arreglo_pasa_variables($ls_re['id']), $co1) ?></td>
            <!--<td><?= number_format($ls_re['monto_usd']) ?></td>
            <td><?= number_format($ls_re['monto_cop']) ?></td>
            <td><?= number_format($ls_re['modificacion_usd']) ?></td>
            <td><?= number_format($ls_re['modificacion_cop']) ?></td>-->
            
            <td>
            	<table width="100%">
                	<?php 
					$busAprob = "select id_nivel_aprobacion_adjudicacion, nombre, id_usuario_aprueba_adjudicacion from t2_nivel_aprobacion_relacion inner join t2_nivel_aprobacion on id = id_nivel_aprobacion_adjudicacion  where id_item = ".$ls_re['id_item'];
					$sqlAprob = query_db($busAprob);
					while ($rowAprob = traer_fila_db($sqlAprob)) {
						if($rowAprob[0] == 4)
						$nombreAprob = $rowAprob[2];
						else $nombreAprob = traer_nombre_muestra($rowAprob[2], $g1,"nombre_administrador","us_id");
					?>
                	<tr>
                    	<td><?= $rowAprob[1]?></td>
                        <td><?= $nombreAprob?></td>
                    </tr>
                    <?php }?>
                </table>
            </td>
            
        </tr>
        <?php
    }
    ?>
</table>
<?php

if ($xls == 1) {
    header('Content-type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=Historico Contrato.xls");
}
?>