<?  include("../lib/@session.php");

function registro_email_enviado_nuevo_otros_deli($pro1_id, $email, $asunto_envio, $texto_envio,$enviado,$tipo,$modulo,$id_primario_otros_email){
global $fecha,$hora;

$arreglo_modulo_pv_id = explode("|",$id_primario_otros_email);
$pv_id_trae = $arreglo_modulo_pv_id[1]; //arreglo id proveedor
$sub_proceso = $arreglo_modulo_pv_id[0];//arreglo id sub proceso carteleras
$cuenta_arr = count($arreglo_modulo_pv_id);
if($cuenta_arr>=2)
	{
		$var1=$pv_id_trae;
		$var2=$sub_proceso;
		
		}
	else{
		$var1=$id_primario_otros_email;
		$var2=0;
		
		}
		

echo $inserta_data = "insert into pro34_registro_correos (us_id, fecha_envio, pro1_id, id_primario_otros_email, id_secundario_otros_email,
 email_envio, asunto_envio, texto_envio, enviado,tipo_envio,tp17_id) values (
".$_SESSION["id_us_session"].",'2014-08-13 12:12:44', $pro1_id, $var1,$var2,'$email','$asunto_envio','$texto_envio','$enviado',$tipo,2) ";

$in_mail = query_db($inserta_data);


}


			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  1841 and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){// proveedores

					$mail_guardado = '<table width="98%" border="0" cellspacing="2" cellpadding="2" style="border:solid 1px #000000">
  <tr>
    <td colspan="2"><img src="http://www.abastecimiento.hocol.com.co/sgpa/imagenes/imagen/logo_cliente_email.png" width="190" height="56" /></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Consecutivo:</strong></div></td>
    <td>S14-1041</td>
  </tr>
  <tr>
    <td width="34%" style="background-color:#999999"><div align="right"><strong>Asunto:</strong></div></td>
    <td width="66%">Modificaci&oacute;n del proceso</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>proveedor:</strong></div></td>
    <td>'.$lp[2].'</td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>URL:</strong></div></td>
    <td><a href="http://www.abastecimiento.hocol.com.co/">http://www.abastecimiento.hocol.com.co</a></td>
  </tr>
  <tr>
    <td style="background-color:#999999"><div align="right"><strong>Detalle:</strong></div></td>
    <td>El proceso fue modificado, por favor verifique el cronograma, documentos o aspectos tecnicos, economicos y listas de precios</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><ul>
      <li>Este correo es automatico, por favor no lo responda.</li>
      <li>Si su contraseña presenta inconvenientes por favor ingrese a <a href="http://www.abastecimiento.hocol.com.co//recordacion_contrasena.php">http://www.abastecimiento.hocol.com.co/sgpa/recordacion_contrasena.php </a> y digite el usuario.</li>
      <li>Comuniquese al soporte técnico en el teléfono (57 1) 255 0916 Bogotá, Colombia</li>
    </ul></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>';

			registro_email_enviado_nuevo_otros_deli(1841, $lp[4], 'Modificacion de procesos', $mail_guardado,1,1,1,0);
				}

?>