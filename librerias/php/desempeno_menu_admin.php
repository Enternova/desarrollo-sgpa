<? include("../lib/@session.php"); 
	verifica_menu("administracion.html");

//$verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 10 and us_id =".$_SESSION["id_us_session"]));
if($_SESSION["id_us_session"]==32 or $_SESSION["id_us_session"]==30){
	$verifica_permiso=1;
}else{
	$verifica_permiso=0;
}
$puede_crear='';
if($verifica_permiso>0){
	$puede_crear.='';//queda desabilitado
		
		
        
	}

  //if($_SESSION["id_us_session"]==32){
    $puede_crear.='<tr>
          <td class="fondo_1" align="center">3</td>
          <td class="fondo_2" onclick="ajax_carga(\'../aplicaciones/desempeno/principal.php?t10_mesa_ayuda_principal_id=0\',\'contenidos\');ajax_carga(\'../aplicaciones/mesa-ayuda/menu_manuales_blank.php\',\'id_div_sub\')">Hist&oacute;rico de Desempe&ntilde;o</td>
        </tr>';
  //}
$menu='<table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" class="fondo_1" align="center">1</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href=\'administracion.html\'">Menu SGPA</td>
        </tr>'.$puede_crear;
       if($es_local=="NO"){
    $menu.='    <tr>
          <td class="fondo_1"><div align="center">&nbsp;</div></td>
          <td class="fondo_2" onclick=window.location.href="../index.php">Salida Segura</td>
        </tr>	';	
	   }
  $menu.='  </table>

<div id="id_div_sub"></div>
';

$modulo="MODULO DESEMPE&Ntilde;O DEL SGPA";	
$alertas="../aplicaciones/desempeno/principal.php";
	
	echo $menu."$$".$modulo."$$".$alertas;

	?>
	