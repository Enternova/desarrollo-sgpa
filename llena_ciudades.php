<?   include("librerias/lib/@include.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

if($depar==1){
?>


<select name="depart" onChange="ajax_carga_02('llena_ciudades.php?depar=2&var=' + this.value ,'grupo_ciudades')">
              <option value="0">Departamento</option>
			   <?
		$sele_maes = query_db("select * from dp_departamento where ps_id   = $var  order by dp_nombre "); 
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
		$sele_maes = query_db("select * from cd_ciudad where dp_id   = $var  order by cd_nombre "); 
		while($lm=traer_fila_row($sele_maes)) {	?>
       <option value="<?=$lm[0];?>"><?=$lm[2];?></option>
                <? } ?>
			  </select>
<? }




?>
