function selecciona_lista(campo_seleccio){//PARA EL INC-0205

/************ 1 **********************/
if(document.getElementById("gerente_confirma_asegu")){
    document.getElementById("gerente_confirma_asegu").onchange=function() {
        var busca=document.getElementById("gerente_confirma_asegu").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("gerente_confirma_asegu").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("gerente_confirma_asegu").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente_confirma_asegu").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente_confirma_asegu").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente_confirma_asegu").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente_confirma_asegu").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #fff; color: #000; } div > #gerente_confirma_asegu_list:leave { display: none }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#gerente_confirma_asegu").val($(this).text())
                    }, false); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#gerente_confirma_asegu").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 2 **********************/
if(document.getElementById("categoria_busca")){
    document.getElementById("categoria_busca").onchange=function() {
        var busca=document.getElementById("categoria_busca").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("categoria_busca").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("categoria_busca").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#categoria_busca").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#categoria_busca").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#categoria_busca").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_categorias.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#categoria_busca").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                    $("#categoria_busca").val($(this).text())
                    }, false); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#categoria_busca").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 3 **********************/
if(document.getElementById("proveedores_busca_adjudicacion")){
    document.getElementById("proveedores_busca_adjudicacion").onchange=function() {
        var busca=document.getElementById("proveedores_busca_adjudicacion").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("proveedores_busca_adjudicacion").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("proveedores_busca_adjudicacion").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca_adjudicacion").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca_adjudicacion").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#proveedores_busca_adjudicacion").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_en_par_servicios.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca_adjudicacion").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                    $("#proveedores_busca_adjudicacion").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#proveedores_busca_adjudicacion").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 4 **********************/
if(document.getElementById("proveedores_busca")){
    document.getElementById("proveedores_busca").onchange=function() {
        var busca=document.getElementById("proveedores_busca").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("proveedores_busca").value="";
        }
        $('#proveedores_busca_list').css('display', 'none')
    }
    document.getElementById("proveedores_busca").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca").empty();
        if($('#proveedores_busca_list').length==0){
            $("#proveedores_busca").parent().append('<div id="proveedores_busca_div" style="width: 30%; position: absolute;"><ul id="proveedores_busca_list" style="background: #fff; color: 000;"></ul></div>');
            $("#proveedores_busca_div").mouseleave(function (){
                $("#proveedores_busca_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#proveedores_busca_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#proveedores_busca").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#proveedores_busca").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('proveedores_busca_list').appendChild(li);
            }
            $('#proveedores_busca_list').css('display', 'block')
            $("#proveedores_busca_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 5 **********************/
if(document.getElementById("busca_id_responsable")){
    document.getElementById("busca_id_responsable").onchange=function() {
        var busca=document.getElementById("busca_id_responsable").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_id_responsable").value="";
        }
        $('#busca_id_responsable_list').css('display', 'none')
    }
    document.getElementById("busca_id_responsable").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_responsable").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_responsable").empty();
        if($('#busca_id_responsable_list').length==0){
            $("#busca_id_responsable").parent().append('<div id="busca_id_responsable_div" style="width: 30%; position: absolute;"><ul id="busca_id_responsable_list" style="background: #fff; color: 000;"></ul></div>');
            $("#busca_id_responsable_div").mouseleave(function (){
                $("#busca_id_responsable_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_responsable").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#busca_id_responsable_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_id_responsable").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_id_responsable").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('busca_id_responsable_list').appendChild(li);
            }
            $('#busca_id_responsable_list').css('display', 'block')
            $("#busca_id_responsable_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 6 **********************/
if(document.getElementById("busca_id_cierre")){
    document.getElementById("busca_id_cierre").onchange=function() {
        var busca=document.getElementById("busca_id_cierre").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_id_cierre").value="";
        }
        $('#busca_id_cierre_list').css('display', 'none')
    }
    document.getElementById("busca_id_cierre").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_cierre").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_cierre").empty();
        if($('#busca_id_cierre_list').length==0){
            $("#busca_id_cierre").parent().append('<div id="busca_id_cierre_div" style="width: 30%; position: absolute;"><ul id="busca_id_cierre_list" style="background: #fff; color: 000;"></ul></div>');
            $("#busca_id_cierre_div").mouseleave(function (){
                $("#busca_id_cierre_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_cierre").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#busca_id_cierre_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_id_cierre").val($(this).text())
                    }, false); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_id_cierre").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('busca_id_cierre_list').appendChild(li);
            }
            $('#busca_id_cierre_list').css('display', 'block')
            $("#busca_id_cierre_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 7 **********************/
if(document.getElementById("busca_id_comite")){
    document.getElementById("busca_id_comite").onchange=function() {
        var busca=document.getElementById("busca_id_comite").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_id_comite").value="";
        }
        $('#busca_id_comite_list').css('display', 'none')
    }
    document.getElementById("busca_id_comite").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_comite").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_comite").empty();
        if($('#busca_id_comite_list').length==0){
            $("#busca_id_comite").parent().append('<div id="busca_id_comite_div" style="width: 30%; position: absolute;"><ul id="busca_id_comite_list" style="background: #fff; color: 000;"></ul></div>');
            $("#busca_id_comite_div").mouseleave(function (){
                $("#busca_id_comite_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_comite.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_comite").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#busca_id_comite_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_id_comite").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_id_comite").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('busca_id_comite_list').appendChild(li);
            }
            $('#busca_id_comite_list').css('display', 'block')
            $("#busca_id_comite_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 8 **********************/
if(document.getElementById("busca_id_solicitud")){
    document.getElementById("busca_id_solicitud").onchange=function() {
        var busca=document.getElementById("busca_id_solicitud").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_id_solicitud").value="";
        }
        $('#busca_id_solicitud_asegu_list').css('display', 'none')
    }
    document.getElementById("busca_id_solicitud").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_solicitud").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_solicitud").empty();
        if($('#busca_id_solicitud_asegu_list').length==0){
            $("#busca_id_solicitud").parent().append('<div id="busca_id_solicitud_asegu_div" style="width: 30%; position: absolute;"><ul id="busca_id_solicitud_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#busca_id_solicitud_asegu_div").mouseleave(function (){
                $("#busca_id_solicitud_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_id_solicitud.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_solicitud").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#busca_id_solicitud_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                id_li=id_li.replace(/\#/g,'')
                id_li=id_li.replace("#",'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_id_solicitud").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_id_solicitud").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('busca_id_solicitud_asegu_list').appendChild(li);
            }
            $('#busca_id_solicitud_asegu_list').css('display', 'block')
            $("#busca_id_solicitud_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
if(document.getElementById("contratos_normales")){
    if(campo_seleccio=="infomativo"){
        /************ 9 **********************/
        document.getElementById("contratos_normales").onchange=function() {
            var busca=document.getElementById("contratos_normales").value
            var bandera=busca.search('----,');
            if(bandera==-1){
                document.getElementById("contratos_normales").value="";
            }
            $('#gerente_confirma_asegu_list').css('display', 'none')
        }
        document.getElementById("contratos_normales").onkeyup=function(evt) {
            //alert(evt.keyCode)
            var coma=$("#contratos_normales").val()
            coma=coma.replace(" ",", ");
            var cadena1=""
            $("#contratos_normales").empty();
            if($('#gerente_confirma_asegu_list').length==0){
                $("#contratos_normales").parent().append('<div id="gerente_confirma_asegu_div" style="width: 40%; background: #fff; position: absolute; box-shadow: 3px 5px 5px 9px #ccc; margin-left: -10%;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000; margin-left: 5%;"></ul></div>');
                $("#gerente_confirma_asegu_div").mouseleave(function (){
                    $("#gerente_confirma_asegu_div").css('display', 'none')
                });
            }
            $.ajax({
                url: '../librerias/php/contratos_normales_y_marco.php',
                type: 'POST',
                dataType: 'html',
                data: {q:$("#contratos_normales").val(), q2:coma},
            })
            .done(function(data) {
                var result=data.replace("\n", "")//para dejar solo la cadena
                result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
                result=result.split("<remplaza>");
                $('#gerente_confirma_asegu_list').empty();
                for (i = 0; i < result.length; i++) {
                    var id_li=result[i].replace('-','')
                    id_li=id_li.replace(/\./g,'')
                    id_li=id_li.replace(/\-/g,'')
                    id_li=id_li.replace(/\ /g,'')
                    id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                    var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                    var style = document.createElement("style");
                    style.appendChild(
                        document.createTextNode(style_text)
                    );
                    document.querySelector("head").appendChild(style);
                    var li=document.createElement('li');
                    li.id=id_li;
                    if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#contratos_normales").val($(this).text())
                    }, false); 
                    } else {
                      if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#contratos_normales").val($(this).text())
                    }, false);
                      }
                    }
                    li.onclick="alert('asd')";
                    var texto=document.createTextNode(result[i]);
                    li.appendChild(texto);
                    document.getElementById('gerente_confirma_asegu_list').appendChild(li);
                }
                $('#gerente_confirma_asegu_list').css('display', 'block')
                $("#gerente_confirma_asegu_div").css('display', 'block')
            })
            .fail(function() {
                console.log("error");
            });
        };
    }else{
        
    /************ 10 **********************/
        document.getElementById("contratos_normales").onchange=function() {
            var busca=document.getElementById("contratos_normales").value
            var bandera=busca.search('----,');
            if(bandera==-1){
                document.getElementById("contratos_normales").value="";
            }
            $('#gerente_confirma_asegu_list').css('display', 'none')
        }
        document.getElementById("contratos_normales").onkeyup=function(evt) {
            //alert(evt.keyCode)
            var coma=$("#contratos_normales").val()
            coma=coma.replace(" ",", ");
            var cadena1=""
            $("#contratos_normales").empty();
            if($('#gerente_confirma_asegu_list').length==0){
                $("#contratos_normales").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
                $("#gerente_confirma_asegu_div").mouseleave(function (){
                    $("#gerente_confirma_asegu_div").css('display', 'none')
                });
            }
            $.ajax({
                url: '../librerias/php/contratos_normales_no_marco.php',
                type: 'POST',
                dataType: 'html',
                data: {q:$("#contratos_normales").val(), q2:coma},
            })
            .done(function(data) {
                var result=data.replace("\n", "")//para dejar solo la cadena
                result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
                result=result.split("<remplaza>");
                $('#gerente_confirma_asegu_list').empty();
                for (i = 0; i < result.length; i++) {
                    var id_li=result[i].replace('-','')
                    id_li=id_li.replace(/\./g,'')
                    id_li=id_li.replace(/\-/g,'')
                    id_li=id_li.replace(/\ /g,'')
                    id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                    var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                    var style = document.createElement("style");
                    style.appendChild(
                        document.createTextNode(style_text)
                    );
                    document.querySelector("head").appendChild(style);
                    var li=document.createElement('li');
                    li.id=id_li;
                    if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#contratos_normales").val($(this).text())
                    }, false); 
                    } else {
                      if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#contratos_normales").val($(this).text())
                    }, false);
                      }
                    }
                    li.onclick="alert('asd')";
                    var texto=document.createTextNode(result[i]);
                    li.appendChild(texto);
                    document.getElementById('gerente_confirma_asegu_list').appendChild(li);
                }
                $('#gerente_confirma_asegu_list').css('display', 'block')
                $("#gerente_confirma_asegu_div").css('display', 'block')
            })
            .fail(function() {
                console.log("error");
            });
        };
    }
}


