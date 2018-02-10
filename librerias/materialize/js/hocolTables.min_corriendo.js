/*** SE UTILZA EL PATRÓN IIFE
**** Expresión de Función Inmediatamente Invocada
**** Función Anónima Auto Ejecutable */
(function(window, document){
	'use strict';
	var hocolTables=function(){
		var vartableUpdate={},
		tableOnBody={},
		hocolTables_methods={
			addEventToTable: function(id){
				if(id!=null && id!=""){
					if(document.addEventListener){
						document.getElementById(id).addEventListener("mousedown",function(event){
							var id_table=this.id
							var id_i=0;
							var htead=this.tHead.rows[0].cells
							for(var i=0; i<htead.length; i++){
								//console.log(id_i)
								if(document.getElementById("id_row_"+id_i)){
									
								}else{
									var elementth=htead[i]
									//console.log(htead[i])
									var text_content=htead[i]
									var row=document.createElement("div");
									row.className="input-field col s2 m2 l2"
									row.id="id_row_"+id_i
									var icon1=document.createElement("i");
									icon1.className="material-icons md-24 left icon-order-left"
									icon1.id="th_"+id_i+"_icon1_"+id_i
									icon1.addEventListener("mousedown",function(event){
										_.changeOrderToTable(this.id,id_table)
				                        //$("#gerente_confirma_asegu").val($(this).text())
				                    }, false);
				                    var tex_i1=document.createTextNode("&#xE5D8;");
									var icon2=document.createElement("i");
									icon2.className="material-icons md-24 right icon-order-right"
									icon2.id="th_"+id_i+"_icon2_"+id_i
									icon2.addEventListener("mousedown",function(event){
										_.changeOrderToTable(this.id,id_table)
				                        //$("#gerente_confirma_asegu").val($(this).text())
				                    }, false);
				                    var tex_i2=document.createTextNode("&#xE5DB;");
				                    //icon1.appendChild(tex_i1);
				                    //icon2.appendChild(tex_i2);
				                    row.appendChild(icon1);
				                    row.appendChild(icon2);
				                    text_content.appendChild(row);
				                    $("#th_"+id_i+"_icon1_"+id_i).append('&#xE5D8;')
				                    $("#th_"+id_i+"_icon2_"+id_i).append('&#xE5DB;')
				                	
				                	id_i++;
				                }

							}
							_.addIdToTable(this.id)
							//console.log(htead)
			                //alert(this.id)			                
			            }, false);
					}else{
						document.getElementById(id).attachEvent("mousedown",function(event){
			            	alert(this.id)
			            }, false);
					}
				}
			},
			addIdToTable: function (id){
				var table=document.getElementById(id)
				//console.log(table)
				var tbody=table.getElementsByTagName("tbody")
                //console.log(tbody[0].rows.length)
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		if(document.getElementById("row_"+j+"_tr_"+h+"_td_"+j)){
                		}else{					                			
	                		var td_element=tbody[0].rows[h].cells[j]
	                		td_element.id="row_"+j+"_tr_"+h+"_td_"+j
	                		td_element.className="row_"+j
	                		console.log(td_element.className)
                		}
                	}
                }
			},
			changeOrderToTable: function(id_icon, id_table){
				var table=document.getElementById(id_table)
				var htead=table.tHead.rows[0].cells
				for(var i=0; i<htead.length; i++){
					var icon_element1=document.getElementById("th_"+i+"_icon1_"+i)
					var icon_element2=document.getElementById("th_"+i+"_icon2_"+i)
					icon_element1.classList.remove("icon-order-active");
					icon_element2.classList.remove("icon-order-active");
				}
				var icon_element_actual=document.getElementById(id_icon)
				icon_element_actual.classList.add("icon-order-active");
				var id_icon_actived=id_icon
				id_icon_actived=id_icon_actived.split("_")
				if(id_icon_actived[2] === "icon1"){
					_.orderTableUp(id_icon, table.id)
				}
			},
			orderTableUp: function(id_icon, id_table){
				var tabe_temp=[];
				//var json_table_temp=JSON.parse(tabe_temp)
				var array_table=[];
				var is_number=true;
				var id_icon_actived=id_icon
				id_icon_actived=id_icon_actived.split("_")
				var table=document.getElementById(id_table);
				var tbody=table.getElementsByTagName("tbody");
				var contPosJson=0;
                //console.log(tbody[0].rows.length)
                var jsonTableTemp={},
                	arrayTable=[],
                	arrayTableObject={},
					jsonTdTemp=[],
					jsonMethodsTables={
						jsonPushTableTemp: function(rowData,tr){
							//if(arrayTable.length==0){
								var obj={
									rowData,
									tr
								}
								arrayTable.push(obj)
							//}
							//jsonTableTemp.push(row)
							return this
						},
						jsonPushTdTemp:function(tr,td){
							jsonTdTemp.push(td)
							return this
						},
						resetJsonTd:function(){
							jsonTdTemp=[]
						}
					};
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	var string_td=[]
                	var string_row=""
                	jsonMethodsTables.resetJsonTd()
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		var td_element=tbody[0].rows[h].cells[j]
                		var result=td_element.innerHTML
            			result=result.replace("\n", "")//para dejar solo la cadena
			            result=result.replace(/^\s+|\s+$/g, "")//para dejar solo la cadena
						result=result.replace("\n","")
						result=result.replace("[\n\r]", "");
                		if(parseFloat(result)){
                			//console.log('es nuero: '+td_element.innerHTML)
                		}else{
                			//console.log('es texto: '+td_element.innerHTML)
                			is_number=false;
                		}
                		if(td_element.className=="row_"+id_icon_actived[1]){
                			string_row=result
                		}
                		jsonMethodsTables.jsonPushTdTemp('tr',result);
                		//string_td.push("{'td':"+result+"}")
                		if(j==tbody[0].rows[h].cells.length-1){
                			jsonMethodsTables.jsonPushTableTemp(string_row,jsonTdTemp);
                			//console.log('entra----'+j)
                			//tabe_temp.tr.push(string_td)
                			//tabe_temp.push("{'row':"+result+",'tr':[]}")
                		}
                	}
                }
                arrayTable.sort()
                //var ot=JSON.parse(jsonTableTemp)
                console.log(arrayTable.length)
                console.log(arrayTable)
                /*if(is_number==true){
                	tabe_temp.sort(function(a, b){return b-a});
                }else{
                	tabe_temp.sort();
                }
                //console.log(tabe_temp)
                for(var z=0; z<tabe_temp.length; z++){
                	for (var h=0; h<tbody[0].rows.length; h++){
                		var td_element=tbody[0].rows[h].cells
	                	for (var j=0; j<td_element.length; j++){
	                		var td_element=tbody[0].rows[h].cells[j]
	                		if(td_element.className=="row_"+id_icon_actived[1]){
	                			if(td_element.innerHTML==tabe_temp[z]){
	                				array_table.push(td_element)
	                				//console.log(td_element)
	                			}
	                			//tabe_temp.push(td_element.innerHTML)
	                			
	                		}
	                	}
	                }
                	/*var tr_table=tbody[0].rows[z].cells
                	for (var j=0; j<tr_table.length; j++){
                		var td_element=tbody[0].rows[z].cells[j]
                		if(td_element.className=="row_"+id_icon_actived[1]){
                			if(td_element.innerHTML==tabe_temp[z]){
                				console.log
                			}
                			//tabe_temp.push(td_element.innerHTML)
                			console.log(tr_table)
                		}
                	}
                }
                $(tbody).empty()
                tbody.innerHTML=array_table
                $(tbody).append('Some text')
                console.log(array_table)*/
			},
			orderTableDown: function(id_icon, id_table){
				var table=document.getElementById(id_table)
				var tbody=table.getElementsByTagName("tbody")
                //console.log(tbody[0].rows.length)
                var z=0, y=0;
                for (var h=0; h<tbody[0].rows.length; h++){
                	for (var j=0; j<tbody[0].rows[h].cells.length; j++){
                		if(document.getElementById("row_"+j+"_tr_"+h+"_td_"+j)){
                		}else{					                			
	                		var td_element=tbody[0].rows[h].cells[j]
	                		td_element.id="row_"+j+"_tr_"+h+"_td_"+j
	                		td_element.className="row_"+j
	                		//console.log(td_element.className)
                		}
                	}
                }
			}
		};
		return hocolTables_methods;
	}
	if(typeof window.hocolTables_methods === 'undefined'){
		window.hocolTables_methods = window._ = hocolTables()
	}
})(window, document)