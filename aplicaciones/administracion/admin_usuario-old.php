<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
verifica_menu("administracion.html");
//paguinacion

$com_p.=" tipo_usuario in (3) and estado = 1";

if($nombre!="")
	$com_p.=" and nombre_administrador like '%$nombre%'";
if($email!="")
	$com_p.=" and email like '%$email%'";
if($nit!="")
$com_p.=" and usuario like '%$nit%'";
  

/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 300;
	$factor_b = 300;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from $g1 where   $com_p ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenido_aux">
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">SECCION: HISTORICO DE USUARIOS</td>
  </tr>
</table>

<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="titulo_tabla_azul_sin_bordes">Buscador de usuarios</td>
  </tr>
  <tr>
    <td width="26%"><div align="right"><strong>Nombre :</strong></div></td>
    <td width="23%"><div align="left">
      <input type="text" name="nombre" id="nombre"  value="<?=$nombre;?>"/>
    </div></td>
    <td width="22%"><div align="right"><strong>Email:</strong></div></td>
    <td width="29%"><div align="left">
      <input type="text" name="email" id="email" email value="<?=$email;?>"/>
    </div></td>
  </tr>
  <tr>
    <td colspan="4">
      <div align="center">
        <input name="button" type="button" class="boton_buscar" id="button" value="Buscar usuarios" onclick="busqueda_paginador_nuevo(1,'../aplicaciones/administracion/admin_usuario.php','contenidos', '0')" /></div>    </td>
    </tr>
</table>
<br />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Lista de usuarios</td>
  </tr>
</table>


<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="81%">&nbsp;</td>
        <td width="14%"><label>
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/administracion/admin_usuario.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
            </select>
        </label></td>
        <td width="5%"><a href="javascript:busqueda_paginador_nuevo(2,'../aplicaciones/administracion/admin_usuario.php','contenidos')"></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="16%" class="columna_subtitulo_resultados">Area</td>
    <td width="21%" class="columna_subtitulo_resultados"><div align="center">Nombre</div></td>
    <td width="16%" class="columna_subtitulo_resultados"><div align="center">Usuario</div></td>
    <td width="30%" class="columna_subtitulo_resultados"><div align="center">E-mail</div></td>
    <td width="12%" class="columna_subtitulo_resultados">Profesional encargado</td>
    <td width="5%" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
  </tr>
  <?  

/*if($complemento=="")
	$complemento = " and estado_proveedor = 1 ";
  */
  $busca_procesos = "select * from (select * , ROW_NUMBER() OVER(ORDER BY nombre_administrador) AS rownum from $g1 where  $com_p  ) as sub
where rownum > $inicio and rownum <= $factor_b	";
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
	
	if($ls[6]==1){
		$semaforor_estado = 'acitvo.png';
		}
	elseif($ls[6]==2){
		$semaforor_estado = 'cerrada.png';
		}
		

	if($ls[9]==1){
		$perfil = 'Administrador';
		}
	elseif($ls[9]==3){
		$perfil = 'Comprador';
		}		
	elseif($ls[9]==4){
		$perfil = 'Auditor';
		}		

$seleecion_area = query_db(" select t2.nombre from tseg3_usuario_areas as t1, t1_area as t2 where t2.estado = 1 and id_usuario =".$ls[0]." and t1.id_area = t2.t1_area_id");

$sel_profecoinal = traer_fila_row(query_db("select t2.us_id from t2_relacion_usuarios_profesionales as t1, $g1 as t2  where  t1.id_profesional = t2.us_id and t1.id_usuario = ".$ls[0].""));

  ?>
  <tr class="<?=$class;?>">
    <td><?
    while($sel_area = traer_fila_db($seleecion_area)){
		
		echo $sel_area[0].", ";
		
		}
	?></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=$ls[4];?></td>
    <td>
    
    <select name="acci2" id="acci2" onchange="cambia_profecional_de_usuario(<?=$ls[0]?>,this.value)">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
          $sel_profss = query_db("select us_id, nombre_administrador from $v_seg1 where id_premiso = 8  group by us_id, nombre_administrador");
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $sel_profecoinal[0] ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select></td>
    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" onclick="ajax_carga('../aplicaciones/administracion/modifica_usuario.php?pv_id=<?=$ls[0];?>','contenido_aux_sub');ingresar_listado('contenido_aux')" /></div></td>
  </tr>
  <tr class="<?=$class;?>">
    <td colspan="4"></td>
    <td colspan="2" id="contrase_<?=$ls[0];?>"></td>
  </tr>
  <? $num_fila++; $encontrados++;
  }// while
  
   ?>
  <tr>
    <td colspan="6" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
</table>
</div>
<div id="contenido_aux_sub"></div>

<input type="hidden" name="id_limpia" />
<input type="hidden" name="id_usua" />
<input type="hidden" name="id_prof" />

</body>
</html>