/************ 11 **********************/
if(document.getElementById("usuario_permiso")){
    document.getElementById("usuario_permiso").onchange=function() {
        var busca=document.getElementById("usuario_permiso").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("usuario_permiso").value="";
        }
        $('#usuario_permiso_list').css('display', 'none')
    }
    document.getElementById("usuario_permiso").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso").empty();
        if($('#usuario_permiso_list').length==0){
            $("#usuario_permiso").parent().append('<div id="usuario_permiso_div" style="width: 30%; position: absolute;"><ul id="usuario_permiso_list" style="background: #fff; color: 000;"></ul></div>');
            $("#usuario_permiso_div").mouseleave(function (){
                $("#usuario_permiso_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#usuario_permiso_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("mousedown",function(event){
                    $("#usuario_permiso").val($(this).text())
                  }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                  li.attachEvent("mousedown",function(event){
                        $("#usuario_permiso").val($(this).text())
                  }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('usuario_permiso_list').appendChild(li);
            }
            $('#usuario_permiso_list').css('display', 'block')
            $("#usuario_permiso_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
	
	
/************ 11  PARA EL BUSCADOR DE USUARIOS AUDITOR**********************/
if(document.getElementById("usuario_permiso_auditor")){
    document.getElementById("usuario_permiso_auditor").onchange=function() {
        var busca=document.getElementById("usuario_permiso_auditor").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("usuario_permiso_auditor").value="";
        }
        $('#usuario_permiso_auditor_list').css('display', 'none')
    }
    document.getElementById("usuario_permiso_auditor").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso_auditor").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso_auditor").empty();
        if($('#usuario_permiso_auditor_list').length==0){
            $("#usuario_permiso_auditor").parent().append('<div id="usuario_permiso_auditor_div" style="width: 30%; position: absolute;"><ul id="usuario_permiso_auditor_list" style="background: #fff; color: 000;"></ul></div>');
            $("#usuario_permiso_auditor_div").mouseleave(function (){
                $("#usuario_permiso_auditor_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_auditor.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso_auditor").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#usuario_permiso_auditor_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                  li.addEventListener("mousedown",function(event){
                    $("#usuario_permiso_auditor").val($(this).text())
                  }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                  li.attachEvent("mousedown",function(event){
                        $("#usuario_permiso_auditor").val($(this).text())
                  }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('usuario_permiso_auditor_list').appendChild(li);
            }
            $('#usuario_permiso_auditor_list').css('display', 'block')
            $("#usuario_permiso_auditor_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}


/************ 12 **********************/
if(document.getElementById("gerente")){
    document.getElementById("gerente").onchange=function() {
        var busca=document.getElementById("gerente").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("gerente").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("gerente").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#gerente").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#gerente").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}


/************ 12 **********************/
if(document.getElementById("usuario_permiso2")){
    document.getElementById("usuario_permiso2").onchange=function() {
        var busca=document.getElementById("usuario_permiso2").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("usuario_permiso2").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("usuario_permiso2").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso2").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso2").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#usuario_permiso2").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso2").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#usuario_permiso2").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#usuario_permiso2").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}


/************ 13 **********************/
if(document.getElementById("partecnico_bus_us")){
    document.getElementById("partecnico_bus_us").onchange=function() {
        var busca=document.getElementById("partecnico_bus_us").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("partecnico_bus_us").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("partecnico_bus_us").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#partecnico_bus_us").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#partecnico_bus_us").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#partecnico_bus_us").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#partecnico_bus_us").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#partecnico_bus_us").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#partecnico_bus_us").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}


/************ 14 **********************/
if(document.getElementById("gerente_contrato_bus_us")){
    document.getElementById("gerente_contrato_bus_us").onchange=function() {
        var busca=document.getElementById("gerente_contrato_bus_us").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("gerente_contrato_bus_us").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("gerente_contrato_bus_us").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente_contrato_bus_us").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente_contrato_bus_us").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#gerente_contrato_bus_us").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente_contrato_bus_us").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#gerente_contrato_bus_us").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#gerente_contrato_bus_us").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 15 **********************/
if(document.getElementById("busca_solicitud")){
    document.getElementById("busca_solicitud").onchange=function() {
        var busca=document.getElementById("busca_solicitud").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_solicitud").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("busca_solicitud").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_solicitud").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_solicitud").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#busca_solicitud").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_solicitudes.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_solicitud").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_solicitud").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_solicitud").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 16 **********************/
if(document.getElementById("llena_lista_sondeos_l")){
    document.getElementById("llena_lista_sondeos_l").onchange=function() {
        var busca=document.getElementById("llena_lista_sondeos_l").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("llena_lista_sondeos_l").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("llena_lista_sondeos_l").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#llena_lista_sondeos_l").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#llena_lista_sondeos_l").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#llena_lista_sondeos_l").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_solicitudes_sondeo.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#llena_lista_sondeos_l").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#llena_lista_sondeos_l").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#llena_lista_sondeos_l").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 17 **********************/
if(document.getElementById("tarifas_busca_contratos")){
    document.getElementById("tarifas_busca_contratos").onchange=function() {
        var busca=document.getElementById("tarifas_busca_contratos").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("tarifas_busca_contratos").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("tarifas_busca_contratos").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#tarifas_busca_contratos").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#tarifas_busca_contratos").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#tarifas_busca_contratos").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_contratos.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#tarifas_busca_contratos").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#tarifas_busca_contratos").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#tarifas_busca_contratos").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 18 **********************/
if(document.getElementById("" + campo_seleccio)){
    document.getElementById("" + campo_seleccio).onchange=function() {
        var busca=document.getElementById("" + campo_seleccio).value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("" + campo_seleccio).value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("" + campo_seleccio).onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#" + campo_seleccio).val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#" + campo_seleccio).empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#" + campo_seleccio).parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/tarifas_autocompleta_contratos.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#" + campo_seleccio).val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#" + campo_seleccio).val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#" + campo_seleccio).val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 19 **********************/
if(document.getElementById("gerente_confirma_asegu2")){
    document.getElementById("gerente_confirma_asegu2").onchange=function() {
        var busca=document.getElementById("gerente_confirma_asegu2").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("gerente_confirma_asegu2").value="";
        }
        $('#gerente_confirma_asegu_list2').css('display', 'none')
    }
    document.getElementById("gerente_confirma_asegu2").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#gerente_confirma_asegu2").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#gerente_confirma_asegu2").empty();
        if($('#gerente_confirma_asegu_list2').length==0){
            $("#gerente_confirma_asegu2").parent().append('<div id="gerente_confirma_asegu_div2" style="width: 100%; position: absolute; margin-top: -30px; z-index:20;"><ul id="gerente_confirma_asegu_list2" style="background: #fff; color: 000; margin-left:40px;"></ul></div>');
            $("#gerente_confirma_asegu_div2").mouseleave(function (){
                $("#gerente_confirma_asegu_div2").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#gerente_confirma_asegu2").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list2').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text= "#"+id_li+"{margin-left:20px;}#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #fff; color: #000; } div > #gerente_confirma_asegu_list2:leave { display: none }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#gerente_confirma_asegu2").val($(this).text())
                    }, false); 

                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#gerente_confirma_asegu2").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list2').appendChild(li);
            }
            $('#gerente_confirma_asegu_list2').css('display', 'block')
            $("#gerente_confirma_asegu_div2").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 20 **********************/
if(document.getElementById("usuario_permiso3")){
    document.getElementById("usuario_permiso3").onchange=function() {
        var busca=document.getElementById("usuario_permiso3").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("usuario_permiso3").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("usuario_permiso3").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#usuario_permiso3").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#usuario_permiso3").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#usuario_permiso3").parent().append('<div id="gerente_confirma_asegu_div" style="width: 40%; position: absolute;margin-top: -30px; z-index:900; box-shadow: 3px 5px 5px 9px #ccc;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/usuarios_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#usuario_permiso3").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+"{margin-left:20px;}#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#usuario_permiso3").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#usuario_permiso3").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 21 para el des083 **********************/
if(document.getElementById("proveedores_busca_adjudica")){
    document.getElementById("proveedores_busca_adjudica").onchange=function() {
        var busca=document.getElementById("proveedores_busca_adjudica").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("proveedores_busca_adjudica").value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("proveedores_busca_adjudica").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca_adjudica").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca_adjudica").empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#proveedores_busca_adjudica").parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_adjudicacion.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca_adjudica").val(), q2:coma},
        })
        .done(function(data) {
            var data=JSON.parse(data)            
            $('#gerente_confirma_asegu_list').empty();
            for(var i in data){
                var result=data[i].nombre.replace("\n", "")//para dejar solo la cadena
                result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
                result=result.replace(/\./g,'')
                result=result.replace(/\-/g,'')
                result=result.replace(/\ /g,'')
                result=result.replace(/\,/g,'')
                result=result.replace(/\*/g,'')
                result=result.replace(" ","")
                result=result.replace(/\:/g,'')
                //console.log("id: "+data[i].id+" razon social: "+data[i].nombre+" nit: "+data[i].nit+" estado: "+data[i].estado)
                var id_li=result+data[i].id
                if(data[i].estado=="Aceptado Extranjero" || data[i].estado=="Convenios y Pagos" || data[i].estado=="Pendiente por Aprobaci" || data[i].estado=="En Proceso" || data[i].estado=="Aceptado"){//evalua estado
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                }else{
                    var style_text="#"+id_li+":hover { background: #ccc; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                }// fin evalua estado
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    if(data[i].estado=="Aceptado Extranjero" || data[i].estado=="Convenios y Pagos" || data[i].estado=="Pendiente por Aprobaci" || data[i].estado=="En Proceso" || data[i].estado=="Aceptado"){//evalua estado
                        li.addEventListener("mousedown",function(event){
                            $("#proveedores_busca_adjudica").val($(this).text())
                        }, false);
                    }// fin evalua estado
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    if(data[i].estado=="Aceptado Extranjero" || data[i].estado=="Convenios y Pagos" || data[i].estado=="Pendiente por Aprobaci" || data[i].estado=="En Proceso" || data[i].estado=="Aceptado"){//evalua estado
                            li.attachEvent("mousedown",function(event){
                                $("#proveedores_busca_adjudica").val($(this).text())
                            }, false);
                    }// fin evalua estado
                  }
                }
                if(data[i].estado=="Aceptado Extranjero" || data[i].estado=="Convenios y Pagos" || data[i].estado=="Pendiente por Aprobaci" || data[i].estado=="En Proceso" || data[i].estado=="Aceptado"){//evalua estado
                    var texto=document.createTextNode(data[i].nombre+" "+data[i].nit+"----,"+data[i].id+"----,");
                }else{
                    var texto=document.createTextNode(data[i].nombre+" "+data[i].nit+"----,"+data[i].id+" "+data[i].estado);
                }// fin evalua estado
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}
/************ 19 **********************/
if(document.getElementById("busca_id_comite_tareas")){
    document.getElementById("busca_id_comite_tareas").onchange=function() {
        var busca=document.getElementById("busca_id_comite_tareas").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("busca_id_comite_tareas").value="";
        }
        $('#busca_id_comite_tareas_list').css('display', 'none')
    }
    document.getElementById("busca_id_comite_tareas").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#busca_id_comite_tareas").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#busca_id_comite_tareas").empty();
        if($('#busca_id_comite_tareas_list').length==0){
            $("#busca_id_comite_tareas").parent().append('<div id="busca_id_comite_tareas_div" style="width: 30%; position: absolute;"><ul id="busca_id_comite_tareas_list" style="background: #fff; color: 000;"></ul></div>');
            $("#busca_id_comite_tareas_div").mouseleave(function (){
                $("#busca_id_comite_tareas_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/busca_comite.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#busca_id_comite_tareas").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#busca_id_comite_tareas_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#busca_id_comite_tareas").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#busca_id_comite_tareas").val($(this).text())
                    }, false);
                  }
                }
                //li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('busca_id_comite_tareas_list').appendChild(li);
            }
            $('#busca_id_comite_tareas_list').css('display', 'block')
            $("#busca_id_comite_tareas_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/************ 21 para el des reportes **********************/
if(document.getElementById("proveedores_busca3")){
    document.getElementById("proveedores_busca3").onchange=function() {
        var busca=document.getElementById("proveedores_busca3").value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("proveedores_busca3").value="";
        }
        $('#proveedores_busca3_list').css('display', 'none')
    }
    document.getElementById("proveedores_busca3").onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#proveedores_busca3").val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#proveedores_busca3").empty();
        if($('#proveedores_busca3_list').length==0){
            $("#proveedores_busca3").parent().append('<div id="proveedores_busca3_div" style="width: 40%; position: absolute;margin-top: -30px; z-index:99; box-shadow: 3px 5px 5px 9px #ccc;"><ul id="proveedores_busca3_list" style="background: #fff; color: 000;"></ul></div>');
            $("#proveedores_busca3_div").mouseleave(function (){
                $("#proveedores_busca3_div").css('display', 'none')
            });
        }
        $.ajax({
            url: '../librerias/php/proveedores_general.php',
            type: 'POST',
            dataType: 'html',
            data: {q:$("#proveedores_busca3").val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#proveedores_busca3_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+"{margin-left:20px;}#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(event){
                        $("#proveedores_busca3").val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#proveedores_busca3").val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('proveedores_busca3_list').appendChild(li);
            }
            $('#proveedores_busca3_list').css('display', 'block')
            $("#proveedores_busca3_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

}

/*funcion para seleccionar lista*/
function selecciona_lista_general_irre(id,ruta)
{
/*
$().ready(function() { jorge gonzales

    $('.modal').modal();
  Materialize.updateTextFields();
  $('.materialboxed').materialbox();
  $('select').material_select('destroy');
  $('.button-collapse').sideNav({
    menuWidth: 300, // Default is 300
    edge: 'left', // Choose the horizontal origin
    closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    draggable: true // Choose whether you can drag to open on touch screens
  });
});
*/
  /************ 18 **********************/
if(document.getElementById("" + id)){
    document.getElementById("" + id).onchange=function() {
        var busca=document.getElementById("" + id).value
        var bandera=busca.search('----,');
        if(bandera==-1){
            document.getElementById("" + id).value="";
        }
        $('#gerente_confirma_asegu_list').css('display', 'none')
    }
    document.getElementById("" + id).onkeyup=function(evt) {
        //alert(evt.keyCode)
        var coma=$("#" + id).val()
        coma=coma.replace(" ",", ");
        var cadena1=""
        $("#" + id).empty();
        if($('#gerente_confirma_asegu_list').length==0){
            $("#" + id).parent().append('<div id="gerente_confirma_asegu_div" style="width: 30%; position: absolute;"><ul id="gerente_confirma_asegu_list" style="background: #fff; color: 000;"></ul></div>');
            $("#gerente_confirma_asegu_div").mouseleave(function (){
                $("#gerente_confirma_asegu_div").css('display', 'none')
            });
        }
        $.ajax({
            url: ruta,
            type: 'POST',
            dataType: 'html',
            data: {q:$("#" + id).val(), q2:coma},
        })
        .done(function(data) {
            var result=data.replace("\n", "")//para dejar solo la cadena
            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
            result=result.split("<remplaza>");
            $('#gerente_confirma_asegu_list').empty();
            for (i = 0; i < result.length; i++) {
                var id_li=result[i].replace('-','')
                id_li=id_li.replace(/\./g,'')
                id_li=id_li.replace(/\-/g,'')
                id_li=id_li.replace(/\ /g,'')
                id_li=id_li.replace(/\,/g,'')
                id_li=id_li.replace(/\*/g,'')
                id_li=id_li.replace(/\:/g,'')
                var style_text="#"+id_li+":hover { background: #229BFF; color: #fff; } #"+id_li+":leave { background: #ccc; color: #212121; }";
                var style = document.createElement("style");
                style.appendChild(
                    document.createTextNode(style_text)
                );
                document.querySelector("head").appendChild(style);
                var li=document.createElement('li');
                li.id=id_li;
                if (li.addEventListener) {  // all browsers except IE before version 9
                    li.addEventListener("mousedown",function(){
                        $("#" + id).val($(this).text())
                    }, false); 
                } else {
                  if (li.attachEvent) {   // IE before version 9
                    li.attachEvent("mousedown",function(event){
                        $("#" + id).val($(this).text())
                    }, false);
                  }
                }
                li.onclick="alert('asd')";
                var texto=document.createTextNode(result[i]);
                li.appendChild(texto);
                document.getElementById('gerente_confirma_asegu_list').appendChild(li);
            }
            $('#gerente_confirma_asegu_list').css('display', 'block')
            $("#gerente_confirma_asegu_div").css('display', 'block')
        })
        .fail(function() {
            console.log("error");
        });
    };
}

/*function log(event, data, formatted) {
        $("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
    }

    function formatItem(row) {
        return row[0] + " (<strong>id: " + row[1] + "</strong>)";
    }
    function formatResult(row) {
        return row[0].replace(/(<.+?>)/gi, '');
    }
    


    $("#" + id).autocomplete(ruta, {
        
        width: 660,
        selectFirst: true,
        max: 1000,
        scroll: true,
        scrollHeight: 300,
        autoFill: false ,
        multiple: true,
        mustMatch: true,
        matchContains: true
    
    });*/
}