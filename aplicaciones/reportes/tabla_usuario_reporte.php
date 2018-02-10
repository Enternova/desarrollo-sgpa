<?
include("../../librerias/lib/@session.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="X-UA-Compatible" content="IE=9">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
  <?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   //echo $u_agent;

  $nombre_ie_css = "chips-ms12";

  
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent))
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
    ?>
         <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
  
?>
  <link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/materialize.css?version=<?=$hora?>">
  <link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/hocolTables.min.css?version=<?=$hora?>">
  <style>
   body, input, label, table, tr, td, th {
          font-family: 'Roboto' !important;
          font-weight: 900;
    }
    .label_for{
          font-family: 'Roboto' !important;
          font-weight: 700 !important;
          color: #229BFF;;
    }
    th, input, label{
          font-size: 14pt !important;
          font-family: 'Roboto' !important;
          font-weight: 900;
    }
     th, input, label{
      font-size: 14pt !important;
    }
     td, th{
      border-right: 1px solid #ccc !important;
      border-left: 1px solid #ccc !important;
    }
    strong{
      font-weight: 900 !important;
    }
  </style>
  <script>
    function abrir_ventana(pagina) {

 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
 window.open(pagina,"",opciones);
 }

  </script>
</head>
<body>
  <div id="table-proveedor" class="section">
    <div class="row">
      <div class="col s12 m12 l12">
          <i class="material-icons" style="color: #229BFF;">&#xE8FD;</i><label class="label_for">&nbsp;&nbsp;&nbsp;&nbsp;Para exportar la informaci&oacute;n de la tabla a un archivo de de excel pulse sobre el bot&oacute;n <strong>Exportar a Excel</strong>.</label>
      </div>
    </div>
      <div class="row">
        <div class="col s12 m3 l3">
          <a onclick="abrir_ventana('../reportes/usuarios_lista_general.php?usuario_permiso='+document.getElementById('usuario').value+'&estado='+document.getElementById('estado').value)" class="waves-effect waves-light btn" style="background-color: #229BFF;"><i class="material-icons left">&#xE2C0;</i>Exportar a Excel</a>
        </div>
      </div>
      <div class="row">
        <div class="col s12 m12 l12">
          <table id="data-table-proveedor" class="responsive-table striped centered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>
                        <div class="input-field">
                          <select id="estado" onchange="busca_usuario(this.value,'estado')">
                            <option value="0">Todos</option>
                            <option value="1" selected>Activos</option>
                            <option value="2">Inactivos</option>
                          </select>
                          <label for="rol" class="estado">Estado</label>
                          
                        </div>
                      </th>
                      <th>
                        Rol
                      </th>
                      <th>
                        <div class="input-field">
                          <i class="material-icons prefix">&#xE7FD;</i>
                          <input autocomplete="off" id="usuario" onkeyup="busca_usuario(this.value,'usuario')" name="usuario" type="text" class="validate" >
                          <label for="usuario" class="label_for">Usuario</label>
                        </div>
                      </th>
                      <th>
                        &Aacute;rea
                      </th>
                      <th>
                        Jefatura
                      </th>
                      <th>
                        Gerente de &Aacute;rea
                      </th>
                      <th>
                        Vicepresidente
                      </th>
                      <th>
                        Director
                      </th>
<th>
                        Presidente
                      </th>
                  </tr>
              </thead>
              <tfoot>
                <tr>
                  <th colspan="8">
                    <div class="input-field col s6 m6 l6 left" id="load-registers">
                    </div>
                    <div class="input-field col s4 m4 l4 right" id="pagination">
                      <ul class="pagination" id="list-pagination">
                        
                      </ul>
                    </div>
                  </th>
                </tr>
              </tfoot>
              <tbody id="cargatodo">
              </tbody>
          </table>
        </div>
      </div>
    </div>
  <script type="text/javascript" src="../../librerias/jquery/jquery2.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/materialize.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/pickdate_custom.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/hocolTables.min.js?version=<?=$hora?>"></script>
  <script>
    $(document).ready(function(){
      //_.addEventToTable('data-table-proveedor');
      $('select').material_select();
      busca_usuario(1,'estado');
    });
    function busca_usuario(key,familia){
      $.post('busca_usuario_reporte.php', {key: key,familia:familia, usuario:$("#usuario").val(), rol:$("#rol").val(), estado:$("#estado").val()}, function(data) {
		  console.log(data)
        var mensaje=JSON.parse(data)
        mensaje=mensaje.replace(/^\s+\s+$/g, "")
        mensaje=mensaje.replace(/^\n/g, "")
        mensaje=mensaje.replace(/^\r/g, "")
        mensaje=mensaje.replace(/\r/gi, "")
        mensaje=mensaje.replace(/\n/gi, "")
        mensaje=mensaje.replace("\n","")
        mensaje=mensaje.replace("[\n\r]", "");
        _.orderTableFromHtml(mensaje, 'data-table-proveedor')
      });
    }
  </script>
</body>
</html>