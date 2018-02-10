<?  include("../../librerias/lib/@session.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Acta_apertura.doc"); 
	header("Content-Transfer-Encoding: binary");

$lista_licitaciones = "select * from $t5 where pro1_id  = $id_invitacion";
$linvi=traer_fila_row(query_db($lista_licitaciones));

$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));
$busca_us_sox = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[2]"));
$busca_us_comprador = traer_fila_row(query_db("select nombre_administrador from us_usuarios  where us_id = $buscar_datos_ap[3]"));


$oferta_vista = 1;   
$valor_apertura_auditor=100000;

             /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/
			 
                    if($linvi[13]==1)
                        $cuantia=$linvi[14];
                    elseif($linvi[13]==2)
                    $cuantia=($linvi[14]+1) / 1800;
                    elseif($linvi[13]==3)
                        $cuantia=( ($linvi[14]+1) * 2700 ) / 1800;			
                
                $cuantia_arr = explode(".",$cuantia);		
                $cuantia =$cuantia_arr[0];		
                
				
                /* CALCULO DEL VALOR DEL PROCESO PASARLO A DOLARES*/  

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
@charset "iso-8859-1";

body {
	color:#333333;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	background:url(../imagenes/imagen/cubo_fondo_pagina.jpg);
}

/*tabulador*/
ul, ol {list-style:none;}
li {font-size:1.166em; line-height:2.485em; padding-left:20px; background:url(../imagenes/botones/flecha_a.png) 0 9px no-repeat; text-align:left}

