<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
if($_GET["usuario_permiso"] <> ""){
	
	$explode = explode("----,",$_GET["usuario_permiso"]);
		$id_usuario = $explode[1];
		}



	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>




</head>

<body>
<iframe src="../aplicaciones/reportes/auditor_lista_general.php?busca_solicitud=<?=$_GET["busca_solicitud"]?>&fecha=<?=$_GET["fecha"]?>&usuario_permiso=<?=$id_usuario?>&modulo=<?=$_GET["modulo"]?>&paginas=<?=$_GET["paginas"]?>" width="100%" height="950px" frameborder="0" /> </iframe>
</body>
</html>
