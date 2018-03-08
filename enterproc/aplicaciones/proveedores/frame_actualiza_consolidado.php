<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script>
	function cambia_fecha_srev(i)
		{
//
			if(i>=5)
				{
				//alert(i)
				window.parent.ajax_carga_reloj_auditor("../aplicaciones/proveedores/actualiza_consolidado.php?id_invitacion=<?=$id_invitacion;?>&id_lista=<?=$id_lista;?>&paginador=<?=$paginador;?>&numero_pagi=<?=$numero_pagi;?>","acualiza_consolidado_es");
					i=0;
				}
			i++;
			y=i	
			setTimeout("cambia_fecha_srev(y)",1000);		
		}
		
cambia_fecha_srev(1)
	
</script>


</head>

<body>
</body>
</html>
