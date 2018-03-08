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
    td, th{
      border-right: 1px solid #ccc !important;
      border-left: 1px solid #ccc !important;
    }
    tr > td{
      cursor: pointer;
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
          <i class="material-icons" style="color: #229BFF;">&#xE8FD;</i><label class="label_for">&nbsp;&nbsp;&nbsp;&nbsp;Para ver el detalle de un registro puede dar click sobre cualquiera de las columnas para ampliar la informaci&oacute;n, para exportar la informaci&oacute;n de la tabla a un archivo de de excel pulse sobre el bot&oacute;n <strong>Exportar a Excel</strong>.</label>
      </div>
    </div>
      <div class="row">
        <div class="col s12 m3 l3">
          <a onclick="abrir_ventana('../reportes/roles_general.php?rol='+document.getElementById('rol').value)" class="waves-effect waves-light btn" style="background-color: #229BFF;"><i class="material-icons left">&#xE2C0;</i>Exportar a Excel</a>
        </div>
      </div>
      <div class="row">
        <div class="col s12 m12 l12">
          <table id="data-table-proveedor" class="responsive-table striped centered" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>
                        <div class="input-field">
                          <i class="material-icons prefix">&#xE7FD;</i>
                          <input autocomplete="off" id="rol" onkeyup="busca_usuario(this.value,'nombre_rol')" name="rol" type="text" class="validate" >
                          <label for="rol" class="label_for">Rol</label>
                        </div>
                      </th>
                      <th>
                        Acceso Modulo de Solicitudes
                      </th>
                      <th>
                        Acceso a la Urna Virtual
                      </th>
                      <th>
                        Acceso al modulo de contratos
                      </th>
                      <th>
                        Acceso al Modulo de Comit&eacute;
                      </th>
                      <th>
                        Acceso a al modulo de Tarifas
                      </th>
                      <th>
                        Acceso Modulo de Reportes
                      </th>
                  </tr>
              </thead>
              <tfoot>
                <tr>
                  <th colspan="7">
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
    <div id="carga-tabla" class="modal" style="width: 100% !important;">
      <div class="modal-content" id="modal-content">
        <h4>Modal Header</h4>
        <p>A bunch of text</p>
      </div>
      <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
      </div>
    </div>
  <script type="text/javascript" src="../../librerias/jquery/jquery2.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/materialize.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/pickdate_custom.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/hocolTablesActions.min.js?version=<?=$hora?>"></script>
  <script>
    $(document).ready(function(){
      $('.modal').modal({
          dismissible: true, // Modal can be dismissed by clicking outside of the modal
          opacity: .5, // Opacity of modal background
          inDuration: 300, // Transition in duration
          outDuration: 200, // Transition out duration
          startingTop: '4%', // Starting top style attribute
          endingTop: '10%', // Ending top style attribute
          ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
            //alert("Ready");
            console.log(modal, trigger);
          },
          complete: function() {
            //alert('Closed'); 
          } // Callback for Modal close
        }
      );
      //_.addEventToTable('data-table-proveedor');
      $('select').material_select();
      busca_usuario(1,'estado');
    });
    function busca_usuario(key,familia){
      $.post('busca_roles_reporte.php', {key: key,familia:familia, usuario:$("#usuario").val(), rol:$("#rol").val(), estado:$("#estado").val()}, function(data) {
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
    function mostrar_modal(id,url){
      $('#'+id).children('#modal-content').empty();
      $('#'+id).children('#modal-content').load(url);
      $('#'+id).modal('open')
    }
  </script>
</body>
</html>