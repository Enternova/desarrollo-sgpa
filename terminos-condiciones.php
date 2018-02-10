<? session_start();
   ob_start();
$verifica_https = $_SERVER['HTTPS'];
if($verifica_https=="off"){
$pagina = "https://www.abastecimiento.hocol.com.co/sgpa/terminos-condiciones.php";
header("Location: $pagina"); 
}
   include("librerias/lib/@include.php");   
       $numero_get = valida_get();
    $numer = numero_ingresos_get();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel='shortcut icon' href='<?=URL_COMPETA;?>/favicon.ico' />
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>


<link href="css/principal.css" rel="stylesheet" type="text/css" />
<link href="css/reloj.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div  class="fondo_cabecera">
<?=banner_afuera();?>
</div>
<form name="ingreso" method="post" action="index.php">
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td><div align="right"><input type="submit" name="button" class="buscar" id="button" value="Volver a la p&aacute;gina de inicio" /></div></td>
    </tr>
  </table>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr> 
    <td class="titulos_procesos">TERMINOS Y CONDICIONES DE USO DE LA PAGINA WEB WWW.COMPRASSLB.COM VERSION 5.0</td>
  </tr>
  <tr> 
    <td> <p align="justify"><br>
        ATENCI&Oacute;N!! </p>
      <p align="justify">CUALQUIER PERSONA QUE NO ACEPTE ESTOS T&Eacute;RMINOS Y CONDICIONES GENERALES, 
        LOS CUALES TIENEN UN CAR&Aacute;CTER OBLIGATORIO Y VINCULANTE, DEBER&Aacute; 
        COMUNICARSE CON info@subastasycomercio.com Y ABSTENERSE DE REALIZAR 
        POSTURAS Y OFERTAS. </p>
      <p align="justify">Este contrato describe los t&eacute;rminos y condiciones generales aplicables 
        al uso de los servicios ofrecidos (&quot;los Servicios&quot;) dentro del 
        sitio www.comprasslb.com (&quot;EL SITIO WEB&quot;). Cualquier persona que 
        desee acceder y/o usar el sitio o los servicios podr&aacute; hacerlo sujet&aacute;ndose 
        a estos t&eacute;rminos y Condiciones Generales, adem&aacute;s del Pliego 
        de Condiciones respectivo del proceso en que este participando. </p>
      <p align="justify">Mediante los presentes t&eacute;rminos y Condiciones se pretende establecer 
        el marco en el cual se desarrollar&aacute;n las relaciones comerciales 
        y contractuales entre los Usuarios del sistema EL SITIO WEB, SUBASTAS &amp; COMERCIO SAS. (&quot;LA EMPRESA&quot;) en su condici&oacute;n de interesados 
        en participar, a los cuales le ser&aacute;n aplicables los principios 
        generales que conforme a la ley colombiana informan a todos los contratos 
        y en especial, el principio de la buena fe para su ejecuci&oacute;n y 
        cumplimiento. </p>
      <p align="justify">01- CAPACIDAD: </p>
      <p align="justify">Los servicios ofrecidos est&aacute;n disponibles solo para personas que 
        tengan capacidad legal para vender o contratar. Por lo anterior, no podr&aacute;n 
        utilizar los servicios, entre otros, menores de edad, personas que no 
        tengan esa capacidad o las personas que hayan sido suspendidas o dadas 
        de baja del sistema EL SITIO WEB, temporal o definitivamente, por haber incumplido 
        los T&eacute;rminos y Condiciones Generales o por haber incurrido a criterio 
        de  LA EMPRESA en conductas o actos dolosos 
        o fraudulentos mediante el uso del o de los Servicios. </p>
      <p align="justify">02 - INSCRIPCION Y REGISTRO: </p>
      <p align="justify">2.1 Podr&aacute;n inscribirse personas naturales o jur&iacute;dicas.      </p>
      <p align="justify">2.2 Para utilizar los servicios de EL SITIO WEB y por ende adquirir 
        la calidad de Usuario, es indispensable diligenciar el formulario de Registro 
        en todos sus campos. El futuro Usuario deber&aacute; completarlo con su 
        informaci&oacute;n de manera exacta, precisa y verdadera asumiendo el 
        compromiso de actualizar los Datos Personales conforme resulte necesario. 
        Los Usuarios garantizan y responden, en cualquier caso, de la veracidad, 
        exactitud, vigencia y autenticidad de los Datos Personales ingresados.      </p>
      <p align="justify">2.3 Una persona autorizada por LA EMPRESA podr&aacute; 
        contactar al Usuario telef&oacute;nicamente o por cualquier otro medio 
        para verificar los datos ingresados. LA EMPRESA se reserva 
        el derecho de solicitar alg&uacute;n dato adicional a efectos de corroborar 
        los Datos Personales, as&iacute; como de inhabilitar a aquellos Usuarios 
        que en un periodo razonable haya intentado contactar sin lograrlo o cuyos 
        datos no hayan podido ser confirmados. En todo caso, no ser&aacute; responsable 
        por las consecuencias que puede generar la falta de actualizaci&oacute;n 
        oportuna de la Informaci&oacute;n, ya que la veracidad y exactitud de 
        la Informaci&oacute;n es responsabilidad de los Usuarios. LA EMPRESA se reserva el derecho a rechazar solicitudes de registro o a cancelar 
        o suspender en cualquier tiempo la calidad de un Usuario registrado para 
        realizar transacciones por cualquiera de los motivos, o por el ocultamiento 
        de informaci&oacute;n o el suministro de informaci&oacute;n falsa o deliberadamente 
        inexacta. </p>
      <p align="justify">2.4 Recibida la Informaci&oacute;n, se proceder&aacute; a evaluar la 
        solicitud de inscripci&oacute;n y activar el usuario una vez sus datos 
        ha sido confirmados con el fin de acceder a las diferentes eventos (Subastas, 
        Compras o Licitaciones en l&iacute;nea) en que este autorizado. </p>
      <p align="justify">2.5 El Usuario ser&aacute; responsable por todas las operaciones efectuadas 
        a su nombre, pues el acceso a EL SITIO WEB est&aacute; restringido al ingreso y 
        uso de su Clave de Seguridad, de conocimiento exclusivo del Usuario. El 
        Usuario se compromete a notificar a LA EMPRESA en forma 
        inmediata y por medio id&oacute;neo y fehaciente, cualquier uso no autorizado 
        de su Cuenta, as&iacute; como el ingreso por terceros no autorizados a 
        la misma. </p>
      <p align="justify">03- MODIFICACIONES A ESTE ACUERDO: </p>
      <p align="justify">LA EMPRESA podr&aacute; modificar en cualquier momento 
        estos t&eacute;rminos y condiciones y notificar&aacute; los cambios al 
        Usuario publicando una versi&oacute;n actualizada de dichos t&eacute;rminos 
        y condiciones en el sitio con expresi&oacute;n de la fecha de la &uacute;ltima 
        modificaci&oacute;n. Dentro de los 3 (tres) d&iacute;as siguientes a la 
        publicaci&oacute;n de las modificaciones introducidas, el Usuario deber&aacute; 
        comunicar por e-mail a info@subastasycomercio.com si acepta las mismas; 
        en ese caso quedar&aacute; disuelto el v&iacute;nculo contractual y ser&aacute; 
        inhabilitado como usuario. Vencido este plazo, se considerar&aacute; que 
        el Usuario acepta los nuevos t&eacute;rminos y el contrato continuar&aacute; 
        vinculando a ambas partes. </p>
      <p align="justify">04- USO DE LA INFORMACION: </p>
      <p align="justify">4.1 La informaci&oacute;n suministrada por los Usuarios con ocasi&oacute;n 
        de su registro en EL SITIO WEB o con ocasi&oacute;n de la compra 
        y venta de bienes y/o servicios, ser&aacute; de uso exclusivo para LA EMPRESA en funci&oacute;n de la realizaci&oacute;n de los fines 
        propios de su actividad. Por lo tanto, los Usuarios otorgan los m&aacute;s 
        amplios derechos para utilizar esa informaci&oacute;n, particularmente 
        para que basados en puesta puedan cerrarse y llevar a feliz t&eacute;rmino 
        las transacciones entre LA EMPRESA y los Usuarios. </p>
      <p align="justify">4.2 LA EMPRESA no vender&aacute;, suministrar&aacute; o 
        pondr&aacute; a disposici&oacute;n de terceros, con fines de lucro o con 
        cualquier otro prop&oacute;sito, la informaci&oacute;n de los Usuarios 
        de EL SITIO WEB en forma distinta a aquella que aqu&iacute; se indica.      </p>
      <p align="justify">4.3 LA EMPRESA mantiene protegido su sitio, y por ende 
        la informaci&oacute;n, ofertas y documentos que han sido suministrados 
        por los Usuarios, mediante la implementaci&oacute;n de sistemas de seguridad 
        y control avanzados. </p>
      <p align="justify">05- DINAMICA DE LAS TRANSACCIONES: </p>
      <p align="justify">5.1 los usuarios deben ingresar al EL SITIO WEB y efectuar un registro, incluyendo 
        una contrase&ntilde;a la cual deber&aacute; ser manejada seg&uacute;n 
        lo aqu&iacute; estipulado. </p>
      <p align="justify">5.2 Cada vez el usuario lo desee podr&aacute; acceder al sistema y participar 
        de los eventos a los cuales haya sido previamente autorizado, encontrando 
        en cada una sus condiciones de compra o venta. El usuario recibir&aacute; 
        v&iacute;a correo electr&oacute;nico la invitaci&oacute;n correspondiente 
        para participar en cada evento. </p>
      <p align="justify">5.3 Cualquier usuario puede comunicarse con el mail: info@subastasycomercio.com 
        o contactar los tel&eacute;fonos en Bogot&aacute;: +571 2550916 donde 
        se le dar&aacute; la asesoria del procedimiento en caso de ser necesario.      </p>
      <p align="justify">&nbsp;</p>
      <p align="justify">10- GARANTIA Y LIMITE DE RESPONSABILIDAD; </p>
      <p align="justify">10.1 Los servicios que ofrece LA EMPRESA tienen el alcance 
        que se especifica en estos t&eacute;rminos y Condiciones. Por ello, salvo 
        lo expresamente aqui indicado, no ofrece garant&iacute;a, explicita o 
        impl&iacute;cita de ning&uacute;n tipo, no ser&aacute; responsable por 
        los da&ntilde;os sufridos por los Usuarios con ocasi&oacute;n de sus transacciones 
        y por ende no responder&aacute; por da&ntilde;o emergente, lucro cesante 
        o cualquier otro perjuicio por hechos sobre los cu&aacute;les no tiene 
        control alguno. </p>
      <p align="justify">10.2 Dentro de los limites legales, en el evento que LA EMPRESA fuere declarado responsable por alg&uacute;n perjuicio ocurrido con 
        ocasi&oacute;n de la prestaci&oacute;n de servicios que ofrece en su plataforma 
        de el EL SITIO WEB especificado en el Titulo de los presentes T&eacute;rminos 
        y Condiciones, su responsabilidad estar&aacute; limitada al valor recibido 
        como contraprestaci&oacute;n de los servicios prestados a los Usuarios 
        durante los doce meses anteriores a la ocurrencia del hecho que dio origen 
        al da&ntilde;o causado. </p>
      <p align="justify">10.3 LA EMPRESA  no responde por los da&ntilde;os o vicios 
        ocultos de los bienes y/o servicios que son objeto de las negociaciones. 
        Se consideran en el estado y sitio en que se encuentran y en la forma 
        como han sido observados por los interesados. No se ofrece garant&iacute;a 
        alguna sobre la calidad, buen funcionamiento, idoneidad, calidad, aptitud, 
        capacidad, ni competencia de los procesos. </p>
      <p align="justify">11- FALLAS EN EL SISTEMA O CASOS QUE PUDIEREN PRESENTARSE: </p>
      <p align="justify">LA EMPRESA  no se responsabiliza por cualquier da&ntilde;o, 
        perjuicio o perdida al Usuario causada por fallas en el sistema, en el 
        servidor o en Internet, tampoco ser&aacute; responsable por cualquier 
        virus que pudiera infectar el equipo del Usuario como consecuencia del 
        acceso, uso o examen de su EL SITIO WEB o a raz&oacute;n de cualquier 
        transferencia de datos, archivos, im&aacute;genes, textos, o audio contenidos 
        en el mismo. Los Usuarios NO podr&aacute;n imputarle responsabilidad alguna 
        ni exigir pago por lucro cesante, en virtud de perjuicios resultantes 
        de dificultades t&eacute;cnicas o fallas humanas, en los sistemas o en 
        Internet. </p>
      <p align="justify">En el caso que un usuario cometa un error grave en una subasta a consideraci&oacute;n 
        de LA EMPRESA, y este error repercuta en otros usuarios 
        inscritos que est&eacute;n participando en la misma, ser&aacute; sancionado 
        haci&eacute;ndosele efectiva la garant&iacute;a de seriedad presentada 
        para dicho bien y la subasta ser&aacute; puesta al aire nuevamente comenzando 
        en el valor de la mejor oferta al momento del da&ntilde;o. En este caso 
        solo podr&aacute;n participar quienes previamente ya estaban inscritos 
        y autorizados, excepto el usuario que cometi&oacute; la falla. </p>
      <p align="justify">LA EMPRESA no garantiza el acceso y uso continuado o ininterrumpido 
        de su sitio. El sistema puede eventualmente no estar disponible debido 
        a dificultades t&eacute;cnicas o fallas de Internet, o por cualquier otra 
        circunstancia ajena; en tales casos se procurar&aacute; restablecerlo 
        con la mayor celeridad posible sin que por ello pueda imput&aacute;rsele 
        alg&uacute;n tipo de responsabilidad. LA EMPRESA no ser&aacute; 
        responsable por ning&uacute;n error u omisi&oacute;n contenidos en su 
        sitio Web. </p>
      <p align="justify">12- LEY APLICABLE Y JURISDICCION: </p>
      <p align="justify">Los presentes t&eacute;rminos y Condiciones y el acuerdo que los mismos 
        implican entre LA EMPRESA y los Usuarios, se regula en todos 
        sus aspectos por la ley colombiana, en especial por la ley 527 de 1999. 
        Cualquier conflicto que surja con ocasi&oacute;n de la ejecuci&oacute;n 
        del presente acuerdo, ser&aacute; resuelta mediante proceso arbitral, 
        de acuerdo a las siguientes reglas: (i) El tribunal estar&aacute; integrado 
        por un (1) &aacute;rbitro si la cuant&iacute;a total de las pretensiones 
        no supera los mil salarios m&iacute;nimos, pues en caso contrario, de 
        superarse tal suma, el tribunal estar&aacute; integrado por tres (3) &aacute;rbitros. 
        El o los &aacute;rbitros ser&aacute;n designados de com&uacute;n acuerdo 
        entre las partes. (ii) La organizaci&oacute;n interna del tribunal se 
        regir&aacute; por la reglas del Centro de Arbitraje y Conciliaci&oacute;n 
        Mercantil de la C&aacute;mara de Comercio de Bogot&aacute;, incluyendo 
        las reglas relativas a los honorarios de los &aacute;rbitros; (iii) El 
        tribunal decidir&aacute; en derecho; y (iv) El tribunal tendr&aacute; 
        su domicilio en el Centro de Arbitraje y Conciliaci&oacute;n Mercantil 
        de la C&aacute;mara de Comercio de Bogot&aacute;, en esta ciudad. </p>
      <p align="justify">13- DOMICILIO </p>
      <p align="justify">SUBASTAS &amp; COMERCIO SAS. tiene como domicilio: 7 No. 72 - 64, Oficina 3. PBX +57(1)2550916 - , 316 4724296 Bogota-Colombia e-Mail info@subastasycomercio.com <br>
      </p></td>
  </tr>
</table>               


</form>

<p>&nbsp;</p>
<div id="cubo_pie">Subastas &amp; Comercio  2012 - Todos los derechos reservados info@subastasycomercio.com</div>


</body>
</html>
