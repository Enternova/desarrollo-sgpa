<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");
	
$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		if($sel_us_bodega[0]>0){
			
		 $menu_comple='<tr>
          <td class="fondo_1"><div align="center">c.</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/formulario-solicitud-pecc-compras.php?id_pecc=1&id_tipo_proceso_pecc=1&id_tipo_contratacion=3\',\'contenidos\')">MRO STOCK</td>
        </tr>';
		
		}
		
		
$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Volver al Men&uacute; SGPA</td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">2</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/historico.php?id_pecc=1&id_tipo_proceso_pecc=1\',\'contenidos\')">Hist&oacute;rico de Solicitudes </td>
        </tr>';

/*+++++++++++++++++++solo si tiene permiso para crear solicitudes+++++++++++++*/		        
$sel_si_tiene_profesional = traer_fila_row(query_db("select count (*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (5, 9, 10, 13, 15, 16)"));
if($sel_si_tiene_profesional[0]>0){
$menu.=' <tr>
          <td width="83%" class="fondo_1" align="center" colspan="2" >Crear Solicitud para<br /> Contratación de Servicios</td>
        </tr>';

$si_tiene_servicio_menor = traer_fila_row(query_db("select count(*) from t1_tipo_proceso where t1_tipo_proceso_id = 16 and estado = 1"));

if($si_tiene_servicio_menor[0]>0){
		
$menu.='	 <tr> 
          <td class="fondo_1"><div align="center">a.</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/carga_proveedores_servicio_menor.php?id_pecc=1&id_tipo_proceso_pecc=1\',\'contenidos\')">Servicio Menor </td>
        </tr>';
}
		 
$menu.='		 <tr>
          <td class="fondo_1"><div align="center">b.</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/formulario-solicitud-pecc.php?id_pecc=1&id_tipo_proceso_pecc=1\',\'contenidos\')">Servicio Mayor</td>
        </tr>
		 <tr>
          <td class="fondo_1" align="center">c.</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/busca-amplia-pecc.php?id_tipo_proceso_pecc=2&id_pecc=1\',\'contenidos\')">Ampliar Contrato Marco</td>
        </tr>';		
		
$menu.='<tr>
          <td class="fondo_1" align="center">d.</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/busca-amplia-pecc.php?id_tipo_proceso_pecc=3&id_pecc=1\',\'contenidos\')">Orden de Trabajo</td>
        </tr>';
$menu.='<tr>
          <td width="83%" class="fondo_1" align="center" colspan="2" >Crear Solicitud para<br /> Compra de Materiales</td>
        </tr>';
$menu.='<tr>
          <td class="fondo_1"><div align="center">a.</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/formulario-solicitud-pecc-compras.php?id_pecc=1&id_tipo_proceso_pecc=1&id_tipo_contratacion=4\',\'contenidos\')">Corporativo </td>
        </tr>
		<tr>
          <td class="fondo_1"><div align="center">b.</div></td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/formulario-solicitud-pecc-compras.php?id_pecc=1&id_tipo_proceso_pecc=1&id_tipo_contratacion=2\',\'contenidos\')">MRO Proyectos</td>
        </tr>'.$menu_comple;
}
/*-------------solo si tiene permiso para crear solicitudes------------------*/

/*------------si es gestor abastecimiento------------
$sel_si_tiene_gestion_abas = traer_fila_row(query_db("select count (*) from tseg12_relacion_usuario_rol where id_usuario = ".$_SESSION["id_us_session"]." and id_rol_general in (21)"));
if($sel_si_tiene_gestion_abas[0]>0){
$menu.=' <tr>
          <td width="83%" class="fondo_1" align="center" colspan="2" >Crear Solicitudes de Servicios</td>
        </tr>';		
		
$menu.='<tr>
          <td class="fondo_1" align="center">d.</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/pecc/busca-amplia-pecc.php?id_tipo_proceso_pecc=3&id_pecc=1\',\'contenidos\')">Orden de Trabajo</td>
        </tr>';
}
------------si es gestor abastecimiento------------*/
        
        if($es_local=="NO"){
     $menu.='   <tr>
          <td class="fondo_1"><div align="center"></div></td>
           <td class="fondo_2" onclick=window.location.href="../index.php">Salida Segura</td>
        </tr>';		
		}
		
$menu.='    </table>';

$modulo="MODULO SOLICITUDES DEL SGPA";	
$alertas="../aplicaciones/pecc/historico.php?id_pecc=1";
	
	echo $menu."$$".$modulo."$$".$alertas;
	?>
	