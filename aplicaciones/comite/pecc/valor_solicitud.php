<?php
include("../../../librerias/lib/@session.php");
header('Content-Type: text/html; charset=ISO-8859-1');
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
?>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
      <tr>
        <td><strong>Nuevo Valor de la Solicitud</strong></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="95%" border="0" align="center" bgcolor="#FFFFFF" >
  <tr>
    <td><table width="100%" border="0" align="center"  class="tabla_proveedores">
      <tr>
        <td align="right" colspan="7"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display = &quot;none&quot;; ' style="width:100px;" /></td>
      </tr>
      <tr>
        <td colspan="7"><strong>Lista de Proveedores para la Adjudicaci&oacute;n</strong></td>
      </tr>
      <tr>
        <td width="36%" align="center" class="fondo_3">Proveedor</td>
        <td width="12%" align="center" class="fondo_3">A&ntilde;o</td>
        <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
        <td width="14%" align="center" class="fondo_3">&Aacute;rea</td>
        <td width="11%" align="center" class="fondo_3">Valor USD$</td>
        <td width="13%" align="center" class="fondo_3">Valor COP$</td>
        <td width="6%" align="center" class="fondo_3">Acciones</td>
      </tr>
      <?php
    $sele_presupuesto = query_db("select * from $vpeec18 where t2_item_pecc_id ='" . $id_item_pecc . "'");
    $valor_total_usd = 0;
    $valor_total_cop = 0;
    $total_equivale_usd = 0;
    while ($sel_presu = traer_fila_db($sele_presupuesto)) {
        $valor_total_usd = $valor_total_usd + $sel_presu[6];
        $valor_total_cop = $valor_total_cop + $sel_presu[7];

        
        ?>
      <tr class="filas_resultados">
        <td align="center"><?= $sel_presu[1] ?></td>
        <td align="center"><?= $sel_presu[4] ?></td>
        <td align="center"><?= $sel_presu[15] ?></td>
        <td align="center"><?= $sel_presu[5] ?></td>
        <td align="center"><input type="text" onkeypress="return isNumberKey(event)" name="nue_valor_sol_<?= $sel_presu[11]?>" id="nue_valor_sol_<?= $sel_presu[11]?>" value="<?= number_format($sel_presu[6], 0) ?>" /></td>
        <td align="center"><input type="text" onkeypress="return isNumberKey(event)" name="nue_valor_sol_<?= $sel_presu[11]?>_cop" id="nue_valor_sol_<?= $sel_presu[11]?>_cop" value="<?= number_format($sel_presu[7], 0) ?>" /></td>
        <td align="center"><input name="sda3" type="button" value="Grabar Nuevo Valor" class="boton_grabar" 
                       onclick="graba_nuevo_valor(<?= $id_item_pecc ?>, 
                                   document.getElementById('nue_valor_sol_<?= $sel_presu[11]?>_cop').value,
                                   document.getElementById('nue_valor_sol_<?= $sel_presu[11]?>').value,
                                    <?= $sel_presu[11]?>)" /></td>
      </tr>
      <?php
    }
    $total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) + $valor_total_usd;
    ?>
    </table></td>
  </tr>
</table>