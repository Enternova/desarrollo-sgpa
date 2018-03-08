<?  include("../lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

if($depar==1){
?>
<link href="../../../css/general.css" rel="stylesheet" type="text/css" />


<select name="depart" onChange="ajax_carga('../../librerias/php/llena_ciudades.php?depar=2&var=' + this.value ,'grupo_ciudades')">
              <option value="0">Departamento</option>
			   <?
		$sele_maes = query_db("select * from $t3 where ps_id   = $var  order by dp_nombre "); 
		while($lm=traer_fila_row($sele_maes)) {	?>
       <option value="<?=$lm[0];?>"><?=$lm[2];?></option>
                <? } ?>
			  </select>
<? } 

if($depar==2){
?>

<select name="ciuadad">
              <option value="0">Ciudad</option>
			   <?
		$sele_maes = query_db("select * from $t4 where dp_id   = $var  order by cd_nombre "); 
		while($lm=traer_fila_row($sele_maes)) {	?>
       <option value="<?=$lm[0];?>"><?=$lm[2];?></option>
                <? } ?>
			  </select>
<? }




?>
