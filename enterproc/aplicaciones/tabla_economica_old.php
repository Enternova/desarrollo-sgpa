<? include("../librerias/lib/@session.php");
//	$lista_licitaciones = "select * from $t55 where in_id = $id_invitacion";
	//$linvi=traer_fila_row(query_db($lista_licitaciones));

	$id_vari=$id_invitacion;
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

if($accion=="activa_campo_subasta")
	{
		$borra_anetrios = query_db("delete from $t93 where in_id = $id_invitacion and evaluador3_termino=4");
		$inserta_campo_subasta = query_db("insert into $t93 (in_id, evaluador3_termino,  evaluador3_valor  ) value ($id_invitacion,4,$valor_campo)");
		?>
        	<script>
				alert("La subasta se activo con éxito")
			</script>
        <?
		
	}

if($accion=="graba_fecha")
	{
		$cambia_fecha = query_db("update $t5 set  apertura_economica='$a_j', cierre_economica='$c_j' where pro1_id = $id_invitacion");
		?>
        	<script>
				alert("Las fechas se grabaron con éxito")
			</script>
        <?
		
	}

$busca_fechas = traer_fila_row(query_db("select apertura_economica ,cierre_economica, fecha_apertura, fecha_cierre from $t5
where pro1_id = $id_invitacion"));

if($busca_fechas[0]=="0000-00-00 00:00:00")
	$fecha_apertura_economica = $busca_fechas[2];
else
	$fecha_apertura_economica = $busca_fechas[0];

if($busca_fechas[1]=="0000-00-00 00:00:00")
	$fecha_cierre_economica = $busca_fechas[3];
else
	$fecha_cierre_economica = $busca_fechas[1];

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../librerias/js/procesos.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>

<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />

<script type="text/javascript">

	
			$(function(){
				
				
			$('#a_j').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
				
					$('#c_j').datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});				

				
			});


		</script>
<script>
function sube_archivo()
	{
	var forma = document.formulario
	if(forma.archivo_lista.value=="")
		{
		alert("Anexe el archivo de excel con el listado de articulos.")
		return;
		}
	else
	{
			forma.target="grp";
			forma.action = "configuracion_criteriosmasivo.html";
			forma.accion.value="campo";
			forma.submit();
	}
	
}



function crea_campo()
	{


	var forma = document.formulario
	if(forma.n_campo.value=="")
		{
		alert("digite el nombre del requerimiento")
		return;
		}
	if(forma.tipo_campo.value=="0")
		{
		alert("Seleccione el tipo de requerimiento")
		return;
		}

	if(forma.orden_aparicion.value=="")
		{
		alert("Digite el orden de aparición")
		return;
		}		
	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_campo";
			forma.submit();

	
	}
	
	}