legend{ font-size:16px; color:#333333; font-weight:bold;}


/*FONDOS BANNER*/

#cubo_fondo{ background:url(../imagenes/imagen/cubo_fondo.jpg) }
#cubo_pie{ background:url(../imagenes/imagen/cubo_fondo_pie.jpg); text-align:center; font-size:11px; color:#FFFFFF; height:20px;  }

/*HIPERVINCULOS*/


/*FORMULARIOS*/

input { 
 font-size: 11px; 
 background-color:#FFFFCC; 
 font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
height:20px;
padding-left:5px; padding-right:30px;
}

select{
 font-size: 11px; 
 background-color: #FFFFCC; 
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
height:25px;
		
}


input.f_fechas{ border:1px solid; background:#FFFFFF;height:15px;
padding-left:5px; padding-right:30px;}


input.guardar{
 background-image:url(../imagenes/botones/b_guardar.gif);
  background-repeat:no-repeat;
  cursor:pointer;
  padding-left:30px;
}

input.calcular{
  background-image:url(../imagenes/botones/calcular.jpg);
  background-repeat:no-repeat;
  cursor:pointer;
  padding-left:30px;
}

input.buscar{
  background-image:url(../imagenes/botones/busqueda.gif);
  background-repeat:no-repeat;
  cursor:pointer;
  padding-left:30px;

}

input.cancelar{
  background-image:url(../imagenes/botones/b_cancelar.gif);
  background-repeat:no-repeat;
  cursor:pointer;
  padding-left:30px;
}

input.campos_faltantes { 
border: 1px solid #FF0000;
}

input.campos_faltantes_fecha { 
border:1px solid #FF0000; background:#FF0000;height:15px;
padding-left:5px; padding-right:30px;
}


select.select_faltantes{ 
background-color:#FF8080; border: 1px solid #FF0000;
}

/*TABLAS*/

table{ border-spacing:3px; margin-left:auto; margin-right:auto; }
td{ text-align:right;  }
.tabla_borde_azul_fondo_blanco{BORDER-BOTTOM: #4491BF 1px solid; BORDER-TOP: #4491BF 1px solid; BORDER-RIGHT: #4491BF 1px solid; 	BORDER-LEFT: #4491BF 1px solid; 	background-color: #ffffff;border-spacing:6px;}
.tabla_sin_borde_fondo_gris{	background-color:#CCCCCC}

.tabla_lista_resultados{  margin:10px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
 }
.campos_blancos_listas { font-size:10px; background-color:#FFFFFF; text-align:left; }
.campos_gris_listas { font-size:10px; background-color:#E9E9E9; text-align:left;}
.campos_blancos_listas_evaluador { font-size:10px; background-color:#FFFFFF; text-align:left; 	BORDER-BOTTOM: #666666 1px ; 
	BORDER-TOP: #666666  1px solid; 
	BORDER-RIGHT:#666666  1px solid; 
	BORDER-LEFT: #666666  1px solid; }
	
.campos_blancos_listas_evaluador_titulos_campos { font-size:10px; background-color:#333333; color:#FFFFFF; text-align:center;  }
	



.tabla_cronograma{ BORDER-BOTTOM: #4491BF 1px solid; BORDER-TOP: #4491BF 1px solid; BORDER-RIGHT: #4491BF 1px solid; 	BORDER-LEFT: #4491BF 1px solid; 	background-color: #ffffff;border-spacing:6px;
  border-spacing:2px; bor
 }
.campos_blancos_cronograma td{ font-size:12px; background-color:#FFFFFF; text-align:left; }
.campos_gris_cronograma  td{ font-size:12px; background-color:#E9E9E9; text-align:left;}



.columna_titulo_resultados{ font-size:11px; background:#9FC2FD;   BORDER-BOTTOM: #999999 1px solid; }
.columna_titulo_resultados_evaluador{ font-size:10px; background:url(../imagenes/botones/fondo_tabla_resultados_economico.png); height:30px;   BORDER-BOTTOM: #999999 1px solid; text-align:center }
.columna_titulo_resultados_evaluador_titulo_proveedor{ color:#000000; font-size:10px; background:url(../imagenes/botones/fondo_tabla_resultados_economico_tp.png); height:30px;   BORDER-BOTTOM: #999999 1px solid; text-align:center }
.columna_subtitulo_resultados{ height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD }



.columna_subtitulo_resultados_economico{ height:20px;font-size:10px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD; text-align:center; }

.tabla_paginador{ font-size:14px; color:#666666}
/*TITULOS*/



.titulo_tabla_azul_sin_bordes{ color:#ffffff; font-size:14px; background-color:#4491BF; text-align:center}

.titulos_procesos { font-size: 14px;text-align:left; font-weight: bold; color: #000000;  BORDER-BOTTOM: #C7422F 1px solid; 	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;}

.titulos_evaluacion { font-size: 14px; font-weight: bold; color: #000000;  font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;}


.titulo_tabla_proveedor1{ color:#ffffff; font-size:14px; background-color:#4491BF; text-align:center}
.titulo_tabla_proveedor2{ color:#ffffff; font-size:14px; background:#FFFF66; text-align:center}
.titulo_tabla_azul_sin_bordes_reporte{ color:#ffffff; font-size:12px; background-color:#4491BF; text-align:center}

.divicion_tablas {
	BORDER-BOTTOM: #666666 1px ; 
	BORDER-TOP: #666666  1px solid; 
	BORDER-RIGHT:#666666  1px solid; 
	BORDER-LEFT: #666666  1px solid; 
	font-size: 10px;

}

.divicion_tablas_oferntes {
	BORDER-BOTTOM: #666666 1px ; 
	BORDER-TOP: #666666  1px solid; 
	BORDER-RIGHT:#666666  1px solid; 
	BORDER-LEFT: #666666  1px solid; 
	font-size: 12px;

}


/*CONTENIDOS*/

.telefono_contacto{ font-size:18px; color:#FF0000; text-align:center}
.chat_contacto{ font-size:18px; color:#006633; text-align:center}
img {  border: none; cursor:pointer;}

.tabla_menu_relover{ background:#FFFDB9; cursor:pointer;}

.oferta_ganadora{ color:#006600; text-align:center; font-size:12px}
.oferta_perdedora{ color:#FF0000; text-align:center; font-size:12px}

.tabla_borde_azul_fondo_blanco_oferente{ font-size:12px;BORDER-BOTTOM: #4491BF 1px solid; BORDER-TOP: #4491BF 1px solid; BORDER-RIGHT: #4491BF 1px solid; 	BORDER-LEFT: #4491BF 1px solid; 	background-color: #ffffff;border-spacing:6px;}
	
</style>

</head>
<body >

<div>
<img src="http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente.png" ><br>
  </p>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos"><div align="center">SECCION: ACTA DE APERTURA DEL PROCESO</div></td>
  </tr>
</table>
<br>
  <div class="titulos_evaluacion">Informaci&oacute;n General del Proceso</div>
  <p><strong>Consecutivo del proceso:</strong>
    <?=$linvi[22];?>
    <br>
      <strong>Detalle y cantidad del objeto a contratar:</strong>
    <?=$linvi[12];?>    
    
    <br>
    <br>
  </p>
  <div class="titulos_evaluacion">Informaci&oacute;n de publicaci&oacute;n</div>
  <p><strong>Fecha de publicaci&oacute;n:</strong>
      <?=$buscar_datos_ap[5];?>
      <br>
    <strong>Hora de publicaci&oacute;n:</strong>
      <?=$buscar_datos_ap[6];?></p>
  <div class="titulos_evaluacion">Informaci&oacute;n de proponentes</div>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" >
  <tr >
    <td width="34%" class="columna_titulo_resultados"><div align="center">Raz&oacute;n Social</div></td>
    <td width="15%" class="columna_titulo_resultados"><div align="center">Fecha y hora de cierre</div></td>
    <td width="12%" class="columna_titulo_resultados"> <div align="center">Fecha y hora recibo oferta</div></td>
    <td width="39%" class="columna_titulo_resultados"><div align="center">Comentarios</div></td>
  </tr>

<?

	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup, $t7.observaciones  ,$t7.observaciones_2 from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t8.pv_id <> 1 ");
				while($lp = traer_fila_row($busca_provee)){

 	$busca_auditor_ultimo_envio=traer_fila_row(query_db("select if(w_fecha_modifica='0000-00-00 00:00:00', w_fecha_creacion , w_fecha_modifica) as fecha_envio_oferta from v_relacion_lista_ofertas  
	 where  w_valor not in ('','Moneda','USD','COP','EURO') and in_id = $linvi[0] and pv_id = $lp[0] order by fecha_envio_oferta desc "));

 if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
?>  

  <tr class="<?=$class;?>">
    <td><div align="left">
      <?=$lp[2];?>
    </div></td>
    <td align="center"><div align="left">
      <?=fecha_for_hora($linvi[18]);?>
    </div></td>
    <td align="center"><div align="left">
      <?=fecha_for_hora($busca_auditor_ultimo_envio[0]);?>
    </div></td>
    <td align="center">
      <div align="left">
        <?
    if($buscar_datos_ap[0]>=1)
		echo $lp[6];
	else echo "<textarea name='proponente[".$lp[0]."]' id='textarea' cols='35' rows='2'></textarea>";
		
	?>    
     </div></td>
  </tr>
  
  <? 

	
    
   
   $num_fila++;} 
   ?>
</table>



<br>



 <?
	
        
        $busca_firma=traer_fila_row(query_db("select * from v_apertura_proceso_grantierra where pro1_id = $id_invitacion"));
		
		?>

 <div class="titulos_evaluacion">Firmas del acta de publicaci&oacute;n</div>

            <table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="47%">&nbsp;</td>
                <td width="6%">&nbsp;</td>
                <td width="47%">&nbsp;</td>
              </tr>
              <tr>
                <td height="42" class="titulos_procesos">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="titulos_procesos">&nbsp;</td>
              </tr>
              <tr>
                <td><div align="center"><strong>
                <?=$busca_firma[3];?>
                </strong></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"><strong>
                  <?=$busca_firma[2];?>
                </strong></div></td>
              </tr>
              <tr>
                <td><div align="center"><strong>Delegado Compras</strong></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"><strong>Delegado de Auditoria</strong></div></td>
              </tr>
              <tr>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>

</body>
</html>
