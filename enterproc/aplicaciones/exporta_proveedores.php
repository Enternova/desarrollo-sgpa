<?  include("../librerias/lib/@session.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de cartelera de aclaraciones.xls"); 
	header("Content-Transfer-Encoding: binary");


	//paguinacion

if($nombre!="")
  $com_p.=" and pv_nombre like '%$nombre%'";
if($email!="")
  $com_p.=" and pv_email like '%$email%'";
if($nit!="")
$com_p.=" and pv_nit like '%$nit%'";
  

$numero_pagi = 50;
if ($pag=="")
  $pag = 1;
else
  $pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


    $li_n_c=traer_fila_row(query_db("select count(*) 
   from $v2 where 1 $com_p  "));
      $total_r = $li_n_c[0];
      $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
  $proxima = $pag;
else
  $proxima = $pag +1;
  
if($pag==1)
  $anterior = $pag;
else
  $anterior = $pag -1;
  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<style>
  .th td{
    background: #005395;
    background-color: #005395;
    color: #FFF;
  }
  .campos_blancos_listas td{ font-size:12px; background-color:#ffffff; text-align:left; }
  .campos_gris_listas  td{ font-size:12px; background-color:#DBFBDC; text-align:left;}
</style>
</head>

<body>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="th">
    <td width="30%" ><strong>Nombre</strong></td>
    <td width="11%"><strong>Identificaci&oacute;n</strong></td>
    <td width="27%"><strong>E-mail</strong></td>
    <td width="10%"><strong>Invitaciones</strong></td>
    <td width="12%"><strong>Adjudicaciones</strong></td>
  </tr>
  <?  

/*if($complemento=="")
  $complemento = " and estado_proveedor = 1 ";
  */
    $busca_procesos = "select * from $v2 where 1 $com_p ";
  $sql_ex = query_db($busca_procesos);
  while($ls=traer_fila_row($sql_ex)){

        if($num_fila%2==0)
        $class="campos_blancos_listas";
      else
        $class="campos_gris_listas";
        
  
  if($ls[13]==1){
    $semaforor_estado = 'acitvo.png';
    }
  elseif($ls[13]==2){
    $semaforor_estado = 'cerrada.png';
    }

  elseif($ls[13]==3){
    $semaforor_estado = 'enproceso.png';
    }

          $busca_participacion = traer_fila_row(query_db("select count(*) from $t7 where pv_id = $ls[0] "));
          $busca_adjudicaciones = traer_fila_row(query_db("select count(*) from $t13 where pv_id = $ls[0] and adjudicado = 1 "));


  ?>
  <tr class="<?=$class;?>">
    <td><?=$ls[2];?></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[11];?></td>
    <td><?=$busca_participacion[0];?></td>
    <td><?=$busca_adjudicaciones[0];?></td>
  </tr>
  <? $num_fila++; $encontrados++;
  }// while
  
   ?>
</table>
</body>
</html>