function edita_requerimiento(id_requerimiento,a,b,c)
	{


	var forma = document.formulario

	
	if(a.value=="")
		{
		alert("digite el nombre del requerimiento")
		return;
		}
	if(b.value=="0")
		{
		alert("Seleccione el tipo de requerimiento")
		return;
		}

	if(c.value=="")
		{
		alert("Digite el orden de aparición")
		return;
		}		
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="e_configura_evaluacion_campo";
			forma.submit();

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}
	
	
function elimina_requerimiento(id_requerimiento)
	{


	var forma = document.formulario
	var msg = confirm("ATENCIÓN:\n Esta seguro de eliminar este requerimiento ? ")
	if(msg){
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="elimina_configura_evaluacion_campo";
			forma.submit();

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}
	


function edita_articulos(id_requerimiento,a,b,c,d,e)
	{


	var forma = document.formulario

	
	if(a.value=="")
		{
		alert("digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(b.value=="")
		{
		alert("digite el detalle del producto que le solicitara al proveedor")
		return;
		}

	if(c.value=="")
		{
		alert("digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}	
	if(d.value=="")
		{
		alert("digite la cantidad del producto que le solicitara al proveedor")
		return;
		}	
		
	if(e.value=="0")
		{
		alert("Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}	
		
			
						
	else
	{
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="edita_articulos_lista";
			forma.submit();

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}

	
	}


function crea_articulo()
	{
	var forma = document.formulario
	if(forma.a.value=="")
		{
		alert("digite el codigo del producto que le solicitara al proveedor")
		return;
		}
	if(forma.b.value=="")
		{
		alert("digite el detalle del producto que le solicitara al proveedor")
		return;
		}
	if(forma.c.value=="")
		{
		alert("digite la unidad de medida del producto que le solicitara al proveedor")
		return;
		}
	if(forma.d.value=="")
		{
		alert("digite la cantidad del producto que le solicitara al proveedor")
		return;
		}
	if(forma.e.value=="0")
		{
		alert("Seleccione la moneda del producto que le solicitara al proveedor")
		return;
		}

	else
	{
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="configura_evaluacion_articulo";
			forma.submit();

	
	}
	
	}


function elimina_articulo(id_requerimiento)
	{


	var forma = document.formulario
	var msg = confirm("ATENCIÓN:\n Esta seguro de eliminar este bien o servicio ? ")
	if(msg){
			forma.campo_id.value = id_requerimiento;
			forma.target="grp";
			forma.action = "../librerias/php/procesos_licitacion.php";
			forma.accion.value="elimina_articulo_lista";
			forma.submit();

			forma.campo_id.value = "";
			forma.target="";
			forma.action = "";
			forma.accion.value="";

	
	}
	
	}

function activar_subasta(campo_activa){
var forma = document.formulario
var msg = confirm("Esta a punto de activar este campo para la subasta. \nNOTA: Esta seguro ?");
if(msg)
	{

			forma.action = "configuracion_criteriosec.html";
			forma.accion.value="activa_campo_subasta";
			forma.valor_campo.value = campo_activa;
			forma.submit();
	
	}

}

function graba_fecha(){
var forma = document.formulario

			if(forma.a_j.value==""){
				alert("Digite la fecha de apertura")
				return
				
				}
			if(forma.c_j.value==""){
				alert("Digite la fecha de cierre")
				return
				
				}
else{

			forma.action = "configuracion_criteriosec.html";
			forma.accion.value="graba_fecha";
			
			forma.submit();
	}

}

</script>
</head>
<body >
 <form name="formulario" method="post" action="configuracion_criteriosec.html" enctype="multipart/form-data" >
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td  class="titulos_procesos">TABLA DE CONDICIONES ECONOMICAS</td>
  </tr>
</table>
<br>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="5"></td>
     </tr>
     <tr >
       <td width="21%">Fecha apertura:</td>
       <td width="17%"><div align="left">
           <input type="text" name="a_j" id="a_j" value="<?=$fecha_apertura_economica;?>" />
       </div></td>
       <td width="12%" align="left" ><div align="right">Fecha cierre:</div></td>
       <td width="16%"  align="left"><div align="left">
           <input type="text" name="c_j" id="c_j" value="<?=$fecha_cierre_economica;?>"/>
       </div></td>
       <td width="16%"  align="left"><input name="button4" type="button" class="guardar" id="button4" value="Grabar fechas" onClick="graba_fecha()"></td>
     </tr>
   </table>
   <br>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="7" class="titulo_tabla_azul_sin_bordes">CONFIGURACION DE REQUERIMIENTOS</td>
     </tr>
     <tr>
       <td width="14%"><div align="right"><strong>Requerimiento:</strong></div></td>
       <td width="18%"><label>
         <div align="left">
           <input name="n_campo" type="text" id="n_campo">
         </div>
       </label></td>
       <td width="12%"><div align="right"><strong>Tipo :</strong></div></td>
       <td width="17%"><label> </label>
           
         <div align="left">
               <select name="tipo_campo" id="tipo_campo">
                 <option value="0">Seleccione el tipo</option>
                 <option value="Numerico">Numerico</option>
                 <option value="Texto Corto">Texto Corto</option>
                 <option value="Texto Largo">Texto Largo</option>
               </select>
             </div></td>
       <td width="11%"><strong>Orden aparici&oacute;n:</strong></td>
    <td width="6%"><label>
         <div align="left">
           <input name="orden_aparicion" type="text" id="orden_aparicion" size="3">
         </div>
    </label></td>
       <td width="22%"><label> </label>
           <div align="center">
             <input name="button" type="button" class="guardar" id="button" value="Agregar requerimiento" onClick="crea_campo()">
         </div></td>
     </tr>
   </table>
   <br>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr>
      <td colspan="5"><div align="center" class="titulo_tabla_azul_sin_bordes">REQUERIMIENTOS  CREADOS</div></td>
    </tr>
    <tr class="tabla_sin_borde_fondo_gris">
      <td width="18%"><div align="center"><strong>Campo activo de subasta</strong></div></td>
      <td width="39%"><div align="center"><strong>Nombre del requerimiento</strong></div></td>
      <td width="20%"><div align="center"><strong>Tipo de requerimiento</strong></div></td>
      <td width="15%"><div align="center"><strong>Orden de aparici&oacute;n</strong></div></td>
      <td width="8%"><div align="center"><strong>Acciones</strong></div></td>
    </tr>
  <?
  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion order by orden_aparacion ");
	$busca_campo_subasta = traer_fila_row(query_db("select evaluador3_valor from $t93 where in_id = $id_invitacion and evaluador3_termino=4"));
	while($l_campo = traer_fila_row($busca_campos)){ 
	
			if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
	 	
      <td><div align="center">
      <? if($l_campo[0]==$busca_campo_subasta[0]) echo'<img src="../imagenes/botones/chulo.jpg" alt="Campo Activo para la subasta" width="23" height="20"></div>'; else echo "&nbsp;"; ?></td>
      <td><div align="center">
        <input name="n_e_campo_<?=$l_campo[0];?>" type="text" id="n_e_campo_<?=$l_campo[0];?>" value="<?=$l_campo[2];?>" size="50">  
      </div></td>
      <td><div align="center">
        <select name="t_e_campo_<?=$l_campo[0];?>" id="tipo_campo2">
          <option value="0">Seleccione el tipo</option>
          <option value="Numerico" <? if($l_campo[3]=="Numerico") echo "selected";?> >Numerico</option>
          <option value="Texto Corto" <? if($l_campo[3]=="Texto Corto") echo "selected";?>>Texto Corto</option>
          <option value="Texto Largo" <? if($l_campo[3]=="Texto Largo") echo "selected";?>>Texto Largo</option>
        </select>
      </div></td>
      <td><div align="center">
        <input name="o_e_campo_<?=$l_campo[0];?>" type="text" id="o_e_campo_<?=$l_campo[0];?>" size="3" value="<?=$l_campo[4];?>">
      </div></td>
      <td><div align="center">
      
      <img src="../imagenes/botones/editar_c.png" alt="Modificar Campo" onClick="edita_requerimiento(<?=$l_campo[0];?>,document.formulario.n_e_campo_<?=$l_campo[0];?>,document.formulario.t_e_campo_<?=$l_campo[0];?>,document.formulario.o_e_campo_<?=$l_campo[0];?>)">  &nbsp;
      
      <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Campo" onClick="elimina_requerimiento(<?=$l_campo[0];?>)" > &nbsp;
      <? if($l_campo[3]=="Numerico"){ ?>
      <a href="javascript:activar_subasta(<?=$l_campo[0];?>)"><img src="../imagenes/botones/2.gif" alt="Este comando activara el campo sobre el cual se regir&aacute; la subasta" width="16" height="16"></a>
      <? } ?>
      </div></td>
    </tr>
  <? $num_fila++; } ?>
  </table>
   <br>
   <br>
   <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td><div align="right">
         <input type="hidden" name="f" id="f" value="0">
         <input type="hidden" name="presupuesto" id="presupuesto"  value="0">
         <input name="button3" type="button" class="guardar" id="button3" value="Agregar Articulo" onClick="crea_articulo()">
       </div></td>
     </tr>
   </table>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="5" class="titulo_tabla_azul_sin_bordes">CREAR LISTA DE  BIENES O SERVICOS REQUERIDOS</td>
     </tr>
     <tr>
       <td width="42%" class="tabla_sin_borde_fondo_gris"><div align="center">Descripci&oacute;n / C&oacute;digo</div></td>
       <td width="7%" class="tabla_sin_borde_fondo_gris"><div align="center">Unidad de medida</div></td>
       <td width="8%" class="tabla_sin_borde_fondo_gris"><div align="center">Cantidad</div></td>
       <td width="37%" class="tabla_sin_borde_fondo_gris"><div align="center">Detalle</div></td>
       <td width="6%" class="tabla_sin_borde_fondo_gris"><div align="center">Moneda</div></td>
     </tr>
     <tr>
       <td><div align="center">
         <input name="a" type="text" id="a" size="60">
       </div></td>
       <td><div align="center">
         <input name="c" type="text" id="c" size="5">
       </div></td>
       <td><div align="center">
         <input name="d" type="text" id="d" size="5">
       </div></td>
       <td><div align="center">
         <textarea name="b" id="b" cols="50" rows="2"></textarea>
       </div></td>
       <td><div align="center">
         <select name="e" id="e">
           <?=listas_afuera($tp7, 1,$sql_e[13],'nombre', 1);?>
         </select>
       </div></td>
     </tr>
   </table>
   <br>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="6"><div align="center" class="titulo_tabla_azul_sin_bordes">LISTA DE BIENES O SERVICIOS CREADOS</div></td>
     </tr>
     <tr class="tabla_sin_borde_fondo_gris">
       <td width="29%"><div align="center">Descripci&oacute;n / C&oacute;digo</div></td>
       <td width="47%"><div align="center"><strong>Detalle</strong></div></td>
       <td width="5%"><div align="center"><strong>Medida</strong></div></td>
       <td width="6%"><div align="center"><strong>Cantidad</strong></div></td>
       <td width="6%"><div align="center"><strong>Moneda</strong></div></td>
       <td width="7%"><div align="center"><strong>Acciones</strong></div></td>
     </tr>
     <?
	 $TOTA = 0;
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion");
	while($l_campo = traer_fila_row($busca_campos)){ 
	
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
       <td><input name="a2_<?=$l_campo[0];?>" type="text" id="a2" size="50"  value="<?=$l_campo[2];?>"></td>
       <td align="left"><textarea name="b2_<?=$l_campo[0];?>" id="b2" cols="50" rows="2"><?=$l_campo[3];?></textarea></td>
       <td><input name="c2_<?=$l_campo[0];?>" type="text" id="c2" size="5" value="<?=$l_campo[4];?>"></td>
       <td><input name="d2_<?=$l_campo[0];?>" type="text" id="d2" size="5" value="<?=$l_campo[5];?>"></td>
       <td><select name="e2_<?=$l_campo[0];?>" id="e2"><?=listas_selecc_diferente_id($tp7, 1,$l_campo[6],'nombre', 1);?></select>
      </td>
       <td><div align="center">
       <img src="../imagenes/botones/editar_c.png" title="Modificar Campo" onClick="edita_articulos(<?=$l_campo[0];?>,document.formulario.a2_<?=$l_campo[0];?>,document.formulario.b2_<?=$l_campo[0];?>,document.formulario.c2_<?=$l_campo[0];?>,document.formulario.d2_<?=$l_campo[0];?>,document.formulario.e2_<?=$l_campo[0];?> )">
        &nbsp; <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Campo" onClick="elimina_articulo(<?=$l_campo[0];?>)" ></div></td>
     </tr>
     <? $TOTA++; $num_fila++;} ?>
   </table>
   <br>
   <table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="3"><p><strong><img src="../imagenes/botones/Advertencia.gif" alt="Control" width="10" height="10"> CONTROL: </strong>Si desea subir los articulos masivamente descargue la <a href="../attfiles/plantilla/plantilla_cargue.xls">plantilla aqu&iacute;</a>, recuerde:</p>
         <ul>
           <li>No incluir columnas adicionales.</li>
           <li>no dejar filas vacias.</li>
           <li>el formato debe ser excel 97-2000, no se podra cargar formato 2007</li>
       </ul></td>
     </tr>
     <tr>
       <td><div align="right"><strong>Busque el documento que anexara:</strong></div></td>
       <td>
         <div align="center">
           <input type="file" name="archivo_lista" id="archivo_lista">
         </div>       </td>
       <td><div align="center">
         <input name="button2" type="button" class="guardar" id="button2" value="Subir Archivo Excel" onClick="sube_archivo()">
       </div></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
   </table>
   <br>
   <input type="hidden" name="accion">
   <input type="hidden" name="valor_campo">
   <input type="hidden" name="campo_id">
   
<input type="hidden" name="id_invitacion" value="<?=$id_vari;?>">
</form>
<iframe name="grp" width="400" height="400" frameborder="0"></iframe>
</body>
</html>
