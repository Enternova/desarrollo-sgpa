<? include("../../../librerias/lib/@session.php");
   
?>
<html>
    <head>
        <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
        <?php
        /* Consulta para traer la informacion de los comentarios de los comites relacionados eliminados */
        $sele_item = query_db("SELECT id_coment, id_comite, CAST(comentario AS TEXT) AS comentario, fecha_creacion from $c5 where id_item = $id_item_pecc");
        ?>
        <style>
            body {
                color:#FFFFF;
                background-color:#FFFFF;
          
            }
          
        </style>
    </head>
    <body>
        <table width="50%" align='center' style="background-color:#FFFFF;" border="0" cellpadding="2" cellspacing="2" class="tabla_principal">
            <tr>
                <td align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display = "none"' style="width:100px;" /></td>
            </tr>
            <tr>
                <td colspan="6" align="center"  class="fondo_3">Lista de comentarios de la solicitud eliminada</td>
            </tr>
            <tr>
                <th class="fondo_3">Comentario</th>
                <th class="fondo_3">Comit&eacute;</th>
                <th class="fondo_3">Fecha y hora</th>
            </tr>
            <?php while ($rowSI = traer_fila_db($sele_item)) {
                $query="SELECT num1, num2, num3 FROM $c1 where id_comite=$rowSI[1]";
                $comite=traer_fila_row(query_db($query));
                ?>
                <tr>
                    <td class="filas_resultados" width="60%"><?if($rowSI[2]!=""){echo $rowSI[2];}else{echo 'Sin Comentarios.';}?></td>
                    <td class="filas_resultados" width="20%"><?= numero_item_pecc($comite[0],$comite[1],$comite[2]) ?></td>
                    <td class="filas_resultados" width="20%"><?= $rowSI[3] ?></td>
                </tr>
            <?php }; ?>
        </table>
    </body>
</html>
